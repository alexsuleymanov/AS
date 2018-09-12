<style>
	#analog0 .dela.show {
		display: none !important;
	}
</style>

<script type="text/javascript">
	function show_analogrow(){
		$("#hiddenanalog").show();
	}
	function hide_analogrow(){
		$("#hiddenanalog").hide();
	}

	function search_analog(analog) {
		$.get('/admin/adm_prod.php<?=$this->url->gvar("time=")?>', {"search_analog" : 1, "id": <?=$_GET['id']?>, "analog": analog}, function (data) {
			newanalog = $("#analog0");
			
			if(data!='error') {
				$("#analog0 table").show();
				$("#analog_img0").attr({'src': '/pic/prod/' + data[1] + '.jpg', 'width': '100'});
				$("#analog_title0").html('<b>' + data[2] + '</b><br />' + data[3] + 'грн.');
			} else {
				$("#analog0 table").hide();
			}
		}, "json");
	}

	function add_analog(analog) {
		$.get('/admin/adm_prod.php<?=$this->url->gvar("time=")?>', {"add_analog" : 1, "id": <?=$_GET['id']?>, "analog": analog}, function (data) {
			if(data!='error') {
				var newanalog = $("#analog0 table:first-of-type").clone();
				newanalog.attr('id', 'analog' + data[0]);
				newanalog.find("#analog_img0").attr('id', 'analog_img'+data[0]);
				newanalog.find("#analog_title0").attr('id', 'analog_title'+data[0]);
				newanalog.find("#analog_price0").attr('id', 'analog_price'+data[0]);
				newanalog.find(".dela").first().html('<a href="" onclick="remove_analog(' + data[0] + '); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a>');

				newanalog.appendTo("#analogs");
				$('#agsearch0').val('');
				$("#hiddenanalog").hide();
				$("#analog0 table").hide();
			}
		}, "json");
	}

	function remove_analogrow(id){
		$("#analog"+id).remove();
	}

	function remove_analog(id){
		if(confirm('Удалить пожожий товар?')) {
			$.get('/admin/adm_prod.php<?=$this->url->gvar("time=")?>', {"del_analog" : id}, remove_analogrow(id));
		}
	}

	$(document).ready(function(){
		$('#agsearch0').on('input',function(e){
			search_analog($(this).val());
		});
	});
</script>
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="" onclick="show_analogrow(); return false;"><img src="<?=$this->path?>/img/add.jpg">Добавить</a><br><br>
		</div>

		<div id="hiddenanalog" style="display: none;">
			<table id="analog0" class="table table-striped table-bordered table-hover">
				<tr>
					<td style="padding: 10px;">
						<div id="analog_select0">
							Введите Id товара<br>
							<input type="text" id="agsearch0" class="analog_search" size="30" name="q" value="" />
							<input type="button" id="gbutton0" value="Добавить" onclick="add_analog($('#agsearch0').val())"/>
							<br/><br/>
						</div>
						<table cellspacing="0" cellpadding="0" width="300" border="0" class="table table-striped table-bordered table-hover" style="display: none;">
							<tr>
								<td style="padding: 10px;">
									<img id="analog_img0" src="" width="100" style="float: left; margin: 0px 10px 10px 0px;">
									<div id="analog_title0" class="child_title"></div>
									<div id="analog_price0" class="child_price"></div>
								</td>
								<td class="show dela" width="16"><a href="" onclick="remove_analog(<?=$r->id?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
							</tr>
						</table>
					</td>
					<td class="show" width="16"><a href="" onclick="hide_analogrow(); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
				</tr>
			</table>
		</div>

		<div class="panel-body">
			<div class="table-responsive">
				<div id="analogs">
					<?	$Relation = new Model_Relation();
					$analogs = $Relation->getall(array("where" => "type = 'prod-prod-analog' and obj = '". ASweb\Db\Db::nq($_GET[id])."'"));
					foreach($analogs as $k => $r){
						$Prod = new Model_Prod();
						$analog = $Prod->get($r->relation);
						?>
						<table cellspacing="0" cellpadding="0" width="300" border="0" class="table table-striped table-bordered table-hover" id="analog<?=$r->id?>">
							<tr>
								<td style="padding: 10px;">
									<img id="analog_img<?=$r->id?>" src="/pic/prod/<?=$analog->id?>.jpg" width="100" style="float: left; margin: 0px 10px 10px 0px;">
									<div id="analog_title<?=$r->id?>" class="child_title"><b><?=$analog->name?></b></div>
									<div id="analog_price<?=$r->id?>" class="child_price"><?=Func::fmtmoney($analog->price).Zend_Registry::get('cur_name')?></div>
								</td>
								<td class="show dela" width="16"><a href="" onclick="remove_analog(<?=$r->id?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
							</tr>
						</table>
					<?}?>
				</div>
			</div>
		</div>
	</div>
</div>