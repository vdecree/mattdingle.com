<?php

  require_once('../../../../wp-load.php');

  global $wpdb, $yith_wcwl, $woocommerce;
  $wishlist = "";

  if( isset( $_GET['user_id'] ) && !empty( $_GET['user_id'] ) ) {
      $user_id = $_GET['user_id'];
  } elseif( is_user_logged_in() ) {
      $user_id = get_current_user_id();
  }

  if( is_user_logged_in() )
  { $wishlist = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `" . YITH_WCWL_TABLE . "` WHERE `user_id` = %s" . $limit_sql, $user_id ), ARRAY_A ); }
  elseif( yith_usecookies() )
      { $wishlist = yith_getcookie( 'yith_wcwl_products' ); }
  else
      { $wishlist = isset( $_SESSION['yith_wcwl_products'] ) ? $_SESSION['yith_wcwl_products'] : array(); }
    
  echo count($wishlist);

?>