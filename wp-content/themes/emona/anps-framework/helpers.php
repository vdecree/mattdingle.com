<?php
/* Header image, video, gallery */
function anps_header_media($id) {
    if(has_post_thumbnail($id)) { 
        $header_media = get_the_post_thumbnail($id, anps_blog_image_size($id));
    }
    elseif(get_post_meta($id, $key ='anps_featured_video', $single = true )) { 
        $header_media = do_shortcode(get_post_meta($id, $key ='anps_featured_video', $single = true ));
    }
    elseif(get_post_meta($id, $key ='gallery_images', $single = true )) { 
        $gallery_images = explode(",",get_post_meta($id, $key ='gallery_images', $single = true )); 
        
        foreach($gallery_images as $key=>$item) {
            if($item == '') {
                unset($gallery_images[$key]);
            }
        }
        
        $header_media = "<div id='carousel' class='carousel slide'>
                  <ol class='carousel-indicators'>";
        for($i=0;$i<count($gallery_images);$i++) {
            if($i==0) {
                $active_class = "active";
            } else {
                $active_class = "";
            }
            $header_media .= "<li data-target='#carousel' data-slide-to='".$i."' class='".$active_class."'></li>";
        }
        $header_media .= "</ol>";
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
        $header_media .= "<a class='left carousel-control' href='#carousel' data-slide='prev'>
                            <span class='glyphicon glyphicon-chevron-left'></span>
                          </a>
                          <a class='right carousel-control' href='#carousel' data-slide='next'>
                            <span class='glyphicon glyphicon-chevron-right'></span>
                          </a>
                  </div>";
    }
    else { 
        $header_media = "";
    }
    return $header_media;
}
add_action('init', 'anps_header_media');
function anps_get_header() {
    global $options_data;
    global $shop_data;
    $header_class = "";

    if( isset($options_data['menu_type']) && $options_data['menu_type'] && $options_data['menu_type'] == "menu_type2" ) {
        $header_class = " header-type-2";
    }
    ?>

    <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ): ?>
        <?php top_bar(); ?>
    <?php else: ?>
        <?php $header_class .= " fixed"; ?>
    <?php endif; ?>

    <header class="site-header wrapper <?php echo $header_class; ?>">
      <div class="container">
        <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ): ?>

            <?php
                global $woocommerce;
                $cart_url = $woocommerce->cart->get_cart_url();
                $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
                if ( $myaccount_page_id ) {
                    $myaccount_page_url = get_permalink( $myaccount_page_id );
                }
            ?>

            <?php if( $shop_data['shop-hide-cart'] != 'on' ): ?>
                <?php get_mini_cart();?>
            <?php endif; ?>

            <div class="login-cart">
                <?php if ( is_user_logged_in() ): ?>
                    <a href="<?php echo $myaccount_page_url; ?>"><?php _e('My Account', ANPS_TEMPLATE_LANG); ?></a> / 
                <?php else: ?>
                    <a href="<?php echo $myaccount_page_url; ?>"><?php _e('Login', ANPS_TEMPLATE_LANG); ?></a> / 
                <?php endif; ?>
                <a href="<?php echo $cart_url; ?>"><?php _e('Cart', ANPS_TEMPLATE_LANG); ?></a>
            </div>
        <?php endif; ?>
        <?php anps_get_site_header();?>
        </div>
    </header>

    <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && (is_cart() || is_checkout() || is_account_page()) ): ?>
        <?php
            global $shop_data;
            if($shop_data['anps_before_shop']) {
                echo do_shortcode(stripslashes($shop_data['anps_before_shop']));
            }
        ?>
        <div class="container">
    <?php endif;
}
function anps_blog_image_size($id) {
    $left_sidebar = get_post_meta($id, 'sbg_selected_sidebar', true);
    $right_sidebar = get_post_meta($id, 'sbg_selected_sidebar_replacement', true);
    if((isset($left_sidebar) && $left_sidebar!="0") && (isset($right_sidebar) && $right_sidebar!="0")) { 
        $blog_image = 'blog-two-sidebar';
    } elseif((isset($left_sidebar) && $left_sidebar!="0") || (isset($right_sidebar) && $right_sidebar!="0")) { 
        $blog_image = 'blog-one-sidebar';
    } else { 
        $blog_image = 'blog-no-sidebar';
    }
    return $blog_image;
}
add_action('init', 'anps_blog_image_size');
function anps_setRTL() {
    global $wp_locale, $wp_styles;
    
    $wp_styles = new stdClass();
    if( get_option('rtl', '') && get_option('rtl', '') == "on" ) {
        $direction = "rtl";
    } else {
        $direction = "ltr";
    }
    $wp_locale->text_direction = $direction;        
    $wp_styles->text_direction = $direction;
}
add_action('wp_loaded', 'anps_setRTL');
function anps_is_responsive($rtn)  {
    global $options_data;   
    $responsive = "";
    $boxed_backgorund = '';
    $hide_body_class = '';
    if(isset($options_data['preloader']) && $options_data['preloader']=="on") {
        $hide_body_class = ' hide-body';
    }

    if ($options_data['pattern']) {
        $boxed_backgorund .= ' pattern-' . $options_data['pattern'];
    }

    if (isset($options_data['responsive'])) $responsive = $options_data['responsive'];
    if ( $responsive != "on" ) {
        if ( $rtn == true ) {
            return " responsive" . $hide_body_class . $boxed_backgorund;
        } else {?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php }
    } else {
        return " responsive-off" . $hide_body_class . $boxed_backgorund;
    }
    
}
function anps_body_style() {
    global $options_data;   
    
    if ( $options_data['pattern'] == '0' ) {
        if($options_data['type'] == "custom color") {
            echo ' style="background-color: ' . $options_data['bg_color'] . ';"';
        }else if ($options_data['type'] == "stretched") {
            echo ' style="background: url(' . $options_data['custom_pattern'] . ') center center fixed;background-size: cover;     -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;"';
        } else {
            echo ' style="background: url(' . $options_data['custom_pattern'] . ')"';
        }
    } 
}
function anps_theme_after_styles() {
    if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
    
    get_template_part("includes/google_analytics");
    get_template_part("includes/shortcut_icon");
}
/* Return site logo */
function anps_get_logo() { 
    global $media_data;
    //$size_sticky = getimagesize($media_data['sticky-logo']);
    $size_sticky = array(120, 120);
    if( ! $size_sticky ) {
        $size_sticky = array(120, 120);
    }
    $logo_width = 82;
    $logo_height = 21;

    if( $media_data['logo-width'] ) {
        $logo_width = $media_data['logo-width'];
    }
    
    if( $media_data['logo-height'] ) {
        $logo_height = $media_data['logo-height'];
    }

    if (isset($media_data['logo']) && $media_data['logo'] != "") : 
        $logo = $media_data['logo'];
        if (!empty($_SERVER['HTTPS'])) {
            $logo = str_replace('http:', 'https:', $logo);
        }
        ?>
        <a href="<?php echo esc_url(home_url("/")); ?>"><img style="width: <?php echo $logo_width; ?>px; height: <?php echo $logo_height; ?>px" alt="Site logo" src="<?php echo $logo; ?>"></a>
    <?php else: ?>
        <a href="<?php echo esc_url(home_url("/")); ?>"><img style="width: <?php echo $logo_width; ?>px; height: <?php echo $logo_height; ?>px" alt="Site logo" src="http://anpsthemes.com/emona/wp-content/uploads/2014/02/logo_emona.png"></a>        
    <?php endif;
}
/* Tags and author */
function anps_tagsAndAuthor() {
    ?>
        <div class="tags-author">
    <?php echo __('posted by', ANPS_TEMPLATE_LANG); ?> <?php echo get_the_author(); ?>
    <?php
    $posttags = get_the_tags();
    if ($posttags) {
        echo " &nbsp;|&nbsp; ";
        echo __('Taged as', ANPS_TEMPLATE_LANG) . " - ";
        $first_tag = true;
        foreach ($posttags as $tag) {
            if ( ! $first_tag) {
                echo ', ';
            }
            echo '<a href="' . esc_url(home_url('/')) . 'tag/' . $tag->slug . '/">';
            echo $tag->name;
            echo '</a>';
            $first_tag = false;
        }
    }
    ?>
        </div>
    <?php
}
/* Current page url */
function curPageURL() {
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"])) $pageURL .= "s";
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") 
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    else 
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    
    return $pageURL;
}
/* Gravatar */
add_filter('avatar_defaults', 'newgravatar');
function newgravatar($avatar_defaults) {
    $myavatar = get_template_directory_uri() . '/images/move_default_avatar.jpg';
    $avatar_defaults[$myavatar] = "Anps default avatar";
    return $avatar_defaults;
}
/* Get post thumbnail src */
function anps_get_the_post_thumbnail_src($img) {
    return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}   
