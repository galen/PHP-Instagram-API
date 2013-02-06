<?php


namespace Fuel\Migrations;

class Instagram_Image
{
	function up()
	{
		// Create sites table and add default
		\DBUtil::create_table('instagram__images', array(
				'id'					=> array('type' => 'int', 'unsigned' => true, 'auto_increment' => true),
				'instagram_id' 			=> array('type' => 'tinytext'),
				'thumb_img'				=> array('type' => 'tinytext'),
				'main_img'				=> array('type' => 'tinytext'),
				'link'					=> array('type' => 'tinytext'),
				'author'				=> array('type' => 'tinytext'),
				'accepted'				=> array('type' => 'boolean'),
				'created_at'			=> array('type' => 'int'),
				'updated_at'			=> array('type' => 'int'),
			), array('id'), false, 'InnoDB', 'utf8_unicode_ci');
	}

	function down()
	{
		\DBUtil::drop_table('instagram__images');
	}

}
