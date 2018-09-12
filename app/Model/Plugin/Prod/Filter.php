<?php

class Model_Plugin_Prod_Filter extends Model_Plugin_Abstract
{
	public static function filter(int $cat = 0) {
		$Cat = new Model_Cat();
		$brands = array();

		$minprice = (floatval($_GET[minprice])) ? floatval($_GET[minprice]) : 0;
		$maxprice = (floatval($_GET[maxprice])) ? floatval($_GET[maxprice]) : 1000000000;

		foreach ($_GET as $k => $v) {	// Производители
			if(preg_match("/^brand(\d+)/", $k, $m))
				$brands[] = $m[1];
		}

		$Char = new Model_Char();
		$chars = $Char->getall(array("where" => "`search` = 1 and ".$Cat->cat_tree($cat)));

		$ids = array();
		$ids2 = array();
		$ch = array();
		$chars_filled = 0;

		$Prod = new Model_Prod();

		$cond = array("select" => "id", "where" => $Cat->cat_tree($cat));
		if($minprice < $maxprice){
			$cond["where"] .= " and price >= $minprice and price <= $maxprice";
		}

		if(count($brands)){
			$cond["where"] .= " and (brand = ".implode(" or brand = ", $brands).")";
		}
		$prods = $Prod->getall($cond);

		foreach($prods as $prod){
			$ch[] = $prod;
			$ids = array_unique(array_merge($ids, array($prod->id)));
		}

		$condpc = array("where" => "(");
		foreach($chars as $kc => $c){
			if($kc) $condpc["where"] .= " or ";
			$condpc["where"] .= "`char` = ".$c->id;
		}
		$condpc["where"] .= ")";

		$Prodchar = new Model_Prodchar();
		$prodchars = $Prodchar->getall($condpc);

		$chars_filled = 0;
		foreach($chars as $k => $char){
			foreach($prodchars as $kk => $pc){
				if($char->type == 1 && $_GET["char".$char->id] && $char->id == $pc->char && $pc->value != $_GET["char".$char->id]){									//Характеристики есть/нет
					$ids = array_diff($ids, array($pc->prod));
				}elseif($char->type == 2 && ($_GET["char".$char->id."from"] || $_GET["char".$char->id."to"]) && $char->id == $pc->char){							//Характеристика от/до
					if($_GET["char".$char->id."from"] && $pc->value < $_GET["char".$char->id."from"]){
						$ids = array_diff($ids, array($pc->prod));
					}
					if($_GET["char".$char->id."to"] && $pc->value > $_GET["char".$char->id."to"]){
						$ids = array_diff($ids, array($pc->prod));
					}
				}elseif($char->type == 4 && is_array($_GET["char".$char->id]) && $char->id == $pc->char && !in_array($pc->charval, $_GET["char".$char->id])){		//Значения характеристик
					$ids = array_diff($ids, array($pc->prod));
				}
				
				if($char->type == 4 && $char->id == $pc->char){
					$ids2[$pc->prod] += 1;
				}
			}
			if($char->type == 4) $chars_filled++;
		}

		foreach($ids2 as $k => $v){
			if($v < $chars_filled) $ids = array_diff($ids, array($k));
		}

		$filter_q = "(";
            
		if(empty($ids)){
			$filter_q .= " id = '0'";
		}else{
			foreach($ids as $v){
				if($i2++) $filter_q .= " or id = $v";
				else $filter_q .= " id = $v";
			}
		}

		$filter_q .= ")";
		return $filter_q;
	}
}