function anps_get_menu() {
?>
    <nav class="navigation" role="navigation">
        <?php
            $locations = get_theme_mod('nav_menu_locations');
            wp_nav_menu( array(
                'container' => false,
                'menu_class' => 'nav-menu',
                'echo' => true,
                'before' => '',
                'after' => '',
                'link_before' => '',
                'link_after' => '',
                'depth' => 0,
                'walker' => new description_walker(),
                'menu'=>$locations['primary']
            ));
        ?>
    </nav>       
    <button class="mobile-nav">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <?php
}
function anps_get_site_header() { ?>
    <div class="site-logo">
        <?php anps_get_logo(); ?>
    </div>
    <?php anps_get_menu(); ?>    
<?php }

add_filter("the_content", "the_content_filter");
 
function the_content_filter($content) {
    // array of custom shortcodes requiring the fix 
    $block = join("|",array("section","contact", "form_item", "services", "service","contact_info", "tabs", "tab", "accordion", "accordion_item", "progress", "quote", "statement", "color", "google_maps", "vimeo", "youtube", "person", "logos", "logo", "button", "error_404", "icon", "icon_group", "content_half", "content_third", "content_two_third", "content_quarter", "content_two_quarter", "content_three_quarter", "twitter", "social_icons", "social_icon"));
    // opening tag
    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
    // closing tag
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
 
    return $rep;
 
}
/* Post gallery */
add_filter( 'post_gallery', 'anps_my_post_gallery', 10, 2 );
function anps_my_post_gallery( $output, $attr) {
    global $post, $wp_locale;
    static $instance = 0;
    $instance++;
    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }
    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));
    
    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';
    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }
    if ( empty($attachments) )
        return '';
    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }
    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $margin_calc = ($columns-1)*2;
    $itemwidth = (100-$margin_calc) / $columns;
    $float = is_rtl() ? 'right' : 'left';
    $margin = 0;
    $selector = "gallery-{$instance}";
    ?>
        <!--[if IE 8]>
            <?php $size = "portfolio-thumbnail-2-column"; ?>
        <![endif]--> 
    <?php 
    $output = '';
    $output .= "<div id='$selector' class='gallery gallery-{$columns}-columns galleryid-{$id}'>";
 
    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $link_big = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_image_src($id, 'full', false) : wp_get_attachment_image_src($id, 'full', false);
        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_image_src($id, 'full', false) : wp_get_attachment_image_src($id, 'full', false);
        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "
            <{$icontag} class='gallery-icon'>
                <a data-toggle='modal' href='#gallery-item-" . $i . "' title='" . wptexturize($attachment->post_excerpt) . "''>
                    <img alt='Gallery image' src='$link[0]' />
                    <span class='glyphicon glyphicon-search'></span>
                </a>
            </{$icontag}>";
        $output .= '
              <div class="modal fade" id="gallery-item-' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-image">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <img src="' . $link_big[0] . '" />
                        <button class="modal-prev wooslider-next"></button>
                        <button class="modal-next"></button>
                    </div>
                  </div>
                </div>
              </div>
        ';
        $output .= "<dd></dd></{$itemtag}>";
        $i++;
    }
    $output .= "
            <br style='clear: both;' />
        </div>\n";
    return $output;
}
//get post_type    
function get_current_post_type() {
    if (is_admin()) {
        global $post, $typenow, $current_screen;
        //we have a post so we can just get the post type from that
        if ($post && $post->post_type)
            return $post->post_type;
        //check the global $typenow - set in admin.php
        elseif ($typenow)
            return $typenow;
        //check the global $current_screen object - set in sceen.php
        elseif ($current_screen && $current_screen->post_type)
            return $current_screen->post_type;
        //lastly check the post_type querystring
        elseif (isset($_REQUEST['post_type']))
            return sanitize_key($_REQUEST['post_type']);
        elseif (isset($_REQUEST['post']))
            return get_post_type($_REQUEST['post']);
        //we do not know the post type!
        return null;
    }
}
/* hide sidebar generator on testimonials and portfolio */
if (get_current_post_type() != 'testimonials' && get_current_post_type() != 'portfolio') {
    //add sidebar generator
    include_once 'sidebar_generator.php';
}
/* Admin/backend styles */
add_action('admin_head', 'backend_styles');
function backend_styles() {
    echo '<style type="text/css">
        .mceListBoxMenu {
            height: auto !important;
        }
        .wp_themeSkin .mceListBoxMenu {
            overflow: visible;
            overflow-x: visible;
        }
    </style>';
}
add_action('admin_head', 'show_hidden_customfields');
function show_hidden_customfields() {
    echo "<input type='hidden' value='" . get_template_directory_uri() . "' id='hidden_url'/>";
}
if (!function_exists('anps_admin_header_style')) :
    /*
     * Styles the header image displayed on the Appearance > Header admin panel.
     * Referenced via add_custom_image_header() in widebox_setup().
     */
    function anps_admin_header_style() {
        ?>
        <style type="text/css">
            /* Shows the same border as on front end */
            #headimg {
                border-bottom: 1px solid #000;
                border-top: 4px solid #000;
            }
        </style>
        <?php
    }
