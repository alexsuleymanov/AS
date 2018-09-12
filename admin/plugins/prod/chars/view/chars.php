<?	
$Cat = new Model_Cat();
$Cat->addPlugin('Tree', new Model_Plugin_Cat_Tree());
	?>

	<div class="panel panel-info">
		<div class="panel-heading">
			Характеристики
		</div>
		
		<div class="panel-body">
			<div class="table-responsive">
			<table class="table">
			<tr>
				<th width="1%">Характеристика</th>
				<th width="*">Значение</th>
			</tr>
<?
		$pc = array();

		if($_GET['id']){
			$Prodchar = new Model_Prodchar();
			$qr = $Prodchar->getall(array("where" => "prod = '".$_GET['id']."'", "order" => "prod asc, charval asc"));
			foreach($qr as $k => $r){
				$pc[$r->char][charval][] = $r->charval;
				$pc[$r->char][value] = $r->value;
			}
		}

		if($opt['char_cats']){
			$Charcat = new Model_Charcat();
			$charcats = $Charcat->getall(array("where" => $Cat->Plugin('Tree')->cat_tree($_GET['cat'])));
			foreach($charcats as $k => $rcc){?>
			<tr>
				<td colspan="2"><b><?=$rcc->name?></b></td>
			</tr>
<?				$Char = new Model_Char();
				$chars = $Char->getall(array("where" => "charcat = '".$rcc->id."'"));

	    		foreach($chars as $k => $r) {?>
			<tr>
				<td><nobr><?=$r->name?></nobr></td>
				<td>
<?					if($r->type == 4){?>
					<select name="charval_<?=$r->id?>">
<?						$Charval = new Model_Charval();
						$qrv = $Charval->getall(array("where" => "`char` = '".$r->id."'"));
						foreach($qrv as $k => $rv) {?>
						<option value="<?=$rv->id?>"<?if ($pc[$r->id][charval] == $rv->id) echo ' selected = "1"'?>><?=$rv->value?></option>
<?						}?>
					</select> <?=$r->izm?>
<?					}elseif($r->type == 2 || $r->type == 3){?>
					<input type="text" name="charval2_<?=$r->id?>" size="<?=($r->type == 2) ? "20": "90"?>" value="<?=$pc[$r->id][value]?>"> <?=$r->izm?>
<?					}elseif($r->type == 1){?>
					<select name="charval2_<?=$r->id?>">
						<option value="0" <?if ($pc[$r->id][value] == 0) echo 'selected = "1"'?>>Нет</option>
						<option value="1" <?if ($pc[$r->id][value] == 1) echo 'selected = "1"'?>>Да</option>
					<select>
<?					}?>
				</td>
			</tr>
<?				}
			}
	?>
<?		}else{
			$Char = new Model_Char();
			$chars = $Char->getall(array("where" => $Cat->Plugin('Tree')->cat_tree($_GET['cat'])));
			foreach($chars as $k => $r) {?>
			<tr>
				<td valign="top"><nobr><?=$r->name?></nobr></td>
				<td>
<?				if($r->type == 4){?>
<?					$Charval = new Model_Charval();
					$qrv = $Charval->getall(array("where" => "`char` = '".$r->id."'", "order" => "id asc"));
					foreach($qrv as $k => $rv) {
						if(empty($pc[$r->id][charval])) $pc[$r->id][charval] = array();
?>
						<div style=""><input type="checkbox" name="charval_<?=$r->id?>[]" value="<?=$rv->id?>" <?if (in_array($rv->id, $pc[$r->id][charval])) echo ' checked = "1"'?>> <?=$rv->value?> <?=$r->izm?></div>
<?					}?>
<?				}elseif($r->type == 2 || $r->type == 3){?>
					<input type="text" name="charval2_<?=$r->id?>" size="<?=($r->type == 2) ? "20": "90"?>" value="<?=$pc[$r->id][value]?>"> <?=$r->izm?>
<?				}elseif($r->type == 1){?>
					<select name="charval2_<?=$r->id?>">
						<option value="0" <?if ($pc[$r->id][value] == 0) echo 'selected = "1"'?>>Нет</option>
						<option value="1" <?if ($pc[$r->id][value] == 1) echo 'selected = "1"'?>>Да</option>
					<select>
<?				}?>
				</td>
			</tr>
<?			}?>
<?		}?>
			</table>
			</div>
		</div>
	</div>
