<?php
	use ASweb\Url\Url;
	
	if(!defined('ASWEB_ADMIN') && !in_array(implode("/", $args), $one_lang_scripts)){
		$region_match = 0;
		$url = new Url();
		$args = $url->parce();

		$Region = new Model_Region();
		$regions = $Region->getall();

		foreach($regions as $k => $v){
			if($v->main){
				$default_region_intname = $v->intname;
				$default_region_id = $v->id;
			}
		}

		$region_intname = $default_region_intname;
		$region_id = $default_region_id;

		foreach($regions as $k => $v){
			if($args[0] == $v->intname){
				$region_intname = $v->intname;
				$region_id = $v->id;
				$region_currency = $v->currency;
				array_shift($args);
				$region_match = 1;
				break;
			}
		}

		$url->args = $args;

		if($region_currency){
			$Currency = new Model_Currency($region_currency);
			$currency = $Currency->get($region_currency);
		}

		Zend_Registry::set('region_id', $region_id);
		Zend_Registry::set('region_intname', $region_intname);
		Zend_Registry::set('currency_name', $currency->name);
		Zend_Registry::set('currency_course', $currency->course);
	}
