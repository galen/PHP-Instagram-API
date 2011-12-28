<?php

/**
* Instagram PHP
* @author Galen Grover <galenjr@gmail.com>
* @license http://opensource.org/licenses/mit-license.php The MIT License
*/

namespace Instagram;

/**
 * Helper class
 */
class Helper {

	/**
	 * Parse mentions in a string
	 *
	 * Finds mentions in a string (@mention) and applies a callback function each one
	 *
	 * @param string $text Text to parse
	 * @param \Closure $callback Function to apply to each mention
	 * @return string Returns the text after the callback have been applied to each mention
	 * @access public
	 */
	public static function parseMentions( $text, \Closure $callback ) {
		return preg_replace_callback( '~@(.+?)(?=\b)~', $callback, $text );
	}

	/**
	 * Parse tags in a string
	 *
	 * Finds tags in a string (#username) and applies a callback function each one
	 *
	 * @param string $text Text to parse
	 * @param \Closure $callback Function to apply to each tag
	 * @return string Returns the text after the callback have been applied to each tag
	 * @access public
	 */
	public static function parseTags( $text, \Closure $callback ) {
		return preg_replace_callback( '~#(.+?)(?=\b)~', $callback, $text );
	}

	/**
	 * Parse mentions and tags in a string
	 *
	 * Finds mentions and tags in a string (@mention, #tag) and applies a callback function each one
	 *
	 * @param string $text Text to parse
	 * @param \Closure $tags_callback Function to apply to each tag
	 * @param \Closure $mentions_callback Function to apply to each mention
	 * @return string Returns the text after the callbacks have been applied to tags and mentions
	 * @access public
	 */
	public static function parseTagsAndMentions( $text, \Closure $tags_callback, \Closure $mentions_callback ) {
		$text = self::parseTags( $text, $tags_callback );
		$text = self::parseMentions( $text, $mentions_callback );
		return $text;
	}

}