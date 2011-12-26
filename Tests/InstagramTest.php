<?php

require_once( '_autoloader.php' );

class InstagramTest extends PHPUnit_Framework_TestCase {

	protected $config = array(
		'access_token'	=> '11007611.f59def8.4f942a67c9174159a1601a037490d3ea'
	);

	protected $valid_user_id = 11007611;
	protected $valid_media_id = 23;
	protected $valid_tag = 'almostdied';

	public function testCreateInstagram() {
		$instagram = new Instagram\Instagram( $this->config );
		$this->assertInstanceOf( 'Instagram\Instagram', $instagram );
	}

	public function testCreateInstagramWithInvalidTokenFailure() {
		$this->setExpectedException('\Instagram\Core\ApiException');
		$instagram = new Instagram\Instagram( array( 'access_token' => '=)' ) );
		$user = $instagram->getUser( $this->valid_user_id );
	}

	public function testCreateInstagramWithoutAccessTokenFailure() {
		$this->setExpectedException('\Instagram\Core\ApiException');
		$instagram = new Instagram\Instagram( array() );
	}

	public function testCreateUser() {
		$instagram = new Instagram\Instagram( $this->config );
		$user = $instagram->getUser( $this->valid_user_id );
		$this->assertInstanceOf( '\Instagram\User', $user );
	}

	public function testCreateInvalidUser() {
		$this->setExpectedException('\Instagram\Core\ApiException');
		$instagram = new Instagram\Instagram( $this->config );
		$user = $instagram->getUser( 'asdf' );
	}

	public function testCreateInvalidUser2() {
		$this->setExpectedException('\Instagram\Core\ApiException');
		$instagram = new Instagram\Instagram( $this->config );
		$user = $instagram->getUser( 928490283490238409284902384902348904 );
	}

	public function testCreateMedia() {
		$instagram = new Instagram\Instagram( $this->config );
		$media = $instagram->getMedia( $this->valid_media_id );
		$this->assertInstanceOf( '\Instagram\Media', $media );
	}

	public function testCreateInvalidMedia() {
		$this->setExpectedException('\Instagram\Core\ApiException');
		$instagram = new Instagram\Instagram( $this->config );
		$media = $instagram->getMedia( 'asdf' );
	}

	public function testCreateInvalidMedia2() {
		$this->setExpectedException('\Instagram\Core\ApiException');
		$instagram = new Instagram\Instagram( $this->config );
		$media = $instagram->getMedia( 9284902834902384092849023849023489043294829308423904829034892304802938 );
	}

	public function testCreateTag() {
		$instagram = new Instagram\Instagram( $this->config );
		$tag = $instagram->getTag( $this->valid_tag );
		$this->assertInstanceOf( '\Instagram\Tag', $tag );
	}

	public function testCreateInvalidTag() {
		$this->setExpectedException('\Instagram\Core\ApiException');
		$instagram = new Instagram\Instagram( $this->config );
		$tag = $instagram->getTag( '' );
	}

	public function testCreateInvalidTag2() {
		$this->setExpectedException('\Instagram\Core\ApiException');
		$instagram = new Instagram\Instagram( $this->config );
		$tag = $instagram->getTag( 928490283490238409284902384902348904 );
	}

	public function testSearchUsers() {
		$instagram = new Instagram\Instagram( $this->config );
		$users = $instagram->searchUsersByName( 'john' );
		$this->assertInstanceOf( '\Instagram\Collection\UserCollection', $users );
	}

	public function testSearchUsersNoResults() {
		$instagram = new Instagram\Instagram( $this->config );
		$users = $instagram->searchUsersByName( 'laksdfjalskfja;sldfjas;lkfj' );
		$this->assertInstanceOf( '\Instagram\Collection\UserCollection', $users );
		$this->assertTrue( $users->count() == 0 );
	}

	public function testInvalidSearchUsers() {
		$this->setExpectedException('\Instagram\Core\ApiException');
		$instagram = new Instagram\Instagram( $this->config );
		$users = $instagram->searchUsersByName( '' );
		$this->assertInstanceOf( '\Instagram\Collection\UserCollection', $users );
	}

	public function testSearchLocations() {
		$instagram = new Instagram\Instagram( $this->config );
		$locations = $instagram->searchLocations( 40.7143528, -74.0059731 );
		$this->assertInstanceOf( '\Instagram\Collection\LocationCollection', $locations );
	}

	public function testSearchLocationsNoResults() {
		$instagram = new Instagram\Instagram( $this->config );
		$locations = $instagram->searchLocations( 1,1 );
		$this->assertInstanceOf( '\Instagram\Collection\LocationCollection', $locations );
		$this->assertTrue( $locations->count() == 0 );
	}

	public function testSearchMedia() {
		$instagram = new Instagram\Instagram( $this->config );
		$media = $instagram->searchMedia( 40.7143528, -74.0059731 );
		$this->assertInstanceOf( '\Instagram\Collection\MediaSearchCollection', $media );
		$this->assertTrue( (bool)strlen( $media->getNextMaxTimestamp() ) );
	}

	public function testSearchMediaNoResults() {
		$instagram = new Instagram\Instagram( $this->config );
		$media = $instagram->searchMedia( 1,1 );
		$this->assertInstanceOf( '\Instagram\Collection\MediaSearchCollection', $media );
		$this->assertTrue( $media->count() == 0 );
		$this->assertTrue( is_null( $media->getNextMaxTimestamp() ) );
	}

	public function testSearchTags() {
		$instagram = new Instagram\Instagram( $this->config );
		$tags = $instagram->searchTags( 'almostdied' );
		$this->assertInstanceOf( '\Instagram\Collection\TagCollection', $tags );
	}

	public function testSearchTagsNoResults() {
		$instagram = new Instagram\Instagram( $this->config );
		$tags = $instagram->searchTags( 'laksdfjalskfja;sldfjas;lkfj123!@#' );
		$this->assertInstanceOf( '\Instagram\Collection\TagCollection', $tags );
		$this->assertTrue( $tags->count() == 0 );
	}

	public function testInvalidSearchTags() {
		$this->setExpectedException('\Instagram\Core\ApiException');
		$instagram = new Instagram\Instagram( $this->config );
		$tags = $instagram->searchTags( '' );
		$this->assertInstanceOf( '\Instagram\Collection\TagCollection', $tags );
	}

}