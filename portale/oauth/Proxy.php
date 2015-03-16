<?php
require_once("OAuth.php");

class Proxy {
	
	public $myData = NULL;
	public $base_url = NULL;
	
	public function __construct($data, $base) {
		$this->myData = $data;	
		$this->base_url = $base;
	}
	
	function sendRequest($path) {
		try {
			if(myData == NULL) return;
			
			$oauth = new OAuth ( $this->myData["key"], $this->myData["secret"], OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION );
			$oauth->setToken ( $this->myData["token"], $this->myData["token_secret"] );
			
			$oauth->fetch ($this->base_url."/".$path );
			
			$response_info = $oauth->getLastResponseInfo ();
			header ( "Content-Type: {$response_info["content_type"]}" );
			echo $oauth->getLastResponse ();
		} catch ( OAuthException $E ) {
			echo "Exception caught: ". $E->getMessage();
		}
	}
}

?>