<?php
namespace ASweb\Distrib\Adaptor;
	
use ASweb\Distrib\Recipient;
use ASweb\Distrib\Message;
use ASweb\Mail\Mail;
	
class Email implements DistribAdaptorInterface
{
	private $from;
	private $to;
	private $message;
		
	public function __construct(Recipient $from)
	{
		$this->from = $from;
		$this->to = $to;
		$this->message = $message;
	}
		
	public function send(Recipient $to, Message $message): bool
	{			
		return Mail::mailhtml($this->from->getName(), $this->from->getAddress(), $to->getAddress(), $message->getSubject, $message->getMessage, $message->getFiles());
	}
}