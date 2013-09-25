<?php

/**
* Instagram PHP
* @author Galen Grover <galenjr@gmail.com>
* @license http://opensource.org/licenses/mit-license.php The MIT License
*/

namespace Instagram\Net;

/**
 * API Response
 *
 * Holds the API response
 */
class ApiResponse {

    /**
     * Response
     *
     * This is the response from the API
     *
     * @var StdClass
     * @access protected
     */
    protected $response;

    /**
     * Response headers
     * 
     * @var array
     * @access protected
     */
    protected $responseHeaders;
    
    /**
     * Constructor
     *
     * @param $raw_response Response from teh API
     * @param $response_headers Response headers
     * @access public
     */
    public function __construct( $raw_response, array $response_headers = null ){
        $this->response = json_decode( $raw_response );
        $this->responseHeaders = $response_headers;
        if ( !$this->isValidApiResponse() ) {
            $this->response = new \StdClass;
            $this->response->meta = new \StdClass;
            $this->response->meta->error_type = 'UnknownAPiError';
            $this->response->meta->code = 555;
            $this->response->meta->error_message = 'Unknown error';
        }
    }

    /**
     * Is Valid
     *
     * Returns true if the API returned an error, otherwise false
     *
     * @return boolean
     * @access public
     */
    public function isValid() {
        return
            $this->response instanceof \StdClass &&
            !isset( $this->response->meta->error_type ) &&
            !isset( $this->response->error_type );
    }
    /**
     * Is Valid API Response
     *
     * Returns true if the response was a valid response from the API, otherwise false
     *
     * @return boolean
     * @access public
     */
    public function isValidApiResponse() {
        return $this->response instanceof \StdClass;
    }

    /**
     * Get the response data
     *
     * @return mixed Return the response's data or null
     * @access public
     */
    public function getData() {
        return isset( $this->response->data ) ? $this->response->data : null;
    }

    /**
     *  Get the raw response
     *
     * @return mixed Returns the response or null
     * @access public
     */
    public function getRawData() {
        return isset( $this->response ) ? $this->response : null;
    }

    /**
     * Get the response headers
     * 
     * @return array Return the response's headers
     * @access public
     */
	public function getHeaders() {
		return $this->responseHeaders;
	}

    /**
     * Get the response's error message
     *
     * @return mixed Returns the error message or null
     * @access public
     */
    public function getErrorMessage() {
        if ( isset( $this->response->error_message ) ) {
            return $this->response->error_message;
        }
        if( isset( $this->response->meta->error_message ) ) {
            return $this->response->meta->error_message;
        }
        return null;
    }

    /**
     * Get the error code
     *
     * @return mixed Returns the error code or null
     * @access public
     */
    public function getErrorCode() {
        if ( isset( $this->response->code ) ) {
            return $this->response->code;
        }
        if( isset( $this->response->meta->code ) ) {
            return $this->response->meta->code;
        }
        return null;
    }

    /**
     * Get the error type
     * 
     * @return mixed Returns the error type or null
     * @access public
     */
    public function getErrorType() {
        if ( isset( $this->response->error_type ) ) {
            return $this->response->error_type;
        }
        if( isset( $this->response->meta->error_type ) ) {
            return $this->response->meta->error_type;
        }
        return null;
    }
    
    /**
     * Gets the Rate limit returned from API
     * 
     * @return mixed Returns the Rate limit returned from API
     * @access public
     */
    public function getRateLimit() {
    	return isset($this->responseHeaders['x-ratelimit-limit']) ? (int) $this->responseHeaders['x-ratelimit-limit'] : null;
    }
    
    /**
     * Gets the Remaining Rate limit returned from API
     *
     * @return mixed Returns the Remaining Rate limit returned from API
     * @access public
     */
    public function getRateLimitRemaining() {
    	return isset($this->responseHeaders['x-ratelimit-remaining']) ? (int) $this->responseHeaders['x-ratelimit-remaining'] : null;
    }
    
    /**
     * Magic to string method
     *
     * @return string Return the json encoded response
     * @access public
     */
    public function __toString() {
        return json_encode( $this->response );
    }

}