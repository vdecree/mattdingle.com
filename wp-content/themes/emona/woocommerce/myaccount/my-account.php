<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$woocommerce->show_messages(); ?>

<div class="row">

	<?php
		if( isset($_GET["subpage"] ) && $_GET["subpage"] == "address" ) {
			myaccount_sidebar("address");
		} else {
			myaccount_sidebar("myaccount");
		}
	?>

	<div class="col-md-9">

		<?php do_action( 'woocommerce_before_my_account' ); ?>

		<?php if( isset($_GET["subpage"] ) && $_GET["subpage"] == "address" ): ?>

			<?php woocommerce_get_template( 'myaccount/my-address.php' ); ?>

		<?php else: ?>

			<?php woocommerce_get_template( 'myaccount/my-downloads.php' ); ?>

			<?php woocommerce_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_my_account' ); ?>

	</div>

</div>