<?php get_header(); ?>
	<?php if ( have_posts() ) : the_post(); ?>
		<div class="author-header">
			<?php echo do_shortcode('[featured_title]' . __( 'All posts by ' . get_the_author(), 'emona' ) . '[/featured_title]'); ?>

			<?php if ( get_the_author_meta( 'description' ) ) : ?>
				<?php echo do_shortcode('[vc_row has_content="true"][vc_column][vc_column_text]' . get_the_author_meta( 'description' ) . '[/vc_column_text][/vc_column][/vc_row]'); ?>
			<?php endif; ?>
		</div>
		<section class="blog-section"><div class="container">
			<?php 
				rewind_posts();
				global $counter_blog;
				$counter_blog = 1;
				while ( have_posts() ) : the_post();
					global $counter_blog;
					get_template_part( 'content', get_post_format() );
					$counter_blog++;
				endwhile;
			?>
		</div></section>
	<?php endif; ?>
<?php get_footer();
