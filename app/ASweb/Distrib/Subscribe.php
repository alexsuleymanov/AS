<?php
namespace ASweb\Distrib;

use ASweb\Db\Db;
use ASweb\Distrib\Exception\SubscriberExists;

class Subscribe
{
	private $Storage;
	private $db;
	private $address_type;
	
	const EMAIL = 'email';
	const PHONE = 'phone';
	const ADDRESS = 'addr';
	
	/**
	 * 
	 * @param \Model_ModelInterface $Storage Модель Subscribe
	 * @param string $address_type Использует внутренние константы: EMAIL, PHONE
	 * @param string $db_name По какой базе будет весьтись рассылка
	 */
	public function __construct(\Model_ModelInterface $Storage, string $address_type, string $db_name)
	{
		$this->Storage = $Storage;
		$this->db = $db_name;
		$this->address_type = $address_type;
	}
	
	public function getRecipients(): array
	{
		$recipients_array = [];
			
		$subs = $this->Storage->getall(array("where" => "visible = 1 and db = '".$this->db."'", "order" => "id"));
		
		foreach ($subs as $v) {
			$recipients_array[] = new Recipient($v->type, $v->addr, $v->name);
		}
		
		return $recipients_array;
	}
	
	public function addSubscriber(string $db, string $name, string $addr)
	{
		if ($this->subscriberExists($db, $addr)) {
			throw new SubscriberExists("User already in Subscribe Database");
		}
		
		$this->Storage->insert([
			"db" => $db,
			"type" => $this->address_type,
			"name" => $name,
			"addr" => $addr,
			"tstamp" => time(),
			"visible" => 1,
		]);
	}
	
	public function deleteSubscriber(string $db, string $addr)
	{
		$this->Storage->delete(array("where" => "`db` = '".Db::nq($db)."' and addr = '".Db::nq($db)."'"));
	}
	
	public function subscriberExists(string $db, string $addr)
	{
		if ($this->Storage->getnum(array("where" => "db = '".Db::nq($db)."' and `".$this->address_type."` = '".Db::nq($addr)."'"))) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getDb(): string
	{
		return $this->db;
	}
	
	public function export(string $filename, SubscribeExport $exporter = null)
	{
		if (is_null($exporter)) {
			
		} else {
			
		}
	}
	
	public function importFromCsv(string $filename, SubscribeExport $importer = null)
	{
		if (is_null($importer)) {
			
		} else {
			$arr = $importer->import($filename);
		}
		
	}
}