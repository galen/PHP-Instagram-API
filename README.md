#PHP Instagram API

[Gittip!](https://www.gittip.com/galen/)

This is a PHP 5.3+ API wrapper for the [Instagram API](http://instagram.com/developer/)

[Live Examples](http://galengrover.com/projects/instagram/)

---

##The API

All methods that access the API can throw exceptions. If the API request fails for any reason other than an expired/missing access token an exception of type `\Instagram\Core\ApiException` will be thrown.  If the API request fails because of an expired/missing access token an exception of type `\Instagram\Core\ApiAuthException` will be thrown. You can use this to redirect to your authorization page.

##Authentication

- [Set up a client for use with Instagram's API](http://instagr.am/developer/clients/manage/)

- Create an Auth Object and pass in the information from the API

<b></b>

    $auth_config = array(
        'client_id'         => '',
        'client_secret'     => '',
        'redirect_uri'      => '',
        'scope'             => array( 'likes', 'comments', 'relationships' )
    );

    $auth = new Instagram\Auth( $auth_config );

- Then you have to get the user to authorize your app 

<b></b>

    $auth->authorize();

- This will redirect the user to the Instagram authorization page. After authorization Instagram will redirect the user to the url in `$auth_config['redirect_uri']` with a code that you will need to obtain an access token

<b></b>

    $_SESSION['instagram_access_token'] = $auth->getAccessToken( $_GET['code'] );

- Then use the access token in your code

<b></b>

    $instagram = new Instagram\Instagram;
    $instagram->setAccessToken( $_SESSION['instagram_access_token'] );
    $current_user = $instagram->getCurrentUser();

##Basic Usage

    $instagram = new Instagram\Instagram( $_SESSION['instagram_access_token'] );
    $user = $instagram->getUser( $user_id );
    $media = $instagram->getMedia( $media_id );
    $tag = $instagram->getTag( 'mariokart' );
    $location = $instagram->getLocation( 3001881 );
    $current_user = $instagram->getCurrentUser();

##Current User

The current user object will give you the currently logged in user

    $current_user = $instagram->getCurrentUser();

With this object you can:

- follow, unfollow, block, and unblock users

<b></b>

    $current_user->follow( $user );
    $current_user->unfollow( $user );
    $current_user->block( $user );
    $current_user->unblock( $user );

- obtain the user's feed, liked media, follow requests

<b></b>

    $feed = $current_user->getFeed();
    $liked_media = $current_user->getLikedMedia();


- ignore and approve follow requests

<b></b>

    $current_user->ignoreFollowRequest( $user );
    $current_user->approveFollowRequest( $user );

You can also perform all the functions you could on a normal user


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

When making a call to a method that returns more than one of something (e.g. getMedia(), searchUsers() ), a collection object will be returned.  Collections can be iterated, counted, and accessed like arrays.

    $user = $instagram->getUser( $user_id );
    $media = $user->getMedia();
    foreach( $media as $photo ) {
         ...
    }
    $media_count = count( $media );
    $first_photo = $media[0];


The collection object will sometimes have an identifier to the "next page" that can be used to obtain the next page of the collection.

To obtain the identifier for the next page you call `getNext()` on the collection object.

For example:

    $user = $instagram->getUser( $user_id );
    $media = $user->getMedia();
    $next_page = $media->getNext();

Example usage:

    <a href="user_media.php?max_id=<?php echo $next_page ?>">

In `user_media.php` you would check for a next page when obtaining the user media.

    $user = $instagram->getUser( $user_id );
    $params = isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null;
    $media = $user->getMedia( $params );

Unfortunately API methods require different params to be passed to them in order to obtain the next set of results (e.g. Tags require the *max_tag_id* param ).


##Searching

You can search for locations, media, tags, and users.

    $locations = $instagram->searchLocations( $lat, $lng );
    $media = $instagram->searchMedia( $lat, $lng );
    $tags = $instagram->searchTags( 'tag' );
    $users = $instagram->searchUsers( 'username' );
