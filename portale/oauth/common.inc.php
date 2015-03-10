<?php
require_once("OAuth.php");
// require_once("../OAuth_TestServer.php");

/*
 * Config Section
 */
$domain = $_SERVER['HTTP_HOST'];
$base = "/portale/oauth";

//base_url indispensabile per il callback
$base_url = "http://$domain$base";

//da questo url vengono recuperati gli endpoint corretti
$wp_json_url= "http://portale.local/wordpress/wp-json/";


// in caso di fallimento della prima request si potrebbero rigenerare?
$key = "3ZkI7e9Y472N";
$secret = "Dc0VFJ7FmiXRbd8quHtfBbt98uNdKADDmZN4ioQCVhZOD6k6";

//signature utilizzata
$hmac_method = new OAuthSignatureMethod_HMAC_SHA1();


?>
