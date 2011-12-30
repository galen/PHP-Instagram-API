<?php

require( '_common.php' );

$user_id = isset( $_GET['user'] ) ? $_GET['user'] : 11007611;
if ( ctype_digit( $user_id ) ) {
	$user = $instagram->getUser( $user_id );
}
else {
	$user = $instagram->searchUsers( $user_id, array( 'count' => 1 ) )->getItem( 1 );
}
$media = $user->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );
$follows = $user->getFollows( isset( $_GET['follows_cursor'] ) ? array( 'cursor' => $_GET['follows_cursor'] ) : null );
$followers = $user->getFollowedBy( isset( $_GET['followers_cursor'] ) ? array( 'cursor' => $_GET['followers_cursor'] ) : null );

require( '_header.php' );
?>

<h3><?php echo $user ?></h3>
<img src="<?php echo $user->getProfilePicture() ?>">

<dl>
	<dt>Name</dt>
	<dd><?php echo $user->getFullName() ?></dd>
	<dt>Website</dt>
	<dd><a href="<?php echo $user->getWebsite() ?>"><?php echo $user->getWebsite() ?></a></dd>
	<dt>Bio</dt>
	<dd><?php echo $user->getBio() ?></dd>
</dl>

<a name="recent_media"></a>
<h4>Recent Media (<?php echo $user->getMediaCount() ?>) <?php if( $media->getNextMaxId() ): ?><a href="?example=user.php&max_id=<?php echo $media->getNextMaxId() ?>#recent_media" class="next_page">Next page</a><?php endif; ?></h4>
<ul class="media_list">
<?php foreach( $media as $m ): ?>
<li><a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a></li>
<?php endforeach; ?>
</ul>

<a name="follows"></a>
<h4>Follows (<?php echo $user->getFollowsCount() ?>) <?php if( $follows->getNextCursor() ): ?><a href="?example=user.php&follows_cursor=<?php echo $follows->getNextCursor() ?>#follows" class="next_page">Next page</a><?php endif; ?></h4>
<ul class="media_list">
<?php foreach( $follows as $follow ): ?>
<li><a href="?example=user.php&user=<?php echo $follow->getId() ?>"><img src="<?php echo $follow->getProfilePicture() ?>" title="<?php echo $follow ?>"></a></li>
<?php endforeach; ?>
</ul>

<a name="followers"></a>
<h4>Followers (<?php echo $user->getFollowedByCount() ?>) <?php if( $followers->getNextCursor() ): ?><a href="?example=user.php&followers_cursor=<?php echo $followers->getNextCursor() ?>#followers" class="next_page">Next page</a><?php endif; ?></h4>
<ul class="media_list">
<?php foreach( $followers as $follower ): ?>
<li><a href="?example=user.php&user=<?php echo $follower->getId() ?>"><img src="<?php echo $follower->getProfilePicture() ?>" title="<?php echo $follower ?>"></a></li>
<?php endforeach; ?>
</ul>

<?php require( '_footer.php' ); ?>