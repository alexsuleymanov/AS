<div id="hiddenkit" style="display: none;">
	<div id="kit0">
	<table width="300" border="0" class="show" id="kit0">
		<tr>
			<td style="padding: 10px;">
				<div id="kit_select0">		
					Введите название товара<br>
					<input type="text" id="gsearch0" size="100" name="q" value=""/><br/><br/>
				</div>
				<img id="kit_img0" src="" width="1" style="float: left; margin: 0px 10px 10px 0px;">
				<div id="kit_title0"></div>
				<div id="kit_price0"></div>
				<div id="kit_discount0" class="child_input" style="display: none;">Скидка: <input type="text" name="kit_discount_input0" id="kit_discount_input0" size="3" />%</div>
			</td>
			<td class="show" width="16" id="dela"><a href="" onclick="remove_kit(0); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
		</tr>
	</table>
	</div>
</div>

<script type="text/javascript">
	function add_kitrow(data){
		table = $("#hiddenkit table:first");
		newkit = table.clone();
		newkit.attr({"id": "kit"+data});
		newkit.find("#gsearch0").attr({"id": "gsearch"+data});
		newkit.find("#kit_select0").attr({"id": "kit_select"+data});
		newkit.find("#kit_img0").attr({"id": "kit_img"+data});
		newkit.find("#kit_title0").attr({"id": "kit_title"+data});
		newkit.find("#kit_price0").attr({"id": "kit_price"+data});
		newkit.find("#kit_discount0").attr({"id": "kit_discount"+data});
		newkit.find("#kit_discount_input0").attr({"id": "kit_discount_input"+data, "name": "kit_discount_input"+data});
		newkit.find("#dela").html('<a href="" id="a" onclick="remove_kit('+data+'); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a>');
		newkit.find("#kit_discount"+data).html('Скидка: <input type="text" name="kit_discount_input'+data+'" id="kit_discount_input'+data+'" size="3" onchange="set_discount('+data+')"/>%');
//		newkit.find("#kit_discount"+data).show();
		newkitscript = "";

		newkitscript += "$().ready(function() {\n";
		newkitscript += "		$('#gsearch"+data+"').autocomplete('/search/hint/prod', {\n";
		newkitscript += "			width: 260,\n";
		newkitscript += "			selectFirst: false\n";
		newkitscript += "		});\n";
	
		newkitscript += "		$('#gsearch"+data+"').result(function(event, data, formatted) {\n";
//		newkitscript += "			$('#kit_img"+data+"').attr({'src': '/pic/prod/'+data[1]+'.jpg', 'width': '100'});\n";
		newkitscript += "			$('#kit_title"+data+"').html('<b>'+data[0]+'</b>');\n";
		newkitscript += "			$('#kit_discount"+data+"').show();\n";

		newkitscript += "			$.get('adm_prod.php"+"<?=$this->url->gvar("time=")?>"+"', {'edit_kit': 1, 'kitid': "+data+", 'kit': data[1]}, function(data){\n";
		newkitscript += "				$('#gsearch"+data+"').attr('disabled', 'true');\n";
		newkitscript += "				$('#kit_select"+data+"').hide();\n";
		newkitscript += "			});\n";
		newkitscript += "		});\n";
		newkitscript += "});\n";

		newkitscript1 = '\n<script type="text\/javascript">\n';
		newkitscript1 += newkitscript;
		newkitscript1 += '<\/script>\n';

		$("#kits").append(newkitscript1);
		$("#kits").prepend(newkit);
		eval(newkitscript);
	}

	function remove_kitrow(data){
		$("#kit"+data).empty();
	}

	function add_kit(){
		$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"add_kit" : 1}, add_kitrow);
	}

	function remove_kit(id){
		if(confirm('Удалить пожожий товар?'))
			$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"del_kit" : id}, remove_kitrow);
	}

	function set_discount(id){
		$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"edit_kit_discount" : 1, "kitid": id, "discount": $("#kit_discount_input"+id).val()});
	}
</script>

			<a href="" onclick="add_kit(); return false;"><img src="<?=$this->path?>/img/add.jpg">Добавить</a><br><br>
			<div id="kits">		
<?	$Kit = new Model_Kit();
	$kits = $Kit->getall(array("where" => "prod = '".ASweb\Db\Db::nq($_GET[id])."'"));
	foreach($kits as $k => $r){
		$Prod = new Model_Prod();
		$kit = $Prod->get($r->relation);
?>
				<div id="kit">
				<script type="text/javascript">
					$().ready(function() {
						$("#gsearch<?=$r->id?>").autocomplete("/search/hint/prod", {
							width: 260,
							selectFirst: false
						});
	
						$("#gsearch<?=$r->id?>").result(function(event, data, formatted) {
//							$("#kit_img<?=$r->id?>").attr({"src": "/pic/prod/"+data[1]+".jpg", "width": "100"});
							$("#kit_title<?=$r->id?>").html(data[0]);
							$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"edit_kit": 1, "kitid": <?=$r->id?>, "kit": data[1]}, function(data){
								$("#gsearch<?=$r->id?>").attr("disabled", "true");
								$("#kit_select<?=$r->id?>").hide();
							});
						});
					});
				</script>

				<table cellspacing="0" cellpadding="0" width="300" border="0" class="show" id="kit<?=$r->id?>">
					<tr>
						<td style="padding: 10px;">
							<img id="kit_img<?=$r->id?>" src="/pic/prod/<?=$kit->id?>.jpg" width="100" style="float: left; margin: 0px 10px 10px 0px;">
							<div id="kit_title<?=$r->id?>" class="child_title"><b><?=$kit->name?></b></div>
							<div id="kit_price<?=$r->id?>" class="child_price"><?=Func::fmtmoney($kit->price).Zend_Registry::get('cur_name')?></div>
							<div id="kit_discount<?=$r->id?>" class="child_input">Скидка: <input type="text" name="kit_discount_input<?=$r->id?>" value="<?=$r->discount?>" id="kit_discount_input<?=$r->id?>" value="<?=$kit->discount?>" size="3" onchange="set_discount(<?=$r->id?>)"/>%</div>
						</td>
						<td class="show" width="16" id="dela"><a href="" onclick="remove_kit(<?=$r->id?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
					</tr>
				</table>
				</div>
	<?}?>
			</div>
