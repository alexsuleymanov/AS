<div id="hiddencolor" style="display: none;">
	<div id="color0">
	<table width="300" border="0" class="table table-striped table-bordered table-hover" id="color0">
		<tr>
			<td style="padding: 10px;">
				<div id="color_select0">		
					Введите название товара<br>
					<input type="text" id="gsearch0" size="100" name="q" value=""/><br/><br/>
				</div>
				<img id="color_img0" src="" width="0" height="0" style="float: left; margin: 0px 10px 10px 0px;">
				<div id="color_title0"></div>
				<div id="color_price0"></div>
				<div id="color_color0" class="child_input" style="display: none;">Цвет: 
					<span id="color_name0"><?echo $color->name?></span>
					<input type="hidden" name="prod_color" id="color_select_0" value="0">

<?/*					<select name="prod_color" id="color_select_0" onchange="set_color(0);">
						<option value="0">Выберите цвет</option>
<?	$Color = new Model_Color();
	$colors = $Color->getall();
	foreach($colors as $v){?>
						<option value="<?=$v->id?>"><?=$v->name?></option>
<?	}?>
					</select>*/?>
				</div>
			</td>
			<td class="show" width="16" id="dela"><a href="" onclick="remove_color(0); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
		</tr>
	</table>
	</div>
</div>

<script type="text/javascript">
	function add_colorrow(data){
		table = $("#hiddencolor table:first");
		newcolor = table.clone();
		newcolor.attr({"id": "color"+data});
		newcolor.find("#gsearch0").attr({"id": "gsearch"+data});
		newcolor.find("#color_select0").attr({"id": "color_select"+data});
		newcolor.find("#color_img0").attr({"id": "color_img"+data});
		newcolor.find("#color_title0").attr({"id": "color_title"+data});
		newcolor.find("#color_price0").attr({"id": "color_price"+data});
		newcolor.find("#color_color0").attr({"id": "color_color"+data});
		newcolor.find("#color_name0").attr({"id": "color_name"+data});
		newcolor.find("#color_select_0").attr({"id": "color_select_"+data});
//		newcolor.find("#color_select_"+data).unbind("change");
//		newcolor.find("#color_select_"+data).attr({"onchange": "set_color(9);"});
/*		newcolor.find("#color_select_"+data).removeAttr("onchange").bind("change", function(){$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"edit_color_color" : 1, "colorid": data, "color": $("#color_select_"+data).val()});}); */

//		newcolor.find("#color_select_"+data).bind("change", "set_color("+data+")");
		newcolor.find("#dela").html('<a href="" id="a" onclick="remove_color('+data+'); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a>');
//		newcolor.find("#color_color"+data).show();
		newcolorscript = "";

		newcolorscript += "$().ready(function() {\n";
		newcolorscript += "		$('#gsearch"+data+"').autocomplete('/search/hint/prod', {\n";
		newcolorscript += "			width: 260,\n";
		newcolorscript += "			selectFirst: false\n";
		newcolorscript += "		});\n";
	
		newcolorscript += "		$('#gsearch"+data+"').result(function(event, data, formatted) {\n";
//		newcolorscript += "			$('#color_img"+data+"').attr({'src': '/pic/prod/'+data[1]+'.jpg', 'width': '100'});\n";
		newcolorscript += "			$('#color_title"+data+"').html('<b>'+data[0]+'</b>');\n";
		newcolorscript += "			$('#color_color"+data+"').show();\n";
		newcolorscript += "			$('#color_name"+data+"').html(data[3]);\n";
		newcolorscript += "			$('#color_select_"+data+"').html(data[2]);\n";

		newcolorscript += "			$.get('adm_prod.php"+"<?=$this->url->gvar("time=")?>"+"', {'edit_color': 1, 'colorid': "+data+", 'prod': data[1], 'color': data[2]}, function(data){\n";
		newcolorscript += "				$('#gsearch"+data+"').attr('disabled', 'true');\n";
		newcolorscript += "				$('#color_select"+data+"').hide();\n";
		newcolorscript += "			});\n";
		newcolorscript += "		});\n";
		newcolorscript += "});\n";

		newcolorscript1 = '\n<script type="text\/javascript">\n';
		newcolorscript1 += newcolorscript;
		newcolorscript1 += '<\/script>\n';

		$("#colors").append(newcolorscript1);
		$("#colors").prepend(newcolor);
		eval(newcolorscript);
	}

	function remove_colorrow(data){
		$("#color"+data).empty();
	}

	function add_color(){
		$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"add_color" : 1}, add_colorrow);
	}

	function remove_color(id){
		if(confirm('Удалить пожожий товар?'))
			$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"del_color" : id}, remove_colorrow);
	}

	function set_color(id){
		$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"edit_color_color" : 1, "colorid": id, "color": $("#color_select_"+id).val()});
	}
