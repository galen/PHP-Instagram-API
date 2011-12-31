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
	 * Holds relationship info for the current user
	 *
	 * @access protected
	 * @var array
	 */
	protected $relationships = array();

	/**
	 * Holds liked info for the current user
	 *
	 * Current user likes are stored in media objects
	 * If a media is liked after a media has been fetched the like will not be a part of the media object
	 *
	 * @access protected
	 * @var array
	 */
	protected $liked = array();

	/**
	 * Holds unliked info for the current user
	 *
	 * @access protected
	 * @var array
	 */
	protected $unliked = array();

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
	 * Does the current use like a media
	 *
	 * @param \Instagram\Media $media Media to query for a like from the current user
	 * @access public
	 */
	public function likes( \Instagram\Media $media ) {
		return isset( $this->liked[$media->getId()] ) || ( isset( $media->getData()->user_has_liked ) && (bool)$media->getData()->user_has_liked === true && !isset( $this->unliked[$media->getId()] ) );
	}

	/**
	 * Add like from current user
	 *
	 * @param \Instagram\Media $media Media to add a like to from the current user
	 * @access public
	 */
	public function addLike( \Instagram\Media $media ) {
		$this->proxy->like( $media );
		unset( $this->unliked[$media->getId()] );
		$this->liked[$media->getId()] = true;
	}

	/**
	 * Delete like from current user
	 *
	 * @param \Instagram\Media $media Media to delete a like to from the current user
	 * @access public
	 */
	public function deleteLike( \Instagram\Media $media ) {
		$this->proxy->unLike( $media );
		unset( $this->liked[$media->getId()] );
		$this->unliked[$media->getId()] = true;
	}

	/**
	 * Update relationship with a user
	 *
	 * Internal function that updates relationships
	 *
	 * @see \Instagram\CurrentUser::follow
	 * @see \Instagram\CurrentUser::unFollow
	 * @see \Instagram\CurrentUser::getRelationship
	 *
	 * @param \Instagram\User $user User whose relationship you'd like to update
	 * @access protected
	 */
	protected function updateRelationship( \Instagram\User $user ) {
		if ( !isset( $this->relationships[ $user->getId() ] ) ) {
			$this->relationships[ $user->getId() ] = $this->proxy->getRelationshipToCurrentUser( $user );
		}
	}

	/**
	 * Follow user
	 *
	 * @param \Instagram\User $user User who should be followed
	 * @return boolean
	 */
	public function follow( \Instagram\User $user ) {
		$this->updateRelationship( $user );
		$response = $this->proxy->modifyRelationship( $user, 'follow' );
		foreach( $response as $r => $v ) {
			$this->relationships[ $user->getId() ]->$r = $v;
		}
		return true;
	}

	/**
	 * Unfollow user
	 *
	 * @param \Instagram\User $user User who should be unfollowed
	 * @return boolean
	 */
	public function unFollow( \Instagram\User $user ) {
		$this->updateRelationship( $user ); 
		$response = $this->proxy->modifyRelationship( $user, 'unfollow' );
		foreach( $response as $r => $v ) {
			$this->relationships[ $user->getId() ]->$r = $v;
		}
		return true;
	}

	/**
	 * Get relationship
	 *
	 * Get the complete relationship to a user
	 *
	 * @param \Instagram\User $user User to get the relationship details of
	 * @return StdClass
	 */
	public function getRelationship( \Instagram\User $user ) {
		$this->updateRelationship( $user );
		return $this->relationships[ $user->getId() ];
	}

	/**
	 * Check following status
	 *
	 * Check if hte current user is following a user
	 *
	 * @param \Instagram\User $user User to check the following status of
	 * @return boolean
	 */
	public function isFollowing( \Instagram\User $user ) {
		return $this->getRelationship( $user )->outgoing_status == 'follows';
	}

	/**
	 * Check following status
	 *
	 * Check if hte current user is followed by
	 *
	 * @param \Instagram\User $user User to check the followed by status of
	 * @return boolean
	 */
	public function isFollowedBy( \Instagram\User $user ) {
		return $this->getRelationship( $user )->incoming_status == 'followed_by';
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