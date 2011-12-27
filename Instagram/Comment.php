<?php

namespace Instagram;

class Comment extends \Instagram\Core\BaseObjectAbstract {

	protected $user;

	public function getText( \Closure $tags_closure = null, \Closure $mentions_closure = null ) {
		$text = $this->data->text;
		if ( $tags_closure ) {
			$text = \Instagram\Helper::parseTags( $text, $tags_closure );
		}
		if ( $mentions_closure ) {
			$text = \Instagram\Helper::parseMentions( $text, $mentions_closure );
		}
		return $text;
	}

	public function getUser() {
		if ( !$this->user ) {
			$this->user = new \Instagram\User( $this->data->from );
		}
		return $this->user;
	}

	public function __toString() {
		return $this->getText();
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