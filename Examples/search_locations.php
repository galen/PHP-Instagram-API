<?php

require( '_common.php' );

$locations = $instagram->searchLocations( 40.778201, -73.969874 );


require( '_header.php' );
?>

<h2>Search Locations near Central Park (<?php echo count( $locations ) ?> results)</h2>

<ol>
<?php foreach( $locations as $n => $location ): ?>
<li><a href="?example=location.php&location=<?php echo $location->getId() ?>"><?php echo $location ?></a></li>
<?php endforeach ?>
</ol>

<?php require( '_footer.php' ) ?>