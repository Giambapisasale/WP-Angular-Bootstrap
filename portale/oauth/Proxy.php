<?php
require_once("OAuth.php");

class Proxy {
	
	public $myData = NULL;
	public $base_url = NULL;
	public $sig_method = NULL;
	public $test_consumer = NULL;
	public $test_token = NULL;
	
	public function __construct($data, $base_url, $sig_method) {
		$this->myData = $data;	
		$this->base_url = $base_url;
		$this->sig_method = $sig_method;
		
		$this->test_consumer = new OAuthConsumer($data["key"], $data["secret"], NULL);
		$this->test_token = new OAuthConsumer($data["token"], $data["token_secret"]);
		
	}
	
	function sendRequest($path) {
		try {
			if($this->myData == NULL) return FALSE;
			
			// imposto i parametri della chiamata che devo effettuare
			// in questo caso l'url lo conosco gia', ma un proxy deve poter rispondere
			// a qualsiasi url e qualsiasi metodo
			$options = array("type"=> "GET");
			// array che conterra' gli headers della chiamata, aggiungiamo header autenticazione
			// per adesso non e' usato perche' abbiamo direttamente la stringa dell'header completa
			$headers = array();
			// url della chiamata
			$url = $this->base_url."/".$path;
			// parametri GET o POST aggiuntivi, devono arrivare dalla chiamata originaria
			$parameters = array();
			
			$request = OAuthRequest::from_consumer_and_token($this->test_consumer, $this->test_token, $options['type'], $url, $parameters);
			// costruisco la signature
			$request->sign_request($this->sig_method, $this->test_consumer, $this->test_token);
			
			// costruisco header autenticazione
			$header = $request->to_header();
			//   // Strip leading 'Authorization:'
			//   $header = trim( substr( $header, 14 ) );
			//   trigger_error($header);
			//   $headers['Authorization'] = trim( $header, ' ' );
			
			// creo il context con le opzioni corrette
			$opts = array(
			'http'=>array(
					'method'=>"GET",
					'header'=>$header
			)
			);
			$context = stream_context_create($opts);
			
			// Open the file using the HTTP headers set above
			$content = file_get_contents($url, false, $context);
			return $content;
			
			
// 			$oauth = new OAuth ( $this->myData["key"], $this->myData["secret"], OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION );
// 			$oauth->setToken ( $this->myData["token"], $this->myData["token_secret"] );
			
// 			$oauth->fetch ($this->base_url."/".$path );
			
// 			$response_info = $oauth->getLastResponseInfo ();
// 			header ( "Content-Type: {$response_info["content_type"]}" );
// 			echo $oauth->getLastResponse ();
		} catch ( OAuthException $E ) {
			echo "Exception caught: ". $E->getMessage();
		}
	}
}

?>