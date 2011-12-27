<?php

namespace Instagram;

class Helper {

	public static function parseTags( $text, \Closure $closure ) {
		return preg_replace_callback( '~#(.+?)(?=\b)~', $closure, $text );
	}

	public static function parseMentions( $text, \Closure $closure ) {
		return preg_replace_callback( '~@(.+?)(?=\b)~', $closure, $text );
	}

	public static function parseTagsAndMentions( $text, \Closure $tags_closure, \Closure $mentions_closure ) {
		$text = self::parseTags( $text, $tags_closure );
		$text = self::parseMentions( $text, $mentions_closure );
	}

}