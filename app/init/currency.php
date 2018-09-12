<?php
/*	$valutas = array();

	if((!Zend_Registry::isRegistered('cur_name') && !$_SESSION['currency']) || $_GET['currency'] || (!$valutas = $cache->load("valutas".$lang))){
		$obj = new Model_Currency();
		$valutas_array = $obj->getall(array("where" => "visible = 1", "order" => "`main` desc"));

		foreach($valutas_array as $k => $v){
			if($v->main && !$_SESSION["currency"]) $_SESSION["currency"] = array("id" => $v->id, "name" => $v->name, "short" => $v->short, "course" => $v->course);
			$valutas[$v->id] = array("id" => $v->id, "name" => $v->name, "short" => $v->short, "course" => $v->course, "main" => $v->main);
		}

		$cache->save($valutas, "currency".$lang, array("model_currency"));

		if($_GET['currency']){
			$url = new AS_URLParser($_SERVER[REQUEST_URI], $_SERVER[QUERY_STRING]);
			$_SESSION['valuta'] = $valutas[$_GET['valuta']];
			$url->redir($url->gvar("valuta="));
		}

	}*/

//	$Currency = new Model_Currency($region_currency);
//	$currency = $Currency->get($region_currency);

	Zend_Registry::set('cur_name', $sett['valuta']);
	Zend_Registry::set('currency_name', $sett['valuta']);
	Zend_Registry::set('cur_course', 1);
	Zend_Registry::set('currency_course', 1);
