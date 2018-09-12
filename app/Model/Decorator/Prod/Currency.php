<?php
use ASweb\Db\Entity;

class Model_Decorator_Prod_Currency extends Model_Decorator_Abstract
{
	private $course_usd;
	private $course_eur;
				
	public function __construct(float $course_usd, float $course_eur)
	{
		$this->course_usd = $course_usd;
		$this->course_eur = $course_eur;
	}
	
	public function get(Entity $row): Entity
	{
		if(!defined("ASWEB_ADMIN") && $row->price == 0 && $row->price_usd != 0) {
			$row->price = $row->price_usd * $this->course_usd;
		}
		
		if(!defined("ASWEB_ADMIN") && $row->price == 0 && $row->price_eur != 0) {
			$row->price = $row->price_eur * $this->course_eur;
		}

		return $row;
	}

	public function getall(array $rows): array
	{
		foreach ($rows as $k => $v) {
			if(!defined("ASWEB_ADMIN") && $v->price == 0 && $v->price_usd != 0) {
				$rows[$k]->price = $v->price_usd * $this->course_usd;
			}
			
			if(!defined("ASWEB_ADMIN") && $v->price == 0 && $v->price_eur != 0) {
				$rows[$k]->price = $v->price_eur * $this->course_eur;
			}
		}
		return $rows;
	}
}