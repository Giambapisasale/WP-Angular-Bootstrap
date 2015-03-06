<?php
if (current_user_can( 'manage_options' ) ) 
{
	echo "<p>ADMIN ON</p>";
	$authenticator = new WP_JSON_Authentication_OAuth1();
	$consumer = $authenticator->add_consumer( $args );
	echo sprintf('ID: %d',     $consumer->ID ) ;
	echo "<br />";
	echo sprintf( 'Key: %s',    $consumer->key ) ;
	echo "<br />";
	echo sprintf( 'Secret: %s', $consumer->secret ) ;
}
else { echo "<p>ADMIN OFF</p>"; }
?>
