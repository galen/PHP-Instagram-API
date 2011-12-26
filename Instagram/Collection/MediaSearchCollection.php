<?php

namespace Instagram\Collection;

class MediaSearchCollection extends \Instagram\Collection\CollectionAbstract {

	protected $next_max_timestamp;

	public function __construct( $raw_data = null ) {
		if ( $raw_data ) {
			$this->setData( $raw_data );
			$this->convertData( '\Instagram\Media' );
			$this->next_max_timestamp = count( $this->data ) ? $this->data[ count( $this->data )-1 ]->getCreatedTime() : null;
		}
	}

	public function getNextMaxTimeStamp() {
		return $this->next_max_timestamp;
	}

}