<?php
 class Affiliates_Traffic_Renderer_WordPress extends Affiliates_Traffic_Renderer { public static function init() { add_shortcode( 'affiliates_traffic', array( __CLASS__, 'affiliates_traffic' ) ); } public static function affiliates_traffic( $IXAP31, $IXAP32 = null ) { $IXAP34 = ''; wp_enqueue_script( 'datepicker' ); wp_enqueue_script( 'datepickers' ); wp_enqueue_style( 'smoothness' ); wp_enqueue_style( 'affiliates-pro' ); $IXAP24 = shortcode_atts( self::$IXAP191, $IXAP31 ); foreach( self::$IXAP191 as $key => $IXAP336 ) { switch( $key ) { case 'show_dates' : case 'show_visits' : case 'show_hits' : case 'show_referrals' : case 'show_src_uris' : case 'show_dest_uris' : case 'show_filters' : case 'show_pagination' : if ( isset( $IXAP24[$key] ) ) { if ( is_string( $IXAP24[$key] ) ) { $value = strtolower( trim( $IXAP24[$key] ) ); switch( $value ) { case 'true' : case 'yes' : $IXAP24[$key] = true; break; case 'false' : case 'no' : $IXAP24[$key] = false; break; default : $IXAP24[$key] = $IXAP336; } } else { $IXAP24[$key] = $IXAP24[$key] ? true : false; } } break; case 'src_uri_maxlength' : case 'dest_uri_maxlength' : case 'per_page' : $value = trim( $IXAP24[$key] ); if ( !empty( $value ) ) { $IXAP24[$key] = max( 0, intval( $value ) ); } else { $IXAP24[$key] = 0; } break; case 'status' : if ( is_string( $IXAP24[$key] ) ) { $IXAP24[$key] = array_map( 'trim', explode( ',', $IXAP24[$key] ) ); } $values = array(); foreach( $IXAP24[$key] as $status ) { if ( $status = Affiliates_Utility::verify_referral_status_transition( $status, $status ) ) { $values[] = $status; } } if (!empty( $values ) ) { $IXAP24[$key] = $values; } else { $IXAP24[$key] = self::$IXAP191[$key]; } break; } } if ( $IXAP24['per_page'] <= 0 ) { $IXAP24['per_page'] = self::$IXAP191['per_page']; } $IXAP34 = self::render_affiliate_traffic( $IXAP24 ); return $IXAP34; } public static function render_affiliate_traffic( $IXAP24 = array() ) { global $wpdb, $affiliates_options, $affiliates_db; $IXAP24 = shortcode_atts( self::$IXAP191, $IXAP24 ); $IXAP105 = array(); if ( $IXAP24['show_dates'] ) { $IXAP105['date'] = __( 'Date', 'affiliates' ); } if ( $IXAP24['show_visits'] ) { $IXAP105['visits'] = __( 'Visits', 'affiliates' ); } if ( $IXAP24['show_hits'] ) { $IXAP105['hits'] = __( 'Hits', 'affiliates' ); } if ( $IXAP24['show_referrals'] ) { $IXAP105['referrals'] = __( 'Referrals', 'affiliates' ); } if ( $IXAP24['show_src_uris'] ) { $IXAP105['src_uri'] = __( 'Source URI', 'affiliates' ); } if ( $IXAP24['show_dest_uris'] ) { $IXAP105['dest_uri'] = __( 'Landing URI', 'affiliates' ); } $IXAP34 = ''; $user_id = get_current_user_id(); $affiliate_id = null; if ( $user_id ) { $affiliate_ids = affiliates_get_user_affiliate( $user_id ); if ( !empty( $affiliate_ids ) ) { $affiliate_id = array_shift( $affiliate_ids ); } } if ( !$affiliate_id ) { return $IXAP34; } $IXAP59 = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; $IXAP59 = remove_query_arg( 'uris_paged', $IXAP59 ); $IXAP59 = remove_query_arg( 'clear_filters', $IXAP59 ); $IXAP59 = remove_query_arg( 'apply_filters', $IXAP59 ); $IXAP15 = isset( $_REQUEST['from_date'] ) ? trim( $_REQUEST['from_date'] ) : null; $IXAP16 = isset( $_REQUEST['thru_date'] ) ? trim( $_REQUEST['thru_date'] ) : null; $src_uri = isset( $_REQUEST['src_uri'] ) ? trim( $_REQUEST['src_uri'] ) : null; $IXAP337 = isset( $_REQUEST['dest_uri'] ) ? trim( $_REQUEST['dest_uri'] ) : null; $IXAP338 = isset( $_REQUEST['min_referrals'] ) ? trim( $_REQUEST['min_referrals'] ) : null; if ( isset( $_REQUEST['clear_filters'] ) ) { unset( $_REQUEST['from_date'] ); unset( $_REQUEST['thru_date'] ); unset( $_REQUEST['src_uri'] ); unset( $_REQUEST['dest_uri'] ); unset( $_REQUEST['min_referrals'] ); $IXAP15 = null; $IXAP16 = null; $src_uri = null; $IXAP337 = null; $IXAP338 = null; $IXAP59 = remove_query_arg( 'from_date', $IXAP59 ); $IXAP59 = remove_query_arg( 'thru_date', $IXAP59 ); $IXAP59 = remove_query_arg( 'src_uri', $IXAP59 ); $IXAP59 = remove_query_arg( 'dest_uri', $IXAP59 ); $IXAP59 = remove_query_arg( 'min_referrals', $IXAP59 ); } else { if ( !empty( $_REQUEST['from_date'] ) ) { $IXAP15 = date( 'Y-m-d', strtotime( $_REQUEST['from_date'] ) ); } else { $IXAP15 = null; } if ( !empty( $_REQUEST['thru_date'] ) ) { $IXAP16 = date( 'Y-m-d', strtotime( $_REQUEST['thru_date'] ) ); } else { $IXAP16 = null; } if ( $IXAP15 && $IXAP16 ) { if ( strtotime( $IXAP15 ) > strtotime( $IXAP16 ) ) { $IXAP16 = null; } } if ( !empty( $_REQUEST['src_uri'] ) ) { $src_uri = trim( $_REQUEST['src_uri'] ); } else if ( isset( $_REQUEST['src_uri'] ) ) { $src_uri = null; } if ( !empty( $_REQUEST['dest_uri'] ) ) { $IXAP337 = trim( $_REQUEST['dest_uri'] ); } else if ( isset( $_REQUEST['dest_uri'] ) ) { $IXAP337 = null; } if ( !empty( $_REQUEST['min_referrals'] ) ) { $IXAP338 = max( 0, intval( $_REQUEST['min_referrals'] ) ); } else if ( isset( $_REQUEST['min_referrals'] ) ) { $IXAP338 = null; } } $affiliates_table = _affiliates_get_tablename( 'affiliates' ); $referrals_table = _affiliates_get_tablename( 'referrals' ); $IXAP18 = _affiliates_get_tablename( 'hits' ); $IXAP339 = _affiliates_get_tablename( 'uris' ); $IXAP247 = isset( $_REQUEST['row_count'] ) ? intval( $_REQUEST['row_count'] ) : 0; if ($IXAP247 <= 0) { $IXAP247 = $IXAP24['per_page']; } $IXAP248 = isset( $_GET['offset'] ) ? intval( $_GET['offset'] ) : 0; if ( $IXAP248 < 0 ) { $IXAP248 = 0; } $IXAP249 = isset( $_REQUEST['uris_paged'] ) ? intval( $_REQUEST['uris_paged'] ) : 0; if ( $IXAP249 < 0 ) { $IXAP249 = 0; } $IXAP68 = isset( $_GET['orderby'] ) ? $_GET['orderby'] : null; switch ( $IXAP68 ) { case 'date' : case 'visits' : case 'hits' : case 'referrals' : case 'src_uri' : case 'dest_uri' : break; default: $IXAP68 = 'date'; } $IXAP69 = isset( $_GET['order'] ) ? $_GET['order'] : null; switch ( $IXAP69 ) { case 'asc' : case 'ASC' : $switch_order = 'DESC'; break; case 'desc' : case 'DESC' : $switch_order = 'ASC'; break; default: $IXAP69 = 'DESC'; $switch_order = 'ASC'; } $IXAP179 = " WHERE 1=%d "; $IXAP180 = array( 1 ); if ( $IXAP15 ) { $IXAP20 = DateHelper::u2s( $IXAP15 ); } if ( $IXAP16 ) { $IXAP21 = DateHelper::u2s( $IXAP16, 24*3600 ); } if ( $IXAP15 && $IXAP16 ) { $IXAP179 .= " AND h.datetime >= %s AND h.datetime <= %s "; $IXAP180[] = $IXAP20; $IXAP180[] = $IXAP21; } else if ( $IXAP15 ) { $IXAP179 .= " AND h.datetime >= %s "; $IXAP180[] = $IXAP20; } else if ( $IXAP16 ) { $IXAP179 .= " AND h.datetime < %s "; $IXAP180[] = $IXAP21; } $IXAP179 .= " AND h.affiliate_id = %d "; $IXAP180[] = $affiliate_id; if ( $src_uri ) { $IXAP179 .= " AND su.uri LIKE '%%%s%%' "; $IXAP180[] = $wpdb->esc_like( $src_uri ); } if ( $IXAP337 ) { $IXAP179 .= " AND du.uri LIKE '%%%s%%' "; $IXAP180[] = $wpdb->esc_like( $IXAP337 ); } $IXAP181 = ''; if ( $IXAP338 ) { $IXAP181 = " HAVING COUNT(r.hit_id) >= " . intval( $IXAP338 ). " "; } $status_condition = ''; if ( is_array( $IXAP24['status'] ) && count( $IXAP24['status'] ) > 0 ) { $status_condition = " AND r.status IN ('" . implode( "','", array_map( 'esc_sql', $IXAP24['status'] ) ) . "') "; } $IXAP250 = $wpdb->prepare( "SELECT
			h.affiliate_id,
			COUNT(r.hit_id) referrals
			FROM $IXAP18 h
			LEFT JOIN $IXAP339 su ON h.src_uri_id = su.uri_id
			LEFT JOIN $IXAP339 du ON h.dest_uri_id = du.uri_id
			LEFT JOIN $referrals_table r ON r.hit_id = h.hit_id $status_condition
			$IXAP179
			GROUP BY h.affiliate_id, h.date, su.uri, du.uri
			$IXAP181", $IXAP180 ); $wpdb->query( $IXAP250 ); $IXAP251 = $wpdb->num_rows; if ( $IXAP251 > $IXAP247 ) { $IXAP252 = true; } else { $IXAP252 = false; } $IXAP75 = ceil ( $IXAP251 / $IXAP247 ); if ( $IXAP249 > $IXAP75 ) { $IXAP249 = $IXAP75; } if ( $IXAP249 != 0 ) { $IXAP248 = ( $IXAP249 - 1 ) * $IXAP247; } $IXAP3 = $wpdb->prepare( "SELECT
			h.*,
			a.name,
			su.uri src_uri,
			du.uri dest_uri,
			COUNT(distinct h.ip) visits,
			SUM(count) hits,
			COUNT(r.hit_id) referrals
			FROM $IXAP18 h
			LEFT JOIN $affiliates_table a ON h.affiliate_id = a.affiliate_id
			LEFT JOIN $IXAP339 su ON h.src_uri_id = su.uri_id
			LEFT JOIN $IXAP339 du ON h.dest_uri_id = du.uri_id
			LEFT JOIN $referrals_table r ON r.hit_id = h.hit_id $status_condition
			$IXAP179
			GROUP BY h.affiliate_id, h.date, su.uri, du.uri
			$IXAP181
			ORDER BY $IXAP68 $IXAP69
			LIMIT $IXAP247 OFFSET $IXAP248", $IXAP180 ); $IXAP26 = $wpdb->get_results( $IXAP3, OBJECT ); $IXAP34 .= '<div class="affiliates-traffic">'; if ( $IXAP24['show_filters'] ) { $IXAP34 .= '<div class="filters">'; $IXAP34 .= '<label class="description" for="setfilters">' . __( 'Filters', 'affiliates' ) . '</label>'; $IXAP34 .= '<form id="setfilters" action="" method="get">'; if ( isset( $IXAP105['date'] ) ) { $IXAP34 .= '<div class="filter-section">'; $IXAP34 .= '<label class="from-date-filter">'; $IXAP34 .= __( 'From', 'affiliates' ); $IXAP34 .= ' '; $IXAP34 .= '<input class="datefield from-date-filter" name="from_date" type="text" value="' . esc_attr( $IXAP15 ) . '"/>'; $IXAP34 .= '</label>'; $IXAP34 .= ' '; $IXAP34 .= '<label class="thru-date-filter">'; $IXAP34 .= __( 'Until', 'affiliates' ); $IXAP34 .= ' '; $IXAP34 .= '<input class="datefield thru-date-filter" name="thru_date" type="text" class="datefield" value="' . esc_attr( $IXAP16 ) . '"/>'; $IXAP34 .= '</label>'; $IXAP34 .= '</div>'; } if ( isset( $IXAP105['src_uri'] ) || isset( $IXAP105['dest_uri'] ) ) { $IXAP34 .= '<div class="filter-section">'; } if ( isset( $IXAP105['src_uri'] ) ) { $IXAP34 .= '<label class="src-uri-filter">'; $IXAP34 .= __( 'Source URI', 'affiliates' ); $IXAP34 .= ' '; $IXAP34 .= '<input class="src-uri-filter" name="src_uri" type="text" value="' . esc_attr( stripslashes( $src_uri ) ) . '"/>'; $IXAP34 .= '</label>'; $IXAP34 .= ' '; } if ( isset( $IXAP105['dest_uri'] ) ) { $IXAP34 .= '<label class="dest-uri-filter">'; $IXAP34 .= __( 'Landing URI', 'affiliates' ); $IXAP34 .= ' '; $IXAP34 .= '<input class="dest-uri-filter" name="dest_uri" type="text" value="' . esc_attr( stripslashes( $IXAP337 ) ) . '"/>'; $IXAP34 .= '</label>'; } if ( isset( $IXAP105['src_uri'] ) || isset( $IXAP105['dest_uri'] ) ) { $IXAP34 .= '</div>'; } if ( isset( $IXAP105['referrals'] ) ) { $IXAP34 .= '<div class="filter-section">'; $IXAP34 .= '<label class="min-referrals-filter">'; $IXAP34 .= __( 'Referrals', 'affiliates' ); $IXAP34 .= ' '; $IXAP34 .= sprintf( '<input class="input-text min-referrals-filter" title="%s" name="min_referrals" type="number" value="%d" min="0"/>', esc_attr( __( 'Minimum number of referrals', 'affiliates' ) ), esc_attr( $IXAP338 ) ); $IXAP34 .= '</label>'; $IXAP34 .= '</div>'; } $IXAP34 .= sprintf( '<input type="hidden" name="row_count" value="%s" />', esc_attr( $IXAP247 ) ); $IXAP34 .= '<div class="filter-buttons">'; $IXAP34 .= '<input class="button apply-button" type="submit" name="apply_filters" value="' . __( 'Apply', 'affiliates' ) . '"/>'; $IXAP34 .= '<input class="button clear-button" type="submit" name="clear_filters" value="' . __( 'Clear', 'affiliates' ) . '"/>'; $IXAP34 .= '</div>'; $IXAP34 .= '</form>'; $IXAP34 .= '</div>'; } if ( $IXAP24['show_pagination'] ) { $IXAP34 .= '<div class="page-options">'; $IXAP34 .= '<form id="setrowcount" action="" method="get">'; $IXAP34 .= '<label class="row-count">'; $IXAP34 .= __( 'Results per page', 'affiliates' ); $IXAP34 .= ' '; $IXAP34 .= '<input name="row_count" type="text" size="2" value="' . esc_attr( $IXAP247 ) .'" />'; $IXAP34 .= ' '; $IXAP34 .= '<input class="button" type="submit" value="' . __( 'Apply', 'affiliates' ) . '"/>'; $IXAP34 .= '</label>'; $IXAP34 .= sprintf( '<input type="hidden" name="from_date" value="%s" />', esc_attr( $IXAP15 ) ); $IXAP34 .= sprintf( '<input type="hidden" name="thru_date" value="%s" />', esc_attr( $IXAP16 ) ); $IXAP34 .= sprintf( '<input type="hidden" name="src_uri" value="%s" />', esc_attr( stripslashes( $src_uri ) ) ); $IXAP34 .= sprintf( '<input type="hidden" name="dest_uri" value="%s" />', esc_attr( stripslashes( $IXAP337 ) ) ); $IXAP34 .= sprintf( '<input type="hidden" name="min_referrals" value="%s" />', esc_attr( $IXAP338 ) ); $IXAP34 .= '</form>'; $IXAP34 .= '</div>'; if ( $IXAP252 ) { require_once AFFILIATES_CORE_LIB . '/class-affiliates-pagination.php'; $IXAP253 = new Affiliates_Pagination( $IXAP251, null, $IXAP247, 'uris_paged' ); $IXAP34 .= '<form id="posts-filter" method="get" action="">'; $IXAP34 .= '<div>'; $IXAP34 .= sprintf( '<input type="hidden" name="from_date" value="%s" />', esc_attr( $IXAP15 ) ); $IXAP34 .= sprintf( '<input type="hidden" name="thru_date" value="%s" />', esc_attr( $IXAP16 ) ); $IXAP34 .= sprintf( '<input type="hidden" name="src_uri" value="%s" />', esc_attr( stripslashes( $src_uri ) ) ); $IXAP34 .= sprintf( '<input type="hidden" name="dest_uri" value="%s" />', esc_attr( stripslashes( $IXAP337 ) ) ); $IXAP34 .= sprintf( '<input type="hidden" name="min_referrals" value="%s" />', esc_attr( $IXAP338 ) ); $IXAP34 .= '</div>'; $IXAP34 .= '<div class="tablenav top">'; $IXAP34 .= $IXAP253->pagination( 'top' ); $IXAP34 .= '</div>'; $IXAP34 .= '</form>'; } } $server_dtz = DateHelper::getServerDateTimeZone(); $IXAP340['date'] = sprintf( __( "* Date is given for the server's time zone : %s, which has an offset of %s hours with respect to GMT.", 'affiliates' ), $server_dtz->getName(), $server_dtz->getOffset( new DateTime() ) / 3600.0 ); $IXAP340['referrals'] = __( 'The number of corresponding referrals or conversions.', 'affiliates' ); $IXAP340['visits'] = __( 'The number of unique visits.', 'affiliates' ); $IXAP340['hits'] = __( 'The number of hits or clicks.', 'affiliates' ); $IXAP340['src_uri'] = __( 'Where the traffic originated from.', 'affiliates' ); $IXAP340['dest_uri'] = __( 'Where the traffic lead to.', 'affiliates' ); $IXAP34 .= '<table class="wp-list-table widefat fixed" cellspacing="0">'; $IXAP34 .= '<thead>'; $IXAP34 .= '<tr>'; foreach ( $IXAP105 as $key => $IXAP106 ) { $IXAP341 = array( 'orderby' => $key, 'order' => $switch_order ); $IXAP107 = ''; $IXAP342 = ''; if ( strcmp( $key, $IXAP68 ) == 0 ) { $IXAP108 = strtolower( $IXAP69 ); $IXAP107 = "$key manage-column sorted $IXAP108"; switch( $IXAP108 ) { case 'asc' : $IXAP342 = ' &uarr;'; break; case 'desc' : $IXAP342 = ' &darr;'; break; } } else { $IXAP107 = "$key manage-column sortable"; } $IXAP106 = sprintf( '<a href="%s" title="%s"><span>%s%s</span><span class="sorting-indicator"></span></a>', esc_url( add_query_arg( $IXAP341, $IXAP59 ) ), !empty( $IXAP340[$key] ) ? esc_attr( $IXAP340[$key] ) : '', esc_html( $IXAP106 ), esc_html( $IXAP342 ) ); $IXAP34 .= "<th scope='col' class='$IXAP107'>$IXAP106</th>"; } $IXAP34 .= '</tr>'; $IXAP34 .= '</thead>'; $IXAP34 .= '<tbody>'; if ( count( $IXAP26 ) > 0 ) { for ( $i = 0; $i < count( $IXAP26 ); $i++ ) { $IXAP11 = $IXAP26[$i]; $IXAP34 .= '<tr class=" ' . ( $i % 2 == 0 ? 'even' : 'odd' ) . '">'; $IXAP34 .= isset( $IXAP105['date'] ) ? "<td class='date'>$IXAP11->date</td>" : ''; $IXAP34 .= isset( $IXAP105['visits'] ) ? "<td class='visits'>$IXAP11->visits</td>" : ''; $IXAP34 .= isset( $IXAP105['hits'] ) ? "<td class='hits'>$IXAP11->hits</td>" : ''; $IXAP34 .= isset( $IXAP105['referrals'] ) ? "<td class='referrals'>$IXAP11->referrals</td>" : ''; $src_uri_trunc = ''; $IXAP343 = ''; $src_uri = $IXAP11->src_uri; if ( $IXAP24['src_uri_maxlength'] && (strlen( $IXAP11->src_uri ) > $IXAP24['src_uri_maxlength'] ) ) { $src_uri = substr( $IXAP11->src_uri, 0, $IXAP24['src_uri_maxlength'] ) . '&hellip;'; $src_uri_trunc = 'truncated'; } $IXAP34 .= isset( $IXAP105['src_uri'] ) ? sprintf( "<td class='src-uri %s'><span title='%s'>%s</span></td>", esc_attr( $src_uri_trunc ), esc_attr( $IXAP11->src_uri ), esc_html( $src_uri ) ) : ''; $IXAP337 = $IXAP11->dest_uri; if ( $IXAP24['dest_uri_maxlength'] && (strlen( $IXAP11->dest_uri ) > $IXAP24['dest_uri_maxlength'] ) ) { $IXAP337 = substr( $IXAP11->dest_uri, 0, $IXAP24['dest_uri_maxlength'] ) . '&hellip;'; $IXAP343 = 'truncated'; } $IXAP34 .= isset( $IXAP105['dest_uri'] ) ? sprintf( "<td class='dest-uri %s'><span title='%s'>%s</span></td>", esc_attr( $IXAP343 ), esc_attr( $IXAP11->dest_uri ), esc_html( $IXAP337 ) ) : ''; $IXAP34 .= '</tr>'; } } else { $IXAP34 .= '<tr><td colspan="' . sizeof( $IXAP105 ) .'">' . __('There are no results.', 'affiliates' ) . '</td></tr>'; } $IXAP34 .= '</tbody>'; $IXAP34 .= '</table>'; if ( $IXAP24['show_pagination'] ) { if ( $IXAP252 ) { require_once AFFILIATES_CORE_LIB . '/class-affiliates-pagination.php'; $IXAP253 = new Affiliates_Pagination( $IXAP251, null, $IXAP247, 'uris_paged' ); $IXAP34 .= '<div class="tablenav bottom">'; $IXAP34 .= $IXAP253->pagination( 'bottom' ); $IXAP34 .= '</div>'; } } $IXAP34 .= '</div>'; return $IXAP34; } } Affiliates_Traffic_Renderer_WordPress::init(); 