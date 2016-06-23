<?php

namespace Fuel\Tasks;

class InstagramPoll
{

	public function cleanup()
	{
		$account = \Propeller\Instagram\Model_Account::query()
				->where('active', 1)
				->get_one();

		$instagram = new \Instagram\Instagram;
		$instagram->setAccessToken($account->token);

		$subscriptions = \Propeller\Instagram\Model_Subscription::query()
			->where('status', 'Live')
			->get();

		$image_delete_count = 0;

		foreach($subscriptions as $sub)
		{
			foreach($sub->images as $image)
			{
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $image->main_img);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$output = curl_exec($ch);
				$curl_info = curl_getinfo($ch);
				curl_close($ch);					

				if($curl_info['http_code'] == 404)
				{
					\Cli::error("Image is not accessible, going to delete now...");

					try
					{
						$image->delete();

						// Show what image we've deleted
						// and increment the count.
						\Cli::write("Image {$image->main_img} deleted", "cyan");
						$image_delete_count++;
					}
					catch(\Exception $e)
					{
						// Log the error
						\Log::error($e->getMessage(), __METHOD__);
						\Cli::error("Unable to delete image: " . $e->getMessage());
					}
				}
			}
		}

		// Show the amount
		\Cli::write("{$image_delete_count} images deleted.");
	}

	/**
	 * Get list of recently tagged media
	 *
	 * Use --all option to get all tagged media.
	 *
	 * @param string $tag Tag name
	 */
	public function subscriptions($tag = null)
	{
		$get_all = \Cli::option('all', false);

		$account = \Propeller\Instagram\Model_Account::query()
				->where('active', 1)
				->get_one();

		$instagram = new \Instagram\Instagram;
		$instagram->setAccessToken($account->token);

		$query = \Propeller\Instagram\Model_Subscription::query()
			->where('status', 'Live');
		if ($tag) {
			$query->where('object_id', $tag);
		}

		foreach($query->get() as $sub)
		{
			$tag = $instagram->getTag($sub->object_id);
			$count = 0;
			$params = [
				'max_tag_id' => null,
			];

			do {
				$media = $tag->getMedia($params);
				foreach($media as $med) {
					if (static::add_media($med, $sub)) {
						$count++;
					}
				}

				if ($get_all) {
					$params['max_tag_id'] = $media->getNextMaxTagId();
				}
			} while ($params['max_tag_id']);


			if($count) {
				$sub->last_image_received = time();
				$sub->save();
			}

			\Log::info($count ? $count.' updates for tag: '.$sub->object_id : 'No updates for tag: '.$sub->object_id, __METHOD__);
			\Cli::write($count ? $count.' updates for tag: '.$sub->object_id : 'No updates for tag: '.$sub->object_id, 'green');

		}
	}

	protected static function add_media($med, $sub)
	{
		$image = \Propeller\Instagram\Model_Image::query()
			->where('instagram_id', $med->id)
			->get_one();

		try
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $med->images->standard_resolution->url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
			curl_close($ch);	

			if($content_type == 'application/xml' and $xml = new \SimpleXMLElement($output))
			{
				// Handle access denied error
				if($xml->Code == 'AccessDenied')
				{
					throw new ImageAccessDeindedException("Access denied to '" . $med->images->standard_resolution->url ."' This entry hasn't been saved to the DB.");
				}

				// Thrown an uknown error exception
				throw new UknownInstagramError("Uknown error ({$xml->Code}): {$xml->Message}");
			}

			// Carry on..
			if(!$image) {
				$image = \Propeller\Instagram\Model_Image::forge();
				$image->accepted = 'unsorted';
			}

			$image->thumb_img = $med->images->thumbnail->url;
			$image->main_img = $med->images->standard_resolution->url;
			$image->lowres_img = $med->images->low_resolution->url;
			$image->instagram_id = $med->id;
			$image->author = $med->user->username;
			$image->link = $med->link;
			$image->subscription_id = $sub->id;
			$image->caption = $med->caption ? $med->caption->text : '';
			$image->tags = [];
			$image->likes = $med->getLikesCount();
			$image->posted_at = $med->getCreatedTime();

			//Loop Thorugh Tags and store each one
			foreach($med->tags as $tag)
			{
				//Check Tag Existance
				$tag_model = \Propeller\Instagram\Model_Tag::query()->where('tag_name', $tag)->get_one();
				if ( !$tag_model )
				{
					//Create That Tag if it doesnt already exist
					$tag_model = \Propeller\Instagram\Model_Tag::forge();
					$tag_model->tag_name = $tag;
					$tag_model->save();
				}

				//Save Tags 
				$image->tags[] = $tag_model;

			}

			$image->save();

			return true;

		}
		catch (ImageAccessDeindedException $e)
		{
			\Cli::write("Attempting to delete image", "cyan");

			if($image)
			{
				$obj = \Propeller\Instagram\Model_Image::find($image->id);

				// Delete the image as we no longer have access to it!
				try
				{
					$obj->delete();

					\Cli::write("Image deleted", "green");
				}
				catch(\Exception $e)
				{
					\Log::error(sprintf("Unable to delete image: %s [tag = %s, id = %s]", $e->getMessage(), $sub->object_id, $med->id), __METHOD__);
					\Cli::error("Unable to delete image: " . $e->getMessage());
				}
			}
		}
		catch(\Exception $e)
		{
			// Some other error
			\Log::error(sprintf("%s [tag = %s, id = %s]", $e->getMessage(), $sub->object_id, $med->id), __METHOD__);
			\Cli::error("Unknown error: " . $e->getMessage());
		}
	}

}

class ImageAccessDeindedException extends \Exception {}
class UknownInstagramError extends \Exception {}
