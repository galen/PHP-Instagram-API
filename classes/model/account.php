<?php

namespace Propeller\Instagram;


class Model_Account extends \Orm\Model
{

	protected static $_table_name = 'instagram__accounts';

	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'label' => 'ID',
		),
		'username' => array(
			'type' => 'varchar',
			'label' => 'Username'
		),
		'instagram_id' => array(
			'type' => 'varchar',
			'label' => 'Instagram ID'
		),
		'token' => array(
			'type' => 'text',
			'label' => 'Token',
		),
		'active' => array(
			'type' => 'varchar',
			'label' => 'Active'
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

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
		),
	);

}
