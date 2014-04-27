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

<div id="side__bar">
	<div class="side__gigfeed">
		<h3>Latest Gigs</h3>
		<ul>
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<li>
				<p class="gig__location"><?php the_field( "gig_location" ); ?></p>
				<time datetime="<?php echo date_i18n( "c" , get_field("gig_datetime") ); ?>"><?php echo date_i18n( $format, get_field("gig_datetime") ); ?></time>
				<?php if( get_field('gig_fee') ): ?>
					<span class="gig_fee">— Entry Fee &pound;<?php the_field( "gig_fee" ); ?></span>
				<?php endif; ?>
			</li>
			<?php endwhile; ?>
		</ul>
	</div> <!-- end gigfeed -->

	<div class="button__group">
		<a href="#" class="btn btn--med btn--gold">Get in touch</a>
	</div>
</div> <!-- end sidebar -->