endif;
/* Filter wp title */
add_filter('wp_title', 'anps_filter_wp_title', 10, 2);
function anps_filter_wp_title($title, $separator) {
    // Don't affect wp_title() calls in feeds.
    if (is_feed())
        return $title;
    // The $paged global variable contains the page number of a listing of posts.
    // The $page global variable contains the page number of a single post that is paged.
    // We'll display whichever one applies, if we're not looking at the first page.
    global $paged, $page;
    if (is_search()) {
        // If we're a search, let's start over:
        $title = sprintf(__('Search results for %s', ANPS_TEMPLATE_LANG), '"' . get_search_query() . '"');
        // Add a page number if we're on page 2 or more:
        if ($paged >= 2)
            $title .= " $separator " . sprintf(__('Page %s', ANPS_TEMPLATE_LANG), $paged);
        // Add the site name to the end:
        $title .= " $separator " . get_bloginfo('name', 'display');
        // We're done. Let's send the new title back to wp_title():
        return $title;
    }
    // Otherwise, let's start by adding the site name to the end:
    $title .= get_bloginfo('name', 'display');
    // If we have a site description and we're on the home/front page, add the description:
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page() ))
        $title .= " $separator " . $site_description;
    
    // Add a page number if necessary:
    if ($paged >= 2 || $page >= 2)
        $title .= " $separator " . sprintf(__('Page %s', ANPS_TEMPLATE_LANG), max($paged, $page));
    // Return the new title to wp_title():
    return $title;
}
/* Page menu show home */
add_filter('wp_page_menu_args', 'anps_page_menu_args');
function anps_page_menu_args($args) {
    $args['show_home'] = true;
    return $args;
}
/* Sets the post excerpt length to 40 characters. */
add_filter('excerpt_length', 'anps_excerpt_length');
function anps_excerpt_length($length) {
    return 40;
}
/* Returns a "Continue Reading" link for excerpts */
function anps_continue_reading_link() {
    return ' <a href="' . get_permalink() . '">' . __('Continue reading <span class="meta-nav">&rarr;</span>', ANPS_TEMPLATE_LANG) . '</a>';
}
/* Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and widebox_continue_reading_link(). */
add_filter('excerpt_more', 'anps_auto_excerpt_more');
function anps_auto_excerpt_more($more) {
    return ' &hellip;' . anps_continue_reading_link();
}
/* Adds a pretty "Continue Reading" link to custom post excerpts. */
add_filter('get_the_excerpt', 'anps_custom_excerpt_more');
function anps_custom_excerpt_more($output) {
    if (has_excerpt() && !is_attachment()) {
        $output .= anps_continue_reading_link();
    }
    return $output;
}
/* Remove inline styles printed when the gallery shortcode is used. */
add_filter('gallery_style', 'anps_remove_gallery_css');
function anps_remove_gallery_css($css) {
    return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css);
}
/* WIDGET: Remove recent comments sytle */
add_action('widgets_init', 'anps_remove_recent_comments_style');
function anps_remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
/* Prints HTML with meta information for the current post—date/time and author. */
if (!function_exists('widebox_posted_on')) :    
    function widebox_posted_on() {
        printf(__('<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', ANPS_TEMPLATE_LANG), 'meta-prep meta-prep-author', sprintf('<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>', get_permalink(), esc_attr(get_the_time()), get_the_date()
                ), sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>', get_author_posts_url(get_the_author_meta('ID')), sprintf(esc_attr__('View all posts by %s', ANPS_TEMPLATE_LANG), get_the_author()), get_the_author()
                )
        );
    }
