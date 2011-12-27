<?php

namespace Instagram\Collection;

class MediaSearchCollection extends \Instagram\Collection\CollectionAbstract {

	protected $next_max_timestamp;

	public function setData( $raw_data ) {
		$this->data = $raw_data->data;
		$this->convertData( '\Instagram\Media' );
		$this->next_max_timestamp = count( $this->data ) ? $this->data[ count( $this->data )-1 ]->getCreatedTime() : null;
	}

	public function getNextMaxTimeStamp() {
		return $this->next_max_timestamp;
	}

	public function getNext() {
		return $this->getNextMaxTimeStamp();
	}

}