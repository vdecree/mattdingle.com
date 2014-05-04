<?php 
/* get blog categories */ 
$post_categories = wp_get_post_categories(get_the_ID());
?>
<article class="post">
    <header>
        <?php echo anps_header_media(get_the_ID()); ?>
        <h1><?php the_title();?></h1>
        <div class="post-meta-wrapper">
            <div class="post-meta">
                <a href='<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>' class='author'><?php echo get_avatar(get_the_author_meta('ID'), '88');?>             
                    <span><?php echo get_comments_number();?></span>
                </a>
                <span class="author-name"><?php echo __("by", ANPS_TEMPLATE_LANG)." ".get_the_author(); ?></span>
                <span class="date"><?php the_date("j / m / Y"); ?></span>
                <span class='categories'>
                    <?php $first_item = false;
                        foreach($post_categories as $c) {
                            $cat = get_category($c); 
                            if($first_item) {
                                echo " / ";
                            }
                            $first_item = true;
                            echo "<a href='".get_category_link($c)."'>".$cat->name."</a>";
                     } ?>
                </span>
            </div>
        </div>
    </header>
    <div class="post-content"><?php the_content(); ?></div>
</article>