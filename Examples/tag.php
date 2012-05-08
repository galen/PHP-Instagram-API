<?php

$instagram = new Instagram\Instagram;
$instagram->setAccessToken( $_SESSION['instagram_access_token'] );

$tag = $instagram->getTag( isset( $_GET['tag'] ) ? $_GET['tag'] : 'mariokart' );
$media = $tag->getMedia( isset( $_GET['max_tag_id'] ) ? array( 'max_tag_id' => $_GET['max_tag_id'] ) : null );

require( 'views/_header.php' );
require( 'views/tag.php' );
require( 'views/_footer.php' );