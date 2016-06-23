<?php

return array(
	'auth' => array(
		'client_id'     => 'e2a904382e2448958d984cffa5554956',
		'client_secret' => 'c080c821eef54f94844f0679ff77538f',
		'redirect_uri'  => \Uri::create('instagram/handler/subscribe'),
		'scope'         => array('basic', 'public_content'),
		'display'       => ''
	),

	/**
	 * Change the place for the defaul nav to be placed.
	 */
	'nav' => 'Your CMS'

);
