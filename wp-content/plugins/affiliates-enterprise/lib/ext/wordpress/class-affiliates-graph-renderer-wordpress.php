<?php
 if ( !defined( 'ABSPATH' ) ) { exit; } class Affiliates_Graph_Renderer_WordPress extends Affiliates_Graph_Renderer { const NONCE = 'affiliate-nonce'; const NONCE_1 = 'affiliate-nonce-1'; const NONCE_2 = 'affiliate-nonce-2'; const NONCE_FILTERS = 'affiliate-nonce-filters'; static function init() { add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wp_enqueue_scripts' ) ); add_filter( 'the_posts', array( __CLASS__, 'the_posts' ) ); add_shortcode( 'affiliates_affiliate_graph', array( __CLASS__, 'graph' ) ); } public static function wp_enqueue_scripts() { global $affiliates_enqueue_jquery; if ( isset( $affiliates_enqueue_jquery ) ) { wp_enqueue_script( 'jquery' ); } } public static function the_posts( $posts ) { global $affiliates_enqueue_jquery; if ( !isset( $affiliates_enqueue_jquery ) ) { if ( !wp_script_is( 'jquery' ) ) { foreach( $posts as $post ) { $IXAP320 = strpos( $post->post_content, '[affiliates_affiliate_graph' ) !== false; if ( $IXAP320 ) { $affiliates_enqueue_jquery = true; break; } } } } return $posts; } static function graph( $IXAP31, $IXAP32 = null ) { wp_enqueue_style( 'affiliates-pro' ); wp_enqueue_script( 'excanvas' ); wp_enqueue_script( 'flot' ); wp_enqueue_script( 'flot-resize' ); $IXAP24 = shortcode_atts( self::$IXAP134, $IXAP31 ); return self::render_graph( $IXAP24 ); } } Affiliates_Graph_Renderer_WordPress::init(); 