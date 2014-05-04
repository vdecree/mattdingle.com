<?php 
    header("Content-type: text/css; charset: UTF-8"); 
    require_once('../../../../wp-load.php');
?>
<?php 
function getExtCustomFonts($font) {
    $dir = get_template_directory().'/fonts'; 
        if ($handle = opendir($dir)) { 
            $arr = array();
            // Get all files and store it to array
            while(false !== ($entry = readdir($handle))) {
                $explode_font=explode('.',$entry);
                if(strtolower($font)==strtolower($explode_font[0]))
                    $arr[] = $entry;
            }          
            closedir($handle); 
            // Remove . and ..
            unset($arr['.'], $arr['..']); 
            return $arr;
        }
}
$fonts = "BebasNeue-webfont";
$type = 1;
$fonts2 = "Open Sans";
$type2 = 0;
$fonts3 = "Arial";
$type3 = 0;
switch(get_option('font_source_1')) {
    case('System fonts') :
        $fonts = urldecode(get_option('font_type_1'));
        $type = 0;
        break;
    case('Custom fonts') :
        //$fonts = get_template_directory_uri()."/fonts/".getExtCustomFonts(get_option('font_type_1'));
        $fonts = urldecode(get_option('font_type_1'));
        $type = 1;
        break;
    case('Google fonts') :
        $fonts = urldecode(get_option('font_type_1'));
        $type = 2;
        break;
}
switch(get_option('font_source_2')) {
    case('System fonts') :
        $fonts2 = urldecode(get_option('font_type_2'));
        $type2 = 0;
        break;
    case('Custom fonts') :
        $fonts2 = urldecode(get_option('font_type_2'));
        $type2 = 1;
        break;
    case('Google fonts') :
    $fonts2 = urldecode(get_option('font_type_2'));
        $type2 = 2;
        break;
}
switch(get_option('font_source_3')) {
    case('System fonts') :
        $fonts3 = urldecode(get_option('font_type_3'));
        $type3 = 0;
        break;
    case('Custom fonts') :
        $fonts3 = urldecode(get_option('font_type_3'));
        $type3 = 1;
        break;
    case('Google fonts') :
        $fonts3 = urldecode(get_option('font_type_3'));
        $type3 = 2;
        break;
} 
?>
<?php if($type==1) : ?>
	@font-face {
		font-family: '<?php echo $fonts ?>';
		src: url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo $fonts; ?>.eot');
		src: <?php foreach(getExtCustomFonts($fonts) as $item) : ?> 
                    <?php $explode_item = explode(".", $item);                     
                    if($explode_item[1]=='eot') : ?>
                    url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo $explode_item[0]; ?>.eot?#iefix') format('embedded-opentype'),
                    <?php endif; 
                    if($explode_item[1]=='woff') : ?>
                    url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo $explode_item[0]; ?>.woff') format('woff'),
                    <?php endif; 
                    if($explode_item[1]=='ttf') : ?>
                    url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo $explode_item[0]; ?>.ttf') format('truetype');
                <?php endif; 
                endforeach; ?>
	}
<?php endif; ?>
<?php if($type2==1) : ?>
	@font-face {
		font-family: '<?php echo $fonts2 ?>';
		src: url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo $fonts2; ?>.eot');
		src: <?php foreach(getExtCustomFonts($fonts2) as $item) : ?> 
                    <?php $explode_item = explode(".", $item);                     
                    if($explode_item[1]=='eot') : ?>
                    url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo $explode_item[0]; ?>.eot?#iefix') format('embedded-opentype'),
                    <?php endif; 
                    if($explode_item[1]=='woff') : ?>
                    url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo $explode_item[0]; ?>.woff') format('woff'),
                    <?php endif; 
                    if($explode_item[1]=='ttf') : ?>
                    url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo $explode_item[0]; ?>.ttf') format('truetype');
                <?php endif; 
                endforeach; ?>
	}
