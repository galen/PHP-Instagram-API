<h3><?php echo $user ?></h3>
<img src="<?php echo $user->getProfilePicture() ?>">

<dl>
	<dt>Name</dt>
	<dd><?php echo $user->getFullName() ?></dd>
	<dt>Website</dt>
	<dd><a href="<?php echo $user->getWebsite() ?>"><?php echo $user->getWebsite() ?></a></dd>
	<dt>Bio</dt>
	<dd><?php echo $user->getBio() ?></dd>
	<dt>Relationship</dt>
	<dd><?php if( $current_user->isFollowing( $user ) ): ?>Following<a href="?example=user.php&user=<?php echo $user->getId() ?>&action=unfollow">X</a><?php else: ?><a href="?example=user.php&user=<?php echo $user->getId() ?>&action=follow">Follow</a><?php endif; ?> <?php if( $current_user->isFollowedBy( $user ) ): ?>Followed by<?php endif; ?></dd>
</dl>

<p>This use is private</p>