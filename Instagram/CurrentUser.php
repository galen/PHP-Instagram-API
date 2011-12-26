<?php

namespace Instagram;

class CurrentUser extends \Instagram\User {

	protected $feed;
	protected $liked_media;

	public function getApiId() {
		return 'self';
	}

	public function getFeed( array $params = null ) {
		if ( $this->feed && !(bool)$force_fetch ) {
			return $this->feed;
		}
		return $this->proxy->getFeed( $params );
	}

	public function getLikedMedia( array $params = null ) {
		if ( $this->liked_media && !(bool)$force_fetch ) {
			return $this->liked_media;
		}
		return $this->proxy->getLikedMedia( $params );
	}

}