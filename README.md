#PHP Instagram API

This is a PHP 5.3+ API wrapper for the [Instagram API](http://instagram.com/developer/)

Still in early development

[Live Examples](http://galengrover.com/projects/instagram/)

##Notes
 - Currently only GET requests are covered. PUT/POST/DELETE are coming soon
 - This library uses PHP 5.3+ and requires the [SPLClassLoader](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) ( available in Examples/_SplClassLoader.php )

##The API

All methods that access the API can throw exceptions. If the API request fails for any reason other than an expired/missing access token an exception of type `\Instagram\Core\ApiException` will be thrown.  If the API request fails because of an expired/missing access token an exception of type `\Instagram\Core\ApiAuthException`. You can use this to redirect to your authorization page.

##Authenticating

This will forward a user to the instagram authorization page:

    $auth->authorize();

Instagram will then send the user back to the redirect url you created with a code. Use this to get your Instagram access token:

    $_SESSION['instagram_access_token'] = $auth->getAccessToken( $_GET['code'] ); 

Complete authorization example

	// You can get this info from your Instagram developer page
	// http://instagram.com/developer/manage/
	$auth_config = array(
		'client_id'			=> '',
		'client_secret'		=> '',
		'callback_url'		=> '',
		'scope'				=> array( 'likes', 'comments', 'relationships' )
	);

	$instagram = new Instagram\Instagram( $auth_config );

	// If a code is present try and get the access token
	// otherwise redirect to the Instagram auth page to get the code
	// Fill in your own redirect location 
	if ( isset( $_GET['code'] ) ) {
		try {
			$_SESSION['instagram_access_token'] = $instagram->getAccessToken( $_GET['code'] );
			header( 'Location: /' );
			exit;
		}
		catch ( \Instagram\Core\ApiException $e ) {
			die( $e->getMessage() );
		}
	}
	else {
		$instagram->authorize();
	}

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

####Liking Media

You can supply a media object or a media id.

	$current_user->addLike( $media );
	$current_user->deleteLike( $media );

####Media Comments

You can supply a media object or a media id.

	$current_user->addMediaComment( $media_id, $_POST['comment_text'] );
	$current_user->deleteMediaComment( $media_id, $_POST['comment_id'] );

####Following

You can supply a user object or a user id.

	$current_user->follow( $user );
	$current_user->unFollow( $user );

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


##Collections

When making a call to a method that returns more than one of something (e.g. getMedia(), searchUsers() ), a collection object will be returned.  Collections cane be iterated, counted, and accessed like arrays.

    $user = $instagram->getUser( $user_id );
    $media = $user->getMedia();
    foreach( $media as $photo ) {
         ...
    }
    $media_count = count( $media );
    $first_photo = $media[0];


The collection object will sometimes have an identifier to the "next page".

For example:

    $user = $instagram->getUser( $user_id );
    $media = $user->getMedia();

To obtain the identifier for the next page you call `getNext()` on the collection object.

    $next_page = $media->getNext();

Example usage:

    <a href="user_media.php?max_id=<?php echo $next_page ?>">

In `user_media.php` you would check for a next page when obtaining the user media.

    $user = $instagram->getUser( $user_id );
    $params = isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null;
    $media = $user->getMedia( $params );

Unfortunately methods require different params to be passed to them in order to obtain the next set of results (e.g. Tags require the *max_tag_id* param ).

##Searching

You can search for locations, media, tags, and users.

    $locations = $instagram->searchLocations( $lat, $lng );
    $media = $instagram->searchMedia( $lat, $lng );
    $tags = $instagram->searchTags( 'tag' );
    $users = $instagram->searchUsersByName( 'username' );