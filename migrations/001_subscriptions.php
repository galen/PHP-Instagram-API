<?php


namespace Fuel\Migrations;

class Subscriptions
{
	function up()
	{
		// Create sites table and add default
		\DBUtil::create_table('instagram__subscription', array(
				'id'					=> array('type' => 'int', 'unsigned' => true, 'auto_increment' => true),
				'guid'					=> array('type' => 'tinytext'),
				'alias'					=> array('type' => 'tinytext'),
				'params'				=> array('type' => 'text'),
				'object_id'				=> array('type' => 'tinytext'),
				'instagram_subscription_id' => array('type' => 'int', 'null' => true),
				'status'				=> array('type' => 'enum', 'constraint' => array('Requested', 'Accepted', 'Live', 'Disabled')),
				'last_image_received'	=> array('type' => 'int', 'null' => true),
				'created_at'			=> array('type' => 'int'),
				'updated_at'			=> array('type' => 'int'),
			), array('id'), false, 'InnoDB', 'utf8_unicode_ci');
	}

	function down()
	{
		\DBUtil::drop_table('instagram__subscription');
	}

}
