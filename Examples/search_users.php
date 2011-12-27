<?php

require( '_common.php' );

$q = isset( $_GET['q'] ) ? $_GET['q'] : 'yoshi';
$users = $instagram->searchUsersByName( $q );


require( '_header.php' );
?>

<h1>Search for user "<?php echo $q ?>" (<?php echo count( $users ) ?> results)</h1>

<ul>
<?php foreach( $users as $n => $user ): ?>
<?php echo $n+1 ?>. <a href="?example=user.php&user=<?php echo $user->getId() ?>"><?php echo $user ?></a><br>
<img src="<?php echo $user->getProfilePicture() ?>"><br><br>
<?php endforeach ?>
</ul>