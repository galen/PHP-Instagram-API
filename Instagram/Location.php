<?php

/**
* Instagram PHP
* @author Galen Grover <galenjr@gmail.com>
* @license http://opensource.org/licenses/mit-license.php The MIT License
*/

namespace Instagram;

/**
 * Location class
 *
 * Some media has a location associated to it. This location will have an ID and a name.
 * Some media has no location associated, but has a lat/lng. These location objects will return null or '' for certain method calls
 *
 *
 */
class Location extends \Instagram\Core\ProxyObjectAbstract {

	/**
	 * Media cache
	 *
	 * When getMedia() is called the media will be stored here so future calls to getMedia()
	 * don't have to fetch the data too
	 *
	 * You can override the cache by passing $force_fetch = true to getMedia()
	 *
	 * @var \Instagram\Collection\MediaCollection
	 */
	protected $media;

	/**
	 * Get location media
	 *
	 * Retrieve the recent media posted to a given location
	 *
	 * @param array $params Optional params to pass to the endpoint
	 * @param bool $force_fetch Force the method to re-fetch the data
	 * @return \Instagram\Collection\MediaCollection
	 * @access public
	 */
	public function getMedia( array $params = null, $force_fetch = false ) {
		if ( (bool)$force_fetch || !$this->media ) {
			$this->media = $this->proxy->getLocationMedia( $this->getApiId(), $params );
		}
		return $this->media;
	}

	/**
	 * Get location ID
	 *
	 * @return string|null
	 * @access public
	 */
	public function getId() {
		return isset( $this->data->id ) ? $this->data->id : null;
	}

	/**
	 * Get location name
	 *
	 * @return string|null
	 * @access public
	 */
	public function getName() {
		return isset( $this->data->name ) ? $this->data->name : null;
	}

	/**
	 * Get location longitude
	 *
	 * Get the longitude of the location
	 *
	 * @return string|null
	 * @access public
	 */
	public function getLat() {
		return is_float( $this->data->latitude ) ? $this->data->latitude : null;
	}

	/**
	 * Get location latitude
	 *
	 * Get the latitude of the location
	 *
	 * @return string|null
	 * @access public
	 */
	public function getLng() {
		return is_float( $this->data->longitude ) ? $this->data->longitude : null;
	}

	/**
	 * Magic toString method
	 *
	 * Returns the location's name
	 *
	 * @return string
	 * @access public
	 */
	public function __toString() {
		return $this->getName() ? $this->getName() : '';
	}

}