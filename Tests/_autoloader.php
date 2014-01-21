<?php

require( '_SplClassLoader.php' );

$loader = new SplClassLoader( 'Instagram', __DIR__ . '/../' );
$loader->register();