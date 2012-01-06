<?php

require( '_common.php' );

$user = $instagram->getCurrentUser();
$media = $user->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );
$follows = $user->getFollows( isset( $_GET['follows_cursor'] ) ? array( 'cursor' => $_GET['follows_cursor'] ) : null );
$followers = $user->getFollowers( isset( $_GET['followers_cursor'] ) ? array( 'cursor' => $_GET['followers_cursor'] ) : null );
$liked_media = $user->getLikedMedia( isset( $_GET['max_like_id'] ) ? array( 'max_like_id' => $_GET['max_like_id'] ) : null );
$feed = $user->getFeed( isset( $_GET['max_feed_id'] ) ? array( 'max_id' => $_GET['max_feed_id'] ) : null );
$follow_requests = $user->getFollowRequests();

require( 'views/_header.php' );
require( 'views/current_user.php' );
require( 'views/_footer.php' );