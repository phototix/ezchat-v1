<?php
// Step 1: Capture the OAuth code
if ($code<>"") {

    // Step 2: Exchange code for access token
    $client_id = "2066061130512912";
    $client_secret = "b9732de3e729cc4e821a55cf72dff230";
    $redirect_uri = "https://portal-v2.ezy.chat/meta_signup";

    $token_url = "https://graph.facebook.com/v15.0/oauth/access_token?client_id=$client_id&redirect_uri=$redirect_uri&client_secret=$client_secret&code=$code";

    $response = file_get_contents($token_url);
    $access_token = json_decode($response)->access_token;

    // Step 3: Use the access token to retrieve WABA information
    $waba_url = "https://graph.facebook.com/v15.0/me/accounts?access_token=$access_token";
    $waba_info = file_get_contents($waba_url);
    echo $waba_info; // This contains information about the WABA account
}

if ($error_code<>""&&$error_message<>"") {
    echo "[$error_code] ".$error_message;
}
?>
