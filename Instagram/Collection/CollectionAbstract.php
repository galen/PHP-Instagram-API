<?php

namespace Instagram\Collection;

abstract class CollectionAbstract implements \Iterator, \ArrayAccess, \Countable {

	protected $pagination;
	protected $position;
	protected $data = array();

	public function __construct( $raw_data = null ) {
		if ( $raw_data ) {
			$this->setData( $raw_data );
		}
	}

	abstract function setData( $raw_data );

	public function getData() {
		return $this->data;
	}

	public function getItem( $item ) {
		return isset( $this->data[$item-1] ) ? $this->data[$item-1] : null;
	}

	public function getSlice( $offset, $length ) {
		return array_slice( $this->data, $offset, $length );
	}

	public function addData( \Instagram\Collection\CollectionAbstract $object ) {
		$this->data = array_merge( $this->data, $object->getData() );
	}

	protected function convertData( $object ) {
		$this->data = array_map(
			function( $c ) use( $object ) {
				return new $object( $c );
			},
			$this->data
		);
	}

	function setProxy( \Instagram\Core\Proxy $proxy ) {
		foreach( $this->data as $object ) {
			$object->setProxy( $proxy );
		}
	}

	function implode( \Closure $callback = null, $sep = ', ' ) {
		if ( !count( $this->getData() ) ) {
			return null;
		}
		if ( !$callback ) {
			$callback = function( $i ){ return $i->__toString(); };
		}
		foreach( $this->getData() as $item ) {
			$items[] = $callback( $item );
		}
		return implode( $sep, $items );
	}

	// Iterator stuff
	public function rewind() {
		$this->position = 0;
	}
	public function current(){
		return $this->data[ $this->position ];
	}
	public function key() {
		return $this->position;
	}
	public function next() {
		return ++$this->position;
	}
	public function valid() {
		return isset( $this->data[  $this->position ] );
	}

	// ArrayAccess stuff
	public function offsetExists( $offset ) {
		return isset( $this->data[$offset] );
	}

	public function offsetGet( $offset ) {
		return $this->data[$offset];
	}

	public function offsetSet( $offset, $value ) {}

	public function offsetUnset( $offset ) {}

	// Countable
	public function count() {
		return count( $this->data );
	}

}