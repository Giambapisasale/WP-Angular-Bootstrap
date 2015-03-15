<?php
require_once("OAuth.php");

class Proxy {
	
	public $myData = NULL;
	
	public function __construct($data) {
		$this->myData = $data;	
	}
	
	function sendRequest($path) {
		try {
			if(myData == NULL) return;
			
			$oauth = new OAuth ( $myData->key, $myData->secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION );
			$oauth->setToken ( $myData->token, $myData->token_secret );
			
			$oauth->fetch ( $path );
			
			$response_info = $oauth->getLastResponseInfo ();
			header ( "Content-Type: {$response_info["content_type"]}" );
			echo $oauth->getLastResponse ();
		} catch ( OAuthException $E ) {
			echo "Exception caught!\n";
			echo "Response: " . $E->lastResponse . "\n";
		}
	}
}

?>