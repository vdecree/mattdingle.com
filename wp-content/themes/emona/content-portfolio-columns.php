<?php
    global $page_data;

    $page = get_page($page_data["portfolio_page"]);
    if($page->post_content != ""){
        echo do_shortcode($page->post_content);
    }
?>

<?php

function getVideos ($shortcode_start, $shortcode_end, $shortcode_content, $offset1, $offset2) {
    $offset = 0; $videos = array();
    while(true) { $start = strpos($shortcode_content, $shortcode_start, $offset);$end = strpos($shortcode_content, $shortcode_end, $start); $offset = $end;
        if ( ! $start ) { break; }
        array_push($videos, substr($shortcode_content, $start + $offset1, $end - $start - $offset2));
    }
    return $videos;
}

$meta = get_post_meta(get_the_ID());

$left_sidebar = 0;
if (isset($meta['sbg_selected_sidebar']))
    $left_sidebar = $meta['sbg_selected_sidebar'];

$right_sidebar = 0;
if (isset($meta['sbg_selected_sidebar_replacement']))
    $right_sidebar = $meta['sbg_selected_sidebar_replacement'];

$max_per_pages = $page_data["limit_items"];
$filter_status = false;
if(isset($page_data["filter_pag"])){
    $filter_status = $page_data["filter_pag"];
}
$number_of_columns = $page_data["pagination_type"];

if(isset($_GET['type'])) {
    $number_of_columns = str_replace("-", " ", $_GET['type']);
}

switch ($number_of_columns) {
    case "1 column": $number_of_columns = "one-column";
        break;
    case "2 column": $number_of_columns = "two-column";
        break;
    case "3 column": $number_of_columns = "three-column";
        break;
    case "4 column": $number_of_columns = "four-column";
        break;
}

if (function_exists('is_plugin_active') && is_plugin_active('colorpicker/colorpicker.php')) {
    switch ($_GET['type']) {
        case "2-column": $number_of_columns = "two-column";
            break;
        case "3-column": $number_of_columns = "three-column";
            break;
        case "4-column": $number_of_columns = "four-column";
            break;
    }
}

$args = array(
    'post_type' => 'portfolio',
    'orderby' => 'id',
    'order' => 'DESC',
    'numberposts' => -1,
);

$thumbnail_args = array(
    'alt' => "",
    'title' => "",
);

$current_number = 0;
$current_class = 1;
$oposite_side = 1;

$portfolio_class = "full";
$portfolio_posts = get_posts($args);

$per_row = 2;
$cols_class = " cols-2";

if( $number_of_columns ==  'three-column' ) {
    $cols_class = " cols-3";
    $per_row = 3;
} elseif( $number_of_columns ==  'four-column' ) {
    $cols_class = " cols-4";
    $per_row = 4;
} 

$counter = 1;

echo '<input type="hidden" class="layout-template" value="' . $layout_template . '">';
?>

<input id="max_per_page" type="hidden" value="<?php echo $max_per_pages; ?>" >

<?php

