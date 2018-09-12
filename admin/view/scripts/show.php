<script>
	function is_empty(id){
		return true;
	}

	function setajax(id, field, value){
		$.get("<?=$_SERVER['SCRIPT_NAME']?>?action=setajax", {'id' : id, 'field': field, 'fieldvalue': value}, function(){
			location.reload();	
		});
	}
	
	function edit_field() {
		
	}
	
	$(document).ready( function() {
			 $('#dataTable_wrapper').dataTable( {
				"language": {
				"lengthMenu": 'Display <select>'+
					'<option value="-1">All</option>'+
					'<option value="50">10</option>'+
					'<option value="100">20</option>'+
					'<option value="500">30</option>'+
					'</select> records'
				}
			 } );
	} );
</script>
		<div class="row">
			<div class="col-lg-12"><?=$this->showhead?></div>
		</div>

		<div class="row">
<?	if ($this->can_add) { ?>
			<div class="col-lg-12">
				<a href="<?=$this->url->gvar("action=edit")?>" class="btn btn-success"><i class="fa fa-plus-circle"></i> Добавить</a><br /><br />
			</div>
<?	}?>
                <div class="col-lg-12">
                   <?/* <div class="panel panel-default">
                        <div class="panel-heading">
                            Список. <?=$this->title?>
                        </div>
                        <!-- /.panel-heading -->*/?>
                        <?/*<div class="panel-body">*/?>
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                                    <thead>
                                        <tr>
											<th>#</th>
									<?		foreach($this->fields as $k => $v) {
												if($v['show'] != 1) continue;?>
                                            <th><?=$v['label']?></th>
									<?		}?>
                                            <th></th>
											<th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?	foreach($this->rows as $kk => $row) {?>
										<tr>
											<td class="center"><?=$kk?></td>
<?			foreach($this->fields as $k => $v) {
				if($v['show'] != 1) continue;
?>
											<td>
<?
				$ftype = ($v['ftype']) ? $v['ftype'] : 'jpg';
				if($v['type'] == 'checkbox'){?>
			<div style="cursor: pointer;" <?if(Zend_Registry::get('admin_level') == 3){?>onclick="setajax(<?=$row->id?>, '<?=$k?>', <?=($row->$k) ? 0 : 1;?>)"<?}?>>
<?					echo ($row->$k) ? "<center><img src=\"".$this->path."/img/ok.png\"></center>" : "<center><img src=\"".$this->path."/img/b_del.png\"></center>";?>
			</div>
<?				}elseif($v['type'] == 'image'){
					if(file_exists($this->globalpath.'/'.$v['location']."/".$row->id.".".$ftype)){
						echo "<img src=\"/thumb?width=50&src=".$v["location"]."/".$row->id.".".$ftype."\">";
					}else{
						echo "<img src=\"".$this->path."/img/no-photo.png\" width=\"120\">";
					}
				}elseif($v['type'] == 'date'){
					echo date("d.m.Y", $row->$k);
				}elseif($v['type'] == 'select'){
					echo $v['items'][$row->$k];
				}else{?>
<?					if($row->$k == $this->originalrows[$kk]->$k){?>

			<div style="cursor: pointer;" id="text<?=$k?>_<?=$kk?>" style="background-color: #ff0000;">
<?					echo $row->$k;?>
			</div>
			<script>
				
				function onchangetext<?=$k?>_<?=$kk?>(a){
	                setajax(<?=$row->id?>, '<?=$k?>', $(a).val());
				}

				$("#text<?=$k?>_<?=$kk?>").bind('click', function(){
					$(this).html("<input type='text' id='<?=$k?><?=$kk?>' name='<?=$k?>' value='<?= ASweb\Db\Db::nq($this->originalrows[$kk]->$k)?>' onchange='onchangetext<?=$k?>_<?=$kk?>(this)'>");
					$(this).unbind('click');
					document.getElementById("<?=$k?><?=$kk?>").focus();
				});
			</script>
												
<?					}else{?>
<?	                    echo $row->$k;?>
<?					}?>
<?				}?>
											</td>
<?			}
										if ($this->can_edit) {?>
											<td class="center"><a href="<?=$this->url->gvar("action=edit&id=".$row->id)?>" title="Редактировать"><img src="<?=$this->path?>/img/b_edit.png"></a></td>
<?										}
										if ($this->can_del) { ?>
											<td class="center"><a href="<?=$this->url->gvar("action=del&id=".$row->id)?>" onclick="return confirm('Удалить?')" title="Удалить"><img src="<?=$this->path?>/img/b_del.png"></a></td>
<?										}?>
										</tr>
<?	}?>
                                    </tbody>
                                </table>
                            </div>
							<?/*
						</div>
					</div>
				</div>*/?>
		</div>
			
		<div class="row">
			<div class="col-lg-12"><?=$this->render('rule.php')?></div>
		</div>
