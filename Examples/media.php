<?php

require( '_common.php' );

$media = $instagram->getMedia( isset( $_GET['media'] ) ? $_GET['media'] : 23 );
$comments = $media->getComments();

$tags_closure = function($m){
	return sprintf( '<a href="?example=tag.php&tag=%s">%s</a>', $m[1], $m[0] );
};

$mentions_closure = function($m){
	return sprintf( '<a href="?example=user.php&user=%s">%s</a>', $m[1], $m[0] );
};

require( '_header.php' );
?>

<h1><a href="?example=user.php&user=<?php echo $media->getUser()->getId() ?>"><?php echo $media->getUser() ?></h1>
<a href="<?php echo $media->getLink() ?>"><img src="<?php echo $media->getStandardRes()->url ?>"><br></a>

<?php if( $media->getCaption() ): ?>
<caption><em><?php echo \Instagram\Helper::parseTagsAndMentions( $media->getCaption(), $tags_closure, $mentions_closure ) ?></em></caption>
<?php endif; ?>

<dl>
	<dt>Likes</dt>
	<dd><?php echo $media->getLikesCount() ?></dd>
	<dt>Tags</dt>
	<dd><?php echo $media->getTags()->implode( function( $t ){ return sprintf( '<a href="?example=tag.php&tag=%1$s">#%1$s</a>', $t ); } ) ?></dd>
</dl>

<?php if( $media->hasNamedLocation() ): ?>@<a href="?example=location.php&location=<?php echo $media->getLocation()->getId() ?>"><?php echo $media->getLocation() ?></a><?php endif; ?>

<?php if( $media->hasLocation() ): ?><p><a href="?example=search_media.php&lat=<?php echo $media->getLocation()->getLat() ?>&lng=<?php echo $media->getLocation()->getLng() ?>">Search nearby media</a></p><?php endif; ?>

<?php foreach( $comments as $comment ): ?>
<p><strong><a href="?example=user.php&user=<?php echo $comment->getUser()->getId() ?>"><?php echo $comment->getUser() ?></a>: </strong><?php echo $comment->getText( $tags_closure, $mentions_closure ) ?></p>
<?php endforeach ?>


