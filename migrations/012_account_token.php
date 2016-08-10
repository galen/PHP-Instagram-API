<?php


namespace Fuel\Migrations;

class Account_Token
{
	protected $subscription_id_cache = [];

	function up()
	{	
		try 
		{
			\DB::start_transaction();

			// Update all the instagram accounts to new propellers token
			\DB::update('instagram__accounts')
				->value('token', "414143281.e2a9043.6d4acb839c38488f831d826bf29d32fe")
				->execute();

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
		// Cant roll this back as the old token was acquired from instagram..
		\Cli::write('Migrated Down Successfully: ' . __FILE__, 'green');		
	}

}
