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
 *
 * @see \Instagram\Instagram->getCurrentUser()
 */
class CurrentUser extends \Instagram\User {

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
 	 * This can be paginated with the next_max_id param obtained from MediaCollection->getNext()
	 *
	 * @param array $params Optional params to pass to the endpoint
	 * @return \Instagram\Collection\MediaCollection
	 * @access public
	 */
	public function getFeed( array $params = null ) {
		return $this->proxy->getFeed( $params );
	}

	/**
	 * Get the current user's liked media
	 *
 	 * This can be paginated with the next_max_like_id param obtained from MediaCollection->getNext()
	 *
	 * @param array $params Optional params to pass to the endpoint
	 * @return \Instagram\Collection\MediaCollection
	 * @access public
	 */
	public function getLikedMedia( array $params = null ) {
		return $this->proxy->getLikedMedia( $params );
	}

}