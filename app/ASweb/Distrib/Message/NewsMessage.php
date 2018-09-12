<?php
namespace ASweb\Distrib\Message;

use \ASweb\Distrib\Message;

class NewsMessage extends Message
{
	protected $type = 'News';
	
	public function getCont()
	{
		echo "Error"; die();
//		return $this->params['cont'];
	}
}