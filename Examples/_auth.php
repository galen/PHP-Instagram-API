<?php

require( '_SplClassLoader.php' );
$loader = new SplClassLoader( 'Instagram', dirname( __DIR__ )  );
$loader->register();

// Example auth config
$auth_config = array(
	'client_id'			=> '',
	'client_secret'		=> '',
	'callback_url'		=> '',
	'scope'				=> array( 'likes', 'comments', 'relationships' )
);

$instagram = new Instagram\Instagram( $auth_config );

// If a code is present try and get the access token
// otherwise redirect to the Instagram auth page to get the code
if ( isset( $_GET['code'] ) ) {
	try {
		$_SESSION['instagram_access_token'] = $instagram->getAccessToken( $_GET['code'] );
		$redirect = '/projects/instagram/';
		header( 'Location: ' . $redirect );
		exit;
	}
	catch ( \Instagram\Core\ApiException $e ) {
		die( $e->getMessage() );
	}
}
else {
	$instagram->authorize();
}