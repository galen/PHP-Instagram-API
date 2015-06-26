<?php

namespace Instagram;

class Controller_Ajax extends \Admin\Controller_Rest
{
	public function post_more() {

		$images = \Propeller\Instagram\Model_Image::query()
			->where('subscription_id', \Input::post('subscription'))
			->where('accepted', \Input::post('status'))
			->order_by('created_at', 'desc')
			->offset(\Input::post('offset'))
			->limit(42)
			->get();

		return $this->response(array(
			'images' => $images,
		));

	}

	public function get_subscriptions()
	{
		return $this->response(array(
			'subscriptions' => \Propeller\Instagram\Subscription::get()
		));
	}

	public function post_status()
	{
		$image = \Propeller\Instagram\Model_Image::find(\Input::post('image'));

		$image->accepted = \Input::post('status');
		$image->save();

		return $this->response(array(
			'status' => 1,
		));
	}
}
