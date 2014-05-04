<div class="envoo-admin">
    <ul class="envoo-admin-menu">
        <li><h2><?php _e("Theme Options", ANPS_TEMPLATE_LANG); ?></h2></li>
        <li>
            <a class="has-submenu" <?php if (!isset($_GET['sub_page']) || $_GET['sub_page'] == "theme_style" || $_GET['sub_page'] == "theme_style_google_font" || $_GET['sub_page'] == "theme_style_custom_font") echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=theme_style"><?php _e("Style Settings", ANPS_TEMPLATE_LANG); ?></a>
            <ul class="envoo-admin-submenu">
                <li><a <?php if (!isset($_GET['sub_page']) || $_GET['sub_page'] == "theme_style") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=theme_style"><?php _e("Theme Style", ANPS_TEMPLATE_LANG); ?></a></li>
                <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "theme_style_google_font") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=theme_style_google_font"><?php _e("Update google fonts", ANPS_TEMPLATE_LANG); ?></a></li>
                <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "theme_style_custom_font") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=theme_style_custom_font"><?php _e("Upload custom fonts", ANPS_TEMPLATE_LANG); ?></a></li>
            </ul>
        </li>
        <li>
            <a class="has-submenu" <?php if (isset($_GET['sub_page']) && ( $_GET['sub_page'] == "options" || $_GET['sub_page'] == "options_page_setup" || $_GET['sub_page'] == "options_social_accounts" || $_GET['sub_page'] == "options_media" )) echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=options"><?php _e("General Settings", ANPS_TEMPLATE_LANG); ?></a>
            <ul class="envoo-admin-submenu">
                <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "options") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=options"><?php _e("Page layout", ANPS_TEMPLATE_LANG); ?></a></li>
                <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "options_page_setup") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=options_page_setup"><?php _e("Page setup", ANPS_TEMPLATE_LANG); ?></a></li>
                <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "options_social_accounts") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=options_social_accounts"><?php _e("Social accounts", ANPS_TEMPLATE_LANG); ?></a></li>
                <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "options_media") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=options_media"><?php _e("Media", ANPS_TEMPLATE_LANG); ?></a></li>
            </ul>
        </li>
        <li>
            <a class="has-submenu" <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "shop_settings") echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=shop_settings"><?php _e("Shop Settings", ANPS_TEMPLATE_LANG); ?></a>
        </li>
        <li>
            <a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "contact_form") 
                        echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=contact_form"><?php _e("Contact Form", ANPS_TEMPLATE_LANG); ?></a>
        </li>
        <li>
            <a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "dummy_content") 
                        echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=dummy_content"><?php _e("Dummy Content", ANPS_TEMPLATE_LANG); ?></a>
        </li>
    </ul>
    <div class="envoo-admin-content">
        <?php
        if(!isset($_GET['sub_page']))
            $_GET['sub_page']='';
      
        switch($_GET['sub_page']) {
            case 'options': include_once 'options_page_view.php'; break;
            case 'options_page': include_once 'options_page_view.php'; break;
            case 'options_page_setup': include_once 'options_page_setup_view.php'; break;
            case 'options_social_accounts': include_once 'options_social_accounts_view.php'; break;
            case 'options_media': include_once 'options_media_view.php'; break;
            case 'contact_form': include_once 'contact_view.php'; break;
            case 'dummy_content': include_once 'dummy_view.php'; break;
            case 'theme_style_google_font': include_once 'update_google_font_view.php'; break;
            case 'theme_style_custom_font': include_once 'update_custom_font_view.php'; break;
            case 'shop_settings': include_once 'shop_settings.php'; break;
            default: include_once 'style_view.php';
        }

        ?>
    </div>
</div> 