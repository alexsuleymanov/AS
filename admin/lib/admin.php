<?php
use ASweb\Db\Db;
use ASweb\Db\Entity;
use ASweb\StdLib\Func;
	
$action = ($_GET['action']) ? $_GET['action'] : 'show';
$id = 0 + $_GET['id'];
$start = 0 + $_GET['start'];
$results = $results ? $results : 500;
$default_order_desc_asc = $default_order_desc_asc ? $default_order_desc_asc : "desc";

if (defined('MULTY_LANG')) {
	$lang = ($_GET['lang']) ? $_GET['lang'] : $default_lang;
	$lang_id = ($_GET['lang']) ? $langs[$_GET['lang']]['id'] : $default_lang_id;

	Zend_Registry::set('lang', $lang);
	$view->langs = $langs;
	$view->lang = $lang;
	$view->lang_id = $lang_id;
	$view->default_lang = $default_lang;
	$view->default_lang_id = $default_lang_id;
	$view->onelang = ($onelang == 1) ? 1 : 0;
}		
	
try {
	if ($action == 'del') {
		$Model = new $model();
		$Plugins->ondel($id);
		ondel($id);
		$Model->destroy($id, $path);
		
		$Cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array(strtolower($model)));
		
		$time_stop = microtime();
		$script_time = $time_stop - $time_start;
		header("Location: ".$url->page.$url->gvar("action=&id="));
	} elseif($action == 'setajax') {
		$Model = new $model();
		$data = array();
		$data[$_GET['field']] = $_GET['fieldvalue'];

		$Model->update($data, array("where" => "id = '".Db::nq($_GET['id'])."'"));
		$Cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array(strtolower($model)));
	} elseif($action == 'set' || $action == 'setlang') {
		$Model = new $model();
		$data = array();
		$translate_data = array();

		$a = $_POST;
		
		foreach ($fields as $k => $v) {
			if ($v['set'] != 1) continue;
			if ($v['type'] == 'checkbox') $a[$k] = 0 + $a[$k];
			if ($v['type'] == 'date') $a[$k] = mktime(0, 0, 0, $a["datem_$k"], $a["dated_$k"], $a["datey_$k"]);
			if ($v['type'] == 'file' && $_POST[$k."_filename"] != '') $a[$k] = $_POST[$k."_filename"];
		}

		foreach ($fields as $k => $v) {
			if ($k == "intname" && $a[$k] == '' && $a['mainpage'] == 0) {
				$data[$k] = Func::mkintname($a["name"]);
			} elseif($k == "intname" && ($a[$k] == '/' || $a[$k] == 'index')) {
				$data[$k] = '';
			} elseif($v['set'] == 1 && ($v['multylang'] == 0 || $default_lang_id == $lang_id)) {
				$data[$k] = $a[$k];
			} elseif(defined('MULTY_LANG') && $v['set'] == 1 && $v['multylang'] == 1 && $default_lang_id != $lang_id) {
				$translate_data[$k] = $a[$k];
			}
		}
			
		if (function_exists('beforeset')) {
			beforeset($id, $_POST);
		}

		if ($id) {
			$Model->update($data, array("where" => "id = $id"));
		} else {
			$Model->insert($data);
		}

		if ($id == 0) {
			$id = $Model->last_id();
			if (function_exists('onadd')) onadd($id);
		}

		if (defined('MULTY_LANG') && count($translate_data)) {
			foreach ($translate_data as $k => $v) {
				$data = array(
					"obj_id" => $id,
					"lang" => $lang,
					"table" => $Model->table,
					"field" => $k,
					"cont" => $v,
				);
				$cond = array(
					"where" => "lang = '".$lang."' and `table` = '".$Model->table."' and field = '".$k."' and obj_id = '".$id."'",
				);

				$Translate = new Model_Translate($Model->db_prefix);
				if ($r = $Translate->getone($cond)) {
					$Translate->update($data, array("where" => "id = '".$r->id."'"));
				} else {
					$Translate->insert($data);
				}
			}
		}

		foreach ($fields as $k => $v) {
			$ftype = ($v['ftype']) ? $v['ftype']: "jpg";
			
			$dst = $path.'/'.$v['location'].'/'.$id.".".$ftype;
			
			if ($_POST[$k."_image_del"]) {
				$OutputCache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array(str_replace(array("/", "."), "_", str_replace("../", "", $v['location'])."/".$id.".".$ftype)));
				
				if (file_exists($dst)) unlink($dst);
			}
				
			if ($v['type'] == 'image') {
				if ($_POST[$k."_imagename"]) {
					if (file_exists($dst)) unlink($dst);
					if (!file_exists($path.'/'.$v['location'])) mkdir($path.'/'.$v["location"]);
					copy($path.'/admin/'.$_POST[$k."_imagename"], $dst);
					unlink($path.'/admin/'.$_POST[$k."_imagename"]);
					
					$OutputCache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array(str_replace(array("/", "."), "_", str_replace("../", "", $v['location'])."/".$id.".".$ftype)));
				}
			}
			
			if ($v['type'] == 'file') {
				$dst = $path.$v['location']."/".$_POST[$k."_filename"];
					
				if($_POST[$k."_filename"]){
					if (file_exists($dst)) unlink($dst);
					if (!file_exists($path.'/'.$v['location'])) mkdir($path.'/'.$v["location"]);
					rename($path."/admin/tmp/".$_POST[$k."_filename"], $dst);
				}
			}

			$dst = $path.'/'.$v['location']."/".$a[$k];
			
