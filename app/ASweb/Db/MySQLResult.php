<?php
namespace ASweb\Db;
	
class MySQLResult
{
	protected $result;

	public function __construct($res)
	{
		$this->result = $res;
	}

	public function f(): Entity
	{
		$row = $this->fa();
		
		if (empty($row)) {
			return new NullEntity();
		} else {
			$obj = new Entity();
			foreach ($row as $k => $v) {
				$obj->$k = $v;
			}
		}
		return $obj;
	}

	public function fa(): array
	{
		$row = $this->result->fetch_assoc();
		if ($row == false) {
			return [];
		} else {
			foreach($row as $k => $v) $row[$k] = Db::dnq($row[$k]);
		}
		return $row;
	}

	public function num_rows(): int
	{
		$n = $this->result->num_rows;
		return $n;
	}
}