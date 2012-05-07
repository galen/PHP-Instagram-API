<?php

namespace Instagram\Core;

abstract class BaseObjectAbstract {

	protected $data;

	public function getId() {
		return $this->data->id;
	}

	public function getApiId() {
		return $this->getId();
	}

	public function __construct( $data ) {
		$this->setData( $data );
	}
	
	public function setData( $data ) {
		$this->data = $data;
	}

	public function getData() {
		return $this->data;
	}

	public function __get( $var ) {
		return isset( $this->data->$var ) ? $this->data->$var : null;
	}

}