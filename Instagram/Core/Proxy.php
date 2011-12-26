<?php

namespace Instagram\Core;

class Proxy {

	protected $client;
	protected $access_token;

	protected $api_url = 'https://api.instagram.com/v1';

	function __construct( $access_token, \Instagram\Net\ClientInterface $client ) {
		$this->access_token = $access_token;
		$this->client = $client;
	}

	private function getObjectMedia( $api_endpoint, $id, array $params = null ) {
		$response = $this->apiCall(
			'get',
			sprintf( '%s/%s/%s/media/recent', $this->api_url, strtolower( $api_endpoint ), $id  ),
			$params
		);
		return new \Instagram\Collection\MediaCollection( $response->getRawData() );
	}

	public function getAllObjectMedia( $api_endpoint, $id, array $params = null ) {
		$media_all = new \Instagram\Collection\MediaCollection;
		do {
			$get_media = $this->getObjectMedia( $api_endpoint, $id, isset( $get_media ) ? (array)$params + array( 'max_id' => $get_media->getNextMaxId() ) : null );
			$media_all->addData( $get_media );
		}while( $get_media->getNextMaxId() );
		return $media_all;
	}

	public function getLocationMedia( $id, array $params = null ) {
		return $this->getObjectMedia( 'Locations', $id, $params );
	}

	public function getTagMedia( $id, array $params = null ) {
		return $this->getObjectMedia( 'Tags', $id, $params );
	}

	public function getUserMedia( $id, array $params = null ) {
		return $this->getObjectMedia( 'Users', $id, $params );
	}

	public function getAllUserMedia( $id, array $params = null ) {
		return $this->getAllObjectMedia( 'Users', $id, $params );
	}

	public function getUser( $id ) {
		$response = $this->apiCall(
			'get',
			sprintf( '%s/users/%s', $this->api_url, $id )
		);
		return new \Instagram\User( $response->getData() );
	}

	public function getUserFollows( $id, array $params = null ) {
		$response = $this->apiCall(
			'get',
			sprintf( '%s/users/%s/follows', $this->api_url, $id ),
			$params
		);
		return new \Instagram\Collection\UserCollection( $response->getRawData() );
	}

	public function getAllUserFollows( $id ) {
		$follows = new \Instagram\Collection\UserCollection;
		do {
			$get_follows = $this->getUserFollows( $id, isset( $get_follows ) ? array( 'cursor' => $get_follows->getNextCursor() ) : null );
			$follows->addData( $get_follows );
		}while( $get_follows->getNextCursor() );
		return $follows;
	}

	public function getUserFollowedBy( $id, array $params = null ) {
		$response = $this->apiCall(
			'get',
			sprintf( '%s/users/%s/followed-by', $this->api_url, $id ),
			$params
		);
		return new \Instagram\Collection\UserCollection( $response->getRawData() );
	}

	public function getAllUserFollowedBy( $id ) {
		$followed_by = new \Instagram\Collection\UserCollection;
		do {
			$get_followed_by = $this->getUserFollowedBy( $id, isset( $get_followed_by ) ? array( 'cursor' => $get_followed_by->getNextCursor() ) : null );
			$followed_by->addData( $get_followed_by );
		}while( $get_followed_by->getNextCursor() );
		return $followed_by;
	}

	public function getMediaComments( $id ) {
		$response = $this->apiCall(
			'get',
			sprintf( '%s/media/%s/comments', $this->api_url, $id )
		);
		return new \Instagram\Collection\CommentCollection( $response->getRawData() );
	}

	public function getMediaLikes( $id ) {
		$response = $this->apiCall(
			'get',
			sprintf( '%s/media/%s/likes', $this->api_url, $id )
		);
		return new \Instagram\Collection\UserCollection( $response->getRawData() );
	}

	public function getCurrentUser() {
		$response = $this->apiCall(
			'get',
			sprintf( '%s/users/self', $this->api_url )
		);
		return new \Instagram\CurrentUser( $response->getData() );
	}

	public function getMedia( $id ) {
		$response = $this->apiCall(
			'get',
			sprintf( '%s/media/%s', $this->api_url, $id )
		);
		return new \Instagram\Media( $response->getData() );
	}

	public function getTag( $tag ) {
		$response = $this->apiCall(
			'get',
			sprintf( '%s/tags/%s', $this->api_url, $tag )
		);
		return new \Instagram\Tag( $response->getData() );
	}

	public function getLocation( $id ) {
		$response = $this->apiCall(
			'get',
			sprintf( '%s/locations/%s', $this->api_url, $id )
		);
		return new \Instagram\Location( $response->getData() );
	}

	public function searchUsers( array $params = null ) {
		$response = $this->apiCall(
			'get',
			$this->api_url . '/users/search',
			$params
		);
		return new \Instagram\Collection\UserCollection( $response->getRawData() );
	}

	public function searchTags( array $params = null ) {
		$response = $this->apiCall(
			'get',
			$this->api_url . '/tags/search',
			$params
		);
		return new \Instagram\Collection\TagCollection( $response->getRawData() );
	}

	public function searchMedia( array $params = null ) {
		$response = $this->apiCall(
			'get',
			$this->api_url . '/media/search',
			$params
		);
		return new \Instagram\Collection\MediaSearchCollection( $response->getRawData() );
	}

	public function searchLocations( array $params = null ) {
		$response = $this->apiCall(
			'get',
			$this->api_url . '/locations/search',
			$params
		);
		return new \Instagram\Collection\LocationCollection( $response->getRawData() );
	}

	public function getPopularMedia( array $params = null ) {
		$response = $this->apiCall(
			'get',
			$this->api_url . '/media/popular',
			$params
		);
		return new \Instagram\Collection\MediaCollection( $response->getRawData() );
	}

	public function getFeed( array $params = null ) {
		$response = $this->apiCall(
			'get',
			$this->api_url . '/users/self/feed',
			$params
		);
		return new \Instagram\Collection\MediaCollection( $response->getRawData() );
	}

	public function getLikedMedia( array $params = null ) {
		$response = $this->apiCall(
			'get',
			$this->api_url . '/users/self/media/liked',
			$params
		);
		return new \Instagram\Collection\MediaCollection( $response->getRawData() );
	}

	private function apiCall( $method, $url, array $params = null, $throw_exception = true ){

		$response = $this->client->$method(
			$url,
			array(
				'access_token'	=> $this->access_token
			) + (array) $params
		);

		if ( !$response->isValid() ) {
			if ( $throw_exception ) {
				if ( $response->getErrorType() == 'OAuthAccessTokenException' ) {
					throw new \Instagram\Core\ApiAuthException( $response->getErrorMessage(), $response->getErrorCode(), $response->getErrorType() );
				}
				else {
					throw new \Instagram\Core\ApiException( $response->getErrorMessage(), $response->getErrorCode(), $response->getErrorType() );
				}
			}
			else {
				return false;
			}
		}
		return $response;
	
	}


}