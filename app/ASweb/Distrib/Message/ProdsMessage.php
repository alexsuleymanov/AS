<?php
namespace ASweb\Distrib\Message;

use \ASweb\Distrib\Message;

class ProdsMessage extends Message
{
	protected $type = 'Prods';
	
	public function getCont()
	{
		echo "Error"; die();
//		return $this->params['cont'];
	}
}