<?php
class Affiliates_Affiliate_Profile_WordPress extends Affiliates_Affiliate_Profile { const NONCE = 'affiliate-profile-nonce'; const IXAP238 = 'edit-profile'; static function init() { add_shortcode( 'affiliates_affiliate_profile', array( __CLASS__, 'profile_shortcode' ) ); } static function profile_shortcode( $IXAP31, $IXAP32 = null ) { $IXAP11 = null; $IXAP24 = shortcode_atts( self::$IXAP124, $IXAP31 ); return self::render_profile( $IXAP24 ); } static function render_profile( $IXAP24 = array() ) { global $affiliates_options, $affiliates_db; wp_enqueue_style( 'affiliates' ); $IXAP34 = ''; $affiliate_id = Affiliates_Affiliate_WordPress::get_user_affiliate_id(); if ( $affiliate_id === false ) { return $IXAP34; } $affiliate = Affiliates_Affiliate_WordPress::get_affiliate( $affiliate_id ); $show_name = isset( $IXAP24['show_name'] ) ? $IXAP24['show_name'] : self::$IXAP124['show_name']; $IXAP239 = $show_name && isset( $IXAP24['edit_name'] ) ? $IXAP24['edit_name'] : self::$IXAP124['edit_name']; $show_email = isset( $IXAP24['show_email'] ) ? $IXAP24['show_email'] : self::$IXAP124['show_email']; $IXAP240 = $show_email && isset( $IXAP24['edit_email'] ) ? $IXAP24['edit_email'] : self::$IXAP124['edit_email']; $show_attributes = isset( $IXAP24['show_attributes'] ) ? $IXAP24['show_attributes'] : self::$IXAP124['show_attributes']; if ( $show_attributes ) { $show_attributes = explode( ",", $show_attributes ); $IXAP241 = array(); foreach ( $show_attributes as $IXAP242 ) { $IXAP242 = trim( $IXAP242 ); if ( Affiliates_Attributes::validate_key( $IXAP242 ) ) { $IXAP241[] = $IXAP242; } } $show_attributes = $IXAP241; } else { $show_attributes = array(); } $IXAP243 = isset( $IXAP24['edit_attributes'] ) ? $IXAP24['edit_attributes'] : self::$IXAP124['edit_attributes']; if ( $IXAP243 ) { $IXAP241 = explode( ",", $IXAP243 ); $IXAP243 = array(); foreach ( $IXAP241 as $IXAP242 ) { if ( in_array( $IXAP242, $show_attributes ) ) { $IXAP243[] = $IXAP242; } } } else { $IXAP243 = array(); } if ( isset( $_POST[self::NONCE] ) ) { if ( !wp_verify_nonce( $_POST[self::NONCE], self::IXAP238 ) ) { wp_die( __( 'Access denied.', AFFILIATES_PRO_PLUGIN_DOMAIN ) ); } if ( $IXAP239 && isset( $_POST['first_name'] ) && ( $_POST['last_name'] ) ) { $affiliate_name = $_POST['first_name'] . " " . $_POST['last_name']; if ( $affiliate->name != $affiliate_name ) { if ( $user_id = Affiliates_Affiliate_WordPress::get_affiliate_user_id( $affiliate_id ) ) { if ( $IXAP244 = Affiliates_Utility::filter( $_POST['first_name'] ) ) { update_user_meta( $user_id, 'first_name', $IXAP244 ); } if ( $IXAP245 = Affiliates_Utility::filter( $_POST['last_name'] ) ) { update_user_meta( $user_id, 'last_name', $IXAP245 ); } } Affiliates_Affiliate_WordPress::update_name( $affiliate_id, $affiliate_name ); } } if ( $IXAP240 && isset( $_POST['affiliate_email'] ) && ( $_POST['affiliate_email'] != $affiliate->email ) ) { if ( ( $new_email = Affiliates_Validator::validate_email( $_POST['affiliate_email'] ) ) && !email_exists( $new_email ) ) { if ( $new_email = Affiliates_Affiliate_WordPress::update_email( $affiliate_id, $new_email ) ) { if ( $user_id = Affiliates_Affiliate_WordPress::get_affiliate_user_id( $affiliate_id ) ) { $userdata = array( 'ID' => $user_id, 'user_email' => $new_email ); wp_update_user( $userdata ); } } } } foreach ( $IXAP243 as $IXAP242 ) { $field_name = "aff_attr_" . $IXAP242; if ( isset( $_POST[$field_name] ) ) { Affiliates_Affiliate_WordPress::update_attribute( $affiliate_id, $IXAP242, $_POST[$field_name] ); } } } $affiliate = Affiliates_Affiliate_WordPress::get_affiliate( $affiliate_id ); $IXAP34 .= '<div class="affiliate-profile">' . '<form id="affiliate-profile" action="" method="post">'; if ( $show_name ) { $IXAP246 = !$IXAP239 ? ' readonly="readonly" ' : ''; if ( $user_id = Affiliates_Affiliate_WordPress::get_affiliate_user_id( $affiliate_id ) ) { $IXAP244 = get_user_meta( $user_id, 'first_name', true ); $IXAP245 = get_user_meta( $user_id, 'last_name', true ); } else { $IXAP244 = ''; $IXAP245 = ''; } $IXAP34 .= '<div class="field first-name">' . '<label for="first_name">' . __( 'First Name', AFFILIATES_PRO_PLUGIN_DOMAIN ) . '</label>' . '<input ' . $IXAP246 . ' name="first_name" type="text" value="' . esc_attr( $IXAP244 ) . '"/>'. '</div>'; $IXAP34 .= '<div class="field last-name">' . '<label for="last_name">' . __( 'Last Name', AFFILIATES_PRO_PLUGIN_DOMAIN ) . '</label>' . '<input ' . $IXAP246 . ' name="last_name" type="text" value="' . esc_attr( $IXAP245 ) . '"/>'. '</div>'; } if ( $show_email ) { $IXAP246 = !$IXAP240 ? ' readonly="readonly" ' : ''; $IXAP34 .= '<div class="field affiliate-email">' . '<label for="affiliate_email">' . __( 'Email', AFFILIATES_PRO_PLUGIN_DOMAIN ) . '</label>' . '<input ' . $IXAP246 . ' name="affiliate_email" type="text" value="' . esc_attr( $affiliate->email ) . '"/>'. '</div>'; } if ( $show_attributes ) { $affiliates_attributes_table = $affiliates_db->get_tablename( 'affiliates_attributes' ); $affiliate_attributes = $affiliates_db->get_objects( "SELECT * FROM $affiliates_attributes_table WHERE affiliate_id = %d", $affiliate_id ); $IXAP224 = array(); foreach ( $affiliate_attributes as $IXAP242 ) { $IXAP224[$IXAP242->attr_key] = $IXAP242->attr_value; } $affiliates_attributes = Affiliates_Attributes::get_keys(); foreach ( $show_attributes as $IXAP201 ) { $IXAP204 = isset( $IXAP224[$IXAP201] ) ? $IXAP224[$IXAP201] : ''; $IXAP246 = !in_array( $IXAP201, $IXAP243 ) ? ' readonly="readonly" ' : ''; $field_name = "aff_attr_" . $IXAP201; $IXAP34 .= '<div class="field affiliate-attribute ' . esc_attr( $IXAP201 ) . '">' . '<label for="' . esc_attr( $field_name ) . '">' . __( $affiliates_attributes[$IXAP201], AFFILIATES_PRO_PLUGIN_DOMAIN ) . '</label>' . '<input ' . $IXAP246 . ' name="' . esc_attr( $field_name ) . '" type="text" value="' . esc_attr( $IXAP204 ) . '"/>'. '</div>'; } } if ( $IXAP239 || $IXAP240 || $IXAP243 ) { $IXAP34 .= '<div class="submit">' . wp_nonce_field( self::IXAP238, self::NONCE, true, false ) . '<input type="submit" value="' . __( 'Save', AFFILIATES_PRO_PLUGIN_DOMAIN ) . '"/>' . '<input type="hidden" value="submitted" name="submitted"/>' . '</div>'; } $IXAP34 .= '</form>'; $IXAP34 .= '</div>'; return $IXAP34; } } Affiliates_Affiliate_Profile_WordPress::init();