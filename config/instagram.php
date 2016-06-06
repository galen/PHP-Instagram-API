<?php

return array(
	'auth' => array(
		'client_id'     => '8d316ba637af488b91ad01e2b2ac41ea',
		'client_secret' => '97ba5bfd2d2743aab12f5e16f3368fd1',
		'redirect_uri'  => \Uri::create('instagram/handler/subscribe'),
		'scope'         => array('basic', 'public_content'),
		'display'       => ''
	),

	/**
	 * Change the place for the defaul nav to be placed.
	 */
	'nav' => 'Your CMS'

);
