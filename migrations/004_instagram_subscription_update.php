<?php


namespace Fuel\Migrations;

class Instagram_Subscription_Update
{
	function up()
	{
		// Create sites table and add default
		\DBUtil::add_fields('instagram__subscription', array(
			'last_managed' => array('type' => 'int', 'null' => true),
		));
	}

	function down()
	{
		\DBUtil::drop_fields('instagram__subscription', 'last_managed');
	}

}
