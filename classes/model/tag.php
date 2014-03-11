<?php

namespace Propeller\Instagram;


class Model_Tag extends \Orm\Model
{

	protected static $_table_name = 'instagram__tags';

	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'label' => 'ID',
		),
		'tag_name' => array(
			'type' => 'text',
			'label' => 'Tag Name'
		),
	);

	protected static $_many_many = array(
		'images' => array(
			'key_from' => 'id',
			'key_through_from' => 'tag_id',
			'table_through' => 'instagram__images_tags',
			'key_through_to' => 'image_id',
			'model_to' => '\Propeller\Instagram\Model_Image',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

}