$myterms = get_terms('portfolio_category', 'orderby=none&hide_empty');
if ($portfolio_posts):
    if ($filter_status):
        ?>
        <div class="box portfolio-filter">

            <ul id="filters" class="portfolio-filters" data-option-key="filter">   

                <li><a href="#filter" class="selected-filter" data-filter="*">All</a></li>

                <?php
                $filters = get_terms('portfolio_category', 'orderby=none&hide_empty');

                foreach ($filters as $filter) {
                    echo '<li><a href="#filter" data-filter="' . strtolower(str_replace(" ", "-", $filter->name)) . '">' . $filter->name . '</a></li>';
                }
                ?>

            </ul>

        </div>
    <?php endif; ?>

    <div class="main-wrapper portfolio-wrapper" <?php
    if (!$filter_status) {
        echo 'style="margin-top: -60px"';
    }
    ?>>
        <ul class="portfolio clearfix" id="isotope-container">

            <?php foreach ($portfolio_posts as $post) : setup_postdata($post); ?>

                <?php
                    $blog_post_class = "2-column";
                    $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), "full", false, '' );

                    $youtube_videos = getVideos("[youtube]", "[/youtube]", str_replace('[youtube hide="true"]', '[youtube]', get_the_content()), 9, 9);
                    $vimeo_videos = getVideos("[vimeo]", "[/vimeo]", str_replace('[vimeo hide="true"]', '[vimeo]', get_the_content()), 7, 7);

                    $media = $src[0];
                    $media_type = "image";
                    $media_popover = get_the_post_thumbnail($post->ID, "full");

                    if( $youtube_videos ) {
                        $media = 'http://img.youtube.com/vi/' . $youtube_videos[0] . '/maxresdefault.jpg';
                        $media_type = "video";
                        $media_popover = do_shortcode('[youtube]' . $youtube_videos[0] . '[/youtube]');
                    } elseif( $vimeo_videos ) {
                        $media = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $vimeo_videos[0] . '.php'));
                        $media = $media[0]['thumbnail_large']; 
                        $media_type = "video";
                        $media_popover = do_shortcode('[vimeo]' . $vimeo_videos[0] . '[/vimeo]');
                    }

                    $popover = '<div class="modal modal-image fade" id="featured-posts-' . $counter . '" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">' . $media_popover . '</div>
                                    </div>
                                </div>
                            </div>';
                ?>

                <li class="post-column<?php echo $cols_class; ?><?php echo $class; ?> isotope-item post <?php echo ' page-' . $current_class . ' ' . $number_of_columns; ?> clearfix <?php
            if (get_the_terms($post->ID, 'portfolio_category')) {
                foreach (get_the_terms($post->ID, 'portfolio_category') as $cat) {
                    echo strtolower(str_replace(" ", "-", $cat->name)) . " ";
                }
            }
                    ?><?php if($counter % $per_row == 0){ echo ' last'; } ?>">

                        <a class="column-header" data-toggle="modal" href="#featured-posts-<?php echo $counter; ?>" style="background-image: url(<?php echo $media ?>)">
                            <h3><?php the_title(); ?></h3>
                            <?php if( $media_type == 'image' ): ?>
                                <span class="glyphicon glyphicon-share-alt"></span>
                            <?php else: ?>
                                <span class="glyphicon glyphicon-film"></span>
                            <?php endif; ?>
                        </a>

                        <div class="post-content">                
                            <?php echo get_excerpt(); ?>
                        </div>

                        <footer>
                            <?php if( $media_type == 'image' ): ?>
                                <span class="glyphicon first glyphicon-pencil"></span>
                            <?php else: ?>
                                <span class="glyphicon first glyphicon-play-circle"></span>
                            <?php endif; ?>
                            <span><?php echo get_the_date('F d, Y'); ?></span>

                            <div class="devider"></div>

                            <span class="glyphicon glyphicon-user"></span>
                            <span><?php echo get_the_author(); ?></span>

                            <div>
                                <a class="btn btn-sm btn-style1" href="<?php the_permalink(); ?>">
                                    <?php _e("Read more", ANPS_TEMPLATE_LANG); ?>
                                </a>
                            </div>
                        </footer>
                        <?php $counter++; ?>
                </li>
            <?php echo $popover; ?>

            <?php endforeach; ?>
        </ul> 
    </div>

    <div class="main-wrapper">

        <div class="pagination box jquery-pagination clearfix">     

            <div data-post-number="<?php echo $wp_query->found_posts; ?>" data-max-pages="<?php echo $max_per_pages; ?>" class="pagination-data">
            
            <ul class="page-numbers">
                <li><a class="previous">&#8592;</a></li>
                
                <?php
                    if ($portfolio_posts) {
                        $number_of_pages = ceil(count($portfolio_posts) / $max_per_pages);
                    }
                    for ($i = 1; $i <= $number_of_pages; $i++) {
                        $selected = '';
                        if ($i == 1) {
                            $selected = 'current';
                        }
                        echo '<li><a class="page-numbers ' . $selected . ' pagination-value">' . $i . '</a></li>';
                    }
                ?>
                <li><a class="nxt">&#8594;</a></li>
            </ul>
            </div>
            <?php wp_reset_query(); ?>
        </div>
    </div>
    <?php
else:
    echo "<h4 style='margin: 10px 0 30px 0'>" . __("No Portfolio posts found!", ANPS_TEMPLATE_LANG) . "</h4>";
endif;    