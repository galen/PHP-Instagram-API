<h2>Search Media <?php if( $media->getNext() ): ?><a href="?example=search.php&search_type=media&lat=<?php echo $_GET['lat'] ?>&lng=<?php echo $_GET['lng'] ?>&distance=<?php echo (int)$_GET['distance'] ?>&max_timestamp=<?php echo $media->getNext() ?>" class="next_page">Next page</a><?php endif; ?></h2>
Searching near <em><?php echo $_GET['lat'] ?>, <?php echo $_GET['lng'] ?></em><?php if( isset( $_GET['max_timestamp'] ) ): ?> before <?php echo date( 'M jS Y @ g:ia', $_GET['max_timestamp'] ) ?><?php endif ?>
<ul class="media_list">
<?php foreach( $media as $m ): ?>
	<li><a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getStandardRes()->url ?>" title="Posted by <?php echo $m->getUser() ?> on <?php echo $m->getCreatedTime( 'M jS Y @ g:ia' ) ?>"></a></li>
<?php endforeach; ?>
</ul>