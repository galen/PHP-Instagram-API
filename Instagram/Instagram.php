<?php

namespace Instagram;

class Instagram {

	protected $config = array(
		'client'			=> 'Instagram\Net\CurlClient',
		'proxy'				=> 'Instagram\Core\Proxy'
	);

	protected $client;
	protected $proxy;

	public function __construct( array $config ) {
		if ( !isset( $config['access_token'] ) || empty($config['access_token'] ) ) {
			throw new \Instagram\Core\ApiException( 'You must supply an access token' );
		}
		$this->config = (array) $config + $this->config;
		$proxy = $this->config['proxy'];
		$this->setProxy( new $proxy( $this->config['access_token'], new $this->config['client'] ) );
	}

	public static function getApiUrl() {
		return self::API_URL;
	}

	public function setProxy( \Instagram\Core\Proxy $proxy ) {
		$this->proxy = $proxy;
	}

	public function getUser( $id ) {
		$user = $this->proxy->getUser( $id );
		$user->setProxy( $this->proxy );
		return $user;
	}

	public function getMedia( $id ) {
		$media = $this->proxy->getMedia( $id );
		$media->setProxy( $this->proxy );
		return $media;
	}

	public function getTag( $tag ) {
		$tag = $this->proxy->getTag( $tag );
		$tag->setProxy( $this->proxy );
		return $tag;
	}

	public function getLocation( $id ) {
		$location = $this->proxy->getLocation( $id );
		$location->setProxy( $this->proxy );
		return $location;
	}

	public function getCurrentUser() {
		$current_user = $this->proxy->getCurrentUser();
		$current_user->setProxy( $this->proxy );
		return $current_user;
	}

	public function getPopularMedia() {
		$popular_media = $this->proxy->getPopularMedia();
		$popular_media->setProxy( $this->proxy );
		return $popular_media;
	}

	public function searchUsersByName( $query, array $params = null ) {
		$params = (array)$params;
		$params['q'] = $query;
		$user_collection = $this->proxy->searchUsers( $params );
		$user_collection->setProxy( $this->proxy );
		return $user_collection;
	}

	public function searchMedia( $lat, $lng, array $params = null ) {
		$params = (array)$params;
		$params['lat'] = (float)$lat;
		$params['lng'] = (float)$lng;
		$media_collection = $this->proxy->searchMedia( $params );
		$media_collection->setProxy( $this->proxy );
		return $media_collection;
	}

	public function searchTags( $query, array $params = null ) {
		$params = (array)$params;
		$params['q'] = $query;
		$tag_collection = $this->proxy->searchTags( $params );
		$tag_collection->setProxy( $this->proxy );
		return $tag_collection;
	}

	public function searchLocations( $lat, $lng, array $params = null ) {
		$params = (array)$params;
		$params['lat'] = (float)$lat;
		$params['lng'] = (float)$lng;
		$location_collection = $this->proxy->searchLocations( $params );
		$location_collection->setProxy( $this->proxy );
		return $location_collection;
	}

}