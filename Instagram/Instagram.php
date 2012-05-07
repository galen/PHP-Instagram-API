<?php

/**
* Instagram PHP
* @author Galen Grover <galenjr@gmail.com>
* @license http://opensource.org/licenses/mit-license.php The MIT License
*/

namespace Instagram;

/**
 * Instagram!
 *
 * All objects are created through this object
 *
 * Authorization is done through this object as well
 */

class Instagram {

	/**
	 * Configuration array
	 *
	 * Contains a default client and proxy
	 *
	 ** Authorization only config options:
	 *
	 * client_secret:
	 * client_id:		These three items are required for authorization
	 * redirect_url:
	 *
	 * access_token:	Instagram access token. This is the only required element for normal operation.
	 * client:			Class that performs all the HTTP actions. Must implement \Instagram\Net\ClientInterface
	 * proxy:			Uses the client to call the API methods
	 * grant_type:		Grant type from teh Instagram API. Only authorization_code is accepted right now.
	 * scope:			{@link http://instagram.com/developer/auth/#scope}
	 * display:			Pass in "touch" if you'd like your authenticating users to see a mobile-optimized
	 *					version of the authenticate page and the sign-in page. 
	 *
	 * @var array
	 * @access protected
	 */
	protected $config = array(
		'client'			=> 'Instagram\Net\CurlClient',
		'proxy'				=> 'Instagram\Core\Proxy',
		'grant_type'		=> 'authorization_code',
		'scope'				=> array( 'basic' ),
		'display'			=> ''
	);

	/**
	 * Proxy object
	 *
	 * The proxy object does all the fetching of the API data
	 *
	 * @var \Instagram\Core\Proxy
	 * @access protected
	 */
	protected $proxy;

	/**
	 * Constructor
	 *
	 * When authorizing you will need to supply a client_id, client_secret, and redirect_url
	 *
	 * After authenticating you only need to supply access_token
	 *
	 * @param array $config Configuration array
	 * @access public
	 */
	public function __construct( array $config ) {
		if (
			!isset( $config['client_id'], $config['client_secret'], $config['callback_url'] ) &&
			!isset( $config['access_token'] )
		)
		{
			throw new \Instagram\Core\ApiException( 'Invalid $config params: You must supply auth info or an access_token' );
		}
		$this->config = (array) $config + $this->config;
		$proxy = $this->config['proxy'];
		$this->setProxy( new $proxy( new $this->config['client'], isset( $this->config['access_token'] ) ? $this->config['access_token'] : null ) );
	}

	/**
	 * Authorize
	 *
	 * Redirects the user to the Instagram authorization url
	 * @access public
	 */
	public function authorize() {
		header(
			sprintf(
				'Location:https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=%s',
				$this->config['client_id'],
				$this->config['callback_url'],
				implode( '+', $this->config['scope'] )
			)
		);
		exit;
	}

	/**
	 * Get the access token
	 *
	 * POSTs to the Instagram API and obtains and access key
	 *
	 * @param string $code Code supplied by Instagram
	 * @return string Returns the access token
	 * @throws \Instagram\Core\ApiException
	 * @access public
	 */
	public function getAccessToken( $code ) {
		$post_data = array(
			'client_id'			=> $this->config['client_id'],
			'client_secret'		=> $this->config['client_secret'],
			'grant_type'		=> $this->config['grant_type'],
			'redirect_uri'		=> $this->config['callback_url'],
			'code'				=> $code
		);
		$response = $this->proxy->getAccessToken( $post_data );
		if ( isset( $response->getRawData()->access_token ) ) {
			return $response->getRawData()->access_token;
		}
		throw new \Instagram\Core\ApiException( $response->getErrorMessage(), $response->getErrorCode(), $response->getErrorType() );
	}

	function logout() {
		$this->proxy->logout();
	}

	/**
	 * Set the proxy
	 *
	 * @param \Instagram\Core\Proxy $proxy Proxy object
	 * @access public
	 */
	public function setProxy( \Instagram\Core\Proxy $proxy ) {
		$this->proxy = $proxy;
	}

 	/**
 	 * Get user
 	 *
 	 * Retrieve a user given his/her ID
 	 *
 	 * @param int $id ID of the user to retrieve
 	 * @return \Instagram\User
 	 * @access public
 	 */
	public function getUser( $id ) {
		$user = new \Instagram\User( $this->proxy->getUser( $id ) );
		$user->setProxy( $this->proxy );
		return $user;
	}

 	/**
 	 * Get user
 	 *
 	 * Retrieve a user given their username
 	 *
 	 * @param string $username Username of the user to retrieve
 	 * @return \Instagram\User
 	 * @access public
 	 * @throws \Instagram\ApiException
 	 */
	public function getUserByUsername( $username ) {
		$user = $this->searchUsers( $username, array( 'count' => 1 ) )->getItem( 1 );
		if ( $user ) {
			return $user;
		}
		throw new \Instagram\Core\ApiException( 'username not found', 400, 'InvalidUsername' );
	}

