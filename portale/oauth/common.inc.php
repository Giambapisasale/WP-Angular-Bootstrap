<?php
require_once("OAuth.php");

/*
 * Config Section
 */
$protocol = isset($_SERVER['HTTPS'])? "https://": "http://";
$domain = $protocol.$_SERVER['HTTP_HOST'];

// lasciare vuoto se si utilizza il virtualhost
// altrimenti impostare come il path tra http://localhost e l'istanza del progetto
// esempio: "/WP-Angular-Bootstrap"
$path = "/WP-Angular-Bootstrap";

$base = $path . "/portale/oauth";

//base_url indispensabile per il callback	
$base_url = $domain.$base;

//da questo url vengono recuperati gli endpoint corretti
$wp_json_url= $domain . $path . "/wordpress/wp-json";

// in caso di fallimento della prima request si potrebbero rigenerare?
$key = "1HQjAZMoDIwf";
$secret = "hBQg17sjD7GDUF2EmtFMRcp565Nssz25oaWYloPeFtaK2pjT";

//signature utilizzata
$hmac_method = new OAuthSignatureMethod_HMAC_SHA1();


?>
