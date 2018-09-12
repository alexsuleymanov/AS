<?
$opt = Zend_Registry::get('opt');
//	par == 1  Основные параметры
//	par == 2  Расширенные параметры
//  par == 3  Все параметры

$par = 0 + $this->params;
$cat = 0 + $this->cat->id;
?>
<!-- Shopping Options Starts -->
<h6 class="text-uppercase"><?=$this->labels['filters']?></h6>
<div class="list-group extsearch">

	<form action="/<?=$this->args[0]?>/<?=$this->args[1]?>" method="get" id="es">
		<input type="hidden" name="filter" value="1" />

		<?	if($opt["prod_brands"]){?>
			<div class="list-group-item">
				<?=$this->labels["manufacturer"]?>
			</div>
			<div class="list-group-item">
				<div class="filter-group">
<?					$brands = $this->model->Brand->Plugin('Cat')->getbycat($cat);
					foreach($brands as $brand) {
						?>
						<label class="checkbox">
							<input name="brand<?=$brand->id?>" type="checkbox" onchange="$('#es').submit();" value="<?=$brand->id?>" <?if($_GET["brand".$brand->id]) echo "checked";?> />
							<?=$brand->name?>
						</label>
					<?	}?>
				</div>
			</div>

		<?	}?>
		<?	if($opt["prod_chars"]){?>
			<?
			$Char = new Model_Char();
			if($par == 1 || $par == 0)
				$chars = $Char->getall(array("where" => $this->model->Cat->cat_tree($cat)." and search = '1'", "order" => "prior desc"));
			else if($par == 2)
				$chars = $Char->getall(array("where" => $this->model->Cat->cat_tree($cat)." and (search = '1' or search = '2')", "order" => "prior desc"));
			else
				$chars = $Char->getall(array("where" => $this->model->Cat->cat_tree($cat)." and (search = '1' or search = '2' or search = '3')", "order" => "prior desc"));
			?>
			<div class="list-group-item">
				<?=$this->labels["price"]?>
			</div>
			<div class="list-group-item">
				<div class="filter-group">
					от <input type="text" name="minprice" size="5" value="<?=$_GET["minprice"]?>" /> до <input type="text" name="maxprice" size="5" value="<?=$_GET["maxprice"]?>" /> грн.
				</div>
			</div>

			<?		foreach($chars as $r){
				if($r->type == 1){	//есть/нет?>
					<div class="list-group-item">
						<?=$r->name?>
					</div>
					<div class="list-group-item">
						<div class="filter-group">
							<input type="checkbox" name="char<?=$r->id?>" value="1" <?if($_GET["char".$r->id]) echo "checked";?> />
						</div>
					</div>

				<?			}else if($r->type == 2){	//число?>
					<div class="list-group-item">
						<?=$r->name?>
					</div>
					<div class="list-group-item">
						<div class="filter-group">
							от <input type="text" size="5" name="char<?=$r->id?>from" onchange="$('#es').submit();" value="<?=$_GET["char".$r->id."from"]?>" /> до <input type="text" size="5" name="char<?=$r->id?>to" onchange="$('#es').submit();" value="<?=$_GET["char".$r->id."to"]?>"> <?=$r->izm?>
						</div>
					</div>

				<?			}else if($r->type == 4){    //набор значений?>
					<div class="list-group-item">
						<?=$r->name?>
					</div>
					<div class="list-group-item">
						<div class="filter-group">
							<?				$Charval = new Model_Charval();
							$charvals = $Charval->getall(array("where" => "`char` = '".$r->id."'"));?>
							<?				foreach($charvals as $charval){?>
								<label class="checkbox">
									<input type="checkbox" name="char<?=$r->id?>[]" onchange="$('#es').submit();" value="<?=$charval->id?>" <?if(is_array($_GET["char".$r->id]) && in_array($charval->id, $_GET["char".$r->id])) echo "checked";?>>
									<?=$charval->value?>
								</label>
							<?				}?>

						</div>
					</div>
				<?			}?>
			<?		}?>

		<?	}?>
		<div class="list-group-item">
			<button type="submit" class="btn btn-default btn-block btn-md" onclick="$('#es').submit();">Подобрать</button>
		</div>
	</form>
</div>
<!-- Shopping Options Ends -->