</script>
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="" onclick="add_color(); return false;"><img src="<?=$this->path?>/img/add.jpg" valign="middle"> Добавить</a><br><br>
		</div>

		<div class="panel-body">
	    <div class="table-responsive">
			
			<div id="colors">		
<?	$Prodcolor = new Model_Prodcolor();
	$prodcolors = $Prodcolor->getall(array("where" => "prod = '". ASweb\Db\Db::nq($_GET[id])."' or relation = '". ASweb\Db\Db::nq($_GET[id])."'"));
	foreach($prodcolors as $k => $r){
		$Prod = new Model_Prod();
		$prod = $Prod->get($r->relation);
?>
				<div id="color">
				<script type="text/javascript">
					$().ready(function() {
						$("#gsearch<?=$r->id?>").autocomplete("/search/hint/prod", {
							width: 260,
							selectFirst: false
						});
	
						$("#gsearch<?=$r->id?>").result(function(event, data, formatted) {
							$("#color_title<?=$r->id?>").html(data[0]);
							$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"edit_color": 1, "colorid": <?=$r->id?>, "color": data[1]}, function(data){
								$("#gsearch<?=$r->id?>").attr("disabled", "true");
								$("#color_select<?=$r->id?>").hide();
								$("#color_name<?=$r->id?>").html(data[3]);
								$("#color_select_<?=$r->id?>").html(data[2]);
							});
						});
					});
				</script>

				<table cellspacing="0" cellpadding="0" width="300" border="0" class="table table-striped table-bordered table-hover" id="color<?=$r->id?>">
					<tr>
						<td style="padding: 10px;">
							<img id="color_img<?=$r->id?>" src="/pic/prod/<?=$r->relation?>.jpg" width="100" style="float: left; margin: 0px 10px 10px 0px;">
							<div id="color_title<?=$r->id?>" class="child_title"><b><?=$prod->name?></b></div>
							<div id="color_price<?=$r->id?>" class="child_price"><?=Func::fmtmoney($prod->price).$this->sett['valuta']?></div>
							<div id="color_color<?=$r->id?>" class="child_input">Цвет:
								<?
									$Color = new Model_Color();
									$color = $Color->get($r->color);?>
								<span id="color_name<?=$r->id?>"><?echo $color->name?></span>
								<input type="hidden" name="prod_color" id="color_select_<?=$r->id?>" value="<?=$r->color?>">
<?/*								<select name="prod_color" id="color_select_<?=$r->id?>" onchange="set_color(<?=$r->id?>);">
									<option value="0" <?if($v->id == 0) echo "selected=\"1\"";?>>Выберите цвет</option>
<?	$Color = new Model_Color();
	$colors = $Color->getall();
	foreach($colors as $v){?>
									<option value="<?=$v->id?>" <?if($v->id == $r->color) echo "selected=\"1\"";?>><?=$v->name?></option>
<?	}?>
								</select>*/?>
							</div>

						</td>
						<td class="show" width="16" id="dela"><a href="" onclick="remove_color(<?=$r->id?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
					</tr>
				</table>
				</div>
	<?}?>
			</div>
		</div>
	</div>
</div>		
