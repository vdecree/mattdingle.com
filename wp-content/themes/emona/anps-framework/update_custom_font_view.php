<?php 
include_once 'classes/Style.php';

if (isset($_GET['save_font']))
            $style->upload_font();
?>
<div class="content">
<form action="themes.php?page=theme_options&sub_page=theme_style_custom_font&save_font" method="post" enctype="multipart/form-data">
    <div class="content-top">
        <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">
        <div class="clear"></div>
    </div>
    <div class="content-inner">
        <h3 style="margin-bottom: 30px"><?php _e("Upload custom fonts", ANPS_TEMPLATE_LANG); ?></h3>
        <div class="input"><input type="file" class="custom" name="font"/></div>    

    </div>

    <div class="content-top" style="border-style: solid none; margin-top: 230px">
        <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">
        <div class="clear"></div>
    </div>
</form>
</div>