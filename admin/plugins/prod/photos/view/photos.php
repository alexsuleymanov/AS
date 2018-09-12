<?	if ($_GET['id']) {?>

<div class="panel panel-info">
	<div class="panel-heading">
		Дополнительные фотографии
	</div>
	<div class="panel-body">

<?		$Photo = new Model_Photo();
		$photos = $Photo->getall(array("where" => "`type` = 'prod' and par = '".$_GET['id']."'"));
		foreach ($photos as $k => $photo) {?>
	<div class="col-lg-3 col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="col-lg-10">Фото <?=$k?></span> <button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></button>
			</div>
                        
			<div class="panel-body">
				<img src="/thumb?src=pic/photo/<?=$photo->id?>.jpg&width=150&height=150" class="col-lg-12">
				<br>
				<span><?=$photo->name?></span>
			</div>
		</div>
	</div>
<?		}?>
	<div class="col-lg-3 col-sm-6">
		<input type="button" id="prod_photos_upload_button"  class="btn btn-success" style="vertical-align: middle;" value="Загрузить">
	</div>
</div>


<script type="text/javascript">
	var num_photos = <?echo count($photos)?>;
	
	$.ajaxUploadSettings.name = 'userfile[]';
	$('#prod_photos_upload_button').ajaxUploadPrompt({
		multiple: 1,
		url : '/admin/lib/upload.php?multiple=1',
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

	function del_prod_photo(k){
			var fname = $('#prod_photo_image0').attr("src");
			alert(fname);
			$.get("/admin/lib/upload.php?action=delete", {"filename": fname}, function(data){
			$('#prod_photo_image0').attr("src", "/img/tr.gif");
//			$('#prod_photo_image0').css({"width" : "1", "height" : "1"});
//			$('#delete_button_<?=$k?>').css({"display": "none"});
		});
	}
</script>
<? }?>
<?/*				$ftype = ($v['ftype']) ? $v['ftype'] : 'jpg';?>
<?	if($_GET['id']){?>
<div id="prod_photos">
<?		$Photo = new Model_Photo();
		$photos = $Photo->getall(array("where" => "`type` = 'prod' and par = '".$_GET['id']."'"));
		foreach($photos as $k => $photo){?>
	<div id="prod_photo<?=$k?>" style="text-align: center; float: left; width: 200px; margin-right: 10px; display: none;">
		<input type="hidden" name="prod_photo_imagename<?=$k?>" id="prod_photo_imagename<?=$k?>" value="" />
		<img id="prod_photo_image<?=$k?>" alt="" src="" align="absmiddle" width="200"><br /><br />
		<img src="/admin/view/img/b_del.png" align="center" style="cursor: pointer;" onclick="del_prod_photo(<?=$k?>);"/>
	</div>
<?		}?>
</div>
<?	}?>
<input type="button" id="photo_upload_button" value="Загрузить" />
		
<script type="text/javascript">
	var num_photos = <?echo count($photos)?>;
	
	$.ajaxUploadSettings.name = 'userfile[]';
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

	function del_prod_photo(k){
			var fname = $('#prod_photo_image0').attr("src");
			alert(fname);
			$.get("/admin/lib/upload.php?action=delete", {"filename": fname}, function(data){
			$('#prod_photo_image0').attr("src", "/img/tr.gif");
//			$('#prod_photo_image0').css({"width" : "1", "height" : "1"});
//			$('#delete_button_<?=$k?>').css({"display": "none"});
		});
	}

</script>
*/?>