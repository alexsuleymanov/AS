<?	if($_GET['id']){?>
<div id="hiddenchild" style="display: none;">
	<div id="child0">
	<table width="300" border="0" class="show" id="child0">
		<tr>
			<td style="padding: 10;">
				<div id="child_select0">		
					Введите название товара<br>
					<input type="text" id="gsearch0" size="100" name="q" value=""/><br/><br/>
				</div>
				<img id="child_img0" src="" width="1" style="float: left; margin: 0px 10px 10px 0px;">
				<div id="child_title0"></div>
			</td>
			<td class="show" width="16" id="dela"><a href="" onclick="remove_child(0); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
		</tr>
	</table>
	</div>
</div>

<script type="text/javascript">
	function add_prodrow(data){
		table = $("#hiddenchild table:first");
		newchild = table.clone();
		newchild.attr({"id": "child"+data});
		newchild.find("#gsearch0").attr({"id": "gsearch"+data});
		newchild.find("#child_select0").attr({"id": "child_select"+data});
		newchild.find("#child_img0").attr({"id": "child_img"+data});
		newchild.find("#child_title0").attr({"id": "child_title"+data});
		newchild.find("#child_price0").attr({"id": "child_price"+data});
		newchild.find("#dela").html('<a href="" id="a" onclick="remove_child('+data+'); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a>');
		newchildscript = "";

		newchildscript += "$().ready(function() {\n";
		newchildscript += "		$('#gsearch"+data+"').autocomplete('/search/hint/prod', {\n";
		newchildscript += "			width: 260,\n";
		newchildscript += "			selectFirst: false\n";
		newchildscript += "		});\n";
	
		newchildscript += "		$('#gsearch"+data+"').result(function(event, data, formatted) {\n";
//		newchildscript += "			$('#child_img"+data+"').attr({'src': '/pic/prod/'+data[1]+'.jpg', 'width': '100'});\n";
		newchildscript += "			$('#child_title"+data+"').html('<b>'+data[0]+'</b>');\n";
		newchildscript += "			$.get('adm_actions.php"+"<?=$this->url->gvar("time=")?>"+"', {'edit_prod': 1, 'relid': "+data+", 'child': data[1]}, function(data){\n";
		newchildscript += "				$('#gsearch"+data+"').attr('disabled', 'true');\n";
		newchildscript += "				$('#child_select"+data+"').hide();\n";
		newchildscript += "			});\n";
		newchildscript += "		});\n";
		newchildscript += "});\n";

		newchildscript1 = '\n<script type="text\/javascript">\n';
		newchildscript1 += newchildscript;
		newchildscript1 += '<\/script>\n';

		$("#childs").append(newchildscript1);
		$("#childs").prepend(newchild);
		eval(newchildscript);
	}

	function remove_childrow(data){
		$("#child"+data).empty();
	}

	function add_prod(){
		$.get('adm_actions.php<?=$this->url->gvar("time=")?>', {"add_prod" : 1}, add_prodrow);
	}

	function remove_child(id){
		if(confirm('Удалить товар из акции?'))
			$.get('adm_actions.php<?=$this->url->gvar("time=")?>', {"del_prod" : id}, remove_childrow);
	}
</script>

			<a href="" onclick="add_prod(); return false;"><img src="<?=$this->path?>/img/add.jpg">Добавить</a><br><br>
			<div id="childs">		
<?	$Relation = new Model_Relation();
	$childs = $Relation->getall(array("where" => "type = 'page-prod' and obj = '".ASweb\Db\Db::nq($_GET[id])."'"));
	foreach($childs as $k => $r){
		$Prod = new Model_Prod();
		$child = $Prod->get($r->relation);
?>
				<div id="child">
				<script type="text/javascript">
					$().ready(function() {
						$("#gsearch<?=$r->id?>").autocomplete("/search/hint/prod", {
							width: 260,
							selectFirst: false
						});
	
						$("#gsearch<?=$r->id?>").result(function(event, data, formatted) {
							$("#child_img<?=$r->id?>").attr({"src": "/pic/prod/"+data[1]+".jpg", "width": "100"});
							$("#child_title<?=$r->id?>").html(data[0]);
							$.get('adm_actions.php<?=$this->url->gvar("time=")?>', {"edit_prod": 1, "relid": <?=$r->id?>, "child": data[1]}, function(data){
								$("#gsearch<?=$r->id?>").attr("disabled", "true");
								$("#child_select<?=$r->id?>").hide();
							});
						});
					});
				</script>

				<table cellspacing="0" cellpadding="0" width="300" border="0" class="show" id="child<?=$r->id?>">
					<tr>
						<td style="padding: 10;">
							<img id="child_img<?=$r->id?>" src="/pic/prod/<?=$child->id?>.jpg" width="100" style="float: left; margin: 0px 10px 10px 0px;">
							<div id="child_title<?=$r->id?>"><b><?=$child->name?></b></div>
							<div id="child_price<?=$r->id?>"><?=Func::fmtmoney($child->price).Zend_Registry::get('cur_name')?></div>
						</td>
						<td class="show" width="16" id="dela"><a href="" onclick="remove_child(<?=$r->id?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
					</tr>
				</table>
				</div>
	<?}?>
			</div>

<?}?>