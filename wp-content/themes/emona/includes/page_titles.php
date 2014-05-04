  
  	<?php if( is_home() && ! is_front_page() ): ?>
  		<div class="slider single-page" style="background: url(<?php if (get_the_post_thumbnail(get_option('page_for_posts'), 'full') != "")  { echo get_the_post_thumbnail_src(get_the_post_thumbnail(get_option('page_for_posts'), 'full')); } ?>) center no-repeat; background-color: <?php echo get_option('primary_color', '#005691'); ?>;">  	
	<?php elseif( is_archive() || is_search() ): ?>
  		<div class="slider single-page" style="background-color: <?php echo get_option('primary_color', '#005691'); ?>;">
  	<?php else: ?>
  		<div class="slider single-page" <?php if ( ! is_single() ): ?>style="background: url(<?php if (get_the_post_thumbnail(get_the_ID(), 'full') != "")  { echo get_the_post_thumbnail_src(get_the_post_thumbnail(get_the_ID(), 'full')); } ?>) center no-repeat; background-color: <?php echo get_option('primary_color', '#005691'); ?>;"<?php endif; ?>>
	<?php endif; ?>
      <div class="main-wrapper">

        <?php 

        if( single_tag_title( '', false) != "" ) :

            echo "Tag: " . single_tag_title( '', false);

        elseif ( get_search_query() != "" ):

            printf( __( 'Search Results for: %s', ANPS_TEMPLATE_LANG ), '' . get_search_query() . '' );

        elseif ( is_home() && ! is_front_page() ) :

            echo get_the_title(get_option('page_for_posts')) ;

        elseif( single_cat_title("",false) != "" ):

            echo single_cat_title("",false);
        elseif ( is_archive() ) :

                echo "Archives for " . get_the_date('F') . ' ' . get_the_date('Y');

        else: ?> 

        <?php


        	if ( get_the_title() == '' ) {
	    		global $wpdb;
		        $data = $wpdb->get_results("SELECT details FROM " . $wpdb->prefix . "envoo_pages WHERE type='error'");
		    	$page = get_page( $data[0]->details );
				if ( isset($page->post_title) )
	            	echo $page->post_title;
			} else {
				the_title();
			}
        ?>
  
        <?php endif;?>

      </div>

  </div>