<?php
    global $blog_post_class, $counter;
    $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), "full", false, '' );

    //$youtube_videos = getVideos("[youtube]", "[/youtube]", str_replace('[youtube hide="true"]', '[youtube]', get_the_content()), 9, 9);
    //$vimeo_videos = getVideos("[vimeo]", "[/vimeo]", str_replace('[vimeo hide="true"]', '[vimeo]', get_the_content()), 7, 7);

    $media = $src[0];
    $media_type = "image";
    $media_popover = get_the_post_thumbnail($post->ID, "full");

    /*if( $youtube_videos ) {
        $media = 'http://img.youtube.com/vi/' . $youtube_videos[0] . '/maxresdefault.jpg';
        $media_type = "video";
        $media_popover = do_shortcode('[youtube]' . $youtube_videos[0] . '[/youtube]');
    } elseif( $vimeo_videos ) {
        $media = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $vimeo_videos[0] . '.php'));
        $media = $media[0]['thumbnail_large']; 
        $media_type = "video";
        $media_popover = do_shortcode('[vimeo]' . $vimeo_videos[0] . '[/vimeo]');
    }*/

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

<div class="<?php echo $blog_post_class; ?>">
    <article id="post-<?php the_ID(); ?>" <?php post_class(" post-column"); ?>>

        <a class="column-header" data-toggle="modal" href="#featured-posts-<?php echo $counter; ?>" style="background-image: url(<?php echo $media ?>)">
            <h3><?php the_title(); ?></h3>
            <?php if( $media_type == 'image' ): ?>
                <span class="glyphicon glyphicon-share-alt"></span>
            <?php else: ?>
                <span class="glyphicon glyphicon-film"></span>
            <?php endif; ?>
        </a>

        <div class="post-content">
            <?php if(get_option("rss_use_excerpt") == "0"): ?>
                <?php the_content(); ?>
            <?php else: ?>                    
                <?php the_excerpt(); ?>
            <?php endif; ?>
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

        <?php echo $popover; ?>
    </article>
</div>