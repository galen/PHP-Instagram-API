<?php

namespace Instagram;

class Auth {

	protected $config = array(
		'grant_type'		=> 'authorization_code',
		'client'			=> 'Instagram\Net\CurlClient',
		'scope'				=> 'basic',
		'display'			=> ''
	);

	public function __construct( array $config ) {
		$this->config = $config + $this->config;
		$this->client = new $this->config['client'];
	}

	public function authorize() {
		header(
			sprintf(
				'Location:https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code',
				$this->config['client_id'],
				$this->config['callback_url']
			)
		);
		exit;
	}

	public function getAccessToken( $code ) {
		$post_data = array(
			'client_id'			=> $this->config['client_id'],
			'client_secret'		=> $this->config['client_secret'],
			'grant_type'		=> $this->config['grant_type'],
			'redirect_uri'		=> $this->config['callback_url'],
			'code'				=> $code
		);
		$response = $this->client->post(
			'https://api.instagram.com/oauth/access_token',
			$post_data
		);
		if ( isset( $response->getRawData()->access_token ) ) {	
			return $response->getRawData()->access_token;
		}
		throw new \Instagram\Core\ApiException( $response->getErrorMessage(), $response->getErrorCode(), $response->getErrorType() );
	}

}