<?php
include_once 'classes/Options.php';
$media_data = $options->get_media();
if (isset($_GET['save_media']))
    $options->save_media(); 
?>
<form action="themes.php?page=theme_options&sub_page=options_media&save_media" method="post">
    <div class="content-top"><input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>" /><div class="clear"></div></div>
    <div class="content-inner">
        <h3><?php _e("Favicon and logo:", ANPS_TEMPLATE_LANG); ?></h3>
        <!-- Favicon -->
        <div class="input">
            <label for="favicon"><?php _e("Favicon", ANPS_TEMPLATE_LANG); ?></label>
            <div class="preview"><img src="<?php echo $media_data['favicon']; ?>"></div>
            <input id="favicon" type="text" size="36" name="favicon" value="<?php echo $media_data['favicon']; ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p><?php _e("Enter an URL or upload an image for the favicon.", ANPS_TEMPLATE_LANG); ?></p>
        </div>
        <!-- Logo -->
        <div class="input">
            <label for="logo"><?php _e("Logo", ANPS_TEMPLATE_LANG); ?></label>
            <?php
                $logo_width = 82;
                $logo_height = 21;

                if( $media_data['logo-width'] ) {
                    $logo_width = $media_data['logo-width'];
                }
                
                if( $media_data['logo-height'] ) {
                    $logo_height = $media_data['logo-height'];
                }

                if( $media_data['logo'] ):
            ?>
            <div class="preview"><img width="<?php echo $logo_width; ?>" height="<?php echo $logo_height; ?>" src="<?php echo $media_data['logo']; ?>"></div>
        <?php endif; ?>
            <input id="logo" type="text" size="36" name="logo" value="<?php echo $media_data['logo']; ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p><?php _e("Enter an URL or upload an image for the logo.", ANPS_TEMPLATE_LANG); ?></p>
        </div>

        <div class="input">
            <label for="logo-width"><?php _e("Logo width", ANPS_TEMPLATE_LANG); ?></label>
            <input style="width: 100px;" id="logo-width" type="text" name="logo-width" value="<?php echo $logo_width; ?>" /> px
        </div>

        <div class="input">
            <label for="logo-height"><?php _e("Logo height", ANPS_TEMPLATE_LANG); ?></label>
            <input style="width: 100px;" id="logo-height" type="text" name="logo-height" value="<?php echo $logo_height; ?>" /> px
        </div>
    </div>
    <div class="content-top" style="border-style: solid none; margin-top: 70px">
        <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">
        <div class="clear"></div>
    </div>
</form>
<?php wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('my-upload', get_template_directory_uri() . 'anps-framework/upload_image.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_script('my-upload');
    wp_enqueue_style('thickbox');
?>