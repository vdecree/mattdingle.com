<?php
global $counter_blog;
/* get blog categories */ 
$post_categories = wp_get_post_categories(get_the_ID()); 
/* get the content */ 
if(get_option("rss_use_excerpt") == "0"){ 
    global $more;
    $more = 0;

    $content_text = get_the_content('');
} else {                     
    $content_text = get_the_excerpt(); 
}
$class_style='';
if($counter_blog%2==0) {
    $class_style = " style-2";
}
$class_post='';
if($counter_blog==1) {
    $class_post = " post-first";
}
$post_data = "<article class='post".$class_post.$class_style."'>";
$post_data .= "<header>";
$post_data .= anps_header_media(get_the_ID());
$post_data .= "<h1><a href='".get_permalink()."' title='".get_the_title()."'>".get_the_title()."</a></h1>";
$post_data .= "<div class='post-meta-wrapper'><div class='post-meta'>";
$post_data .= "<a class='author'>".get_avatar(get_the_author_meta('ID'), '88')."             
                  <span>".get_comments_number()."</span>
                </a>";
$post_data .= "<span class='author-name'>".__("by", ANPS_TEMPLATE_LANG)." ".get_the_author()."</span>";
$post_data .= "<span class='date'>".get_the_date("j / m / Y")."</span>";
$post_data .= "<span class='categories'>";
$first_item = false;
foreach($post_categories as $c) {
    $cat = get_category($c); 
    if($first_item) {
        $post_data .= " / ";
    }
    $first_item = true;
    $post_data .= "<a href='".get_category_link($c)."'>".$cat->name."</a>";
}
$post_data .= "</span>";
$post_data .= "</div></div>";
$post_data .= "</header>";
$post_data .= "<div class='post-content'>".$content_text."</div>"; 
$post_data .= "<footer><a href='".get_permalink()."' class='btn-style-1 post-btn'>".__("Read more", ANPS_TEMPLATE_LANG)."</a></footer>";
$post_data .= "</article>";
echo $post_data;