<?php

namespace Propeller\Instagram;

class Model_Image extends \Orm\Model
{

	protected static $_table_name = 'instagram__images';

	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'label' => 'ID',
		),
		'instagram_id' => array(
			'type' => 'varchar',
			'label' => 'Instagram ID'
		),
		'subscription_id' => array(
			'type' => 'varchar',
			'label' => 'Subscription ID'
		),
		'thumb_img' => array(
			'type' => 'varchar',
			'label' => 'Thumbnail IMG'
		),
		'main_img' => array(
			'type' => 'varchar',
			'label' => 'Main IMG'
		),
		'lowres_img' => array(
			'type' => 'varchar',
			'label' => 'Low Res IMG'
		),
		'link' => array(
			'type' => 'varchar',
			'label' => 'Link'
		),
		'author' => array(
			'type' => 'varchar',
			'label' => 'Author'
		),
		'caption' => array(
			'type' => 'text',
			'label' => 'Caption',
			'null' => true
		),
		'accepted' => array(
			'type' => 'boolean',
			'label' => 'Accepted'
		),
		'created_at' => array(
			'type' => 'int',
			'label' => 'Created',
		),
		'updated_at' => array(
			'type' => 'int',
			'label' => 'Updated',
		),
	);

	protected static $_belongs_to = array(
		'subscription' => array(
			'key_from' => 'subscription_id',
			'model_to' => '\Propeller\Instagram\Model_Subscription',
			'key_to' => 'instagram_subscription_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		)
	);

	protected static $_many_many = array(
		'tags' => array(
			'key_from' => 'id',
			'key_through_from' => 'image_id',
			'table_through' => 'instagram__images_tags',
			'key_through_to' => 'tag_id',
			'model_to' => '\Propeller\Instagram\Model_Tag',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
		),
	);

}
