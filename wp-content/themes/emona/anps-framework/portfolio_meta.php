<?php 
add_action('add_meta_boxes', 'anps_portfolio_content_add_custom_box');
add_action('save_post', 'anps_portfolio_content_save_postdata');
function anps_portfolio_content_add_custom_box() {
    $screens = array('portfolio');
    foreach ($screens as $screen) {
        add_meta_box('anps_portfolio_meta', __('Portfolio left content', ANPS_TEMPLATE_LANG), 'display_portfolio_meta_box_content', $screen, 'normal', 'high');
    }
}
function display_portfolio_meta_box_content( $post ) {
        $value2 = get_post_meta( $post -> ID, $key = 'anps_left_content', $single = true );
        wp_editor($value2, 'left_content', array(
                'wpautop'       => true,
                'media_buttons' => false,
                'textarea_name' => 'anps_left_content',
                'textarea_rows' => 10,
                'teeny'         => true
                ));
}
function anps_portfolio_content_save_postdata($post_id) { 
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (empty($_POST)) {
        return;
    }
    if(!$_POST['post_ID']) {
        if(!$post_id) {
            return;
        } else {
            $_POST['post_ID'] = $post_id;
        }
    }
    if(!$_POST['post_type']) {
        return;
    }
    // Check permissions
    if ('portfolio' == $_POST['post_type']) { 
        if (!current_user_can('edit_page', $post_id))
            return;
    }
    else {
        if (!current_user_can('edit_post', $post_id))
            return;
    }
    $post_ID = $_POST['post_ID'];
    if (!isset($_POST['anps_left_content'])) {
        $_POST['anps_left_content'] = '';
    }
    $mydata2 = $_POST['anps_left_content'];
    add_post_meta($post_ID, 'anps_left_content', $mydata2, true) or update_post_meta($post_ID, 'anps_left_content', $mydata2);
}
