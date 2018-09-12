<?php
namespace ASweb\Distrib\Message;

use \ASweb\Distrib\Message;

class ActionMessage extends Message
{
	protected $type = 'Action';
	
	public function getCont()
	{
		echo "Error"; die();
		
//		return $this->params['cont'];
	}
}