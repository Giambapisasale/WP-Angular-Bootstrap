<?php
session_start();

require_once("common.inc.php");
require_once ("Proxy.php");


// testare inclusione in iframe?


if( isset($_REQUEST['action']) && !empty($_REQUEST['action']) ) {
	$action = $_REQUEST['action'];
	
	$test_consumer = new OAuthConsumer($key, $secret, NULL);
	
	$json_endpoint = file_get_contents($wp_json_url);
	$json_endpoint = json_decode($json_endpoint);
	
	$sig_method = $hmac_method;

	if (  $_REQUEST['action'] == "request_token" ) {
		//update status
		$_SESSION['status'] = array(
				"percentage"=> 20,
				"tip" => "request token",
				"FIN" => false,
		);
		
		$request_ep = $json_endpoint->authentication->oauth1->request;
		
		$token = NULL;
		$token_secret = NULL;
		
		try {

			$parsed = parse_url($request_ep);
			$params = array();
			parse_str($parsed['query'], $params);
			$req_req = OAuthRequest::from_consumer_and_token($test_consumer, NULL, "GET", $request_ep, $params);
			$req_req->sign_request($sig_method, $test_consumer, NULL);
			
			$req_res = file_get_contents($req_req); //aggiungere controllo fallimento della richiesta del token
			parse_str($req_res); //tramite questa funzione mi dichiaro queste variabili nello stesso scope chiamato dalla funzione
			$token = $oauth_token;
			$token_secret = $oauth_token_secret;
			
		} catch (Exception $e) {
			reportError("failed to retrieve token in request token");
		}
		//update status
		$_SESSION['status'] = array(
				"percentage"=> 40,
				"tip" => "auth url",
				"FIN" => false,
		);
		
		$authorize_ep = $json_endpoint->authentication->oauth1->authorize;
		
		$callback_url = "$base_url/client.php?action=access_token&key=$key&secret=$secret&token=$token&token_secret=$token_secret&endpoint=" . urlencode($authorize_ep);
		$auth_url = $authorize_ep . "?oauth_token=$token&oauth_callback=".urlencode($callback_url);
		
		Header("Location: $auth_url"); //invio al cliente header per il redirect
		

	} else if ( $_REQUEST['action'] == "access_token" ) {
		
		if ( !(isset($_REQUEST['token']) && !empty($_REQUEST['token']) && 
				isset($_REQUEST['token_secret']) && !empty($_REQUEST['token_secret'])) ) {
			reportError("invalid token or token_secret");
			exit();
		}
		$token = $_REQUEST['token'];
		$token_secret = $_REQUEST['token_secret'];
		$test_token = new OAuthConsumer($token, $token_secret);
		
		$_SESSION['status'] = array(
				"percentage"=> 60,
				"tip" => "access token",
				"FIN" => false,
		);
		
		$acc_res = NULL;
		
		try {

			$access_ep = $json_endpoint->authentication->oauth1->access;
			
			$parsed = parse_url($access_ep);
			
			$params = array();
			parse_str($parsed['query'], $params);
			
			$acc_req = OAuthRequest::from_consumer_and_token($test_consumer, $test_token, "GET", $access_ep, $params);
			$acc_req->sign_request($sig_method, $test_consumer, $test_token);
			$acc_req->set_parameter("oauth_verifier", $_GET["oauth_verifier"]);
			$acc_res = file_get_contents($acc_req);
		} catch (Exception $e) {
			reportError("failed to retrieve access token");
		}
		
		parse_str($acc_res);
		
		$data=array(
				"key"=> $key,
				"secret" => $secret,
				"token" => $oauth_token,
				"token_secret" => $oauth_token_secret
		);
		
		$_SESSION['status'] = array(
				"percentage"=> 80,
				"tip" => "acquiring data key",
				"FIN" => false,
		);
		
		$_SESSION['userKey'] = $data;
		$_SESSION['isLogged'] = true;
		
		// per effettuare una chiamata, recuperare dalla session i dati
		// TODO verificare se sono ancora validi, la chiamata restituira' 401 e
		// bisogna invalidare i dati attuali e ricominciare il processo di autorizzazione
		$data = $_SESSION['userKey'];
		$test_consumer = new OAuthConsumer($data["key"], $data["secret"], NULL);
		$test_token = new OAuthConsumer($data["token"], $data["token_secret"]);
		
		// imposto i parametri della chiamata che devo effettuare
		// in questo caso l'url lo conosco gia', ma un proxy deve poter rispondere
		// a qualsiasi url
		$options = array("type"=> "GET");
		// array che conterra' gli headers della chiamata, aggiungiamo header autenticazione
		// per adesso non e' usato perche' abbiamo direttamente la stringa dell'header completa
		$headers = array();
		// url della chiamata
		$url = $wp_json_url."/users/me";
		// parametri GET o POST aggiuntivi, devono arrivare dalla chiamata originaria
		$parameters = array();
		
		$request = OAuthRequest::from_consumer_and_token($test_consumer, $test_token, $options['type'], $url, $parameters);
		// costruisco la signature
		$request->sign_request($sig_method, $test_consumer, $test_token);
		
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
		$users_me_content = file_get_contents($url, false, $context);
		
		//   $oauth = new OAuth ( $data["key"], $data["secret"], OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION );
		//   $oauth->setToken ( $data["token"], $data["token_secret"] );
		//   $path = $wp_json_url."/users/me";
		//   $oauth->fetch ( $path );
		//   $response_info = $oauth->getLastResponseInfo();
		
		//   $_SESSION['userData'] = $oauth->getLastResponse();
		$_SESSION['userData'] =   $users_me_content;
		$_SESSION['status'] = array(
				"percentage"=> 100,
				"tip" => "complete",
				"FIN" => true,
		);
		
		echo "<script>parent.update_storage('".$_SESSION['userData']."');</script>";
		
		return;

	}else if ($action == "p") {
		
		if(isset($_GET['path']) && !empty($_GET['path']) &&
				isset($_SESSION['userData']) && isset($_SESSION['userKey']) ) {
					
			$function = $_GET['path'];
			if( isset($_SESSION['isLogged']) && $_SESSION['isLogged'] ) {
				
				if ( substr( $function, 0, 4 ) === "api/" )
					$proxy  = new Proxy($_SESSION['userKey'], $domain, $sig_method);
				else
					$proxy  = new Proxy($_SESSION['userKey'], $wp_json_url , $sig_method);
				
			} else 
				header('HTTP/1.1 401 Unauthorized', true, 401);
				
			
			echo $proxy->sendRequest($_GET['path']);
		}
	}else if ($action == "status") {
		
		if(isset($_SESSION['status'])) {
			header('Content-Type: application/json');
			echo json_encode($_SESSION['status']);
		}
	} else
		return reportError("no any action found");
	
}

function reportError($error) {
	header('Content-Type: application/json');
	echo json_encode($error);
}


