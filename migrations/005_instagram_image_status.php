<?php


namespace Fuel\Migrations;

class Instagram_Image_Status
{
	function up()
	{
		try 
		{
			\DB::start_transaction();

			\DBUtil::modify_fields('instagram__images', array(
	    		'accepted' => array('type' => 'enum', 'constraint' => array('unsorted', 'accepted', 'declined'))
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

			\DBUtil::modify_fields('instagram__images', array(
	    		'accepted' => array('type' => 'boolean', 'null' => false)
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
