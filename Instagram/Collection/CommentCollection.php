<?php

namespace Instagram\Collection;

class CommentCollection extends \Instagram\Collection\CollectionAbstract {

	public function setData( $raw_data ) {
		$this->data = $raw_data->data;
		$this->convertData( '\Instagram\Comment' );
	}

}