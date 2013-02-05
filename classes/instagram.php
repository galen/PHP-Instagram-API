<?php

namespace Propeller;

class Instagram
{

	public static function forge()
	{
		\Config::load('instagram', true);

		$auth = new \Instagram\Auth(\Config::get('instagram.auth'));

		$auth->authorize();
	}

}
