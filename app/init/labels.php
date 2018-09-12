<?php
	$labels = array();

	if (!$labels = $Cache->load("labels".$lang)) {
		$obj = new Model_Labels();
		$labels_array = $obj->getall();

		foreach ($labels_array as $k => $v) {
			$labels[$v->intname] = $v->value;
		}

		$Cache->save($labels, "labels".$lang, array("model_labels"));
	}