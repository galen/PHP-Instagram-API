<?php

$instagram = new Instagram\Instagram;
$instagram->setAccessToken( $_SESSION['instagram_access_token'] );

$current_user = $instagram->getCurrentUser();
$media = $current_user->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );
$follows = $current_user->getFollows( isset( $_GET['follows_cursor'] ) ? array( 'cursor' => $_GET['follows_cursor'] ) : null );
$followers = $current_user->getFollowers( isset( $_GET['followers_cursor'] ) ? array( 'cursor' => $_GET['followers_cursor'] ) : null );
$liked_media = $current_user->getLikedMedia( isset( $_GET['max_like_id'] ) ? array( 'max_like_id' => $_GET['max_like_id'] ) : null );
$feed = $current_user->getFeed( isset( $_GET['max_feed_id'] ) ? array( 'max_id' => $_GET['max_feed_id'] ) : null );
$follow_requests = $current_user->getFollowRequests();

require( 'views/_header.php' );
require( 'views/current_user.php' );
require( 'views/_footer.php' );