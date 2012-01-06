<?php

require( '_common.php' );

$current_user = $instagram->getCurrentUser();

try{
	$username = isset( $_GET['user'] ) ? $_GET['user'] : 'galenweee';
	$user = $instagram->getUserByUsername( $username );
	$incoming_relationship = $current_user->getRelationship( $user )->incoming_status;

	if ( isset( $_GET['action'] ) ) {
		switch( $_GET['action'] ) {
			case 'follow':
				$current_user->follow( $user );
				break;
			case 'unfollow':
				$current_user->unFollow( $user );
				break;
		}
	}

	$media = $user->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );
	$follows = $user->getFollows( isset( $_GET['follows_cursor'] ) ? array( 'cursor' => $_GET['follows_cursor'] ) : null );
	$followers = $user->getFollowers( isset( $_GET['followers_cursor'] ) ? array( 'cursor' => $_GET['followers_cursor'] ) : null );
}
catch( \Instagram\Core\ApiException $e ) {
	if ( $e->getType() == $e::TYPE_NOT_ALLOWED ) {
		require( 'views/_header.php' );
		require( 'views/user_private.php' );
		require( 'views/_footer.php' );
		exit;
	}
	else {
		throw $e;
	}
}

require( 'views/_header.php' );
require( 'views/user.php' );
require( 'views/_footer.php' );