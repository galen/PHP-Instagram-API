<?php

namespace Instagram;

class Location extends \Instagram\Core\ProxyObjectAbstract {

	protected $media;

	public function getMedia( array $params = null, $force_fetch = false ) {
		if ( (bool)$force_fetch || !$this->media ) {
			$this->media = $this->proxy->getLocationMedia( $this->getApiId(), $params );
		}
		return $this->media;
	}

	public function getName() {
		return isset( $this->data->name ) ? $this->data->name : null;
	}

	public function __toString() {
		return $this->getName() ? $this->getName() : '';
	}

	public function getId() {
		return isset( $this->data->id ) ? $this->data->id : null;
	}

	public function getLat() {
		return is_float( $this->data->latitude ) ? $this->data->latitude : null;
	}

	public function getLng() {
		return is_float( $this->data->longitude ) ? $this->data->longitude : null;
	}

}