<?php

$instagram = new Instagram\Instagram;
$instagram->setAccessToken( $_SESSION['instagram_access_token'] );
$current_user = $instagram->getCurrentUser();

try{
	$username = isset( $_GET['user'] ) ? $_GET['user'] : 'galenweee';
	$user = $instagram->getUserByUsername( $username );

	try {
		if ( isset( $_POST['action'] ) ) {
			switch( strtolower( $_POST['action'] ) ) {
				case 'follow':
					$current_user->follow( $user );
					break;
				case 'unfollow':
					$current_user->unFollow( $user );
					break;
				case 'approve follower':
					$current_user->approveFollowRequest( $user );
					break;
				case 'ignore follower':
					$current_user->ignoreFollowRequest( $user );
					break;
				case 'block':
					$current_user->block( $user );
					break;
				case 'unblock':
					$current_user->unblock( $user );
					break;
			}
		}
	}
	catch( \Instagram\Core\ApiException $e ) {
		$error = $_POST['error_message'];
	}
	$outgoing_relationship = $current_user->getRelationship( $user )->outgoing_status;
	$incoming_relationship = $current_user->getRelationship( $user )->incoming_status;
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