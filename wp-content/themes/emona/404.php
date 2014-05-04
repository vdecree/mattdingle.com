<?php get_header(); ?>
<?php
	if(isset($page_data['error_page']) && $page_data['error_page'] != '0') {
		$page = get_page( $page_data['error_page'] );
		echo do_shortcode(str_replace("&nbsp;", "<p><br /></p>", $page->post_content));
	}
?>
<?php get_footer(); ?>