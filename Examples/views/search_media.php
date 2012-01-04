<h2>Search Media</h2>
Searching near <em><?php echo $_GET['lat'] ?>, <?php echo $_GET['lng'] ?></em>
<ul class="media_list">
<?php foreach( $media as $m ): ?>
	<li><a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getStandardRes()->url ?>" title=""></a></li>
<?php endforeach; ?>
</ul>