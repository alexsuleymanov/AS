<?php
	use ASweb\Url\Url;
	use ASweb\Db\DBException;
	
	$args = array();
	
	try{
		require_once("incl.php");

		if (!defined("MULTY_LANG")) {
			$url = new Url();
			$args = $url->parce();
		}

		require_once("incl2.php");
		
		if (($k = count($args)) > 1) {
//			while($page->id == null && $k > 0){ //Так было раньше. Теперь все служебные файлы в system-scripts.php
			$_pagename = '';
			for ($i = 0; $i < $k; $i++) {
				if ($i) {
					$_pagename .= "/";
				}
				$_pagename .= $args[$i];
			}
			$page = $Page->getbyname($_pagename);
//				$k--;
//			}
		} else {
			$_pagename = ($args[0]) ? $args[0] : '';
			$page = $Page->getbyname($_pagename);
		}

		if (!empty($args) && !in_array($args[0].".php", $minimal_scripts)) {
			require_once "app/init/view.php";
		}

		if (empty($page)) {
			if (file_exists("app/controller/".$args[0].".php") && in_array($args[0].".php", $system_scripts)) {
				include("app/controller/".$args[0].".php");
			} else {
				include("app/controller/404.php"); 
			}
			die();
		}

		if ($page->href) {
			include("app/controller/".$page->href);
			die();
		} else {
			include("app/controller/page.php");
			die();
		}
	} catch(Zend_Exception $e) {
		echo "<font color=red>Zend Exception!</font><br />";
		echo $e->getMessage()."<br />";
		echo "in file: ".$e->getFile()."<br />";
		echo "at line: ".$e->getLine()."<br />";
		echo "<br />";
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
	} catch(Exception $e) {
		echo "<font color=red>Exception!</font><br />";
		echo $e->getMessage()."<br />";
		echo "in file: ".$e->getFile()."<br />";
		echo "at line: ".$e->getLine()."<br />";
		echo "<br />";
	}
