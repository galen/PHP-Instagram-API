<?php

namespace Fuel\Migrations;

class Instagram_Account_Auth
{
	function up()
	{
		// Create sites table and add default
		\DBUtil::create_table('instagram__accounts', array(
				'id'					=> array('type' => 'int', 'unsigned' => true, 'auto_increment' => true),
				'username'				=> array('type' => 'tinytext'),
				'instagram_id'			=> array('type' => 'tinytext'),
				'token'					=> array('type' => 'text'),
				'active'				=> array('type' => 'bool'),
				'created_at'			=> array('type' => 'int'),
				'updated_at'			=> array('type' => 'int'),
			), array('id'), false, 'InnoDB', 'utf8_unicode_ci');
	}

	function down()
	{
		\DBUtil::drop_table('instagram__accounts');
	}

}
