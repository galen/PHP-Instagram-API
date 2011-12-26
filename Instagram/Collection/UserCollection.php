<?php

namespace Instagram\Collection;

class UserCollection extends \Instagram\Collection\CollectionAbstract {

	protected $pagination;

	public function __construct( $raw_data = null ) {
		if ( $raw_data ) {
			$this->setData( $raw_data );
			$this->pagination = isset( $raw_data->pagination ) ? $raw_data->pagination : null;
			$this->convertData( '\Instagram\User' );
		}
	}

	public function getNextCursor() {
		return isset( $this->pagination->next_cursor ) && !empty( $this->pagination->next_cursor ) ? $this->pagination->next_cursor : null;
	}

	public function getNextUrl() {
		return isset( $this->pagination->next_url ) && !empty( $this->pagination->next_url ) ? $this->pagination->next_url : null;
	}

}