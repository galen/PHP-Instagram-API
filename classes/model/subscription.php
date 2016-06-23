<?php

namespace Propeller\Instagram;


class Model_Subscription extends \Orm\Model
{

	protected static $_table_name = 'instagram__subscription';

	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'label' => 'ID',
		),
		'guid' => array(
			'type' => 'varchar',
			'label' => 'Verify Token'
		),
		'alias' => array(
			'type' => 'varchar',
			'label' => 'Subscription Alias'
		),
		'params' => array(
			'type' => 'text',
			'label' => 'Parameters',
		),
		'object_id' => array(
			'type' => 'varchar',
			'label' => 'Subscribed To:'
		),
		'instagram_subscription_id' => array(
			'type' => 'int',
			'label' => 'Instagram Subscription Id'
		),
		'status' => array(
			'type' => 'enum',
			'label' => 'Status',
		),
		'last_image_received' => array(
			'type' => 'int',
			'label' => 'Last Image Received At',
		),
		'last_managed' => array(
			'type' => 'int',
			'label' => 'Last Managed',
		),
		'created_at' => array(
			'type' => 'int',
			'label' => 'Created',
		),
		'updated_at' => array(
			'type' => 'int',
			'label' => 'Updated',
		),
	);

	public function latest_images($count)
	{
		return \Propeller\Instagram\Model_Image::query()
			->where('subscription_id', $this->instagram_subscription_id)
			->order_by('created_at')
			->limit($count)
			->get();
	}
	
	public function preview_images($limit)
	{
		return \Propeller\Instagram\Model_Image::query()
			->where('subscription_id', $this->instagram_subscription_id)
			->where('accepted', 'unsorted')
			->order_by('created_at', 'desc')
			->limit($limit)
			->get();
	}

	public function random_images($count)
	{
		$images = array();
		if(count($this->images) <= $count) {
			return $this->images;
		}
		for($i = 1; $i <= $count; $i++) {
			$images[] = $this->images[array_rand($this->images)];
		}

		return $images;
	}

	protected static $_has_many = array(
		'images' => array(
			'key_from' => 'id',
			'model_to' => '\Propeller\Instagram\Model_Image',
			'key_to' => 'subscription_id',
			'cascade_save' => true,
			'cascade_delete' => false,
		)
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
		),
	);

}
