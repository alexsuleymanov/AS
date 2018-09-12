<?php
namespace ASweb\Db;
	
abstract class Db
{
	abstract function q($query);
	abstract function lastid();
		
	public static $db_prefix;

	public static function dnq($str)
	{
		return stripslashes($str);
	}

	public static function nq($data)
	{
		$data = str_replace("\\", "\\\\", $data);
		$data = str_replace("'", "\'", $data);
		$data = str_replace('"', '\"', $data);
		$data = str_replace("\x00", "\\x00", $data);
		$data = str_replace("\x1a", "\\x1a", $data);
		$data = str_replace("\r", "\\r", $data);
		$data = str_replace("\n", "\\n", $data);
		return($data); 
	}
}