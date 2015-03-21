<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_1_minute' );

function keep_me_logged_in_for_1_minute( $expirein ) {
	return 60; 
}