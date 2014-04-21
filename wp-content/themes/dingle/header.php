<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // Google Chrome Frame for IE ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>

	</head>

	<body <?php body_class(); ?>>

		<?php include_once("library/images/svg-defs.svg"); ?>

		<div id="page__wrapper">

		<header id="header" role="banner">
			<div class="container">

					<a href="#" id="logo">
						<svg viewBox="0 0 353.59 93.53" class="icon shape-logo">
						  <use xlink:href="#shape-logo"></use>
						</svg>
					</a>

					<?php // to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> ?>
					<!-- <p id="logo" class="h1"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?></a></p> -->

					<?php // if you'd like to use the site description you can un-comment it below ?>
					<?php // bloginfo('description'); ?>


					<div id="controls">
						<nav class="nav" id="js-nav" role="navigation">
						<!-- <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'dingle' ); ?></a> -->
						 <?php wp_nav_menu( array(
							 'container' =>false,
							 'menu_class' => 'nav__list',
							 'echo' => true,
							 'before' => false,
							 'after' => false,
							 'link_before' => '',
							 'link_after' => '',
							 'depth' => 0,
							 'walker' => new Description_Walker())
							 ); 
						 ?>
						</nav><!-- #site-navigation -->
					</div> <!-- end controls -->

				</div>

			</header>
