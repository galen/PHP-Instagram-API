<?php

require( '_common.php' );

$user = $instagram->getCurrentUser();
$media = $user->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );
$follows = $user->getFollows( isset( $_GET['follows_cursor'] ) ? array( 'cursor' => $_GET['follows_cursor'] ) : null );
$followed_by = $user->getFollowedBy( isset( $_GET['followed_by_cursor'] ) ? array( 'cursor' => $_GET['followed_by_cursor'] ) : null );
$liked_media = $user->getLikedMedia( isset( $_GET['max_like_id'] ) ? array( 'max_like_id' => $_GET['max_like_id'] ) : null );

require( '_header.php' );
?>

<h1><?php echo $user ?></h1>
<img src="<?php echo $user->getProfilePicture() ?>">

<h2>Recent Media (<?php echo $user->getMediaCount() ?>) <?php if( $media->getNextMaxId() ): ?><a href="?example=current_user.php&max_id=<?php echo $media->getNextMaxId() ?>">Next page</a><?php endif; ?></h2>
<?php foreach( $media as $m ): ?>
<a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a>
<?php endforeach; ?>

<h2>Follows (<?php echo $user->getFollowsCount() ?>) <?php if( $follows->getNextCursor() ): ?><a href="?example=current_user.php&follows_cursor=<?php echo $follows->getNextCursor() ?>">Next page</a><?php endif; ?></h2>
<?php foreach( $follows as $follow ): ?>
<a href="?example=user.php&user=<?php echo $follow->getId() ?>"><img src="<?php echo $follow->getProfilePicture() ?>"></a>
<?php endforeach; ?>

<h2>Followed By (<?php echo $user->getFollowedByCount() ?>)<?php if( $followed_by->getNextCursor() ): ?><a href="?example=current_user.php&followed_by_cursor=<?php echo $followed_by->getNextCursor() ?>">Next page</a><?php endif; ?></h2>
<?php foreach( $followed_by as $follower ): ?>
<a href="?example=user.php&user=<?php echo $follower->getId() ?>"><img src="<?php echo $follower->getProfilePicture() ?>"></a>
<?php endforeach; ?>

<h2>Liked Media <?php if( $liked_media->getNextMaxLikeId() ): ?><a href="?example=current_user.php&max_like_id=<?php echo $liked_media->getNextMaxLikeId() ?>">Next page</a><?php endif; ?></h2>
<?php foreach( $liked_media as $liked_m ): ?>
<a href="?example=media.php&media=<?php echo $liked_m->getId() ?>"><img src="<?php echo $liked_m->getThumbnail()->url ?>"></a>
<?php endforeach; ?>