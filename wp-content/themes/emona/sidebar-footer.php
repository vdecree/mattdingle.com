<?php
$footer_columns = get_option('footer_style', '2'); 
if($footer_columns=='1') : ?>
<footer class="site-footer parallax">
	<div class="container">
		<div class="row">
			<div class="col-md-8"><ul><?php do_shortcode(dynamic_sidebar( 'footer-left' )); ?></ul></div>
			<div class="col-md-4"><ul><?php do_shortcode(dynamic_sidebar( 'footer-right' )); ?></ul></div>
		</div>
	</div>
<?php elseif($footer_columns=='2' || $footer_columns=='0') : ?>
<footer class="site-footer style-2">
	<div class="container">
		<div class="row">
			<div class="col-md-3"><ul><?php do_shortcode(dynamic_sidebar( 'footer-1' )); ?></ul></div>
			<div class="col-md-3"><ul><?php do_shortcode(dynamic_sidebar( 'footer-2' )); ?></ul></div>
			<div class="col-md-3"><ul><?php do_shortcode(dynamic_sidebar( 'footer-3' )); ?></ul></div>
			<div class="col-md-3"><ul><?php do_shortcode(dynamic_sidebar( 'footer-4' )); ?></ul></div>
		</div>
	</div>
<?php elseif($footer_columns=='3') : ?>
<footer class="site-footer style-2">
	<div class="container">
		<div class="row">
			<div class="col-md-3"><ul><?php do_shortcode(dynamic_sidebar( 'footer-1' )); ?></ul></div>
			<div class="col-md-3"><ul><?php do_shortcode(dynamic_sidebar( 'footer-2' )); ?></ul></div>
			<div class="col-md-3"><ul><?php do_shortcode(dynamic_sidebar( 'footer-3' )); ?></ul></div>
			<div class="col-md-3"><ul><?php do_shortcode(dynamic_sidebar( 'footer-4' )); ?></ul></div>
		</div>
	</div>
</footer>
<footer class="site-footer parallax">
	<div class="container">
		<div class="row">
			<div class="col-md-8"><ul><?php do_shortcode(dynamic_sidebar( 'footer-left' )); ?></ul></div>
			<div class="col-md-4"><ul><?php do_shortcode(dynamic_sidebar( 'footer-right' )); ?></ul></div>
		</div>
	</div>
<?php endif; ?>
