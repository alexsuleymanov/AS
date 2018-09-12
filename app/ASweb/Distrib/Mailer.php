<?php
namespace ASweb\Distrib;

use ASweb\Distrib\Adaptor\DistribAdaptorInterface;
	
class Mailer
{
	private $Adaptor;
		
	public function __construct(DistribAdaptorInterface $Adaptor)
	{
		$this->Adaptor = $Adaptor;
	}
		
	/**
	 * Рассылает сообщения по базе. 
	 * Аргументы - массив объектов Recipient
	 * 
	 * Аргумент $start используется, если рассылка начинается не с начала базы
	 * Возвращает количество разосланных сообщений
	 * 
	 */
	public function sendMassages(Message $Message, array $recipients, $start = 0): int
	{
		foreach ($recipients as $k => $recipient) {
			if ($k < $start) {
				continue;
			}
			
			$this->Adaptor->send($recipient, $Message);
		}
			
		return $k+1;
	}
}