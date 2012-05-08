<?php

$instagram = new Instagram\Instagram;
$instagram->setAccessToken( $_SESSION['instagram_access_token'] );

if ( isset( $_GET['lat'], $_GET['lng'] ) ) {
	$search = true;
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];
	$params = array(
		'distance' =>100,
		'max_timestamp' => isset( $_GET['max_timestamp'] ) ? $_GET['max_timestamp'] : null
	);
	$media = $instagram->searchMedia( $lat, $lng, $params );
}


require( 'views/_header.php' );
require( 'views/near.php' );
require( 'views/_footer.php' );