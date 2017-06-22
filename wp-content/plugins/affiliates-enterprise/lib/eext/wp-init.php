<?php
 global $affiliates_options, $affiliates_version, $affiliates_pro_version, $affiliates_enterprise_version, $affiliates_enterprise_admin_messages; if ( !isset( $affiliates_enterprise_admin_messages ) ) { $affiliates_enterprise_admin_messages = array(); } if ( !isset( $affiliates_enterprise_version ) ) { $affiliates_enterprise_version = AFFILIATES_EEXT_VERSION; } add_action( 'init', 'affiliates_enterprise_version_check' ); function affiliates_enterprise_version_check() { global $affiliates_enterprise_version, $affiliates_enterprise_admin_messages; $IXAP114 = get_option( 'affiliates_enterprise_plugin_version', null ); $affiliates_enterprise_version = AFFILIATES_EEXT_VERSION; if ( version_compare( $IXAP114, $affiliates_enterprise_version ) < 0 ) { if ( affiliates_enterprise_update( $IXAP114 ) ) { update_option( 'affiliates_enterprise_plugin_version', $affiliates_enterprise_version ); } else { $affiliates_enterprise_admin_messages[] = '<div class="error">Updating Affiliates E-Ext FAILED.</div>'; } } } function affiliates_enterprise_admin_notices() { global $affiliates_enterprise_admin_messages; if ( !empty( $affiliates_enterprise_admin_messages ) ) { foreach ( $affiliates_enterprise_admin_messages as $IXAP102 ) { echo $IXAP102; } } } add_action( 'admin_notices', 'affiliates_enterprise_admin_notices' ); function affiliates_enterprise_activate( $network_wide = false ) { if ( is_multisite() && $network_wide ) { $IXAP115 = affiliates_get_blogs(); foreach ( $IXAP115 as $IXAP116 ) { switch_to_blog( $IXAP116 ); wp_cache_reset(); affiliates_enterprise_setup(); restore_current_blog(); } } else { affiliates_pro_setup(); } } function affiliates_enterprise_setup() { global $affiliates_db, $wpdb; if ( affiliates_enterprise_check_dependencies() ) { $charset = null; $IXAP2 = null; if ( ! empty( $wpdb->charset ) ) { $charset = $wpdb->charset; } if ( ! empty( $wpdb->collate ) ) { $IXAP2 = $wpdb->collate; } $affiliates_db->create_tables( $charset, $IXAP2 ); affiliates_enterprise_update(); } } function affiliates_enterprise_wpmu_new_blog( $IXAP116, $user_id ) { if ( is_multisite() ) { if ( affiliates_is_sitewide_plugin() ) { switch_to_blog( $IXAP116 ); wp_cache_reset(); affiliates_enterprise_setup(); restore_current_blog(); } } } function affiliates_enterprise_delete_blog( $IXAP116, $IXAP117 = false ) { if ( is_multisite() ) { if ( affiliates_is_sitewide_plugin() ) { switch_to_blog( $IXAP116 ); wp_cache_reset(); affiliates_enterprise_cleanup( $IXAP117 ); restore_current_blog(); } } } register_activation_hook( AFFILIATES_ENTERPRISE_PLUGIN_FILE, 'affiliates_enterprise_activate' ); add_action( 'wpmu_new_blog', 'affiliates_enterprise_wpmu_new_blog', 12, 2 ); add_action( 'delete_blog', 'affiliates_enterprise_delete_blog', 10, 2 ); function affiliates_enterprise_update( $IXAP114 = null ) { global $affiliates_db, $wpdb; $IXAP11 = true; $IXAP118 = array(); if ( affiliates_enterprise_check_dependencies() ) { $charset = null; $IXAP2 = null; if ( ! empty( $wpdb->charset ) ) { $charset = $wpdb->charset; } if ( ! empty( $wpdb->collate ) ) { $IXAP2 = $wpdb->collate; } $IXAP4 = $affiliates_db->get_tablename( 'campaigns' ); if ( $affiliates_db->get_value( "SHOW TABLES LIKE '" . $IXAP4 . "'" ) != $IXAP4 ) { $IXAP3 = "CREATE TABLE " . $IXAP4 . " (
			campaign_id  BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			affiliate_id BIGINT(20) UNSIGNED NOT NULL,
			name         VARCHAR(100) DEFAULT NULL,
			description  LONGTEXT DEFAULT NULL,
			from_date    DATE DEFAULT NULL,
			thru_date    DATE DEFAULT NULL,
			type         VARCHAR(10) DEFAULT NULL,
			status       VARCHAR(10) DEFAULT NULL,
			PRIMARY KEY  (campaign_id),
			INDEX        aff_cmp_acn (affiliate_id,campaign_id,name),
			INDEX        aff_cmp_nam (name(20))
			) $charset_collate;"; $IXAP118[] = $IXAP3; } foreach ( $IXAP118 as $IXAP3 ) { if ( $affiliates_db->query( $IXAP3 ) === false ) { $IXAP11 = false; } } } return $IXAP11; } remove_action( 'deactivate_' . plugin_basename( AFFILIATES_PRO_FILE ), 'affiliates_pro_deactivate' ); register_deactivation_hook( AFFILIATES_ENTERPRISE_PLUGIN_FILE, 'affiliates_enterprise_deactivate' ); function affiliates_enterprise_deactivate( $network_wide = false ) { if ( is_multisite() && $network_wide ) { if ( get_option( 'aff_delete_network_data', false ) ) { $IXAP115 = affiliates_get_blogs(); foreach ( $IXAP115 as $IXAP116 ) { switch_to_blog( $IXAP116 ); wp_cache_reset(); affiliates_enterprise_cleanup( true ); restore_current_blog(); } } } else { affiliates_enterprise_cleanup(); } } function affiliates_enterprise_cleanup( $IXAP119 = false ) { global $affiliates_db; $IXAP120 = get_option( 'aff_delete_data', false ) || $IXAP119; if ( $IXAP120 ) { $affiliates_table = $affiliates_db->get_tablename( 'affiliates' ); if ( $affiliates = $affiliates_db->get_objects( "SELECT affiliate_id FROM $affiliates_table" ) ) { foreach( $affiliates as $affiliate ) { delete_option( Affiliates_Multi_Tier::IXAP79 . '_' . intval( $affiliate->affiliate_id ) ); } } $affiliates_db->drop_tables(); delete_option( 'affiliates_pro_plugin_version' ); delete_option( 'affiliates_enterprise_plugin_version' ); delete_option( Affiliates_Referral::IXAP121 ); delete_option( Affiliates_Referral::IXAP122 ); delete_option( 'affiliates_notifications' ); delete_option( Affiliates_Multi_Tier::IXAP77 ); delete_option( Affiliates_Multi_Tier::IXAP79 ); delete_option( Affiliates_Multi_Tier::IXAP80 ); delete_option( Affiliates_Multi_Tier::INCLUDE_DIRECT ); delete_option( Affiliates_Multi_Tier::N_TIERS ); delete_option( Affiliates_Multi_Tier::IXAP81 ); } affiliates_deactivate(); } add_action( 'init', 'affiliates_enterprise_init' ); function affiliates_enterprise_init() { global $affiliates_enterprise_admin_messages; load_plugin_textdomain( AFFILIATES_ENTERPRISE_PLUGIN_DOMAIN, null, AFFILIATES_PLUGIN_NAME . '/lib/eext/languages' ); affiliates_enterprise_check_dependencies(); } function affiliates_enterprise_check_dependencies() { global $affiliates_enterprise_admin_messages; $IXAP11 = true; $active_plugins = get_option( 'active_plugins', array() ); if ( is_multisite() ) { $IXAP123 = get_site_option( 'active_sitewide_plugins', array() ); $IXAP123 = array_keys( $IXAP123 ); $active_plugins = array_merge( $active_plugins, $IXAP123 ); } $affiliates_pro_is_active = in_array( 'affiliates-pro/affiliates-pro.php', $active_plugins ); if ( $affiliates_pro_is_active ) { $affiliates_enterprise_admin_messages[] = "<div class='error'>" . __( 'The <a href="http://www.itthinx.com/plugins/affiliates-pro" target="_blank">Affiliates Pro</a> plugin must be deactivated or removed.', AFFILIATES_ENTERPRISE_PLUGIN_DOMAIN ) . "</div>"; } if ( $affiliates_pro_is_active ) { include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); deactivate_plugins( AFFILIATES_PLUGIN_BASENAME ); $IXAP11 = false; } return $IXAP11; } require_once( dirname( AFFILIATES_ENTERPRISE_PLUGIN_FILE ) . '/lib/eext/interfaces.php' ); require_once( dirname( AFFILIATES_ENTERPRISE_PLUGIN_FILE ) . '/lib/eext/abstract/abstract.php' ); require_once( dirname( AFFILIATES_ENTERPRISE_PLUGIN_FILE ) . '/lib/eext/includes/includes.php' ); require_once( dirname( AFFILIATES_ENTERPRISE_PLUGIN_FILE ) . '/lib/eext/wordpress/wordpress.php' ); include_once( AFFILIATES_CORE_LIB . '/class-affiliates-utility.php' ); include_once( AFFILIATES_CORE_LIB . '/class-affiliates-pagination.php' ); include_once( AFFILIATES_CORE_LIB . '/class-affiliates-date-helper.php' ); add_action( 'widgets_init', 'affiliates_enterprise_widgets_init' ); function affiliates_enterprise_widgets_init() { } add_action( 'admin_init', 'affiliates_enterprise_admin_init' ); function affiliates_enterprise_admin_init() { global $affiliates_enterprise_version; wp_register_style( 'smoothness', AFFILIATES_CORE_URL . '/css/smoothness/jquery-ui-1.8.16.custom.css', array(), $affiliates_enterprise_version ); wp_register_style( 'affiliates_enterprise_admin', AFFILIATES_ENTERPRISE_PLUGIN_URL . 'css/affiliates_enterprise_admin.css', array(), $affiliates_enterprise_version ); } add_action( 'affiliates_admin_menu', 'affiliates_enterprise_affiliates_admin_menu' ); function affiliates_enterprise_affiliates_admin_menu( $IXAP75 ) { foreach ( $IXAP75 as $IXAP57 ) { add_action( 'admin_print_styles-' . $IXAP57, 'affiliates_enterprise_admin_print_styles' ); add_action( 'admin_print_scripts-' . $IXAP57, 'affiliates_enterprise_admin_print_scripts' ); } } function affiliates_enterprise_admin_print_styles() { wp_enqueue_style( 'smoothness' ); wp_enqueue_style( 'affiliates_enterprise_admin' ); } function affiliates_enterprise_admin_print_scripts() { global $affiliates_enterprise_version; } 