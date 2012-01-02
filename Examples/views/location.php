<h2>Location</h2>

<h3><?php echo $location ?></h3>

<h4>Recent Media<?php if( $media->getNextMaxId() ): ?> <a href="?example=location.php&location=<?php echo $location->getId() ?>&max_id=<?php echo $media->getNextMaxId() ?>" class="next_page">Next page</a><?php endif; ?></h4>

<ul class="media_list">
<?php foreach( $media as $m ): ?>
<a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a>
<?php endforeach; ?>