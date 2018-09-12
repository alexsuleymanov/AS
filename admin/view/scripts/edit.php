<?
	$t[months] = array(
		"01" => "январь",
		"02" => "февраль",
		"03" => "март",
		"04" => "апрель",
		"05" => "май",
		"06" => "июнь",
		"07" => "июль",
		"08" => "август",
		"09" => "сентябрь",
		"10" => "октябрь",
		"11" => "ноябрь",
		"12" => "декабрь",
	);
?>

<div class="panel-body">
<?	if(defined("MULTY_LANG") && $this->onelang != 1){?>
	<div class="row">
		<div class="col-lg-12">

			<script type="text/javascript">
				function setlang(lang){
					$('#editform').attr('action', '<?=$this->url->gvar("action=setlang")?>');
					$('#setlang').val(lang);
					$('#editform').submit(); 
					return false;
				}
			</script>

			<ul class="nav nav-tabs">
<?		foreach($this->langs as $k => $v){?>                                                                                                                                                                                                                                    
				<li class="<?=($this->lang == $k) ? "active": ""?>"><a onclick="return setlang('<?=$k?>');" href="<?=$this->url->gvar("action=setlang&fromlang=".$this->lang."&lang=".$k)?>" data-toggle="tab"><?=$v['name']?> <img src="/pic/lang/<?=$v['id']?>.jpg" align="absmiddle" alt=""></a></li>
<?		}?>
			</ul>
		</div>
	</div><br /><br />
<?	}?>
	<div class="row">
		<div class="col-lg-12">
			<form role="form" name="editform" action="<?=$this->url->gvar("action=set")?>" method="post" enctype="multipart/form-data" id="editform">
<?	if(defined("MULTY_LANG")){?>
				<input type="hidden" name="setlang" id="setlang" value="">
<?	}?>

