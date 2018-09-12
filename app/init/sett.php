<?php
	$sett = array();

	if (!$sett = $Cache->load("sett".$lang)){
		$obj = new Model_Sett();
		$sett_array = $obj->getall();

		foreach ($sett_array as $k => $v) {
			$sett[$v->intname] = $v->value;
		}

		$Cache->save($sett, "sett".$lang, array("model_sett"));
	}
