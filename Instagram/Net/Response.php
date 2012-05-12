<?php

/**
* Instagram PHP
* @author Galen Grover <galenjr@gmail.com>
* @license http://opensource.org/licenses/mit-license.php The MIT License
*/

namespace Instagram\Net;

class Response {

	protected $response;

	function __construct( $raw_response ){
		$this->response = json_decode( $raw_response );
		if ( !$this->isValidApiResponse() ) {
			$this->response = new \StdClass;
			$this->response->meta = new \StdClass;
			$this->response->meta->error_type = 'InvalidAPIUrlError';
			$this->response->meta->code = 444;
			$this->response->meta->error_message = 'invalid api url';
		}
	}

	function isValid() {
		return $this->response instanceof \StdClass && !isset( $this->response->meta->error_type ) && !isset( $this->response->error_type );
	}

	public function getData() {
		return isset( $this->response->data ) ? $this->response->data : null;
	}

	public function getRawData() {
		return isset( $this->response ) ? $this->response : null;
	}

	public function isValidApiResponse() {
		return $this->response instanceof \StdClass;
	}

	public function getErrorMessage() {
		if ( isset( $this->response->error_message ) ) {
			return $this->response->error_message;
		}
		elseif( isset( $this->response->meta->error_message ) ) {
			return $this->response->meta->error_message;
		}
		else {
			return null;
		}
	}

	public function getErrorCode() {
		if ( isset( $this->response->code ) ) {
			return $this->response->code;
		}
		elseif( isset( $this->response->meta->code ) ) {
			return $this->response->meta->code;
		}
		else {
			return null;
		}
	}

	public function getErrorType() {
		if ( isset( $this->response->error_type ) ) {
			return $this->response->error_type;
		}
		elseif( isset( $this->response->meta->error_type ) ) {
			return $this->response->meta->error_type;
		}
		else {
			return null;
		}
	}

	public function __toString() {
		return json_encode( $this->response );
	}

}