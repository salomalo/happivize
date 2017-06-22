<?php
 if ( !defined( 'ABSPATH' ) ) { exit; } class Affiliates_Campaigns_WordPress { const NONCE = 'nonce-campaigns'; const IXAP74 = 'campaigns'; public static function init() { add_action( 'affiliates_admin_menu', array( __CLASS__, 'affiliates_admin_menu' ) ); } public static function affiliates_admin_menu() { $IXAP57 = add_submenu_page( 'affiliates-admin', __( 'Campaigns', AFFILIATES_PRO_PLUGIN_DOMAIN ), __( 'Campaigns', AFFILIATES_PRO_PLUGIN_DOMAIN ), AFFILIATES_ADMINISTER_OPTIONS, 'affiliates-admin-campaigns', array( __CLASS__, 'affiliates_admin_campaigns' ) ); $IXAP75[] = $IXAP57; add_action( 'admin_print_styles-' . $IXAP57, 'affiliates_admin_print_styles' ); add_action( 'admin_print_scripts-' . $IXAP57, 'affiliates_admin_print_scripts' ); add_action( 'admin_print_styles-' . $IXAP57, 'affiliates_pro_admin_print_styles' ); add_action( 'admin_print_scripts-' . $IXAP57, 'affiliates_pro_admin_print_scripts' ); } public static function admin_print_styles() { global $affiliates_enterprise_version; if ( !wp_style_is( 'chosen' ) ) { wp_enqueue_style( 'chosen', AFFILIATES_ENTERPRISE_PLUGIN_URL . 'css/chosen/chosen.min.css', array(), $affiliates_enterprise_version ); } } public static function admin_print_scripts() { global $affiliates_enterprise_version; if ( !wp_script_is( 'chosen' ) ) { wp_enqueue_script( 'chosen', AFFILIATES_ENTERPRISE_PLUGIN_URL . 'js/chosen/chosen.jquery.min.js', array( 'jquery' ), $affiliates_enterprise_version ); } } public static function affiliates_admin_campaigns() { if ( !current_user_can( AFFILIATES_ADMINISTER_OPTIONS ) ) { wp_die( __( 'Access denied.', AFFILIATES_ENTERPRISE_PLUGIN_DOMAIN ) ); } Affiliates_Campaign_Table::render(); affiliates_footer(); } } add_action( 'init', array( 'Affiliates_Campaigns_WordPress', 'init' ) ); 