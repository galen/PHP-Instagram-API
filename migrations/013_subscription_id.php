<?php


namespace Fuel\Migrations;

class Subscription_Id
{
	protected $subscription_id_cache = [];

	function up()
	{	
		try 
		{
			\DB::start_transaction();

			// Get all the images and their current subscription ID
			$images = \DB::select('id', 'subscription_id')
				->from('instagram__images')
				->execute()
				->as_array('id', 'subscription_id');

			foreach ($images as $image_id => $image_subscription_id) {
				// Find the subscription it relates to, using cache if found
				$new_subscription_id = false;
				if (isset($this->subscription_id_cache[$image_subscription_id])) {
					$new_subscription_id = $this->subscription_id_cache[$image_subscription_id];
				}

				if (!$new_subscription_id) {
					$new_subscription_id = \DB::select('id')
						->from('instagram__subscription')
						->where('instagram_subscription_id', $image_subscription_id)
						->execute()
						->get('id');
				}

				if ($new_subscription_id) {
					\DB::update('instagram__images')
						->value('subscription_id', $new_subscription_id)
						->where('id', '=', $image_id)
						->execute();
				}
			}

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

			// Get all the images and their current subscription ID
			$images = \DB::select('id', 'subscription_id')
				->from('instagram__images')
				->execute()
				->as_array('id', 'subscription_id');

			foreach ($images as $image_id => $image_subscription_id) {
				// Find the subscription it relates to, using cache if found
				$new_subscription_id = false;
				if (isset($this->subscription_id_cache[$image_subscription_id])) {
					$new_subscription_id = $this->subscription_id_cache[$image_subscription_id];
				}

				if (!$new_subscription_id) {
					$new_subscription_id = \DB::select('instagram_subscription_id')
						->from('instagram__subscription')
						->where('id', $image_subscription_id)
						->execute()
						->get('instagram_subscription_id');
				}

				if ($new_subscription_id) {
					\DB::update('instagram__images')
						->value('subscription_id', $new_subscription_id)
						->where('id', '=', $image_id)
						->execute();
				}
			}

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
