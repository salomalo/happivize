<?php
/**
 * class-affiliates-products-jigoshop.php
 *
 * Copyright (c) "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates-products
 * @since affiliates-products 1.4.0
 */

/**
 * Jigoshop component.
 */
class Affiliates_Products_Jigoshop extends Affiliates_Products_Base {

	private static $name   = 'Jigoshop';
	private static $system = 'jigoshop';

	/**
	 * Admin setup.
	 */
	public static function init() {
		$active_plugins = get_option( 'active_plugins', array() );
		if ( is_multisite() ) {
			$active_sitewide_plugins = get_site_option( 'active_sitewide_plugins', array() );
			$active_sitewide_plugins = array_keys( $active_sitewide_plugins );
			$active_plugins = array_merge( $active_plugins, $active_sitewide_plugins );
		}
		$jigoshop_is_active = in_array( 'jigoshop/jigoshop.php', $active_plugins );
		if ( $jigoshop_is_active ) {
			Affiliates_Products_Components::register_component( self::$system, self::$name, __CLASS__, __FILE__ );
			add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ), 20 );
			self::$instance = new Affiliates_Products_Jigoshop();
			add_action ( 'jigoshop_new_order', array( __CLASS__, 'jigoshop_new_order' ) );

			$options = get_option( 'affiliates_products', array() );
			$auto_assign_to_author = isset( $options['auto_assign_to_author'] ) ? $options['auto_assign_to_author'] : false;
			$default_rate          = isset( $options['default_rate'] ) ? $options['default_rate'] : 0;

