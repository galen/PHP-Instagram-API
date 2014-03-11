<?php


namespace Fuel\Migrations;

class Subscriptions
{
	function up()
	{
		try 
		{
			\DB::start_transaction();

			\DBUtil::create_table('instagram__subscription', array(
				'id'					=> array('type' => 'int', 'unsigned' => true, 'auto_increment' => true),
				'guid'					=> array('type' => 'tinytext'),
				'alias'					=> array('type' => 'tinytext'),
				'params'				=> array('type' => 'text'),
				'object_id'				=> array('type' => 'tinytext'),
				'instagram_subscription_id' => array('type' => 'int', 'null' => true),
				'status'				=> array('type' => 'enum', 'constraint' => array('Requested', 'Accepted', 'Live', 'Disabled')),
				'last_image_received'	=> array('type' => 'int', 'null' => true),
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

			\DBUtil::drop_table('instagram__subscription');

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
