<?php

/**
* Instagram PHP
* @author Galen Grover <galenjr@gmail.com>
* @license http://opensource.org/licenses/mit-license.php The MIT License
*/

namespace Instagram\Collection;

/**
 * Tag Media Collection
 *
 * Holds a collection of media associated with a tag
 */
class TagMediaCollection extends \Instagram\Collection\MediaCollection {

    /**
     * Get next max tag id
     *
     * Get the next max tag id for use in pagination
     *
     * @return string Returns the next max tag id
     * @access public
     */
    public function getNextMaxTagId() {
        return isset( $this->pagination->next_max_tag_id ) ? $this->pagination->next_max_tag_id : null;
    }

    /**
     * Get next max tag id
     *
     * Get the next max tag id for use in pagination
     *
     * @return string Returns the next max tag id
     * @access public
     */
    public function getNext() {
        return $this->getNextMaxTagId();
    }

}