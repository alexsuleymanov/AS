<style>
	#child0 .dela.show {
		display: none !important;
	}
</style>

<script type="text/javascript">
	function show_childrow(){
		$("#hiddenchild").show();
	}
	function hide_childrow(){
		$("#hiddenchild").hide();
	}

	function search_child(child) {
		$.get('/admin/adm_prod.php<?=$this->url->gvar("time=")?>', {"search_child" : 1, "id": <?=$_GET['id']?>, "child": child}, function (data) {
			newchild = $("#child0");
			if(data!='error') {
				$("#child0 table").show();
				$("#child_img0").attr({'src': '/pic/prod/' + data[1] + '.jpg', 'width': '100'});
				$("#child_title0").html('<b>' + data[2] + '</b><br />' + data[3] + 'грн.');
			} else {
				$("#child0 table").hide();
			}
		}, "json");
	}

	function add_child(child) {
		$.get('/admin/adm_prod.php<?=$this->url->gvar("time=")?>', {"add_child" : 1, "id": <?=$_GET['id']?>, "child": child}, function (data) {
			if(data!='error') {
				var newchild = $("#child0 table:first-of-type").clone();
				newchild.attr('id', 'child' + data[0]);
				newchild.find("#child_img0").attr('id', 'child_img'+data[0]);
				newchild.find("#child_title0").attr('id', 'child_title'+data[0]);
				newchild.find("#child_price0").attr('id', 'child_price'+data[0]);
				newchild.find(".dela").first().html('<a href="" onclick="remove_child(' + data[0] + '); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a>');

				newchild.appendTo("#childs");
				$('#gsearch0').val('');
				$("#hiddenchild").hide();
				$("#child0 table").hide();
			}
		}, "json");
	}

	function remove_childrow(id){
		$("#child"+id).remove();
	}

	function remove_child(id){
		if(confirm('Удалить пожожий товар?')) {
			$.get('/admin/adm_prod.php<?=$this->url->gvar("time=")?>', {"del_child" : id}, remove_childrow(id));
		}
	}

	$(document).ready(function(){
		$('#gsearch0').on('input',function(e){
			search_child($(this).val());
		});
	});
</script>
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="" onclick="show_childrow(); return false;"><img src="<?=$this->path?>/img/add.jpg">Добавить</a><br><br>
		</div>

		<div id="hiddenchild" style="display: none;">
			<table id="child0" class="table table-striped table-bordered table-hover">
				<tr>
					<td style="padding: 10px;">
						<div id="child_select0">
							Введите Id товара<br>
							<input type="text" id="gsearch0" class="child_search" size="30" name="q" value="" />
							<input type="button" id="gbutton0" value="Добавить" onclick="add_child($('#gsearch0').val())"/>
							<br/><br/>
						</div>
						<table cellspacing="0" cellpadding="0" width="300" border="0" class="table table-striped table-bordered table-hover" style="display: none;">
							<tr>
								<td style="padding: 10px;">
									<img id="child_img0" src="" width="100" style="float: left; margin: 0px 10px 10px 0px;">
									<div id="child_title0" class="child_title"></div>
									<div id="child_price0" class="child_price"></div>
								</td>
								<td class="show dela" width="16"><a href="" onclick="remove_child(<?=$r->id?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
							</tr>
						</table>
					</td>
					<td class="show" width="16"><a href="" onclick="hide_childrow(); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
				</tr>
			</table>
		</div>

		<div class="panel-body">
			<div class="table-responsive">
				<div id="childs">
					<?	$Relation = new Model_Relation();
					$childs = $Relation->getall(array("where" => "type = 'prod-prod' and obj = '". ASweb\Db\Db::nq($_GET[id])."'"));
					foreach($childs as $k => $r){
						$Prod = new Model_Prod();
						$child = $Prod->get($r->relation);
						?>
						<table cellspacing="0" cellpadding="0" width="300" border="0" class="table table-striped table-bordered table-hover" id="child<?=$r->id?>">
							<tr>
								<td style="padding: 10px;">
									<img id="child_img<?=$r->id?>" src="/pic/prod/<?=$child->id?>.jpg" width="100" style="float: left; margin: 0px 10px 10px 0px;">
									<div id="child_title<?=$r->id?>" class="child_title"><b><?=$child->name?></b></div>
									<div id="child_price<?=$r->id?>" class="child_price"><?=Func::fmtmoney($child->price).Zend_Registry::get('cur_name')?></div>
								</td>
								<td class="show dela" width="16"><a href="" onclick="remove_child(<?=$r->id?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
							</tr>
						</table>
					<?}?>
				</div>
			</div>
		</div>
	</div>
</div>