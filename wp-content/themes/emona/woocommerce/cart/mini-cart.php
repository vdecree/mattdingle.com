<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<div class="cart-hover">

	<ul class="cart_list <?php echo $args['list_class']; ?>">

		<?php if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) : ?>

			<?php foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) :

				$_product = $cart_item['data'];

				// Only display if allowed
				if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 )
					continue;

				// Get price
				$product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();

				$product_price = apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $cart_item, $cart_item_key );
				?>

				<li>
					<a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>"><?php echo $cart_item['quantity'] . " / "?><?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?></a>
					<?php echo $product_price ; ?>
				</li>

			<?php endforeach; ?>

		<?php else : ?>

			<li class="empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></li>

		<?php endif; ?>

	</ul><!-- end product list -->

	<?php if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) : ?>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

		<p class="buttons">
			<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="btn btn-style-1 btn-md"><?php _e( 'View Cart', 'woocommerce' ); ?></a>
			<a href="<?php echo $woocommerce->cart->get_checkout_url(); ?>" class="btn btn-style-1 btn-md checkout"><?php _e( 'Checkout', 'woocommerce' ); ?></a>
		</p>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_mini_cart' ); ?>

</div>