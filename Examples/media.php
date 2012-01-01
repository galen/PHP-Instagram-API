<?php

require( '_common.php' );

$media_id = isset( $_GET['media'] ) ? $_GET['media'] : '427150720_11007611';

$current_user = $instagram->getCurrentUser();

if ( isset( $_POST['action'] ) ) {
	switch( $_POST['action'] ) {
		case 'add_comment':
			$current_user->addMediaComment( $media_id, $_POST['comment_text'] );
			break;
		case 'delete_comment':
			$current_user->deleteMediaComment( $media_id, $_POST['comment_id'] );
			break;
	}
}

if ( isset( $_GET['action'] ) ) {
	switch( $_GET['action'] ) {
		case 'like':
			$current_user->addLike( $media_id );
			break;
		case 'unlike':
			$current_user->deleteLike( $media_id );
			break;
	}
}

$media = $instagram->getMedia( $media_id );
$comments = $media->fetchComments();

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
<p id="like"><?php if( $current_user->likes( $media ) ): ?><a href="?example=media.php&media=<?php echo $media->getId() ?>&action=unlike">Unlike</a><?php else: ?><a href="?example=media.php&media=<?php echo $media->getId() ?>&action=like">Like</a><?php endif; ?></p>
<dl>
	<dt>User</dt>
	<dd><a href="?example=user.php&user=<?php echo $media->getUser()->getId() ?>"><?php echo $media->getUser() ?></a></dd>
	<dt>Date</dt>
	<dd><?php echo $media->getCreatedTime( 'M jS Y @ g:ia' ) ?></dd>
	<dt>Likes (<?php echo $media->getLikesCount() ?>)</dt>
	<dd><ul class="media_list"><?php foreach( $media->getLikes() as $like ): ?><li><a href="?example=user.php&user=<?php echo $like->getId() ?>"><img src="<?php echo $like->getProfilePicture() ?>"></a></li><?php endforeach; ?></ul></dd>
	<dt>Tags</dt>
	<dd><?php echo $media->getTags()->implode( function( $t ){ return sprintf( '<a href="?example=tag.php&tag=%1$s">#%1$s</a>', $t ); } ) ?></dd>
	<dt>Filter</dt>
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
<?php if( count( $comments ) ): ?>
<?php foreach( $comments as $comment ): ?>
<p><strong><a href="?example=user.php&user=<?php echo $comment->getUser()->getId() ?>"><?php echo $comment->getUser() ?></a>: </strong><?php echo \Instagram\Helper::parseTagsAndMentions( $comment->getText(), $tags_closure, $mentions_closure ) ?><?php if( $comment->getUSer()->getId() == $current_user->getId() ): ?>
<form action="" method="post">
<input type="submit" value="X">
<input type="hidden" name="example" value="media.php">
<input type="hidden" name="media" value="<?php echo $media->getId() ?>">
<input type="hidden" name="action" value="delete_comment">
<input type="hidden" name="comment_id" value="<?php echo $comment->getId() ?>">
</form>
<?php endif; ?></p>
<?php endforeach ?>
<?php else: ?>
<p><em>No comments</em></p>
<?php endif; ?>
<form action="" method="post" id="comment_form">
<input type="hidden" name="action" value="add_comment">
<textarea id="comment_text" name="comment_text"></textarea>
<input type="submit" name="comment_submit" value="Comment">
</form>
<?php require( '_footer.php' ) ?>
