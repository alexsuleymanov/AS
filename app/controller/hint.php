<?
	$results = 20;
	$type = $_GET['type'];
	$q = $_GET['q'];
	$format = $args[2];

	if($q){
		$q = $q;
		$words = preg_split("/[\s\.,\-\=\+!\'\"%\&\(\)]/", $q, -1, PREG_SPLIT_NO_EMPTY);
		$i = 0; $n = 0;

		$cond = array();

		if($args[1] == "prod"){
   			$Prod = new Model_Prod();
			$Cat = new Model_Cat();
			
			$cond["where"] = "visible = 1";
			foreach($words as $k => $v){
				$cond["where"] .= " and (id like '%$v%' or name like '%$v%')";
			}
			$cond["limit"] = "$results";
			$prods = $Prod->getall($cond);

			foreach($prods as $prod){
				$cat = $Cat->get($prod->cat);
				/*echo $prod->name."|".$prod->id."\n";*/?>
				<a href="/catalog/<?=$cat->intname?>/<?=$prod->id?>"><div class="hint-item-left"><?if(file_exists('pic/prod/'.$prod->id.'.jpg')){?><img src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&width=50" alt="<?=$prod->name?>" title="<?=$prod->name?>" class="img-thumbnail img-responsive"><?}?></div><div class="hint-item-right"><div class="hir-1"><?=$prod->name?></div><div class="hir-2"><?=Func::fmtmoney($prod->price).$view->sett["valuta"]?></div></div></a>
			<?}
		}
	}
