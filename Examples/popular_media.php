<?php

$media = $instagram->getPopularMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );

require( 'views/_header.php' );
require( 'views/popular_media.php' );
require( 'views/_footer.php' );