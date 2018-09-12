<?php
	$templates = array();

	if (!$templates = $Cache->load("template".$lang)) {
		$obj = new Model_Template();
		$templates_array = $obj->getall();

		foreach($templates_array as $k => $v) {
			$templates[$v->intname] = $v->cont;
		}

		$Cache->save($templates, "template".$lang, array("model_template"));
	}
