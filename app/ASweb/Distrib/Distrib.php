<?php
namespace ASweb\Distrib;

/**
 * Рассылает по "списку пользователей" "сообщение"
 * 
 * Все выражения в кавычках - это классы!
 * "Список пользователей" - могут быть Клиенты из списка рассылки
 * "Сообщение" - сообщение любого типа
 * "Рассыльщик" - рассыльщик по e-mail базе или sms. Возможно добавить другие виды рассыльщиков
 */
class Distrib{
	private $Subscribe;
	private $DistribStorage;
	private $Mailer;
	private $Message;
	private $recipients = array();
	private $messages_sent = 0;	
	
	public function __construct(Subscribe $SubscribeList, Message $Message, Mailer $Mailer, $DistribStorage = null) {
		$this->Subscribe = $SubscribeList;
		$this->Message = $Message;
		$this->Mailer = $Mailer;
		$this->DistribStorage = $DistribStorage;
		
		$this->recipients = $this->Subscribe->getRecipients();
	}
		
	public function start(int $start = 0){
		$this->messages_sent = $this->Mailer->sendMassages($this->Message, $this->recipients, $start);
		$this->save();
	}
		
	public function save(){
		if (!is_null($this->DistribStorage)) {
			$this->DistribStorage->insert(array(
				"tstamp" => time(),
				"type" => $this->Message->getType(),
				"subj" => $this->Message->getSubject(),
				"cont" => $this->Message->getBody(),
				"db" => $this->Subscribe->getDb(),
				"sentto" => $this->messages_sent,		
			));
		}
	}
		
	public function load(int $id){
		if (!is_null($this->DistribStorage)) {
			$distrib = $this->DistribStorage->get($id);
		}
		return $distrib;
	}
}