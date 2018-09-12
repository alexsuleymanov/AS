<?php
namespace ASweb\Distrib\Adaptor;
	
use ASweb\Distrib\Recipient;
use ASweb\Distrib\Message;
	
interface DistribAdaptorInterface
{
	public function send(Recipient $to, Message $message): bool;
}