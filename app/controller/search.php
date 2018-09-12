<?	// Controller - Поиск
	$results = 20;
	$start = 0 + $_GET['start'];
	$q = $_GET['q'];

	if($args[1] == 'hint'){
		if($q){
			$format = $args[3];

			$words = preg_split("/[\s\.,\-\=\+!\'\"%\&\(\)]/", $q, -1, PREG_SPLIT_NO_EMPTY);
			$i = 0; $n = 0;

			$cond = array();

			if($args[2] == "prod"){
	   			$Prod = new Model_Prod();
				$cond["where"] = "visible = 1";
				foreach($words as $k => $v){
					$cond["where"] .= " and (id like '%$v%' or name like '%$v%')";
				}
				$cond["limit"] = "$results";
				$prods = $Prod->getall($cond);

				foreach($prods as $prod){
					if($format == 'href'){
						echo "<div style=\"padding; 10px; clear: both;\" onclick=\"/catalog/prod-".$prod->id."\"><img src=\"/pic/prod/".$prod->id.".jpg\" width=\"100\" style=\"float: left;\"/> <h2>".$prod->name."</h2Цена: ".$prod->price." грн.</div>|".$prod->id."\n";
					}elseif($format == '' || $format == 'admin'){
						if($opt['prod_color']){
							$Color = new Model_Color();
							$color = $Color->get($prod->color);
							echo "<div style=\"padding; 10px; clear: both;\"><img src=\"/pic/prod/".$prod->id.".jpg\" width=\"100\" style=\"float: left;\"/> <h2>".$prod->name."</h2>Цена: ".$prod->price." грн.<div>|".$prod->id."|".$prod->color."|".$color->name."\n";
						}else{
							echo "<div style=\"padding; 10px; clear: both;\"><img src=\"/pic/prod/".$prod->id.".jpg\" width=\"100\" style=\"float: left;\"/> <h2>".$prod->name."</h2>Цена ".$prod->price." грн.</div>|".$prod->id."\n";
						}
					}elseif($format == 'simple'){
						echo "<div style=\"padding; 10px; clear: both;\">".$prod->name."</div>|".$prod->id."\n";
					}
				}
			}
			die();
		}
	}

	if($q){
		$text = $q;
		$words = preg_split("/[\s\.,\-\=\+!\'\"%\&\(\)]/", $text, -1, PREG_SPLIT_NO_EMPTY);
		
		if($opt["prods"]){
			$cond = array();
			$Prod = new Model_Prod();
			$cond["where"] = "visible = 1";
			
			foreach($words as $k => $v){
				$cond["where"] .= " and (name like '%$v%' or title like '%$v%')";
			}

			$view->cnt = $Prod->getnum($cond);
			$view->results = $results;
			$view->start = $start;
			$cond["limit"] = "$start, $results";
			
			$prods = $Prod->getall($cond);
			$view->prods = $prods;

		}
		
		$view->bc["/".$args[0]] = $labels["search"];
		$view->page->cont = $view->render('catalog/prod-list.php');
		echo $layout->render($view);
	}else{
		$view->bc["/".$args[0]] = $labels["search"];
		$view->page->cont .= $view->render('search/index.php');
		echo $layout->render($view);
	}
