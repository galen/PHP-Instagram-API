<?php

namespace Propeller\Instagram;


class Model_Subscription extends \Orm\Model
{

	protected static $_table_name = 'instagram__subscription';

	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'label' => 'ID',
		),
		'guid' => array(
			'type' => 'varchar',
			'label' => 'Verify Token'
		),
		'alias' => array(
			'type' => 'varchar',
			'label' => 'Subscription Alias'
		),
		'params' => array(
			'type' => 'text',
			'label' => 'Parameters',
		),
		'object_id' => array(
			'type' => 'varchar',
			'label' => 'Subscribed To:'
		),
		'instagram_subscription_id' => array(
			'type' => 'int',
			'label' => 'Instagram Subscription Id'
		),
		'status' => array(
			'type' => 'enum',
			'label' => 'Status',
		),
		'last_image_received' => array(
			'type' => 'int',
			'label' => 'Last Image Received At',
			'default' => 0,
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

	protected static $_has_many = array(
		'images' => array(
			'key_from' => 'instagram_subscription_id',
			'model_to' => '\Propeller\Instagram\Model_Image',
			'key_to' => 'subscription_id',
			'cascade_save' => true,
			'cascade_delete' => false,
		)
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
