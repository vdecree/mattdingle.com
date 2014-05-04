<?php
get_header();
global $page_data; 
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
        while (have_posts()) : the_post();
            if ($left_sidebar[0] != "0" && $left_sidebar[0] != null): ?>
                    <aside class="sidebar col-md-<?php if($num_of_sidebars == 1) { echo "3"; } else if($num_of_sidebars == 2) { echo "3"; } ?> clearfix">
                        <ul>
                            <?php dynamic_sidebar($left_sidebar[0]); wp_reset_query(); ?>
                        </ul>
                    </aside>   
            <?php endif; ?>
            
               <?php the_content(); ?>
            <?php if (isset($right_sidebar[0]) && $right_sidebar[0] != "0"): ?>
                <aside class="sidebar col-md-<?php if($num_of_sidebars == 1) { echo "3"; } else if($num_of_sidebars == 2) { echo "3"; } ?> clearfix">
                    <ul>
                        <?php dynamic_sidebar($right_sidebar[0]); ?>
                    </ul>
                </aside>   
            <?php endif;
        endwhile; // end of the loop. 
    ?>
<?php get_footer(); ?>