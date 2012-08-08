<?php

require( '_SplClassLoader.php' );
$loader = new SplClassLoader( 'Instagram', dirname( __DIR__ )  );
$loader->register();

$auth = new Instagram\Auth( $auth_config );

// If a code is present try and get the access token
// otherwise redirect to the Instagram auth page to get the code
if ( isset( $_GET['code'] ) ) {
    try {
        $_SESSION['instagram_access_token'] = $auth->getAccessToken( $_GET['code'] );
        header( 'Location: ' . REDIRECT_AFTER_AUTH );
        exit;
    }
    catch ( \Instagram\Core\ApiException $e ) {
        $error = ucwords( $e->getMessage() );
        require( EXAMPLES_DIR . '/views/_header.php' );
        require( EXAMPLES_DIR . '/views/_error.php' );
        require( EXAMPLES_DIR . '/views/_footer.php' );
        exit;
    }
}
else {
    $auth->authorize();
}