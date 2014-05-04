<?php
/**
 * Edit address form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $current_user;

get_currentuserinfo();
?>

<?php wc_print_notices(); ?>

<div class="row">

	<?php
		myaccount_sidebar("address");
	?>

	<div class="col-md-9">

		<?php if (!$load_address) : ?>

			<?php woocommerce_get_template('myaccount/my-address.php'); ?>

		<?php else : ?>

			<form class="change-address" method="post">

				<h3 class="myaccount-heading"><?php if ($load_address=='billing') _e( 'Billing Address', 'woocommerce' ); else _e( 'Shipping Address', 'woocommerce' ); ?></h3>

				<?php foreach ( $address as $key => $field ) : ?>

					<?php woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] ); ?>

				<?php endforeach; ?>

				<p>
					<button type="submit" name="save_address" class="btn btn-md btn-style-1"><?php _e( 'Save Address', 'woocommerce' ); ?></button>
					<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
					<input type="hidden" name="action" value="edit_address" />
				</p>

			</form>

		<?php endif; ?>

	</div>

</div>