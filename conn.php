<?php
	use ASweb\Db\MySQL;
	use ASweb\Db\DBException;
	
	$db_server	= "localhost";
	$db_login	= "igorz";
	$db_pass	= "95Kp6HNR";
	$db_base	= "proshop";
	$db_prefix	= "proshop_";

	try {
		MySQL::$db_prefix = $db_prefix;
		$db = MySQL::getInstance($db_server, $db_login, $db_pass, $db_base);
		$db->q("set character set utf8");
		$db->q("set names utf8");
	} catch(DBException $e) {
		echo "<font color=red>DBException!</font><br />";
		echo $e->getMessage()."<br />";
		echo "in file: ".$e->getFile()."<br />";
		echo "at line: ".$e->getLine()."<br />";
		echo "Trace: <br />";
		$trace = $e->getTrace(); 
		foreach ($trace as $k => $v) {
			echo "<font color=\"green\">".$k." -> </font>";
			foreach ($v as $kk => $vv) {
				echo $kk." -> ";
				if (is_array($vv)) {
					print_r($vv);
				} else {
					echo $vv;
				}
				echo "<br />";
			}
			echo "<br />";
		}
		echo "<br />";
	}