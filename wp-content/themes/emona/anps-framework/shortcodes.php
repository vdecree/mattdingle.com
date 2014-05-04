<?php
load_template(TEMPLATEPATH . '/anps-framework/recaptchalib.php');
/* Blog shortcode */
function anps_blog_func($atts, $content) {
    extract( shortcode_atts( array(
		'category' => '',
		'orderby' => '',
		'order' => ''
	), $atts ) );
    global $wp_rewrite;
   
    get_query_var('paged') > 1 ? $current = get_query_var('paged') : $current = 1;
    $args = array(
	'posts_per_page'   => $content,
	'cat'              => $category,
	'orderby'          => $orderby,
	'order'            => $order,
	'post_type'        => 'post',
	'post_status'      => 'publish',
        'paged' => $current);
    
    $posts = new WP_Query( $args );
  
    $pagination = array(
	'base' => @add_query_arg('page','%#%'),
	'format' => '',
	'total' => $posts->max_num_pages,
	'current' => $current,
	'show_all' => false,
        'prev_text'    => '',
        'next_text'    => '',
	'type' => 'list',
	);

    $post_text = "";
    
    if($posts->have_posts()) :
        $post_text .= '<section class="blog-section"><div class="container">';
        global $counter_blog;
        $counter_blog = 1;
        while($posts->have_posts()) : 
            $posts->the_post(); 
            ob_start();
            get_template_part( 'content', get_post_format() );
            $counter_blog++;
            $post_text .= ob_get_clean();
        endwhile;   
        if( $wp_rewrite->using_permalinks() ) {
            $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
        }
        if( !empty($wp_query->query_vars['s']) ) {
            $pagination['add_args'] = array('s'=>get_query_var('s'));
        }
        $post_text .= '<div class="page-numbers-wrapper">'.paginate_links( $pagination ).'</div>';
        $post_text .= '</div></section>';
        wp_reset_postdata();
    else :
        $post_text .= "<h2>".__('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', ANPS_TEMPLATE_LANG)."</h2>";
    endif;
    return $post_text;
}
add_shortcode("blog", "anps_blog_func");
/* Portfolio shortcode */
function anps_portfolio_func($atts, $content) {
    extract( shortcode_atts( array(
		'filter' => 'on',
		'columns' => '4',
        'category'=> '',
        'orderby' => '',
		'order' => '',
        'heading' => ''
	), $atts ) );
    $tax_query='';

    if($category && $category!='All') {
        $tax_query = array(
                            array(
                                'taxonomy' => 'portfolio_category',
                                'field' => 'id',
                                'terms' => $category
                            )
                       );
    }
        
    $args = array(
        'post_type' => 'portfolio',
        'orderby' => $orderby,
        'order' => $order,
        'showposts' => -1,
        'tax_query' => $tax_query
    );
    
    $portfolio_posts = new WP_Query( $args ); 
    
    $portfolio_data = "<section id='portfolio'>";
    $portfolio_data .= "<p>&nbsp;</p>
                        <p>&nbsp;</p>";
    if($heading) {
        $portfolio_data .= "<h1 class='featured-heading'><span>".$heading."</span></h1>";
    }
    if($filter=="on") {
        $portfolio_data .= "<div class='filter'>
                            <ul>";
        $portfolio_data .= "<li><button class='selected' data-filter='*'>".__("All", ANPS_TEMPLATE_LANG)."</button></li>";
        $filters = get_terms('portfolio_category', 'orderby=none&hide_empty');
        foreach ($filters as $item) {
            $portfolio_data .= '<li><button class="" data-filter="' . strtolower(str_replace(" ", "-", $item->name)) . '">' . $item->name . '</button></li>';
        }
        $portfolio_data .= "</ul></div>";
    } 
    $portfolio_data .= "<ul class='isotope posts'>";

    while($portfolio_posts->have_posts()) : 
        $portfolio_posts->the_post();
        $portfolio_cat = ""; 
        if (get_the_terms(get_the_ID(), 'portfolio_category')) {
            $first_item = false;
            foreach (get_the_terms(get_the_ID(), 'portfolio_category') as $cat) {
                if($first_item) {
                    $portfolio_cat .= " ";
                }
                $first_item = true;
                $portfolio_cat .= strtolower(str_replace(" ", "-", $cat->name));
            }
        }
        if(has_post_thumbnail(get_the_ID())) {
                $image = get_the_post_thumbnail(get_the_ID(), 'recent-blog-portfolio');
        }
        elseif(get_post_meta(get_the_ID(), $key ='gallery_images', $single = true )) { 
            $exploded_images = explode(',',get_post_meta(get_the_ID(), $key ='gallery_images', $single = true ));
            $image_url = wp_get_attachment_image_src($exploded_images[0], 'recent-blog-portfolio'); 
            $image = "<img src='".$image_url[0]."' />";
        }
        $portfolio_data .= "<li class='".$portfolio_cat."'>";
        $portfolio_data .=  "<div class='image-wrapper'>".$image."</div>";
        $portfolio_data .= "<a href='".get_template_directory_uri()."/content-portfolio.php?ajax=true&amp;id=".get_the_ID()."' rel='prettyPhoto' data-rel-type='portfolio' class='post-meta'>";
        $portfolio_data .= "<div class='post-meta-wrap'>
                                <div class='post-meta-inner'>
                                    <h2>".get_the_title()."</h2>
                                    <span class='glyphicon glyphicon-camera'></span>
                                </div>
                            </div>
                            </a>";             
        $portfolio_data .= "</li>";
    endwhile;
    $portfolio_data .= "</ul>";
    $portfolio_data .= "</section>";
    return $portfolio_data;
}
add_shortcode("portfolio", "anps_portfolio_func");
/* Image */
function anps_image_func($atts, $content) {
    extract( shortcode_atts( array(
        'alt' => '',
    ), $atts ) );

    if (!empty($_SERVER['HTTPS'])) {
        $content = str_replace('http:', 'https:', $content);
    }

    return "<img alt='" . $alt . "' src='".$content."' />";
}
add_shortcode("image", "anps_image_func");
/* END Image */
/* Image */
function anps_latest_products_func($atts, $content) {

    $return = '<div class="products-scroll">';
    $return .= do_shortcode('[recent_products per_page="' . $content . '" columns="5" orderby="date" order="desc"]');
    $return .= '</div>';

    return $return;
}
add_shortcode("latest_products", "anps_latest_products_func");
/* END Image */
/* Shop banner */
function anps_shop_banner_func($atts, $content) {
    extract( shortcode_atts( array(
        'image' => '',
        'link' => '',
        'image_u' => ''
    ), $atts ) );
    
    if($image_u) {
        $image = wp_get_attachment_image_src($image_u, 'full');
        $image = $image[0];
    }

    $el = 'div';

    if($link) {
        $el = 'a';
        $link = ' href="' . $link . '"';
    } else {
        $link = '';
    }

    return '<' . $el . $link . ' class="shop-banner"><div style="background-image: url(' . $image . ');"></div><h2>' . $content . '</h2></' . $el . '>';
}
add_shortcode("shop_banner", "anps_shop_banner_func");
/* END Shop banner */
/* Box */
function anps_box_func($atts, $content) {
    return "<div class='box'>".$content."</div>";
}
add_shortcode("box", "anps_box_func");
/* END Box */
/* Team shortcode */
function anps_team_func($atts, $content) {
    extract( shortcode_atts( array(
                'heading' => 'Team'
	), $atts ) );

    $args = array(
        'post_type' => 'team',
        'showposts' => -1
    );   
    $team_posts = new WP_Query( $args ); 
    $team_data = "<section id='team'>";
    $team_data .= "<h1 class='featured-heading'><span>".$heading."</span></h1>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>";
    $team_data .= "<div class='section-style-2'>";
    $team_data .= "<div class='container'>";
    $team_data .= "<ul class='persons'>";
    while($team_posts->have_posts()) : 
        $team_posts->the_post();
        $subtitle = get_post_meta( get_the_ID(), $key = 'anps_team_subtitle', $single = true );
        $team_tags = "";       
        if (get_the_terms(get_the_ID(), 'team_tags')) {
            $first_item = false;
            foreach (get_the_terms(get_the_ID(), 'team_tags') as $tag) {
                if($first_item) {
                    $team_tags .= ", ";
                }
                $first_item = true;
                $team_tags .= strtolower(str_replace(" ", "-", $tag->name));
            }
        }
        $team_data .= "<li>";
        $team_data .= "<a href='".get_template_directory_uri()."/content-team.php?ajax=true&amp;id=".get_the_ID()."' rel='prettyPhoto' data-rel-type='team'>";
        $team_data .= "<div class='image-wrapper'>".get_the_post_thumbnail(get_the_ID(), 'team')."</div>";
        $team_data .= "<div class='post-meta'>
                        <div class='post-meta-wrap'>
                            <div class='post-meta-inner'>
                                <h2>".$subtitle."</h2>
                                <small>".$team_tags."</small>
                                <span class='open'>?</span>
                            </div>
                        </div>
                        </div></a>";
        $team_data .= "<h2>".get_the_title()."</h2>";
        $team_data .= "</li>";
    endwhile;
    $team_data .= "</ul></div></div>";
    $team_data .= "</section>";
    return $team_data;        
}
add_shortcode("team", "anps_team_func");
/* Recent blog posts */
function anps_recent_blog_func($atts, $content) {
    extract( shortcode_atts( array(
		'number' => '4',
                'slug' => ''
	), $atts ) );
     $args = array(
	'posts_per_page'   => $number,
	'orderby'          => "date",
	'order'            => "DESC",
	'post_type'        => 'post',
	'post_status'      => 'publish');
     $posts = new WP_Query( $args );
     $section_id='';
     if($slug) {
         $section_id = "id='".$slug."'";
     }
     $image = "";
     $recent_post_text ="";
     if($posts->have_posts()) :
        $recent_post_text .= '<section '.$section_id.'>
                        <p>&nbsp;</p>
                        <ul class="posts">';
        while($posts->have_posts()) : 
            $posts->the_post(); 
            if(has_post_thumbnail(get_the_ID())) {
                $glyph_icon = 'pencil';
                $image = get_the_post_thumbnail(get_the_ID(), 'recent-blog-portfolio');
            }
            elseif(get_post_meta(get_the_ID(), $key ='anps_featured_video', $single = true )) { 
                $glyph_icon = 'film';
                if(strpos(get_post_meta(get_the_ID(), $key ='anps_featured_video', $single = true ), 'vimeo')) {
                    $vimeo = str_replace(array("[vimeo]", "[/vimeo]"),"",get_post_meta(get_the_ID(), $key ='anps_featured_video', $single = true ));
                    $vimeo_img = unserialize(file_get_contents("https://vimeo.com/api/v2/video/$vimeo.php"));
                    $image = "<img src='".$vimeo_img[0]['thumbnail_large']."' alt='".get_the_title()."' />";
                } elseif(strpos(get_post_meta(get_the_ID(), $key ='anps_featured_video', $single = true ), 'youtube')) { var_dump("adssad");
                    $youtube = str_replace(array("[youtube]", "[/youtube]"),"",get_post_meta(get_the_ID(), $key ='anps_featured_video', $single = true ));
                    $youtube_url = "https://img.youtube.com/vi/$youtube/0.jpg";
                    $image = "<img src='".$youtube_url."' alt='".get_the_title()."' />";
                }
            }
            elseif(get_post_meta(get_the_ID(), $key ='gallery_images', $single = true )) { 
                $glyph_icon = 'camera';
                $exploded_images = explode(',',get_post_meta(get_the_ID(), $key ='gallery_images', $single = true ));
                $image_url = wp_get_attachment_image_src($exploded_images[0], 'recent-blog-portfolio'); 
                $image = "<img src='".$image_url[0]."' alt='".get_the_title()."' />";
            } else {
                $glyph_icon = 'pencil'; 
            }

            $return_content = get_the_content();
            $start = strpos(get_the_content(), '[vc_column_text]')+16;
            $end = strpos(get_the_content(), '[/vc_column_text]');
            if( $start > -1 ) {
                $return_content = substr(get_the_content(), $start, $end-$start);
            }

            $recent_post_text .= "<li>
                                    <div class='image-wrapper'>".$image."</div>";
            $recent_post_text .= "<div class='author'>".get_avatar(get_the_author_meta('ID'), '88')."<span>".get_comments_number()."</span></div>";
            $recent_post_text .= "<a href='".get_permalink()."' class='post-meta'>
                                    <div class='post-meta-wrap'>
                                        <div class='post-meta-inner'>
                                        <div class='author'>".get_avatar(get_the_author_meta('ID'), '88')."<span>".get_comments_number()."</span></div>";
            $recent_post_text .= "<h2>".get_the_title()."</h2>
                                  <span class='glyphicon glyphicon-".$glyph_icon."'></span>
                                  </div></div></a>";
            $recent_post_text .= "</li>";
        endwhile;
        $recent_post_text .= "</ul></section>";
     endif;
     return $recent_post_text;
}
add_shortcode("recent_blog", "anps_recent_blog_func");
/* Subsection */
function anps_subsection_func($atts, $content) {
    $args = array(
        'post_type' => 'page',
        'p' => $content
        );
    $posts = new WP_Query( $args );
    if($posts->have_posts()) :
        while($posts->have_posts()) : 
            $posts->the_post(); 
            return "<section id='".basename(get_permalink())."'>".do_shortcode(get_the_content())."</section>";
        endwhile;    
    endif;  
}
add_shortcode("subsection", "anps_subsection_func");
/* Progress */
function anps_progress_func($atts, $content) {
    extract( shortcode_atts( array(
		'procent' => '0'
        ), $atts ) );

    global $is_in_person;
    $size = 121;

    if($is_in_person) {
        $size = 78;
    }

    $progress_data = "<div class='radial-progress-bar'>";
    $progress_data .= "<canvas data-rpb-val='".$procent."' width='" . $size . "' height='" . $size . "'><div></div></canvas>";
    $progress_data .= "<div class='rdb-meta'><span>0%</span></div>";
    $progress_data .= "<h2>".$content."</h2>";
    $progress_data .= "</div>";
    return $progress_data;
}
add_shortcode("progress", "anps_progress_func");
/*************************************
****** Column layout shortcodes ******
**************************************/
function content_half_func( $atts,  $content ) {
	extract( shortcode_atts( array(
		'id' => '',
        'class' => ''
	), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    if ( '</p>' == substr( $content, 0, 4 )
    and '<p>' == substr( $content, strlen( $content ) - 3 ) )
    $content = substr( $content, 4, strlen( $content ) - 7 );
    
    if ( $id == "first" ) {
        return '<div class="row">
                <div class="col-md-6 ' . $class . '">' . $content . '</div>';
    }
    elseif ( $id == "last" ) {
        return '<div class="col-md-6 ' . $class . '">' . $content . '</div>
                </div>';
    }
    else {
        return '<div class="col-md-6 ' . $class . '">' . $content . '</div>';
    }
}
add_shortcode( 'content_half', 'content_half_func' );
function content_third_func( $atts,  $content ) {
	extract( shortcode_atts( array(
		'id' => '',
        'class' => ''
	), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    if ( '</p>' == substr( $content, 0, 4 )
    and '<p>' == substr( $content, strlen( $content ) - 3 ) )
    $content = substr( $content, 4, strlen( $content ) - 7 );
    if ( $id == "first" ) {
        return '<div class="row">
                <div class="col-sm-4 ' . $class . '">' . $content . '</div>';
    }
    elseif ( $id == "last" ) {
        return '<div class="col-sm-4 ' . $class . '">' . $content . '</div>
                </div>';
    }
    else {
        return '<div class="col-sm-4 ' . $class . '">' . $content . '</div>';
    }
}
add_shortcode( 'content_third', 'content_third_func' );
function content_two_third_func( $atts,  $content ) {
	extract( shortcode_atts( array(
		'id' => '',
        'class' => ''
	), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    if ( '</p>' == substr( $content, 0, 4 )
    and '<p>' == substr( $content, strlen( $content ) - 3 ) )
    $content = substr( $content, 4, strlen( $content ) - 7 );
    if ( $id == "first" ) {
        return '<div class="row">
                <div class="col-sm-8 ' . $class . '">' . $content . '</div>';
    }
    elseif ( $id == "last" ) {
        return '<div class="col-sm-8 ' . $class . '">' . $content . '</div>
                </div>';
    }
    else {
        return '<div class="col-sm-8 ' . $class . '">' . $content . '</div>';
    }
}
add_shortcode( 'content_two_third', 'content_two_third_func' );
function content_quarter_func( $atts,  $content ) {
	extract( shortcode_atts( array(
		'id' => '',
        'class' => ''
	), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    if ( '</p>' == substr( $content, 0, 4 )
    and '<p>' == substr( $content, strlen( $content ) - 3 ) )
    $content = substr( $content, 4, strlen( $content ) - 7 );
    if ( $id == "first" ) {
        return '<div class="row">
                <div class="col-md-3 ' . $class . '">' . $content . '</div>';
    }
    elseif ( $id == "last" ) {
        return '<div class="col-md-3 ' . $class . '">' . $content . '</div>
                </div>';
    }
    else {
        return '<div class="col-md-3 ' . $class . '">' . $content . '</div>';
    }
}
add_shortcode( 'content_quarter', 'content_quarter_func' );
function content_two_quarter_func( $atts,  $content ) {
	extract( shortcode_atts( array(
		'id' => '',
        'class' => ''
	), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    if ( '</p>' == substr( $content, 0, 4 )
    and '<p>' == substr( $content, strlen( $content ) - 3 ) )
    $content = substr( $content, 4, strlen( $content ) - 7 );
    if ( $id == "first" ) {
        return '<div class="row">
                <div class="col-md-6 ' . $class . '">' . $content . '</div>';
    }
    elseif ( $id == "last" ) {
        return '<div class="col-md-6 ' . $class . '">' . $content . '</div>
                </div>';
    }
    else {
        return '<div class="col-md-6 ' . $class . '">' . $content . '</div>';
    }
}
add_shortcode( 'content_two_quarter', 'content_two_quarter_func' );
function content_three_quarter_func( $atts,  $content ) {
	extract( shortcode_atts( array(
		'id' => '',
        'class' => ''
	), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    if ( '</p>' == substr( $content, 0, 4 )
    and '<p>' == substr( $content, strlen( $content ) - 3 ) )
    $content = substr( $content, 4, strlen( $content ) - 7 );
    if ( $id == "first" ) {
        return '<div class="row">
                <div class="col-md-9 ' . $class . '">' . $content . '</div>';
    }
    elseif ( $id == "last" ) {
        return '<div class="col-md-9 ' . $class . '">' . $content . '</div>
                </div>';
    }
    else {
        return '<div class="col-md-9 ' . $class . '">' . $content . '</div>';
    }
}
add_shortcode( 'content_three_quarter', 'content_three_quarter_func' );
/*************************************
**** END Column layout shortcodes ****
**************************************/
/* Icon shortcode */
function icon_func( $atts,  $content ) {
	extract( shortcode_atts( array(
            'link' => '',
            'target' => '_self',
            'icon' => '',
            'title' => '',
            'position' => ''
        ), $atts ) );
    
    if($link) {
        return '<a href="'.$link.'" class="icon '.$position.'" target="'.$target.'">
                    <span class="glyphicon glyphicon-'.$icon.'"></span>
                    <h2>'.$title.'</h2>
                    <p>'.$content.'</p>    
                </a>';          
    } else {
        return '<span class="icon '.$position.'" target="'.$target.'">
                    <span class="glyphicon glyphicon-'.$icon.'"></span>
                    <h2>'.$title.'</h2>
                    <p>'.$content.'</p>    
                </span>';          
    }
  	
}
add_shortcode( 'icon', 'icon_func' );
/* Quote */
function quote_func( $atts,  $content ) {
    extract( shortcode_atts( array( ), $atts ) );
    return '<blockquote>' . $content . '</blockquote>';
}
add_shortcode( 'quote', 'quote_func' );
/* Glyph shortcode */
function glyph_func( $atts,  $content ) {
    return "<span class='glyphicon glyphicon-".$content."'></span>";
}
add_shortcode('glyph', 'glyph_func');
/* Featured title shortcode */
function featured_title_func( $atts,  $content ) {
    extract( shortcode_atts( array( 'slug' => ''), $atts ) );
    $id_section='';
    if($slug) {
        $id_section = "id=$slug";
    }
    return "<h1 $id_section class='featured-heading'><span>".do_shortcode($content)."</span></h1>";
}
add_shortcode('featured_title', 'featured_title_func');
/* Featured title shortcode */
function title_func( $atts,  $content ) {
    extract( shortcode_atts( array( 'size' => ''), $atts ) );
    $id_section = "";
    if(!$size) {
        $size = '1';
    }
    return "<h$size $id_section><span>".do_shortcode($content)."</span></h$size>";
}
add_shortcode('title', 'title_func');
/* Color */
function color_func( $atts,  $content ) {
    extract( shortcode_atts( array( 'style' => '', 'custom' => '' ), $atts ) );
    $custom = ' style="color: ' . $custom . '"';
    if( $style && $style != "" ) {
        return '<span' . $custom . ' class="color ' . $style . '">' . do_shortcode($content) . '</span>';
    } else {
        return '<span' . $custom . ' class="color">' . do_shortcode($content) . '</span>';
    }
}
add_shortcode( 'color', 'color_func' );
/* Google maps */
$google_maps_counter = 0;
function google_maps_func( $atts,  $content ) {
    global $google_maps_counter;
    $google_maps_counter++;
    extract( shortcode_atts( array(
                'zoom'   => '15'
    ), $atts ) ); 
    return "<script>
            jQuery(document).ready(function( $ ) { 
                $('#map$google_maps_counter').gmap3({
                map:{
                  options:{
                    zoom: {$zoom},
                    scrollwheel: false,
                  }
                },
                getlatlng:{
                  address:  '" . $content .  "',
                  callback: function(results) {
                    if ( !results ) return;
                    $(this).gmap3('get').setCenter(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
                    $(this).gmap3({
                      marker:{
                        latLng:results[0].geometry.location
                      }
                    })
                  }
                }
              });   
            });
            </script>
            <div class='map' id='map$google_maps_counter'></div>";
}
add_shortcode('google_maps', 'google_maps_func');
/* Vimeo */
function vimeo_func( $atts,  $content ) {
    return '<div class="video-wrapper"><iframe src="https://player.vimeo.com/video/' . $content . '" width="320" height="240" style="border: none !important"></iframe></div>';
}
add_shortcode( 'vimeo', 'vimeo_func' );
/* Youtube */
function youtube_func( $atts,  $content ) {
    return '<div class="video-wrapper"><iframe src="https://www.youtube.com/embed/' . $content . '?wmode=transparent" width="560" height="315" style="border: none !important"></iframe></div>';
}
add_shortcode( 'youtube', 'youtube_func' );
/* Button */
global $button_counter; 
$button_counter = 0;
function button_func( $atts,  $content ) { 
    extract( shortcode_atts( array(
        'link'       => '#',
        'target'     => '_self',
        'size'       => 'small',
        'style'      => '',
        'color'      => '',
        'background' => '',
        'color_hover' => '',
        'background_hover' => ''
    ), $atts ) );
    global $button_counter;
    
    $style_attr = "";
    if($color) {
        $style_attr .= "color: " . $color . " !important;";
    }
    if($background) {
        $style_attr .= "background: " . $background . ";";
        $style_attr .= "border-color: " . $background . ";";
    }
    if ( $target != '' ) {
        $target = ' target="' . $target . '"';
    }
    
    switch($size) {
        case "large": $size = "btn-lg"; break;
        case "medium": $size = ""; break;
        case "small": $size = "btn-sm"; break;
    }
    switch($style) {
        case "style1": $style = "style-1"; break;
        case "style2": $style = "style-2"; break;
        default: $style = "style-1"; break;
    }
    $style_id = "custom-id-".$button_counter; 
    $button_counter++;
    $style_css='';
    if( !$link ) {
        $style_css .= '<button' . $target . ' class="' . $size . ' btn-' . $style . '" id="'.$style_id.'">' . $content . '</button>';
    } else {
        $style_css .= '<a' . $target . ' href="' . $link . '" class="' . $size . ' btn-' . $style . '" id="'.$style_id.'">' . $content . '</a>';
    }   
    return $style_css;
}
add_shortcode( 'button', 'button_func' );
/* Error 404 */
function error_404_func( $atts,  $content ) {
	extract( shortcode_atts( array(
        'title' => ''
    ), $atts ) );
		
	return '<div class="error-page">
                <h1>' . $title . '</h1>
                <h2>' .$content. '</h2>              
            </div>';
}
add_shortcode( 'error_404', 'error_404_func' );
/* Load VC shortcodes support */
if ( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    load_template(TEMPLATEPATH . '/anps-framework/vc_shortcodes_map.php');
} else {
function remove_wpautop($content, $autop = false) {

  if($autop) { // Possible to use !preg_match('('.WPBMap::getTagsRegexp().')', $content)
      $content = wpautop(preg_replace('/<\/?p\>/', "\n", $content)."\n");
  }
  return do_shortcode( shortcode_unautop($content) );
}
/* VC Row */
function vc_theme_rows($atts, $content) {
    $style = '';
    $extra_class = '';
    $extra_id = '';
    global $not_content;
    if(isset($atts['bg_color'])) {
        $style .= 'background-color: '. $atts['bg_color'] . ';';
    }
    if(isset($atts['font_color'])) {
        $style .= 'color: '. $atts['font_color'] . ';';
    }
    if(isset($atts['padding'])) {
        $style .= 'padding: '. $atts['padding'] . ';';
    }
    if(isset($atts['margin_bottom'])) {
        $style .= 'margin-bottom: '. $atts['margin_bottom'] . ';';
    }
    if(isset($atts['bg_image'])) {
        $image_attributes = wp_get_attachment_image_src( $atts['bg_image'], 'full' );
        $style .= 'background-image: url(' . $image_attributes[0] . ');';
    }
    if(isset($atts['el_class'])) {
        $extra_class = ' '. $atts['el_class'];
    }
    if(isset($atts['id'])) {
        $extra_id = 'id= "'. $atts['id'].'"';
    }
    if($style!='') {
        $style = ' style="' . $style . '"';
    }
    if(isset($atts['has_content'])&&$atts['has_content']=="true") {
        $div_value = '<div class="container"><div class="row row-md">'.remove_wpautop($content).'</div></div>';
    } else {
        $not_content = true;
        return '<div '.$extra_id.' class="clearfix' . $extra_class . '"' . $style . '>'.remove_wpautop($content).'</div>';
    }
    return '<section '.$extra_id.' class="' . $extra_class . '"' . $style . '>'.$div_value.'</section>';
}
function vc_theme_vc_row($atts, $content = null) {
    return vc_theme_rows($atts, $content);
}
function vc_theme_vc_row_inner($atts, $content = null) {
    return vc_theme_rows($atts, $content);
}
add_shortcode('vc_row', 'vc_theme_rows');
add_shortcode('vc_row_inner', 'vc_theme_rows');
/* VC Columns */
function vc_theme_columns($atts, $content = null) {
    if(!isset($atts['width'])) {
        $atts['width'] = '12/12';
    }
    $width = explode('/', $atts['width']);
    $col = (12/$width[1])*$width[0];
    $extra_class = '';
    global $not_content, $is_in_person;
    if(isset($atts['el_class'])) {
        $extra_class = ' ' . $atts['el_class'];
    }
    if($not_content&&!$is_in_person) {
        $not_content = false;
        return remove_wpautop($content); 
    } else {
        return '<div class="col-md-' . $col . $extra_class . '">'.remove_wpautop($content).'</div>';
    }
}
add_shortcode('vc_column', 'vc_theme_columns');
add_shortcode('vc_column_inner', 'vc_theme_columns');
/* VC Column Text */
function vc_column_text_func($atts, $content = null) {
    return do_shortcode(force_balance_tags($content));
}
add_shortcode('vc_column_text', 'vc_column_text_func');
/* VC Tabs */
function vc_tabs_func ($atts, $content = null) { 
    $content2 = str_replace("vc_tab", "tab", $content);
    return do_shortcode("[tabs]".$content2."[/tabs]");
}
add_shortcode('vc_tabs', 'vc_tabs_func');
/* Header quote */
function header_quote_func( $atts,  $content ) {
    extract( shortcode_atts( array( 
        'parallax' => 'false',
        'parallax_overlay' => 'false',
        'image' => '',
        'image_u' => '',
        'color' => '',
        'slug' => ''
    ), $atts ) );
    
    if($image_u) {
        $image = wp_get_attachment_image_src($image_u, 'full');
        $image = $image[0];
    }

    global $anps_parallax_slug;
    $parallax_class = "";
    if($parallax=="true") {
        $parallax_class = " parallax";
        $anps_parallax_slug[] = $slug;
        $parallax_id = "id='$slug'";
    } 
    
    $parallax_overlay_class = "";
    if($parallax_overlay=="true") {
        $parallax_overlay_class = " parallax-overlay";
    } 
        
    $style = '';
    if($image) {
        $style = "background-image: url('$image');";
    } elseif($color) {
        $style = "background-color: $color;";
    }
    
    $header_data = '<div '.$parallax_id.' class="header-quote'.$parallax_class.$parallax_overlay_class.'" style="'.$style.'">';
    $header_data .=  "<h1>".$content."</h1>";
    $header_data .= "</div>";
    return $header_data;
}
add_shortcode('header_quote', 'header_quote_func');
/* END header quote */    
/* Twitter */
global $anps_parallax_slug;
$anps_parallax_slug = array();
function anps_twitter_func($atts, $content) {
    extract( shortcode_atts( array(
		'title' => 'Stay tuned, follow us on Twitter',
                'parallax' => 'false',
                'parallax_overlay' => '',
                'image' => '',
                'color' => '',
                'slug' => '',
                'image_u' => ''
	), $atts ) );

    if($image_u) {
        $image = wp_get_attachment_image_src($image_u, 'full');
        $image = $image[0];
    }

    if (!empty($_SERVER['HTTPS'])) {
        $image = str_replace('http:', 'https:', $image);
    }

    global $anps_parallax_slug; 
    $parallax_class = "";
    if($parallax=="true") {
        $parallax_class = " parallax";
        $parallax_id = "id='$slug'";
        $anps_parallax_slug[] = $slug;
    } 
    
    $parallax_overlay_class = "";
    if($parallax_overlay=="true") {
        $parallax_overlay_class = " parallax-overlay";
    } 
    
    $style = '';
    if($image) {
        $style = "background-image: url('$image');";
    } elseif($color) {
        $style = "background-color: $color;";
    }
    
    load_template(TEMPLATEPATH.'/includes/TwitterAPIExchange.php');
    $settings = array(
        'oauth_access_token' => "1485322933-oo8YU1ZTz5E4Zt92hTTbCdJoZxIJIabghjnsPkX",
        'oauth_access_token_secret' => "RfXHN2OXMkBYp3IaEqrBmPhUYR2N61P8pyHf8QXqM",
        'consumer_key' => "Zr397FLlTFM4RVBsoLVgA",
        'consumer_secret' => "3Z2wNAG2vvunam2mfJATxnJcThnqw1qu02Xy8QlqFI"
    );
    $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    $getfield = '?screen_name=' . $content . '&count=3';
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $tweets = json_decode($twitter->setGetfield($getfield)
                 ->buildOauth($url, $requestMethod)
                 ->performRequest());
    $return = '<section '.$parallax_id.' class="twitter'.$parallax_class.$parallax_overlay_class.'" style="'.$style.'">
                <div class="row">';
    foreach( $tweets as $tweet ) {
        $tweet_text = $tweet->text;
        $tweet_text = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="http://$1" target="_blank">http://$1</a>', $tweet_text); //replace links
        $tweet_text = preg_replace('/@([a-z0-9_]+)/i', '<a href="http://twitter.com/$1" target="_blank">@$1</a>', $tweet_text); //replace users
        $return .= '<div class="col-md-4"><span></span>' . $tweet_text . '</div>';
    }
    $return .= '</div><h1>'.$title.'</h1></section>';
    return $return;
}
add_shortcode("twitter", "anps_twitter_func");
/* END twitter */
/* Logos */
function anps_logos_func( $atts,  $content ) { 
    return "<ul class='logos'>".do_shortcode($content)."</ul>";
}
add_shortcode('logos', 'anps_logos_func');
/* Single logo */
function anps_logo_func( $atts,  $content ) { 
    extract( shortcode_atts( array(
        'url' => '',
        'alt' => '',
        'image_u' => ''
    ), $atts ) ); 

    if($image_u) {
        $content = wp_get_attachment_image_src($image_u, 'full');
        $content = $content[0];
    }

    if($url) {
        return "<li><a href='".$url."' target='_blank'><img src='".$content."' alt='".$alt."'></a></li>";
    } else {
        return "<li><span><img src='".$content."' alt='".$alt."'></span></li>";
    }
}
add_shortcode('logo', 'anps_logo_func');
/* Social icons */
function anps_social_icons_func( $atts,  $content ) { 
    return "<div class='social-bookmarks'><ul>".do_shortcode($content)."</ul></div>";
}
add_shortcode('social_icons', 'anps_social_icons_func');
/* Single social icon */
function anps_social_icon_func( $atts,  $content ) { 
    extract( shortcode_atts( array(
        'url' => '#',
        'type' => '',
        'target' => '_blank'
    ), $atts ) ); 
    return "<li class='".$type."'><a href='".$url."' target='".$blank."'></a></li>";
}
add_shortcode('social_icon', 'anps_social_icon_func');
/* Contact info shortcode */
function contact_info_func( $atts,  $content ) {
    extract( shortcode_atts( array( 
        'parallax' => 'false',
        'parallax_overlay' => 'false',
        'color' => '',
        'image' => '',
        'slug' => '',
        'image_u' => ''
    ), $atts ) );

    if($image_u) {
        $image = wp_get_attachment_image_src($image_u, 'full');
        $image = $image[0];
    }

    global $anps_parallax_slug;
    $parallax_class = "";
    if($parallax=="true") {
        $parallax_class = " parallax";
        $anps_parallax_slug[] = $slug;
        $parallax_id = "id='$slug'";
    } 
    $parallax_overlay_class = "";
    if($parallax_overlay=="true") {
        $parallax_overlay_class = " parallax-overlay";
    } 
    $style = '';
    if($image) {
        $style = "background-image: url('$image');";
    } elseif($color) {
        $style = "background-color: $color;";
    }
    $contact_data = '<div '.$parallax_id.' class="contact-info'.$parallax_class.$parallax_overlay_class.'" style="'.$style.'">';
    $contact_data .= do_shortcode($content);
    $contact_data .= "</div>";    
    return $contact_data;
}
add_shortcode('contact_info', 'contact_info_func');
/* Statement */
function statement_func( $atts,  $content ) {
    extract( shortcode_atts( array( 
        'parallax' => 'false',
        'parallax_overlay' => 'false',
        'image' => '',
        'color' => '',
        'container' => 'false',
        'slug' => '',
        'image_u' => ''
    ), $atts ) );

    if($image_u) {
        $image = wp_get_attachment_image_src($image_u, 'full');
        $image = $image[0];
    }

    global $anps_parallax_slug;
    $parallax_class = "";
    if($parallax=="true") {
        $parallax_class = " parallax";
        $anps_parallax_slug[] = $slug;
        $parallax_id = "id='$slug'";
    } 
    $parallax_overlay_class = "";
    if($parallax_overlay=="true") {
        $parallax_overlay_class = " parallax-overlay";
    } 
    $containe_class = "";
    $container_before = "";
    $container_after = "";
    $container_class='';
    if($container=="true") {
        $container_before = '<div class="container">';
        $container_after = '</div>';
        $container_class = ' text-statement';
    } 
    $style = '';
    if($image) {
        $style = "background-image: url('$image');";
    } elseif($color) {
        $style = "background-color: $color;";
    } 
    return '<section '.$parallax_id.' class="statement'.$parallax_class.$parallax_overlay_class.$container_class.'" style="'.$style.'">'.$container_before.do_shortcode($content).$container_after.'</section>';
}
add_shortcode('statement','statement_func');
/* END statement */
/* Icon group */
function anps_icon_group_func( $atts,  $content ) { 
    extract( shortcode_atts( array(
        'icon_spacing' => 'false'
    ), $atts ) );
    if( $icon_spacing == 'true' ) {
        $icon_spacing = ' icon-spacing';
    } else {
        $icon_spacing = '';
    }
    return '<div class="icon-group' . $icon_spacing . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('icon_group', 'anps_icon_group_func');
/* Tabs shortcodes */
global $tabs_first;
$tabs_counter = 0;
$indiv_tab_counter = 0;
function tabs_func( $atts,  $content ) {
        extract( shortcode_atts( array(), $atts ) );
    global $tabs_counter, $indiv_tab_counter;
    $tabs_counter++;
    $sub_tabs_counter = 1;
    $indiv_tab_counter = 0;
    preg_match_all( '/tab title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE );
    $tab_titles = array();
    if ( isset($matches[0]) ) { $tab_titles = $matches[0]; }
    $tabs_menu = '';
    $tabs_menu .= '<ul class="nav nav-tabs" id="tab-' . $tabs_counter . '">';
    foreach ( $tab_titles as $tab ) {
        preg_match('/title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
        if(isset($tab_matches[1][0])) {
            if( $sub_tabs_counter == 1 ) {
                $tabs_menu .= '<li class="active"><a data-toggle="tab" href="#tab' . $tabs_counter . '-' . $sub_tabs_counter . '">' . $tab_matches[1][0] . '</a></li>';
            } else {
                $tabs_menu .= '<li><a data-toggle="tab" href="#tab' . $tabs_counter . '-' . $sub_tabs_counter . '">' . $tab_matches[1][0] . '</a></li>';
            }
            $sub_tabs_counter++; 
        }
    }
    $tabs_menu .= '</ul>';
    return $tabs_menu . '<div class="tab-content">' . do_shortcode($content) . '</div>';
}
add_shortcode('tabs', 'tabs_func');
/* Tab */
$tabs_first = true;
$tabs_single = 0;
function tab_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            "title" => ""
        ), $atts ) );
    global $tabs_counter, $tabs_first, $tabs_single;
    $active = "";
    if( $tabs_first ) {
        $active = " active";
    }
    $content = str_replace('&nbsp;', '<p class="blank-line clearfix"><br /></p>', $content);
    $tabs_first = false;
    $tabs_single++;
    return '<div id="tab' . $tabs_counter . '-' . $tabs_single . '" class="tab-pane' . $active . '">' . do_shortcode( $content ) . '</div>';
}
add_shortcode('tab', 'tab_func');
$accordion_counter = 0;
$accordion_opened = false;
function accordion_func( $atts,  $content ) {
    extract( shortcode_atts( array(
        "opened" => "false",
        'type' => 'accordion'
    ), $atts ) );
    global $accordion_counter, $accordion_opened, $accordion_type; 
    $accordion_type = '';
    $accordion_counter++;
    if($type == 'accordion') { 
        $accordion_type = 'data-parent="#accordion' . $accordion_counter . '"';
    }
    if( $opened == "true" ) {
        $accordion_opened = true;
    }
    return '<div class="panel-group" id="accordion' . $accordion_counter . '">' .  do_shortcode($content) . '</div>';
}
add_shortcode('accordion', 'accordion_func');
$accordion_item_counter = 0;
function accordion_item_func( $atts,  $content ) { 
    extract( shortcode_atts( array(
            'title' => ''           
    ), $atts ) );
    $opened_class = "";
    $class = ' class="collapsed"';
    global $accordion_item_counter, $accordion_opened, $accordion_type; 
    if( $accordion_opened ) {
        $opened_class = " in";
        $class = "";
        $accordion_opened = false;
    }
    $accordion_item_counter++;
    return '<div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse"' . $class. ' href="#collapse' . $accordion_item_counter . '" '.$accordion_type.'>' . $title . '</a>
                    </h4>
                </div>
                <div id="collapse' . $accordion_item_counter . '" class="panel-collapse' . $opened_class . ' collapse">
                    <div class="panel-body">' .  do_shortcode($content) . '</div>
                </div>
            </div>';
}
add_shortcode('accordion_item', 'accordion_item_func');
/* Services */
function services_func( $atts,  $content ) {   
    $services_data = "<div class='services'>";
    $services_data .= "<ul>".do_shortcode($content)."</ul></div>";
    strip_tags($services_data,"<p></p>");
    return $services_data;
}
add_shortcode('services', 'services_func');
/* Service */
function service_func( $atts,  $content ) {   
    extract( shortcode_atts( array(
        'icon'  => '', 
        'title' => '',
        'price' => '',
        'align' => 'left',
        'select' => 'false'
    ), $atts ) );
    if($select=="true") {
        $selected = 'selected';
        $visible = ' visible';
    } else {
        $selected = '';
        $visible = '';
    }
    $service_data = "<li class='".$align." ".$selected."'>";
    $service_data .= "<button><span class='glyphicon glyphicon-".$icon."'></span></button>";
    $service_data .= "<div class='service".$visible."'>";
    $service_data .= "<span class='glyphicon glyphicon-".$icon."'></span>";
    $service_data .= "<h1>".$title." / <span class='color'>".$price."</span></h1>";
    $service_data .= do_shortcode($content);
    $service_data .= "</div></li>";
    return $service_data;
}
add_shortcode('service', 'service_func');
/* Section */
function anps_section_func($atts, $content) {
    extract( shortcode_atts( array(
                'slug' => '',
                'style2' => 'false'
        ), $atts ) );
    $id_section='';
    if($slug) {
        $id_section = "id=$slug";
    }
    $style2_class='';
    if($style2=="true") {
        $style2_class = "class='section-style-2'";
    }
    return "<section $id_section $style2_class><div class='container'>".do_shortcode($content)."</div></section>";
}
add_shortcode("section", "anps_section_func");
/* Contact shortcode */
function anps_contact_func($atts, $content) { 
    extract( shortcode_atts( array(
            'email_to' => '',
            'success_msg' => 'Message sucessfuly sent!',
            'error_text' => 'Please insert only letters',
            'error_number' => 'Please insert numbers only',
            'error_email' => 'Please insert a valid email',
            'error_phone' => 'Please insert a valid phone number',
            'error_required' => 'This element is required',
            'email_from' => 'ziga.miklic92@gmail.com',
            'subject' =>'This is an awesome email!'
    ), $atts ) );
    global $test_mail;
    $test_mail = "TEST";
    $contact_data = "<form method='post' data-subject='".$subject."' data-from='".$email_from."' data-required='".$error_required."' data-email='".$error_email."' data-number='".$error_number."' data-text='".$error_text."' data-success='" . $success_msg . "' data-to='".$email_to."'>";
    $contact_data .= do_shortcode($content);
    $contact_data .= "</form>";
    return $contact_data; 
}
add_shortcode("contact", "anps_contact_func");
/* Contact item */
function anps_contact_item_func($atts, $content) {
    extract( shortcode_atts( array(
                'type' => 'text',
                'rows' => '5',
                'required' => 'false',
                'placeholder' => '',
                'validation' => 'none',
                'checked' => ''
        ), $atts ) );

    if($required=="true") {
        $required_data = ' data-required="required"';
    } else {
        $required_data = "";
    }
    if($type=="text") {
        $input_type = '<input type="text" placeholder="'.$placeholder.'" name="'.$placeholder.'" data-validation="'.$validation.'"'.$required_data.'>';
    } elseif ($type=="textarea") {
        $input_type = '<textarea rows="'.$rows.'" placeholder="'.$placeholder.'" name="'.$placeholder.'" data-validation="'.$validation.'"'.$required_data.'></textarea>';
    } elseif($type=="dropdown") {
        $dropdown_items = explode(",", $content);
        $input_type = "<select name='".$placeholder."'".$required_data.">";
        foreach($dropdown_items as $item) {
            $input_type .= "<option value='".$item."'>".$item."</option>";
        }
        $input_type .= "</select>";
    } elseif($type=="checkbox") {
        if( $checked == 'true' ) {
            $checked = ' checked="checked"';
        } else {
            $checked = '';
        }
        $input_type = "<input" . $checked . " type='checkbox' id='".$placeholder."' name='".$placeholder."' />";
        $input_type .= "<label for='".$placeholder."'>".$content."</label>";
    } elseif($type=="radio") {
        $radio_items = explode(",", $content);
        $input_type = "";
        $j=0;
        foreach($radio_items as $item) {
            $input_type .= "<div><input type='radio' name='".$placeholder."' id='".$placeholder.$j."' />";
            $input_type .= "<label for='".$placeholder.$j."'>".$item."</label></div>";
            $j++;
        }
    } elseif($type=="captcha") {
        global $contact_data;
        $publickey = $contact_data['public_key']; 
        $input_type = "<div class='captcha'>" . recaptcha_get_html($publickey) . "</div>";
        $input_type .= '<div class="clear"></div>';        
    }

    return $input_type;
}
add_shortcode("form_item", "anps_contact_item_func");
/* Contact button */
function anps_contact_button_func($atts, $content) { 
    return "<div class='col-md-6'><button data-form='clear' class='btn-style-1 btn-lg'>".__("Clear", ANPS_TEMPLATE_LANG)."</button></div>
            <div class='col-md-6'><button data-form='submit' class='btn-style-1 btn-lg'>".__("Submit", ANPS_TEMPLATE_LANG)."</button></div>";
}
add_shortcode("contact_button", "anps_contact_button_func");
/* Shoutbox */
function shoutbox_func( $atts,  $content ) {  
    return '<div class="shoutbox">' . do_shortcode($content) . '</div>';
}
add_shortcode('shoutbox', 'shoutbox_func');
} 
/* Heading */
function heading_func( $atts,  $content ) {  
    extract( shortcode_atts( array(
        'size' => '1'
    ), $atts ) ); 
    return '<h' . $size . '><span>' . $content . '</span></h1>';
}
add_shortcode('heading', 'heading_func');