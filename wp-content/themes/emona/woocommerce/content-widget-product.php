<?php global $product; ?>
<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), "full"); ?>
<li>
	<a href="<?php the_permalink() ?>">
		<div style="background-image: url(<?php echo $src[0]; ?>);" class="image">
			<?php
				if ( has_post_thumbnail() )
					the_post_thumbnail( 'full' );
				else
					echo woocommerce_placeholder_img( 'full' );
			?>
		</div>
	</a>
	<h4><a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a></h4>
	<div class="widget-rating"><?php echo woocommerce_template_loop_rating(); ?></div>
	<div class="widget-price"><?php echo $product->get_price_html() ?></div>
</li>