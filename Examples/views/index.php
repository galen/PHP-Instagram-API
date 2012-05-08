
<h2>Choose an example to load</h2>
<ul>
<?php foreach( $files as $file ): ?>
	<?php if( strpos( basename( $file ), '_' ) !== 0 ): ?>
	<li>- <a href="?example=<?php echo basename( $file ) ?>"><?php echo str_replace( '_', ' ', basename( $file, '.php' ) ) ?></a> &rarr; <a href="<?php echo GITHUB_URL ?><?php echo basename( $file ) ?>">github</a></li>
	<?php endif; ?>
<?php endforeach; ?>
</ul>