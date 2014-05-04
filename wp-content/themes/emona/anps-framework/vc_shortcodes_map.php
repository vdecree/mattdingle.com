<?php
/* Shortcodes */
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
    $image_bg='';
    $style='';
    if($image) {
        $image_bg = $image;
        $style = "background-image: url('$image_bg');";
    } elseif($image_u) {
        $image_attributes = wp_get_attachment_image_src( $image_u, 'full' );
        $image_bg = $image_attributes[0];
        $style = "background-image: url('$image_bg');";
    } elseif($color) {
        $style = "background-color: $color;";
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
                'image_u' => '',
                'color' => '',
                'slug' => ''
	), $atts ) );
    global $anps_parallax_slug; 
    $parallax_class = "";
    if($parallax=="true") {
        $parallax_class = " parallax";
        $parallax_id = "id='$slug'";
        $anps_parallax_slug[] = $slug;
    } 
    $image_bg='';
    if($image) {
        $image_bg = $image;
    } elseif($image_u) {
        $image_attributes = wp_get_attachment_image_src( $image_u, 'full' );
        $image_bg = $image_attributes[0];
    }
    if (!empty($_SERVER['HTTPS'])) {
        $image = str_replace('http:', 'https:', $image);
        $image_bg =  str_replace('http:', 'https:', $image_bg);
    }
    $parallax_overlay_class = "";
    if($parallax_overlay=="true") {
        $parallax_overlay_class = " parallax-overlay";
    } 
    
    $style = '';
    if($image) {
        $style = "background-image: url('$image_bg');";
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
class WPBakeryShortCode_logos extends WPBakeryShortCodesContainer {
    function __construct() {}
    public function anps_logos_func( $atts,  $content ) { 
        return "<ul class='logos'>".do_shortcode($content)."</ul>";
    }
} 
add_shortcode('logos', array('WPBakeryShortCode_logos','anps_logos_func'));
/* END Logos */
/* Logo */
class WPBakeryShortCode_anps_logo extends WPBakeryShortCode {
    function __construct() {}
    function anps_logo_func( $atts,  $content ) { 
        extract( shortcode_atts( array(
            'url' => '',
            'image_u' => '',
            'alt' => ''
        ), $atts ) ); 
        $image_bg='';
        if($content) {
            $image_bg = $content;
        } elseif($image_u) {
            $image_attributes = wp_get_attachment_image_src( $image_u, 'full' );
            $image_bg = $image_attributes[0];
        }
        
        if($url) {
            return "<li><a href='".$url."' target='_blank'><img src='".$image_bg."' alt='".$alt."'></a></li>";
        } else {
            return "<li><span><img src='".$image_bg."' alt='".$alt."'></span></li>";
        }
    }
}
add_shortcode('logo', array('WPBakeryShortCode_anps_logo','anps_logo_func'));
/* END Logo */
/* Contact info */
class WPBakeryShortCode_contact_info extends WPBakeryShortCodesContainer {
    function __construct() {}
    function contact_info_func( $atts,  $content ) {
        extract( shortcode_atts( array( 
            'parallax' => 'false',
            'parallax_overlay' => 'false',
            'color' => '',
            'image' => '',
            'slug' => 'contact_info'
        ), $atts ) );
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
        if (!empty($_SERVER['HTTPS'])) {
            $image = str_replace('http:', 'https:', $image);
        }
        if($image) {
            $image_bg = $image;
            $style = "background-image: url('$image_bg');";            
        } elseif($image_u) {
            $image_attributes = wp_get_attachment_image_src( $image_u, 'full' );
            $image_bg = $image_attributes[0]; 
            $style = "background-image: url('$image_bg');";
        } elseif($color) {
            $style = "background-color: $color;";
        }
        $contact_data = '<div '.$parallax_id.' class="contact-info'.$parallax_class.$parallax_overlay_class.'" style="'.$style.'">';
        $contact_data .= do_shortcode($content);
        $contact_data .= "</div>";    
        return $contact_data;
    }
}
add_shortcode('contact_info', array('WPBakeryShortCode_contact_info','contact_info_func'));
/* END Contact info */
/* Statement */
class WPBakeryShortCode_statement extends WPBakeryShortCodesContainer {
    function __construct(){}
    function statement_func( $atts,  $content ) {
        extract( shortcode_atts( array( 
            'parallax' => 'false',
            'parallax_overlay' => 'false',
            'image' => '',
            'image_u' => '',
            'color' => '',
            'slug' => ''
        ), $atts ) );
        global $anps_parallax_slug;
        $container_class = "";
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
            $image_bg = $image;
            $style = "background-image: url('$image_bg');";
        } elseif($image_u) {
            $image_attributes = wp_get_attachment_image_src( $image_u, 'full' );
            $image_bg = $image_attributes[0];
            $style = "background-image: url('$image_bg');";
        } elseif($color) {
            $style = "background-color: $color;";
        } 
        return '<section '.$parallax_id.' class="statement'.$parallax_class.$parallax_overlay_class.$container_class.'" style="'.$style.'">'.do_shortcode($content).'</section>';
    }
}
add_shortcode('statement',array('WPBakeryShortCode_statement','statement_func'));
/* END Statement */
/* Icon group */
class WPBakeryShortCode_icon_group extends WPBakeryShortCodesContainer {
    function __construct() {}
    function anps_icon_group_func( $atts,  $content ) { 
        extract( shortcode_atts( array(), $atts ) );
        return '<div class="icon-group">' . do_shortcode($content) . '</div>';
    }
}
add_shortcode('icon_group', array('WPBakeryShortCode_icon_group','anps_icon_group_func'));
/* END Icon group */
/* Tabs */
global $tabs_first;
$tabs_counter = 0;
$indiv_tab_counter = 0;
class WPBakeryShortCode_tabs extends WPBakeryShortCodesContainer {
    function __construct() {}
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
}
add_shortcode('tabs', array('WPBakeryShortCode_tabs','tabs_func'));
/* END Tabs */
/* Tab */
$tabs_first = true;
$tabs_single = 0;
class WPBakeryShortCode_tab extends WPBakeryShortCodesContainer {
    function __construct() {}
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
}
add_shortcode('tab', array('WPBakeryShortCode_tab','tab_func'));
/* END Tab */
/* Accordion */
global $accordion_opened;
$accordion_counter = 0;
$accordion_opened = false;
class WPBakeryShortCode_accordion extends WPBakeryShortCodesContainer {
    function __construct(){}
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
}
add_shortcode('accordion', array('WPBakeryShortCode_accordion','accordion_func'));
/* END Accordion */
/* Accordion item */
$accordion_item_counter = 0;
class WPBakeryShortCode_accordion_item extends WPBakeryShortCodesContainer {
    function __construct(){}
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
}
add_shortcode('accordion_item', array('WPBakeryShortCode_accordion_item','accordion_item_func'));
/* END Accordion item */
/* Services */
class WPBakeryShortCode_services extends WPBakeryShortCodesContainer {
    function __construct(){}
    function services_func( $atts,  $content ) {   
        $services_data = "<div class='services'>";
        $services_data .= "<ul>".do_shortcode($content)."</ul></div>";
        strip_tags($services_data,"<p></p>");
        return $services_data;
    }
}
add_shortcode('services', array('WPBakeryShortCode_services','services_func'));
/* END Services */
/* Service */
class WPBakeryShortCode_service extends WPBakeryShortCodesContainer {
    function __construct(){}
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
}
add_shortcode('service', array('WPBakeryShortCode_service','service_func'));
/* END Service */
/* Section */
class WPBakeryShortCode_section extends WPBakeryShortCodesContainer {
    function __construct() {}
    function anps_section_func($atts, $content) {
        extract( shortcode_atts( array(
                    'slug' => ''
            ), $atts ) );
        if($slug) {
            $id_section = "id='$slug'";
        }
        return "<section $id_section class='container'>".do_shortcode($content)."</section>";
    }
}
add_shortcode("section", array("WPBakeryShortCode_section","anps_section_func"));
/* END Section */
/* Contact */
class WPBakeryShortCode_contact extends WPBakeryShortCodesContainer {
    function __construct(){}
    function anps_contact_func($atts, $content) { 
        extract( shortcode_atts( array(
		'email_to' => '',
                'success_msg' => 'Message sucessfuly sent!',
                'error_text' => 'Please insert only letters',
                'error_number' => 'Please insert numbers only',
                'error_email' => 'Please insert a valid email',
                'error_phone' => 'Please insert a valid phone number',
                'error_required' => 'This element is required',
                'email_from' => '',
                'subject' =>'This is an awesome email!'
	), $atts ) );
    
    $contact_data = "<form method='post' data-subject='".$subject."' data-from='".$email_from."' data-required='".$error_required."' data-email='".$error_email."' data-number='".$error_number."' data-text='".$error_text."' data-success='" . $success_msg . "' data-to='".$email_to."'>";
    $contact_data .= do_shortcode($content);
    $contact_data .= "</form>";
    return $contact_data; 
    }
}
add_shortcode("contact", array("WPBakeryShortCode_contact","anps_contact_func"));
/* END Contact */
/* Contact item */
class WPBakeryShortCode_Contact_Item extends WPBakeryShortCodesContainer {
    function __construct() {}
    function anps_contact_item_func($atts, $content) {
        extract( shortcode_atts( array(
                    'type' => 'text',
                    'rows' => '5',
                    'required' => 'false',
                    'placeholder' => '',
                    'validation' => 'none'
            ), $atts ) );
        if($required=="true") {
            $required_data = ' data-required="required"';
        } else {
            $required_data = "";
        }
        $name_input = $placeholder;
        if($type=="text") {
            $input_type = '<input type="text" placeholder="'.$placeholder.'" name="'.$name_input.'" data-validation="'.$validation.'"'.$required_data.'>';
        } elseif ($type=="textarea") {
            $input_type = '<textarea rows="'.$rows.'" placeholder="'.$placeholder.'" name="'.$name_input.'" data-validation="'.$validation.'"'.$required_data.'></textarea>';
        } elseif($type=="dropdown") {
            $dropdown_items = explode(",", $content);
            $input_type = "<select name='".$name_input."'".$required_data.">";
            foreach($dropdown_items as $item) {
                $input_type .= "<option value='".$item."'>".$item."</option>";
            }
            $input_type .= "<select>";
        } elseif($type=="checkbox") {
            $input_type = "<input type='checkbox' id='".$name_input."' name='".$name_input."' />";
            $input_type .= "<label for='".$name_input."'>".$content."</label>";
        } elseif($type=="radio") {
            $radio_items = explode(",", $content);
            $input_type = "";
            $j=0;
            foreach($radio_items as $item) {
                $input_type .= "<input type='radio' name='".$name_input."' id='".$name_input.$j."' />";
                $input_type .= "<label for='".$name_input.$j."'>".$item."</label>";
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
}
add_shortcode("form_item", array("WPBakeryShortCode_Contact_Item","anps_contact_item_func"));
/* END Contact item */
/* Contact button */
class WPBakeryShortCode_anps_contact_button extends WPBakeryShortCode {
    function __construct(){}
    function anps_contact_button_func($atts, $content) { 
        return "<div class='col-md-6'><button data-form='clear' class='btn-style-1 btn-lg'>".__("Clear", ANPS_TEMPLATE_LANG)."</button></div>
                <div class='col-md-6'><button data-form='submit' class='btn-style-1 btn-lg'>".__("Submit", ANPS_TEMPLATE_LANG)."</button></div>";
    }
}
add_shortcode("contact_button", array("WPBakeryShortCode_anps_contact_button","anps_contact_button_func"));
/* END Contact button */
/* END Shortcodes */
/* Remove Default VC values */
$vc_values = array(
    //'vc_row', REQUIRED!
    //'vc_column_text',
    'vc_separator',
    'vc_text_separator',
    'vc_message',
    'vc_facebook',
    'vc_tweetmeme',
    'vc_googleplus',
    'vc_pinterest',
    'vc_toggle',
    'vc_single_image',
    'vc_gallery',
    'vc_images_carousel',
    //'vc_tabs',
    'vc_button2',
    'vc_cta_button2',
    'vc_tour',
    'vc_accordion',
    'vc_posts_grid',
    'vc_carousel',
    'vc_posts_slider',
    'vc_widget_sidebar',
    'vc_button',
    'vc_cta_button',
    'vc_video',
    'vc_gmaps',
    //'vc_raw_html',
    'vc_raw_js',
    'vc_flickr',
    'vc_progress_bar',
    'vc_pie',
    /* 3rd Party Plugins */
    //'layerslider_vc',
    'rev_slider_vc',
    /* WordPress Widgets */
    'vc_wp_search',
    'vc_wp_meta',
    'vc_wp_recentcomments',
    'vc_wp_calendar',
    'vc_wp_pages',
    'vc_wp_tagcloud',
    'vc_wp_custommenu',
    'vc_wp_text',
    'vc_wp_posts',
    'vc_wp_links',
    'vc_wp_categories',
    'vc_wp_archives',
    'vc_wp_rss'
);
foreach ($vc_values as $vc_value) {
    vc_remove_element($vc_value);
}
/* Blog categories new parameter */
function blog_categories_settings_field($settings, $value) {    
    $dependency = vc_generate_dependencies_attributes($settings);
    $blog_data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    $blog_data .= '<option class="0">'.__("All", ANPS_TEMPLATE_LANG).'</option>';
    foreach(get_categories() as $val) {
        $selected = '';
        if ($value!=='' && $val->cat_ID === $value) {
             $selected = ' selected="selected"';
        }
        $blog_data .= '<option class="'.$val->cat_ID.'" value="'.$val->cat_ID.'"'.$selected.'>'.$val->name.'</option>';
    }
    $blog_data .= '</select>';
    return $blog_data;
}
add_shortcode_param('blog_categories' , 'blog_categories_settings_field');
/* Portfolio categories new parameter */
function portfolio_categories_settings_field($settings, $value) {   
    $categories = get_terms('portfolio_category');
    $dependency = vc_generate_dependencies_attributes($settings);
    $data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    $data .= '<option class="0">'.__("All", ANPS_TEMPLATE_LANG).'</option>';
    foreach($categories as $val) {
        $selected = '';
        if ($value!=='' && $val->term_id === $value) {
             $selected = ' selected="selected"';
        }
        $data .= '<option class="'.$val->term_id.'" value="'.$val->term_id.'"'.$selected.'>'.$val->name.'</option>';
    }
    $data .= '</select>';
    return $data;
}
add_shortcode_param('portfolio_categories' , 'portfolio_categories_settings_field');
/* All pages new parameter */
function all_pages_settings_field($settings, $value) {   
    $dependency = vc_generate_dependencies_attributes($settings);
    $data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    foreach(get_pages() as $val) {
        $selected = '';
        if ($value!=='' && $val->ID === $value) {
             $selected = ' selected="selected"';
        }
        $data .= '<option class="'.$val->ID.'" value="'.$val->ID.'"'.$selected.'>'.$val->post_title.'</option>';
    }
    $data .= '</select>';
    return $data;
}
add_shortcode_param('all_pages' , 'all_pages_settings_field');
/* VC Blog */
vc_map( array(
   "name" => __("Blog", ANPS_TEMPLATE_LANG),
   "base" => "blog",
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "icon" => "icon-wpb-blog", 
   "params" => array(
      array(
         "type" => "blog_categories",
         "holder" => "div",
         "heading" => __("Blog categories", ANPS_TEMPLATE_LANG),
         "param_name" => "category",
         "description" => __("Select blog categories.", ANPS_TEMPLATE_LANG)
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Posts per page", ANPS_TEMPLATE_LANG),
         "param_name" => "content",
         "description" => __("Enter post per page.", ANPS_TEMPLATE_LANG)
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Order By", ANPS_TEMPLATE_LANG),
         "param_name" => "orderby",
         "value" => array(__("Default", ANPS_TEMPLATE_LANG)=>'', __("Date", ANPS_TEMPLATE_LANG)=>'date', __("Id", ANPS_TEMPLATE_LANG)=>'ID', __("Title", ANPS_TEMPLATE_LANG)=>'title', __("Name", ANPS_TEMPLATE_LANG)=>'name', __("Author", ANPS_TEMPLATE_LANG)=>'author'), 
         "description" => __("Enter parallax.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Order", ANPS_TEMPLATE_LANG),
         "param_name" => "order",
         "value" => array(__("Default", ANPS_TEMPLATE_LANG)=>'', __("ASC", ANPS_TEMPLATE_LANG)=>'ASC', __("DESC", ANPS_TEMPLATE_LANG)=>'DESC')
       )
    )
) );
/* END VC Blog */
/* VC Portfolio */
vc_map( array(
   "name" => __("Portfolio", ANPS_TEMPLATE_LANG),
   "base" => "portfolio",
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "icon" => "icon-wpb-portfolio", 
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Heading", ANPS_TEMPLATE_LANG),
         "param_name" => "heading",
         "description" => __("Enter portfolio featured heading.", ANPS_TEMPLATE_LANG)
      ), 
      array(
         "type" => "portfolio_categories",
         "holder" => "div",
         "heading" => __("Portfolio categories", ANPS_TEMPLATE_LANG),
         "param_name" => "category",
         "description" => __("Select portfolio categories.", ANPS_TEMPLATE_LANG)
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Filter", ANPS_TEMPLATE_LANG),
         "param_name" => "filter",
         "value" => array(__("On", ANPS_TEMPLATE_LANG)=>'on', __("Off", ANPS_TEMPLATE_LANG)=>'off')
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Order By", ANPS_TEMPLATE_LANG),
         "param_name" => "orderby",
         "value" => array(__("Default", ANPS_TEMPLATE_LANG)=>'', __("Id", ANPS_TEMPLATE_LANG)=>'id'), 
         "description" => __("Enter parallax.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Order", ANPS_TEMPLATE_LANG),
         "param_name" => "order",
         "value" => array(__("Default", ANPS_TEMPLATE_LANG)=>'', __("ASC", ANPS_TEMPLATE_LANG)=>'ASC', __("DESC", ANPS_TEMPLATE_LANG)=>'DESC')
       )
    )
));
/* END VC Portfolio */
/* VC team */
vc_map( array(
   "name" => __("Team", ANPS_TEMPLATE_LANG),
   "base" => "team",
   "class" => "",
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "icon" => "icon-wpb-team", 
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Heading", ANPS_TEMPLATE_LANG),
         "param_name" => "heading",
         "value" => "Team", 
         "description" => __("Enter heading.", ANPS_TEMPLATE_LANG)
      ) 
       )
) );
/* END VC team */
/* VC recent blog */
vc_map( array(
   "name" => __("Recent blog", ANPS_TEMPLATE_LANG),
   "base" => "recent_blog",
   "class" => "",
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "icon" => "icon-wpb-recent_blog", 
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number of blog posts", ANPS_TEMPLATE_LANG),
         "param_name" => "number",
         "value" => "4", 
         "description" => __("Enter number of recent blog posts.", ANPS_TEMPLATE_LANG)
      ) 
       )
) );
/* END VC recent blog */
/* VC twitter */
vc_map( array(
   "name" => __("Twitter", ANPS_TEMPLATE_LANG),
   "base" => "twitter",
   "class" => "",
   "icon" => "icon-wpb-twitter", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Slug", ANPS_TEMPLATE_LANG),
         "param_name" => "slug",
         "description" => __("This is used for both for none page navigation and the parallax effect (if you do not have the navigation need you enter a unique slug if you want parallax effect to function)", ANPS_TEMPLATE_LANG)  
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", ANPS_TEMPLATE_LANG),
         "param_name" => "title",
         "value" => "Stay tuned, follow us on Twitter", 
         "description" => __("Enter twitter title.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Parallax", ANPS_TEMPLATE_LANG),
         "param_name" => "parallax",
         "value" => array(__("False", ANPS_TEMPLATE_LANG)=>'false', __("True", ANPS_TEMPLATE_LANG)=>'true'), 
         "description" => __("Enter parallax.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Parallax overlay", ANPS_TEMPLATE_LANG),
         "param_name" => "parallax_overlay",
         "value" => array(__("False", ANPS_TEMPLATE_LANG)=>'', __("True", ANPS_TEMPLATE_LANG)=>'true'), 
         "description" => __("Parallax overlay.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Background image url", ANPS_TEMPLATE_LANG),
         "param_name" => "image",
         "description" => __("Enter background image url.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "attach_image",
         "holder" => "div",
         "heading" => __("Background image", ANPS_TEMPLATE_LANG),
         "param_name" => "image_u"
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Background color", ANPS_TEMPLATE_LANG),
         "param_name" => "color",
         "value" => "", 
         "description" => __("Background color.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Twitter username", ANPS_TEMPLATE_LANG),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter twitter username.", ANPS_TEMPLATE_LANG)
      )
       )
) );
/* END VC twitter */
/* VC Contact */
vc_map( array(
    "name" => __("Contact", ANPS_TEMPLATE_LANG),
    "base" => "contact",
    "content_element" => true,
    "show_settings_on_create" => true,
    "icon" => "icon-wpb-contact",
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Email to", ANPS_TEMPLATE_LANG),
            "param_name" => "email_to",
            "description" => __("Email to.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Email from", ANPS_TEMPLATE_LANG),
            "param_name" => "email_from",
            "description" => __("Email from.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Subject", ANPS_TEMPLATE_LANG),
            "param_name" => "subject",
            "value" => "This is an awesome email!"
        ),
        array(
            "type" => "textfield",
            "heading" => __("Success message", ANPS_TEMPLATE_LANG),
            "param_name" => "success_msg",
            "value" => "Message sucessfuly sent!"
        ),
        array(
            "type" => "textfield",
            "heading" => __("Error text", ANPS_TEMPLATE_LANG),
            "param_name" => "error_text",
            "value" => "Please insert only letters",
            "description" => __("Error text message.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Error number", ANPS_TEMPLATE_LANG),
            "param_name" => "error_number",
            "value" => "Please insert numbers only",
            "description" => __("Error number message.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Error email", ANPS_TEMPLATE_LANG),
            "param_name" => "error_email",
            "value" => "Please insert a valid email",
            "description" => __("Error email message.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Error phone", ANPS_TEMPLATE_LANG),
            "param_name" => "error_phone",
            "value" => "Please insert a valid phone number",
            "description" => __("Error phone number message.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Error required", ANPS_TEMPLATE_LANG),
            "param_name" => "error_required",
            "value" => "This element is required",
            "description" => __("Error required message.", ANPS_TEMPLATE_LANG)
        )
    ),
    "js_view" => 'VcColumnView'
) );
/* VC END Contact */
/* VC Contact item */
vc_map( array(
    "name" => __("Contact item", ANPS_TEMPLATE_LANG),
    "base" => "form_item",
    "content_element" => true,
    "icon" => "icon-wpb-contact",
    //"as_child" => array('only' => 'contact'),
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => __("Type", ANPS_TEMPLATE_LANG),
            "param_name" => "type",
            "value" => array(__("Text", ANPS_TEMPLATE_LANG)=>'text', __("Textarea", ANPS_TEMPLATE_LANG)=>'textarea', __("Dropdown", ANPS_TEMPLATE_LANG)=>'dropdown', __("Checkbox", ANPS_TEMPLATE_LANG)=>'checkbox', __("Radio", ANPS_TEMPLATE_LANG)=>'radio', __("Captcha", ANPS_TEMPLATE_LANG)=>'captcha'),
            "description" => __("Input type.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Required", ANPS_TEMPLATE_LANG),
            "param_name" => "required",
            "value" => array(__("False", ANPS_TEMPLATE_LANG)=>'false', __("True", ANPS_TEMPLATE_LANG)=>'true')
       ),
       array(
            "type" => "textfield",
            "heading" => __("Placeholder", ANPS_TEMPLATE_LANG),
            "param_name" => "placeholder"
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Validation", ANPS_TEMPLATE_LANG),
            "param_name" => "validation",
            "value" => array(__("None", ANPS_TEMPLATE_LANG)=>'none', __("Text", ANPS_TEMPLATE_LANG)=>'text', __("Number", ANPS_TEMPLATE_LANG)=>'number', __("Email", ANPS_TEMPLATE_LANG)=>'email', __("Phone", ANPS_TEMPLATE_LANG)=>'phone'),
            "description" => __("Contact form validation.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Rows", ANPS_TEMPLATE_LANG),
            "param_name" => "rows",
            "value" => "5",
            "description" => __("Textarea input field rows.", ANPS_TEMPLATE_LANG)
        ),
     )
) );
/* VC END Contact item */
/* VC Contact button */
vc_map( array(
    "name" => __("Contact button", ANPS_TEMPLATE_LANG),
    "base" => "contact_button",
    "content_element" => true,
    "icon" => "icon-wpb-contact",
    "show_settings_on_create" => false
) );
/* VC END Contact button */
/* VC progress */
vc_map( array(
   "name" => __("Progress", ANPS_TEMPLATE_LANG),
   "base" => "progress",
   "class" => "",
   "icon" => "icon-wpb-progress", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Progress procent", ANPS_TEMPLATE_LANG),
         "param_name" => "procent",
         "value" => "", 
         "description" => __("Enter progress procent.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Progress title", ANPS_TEMPLATE_LANG),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter progress title.", ANPS_TEMPLATE_LANG)
      )
       )
) );
/* END VC progress */
/* VC icon */
vc_map( array(
   "name" => __("Icon", ANPS_TEMPLATE_LANG),
   "base" => "icon",
   "icon" => "icon-wpb-icon", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Text", ANPS_TEMPLATE_LANG),
         "param_name" => "content"
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Title", ANPS_TEMPLATE_LANG),
         "param_name" => "title"
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Link", ANPS_TEMPLATE_LANG),
         "param_name" => "link"
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Target", ANPS_TEMPLATE_LANG),
         "param_name" => "target",
         "value" => "_self"
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Icon", ANPS_TEMPLATE_LANG),
         "param_name" => "icon",
         "value" => array(__("", ANPS_TEMPLATE_LANG)=>'', 
        __("adjust", ANPS_TEMPLATE_LANG)=>"adjust",
__("align-center", ANPS_TEMPLATE_LANG)=>"align-center",
__("align-justify", ANPS_TEMPLATE_LANG)=>"align-justify",
__("align-left", ANPS_TEMPLATE_LANG)=>"align-left",
__("align-right", ANPS_TEMPLATE_LANG)=>"align-right",
__("arrow-down", ANPS_TEMPLATE_LANG)=>"arrow-down",
__("arrow-left", ANPS_TEMPLATE_LANG)=>"arrow-left",
__("arrow-right", ANPS_TEMPLATE_LANG)=>"arrow-right",
__("arrow-up", ANPS_TEMPLATE_LANG)=>"arrow-up",
__("asterisk", ANPS_TEMPLATE_LANG)=>"asterisk",
__("backward", ANPS_TEMPLATE_LANG)=>"backward",
__("ban-circle", ANPS_TEMPLATE_LANG)=>"ban-circle",
__("barcode", ANPS_TEMPLATE_LANG)=>"barcode",
__("bell", ANPS_TEMPLATE_LANG)=>"bell",
__("bold", ANPS_TEMPLATE_LANG)=>"bold",
__("book", ANPS_TEMPLATE_LANG)=>"book",
__("bookmark", ANPS_TEMPLATE_LANG)=>"bookmark",
__("briefcase", ANPS_TEMPLATE_LANG)=>"briefcase",
__("bullhorn", ANPS_TEMPLATE_LANG)=>"bullhorn",
__("calendar", ANPS_TEMPLATE_LANG)=>"calendar",
__("camera", ANPS_TEMPLATE_LANG)=>"camera",
__("certificate", ANPS_TEMPLATE_LANG)=>"certificate",
__("check", ANPS_TEMPLATE_LANG)=>"check",
__("chevron-down", ANPS_TEMPLATE_LANG)=>"chevron-down",
__("chevron-left", ANPS_TEMPLATE_LANG)=>"chevron-left",
__("chevron-right", ANPS_TEMPLATE_LANG)=>"chevron-right",
__("chevron-up", ANPS_TEMPLATE_LANG)=>"chevron-up",
__("circle-arrow-down", ANPS_TEMPLATE_LANG)=>"circle-arrow-down",
__("circle-arrow-left", ANPS_TEMPLATE_LANG)=>"circle-arrow-left",
__("circle-arrow-right", ANPS_TEMPLATE_LANG)=>"circle-arrow-right",
__("circle-arrow-up", ANPS_TEMPLATE_LANG)=>"circle-arrow-up",
__("cloud", ANPS_TEMPLATE_LANG)=>"cloud",
__("cloud-download", ANPS_TEMPLATE_LANG)=>"cloud-download",
__("cloud-upload", ANPS_TEMPLATE_LANG)=>"cloud-upload",
__("cog", ANPS_TEMPLATE_LANG)=>"cog",
__("collapse-down", ANPS_TEMPLATE_LANG)=>"collapse-down",
__("collapse-up", ANPS_TEMPLATE_LANG)=>"collapse-up",
__("comment", ANPS_TEMPLATE_LANG)=>"comment",
__("compressed", ANPS_TEMPLATE_LANG)=>"compressed",
__("copyright-mark", ANPS_TEMPLATE_LANG)=>"copyright-mark",
__("credit-card", ANPS_TEMPLATE_LANG)=>"credit-card",
__("cutlery", ANPS_TEMPLATE_LANG)=>"cutlery",
__("dashboard", ANPS_TEMPLATE_LANG)=>"dashboard",
__("download", ANPS_TEMPLATE_LANG)=>"download",
__("download-alt", ANPS_TEMPLATE_LANG)=>"download-alt",
__("earphone", ANPS_TEMPLATE_LANG)=>"earphone",
__("edit", ANPS_TEMPLATE_LANG)=>"edit",
__("eject", ANPS_TEMPLATE_LANG)=>"eject",
__("envelope", ANPS_TEMPLATE_LANG)=>"envelope",
__("euro", ANPS_TEMPLATE_LANG)=>"euro",
__("exclamation-sign", ANPS_TEMPLATE_LANG)=>"exclamation-sign",
__("expand", ANPS_TEMPLATE_LANG)=>"expand",
__("export", ANPS_TEMPLATE_LANG)=>"export",
__("eye-close", ANPS_TEMPLATE_LANG)=>"eye-close",
__("eye-open", ANPS_TEMPLATE_LANG)=>"eye-open",
__("facetime-video", ANPS_TEMPLATE_LANG)=>"facetime-video",
__("fast-backward", ANPS_TEMPLATE_LANG)=>"fast-backward",
__("fast-forward", ANPS_TEMPLATE_LANG)=>"fast-forward",
__("file", ANPS_TEMPLATE_LANG)=>"file",
__("film", ANPS_TEMPLATE_LANG)=>"film",
__("filter", ANPS_TEMPLATE_LANG)=>"filter",
__("fire", ANPS_TEMPLATE_LANG)=>"fire",
__("flag", ANPS_TEMPLATE_LANG)=>"flag",
__("flash", ANPS_TEMPLATE_LANG)=>"flash",
__("floppy-disk", ANPS_TEMPLATE_LANG)=>"floppy-disk",
__("floppy-open", ANPS_TEMPLATE_LANG)=>"floppy-open",
__("floppy-remove", ANPS_TEMPLATE_LANG)=>"floppy-remove",
__("floppy-save", ANPS_TEMPLATE_LANG)=>"floppy-save",
__("floppy-saved", ANPS_TEMPLATE_LANG)=>"floppy-saved",
__("folder-close", ANPS_TEMPLATE_LANG)=>"folder-close",
__("folder-open", ANPS_TEMPLATE_LANG)=>"folder-open",
__("font", ANPS_TEMPLATE_LANG)=>"font",
__("forward", ANPS_TEMPLATE_LANG)=>"forward",
__("fullscreen", ANPS_TEMPLATE_LANG)=>"fullscreen",
__("gbp", ANPS_TEMPLATE_LANG)=>"gbp",
__("gift", ANPS_TEMPLATE_LANG)=>"gift",
__("glass", ANPS_TEMPLATE_LANG)=>"glass",
__("globe", ANPS_TEMPLATE_LANG)=>"globe",
__("hand-down", ANPS_TEMPLATE_LANG)=>"hand-down",
__("hand-left", ANPS_TEMPLATE_LANG)=>"hand-left",
__("hand-right", ANPS_TEMPLATE_LANG)=>"hand-right",
__("hand-up", ANPS_TEMPLATE_LANG)=>"hand-up",
__("hd-video", ANPS_TEMPLATE_LANG)=>"hd-video",
__("hdd", ANPS_TEMPLATE_LANG)=>"hdd",
__("header", ANPS_TEMPLATE_LANG)=>"header",
__("headphones", ANPS_TEMPLATE_LANG)=>"headphones",
__("heart", ANPS_TEMPLATE_LANG)=>"heart",
__("heart-empty", ANPS_TEMPLATE_LANG)=>"heart-empty",
__("home", ANPS_TEMPLATE_LANG)=>"home",
__("import", ANPS_TEMPLATE_LANG)=>"import",
__("inbox", ANPS_TEMPLATE_LANG)=>"inbox",
__("indent-left", ANPS_TEMPLATE_LANG)=>"indent-left",
__("indent-right", ANPS_TEMPLATE_LANG)=>"indent-right",
__("info-sign", ANPS_TEMPLATE_LANG)=>"info-sign",
__("italic", ANPS_TEMPLATE_LANG)=>"italic",
__("leaf", ANPS_TEMPLATE_LANG)=>"leaf",
__("link", ANPS_TEMPLATE_LANG)=>"link",
__("list", ANPS_TEMPLATE_LANG)=>"list",
__("list-alt", ANPS_TEMPLATE_LANG)=>"list-alt",
__("lock", ANPS_TEMPLATE_LANG)=>"lock",
__("log-in", ANPS_TEMPLATE_LANG)=>"log-in",
__("log-out", ANPS_TEMPLATE_LANG)=>"log-out",
__("magnet", ANPS_TEMPLATE_LANG)=>"magnet",
__("map-marker", ANPS_TEMPLATE_LANG)=>"map-marker",
__("minus", ANPS_TEMPLATE_LANG)=>"minus",
__("minus-sign", ANPS_TEMPLATE_LANG)=>"minus-sign",
__("emona", ANPS_TEMPLATE_LANG)=>"emona",
__("music", ANPS_TEMPLATE_LANG)=>"music",
__("new-window", ANPS_TEMPLATE_LANG)=>"new-window",
__("off", ANPS_TEMPLATE_LANG)=>"off",
__("ok", ANPS_TEMPLATE_LANG)=>"ok",
__("ok-circle", ANPS_TEMPLATE_LANG)=>"ok-circle",
__("ok-sign", ANPS_TEMPLATE_LANG)=>"ok-sign",
__("open", ANPS_TEMPLATE_LANG)=>"open",
__("paperclip", ANPS_TEMPLATE_LANG)=>"paperclip",
__("pause", ANPS_TEMPLATE_LANG)=>"pause",
__("pencil", ANPS_TEMPLATE_LANG)=>"pencil",
__("phone", ANPS_TEMPLATE_LANG)=>"phone",
__("phone-alt", ANPS_TEMPLATE_LANG)=>"phone-alt",
__("picture", ANPS_TEMPLATE_LANG)=>"picture",
__("plane", ANPS_TEMPLATE_LANG)=>"plane",
__("play", ANPS_TEMPLATE_LANG)=>"play",
__("play-circle", ANPS_TEMPLATE_LANG)=>"play-circle",
__("plus", ANPS_TEMPLATE_LANG)=>"plus",
__("plus-sign", ANPS_TEMPLATE_LANG)=>"plus-sign",
__("print", ANPS_TEMPLATE_LANG)=>"print",
__("pushpin", ANPS_TEMPLATE_LANG)=>"pushpin",
__("qrcode", ANPS_TEMPLATE_LANG)=>"qrcode",
__("question-sign", ANPS_TEMPLATE_LANG)=>"question-sign",
__("random", ANPS_TEMPLATE_LANG)=>"random",
__("record", ANPS_TEMPLATE_LANG)=>"record",
__("refresh", ANPS_TEMPLATE_LANG)=>"refresh",
__("registration-mark", ANPS_TEMPLATE_LANG)=>"registration-mark",
__("remove", ANPS_TEMPLATE_LANG)=>"remove",
__("remove-circle", ANPS_TEMPLATE_LANG)=>"remove-circle",
__("remove-sign", ANPS_TEMPLATE_LANG)=>"remove-sign",
__("repeat", ANPS_TEMPLATE_LANG)=>"repeat",
__("resize-full", ANPS_TEMPLATE_LANG)=>"resize-full",
__("resize-horizontal", ANPS_TEMPLATE_LANG)=>"resize-horizontal",
__("resize-small", ANPS_TEMPLATE_LANG)=>"resize-small",
__("resize-vertical", ANPS_TEMPLATE_LANG)=>"resize-vertical",
__("retweet", ANPS_TEMPLATE_LANG)=>"retweet",
__("road", ANPS_TEMPLATE_LANG)=>"road",
__("save", ANPS_TEMPLATE_LANG)=>"save",
__("saved", ANPS_TEMPLATE_LANG)=>"saved",
__("screenshot", ANPS_TEMPLATE_LANG)=>"screenshot",
__("sd-video", ANPS_TEMPLATE_LANG)=>"sd-video",
__("search", ANPS_TEMPLATE_LANG)=>"search",
__("send", ANPS_TEMPLATE_LANG)=>"send",
__("share", ANPS_TEMPLATE_LANG)=>"share",
__("share-alt", ANPS_TEMPLATE_LANG)=>"share-alt",
__("shopping-cart", ANPS_TEMPLATE_LANG)=>"shopping-cart",
__("signal", ANPS_TEMPLATE_LANG)=>"signal",
__("sort", ANPS_TEMPLATE_LANG)=>"sort",
__("sort-by-alphabet", ANPS_TEMPLATE_LANG)=>"sort-by-alphabet",
__("sort-by-alphabet-alt", ANPS_TEMPLATE_LANG)=>"sort-by-alphabet-alt",
__("sort-by-attributes", ANPS_TEMPLATE_LANG)=>"sort-by-attributes",
__("sort-by-attributes-alt", ANPS_TEMPLATE_LANG)=>"sort-by-attributes-alt",
__("sort-by-order", ANPS_TEMPLATE_LANG)=>"sort-by-order",
__("sort-by-order-alt", ANPS_TEMPLATE_LANG)=>"sort-by-order-alt",
__("sound-5-1", ANPS_TEMPLATE_LANG)=>"sound-5-1",
__("sound-6-1", ANPS_TEMPLATE_LANG)=>"sound-6-1",
__("sound-7-1", ANPS_TEMPLATE_LANG)=>"sound-7-1",
__("sound-dolby", ANPS_TEMPLATE_LANG)=>"sound-dolby",
__("sound-stereo", ANPS_TEMPLATE_LANG)=>"sound-stereo",
__("star", ANPS_TEMPLATE_LANG)=>"star",
__("star-empty", ANPS_TEMPLATE_LANG)=>"star-empty",
__("stats", ANPS_TEMPLATE_LANG)=>"stats",
__("step-backward", ANPS_TEMPLATE_LANG)=>"step-backward",
__("step-forward", ANPS_TEMPLATE_LANG)=>"step-forward",
__("stop", ANPS_TEMPLATE_LANG)=>"stop",
__("subtitles", ANPS_TEMPLATE_LANG)=>"subtitles",
__("tag", ANPS_TEMPLATE_LANG)=>"tag",
__("tags", ANPS_TEMPLATE_LANG)=>"tags",
__("tasks", ANPS_TEMPLATE_LANG)=>"tasks",
__("text-height", ANPS_TEMPLATE_LANG)=>"text-height",
__("text-width", ANPS_TEMPLATE_LANG)=>"text-width",
__("th", ANPS_TEMPLATE_LANG)=>"th",
__("th-large", ANPS_TEMPLATE_LANG)=>"th-large",
__("th-list", ANPS_TEMPLATE_LANG)=>"th-list",
__("thumbs-down", ANPS_TEMPLATE_LANG)=>"thumbs-down",
__("thumbs-up", ANPS_TEMPLATE_LANG)=>"thumbs-up",
__("time", ANPS_TEMPLATE_LANG)=>"time",
__("tint", ANPS_TEMPLATE_LANG)=>"tint",
__("tower", ANPS_TEMPLATE_LANG)=>"tower",
__("transfer", ANPS_TEMPLATE_LANG)=>"transfer",
__("trash", ANPS_TEMPLATE_LANG)=>"trash",
__("tree-conifer", ANPS_TEMPLATE_LANG)=>"tree-conifer",
__("tree-deciduous", ANPS_TEMPLATE_LANG)=>"tree-deciduous",
__("unchecked", ANPS_TEMPLATE_LANG)=>"unchecked",
__("upload", ANPS_TEMPLATE_LANG)=>"upload",
__("usd", ANPS_TEMPLATE_LANG)=>"usd",
__("user", ANPS_TEMPLATE_LANG)=>"user",
__("volume-down", ANPS_TEMPLATE_LANG)=>"volume-down",
__("volume-off", ANPS_TEMPLATE_LANG)=>"volume-off",
__("volume-up", ANPS_TEMPLATE_LANG)=>"volume-up",
__("warning-sign", ANPS_TEMPLATE_LANG)=>"warning-sign",
__("wrench", ANPS_TEMPLATE_LANG)=>"wrench",
__("zoom-in", ANPS_TEMPLATE_LANG)=>"zoom-in",
__("zoom-out", ANPS_TEMPLATE_LANG)=>"zoom-out")
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Position", ANPS_TEMPLATE_LANG),
         "param_name" => "position"
      ),
   )
) );
/* END VC icon */
/* VC icon group */
vc_map( array(
   "name" => __("Icon group", ANPS_TEMPLATE_LANG),
   "base" => "icon_group",
   "as_parent" => array("only"=>"icon"), 
   "icon" => "icon-wpb-icon_group", 
   "show_settings_on_create" => false, 
   "category" => __('Content', ANPS_TEMPLATE_LANG)
));
/* END VC icon group */
/* VC quote */
vc_map( array(
   "name" => __("Quote", ANPS_TEMPLATE_LANG),
   "base" => "quote",
   "class" => "",
   "icon" => "icon-wpb-quote", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Quote text", ANPS_TEMPLATE_LANG),
         "param_name" => "content"
      )
   )
) );
/* END VC quote */
/* VC statement */
vc_map( array(
   "name" => __("Statement", ANPS_TEMPLATE_LANG),
   "base" => "statement",
   "is_container" => true, 
   "as_parent" => array(), 
   "icon" => "icon-wpb-statement", 
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Slug", ANPS_TEMPLATE_LANG),
         "param_name" => "slug",
         "description" => __("This is used for both for none page navigation and the parallax effect (if you do not have the navigation need you enter a unique slug if you want parallax effect to function)", ANPS_TEMPLATE_LANG)  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Parallax", ANPS_TEMPLATE_LANG),
         "param_name" => "parallax",
         "value" => array(__("False", ANPS_TEMPLATE_LANG)=>'false', __("True", ANPS_TEMPLATE_LANG)=>'true'), 
         "description" => __("Enter parallax.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Parallax overlay", ANPS_TEMPLATE_LANG),
         "param_name" => "parallax_overlay",
         "value" => array(__("False", ANPS_TEMPLATE_LANG)=>'', __("True", ANPS_TEMPLATE_LANG)=>'true'), 
         "description" => __("Parallax overlay.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Background image url", ANPS_TEMPLATE_LANG),
         "param_name" => "image"
       ),
       array(
         "type" => "attach_image",
         "holder" => "div",
         "heading" => __("Background image", ANPS_TEMPLATE_LANG),
         "param_name" => "image_u"
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Background color", ANPS_TEMPLATE_LANG),
         "param_name" => "color",
         "value" => "", 
         "description" => __("Background color.", ANPS_TEMPLATE_LANG)
       )
   )
) );
/* END VC statement */
/* VC Header quote */
vc_map( array(
   "name" => __("Header quote", ANPS_TEMPLATE_LANG),
   "base" => "header_quote",
   "icon" => "icon-wpb-header_quote", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Header quote text", ANPS_TEMPLATE_LANG),
         "param_name" => "content"
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Slug", ANPS_TEMPLATE_LANG),
         "param_name" => "slug",
         "description" => __("This is used for both for none page navigation and the parallax effect (if you do not have the navigation need you enter a unique slug if you want parallax effect to function)", ANPS_TEMPLATE_LANG)  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Parallax", ANPS_TEMPLATE_LANG),
         "param_name" => "parallax",
         "value" => array(__("False", ANPS_TEMPLATE_LANG)=>'false', __("True", ANPS_TEMPLATE_LANG)=>'true'), 
         "description" => __("Enter parallax.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Parallax overlay", ANPS_TEMPLATE_LANG),
         "param_name" => "parallax_overlay",
         "value" => array(__("False", ANPS_TEMPLATE_LANG)=>'', __("True", ANPS_TEMPLATE_LANG)=>'true'), 
         "description" => __("Parallax overlay.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Background image url", ANPS_TEMPLATE_LANG),
         "param_name" => "image"
       ),
       array(
         "type" => "attach_image",
         "holder" => "div",
         "heading" => __("Background image", ANPS_TEMPLATE_LANG),
         "param_name" => "image_u"
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Background color", ANPS_TEMPLATE_LANG),
         "param_name" => "color",
         "value" => "", 
         "description" => __("Background color.", ANPS_TEMPLATE_LANG)
       )
   )
) );
/* END VC Header quote */
/* VC Banner */
vc_map( array(
   "name" => __("Shop banner", ANPS_TEMPLATE_LANG),
   "base" => "shop_banner",
   "icon" => "icon-wpb-shop-banner", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", ANPS_TEMPLATE_LANG),
         "param_name" => "content"
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Link", ANPS_TEMPLATE_LANG),
         "param_name" => "link"
       ),
       array(
         "type" => "attach_image",
         "holder" => "div",
         "heading" => __("Image", ANPS_TEMPLATE_LANG),
         "param_name" => "image_u"
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Image url", ANPS_TEMPLATE_LANG),
         "param_name" => "image"
       )
   )
) );
/* END VC banner */
/* VC glyph */
vc_map( array(
   "name" => __("Glyph icon", ANPS_TEMPLATE_LANG),
   "base" => "glyph",
   "class" => "",
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "icon" => "icon-wpb-glyph", 
   "params" => array(
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Glyph icon", ANPS_TEMPLATE_LANG),
         "param_name" => "content",
         "value" => array(__("", ANPS_TEMPLATE_LANG)=>'', 
        __("adjust", ANPS_TEMPLATE_LANG)=>"adjust",
        __("align-center", ANPS_TEMPLATE_LANG)=>"align-center",
        __("align-justify", ANPS_TEMPLATE_LANG)=>"align-justify",
        __("align-left", ANPS_TEMPLATE_LANG)=>"align-left",
        __("align-right", ANPS_TEMPLATE_LANG)=>"align-right",
        __("arrow-down", ANPS_TEMPLATE_LANG)=>"arrow-down",
        __("arrow-left", ANPS_TEMPLATE_LANG)=>"arrow-left",
        __("arrow-right", ANPS_TEMPLATE_LANG)=>"arrow-right",
        __("arrow-up", ANPS_TEMPLATE_LANG)=>"arrow-up",
        __("asterisk", ANPS_TEMPLATE_LANG)=>"asterisk",
        __("backward", ANPS_TEMPLATE_LANG)=>"backward",
        __("ban-circle", ANPS_TEMPLATE_LANG)=>"ban-circle",
        __("barcode", ANPS_TEMPLATE_LANG)=>"barcode",
        __("bell", ANPS_TEMPLATE_LANG)=>"bell",
        __("bold", ANPS_TEMPLATE_LANG)=>"bold",
        __("book", ANPS_TEMPLATE_LANG)=>"book",
        __("bookmark", ANPS_TEMPLATE_LANG)=>"bookmark",
        __("briefcase", ANPS_TEMPLATE_LANG)=>"briefcase",
        __("bullhorn", ANPS_TEMPLATE_LANG)=>"bullhorn",
        __("calendar", ANPS_TEMPLATE_LANG)=>"calendar",
        __("camera", ANPS_TEMPLATE_LANG)=>"camera",
        __("certificate", ANPS_TEMPLATE_LANG)=>"certificate",
        __("check", ANPS_TEMPLATE_LANG)=>"check",
        __("chevron-down", ANPS_TEMPLATE_LANG)=>"chevron-down",
        __("chevron-left", ANPS_TEMPLATE_LANG)=>"chevron-left",
        __("chevron-right", ANPS_TEMPLATE_LANG)=>"chevron-right",
        __("chevron-up", ANPS_TEMPLATE_LANG)=>"chevron-up",
        __("circle-arrow-down", ANPS_TEMPLATE_LANG)=>"circle-arrow-down",
        __("circle-arrow-left", ANPS_TEMPLATE_LANG)=>"circle-arrow-left",
        __("circle-arrow-right", ANPS_TEMPLATE_LANG)=>"circle-arrow-right",
        __("circle-arrow-up", ANPS_TEMPLATE_LANG)=>"circle-arrow-up",
        __("cloud", ANPS_TEMPLATE_LANG)=>"cloud",
        __("cloud-download", ANPS_TEMPLATE_LANG)=>"cloud-download",
        __("cloud-upload", ANPS_TEMPLATE_LANG)=>"cloud-upload",
        __("cog", ANPS_TEMPLATE_LANG)=>"cog",
        __("collapse-down", ANPS_TEMPLATE_LANG)=>"collapse-down",
        __("collapse-up", ANPS_TEMPLATE_LANG)=>"collapse-up",
        __("comment", ANPS_TEMPLATE_LANG)=>"comment",
        __("compressed", ANPS_TEMPLATE_LANG)=>"compressed",
        __("copyright-mark", ANPS_TEMPLATE_LANG)=>"copyright-mark",
        __("credit-card", ANPS_TEMPLATE_LANG)=>"credit-card",
        __("cutlery", ANPS_TEMPLATE_LANG)=>"cutlery",
        __("dashboard", ANPS_TEMPLATE_LANG)=>"dashboard",
        __("download", ANPS_TEMPLATE_LANG)=>"download",
        __("download-alt", ANPS_TEMPLATE_LANG)=>"download-alt",
        __("earphone", ANPS_TEMPLATE_LANG)=>"earphone",
        __("edit", ANPS_TEMPLATE_LANG)=>"edit",
        __("eject", ANPS_TEMPLATE_LANG)=>"eject",
        __("envelope", ANPS_TEMPLATE_LANG)=>"envelope",
        __("euro", ANPS_TEMPLATE_LANG)=>"euro",
        __("exclamation-sign", ANPS_TEMPLATE_LANG)=>"exclamation-sign",
        __("expand", ANPS_TEMPLATE_LANG)=>"expand",
        __("export", ANPS_TEMPLATE_LANG)=>"export",
        __("eye-close", ANPS_TEMPLATE_LANG)=>"eye-close",
        __("eye-open", ANPS_TEMPLATE_LANG)=>"eye-open",
        __("facetime-video", ANPS_TEMPLATE_LANG)=>"facetime-video",
        __("fast-backward", ANPS_TEMPLATE_LANG)=>"fast-backward",
        __("fast-forward", ANPS_TEMPLATE_LANG)=>"fast-forward",
        __("file", ANPS_TEMPLATE_LANG)=>"file",
        __("film", ANPS_TEMPLATE_LANG)=>"film",
        __("filter", ANPS_TEMPLATE_LANG)=>"filter",
        __("fire", ANPS_TEMPLATE_LANG)=>"fire",
        __("flag", ANPS_TEMPLATE_LANG)=>"flag",
        __("flash", ANPS_TEMPLATE_LANG)=>"flash",
        __("floppy-disk", ANPS_TEMPLATE_LANG)=>"floppy-disk",
        __("floppy-open", ANPS_TEMPLATE_LANG)=>"floppy-open",
        __("floppy-remove", ANPS_TEMPLATE_LANG)=>"floppy-remove",
        __("floppy-save", ANPS_TEMPLATE_LANG)=>"floppy-save",
        __("floppy-saved", ANPS_TEMPLATE_LANG)=>"floppy-saved",
        __("folder-close", ANPS_TEMPLATE_LANG)=>"folder-close",
        __("folder-open", ANPS_TEMPLATE_LANG)=>"folder-open",
        __("font", ANPS_TEMPLATE_LANG)=>"font",
        __("forward", ANPS_TEMPLATE_LANG)=>"forward",
        __("fullscreen", ANPS_TEMPLATE_LANG)=>"fullscreen",
        __("gbp", ANPS_TEMPLATE_LANG)=>"gbp",
        __("gift", ANPS_TEMPLATE_LANG)=>"gift",
        __("glass", ANPS_TEMPLATE_LANG)=>"glass",
        __("globe", ANPS_TEMPLATE_LANG)=>"globe",
        __("hand-down", ANPS_TEMPLATE_LANG)=>"hand-down",
        __("hand-left", ANPS_TEMPLATE_LANG)=>"hand-left",
        __("hand-right", ANPS_TEMPLATE_LANG)=>"hand-right",
        __("hand-up", ANPS_TEMPLATE_LANG)=>"hand-up",
        __("hd-video", ANPS_TEMPLATE_LANG)=>"hd-video",
        __("hdd", ANPS_TEMPLATE_LANG)=>"hdd",
        __("header", ANPS_TEMPLATE_LANG)=>"header",
        __("headphones", ANPS_TEMPLATE_LANG)=>"headphones",
        __("heart", ANPS_TEMPLATE_LANG)=>"heart",
        __("heart-empty", ANPS_TEMPLATE_LANG)=>"heart-empty",
        __("home", ANPS_TEMPLATE_LANG)=>"home",
        __("import", ANPS_TEMPLATE_LANG)=>"import",
        __("inbox", ANPS_TEMPLATE_LANG)=>"inbox",
        __("indent-left", ANPS_TEMPLATE_LANG)=>"indent-left",
        __("indent-right", ANPS_TEMPLATE_LANG)=>"indent-right",
        __("info-sign", ANPS_TEMPLATE_LANG)=>"info-sign",
        __("italic", ANPS_TEMPLATE_LANG)=>"italic",
        __("leaf", ANPS_TEMPLATE_LANG)=>"leaf",
        __("link", ANPS_TEMPLATE_LANG)=>"link",
        __("list", ANPS_TEMPLATE_LANG)=>"list",
        __("list-alt", ANPS_TEMPLATE_LANG)=>"list-alt",
        __("lock", ANPS_TEMPLATE_LANG)=>"lock",
        __("log-in", ANPS_TEMPLATE_LANG)=>"log-in",
        __("log-out", ANPS_TEMPLATE_LANG)=>"log-out",
        __("magnet", ANPS_TEMPLATE_LANG)=>"magnet",
        __("map-marker", ANPS_TEMPLATE_LANG)=>"map-marker",
        __("minus", ANPS_TEMPLATE_LANG)=>"minus",
        __("minus-sign", ANPS_TEMPLATE_LANG)=>"minus-sign",
        __("emona", ANPS_TEMPLATE_LANG)=>"emona",
        __("music", ANPS_TEMPLATE_LANG)=>"music",
        __("new-window", ANPS_TEMPLATE_LANG)=>"new-window",
        __("off", ANPS_TEMPLATE_LANG)=>"off",
        __("ok", ANPS_TEMPLATE_LANG)=>"ok",
        __("ok-circle", ANPS_TEMPLATE_LANG)=>"ok-circle",
        __("ok-sign", ANPS_TEMPLATE_LANG)=>"ok-sign",
        __("open", ANPS_TEMPLATE_LANG)=>"open",
        __("paperclip", ANPS_TEMPLATE_LANG)=>"paperclip",
        __("pause", ANPS_TEMPLATE_LANG)=>"pause",
        __("pencil", ANPS_TEMPLATE_LANG)=>"pencil",
        __("phone", ANPS_TEMPLATE_LANG)=>"phone",
        __("phone-alt", ANPS_TEMPLATE_LANG)=>"phone-alt",
        __("picture", ANPS_TEMPLATE_LANG)=>"picture",
        __("plane", ANPS_TEMPLATE_LANG)=>"plane",
        __("play", ANPS_TEMPLATE_LANG)=>"play",
        __("play-circle", ANPS_TEMPLATE_LANG)=>"play-circle",
        __("plus", ANPS_TEMPLATE_LANG)=>"plus",
        __("plus-sign", ANPS_TEMPLATE_LANG)=>"plus-sign",
        __("print", ANPS_TEMPLATE_LANG)=>"print",
        __("pushpin", ANPS_TEMPLATE_LANG)=>"pushpin",
        __("qrcode", ANPS_TEMPLATE_LANG)=>"qrcode",
        __("question-sign", ANPS_TEMPLATE_LANG)=>"question-sign",
        __("random", ANPS_TEMPLATE_LANG)=>"random",
        __("record", ANPS_TEMPLATE_LANG)=>"record",
        __("refresh", ANPS_TEMPLATE_LANG)=>"refresh",
        __("registration-mark", ANPS_TEMPLATE_LANG)=>"registration-mark",
        __("remove", ANPS_TEMPLATE_LANG)=>"remove",
        __("remove-circle", ANPS_TEMPLATE_LANG)=>"remove-circle",
        __("remove-sign", ANPS_TEMPLATE_LANG)=>"remove-sign",
        __("repeat", ANPS_TEMPLATE_LANG)=>"repeat",
        __("resize-full", ANPS_TEMPLATE_LANG)=>"resize-full",
        __("resize-horizontal", ANPS_TEMPLATE_LANG)=>"resize-horizontal",
        __("resize-small", ANPS_TEMPLATE_LANG)=>"resize-small",
        __("resize-vertical", ANPS_TEMPLATE_LANG)=>"resize-vertical",
        __("retweet", ANPS_TEMPLATE_LANG)=>"retweet",
        __("road", ANPS_TEMPLATE_LANG)=>"road",
        __("save", ANPS_TEMPLATE_LANG)=>"save",
        __("saved", ANPS_TEMPLATE_LANG)=>"saved",
        __("screenshot", ANPS_TEMPLATE_LANG)=>"screenshot",
        __("sd-video", ANPS_TEMPLATE_LANG)=>"sd-video",
        __("search", ANPS_TEMPLATE_LANG)=>"search",
        __("send", ANPS_TEMPLATE_LANG)=>"send",
        __("share", ANPS_TEMPLATE_LANG)=>"share",
        __("share-alt", ANPS_TEMPLATE_LANG)=>"share-alt",
        __("shopping-cart", ANPS_TEMPLATE_LANG)=>"shopping-cart",
        __("signal", ANPS_TEMPLATE_LANG)=>"signal",
        __("sort", ANPS_TEMPLATE_LANG)=>"sort",
        __("sort-by-alphabet", ANPS_TEMPLATE_LANG)=>"sort-by-alphabet",
        __("sort-by-alphabet-alt", ANPS_TEMPLATE_LANG)=>"sort-by-alphabet-alt",
        __("sort-by-attributes", ANPS_TEMPLATE_LANG)=>"sort-by-attributes",
        __("sort-by-attributes-alt", ANPS_TEMPLATE_LANG)=>"sort-by-attributes-alt",
        __("sort-by-order", ANPS_TEMPLATE_LANG)=>"sort-by-order",
        __("sort-by-order-alt", ANPS_TEMPLATE_LANG)=>"sort-by-order-alt",
        __("sound-5-1", ANPS_TEMPLATE_LANG)=>"sound-5-1",
        __("sound-6-1", ANPS_TEMPLATE_LANG)=>"sound-6-1",
        __("sound-7-1", ANPS_TEMPLATE_LANG)=>"sound-7-1",
        __("sound-dolby", ANPS_TEMPLATE_LANG)=>"sound-dolby",
        __("sound-stereo", ANPS_TEMPLATE_LANG)=>"sound-stereo",
        __("star", ANPS_TEMPLATE_LANG)=>"star",
        __("star-empty", ANPS_TEMPLATE_LANG)=>"star-empty",
        __("stats", ANPS_TEMPLATE_LANG)=>"stats",
        __("step-backward", ANPS_TEMPLATE_LANG)=>"step-backward",
        __("step-forward", ANPS_TEMPLATE_LANG)=>"step-forward",
        __("stop", ANPS_TEMPLATE_LANG)=>"stop",
        __("subtitles", ANPS_TEMPLATE_LANG)=>"subtitles",
        __("tag", ANPS_TEMPLATE_LANG)=>"tag",
        __("tags", ANPS_TEMPLATE_LANG)=>"tags",
        __("tasks", ANPS_TEMPLATE_LANG)=>"tasks",
        __("text-height", ANPS_TEMPLATE_LANG)=>"text-height",
        __("text-width", ANPS_TEMPLATE_LANG)=>"text-width",
        __("th", ANPS_TEMPLATE_LANG)=>"th",
        __("th-large", ANPS_TEMPLATE_LANG)=>"th-large",
        __("th-list", ANPS_TEMPLATE_LANG)=>"th-list",
        __("thumbs-down", ANPS_TEMPLATE_LANG)=>"thumbs-down",
        __("thumbs-up", ANPS_TEMPLATE_LANG)=>"thumbs-up",
        __("time", ANPS_TEMPLATE_LANG)=>"time",
        __("tint", ANPS_TEMPLATE_LANG)=>"tint",
        __("tower", ANPS_TEMPLATE_LANG)=>"tower",
        __("transfer", ANPS_TEMPLATE_LANG)=>"transfer",
        __("trash", ANPS_TEMPLATE_LANG)=>"trash",
        __("tree-conifer", ANPS_TEMPLATE_LANG)=>"tree-conifer",
        __("tree-deciduous", ANPS_TEMPLATE_LANG)=>"tree-deciduous",
        __("unchecked", ANPS_TEMPLATE_LANG)=>"unchecked",
        __("upload", ANPS_TEMPLATE_LANG)=>"upload",
        __("usd", ANPS_TEMPLATE_LANG)=>"usd",
        __("user", ANPS_TEMPLATE_LANG)=>"user",
        __("volume-down", ANPS_TEMPLATE_LANG)=>"volume-down",
        __("volume-off", ANPS_TEMPLATE_LANG)=>"volume-off",
        __("volume-up", ANPS_TEMPLATE_LANG)=>"volume-up",
        __("warning-sign", ANPS_TEMPLATE_LANG)=>"warning-sign",
        __("wrench", ANPS_TEMPLATE_LANG)=>"wrench",
        __("zoom-in", ANPS_TEMPLATE_LANG)=>"zoom-in",
        __("zoom-out", ANPS_TEMPLATE_LANG)=>"zoom-out")
      ) 
       )
) );
/* END VC glyph */
/* VC featured title */
vc_map( array(
   "name" => __("Featured title", ANPS_TEMPLATE_LANG),
   "base" => "featured_title",
   "class" => "",
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "icon" => "icon-wpb-featured_title", 
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Featured title", ANPS_TEMPLATE_LANG),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter featured title.", ANPS_TEMPLATE_LANG)
      ) 
       )
) );
/* END VC featured title */
/* VC title */
vc_map( array(
   "name" => __("Title", ANPS_TEMPLATE_LANG),
   "base" => "title",
   "class" => "",
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "icon" => "icon-wpb-title", 
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", ANPS_TEMPLATE_LANG),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter title.", ANPS_TEMPLATE_LANG)
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Size", ANPS_TEMPLATE_LANG),
         "param_name" => "size",
         "value" => array(__("H1", ANPS_TEMPLATE_LANG)=>'1', __("H2", ANPS_TEMPLATE_LANG)=>'2', __("H3", ANPS_TEMPLATE_LANG)=>'3', __("H4", ANPS_TEMPLATE_LANG)=>'4', __("H5", ANPS_TEMPLATE_LANG)=>'5'), 
         "description" => __("Enter title size.", ANPS_TEMPLATE_LANG)
      )
       )
) );
/* END VC title */
/* VC Google maps */
vc_map( array(
   "name" => __("Google maps", ANPS_TEMPLATE_LANG),
   "base" => "google_maps",
   "class" => "", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "icon" => "icon-wpb-google_maps", 
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Location", ANPS_TEMPLATE_LANG),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter location.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Zoom", ANPS_TEMPLATE_LANG),
         "param_name" => "zoom",
         "value" => "15", 
         "description" => __("Enter zoom.", ANPS_TEMPLATE_LANG)
       )
     )
) );
/* END VC Google maps */
/* VC vimeo */
vc_map( array(
   "name" => __("Vimeo", ANPS_TEMPLATE_LANG),
   "base" => "vimeo",
   "class" => "",
   "icon" => "icon-wpb-film-vimeo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Video id", ANPS_TEMPLATE_LANG),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter vimeo video id.", ANPS_TEMPLATE_LANG)
      ) 
       )
) );
/* END VC vimeo */
/* VC youtube */
vc_map( array(
   "name" => __("Youtube", ANPS_TEMPLATE_LANG),
   "base" => "youtube",
   "class" => "",
   "icon" => "icon-wpb-film-youtube", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Video id", ANPS_TEMPLATE_LANG),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter youtube video id.", ANPS_TEMPLATE_LANG)
      ) 
       )
) );
/* END VC youtube */
/* VC logos (as parent) */
vc_map( array(
    "name" => __("Logos", ANPS_TEMPLATE_LANG),
    "base" => "logos",
    "as_parent" => array('only' => 'logo'), 
    "content_element" => true,
    "show_settings_on_create" => false,
    "icon" => "icon-wpb-logos",
    "js_view" => 'VcColumnView'
) );
/* END VC logos*/
/* VC logo (as child) */
vc_map( array(
    "name" => __("Logo", ANPS_TEMPLATE_LANG),
    "base" => "logo",
    "content_element" => true,
    "icon" => "icon-wpb-logos",
    "as_child" => array('only' => 'logos'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Image url", ANPS_TEMPLATE_LANG),
            "param_name" => "content",
            "description" => __("Enter image url.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Image", ANPS_TEMPLATE_LANG),
            "param_name" => "image_u"
        ),
        array(
            "type" => "textfield",
            "heading" => __("Url", ANPS_TEMPLATE_LANG),
            "param_name" => "url",
            "value" => "#",
            "description" => __("Logo url.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Alt", ANPS_TEMPLATE_LANG),
            "param_name" => "alt",
            "description" => __("Logo alt.", ANPS_TEMPLATE_LANG)
        )
    )
) );
/* END VC logo */
/* VC button */
vc_map( array(
   "name" => __("Button", ANPS_TEMPLATE_LANG),
   "base" => "button",
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "icon" => "icon-wpb-button", 
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Text", ANPS_TEMPLATE_LANG),
         "param_name" => "content",
         "description" => __("Enter button text.", ANPS_TEMPLATE_LANG)
      ), 
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Link", ANPS_TEMPLATE_LANG),
         "param_name" => "link",
         "value" => "#", 
         "description" => __("Enter button link.", ANPS_TEMPLATE_LANG)
      ), 
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Target", ANPS_TEMPLATE_LANG),
         "param_name" => "target",
         "value" => "_self", 
         "description" => __("Enter button target.", ANPS_TEMPLATE_LANG)
      ), 
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Size", ANPS_TEMPLATE_LANG),
         "param_name" => "size",
         "value" => array(__("Small", ANPS_TEMPLATE_LANG)=>'small', __("Medium", ANPS_TEMPLATE_LANG)=>'medium', __("Large", ANPS_TEMPLATE_LANG)=>'large'), 
         "description" => __("Enter button size.", ANPS_TEMPLATE_LANG)
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Style", ANPS_TEMPLATE_LANG),
         "param_name" => "style",
         "value" => array(__("Style1", ANPS_TEMPLATE_LANG)=>'style1', __("Style2", ANPS_TEMPLATE_LANG)=>'style2'), 
         "description" => __("Enter button style.", ANPS_TEMPLATE_LANG)
      ),
      array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Color", ANPS_TEMPLATE_LANG),
         "param_name" => "color",
         "description" => __("Enter button text color.", ANPS_TEMPLATE_LANG)
      ),
      array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Background", ANPS_TEMPLATE_LANG),
         "param_name" => "background",
         "description" => __("Enter button background color.", ANPS_TEMPLATE_LANG)
      ),
      array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Color hover", ANPS_TEMPLATE_LANG),
         "param_name" => "color_hover",
         "description" => __("Enter button text hover color.", ANPS_TEMPLATE_LANG)
      ),
      array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Background hover", ANPS_TEMPLATE_LANG),
         "param_name" => "background_hover",
         "description" => __("Enter button background hover color.", ANPS_TEMPLATE_LANG)
      ),
     )
) );
/* END VC button */
/* VC services (as parent) */
vc_map( array(
    "name" => __("Services", ANPS_TEMPLATE_LANG),
    "base" => "services",
    "content_element" => true,
    "as_parent" => array('only' => 'service'),     
    "show_settings_on_create" => false,
    "icon" => "icon-wpb-services",
    "js_view" => 'VcColumnView'
) );
/* END VC services */
/* VC service (as child) */
vc_map( array(
    "name" => __("Service", ANPS_TEMPLATE_LANG),
    "base" => "service",
    "content_element" => true,
    "is_container" => true,
    "as_child" => array('only' => 'services'),
    "icon" => "icon-wpb-services",
    "params" => array(
        array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Icon", ANPS_TEMPLATE_LANG),
         "param_name" => "icon",
         "value" => array(__("", ANPS_TEMPLATE_LANG)=>'', 
        __("adjust", ANPS_TEMPLATE_LANG)=>"adjust",
__("align-center", ANPS_TEMPLATE_LANG)=>"align-center",
__("align-justify", ANPS_TEMPLATE_LANG)=>"align-justify",
__("align-left", ANPS_TEMPLATE_LANG)=>"align-left",
__("align-right", ANPS_TEMPLATE_LANG)=>"align-right",
__("arrow-down", ANPS_TEMPLATE_LANG)=>"arrow-down",
__("arrow-left", ANPS_TEMPLATE_LANG)=>"arrow-left",
__("arrow-right", ANPS_TEMPLATE_LANG)=>"arrow-right",
__("arrow-up", ANPS_TEMPLATE_LANG)=>"arrow-up",
__("asterisk", ANPS_TEMPLATE_LANG)=>"asterisk",
__("backward", ANPS_TEMPLATE_LANG)=>"backward",
__("ban-circle", ANPS_TEMPLATE_LANG)=>"ban-circle",
__("barcode", ANPS_TEMPLATE_LANG)=>"barcode",
__("bell", ANPS_TEMPLATE_LANG)=>"bell",
__("bold", ANPS_TEMPLATE_LANG)=>"bold",
__("book", ANPS_TEMPLATE_LANG)=>"book",
__("bookmark", ANPS_TEMPLATE_LANG)=>"bookmark",
__("briefcase", ANPS_TEMPLATE_LANG)=>"briefcase",
__("bullhorn", ANPS_TEMPLATE_LANG)=>"bullhorn",
__("calendar", ANPS_TEMPLATE_LANG)=>"calendar",
__("camera", ANPS_TEMPLATE_LANG)=>"camera",
__("certificate", ANPS_TEMPLATE_LANG)=>"certificate",
__("check", ANPS_TEMPLATE_LANG)=>"check",
__("chevron-down", ANPS_TEMPLATE_LANG)=>"chevron-down",
__("chevron-left", ANPS_TEMPLATE_LANG)=>"chevron-left",
__("chevron-right", ANPS_TEMPLATE_LANG)=>"chevron-right",
__("chevron-up", ANPS_TEMPLATE_LANG)=>"chevron-up",
__("circle-arrow-down", ANPS_TEMPLATE_LANG)=>"circle-arrow-down",
__("circle-arrow-left", ANPS_TEMPLATE_LANG)=>"circle-arrow-left",
__("circle-arrow-right", ANPS_TEMPLATE_LANG)=>"circle-arrow-right",
__("circle-arrow-up", ANPS_TEMPLATE_LANG)=>"circle-arrow-up",
__("cloud", ANPS_TEMPLATE_LANG)=>"cloud",
__("cloud-download", ANPS_TEMPLATE_LANG)=>"cloud-download",
__("cloud-upload", ANPS_TEMPLATE_LANG)=>"cloud-upload",
__("cog", ANPS_TEMPLATE_LANG)=>"cog",
__("collapse-down", ANPS_TEMPLATE_LANG)=>"collapse-down",
__("collapse-up", ANPS_TEMPLATE_LANG)=>"collapse-up",
__("comment", ANPS_TEMPLATE_LANG)=>"comment",
__("compressed", ANPS_TEMPLATE_LANG)=>"compressed",
__("copyright-mark", ANPS_TEMPLATE_LANG)=>"copyright-mark",
__("credit-card", ANPS_TEMPLATE_LANG)=>"credit-card",
__("cutlery", ANPS_TEMPLATE_LANG)=>"cutlery",
__("dashboard", ANPS_TEMPLATE_LANG)=>"dashboard",
__("download", ANPS_TEMPLATE_LANG)=>"download",
__("download-alt", ANPS_TEMPLATE_LANG)=>"download-alt",
__("earphone", ANPS_TEMPLATE_LANG)=>"earphone",
__("edit", ANPS_TEMPLATE_LANG)=>"edit",
__("eject", ANPS_TEMPLATE_LANG)=>"eject",
__("envelope", ANPS_TEMPLATE_LANG)=>"envelope",
__("euro", ANPS_TEMPLATE_LANG)=>"euro",
__("exclamation-sign", ANPS_TEMPLATE_LANG)=>"exclamation-sign",
__("expand", ANPS_TEMPLATE_LANG)=>"expand",
__("export", ANPS_TEMPLATE_LANG)=>"export",
__("eye-close", ANPS_TEMPLATE_LANG)=>"eye-close",
__("eye-open", ANPS_TEMPLATE_LANG)=>"eye-open",
__("facetime-video", ANPS_TEMPLATE_LANG)=>"facetime-video",
__("fast-backward", ANPS_TEMPLATE_LANG)=>"fast-backward",
__("fast-forward", ANPS_TEMPLATE_LANG)=>"fast-forward",
__("file", ANPS_TEMPLATE_LANG)=>"file",
__("film", ANPS_TEMPLATE_LANG)=>"film",
__("filter", ANPS_TEMPLATE_LANG)=>"filter",
__("fire", ANPS_TEMPLATE_LANG)=>"fire",
__("flag", ANPS_TEMPLATE_LANG)=>"flag",
__("flash", ANPS_TEMPLATE_LANG)=>"flash",
__("floppy-disk", ANPS_TEMPLATE_LANG)=>"floppy-disk",
__("floppy-open", ANPS_TEMPLATE_LANG)=>"floppy-open",
__("floppy-remove", ANPS_TEMPLATE_LANG)=>"floppy-remove",
__("floppy-save", ANPS_TEMPLATE_LANG)=>"floppy-save",
__("floppy-saved", ANPS_TEMPLATE_LANG)=>"floppy-saved",
__("folder-close", ANPS_TEMPLATE_LANG)=>"folder-close",
__("folder-open", ANPS_TEMPLATE_LANG)=>"folder-open",
__("font", ANPS_TEMPLATE_LANG)=>"font",
__("forward", ANPS_TEMPLATE_LANG)=>"forward",
__("fullscreen", ANPS_TEMPLATE_LANG)=>"fullscreen",
__("gbp", ANPS_TEMPLATE_LANG)=>"gbp",
__("gift", ANPS_TEMPLATE_LANG)=>"gift",
__("glass", ANPS_TEMPLATE_LANG)=>"glass",
__("globe", ANPS_TEMPLATE_LANG)=>"globe",
__("hand-down", ANPS_TEMPLATE_LANG)=>"hand-down",
__("hand-left", ANPS_TEMPLATE_LANG)=>"hand-left",
__("hand-right", ANPS_TEMPLATE_LANG)=>"hand-right",
__("hand-up", ANPS_TEMPLATE_LANG)=>"hand-up",
__("hd-video", ANPS_TEMPLATE_LANG)=>"hd-video",
__("hdd", ANPS_TEMPLATE_LANG)=>"hdd",
__("header", ANPS_TEMPLATE_LANG)=>"header",
__("headphones", ANPS_TEMPLATE_LANG)=>"headphones",
__("heart", ANPS_TEMPLATE_LANG)=>"heart",
__("heart-empty", ANPS_TEMPLATE_LANG)=>"heart-empty",
__("home", ANPS_TEMPLATE_LANG)=>"home",
__("import", ANPS_TEMPLATE_LANG)=>"import",
__("inbox", ANPS_TEMPLATE_LANG)=>"inbox",
__("indent-left", ANPS_TEMPLATE_LANG)=>"indent-left",
__("indent-right", ANPS_TEMPLATE_LANG)=>"indent-right",
__("info-sign", ANPS_TEMPLATE_LANG)=>"info-sign",
__("italic", ANPS_TEMPLATE_LANG)=>"italic",
__("leaf", ANPS_TEMPLATE_LANG)=>"leaf",
__("link", ANPS_TEMPLATE_LANG)=>"link",
__("list", ANPS_TEMPLATE_LANG)=>"list",
__("list-alt", ANPS_TEMPLATE_LANG)=>"list-alt",
__("lock", ANPS_TEMPLATE_LANG)=>"lock",
__("log-in", ANPS_TEMPLATE_LANG)=>"log-in",
__("log-out", ANPS_TEMPLATE_LANG)=>"log-out",
__("magnet", ANPS_TEMPLATE_LANG)=>"magnet",
__("map-marker", ANPS_TEMPLATE_LANG)=>"map-marker",
__("minus", ANPS_TEMPLATE_LANG)=>"minus",
__("minus-sign", ANPS_TEMPLATE_LANG)=>"minus-sign",
__("emona", ANPS_TEMPLATE_LANG)=>"emona",
__("music", ANPS_TEMPLATE_LANG)=>"music",
__("new-window", ANPS_TEMPLATE_LANG)=>"new-window",
__("off", ANPS_TEMPLATE_LANG)=>"off",
__("ok", ANPS_TEMPLATE_LANG)=>"ok",
__("ok-circle", ANPS_TEMPLATE_LANG)=>"ok-circle",
__("ok-sign", ANPS_TEMPLATE_LANG)=>"ok-sign",
__("open", ANPS_TEMPLATE_LANG)=>"open",
__("paperclip", ANPS_TEMPLATE_LANG)=>"paperclip",
__("pause", ANPS_TEMPLATE_LANG)=>"pause",
__("pencil", ANPS_TEMPLATE_LANG)=>"pencil",
__("phone", ANPS_TEMPLATE_LANG)=>"phone",
__("phone-alt", ANPS_TEMPLATE_LANG)=>"phone-alt",
__("picture", ANPS_TEMPLATE_LANG)=>"picture",
__("plane", ANPS_TEMPLATE_LANG)=>"plane",
__("play", ANPS_TEMPLATE_LANG)=>"play",
__("play-circle", ANPS_TEMPLATE_LANG)=>"play-circle",
__("plus", ANPS_TEMPLATE_LANG)=>"plus",
__("plus-sign", ANPS_TEMPLATE_LANG)=>"plus-sign",
__("print", ANPS_TEMPLATE_LANG)=>"print",
__("pushpin", ANPS_TEMPLATE_LANG)=>"pushpin",
__("qrcode", ANPS_TEMPLATE_LANG)=>"qrcode",
__("question-sign", ANPS_TEMPLATE_LANG)=>"question-sign",
__("random", ANPS_TEMPLATE_LANG)=>"random",
__("record", ANPS_TEMPLATE_LANG)=>"record",
__("refresh", ANPS_TEMPLATE_LANG)=>"refresh",
__("registration-mark", ANPS_TEMPLATE_LANG)=>"registration-mark",
__("remove", ANPS_TEMPLATE_LANG)=>"remove",
__("remove-circle", ANPS_TEMPLATE_LANG)=>"remove-circle",
__("remove-sign", ANPS_TEMPLATE_LANG)=>"remove-sign",
__("repeat", ANPS_TEMPLATE_LANG)=>"repeat",
__("resize-full", ANPS_TEMPLATE_LANG)=>"resize-full",
__("resize-horizontal", ANPS_TEMPLATE_LANG)=>"resize-horizontal",
__("resize-small", ANPS_TEMPLATE_LANG)=>"resize-small",
__("resize-vertical", ANPS_TEMPLATE_LANG)=>"resize-vertical",
__("retweet", ANPS_TEMPLATE_LANG)=>"retweet",
__("road", ANPS_TEMPLATE_LANG)=>"road",
__("save", ANPS_TEMPLATE_LANG)=>"save",
__("saved", ANPS_TEMPLATE_LANG)=>"saved",
__("screenshot", ANPS_TEMPLATE_LANG)=>"screenshot",
__("sd-video", ANPS_TEMPLATE_LANG)=>"sd-video",
__("search", ANPS_TEMPLATE_LANG)=>"search",
__("send", ANPS_TEMPLATE_LANG)=>"send",
__("share", ANPS_TEMPLATE_LANG)=>"share",
__("share-alt", ANPS_TEMPLATE_LANG)=>"share-alt",
__("shopping-cart", ANPS_TEMPLATE_LANG)=>"shopping-cart",
__("signal", ANPS_TEMPLATE_LANG)=>"signal",
__("sort", ANPS_TEMPLATE_LANG)=>"sort",
__("sort-by-alphabet", ANPS_TEMPLATE_LANG)=>"sort-by-alphabet",
__("sort-by-alphabet-alt", ANPS_TEMPLATE_LANG)=>"sort-by-alphabet-alt",
__("sort-by-attributes", ANPS_TEMPLATE_LANG)=>"sort-by-attributes",
__("sort-by-attributes-alt", ANPS_TEMPLATE_LANG)=>"sort-by-attributes-alt",
__("sort-by-order", ANPS_TEMPLATE_LANG)=>"sort-by-order",
__("sort-by-order-alt", ANPS_TEMPLATE_LANG)=>"sort-by-order-alt",
__("sound-5-1", ANPS_TEMPLATE_LANG)=>"sound-5-1",
__("sound-6-1", ANPS_TEMPLATE_LANG)=>"sound-6-1",
__("sound-7-1", ANPS_TEMPLATE_LANG)=>"sound-7-1",
__("sound-dolby", ANPS_TEMPLATE_LANG)=>"sound-dolby",
__("sound-stereo", ANPS_TEMPLATE_LANG)=>"sound-stereo",
__("star", ANPS_TEMPLATE_LANG)=>"star",
__("star-empty", ANPS_TEMPLATE_LANG)=>"star-empty",
__("stats", ANPS_TEMPLATE_LANG)=>"stats",
__("step-backward", ANPS_TEMPLATE_LANG)=>"step-backward",
__("step-forward", ANPS_TEMPLATE_LANG)=>"step-forward",
__("stop", ANPS_TEMPLATE_LANG)=>"stop",
__("subtitles", ANPS_TEMPLATE_LANG)=>"subtitles",
__("tag", ANPS_TEMPLATE_LANG)=>"tag",
__("tags", ANPS_TEMPLATE_LANG)=>"tags",
__("tasks", ANPS_TEMPLATE_LANG)=>"tasks",
__("text-height", ANPS_TEMPLATE_LANG)=>"text-height",
__("text-width", ANPS_TEMPLATE_LANG)=>"text-width",
__("th", ANPS_TEMPLATE_LANG)=>"th",
__("th-large", ANPS_TEMPLATE_LANG)=>"th-large",
__("th-list", ANPS_TEMPLATE_LANG)=>"th-list",
__("thumbs-down", ANPS_TEMPLATE_LANG)=>"thumbs-down",
__("thumbs-up", ANPS_TEMPLATE_LANG)=>"thumbs-up",
__("time", ANPS_TEMPLATE_LANG)=>"time",
__("tint", ANPS_TEMPLATE_LANG)=>"tint",
__("tower", ANPS_TEMPLATE_LANG)=>"tower",
__("transfer", ANPS_TEMPLATE_LANG)=>"transfer",
__("trash", ANPS_TEMPLATE_LANG)=>"trash",
__("tree-conifer", ANPS_TEMPLATE_LANG)=>"tree-conifer",
__("tree-deciduous", ANPS_TEMPLATE_LANG)=>"tree-deciduous",
__("unchecked", ANPS_TEMPLATE_LANG)=>"unchecked",
__("upload", ANPS_TEMPLATE_LANG)=>"upload",
__("usd", ANPS_TEMPLATE_LANG)=>"usd",
__("user", ANPS_TEMPLATE_LANG)=>"user",
__("volume-down", ANPS_TEMPLATE_LANG)=>"volume-down",
__("volume-off", ANPS_TEMPLATE_LANG)=>"volume-off",
__("volume-up", ANPS_TEMPLATE_LANG)=>"volume-up",
__("warning-sign", ANPS_TEMPLATE_LANG)=>"warning-sign",
__("wrench", ANPS_TEMPLATE_LANG)=>"wrench",
__("zoom-in", ANPS_TEMPLATE_LANG)=>"zoom-in",
__("zoom-out", ANPS_TEMPLATE_LANG)=>"zoom-out")
      ),
        array(
            "type" => "textfield",
            "heading" => __("Title", ANPS_TEMPLATE_LANG),
            "param_name" => "title",
            "description" => __("Service title.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Price", ANPS_TEMPLATE_LANG),
            "param_name" => "price",
            "description" => __("Service price.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Align", ANPS_TEMPLATE_LANG),
            "param_name" => "align",
            "value" =>array(__("Left", ANPS_TEMPLATE_LANG)=>'left', __("Right", ANPS_TEMPLATE_LANG)=>'right'),
            "description" => __("Service align.", ANPS_TEMPLATE_LANG)
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Select", ANPS_TEMPLATE_LANG),
            "param_name" => "select",
            "value" =>array(__("No", ANPS_TEMPLATE_LANG)=>'false', __("Yes", ANPS_TEMPLATE_LANG)=>'true'),
            "description" => __("Service selected.", ANPS_TEMPLATE_LANG)
        )
    )
) );
/* END VC service */
/* VC contact info */
vc_map( array(
   "name" => __("Contact info", ANPS_TEMPLATE_LANG),
   "base" => "contact_info",
   "as_parent" => array(), 
   "is_container" => true, 
   "icon" => "icon-wpb-contact_info", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Parallax", ANPS_TEMPLATE_LANG),
         "param_name" => "parallax",
         "value" => array(__("False", ANPS_TEMPLATE_LANG)=>'false', __("True", ANPS_TEMPLATE_LANG)=>'true'), 
         "description" => __("Enter parallax.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Parallax overlay", ANPS_TEMPLATE_LANG),
         "param_name" => "parallax_overlay",
         "value" => array(__("False", ANPS_TEMPLATE_LANG)=>'', __("True", ANPS_TEMPLATE_LANG)=>'true'), 
         "description" => __("Parallax overlay.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Background image url", ANPS_TEMPLATE_LANG),
         "param_name" => "image",
         "description" => __("Enter background image url.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "attach_image",
         "holder" => "div",
         "heading" => __("Background image", ANPS_TEMPLATE_LANG),
         "param_name" => "image_u"
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Background color", ANPS_TEMPLATE_LANG),
         "param_name" => "color",
         "value" => "", 
         "description" => __("Background color.", ANPS_TEMPLATE_LANG)
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Slug", ANPS_TEMPLATE_LANG),
         "param_name" => "slug",
         "description" => __("This is used for both for none page navigation and the parallax effect (if you do not have the navigation need you enter a unique slug if you want parallax effect to function)", ANPS_TEMPLATE_LANG)
      )
       )
) );
/* END VC contact info */
/* VC section */
vc_map( array(
   "name" => __("Section", ANPS_TEMPLATE_LANG),
   "base" => "section",
   "as_parent" => array(), 
   "is_container" => true, 
   "icon" => "icon-wpb-section", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Slug", ANPS_TEMPLATE_LANG),
         "param_name" => "slug",
         "description" => __("Enter section id/slug.", ANPS_TEMPLATE_LANG)
      )
   )
));
/* END VC section */
/* VC subsection */
vc_map( array(
   "name" => __("Subsection", ANPS_TEMPLATE_LANG),
   "base" => "subsection",
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "icon" => "icon-wpb-subsection", 
   "params" => array(
      array(
         "type" => "all_pages",
         "holder" => "div",
         "heading" => __("Page", ANPS_TEMPLATE_LANG),
         "param_name" => "content",
         "description" => __("Select page.", ANPS_TEMPLATE_LANG)
      )
   )
));
/* END VC subsection */
/* VC accordion (as parent) */
vc_map( array(
    "name" => __("Accordion/Toggle", ANPS_TEMPLATE_LANG),
    "base" => "accordion",
    "content_element" => true,
    "as_parent" => array('only' => 'accordion_item'),     
    "show_settings_on_create" => true,
    "icon" => "icon-wpb-accordion",
    "params" => array(
      array(
            "type" => "dropdown",
            "heading" => __("Opened", ANPS_TEMPLATE_LANG),
            "param_name" => "opened",
            "value" =>array(__("No", ANPS_TEMPLATE_LANG)=>'false', __("Yes", ANPS_TEMPLATE_LANG)=>'true'),
            "description" => __("Opened Accordion/Toggle item.", ANPS_TEMPLATE_LANG)
        ),
      array(
            "type" => "dropdown",
            "heading" => __("Type", ANPS_TEMPLATE_LANG),
            "param_name" => "type",
            "value" =>array(__("Accordion", ANPS_TEMPLATE_LANG)=>'accordion', __("Toggle", ANPS_TEMPLATE_LANG)=>''),
            "description" => __("Select type.", ANPS_TEMPLATE_LANG)
        )
    ),
    "js_view" => 'VcColumnView'
) );
/* END VC accordion */
/* VC accordion item (as child) */
vc_map( array(
    "name" => __("Accordion/Toggle item", ANPS_TEMPLATE_LANG),
    "base" => "accordion_item",
    "content_element" => true,
    "is_container" => true,
    "icon" => "icon-wpb-accordion",
    "as_child" => array('only' => 'accordion'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Title", ANPS_TEMPLATE_LANG),
            "param_name" => "title",
            "description" => __("Service title.", ANPS_TEMPLATE_LANG)
        )
    )
) );
/* END VC accordion item */
/* VC tabs (as parent) */
/*vc_map( array(
    "name" => __("Tabs", ANPS_TEMPLATE_LANG),
    "base" => "tabs",
    "content_element" => true,
    "as_parent" => array('only' => 'tab'),     
    "show_settings_on_create" => true,
    "icon" => "icon-wpb-tabs",
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Tab1 title", ANPS_TEMPLATE_LANG),
            "param_name" => "tab1"
        ),
        array(
            "type" => "textfield",
            "heading" => __("Tab2 title", ANPS_TEMPLATE_LANG),
            "param_name" => "tab2"
        ),
        array(
            "type" => "textfield",
            "heading" => __("Tab3 title", ANPS_TEMPLATE_LANG),
            "param_name" => "tab3"
        ),
        array(
            "type" => "textfield",
            "heading" => __("Tab4 title", ANPS_TEMPLATE_LANG),
            "param_name" => "tab4"
        ),
        array(
            "type" => "textfield",
            "heading" => __("Tab5 title", ANPS_TEMPLATE_LANG),
            "param_name" => "tab5"
        ),
        array(
            "type" => "textfield",
            "heading" => __("Tab6 title", ANPS_TEMPLATE_LANG),
            "param_name" => "tab6"
        )
    ),
    "js_view" => 'VcColumnView'
) );*/
/* END VC tabs */
/* VC tabs item (as child) */
/*vc_map( array(
    "name" => __("Accordion/Toggle item", ANPS_TEMPLATE_LANG),
    "base" => "tab",
    "content_element" => true,
    "is_container" => true,
    "icon" => "icon-wpb-tabs",
    "as_child" => array('only' => 'tabs'),
) );*/
/* END VC tabs item */
/* VC Error 404 */
vc_map( array(
   "name" => __("Error 404", ANPS_TEMPLATE_LANG),
   "base" => "error_404",
   "icon" => "icon-wpb-error404", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Title", ANPS_TEMPLATE_LANG),
         "param_name" => "title"
       ),
       array(
         "type" => "textarea",
         "holder" => "div",
         "heading" => __("Text", ANPS_TEMPLATE_LANG),
         "param_name" => "content"
      )
    )
));
/* VC END Error 404 */
/* VC order tracking */
vc_map( array(
   "name" => __("Woocommerce order tracking", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_order_tracking",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC order tracking */
/* VC shop messages */
vc_map( array(
   "name" => __("Woocommerce shop messages", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_shop_messages",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC shop messages */
/* VC recent products */
vc_map( array(
   "name" => __("Woocommerce recent products", ANPS_TEMPLATE_LANG),
   "base" => "recent_products",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textarea",
         "holder" => "div",
         "heading" => __("Per page", ANPS_TEMPLATE_LANG),
         "param_name" => "per_page",
         "value" => "12"  
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Columns", ANPS_TEMPLATE_LANG),
         "param_name" => "columns",
         "value" => "4" 
       ), 
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order by", ANPS_TEMPLATE_LANG),
         "param_name" => "orderby",
         "value" => "date"  
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order", ANPS_TEMPLATE_LANG),
         "param_name" => "order",
         "value" => "desc"  
       )
    )
));
/* END VC recent products */
/* VC featured products */
vc_map( array(
   "name" => __("Woocommerce featured products", ANPS_TEMPLATE_LANG),
   "base" => "featured_products",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textarea",
         "holder" => "div",
         "heading" => __("Per page", ANPS_TEMPLATE_LANG),
         "param_name" => "per_page",
         "value" => "12"  
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Columns", ANPS_TEMPLATE_LANG),
         "param_name" => "columns",
         "value" => "4" 
       ), 
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order by", ANPS_TEMPLATE_LANG),
         "param_name" => "orderby",
         "value" => "date"  
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order", ANPS_TEMPLATE_LANG),
         "param_name" => "order",
         "value" => "desc"  
       )
    )
));
/* END VC featured products */
/* VC product */
vc_map( array(
   "name" => __("Woocommerce product", ANPS_TEMPLATE_LANG),
   "base" => "product",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textarea",
         "holder" => "div",
         "heading" => __("Id", ANPS_TEMPLATE_LANG),
         "param_name" => "id",
         "description" => "To find the Product ID, go to the Product > Edit screen and look in the URL for the postid= as shown below (http://docs.woothemes.com/document/woocommerce-shortcodes)."  
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Sku", ANPS_TEMPLATE_LANG),
         "param_name" => "sku",
         "description" => "You can add product by id or by sku." 
       )
      )
    )
);
/* END VC product */
/* VC products */
vc_map( array(
   "name" => __("Woocommerce products", ANPS_TEMPLATE_LANG),
   "base" => "products",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textarea",
         "holder" => "div",
         "heading" => __("Id", ANPS_TEMPLATE_LANG),
         "param_name" => "id",
         "description" => "Separate product ids with ,"  
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Sku", ANPS_TEMPLATE_LANG),
         "param_name" => "sku",
         "description" => "Separate product skus with ," 
       )
      )
    )
);
/* END VC products */
/* VC add to cart */
vc_map( array(
   "name" => __("Woocommerce add to cart", ANPS_TEMPLATE_LANG),
   "base" => "add_to_cart",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textarea",
         "holder" => "div",
         "heading" => __("Id", ANPS_TEMPLATE_LANG),
         "param_name" => "id",
         "description" => "Enter product id"  
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Sku", ANPS_TEMPLATE_LANG),
         "param_name" => "sku",
         "description" => "Enter product sku" 
       )
      )
    )
);
/* END VC add to cart */
/* VC product categories */
vc_map( array(
   "name" => __("Woocommerce product categories", ANPS_TEMPLATE_LANG),
   "base" => "product_categories",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textarea",
         "holder" => "div",
         "heading" => __("Number", ANPS_TEMPLATE_LANG),
         "param_name" => "number",
         "value" => "12",  
         "description" => "Number of products"  
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Parent", ANPS_TEMPLATE_LANG),
         "param_name" => "parent",
         "value" => "0", 
         "description" => "Set the parent paramater to 0 to only display top level categories. Set ids to a comma separated list of category ids to only show those." 
       )
      )
    )
);
/* END VC product categories */
/* VC product category */
vc_map( array(
   "name" => __("Woocommerce product category", ANPS_TEMPLATE_LANG),
   "base" => "product_category",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textarea",
         "holder" => "div",
         "heading" => __("Category", ANPS_TEMPLATE_LANG),
         "param_name" => "category", 
         "description" => "Category name"  
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Per page", ANPS_TEMPLATE_LANG),
         "param_name" => "per_page",
         "value" => "12", 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Columns", ANPS_TEMPLATE_LANG),
         "param_name" => "columns",
         "value" => "4", 
        ),
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order by", ANPS_TEMPLATE_LANG),
         "param_name" => "orderby",
         "value" => "date", 
        ),
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order", ANPS_TEMPLATE_LANG),
         "param_name" => "order",
         "value" => "desc", 
        )    
      )
    )
);
/* END VC product category */
/* VC woocommerce cart */
vc_map( array(
   "name" => __("Woocommerce cart", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_cart",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce cart */
/* VC woocommerce checkout */
vc_map( array(
   "name" => __("Woocommerce checkout", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_checkout",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce checkout */
/* VC woocommerce pay */
vc_map( array(
   "name" => __("Woocommerce pay", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_pay",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce pay */
/* VC woocommerce thankyou */
vc_map( array(
   "name" => __("Woocommerce thankyou", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_thankyou",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce thankyou */
/* VC woocommerce order tracking */
vc_map( array(
   "name" => __("Woocommerce order tracking", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_order_tracking",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce order tracking */
/* VC woocommerce my account */
vc_map( array(
   "name" => __("Woocommerce my account", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_my_account",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce my account] */
/* VC woocommerce edit address */
vc_map( array(
   "name" => __("Woocommerce edit address", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_edit_address",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce edit address */
/* VC woocommerce view order */
vc_map( array(
   "name" => __("Woocommerce view order", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_view_order",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce view order */
/* VC woocommerce change password */
vc_map( array(
   "name" => __("Woocommerce change password", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_change_password",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce change password */
/* VC woocommerce lost password */
vc_map( array(
   "name" => __("Woocommerce lost password", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_lost_password",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce lost password */
/* VC woocommerce logout */
vc_map( array(
   "name" => __("Woocommerce logout", ANPS_TEMPLATE_LANG),
   "base" => "woocommerce_logout",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce logout */
/* VC add to cart url */
vc_map( array(
   "name" => __("Woocommerce add to cart url", ANPS_TEMPLATE_LANG),
   "base" => "add_to_cart_url",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textarea",
         "holder" => "div",
         "heading" => __("Id", ANPS_TEMPLATE_LANG),
         "param_name" => "id",
         "description" => "Enter product id"  
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Sku", ANPS_TEMPLATE_LANG),
         "param_name" => "sku",
         "description" => "Enter product sku" 
       )
      )
    )
);
/* END VC add to cart url */
/* VC product page */
vc_map( array(
   "name" => __("Woocommerce product page", ANPS_TEMPLATE_LANG),
   "base" => "product_page",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
       array(
         "type" => "textarea",
         "holder" => "div",
         "heading" => __("Id", ANPS_TEMPLATE_LANG),
         "param_name" => "id",
         "description" => "Enter product id"  
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Sku", ANPS_TEMPLATE_LANG),
         "param_name" => "sku",
         "description" => "Enter product sku" 
       )
      )
    )
);
/* END VC product page */
/* VC sale products */
vc_map( array(
   "name" => __("Woocommerce sale products", ANPS_TEMPLATE_LANG),
   "base" => "sale_products",
   "icon" => "icon-wpb-woo",
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Per page", ANPS_TEMPLATE_LANG),
         "param_name" => "per_page",
         "value" => "12", 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Columns", ANPS_TEMPLATE_LANG),
         "param_name" => "columns",
         "value" => "4", 
        ),
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order by", ANPS_TEMPLATE_LANG),
         "param_name" => "orderby",
         "value" => "title", 
        ),
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order", ANPS_TEMPLATE_LANG),
         "param_name" => "order",
         "value" => "asc", 
        )   
      )
    )
);
/* END VC sale products */
/* VC top rated products */
vc_map( array(
   "name" => __("Woocommerce top rated products", ANPS_TEMPLATE_LANG),
   "base" => "top_rated_products",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Per page", ANPS_TEMPLATE_LANG),
         "param_name" => "per_page",
         "value" => "12", 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Columns", ANPS_TEMPLATE_LANG),
         "param_name" => "columns",
         "value" => "4", 
        ),
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order by", ANPS_TEMPLATE_LANG),
         "param_name" => "orderby",
         "value" => "title", 
        ),
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order", ANPS_TEMPLATE_LANG),
         "param_name" => "order",
         "value" => "asc", 
        )    
      )
    )
);
/* END VC top rated products */
/* VC best selling products */
vc_map( array(
   "name" => __("Woocommerce best selling products", ANPS_TEMPLATE_LANG),
   "base" => "best_selling_products",
   "icon" => "icon-wpb-woo",
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Per page", ANPS_TEMPLATE_LANG),
         "param_name" => "per_page",
         "value" => "12", 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Columns", ANPS_TEMPLATE_LANG),
         "param_name" => "columns",
         "value" => "4", 
        )   
      )
    )
);
/* END VC best selling products */
/* VC related products */
vc_map( array(
   "name" => __("Woocommerce related products", ANPS_TEMPLATE_LANG),
   "base" => "related_products",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Per page", ANPS_TEMPLATE_LANG),
         "param_name" => "per_page",
         "value" => "12", 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Columns", ANPS_TEMPLATE_LANG),
         "param_name" => "columns",
         "value" => "4", 
        ),
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order by", ANPS_TEMPLATE_LANG),
         "param_name" => "orderby",
         "value" => "title", 
        )   
      )
    )
);
/* END VC related products */
/* VC product attribute */
vc_map( array(
   "name" => __("Woocommerce product attribute", ANPS_TEMPLATE_LANG),
   "base" => "product_attribute",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Content', ANPS_TEMPLATE_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Per page", ANPS_TEMPLATE_LANG),
         "param_name" => "per_page",
         "value" => "12", 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Columns", ANPS_TEMPLATE_LANG),
         "param_name" => "columns",
         "value" => "4", 
        ),
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order by", ANPS_TEMPLATE_LANG),
         "param_name" => "orderby",
         "value" => "title", 
        ),
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order", ANPS_TEMPLATE_LANG),
         "param_name" => "order",
         "value" => "asc", 
        ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Attribute", ANPS_TEMPLATE_LANG),
         "param_name" => "attribute",
         "value" => "asc", 
        ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Filter", ANPS_TEMPLATE_LANG),
         "param_name" => "filter",
         "value" => "asc", 
        )
      )
    )
);
/* END VC product attribute */
/* Add parameter vc_row */
vc_add_param('vc_row', array("type" => "textfield", 'heading'=>__("Id", ANPS_TEMPLATE_LANG), 'param_name' =>'id')); 
vc_add_param('vc_row', array("type" => "dropdown", 'heading'=>__("Content wrapper", ANPS_TEMPLATE_LANG), 'param_name' =>'has_content', "value" =>array(__("true", ANPS_TEMPLATE_LANG)=>'true', __("false", ANPS_TEMPLATE_LANG)=>'false'))); 

/* Add parameter vc_row_inner */
vc_add_param('vc_row_inner', array("type" => "dropdown", 'heading'=>__("Content wrapper", ANPS_TEMPLATE_LANG), 'param_name' =>'has_content', "value" =>array(__("true", ANPS_TEMPLATE_LANG)=>'true', __("false", ANPS_TEMPLATE_LANG)=>'false'))); 