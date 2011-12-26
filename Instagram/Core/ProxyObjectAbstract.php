<?php

namespace Instagram\Core;

abstract class ProxyObjectAbstract extends \Instagram\Core\BaseObjectAbstract {

	protected $proxy;

	public function setProxy( \Instagram\Core\Proxy $proxy ) {
		$this->proxy = $proxy;
	}

}