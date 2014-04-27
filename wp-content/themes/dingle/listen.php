<?php
/*
 Template Name: Listen Template
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/

$args = array(
	'posts_per_page' => '2',
	'post_type' => 'tracks'
);
 
// get results
$song_query = new WP_Query( $args );
?>

<?php get_header(); ?>

<div id="page__content" role="main">

<div class="latest__tracks">
<?php if( $song_query->have_posts() ): $gigNumber = 1; ?>
	<h1><?php the_title(); ?></h1>
	<?php while ( $song_query->have_posts() ) : $song_query->the_post(); ?>

		<div class="track__item"><?php the_field( "soundcloud_embed_link" ); ?></div>

		<?php endwhile; ?>
<?php endif; ?>
</div>


<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>

<?php get_footer(); ?>