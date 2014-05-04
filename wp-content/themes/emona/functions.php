<?php
/* CONSTANTS */
define('ANPS_TEMPLATE_LANG', 'emona');
global $not_content;
/* Override vc tabs */
if ( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    function vc_theme_rows($atts, $content) {
        $style = '';
        $extra_class = '';
        $extra_id = '';
        global $not_content;
        if(isset($atts['bg_color']) && $atts['bg_color']) {
            $style .= 'background-color: '. $atts['bg_color'] . ';';
        }
        if(isset($atts['font_color']) && $atts['font_color']) {
            $style .= 'color: '. $atts['font_color'] . ';';
        }
        if(isset($atts['padding']) && $atts['padding']) {
            $style .= 'padding: '. $atts['padding'] . ';';
        }
        if(isset($atts['margin_bottom']) && $atts['margin_bottom']) {
            $style .= 'margin-bottom: '. $atts['margin_bottom'] . ';';
        }
        if(isset($atts['bg_image']) && $atts['bg_image']) {
            $image_attributes = wp_get_attachment_image_src( $atts['bg_image'], 'full' );
            $style .= 'background-image: url(' . $image_attributes[0] . ');';
        }
        if(isset($atts['el_class']) && $atts['el_class']) {
            $extra_class = ' '. $atts['el_class'];
        }
        if(isset($atts['id']) && $atts['id']) {
            $extra_id = 'id= "'. $atts['id'].'"';
        }
        if($style!='') {
            $style = ' style="' . $style . '"';
        }
        if($atts['has_content']!="false") {
            $div_value = '<div class="container"><div class="row row-md">'.wpb_js_remove_wpautop($content).'</div></div>';
        } else {
            $not_content = true;
            return '<div '.$extra_id.' class="clearfix' . $extra_class . '"' . $style . '>'.wpb_js_remove_wpautop($content).'</div>';
        }
        return '<section '.$extra_id.' class="' . $extra_class . '"' . $style . '>'.$div_value.'</section>';
    }
    function vc_theme_columns($atts, $content = null) {
        if( !isset($width) || !$width ) {
            $width = '1/1';
        }
        $width = explode('/', $atts['width']);
        if($width[1] > 0) {
            $col = (12/$width[1])*$width[0];
        } else {
            $col = 12;
        }
        $extra_class = '';
        global $not_content, $is_in_person;
        if(isset($atts['el_class']) && $atts['el_class']) {
            $extra_class = ' ' . $atts['el_class'];
        }
        if($not_content&&!$is_in_person) {
            $not_content = false;
            return wpb_js_remove_wpautop($content); 
        } else {
            return '<div class="col-md-' . $col . $extra_class . '">'.wpb_js_remove_wpautop($content).'</div>';
        }
    }
    function vc_theme_vc_row($atts, $content = null) {
        return vc_theme_rows($atts, $content);
    }
    function vc_theme_vc_row_inner($atts, $content = null) {
        return vc_theme_rows($atts, $content);
    }
    function vc_theme_vc_column($atts, $content = null) {
        return vc_theme_columns($atts, $content);
    }
    function vc_theme_vc_column_inner($atts, $content = null) {
        return vc_theme_columns($atts, $content);
    }
    function vc_theme_vc_tabs($atts, $content = null) { 
        $content2 = str_replace("vc_tab", "tab", $content);
        return do_shortcode("[tabs]".$content2."[/tabs]");
    }
    function vc_theme_vc_column_text($atts, $content = null) {
        return do_shortcode(force_balance_tags($content));
    }
}

/* Image sizes */
add_theme_support('post-thumbnails');
add_image_size('blog-one-sidebar', 1574, 706, true);
add_image_size('blog-no-sidebar', 1574, 706, true);
add_image_size('blog-two-sidebar', 1574, 706, true);
add_image_size('recent-blog-portfolio', 706, 530, true);
add_image_size('team', 564, 712, true);
add_image_size('product-widget', 146, 174, true);
if(!is_admin()) {
    include_once get_template_directory().'/anps-framework/classes/Options.php'; 
    include_once get_template_directory().'/anps-framework/classes/Contact.php'; 
    $page_data = $options->get_page_setup_data();
    $options_data = $options->get_page_data(); 
    $media_data = $options->get_media(); 
    $social_data = $options->get_social(); 
    $contact_data = $contact->get_data();
    $shop_data = $options->get_shop_setup_data();
}
/* Include helper.php */
include_once get_template_directory().'/anps-framework/helpers.php';
if (!isset($content_width))
    $content_width = 967;
