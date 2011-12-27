<?php

require( '_common.php' );

$user_id = isset( $_GET['user'] ) ? $_GET['user'] : 11007611;
$user = $instagram->getUser( $user_id );
$media = $user->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );
$follows = $user->getFollows( isset( $_GET['follows_cursor'] ) ? array( 'cursor' => $_GET['follows_cursor'] ) : null );
$followed_by = $user->getFollowedBy( isset( $_GET['followed_by_cursor'] ) ? array( 'cursor' => $_GET['followed_by_cursor'] ) : null );


require( '_header.php' );
?>

<h1><?php echo $user ?></h1>
<img src="<?php echo $user->getProfilePicture() ?>">

<h2>Recent Media (<?php echo $user->getMediaCount() ?>) <?php if( $media->getNextMaxId() ): ?><a href="?example=user.php&user=<?php echo $user_id ?>&max_id=<?php echo $media->getNextMaxId() ?>">Next page</a><?php endif; ?></h2>
<?php foreach( $media as $m ): ?>
<a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a>
<?php endforeach; ?>

<h2>Follows (<?php echo $user->getFollowsCount() ?>) <?php if( $follows->getNextCursor() ): ?><a href="?example=user.php&user=<?php echo $user_id ?>&follows_cursor=<?php echo $follows->getNextCursor() ?>">Next page</a><?php endif; ?></h2>
<?php foreach( $follows as $follow ): ?>
<a title="<?php echo $follow ?>" href="?example=user.php&user=<?php echo $follow->getId() ?>"><img src="<?php echo $follow->getProfilePicture() ?>"></a>
<?php endforeach; ?>

<h2>Followed By (<?php echo $user->getFollowedByCount() ?>)<?php if( $follows->getNextCursor() ): ?><a href="?example=user.php&user=<?php echo $user_id ?>&followed_by_cursor=<?php echo $followed_by->getNextCursor() ?>">Next page</a><?php endif; ?></h2>
<?php foreach( $followed_by as $follower ): ?>
<a title="<?php echo $follower ?>" href="?example=user.php&user=<?php echo $follower->getId() ?>"><img src="<?php echo $follower->getProfilePicture() ?>"></a>
<?php endforeach; ?>