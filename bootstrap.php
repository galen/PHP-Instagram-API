<?php

$module_paths = \Config::get('module_paths', []);
array_push($module_paths, __DIR__.'/modules/');
\Config::set('module_paths', $module_paths);


Autoloader::add_classes(array(
	// Classes
		'Propeller\Instagram'					 	=> __DIR__.'/classes/instagram.php',
		'Propeller\Instagram\Model_Subscription'	=> __DIR__.'/classes/model/subscription.php',

		'Propeller\Instagram\Subscription'		=> __DIR__.'/classes/subscription.php',

		'Instagram\Auth'				=> __DIR__.'/classes/Instagram/Auth.php',
		'Instagram\Comment'				=> __DIR__.'/classes/Instagram/Comment.php',
		'Instagram\CurrentUser'			=> __DIR__.'/classes/Instagram/CurrentUser.php',
		'Instagram\Helper'				=> __DIR__.'/classes/Instagram/Helper.php',
		'Instagram\Instagram'			=> __DIR__.'/classes/Instagram/Instagram.php',
		'Instagram\Location'			=> __DIR__.'/classes/Instagram/Location.php',
		'Instagram\Media'				=> __DIR__.'/classes/Instagram/Media.php',
		'Instagram\Tag'					=> __DIR__.'/classes/Instagram/Tag.php',
		'Instagram\User'				=> __DIR__.'/classes/Instagram/User.php',

		'Instagram\Collection\CollectionAbstract'	=> __DIR__.'/classes/Instagram/Collection/CollectionAbstract.php',
		'Instagram\Collection\CommentCollection'	=> __DIR__.'/classes/Instagram/Collection/CommentCollection.php',
		'Instagram\Collection\LikedMediaCollection'	=> __DIR__.'/classes/Instagram/Collection/LikedMediaCollection.php',
		'Instagram\Collection\LocationCollection'	=> __DIR__.'/classes/Instagram/Collection/LocationCollection.php',
		'Instagram\Collection\MediaCollection'		=> __DIR__.'/classes/Instagram/Collection/MediaCollection.php',
		'Instagram\Collection\MediaSearchCollection'=> __DIR__.'/classes/Instagram/Collection/MediaSearchCollection.php',
		'Instagram\Collection\TagCollection'		=> __DIR__.'/classes/Instagram/Collection/TagCollection.php',
		'Instagram\Collection\TagMediaCollection'	=> __DIR__.'/classes/Instagram/Collection/TagMediaCollection.php',
		'Instagram\Collection\UserCollection'		=> __DIR__.'/classes/Instagram/Collection/UserCollection.php',

		'Instagram\Core\ApiAuthException' 	=> __DIR__.'/classes/Instagram/Core/ApiAuthException.php',
		'Instagram\Core\ApiException' 		=> __DIR__.'/classes/Instagram/Core/ApiException.php',
		'Instagram\Core\BaseObjectAbstract' => __DIR__.'/classes/Instagram/Core/BaseObjectAbstract.php',
		'Instagram\Core\Proxy' 				=> __DIR__.'/classes/Instagram/Core/Proxy.php',

		'Instagram\Net\ApiResponse'			=> __DIR__.'/classes/Instagram/Net/ApiResponse.php',
		'Instagram\Net\ClientInterface'		=> __DIR__.'/classes/Instagram/Net/ClientInterface.php',
		'Instagram\Net\CurlClient'			=> __DIR__.'/classes/Instagram/Net/CurlClient.php',
));
