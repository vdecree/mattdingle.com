<?php include_once 'classes/Contact.php';
if (isset($_GET['save_contact']))
    $contact->save_data();

$contact_data = $contact->get_data();
?>

<form action="themes.php?page=theme_options&sub_page=contact_form&save_contact" method="post">
    <div class="content-top"><input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>" /><div class="clear"></div></div>
    <div class="content-inner">
        <h3><?php _e("Captcha", ANPS_TEMPLATE_LANG); ?></h3>
        <p><?php _e("Public and private key for captcha.", ANPS_TEMPLATE_LANG); ?></p>
            <div class="form_fields_wrapper">
                        <!-- PUBLIC KEY -->
                        <div class="input label-place-val contact-public">
                            <label for="public_key">Public key</label>
                            <input type="text" name="public_key" value="<?php echo $contact_data['public_key']; ?>" />
                        </div>
                        <!-- END PUBLIC KEY -->
                        <!-- PRIVATE KEY -->
                        <div class="input label-place-val contact-private">
                            <label for="private_key">Private key</label>
                            <input type="text" name="private_key" value="<?php echo $contact_data['private_key']; ?>" />
                        </div>
                        <!-- END PRIVATE KEY -->
                    </div>
            </div>  
    <div class="content-top" style="border-style: solid none; margin-top: 50px">
        <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">
        <div class="clear"></div>
    </div>
</form>