/*				if($_POST[$k."_file_del"]) {
					if (file_exists($dst)) unlink($dst);
					$a[$k] = "";
				}*/
					
			if ($v['type'] == 'multiselect' || $v['type'] == 'multiselecttree') {
			    $Relation = new Model_Relation();
				if ($v['obj-rel'] == 'relation') {
					$Relation->delete(array("where" => "relation = '$id' and `type` = '".$v['relation']."'"));
				} else {
					$Relation->delete(array("where" => "obj = '$id' and `type` = '".$v['relation']."'"));
				}

				if (!empty($a[$k])) {
					foreach ($a[$k] as $kk => $vv) {
						if ($v['obj-rel'] == 'relation') {
							$data = array(
								"type" => $v['relation'],
								"relation" => $id,
								"obj" => $vv,
							);
						} else {
							$data = array(
								"type" => $v['relation'],
								"obj" => $id,
								"relation" => $vv,
							);
						}
						$Relation->insert($data);
					}
				}
					
				if (count($a[$k]) > 1) {
					if ($v['obj-rel'] == 'relation') {
						$Relation->delete(array("where" => "relation = '$id' and obj = '-1' and `type` = '".$v['relation']."'"));
					} else {
						$Relation->delete(array("where" => "obj = '$id' and relation = '-1' and `type` = '".$v['relation']."'"));
					}
				}
			}
		}

		$Plugins->onset($id);
		onset($id);
		
		$Cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array(strtolower($model)));
			
		if ($action == 'setlang') {
			header("Location: ".$url->page.$url->gvar("action=edit&id=$id&lang=".$a['setlang']));
		} else {
			header("Location: ".$url->page.$url->gvar("action=&id=&lang="));
		}
	} elseif($action == 'edit') {
//	Delete tmp files
		$dd = opendir("tmp");
		while ($ff = readdir($dd)) {
			if ($ff != '.' && $ff != '..' && $ff != 'translate') {
				unlink("tmp/".$ff);
			}
		}
//	/Delete tmp files			

		$id = 0 + $_GET[id];
		$a = new Entity();

		if ($id == 0) {
			foreach ($fields as $k => $v) {
				$a->$k = $v['value'];
			}
		} else {
			$Model = new $model();
			$a = $Model->get($id);
		}
						
		$view->a = $a;
		$view->fields = $fields;
						
		$view->title = $title." - ".$a->name;
		$view->id = $id;
		$view->user_code = $user_code;

		$view->cont = $view->render('edit.php');
		echo $layout->render($view);
	} elseif($action == 'show') {
		$Model = new $model();
		$Model->type = $model_type;

		$view->fields = $fields;

		if($_GET['q']) {
			$filter_empty = 1;
			$show_cond_old = $show_cond;
			if (empty($show_cond["where"])) $show_cond["where"] = "1 = 1";
			$show_cond["where"] .= " and (";
			foreach ($fields as $k => $v) {					
				if ($v['filter']) {
					if ($fk++) {
						$show_cond["where"] .= " or ";
					}
					$filter_empty = 0;
					$show_cond["where"] .= "`".$k."` like '%".data_base::nq($_GET['q'])."%'";
				}
			}
			$show_cond["where"] .= ")";
				
			if ($filter_empty) {
				$show_cond = $show_cond_old;
			}
		}


		$view->cnt = $Model->getnum($show_cond);
		$view->results = $results;
		$view->start = $start;
	
		$order = ($_GET['order']) ? $_GET['order'] : $default_order;
		$desc_asc = ($_GET['desc_asc']) ? $_GET['desc_asc'] : $default_order_desc_asc;

		$show_cond['order'] = $order." ".$desc_asc;
		if ($default_order_string) {
			$show_cond['order'] = $default_order_string;
		}
		$show_cond["limit"] = "$start, $results";
		$rows = $Model->getall($show_cond);
		$rows2 = $Model->getall($show_cond);

		$view->rows = array();
		$view->originalrows = array();

		foreach ($rows as $k => $v) {
			$view->rows[$k] = $Plugins->onshow($v);
			$view->rows[$k] = onshow($v);
		}

		foreach ($rows2 as $k => $v) {
			$view->originalrows[$k] = $v;
		}

		$view->can_edit = $can_edit;
		$view->can_del = $can_del;
		$view->can_add = $can_add;
		$view->title = $title;
		$view->showhead = showhead();
		$view->order = $order;
		$view->desc_asc = $desc_asc;
		
		$view->cont = $view->render('show.php');
		echo $layout->render($view);
	}
} catch(DBException $e) {
	echo "<font color=red>DBException!</font><br />";
	echo $e->getMessage()."<br />";
	echo "in file: ".$e->getFile()."<br />";
	echo "at line: ".$e->getLine()."<br />";
	echo "Trace: <br />";
	$trace = $e->getTrace(); 
	foreach($trace as $k => $v){
		echo "<font color=\"green\">".$k." -> </font>";
		foreach($v as $kk => $vv){
			echo $kk." -> ";
			if(is_array($vv)) print_r($vv); else echo $vv;
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
	echo "Trace: <br />";
	$trace = $e->getTrace(); 
	foreach($trace as $k => $v){
		echo "<font color=\"green\">".$k." -> </font>";
		foreach($v as $kk => $vv){
			echo $kk." -> ";
			if(is_array($vv)) print_r($vv); else echo $vv;
			echo "<br />";
		}
		echo "<br />";
	}
	echo "<br />";
}