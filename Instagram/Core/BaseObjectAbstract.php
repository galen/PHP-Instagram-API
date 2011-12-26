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

}