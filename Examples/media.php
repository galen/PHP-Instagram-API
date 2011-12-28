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

<a href="<?php echo $media->getLink() ?>"><img src="<?php echo $media->getStandardRes()->url ?>"></a>
<?php if( $media->getCaption() ): ?>
<p id="caption"><em><?php echo \Instagram\Helper::parseTagsAndMentions( $media->getCaption(), $tags_closure, $mentions_closure ) ?></em></p>
<?php endif; ?>

<dl>
	<dt>User</dt>
	<dd><a href="?example=user.php&user=<?php echo $media->getUser()->getId() ?>"><?php echo $media->getUser() ?></a></dd>
	<dt>Date</dt>
	<dd><?php echo $media->getCreatedTime( 'M jS Y @ g:ia' ) ?></dd>
	<dt>Likes</dt>
	<dd><ul class="media_list"><?php foreach( $media->getLikes() as $like ): ?><li><a href="?example=user.php&user=<?php echo $like->getId() ?>"><img src="<?php echo $like->getProfilePicture() ?>"></a></li><?php endforeach; ?></ul></dd>
	<dt>Tags</dt>
	<dd><?php echo $media->getTags()->implode( function( $t ){ return sprintf( '<a href="?example=tag.php&tag=%1$s">#%1$s</a>', $t ); } ) ?></dd>
	<dt>filter</dt>
	<dd><?php echo $media->getFilter() ?></dd>
	<dt>Location</dt>
	<dd>
	<?php if( $media->hasNamedLocation() ): ?>
		<a href="?example=location.php&location=<?php echo $media->getLocation()->getId() ?>"><?php echo $media->getLocation() ?></a>
	<?php elseif( $media->hasLocation() ): ?>
		<a href="?example=search_media.php&lat=<?php echo $media->getLocation()->getLat() ?>&lng=<?php echo $media->getLocation()->getLng() ?>">Search nearby media</a
	<?php endif; ?>
	</dd>
</dl>

<h3>Comments</h3>
<?php foreach( $comments as $comment ): ?>
<p><strong><a href="?example=user.php&user=<?php echo $comment->getUser()->getId() ?>"><?php echo $comment->getUser() ?></a>: </strong><?php echo $comment->getText( $tags_closure, $mentions_closure ) ?></p>
<?php endforeach ?>


