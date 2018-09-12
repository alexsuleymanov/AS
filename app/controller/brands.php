<?// Controller - Список брендов

	$results = 15;
	$start = 0 + $_GET['start'];

	$_pagename = $args[0];
	$_intname = $args[1];

	$view->bc["/".$args[0]] = $labels["brands"];

	if(empty($_intname)){
		$Brand = new Model_Brand();
		$view->brands = $Brand->getall(array("where" => "visible = 1", "order" => "name"));

		$view->page->cont = $view->render('brands/list.php');
		echo $layout->render($view);
	}else{
		$Brand = new Model_Brand();
		$brand = $Brand->getbyname($_intname);
		$view->brand = $brand;
		$view->page->id = $view->brand->id;
		$view->page->intname = $view->brand->intname;
		$view->page->name = $view->brand->name;
		$view->page->title = ($view->brand->title) ? $view->brand->title : $view->brand->name;
		$view->page->kw = $view->brand->kw;
		$view->page->descr = $view->brand->descr;
		$view->page->h1 = ($view->brand->h1) ? $view->brand->h1 : $view->brand->name;
		$view->page->cont = $view->brand->cont;

		$view->bc["/".$args[0]."/".$_intname] = $view->page->name;

		if($brand){
			$Cat = new Model_Cat();
			$cats = $Cat->getbybrand($brand->id);
			$view->cats = $cats;

			if(!empty($view->cats))
				$view->page->cont .= $view->render('brands/cats.php');

			echo $layout->render($view);			
		}else{
		    echo $layout->error_404();
		}
	}
