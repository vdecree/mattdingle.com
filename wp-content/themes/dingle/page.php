<?php get_header(); ?>

	<div id="page__content" role="main">

	<div class="container">

	<div class="content__left">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>

	 <?php // end article header ?>

	<?php endwhile; else : ?>

			<article id="post-not-found" class="hentry cf">
				<header class="article-header">
					<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
				</header>
				<section class="entry-content">
					<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
				</section>
				<footer class="article-footer">
						<p><?php _e( 'This is the error message in the page.php template.', 'bonestheme' ); ?></p>
				</footer>
			</article>

	<?php endif; ?>

	</div>

<?php include_once('sidebar-sidebar2.php') ?>

</div>

<?php get_footer(); ?>
