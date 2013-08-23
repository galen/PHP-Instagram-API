<?php

$instagram = new Instagram\Instagram;
$instagram->setAccessToken( $_SESSION['instagram_access_token'] );

$media_id = isset( $_GET['media'] ) ? $_GET['media'] : '508844963978072137_11007611';
$current_user = $instagram->getCurrentUser();

try {
    if ( isset( $_POST['action'] ) ) {
        switch( strtolower( $_POST['action'] ) ) {
            case 'add_comment':
                $current_user->addMediaComment( $media_id, $_POST['comment_text'] );
                break;
            case 'delete_comment':
                $current_user->deleteMediaComment( $media_id, $_POST['comment_id'] );
                break;
            case 'like':
                $current_user->addLike( $media_id );
                break;
            case 'unlike':
                $current_user->deleteLike( $media_id );
                break;
        }
    }
}
catch( \Instagram\Core\ApiException $e ) {
    $error = $e->getMessage();
}

$media = $instagram->getMedia( $media_id );
$comments = $media->getComments();

$tags_closure = function($m){
    return sprintf( '<a href="?example=tag.php&tag=%s">%s</a>', $m[1], $m[0] );
};

$mentions_closure = function($m){
    return sprintf( '<a href="?example=user.php&user=%s">%s</a>', $m[1], $m[0] );
};

require( 'views/_header.php' );
require( 'views/media.php' );
require( 'views/_footer.php' );
