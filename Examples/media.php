<?php

require( '_common.php' );

$media = $instagram->getMedia( isset( $_GET['media'] ) ? $_GET['media'] : 23 );
$comments = $media->getComments();


require( '_header.php' );
?>

<a href="<?php echo $media->getLink() ?>"><img src="<?php echo $media->getStandardRes()->url ?>"><br></a>

<?php if( $media->getCaption() ): ?>
<caption><em><?php echo $media->getCaption() ?></em></caption>
<?php endif; ?>

<dl>
	<dt>Likes</dt>
	<dd><?php echo $media->getLikesCount() ?></dd>
	<dt>Tags</dt>
	<dd><?php echo $media->getTags()->implode( function( $t ){ return sprintf( '<a href="?example=tag.php&tag=%1$s">%1$s</a>', $t ); } ) ?></dd>
</dl>

<?php if( $media->hasNamedLocation() ): ?>@<a href="?example=location.php&location=<?php echo $media->getLocation()->getId() ?>"><?php echo $media->getLocation() ?></a><?php endif; ?>

<?php if( $media->hasLocation() ): ?><p><a href="?example=search_media.php&lat=<?php echo $media->getLocation()->getLat() ?>&lng=<?php echo $media->getLocation()->getLng() ?>">Search nearby media</a></p><?php endif; ?>

<?php foreach( $comments as $comment ): ?>
<p><strong><a href="?example=user.php&user=<?php echo $comment->getUser()->getId() ?>"><?php echo $comment->getUser() ?></a>: </strong><?php echo $comment ?></p>
<?php endforeach ?>


