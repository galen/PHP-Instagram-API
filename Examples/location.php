<?php

require( '_common.php' );

$location = $instagram->getLocation( isset( $_GET['location'] ) ? $_GET['location'] : 3001881 );
$media = $location->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );


require( '_header.php' );
?>

<h2>Location</h2>

<h3><?php echo $location ?></h3>

<h4>Recent Media<?php if( $media->getNextMaxId() ): ?> <a href="?example=location.php&location=<?php echo $location->getId() ?>&max_id=<?php echo $media->getNextMaxId() ?>" class="next_page">Next page</a><?php endif; ?></h4>

<ul class="media_list">
<?php foreach( $media as $m ): ?>
<a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a>
<?php endforeach; ?>

<?php require( '_footer.php' ) ?>