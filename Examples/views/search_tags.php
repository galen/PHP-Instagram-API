<h2>Search Tags</h2>
<p>Search for <em><?php echo $_GET['tag'] ?></em></p>
<ul class="list">
<?php foreach( $tags as $tag ): ?>
	<li><a href="?example=tag.php&tag=<?php echo $tag ?>"><?php echo $tag ?></a></li>
<?php endforeach; ?>
</ul>