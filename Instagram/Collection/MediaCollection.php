<?php

namespace Instagram\Collection;

class MediaCollection extends \Instagram\Collection\CollectionAbstract {

	protected $pagination;

	public function __construct( $raw_data = null ) {
		if ( $raw_data ) {
			$this->setData( $raw_data );
			$this->pagination = isset( $raw_data->pagination ) ? $raw_data->pagination : null;
			$this->convertData( '\Instagram\Media' );
		}
	}

	public function getNextMaxId() {
		return isset( $this->pagination->next_max_id ) ? $this->pagination->next_max_id : null;
	}

	public function getNextUrl() {
		return isset( $this->pagination->next_url ) ? $this->pagination->next_url : null;
	}

}