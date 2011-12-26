<?php

require( '_SplClassLoader.php' );
$loader = new SplClassLoader( 'Instagram', dirname( __DIR__ ) );
$loader->register();

$instagram_config = array(
	'access_token'	=> $_SESSION['instagram_access_token']
);
$instagram = new Instagram\Instagram( $instagram_config );