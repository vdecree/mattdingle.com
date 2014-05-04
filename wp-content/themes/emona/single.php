<?php get_header(); 
$meta = get_post_meta(get_the_ID());
$num_of_sidebars = 0;
$left_sidebar = 0;
if (isset($meta['sbg_selected_sidebar'])) {
    $left_sidebar = $meta['sbg_selected_sidebar'];
    if($left_sidebar[0] != "0") {
        $num_of_sidebars++;   
    }
}
$right_sidebar = 0;
if (isset($meta['sbg_selected_sidebar_replacement'])) {
    $right_sidebar = $meta['sbg_selected_sidebar_replacement'];
    if($right_sidebar[0] != "0") {
        $num_of_sidebars++;   
    }
}
?>
<?php
if(get_post_type() == "post") : ?>
<?php $value2 = get_option('anps_before_blog', '');
      if($value2 == '') {
        $value2 = '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>';
      }
      echo do_shortcode($value2);  
?>
<section class="blog-single">
    <div class="container">
        <?php if ($left_sidebar[0] != "0"): ?>
	            <aside class="sidebar col-md-<?php if($num_of_sidebars == 1) { echo "3"; } else if($num_of_sidebars == 2) { echo "3"; } ?>">
	            	<ul><?php dynamic_sidebar($left_sidebar[0]); ?></ul>
	            </aside>   
	<?php endif; ?>
        <div class="<?php if($num_of_sidebars == 1) { echo "col-md-9"; } else if($num_of_sidebars == 2) { echo "col-md-6"; } ?>">
<?php while(have_posts()) {
            the_post(); 
            get_template_part( 'content-single-blog', get_post_format() );
            wp_link_pages();
            comments_template();
    }    
endif; ?>
        </div>
        <?php if (isset($right_sidebar[0]) && $right_sidebar[0] != "0"): ?>
            <aside class="sidebar col-md-<?php if($num_of_sidebars == 1) { echo "3"; } else if($num_of_sidebars == 2) { echo "3"; } ?>">
            	<ul>
            		<?php dynamic_sidebar($right_sidebar[0]); ?>
            	</ul>	
            </aside>   
        <?php endif; ?>
      </div>
</section>
<?php get_footer(); ?>