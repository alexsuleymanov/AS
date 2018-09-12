<?
	$Brand = new Model_Brand();
	$Cat = new Model_Cat();
	$cats = $Cat->getall(array("where" => "cat = 0 and visible = 1", "order" => "rand()", "limit" => 4));
?>

<div class="mbp">
	<h2 class="upp"><?=$cats[0]->name?></h2>
	<?
		$brands = $Brand->getall(array("where" => "visible = 1", "limit" => "7", "order" => "rand()"));
		foreach ($brands as $brand) {?>
		<div class="mbp1"><a href="/"><?=$brand->name?></a></div>
	
		<?}
	?>
</div>
<div class="mbp2">
	<h2 class="upp"><?=$cats[1]->name?></h2>
	<?
		$brands = $Brand->getall(array("where" => "visible = 1", "limit" => "7", "order" => "rand()"));
		foreach ($brands as $brand) {?>
		<div class="mbp1"><a href="/"><?=$brand->name?></a></div>
	
		<?}
	?>
</div>
<div class="mbp2">
	<h2 class="upp"><?=$cats[2]->name?></h2>
	<?
		$brands = $Brand->getall(array("where" => "visible = 1", "limit" => "7", "order" => "rand()"));
		foreach ($brands as $brand) {?>
		<div class="mbp1"><a href="/"><?=$brand->name?></a></div>
	
		<?}
	?>
</div>
<div class="mbp2">
	<h2 class="upp"><?=$cats[3]->name?></h2>
	<?
		$brands = $Brand->getall(array("where" => "visible = 1", "limit" => "7", "order" => "rand()"));
		foreach ($brands as $brand) {?>
		<div class="mbp1"><a href="/brands/<?=$brand->intname?>"><?=$brand->name?></a></div>
	
		<?}
	?>
</div>

<div class="clear"></div>

<div class="allbrands2">
	<a href="/brands"><img src="<?=$this->path?>/img/allbrands.png" alt="more" /></a>
</div>