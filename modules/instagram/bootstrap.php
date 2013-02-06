<?php

\Package::load('admin');
\Module::load('admin');

\PropNav\Menu::instance('admin')->add_item(
	\PropNav\Item::forge('Instagram', '', 100)
		->add_item(\PropNav\Item::forge('Manage', '/admin/instagram/manage/index'), 1)
		->add_item(\PropNav\Item::forge('Image Feed', '/admin/instagram/manage/images'), 2)
);
