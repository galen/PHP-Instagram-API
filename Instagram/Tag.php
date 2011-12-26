<?php

namespace Instagram;

class Tag extends \Instagram\Core\ProxyObjectAbstract {

	protected $media;

	public function getMedia( array $params = null, $force_fetch = false ) {
		if ( (bool)$force_fetch || !$this->media ) {
			$this->media = $this->proxy->getTagMedia( $this->getApiId(), $params );
		}
		return $this->media;
	}

	public function getMediaCount() {
		return (int)$this->data->media_count;
	}

	public function getName() {
		return $this->data->name;
	}

	public function getId() {
		return $this->getName();
	}

	public function __toString() {
		return $this->getName();
	}

}