endif;
/* Prints HTML with meta information for the current post (category, tags and permalink).*/
if (!function_exists('widebox_posted_in')) :   
    function widebox_posted_in() {
        // Retrieves tag list of current post, separated by commas.
        $tag_list = get_the_tag_list('', ', ');
        if ($tag_list) {
            $posted_in = __('This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', ANPS_TEMPLATE_LANG);
        } elseif (is_object_in_taxonomy(get_post_type(), 'category')) {
            $posted_in = __('This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', ANPS_TEMPLATE_LANG);
        } else {
            $posted_in = __('Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', ANPS_TEMPLATE_LANG);
        }
        // Prints the string, replacing the placeholders.
        printf($posted_in, get_the_category_list(', '), $tag_list, get_permalink(), the_title_attribute('echo=0'));
    }
endif;
/* After setup theme */
add_action('after_setup_theme', 'anps_setup');
if (!function_exists('anps_setup')):
    function anps_setup() {
        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();
        // This theme uses post thumbnails
        add_theme_support('post-thumbnails');
        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');
        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain(ANPS_TEMPLATE_LANG, get_template_directory() . '/languages');
        $locale = get_locale();
        $locale_file = get_template_directory() . "/languages/$locale.php";
        if (is_readable($locale_file))
            require_once( $locale_file );
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => __('Primary Navigation', ANPS_TEMPLATE_LANG),
        ));
        // This theme allows users to set a custom background
        //add_custom_background();
        // Your changeable header business starts here
        define('HEADER_TEXTCOLOR', '');
        // No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
        define('HEADER_IMAGE', '%s/images/headers/path.jpg');
        // The height and width of your custom header. You can hook into the theme's own filters to change these values.
        // Add a filter to widebox_header_image_width and widebox_header_image_height to change these values.
        define('HEADER_IMAGE_WIDTH', apply_filters('widebox_header_image_width', 190));
        define('HEADER_IMAGE_HEIGHT', apply_filters('widebox_header_image_height', 54));
        // We'll be using post thumbnails for custom header images on posts and pages.
        // We want them to be 940 pixels wide by 198 pixels tall.
        // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
        set_post_thumbnail_size(HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true);
        // Don't support text inside the header image.
        define('NO_HEADER_TEXT', true);
        // Add a way for the custom header to be styled in the admin panel that controls
        // custom headers. See widebox_admin_header_style(), below.
        //add_custom_image_header( '', 'widebox_admin_header_style' );
        // ... and thus ends the changeable header business.
        // Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
        register_default_headers(array(
            'berries' => array(
                'url' => '%s/images/headers/logo.png',
                'thumbnail_url' => '%s/images/headers/logo.png',
                /* translators: header image description */
                'description' => __('Move default logo', ANPS_TEMPLATE_LANG)
            )
        ));
        if (!isset($_GET['stylesheet']))
            $_GET['stylesheet'] = '';
        $theme = wp_get_theme($_GET['stylesheet']);
        if (!isset($_GET['activated']))
            $_GET['activated'] = '';
        if ($_GET['activated'] == 'true' && $theme->get_template() == 'widebox132') {
            
            $arr = array(
                    0=>array('label'=>'e-mail', 'input_type'=>'text', 'is_required'=>'on', 'placeholder'=>'email', 'validation'=>'email'),
                    1=>array('label'=>'subject', 'input_type'=>'text', 'is_required'=>'on', 'placeholder'=>'subject', 'validation'=>'none'),
                    2=>array('label'=>'contact number', 'input_type'=>'text', 'is_required'=>'', 'placeholder'=>'contact number', 'validation'=>'phone'),
                    3=>array('label'=>'lorem ipsum', 'input_type'=>'text', 'is_required'=>'', 'placeholder'=>'lorem ipsum', 'validation'=>'none'),
                    4=>array('label'=>'message', 'input_type'=>'textarea', 'is_required'=>'on', 'placeholder'=>'message', 'validation'=>'none'),
                );
            update_option('anps_contact', $arr);
        } 
    }
