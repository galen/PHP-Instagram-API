<?php

namespace Instagram;

class Controller_Handler extends \Controller
{
	public function action_subscribe()
	{

		if($challenge = \Input::get('hub.challenge')) {
			return \Response::forge($challenge, 200);
		}
	}
}
