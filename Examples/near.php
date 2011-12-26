<?php

require( '_common.php' );

if ( isset( $_GET['lat'], $_GET['lng'] ) ) {
	$search = true;
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];
	$media = $instagram->searchMedia( $lat, $lng, isset( $_GET['max_timestamp'] ) ? array( 'max_timestamp' => $_GET['max_timestamp'] ) : null );
}


require( '_header.php' );
?>

<?php if ( isset( $media ) ): ?>
<h1>Search media near me (<?php echo count( $media ) ?> results)</h1>

<?php foreach( $media as $n => $m ): ?>
<a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a>
<?php endforeach ?>
<?php if( $media->getNextMaxTimeStamp() ): ?><br><br><a href="?example=near.php&lat=<?php echo $_GET['lat'] ?>&lng=<?php echo $_GET['lng'] ?>&max_timestamp=<?php echo $media->getNextMaxTimestamp() ?>">Next page</a><?php endif; ?>
<?php else: ?>
<script type="text/javascript">
success = function(position){
console.log(position);
window.location=window.location+"&lat="+position.coords.latitude+"&lng="+position.coords.longitude;
}
error = function(){}
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(success, error, {enableHighAccuracy: true});
} else {
  alert('not supported');
}
</script>
Searching for your location…
<?php endif; ?>


