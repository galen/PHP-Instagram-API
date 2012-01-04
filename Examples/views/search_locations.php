<h2>Search Locations</h2>
Searching near <em><?php echo $_GET['lat'] ?>, <?php echo $_GET['lng'] ?></em>
<ul class="list">
<?php foreach( $locations as $location ): ?>
	<li><a href="?example=location.php&location=<?php echo $location->getId() ?>"><?php echo $location ?></a></li>
<?php endforeach; ?>
</ul>