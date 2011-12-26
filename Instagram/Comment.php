<?php

namespace Instagram;

class Comment extends \Instagram\Core\BaseObjectAbstract {

	protected $user;

	public function getText() {
		return $this->data->text;
	}

	public function getUser() {
		if ( !$this->user ) {
			$this->user = new \Instagram\User( $this->data->from );
		}
		return $this->user;
	}

	public function __toString() {
		return $this->data->text;
	}

	public function getCreatedTime( $format = null ) {
		if ( $format ) {
			$date = date( $format, $this->data->created_time );
		}
		else {
			$date = $this->data->created_time;
		}
		return $date;
	}

}