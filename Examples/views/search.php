<script type="text/javascript"
    src="http://maps.googleapis.com/maps/api/js?sensor=false">
</script>
<script type="text/javascript">
  function initialize() {

    var latlng_media = new google.maps.LatLng(<?php if( isset( $media ) ): ?><?php echo $_GET['lat'] ?>, <?php echo $_GET['lng'] ?><?php else: ?>32.7153292, -117.1572551<?php endif; ?>);
    var myOptions_media = {
      zoom: <?php if( isset( $media ) ): ?>14<?php else: ?>8<?php endif; ?>,
      center: latlng_media,
      streetViewControl: false,
      mapTypeControl: false,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var latlng_locations = new google.maps.LatLng(<?php if( isset( $locations ) ): ?><?php echo $_GET['lat'] ?>, <?php echo $_GET['lng'] ?><?php else: ?>40.7746431, -73.9701962<?php endif; ?>);
    var myOptions_locations = {
      zoom: <?php if( isset( $locations ) ): ?>14<?php else: ?>8<?php endif; ?>,
      center: latlng_locations,
      streetViewControl: false,
      mapTypeControl: false,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    
    var map_media = new google.maps.Map(document.getElementById("map_media"), myOptions_media );
	google.maps.event.addListener(map_media, 'dragend', function(e) {
		document.getElementById("media_lat").value = Math.round( map_media.center.lat()*1000000)/1000000;
		document.getElementById("media_lng").value = Math.round( map_media.center.lng()*1000000 )/1000000;
	});
	if ( !document.getElementById("media_lat").value ) {
		document.getElementById("media_lat").value = Math.round( map_media.center.lat()*1000000)/1000000;
		document.getElementById("media_lng").value = Math.round( map_media.center.lng()*1000000 )/1000000;
	}
	
    var map_locations = new google.maps.Map(document.getElementById("map_locations"), myOptions_locations );
	google.maps.event.addListener(map_locations, 'dragend', function(e) {
		document.getElementById("locations_lat").value = Math.round( map_locations.center.lat()*1000000)/1000000;
		document.getElementById("locations_lng").value = Math.round( map_locations.center.lng()*1000000 )/1000000;
	});
	if ( !document.getElementById("locations_lat").value ) {
		document.getElementById("locations_lat").value = Math.round( map_locations.center.lat()*1000000)/1000000;
		document.getElementById("locations_lng").value = Math.round( map_locations.center.lng()*1000000 )/1000000;
	}
  }

google.maps.event.addDomListener(window, "load", initialize );
</script>

<div id="search_forms">

	<div id="users_wrapper" class="search_form_wrapper<?php if( isset( $users ) ): ?> active<?php endif; ?>">
		<h2>Search Users</h2>
		<form action="">
			<input type="hidden" name="example" value="search.php">
			<input type="hidden" name="search_type" value="users">
			<label for="user">Search string</label>
			<input id="user" type="text" name="user" value="<?php if( isset( $users ) ): ?><?php echo $_GET['user'] ?><?php endif; ?>"><br>
			<input type="submit" value="Search Users">
		</form>
	</div>

	<div id="users_wrapper" class="search_form_wrapper<?php if( isset( $tags ) ): ?> active<?php endif; ?>">
		<h2>Search Tags</h2>
		<form action="">
			<input type="hidden" name="example" value="search.php">
			<input type="hidden" name="search_type" value="tags">
			<label for="tag">Search string</label>
			<input id="tag" type="text" name="tag" value="<?php if( isset( $tags ) ): ?><?php echo $_GET['tag'] ?><?php endif; ?>"><br>
			<input type="submit" value="Search Tags">
		</form>
	</div>	

	<div id="users_wrapper" class="search_form_wrapper<?php if( isset( $media ) ): ?> active<?php endif; ?>">
		<h2>Search Media</h2>
		<div class="map_wrapper"><div id="map_media" class="map"></div><img src="/projects/instagram/system/lib/PHP-Instagram-API/Examples/_images/crosshair.gif" class="crosshairs"></div>
		<form action="">
			<input type="hidden" name="example" value="search.php">
			<input type="hidden" name="search_type" value="media">
			<label for="lat">Latitude</label>
			<input id="media_lat" type="text" name="lat" value="<?php if( isset( $media ) ): ?><?php echo $_GET['lat'] ?><?php endif; ?>"><br>
			<label for="lng">Longitude</label>
			<input id="media_lng" type="text" name="lng" value="<?php if( isset( $media ) ): ?><?php echo $_GET['lng'] ?><?php endif; ?>"><br>
			<label for="distance">Distance</label>
			<input id="distance" type="text" name="distance" value="<?php if( isset( $_GET['distance'] ) ): ?><?php echo (int)$_GET['distance'] ?><?php else: ?>1000<?php endif; ?>"> <span>meters</span><br>
			<input type="submit" value="Search Media">
		</form>
	</div>

	<div id="users_wrapper" class="search_form_wrapper<?php if( isset( $locations ) ): ?> active<?php endif; ?>">
		<h2>Search Locations</h2>
		<div class="map_wrapper"><div id="map_locations" class="map"></div><img src="/projects/instagram/system/lib/PHP-Instagram-API/Examples/_images/crosshair.gif" class="crosshairs"></div>
		<form action="">
			<input type="hidden" name="example" value="search.php">
			<input type="hidden" name="search_type" value="locations">
			<label for="lat">Latitude</label>
			<input id="locations_lat" type="text" name="lat" value="<?php if( isset( $locations ) ): ?><?php echo $_GET['lat'] ?><?php endif; ?>"><br>
			<label for="lng">Longitude</label>
			<input id="locations_lng" type="text" name="lng" value="<?php if( isset( $locations ) ): ?><?php echo $_GET['lng'] ?><?php endif; ?>"><br>
			<label for="distance">Distance</label>
			<input id="distance" type="text" name="distance" value="<?php if( isset( $_GET['distance'] ) ): ?><?php echo (int)$_GET['distance'] ?><?php else: ?>1000<?php endif; ?>"> <span>meters</span><br>
			<input type="submit" value="Search Locations">
		</form>
	</div>

</div>
<div id="search_results">
<?php if( isset( $results_view ) ): ?><?php require( $results_view ) ?><?php endif; ?>
</div>