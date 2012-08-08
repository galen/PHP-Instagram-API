<?php

require_once( '_autoloader.php' );

class LocationTest extends PHPUnit_Framework_TestCase {

    protected $access_token = '11007611.f59def8.4f942a67c9174159a1601a037490d3ea';
    protected $instagram;
    protected $location;
    protected $valid_location_id = 1;

    protected function setUp() {
        $this->instagram = new Instagram\Instagram( $this->access_token );
    }

    public function testFullLocationData() {
        $location = $this->instagram->getLocation( 1 );
        $this->assertTrue( $location->getId() != '' );
        $this->assertTrue( is_string( $location->getName() ) );
        $this->assertTrue( is_float( $location->getLat() ) || is_null( $location->getLat() ) );
        $this->assertTrue( is_float( $location->getLng() ) || is_null( $location->getLng() ) );
    }

    public function testBasicLocationData() {
        $media = $this->instagram->getMedia( '427150720_11007611' );
        $location = $media->getLocation();
        $this->assertTrue( is_null( $location->getName() ) );
    }
    
    public function testNullLocationData() {
        $media = $this->instagram->getMedia( 3 );
        $location = $media->getLocation();
        $this->assertTrue( is_null( $location ) );
    }

    public function testGetMedia() {
        $location = $this->instagram->getLocation( 1 );
        $media = $location->getMedia();
        $this->assertInstanceOf( '\Instagram\Collection\MediaCollection', $media );
    }



}