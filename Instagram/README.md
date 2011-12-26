#PHP Instagram API

##Authenticating

This will forward a user to the instagram authorization page:

    $auth->authorize();

Instagram will then send the user back to the redirect url you created with a code. Use this to get your Instagram access token:

    $_SESSION['instagram_access_token'] = $auth->getAccessToken(); 

**Authentication example**

	if ( isset( $_SESSION['instagram_access_token'] ) ) {
		header( 'Location: /' );
		exit;
	}
	
	$auth = new Instagram\Auth(
    	array(
			'client_id'			=> '',
			'client_secret'		=> '',
			'callback_url'		=> ''
		)
    );
	if ( isset( $_GET['code'] ) ) {
		try {
			$_SESSION['instagram_access_token'] = $auth->getAccessToken();
			header( 'Location: /' );
			exit;
		}
		catch ( \Instagram\Core\ApiException $e ) {
			die( $e->getMessage() );
		}
	}
	else {
		$auth->authorize();
	}

##Basic Usage

    $user = new \Instagram\User( 11007611, new \Instagram\Net\CurlClient, $_SESSION['instagram_access_token'] );

    $media = new \Instagram\Media( 3, new \Instagram\Net\CurlClient, $_SESSION['instagram_access_token'] );

    $tag = new \Instagram\Tag( 'almostdied', new \Instagram\Net\CurlClient, $_SESSION['instagram_access_token'] );

    $location = new \Instagram\Location( 1, new \Instagram\Net\CurlClient, $_SESSION['instagram_access_token'] );

##Alternate usage

Through the Instagram object you can create objects on the fly.  You need to pass a config array to the Instagram object. It only needs to contain an access token.  You can pass a different Client object as well, the default client is the provided CurlClient.

	$instagram_config = array(
		'access_token'	=> $_SESSION['instagram_access_token']
	);
	$instagram = new Instagram\Instagram( $instagram_config );
	$media = $instagram->getUser( 11007611 )->getMedia( array( 'count' => 3 ) );

##Getting Media

Users, tags, and locations have media associated with them.

This will return recent media from the 3 objects:

    $user->getMedia();
	$tag->getMedia();
	$location->getMedia();

You can pass an array of parameters to `getMedia()`. These parameters will be passed directly to the API.  Check the API for a list of available parameters.

    $user->getMedia( array( 'count' => 3 ) );