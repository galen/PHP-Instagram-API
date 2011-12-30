<?php

require( '_common.php' );

$media = $instagram->getPopularMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );

require( '_header.php' );
?>

<h2>Popular Media</h2>

<ul class="media_list">
<?php foreach( $media as $m ): ?>
<li><a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a></li>
<?php endforeach; ?>
</ul>

<?php require( '_footer.php' ) ?>