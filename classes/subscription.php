<?php

/**
 * Propeller Instagram
 * @author Paul Westerdale <paul@propcom.co.uk>
 */

namespace Propeller\Instagram;

/**
 * This operates outside of the grounds of the usual Instagram API as it does
 * not require user credentials or auth to create.
 * This is solely created by the Application itself and managed on a per APP basis.
 */

class Subscription
{

	public static function forge($alias, $params)
	{
		\Config::load('instagram', true);
		$config = \Config::get('instagram.auth');
		$guid = uniqid();

		$sub = \Propeller\Instagram\Model_Subscription::query()
			->where('object_id', $params['object_id'])
			->get_one();

		if(!$sub) {
			$sub = \Propeller\Instagram\Model_Subscription::forge();
		}

		$sub->guid = $guid;
		$sub->params = json_encode($params);
		$sub->alias = $alias;
		$sub->status = 'Requested';
		$sub->object_id = $params['object_id'];
		$sub->save();

		$params = array_merge($params, array(
				'verify_token' => $guid,
				'callback_url' => 'http://swtest.l2.prop.cm/instagram/handler/subscribe',
				'client_id' => $config['client_id'],
				'client_secret' => $config['client_secret']
			));

		$curl = new \Instagram\Net\CurlClient();
		$result = $curl->post('https://api.instagram.com/v1/subscriptions/', $params);
		$response = json_decode($result);
		$sub->instagram_subscription_id = $response['id'];
		$sub->status = 'Live';
		$sub->save();

		die();
	}

	public static function cancel($id)
	{
		\Config::load('instagram', true);
		$config = \Config::get('instagram.auth');

		$params = array(
			'client_secret' => $config['client_secret'],
			'client_id' => $config['client_id'],
			'id' => $id
		);
		$curl = new \Instagram\Net\CurlClient();
		$result = $curl->delete('https://api.instagram.com/v1/subscriptions/', $params);

		return $result;
	}

	public static function get()
	{
		\Config::load('instagram', true);
		$config = \Config::get('instagram.auth');

		$params = array(
			'client_secret' => $config['client_secret'],
			'client_id' => $config['client_id'],
		);
		$curl = new \Instagram\Net\CurlClient();
		$result = $curl->get('https://api.instagram.com/v1/subscriptions/', $params);
		$data = json_decode($result);
		return $data->data;

	}

}
