<ul>
<?	$Prod = new Model_Prod();
	$prods = $Prod->getall(array("where" => "visible = 1 and globalcat != 0", "limit" => "40", "order" => "rand()"));
	foreach($prods as $prod){
		$Cat = new Model_Globalcat();
		$cat = $Cat->getone(array("where" => "id = $prod->globalcat"));?>
	<li>
		<div class="info">
			<a href="/catalog/<?=$cat->intname?>/<?=$prod->intname?>"><?=$prod->name?></a>
			<span class="cat"><?=$prod->short?></span>
		</div>
		<div class="clear"></div>
	</li>
<?	}?>
</ul>