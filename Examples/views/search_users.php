<h2>Search Users</h2>
<p>Search for <em><?php echo $_GET['user'] ?></em></p>
<ul class="media_list">
<?php foreach( $users as $user ): ?>
	<li><a href="?example=user.php&user=<?php echo $user ?>"><img src="<?php echo $user->getProfilePicture() ?>" title="<?php echo $user ?>"></a></li>
<?php endforeach; ?>
</ul>