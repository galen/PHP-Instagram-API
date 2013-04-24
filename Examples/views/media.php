<a href="<?php echo $media->getLink() ?>"><img src="<?php echo $media->getStandardRes()->url ?>"></a>
<?php if( $media->getCaption() ): ?>
<p id="caption"><em><?php echo \Instagram\Helper::parseTagsAndMentions( $media->getCaption(), $tags_closure, $mentions_closure ) ?></em></p>
<?php endif; ?>
<form id="like" action="?example=media.php&media_id=<?php echo $media_id ?>" method="post">
	<?php if( $current_user->likes( $media ) ): ?>
	<input type="submit" name="action" value="Unlike">
	<?php else: ?>
	<input type="submit" name="action" value="Like">
	<?php endif; ?>
</form>
<dl>
	<dt>User</dt>
	<dd><a href="?example=user.php&user=<?php echo $media->getUser() ?>"><?php echo $media->getUser() ?></a></dd>
	<dt>Date</dt>
	<dd><?php echo $media->getCreatedTime( 'M jS Y @ g:ia' ) ?></dd>
	<dt>Likes (<?php echo $media->getLikesCount() ?>)<?php if( !isset( $_GET['all_likes'] ) ): ?><br><a href="?example=media.php&media=<?php echo $media->getId() ?>&all_likes=true">View all</a><?php else: ?><br>Viewing all <a href="?example=media.php&media=<?php echo $media->getId() ?>">X</a><?php endif; ?></dt>
	<dd><ul class="media_list"><?php foreach( $media->getLikes( isset( $_GET['all_likes'] ) ? true : false ) as $like ): ?><li><a href="?example=user.php&user=<?php echo $like ?>"><img src="<?php echo $like->getProfilePicture() ?>"></a></li><?php endforeach; ?></ul></dd>
	<dt>Tags</dt>
	<dd><?php echo $media->getTags()->implode( function( $t ){ return sprintf( '<a href="?example=tag.php&tag=%1$s">#%1$s</a>', $t ); } ) ?></dd>
	<dt>Filter</dt>
	<dd><?php echo $media->getFilter() ?></dd>
	<dt>Location</dt>
	<dd>
	<?php if( $media->hasNamedLocation() ): ?>
		<a href="?example=location.php&location=<?php echo $media->getLocation()->getId() ?>"><?php echo $media->getLocation() ?></a>
	<?php elseif( $media->hasLocation() ): ?>
		<a href="?example=search.php&search_type=media&lat=<?php echo $media->getLocation()->getLat() ?>&lng=<?php echo $media->getLocation()->getLng() ?>&distance=100">Search nearby media</a
	<?php endif; ?>
	</dd>
</dl>

<a name="comments"></a>
<h3>Comments</h3>
<?php if( count( $comments ) ): ?>
<?php foreach( $comments as $comment ): ?>
<p><strong><a href="?example=user.php&user=<?php echo $comment->getUser() ?>"><?php echo $comment->getUser() ?></a>: </strong><?php echo \Instagram\Helper::parseTagsAndMentions( $comment->getText(), $tags_closure, $mentions_closure ) ?><?php if( \Instagram\Helper::commentIsDeletable( $comment, $media, $current_user ) ): ?>
<form action="#comments" method="post">
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
<form action="#comments" method="post" id="comment_form">
<input type="hidden" name="action" value="add_comment">
<textarea id="comment_text" name="comment_text"></textarea>
<input type="submit" name="comment_submit" value="Comment">
</form>
