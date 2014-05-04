<?php
class AnpsRecentPopularComment extends WP_Widget
{
  function AnpsRecentPopularComment()
  {
    $widget_ops = array('classname' => 'AnpsRecentPopularComment', 'description' => 'Shows a box with most popular posts, most recent posts and comments.' );
    $this->WP_Widget('AnpsRecentPopularComment', 'Anps Recent/Popular/Comments box', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'anps_number_fields' => '', ) );
    $anps_number_fields = $instance['anps_number_fields'];
?>
  <p><label for="<?php echo $this->get_field_id('anps_number_fields'); ?>"><?php _e("Number of posts/comments to show:", ANPS_TEMPLATE_LANG); ?></label>
  <input id="<?php echo $this->get_field_id('anps_number_fields'); ?>" name="<?php echo $this->get_field_name('anps_number_fields'); ?>" value="<?php echo esc_attr($anps_number_fields); ?>" type="text" value="5" size="3"></p>
  
  </p>
   <?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['anps_number_fields'] = $new_instance['anps_number_fields'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    global $wpdb;
    $anps_number_fields = $instance['anps_number_fields'];
    
    echo $before_widget;
        
    ?>
  <ul>
      <li><?php _e("Recent", ANPS_TEMPLATE_LANG); ?></li>
      <li><?php _e("Featured", ANPS_TEMPLATE_LANG); ?></li>
      <li><?php _e("Comments", ANPS_TEMPLATE_LANG); ?></li>
  </ul>  
<div class="on links">
    <?php 
    $paged = '';
    $new_query = new WP_Query();
    $new_query->query( 'paged='.$paged . '&posts_per_page=' . $anps_number_fields . '&numberposts=' .  $anps_number_fields .'&orderby=comment_count&order="DESC"' );
    echo "<ul>";
    //The Loop
    while ($new_query->have_posts()) : $new_query->the_post(); ?>
    <li>
        <a class="post" href="<?php echo get_permalink(get_the_ID()) . '" title="'.get_the_title().'"'; ?>"><?php echo get_the_title(); ?></a>
    </li>              
  <?php endwhile; ?>
</ul>
</div>
<div class="links">
    <?php 
    $paged = '';
    $new_query = new WP_Query();
    $new_query->query( 'paged='.$paged . '&posts_per_page=' . $anps_number_fields . '&numberposts=' .  $anps_number_fields .'&orderby=id&order="DESC"' );
    echo "<ul>";
    //The Loop
    while ($new_query->have_posts()) : $new_query->the_post();?>
    <li>
        <a class="post" href="<?php echo get_permalink(get_the_ID()) . '" title="'.get_the_title().'"'; ?>"><?php echo get_the_title(); ?></a>
    </li>               
  <?php endwhile; ?>
</ul>
</div>  
<div class="comments">
    <?php
      global $wpdb;
      $sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url, SUBSTRING(comment_content,1,30) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT " . $anps_number_fields;
      $comments = $wpdb->get_results($sql);
      echo "<ul>";
      foreach ($comments as $comment) {
        $comment2 = $comment;
        $comment = get_comment($comment->comment_ID);
        echo '<li><a href="'. get_permalink($comment2->ID).'">'.$comment->comment_content.'</a></li>';
            }
        ?>
</ul>
</div>
    <?php
 
    echo $after_widget;

  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("AnpsRecentPopularComment");') );