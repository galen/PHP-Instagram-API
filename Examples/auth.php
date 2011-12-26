<?php

require( '_SplClassLoader.php' );
$loader = new SplClassLoader( 'Instagram', dirname( __DIR__ )  );
$loader->register();

// If a code is present try and get the access token
// otherwise redirect to the Instagram auth page
$auth = new Instagram\Auth( $auth_config );
if ( isset( $_GET['code'] ) ) {
	try {
		$_SESSION['instagram_access_token'] = $auth->getAccessToken( $_GET['code'] );
		header( 'Location: /examples/' );
		exit;
	}
	catch ( \Instagram\Core\ApiException $e ) {
		die( $e->getMessage() );
	}
}
else {
	$auth->authorize();
}