<?		foreach($this->fields as $k => $v) {
			if($v['edit'] != 1) continue;?>
			<div class="form-group" style="margin-bottom: 20px;">
				<label><?=$v['label']?><?if($v['multylang'] == 1 && MULTY_LANG == 1){?> <img src="/pic/lang/<?=$this->lang_id?>.jpg" align="absmiddle"><?}?></label>
<?			if($v['type'] == 'hidden' && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1){?>
				<input type="hidden" name="<?=$k?>" value="<?=htmlspecialchars($this->a->$k)?>" />
<?			}elseif ($v['type'] == 'html' && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1){ ?>
				<textarea name="<?=$k?>" class="ckeditor form-control" rows="10" cols="80" style="width: 100%"><?=$this->a->$k?></textarea>
<?			}else if ($v['type'] == 'text' && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1) {?>
				<input type="text" name="<?=$k?>" class="form-control" value="<?=htmlspecialchars($this->a->$k)?>" style="width: 100%">
<?/*				<p class="help-block">Example block-level help text here.</p>*/?>
<?			} else if ($v['type'] == 'textarea' && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1) {?>
				<textarea name="<?=$k?>" class="form-control" rows=10 style="width: 100%"><?=$this->a->$k?></textarea>
<?			} else if ($v['type'] == 'checkbox'  && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1) {?>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="<?=$k?>" value="1"<?if ($this->a->$k) echo ' checked = 1'?>>
					</label>
				</div>
				
<?			} else if ($v['type'] == 'select' && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1) {?>
				<select name="<?=$k?>" class="form-control">
<?				foreach($v['items'] as $k1 => $v1) {?>
			        <option value="<?=$k1?>"<?if ($k1 == $this->a->$k) echo ' selected = 1'?>><?=$v1?></option>
<?				}?>
				</select>
<?			} else if ($v['type'] == 'multiselect' && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1) {?>
				<div style="border: 1px solid #999999; overflow: hidden; padding: 10px;">
<?				$Relation = new Model_Relation();
				$rel = array();
				$relations = $Relation->getall(array("where" => "`type` = '".$v['relation']."' and obj = '".$this->id."'"));
				foreach($relations as $kkk => $vvv) $rel[] = $vvv->relation;
				foreach($v['items'] as $k1 => $v1) {?>
					<div style="width: 300px; float: left;"><input type="checkbox" name="<?=$k?>[]" value="<?=$k1?>" <?if (in_array($k1, $rel) || (empty($_GET[id]) && $v['selected'])) echo ' checked = 1'?>> <?=$v1?></div>
<?				}?>
				</div>
<?			} else if ($v['type'] == 'multiselecttree' && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1) {?>
				<div style="border: 1px solid #999999; overflow: hidden; padding: 10px;">
<?
				function draw_tree($k, $tree, $rel, $par){
					echo "<ul style=\"padding-left: 20px;\">";
					foreach($tree as $kk => $item){
						if($item['par'] == $par){
							unset($tree[$kk]);
							echo "<li><input type=\"checkbox\" name=\"".$k."[]\" value=\"".$item['id']."\"";
							if (in_array($item['id'], $rel) || (empty($_GET[id]) && $v['selected'])) echo " checked = 1";
							echo ">";
							echo $item['name'];
							draw_tree($k, $tree, $rel, $item['id']);
							echo "</li>";
						}
					}
					echo "</ul>";
				}

				$Relation = new Model_Relation();
				$rel = array();
				if($v['obj-rel'] == 'relation'){
					$relations = $Relation->getall(array("where" => "`type` = '".$v['relation']."' and relation = '".$this->id."'"));
					foreach($relations as $kkk => $vvv) $rel[] = $vvv->obj;
				}else{
					$relations = $Relation->getall(array("where" => "`type` = '".$v['relation']."' and obj = '".$this->id."'"));
					foreach($relations as $kkk => $vvv) $rel[] = $vvv->relation;
				}
				$tree = $v['items'];
				draw_tree($k, $tree, $rel, 0);?>
				</div>
<?			}  else if ($v['type'] == 'radio' && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1) {?>
<?				foreach($v[items] as $k1 => $v1) {?>
				<input type="radio" name="<?=$k?>" class="form-control" value="<?=$k1?>"<?if ($k1 == $this->a->$k) echo ' checked = 1'?>><?=$v1?> &nbsp; &nbsp;
<?				}?>
<?			} else if ($v['type'] == 'date' && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1) {?>
				<div style="clear: both;"></div>
				<input type="text" size=2 class="form-control" style="width: 25%; float: left; margin-right: 20px;" name="dated_<?=$k?>" value="<?=date("d", $this->a->$k)?>">
				<select name="datem_<?=$k?>" class="form-control" style="width: 25%; float: left; margin-right: 20px;">
<?				foreach($t[months] as $k1 => $v1) {?>
				<option value="<?=$k1?>"<?if ($k1 == date("m", $this->a->$k)) echo ' selected'?>><?=$v1?>
<?				}?>
				</select>
				<input type="text" size=4 name="datey_<?=$k?>" class="form-control" value="<?=date("Y", $this->a->$k)?>" style="width: 25%; float: left; margin-right: 20px;">
				<div style="clear: both;"></div>
<?			} else if ($v['type'] == 'image' && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1) {
				$ftype = ($v['ftype']) ? $v['ftype'] : 'jpg';
?>		<input type="hidden" name="<?=$k?>_imagename" id="<?=$k?>_imagename" value="">
		<table cellpadding="20">
			<tr>
				<td>
<?              if(file_exists($this->globalpath.'/'.$v['location'].'/'.$this->id.'.jpg')){?>
					<img id="<?=$k?>_image" alt="" src="/<?=$v['location']?>/<?=$this->id?>.<?=$ftype?>?time=<?=time()?>" align="absmiddle" width="200">
<?				}else{?>
					<img id="<?=$k?>_image" alt="" src="<?=$this->path?>/img/no-photo.png" align="absmiddle" width="200">
<?				}?>
				</td>
				<td style="padding: 20px;"><input type="button" id="upload_button_<?=$k?>"  class="btn btn-default" value="Загрузить">
<?              if(file_exists($this->globalpath.'/'.$v['location']."/".$this->id.".jpg")){?>
					<input type="button" id="delete_button_<?=$k?>"  class="btn btn-default" value="Удалить" onclick="delete_image_<?=$k?>();">
<?				}?>
					
				<script type="text/javascript">
					function delete_image_<?=$k?>(){
						$.get("/admin/lib/upload.php?action=delete", {"filename": '<?=$this->globalpath.'/'.$v['location']?>/<?=$this->id?>.<?=$ftype?>'}, function(data){
							$('#<?=$k?>_image').attr("src", "/img/tr.gif");
							$('#<?=$k?>_image').css({"width" : "1", "height" : "1"});
							$('#delete_button_<?=$k?>').css({"visibility": "hidden"});
						});
					}

					$.ajaxUploadSettings.name = 'userfile';
					$('#upload_button_<?=$k?>').ajaxUploadPrompt({
						url : '/admin/lib/upload.php',
						onprogress : function (e) {
							$('#<?=$k?>_image').attr("src", '<?=$this->path?>/img/upload/loader.gif');
						},
						error : function () {
						},
						success : function (data) {
							console.log(data);
			
							$('#<?=$k?>_image').attr("src", "tmp/"+data);
							$('#<?=$k?>_image').css("width", "200");
							$('#<?=$k?>_imagename').val("tmp/"+data);
						}
					});
				</script>
				</td>
			</tr>
		</table>
<?				$wh = "";
				if ($v[width] != '') $wh .= " width=".$v[width];
				if ($v[height] != '') $wh .= " height=".$v[height];
//				echo (file_exists($v['location']."/".$id.'.jpg'))? '<img '.$wh.' src="'.$v['location']."/".$id.'.jpg?r='.time().'"><br><input type="checkbox" name="'.$k.'_image_del" value="1"> Удалить': '<i>нет</i>'; //"for_colorer
			} else if ($v['type'] == 'file') {?>
		<input type="hidden" name="<?=$k?>" id="<?=$k?>_filename" value="<?=$this->a->$k?>">
		<input type="hidden" name="<?=$k?>_filename" id="<?=$k?>_filename2" value="<?=$this->a->$k?>">
		<table>
			<tr>
<?				if($this->a->$k){?>
				<td><img id="<?=$k?>_image" alt="" src="<?=$this->path?>/img/file.jpg" align="absmiddle"> <span id="<?=$k?>_file_name"><?=$this->a->$k?></span></td>
<?				}else{?>
				<td><img id="<?=$k?>_image" alt="" src="<?=$this->path?>/img/tr.gif" align="absmiddle"> <span id="<?=$k?>_file_name"></span></td>
<?				}?>
				<td><input type="button" id="file_upload_button_<?=$k?>"  class="btn btn-default" value="Загрузить">
<?				if($this->a->$k){?>
					<input type="button" id="file_delete_button_<?=$k?>"  class="btn btn-default" value="Удалить" onclick="delete_file_<?=$k?>();">
<?				}?>
				</td>
			</tr>
		</table>
<script>
	function delete_file_<?=$k?>(){
		$.get("/admin/lib/upload_file.php?action=delete", {"filename": '<?=$this->globalpath?>/<?=$v['location']?>/<?=$this->a->$k?>'}, function(data){
			console.log(data);
			$('#<?=$k?>_image').attr("src", "<?=$this->path?>/img/tr.gif");
			$('#<?=$k?>_image').css({"width" : "1", "height" : "1"});
			$('#<?=$k?>_file_name').html('');
			$('#<?=$k?>').val('');
			$('#<?=$k?>_filename').val('');
			$('#<?=$k?>_filename2').val('');
			$('#file_delete_button_<?=$k?>').css({"visibility": "hidden"});
		});
	}

					$.ajaxUploadSettings.name = 'userfile';
					$('#file_upload_button_<?=$k?>').ajaxUploadPrompt({
						url : '/admin/lib/upload_file.php',
						onprogress : function (e) {
							$('#<?=$k?>_image').attr("src", '<?=$this->path?>/img/upload/loader.gif');
							$('#<?=$k?>_file_name').html('');
						},
						error : function () {
						},
						success : function (data) {
							console.log(data);
			
							$('#<?=$k?>_image').attr("src", '<?=$this->path?>/img/file.jpg');
							$('#<?=$k?>_filename').val(data);
							$('#<?=$k?>_filename2').val(data);
							$('#<?=$k?>_file_name').html(data);
						}
					});
					
	var ajaxupload<?=$k?> = new AjaxUpload('file_upload_button_<?=$k?>', {
		action: '/admin/lib/upload_file.php?location=<?=$v['location']?>',
		onSubmit : function(file, ext){
			$('#<?=$k?>_image').attr("src", '<?=$this->path?>/img/upload/loader.gif');
			$('#<?=$k?>_file_name').html('');
		},
		onComplete: function(file, response){
			$('#<?=$k?>_image').attr("src", '<?=$this->path?>/img/file.jpg');
			$('#<?=$k?>_filename').val(response);
			$('#<?=$k?>_filename2').val(response);
			$('#<?=$k?>_file_name').html(response);
		}
	});

</script>

<?/*      <input type="hidden" name="<?=$k?>" readonly value="<?=$this->a->$k?>">
      <input type="file" name="<?=$k?>_file">
      <br>
<?				echo ($this->a->$k != '' && file_exists($v['location']."/".$this->a->$k))? 'Загружен: '.$this->a->$k.'; Размер: '.filesize($v['location']."/".$this->a->$k).'<br><input type="checkbox" name="'.$k.'_file_del" value="1"> Удалить': '<i>нет</i>'; //"for_colorer
*/
			} else if ($v['type'] == 'custom' && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1) {
				echo $v[content];
			} else if ($v['type'] == 'color' && Zend_Registry::get("admin_level") >= $v['admin_level'] && $v['edit'] == 1) {
				if (empty($colorsincluded)) {
					$colorsincluded = 1;?>
<script language="JavaScript">
	hexValues = new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");

	function toHex(integer) {
		hexDigit1 = Math.floor(integer / 16); /* / */
		hexDigit2 = (integer % 16);
		return hexValues[hexDigit1] + hexValues[hexDigit2];
	}
	
	function bpal(editbox) {
		var n, m, r, g, b, clr;
		document.write("<table border=0 cellspacing=0 cellpadding=0>");
		for (n = 0; n < 64; n++) {
			document.write('<tr>');
			for (m = 0; m < 64; m++) {
				r = Math.floor((n % 16) * 255 / 15); /* / */
				g = Math.floor((m % 16) * 255 / 15); /* / */
				b = Math.floor((Math.floor(n / 16) * 4 + Math.floor(m / 16)) * 255 / 15); /* / */
  			
				clr = toHex(r) + toHex(g) + toHex(b);

	//  			document.write(clr + "<br>");
				document.write('<td bgcolor="#' + clr + '" onclick="editform.' + editbox + '.value=\'' + clr + '\'; editform.' + editbox + '_show.style.backgroundColor=\'#' + clr + '\';"><img src="img/tr.gif" width=4 height=4></td>'); /* / */
			}
			document.write('</tr>'); /* / */
		}
		document.write("</table>"); /* / */
	}
</script>
			</div>

<?				}?>
       <input type="text" size=8 name="<?=$k?>" value="<?=$this->a->$k?>">
       <input type="text" size=8 name="<?=$k?>_show" style="background-color: #<?=$this->a->$k?>" value="" readonly>
       <br><br>
       <script language="JavaScript">bpal("<?=$k?>");</script>
<?			}?>
			</div>
<?		}?>
<?		if ($this->user_code != '') require($this->user_code);?>
		<div class="form-group" style="margin-bottom: 20px;">
			<input type=submit name="" value="Сохранить" class="btn btn-success">
			<input type=button name="" value="Отмена"  class="btn btn-danger" onclick="window.location.href='<?=$this->url->page.$this->url->gvar("action=&id=")?>';">
		</div>

			</form>
		</div>
	</div>
</div>