<?php

require_once( '_autoloader.php' );

class InstagramTest extends PHPUnit_Framework_TestCase {

    protected $access_token = '11007611.f59def8.4f942a67c9174159a1601a037490d3ea';
    protected $valid_user_id = 11007611;
    protected $valid_media_id = 23;
    protected $valid_tag = 'almostdied';

    public function testCreateInstagram() {
        $instagram = new Instagram\Instagram( $this->access_token );
        $this->assertInstanceOf( 'Instagram\Instagram', $instagram );
    }

    public function testCreateInstagramWithInvalidTokenFailure() {
        $this->setExpectedException('\Instagram\Core\ApiException');
        $instagram = new Instagram\Instagram( '=)' );
        $user = $instagram->getUser( $this->valid_user_id );
    }

    public function testCreateUser() {
        $instagram = new Instagram\Instagram( $this->access_token );
        $user = $instagram->getUser( $this->valid_user_id );
        $this->assertInstanceOf( '\Instagram\User', $user );
    }

    public function testCreateInvalidUser() {
        $this->setExpectedException('\Instagram\Core\ApiException');
        $instagram = new Instagram\Instagram( $this->access_token );
        $user = $instagram->getUser( 'asdf' );
    }

    public function testCreateInvalidUser2() {
        $this->setExpectedException('\Instagram\Core\ApiException');
        $instagram = new Instagram\Instagram( $this->access_token );
        $user = $instagram->getUser( 928490283490238409284902384902348904 );
    }

    public function testCreateMedia() {
        $instagram = new Instagram\Instagram( $this->access_token );
        $media = $instagram->getMedia( $this->valid_media_id );
        $this->assertInstanceOf( '\Instagram\Media', $media );
    }

    public function testCreateInvalidMedia() {
        $this->setExpectedException('\Instagram\Core\ApiException');
        $instagram = new Instagram\Instagram( $this->access_token );
        $media = $instagram->getMedia( 'asdf' );
    }

    public function testCreateInvalidMedia2() {
        $this->setExpectedException('\Instagram\Core\ApiException');
        $instagram = new Instagram\Instagram( $this->access_token );
        $media = $instagram->getMedia( 9284902834902384092849023849023489043294829308423904829034892304802938 );
    }

    public function testCreateTag() {
        $instagram = new Instagram\Instagram( $this->access_token );
        $tag = $instagram->getTag( $this->valid_tag );
        $this->assertInstanceOf( '\Instagram\Tag', $tag );
    }

    public function testCreateInvalidTag() {
        $this->setExpectedException('\Instagram\Core\ApiException');
        $instagram = new Instagram\Instagram( $this->access_token );
        $tag = $instagram->getTag( '' );
    }

    public function testCreateInvalidTag2() {
        $this->setExpectedException('\Instagram\Core\ApiException');
        $instagram = new Instagram\Instagram( $this->access_token );
        $tag = $instagram->getTag( 928490283490238409284902384902348904 );
    }

    public function testSearchUsers() {
        $instagram = new Instagram\Instagram( $this->access_token );
        $users = $instagram->searchUsers( 'john' );
        $this->assertInstanceOf( '\Instagram\Collection\UserCollection', $users );
    }

    public function testSearchUsersNoResults() {
        $instagram = new Instagram\Instagram( $this->access_token );
        $users = $instagram->searchUsers( 'laksdfjalskfja;sldfjas;lkfj' );
        $this->assertInstanceOf( '\Instagram\Collection\UserCollection', $users );
        $this->assertTrue( $users->count() == 0 );
    }

    public function testInvalidSearchUsers() {
        $this->setExpectedException('\Instagram\Core\ApiException');
        $instagram = new Instagram\Instagram( $this->access_token );
        $users = $instagram->searchUsers( '' );
        $this->assertInstanceOf( '\Instagram\Collection\UserCollection', $users );
    }

    public function testSearchLocations() {
        $instagram = new Instagram\Instagram( $this->access_token );
        $locations = $instagram->searchLocations( 40.7143528, -74.0059731 );
        $this->assertInstanceOf( '\Instagram\Collection\LocationCollection', $locations );
    }

    public function testSearchLocationsNoResults() {
        $instagram = new Instagram\Instagram( $this->access_token );
        $locations = $instagram->searchLocations( 800,800 );
        $this->assertInstanceOf( '\Instagram\Collection\LocationCollection', $locations );
        $this->assertTrue( $locations->count() == 0 );
    }

    public function testSearchMedia() {
        $instagram = new Instagram\Instagram( $this->access_token );
        $media = $instagram->searchMedia( 40.7143528, -74.0059731 );
        $this->assertInstanceOf( '\Instagram\Collection\MediaSearchCollection', $media );
        $this->assertTrue( (bool)strlen( $media->getNextMaxTimestamp() ) );
    }

    public function testSearchMediaNoResults() {
        $instagram = new Instagram\Instagram( $this->access_token );
        $media = $instagram->searchMedia( 1,1 );
        $this->assertInstanceOf( '\Instagram\Collection\MediaSearchCollection', $media );
        $this->assertTrue( $media->count() == 0 );
        $this->assertTrue( is_null( $media->getNextMaxTimestamp() ) );
    }

    public function testSearchTags() {
        $instagram = new Instagram\Instagram( $this->access_token );
        $tags = $instagram->searchTags( 'almostdied' );
        $this->assertInstanceOf( '\Instagram\Collection\TagCollection', $tags );
    }

    public function testSearchTagsNoResults() {
        $instagram = new Instagram\Instagram( $this->access_token );
        $tags = $instagram->searchTags( 'laksdfjalskfja;sldfjas;lkfj123!@#' );
        $this->assertInstanceOf( '\Instagram\Collection\TagCollection', $tags );
        $this->assertTrue( $tags->count() == 0 );
    }

    public function testInvalidSearchTags() {
        $this->setExpectedException('\Instagram\Core\ApiException');
        $instagram = new Instagram\Instagram( $this->access_token );
        $tags = $instagram->searchTags( '' );
        $this->assertInstanceOf( '\Instagram\Collection\TagCollection', $tags );
    }

}