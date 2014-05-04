<?php 
include_once 'classes/Style.php';

if (isset($_GET['save_font']))
            $style->update_gfonts();
?>
<form action="themes.php?page=theme_options&sub_page=theme_style_google_font&save_font" method="post">
    <div class="content-inner">
        <h3><?php _e("Update google fonts", ANPS_TEMPLATE_LANG); ?></h3>                
        <center><input type="submit" class="dummy" value="<?php _e("Update google fonts", ANPS_TEMPLATE_LANG); ?>" /></center>
    </div>
</form>