add_filter('widget_text', 'do_shortcode');
/* Widgets */
include_once 'anps-framework/widgets/widgets.php';
/* Shortcodes */
include_once 'anps-framework/shortcodes.php';
if (is_admin()) {
    include_once 'shortcodes/shortcodes_init.php';
}
/* On setup theme */
add_action('after_setup_theme', 'anps_register_custom_fonts');
function anps_register_custom_fonts() { 
    if (!isset($_GET['stylesheet'])) {
        $_GET['stylesheet'] = '';
    }
    $theme = wp_get_theme($_GET['stylesheet']);
    if (!isset($_GET['activated'])) {
        $_GET['activated'] = '';
    }
    if ($_GET['activated'] == 'true' && $theme->get_template() == ANPS_TEMPLATE_LANG) { 
        include_once get_template_directory().'/anps-framework/classes/Options.php';
        include_once get_template_directory().'/anps-framework/classes/Style.php';
        /* Add google fonts*/
        if(get_option('anps_google_fonts', '')=='') {
            $style->update_gfonts_install();
        }
        /* Add custom fonts to options */
        $style->get_custom_fonts();
        /* Add default fonts */
        if(get_option('font_type_1', '')=='') {
            update_option("font_type_1", "BebasNeue-webfont");
        }
        if(get_option('font_type_2', '')=='') {
            update_option("font_type_2", "Open+Sans");
        }
        if(get_option('font_type_3', '')=='') {
            update_option("font_type_3", "Arial, Helvetica, sans-serif");
        }
    }
    $fonts_installed = get_option('fonts_intalled');
    
    if($fonts_installed==1)
        return;
    
    /* Get custom font */
    include_once get_template_directory().'/anps-framework/classes/Style.php';
    $fonts = $style->get_custom_fonts();
    /* Update custom font */
    foreach($fonts as $name=>$value) { 
        $arr_save[] = array('value'=>$value, 'name'=>$name);
    }
    update_option('anps_custom_fonts', $arr_save);
    update_option('fonts_intalled', 1);
}
/* Team */
include_once 'anps-framework/team.php';
add_action('init', 'anps_team');
function anps_team() {
    new Team();
}
/* Team metaboxes */
include_once 'anps-framework/team_meta.php';
/* Portfolio metaboxes */
include_once 'anps-framework/portfolio_meta.php';
/* Portfolio */
include_once 'anps-framework/portfolio.php';
add_action('init', 'anps_portfolio');
function anps_portfolio() {
    new Portfolio();
}
/* Portfolio metaboxes */
include_once 'anps-framework/metaboxes.php';
/* Menu metaboxes */
//include_once 'anps-framework/menu_meta.php';
/* Featured video metabox */
include_once 'anps-framework/featured_video_meta.php';
 
//install paralax slider
include_once 'anps-framework/install_plugins.php';
add_editor_style('css/editor-style.php');
/* Admin bar theme options menu */
include_once 'anps-framework/classes/adminBar.php';
/* PHP header() NO ERRORS */
if (is_admin())
    add_action('init', 'anps_do_output_buffer');
