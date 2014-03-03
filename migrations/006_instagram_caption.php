<?php


namespace Fuel\Migrations;

class Instagram_Caption
{
	function up()
	{
		\DBUtil::add_fields('instagram__images', array(
			'caption' => array('type' => 'text', 'null' => true),
		));
	}

	function down()
	{
		\DBUtil::drop_fields('instagram__images', array(
			'caption'
		));
	}

}
