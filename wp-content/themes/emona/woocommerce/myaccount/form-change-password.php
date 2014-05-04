<?php
/**
 * Change password form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>

<?php $woocommerce->show_messages(); ?>

<div class="row">

	<?php myaccount_sidebar("change_password"); ?>

	<div class="col-md-9 change-password">

		<h3 class="myaccount-heading"><?php _e("Change Password", "emona"); ?></h3>

		<form action="<?php echo esc_url( get_permalink(woocommerce_get_page_id('change_password')) ); ?>" method="post">

			<p class="form-row form-row-first">
				<input type="password" placeholder="<?php _e( 'New password', 'woocommerce' ); ?>*" class="input-text" name="password_1" id="password_1" />
			</p>
			<p class="form-row form-row-last">
				<input type="password" placeholder="<?php _e( 'Re-enter new password', 'woocommerce' ); ?>*" class="input-text" name="password_2" id="password_2" />
			</p>
			<div class="clear"></div>

			<p><span class="btn btn-sm"><input type="submit" name="change_password" value="<?php _e( 'Save', 'woocommerce' ); ?>" /></span></p>

			<?php $woocommerce->nonce_field('change_password')?>
			<input type="hidden" name="action" value="change_password" />

		</form>

	</div>
</div>