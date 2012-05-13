<?php

namespace Instagram\Core;

abstract class BaseObjectAbstract {

    protected $data;
    protected $proxy = null;

    public function getId() {
        return $this->data->id;
    }

    public function getApiId() {
        return $this->getId();
    }

    public function __construct( $data, \Instagram\Core\Proxy $proxy = null ) {
        $this->setData( $data );
        $this->proxy = $proxy;
    }
    
    public function setData( $data ) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

    public function __get( $var ) {
        return isset( $this->data->$var ) ? $this->data->$var : null;
    }

    public function setProxy( \Instagram\Core\Proxy $proxy ) {
        $this->proxy = $proxy;
    }

}