<?php include_once 'classes/Style.php'; 
/* Save form */
if(isset($_GET['save_style']))
    $style->save();
/* get all fonts */
$fonts = $style->all_fonts(); 
?>
<div class="content">
    <form action="themes.php?page=theme_options&save_style" method="post">
        <div class="content-top">
            <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">
            <div class="clear"></div>
        </div>
        <div class="content-inner">
            <h3><?php _e("Font family", ANPS_TEMPLATE_LANG); ?></h3>
            <div class="input">
                <label for="font_type_1">Font type 1</label>                    
                <select name="font_type_1" id="font_type_1">
                    <?php foreach($fonts as $name=>$value) : ?>
                    <optgroup label="<?php echo $name; ?>">
                    <?php foreach ($value as $font) : 
                            $selected = '';
                            if ($font['value'] == get_option('font_type_1', 'Arial, Helvetica, sans-serif'))
                                $selected = 'selected="selected"';                                
                            ?>
                            <option value="<?php echo $font['value']."|".$name; ?>" <?php echo $selected; ?>><?php echo $font['name']; ?></option>
                    <?php endforeach; ?>
                    </optgroup>  
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input">
                <label for="font_type_2"><?php _e("Font type 2", ANPS_TEMPLATE_LANG); ?></label>
                <select name="font_type_2" id="font_type_2">
                    <?php foreach($fonts as $name=>$value) : ?>
                    <optgroup label="<?php echo $name; ?>">
                    <?php foreach ($value as $font) :
                            $selected = '';
                            if ($font['value'] == get_option('font_type_2', 'Arial, Helvetica, sans-serif'))
                                $selected = 'selected="selected"';
    
                            ?>
                            <option value="<?php echo $font['value']."|".$name; ?>" <?php echo $selected; ?>><?php echo $font['name']; ?></option>
                    <?php endforeach; ?>
                    </optgroup>  
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input">
                <label for="font_type_3"><?php _e("Font type 3", ANPS_TEMPLATE_LANG); ?></label>
                <select name="font_type_3" id="font_type_3">
                    <?php foreach($fonts as $name=>$value) : ?>
                    <optgroup label="<?php echo $name; ?>">
                    <?php foreach ($value as $font) :
                            $selected = '';
                            if ($font['value'] == get_option('font_type_3', 'Arial, Helvetica, sans-serif'))
                                $selected = 'selected="selected"';
    
                            ?>
                            <option value="<?php echo $font['value']."|".$name; ?>" <?php echo $selected; ?>><?php echo $font['name']; ?></option>
                    <?php endforeach; ?>
                    </optgroup>  
                    <?php endforeach; ?>
                </select>
            </div>
            <br /><hr /><br />
            <h3><?php _e("Predefined color Scheme", ANPS_TEMPLATE_LANG); ?></h3>
            <p><?php _e("Selecting one of this schemes will import the predefined colors below, which you can then edit as you like.", ANPS_TEMPLATE_LANG); ?></p>
            <br /><br />
            <select name="predefined_colors" id="predefined_colors">
                <option></option>
                <option value="default">Default</option>
                <option value="green">Green</option>
                <option value="brown">Brown</option>
                <option value="red">Red</option>
                <option value="darkBlue">Dark Blue</option>
                <option value="purple">Purple</option>
                <option value="orange">Orange</option>
                <option value="grey">Grey</option>
            </select>
            <br /><br /><br /><hr />
            <h3><?php _e("Main theme colors", ANPS_TEMPLATE_LANG); ?></h3>
            <div class="input">
                <label for="primary_color"><?php _e("Primary color", ANPS_TEMPLATE_LANG); ?></label>
                <input data-value="<?php echo get_option('primary_color', '#0ea7c3'); ?>" readonly style="background: <?php echo get_option('primary_color', '#0ea7c3'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="primary_color" value="<?php echo get_option('primary_color', '#0ea7c3'); ?>" id="primary_color" />
            </div>
            <div class="input">
                <label for="hover_color"><?php _e("Hover color", ANPS_TEMPLATE_LANG); ?></label>
                <input data-value="<?php echo get_option('hover_color', '#13bfdf'); ?>" readonly style="background: <?php echo get_option('hover_color', '#13bfdf'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="hover_color" value="<?php echo get_option('hover_color', '#13bfdf'); ?>" id="hover_color" />
            </div>
            <div class="input">
                <label for="background_color"><?php _e("Background color", ANPS_TEMPLATE_LANG); ?></label>
                <input data-value="<?php echo get_option('background_color', '#fff'); ?>" readonly style="background: <?php echo get_option('background_color', '#fff'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="background_color" value="<?php echo get_option('background_color', '#fff'); ?>" id="background_color" />
            </div>            
            <div class="input">
                <label for="text_color"><?php _e("Text color", ANPS_TEMPLATE_LANG); ?></label>
                <input data-value="<?php echo get_option('text_color', '#444'); ?>" readonly style="background: <?php echo get_option('text_color', '#444'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="text_color" value="<?php echo get_option('text_color', '#444'); ?>" id="text_color" />
            </div>
            <div class="input">
                <label for="headings_color"><?php _e("Headings color", ANPS_TEMPLATE_LANG); ?></label>
                <input data-value="<?php echo get_option('headings_color', '#000'); ?>" readonly style="background: <?php echo get_option('headings_color', '#000'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="headings_color" value="<?php echo get_option('headings_color', '#000'); ?>" id="headings_color" />
            </div>
           <div class="input">
                <label for="services_price"><?php _e("Services price", ANPS_TEMPLATE_LANG); ?></label>
                <input data-value="<?php echo get_option('services_price', '#adeaf5'); ?>" readonly style="background: <?php echo get_option('services_price', '#adeaf5'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="services_price" value="<?php echo get_option('services_price', '#adeaf5'); ?>" id="services_price" />
            </div>
          
            <br/><br/><br/><br/><br/>
        </div>
        <div class="content-top" style="border-style: solid none">
            <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">
            <div class="clear"></div>
        </div>
    </form>
    <div class="clear"></div>    
</div>