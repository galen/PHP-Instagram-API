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
class Media extends \Instagram\Core\BaseObjectAbstract {

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
	 * Get media comments
	 *
	 * Media objects contain the first 10 comments. You can get these comments by passing `false`
	 * to this method. Using the internal comments of a media object cause issues when adding/deleting comments on media.
	 *
	 * @param bool $fetch_from_api Query the API or use internal
	 * @return \Instagram\CommentCollection
	 * @access public
	 */
	public function getComments( $fetch_from_api = true ) {
		if ( !$fetch_from_api ) {
			return $this->proxy->getMediaComments( $this->getApiId() );
		}
		$this->comments = new \Instagram\Collection\CommentCollection( $this->proxy->getMediaComments( $this->getApiId() ), $this->proxy );
		return $this->comments;
	}

	/**
	 * Add a comment
	 *
	 * @param int|\Instagram\Media ID of media or a media object
	 * @param string $text Comment text
	 * @access public
	 */
	public function addComment( $media, $text ) {
		if ( $media instanceof \Instagram\Media ) {
			$media = $media->getId();
		}
		$this->proxy->addMediaComment( $media, $text );
	}

	/**
	 * Delete a comment
	 *
	 * @param int|\Instagram\Media ID of media or a media object
	 * @param string $text Comment text
	 * @access public
	 */
	public function deleteComment( $media, $comment ) {
		if ( $media instanceof \Instagram\Media ) {
			$media = $media->getId();
		}
		if ( $comment instanceof \Instagram\Comment ) {
			$comment = $comment->getId();
		}
		$this->proxy->deleteMediaComment( $media, $comment );
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
		$this->tags = new \Instagram\Collection\TagCollection( $this->data->tags, $this->proxy );
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
	 * Get media likes
	 *
	 * Media objects contain the first 10 likes. You can get these likes by passing `false`
	 * to this method. Using the internal likes of a media object cause issues when liking/disliking media.
	 *
	 * @param bool $fetch_from_api Query the API or use internal
	 * @return \Instagram\UserCollection
	 * @access public
	 */
	public function getLikes( $fetch_from_api = true ) {
		if ( !$fetch_from_api ) {
			return new \Instagram\Collection\UserCollection( $this->data->likes );
		}
		$user_collection = new \Instagram\Collection\UserCollection( $this->proxy->getMediaLikes( $this->getApiId() ), $this->proxy );
		$user_collection->setProxy( $this->proxy );
		$this->likes = $user_collection;
		return $this->likes;
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