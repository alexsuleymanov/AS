<?php
	$blocks = array();

	if (!$blocks = $Cache->load("block".$lang)) {
		$obj = new Model_Block();
		$blocks_array = $obj->getall();

		foreach ($blocks_array as $k => $v) {
			$blocks[$v->intname] = $v->value;
		}
		
		$Cache->save($blocks, "block".$lang, array("model_block"));
	}
