<?php get_header(); ?>

<div class="container search-page">
        
        <div id="header-quote" class="header-quote parallax" style="background-image: url(images/about_us_shortcode_background.png);">
          <h1><?php _e("Looking for something?", ANPS_TEMPLATE_LANG); ?></h1>
        </div>

        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <h1 class="featured-heading"><span><?php _e("Search", ANPS_TEMPLATE_LANG); ?></span></h1>

        <h1 class="color"><?php _e("New search", ANPS_TEMPLATE_LANG); ?><small><?php _e("If you are not happy with the results below please do another search", ANPS_TEMPLATE_LANG); ?></small></h1>
        <form>
            <div>
                <input type="text" value="" name="s" id="s" placeholder="Type your search input here...">
                <div class="submit"><span class="glyphicon glyphicon-search"></span><input type="submit" id="searchsubmit" value=""></div>
            </div>
        </form>

        <?php if ( have_posts() ) : $num = wp_count_posts(); ?>

            <h2 class="search-heading"><?php echo $num->publish . ' ' . __( 'results found', ANPS_TEMPLATE_LANG ); ?></h2>

            <ol class="search-posts">
                <?php while ( have_posts() ) : the_post(); ?>

                    <li>
                        <a href="<?php echo the_permalink(); ?>#comments">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        </a>
                    </li>

                <?php endwhile; ?>
            </ol>
            <?php  get_template_part('includes/pagination'); ?>
        <?php else : ?>
            <h2><?php _e( 'Nothing Found', ANPS_TEMPLATE_LANG ); ?></h2>
            <div class="no-results">               
                <h3><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', ANPS_TEMPLATE_LANG ); ?></h3>
                <h4 class="color"><?php _e("Search results for: ", ANPS_TEMPLATE_LANG); ?><?php echo $_GET['s']; ?></h4>
                <p><?php _e("Nothing Found", ANPS_TEMPLATE_LANG); ?></p>
                <p><?php _e("Sorry, no posts matched your criteria. Please try another search.", ANPS_TEMPLATE_LANG); ?></p>
                <br>
                <p><?php _e("You might want to consider some of our suggestions to get better results:", ANPS_TEMPLATE_LANG); ?></p>
                <p>
                    <ul>
                        <li><?php _e("Check your spelling.", ANPS_TEMPLATE_LANG); ?></li>
                        <li><?php _e("Try a similar keyword, for example: tablet instead of laptop.", ANPS_TEMPLATE_LANG); ?></li>
                        <li><?php _e("Try using more than one keyword.", ANPS_TEMPLATE_LANG); ?></li>
                    </ul>
                </p>
            </div>
        <?php endif; ?>
</div>
<?php get_footer(); ?>
