<?php

/**

 * Lost password form

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).

 * will need to copy the new files to your theme to maintain compatibility. We try to do this.

 * as little as possible, but it does happen. When this occurs the version of the template file will.

 * be bumped and the readme will list any important changes.

 *

 * @see 	    http://docs.woothemes.com/document/template-structure/

 * @author  WooThemes

 * @package WooCommerce/Templates

 * @version 2.3.0

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

}



?>



<?php wc_print_notices(); 

//do_shortcode('[wppb-recover-password]');

?>

<div class="forgot_password">
  <?php echo do_shortcode('[wppb-recover-password]'); ?>
</div>

