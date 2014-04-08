<?php


namespace Fuel\Migrations;

class Instagram_Low_Res_Image
{
	function up()
	{	
		try 
		{
			\DB::start_transaction();

			\DBUtil::add_fields('instagram__images', array(
				'lowres_img' => array('type' => 'varchar', 'null' => true),
			));

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

			\DBUtil::drop_fields('instagram__images', array(
				'lowres_img'
			));

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
