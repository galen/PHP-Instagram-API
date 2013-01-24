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
		<dd>
			<?php if( $current_user->isAwaitingFollowApprovalFrom( $user ) ): ?>
				Requested
				<form action="" method="post">
					<input type="submit" name="action" value="Cancel Request">
					<input type="hidden" name="error_message" value="Error unfollowing <?php echo $user ?>">
				</form>
			<?php elseif( $current_user->isFollowing( $user ) ): ?>
				Following
				<form action="" method="post">
					<input type="submit" name="action" value="Unfollow">
					<input type="hidden" name="error_message" value="Error unfollowing <?php echo $user ?>">
				</form>
			<?php else: ?>
				<form action="" method="post">
					<input type="submit" name="action" value="Follow">
					<input type="hidden" name="error_message" value="Error following <?php echo $user ?>">
				</form>
			<?php endif; ?>
		</dd>
		<dt>Incoming Relationship</dt>
		<dd>
			<?php if( $current_user->hasBeenRequestedBy( $user ) ): ?>
				Requested By: 
				<form action="" method="post">
					<input type="submit" name="action" value="Approve Follower">
					<input type="hidden" name="error_message" value="Error approving follower <?php echo $user ?>">
				</form>
				<form action="" method="post">
					<input type="submit" name="action" value="Ignore Follower">
					<input type="hidden" name="error_message" value="Error ignoring <?php echo $user ?>">
				</form>
			<?php else: ?>
				<?php echo ucfirst( str_replace( '_', ' ', $incoming_relationship ) ) ?>
			<?php endif; ?>
		</dd>
		<dt>Block</dt>
		<?php if( $current_user->isBlocking( $user ) ): ?>
			<dd>
				<form action="" method="post">
					<input type="submit" name="action" value="Unblock">
					<input type="hidden" name="error_message" value="Error unblocking <?php echo $user ?>">
				</form>
			</dd>
		<?php else: ?>
			<dd>
				<form action="" method="post">
					<input type="submit" name="action" value="Block">
					<input type="hidden" name="error_message" value="Error blocking <?php echo $user ?>">
				</form>
			</dd>
		<?php endif; ?>
	<?php endif; ?>
</dl>
<p>This user is private</p>