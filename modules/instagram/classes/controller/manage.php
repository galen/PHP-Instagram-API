<?php

namespace Instagram;

class Controller_Manage extends \Admin\Controller_Template
{

	public function before()
	{
		parent::before();
		\Config::load('instagram', true);
	}

	public function action_approval($id)
	{
		$sub = \Propeller\Instagram\Model_Subscription::query()
			->where('instagram_subscription_id', $id)
			->get_one();

		$sub->last_managed = time();
		$sub->save();

		$image_counts = \DB::select(\DB::expr('COUNT(id) as image_count, accepted'))
			->from('instagram__images')
			->where('subscription_id', $id)
			->order_by('created_at', 'desc')
			->group_by('accepted')
			->limit(42)
			->execute()
			->as_array('accepted', 'image_count');

		$unsorted_images = \DB::select()
			->from('instagram__images')
			->where('subscription_id', $id)
			->where('accepted', 'unsorted')
			->order_by('created_at', 'desc')
			->limit(42)
			->execute()
			->as_array();

		$accepted_images = \DB::select()
			->from('instagram__images')
			->where('subscription_id', $id)
			->where('accepted', 'accepted')
			->order_by('created_at', 'desc')
			->limit(42)
			->execute()
			->as_array();

		$declined_images = \DB::select()
			->from('instagram__images')
			->where('subscription_id', $id)
			->where('accepted', 'declined')
			->order_by('created_at', 'desc')
			->limit(42)
			->execute()
			->as_array();


		$view = \View::forge('approval');
		$view->set('unsorted_images', $unsorted_images);
		$view->set('accepted_images', $accepted_images);
		$view->set('declined_images', $declined_images);
		$view->set('image_counts', $image_counts);
		$view->set('subscription_id', $id);

		$this->template->title = 'Approve Images - '.$sub->alias;
		$this->template->content = $view;


	}

	public function action_unsubscribe($id)
	{
		$cancel = \Propeller\Instagram\Subscription::cancel($id);
		\Session::set_flash('success', 'This subscription has been closed.');
		$sub = \Propeller\Instagram\Model_Subscription::query()
			->where('instagram_subscription_id', $id)
			->get_one();

		$sub->status = 'Disabled';
		$sub->save();

		\Response::redirect('/admin/instagram/manage/index');
	}

	public function action_index()
	{
		$account = \Propeller\Instagram\Model_Account::query()
			->where('active', 1)
			->get_one();

		if (!$account) {
			\Response::redirect('admin/instagram/manage/authenticate');
		}

		$view = \View::forge('manage');
		$view->set('fieldset', \Propeller\Instagram\Subscription::fieldset(), false);
		$subscriptions = \Propeller\Instagram\Subscription::get();
		$prop_sub = \Propeller\Instagram\Model_Subscription::find('all');
		$merged = array();

		if($prop_sub) {
			foreach($prop_sub as $subscription) {
				$merged[$subscription->object_id] = $subscription;
			}

			foreach($subscriptions as $subscription) {
				$key = str_replace('#', '', $subscription->object_id);
				if(isset($merged[$key])) {
					$merged[$key]->instagram = $subscription;
				}
			}
		}

		if(\Input::post()) {
			try {
				 \Propeller\Instagram\Subscription::forge(
					 \Input::post('name'),
					 array(
						 'object_id' => \Input::post('tag'),
						 'aspect' => 'media',
						 'object' => 'tag',
					 )
				 );
			} catch (\Exception $e) {
				if (in_array(\Fuel::$env, [\Fuel::PRODUCTION, \Fuel::STAGING, \Fuel::TEST])) {
					\Session::set_flash('error', '');
				} else {
					\Session::set_flash('error', 'Instagram integration can not be used on development.');
				}
			}
		}

		$view->set('subscriptions', $merged);


		$this->template->title = 'Instagram';
		$this->template->content = $view;
	}

	public function action_authenticate()
	{
		$auth_config = \Config::get('instagram.auth');
		$view = \View::forge('authenticate');

		// Check we have the configs we need
		if ( !$auth_config['client_id'] || !$auth_config['redirect_uri'] ) {
			$view->set('error', 'Please make sure Instagram configuration is filled in correctly');
		}
		// If they have clicked the "authenticate" button
		elseif ( \Input::get('go') !== null ) {
			$auth = new \Instagram\Auth($auth_config);
			$auth->authorize();
		}

		
		$this->template->title = 'Authenticate Instagram';
		$this->template->content = $view;
	}

	public function action_authenticate_success()
	{
		// check we have an account
		$account = \Propeller\Instagram\Model_Account::query()
			->where('active', 1)
			->get_one();

		if (!$account) {
			\Response::redirect('admin/instagram/manage/authenticate');
		}

		$view = \View::forge('authenticate_success');
		$this->template->title = 'Authorize Instagram - Success';
		$this->template->content = $view;
	}
}