<?php endif; ?>
<?php if($type3==1) : ?>
	@font-face {
		font-family: '<?php echo $fonts3 ?>';
		src: url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo $fonts3; ?>.eot');
		src: <?php foreach(getExtCustomFonts($fonts3) as $item) : ?> 
                    <?php $explode_item = explode(".", $item);                     
                    if($explode_item[1]=='eot') : ?>
                    url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo $explode_item[0]; ?>.eot?#iefix') format('embedded-opentype'),
                    <?php endif; 
                    if($explode_item[1]=='woff') : ?>
                    url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo $explode_item[0]; ?>.woff') format('woff'),
                    <?php endif; 
                    if($explode_item[1]=='ttf') : ?>
                    url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo $explode_item[0]; ?>.ttf') format('truetype');
                <?php endif; 
                endforeach; ?>
	}
<?php endif; ?>
<?php
    /* Main theme colors */
    $primary_color = get_option('primary_color', '#0ea7c3');
    $hover_color = get_option('hover_color', '#13bfdf');
    $headings_color = get_option('headings_color', '#000');
    $services_price = get_option('services_price', '#adeaf5');
    $text_color = get_option('text_color', '#444');
    $background_color = get_option('background_color', '#fff');
    
    function hex_to_rgb($hex) {
        $hex = str_replace('#','',$hex);
        if(strlen($hex)==3) {
            $hex = $hex.$hex;
        }
        $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
        return $rgb;
    }
    /* Darken function */
    function colourBrightness($hex, $percent) {
        // Work out if hash given
	$hash = '';
	if (stristr($hex,'#')) {
            $hex = str_replace('#','',$hex);
            $hash = '#';
	}
	$brightness = -(100 - $percent*2)/100;
	/// HEX TO RGB
	$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
	//// CALCULATE 
	for ($i=0; $i<3; $i++) {
            // See if brighter or darker
            if ($brightness > 0) {
                // Lighter
                $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
            } else {
		// Darker
                $positivePercent = $brightness - ($brightness*2);
		$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
            }
            // In case rounding up causes us to go to 256
            if ($rgb[$i] > 255) {
                $rgb[$i] = 255;
            }
	}
	//// RBG to Hex
	$hex = '';
	for($i=0; $i < 3; $i++) {
            // Convert the decimal digit to hex
            $hexDigit = dechex($rgb[$i]);
            // Add a leading zero if necessary
            if(strlen($hexDigit) == 1) {
                $hexDigit = "0" . $hexDigit;
            }
            // Append to the hex string
            $hex .= $hexDigit;
	}
	return $hash.$hex;
    }
