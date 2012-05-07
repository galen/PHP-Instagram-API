<h2>Currently Logged In User</h2>

<h3><?php echo $current_user ?></h3>
<img src="<?php echo $current_user->getProfilePicture() ?>">

<a name="recent_media"></a>
<h4>Recent Media (<?php echo $current_user->getMediaCount() ?>) <?php if( $media->getNextMaxId() ): ?><a href="?example=current_user.php&max_id=<?php echo $media->getNextMaxId() ?>#recent_media" class="next_page">Next page</a><?php endif; ?></h4>
<ul class="media_list">
<?php foreach( $media as $m ): ?>
<li><a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a></li>
<?php endforeach; ?>
</ul>

<a name="follows"></a>
<h4>Follows (<?php echo $current_user->getFollowsCount() ?>) <?php if( $follows->getNextCursor() ): ?><a href="?example=current_user.php&follows_cursor=<?php echo $follows->getNextCursor() ?>#follows" class="next_page">Next page</a><?php endif; ?></h4>
<ul class="media_list">
<?php foreach( $follows as $follow ): ?>
<li><a href="?example=user.php&user=<?php echo $follow ?>"><img src="<?php echo $follow->getProfilePicture() ?>" title="<?php echo $follow ?>"></a></li>
<?php endforeach; ?>
</ul>

<a name="followers"></a>
<h4>Followers (<?php echo $current_user->getFollowersCount() ?>) <?php if( $followers->getNextCursor() ): ?><a href="?example=current_user.php&followers_cursor=<?php echo $followers->getNextCursor() ?>#followers" class="next_page">Next page</a><?php endif; ?></h4>
<ul class="media_list">
<?php foreach( $followers as $follower ): ?>
<li><a href="?example=user.php&user=<?php echo $follower ?>"><img src="<?php echo $follower->getProfilePicture() ?>" title="<?php echo $follower ?>"></a></li>
<?php endforeach; ?>
</ul>

<a name="liked_media"></a>
<h4>Liked Media <?php if( $liked_media->getNextMaxLikeId() ): ?> <a href="?example=current_user.php&max_like_id=<?php echo $liked_media->getNextMaxLikeId() ?>#liked_media" class="next_page">Next page</a><?php endif; ?></h4>
<ul class="media_list">
<?php foreach( $liked_media as $liked_m ): ?>
<li><a href="?example=media.php&media=<?php echo $liked_m->getId() ?>"><img src="<?php echo $liked_m->getThumbnail()->url ?>"></a></li>
<?php endforeach; ?>
</ul>

<a name="feed"></a>
<h4>Feed <?php if( $feed->getNextMaxId() ): ?> <a href="?example=current_user.php&max_feed_id=<?php echo $feed->getNextMaxId() ?>#feed" class="next_page">Next page</a><?php endif; ?></h4>
<ul class="media_list">
<?php foreach( $feed as $f ): ?>
<li><a href="?example=media.php&media=<?php echo $f->getId() ?>"><img src="<?php echo $f->getThumbnail()->url ?>" title="Posted by <?php echo $f->getUser() ?>"></a></li>
<?php endforeach; ?>
</ul>

<a name="follower_requests"></a>
<h4>Follow Requests <?php if( $follow_requests->getNextCursor() ): ?><a href="?example=current_user.php&follow_requests_cursor=<?php echo $follow_requests->getNextCursor() ?>#follow_requests" class="next_page">Next page</a><?php endif; ?></h4>
<ul class="media_list">
<?php foreach( $follow_requests as $follow_request ): ?>
<li><a href="?example=user.php&user=<?php echo $follow_request ?>"><img src="<?php echo $follow_request->getProfilePicture() ?>" title="<?php echo $follow_request ?>"></a></li>
<?php endforeach; ?>
</ul>