<?php

/**
* Instagram PHP
* @author Galen Grover <galenjr@gmail.com>
* @license http://opensource.org/licenses/mit-license.php The MIT License
*/

namespace Instagram;

/**
 * Current User
 *
 * Holds the currently logged in user
 */
class CurrentUser extends \Instagram\User {

	/**
	 * Current user's feed
	 *
	 * @var MediaCollection
	 */
	protected $feed;

	/**
	 * Current user's liked media
	 *
	 * @var MediaCollection
	 */
	protected $liked_media;

	/**
	 * Get the API ID
	 *
	 * @return string Returns "self"
	 * @access public
	 */
	public function getApiId() {
		return 'self';
	}

	/**
	 * Get the current user's feed
	 *
	 * @param array $params Optional params to pass to the endpoint
	 * @return \Instagram\Collection\MediaCollection
	 * @access public
	 */
	public function getFeed( array $params = null ) {
		if ( $this->feed && !(bool)$force_fetch ) {
			return $this->feed;
		}
		return $this->proxy->getFeed( $params );
	}

	/**
	 * Get the current user's liked media
	 *
	 * @param array $params Optional params to pass to the endpoint
	 * @return \Instagram\Collection\MediaCollection
	 * @access public
	 */
	public function getLikedMedia( array $params = null ) {
		if ( $this->liked_media && !(bool)$force_fetch ) {
			return $this->liked_media;
		}
		return $this->proxy->getLikedMedia( $params );
	}

}