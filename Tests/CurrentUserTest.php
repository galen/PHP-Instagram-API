<?php

require_once( '_autoloader.php' );

class CurrentUserTest extends PHPUnit_Framework_TestCase {

    protected $access_token = '11007611.f59def8.4f942a67c9174159a1601a037490d3ea';
    protected $instagram;
    protected $user;
    protected $valid_user_id = 11007611;

    protected function setUp() {
        $this->instagram = new Instagram\Instagram( $this->access_token );
        $this->user = $this->instagram->getCurrentUser();
    }

    public function testUserData() {
        $this->assertTrue( is_string( $this->user->getUserName() ) );
        $this->assertRegExp( '~\S+~', $this->user->getUserName() );
        $this->assertTrue( is_string( $this->user->getFullName() ) );
        $this->assertTrue( is_string( $this->user->getProfilePicture() ) );
        $this->assertTrue( is_string( $this->user->getBio() ) );
        $this->assertTrue( is_string( $this->user->getWebsite() ) );
        $this->assertTrue( is_int( $this->user->getFollowsCount() ) );
        $this->assertTrue( is_int( $this->user->getFollowersCount() ) );
        $this->assertTrue( is_int( $this->user->getMediaCount() ) );
        $this->assertInstanceOf( '\StdClass', $this->user->getCounts() );
    }

    public function testGetMedia() {
        $media = $this->user->getMedia();
        $this->assertInstanceOf( '\Instagram\Collection\MediaCollection', $media );
    }

    public function testGetFeed() {
        $media = $this->user->getFeed();
        $this->assertInstanceOf( '\Instagram\Collection\MediaCollection', $media );
    }

    public function testGetLikedMedia() {
        $media = $this->user->getLikedMedia();
        $this->assertInstanceOf( '\Instagram\Collection\MediaCollection', $media );
    }

}
