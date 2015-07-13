<?php


namespace Fuel\Migrations;

class Instagram_Posted_At
{
	function up()
	{	
		try 
		{
			\DB::start_transaction();

			\DBUtil::add_fields('instagram__images', array(
				'posted_at' => array('type' => 'int', 'null' => true),
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
				'posted_at'
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
