<?php

namespace Instagram\Core;

class ApiException extends \Exception {

	const TYPE_NOT_ALLOWED	= 'APINotAllowedError';
	const TYPE_OAUTH		= 'OAuthAccessTokenException';

	protected $type;

	public function __construct( $message = null, $code = 0, $type = null, \Exception $previous = null ) {
		$this->type = $type;
		parent::__construct( $message, $code, $previous );
	}

	public function getType() {
		return $this->type;
	}

}