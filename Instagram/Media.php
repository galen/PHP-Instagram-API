<?php

namespace Instagram;

class Media extends \Instagram\Core\ProxyObjectAbstract {

	protected $comments;
	protected $likes;
	protected $location;
	protected $tags;

	public function getThumbnail() {
		return $this->data->images->thumbnail;
	}
	
	public function getStandardRes() {
		return $this->data->images->standard_resolution;
	}

	public function getLowRes() {
		return $this->data->images->low_resolution;
	}

	public function getCaption() {
		if ( $this->data->caption ) {
			return new \Instagram\Comment( $this->data->caption );
		}
		return null;
	}

	public function getCreatedTime( $format = null ) {
		if ( $format ) {
			$date = date( $format, $this->data->created_time );
		}
		else {
			$date = $this->data->created_time;
		}
		return $date;
	}

	public function getUser() {
		return new \Instagram\User( $this->data->user, $this->proxy );
	}

	public function getComments( $force_fetch = false ) {
		if ( $this->comments && !(bool)$force_fetch ) {
			return $this->comments;
		}
		$this->comments = $this->proxy->getMediaComments( $this->getApiId() );
		return $this->comments;
	}

	public function getFilter() {
		return $this->data->filter;
	}
	
	public function getTags() {
		$this->tags = new \Instagram\Collection\TagCollection( $this->data->tags );
		$this->tags->setProxy( $this->proxy );
		return $this->tags;
	}

	public function getLink() {
		return $this->data->link;
	}
	
	public function getLikesCount() {
		return (int)$this->data->likes->count;
	}
	
	public function getLikes( $force_fetch = false ) {
		if ( $this->likes && !(bool)$force_fetch ) {
			return $this->likes;
		}
		$user_collection = $this->proxy->getMediaLikes( $this->getApiId() );
		$user_collection->setProxy( $this->proxy );
		$this->likes = $user_collection;
		return $this->likes;
	}

	public function hasLocation() {
		return isset( $this->data->location );
	}

	public function hasNamedLocation() {
		return isset( $this->data->location->id );
	}

	public function getLocation( $force_fetch = false ) {
		if ( !$this->hasLocation() ) {
			return null;
		}
		if ( !$this->location || (bool)$force_fetch ) {
			$this->location = new \Instagram\Location( $this->data->location, isset( $this->data->location->id ) ? $this->proxy : null );
		}
		return $this->location;
	}

	public function __toString() {
		return $this->getThumbnail()->url;
	}

}