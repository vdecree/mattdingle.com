<?php
/*
 Template Name: Contact
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

<div id="page__content" role="main">

<div class="container">

<div class="content__left">

<?php while ( have_posts() ) : the_post(); ?>

     <h1><?php the_title(); ?></h1>

     <?php the_content(); ?>

<?php endwhile; // end of the loop. ?>

</div>

<?php include_once('sidebar-sidebar2.php') ?>

</div>

<?php get_footer(); ?>