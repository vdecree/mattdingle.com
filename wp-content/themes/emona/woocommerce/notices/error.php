<?php
/**
 * Show error messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>
<ul class="woocommerce-error">
	<?php foreach ( $messages as $error ) : ?>
		<li class="alert alert-danger"><?php echo wp_kses_post( $error ); ?><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></li>
	<?php endforeach; ?>
</ul>