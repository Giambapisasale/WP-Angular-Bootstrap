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
$wp_json_url= "http://localhost/WP-Angular-Bootstrap/wordpress/wp-json/";


// in caso di fallimento della prima request si potrebbero rigenerare?
$key = "Z0ib5A99Ffd6";
$secret = "Xu6VTDQmy0WjHFFLdjW0mPIy4CDFfYe1A9GSFtUBUr0KYPBA";

//signature utilizzata
$hmac_method = new OAuthSignatureMethod_HMAC_SHA1();


?>
