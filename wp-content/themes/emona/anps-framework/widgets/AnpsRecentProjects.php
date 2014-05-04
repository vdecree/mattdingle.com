<?php

class AnpsRecentProjects extends WP_Widget {

    function AnpsRecentProjects() {        
        $widget_ops = array('classname' => 'anps-recent-posts', 'description' => 'Shows recent projects');
        $this->WP_Widget('AnpsRecentProjects', 'AnpsThemes - Recent Projects', $widget_ops);
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array(
            'title' => '', 
            'anps_number_fields' => '', 
            'anps_recent_title' => '',
            'anps_comments_title' => ''
        ));

        $title = $instance['title'];
        $anps_number_fields = $instance['anps_number_fields'];
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>">Title for recent projects: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

        <p><label for="<?php echo $this->get_field_id('anps_number_fields'); ?>">Number of projects to show:</label>
            <input id="<?php echo $this->get_field_id('anps_number_fields'); ?>" name="<?php echo $this->get_field_name('anps_number_fields'); ?>" value="<?php echo esc_attr($anps_number_fields); ?>" type="text" value="5" size="3"></p>

        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['anps_number_fields'] = $new_instance['anps_number_fields'];
        return $instance;
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);

        $anps_number_fields = $instance['anps_number_fields'];

        echo $before_widget;

        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

        if (!empty($title)) {
            echo $before_title . $title . $after_title;;
        }

        /* Popular posts */

        $tab2 = "";

        $paged = '';
        $new_query = new WP_Query();
        $new_query->query('post_type=portfolio&paged=' . $paged . '&posts_per_page=' . $anps_number_fields . '&numberposts=' . $anps_number_fields . '&orderby=id&order="DESC"');

        //The Loop
        echo '<ul class="recent-blog-posts recent-projects">';

        while ($new_query->have_posts()) : $new_query->the_post(); 

            $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 720,405 ), false, '' ); ?>
            
            <li>
                <div style="background-image: url(<?php echo $src[0]; ?>);" class="image">
                <?php if (strpos(get_post_field('post_content', get_the_ID()), "[vimeo]") > -1) {

                    $content = get_post_field('post_content', get_the_ID());
                    $start = strpos($content, "[vimeo]");
                    $end = strpos($content, "[/vimeo]");

                    echo "<div class='video-outer'>" . do_shortcode(substr($content, $start, $end - $start + 8)) . "</div>";

                    } elseif (

                    strpos(get_post_field('post_content', get_the_ID()), "[youtube]") > -1) {

                    $check_if_text_only = false;
                    $content = get_post_field('post_content', get_the_ID());
                    $start = strpos($content, "[youtube]");
                    $end = strpos($content, "[/youtube]");

                    echo "<div class='video-outer'>" . do_shortcode(substr($content, $start, $end - $start + 10)) . "</div>";
                } else {
                    the_post_thumbnail($post->ID);
                }
                ?>
                </div>
                <div class="date">
                    <?php echo get_the_date("d/m/Y"); ?>
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
                <a href="<?php the_permalink(); ?>"><?php _e("Read more", ANPS_TEMPLATE_LANG); ?></a>
            </li>

        <?php endwhile;  

        echo '</ul>';

        echo $after_widget;
    }
}
add_action('widgets_init', create_function('', 'return register_widget("AnpsRecentProjects");'));