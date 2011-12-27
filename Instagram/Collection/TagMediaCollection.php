<?php

namespace Instagram\Collection;

class TagMediaCollection extends \Instagram\Collection\CollectionAbstract {

	protected $pagination;

	public function setData( $raw_data ) {
		$this->data = $raw_data->data;
		$this->pagination = isset( $raw_data->pagination ) ? $raw_data->pagination : null;
		$this->convertData( '\Instagram\Media' );
	}

	public function getNextMaxTagId() {
		return isset( $this->pagination->next_max_tag_id ) ? $this->pagination->next_max_tag_id : null;
	}

	public function getNextUrl() {
		return isset( $this->pagination->next_url ) ? $this->pagination->next_url : null;
	}

}