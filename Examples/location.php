<?php

$instagram = new Instagram\Instagram;
$instagram->setAccessToken( $_SESSION['instagram_access_token'] );
$current_user = $instagram->getCurrentUser();

$location = $instagram->getLocation( isset( $_GET['location'] ) ? $_GET['location'] : 4774498 );
$media = $location->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );

require( 'views/_header.php' );
require( 'views/location.php' );
require( 'views/_footer.php' );