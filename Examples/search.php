<?php

$instagram = new Instagram\Instagram;
$instagram->setAccessToken( $_SESSION['instagram_access_token'] );

$view = 'views/search.php';
$valid_searches = array( 'tags', 'users', 'media', 'locations' );

if ( isset(  $_GET['search_type'] ) && in_array( $_GET['search_type'], $valid_searches ) ) {

    switch( $_GET['search_type'] ) {
        case 'users':
            $users = $instagram->searchUsers( $_GET['user'] );
            $results_view = 'search_users.php';
            break;
        case 'tags':
            $tags = $instagram->searchTags( $_GET['tag'] );
            $results_view = 'search_tags.php';
            break;
        case 'locations':
            $locations = $instagram->searchLocations( $_GET['lat'], $_GET['lng'] );
            $results_view = 'search_locations.php';
            break;
        case 'media':
            $params['distance'] = isset( $_GET['distance'] ) ? (int)$_GET['distance'] : 1000;
            $params['max_timestamp'] = isset( $_GET['max_timestamp'] ) ? $_GET['max_timestamp'] : null;
            $media = $instagram->searchMedia( $_GET['lat'], $_GET['lng'], $params );
            $results_view = 'search_media.php';
            break;
    }

}


require( 'views/_header.php' );
require( 'views/search.php' );
require( 'views/_footer.php' );
