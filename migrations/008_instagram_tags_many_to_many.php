<?php


namespace Fuel\Migrations;

class Instagram_Tags_Many_To_Many
{
	function up()
	{	
		try 
		{
			\DB::start_transaction();

			//Remove Previous Serialised Storage field which won't be used any more
			\DBUtil::drop_fields('instagram__images', array(
				'tags'
			));
			//Create Tag Table
			\DBUtil::create_table('instagram__tags', array(
				'id'		=> array('type' => 'int', 'unsigned' => true, 'auto_increment' => true),
				'tag_name'	=> array('type' => 'text'),
			), array('id'), true, 'InnoDB', 'utf8_unicode_ci');
			//Create link Table
			\DBUtil::create_table('instagram__images_tags', array(
				'image_id'	=> array('type' => 'int', 'unsigned' => true),
				'tag_id'	=> array('type' => 'int', 'unsigned' => true),
			), array(), true, 'InnoDB', 'utf8_unicode_ci');

			\DB::commit_transaction();
		} 
		catch (\Exception $e)
		{
			\DB::rollback_transaction();
			\Cli::error(sprintf('Up Migration Failed - %s - %s', $e->getMessage(), __FILE__));
			return false;
		}

		\Cli::write('Migrated Up Successfully: ' . __FILE__, 'green');
	}

	function down()
	{
		try
		{
			\DB::start_transaction();

			\DBUtil::add_fields('instagram__images', array(
				'tags' => array('type' => 'text', 'null' => true),
			));
			\DBUtil::drop_table('instagram__tags');
			\DBUtil::drop_table('instagram__images_tags');

			\DB::commit_transaction();
		}
		catch (\Exception $e)
		{
			\DB::rollback_transaction();
			\Cli::error(sprintf('Up Migration Failed - %s - %s', $e->getMessage(), __FILE__));
			return false;
		}

		\Cli::write('Migrated Down Successfully: ' . __FILE__, 'green');		
	}

}
