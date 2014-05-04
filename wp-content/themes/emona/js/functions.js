"use strict";

var id, video_id, player;
function onPlayerReady(event) {
  event.target.mute();
}
function onYouTubePlayerAPIReady() {
  player = new YT.Player(id, {
    playerVars: { 'autoplay': 1, 'controls': 0,'autohide':1,'wmode':'opaque', 'showinfo':0, 'loop':1, 'playlist' : video_id },
    videoId: video_id,
    events: {
      'onReady': onPlayerReady}
  });
}
function sliderVideo(id_par, video_id_par) {
    var tag = document.createElement('script');
    tag.src = "http://www.youtube.com/player_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    id = id_par;
    video_id = video_id_par;
    var player;
}
function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{1,4})?$/;
    if (!emailReg.test(email)) {
        return false;
    } else {
        return true;
    }
}
function validateCaptcha() {
    var challengeField = jQuery("input#recaptcha_challenge_field").val();
    var responseField = jQuery("input#recaptcha_response_field").val();

    var html = jQuery.ajax({
        type: "POST",
        url: jQuery('#theme-path').val() + "/includes/validate_captcha.php",
        data: "recaptcha_challenge_field=" + challengeField + "&recaptcha_response_field=" + responseField,
        async: false
        }).responseText;

    if(html == "success") {
        return true;
    } else {
        return false;
    }
}
function validateContactNumber(number) {
    var numberReg = /^((\+)?[1-9]{1,3})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/;
    if (!numberReg.test(number)) {
        return false;
    } else {
        return true;
    }
}
function validateTextOnly(text) {
    var textReg = /^[A-z]+$/;
    if (!textReg.test(text)) {
        return false;
    } else {
        return true;
    }
}
function validateNumberOnly(number) {
    var numberReg = /^[0-9]+$/;
    if (!numberReg.test(number)) {
        return false;
    } else {
        return true;
    }
}
function checkElementValidation(child, type, check, error) {
    child.parent().find('.error-message').remove();
    if ( child.val() == "" && child.attr("data-required") == "required" ) {
        child.addClass("error");
        child.parent().append('<span class="error-message">' + child.parents("form").attr("data-required") + '</span>');
        child.parent().find('.error-message').css("margin-left", -child.parent().find('.error-message').innerWidth()/2);
        return false;
    } else if( child.attr("data-validation") == type && 
        child.val() != "" ) {
        if( !check ) {
            child.addClass("error");
            child.parent().append('<span class="error-message">' + error + '</span>');
            child.parent().find('.error-message').css("margin-left", -child.parent().find('.error-message').innerWidth()/2);
            return false;
        }
    }
    child.removeClass("error");
    return true;
}
function checkFormValidation(el) {
    var valid = true,
        children = el.find('input[type="text"], textarea');
    children.each(function(index) {
        var child = children.eq(index);
        var parent = child.parents("form");
        if( !checkElementValidation(child, "email", validateEmail(child.val()), parent.attr("data-email")) ||
            !checkElementValidation(child, "phone", validateContactNumber(child.val()), parent.attr("data-phone")) ||
            !checkElementValidation(child, "text_only", validateTextOnly(child.val()), parent.attr("data-text")) ||
            !checkElementValidation(child, "number", validateNumberOnly(child.val()), parent.attr("data-number")) 
        ) {
            valid = false;
        }
    });
    return valid;
}
jQuery.fn.serializeObject = function()
{
var o = {};
var a = this.serializeArray();
jQuery.each(a, function() {
    if (o[this.name]) {
        if (!o[this.name].push) {
            o[this.name] = [o[this.name]];
        }
        o[this.name].push(this.value || '');
    } else {
        o[this.name] = this.value || '';
    }
});
return o;
};
jQuery(function($) {
	$(".mobile-nav").on("click", function() {
        if( !$(".site-header").hasClass("header-type-2") ) {
            $(window).scrollTop(0);
        }
		$(".navigation").toggleClass("show");
		$(".site-header").toggleClass("show-mobile");
        if( $(window).scrollTop() < 200 && headerShowOnScroll && ! $(".site-header").hasClass("show-mobile") ) {
            $(".site-header").addClass("show-on-scroll");
        }
	});

    $('.nav-menu a[href*=#]:not([href=#])').on("click", function() {
        if( $(window).width() < 890 && $(".site-header").hasClass("show-mobile") ) {
            $(".mobile-nav").click();
        }
    });

    if( $(window).width() > 890 && $(".site-header").hasClass("header-type-2") ) {
        $(".mobile-nav").click();
    }

    window.requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame || function( callback ){ window.setTimeout(callback, 1000 / 60);};
     
    function draw(context, imd, arc_p, arc_r, quart, circ, counter, el, max) {
        context.putImageData(imd, 0, 0);
        context.beginPath();
        context.arc(arc_p, arc_p, arc_r, -(quart), -((circ) * counter/100) - quart, true);
        $(el).siblings("div").children("span").html((counter++) + "%");
        context.stroke();
        context.closePath();
        if( counter <= max ) {
            window.requestAnimationFrame(function(){draw(context, imd, arc_p, arc_r, quart, circ, counter, el, max)}, 1000); 
        }
    }

    /* Wrap select */
    $("form select:not(#billing_country)").wrap("<div class='select-wrap' />");
	/*----------------------------------------------------*/
	/* Preload site
	/*----------------------------------------------------*/
    var timer=null; 
    var circ = Math.PI * 2;
    var quart = Math.PI / 2;
    $.fn.radialProgressBar = function() {
        var counter = 1;
        var el = $(this).children("canvas");
        if( el[0].getContext ) {
            var context = el[0].getContext('2d');
            var imd_w, arc_p, arc_r, line_w;
            if( el.width() >= 121 ) {
                imd_w = 240;
                arc_p = 60;
                arc_r = 56;
                line_w = 7.0;
            } else if ( el.width() >= 77) {
                imd_w = 154;
                arc_p = 39;
                arc_r = 34;
                line_w = 4.0;             
            }
            var devicePixelRatio = window.devicePixelRatio || 1,
            backingStoreRatio = context.webkitBackingStorePixelRatio || context.mozBackingStorePixelRatio || context.msBackingStorePixelRatio || context.oBackingStorePixelRatio || context.backingStorePixelRatio || 1, 
            ratio = devicePixelRatio / backingStoreRatio;
            var imd = context.getImageData(0, 0, imd_w, imd_w);
            var max = $(el).attr("data-rpb-val");
            if (devicePixelRatio !== backingStoreRatio) {
                var oldWidth = $(el).width();
                var oldHeight = $(el).height();
                $(el).attr("width", oldWidth * ratio);
                $(el).attr("height", oldHeight * ratio);
                $(el).css("width", oldWidth + "px");
                $(el).css("height", oldHeight + "px");
                context.scale(ratio, ratio);
            }
            context.strokeStyle = el.css("color");
            context.lineWidth = line_w;
            draw(context, imd, arc_p, arc_r, quart, circ, counter, el, max);
        } else {
            $(el).siblings("div").children("span").html($(el).attr("data-rpb-val") + "%");
        }
    };
    var headerShowOnScroll = false;
    if( $(".site-header").hasClass("show-on-scroll") ) {
        headerShowOnScroll  = true;
    }
    $( window ).scroll(function() {
        if( $(window).scrollTop() > 200 && headerShowOnScroll ) {
            $(".site-header").removeClass("show-on-scroll");
        } else if( $(window).scrollTop() < 200 && headerShowOnScroll && ! $(".site-header").hasClass("show-mobile") ) {
            $(".site-header").addClass("show-on-scroll");
        }
    });
    /* Contact Form on SUBMIT */
    $('form input[type="text"]:not(#coupon_code), form textarea').wrap('<div class="form-row" />');
    $('input[type="text"], textarea').on("blur", function(){
        var parent = $(this).parents("form");
        if( !checkElementValidation($(this), "email", validateEmail($(this).val()), parent.attr("data-email")) ||
            !checkElementValidation($(this), "phone", validateContactNumber($(this).val()), parent.attr("data-phone")) ||
            !checkElementValidation($(this), "text_only", validateTextOnly($(this).val()), parent.attr("data-text")) ||
            !checkElementValidation($(this), "number", validateNumberOnly($(this).val()), parent.attr("data-number"))) {
        }
    });
    $('[data-form="submit"]').on('click', function(e) {
        $(this).parents('form[data-success]').submit();
        e.preventDefault();
    });
    $("form[data-success]").on("submit", function(e){
        var el = $(this);
        var formData = el.serializeObject();

        var captcha = true;

        if( $(".captcha").length > 0 ) {
            if(!validateCaptcha()) {
                captcha = false;
            }
            Recaptcha.reload();
        }
        
        if(checkFormValidation(el) && captcha) {
            try {
                $.ajax({
                    type: "POST",
                    url: $('#theme-path').val() + '/includes/mail.php',
                    data: {
                        form_data : formData,
                        to        : el.attr("data-to"),
                        from      : el.attr("data-from"),
                        subject   : el.attr("data-subject"),
                    },
                    success: function(msg) {
                        if( ! el.next().hasClass("success") ) {
                            $(el).after('<div class="success">' + el.attr("data-success") + '<span class="glyphicon glyphicon-remove"></span></div>');
                            $(el).next().find(".glyphicon-remove").on('click', function() {
                                $(this).parent().remove();
                            });
                        }
                    }
                });
            } catch(e) {}
        }
        e.preventDefault();
        return false;
    });
    /* Contact Form on Clear */
    $('[data-form="clear"]').on('click', function() {
        var el = $(this).parents('form[data-success]').find('input[type="text"], textarea');
        el.each(function(index) {
            el.eq(index).val("");
            el.eq(index).removeClass("error");
            el.eq(index).parent().find(".error-message").remove();
        });
        if( $(this).parents('form[data-success]').next().hasClass("success") ) {
            $(this).parents('form[data-success]').next().remove();
        }
        return false;
    });  
    /* Featured/Recent/Comments Widget */
    $(".rfc_widget button").on("click", function() {
        var index = $(this).parent().index();
        if(index == 2) {
            index = 1;
        } else if (index == 4) {
            index = 2;
        }
        $(".rfc_widget div").removeClass("on");
        $(".rfc_widget div").eq(index).addClass("on");
    });
    $(".services button").on("click", function() {
        var index = $(this).parent().index();
        $(".services > ul > li").removeClass("selected");
        $(".services > ul > li > div").removeClass("visible");
        $(".services > ul > li").eq(index).addClass("selected");
        $(".services > ul > li").eq(index).children("div").addClass("visible");
    });
    /* Portfolio */
    try {
        var $container = $('.isotope');
        var first_scroll = true;
        $(window).scroll(function() {
            if(first_scroll) {
                $container.isotope();
                first_scroll = false;
            }
        });
        $(window).focus(function(){
            $container.isotope();
        });
        $container.isotope({
            itemSelector : '.isotope li',
            layoutMode: 'fitRows',
            animationOptions: {
                duration: 750,
                queue: false,
            }
        });
        $('.filter button').on('click', function() {
            $('.filter button').removeClass('selected');
            $(this).addClass("selected");
            var item = "";
            if( $(this).attr('data-filter') != '*' ) {
                item = ".";
            }
            item += $(this).attr('data-filter');
            $container.isotope({ filter: item });
        });
        $(window).smartresize(function(){
            var item = "";
            if( $('.filter').length > 0 ) {
                if( $('.filter button.selected').attr('data-filter') != '*' ) {
                    item = ".";
                }
                item += $('.filter button.selected').attr('data-filter');
            } else {
                item = '*';
            }

            $container.isotope({ filter: item });
        });
    } catch (e) { }
   /* Navigation links (smooth scroll) */
    $('.nav-menu a[href*=#]:not([href=#]), .ls-layer a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
            || location.hostname == this.hostname) {
          var target = $(this.hash);
          var href = $.attr(this, 'href');
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top - 105
            }, 1000, function () {
                //window.location.hash = href;
            });
            return false;
          }
        }
    });
    var navLinkIDs = "";
    $('.nav-menu a[href*=#]:not([href=#])').each(function(index) {
        if(navLinkIDs != "") {
            navLinkIDs += ", ";
        }
        var str = $('.nav-menu a[href*=#]:not([href=#])').eq(index).attr("href").split('/');
        navLinkIDs += str[str.length-1];
    });

    $.fn.isOnScreen = function(){
         
        var win = $(window);
         
        var viewport = {
            top : win.scrollTop(),
            left : win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();
         
        var bounds = this.offset();
        bounds.right = bounds.left + this.outerWidth();
        bounds.bottom = bounds.top + this.outerHeight();
         
        return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
         
    };

    function onScreen() {
        $('.nav-menu li').removeClass("current-menu-item");

        $('.nav-menu a[href*=#]:not([href=#])').each(function(index) {
            var str = $('.nav-menu a[href*=#]:not([href=#])').eq(index).attr("href").split('/');
            var el = $(str[str.length-1]);
            if( el.length > 0 ) {
                if(el.isOnScreen()){
                    $('.nav-menu a[href*=#]:not([href=#])').eq(index).parent().addClass("current-menu-item");
                    return false;
                };
            }
        });
    }

    if ($("body.home").length > 0) {
        $(window).scroll(function() {
            onScreen();
        });
    }

    onScreen();
        

    $('.radial-progress-bar').waypoint(function(direction) {
        var el = $(this);
        if( ! el.hasClass("animated") ) {
            el.addClass('animated');
            setTimeout(function() {
                el.radialProgressBar();
            }, 100);
        }
    }, { offset: '100%' });
try {
    $("a[rel^='prettyPhoto']").prettyPhoto({
    theme: 'light_square',
    changepicturecallback: function() { 
    if($(".pp_pic_holder").height() > $(window).height()) {
        $("body").css("overflow", "hidden");
        $(".pp_pic_holder").addClass("pp-mobile");
    }
    $(".pp_inline .radial-progress-bar").each(function(index) {
        $(".pp_inline .radial-progress-bar").eq(index).radialProgressBar()
    });
    },
    callback: function(){
        $("body").css("overflow-y", "scroll");
        $(".pp_pic_holder").removeClass("pp-mobile");        
    },
    markup: '<div class="pp_pic_holder"> \
                <div class="ppt">&nbsp;</div> \
                <div class="pp_top"> \
                  <div class="pp_left"></div> \
                  <div class="pp_middle"></div> \
                  <div class="pp_right"></div> \
                </div> \
                <div class="pp_content_container"> \
                  <div class="pp_left"> \
                  <div class="pp_right"> \
                    <div class="pp_content"> \
                  <a class="pp_close" href="#"> \
                    <span class="glyphicon glyphicon-remove"></span> \
                  </a> \
                      <div class="pp_loaderIcon"></div> \
                      <div class="pp_fade"> \
                        <a href="#" class="pp_expand" title="Expand the image">Expand</a> \
                        <div class="pp_hoverContainer"> \
                          <a class="pp_next" href="#">next</a> \
                          <a class="pp_previous" href="#">previous</a> \
                        </div> \
                        <div id="pp_full_res"></div> \
                        <div class="pp_details"> \
                          <div class="pp_nav"> \
                            <a href="#" class="pp_arrow_previous">Previous</a> \
                            <p class="currentTextHolder">0/0</p> \
                            <a href="#" class="pp_arrow_next">Next</a> \
                          </div> \
                          <p class="pp_description"></p> \ \
                        </div> \
                      </div> \
                    </div> \
                  </div> \
                  </div> \
                </div> \
                <div class="pp_bottom"> \
                  <div class="pp_left"></div> \
                  <div class="pp_middle"></div> \
                  <div class="pp_right"></div> \
                </div> \
              </div> \
              <div class="pp_overlay"></div>',
              });
} catch(e) {}
    try {
    $("[data-twitter]").each(function(index) {
        var el = $("[data-twitter]").eq(index);
        $.ajax({
            type: "POST",
            url: window.location.protocol + '//' + window.location.hostname + (window.location.port === '' ? '' : ':'+ window.location.port) + window.location.pathname + '/php/twitter.php',
            data: {
                account : el.attr("data-twitter")
            },
            success: function(msg) {
                el.prepend(msg);
            }
        });
        
    });
} catch(e) {}

$('.widget_calendar td').each(function(index) {
    if( ! $('.widget_calendar td').eq(index).has('a').length ) {
        $('.widget_calendar td').eq(index).wrapInner('<span>');
    }
});

$('.widget_search .glyphicon, .search-page .glyphicon, .widget_product_search .glyphicon').on('click', function(){
    $(this).parents('form').find('input[type="submit"]').click();
});

/* WordPress JS */
$('button[data-form="clear"]').on('click', function() {
   $('textarea, input[type="text"]').val(''); 
});
$('button[data-form="submit"]').on('click', function() {
   $('.form-submit #submit').click(); 
});
$("blockquote").addClass("quote left").prepend('<i class="fa fa-quote-right"></i>');

$('.searchform input[type="submit"], .widget_product_search input[type="submit"]').val('').wrap('<div class="submit" />');
$('.searchform .submit, .widget_product_search .submit').prepend('<span class="glyphicon glyphicon-search"></span>');
$('.searchform input[type="text"]').attr('placeholder', 'search');

$('.widget_categories li, .widget_archive li').each(function(index){
    var tmp = $('.widget_categories li, .widget_archive li').eq(index).children('a');
    $('.widget_categories li, .widget_archive li').eq(index).children('a').remove();
    $('.widget_categories li, .widget_archive li').eq(index).wrapInner('<span />');
    $('.widget_categories li, .widget_archive li').eq(index).prepend(tmp);
    $('.widget_categories li, .widget_archive li').eq(index).children('a').append( $('.widget_categories li, .widget_archive li').eq(index).children('span') );
});

/* PrettyPhoto (02.01.2013) */
$('[data-rel-type]').each(function(index){
    if(window.location.href.indexOf($('[data-rel-type]').eq(index).attr("data-rel-type")+"/" + index + "/") > -1) {
       $('[data-rel-type]').eq(index).click();
    }
});

/* LayerSlider new version */

function addNewStyle(newStyle) {
    var styleElement = document.getElementById('styles_js');
    if (!styleElement) {
        styleElement = document.createElement('style');
        styleElement.type = 'text/css';
        styleElement.id = 'styles_js';
        document.getElementsByTagName('head')[0].appendChild(styleElement);
    }
    styleElement.appendChild(document.createTextNode(newStyle));
}

// Uncomment the two line below if you want the LayerSlider
// height to match the size of the browser window

/*
    addNewStyle('.ls-wp-fullwidth-container, .ls-wp-fullwidth-helper, .ls-wp-container {height: ' + $(window).height() + 'px !important;}');
    addNewStyle('@media (max-width: 1024px) {.ls-wp-fullwidth-container, .ls-wp-fullwidth-helper, .ls-wp-container {height: 300px !important;}}');  
*/

/* WooCommerce */

$(".cart-update").on("click", function () {
    $("input[name='update_cart']").click();
});
$(".cart-checkout").on("click", function () {
    $("input[name='proceed']").click();
});

$('.top-bar #searchform .submit input[type="submit"]').on('click', function() {
    if( !$('.top-bar #searchform').hasClass('opened') ) {
        $('.top-bar #searchform').addClass('opened');
        return false;
    }
});

$('[name="send-woo-comment"]').on('click', function(){
    $('.form-submit [name="submit"]').click();
});

/* WooCommerce Product Image LightBox */

function changeProductImage() {
    $(".product-gallery img").attr("src", $(".thumbnails a").eq(currentProductThumb).attr("href"));
}

if( $(".yith_magnifier_gallery").length > 0 ) {
    $(".thumbnails li").on("click", function() {
        $(".thumbnails li").children("a").removeClass("active");
        $(this).children("a").addClass("active");
    });
}
else if( $(".single-product").length > 0 ) {

    var currentProductThumb = 0;
    var numProductThumb = $(".thumbnails a").length;

    $(".thumbnails a").on("click", function() {
        currentProductThumb = $(this).index();
        $(".thumbnails a").removeClass("active");
        $(this).addClass("active");
        $(".woocommerce-main-image img, .product-gallery img").attr("src", $(this).attr("href"));
        return false;
    });

    $(".modal-prev").on("click", function () {
        if( currentProductThumb > 0 ) {
            currentProductThumb--;
            changeProductImage();
        }
    });

    $(".modal-next").on("click", function () {
        if( currentProductThumb < numProductThumb-1 ) {
            currentProductThumb++;
            changeProductImage();
        }
    });

    $(".product-gallery").on("hidden.bs.modal", function() {
        $(".product-gallery img").attr("src", $(".thumbnails a.active").attr("href"));
    });
}

var el = $('.site-header');
var top = parseInt(el.css('margin-top'));
var hasAdminBar = $('.admin-bar').length > 0;

if(hasAdminBar) {
    top -= 32;
}

$(window).scroll(function() {
    if( $(window).scrollTop() >= top && ! el.hasClass('show-mobile') ) {
        el.addClass('fixed');
    } else {
        el.removeClass('fixed');
    }
});

var elProductBug = $(".products li .product-url-inner > div");
elProductBug.each(function(index){
    var start = elProductBug.eq(index).html().indexOf('<div class="product-btn-wrapper">');
    elProductBug.eq(index).html( elProductBug.eq(index).html().substr(start) );
});

$('.anps-wishlist').hover(function() {
    $(this).parents('.product-inner').children('.product-url').addClass('hover');
}, function() {
    $(this).parents('.product-inner').children('.product-url').removeClass('hover');
});
});