function anps_do_output_buffer() {
    ob_start();
}
remove_action( 'admin_notices', 'woothemes_updater_notice' );
/* Infinite scroll 08.07.2013 */
function anps_infinite_scroll_init() {
    add_theme_support( 'infinite-scroll', array(
        'type'       => 'click',
        'footer_widgets' => true,
        'container'  => 'section-content',
        'footer'     => 'site-footer',
    ) );
}
add_action( 'init', 'anps_infinite_scroll_init' );
/* WooCommerce */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    include_once 'anps-framework/woocommerce/functions.php';
}
/* MegaMenu */
class description_walker extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="'. esc_attr( $class_names ) . '"';
        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url       ) .'"' : '';
        $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';
        $description = do_shortcode($description);
        $append = "";
        $prepend = "";
        if($depth == 0)
        {
            $description = $append = $prepend = "";
        }
        $locations = get_theme_mod('nav_menu_locations');
        
        if($locations['primary']) {
            $item_output = "";
            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= '</a>';
            $item_output .= $description.$args->link_after;
            $item_output .= $args->after;
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth = 0, $args, $args, $current_object_id = 0 );
        }
    }
} 
function anps_custom_colors() {
    echo '<style type="text/css">
        #gallery_images .image {width: 23%;margin:0 1%;float: left}
        #gallery_images ul:after {content: "";display: table;clear: both;}
        #gallery_images .image img {max-width: 100%;height: 50px;}
    </style>';
}
add_action('admin_head', 'anps_custom_colors');
/* Post/Page gallery images */
include_once 'anps-framework/gallery_images.php';
function anps_scripts_and_styles() {
    wp_enqueue_script("jquery");
    wp_enqueue_style("custom_styles", get_template_directory_uri()  . "/includes/custom-styles.php");
    wp_enqueue_style("font-awesome", "//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");

    global $is_IE;

    if ( $is_IE ) {
        wp_enqueue_style("ie-fix", get_template_directory_uri() . '/css/ie-fix.css');
        wp_enqueue_script( "respond", get_template_directory_uri()  . "/js/respond.js", '', '', true );
        wp_enqueue_script( "iefix", get_template_directory_uri()  . "/js/ie-fix.js", '', '', true );
        wp_enqueue_script( "htmlshiv", get_template_directory_uri()  . "/js/html5shiv.js", '', '', false );
    }
  
    wp_enqueue_script( "easing2", get_template_directory_uri()  . "/js/jquery.easing.1.3.js", '', '', true );
    wp_enqueue_script( "queryloader2", get_template_directory_uri()  . "/js/jquery.queryloader2.js", '', '', true );
    wp_enqueue_script( "parallax", get_template_directory_uri()  . "/js/jquery.parallax.js", '', '', true );
    wp_enqueue_script( "isotope", get_template_directory_uri()  . "/js/jquery.isotope.min.js", '', '', true );
    wp_enqueue_script( "smoothscroll", get_template_directory_uri()  . "/js/smoothscroll.js", '', '', true );
    wp_enqueue_script( "modal", get_template_directory_uri()  . "/js/bootstrap/modal.js", '', '', true );
    wp_enqueue_script( "alert", get_template_directory_uri()  . "/js/bootstrap/alert.js", '', '', true );
    wp_enqueue_script( "tab", get_template_directory_uri()  . "/js/bootstrap/tab.js", '', '', true );
    wp_enqueue_script( "collapse", get_template_directory_uri()  . "/js/bootstrap/collapse.js", '', '', true );
    wp_enqueue_script( "carousel", get_template_directory_uri()  . "/js/bootstrap/carousel.js", '', '', true );
    wp_enqueue_script( "transition", get_template_directory_uri()  . "/js/bootstrap/transition.js", '', '', true );
    wp_enqueue_script( "waypoints", get_template_directory_uri()  . "/js/waypoints.min.js", '', '', true );
    if (!empty($_SERVER['HTTPS'])) {
        wp_enqueue_script( "gmap3_link", "https://maps.google.com/maps/api/js?sensor=false", '', '', true );
    } else {
        wp_enqueue_script( "gmap3_link", "http://maps.google.com/maps/api/js?sensor=false", '', '', true );
    }
    wp_enqueue_script( "gmap3", get_template_directory_uri()  . "/js/gmap3.min.js", '', '', true );
    wp_enqueue_script( "functions", get_template_directory_uri()  . "/js/functions.js", '', '', true );
    wp_enqueue_script( "prettyPhoto", get_template_directory_uri()  . "/js/jquery.prettyPhoto.js", '', '', true );
}
add_action( 'wp_enqueue_scripts', 'anps_scripts_and_styles' );
function anps_theme_styles() {     
    global $options_data;
    
    $url_prepend = "http";

    if (!empty($_SERVER['HTTPS'])) {
        $url_prepend .= "s";
    }

    if ( get_option('font_source_1') && get_option('font_source_1')=='Google fonts') {

        wp_enqueue_style( "font_type_1",  $url_prepend . '://fonts.googleapis.com/css?family=' . get_option('font_type_1', 'Open+Sans') . ':400italic,400,600,700,300&subset=latin,latin-ext');
    } else {
        wp_enqueue_style( "font_type_1",  $url_prepend . '://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700,300&subset=latin,latin-ext');      
    }
        
    if ( get_option('font_source_2') && get_option('font_source_2')=='Google fonts') {
        wp_enqueue_style( "font_type_2",  $url_prepend . '://fonts.googleapis.com/css?family=' . get_option('font_type_2', 'Open+Sans') . ':400italic,400,600,700,300&subset=latin,latin-ext');
    }
    
    if ( get_option('font_source_3') && get_option('font_source_3')=='Google fonts') {
        wp_enqueue_style( "font_type_3",  $url_prepend . '://fonts.googleapis.com/css?family=' . get_option('font_type_3', 'Open+Sans') . ':400italic,400,600,700,300&subset=latin,latin-ext');
    }
    wp_enqueue_style( "theme_custom_style", get_template_directory_uri() . "/includes/custom-styles.php" );
    wp_enqueue_style( "theme_main_style", get_bloginfo( 'stylesheet_url' ) );
    wp_enqueue_style( "custom", get_template_directory_uri() . '/custom.css' );
    wp_enqueue_style( "prettyPhoto", get_template_directory_uri() . '/css/prettyPhoto.css' );
    $responsive = "";
    if (isset($options_data['responsive'])) {
        $responsive = $options_data['responsive'];
    }
    wp_register_style('bra_photostream', get_template_directory_uri() . "/anps-framework/photostream/bra_photostream_widget.css");
    wp_enqueue_style('bra_photostream');

    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        wp_enqueue_style( "woocommerce-theme", get_template_directory_uri() . '/anps-framework/woocommerce/style.css' );
    }
} 

