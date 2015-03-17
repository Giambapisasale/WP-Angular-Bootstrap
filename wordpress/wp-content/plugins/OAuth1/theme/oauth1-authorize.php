<?php
login_header(
	__('Authorize', 'oauth'),
	'',
	$errors
);

$current_user = wp_get_current_user();

$url = site_url( 'wp-login.php?action=oauth1_authorize', 'login_post' );

?>

<style>

	.login-title {
		margin-bottom: 15px;
	}

	.login-info .avatar {
		margin-right: 15px;
		margin-bottom: 15px;
		float: left;
	}

	#login form .login-info p {
		margin-bottom: 15px;
	}

	/** Note - login scope has not yet been implemented. **/
	.login-scope {
		clear: both;
		margin-bottom: 15px;
	}

	.login-scope h4 {
		margin-bottom: 10px;
	}

	.login-scope ul {
		margin-left: 1.5em;
	}

	.submit {
		clear: both;
	}

	.submit .button {
		margin-right: 10px;
		float: left;
	}

    #oauth1_authorize_form {
      margin: 0px;
    }

    .annulla {
      text-transform: uppercase;
      text-align: center;
      font-weight: bold;
      color: #005c81 !important;
    }

    .autorizza {
      text-transform: uppercase;
      text-align: center;
      font-weight: bold;
      color: #fff;
      background-color: #005c81 !important;
    }

    .login-title {
      text-transform: uppercase;
      text-align: center;
      color: #005c81;
      font-size: 20px;
      font-weight: bold;
      font-family: Arial;
    }

    .login-info p {
      color: #005c81;
      font-weight: bold;
      text-align: center;
    }

    .avatar {
     float: none !important;
    }

    .submit {
      width: 100%;
      text-align: center !important;
    }

    .submit * { float: none !important; }
</style>

<form name="oauth1_authorize_form" id="oauth1_authorize_form" action="<?php echo esc_url( $url ); ?>" method="post">

	<h2 class="login-title">Connetti</h2>

	<div class="login-info">
      <center>
		<p>Vuoi connetterti a <?= get_bloginfo( 'name' ) ?>?</p>

		<?php echo get_avatar( $current_user->ID, '78' ); ?>
      </center>
	</div>

	<?php
	/**
	 * Fires inside the lostpassword <form> tags, before the hidden fields.
	 *
	 * @since 2.1.0
	 */
	do_action( 'oauth1_authorize_form', $consumer ); ?>
	<p class="submit">
		<button type="submit" name="wp-submit" value="authorize" class="button button-primary button-large autorizza">Autorizza</button>
		<button type="submit" name="wp-submit" value="cancel" class="button button-large annulla" OnClick="parent.close_modal();">Annulla</button>
	</p>

</form>

<p id="nav">
<?php
if ( get_option( 'users_can_register' ) ) :
	$registration_url = sprintf( '<a href="%s">%s</a>', esc_url( wp_registration_url() ), __( 'Register' ) );
	/**
	 * Filter the registration URL below the login form.
	 *
	 * @since 1.5.0
	 *
	 * @param string $registration_url Registration URL.
	 */
	echo ' | ' . apply_filters( 'register', $registration_url );
endif;
?>
</p>

<?php
