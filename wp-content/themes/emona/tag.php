<?php get_header(); 
$value2 = get_option('anps_before_blog', ''); 
echo do_shortcode($value2);  

$new_query = new WP_Query();	 
if (is_tag()) {
    $new_query->query('paged=' . $paged . '&tag=' . get_query_var('tag') . '');
} else {
    $new_query->query('paged=' . $paged . '&post_type=post');
}
global $counter_blog;
$counter_blog = 1;
echo '<section class="blog-section"><div class="container">';
while ($new_query->have_posts()) :
    $new_query->the_post();
    get_template_part( 'content', get_post_format() );
    $counter_blog++;
endwhile;
echo "</div></section>";
get_footer(); ?>