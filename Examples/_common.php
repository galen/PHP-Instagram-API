<?php

// Set default timezone
date_default_timezone_set('America/Los_Angeles');

require( '_SplClassLoader.php' );
$loader = new SplClassLoader( 'Instagram', dirname( __DIR__ ) );
$loader->register();

$instagram_config = array(
	'access_token'	=> $_SESSION['instagram_access_token'] . ( isset( $_GET['test_token'] ) ? '!' : '' )
);
$instagram = new Instagram\Instagram( $instagram_config );