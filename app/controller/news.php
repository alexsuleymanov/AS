<?// Controller - Новости
	$results = 15;
	$start = 0 + $_GET['start'];

	foreach($args as $k=>$v){
		if(preg_match("/archive-(\d+)-(\d+)/", $v, $m)){
			$archive = 1;
			$archive_year = 0 + $m[1];
			$archive_month = 0 + $m[2];
		}
		if(preg_match("/cat-(\d+)-(.*?)/", $v, $m))
			$cat = 0 + $m[1];
		if(preg_match("/tag-(\d+)-(.*?)/", $v, $m))
			$tag = 0 + $m[1];
	}

	if($cat || $tag || $archive){
		$_intname = "";
	}else{
	    $_intname = $args[1];
	}

	$view->bc["/".$args[0]] = $view->page->name;

	if(empty($_intname)){
		$News = new Model_Page('news');
		$cond = array(
			"where" => "visible = 1",
			"order" => "tstamp desc",
		);

		if($archive){
			$t1 = mktime(0, 0, 0, $archive_month, 1, $archive_year);
			$t2 = mktime(0, 0, 0, $archive_month+1, 1, $archive_year);
			$cond["where"] .= " and tstamp > '".$t1."' and tstamp < '".$t2."'";

			$view->page->title .= ". ".$archive_year.", ".$archive_month;
		}

		$view->cnt = $News->getnum($cond);
		$view->results = $results;
		$view->start = $start;
		
		$cond["limit"] = "$start, $results";

		$view->news = $News->getall($cond);

		$view->page->cont = $view->render('news/list.php');
		$view->page->cont .= $view->render('block/rule.php');

		echo $layout->render($view);
	}else{
		$News = new Model_Page('news');
		$view->news = $News->getbyname($_intname);
		
		if(!$view->news->id){
		    echo $layout->error_404($view);
			exit();
		}

		$view->page->id = $view->news->id;
		$view->page->intname = $view->news->intname;
		$view->page->name = $view->news->name;
		$view->page->title = ($view->news->title) ? $view->news->title : $view->news->name;
		$view->page->kw = $view->news->kw;
		$view->page->descr = $view->news->descr;
		$view->page->h1 = ($view->news->h1) ? $view->news->h1 : $view->news->name;
		$view->page->cont = $view->news->cont;

		$view->bc["/".$args[0]."/".$_intname] = $view->page->name;
		$view->canonical = "/".$args[0]."/".$view->news->intname;

		if($opt["news_rating"]){
			$view->page->rating = $News->getrating($view->news->id);
			$view->page->cont .= $view->render("news/rating.php");
		}

		echo $layout->render($view);
	}
