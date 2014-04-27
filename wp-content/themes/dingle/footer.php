<?php

	$args = array(
		'posts_per_page' => '3',
		'post_type' => 'gig'
	);

	$field = get_field("gig_datetime");
	$format = "dS M y";
	$timestamp” = get_field("gig_datetime");

	// get results
	$the_query = new WP_Query( $args );
?>


		<footer id="footer" role="footer">
		<div class="container">

			<div class="gig__feed--mini">
				<h3>Latest Gigs</h3>

				<ul>
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<li>
						<p class="gig__location"><?php the_field( "gig_location" ); ?></p>
						<time datetime="<?php echo date_i18n( "c" , get_field("gig_datetime") ); ?>"><?php echo date_i18n( $format, get_field("gig_datetime") ); ?></time>
						<?php if( get_field('gig_fee') ): ?>
							<span class="gig__fee">— Entry Fee &pound;<?php the_field( "gig_fee" ); ?></span>
						<?php endif; ?>
					</li>
					<?php endwhile; ?>
				</ul>

			</div> <!-- end gig feed -->
			
			<div class="contact__detail">
				<h3>Get in touch</h3>
				<p>
					<a href="#">hello@mattdingle.com</a><br />
					<em>Or visit the <a href="#">contact page</a>.</em>
				</p>
				<p>Alternatively visit me on <a href="#">Soundcloud</a></p>
			</div>
		</div>

		<div class="foot__note">
			<p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. | Built by <a href="http://visualdecree.co.uk">visualdecree.co.uk</a></p>
		</div>
		</footer>

	</div><!-- end page__content -->
</div> <!-- end page wrapper -->

<?php // all js scripts are loaded in library/bones.php ?>
<?php wp_footer(); ?>

</body>

</html> <!-- end of site. what a ride! -->
