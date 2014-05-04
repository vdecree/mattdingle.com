<?php 
require_once('../../../wp-load.php');
$args = array(
        'post_type' => 'portfolio',
        'p' => $_GET['id']
    );
$portfolio_posts = new WP_Query( $args ); 
while($portfolio_posts->have_posts()) : 
    $portfolio_posts->the_post(); 
    $id = get_the_ID();
    if(get_post_meta($id, $key ='gallery_images', $single = true )) {
        $gallery_images = explode(",",get_post_meta($id, $key ='gallery_images', $single = true )); 
        
        foreach($gallery_images as $key=>$item) {
            if($item == '') {
                unset($gallery_images[$key]);
            }
        }
        
        $header_media = "<div id='carousel' class='carousel slide'>";

        if(count($gallery_images) > 1) {
            $header_media .= "<ol class='carousel-indicators'>";
            for($i=0;$i<count($gallery_images);$i++) {
                if($i==0) {
                    $active_class = "active";
                } else {
                    $active_class = "";
                }
                $header_media .= "<li data-target='#carousel' data-slide-to='".$i."' class='".$active_class."'></li>";
            }
            $header_media .= "</ol>";
        }
        $header_media .= "<div class='carousel-inner'>";
        $j=0;
        foreach($gallery_images as $item) {
            $image_src = wp_get_attachment_image_src($item, "blog-no-sidebar"); 
            $image_title = get_the_title($item); 
            if($j==0) {
                $active_class = " active";
            } else {
                $active_class = "";
            }
            $header_media .= "<div class='item$active_class'>";
            $header_media .= "<img alt='".$image_title."'  src='".$image_src[0]."'>";
            $header_media .= "</div>";
            $j++;
        }
        $header_media .= "</div>";
        if(count($gallery_images) > 1) {
            $header_media .= "<a class='left carousel-control' href='#carousel' data-slide='prev'>
                                <span class='glyphicon glyphicon-chevron-left'></span>
                              </a>
                              <a class='right carousel-control' href='#carousel' data-slide='next'>
                                <span class='glyphicon glyphicon-chevron-right'></span>
                              </a>";
        }
        $header_media .= "</div>";
    }
    elseif(has_post_thumbnail($id)) { 
        $header_media = get_the_post_thumbnail($id, anps_blog_image_size($id));
    }
    elseif(get_post_meta($id, $key ='anps_featured_video', $single = true )) { 
        $header_media = do_shortcode(get_post_meta($id, $key ='anps_featured_video', $single = true ));
    }
    else { 
        $header_media = "";
    }
?>
<h1><?php the_title(); ?></h1>
<?php echo $header_media; ?>
<div class='clearfix'>
    <div class="popover-left">
            <ul class="tags box">
                <?php
                      foreach(get_the_terms(get_the_ID(), 'portfolio_category') as $c) {
                        $first_item = true;
                        echo "<li>".$c->name."</li>";
                    } ?>
            </ul>
            <?php echo do_shortcode(get_post_meta( get_the_ID(), $key = 'anps_left_content', $single = true )); ?>
    </div>
    <div class="popover-right">
        <?php the_content(); ?>
    </div>
</div>
<?php endwhile;