<div id="hiddenvar" style="display: none;">
	<table class="show" id="var0" width="100%">
		<tr>
			<td class="show" width="39%"><input type='text' id="title" name='var_0_title' style="width: 100%" value="" disabled="true"></td>
			<td class="show" width="39%"><input type='text' id="price" name='var_0_price' style="width: 100%" value="" disabled="true"></td>
			<td class="show" width="2%" id="dela"><a href="" id="a" onclick="remove_var(0); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	function add_row(data){
		table = $("#hiddenvar table:first");
		title = table.find("#title");
		newvar = table.clone();
		newvar.attr({"id": "var"+data});
		newvar.find("#title").attr({"name": "var_"+data+"_title", "disabled": ""});
		newvar.find("#price").attr({"name": "var_"+data+"_price", "disabled": ""});
		newvar.find("#dela").html('<a href="" id="a" onclick="remove_var('+data+'); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a>');
		$("#vars").append(newvar);
	}

	function remove_row(data){
		$("#var"+data).empty();
	}

	function add_var(){
		$.get('/admin/adm_prod.php', {"add_var" : 1}, add_row);
	}

	function remove_var(id){
		if(confirm('Удалить вариант приобретения?'))
			$.get('/admin/adm_prod.php', {"del_var" : id}, remove_row);
	}
</script>
			<div class="add" href="" onclick="add_var(); return false;"><img src="<?=$this->path?>/img/add.jpg">Добавить</div><br><br>
			<table class="show" width="100%">
				<tr>
					<th class="show" width="39%">Вариант</th>
					<th class="show" width="39%">Цена</th>
					<th class="show" width="2%"></th>
				</tr>
			</table>
			<div id="vars">		
<?	$Prodvar = new Model_Prodvar();
	$prodvars = $Prodvar->getall(array("where" => "prod = '".ASweb\Db\Db::nq($_GET[id])."'"));
	foreach($prodvars as $k => $r){?>
			<table class="show" id="var<?=$r->id?>" width="100%">
				<tr>
					<td class="show" width="39%"><input type='text' id="title" name='var_<?=$r->id?>_title' style="width: 100%" value="<?=$r->name?>"></td>
					<td class="show" width="39%"><input type='text' id="price" name='var_<?=$r->id?>_price' style="width: 100%" value="<?=$r->price?>"></td>
					<td class="show" width="2%" id="dela"><a href="" onclick="remove_var(<?=$r->id?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
				</tr>
			</table>
	<?}?>
			</div>
<br /><br />