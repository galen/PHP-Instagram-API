<?php

require( '_SplClassLoader.php' );

$loader = new SplClassLoader( 'Instagram', '../Instagram' );
$loader->register();