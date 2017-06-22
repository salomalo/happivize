<?php
	
/**
 * Copyright (c) "kento" Karim Rahimpur www.itthinx.com
 * 
 * This code is provided subject to the license granted.
 *
 * UNAUTHORIZED USE AND DISTRIBUTION IS PROHIBITED.
 *
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * 
 * This header and all notices must be kept intact.
 */

	
abstract class Affiliates_Totals implements I_Affiliates_Totals { public static function get_mass_payment_file( $service = 'paypal', $params = null, $charset = null ) { global $affiliates_db; $IXAP15 = isset( $params['from_date'] ) ? $params['from_date'] : null; $IXAP20 = $IXAP15 ? DateHelper::u2s( $IXAP15 ) : null; $IXAP16 = isset( $params['thru_date'] ) ? $params['thru_date'] : null; $IXAP21 = $IXAP16 ? DateHelper::u2s( $IXAP16, 24*3600 ) : null; $IXAP178 = isset( $params['minimum_total'] ) ? bcadd( "0", $params['minimum_total'], AFFILIATES_REFERRAL_AMOUNT_DECIMALS ) : null; $affiliate_status = isset( $params['affiliate_status'] ) ? Affiliates_Utility::verify_affiliate_status( $params['affiliate_status'] ) : null; $referral_status = isset( $params['referral_status'] ) ? Affiliates_Utility::verify_referral_status_transition( $params['referral_status'], $params['referral_status'] ) : null; $currency_id = isset( $params['currency_id'] ) ? Affiliates_Utility::verify_currency_id( $params['currency_id'] ) : null; $affiliate_id = isset( $params['affiliate_id'] ) ? affiliates_check_affiliate_id( $params['affiliate_id'] ) : null; $affiliate_name = isset( $params['affiliate_name'] ) ? $params['affiliate_name'] : null; $affiliate_user_login = isset( $params['affiliate_user_login'] ) ? $params['affiliate_user_login'] : null; $IXAP68 = isset( $params['orderby'] ) ? $params['orderby'] : null; $IXAP69 = isset( $params['order'] ) ? $params['order'] : null; switch ( $IXAP68 ) { case 'affiliate_id' : case 'name' : case 'user_login' : case 'email' : case 'total' : case 'currency_id' : break; default: $IXAP68 = 'name'; } switch ( $IXAP69 ) { case 'asc' : case 'ASC' : case 'desc' : case 'DESC' : break; default: $IXAP69 = 'ASC'; } if ( isset( $params['tables'] ) ) { $affiliates_table = $params['tables']['affiliates']; $affiliates_users_table = $params['tables']['affiliates_users']; $referrals_table = $params['tables']['referrals']; $users_table = $params['tables']['users']; $IXAP179 = array( " 1=%d " ); $IXAP180 = array( 1 ); if ( $affiliate_id ) { $IXAP179[] = " a.affiliate_id = %d "; $IXAP180[] = $affiliate_id; } if ( $affiliate_name ) { $IXAP179[] = " a.name LIKE '%%%s%%' "; $IXAP180[] = $affiliate_name; } if ( $affiliate_user_login ) { $IXAP179[] = " u.user_login LIKE '%%%s%%' "; $IXAP180[] = $affiliate_user_login; } if ( $IXAP20 && $IXAP21 ) { $IXAP179[] = " r.datetime >= %s AND r.datetime < %s "; $IXAP180[] = $IXAP20; $IXAP180[] = $IXAP21; } else if ( $IXAP20 ) { $IXAP179[] = " r.datetime >= %s "; $IXAP180[] = $IXAP20; } else if ( $IXAP21 ) { $IXAP179[] = " r.datetime < %s "; $IXAP180[] = $IXAP21; } if ( $affiliate_status ) { $IXAP179[] = " a.status = %s "; $IXAP180[] = $affiliate_status; } if ( $referral_status ) { $IXAP179[] = " r.status = %s "; $IXAP180[] = $referral_status; } if ( $currency_id ) { $IXAP179[] = " r.currency_id = %s "; $IXAP180[] = $currency_id; } if ( !empty( $IXAP179 ) ) { $IXAP179 = " WHERE " . implode( " AND ", $IXAP179 ); } else { $IXAP179 = ''; } $IXAP181 = ''; if ( $IXAP178 ) { $IXAP181 .= " HAVING SUM(r.amount) >= %s "; $IXAP180[] = $IXAP178; } $IXAP182 = ''; if ( $IXAP68 && $IXAP69 ) { $IXAP182 .= " ORDER BY $IXAP68 $IXAP69 "; } $IXAP26 = $affiliates_db->get_objects( "
				SELECT a.*, u.user_login, SUM(r.amount) as total, r.currency_id
				FROM $referrals_table r
				LEFT JOIN $affiliates_table a ON r.affiliate_id = a.affiliate_id
				LEFT JOIN $affiliates_users_table au ON a.affiliate_id = au.affiliate_id
				LEFT JOIN $users_table u on au.user_id = u.ID
				$IXAP179
				GROUP BY r.affiliate_id, r.currency_id
				$IXAP181
				$IXAP182
				", $IXAP180 ); $service = strtolower( $service ); if ( !headers_sent() ) { switch ( $service ) { case 'paypal' : $now = date( 'Y-m-d-H-i-s', time() ); header( 'Content-Description: File Transfer' ); if ( !empty( $charset ) ) { header( 'Content-Type: text/plain; charset=' . $charset ); } else { header( 'Content-Type: text/plain' ); } header( "Content-Disposition: attachment; filename=\"affiliates-mass-payment-$now.txt\"" ); foreach( $IXAP26 as $IXAP11 ) { $IXAP183 = Affiliates_Affiliate::get_attribute( $IXAP11->affiliate_id, Affiliates_Attributes::IXAP128 ); $IXAP184 = !empty( $IXAP183 ) ? $IXAP183 : $IXAP11->email; $amount = $IXAP11->total; $currency_id = $IXAP11->currency_id; $affiliate_id = $IXAP11->affiliate_id; $note = "Affiliate payment"; if ( !empty( $IXAP184 ) && !empty( $amount ) && !empty( $currency_id ) ) { echo "$IXAP184\t$amount\t$currency_id\t$affiliate_id\t$note\n"; } } echo "\n"; break; case 'export' : $now = date( 'Y-m-d-H-i-s', time() ); header( 'Content-Description: File Transfer' ); if ( !empty( $charset ) ) { header( 'Content-Type: text/tab-separated-values; charset=' . $charset ); } else { header( 'Content-Type: text/tab-separated-values' ); } header( "Content-Disposition: attachment; filename=\"affiliates-totals-export-$now.tsv\"" ); echo __( 'Id', AFFILIATES_PRO_PLUGIN_DOMAIN ); echo "\t"; echo __( 'Affiliate', AFFILIATES_PRO_PLUGIN_DOMAIN ); echo "\t"; echo __( 'Email', AFFILIATES_PRO_PLUGIN_DOMAIN ); echo "\t"; echo __( 'Username', AFFILIATES_PRO_PLUGIN_DOMAIN ); echo "\t"; echo __( 'Total', AFFILIATES_PRO_PLUGIN_DOMAIN ); echo "\t"; echo __( 'Currency', AFFILIATES_PRO_PLUGIN_DOMAIN ); echo "\n"; foreach( $IXAP26 as $IXAP11 ) { $affiliate_id = $IXAP11->affiliate_id; $name = stripslashes( $IXAP11->name ); $IXAP184 = $IXAP11->email; $user_login = stripslashes( $IXAP11->user_login ); $amount = $IXAP11->total; $currency_id = $IXAP11->currency_id; echo "$affiliate_id\t$name\t$IXAP184\t$user_login\t$amount\t$currency_id\n"; } echo "\n"; } } else { wp_die( 'ERROR: headers already sent' ); } } } public static function update_status( $new_status, $params = null ) { global $affiliates_db; $IXAP34 = ""; $IXAP15 = isset( $params['from_date'] ) ? $params['from_date'] : null; $IXAP20 = $IXAP15 ? DateHelper::u2s( $IXAP15 ) : null; $IXAP16 = isset( $params['thru_date'] ) ? $params['thru_date'] : null; $IXAP21 = $IXAP16 ? DateHelper::u2s( $IXAP16, 24*3600 ) : null; $IXAP178 = isset( $params['minimum_total'] ) ? bcadd( "0", $params['minimum_total'], AFFILIATES_REFERRAL_AMOUNT_DECIMALS ) : null; $affiliate_status = isset( $params['affiliate_status'] ) ? Affiliates_Utility::verify_affiliate_status( $params['affiliate_status'] ) : null; $referral_status = isset( $params['referral_status'] ) ? Affiliates_Utility::verify_referral_status_transition( $params['referral_status'], $params['referral_status'] ) : null; $currency_id = isset( $params['currency_id'] ) ? Affiliates_Utility::verify_currency_id( $params['currency_id'] ) : null; $affiliate_id = isset( $params['affiliate_id'] ) ? affiliates_check_affiliate_id( $params['affiliate_id'] ) : null; $affiliate_name = isset( $params['affiliate_name'] ) ? $params['affiliate_name'] : null; $affiliate_user_login = isset( $params['affiliate_user_login'] ) ? $params['affiliate_user_login'] : null; $IXAP68 = isset( $params['orderby'] ) ? $params['orderby'] : null; $IXAP69 = isset( $params['order'] ) ? $params['order'] : null; switch ( $IXAP68 ) { case 'affiliate_id' : case 'name' : case 'email' : $IXAP68 = 'a.' . $IXAP68; break; case 'user_login' : $IXAP68 = 'au.' . $IXAP68; break; case 'currency_id' : $IXAP68 = 'r.' . $IXAP68; break; default: $IXAP68 = 'a.name'; } switch ( $IXAP69 ) { case 'asc' : case 'ASC' : case 'desc' : case 'DESC' : break; default: $IXAP69 = 'ASC'; } if ( isset( $params['tables'] ) ) { $IXAP34 .= "<h1>" . __( "Closing referrals", AFFILIATES_PRO_PLUGIN_DOMAIN ) . "</h1>"; $IXAP34 .= "<div class='closing-referrals-overview'>"; $affiliates_table = $params['tables']['affiliates']; $affiliates_users_table = $params['tables']['affiliates_users']; $referrals_table = $params['tables']['referrals']; $users_table = $params['tables']['users']; $IXAP179 = array( " 1=%d " ); $IXAP180 = array( 1 ); if ( $affiliate_id ) { $IXAP179[] = " a.affiliate_id = %d "; $IXAP180[] = $affiliate_id; } if ( $affiliate_name ) { $IXAP179[] = " a.name LIKE '%%%s%%' "; $IXAP180[] = $affiliate_name; } if ( $affiliate_user_login ) { $IXAP179[] = " u.user_login LIKE '%%%s%%' "; $IXAP180[] = $affiliate_user_login; } if ( $IXAP20 && $IXAP21 ) { $IXAP179[] = " r.datetime >= %s AND r.datetime < %s "; $IXAP180[] = $IXAP20; $IXAP180[] = $IXAP21; } else if ( $IXAP20 ) { $IXAP179[] = " r.datetime >= %s "; $IXAP180[] = $IXAP20; } else if ( $IXAP21 ) { $IXAP179[] = " r.datetime < %s "; $IXAP180[] = $IXAP21; } if ( $affiliate_status ) { $IXAP179[] = " a.status = %s "; $IXAP180[] = $affiliate_status; } if ( $referral_status ) { $IXAP179[] = " r.status = %s "; $IXAP180[] = $referral_status; } if ( $currency_id ) { $IXAP179[] = " r.currency_id = %s "; $IXAP180[] = $currency_id; } if ( $IXAP178 ) { $subfilters = $IXAP179; if ( !empty( $subfilters ) ) { $subfilters = " WHERE " . implode( " AND ", $IXAP179 ); } else { $subfilters = ''; } $subfilter_params = $IXAP180; $subhaving = " HAVING SUM(r.amount) >= %s "; $subfilter_params[] = $IXAP178; $IXAP179[] = " (a.affiliate_id, r.currency_id) IN
					(
					SELECT r.affiliate_id, r.currency_id
					FROM $referrals_table r
					LEFT JOIN $affiliates_table a ON r.affiliate_id = a.affiliate_id
					LEFT JOIN $affiliates_users_table au ON a.affiliate_id = au.affiliate_id
					LEFT JOIN $users_table u on au.user_id = u.ID
					$subfilters
					GROUP BY r.affiliate_id, r.currency_id
					$subhaving
					)
					"; foreach( $subfilter_params as $subfilter_param ) { array_push( $IXAP180, $subfilter_param ); } $IXAP179[] = " r.amount IS NOT NULL "; } if ( !empty( $IXAP179 ) ) { $IXAP179 = " WHERE " . implode( " AND ", $IXAP179 ); } else { $IXAP179 = ''; } $IXAP182 = ''; if ( $IXAP68 && $IXAP69 ) { $IXAP182 .= " ORDER BY $IXAP68 $IXAP69 "; } $step = isset( $params['step'] ) ? intval( $params['step'] ) : 1; switch ( $step ) { case 1 : $IXAP26 = $affiliates_db->get_objects( "
						SELECT a.*, r.*, u.user_login
						FROM $referrals_table r
						LEFT JOIN $affiliates_table a ON r.affiliate_id = a.affiliate_id
						LEFT JOIN $affiliates_users_table au ON a.affiliate_id = au.affiliate_id
						LEFT JOIN $users_table u on au.user_id = u.ID
						$IXAP179
						$IXAP182
						", $IXAP180 ); $IXAP34 .= "<div class='manage'>"; $IXAP34 .= "<div class='warning'>"; $IXAP34 .= "<p>"; $IXAP34 .= "<strong>"; $IXAP34 .= __( "Please review the list of referrals that will be <em>closed</em>.", AFFILIATES_PRO_PLUGIN_DOMAIN ); $IXAP34 .= "</strong>"; $IXAP34 .= "</p>"; $IXAP34 .= "</div>"; $IXAP34 .= "<p>"; $IXAP34 .= __( "Usually only referrals that are <em>accepted</em> and have been paid out should be <em>closed</em>. If there are unwanted or too many referrals shown, restrict your filter settings.", AFFILIATES_PRO_PLUGIN_DOMAIN ); $IXAP34 .= "</p>"; $IXAP34 .= "<p>"; $IXAP34 .= __( "If these referrals can be closed, click the confirmation button below.", AFFILIATES_PRO_PLUGIN_DOMAIN ); $IXAP34 .= "</p>"; $IXAP34 .= "</div>"; $IXAP34 .= '<div id="referrals-overview" class="referrals-overview">'; $IXAP34 .= self::render_results( $IXAP26 ); $IXAP34 .= '</div>'; if ( count( $IXAP26 > 0 ) ) { $IXAP185 = ""; if ( !empty( $IXAP15 ) ) { $IXAP185 .= "&from_date=" . urlencode( $IXAP15 ); } if ( !empty( $IXAP16 ) ) { $IXAP185 .= "&thru_date=" . urlencode( $IXAP16 ); } if ( !empty( $IXAP178 ) ) { $IXAP185 .= "&minimum_total=" . urlencode( $IXAP178 ); } if ( !empty( $affiliate_status ) ) { $IXAP185 .= "&affiliate_status=" . urlencode( $affiliate_status ); } if ( !empty( $referral_status ) ) { $IXAP185 .= "&referral_status=" . urlencode( $referral_status ); } if ( !empty( $currency_id ) ) { $IXAP185 .= "&currency_id=" . urlencode( $currency_id ); } if ( !empty( $affiliate_id ) ) { $IXAP185 .= "&affiliate_id=" . urlencode( $affiliate_id ); } if ( !empty( $affiliate_name ) ) { $IXAP185 .= "&affiliate_name=" . urlencode( $affiliate_name ); } if ( !empty( $affiliate_user_login ) ) { $IXAP185 .= "&affiliate_user_login=" . urlencode( $affiliate_user_login ); } if ( !empty( $IXAP68 ) ) { $IXAP185 .= "&orderby=" . urlencode( $IXAP68 ); } if ( !empty( $IXAP69 ) ) { $IXAP185 .= "&order=" . urlencode( $IXAP69 ); } $IXAP186 = esc_url( AFFILIATES_PRO_PLUGIN_URL . 'lib/ext/includes/generate-mass-payment-file.php' ); $IXAP34 .= '<div class="manage confirm">'; $IXAP59 = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; $IXAP59 = remove_query_arg( 'paged', $IXAP59 ); $IXAP59 = remove_query_arg( 'action', $IXAP59 ); $IXAP59 = remove_query_arg( 'affiliate_id', $IXAP59 ); $IXAP34 .= "<p>"; $IXAP34 .= __( "Close these referrals by clicking:", AFFILIATES_PRO_PLUGIN_DOMAIN ); $IXAP34 .= "</p>"; $IXAP34 .= "<a title='" . __( 'Click to close these referrals', AFFILIATES_PRO_PLUGIN_DOMAIN ) . "' " . "class='close-referrals button' " . "href='" . esc_url( $IXAP59 ) . "&action=close_referrals&step=2" . $IXAP185 . "'>" . "<img class='icon' alt='" . __( 'Close referrals', AFFILIATES_PRO_PLUGIN_DOMAIN) . "' src='". AFFILIATES_PRO_PLUGIN_URL ."images/closed.png'/>" . "<span class='label'>" . __( 'Close Referrals', AFFILIATES_PRO_PLUGIN_DOMAIN) . "</span>" . "</a>"; $IXAP34 .= "<div class='warning'>"; $IXAP34 .= "<p>"; $IXAP34 .= "<strong>"; $IXAP34 .= __( "This action can not be undone*.", AFFILIATES_PRO_PLUGIN_DOMAIN ); $IXAP34 .= "</strong>"; $IXAP34 .= "</p>"; $IXAP34 .= "<p>"; $IXAP34 .= "<span style='font-size:0.8em;'>"; $IXAP34 .= __( "*To undo, each referral would have to be set to the desired status individually.", AFFILIATES_PRO_PLUGIN_DOMAIN ); $IXAP34 .= "</span>"; $IXAP34 .= "</p>"; $IXAP34 .= "</div>"; $IXAP34 .= '</div>'; } break; case 2 : $IXAP26 = $affiliates_db->get_objects( "
						SELECT a.*, r.*, u.user_login
						FROM $referrals_table r
						LEFT JOIN $affiliates_table a ON r.affiliate_id = a.affiliate_id
						LEFT JOIN $affiliates_users_table au ON a.affiliate_id = au.affiliate_id
						LEFT JOIN $users_table u on au.user_id = u.ID
						$IXAP179
						$IXAP182
						", $IXAP180 ); $IXAP187 = array(); $IXAP188 = array(); $IXAP189 = array(); foreach ( $IXAP26 as $IXAP11 ) { if ( $s = Affiliates_Utility::verify_referral_status_transition( $IXAP11->status, $new_status ) ) { if ( $affiliates_db->query( "UPDATE $referrals_table SET status = %s WHERE affiliate_id = %d AND post_id = %d AND datetime = %s ", $s, $IXAP11->affiliate_id, $IXAP11->post_id, $IXAP11->datetime ) ) { $IXAP11->status = $s; $IXAP187[] = $IXAP11; } else { $IXAP189[] = $IXAP11; } } else { $IXAP188[] = $IXAP11; } } $status_descriptions = array( AFFILIATES_REFERRAL_STATUS_ACCEPTED => __( 'Accepted', AFFILIATES_PLUGIN_DOMAIN ), AFFILIATES_REFERRAL_STATUS_CLOSED => __( 'Closed', AFFILIATES_PLUGIN_DOMAIN ), AFFILIATES_REFERRAL_STATUS_PENDING => __( 'Pending', AFFILIATES_PLUGIN_DOMAIN ), AFFILIATES_REFERRAL_STATUS_REJECTED => __( 'Rejected', AFFILIATES_PLUGIN_DOMAIN ), ); $IXAP34 .= "<h2>" . __( "Updated", AFFILIATES_PRO_PLUGIN_DOMAIN ) . "</h2>"; $IXAP34 .= "<p>"; $IXAP34 .= sprintf( __( "These referrals have been updated to <em>%s</em>.", AFFILIATES_PRO_PLUGIN_DOMAIN ), ( isset( $status_descriptions[$new_status] ) ? $status_descriptions[$new_status] : $new_status ) ); $IXAP34 .= "</p>"; $IXAP34 .= self::render_results( $IXAP187 ); if ( count( $IXAP188 ) > 0 ) { $IXAP34 .= "<h2>" . __( "Omitted", AFFILIATES_PRO_PLUGIN_DOMAIN ) . "</h2>"; $IXAP34 .= "<p>"; $IXAP34 .= sprintf( __( "These referrals have been omitted because their status must not be changed to <em>%s</em>.", AFFILIATES_PRO_PLUGIN_DOMAIN ), ( isset( $status_descriptions[$new_status] ) ? $status_descriptions[$new_status] : $new_status ) ); $IXAP34 .= "</p>"; $IXAP34 .= self::render_results( $IXAP188 ); } if ( count( $IXAP189 ) > 0 ) { $IXAP34 .= "<h2>" . __( "Failed", AFFILIATES_PRO_PLUGIN_DOMAIN ) . "</h2>"; $IXAP34 .= "<p>"; $IXAP34 .= sprintf( __( "These referrals could not be updated to <em>%s</em>.", AFFILIATES_PRO_PLUGIN_DOMAIN ), ( isset( $status_descriptions[$new_status] ) ? $status_descriptions[$new_status] : $new_status ) ); $IXAP34 .= "</p>"; $IXAP34 .= self::render_results( $IXAP189 ); } break; } $IXAP34 .= "</div>"; } return $IXAP34; } public static function render_results( $IXAP26 ) { $IXAP34 = ""; $IXAP105 = array( 'datetime' => __( 'Date', AFFILIATES_PLUGIN_DOMAIN ), 'post_title' => __( 'Post', AFFILIATES_PLUGIN_DOMAIN ), 'name' => __( 'Affiliate', AFFILIATES_PLUGIN_DOMAIN ), 'amount' => __( 'Amount', AFFILIATES_PLUGIN_DOMAIN ), 'currency_id' => __( 'Currency', AFFILIATES_PLUGIN_DOMAIN ), 'status' => __( 'Status', AFFILIATES_PLUGIN_DOMAIN ) ); $status_descriptions = array( AFFILIATES_REFERRAL_STATUS_ACCEPTED => __( 'Accepted', AFFILIATES_PLUGIN_DOMAIN ), AFFILIATES_REFERRAL_STATUS_CLOSED => __( 'Closed', AFFILIATES_PLUGIN_DOMAIN ), AFFILIATES_REFERRAL_STATUS_PENDING => __( 'Pending', AFFILIATES_PLUGIN_DOMAIN ), AFFILIATES_REFERRAL_STATUS_REJECTED => __( 'Rejected', AFFILIATES_PLUGIN_DOMAIN ), ); $status_icons = array( AFFILIATES_REFERRAL_STATUS_ACCEPTED => "<img class='icon' alt='" . __( 'Accepted', AFFILIATES_PRO_PLUGIN_DOMAIN) . "' src='" . AFFILIATES_PRO_PLUGIN_URL . "images/accepted.png'/>", AFFILIATES_REFERRAL_STATUS_CLOSED => "<img class='icon' alt='" . __( 'Closed', AFFILIATES_PRO_PLUGIN_DOMAIN) . "' src='" . AFFILIATES_PRO_PLUGIN_URL . "images/closed.png'/>", AFFILIATES_REFERRAL_STATUS_PENDING => "<img class='icon' alt='" . __( 'Pending', AFFILIATES_PRO_PLUGIN_DOMAIN) . "' src='" . AFFILIATES_PRO_PLUGIN_URL . "images/pending.png'/>", AFFILIATES_REFERRAL_STATUS_REJECTED => "<img class='icon' alt='" . __( 'Rejected', AFFILIATES_PRO_PLUGIN_DOMAIN) . "' src='" . AFFILIATES_PRO_PLUGIN_URL . "images/rejected.png'/>", ); $IXAP34 .= '<table id="referrals" class="referrals wp-list-table widefat fixed" cellspacing="0">'; $IXAP34 .= "<thead>"; $IXAP34 .= "<tr>"; foreach ( $IXAP105 as $key => $IXAP106 ) { $IXAP34 .= "<th scope='col'>$IXAP106</th>"; } $IXAP34 .= "</tr>"; $IXAP34 .= "</thead>"; $IXAP34 .= "<tbody>"; if ( count( $IXAP26 ) > 0 ) { for ( $i = 0; $i < count( $IXAP26 ); $i++ ) { $IXAP11 = $IXAP26[$i]; $IXAP34 .= '<tr class="details-referrals ' . ( $i % 2 == 0 ? 'even' : 'odd' ) . '">'; $IXAP34 .= '<td class="datetime">' . DateHelper::s2u( $IXAP11->datetime ) . '</td>'; $IXAP190 = get_the_title( $IXAP11->post_id ); $IXAP34 .= '<td class="post_title">' . wp_filter_nohtml_kses( $IXAP190 ) . '</td>'; $IXAP34 .= "<td class='name'>" . stripslashes( wp_filter_nohtml_kses( $IXAP11->name ) ) . "</td>"; $IXAP34 .= "<td class='amount'>" . stripslashes( wp_filter_nohtml_kses( $IXAP11->amount ) ) . "</td>"; $IXAP34 .= "<td class='currency_id'>" . stripslashes( wp_filter_nohtml_kses( $IXAP11->currency_id ) ) . "</td>"; $IXAP34 .= "<td class='status'>"; $IXAP34 .= isset( $status_icons[$IXAP11->status] ) ? $status_icons[$IXAP11->status] : ''; $IXAP34 .= isset( $status_descriptions[$IXAP11->status] ) ? $status_descriptions[$IXAP11->status] : ''; $IXAP34 .= "</td>"; $IXAP34 .= '</tr>'; } } else { $IXAP34 .= '<tr><td colspan="' . count( $IXAP105 ) . '">' . __('There are no results.', AFFILIATES_PLUGIN_DOMAIN ) . '</td></tr>'; } $IXAP34 .= '</tbody>'; $IXAP34 .= '</table>'; return $IXAP34; } }