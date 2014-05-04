<?php
include_once 'classes/Options.php';

$social_data = $options->get_social();
if (isset($_GET['save_social']))
  $options->save_social(); 
?>
<form action="themes.php?page=theme_options&sub_page=options_social_accounts&save_social" method="post">   
    <div class="content-top"><input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>" /><div class="clear"></div></div>
    <div class="content-inner">
        <!-- Social accounts data -->
        <h3><?php _e("Social accounts:", ANPS_TEMPLATE_LANG); ?></h3>

        <p><?php _e("Here you can set up all of your general social accounts. The email is used for the contact form.", ANPS_TEMPLATE_LANG); ?></p>
        <!-- Email -->
        <div class="input">
            <label for="email"><?php _e("Email", ANPS_TEMPLATE_LANG); ?></label>
            <input type="text" name="email" value="<?php echo $social_data['email']; ?>" />
        </div>
        <!-- Google analytics -->
        <div class="input">
            <label for="google_analytics">Google analytics</label>
            <input type="text" name="google_analytics" value="<?php echo $social_data['google_analytics']; ?>" />
        </div>

    </div>

    <div class="content-top" style="border-style: solid none; margin-top: 70px">
        <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">
        <div class="clear"></div>
    </div>
</form>