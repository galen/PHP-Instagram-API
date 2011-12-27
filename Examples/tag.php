<?php

require( '_common.php' );

$tag = $instagram->getTag( isset( $_GET['tag'] ) ? $_GET['tag'] : 'mariokart' );
$media = $tag->getMedia( isset( $_GET['max_tag_id'] ) ? array( 'max_tag_id' => $_GET['max_tag_id'] ) : null );

require( '_header.php' );
?>

<h1>#<?php echo $tag ?></h1>

<h2>Recent Media </h2>
<?php foreach( $media as $m ): ?>
<a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a>
<?php endforeach; ?>

<?php if( $media->getNextMaxTagId() ): ?><br><br><a href="?example=tag.php&tag=<?php echo $tag ?>&max_tag_id=<?php echo $media->getNextMaxTagId() ?>">Next page</a><?php endif; ?>
