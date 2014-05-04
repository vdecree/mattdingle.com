<?php global $options_data; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php anps_is_responsive(false); ?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php anps_theme_styles(); ?>
	<?php anps_theme_after_styles(); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(anps_is_responsive(true));?><?php anps_body_style();?>>
	<div class="site-wrapper<?php anps_boxed(); ?>">

		<?php anps_get_header(); ?>