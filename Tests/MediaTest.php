<?php

require_once( '_autoloader.php' );

class MediaTest extends PHPUnit_Framework_TestCase {

    protected $access_token = '11007611.f59def8.4f942a67c9174159a1601a037490d3ea';
    protected $instagram;
    protected $media;
    protected $valid_media_id = 23;

    protected function setUp() {
        $this->instagram = new Instagram\Instagram( $this->access_token );
        $this->media = $this->instagram->getMedia( $this->valid_media_id );
    }

    public function testMediaData() {
        $this->assertTrue( is_string( $this->media->getThumbnail()->url ) );
        $this->assertTrue( is_string( $this->media->getStandardRes()->url ) );
        $this->assertTrue( is_string( $this->media->getLowRes()->url ) );
        $this->assertTrue(
            is_null( $this->media->getCaption() ) ||
            $this->media->getCaption() instanceof \Instagram\Comment
        );
        $this->assertInstanceOf( '\Instagram\User', $this->media->getUser() );
        $this->assertInstanceOf( '\Instagram\Collection\CommentCollection', $this->media->getComments() );
        $this->assertTrue( is_string( $this->media->getFilter() ) );
        $this->assertInstanceOf( '\Instagram\Collection\TagCollection',  $this->media->getTags() );
        $this->assertTrue( is_string( $this->media->getLink() ) );
        $this->assertTrue( is_int( $this->media->getLikesCount() ) );
        $this->assertInstanceOf( '\Instagram\Collection\UserCollection', $this->media->getLikes() );    
        $this->assertTrue(
            is_null( $this->media->getLocation() ) ||
            $this->media->getLocation() instanceof \Instagram\Location ||
            $this->media->getLocation() instanceof \StdClass
        );
    }

}