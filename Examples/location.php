<?php

require( '_common.php' );

$location = $instagram->getLocation( isset( $_GET['location'] ) ? $_GET['location'] : 3001881 );
$media = $location->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );


require( '_header.php' );
?>

<h1><?php echo $location ?></h1>

<h2>Recent Media </h2>
<?php foreach( $media as $m ): ?>
<a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a>
<?php endforeach; ?>

<?php if( $media->getNextMaxId() ): ?><br><br><a href="?example=location.php&location=<?php echo $location->getId() ?>&max_id=<?php echo $media->getNextMaxId() ?>">Next page</a><?php endif; ?>
