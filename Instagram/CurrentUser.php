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
	 * @param \Instagram\Media|string $media Media to add a like to from the current user
	 * @access public
	 */
	public function addLike( $media ) {
		if ( $media instanceof \Instagram\Media ) {
			$media = $media->getId();
		}
		$this->proxy->like( $media );
		unset( $this->unliked[$media] );
		$this->liked[$media] = true;
	}

	/**
	 * Delete like from current user
	 *
	 * @param \Instagram\Media|string $media Media to delete a like to from the current user
	 * @access public
	 */
	public function deleteLike( $media ) {
		if ( $media instanceof \Instagram\Media ) {
			$media = $media->getId();
		}
		$this->proxy->unLike( $media );
		unset( $this->liked[$media] );
		$this->unliked[$media] = true;
	}

	/**
	 * Add a comment
	 *
	 * @param \Instagram\Media|string Media to add a comment to
	 * @param string $text Comment text
	 * @access public
	 */
	public function addMediaComment( $media, $text ) {
		if ( $media instanceof \Instagram\Media ) {
			$media = $media->getId();
		}
		$this->proxy->addMediaComment( $media, $text );
	}

	/**
	 * Delete a comment
	 *
	 * @param \Instagram\Media|string Media to delete a comment from
	 * @param string $text Comment text
	 * @access public
	 */
	public function deleteMediaComment( $media, $comment ) {
		if ( $media instanceof \Instagram\Media ) {
			$media = $media->getId();
		}
		if ( $comment instanceof \Instagram\Comment ) {
			$comment = $comment->getId();
		}
		$this->proxy->deleteMediaComment( $media, $comment );
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
	 * @param \Instagram\User|string User object or user id whose relationship you'd like to update
	 * @access protected
	 */
	protected function updateRelationship( $user ) {
		if ( $user instanceof \Instagram\User ) {
			$user = $user->getId();
		}
		if ( !isset( $this->relationships[ $user ] ) ) {
			$this->relationships[ $user ] = $this->proxy->getRelationshipToCurrentUser( $user );
		}
	}

	/**
	 * Follow user
	 *
	 * @param \Instagram\User|string User object or user id who should be followed
	 * @return boolean
	 */
	public function follow( $user ) {
		if ( $user instanceof \Instagram\User ) {
			$user = $user->getId();
		}
		$this->updateRelationship( $user );
		$response = $this->proxy->modifyRelationship( $user, 'follow' );
		foreach( $response as $r => $v ) {
			$this->relationships[ $user ]->$r = $v;
		}
		return true;
	}

	/**
	 * Approve follower
	 *
	 * @param \Instagram\User|string $user User object or user id who should be approved for following
	 * @return boolean
	 */
	public function approveFollowRequest( $user ) {
		if ( $user instanceof \Instagram\User ) {
			$user = $user->getId();
		}
		$this->updateRelationship( $user ); 
		$response = $this->proxy->modifyRelationship( $user, 'approve' );
		foreach( $response as $r => $v ) {
			$this->relationships[ $user ]->$r = $v;
		}
		return true;
	}

	/**
	 * Ignore follower
	 *
	 * @param \Instagram\User|string $user User object or user id who should be ignored
	 * @return boolean
	 */
	public function ignoreFollowRequest( $user ) {
		if ( $user instanceof \Instagram\User ) {
			$user = $user->getId();
		}
		$this->updateRelationship( $user ); 
		$response = $this->proxy->modifyRelationship( $user, 'ignore' );
		foreach( $response as $r => $v ) {
			$this->relationships[ $user ]->$r = $v;
		}
		return true;
	}

	/**
	 * Deprecated unfollow()
	 *
	 * Renamed to keep standard naming convention.
	 */
	public function unFollow( $user ) {
		$this->unfollow();
	}

	/**
	 * Unfollow user
	 *
	 * @param \Instagram\User|string $user User object or user id who should be unfollowed
	 * @return boolean
	 */
	public function unfollow( $user ) {
		if ( $user instanceof \Instagram\User ) {
			$user = $user->getId();
		}
		$this->updateRelationship( $user ); 
		$response = $this->proxy->modifyRelationship( $user, 'unfollow' );
		foreach( $response as $r => $v ) {
			$this->relationships[ $user ]->$r = $v;
		}
		return true;
	}

	/**
	 * Block user
	 *
	 * @param \Instagram\User|string $user User object or user id who should be blocked
	 * @return boolean
	 */
	public function block( $user ) {
		if ( $user instanceof \Instagram\User ) {
			$user = $user->getId();
		}
		$this->updateRelationship( $user ); 
		$response = $this->proxy->modifyRelationship( $user, 'block' );
		foreach( $response as $r => $v ) {
			$this->relationships[ $user ]->$r = $v;
		}
		return true;
	}

	/**
	 * Unblock user
	 *
	 * @param \Instagram\User|string $user User object or user id who should be unblocked
	 * @return boolean
	 */
	public function unblock( $user ) {
		if ( $user instanceof \Instagram\User ) {
			$user = $user->getId();
		}
		$this->updateRelationship( $user ); 
		$response = $this->proxy->modifyRelationship( $user, 'unblock' );
		foreach( $response as $r => $v ) {
			$this->relationships[ $user ]->$r = $v;
		}
		return true;
	}

	/**
	 * Get relationship
	 *
	 * Get the complete relationship to a user
	 *
	 * @param \Instagram\User|string $user User object or user id to get the relationship details of
	 * @return StdClass
	 */
	public function getRelationship( $user ) {
		if ( $user instanceof \Instagram\User ) {
			$user = $user->getId();
		}
		$this->updateRelationship( $user );
		return $this->relationships[ $user ];
	}

	/**
	 * Get follow request
	 *
	 * Get the users that have requested to follow the current user
	 *
	 * @return \Instagram\Collection\UserCollection
	 */
	public function getFollowRequests() {
		return new \Instagram\Collection\UserCollection( $this->proxy->getFollowRequests(), $this->proxy );
	}

	/**
	 * Check following status
	 *
	 * Check if hte current user is following a user
	 *
	 * @param \Instagram\User|string $user User object or user id to check the following status of
	 * @return boolean
	 */
	public function isBlocking( $user ) {
		if ( $user instanceof \Instagram\User ) {
			$user = $user->getId();
		}
		return $this->getRelationship( $user )->incoming_status == 'blocked_by_you';
	}

	/**
	 * Check following status
	 *
	 * Check if hte current user is following a user
	 *
	 * @param \Instagram\User|string $user User object or user id to check the following status of
	 * @return boolean
	 */
	public function isFollowing( $user ) {
		if ( $user instanceof \Instagram\User ) {
			$user = $user->getId();
		}
		return $this->getRelationship( $user )->outgoing_status == 'follows';
	}

	/**
	 * Check followed by status
	 *
	 * Check if the current user is followed by a user
	 *
	 * @param \Instagram\User|string $user User object or user id to check the followed by status of
	 * @return boolean
	 */
	public function isFollowedBy( $user ) {
		if ( $user instanceof \Instagram\User ) {
			$user = $user->getId();
		}
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
		return new \Instagram\Collection\MediaCollection( $this->proxy->getFeed( $params ), $this->proxy );
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
		return new \Instagram\Collection\LikedMediaCollection( $this->proxy->getLikedMedia( $params ), $this->proxy );
	}

}