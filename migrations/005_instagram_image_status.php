<?php


namespace Fuel\Migrations;

class Instagram_Image_Status
{
	function up()
	{

		\DBUtil::modify_fields('instagram__images', array(
    		'accepted' => array('type' => 'enum', 'constraint' => array('unsorted', 'accepted', 'declined'))
		));

	}

	function down()
	{
		\DBUtil::modify_fields('instagram__images', array(
    		'accepted' => array('type' => 'boolean', 'null' => false)
		));
	}

}
