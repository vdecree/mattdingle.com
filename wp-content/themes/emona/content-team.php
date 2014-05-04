<?php 
require_once('../../../wp-load.php');
$args = array(
        'post_type' => 'team',
        'p' => $_GET['id']
    );
global $is_in_person;
$is_in_person = true;
$team_posts = new WP_Query( $args ); 
while($team_posts->have_posts()) : 
    $team_posts->the_post(); 
?>
<div class="person">
  <div class="left">
    <div class="image-wrapper"><?php echo get_the_post_thumbnail(get_the_ID(), 'team'); ?></div>
    <h2><?php the_title(); ?></h2>
  </div>
  <div class="right">
    <h2><?php echo get_post_meta( get_the_ID(), $key = 'anps_team_subtitle', $single = true ); ?></h2>
    <?php
    $team_tags = "";       
        if (get_the_terms(get_the_ID(), 'team_tags')) {
            $first_item = false;
            foreach (get_the_terms(get_the_ID(), 'team_tags') as $tag) {
                if($first_item) {
                    $team_tags .= ", ";
                }
                $first_item = true;
                $team_tags .= strtolower(str_replace(" ", "-", $tag->name));
            }
        }
    ?>
    <small><?php echo $team_tags; ?></small>
    <?php the_content(); ?>
  </div>
</div>
<?php endwhile; $is_in_person = false; ?>