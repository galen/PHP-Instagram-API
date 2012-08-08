<?php

require_once( '_autoloader.php' );

class TagTest extends PHPUnit_Framework_TestCase {

    protected $access_token = '11007611.f59def8.4f942a67c9174159a1601a037490d3ea';
    protected $instagram;
    protected $tag;
    protected $valid_tag = 'almostdied';

    protected function setUp() {
        $this->instagram = new Instagram\Instagram( $this->access_token );
        $this->tag = $this->instagram->getTag( $this->valid_tag );
    }

    public function testTagData() {
        $this->assertTrue( is_string( $this->tag->getName() ) );
        $this->assertTrue( is_int( $this->tag->getMediaCount() ) );
    }

    public function testGetMedia() {
        $media = $this->tag->getMedia();
        $this->assertInstanceOf( '\Instagram\Collection\TagMediaCollection', $media );
    }

}