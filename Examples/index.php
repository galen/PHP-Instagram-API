<?php

define( 'GITHUB_URL',			'https://github.com/galen/PHP-Instagram-API/blob/master/Examples/' );
define( 'EXAMPLES_DIR',			__DIR__ );

// Turn on error reporting
error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

// Start the session
session_start();

// Start authorization
if ( !isset( $_SESSION['instagram_access_token'] ) ) {
	$auth_config = array(
		'client_id'			=> '',
		'client_secret'		=> '',
		'callback_url'		=> '' ),
		'scope'				=> array( 'likes', 'comments', 'relationships' )
	);
	require( __DIR__ . '/system/lib/PHP-Instagram-API/Examples/_auth.php' );
	exit;
}

// If an example has been chosen, include it and exit
if ( isset( $_GET['example'] ) ) {
	$github_url = GITHUB_URL . $_GET['example'];
	try {
		require( EXAMPLES_DIR . '/_common.php' );
		require( EXAMPLES_DIR . '/' . $_GET['example'] );
		exit;
	}
	catch ( \Instagram\Core\ApiException $e ) {
		if ( $e->getType() == $e::TYPE_OAUTH ) {
			unset( $_SESSION['instagram_access_token'] );
			header( 'Location: /projects/instagram/?' . str_replace( '&test_token', '', $_SERVER['QUERY_STRING'] ) );
			exit;
		}
		$error = ucwords( $e->getMessage() );
		require( EXAMPLES_DIR . '/_header.php' );
		require( EXAMPLES_DIR . '/_error.php' );
		require( EXAMPLES_DIR . '/_footer.php' );
		exit;
	}
}

// Get all the examples for display
$files = glob( EXAMPLES_DIR . '/*.php' );

require( EXAMPLES_DIR . '/views/_header.php' );
?>

<h2>Choose an example to load</h2>
<ul>
<?php foreach( $files as $file ): ?>
	<?php if( strpos( basename( $file ), '_' ) !== 0 ): ?>
	<li>- <a href="?example=<?php echo basename( $file ) ?>"><?php echo str_replace( '_', ' ', basename( $file, '.php' ) ) ?></a> &rarr; <a href="<?php echo GITHUB_URL ?><?php echo basename( $file ) ?>">github</a></li>
	<?php endif; ?>
<?php endforeach; ?>
</ul>

<?php
require( EXAMPLES_DIR . '/views/_footer.php' );