	/**
	 * Check if a user is private
	 *
	 * @return bool
	 * @access public
	 */
	public function isUserPrivate( $user_id ) {
		$relationship = $this->proxy->getRelationshipToCurrentUser( $user_id );
		return (bool)$relationship->target_user_is_private;
	}

 	/**
 	 * Get media
 	 *
 	 * Retreive a media object given it's ID
 	 *
 	 * @param int $id ID of the media to retrieve
 	 * @return \Instagram\Media
 	 * @access public
 	 */
	public function getMedia( $id ) {
		$media = new \Instagram\Media( $this->proxy->getMedia( $id ) );
		$media->setProxy( $this->proxy );
		return $media;
	}

 	/**
 	 * Get Tag
 	 *
 	 * @param string $tag Tag to retrieve
  	 * @return \Instagram\Tag
 	 * @access public
 	 */
	public function getTag( $tag ) {
		$tag = new \Instagram\Tag( $this->proxy->getTag( $tag ) );
		$tag->setProxy( $this->proxy );
		return $tag;
	}

 	/**
 	 * Get location
 	 *
 	 * Retreive a location given it's ID
 	 *
 	 * @param int $id ID of the location to retrieve
 	 * @return \Instagram\Location
 	 * @access public
 	 */
	public function getLocation( $id ) {
		$location = new \Instagram\Location( $this->proxy->getLocation( $id ) );
		$location->setProxy( $this->proxy );
		return $location;
	}

 	/**
 	 * Get current user
 	 *
 	 * Returns the current user wrapped in a CurrentUser object
 	 *
 	 * @return \Instagram\CurrentUser
 	 * @access public
 	 */
	public function getCurrentUser() {
		$current_user = new \Instagram\CurrentUser( $this->proxy->getCurrentUser() );
		$current_user->setProxy( $this->proxy );
		return $current_user;
	}

 	/**
 	 * Get popular media
 	 *
 	 * Returns current popular media
 	 *
 	 * @return \Instagram\Collection\MediaCollection
 	 * @access public
 	 */
	public function getPopularMedia() {
		$popular_media = new \Instagram\Collection\MediaCollection( $this->proxy->getPopularMedia() );
		$popular_media->setProxy( $this->proxy );
		return $popular_media;
	}

 	/**
 	 * Search users
 	 *
 	 * Search the users by username
 	 *
 	 * @param string $query Search query
	 * @param array $params Optional params to pass to the endpoint
 	 * @return \Instagram\Collection\UserCollection
 	 * @access public
 	 */
	public function searchUsers( $query, array $params = null ) {
		$params = (array)$params;
		$params['q'] = $query;
		$user_collection = new \Instagram\Collection\UserCollection( $this->proxy->searchUsers( $params ) );
		$user_collection->setProxy( $this->proxy );
		return $user_collection;
	}

 	/**
 	 * Search Media
 	 *
 	 * Returns media that is a certain distance from a given lat/lng
 	 *
 	 * To specify a distance, pass the distance (in meters) in the $params
 	 *
 	 * Default distance is 1000m
 	 *
 	 * @param float $lat Latitude of the search
 	 * @param float $lng Longitude of the search
	 * @param array $params Optional params to pass to the endpoint
 	 * @return \Instagram\Collection\MediaSearchCollection
 	 * @access public
 	 */
	public function searchMedia( $lat, $lng, array $params = null ) {
		$params = (array)$params;
		$params['lat'] = (float)$lat;
		$params['lng'] = (float)$lng;
		$media_collection =  new \Instagram\Collection\MediaSearchCollection( $this->proxy->searchMedia( $params ) );
		$media_collection->setProxy( $this->proxy );
		return $media_collection;
	}

 	/**
 	 * Search for tags
 	 *
 	 * @param string $query Search query
	 * @param array $params Optional params to pass to the endpoint
 	 * @return \Instagram\Collection\TagCollection
 	 * @access public
 	 */
	public function searchTags( $query, array $params = null ) {
		$params = (array)$params;
		$params['q'] = $query;
		$tag_collection =  new \Instagram\Collection\TagCollection( $this->proxy->searchTags( $params ) );
		$tag_collection->setProxy( $this->proxy );
		return $tag_collection;
	}

 	/**
 	 * Search Locations
 	 *
 	 * Returns locations that are a certain distance from a given lat/lng
 	 *
 	 * To specify a distance, pass the distance (in meters) in the $params
 	 *
 	 * Default distance is 1000m
 	 *
 	 * @param float $lat Latitude of the search
 	 * @param float $lng Longitude of the search
	 * @param array $params Optional params to pass to the endpoint
 	 * @return \Instagram\LocationCollection
 	 * @access public
 	 */
	public function searchLocations( $lat, $lng, array $params = null ) {
		$params = (array)$params;
		$params['lat'] = (float)$lat;
		$params['lng'] = (float)$lng;
		$location_collection = new \Instagram\Collection\LocationCollection( $this->proxy->searchLocations( $params ) );
		$location_collection->setProxy( $this->proxy );
		return $location_collection;
	}

}