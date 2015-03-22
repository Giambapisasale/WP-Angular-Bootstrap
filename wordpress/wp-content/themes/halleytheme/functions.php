<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_1_minute' );

function keep_me_logged_in_for_1_minute( $expirein ) {
  return 60;
}

function my_login_logo() { ?>
<style type="text/css">
  .login h1 a {
    background-image: none;
    padding-bottom: 30px;
  }
</style>
<?php }

add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_stylesheet() {
?>

<script>
  window.onload = function() {
    var s = document.getElementById("login").getElementsByTagName("h1")[0];
    s.innerHTML = "<?php bloginfo( 'name' ) ?>";

    var login_text = document.createElement("p");
    login_text.className = "uppercase login-text";
    login_text.innerHTML = "Login";

    var login = document.getElementById("loginform");
    login.insertBefore(login_text, login.firstChild);

    document.getElementById("user_login").placeholder = "Il tuo nome";
    document.getElementById("user_pass").placeholder = "La tua password";

    var remember_input = document.getElementById("rememberme");
    var checkbox = document.createElement("img");
    checkbox.src = "../portale/images/assets/checkbox.png";

    var checked = document.createElement("img");
    checked.src = "../portale/images/assets/checkbox_checked.png";

    remember_input.parentNode.insertBefore(checkbox, remember_input.nextSibling);
    remember_input.parentNode.insertBefore(checked, remember_input.nextSibling);

    document.getElementById("wp-submit").value = "Entra";

    var nav = document.getElementById("nav");
    login.appendChild(nav);
    nav.getElementsByTagName("a")[0].innerHTML = "Hai dimenticato la password?";
  };
</script>

<style>
  #login { width: 461px; }

  #login h1 {
    width: 461px;
    line-height: 90px;
    border-bottom: 10px solid #2a82a1;
    font-weight: bold;
    text-align: center;
    color: #fff;
    background-color: #005c81;
  }
  .login-text {
    text-transform: uppercase;
    text-align: center;
    color: #005c81;
    font-size: 20px;
    font-weight: bold;
    font-family: Arial;
    padding-bottom: 10px;
  }
  #loginform {
    margin: 0px;
    padding: 20px;
    width: 421px;
  }
  #loginform label {
    color: #005c81;
    font-weight: bold;
    font-family: Arial;
  }
  #loginform input[type='text'], #loginform input[type='password'] {
    padding: 16px;
    font-size: 13px;
    font-weight: normal;
    border: none;
    background-color: #ededed;
  }

  #wp-submit {
    width: 421px;
    height: 40px;
    margin: 10px 0px;
    text-transform: uppercase;
    text-align: center;
    font-weight: bold;
    font-family: Arial;
    color: #fff;
    background-color: #005c81;
  }

  .submit { text-align: center; }

  #nav { text-align: center; }
  #nav a { color: #057 !important; }

  .forgetmenot label {
    color: #057;
    font-weight: normal !important;
  }

  input[type="checkbox"] { display: none; }
  input[type="checkbox"] +img + img { display: none; }
  input[type="checkbox"]:checked + img { display: none; }
  input[type="checkbox"] + img, input[type="checkbox"]:checked + img + img
  {
    display: inline-block;
    width: 16px;
    height: 16px;
    margin-top: -2px;
    vertical-align: sub;
  }

  #backtoblog { display: none; }
</style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );
