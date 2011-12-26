<?php

namespace Instagram\Collection;

class CommentCollection extends \Instagram\Collection\CollectionAbstract {

	public function __construct( $raw_data = null ) {
		if ( $raw_data ){
			$this->setData( $raw_data );
			$this->convertData( '\Instagram\Comment' );
		}
	}

}