<html>
  <head>
    <script type="text/javascript" src="js/oauth/sha1.asc"></script>
    <script type="text/javascript" src="js/oauth/oauth.asc"></script>
    <script type="text/javascript" src="js/oauth/consumer.asc"></script>
  </head>
  <body>

    <h4>CONSUMER KEY</h4>
    consumer ID:      <input name="consumer_ID"            type="text"/><br>
    consumer Key:     <input name="consumer_key"           type="text"/><br>
    consumer secret:  <input name="consumer_secret"        type="text"/><br/>

    <hr>

    <h4>Authorize</h4>
    oauth_token:        <input type="text" name="token"/><br>
    oauth_token_secret: <input type="text" name="token_secret" /><br>
    oauth_callback:     <input type="text" name="callback"><br>

    <hr>

    <!-- REQUEST form -->
    <form action="../wordpress/oauth1/request?" name="request" method="POST">

      <!-- Consumer Key generata -->
      <!-- consumer key: -->     <input name="oauth_consumer_key"     type="hidden" size="64" value=""/><br/>

      <!-- signature method: --> <input name="oauth_signature_method" type="hidden"/><br>
      <!-- timestamp:        --> <input name="oauth_timestamp"        type="hidden"/><br>
      <!-- nonce:            --> <input name="oauth_nonce"            type="hidden"/><br>
      <!-- signature:        --> <input name="oauth_signature"        type="hidden"/><br>
    </form>

    <!-- AUTHORIZE form -->
    <form action="../wordpress/oauth1/authorize?"name="authorize" method="GET">
      <!-- request token: -->    <input name="oauth_token"            type="hidden" size="64"/><br/>
      <!-- callback URL: -->     <input name="oauth_callback"         type="hidden" size="80"/>
    </form>

    <form name="etc">
      <input name="URL" type="hidden" size="80" value="../wordpress/oauth1/request?"/><br/>

      <!-- Consumer Key Secret -->
      <input name="consumerSecret" type="hidden" size="64" value=""/><br/>

      <input name="tokenSecret" type="hidden" value=""/>
    </form>
    <script>
      var request, oauth_token, oauth_token_secret, oauth_callback_confirmed, timestamp, nonce, signature, signature_method, consumer_secret, consumer_key, consumer_id; 

      function getnamevalue(name) { return document.getElementsByName(name)[0].value; }

      function ajaxreq(url, seq)
      {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
        } else {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("POST", url, false);
        
        // POST params
        if (seq != 2 && seq != 4) { xmlhttp.send(); }
        else if (seq == 2) { // login
          xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
          xmlhttp.send("log=admin&pwd=testadmin");
        }
        else { //authorize
          xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
          xmlhttp.send("consumer="+consumer_id+"&oauth_token="+oauth_token+"&_wpnonce="+nonce+"&_wp_http_referer=../wordpress/wp-login.php?action=oauth1_authorize&oauth_token="+oauth_token+"&oauth_token_secret="+oauth_token_secret+"&oauth_consumer_key="+consumer_key+"&oauth_timestamp="+timestamp+"&oauth_nonce="+nonce+"&oauth_signature="+signature+"&oauth_signature_method="+signature_method);
        }

        if(seq == 0) { // get Consumer Key
          var req = xmlhttp.responseText;
          req = req.split("<br />");
          req[0] = req[0].replace("<p>ADMIN ON</p>ID: ", "");
          req[1] = req[1].replace("Key: ", "");
          req[2] = req[2].replace("Secret: ", "");
          // alert("ID: "+req[0]+"\nKey: "+req[1]+"\nSecret: "+req[2]);
          consumer_id = req[0];
          document.getElementsByName("consumer_ID")[0].value = req[0];
          document.getElementsByName("oauth_consumer_key")[0].value = req[1];
          document.getElementsByName("consumerSecret")[0].value = req[2];

          // input fuori dal form
          document.getElementsByName("consumer_key")[0].value = req[1];
          document.getElementsByName("consumer_secret")[0].value = req[2];

          consumer.signForm(document.request, document.etc);

          timestamp = getnamevalue("oauth_timestamp");
          nonce = getnamevalue("oauth_nonce");
          signature = getnamevalue("oauth_signature");
          signature_method = getnamevalue("oauth_signature_method");
          // consumer_secret = getnamevalue("consumerSecret");
          consumer_key = getnamevalue("oauth_consumer_key");

          ajaxreq("../wordpress/oauth1/request?oauth_consumer_key="+req[1]+"&oauth_timestamp="+timestamp+"&oauth_nonce="+nonce+"&oauth_signature="+signature+"&oauth_signature_method="+signature_method, 1);
        }
        else if(seq == 1) { // Request token
          request = xmlhttp.responseText;
          alert(request);
          request = request.replace("oauth_token", "");
          request = request.replace("&oauth_token_secret", "");
          request = request.replace("&oauth_callback_confirmed", "");
          request = request.split("=");
          request.shift();
          oauth_token = request[0];
          oauth_token_secret = request[1];
          oauth_callback_confirmed = request[2];
          document.getElementsByName("oauth_token")[0].value = oauth_token;
          document.getElementsByName("tokenSecret")[0].value = oauth_token_secret;
          document.getElementsByName("oauth_callback")[0].value = oauth_callback_confirmed;

          // input fuori dal form
          document.getElementsByName("token")[0].value = oauth_token;       
          document.getElementsByName("token_secret")[0].value = oauth_token_secret;
          document.getElementsByName("callback")[0].value = oauth_callback_confirmed;

          ajaxreq("../wordpress/wp-login.php", 2);
        }
        else if(seq == 2) { // login
          var URL = document.getElementsByName("URL")[0];
          URL.value = "../wordpress/oauth1/authorize";
          ajaxreq("../wordpress/oauth1/authorize?oauth_token="+oauth_token+"&oauth_token_secret="+oauth_token_secret+"&oauth_consumer_key="+consumer_key+
                  "&oauth_timestamp="+timestamp+
                  "&oauth_nonce="+nonce+
                  "&oauth_signature="+signature+
                  "&oauth_signature_method="+signature_method, 3);

        }
        else if(seq == 3) { // authorize
          var result = xmlhttp.responseText;
          alert(result);
          ajaxreq("../wordpress/wp-login.php?action=oauth1_authorize", 4);
        }
        else if(seq == 4) { // authorize 2
          var result = xmlhttp.responseText;
          alert(result);
        }
        else if(seq == 5) { // access
          consumer.signForm(document.request, document.etc);
          var URL = document.getElementsByName("URL")[0];
          alert(URL.value);
          URL.value = "../wordpress/oauth1/access";
          alert(URL.value);
        }
      }

      //        * Consumer Key (404.php)
            ajaxreq("../wordpress/asdasd", 0);

      //        * Request Token
      //      ajaxreq("../wordpress/oauth1/request?oauth_consumer_key="+consumer_key+"&oauth_timestamp="+timestamp+"&oauth_nonce="+nonce+"&oauth_signature="+signature+"&oauth_signature_method="+signature_method, 1);

      //        * Login
      //      ajaxreq("../wordpress/wp-login.php", 2);

      /*        * Authorize
        ajaxreq("../wordpress/oauth1/authorize?oauth_token=BmSttcJhzh1RcsFbNsSk66v0&oauth_token_secret=P6Tdw5ro3czPlkvhFMLxFusJJMHqk5bOwmx4qSbCx0pPjJyQ&oauth_consumer_key="+consumer_key+
              "&oauth_timestamp="+timestamp+
              "&oauth_nonce="+nonce+
              "&oauth_signature="+signature+
              "&oauth_signature_method="+signature_method, 3);
      */
    </script>
  </body>
</html>