endif;
/* theme options init */
add_action('admin_init', 'theme_options_init');
function theme_options_init() {
    register_setting('sample_options', 'sample_theme_options');
}
/* If user is admin, he will see theme options */
add_action('admin_menu', 'theme_options_add_page');
function theme_options_add_page() {
    global $current_user; 
    if($current_user->user_level==10) {
        add_theme_page('Theme Options', 'Theme Options', 'read', 'theme_options', 'theme_options_do_page');
    }
}
function theme_options_do_page() {
    include_once "admin_view.php";
}
/* Wp_mail */
function MailFunction(){
    $to = $_POST['form_data']['envoo-admin-mail'];    //your e-mail to which the message will be sent
    $from = $_POST['form_data']['envoo-admin-mail'];        //e-mail address from which the e-mail will be sent
    $subject_contact_us = 'Someone has sent you a message!';   //subject of the e-mail for the form on contact-us.html
    $subject_follow_us = 'I want to follow you';       //subject of the e-mail for the form on follow-us.html
    $message = '';
    $message .= '<table cellpadding="0" cellspacing="0">';
    foreach ($_POST['form_data'] as $postname => $post) {
        if ($postname != 'envoo-admin-mail' && $postname != "recaptcha_challenge_field" && $postname != "recaptcha_response_field") {
            $message .= "<tr><td style='padding: 5px 20px 5px 5px'><strong>" . urldecode($postname) . ":</strong>" . "</td><td style='padding: 5px; color: #444'>" . $post . "</td></tr>";
        }
    }
    $message .= '</table>';
    $headers = 'From: ' . $from . "\r\n" .
            'Reply-To: info@yourdomain.com' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    wp_mail($to, $subject_contact_us, $message, $headers);
}
add_action('wp_ajax_nopriv_MailFunction', 'MailFunction');
add_action( 'wp_ajax_MailFunction', 'MailFunction' ); 
/* Comments */
function anps_comment($comment, $args, $depth) {
    $email = $comment->comment_author_email;
    $user_id = -1;
    if (email_exists($email))
        $user_id = email_exists($email);
    $GLOBALS['comment'] = $comment;
    ?>
                                
    <li <?php comment_class(); ?>>
        <article id="comment-<?php comment_ID(); ?>">
            <header>
                <span class="date"><?php echo get_comment_date("d")." ".strtolower(get_comment_date("M"));?></span>
                <h1><?php comment_author(); ?></h1>
                <?php echo comment_reply_link(array_merge(array('reply_text' => 'Reply'), array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
            </header>
            <div class="comment-content"><?php comment_text(); ?></div>
        </article>
    </li>
<?php }
/* Remove Excerpt text */
function sbt_auto_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'sbt_auto_excerpt_more', 20 );
function sbt_custom_excerpt_more( $output ) {
    return preg_replace('/<a[^>]+>Continue reading.*?<\/a>/i','',$output);
}
add_filter( 'get_the_excerpt', 'sbt_custom_excerpt_more', 20 );
function getFooterTwitter() {
    $twitter_user = get_option('footer_twitter_acc', 'twitter');
    $settings = array(
        'oauth_access_token' => "1485322933-3Xfq0A59JkWizyboxRBwCMcnrIKWAmXOkqLG5Lm",
        'oauth_access_token_secret' => "aFuG3JCbHLzelXCGNmr4Tr054GY5wB6p1yLd84xdMuI",
        'consumer_key' => "D3xtlRxe9M909v3mrez3g",
        'consumer_secret' => "09FiAL70fZfvHtdOJViKaKVrPEfpGsVCy0zKK2SH8E"
    );
    $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    $getfield = '?screen_name=' . $twitter_user . '&count=1';
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $twitter_json = $twitter->setGetfield($getfield)
                 ->buildOauth($url, $requestMethod)
                 ->performRequest();
    $twitter_json = json_decode($twitter_json, true);
    $twitter_user_url = "https://twitter.com/" . $twitter_user;
    $twitter_text = $twitter_json[0]["text"];
    $twitter_tweet_url = "https://twitter.com/" . $twitter_user . "/status/" . $twitter_json[0]["id_str"];
    ?>
    <div class="twitter-footer"><div class="container"><a href="<?php echo $twitter_user_url; ?>" target="_blank" class="tw-icon"></a><a href="<?php echo $twitter_user_url; ?>" target="_blank" class="tw-heading"><?php _e("twitter feed", ANPS_TEMPLATE_LANG); ?></a><a href="<?php echo $twitter_tweet_url; ?>" target="_blank" class="tw-content"><?php echo $twitter_text; ?></a></div></div>
    <?php
}
function get_excerpt(){
    $excerpt = get_the_content();
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, 100);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    if( $excerpt != "" ) {
        $excerpt = $excerpt.'...';
    }
    return $excerpt;
}

add_filter('widget_tag_cloud_args','set_cloud_tag_size');
function set_cloud_tag_size($args) {
    $args = array('smallest' => 13, 'largest' => 24);
    return $args;
} 

function anps_boxed() {
    global $options_data;

    if (isset($options_data['boxed']) && $options_data['boxed'] == 'on') {
        echo ' boxed';
    }
}