?>
/* Text Color */
body {
  background-color: <?php echo $background_color;?>;
  color: <?php echo $text_color;?>;
}
/* Heading Color */
a,
h1, h2, h3, h4, h5, h6,
.services div li,
.no-results p,
.no-results li,
.search-page ol,
.site-footer.style-2 .widget-title {
  color: <?php echo $headings_color;?>;
}
.site-header .mobile-nav span {
  background-color: <?php echo $headings_color;?>;
}
/* Primary Color */
a:hover,
.icon:hover h2,
.icon .glyphicon:before,
.icon-group .icon:hover .glyphicon:before,
.featured-heading,
.color,
.btn-style-2,
.site-footer .menu li a:hover,
.radial-progress-bar canvas,
.sidebar a:hover,
.shoutbox h1,
.quote,
.services div .glyphicon,
.twitter a,
.posts .post-meta .author span, 
.persons .post-meta .author span,
.persons li a .open,
.sidebar .rfc_widget button:hover,
.services > ul > li button:hover,
.services > ul > li.selected button,
#infinite-handle,
.error-page h1,
.error-page h2 a,
.search-page .glyphicon,
.products li.product-style-2 .anps-wishlist .add_to_wishlist,
.products li.product-style-2 .product-btn-inner > a:hover,
.products li.product-style-2 .anps-compare a:hover {
  color: <?php echo $primary_color;?>;
}
input[type=checkbox]:checked + label:after {
  color: <?php echo $primary_color;?>;
}
.icon:hover .glyphicon,
.icon:after,
.featured-heading span:before,
.featured-heading span:after,
.btn-style-1,
.wishlist_table .add_to_cart.button,
.buttons .button,
.btn-style-2:hover,
.social-bookmarks li a,
.nav-tabs li a,
.nav-tabs li.active a:after,
.panel-group .panel .panel-title a:after,
.site-wrapper .author span,
.comment-list li header span,
#searchform input[type="submit"],
.services div h1,
.twitter span,
.posts .post-meta, 
.persons .post-meta,
.filter li button:hover,
.filter li button.selected,
div.light_square .pp_close,
.box,
.ls-move h1 em,
ul.page-numbers li .current,
.widget_calendar td a:hover {
  background-color: <?php echo $primary_color; ?>;
}
.site-header.header-type-2 .navigation > ul > li a:hover,
.site-header.header-type-2 .mobile-nav:hover,
.site-header.header-type-2 .current-menu-item > a {
  background-color: <?php echo $primary_color; ?> !important;  
}
input[type=radio]:checked + label:after {
  background-color: <?php echo $primary_color;?>;
}
.last:hover:after,
.last:hover:before,
.next:hover:after,
.next:hover:before {
    border-left-color: <?php echo $primary_color;?>;
}

.first:hover:before,
.first:hover:after,
.prev:hover:before, 
.prev:hover:after {
    border-right-color: <?php echo $primary_color;?>;
}
@media (min-width: 889px) {
  .navigation > ul > li .sub-menu .current-menu-item > a,
  .navigation a:hover {
    color: <?php echo $primary_color;?>;
  }
  .navigation > ul > li.current-menu-item > a {
    color: <?php echo $primary_color;?>;
  }
}
@media (max-width: 888px) {
  .navigation li {
    color: <?php echo $primary_color;?>;
  }
  .navigation a:before {
    background-color: <?php echo $primary_color;?>;
  }
}
.icon .glyphicon {
  border: 7px solid <?php echo $primary_color;?>;
}
.icon .glyphicon:after {
  border: 4px solid <?php echo $primary_color;?>;
}
.select-wrap:before {
  border-top: 4px solid <?php echo $primary_color;?>;
}
.btn-style-2 {
  border: 1px solid <?php echo $primary_color;?>;
}
.btn-style-2:after {
  border: 4px solid <?php echo $primary_color;?>;
}
.site-wrapper .author img {
  border: 6px solid <?php echo $primary_color;?>;
}
.social-bookmarks li a:hover {
  background-color: <?php echo $primary_color;?>;
  background-color: <?php echo colourBrightness($primary_color, 7);?>;
}
.posts .post-meta,
.persons .post-meta {
  background-color: <?php echo $primary_color;?>;
  background-color: <?php list($r, $g, $b) = hex_to_rgb($primary_color); ?> rgba(<?php echo $r;?>, <?php echo $g;?>, <?php echo $b;?>, 0.9);
}
.site-footer .copyright {
  background-color: <?php echo $primary_color;?>;
  background-color: <?php list($r, $g, $b) = hex_to_rgb($primary_color); ?> rgba(<?php echo $r;?>, <?php echo $g;?>, <?php echo $b;?>, 0.5);
}
.site-footer.style-2 .copyright {
  background-color: <?php echo $primary_color;?>;
}
/* Hover Color */

#infinite-handle span:hover,
.widget_calendar th,
.widget_calendar caption {
  color: <?php echo $hover_color;?>;
}

.widget_calendar td a {
  background-color: <?php echo $hover_color;?>;
}

.btn-style-2:hover,
.btn-style-2:hover:after {
  border-color: <?php echo $hover_color;?>;
}

