<?php


namespace Fuel\Migrations;

class Instagram_Tags_Many_To_Many
{
	function up()
	{	
		//Remove Previous Serialised Storage field which won't be used any more
		\DBUtil::drop_fields('instagram__images', array(
			'tags'
		));
		//Create Tag Table
		\DBUtil::create_table('instagram__tags', array(
				'id'					=> array('type' => 'int', 'unsigned' => true, 'auto_increment' => true),
				'tag_name'				=> array('type' => 'text'),
		), array('id'), true, 'InnoDB', 'utf8_unicode_ci');
		//Create link Table
		\DBUtil::create_table('instagram__images_tags', array(
				'image_id'				=> array('type' => 'int', 'unsigned' => true),
				'tag_id'				=> array('type' => 'int', 'unsigned' => true),
		), array(), true, 'InnoDB', 'utf8_unicode_ci');
	}

	function down()
	{
		\DBUtil::add_fields('instagram__images', array(
			'tags' => array('type' => 'text', 'null' => true),
		));
		\DBUtil::drop_table('instagram__tags');
		\DBUtil::drop_table('instagram__images_tags');
	}

}
