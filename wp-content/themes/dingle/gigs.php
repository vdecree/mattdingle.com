<?php
/*
 Template Name: Gigs Template
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
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$args = array(
	'posts_per_page' => '12',
	'post_type' => 'gig',
	'paged' => $paged
);

$format = "c";
$timestamp = get_field("gig_datetime");
 
// get results
$the_query = new WP_Query( $args );
?>

<?php get_header(); ?>

<div id="page__content" role="main">

<div class="container gig__container">
	<div id="gig__list__large">
	<?php if( $the_query->have_posts() ): $gigNumber = 1; ?>
	<h1><?php the_title(); ?></h1>
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

    $total_pages = $the_query->max_num_pages;  

    if ($total_pages > 1){  
      $current_page = max(1, get_query_var('paged'));  
      echo '<nav class="pagination">';
      echo paginate_links(array(  
          'base' => get_pagenum_link(1) . '%_%',  
          'format' => 'page%#%',  
          'current' => $current_page,  
          'total' => $total_pages,
          'prev_text'    => __('&larr; Previous'),
					'next_text'    => __('Next &rarr;'),
          'prev_next'    => true,
          'type' => 'list', 
        )); 
        echo '</nav>';
    }  
    ?>
<!--end pagination--> 

</div>

<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>

<?php get_footer(); ?>