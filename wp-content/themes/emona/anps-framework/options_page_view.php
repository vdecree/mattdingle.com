<?php
include_once 'classes/Options.php';

$options_data = $options->get_page_data();  
if (isset($_GET['save_page']))
  $options->save_page();
?>
<form action="themes.php?page=theme_options&sub_page=options_page&save_page" method="post">

    <div class="content-top"><input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>" /><div class="clear"></div></div>

    <div class="content-inner">
        <!-- Page layout -->
        <h3><?php _e("Page layout:", ANPS_TEMPLATE_LANG); ?></h3>
        <p><?php _e("Here you can change all the settings about responsive layout and will your site be boxed (when checked you will have more options).", ANPS_TEMPLATE_LANG); ?></p>        
        <div class="info">
            <!-- Responsive -->
            <div class="input">
                <?php
                if(!isset($options_data['responsive']))
                    $checked='';
                elseif ($options_data['responsive'] == '-1')
                    $checked = '';
                elseif ($options_data['responsive'] == '')
                    $checked = '';
                else
                    $checked = 'checked';
                ?>
                <label for="responsive"><?php _e("Disable Responsive", ANPS_TEMPLATE_LANG); ?></label>
                <input class="small_input" style="margin-left: 74px" type="checkbox" name="responsive" <?php echo $checked; ?> />
            </div>
        <!-- Preloader enable/disable -->
            <div class="input">
                <?php 
                if(!isset($options_data['preloader']))
                    $checked='';
                elseif ($options_data['preloader'] == '-1')
                    $checked = '';
                elseif ($options_data['preloader'] == '')
                    $checked = '';
                else
                    $checked = 'checked';
                ?>
                <label for="preloader"><?php _e("Preloader enabled", ANPS_TEMPLATE_LANG); ?></label>
                <input class="small_input" style="margin-left: 74px" type="checkbox" name="preloader" <?php echo $checked; ?> />
            </div>
        <!-- END Menu hidden --> 


            <!-- Boxed -->
            <div class="input">
                <?php
                if(!isset($options_data['boxed']))
                    $checked='';
                elseif ($options_data['boxed'] == '-1')
                    $checked = '';
                elseif ($options_data['boxed'] == '')
                    $checked = '';
                else
                    $checked = 'checked';
                ?>
                <label for="boxed"><?php _e("Boxed", "emona"); ?></label>
                <input id="is-boxed" class="small_input" style="margin-left: 74px" type="checkbox" name="boxed" <?php echo $checked; ?> />

            </div>
            <!-- Pattern -->
            <div <?php if ($checked == "") echo 'style="display:none"'; ?> class="input" id="pattern-select-wrapper">
                <label for="pattern"><?php _e("Pattern", "emona"); ?></label>
                <div class="admin-patern-radio">
                    <?php for ($i = 0; $i < 10; $i++) :
                        if ($options_data['pattern'] == $i)
                            $checked = 'checked';
                        else
                            $checked = '';
                        ?>
                        <input type="radio" name="pattern" value="<?php echo $i; ?>" <?php echo $checked; ?>/>
                    <?php endfor; ?>
                </div>
                <div class="admin-patern-select">
                    <?php for ($i = 0; $i < 10; $i++) : ?>
                        <?php if ($options_data['pattern'] == $i): ?>
                            <img id="selected-pattern" src="<?php echo get_stylesheet_directory_uri(); ?>/images/patterns/patern<?php echo $i; ?>.png" />
                        <?php else: ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/patterns/patern<?php echo $i; ?>.png" />
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <div style="clear: both"></div>
            </div>
            <!-- Custom background -->
            <div class="input" <?php if (!isset($options_data['boxed']) || $options_data['pattern'] != 0 || $options_data['boxed'] == '-1' || $options_data['boxed'] == '') echo 'style="display: none"'; ?> id="patern-type-wrapper">
                <label for="pattern"><?php _e("Custom background type", "emona"); ?></label>
                <div class="patern-type">
                    <?php $types = array('stretched', 'tilled', 'custom color');
                    foreach ($types as $type) :
                        if(!isset($options_data['type']))
                            $checked='';
                        elseif ($options_data['type'] == $type)
                            $checked = 'checked';
                        else
                            $checked = '';
                        ?>
                        <input style="display: inline-block;" type="radio" id="back-type-<?php echo $type; ?>" name="type" value="<?php echo $type; ?>" <?php echo $checked; ?>/>
                        <label style="font-weight: normal;display: inline; margin: 0; cursor: pointer" for="back-type-<?php echo $type; ?>"><?php echo $type; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Custom pattern -->
            <div class="input"  <?php if ((!isset($options_data['boxed']) || $options_data['pattern'] != 0 || $options_data['boxed'] == '-1' || $options_data['boxed'] == '') || ($options_data['type'] != "stretched") && $options_data['type'] != "tilled" ) echo 'style="display: none"'; ?> id="custom-patern-wrapper">
                <label for="custom_pattern"><?php _e("Custom background image/pattern", "emona"); ?></label>
                <input id="custom_pattern" type="text" size="36" name="custom_pattern" value="<?php echo $options_data['custom_pattern']; ?>" />
                <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            </div>
            <!-- Custom background color -->

            <div id="custom-background-color-wrapper" class="input" <?php if ((!isset($options_data['boxed']) || $options_data['pattern'] != 0 || $options_data['boxed'] == '-1' || $options_data['boxed'] == '') || (!isset($options_data['type']) || $options_data['type'] != "custom color") ) echo 'style="display: none"'; ?>>
                <label for="bg_color"><?php _e("Custom background color", "emona"); ?></label>
                <input data-value="<?php echo $options_data['bg_color']; ?>" readonly style="background: <?php echo $options_data['bg_color']; ?>" class="color-pick-color"><input class="color-pick" type="text" name="bg_color" value="<?php echo $options_data['bg_color']; ?>" id="bg_color" />
            </div>
        
        <hr />
        <!-- Copyright -->
        <h3><?php _e("Copyright footer layout:", ANPS_TEMPLATE_LANG); ?></h3>

        <div class="input">
            <label for="copyright_text"><?php _e("Copyright footer status", ANPS_TEMPLATE_LANG); ?></label>
            <input type="text" name="copyright_text" value="<?php echo $options_data['copyright_text']; ?>" />
        </div>
        <!-- END Copyright -->
    </div>
</div>

<div class="content-top" style="border-style: solid none; margin-top: 70px">
    <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">
    <div class="clear"></div>
</div>
</form>

<?php
    if (isset($_GET['save_page'])) {
      update_option("rtl", $_POST['rtl']);
    }
?>