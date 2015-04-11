<?php
/*
Template Name: LogoutLink
*/

// check_ajax_referer( 'ajax-logout-nonce', 'ajaxsecurity' );
wp_clear_auth_cookie();
wp_logout();
ob_clean(); // probably overkill for this, but good habit
echo 'adios!!';
wp_die();