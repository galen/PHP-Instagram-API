<?php

namespace Instagram\Collection;

class TagCollection extends \Instagram\Collection\CollectionAbstract {

	public function setData( $raw_data ) {
		if ( isset( $raw_data->data ) ) {
			$this->data = $raw_data->data;
		}
		elseif( is_array( $raw_data ) ) {
			$this->data = array_map( function( $t ){ return (object)array( 'name' => $t ); }, $raw_data );
		}
		$this->convertData( '\Instagram\Tag' );
	}

	public function getNextMaxTagId() {
		return isset( $this->pagination->next_max_tag_id ) ? $this->pagination->next_max_tag_id : null;
	}

	public function getNextUrl() {
		return isset( $this->pagination->next_url ) ? $this->pagination->next_url : null;
	}

}