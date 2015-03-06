<html>
  <head>
    <script type="text/javascript" src="js/oauth/sha1.asc"></script>
    <script type="text/javascript" src="js/oauth/oauth.asc"></script>
    <script type="text/javascript" src="js/oauth/consumer.asc"></script>
  </head>
  <body>

    <form action="../wordpress/oauth1/request?" name="request" method="POST">
        <input type="submit" value="Get Request Token"/><br/>

        <!-- Consumer Key generata -->
        consumer key:     <input name="oauth_consumer_key"     type="text" size="64" value="nEez2wYJAF1k"/><br/>

        signature method: <input name="oauth_signature_method" type="text"/><br>
        timestamp:        <input name="oauth_timestamp"        type="text"/><br>
        nonce:            <input name="oauth_nonce"            type="text"/><br>
        signature:        <input name="oauth_signature"        type="text"/><br>
    </form>
    <form name="etc">
                          <input name="URL"                    type="hidden" size="80" value="../wordpress/oauth1/request?"/><br/>

      <!-- Consumer Key Secret -->
        consumer secret:  <input name="consumerSecret"         type="text" size="64" value="IOh1gWkUc7n0mpth2eciYmoVdJ11oFzahpHQDDnpaUBDani7"/><br/>

                          <input name="tokenSecret"            type="hidden" value=""/>
    </form>
    <script>
      var request, oauth_token, oauth_token_secret, oauth_callback_confirmed;
      consumer.signForm(document.request, document.etc);

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
        if(seq != 2) { xmlhttp.send(); }
        else { // login
          xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
          xmlhttp.send("log=admin&pwd=testadmin");
        }

        if(seq == 0) { // get Consumer Key
          var req = xmlhttp.responseText;
          alert(req);
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
        }
        else if(seq == 3) { // authorize
          var req = xmlhttp.responseText;
          alert(req);
        }
        else if(seq == 4) { // access
          consumer.signForm(document.request, document.etc);
          var URL = document.getElementsByName("URL")[0];
          alert(URL.value);
          URL.value = "../wordpress/oauth1/access";
          alert(URL.value);
        }
      }

      function getnamevalue(name) { return document.getElementsByName(name)[0].value; }

      var timestamp, nonce, signature, signature_method; 
      timestamp = getnamevalue("oauth_timestamp");
      nonce = getnamevalue("oauth_nonce");
      signature = getnamevalue("oauth_signature");
      signature_method = getnamevalue("oauth_signature_method");

      var consumer_secret, consumer_key;
      //consumer_secret = getnamevalue("consumerSecret");
      consumer_key = getnamevalue("oauth_consumer_key");



//        * Consumer Key (404.php)
//      ajaxreq("../wordpress/asdasd", 0);

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
