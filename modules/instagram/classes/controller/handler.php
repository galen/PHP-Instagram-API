<?php

namespace Instagram;

class Controller_Handler extends \Controller
{
	public function action_subscribe()
	{

		\Config::load('instagram', true);
		$auth = new \Instagram\Auth( \Config::get('instagram.auth') );

		if($challenge = \Input::get('hub_challenge')) {
			return \Response::forge($challenge, 200);
		} elseif($code = \Input::get('code')) {

			$token = $auth->getAccessToken($code);
			$instagram = new \Instagram\Instagram;
			$instagram->setAccessToken($token);
			$current_user = $instagram->getCurrentUser();

			$acct = \Propeller\Instagram\Model_Account::forge();
			$acct->token = $token;
			$acct->instagram_id = $current_user->id;
			$acct->username = $current_user->username;
			$acct->active = 1;
			$acct->save();

			\Response::redirect('/admin/instagram/manage/index');

		} else {
			// Read in the change statuses.
			$raw = file_get_contents('php://input');
			$changed = json_decode($raw);
			$account = \Propeller\Instagram\Model_Account::query()
				->where('active', 1)
				->get_one();

			$instagram = new \Instagram\Instagram;
			$instagram->setAccessToken($account->token);

			foreach($changed as $change) {
				$sub = \Propeller\Instagram\Model_Subscription::query()
					->where('object_id', $change->object_id)
					->get_one();

				$tag = $instagram->getTag($change->object_id);
				$media = $tag->getMedia();
				foreach($media as $med) {
					$image = \Propeller\Instagram\Model_Image::query()
						->where('instagram_id', $med->id)
						->get_one();

					if(!$image) {
						$image = \Propeller\Instagram\Model_Image::forge();
						$image->thumb_img = $med->images->thumbnail->url;
						$image->main_img = $med->images->standard_resolution->url;
						$image->instagram_id = $med->id;
						$image->author = $med->user->username;
						$image->link = $med->link;
						$image->active = 0;

						$image->save();
					}
				}

			}

		}
	}
}
