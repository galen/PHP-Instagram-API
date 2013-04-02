<?php

namespace Fuel\Tasks;

class InstagramPoll
{

	public function subscriptions()
	{
		$account = \Propeller\Instagram\Model_Account::query()
				->where('active', 1)
				->get_one();

		$instagram = new \Instagram\Instagram;
		$instagram->setAccessToken($account->token);

		$subscriptions = \Propeller\Instagram\Model_Subscription::query()
			->where('status', 'Live')
			->get();

		foreach($subscriptions as $sub) {

			$tag = $instagram->getTag($sub->object_id);
			$media = $tag->getMedia();
			$count = 0;

			foreach($media as $med) {

				$image = \DB::select('instagram_id')
					->from(\Propeller\Instagram\Model_Image::table())
					->where('instagram_id', $med->id)
					->execute()
					->as_array('instagram_id', null);

				if(!$image) {
					$image = \Propeller\Instagram\Model_Image::forge();
					$image->thumb_img = $med->images->thumbnail->url;
					$image->main_img = $med->images->standard_resolution->url;
					$image->instagram_id = $med->id;
					$image->author = $med->user->username;
					$image->link = $med->link;
					$image->accepted = 'unsorted';
					$image->subscription_id = $sub->instagram_subscription_id;

					$image->save();
					$count++;
				}
			}

			if($count) {
				$sub->last_image_received = time();
				$sub->save();
			}

			\Cli::write($count ? $count.' updates for tag: '.$sub->object_id : 'No updates for tag: '.$sub->object_id, 'green');

		}
	}
}