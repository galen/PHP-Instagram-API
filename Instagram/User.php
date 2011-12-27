<?php

namespace Instagram;

class User extends \Instagram\Core\ProxyObjectAbstract {

	protected $media;
	protected $follows;
	protected $followed_by;


	public function getUserName() {
		return $this->data->username;
	}

	public function getFullName() {
		return isset( $this->data->full_name ) ? $this->data->full_name : null;
	}

	public function getProfilePicture() {
		return $this->data->profile_picture;
	}

	public function getBio() {
		return $this->data->bio;
	}

	public function getWebsite() {
		return $this->data->website;
	}

	public function getCounts() {
		return $this->data->counts;
	}

	public function getFollowsCount() {
		return (int)$this->data->counts->follows;
	}

	public function getFollowedByCount() {
		return (int)$this->data->counts->followed_by;
	}

	public function getMediaCount() {
		return (int)$this->data->counts->media;
	}

	public function getMedia( array $params = null, $force_fetch = null ) {
		if ( $this->media && !(bool)$force_fetch ) {
			return $this->media;
		}
		$this->media = $this->proxy->getUserMedia( $this->getApiId(), $params );
		return $this->media;
	}

	public function getFollows( array $params = null, $force_fetch = null ) {
		if ( $this->follows && !(bool)$force_fetch ) {
			return $this->follows;
		}
		$this->follows = $this->proxy->getUserFollows( $this->getApiId(), $params );
		return $this->follows;
	}

	public function getFollowedBy( array $params = null, $force_fetch = null ) {
		if ( $this->followed_by && !(bool)$force_fetch ) {
			return $this->followed_by;
		}
		$this->followed_by = $this->proxy->getUserFollowedBy( $this->getApiId(), $params );
		return $this->followed_by;
	}

	public function __toString() {
		return $this->getUserName();
	}

}