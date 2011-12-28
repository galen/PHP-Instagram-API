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
<h2>Search media near me</h2>

<h3>Found <?php echo count( $media ) ?> results <?php if( $media->getNextMaxTimeStamp() ): ?><a href="?example=near.php&lat=<?php echo $_GET['lat'] ?>&lng=<?php echo $_GET['lng'] ?>&max_timestamp=<?php echo $media->getNextMaxTimestamp() ?>" class="next_page">Next page</a><?php endif; ?></h3>

<ul class="media_list">
<?php foreach( $media as $n => $m ): ?>
<li><a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a></li>
<?php endforeach ?>
</ul>
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

<?php require( '_footer.php' ); ?>