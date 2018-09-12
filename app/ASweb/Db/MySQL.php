<?php
namespace ASweb\Db;
	
class MySQL extends Db
{
	private static $instance = null;
	
	protected $mysqli;
		
	private function __construct($server, $login, $pass, $base)
	{
		$this->mysqli = new \mysqli($server, $login, $pass, $base);
		if ($this->mysqli->connect_error) throw new DBException($this->mysqli->connect_error);
	}
				
	public function __destruct()
	{
//			$this->mysqli->close();
	}
		
	public static function getInstance($server = null, $login = null, $pass = null, $base = null){
		if (is_null(self::$instance)) {
			if (is_null($server) || is_null($login) || is_null($pass) || is_null($base)) {
				throw new DBException("Wrong Server, Login, Pass or Base parameters");
			} else {
				self::$instance = new self($server, $login, $pass, $base);
			}
		}
			
		return self::$instance;
	}
		
	/**
	*	Выполняет запрос SQL. !!! Для многострочных запросов используйте mq()
	* @param type $query
	* @return \ASweb\Db\MySQLResult
	* @throws DBException
	*/
	public function q($query)
	{
		$res = $this->mysqli->query($query);
		if ($res == false) throw new DBException($mysqli->error);
		return new MySQLResult($res);
	}

	/**
	 * Ограниченная функция!!! Нельзя использовать для запросов Select
	 * @param type $query
	 * @throws DBException
	 */
	public function mq($query)
	{
		$res = $this->mysqli->multi_query($query);
		if ($res == false) throw new DBException($mysqli->error);
		while ($this->mysqli->next_result())
		{
				
		}
	}

	/**
	 * После Insert получает id вставленного элемента
	 * @return type
	 * @throws DBException
	 */
	public function lastid()
	{
		$ret = $this->mysqli->insert_id;
		if ($ret == false) throw new DBException("No MySQL connection was established<br/>");
		return $ret;
	}

	/**
	 * После Insert получает id вставленного элемента
	 * @return type
	 * @throws DBException
	 */		
	public function getLastid()
	{
		return $this->lastid();
	}
		
	private function __wakeup()
	{
	}
		
	private function __clone()
	{
	}
}
