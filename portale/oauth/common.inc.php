<?php
require_once("OAuth.php");

/*
 * Config Section
 */
$domain = $_SERVER['HTTP_HOST'];
$base = "/portale/oauth";

//base_url indispensabile per il callback	
$base_url = "http://$domain$base";

//da questo url vengono recuperati gli endpoint corretti
$wp_json_url= "http://$domain/wordpress/wp-json/";


// in caso di fallimento della prima request si potrebbero rigenerare?
$key = "qg1qm8seOmwF";
$secret = "F0fofyGe8X9kloOzrzE6xzktk35Ed2s7DHXfojVAiR7fWYoG";

//signature utilizzata
$hmac_method = new OAuthSignatureMethod_HMAC_SHA1();


?>
