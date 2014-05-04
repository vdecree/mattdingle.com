<?php

	global $shop_data;

	/* Disable woocommerce default css */

	add_filter( 'woocommerce_enqueue_styles', '__return_false' );

	/* Support for WooCommerce */

	add_theme_support("woocommerce");

	/* Change number or products per row */

	add_filter('loop_shop_columns', 'loop_columns');
	if (!function_exists('loop_columns')) {
		function loop_columns() {
			return 3;
		}
	}

	/* Remove the Short description content area */

	function remove_short_description() {
		remove_meta_box( 'postexcerpt', 'product', 'normal');
	}

	//add_action('add_meta_boxes', 'remove_short_description', 999);

	add_filter('loop_shop_columns', 'loop_columns', 999);

	/* Change the number of Related Products */

	function woo_related_products_limit() {
	  global $product;
		
		$args = array(
			'post_type'        		=> 'product',
			'no_found_rows'    		=> 1,
			'posts_per_page'   		=> 5,
			'ignore_sticky_posts' 	=> 1,
			'orderby'             	=> $orderby,
			'post__in'            	=> $related,
			'post__not_in'        	=> array($product->id)
		);
		return $args;
	}
	add_filter( 'woocommerce_related_products_args', 'woo_related_products_limit' );

	/* Change number of Upsell Products */

	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );
	 
	if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
		function woocommerce_output_upsells() {
		    woocommerce_upsell_display( 5,5 );
		}
	}

	/* WPML */

	function icl_post_languages() {
	  $languages = icl_get_languages('skip_missing=1');
	  if(1 < count($languages)){
	    echo __('This post is also available in:', "emona");
	    foreach($languages as $l){
	      if(!$l['active']) $langs[] = '<a href="'.$l['url'].'">'.$l['translated_name'].'</a>';
	    }
	    echo join(', ', $langs);
	  }
	}


	/* Mini cart */

    add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

    function woocommerce_header_add_to_cart_fragment($fragments) { 
	    global $woocommerce;
	    ob_start();
	    ?>

	    <a class="cart-contents">

		    <span class="cart-subtotal">
		    	<?php echo woocommerce_price($woocommerce->cart->subtotal); ?>
		    </span>

			<!--[if gte IE 9]><!-->
				<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 width="500px" height="500px" viewBox="0 0 500 500" enable-background="new 0 0 500 500" xml:space="preserve">
				<g>
					<rect x="30" y="133.415" width="445.772" height="361.585"/>
					<rect x="136.268" y="7.827" width="37.262" height="187.693"/>
					<rect x="136.151" y="7.33" width="236.023" height="37.259"/>
					<rect x="335.069" y="7.327" width="37.257" height="187.692"/>
				</g>
				</svg>
			<!--<![endif]-->

			<!--[if lte IE 8]>
			  <img title="<?php _e('Cart','woothemes'); ?>" src="<?php echo get_template_directory_uri(); ?>/images/cart_icon.png" width="25" height="25" />
			<![endif]-->
		</a>

		<?php woocommerce_mini_cart(); ?>
		
	    <?php
	    $fragments['a.cart-contents'] = ob_get_clean();
	    return $fragments;
    }

	function woo_mini_cart() {
		global $woocommerce;

        echo '<div class="woo-cart">';
        $cart = woocommerce_header_add_to_cart_fragment(""); 
        echo $cart ["a.cart-contents"];

        echo '</div>';
	}

    add_action('woo_nav_after', 'wootique_cart_button', 10);
    
    function wootique_cart_button() { 
    	global $woocommerce;
        echo current(woocommerce_header_add_to_cart_fragment());
    }

    /* Register Widget Area for Filter */

    register_sidebar(array(
        'name' => __('Filter', 'emona'),
        'id' => 'filter-widget-area',
        'description' => __('Filter widget area. Can only contain WooCommerce Price Filter and YITH WooCommerce Ajax Navigation widgets.', 'emona'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    /* Remove Breadcrumbs */

	remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);

	/* Load PrettyPhoto on Non-WooCommerce Pages */


    /* Order Status Bar */

    function order_status( $status ) {
    	global $woocommerce;
		$myaccount_url = get_permalink(get_option( 'woocommerce_myaccount_page_id' ));
		$cart_url = $woocommerce->cart->get_cart_url();
		$checkout_url = $woocommerce->cart->get_checkout_url();
		$payment_page = get_permalink( woocommerce_get_page_id( 'pay' ) );

		?>
			<ul class="order-status">
				<li class="first"><a <?php if( $status == "myaccout" ) { echo 'class="current"'; } ?> href="<?php echo $myaccount_url; ?>"><?php echo _e("Sign in", "emona"); ?></a></li>
				<li><a <?php if( $status == "cart" ) { echo 'class="current"'; } ?> href="<?php echo $cart_url; ?>"><?php echo _e("Cart", "emona"); ?></a></li>
				<li><a <?php if( $status == "checkout" ) { echo 'class="current"'; } ?> href="<?php echo $checkout_url; ?>"><?php echo _e("Checkout", "emona"); ?></a></li>
				<li class="last"><a <?php if( $status == "thankyou" ) { echo 'class="current"'; } ?> href="<?php echo $payment_page; ?>"><?php echo _e("Order Complete", "emona"); ?></a></li>
			</ul>
		<?php
    }

    /* My Account Sidebar */

    function myaccount_sidebar($page) { ?>

			<div class="col-md-3 sidebar">

				<h3><?php _e("My Account", "emona"); ?></h3>

				<ul class="myaccount-menu">
					<li class="widget-container widget_nav_menu">
						<div class="menu-main-menu-container">
							<ul class="menu">
								<li class="menu-item<?php if($page == "myaccount"){ echo " current-menu-item page_item current_page_item current_page_parent"; } ?>"><a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>"><?php _e("My Orders", "emona"); ?></a></li>
								<?php if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ): ?>
									<li class="menu-item<?php if($page == "wishlist"){ echo " current-menu-item page_item current_page_item current_page_parent"; } ?>"><a href="<?php echo get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ); ?>"><?php _e("My Wishlist", "emona"); ?></a></li>
								<?php endif; ?>
								<li class="menu-item<?php if($page == "address"){ echo " current-menu-item page_item current_page_item current_page_parent"; } ?>"><a href="<?php echo add_query_arg("subpage", "address", get_permalink( get_option( 'woocommerce_myaccount_page_id' ))); ?>"><?php _e("Address Book", "emona"); ?></a></li>
								<li class="menu-item<?php if($page == "change_account"){ echo " current-menu-item page_item current_page_item current_page_parent"; } ?>"><a href="<?php echo wc_customer_edit_account_url(); ?>"><?php _e("Change Account", "emona"); ?></a></li>
								<?php
								    if (is_user_logged_in()) {
								        echo '<li><a href="'. wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ) .'">' . __("Logout", "emona") . '</a></li>';
								    }
								?>
							</ul>
						</div>				
					</li>
				</ul>

			</div>
		<?php
    }

	/* Check if WishList and Copare plugins are active */

	function check_yith_woocommerce_wishlist() {
		if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ):
			return '<div class="anps-wishlist">' . strip_tags(do_shortcode("[yith_wcwl_add_to_wishlist]"), '<a><div><span><script>') . '</div>';
		endif; 
	}

	function check_yith_woocommerce_compare() {
		if ( in_array( 'yith-woocommerce-compare/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ): ?>
			<div class="anps-compare">
				<?php echo do_shortcode("[yith_compare_button]"); ?>
			</div>
		<?php endif; 
	}

	/* Remove Showing results functionality site-wide */

	function woocommerce_result_count() {
	    return;
	}

	/* Remove Default Sorting */

	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

	/* Add image size for custom widgets */

	add_image_size( "woocommerce-custom-widgets", "281", "284", true );

	/* Replace WooCommerce widgets with custom widgets */

	add_action( 'widgets_init', 'override_woocommerce_widgets', 15 );
	 
	function override_woocommerce_widgets() {
	 
		/* Best sellers */

		if ( class_exists( 'WC_Widget_Best_Sellers' ) ) {
			unregister_widget( 'WC_Widget_Best_Sellers' );
			include_once( 'widgets/widget-best-sellers.php' );
			register_widget( 'Custom_WC_Widget_Best_Sellers' );
		}
	 
		/* Featured products */

		if ( class_exists( 'WC_Widget_Featured_Products' ) ) {
			unregister_widget( 'WC_Widget_Featured_Products' );
			include_once( 'widgets/widget-featured-products.php' );
			register_widget( 'Custom_WC_Widget_Featured_Products' );
		}

		/* Random products */

		if ( class_exists( 'WC_Widget_Random_Products' ) ) {
			unregister_widget( 'WC_Widget_Random_Products' );
			include_once( 'widgets/widget-random-products.php' );
			register_widget( 'Custom_WC_Widget_Random_Products' );
		}

		/* Recently view products */

		if ( class_exists( 'WC_Widget_Recently_Viewed' ) ) {
			unregister_widget( 'WC_Widget_Recently_Viewed' );
			include_once( 'widgets/widget-recently-viewed.php' );
			register_widget( 'Custom_WC_Widget_Recently_Viewed' );
		}

		/* Recently added products */

		if ( class_exists( 'WC_Widget_Recent_Products' ) ) {
			unregister_widget( 'WC_Widget_Recent_Products' );
			include_once( 'widgets/widget-recent-products.php' );
			register_widget( 'Custom_WC_Widget_Recent_Products' );
		}

		/* Top rated products */

		if ( class_exists( 'WC_Widget_Top_Rated_Products' ) ) {
			unregister_widget( 'WC_Widget_Top_Rated_Products' );
			include_once( 'widgets/widget-top-rated-products.php' );
			register_widget( 'Custom_WC_Widget_Top_Rated_Products' );
		}

		/* Products */

		if ( class_exists( 'WC_Widget_Products' ) ) {
			unregister_widget( 'WC_Widget_Products' );
			include_once( 'widgets/widget-products.php' );
			register_widget( 'Custom_WC_Widget_Products' );
		}

		/* Recent Reviews */

		if ( class_exists( 'WC_Widget_Recent_Reviews' ) ) {
			unregister_widget( 'WC_Widget_Recent_Reviews' );
			include_once( 'widgets/widget-recent-reviews.php' );
			register_widget( 'Custom_WC_Widget_Recent_Reviews' );
		}

	}

	/* Producsts per page */

	global $shop_data;

	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return ' . $shop_data['shop_per_page'] . ';' ), 20 );

	/* Top bar */

	function top_bar() {
		if ( is_active_sidebar( 'top-bar-left') || is_active_sidebar( 'top-bar-right') ) {
			echo '<div class="top-bar"><div class="container">';
				echo '<ul class="left">';
					do_shortcode(dynamic_sidebar( 'top-bar-left' ));
				echo '</ul>';
				echo '<ul class="right">';
					do_shortcode(dynamic_sidebar( 'top-bar-right' ));
				echo '</ul>';
			echo '</div></div>';
		}
	}

	function get_mini_cart() {
	    global $shop_data;

	    if( ! isset($shop_data["hide_cart"]) && in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )) {
	        woo_mini_cart();
	    } elseif( isset($shop_data["hide_cart"]) && $shop_data["hide_cart"] != "on" && in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	    }
	}


	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );
	 
	if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
		function woocommerce_output_upsells() {
		    woocommerce_upsell_display(6,6); // Display 3 products in rows of 3
		}
	}
?>