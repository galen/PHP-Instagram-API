<?php

\Package::load('admin');
\Module::load('admin');

$count = \DB::select(\DB::expr('COUNT(*) as count'))
	->from('instagram__subscription')
	->where('last_image_received', '>', \DB::expr('last_managed'))
	->or_where('last_managed', null)
	->execute()
	->get('count');

$nav_title = $count > 0 ? 'Instagram <span class="badge badge-important">' . $count . '</span>' : 'Instagram';

\PropNav\Menu::instance('admin')->add_item(
	\PropNav\Item::forge("Your CMS.{$nav_title}", '', 100)
		->add_item(\PropNav\Item::forge('Manage', '/admin/instagram/manage/index'), 1)
);


$roles = array(
	'manage_instagram' => array(
		'Instagram\Controller_Ajax' => true,
		'Instagram\Controller_Handler' => true,
		'Instagram\Controller_Manage' => true
	)
);

\Auth::acl()->add($roles);
