<?php

require( '_common.php' );

$q = isset( $_GET['q'] ) ? $_GET['q'] : 'yoshi';
$users = $instagram->searchUsers( $q );


require( '_header.php' );
?>

<h3>Search for user "<?php echo $q ?>" (<?php echo count( $users ) ?> results)</h3>

<ul class="media_list">
<?php foreach( $users as $n => $user ): ?>
<li><a href="?example=user.php&user=<?php echo $user->getId() ?>" title="<?php echo $user ?>"><img src="<?php echo $user->getProfilePicture() ?>"></a></li>
<?php endforeach ?>
</ul>

<?php require( '_footer.php' ) ?>