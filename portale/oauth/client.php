<?php
session_start();

require_once("common.inc.php");
require_once ("Proxy.php");


if( isset($_REQUEST['action']) && !empty($_REQUEST['action']) ) {
	$action = $_REQUEST['action'];
	
	$test_consumer = new OAuthConsumer($key, $secret, NULL);
	
	$json_endpoint = null;
	if(!empty($_SESSION['endpoints'])) {
		$json_endpoint = $_SESSION['endpoints'];
	} else {
		$json_endpoint = file_get_contents($wp_json_url);
		$json_endpoint = json_decode($json_endpoint);
		$_SESSION['endpoints'] = $json_endpoint;
		
	}
	session_write_close();
	
	
	$sig_method = $hmac_method;

	if ( $action == "request_token" ) {
		//update status
		session_start();
		$_SESSION['status'] = array(
				"percentage"=> 20,
				"tip" => "request token",
				"FIN" => false,
		);
		session_write_close();
		
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
		session_start();		
		$_SESSION['status'] = array(
				"percentage"=> 40,
				"tip" => "auth url",
				"FIN" => false,
		);
		session_write_close();
		
		$authorize_ep = $json_endpoint->authentication->oauth1->authorize;
		
		$callback_url = "$base_url/client.php?action=access_token&key=$key&secret=$secret&token=$token&token_secret=$token_secret&endpoint=" . urlencode($authorize_ep);
		$auth_url = $authorize_ep . "?oauth_token=$token&oauth_callback=".urlencode($callback_url);
		
		Header("Location: $auth_url"); //invio al cliente header per il redirect
		

	} else if ( $action == "access_token" ) {
		
		if ( !(isset($_REQUEST['token']) && !empty($_REQUEST['token']) && 
				isset($_REQUEST['token_secret']) && !empty($_REQUEST['token_secret'])) ) {
			reportError("invalid token or token_secret");
			exit();
		}
		$token = $_REQUEST['token'];
		$token_secret = $_REQUEST['token_secret'];
		$test_token = new OAuthConsumer($token, $token_secret);
		session_start();
		$_SESSION['status'] = array(
				"percentage"=> 60,
				"tip" => "access token",
				"FIN" => false,
		);
		session_write_close();
		
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
		session_start();
		$_SESSION['status'] = array(
				"percentage"=> 80,
				"tip" => "acquiring data key",
				"FIN" => false,
		);
		
		$_SESSION['userKey'] = $data;
		$_SESSION['isLogged'] = true;
		
		session_write_close();
		$proxy  = new Proxy($data, $wp_json_url , $sig_method);

		$users_me_content = $proxy->sendRequest("users/me");
		
		//   $oauth = new OAuth ( $data["key"], $data["secret"], OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION );
		//   $oauth->setToken ( $data["token"], $data["token_secret"] );
		//   $path = $wp_json_url."/users/me";
		//   $oauth->fetch ( $path );
		//   $response_info = $oauth->getLastResponseInfo();
		
		//   $_SESSION['userData'] = $oauth->getLastResponse();
		session_start();
		$_SESSION['userData'] =   $users_me_content;
		$_SESSION['status'] = array(
				"percentage"=> 100,
				"tip" => "complete",
				"FIN" => true,
		);
		session_write_close();
		echo "<script>parent.update_storage('".$_SESSION['userData']."');</script>";
		
		return;

	}else if ($action == "p") {
		// action proxy, utilizzo il path solo se sono loggato
		session_start();
		if(isset($_GET['path']) && !empty($_GET['path']) &&
				isset($_SESSION['userData']) && isset($_SESSION['userKey']) ) {
					
			$function = $_GET['path'];
			if( isset($_SESSION['isLogged']) && $_SESSION['isLogged'] ) {
				//chiamata alle API
				if ( substr( $function, 0, 4 ) === "api/" ){
					$proxy  = new Proxy($_SESSION['userKey'], $domain, $sig_method);
				}
				else {
					$proxy  = new Proxy($_SESSION['userKey'], $wp_json_url , $sig_method);
				}
				
			} else {
				header('HTTP/1.1 401 Unauthorized', true, 401);
				return;
			}				
			
			echo $proxy->sendRequest($_GET['path']);
		}
		session_write_close();
	} else if ($action == "status") {
		
		if(!isset($_SESSION['status'])) {
			session_start();
			$_SESSION['status'] = array(
					"percentage"=> 10,
					"tip" => "Start",
					"FIN" => false,
			);
			session_write_close();
		}
		header('Content-Type: application/json');
		echo json_encode($_SESSION['status']);
		
	} else if ($action == "logout") {
		// Desetta tutte le variabili di sessione.
		session_unset();
		// Infine , distrugge la sessione.
		session_destroy();
		
	} else {
	
		return reportError("Error");
	}
	
}

function reportError($error) {
	header('Content-Type: application/json');
	echo json_encode($error);
}


