<?php


namespace Fuel\Migrations;

class Instagram_Tags
{
	function up()
	{
		\DBUtil::add_fields('instagram__images', array(
			'tags' => array('type' => 'text', 'null' => true),
		));
	}

	function down()
	{
		\DBUtil::drop_fields('instagram__images', array(
			'tags'
		));
	}

}