load_theme_textdomain( 'emona', get_template_directory() . '/languages' );

/* Admin only scripts */

function anps_load_custom_wp_admin_scripts($hook) {
    /* Overwrite VC styling */
    wp_enqueue_style( "vc_custom", get_template_directory_uri() . '/css/vc_custom.css' ); 

    if( 'appearance_page_theme_options' != $hook ) {
        return;
    }

    /* Theme Options Style */
    wp_enqueue_style( "admin-style", get_template_directory_uri() . '/anps-framework/css/admin-style.css' ); 
    if(!isset($_GET['sub_page']) || $_GET['sub_page'] == "theme_style" || $_GET['sub_page'] == "options")
        wp_enqueue_style( "colorpicker", get_template_directory_uri() . '/anps-framework/css/colorpicker.css' ); 
    wp_enqueue_script( "jquery_google", "//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" );
    if (isset($_GET['sub_page']) && ($_GET['sub_page'] == "options" || $_GET['sub_page'] == "options_page"))
        wp_enqueue_script( "pattern", get_template_directory_uri() . "/anps-framework/js/pattern.js" );
    if(!isset($_GET['sub_page']) || $_GET['sub_page'] == "theme_style" || $_GET['sub_page'] == "options") { 
        wp_enqueue_script( "colorpicker_theme", get_template_directory_uri() . "/anps-framework/js/colorpicker.js" ); 
        wp_enqueue_script( "colorpicker_custom", get_template_directory_uri() . "/anps-framework/js/colorpicker_custom.js" ); 
    }
    if (isset($_GET['sub_page']) && $_GET['sub_page'] == "contact_form") 
        wp_enqueue_script( "contact", get_template_directory_uri() . "/anps-framework/js/contact.js" ); 
    wp_enqueue_script( "theme-options", get_template_directory_uri() . "/anps-framework/js/theme-options.js" ); 
}
add_action( 'admin_enqueue_scripts', 'anps_load_custom_wp_admin_scripts' );