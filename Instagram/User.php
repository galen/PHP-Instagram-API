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
		$this->checkFull();
		return isset( $this->data->counts ) ? $this->data->counts : null;
	}

	public function getFollowsCount() {
		return (int)$this->getCounts()->follows;
	}

	public function getFollowedByCount() {
		return (int)$this->getCounts()->followed_by;
	}

	public function getMediaCount() {
		return (int)$this->getCounts()->media;
	}

	public function checkFull() {
		if ( !isset( $this->data->counts ) ) {
			$this->setData( $this->proxy->getUser( $this->getApiId() )->getData() );
		}
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