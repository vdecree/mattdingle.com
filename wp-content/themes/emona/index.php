<?php get_header();
/* The loop */ 
$value2 = get_option('anps_before_blog', '');
if($value2 == '') {
$value2 = '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>';
} 
echo do_shortcode($value2 . "[blog]"); 
get_footer();