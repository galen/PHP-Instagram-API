<?php


namespace Fuel\Migrations;

class Instagram_Image
{
	function up()
	{
		try 
		{
			\DB::start_transaction();
			
			\DBUtil::create_table('instagram__images', array(
				'id'					=> array('type' => 'int', 'unsigned' => true, 'auto_increment' => true),
				'instagram_id' 			=> array('type' => 'tinytext'),
				'subscription_id'		=> array('type' => 'tinytext'),
				'thumb_img'				=> array('type' => 'tinytext'),
				'main_img'				=> array('type' => 'tinytext'),
				'link'					=> array('type' => 'tinytext'),
				'author'				=> array('type' => 'tinytext'),
				'accepted'				=> array('type' => 'boolean'),
				'created_at'			=> array('type' => 'int'),
				'updated_at'			=> array('type' => 'int'),
			), array('id'), false, 'InnoDB', 'utf8_unicode_ci');

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

			\DBUtil::drop_table('instagram__images');

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
