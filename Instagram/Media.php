<?php

/**
* Instagram PHP
* @author Galen Grover <galenjr@gmail.com>
* @license http://opensource.org/licenses/mit-license.php The MIT License
*/

namespace Instagram;

/**
 * Media class
 */
class Media extends \Instagram\Core\ProxyObjectAbstract {

	/**
	 * Comments cache
	 *
	 * @var \Instagram\Collection\CommentCollection
	 */
	protected $comments;

	/**
	 * Location
	 *
	 * @var \Instagram\Location
	 */
	protected $location;

	/**
	 * Tags
	 *
	 * @var \Instagram\Collection\TagCollection
	 */
	protected $tags;

	/**
	 * Get the thumbnail
	 *
	 * @return string
	 * @access public
	 */
	public function getThumbnail() {
		return $this->data->images->thumbnail;
	}

	/**
	 * Get the standard resolution image
	 *
	 * @return string
	 * @access public
	 */
	public function getStandardRes() {
		return $this->data->images->standard_resolution;
	}

	/**
	 * Get the low resolution image
	 *
	 * @return string
	 * @access public
	 */
	public function getLowRes() {
		return $this->data->images->low_resolution;
	}

	/**
	 * Get the media caption
	 *
	 * @return string
	 * @access public
	 */
	public function getCaption() {
		if ( $this->data->caption ) {
			return new \Instagram\Comment( $this->data->caption );
		}
		return null;
	}

	/**
	 * Get the created time
	 *
	 * @param string $format {@link http://php.net/manual/en/function.date.php}
	 * @return string
	 * @access public
	 */
	public function getCreatedTime( $format = null ) {
		if ( $format ) {
			$date = date( $format, $this->data->created_time );
		}
		else {
			$date = $this->data->created_time;
		}
		return $date;
	}

	/**
	 * Get the user that posted the media
	 *
	 * @return \Instagram\User
	 * @access public
	 */
	public function getUser() {
		return new \Instagram\User( $this->data->user, $this->proxy );
	}

	/**
	 * Get all comments
	 *
	 * The media object will already contain the first 10 comments attached to it whcih can be obtained
	 * with getComments(). This will return all of them.
	 *
	 * @param bool $force_fetch Don't use the cache
	 * @return \Instagram\CommentCollection
	 * @access public
	 */
	public function fetchComments( $force_fetch = false ) {
		if ( $this->comments && !(bool)$force_fetch ) {
			return $this->comments;
		}
		$this->comments = $this->proxy->getMediaComments( $this->getApiId() );
		return $this->comments;
	}

	/**
	 * Get first 10 comments that were returned with the media
	 *
	 * @return \Instagram\CommentCollection
	 * @access public
	 */
	public function getComments() {
		return $this->proxy->getMediaComments( $this->getApiId() );
	}

	/**
	 * Get the media filter
	 *
	 * @return string
	 * @access public
	 */
	public function getFilter() {
		return $this->data->filter;
	}

	/**
	 * Get the media's tags
	 *
	 * @return \Instagram\Collection\TagCollection
	 * @access public
	 */
	public function getTags() {
		if ( $this->tags ) {
			return $this->tags;
		}
		$this->tags = new \Instagram\Collection\TagCollection( $this->data->tags );
		$this->tags->setProxy( $this->proxy );
		return $this->tags;
	}

	/**
	 * Get the media's link
	 *
	 * @return string
	 * @access public
	 */
	public function getLink() {
		return $this->data->link;
	}

	/**
	 * Get the media's likes count
	 *
	 * @return int
	 * @access public
	 */
	public function getLikesCount() {
		return (int)$this->data->likes->count;
	}

	/**
	 * Fetch likes from the API
	 *
	 * @param bool $force_fetch Don't use the cache
	 * @return \Instagram\UserCollection
	 * @access public
	 */
	public function fetchLikes( $force_fetch = false ) {
		if ( $this->likes && !(bool)$force_fetch ) {
			return $this->likes;
		}
		$user_collection = $this->proxy->getMediaLikes( $this->getApiId() );
		$user_collection->setProxy( $this->proxy );
		$this->likes = $user_collection;
		return $this->likes;
	}

	/**
	 * Get first 10 likes that were returned with the media
	 *
	 * @param bool $force_fetch Don't use the cache
	 * @return \Instagram\CommentCollection
	 * @access public
	 */
	public function getLikes() {
		return new \Instagram\Collection\UserCollection( $this->data->likes );
	}

	/**
	 * Get location status
	 *
	 * Will return true if any location data is associated with the media
	 *
	 * @return bool
	 * @access public
	 */
	public function hasLocation() {
		return isset( $this->data->location );
	}

	/**
	 * Get location status
	 *
	 * Will return true if the media has a named location attached to it
	 *
	 * Some media only has lat/lng data
	 *
	 * @return bool
	 * @access public
	 */
	public function hasNamedLocation() {
		return isset( $this->data->location->id );
	}

	/**
	 * Get the location
	 *
	 * Returns the location associated with the media or null if no location data is available
	 *
	 * @param bool $force_fetch Don't use the cache
	 * @return \Instagram\Location|null
	 * @access public
	 */
	public function getLocation( $force_fetch = false ) {
		if ( !$this->hasLocation() ) {
			return null;
		}
		if ( !$this->location || (bool)$force_fetch ) {
			$this->location = new \Instagram\Location( $this->data->location, isset( $this->data->location->id ) ? $this->proxy : null );
		}
		return $this->location;
	}

	/**
	 * Magic toString method
	 *
	 * Returns the media's thumbnail url
	 *
	 * @return string
	 * @access public
	 */
	public function __toString() {
		return $this->getThumbnail()->url;
	}

}