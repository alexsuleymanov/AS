<?php
	namespace ASweb\Distrib\Adaptor;
	
	use ASweb\Distrib\Recipient;
	use ASweb\Distrib\Message;
	use ASweb\Mail\Mail;
	
	class SMS implements DistribAdaptorInterface
	{
		private $from;
		private $to;
		private $message;
		
		public function __construct(Recipient $from, Recipient $to, Message $message)
		{
			$this->from = $from;
			$this->to = $to;
			$this->message = $message;
		}
		
		public function send(): bool
		{
			// В разработке
			return false;
		}

	}