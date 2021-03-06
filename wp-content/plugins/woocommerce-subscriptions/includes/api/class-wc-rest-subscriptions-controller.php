<?php
/**
 * REST API Subscriptions controller
 *
 * Handles requests to the /subscription endpoint.
 *
 * @author   Prospress
 * @since    2.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * REST API Subscriptions controller class.
 *
 * @package WooCommerce_Subscriptions/API
 * @extends WC_REST_Orders_Controller
 */
class WC_REST_Subscriptions_Controller extends WC_REST_Orders_V1_Controller {

	/**
	 * Route base.
	 *
	 * @var string
	 */
	protected $rest_base = 'subscriptions';

	/**
	 * Post type.
	 *
	 * @var string
	 */
	protected $post_type = 'shop_subscription';

	/**
	 * Initialize subscription actions and filters
	 */
	public function __construct() {
		add_filter( 'woocommerce_rest_prepare_shop_subscription', array( $this, 'filter_get_subscription_response' ), 10, 3 );

		add_filter( 'woocommerce_rest_shop_subscription_query', array( $this, 'query_args' ), 10, 2 );
	}

	/**
	 * Register the routes for subscriptions.
	 */
	public function register_routes() {
		parent::register_routes();

		register_rest_route( $this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)/orders', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_subscription_orders' ),
				'permission_callback' => array( $this, 'get_items_permissions_check' ),
				'args'                => $this->get_collection_params(),
			),
			'schema' => array( $this, 'get_public_item_schema' ),
		) );

		register_rest_route( $this->namespace, '/' . $this->rest_base . '/statuses', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_statuses' ),
			),
			'schema' => array( $this, 'get_public_item_schema' ),
		) );
	}

	/**
	 * Filter WC_REST_Orders_Controller::get_item response for subscription post types
	 *
	 * @since 2.1
	 * @param WP_REST_Response $response
	 * @param WP_POST $post
	 * @param WP_REST_Request $request
	 */
	public function filter_get_subscription_response( $response, $post, $request ) {

		if ( ! empty( $post->post_type ) && ! empty( $post->ID ) && 'shop_subscription' == $post->post_type ) {
			$subscription = wcs_get_subscription( $post->ID );

			$response->data['billing_period']    = $subscription->get_billing_period();
			$response->data['billing_interval']  = $subscription->get_billing_interval();

			foreach ( array( 'start', 'trial_end', 'next_payment', 'end' ) as $date_type ) {
				$date_type_key = ( 'start' === $date_type ) ? 'date_created' : $date_type;
				$date = $subscription->get_date( $date_type_key );

				$response->data[ $date_type . '_date'] = ( ! empty( $date ) ) ? wc_rest_prepare_date_response( $date ) : '';
			}
		}

		return $response;
	}

	/**
	 * Sets the order_total value on the subscription after WC_REST_Orders_Controller::create_order
	 * calls calculate_totals(). This allows store admins to create a recurring payment via the api
	 * without needing to attach a product to the subscription.
	 *
	 * @since 2.1
	 * @param WP_REST_Request $request
	 */
	protected function create_order( $request ) {
		try {
			if ( ! is_null( $request['customer_id'] ) && 0 !== $request['customer_id'] && false === get_user_by( 'id', $request['customer_id'] ) ) {
				throw new WC_REST_Exception( 'woocommerce_rest_invalid_customer_id',__( 'Customer ID is invalid.', 'woocommerce-subscriptions' ), 400 );
			}

			// If the start date is not set in the request, set its default to now
			if ( ! isset( $request['start_date'] ) ) {
				$request['start_date'] = gmdate( 'Y-m-d H:i:s' );
			}

			// prepare all subscription data from the request
			$subscription = $this->prepare_item_for_database( $request );
			$subscription->set_created_via( 'rest-api' );
			$subscription->set_prices_include_tax( 'yes' === get_option( 'woocommerce_prices_include_tax' ) );
			$subscription->calculate_totals();

			// allow the order total to be overriden (i.e. if you want to have a subscription with no order items but a flat $10.00 recurring payment )
			if ( isset( $request['order_total'] ) ) {
				$subscription->set_total( wc_format_decimal( $request['order_total'], get_option( 'woocommerce_price_num_decimals' ) ) );
			}

			$subscription->save();

			// Store the post meta on the subscription after it's saved, this is to avoid compat. issue with the filters in WC_Subscriptions::set_payment_method_meta() expecting the $subscription to have an ID (therefore it needs to be called after the WC_Subscription has been saved)
			$payment_data = ( ! empty( $request['payment_details'] ) ) ? $request['payment_details'] : array();
			if ( empty( $payment_data['payment_details']['method_id'] ) && ! empty( $request['payment_method'] ) ) {
				$payment_data['method_id'] = $request['payment_method'];
			}

			$this->update_payment_method( $subscription, $payment_data );

			// Handle set paid.
			if ( true === $request['set_paid'] ) {
				$subscription->payment_complete( $request['transaction_id'] );
			} else {
				$subscription->save(); // $subscription->payment_complete() calls $subscription->update_status() which saves the subscription, so we only need to save it if not calling that
			}

			return $subscription->get_id();
		} catch ( WC_Data_Exception $e ) {
			return new WP_Error( $e->getErrorCode(), $e->getMessage(), $e->getErrorData() );
		} catch ( WC_REST_Exception $e ) {
			return new WP_Error( $e->getErrorCode(), $e->getMessage(), array( 'status' => $e->getCode() ) );
		}
	}

	/**
	 * Overrides WC_REST_Orders_Controller::update_order to update subscription specific meta
	 * calls parent::update_order to update the rest.
	 *
	 * @since 2.1
	 * @param WP_REST_Request $request
	 * @param WP_POST $post
	 */
	protected function update_order( $request ) {
		try {
			$subscription = $this->prepare_item_for_database( $request );

			// If any line items have changed, recalculate subscription totals.
			if ( isset( $request['line_items'] ) || isset( $request['shipping_lines'] ) || isset( $request['fee_lines'] ) || isset( $request['coupon_lines'] ) ) {
				$subscription->calculate_totals();
			}

			// allow the order total to be overriden (i.e. if you want to have a subscription with no order items but a flat $10.00 recurring payment )
			if ( isset( $request['order_total'] ) ) {
				$subscription->set_total( wc_format_decimal( $request['order_total'], get_option( 'woocommerce_price_num_decimals' ) ) );
			}

			$subscription->save();

			// Update the post meta on the subscription after it's saved, this is to avoid compat. issue with the filters in WC_Subscriptions::set_payment_method_meta() expecting the $subscription to have an ID (therefore it needs to be called after the WC_Subscription has been saved)
			$payment_data = ( ! empty( $request['payment_details'] ) ) ? $request['payment_details'] : array();
			$existing_payment_method_id = $subscription->get_payment_method();

			if ( empty( $payment_data['method_id'] ) && isset( $request['payment_method'] ) ) {
				$payment_data['method_id'] = $request['payment_method'];

			} elseif ( ! empty( $existing_payment_method_id ) ) {
				$payment_data['method_id'] = $existing_payment_method_id;
			}

			if ( isset( $payment_data['method_id'] ) ) {
				$this->update_payment_method( $subscription, $payment_data, true );
			}

			// Handle set paid.
			if ( $subscription->needs_payment() && true === $request['set_paid'] ) {
				$subscription->payment_complete();
			}

			return $subscription->get_id();
		} catch ( WC_Data_Exception $e ) {
			return new WP_Error( $e->getErrorCode(), $e->getMessage(), $e->getErrorData() );
		} catch ( WC_REST_Exception $e ) {
			return new WP_Error( $e->getErrorCode(), $e->getMessage(), array( 'status' => $e->getCode() ) );
		}
	}

	/**
	 * Get subscription orders
	 *
	 * @since 2.1
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response $response
	 */
	public function get_subscription_orders( $request ) {
		$id = (int) $request['id'];

		if ( empty( $id ) || ! wcs_is_subscription( $id ) ) {
			return new WP_Error( 'woocommerce_rest_invalid_shop_subscription_id', __( 'Invalid subscription id.', 'woocommerce-subscriptions' ), array( 'status' => 404 ) );
		}

		$this->post_type     = 'shop_order';
		$subscription        = wcs_get_subscription( $id );
		$subscription_orders = $subscription->get_related_orders();

		$orders = array();

		foreach ( $subscription_orders as $order_id ) {
			$post = get_post( $order_id );
			if ( ! wc_rest_check_post_permissions( $this->post_type, 'read', $post->ID ) ) {
				continue;
			}

			$response = $this->prepare_item_for_response( $post, $request );

			foreach ( array( 'parent', 'renewal', 'switch' ) as $order_type ) {
				if ( wcs_order_contains_subscription( $order_id, $order_type ) ) {
					$response->data['order_type'] = $order_type . '_order';
					break;
				}
			}

			$orders[] = $this->prepare_response_for_collection( $response );
		}

		$response = rest_ensure_response( $orders );
		$response->header( 'X-WP-Total', count( $orders ) );
		$response->header( 'X-WP-TotalPages', 1 );

		return apply_filters( 'wcs_rest_subscription_orders_response', $response, $request );
	}

	/**
	 * Get subscription statuses
	 *
	 * @since 2.1
	 */
	public function get_statuses() {
		return rest_ensure_response( wcs_get_subscription_statuses() );
	}

	/**
	 * Overrides WC_REST_Orders_Controller::get_order_statuses() so that subscription statuses are
	 * validated correctly in WC_REST_Orders_Controller::get_collection_params()
	 *
	 * @since 2.1
	 */
	protected function get_order_statuses() {
		$subscription_statuses = array();

		foreach ( array_keys( wcs_get_subscription_statuses() ) as $status ) {
			$subscription_statuses[] = str_replace( 'wc-', '', $status );
		}
		return $subscription_statuses;
	}

	/**
	 * Validate and update payment method on a subscription
	 *
	 * @since 2.1
	 * @param WC_Subscription $subscription
	 * @param array $data
	 * @param bool $updating
	 */
	public function update_payment_method( $subscription, $data, $updating = false ) {
		$payment_method = ( ! empty( $data['method_id'] ) ) ? $data['method_id'] : '';

		try {
			if ( $updating && ! array_key_exists( $payment_method, WCS_Change_Payment_Method_Admin::get_valid_payment_methods( $subscription ) ) ) {
				throw new Exception( __( 'Gateway does not support admin changing the payment method on a Subscription.', 'woocommerce-subscriptions' ) );
			}

			$payment_method_meta = apply_filters( 'woocommerce_subscription_payment_meta', array(), $subscription );

			if ( isset( $payment_method_meta[ $payment_method ] ) ) {
				$payment_method_meta = $payment_method_meta[ $payment_method ];

				if ( ! empty( $payment_method_meta ) ) {

					foreach ( $payment_method_meta as $meta_table => &$meta ) {
						if ( ! is_array( $meta ) ) {
							continue;
						}

						foreach ( $meta as $meta_key => &$meta_data ) {

							if ( isset( $data[ $meta_table ][ $meta_key ] ) ) {
								$meta_data['value'] = $data[ $meta_table ][ $meta_key ];
							}
						}
					}
				}
			}

			$subscription->set_payment_method( $payment_method, $payment_method_meta );

		} catch ( Exception $e ) {
			$subscription->set_payment_method();
			$subscription->save();
			// translators: 1$: gateway id, 2$: error message
			throw new WC_REST_Exception( 'woocommerce_rest_invalid_payment_data', sprintf( __( 'Subscription payment method could not be set to %1$s with error message: %2$s', 'woocommerce-subscriptions' ), $payment_method, $e->getMessage() ), 400 );
		}
	}

	/**
	 * Prepare a single subscription for create.
	 *
	 * @param  WP_REST_Request $request Request object.
	 * @return WP_Error|WC_Subscription $data Object.
	 */
	protected function prepare_item_for_database( $request ) {
		$id           = isset( $request['id'] ) ? absint( $request['id'] ) : 0;
		$subscription = new WC_Subscription( $id );
		$schema       = $this->get_item_schema();
		$data_keys    = array_keys( array_filter( $schema['properties'], array( $this, 'filter_writable_props' ) ) );

		$dates_to_update = array();

		// Handle all writable props
		foreach ( $data_keys as $key ) {
			$value = $request[ $key ];

			if ( ! is_null( $value ) ) {
				switch ( $key ) {
					case 'billing' :
					case 'shipping' :
						$this->update_address( $subscription, $value, $key );
						break;
					case 'line_items' :
					case 'shipping_lines' :
					case 'fee_lines' :
					case 'coupon_lines' :
						if ( is_array( $value ) ) {
							foreach ( $value as $item ) {
								if ( is_array( $item ) ) {
									if ( $this->item_is_null( $item ) || ( isset( $item['quantity'] ) && 0 === $item['quantity'] ) ) {
										$subscription->remove_item( $item['id'] );
									} else {
										$this->set_item( $subscription, $key, $item );
									}
								}
							}
						}
						break;
					case 'start_date' :
					case 'trial_end_date' :
					case 'next_payment_date' :
					case 'end_date' :
						$date_type_key = ( 'start_date' === $key ) ? 'date_created' : $key;
						$dates_to_update[ $date_type_key ] = $value;
						break;
					default :
						if ( is_callable( array( $subscription, "set_{$key}" ) ) ) {
							$subscription->{"set_{$key}"}( $value );
						}
						break;
				}
			}
		}

		try {
			if ( ! empty( $dates_to_update ) ) {
				$subscription->update_dates( $dates_to_update );
			}
		} catch ( Exception $e ) {
			throw new WC_REST_Exception( 'woocommerce_rest_cannot_update_subscription_dates', sprintf( __( 'Updating subscription dates errored with message: %s', 'woocommerce-subscriptions' ), $e->getMessage() ), 400 );
		}

		/**
		 * Filter the data for the insert.
		 *
		 * The dynamic portion of the hook name, $this->post_type, refers to post_type of the post being
		 * prepared for the response.
		 *
		 * @param WC_Subscription    $subscription   The subscription object.
		 * @param WP_REST_Request    $request        Request object.
		 */
		return apply_filters( "woocommerce_rest_pre_insert_{$this->post_type}", $subscription, $request );
	}

	/**
	 * Adds additional item schema information for subscription requests
	 *
	 * @since 2.1
	 */
	public function get_item_schema() {
		$schema = parent::get_item_schema();

		$subscriptions_schema = array(
			'billing_interval' => array(
				'description' => __( 'The number of billing periods between subscription renewals.', 'woocommerce-subscriptions' ),
				'type'        => 'integer',
				'context'     => array( 'view', 'edit' ),
			),
			'billing_period' => array(
				'description' => __( 'Billing period for the subscription.', 'woocommerce-subscriptions' ),
				'type'        => 'string',
				'enum'        => array_keys( wcs_get_subscription_period_strings() ),
				'context'     => array( 'view', 'edit' ),
			),
			'payment_details' => array(
				'description' => __( 'Subscription payment details.', 'woocommerce-subscriptions' ),
				'type'        => 'object',
				'context'     => array( 'edit' ),
				'properties'  => array(
					'method_id' => array(
						'description' => __( 'Payment gateway ID.', 'woocommerce-subscriptions' ),
						'type'        => 'string',
						'context'     => array( 'edit' ),
					),
				),
			),
			'start_date' => array(
				'description' => __( "The subscription's start date.", 'woocommerce-subscriptions' ),
				'type'        => 'date-time',
				'context'     => array( 'view', 'edit' ),
			),
			'trial_end_date' => array(
				'description' => __( "The subscription's trial date", 'woocommerce-subscriptions' ),
				'type'        => 'date-time',
				'context'     => array( 'view', 'edit' ),
			),
			'next_payment_date' => array(
				'description' => __( "The subscription's next payment date.", 'woocommerce-subscriptions' ),
				'type'        => 'date-time',
				'context'     => array( 'view', 'edit' ),
			),
			'end_date' => array(
				'description' => __( "The subscription's end date.", 'woocommerce-subscriptions' ),
				'type'        => 'date-time',
				'context'     => array( 'view', 'edit' ),
			),
		);

		$schema['properties'] += $subscriptions_schema;
		return $schema;
	}

	/**
	 * Deprecated functions
	 */

	/**
	 * Prepare subscription data for create.
	 *
	 * Now that we override WC_REST_Orders_V1_Controller::prepare_item_for_database() function,
	 * we no longer need to prepare these args
	 *
	 * @since 2.1
	 * @param stdClass $data
	 * @param WP_REST_Request $request Request object.
	 * @return stdClass
	 * @deprecated 2.2
	 */
	public function prepare_subscription_args( $data, $request ) {
		wcs_deprecated_function( __METHOD__, '2.2' );

		$data->billing_interval = $request['billing_interval'];
		$data->billing_period   = $request['billing_period'];

		foreach ( array( 'start', 'trial_end', 'end', 'next_payment' ) as $date_type ) {
			if ( ! empty( $request[ $date_type . '_date' ] ) ) {
				$date_type_key = ( 'start' === $date_type ) ? 'date_created' : $date_type . '_date';
				$data->{$date_type_key} = $request[ $date_type . '_date' ];
			}
		}

		$data->payment_details = ! empty( $request['payment_details'] ) ? $request['payment_details'] : '';
		$data->payment_method  = ! empty( $request['payment_method'] ) ? $request['payment_method'] : '';

		return $data;
	}

	/**
	 * Update or set the subscription schedule with the request data.
	 *
	 *
	 * @since 2.1
	 * @param WC_Subscription $subscription
	 * @param array $data
	 * @deprecated 2.2
	 */
	public function update_schedule( $subscription, $data ) {
		wcs_deprecated_function( __METHOD__, '2.2', 'WC_REST_Subscriptions_Controller::prepare_item_for_database() now prepares the billing interval/period and dates' );

		if ( isset( $data['billing_interval'] ) ) {
			$subscription->set_billing_interval( absint( $data['billing_interval'] ) );
		}

		if ( ! empty( $data['billing_period'] ) ) {
			$subscription->set_billing_period( $data['billing_period'] );
		}

		try {
			$dates_to_update = array();

			foreach ( array( 'start', 'trial_end', 'end', 'next_payment' ) as $date_type ) {
				if ( isset( $data[ $date_type . '_date' ] ) ) {
					$date_type_key = ( 'start' === $date_type ) ? 'date_created' : $date_type;
					$dates_to_update[ $date_type_key ] = $data[ $date_type . '_date' ];
				}
			}

			if ( ! empty( $dates_to_update ) ) {
				$subscription->update_dates( $dates_to_update );
			}
		} catch ( Exception $e ) {
			throw new WC_REST_Exception( 'woocommerce_rest_cannot_update_subscription_dates', sprintf( __( 'Updating subscription dates errored with message: %s', 'woocommerce-subscriptions' ), $e->getMessage() ), 400 );
		}
	}
}
