<?php

date_default_timezone_set('America/Los_Angeles');

require( '_SplClassLoader.php' );
$loader = new SplClassLoader( 'Instagram', dirname( __DIR__ ) );
$loader->register();

$instagram = new Instagram\Instagram;
$instagram->setAccessToken( $_SESSION['instagram_access_token'] );
$current_user = $instagram->getCurrentUser();