.nav-tabs li a:hover,
.btn-style-1:hover,
.wishlist_table .add_to_cart.button:hover,
.buttons .button:hover,
#searchform input[type="text"]  {
  background-color: <?php echo $hover_color;?>;
}
/* Services Price Color */
.services div h1 span {
  color: <?php echo $services_price;?>;
}
/* Background Color */
.site-header,
.featured-heading span,
.persons li {
  background-color: #fff;
}
/* =Font Families
-------------------------------------------------------------- */
body,
input[type="text"],
textarea,
select,
.comment-list li header h1 {
  font-family: <?php echo $fonts3;?>;
}
h1, h2, h3, h4, h5,
.btn-style-1,
.wishlist_table .add_to_cart.button,
.buttons .button,
.radial-progress-bar,
.widget_tag_cloud a,
.widget_product_tag_cloud a,
.rfc_widget > ul li,
.services div li,
.persons li a .open,
#infinite-handle span,
.search-page input[type="text"],
.search-page ol {
  font-family: "<?php echo $fonts;?>", Arial;
}
.site-header,
.statement h2,
.twitter-feed h2,
.contact-info h2,
.statement h3,
.twitter-feed h3,
.contact-info h3,
.statement,
.twitter-feed,
.contact-info,
.header-quote,
.btn-style-2,
.site-footer,
.panel-group .panel .panel-title a:after,
.shoutbox h2,
.twitter,
.filter li button,
.ls-move h2 {
  font-family: '<?php echo $fonts2;?>', Arial, Helvetica;
}
li.comment.odd header span {
  background-color: #454545;
}

.site-footer .widget-title {
  color: #fff;
}

<?php global $options_data; if($options_data['preloader']): ?>

.site-wrapper {
  opacity: 0;
}

<?php endif; ?>

/* WooCommmerce */

.btn-style-3 {
  background-color: #414141;
}

.btn-style-3:hover {
  background-color: #616161;
}

.product h3,
.product_list_widget h4,
#lang_sel a.lang_sel_sel,
.top-bar #lang_sel:hover > a,
.top-bar #lang_sel ul ul :hover > a,
.woo-cart .amount,
.site-header .navigation .megamenu > ul.sub-menu .sub-menu li,
.single-product .quantity input[type="number"],
.summary .product_meta a:hover {
  color: <?php echo $primary_color;?>;
}

.order-status li a.current, .order-status li a.current:hover,
.sidebar .menu li.current-menu-item a,
.order-info mark,
.product-url-inner:before,
.top-bar,
.top-bar:before,
.top-bar:after,
.shop-banner:hover:before,
#reviews .comments li .comments-meta div,
.single-product-row .modal-header .close {
  background-color: <?php echo $primary_color;?>;
}

.order-status li a.current:after {
  border-left-color: <?php echo $primary_color;?>;
}

.top-bar #lang_sel a.lang_sel_sel:before {
  border-top: 4px solid <?php echo $primary_color;?>;
}

.checkout label,
.woo-register-form,
.order-info,
.price,
.product-url-inner .btn,
.price_slider_amount,
.widget-price,
.widget_shopping_cart .total {
  font-family: "<?php echo $fonts;?>", Arial;
}

.top-bar {
  font-family: "<?php echo $fonts2;?>", Arial;
}

#ship-to-different-address label,
#payment label,
.price,
.price_slider_amount,
.widget-price,
.widget_shopping_cart .total strong,
.no-link > a:hover {
  color: <?php echo $headings_color;?>;
}

.createacc input[type=checkbox] + label,
.order_details li,
.site-header .navigation .megamenu li > span {
  color: <?php echo $text_color;?>;
}

.ui-slider-handle {
  background-color: <?php echo $hover_color;?>;
}

.widget_price_filter .button,
.single-product .price,
.single-product-row .add_to_wishlist,
.summary .product_meta a {
  color: <?php echo $hover_color;?>;
}

.site-header rect {
  fill: <?php echo $primary_color;?>;
}

.site-header svg {
  height: 25px;
  width: 25px;
}