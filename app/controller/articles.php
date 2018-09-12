<?// Controller - Статьи
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
		$Article = new Model_Page('article');
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

		if($cat){
			$Cat = new Model_Cat();
			$cat = $Cat->getone(array("where" => "id = '".ASweb\Db\Db::nq($cat)."'"));

			$view->page->title = $view->page->title.". ".$cat->name;
			$view->page->kw = ($view->page->kw) ? $view->page->kw.", ".$cat->kw : "";
			$view->page->descr = ($view->page->descr) ? $view->page->descr.". ".$cat->name : "";

			$cond["relation"] = array("select" => "relation", "where" => "`type` = 'cat-article' and obj = '".ASweb\Db\Db::nq($cat->id)."'");

			$view->canonical = "/".$args[0]."/cat-".$cat->id."-".$cat->intname;

			$tree = array_reverse($Cat->get_cat_tree_up($cat->id));

			foreach($tree as $k => $v){
				$Cat = new Model_Cat();
				$cat_row = $Cat->get($v->id);
				$view->bc["/".$args[0]."/cat-".$cat_row->id."-".$cat_row->intname] = $cat_row->name;
			}
		}

		if($tag){
			$Tag = new Model_Tag();
			$tag = $Tag->getone(array("where" => "id = '".ASweb\Db\Db::nq($tag)."'"));

			$view->page->title = $view->page->title.". ".$tag->name;
			$view->page->kw = ($view->page->kw) ? $view->page->kw.", ".$tag->kw : "";
			$view->page->descr = ($view->page->descr) ? $view->page->descr.". ".$tag->name : "";

			$cond["relation"] = array("select" => "obj", "where" => "`type` = 'article-tag' and relation = '".ASweb\Db\Db::nq($tag->id)."'");
			$view->canonical = "/".$args[0]."/tag-".$tag->id."-".$tag->intname;
		}

		$view->cnt = $Article->getnum($cond);
		$view->results = $results;
		$view->start = $start;
		
		$cond["limit"] = "$start, $results";

		$view->articles = $Article->getall($cond);

		$view->page->cont = $view->render('articles/list.php');
		$view->page->cont .= $view->render('block/rule.php');

		echo $layout->render($view);
	}else{
		$Article = new Model_Page('article');
		$view->article = $Article->getbyname($_intname);
		
		if(!$view->article->id){
		    echo $layout->error_404($view);
			exit();
		}

		$view->page->id = $view->article->id;
		$view->page->intname = $view->article->intname;
		$view->page->name = $view->article->name;
		$view->page->title = ($view->article->title) ? $view->article->title : $view->article->name;
		$view->page->kw = $view->article->kw;
		$view->page->descr = $view->article->descr;
		$view->page->h1 = ($view->article->h1) ? $view->article->h1 : $view->article->name;
		$view->page->cont = $view->article->cont;

		$view->bc["/".$args[0]."/".$_intname] = $view->page->name;
		$view->canonical = "/".$args[0]."/".$view->article->intname;

		if($opt["articles_rating"]){
			$view->page->rating = $Article->getrating($view->article->id);
			$view->page->cont .= $view->render("articles/rating.php");
		}

		if($opt["articles_comments"]){
			$form = new Form_Comment('article');
			$form->addDecorator(new Form_Decorator_Ajax());
			$form->getElement('type')->setValue('article');
			$view->form = $form->render($view);

			$view->comments = $Article->getcomments($view->article->id);

			$view->page->cont .= $view->render("articles/comments.php");
		}

		echo $layout->render($view);
	}
