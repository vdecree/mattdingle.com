<?php
/*
 Template Name: Home Template
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
 // args
$args = array(
	'posts_per_page' => '6',
	'post_type' => 'gig'
);

$format = "c";
$timestamp = get_field("gig_datetime");
 
// get results
$the_query = new WP_Query( $args );
?>

<?php get_header(); ?>

<?php get_template_part( 'banner', 'image' ); ?>

<div id="page__content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<?php the_content(); ?>			

<?php endwhile; ?>

<div id="gig__list">
	<h2 class="hdin--capped hdin--undln">Upcoming Gigs</h2>

<?php if( $the_query->have_posts() ): $gigNumber = 1; ?>
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<div class="gig__date-<?php echo $gigNumber++; ?>">
			<p class="gig__location"><?php the_field( "gig_location" ); ?></p>
			<time datetime="<?php echo date_i18n( "c" , get_field("gig_datetime") ); ?>"><?php echo date_i18n( "jS M, Y @ g:i a", get_field("gig_datetime") ); ?></time>
			<?php if( get_field('gig_fee') ): ?>
			<span class="btn btn--small btn--gold">Entry Fee &pound;<?php the_field( "gig_fee" ); ?></span>
			<?php endif; ?>
		</div>
	<?php endwhile; ?>
<?php endif; ?>

</div> <!-- end gig dates -->

<?php
$args = array(
	'posts_per_page' => '2',
	'post_type' => 'tracks'
);
 
// get results
$song_query = new WP_Query( $args );
?>
<div class="latest__tracks">
<?php if( $song_query->have_posts() ): $gigNumber = 1; ?>
	<h2 class="hdin--capped hdin--undln">Latest Tracks</h2>
	<?php while ( $song_query->have_posts() ) : $song_query->the_post(); ?>

		<div class="track__item"><?php the_field( "soundcloud_embed_link" ); ?></div>

		<?php endwhile; ?>
<?php endif; ?>
</div>

 
<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>

<?php get_footer(); ?>
