<?php

namespace Instagram\Net;

class CurlClient implements ClientInterface {
	
	protected $curl = null;
	
	function __construct(){
		$this->initializeCurl();
	}

	function get( $url, array $data = null ){
		curl_setopt( $this->curl, CURLOPT_URL, sprintf( "%s?%s", $url, http_build_query( $data ) ) );
		return $this->fetch();
	}
	
	function post( $url, array $data = null ) {
		curl_setopt( $this->curl, CURLOPT_URL, $url );
		curl_setopt( $this->curl, CURLOPT_POST, true );
		curl_setopt( $this->curl, CURLOPT_POSTFIELDS, $data );
		return $this->fetch();
	}
	
	function put( $url, array $data = null  ){}
	function delete( $url, array $data = null  ){}
	
	function initializeCurl() {
		$this->curl = curl_init();
		curl_setopt( $this->curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $this->curl, CURLOPT_SSL_VERIFYPEER, false );
	}
	
	function fetch() {
		$raw_response = curl_exec( $this->curl );
		if ( strlen( $raw_response ) > 0 ) {
			return new \Instagram\Net\Response( $raw_response );
		}
		else {
			throw new \Instagram\Core\ApiException( curl_error( $this->curl ), 666, 'CurlError' );
		}
	}
	
}