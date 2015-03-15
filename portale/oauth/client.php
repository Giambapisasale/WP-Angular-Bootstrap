<?php
session_start();

require_once("common.inc.php");
require_once ("Proxy.php");


// testare inclusione in iframe?

$token = @$_REQUEST['token'];
$token_secret = @$_REQUEST['token_secret'];
$action = @$_REQUEST['action'];
$dump_request = @$_REQUEST['dump_request'];
$sig_method = $hmac_method;

$test_consumer = new OAuthConsumer($key, $secret, NULL);

$test_token = NULL;
if ($token) {
  $test_token = new OAuthConsumer($token, $token_secret);
}

//recupera la lista degli endpoint offerti dal plugin per wordpress
$json_endpoint = file_get_contents($wp_json_url);
$json_endpoint = json_decode($json_endpoint);

$request_ep = $json_endpoint->authentication->oauth1->request;
$authorize_ep = $json_endpoint->authentication->oauth1->authorize;
$access_ep = $json_endpoint->authentication->oauth1->access;

if (empty($action) || $action == "request_token") {
  $_SESSION['status'] = array(
  		"percentage"=> 20,
  		"tip" => "request token",
	  	"FIN" => false,
  );
//   $parsed = parse_url($endpoint);
  $parsed = parse_url($request_ep);
  
  $params = array();
  parse_str($parsed['query'], $params);

  $req_req = OAuthRequest::from_consumer_and_token($test_consumer, NULL, "GET", $request_ep, $params);
  $req_req->sign_request($sig_method, $test_consumer, NULL);
  if ($dump_request) {
    Header('Content-type: text/plain');
    print "request url: " . $req_req->to_url(). "\n";
    print_r($req_req);
    exit;
  }
//   Header("Location: $req_req");
  $req_res = file_get_contents($req_req); //aggiungere controllo fallimento della richiesta del token
  parse_str($req_res); //tramite questa funzione mi dichiaro queste variabili nello stesso scope chiamato dalla funzione
  $token = $oauth_token;
  $token_secret = $oauth_token_secret;
  $_SESSION['status'] = array(
	"percentage"=> 40,
	"tip" => "auth url",
	"FIN" => false,
  );
  
// } 
// else if ($action == "authorize") { 2
//   $callback_url = "$base_url/client.php?key=$key&secret=$secret&token=$token&token_secret=$token_secret&endpoint=" . urlencode($endpoint);
//   $auth_url = $endpoint . "?oauth_token=$token&oauth_callback=".urlencode($callback_url);
  $callback_url = "$base_url/client.php?action=access_token&key=$key&secret=$secret&token=$token&token_secret=$token_secret&endpoint=" . urlencode($authorize_ep);
  $auth_url = $authorize_ep . "?oauth_token=$token&oauth_callback=".urlencode($callback_url);
  
  if ($dump_request) { //debug
    Header('Content-type: text/plain');
    print("auth_url: " . $auth_url);
    exit;
  }
  Header("Location: $auth_url"); //invio al cliente header per il redirect  
	
}
else if ($action == "access_token") {//step 3
  $_SESSION['status'] = array(
  		"percentage"=> 60,
  		"tip" => "access token",
	  	"FIN" => false,
  );
//   $parsed = parse_url($endpoint);
  $parsed = parse_url($access_ep);
  
  $params = array();
  parse_str($parsed['query'], $params);

//   $acc_req = OAuthRequest::from_consumer_and_token($test_consumer, $test_token, "GET", $endpoint, $params);
  $acc_req = OAuthRequest::from_consumer_and_token($test_consumer, $test_token, "GET", $access_ep, $params);
  
  $acc_req->sign_request($sig_method, $test_consumer, $test_token);
  $acc_req->set_parameter("oauth_verifier", $_GET["oauth_verifier"]);
  
  if ($dump_request) {
    Header('Content-type: text/plain');
    print "request url: " . $acc_req->to_url() . "\n";
    print_r($acc_req);
    exit;
  }
//   Header("Location: $acc_req");
  $acc_res = file_get_contents($acc_req);
  parse_str($acc_res); //magica funzione php
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
  
//   header('Content-Type: application/json');
//   echo json_encode($data);
  
  $_SESSION['userKey'] = $data;
  $_SESSION['isLogged'] = true;
  
  $oauth = new OAuth ( $data->key, $data->secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION );
  $oauth->setToken ( $data->token, $data->token_secret );
  $path = "GET /users/me";
  $oauth->fetch ( $path );
  $response_info = $oauth->getLastResponseInfo();
  $_SESSION['userData'] = $oauth->getLastResponse();
  $_SESSION['status'] = array(
  		"percentage"=> 100,
  		"tip" => "complete",
	  	"FIN" => true,
  );
  
  echo "<script>parent.update_storage('".$_SESSION['userData']."');</script>";
  
  return;
  //implementare action status che ritorna lo step corrente
}else if ($action == "p") {
	if(isset($_GET['path']) && empty($_GET['path']) &&
			isset($_SESSION['userData']) && isset($_SESSION['userKey']) ) {
				
		$proxy  = new Proxy($_SESSION['userKey']);
		$proxy->sendRequest($_GET['path']);
	}
}else if ($action == "status") {
	if(isset($_SESSION['status'])) {
		header('Content-Type: application/json');
		echo json_encode($_SESSION['status']);
	}
} else
	return;
