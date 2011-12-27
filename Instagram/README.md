#PHP Instagram API

##Notes
 - Currently only GET requests are covered. PUT/POST/DELETE are coming soon
 - This library uses PHP 5.3+ and requires the [SPLClassLoader](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) ( available in Examples/_SplClassLoader.php )

##Authenticating

This will forward a user to the instagram authorization page:

    $auth->authorize();

Instagram will then send the user back to the redirect url you created with a code. Use this to get your Instagram access token:

    $_SESSION['instagram_access_token'] = $auth->getAccessToken( $_GET['code'] ); 

**Authentication example comign soon**

##Basic Usage

    $instagram_config = array(
	    'access_token'	=> $_SESSION['instagram_access_token']
    );
    $instagram = new Instagram\Instagram( $instagram_config );

    $user = $instagram->getUser( $user_id );
    $media = $instagram->getMedia( $media_id );
    $tag = $instagram->getTag( 'mariokart' );
    $location = $instagram->getLocation( 3001881 );
    $current_user = $instagram->getCurrentUser();

This will give you basic info about each object

##Current User

The current user object will give you the currently logged in user.  With this object you can obtain the users feed and liked media as well as all the normal user data.

    $current_user = $instagram->getCurrentUser();
    $feed = $current_user->getFeed();
    $liked_media = $current_user->getLikedMedia();

##Getting Media

Users, tags, locations, and the current user have media associated with them.

This will return recent media from the 4 objects:

    $user->getMedia();
	$tag->getMedia();
	$location->getMedia();
    $current_user->getMedia();

You can pass an array of parameters to `getMedia()`. These parameters will be passed directly to the API.  Check the API for a list of available parameters.

    $user->getMedia(
        array( 'count' => 3 )
    );
    $tag->getMedia(
        array( 'max_tag_id' => $max_tag_id )
    );
    $location->getMedia(
        array( 'max_id' => $max_id )
    );

##Pagination

Some methods return collections that have links to the "next page".

For example:

    $user = $instagram->getUser( $user_id );
    $media = $user->getMedia();

This next method call will obtain the "max_id" of the next page of the user's media.

    $next_page = $media->getNext();

Example usage:

    <a href="user_media.php?max_id=<?php echo $next_page ?>">

In `user_media.php` you would check for a next page when obtaining the user media.

    $user = $instagram->getUser( $user_id );
    $params = isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null;
    $media = $user->getMedia( $params );

Unfortunately methods require different params to be passed ot them in order to obtain the next set of results (e.g. Tags require the *max_tag_id* param ).

##Searching

You can search for locations, media, tags, and users.

    $locations = $instagram->searchLocations( $lat, $lng );
    $media = $instagram->searchMedia( $lat, $lng );
    $tags = $instagram->searchTags( 'tag' );
    $users = $instagram->searchUsersByName( 'username' );