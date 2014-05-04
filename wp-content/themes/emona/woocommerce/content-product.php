<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $shop_data;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

global $shop_data;

if( is_shop() || is_product_category() || is_product_tag() ) {
	global $num_of_sidebars;

	switch( $shop_data['shop_pagination'] ) {
		case '2 column': $woocommerce_loop['columns'] = 2; $classes[] = "col-sm-6"; break;
		case '3 column': $woocommerce_loop['columns'] = 3; $classes[] = "col-sm-4"; break;
		case '4 column': $woocommerce_loop['columns'] = 4; $classes[] = "col-sm-3"; break;
		case '5 column': $woocommerce_loop['columns'] = 5; $classes[] = "col-product-default"; break;
		default: $woocommerce_loop['columns'] = 4; $classes[] = "col-sm-3"; break;
	}
 
} else {
	$woocommerce_loop['columns'] = 5;
	$classes[] = "col-product-default";
}

if( isset($shop_data['product_style']) && $shop_data['product_style'] == 'Style 2' ) {
	$classes[] = "product-style-2";
}

?>
<li <?php post_class( $classes ); ?>>

	<?php
		global $shop_data;
		$long_price = false;

		if(isset($shop_data['shop-long-price']) && $shop_data['shop-long-price']=='on') {
			$long_price = true;
		}

		if( isset($shop_data['product_style']) && $shop_data['product_style'] == 'Style 2' ) {

		} else {

		}
	?>

	<div class="product-inner<?php if($long_price) { echo ' long-price'; } ?>">

		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

			<div class="product-url">
				
				<?php if( isset($shop_data['shop-second-img']) && $shop_data['shop-second-img'] == 'on' ): ?>
					<div class="second-product-img">
						<?php
							$gal_ids = $product->get_gallery_attachment_ids();
							$image = wp_get_attachment_image( $gal_ids[0], "shop_catalog" );
							echo $image;
						?>
					</div>
				<?php endif; ?>

				<?php
					/**
					 * woocommerce_before_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item_title' );
				?>

				<?php if( isset($shop_data['product_style']) && $shop_data['product_style'] == 'Style 2' ): ?>
					<a href="<?php the_permalink(); ?>" class="product-url-inner">
					</a>
				<?php else: ?>
					<div class="product-url-inner">
						<div>
							<?php echo strip_tags(do_shortcode('[add_to_cart id="' . get_the_ID() . '"]'), '<a><div><span><script>'); ?>
							<a href="<?php the_permalink(); ?>" class="glyphicon glyphicon-link"></a>
							<?php check_yith_woocommerce_compare(); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<h3><?php the_title(); ?></h3>

			<?php
				do_action( 'woocommerce_after_shop_loop_item_title' );
			?>

			<?php if( isset($shop_data['product_style']) && $shop_data['product_style'] == 'Style 2' ): ?>
				<?php check_yith_woocommerce_compare(); ?>
			<?php endif; ?>

		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

	</div>

</li>