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
  navigator.geolocation.getCurrentPosition(success, error, {enableHighAccuracy: true, timeout: 10000});
} else {
  alert('Error getting location');
  window.location = 'http://www.galengrover.com/projects/instagram';
}
</script>
<p>Searching for your location <img src="system/lib/PHP-Instagram-API/Examples/_images/working.gif"></p>
<?php endif; ?>
