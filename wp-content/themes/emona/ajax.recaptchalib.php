<?php
require_once('anps-framework/recaptchalib.php');
include_once 'anps-framework/classes/Contact.php'; 
$contact_data = $contact->get_data();
if(!isset($contact_data))
    return;

foreach ($contact_data as $element) { 
    if($element['input_type']=='captcha') {
        $privatekey = $element['private_key']; 
    }
}

$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["amp;recaptcha_response_field"]);

if ($resp->is_valid) {
    ?>success<?php
} else {
    die("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
            "(reCAPTCHA said: " . $resp->error . ")");
}
