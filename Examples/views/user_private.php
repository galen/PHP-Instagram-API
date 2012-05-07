<h3><?php echo $user ?></h3>
<img src="<?php echo $user->getProfilePicture() ?>">

<dl>
	<dt>Name</dt>
	<dd><?php echo $user->getFullName() ?></dd>
	<dt>Website</dt>
	<dd><a href="<?php echo $user->getWebsite() ?>"><?php echo $user->getWebsite() ?></a></dd>
	<dt>Bio</dt>
	<dd><?php echo $user->getBio() ?></dd>
	<?php if( $user->username != $current_user->username ): ?>
	<dt>Outgoing Relationship</dt>
	<dd><?php if( $current_user->isFollowing( $user ) ): ?>Following<a href="?example=user.php&user=<?php echo $user ?>&action=unfollow">X</a><?php else: ?><a href="?example=user.php&user=<?php echo $user ?>&action=follow">Follow</a><?php endif; ?></dd>
	<dt>Incoming Relationship</dt>
	<dd><?php if( $incoming_relationship == 'requested_by' ): ?>Requested By: <a href="?example=user.php&user=<?php echo $user ?>&action=approve_follower">Approve</a>, <a href="?example=user.php&user=<?php echo $user ?>&action=ignore_follower">Ignore</a><?php else: ?><?php echo ucfirst( str_replace( '_', ' ', $incoming_relationship ) ) ?><?php endif; ?></dd>
	<?php endif; ?>
	<dt>Block</dt>
	<dd><a href="?example=user.php&user=<?php echo $user ?>&action=block">Block this user</a></dd>
</dl>
<?php if( $user->username == $current_user->username ): ?><p>This is you</p><?php else: ?><p>This use is private</p><?php endif; ?>