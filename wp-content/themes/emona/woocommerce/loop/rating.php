<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
	return;

global $shop_data;
?>

<div class="rating-wrapper">
	<?php if ( $rating_html = $product->get_rating_html() ) : ?>
		<?php echo $rating_html; ?>
	<?php elseif( $shop_data['shop-empty-stars'] == 'on' ): ?>
		<div class="star-rating" title="Rated 0.00 out of 5">
			<span style="width:0;"><strong class="rating">0.00</strong> out of 5</span>
		</div>
	<?php endif; ?>
</div>