			if ( $auto_assign_to_author || ( bccomp( $default_rate, '0', Affiliates_Products_Base::DECIMALS ) > 0 ) ) { 
				add_action( 'transition_post_status', array( __CLASS__, 'transition_post_status' ), 10, 3 );
			}
		}
	}

	/**
	 * Adds the admin section.
	 */
	public static function admin_menu() {

		$page = add_submenu_page(
			'affiliates-products',
			__( 'Jigoshop' ),
			__( 'Jigoshop' ),
			AFFILIATES_ADMINISTER_OPTIONS,
			'affiliates-products-jigoshop',
			array( __CLASS__, 'affiliates_products' )
		);
		add_action( 'admin_print_styles-' . $page, 'affiliates_admin_print_styles' );
		add_action( 'admin_print_scripts-' . $page, 'affiliates_admin_print_scripts' );
		add_action( 'admin_print_scripts-' . $page, array( 'Affiliates_Products_Admin', 'admin_print_scripts' ) );
		add_action( 'admin_print_styles-' . $page, array( 'Affiliates_Products_Admin', 'admin_print_styles' ) );
	}

	public function get_system() {
		return self::$system;
	}

	public function get_name() {
		return self::$name;
	}

	public function get_products( $args = array() ) {

		global $wpdb;

		$options = get_option( 'affiliates_products', null );
		$product_options = isset( $options[self::$instance->get_system()] ) ? $options[self::$instance->get_system()] : array();

		$products = array();

		$filters = array(
			" 1 = %d ",
			" $wpdb->posts.post_type = 'product' ",
			" $wpdb->posts.post_status IN ('publish','draft') "
		);
		$filter_params = array( 1 );
		if ( isset( $args['filters'] ) ) {
			extract( $args['filters'] );
			if ( isset( $affiliate_id ) ) {
				$filter_product_ids = array();
				foreach( $product_options as $id => $values ) {
					if ( isset( $values['affiliate_id'] ) && ( $values['affiliate_id'] == $affiliate_id ) ) {
						$filter_product_ids[] = intval( $id );
					}
				}
				if ( count( $filter_product_ids ) == 0 ) {
					$filter_product_ids[] = 'NULL';
				}
				$filters[] = sprintf( " $wpdb->posts.ID IN ( %s ) ", implode( ',', $filter_product_ids ) );
			}
			if ( isset( $affiliate_name ) ) {
				$filter_product_ids = array();
				foreach( $product_options as $id => $values ) {
					if ( isset( $values['affiliate_id'] ) ) {
						if ( $affiliate = affiliates_get_affiliate( $values['affiliate_id'] ) ) {
							if ( stripos( $affiliate['name'], $affiliate_name ) !== false ) {
								$filter_product_ids[] = intval( $id );
							}
						}
					}
				}
				if ( count( $filter_product_ids ) == 0 ) {
					$filter_product_ids[] = 'NULL';
				}
				$filters[] = sprintf( " $wpdb->posts.ID IN ( %s ) ", implode( ',', $filter_product_ids ) );
			}
// 			if ( $affiliate_user_login ) {
// 				$filters[] = " $wpdb->users.user_login LIKE '%%%s%%' ";
// 				$filter_params[] = $affiliate_user_login;
// 			}
			if ( !empty( $product_id ) ) {
				$filters[] = " $wpdb->posts.ID = %d ";
				$filter_params[] = intval( $product_id );
			}
			if ( !empty( $product_name ) ) {
				$filters[] = " $wpdb->posts.post_title LIKE '%%%s%%' ";
				$filter_params[] = $product_name;
			}
		}
		if ( !empty( $filters ) ) {
			$filters = " WHERE " . implode( " AND ", $filters );
		} else {
			$filters = '';
		}

		$orderby = '';
		if ( isset( $args['display'] ) ) {
			extract( $args['display'] );
			if ( isset( $orderby ) ) {
				switch( $orderby ) {
					case 'id' :
						$orderby = "ORDER BY $wpdb->posts.ID";
						break;
					case 'name' :
						$orderby = "ORDER BY $wpdb->posts.post_title";
						break;
					case 'affiliate_id' :
						break;
					default :
						$orderby = '';
				}
				if ( isset( $order ) ) {
					$orderby .= " $order";
				}
			}
		}

		if ( isset( $row_count ) && isset( $offset ) ) {
			$s = "SELECT * FROM $wpdb->posts $filters $orderby LIMIT $row_count OFFSET $offset";
		} else {
			$s = "SELECT * FROM $wpdb->posts $filters $orderby";
		}

		$q = $wpdb->prepare( $s, $filter_params );
		$rows = $wpdb->get_results( $q );

		foreach ( $rows as $row ) {
			$affiliate_id = null;
			$rate = null;
			if ( isset( $product_options[$row->ID] ) ) {
				if ( isset( $product_options[$row->ID]['affiliate_id'] ) ) {
					$affiliate_id = $product_options[$row->ID]['affiliate_id'];
				}
				if ( isset( $product_options[$row->ID]['rate'] ) ) {
					$rate = $product_options[$row->ID]['rate'];
				}
			}

			$products[] = array(
				'id'           => $row->ID,
				'name'         => $row->post_title,
				'affiliate_id' => $affiliate_id,
				'rate'         => $rate
			);
		}

		return $products;
	}

	/**
	 * Record a product referral when a new order has been saved.
	 * @param int $order_id
	 */
	public static function jigoshop_new_order( $order_id ) {

		$order_total        = get_post_meta( $order_id, '_order_total', true );
		$order_tax          = get_post_meta( $order_id, '_order_tax', true );
		$order_shipping     = get_post_meta( $order_id, '_order_shipping', true );
		$order_shipping_tax = get_post_meta( $order_id, '_order_shipping_tax', true );

		$order_subtotal     = $order_total - $order_tax - $order_shipping - $order_shipping_tax;

		$currency           = Jigoshop_Base::get_options()->get_option('jigoshop_currency');

		$order_link = '<a href="' . admin_url( 'post.php?post=' . $order_id . '&action=edit' ) . '">';
		$order_link .= sprintf( __( 'Order #%s', AFFILIATES_PRODUCTS_PLUGIN_DOMAIN ), $order_id );
		$order_link .= "</a>";

		$options = get_option( 'affiliates_products', null );
		$product_options = isset( $options[self::$instance->get_system()] ) ? $options[self::$instance->get_system()] : array();

		$order = new jigoshop_order();
		if ( $order->get_order( $order_id ) ) {
			$items = $order->items;
			$nets = self::get_net_item_totals( $order_id );
			foreach( $items as $order_item_id => $item ) {

				$product = $order->get_product_from_item( $item );
				// check if it's assigned to an affiliate
				if ( $product->exists() && isset( $product_options[$product->id] ) ) {
					$product_id = $product->id;
					if ( isset( $product_options[$product_id]['affiliate_id'] ) ) {
						$affiliate_id = $product_options[$product_id]['affiliate_id'];
						$rate = isset( $product_options[$product_id]['rate'] ) ? $product_options[$product_id]['rate'] : null;
						if ( $rate && affiliates_check_affiliate_id( $affiliate_id ) ) {

							// get the quantity and calculate the product subtotal
							// this works when tax is included in product prices as well as when it isn't
							// because $item['cost'] is the next price without tax

							$quantity         = isset( $item['qty'] ) && ( $item['qty'] > 0 ) ? $item['qty'] : 1;
							$product_price    = round( $item['cost'] / $quantity, 2 );

							if ( isset( $nets[$order_item_id] ) ) {
								$product_subtotal = $nets[$order_item_id];
							} else {
								$product_subtotal = bcmul( $item['cost'], 1, AFFILIATES_REFERRAL_AMOUNT_DECIMALS );
							}

							$commission = bcmul( $product_subtotal, $rate, AFFILIATES_REFERRAL_AMOUNT_DECIMALS );

							$product_description = get_the_title( $product->id );

							// store a referral
							$data = array(
									'order_id' => array(
											'title' => 'Order ID',
											'domain' => AFFILIATES_PRODUCTS_PLUGIN_DOMAIN,
											'value' => esc_sql( $order_id )
									),
									'order_total' => array(
											'title' => 'Total',
											'domain' =>  AFFILIATES_PRODUCTS_PLUGIN_DOMAIN,
											'value' => esc_sql( $order_subtotal )
									),
									'order_currency' => array(
											'title' => 'Currency',
											'domain' =>  AFFILIATES_PRODUCTS_PLUGIN_DOMAIN,
											'value' => esc_sql( $currency )
									),
									'order_link' => array(
											'title' => 'Order',
											'domain' =>  AFFILIATES_PRODUCTS_PLUGIN_DOMAIN,
											'value' => esc_sql( $order_link )
									),
									'product_id' => array(
											'title' => 'Product ID',
											'domain' => AFFILIATES_PRODUCTS_PLUGIN_DOMAIN,
											'value' => esc_sql( $product_id )
									),
									'product_description' => array(
											'title' => 'Product Description',
											'domain' =>  AFFILIATES_PRODUCTS_PLUGIN_DOMAIN,
											'value' => esc_sql( $product_description )
									),
									'product_price' => array(
											'title' => 'Product Price',
											'domain' =>  AFFILIATES_PRODUCTS_PLUGIN_DOMAIN,
											'value' => esc_sql( $product_price )
									),
									'product_quantity' => array(
											'title' => 'Product Quantity',
											'domain' =>  AFFILIATES_PRODUCTS_PLUGIN_DOMAIN,
											'value' => esc_sql( $quantity )
									),
									'product_subtotal' => array(
											'title' => 'Product Subtotal',
											'domain' =>  AFFILIATES_PRODUCTS_PLUGIN_DOMAIN,
											'value' => esc_sql( $product_subtotal )
									),
	// 								'product_link' => array(
	// 										'title'  => 'Product',
	// 										'domain' => AFFILIATES_PRODUCTS_PLUGIN_DOMAIN,
	// 										'value'  => esc_sql( $product_link )
	// 								)
							);

							$post_id = $order_id;
							$description = sprintf( '%s (Order #%s, Product #%s)', $product_description, $order_id, $product_id );
							if ( class_exists( 'Affiliates_Referral_WordPress' ) ) {
								$r = new Affiliates_Referral_WordPress();
								$r->add_referrals( array( $affiliate_id ), $post_id, $description, $data, $product_subtotal, $commission, $currency, null, 'product', $order_id );
							} else {
								self::add_referral( $affiliate_id, $post_id, $description, $data, $commission, $currency );
							}

						}
					}
				}
			}
		}
	}

	/**
	 * Sets defaults.
	 * @param string $new_status
	 * @param string  $old_status
	 * @param object $post
	 */
	public static function transition_post_status( $new_status, $old_status, $post ) {

		if ( isset( $post->ID ) && isset( $post->post_type ) ) {
			if ( $post->post_type == 'product' ) {
				if ( $product_id = $post->ID ) {

					$options = get_option( 'affiliates_products', array() );
					$product_options = isset( $options[self::$instance->get_system()] ) ? $options[self::$instance->get_system()] : array();

					// don't overwrite settings, especially important because
					// we can get in here quite often
					if ( !isset( $product_options[$product_id] ) ) {

						$auto_assign_to_author = isset( $options['auto_assign_to_author'] ) ? $options['auto_assign_to_author'] : false;
						$default_rate          = isset( $options['default_rate'] ) ? $options['default_rate'] : 0;

						$product_option = array();
						if ( $auto_assign_to_author ) {
							if ( isset( $post->post_author ) ) {
								if ( $affiliate_ids = affiliates_get_user_affiliate( $post->post_author ) ) {
									if ( count( $affiliate_ids ) > 0 ) {
										$product_option['affiliate_id'] = $affiliate_ids[0];
									}
								}
							}
						}

						if ( bccomp( $default_rate, '0', Affiliates_Products_Base::DECIMALS ) > 0 ) {
							$product_option['rate'] = $default_rate;
						}

						if ( count( $product_option ) > 0 ) {
							$product_options[$product_id] = $product_option;

							$options[self::$instance->get_system()] = $product_options;
							update_option( 'affiliates_products', $options );
						}
					}
				}
			}
		}
	}




	/**
	 * Returns net item totals taking into account discounts that have been
	 * applied after taxes.
	 * @param int $order_id
	 * @param boolean $prorate_remaining whether to prorate and subtract the non-per-product-discounts per item (yeah that sounds terrible)
	 * @return array of float net item totals, indexed by order_item_id; null if the order can't be retrieved
	 */
	public static function get_net_item_totals( $order_id, $prorate_remaining = true ) {

		$result = null;

		if ( $order_id ) {
			$order = new jigoshop_order();
			if ( $order->get_order( $order_id ) ) {
				$order_discount           = $order->order_discount;
				$item_total               = 0;
				$net_item_totals          = array();
				$sum_of_product_discounts = 0;

				foreach( $order->items as $order_item_id => $item ) {

					$this_item_total         = self::get_item_total( $item );
					$item_total              += $this_item_total;
					$product                 = $order->get_product_from_item( $item );
					$net_item_total          = $this_item_total;

					foreach( $order->order_discount_coupons as $the_coupon ) {
						$discount = 0;
						if ( $coupon = JS_Coupons::get_coupon( $the_coupon['code'] ) ) {
							$product_array = (array) $product;
							$product_array['product_id'] = $product->id; // (facepalm)
							if ( JS_Coupons::is_valid_coupon_for_product( $the_coupon['code'], $product_array ) )  {
								switch( $the_coupon['type'] ) {
									case 'percent_product' :
										$discount          = $the_coupon['amount'] * $this_item_total / 100;
										break;
									case 'fixed_product' :
										$discount          = $the_coupon['amount'] * $item['qty'];
										break;
								}
							}
						}

						$jigoshop_options = Jigoshop_Base::get_options();
						if ( $jigoshop_options->get_option( 'jigoshop_tax_after_coupon' ) != 'yes' ) {
							if ( isset( $item['taxrate'] ) && $item['taxrate'] > 0 ) {
								$discount = $discount / ( ( 100 + $item['taxrate'] ) / 100 );
							}
						}
						$net_item_total -= $discount;
						if ( $net_item_total < 0 ) {
							$net_item_total = 0;
						}
						$sum_of_product_discounts += $discount;
					}
					$net_item_totals[$order_item_id] = $net_item_total;
				}
				$remaining_order_discount = $order_discount - $sum_of_product_discounts; // *
				if ( $prorate_remaining && $remaining_order_discount > 0 && $item_total > 0 ) {
					$prorated_item_discounts = array(); // *
					foreach( $order->items as $order_item_id => $item ) {
						$this_item_total = self::get_item_total( $item );
						$this_prorated_discount = $this_item_total * $remaining_order_discount / $item_total;
						$prorated_item_discounts[$order_item_id] = $this_prorated_discount;
					}
					foreach ( $order->items as $order_item_id => $item ) {
						$net_item_totals[$order_item_id] -= $prorated_item_discounts[$order_item_id];
					}
				}
				$result = $net_item_totals;
			}
		}
		return $result;
	}

	public static function get_item_total( &$item ) {
		return $item['cost'];
	}

	public static function get_item_total_inc_tax( &$item ) {
		if ( $item['cost_inc_tax'] >= 0 ) {
			return $item['cost_inc_tax'];
		} else {
			return round( ( $item['taxrate'] + 100 ) * self::get_item_total( $item ) / 100, 2 );
		}
	}
}
Affiliates_Products_Jigoshop::init();
