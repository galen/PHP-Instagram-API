<?php

namespace Instagram\Collection;

class LikedMediaCollection extends \Instagram\Collection\MediaCollection {

	public function getNextMaxLikeId() {
		return isset( $this->pagination->next_max_like_id ) ? $this->pagination->next_max_like_id : null;
	}

	public function getNext() {
		return $this->getNextMaxLikeId();
	}

}