<?php
require_once('../../../../wp-load.php');
include_once get_template_directory().'/anps-framework/classes/Contact.php'; 
$contact_data = $contact->get_data();

load_template(TEMPLATEPATH . '/anps-framework/recaptchalib.php');

global $contact_data;
$publickey = $contact_data['public_key']; 
$privatekey = $contact_data['private_key'];

$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    echo "fail";
} else {
    echo "success";
}