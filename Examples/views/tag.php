<h3>#<?php echo $tag ?></h3>

<h4>Recent Media <?php if( $media->getNextMaxTagId() ): ?><a href="?example=tag.php&tag=<?php echo $tag ?>&max_tag_id=<?php echo $media->getNextMaxTagId() ?>" class="next_page">Next page</a></li><?php endif; ?></h4>
<ul class="media_list">
<?php foreach( $media as $m ): ?>
<li><a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>" title="Posted by <?php echo $m->getUser() ?> on <?php echo $m->getCreatedTime( 'M jS Y @ g:ia' ) ?>"></a></li>
<?php endforeach; ?>
</ul>