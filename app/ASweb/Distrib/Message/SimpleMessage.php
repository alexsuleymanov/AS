<?php
namespace ASweb\Distrib\Message;

use \ASweb\Distrib\Message;

class SimpleMessage extends Message
{
	protected $type = 'Simple';
	
	public function getCont()
	{
		return $this->params['cont'];
	}
}