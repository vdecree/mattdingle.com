<div class="container">
<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce; ?>

<?php $woocommerce->show_messages(); ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>

<?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') : ?>

<?php endif; ?>

<div class="row" id="customer_login">

<?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') : ?>
	<div class="col-md-8 woo-login-form">
<?php else: ?>
	<div class="col-md-12 woo-login-form">
<?php endif; ?>
	<h2><?php _e( 'Registered customers', 'emona' ); ?></h2>
	<form method="post" class="login">
		<p class="form-row form-row-first">
			<input type="text" class="input-text" placeholder="<?php _e( 'Username or email', 'woocommerce' ); ?>*" name="username" id="username" />
		</p>
		<p class="form-row form-row-last">
			<input class="input-text" placeholder="<?php _e( 'Password', 'woocommerce' ); ?>" type="password" name="password" id="password" />
		</p>
		<div class="clear"></div>

		<p class="form-row">
			<?php $woocommerce->nonce_field('login', 'login') ?>
			<input class="btn btn-md btn-style-1" type="submit" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" />
			<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
		</p>
	</form>
<?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') : ?>

	</div>

	<div class="col-md-4 woo-register-form">
		<h2><?php _e("Not registered?", "emona"); ?></h2>
		<div>
			<p><?php _e("Creating an account  is quick and easy, and will allow you to move through our checkout quicker.", "emona"); ?></p>
			<a class="btn btn-md btn-style-1 open-register-form" data-toggle="modal" href="#register-popup"><?php _e("Register", "emona"); ?></a>
		</div>
	</div>

	<div class="modal fade" id="register-popup">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
                </div>
				<div class="modal-body">
					<form method="post" class="register">

						<?php if ( get_option( 'woocommerce_registration_email_for_username' ) == 'no' ) : ?>

							<p class="form-row form-row-first">
								<label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
								<input type="text" class="input-text" name="username" id="reg_username" value="<?php if (isset($_POST['username'])) echo esc_attr($_POST['username']); ?>" />
							</p>

							<p class="form-row form-row-last">

						<?php else : ?>

							<p class="form-row form-row-wide">

						<?php endif; ?>

							<label for="reg_email"><?php _e( 'Email', 'emona' ); ?> <span class="required">*</span></label>
							<input type="email" class="input-text" name="email" id="reg_email" value="<?php if (isset($_POST['email'])) echo esc_attr($_POST['email']); ?>" />
						</p>

						<div class="clear"></div>

						<p class="form-row form-row-first">
							<label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
							<input type="password" class="input-text" name="password" id="reg_password" value="<?php if (isset($_POST['password'])) echo esc_attr($_POST['password']); ?>" />
						</p>
						<p class="form-row form-row-last">
							<label for="reg_password2"><?php _e( 'Re-enter password', 'woocommerce' ); ?> <span class="required">*</span></label>
							<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if (isset($_POST['password2'])) echo esc_attr($_POST['password2']); ?>" />
						</p>
						<div class="clear"></div>

						<!-- Spam Trap -->
						<div style="left:-999em; position:absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

						<?php do_action( 'register_form' ); ?>

						<p class="form-row-submit">
							<?php $woocommerce->nonce_field('register', 'register') ?>
							
							<span class="btn btn-style-1 btn-md btn-span-wrap"><input type="submit" name="register" value="<?php _e( 'Register', 'woocommerce' ); ?>" /></span>
						</p>

					</form>
				</div>
			</div>
		</div>
	</div>

</div>
<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>
</div>