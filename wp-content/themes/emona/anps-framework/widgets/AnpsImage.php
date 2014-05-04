<?php

class AnpsImage extends WP_Widget {

    public function __construct() {
        parent::__construct(
                'AnpsImages', 'AnpsThemes - Images', array('description' => __('Choose a image to show on page', ANPS_TEMPLATE_LANG),)
        );
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => ''));

        $title = $instance['title'];
        ?>
        <?php $images = & get_children('post_type=attachment&post_mime_type=image'); ?>
        <select id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>">
            <option value="">Select an image</option>
            <?php foreach ($images as $item) : ?>
                <option <?php if ($item->guid == $title) {
                    echo 'selected="selected"';
                } ?> value="<?php echo $item->guid; ?>"><?php echo $item->post_title; ?></option>
        <?php endforeach; ?>
        </select>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        return $instance;
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = $instance['title'];
        echo $before_widget;
        ?>

        <img alt="<?php echo $title; ?>" src="<?php echo $title; ?>" />

        <?php
        echo $after_widget;
    }

}

add_action( 'widgets_init', create_function('', 'return register_widget("AnpsImage");') );
