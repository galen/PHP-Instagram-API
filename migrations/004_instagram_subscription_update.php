<?php


namespace Fuel\Migrations;

class Instagram_Subscription_Update
{
	function up()
	{
		try 
		{
			\DB::start_transaction();
			
			\DBUtil::add_fields('instagram__subscription', array(
				'last_managed' => array('type' => 'int', 'null' => true),
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
			
			\DBUtil::drop_fields('instagram__subscription', 'last_managed');

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
