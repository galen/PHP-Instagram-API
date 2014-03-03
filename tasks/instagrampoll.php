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
				$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
				curl_close($ch);					
				
				if($content_type == 'application/xml' and $xml = new \SimpleXMLElement($output))
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
						\Log::error($e->getMessage());						
						\Cli::error("Unable to delete image: " . $e->getMessage());
					}
				}		
			}
		}
		
		// Show the amount 
		\Cli::write("{$image_delete_count} images deleted.");		
	}

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
							throw new ImageAccessDeindedException("Access denied to 'http://distilleryimage0.s3.amazonaws.com/47040426c57211e2880f22000a1f9ca7_5.jpg'. This entry hasn't been saved to the DB.");
						}
						
						// Thrown an uknown error exception
						throw new UknownInstagramError("Uknown error ({$xml->Code}): {$xml->Message}");
					}												
					
					// Carry on..
					if(!$image) {
						$image = \Propeller\Instagram\Model_Image::forge();
						$image->thumb_img = $med->images->thumbnail->url;
						$image->main_img = $med->images->standard_resolution->url;
						$image->instagram_id = $med->id;
						$image->author = $med->user->username;
						$image->link = $med->link;
						$image->accepted = 'unsorted';
						$image->subscription_id = $sub->instagram_subscription_id;
						$image->caption = $med->caption->text;
						$image->tags = serialize($med->tags);

						$image->save();
						$count++;
					}				
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
							\Cli::error("Unable to delete image: " . $e->getMessage());
						}
					}				
				}
				catch(\Exception $e)
				{
					// Some other error
					\Log::error($e->getMessage()); 	
					
					\Cli::error("Uknown error: " . $e->getMessage());
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

class ImageAccessDeindedException extends \Exception {}
class UknownInstagramError extends \Exception {}