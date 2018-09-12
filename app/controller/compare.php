<?// Controller - Сравнение

	$action = $args[1];
	$cat = $args[2];
	$prod = $args[3];

	$view->bc["/".$args[0]] = $labels["compare"];

	if($action == "add"){
		$Compare->add($cat, $prod);
		$result = array("count" => $Compare->count($cat), "prods" => $Compare->getall($cat), "url" => $Compare->url($cat));
		echo Zend_Json::encode($result);
	}elseif($action == "del"){
		$Compare->del($cat, $prod);
		if(Func::is_ajax()){
			$result = array("count" => $Compare->count($cat), "prods" => $Compare->getall($cat), "url" => $Compare->url($cat));
			echo Zend_Json::encode($result);
			
		}else{
			$url->redir($Compare->url($cat));
		}
	}elseif($action == "cmp" && $cat){		
		$Prod = new Model_Prod();
		$Cat = new Model_Cat();
		
		$view->prods = array();
		$view->prod_chars = array();

		if($args[3]) $ids = explode("-", $args[3]);
		else $ids = $Compare->getall($cat);

		foreach($ids as $k => $v){			
			$view->prods[$v] = $Prod->get($v);
			$view->prod_chars[$v] = $Prod->getprodchars($v);
		}

		if($opt["char_cats"]){
			$Charcat = new Model_Charcat();
			$view->charcats = $Charcat->getall(array("where" => $Cat->cat_tree($cat)));
		}
		$Char = new Model_Char();
		$view->chars = $Char->getall(array("where" => $Cat->cat_tree($cat)));
		$view->page = new stdClass();
		
		if(empty($args[3])) echo $view->page->cont = $view->render("compare/empty.php");
		else $view->page->cont = $view->render("compare/show.php");
		echo $layout->render($view);
	}