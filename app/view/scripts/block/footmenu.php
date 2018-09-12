<div class="col-sm-3">
	<h5 class="title"><?=$this->labels['info']?></h5>
	<ul class="list alt-list">
		<?	$model_page = new Model_Page('page');
		$Menus = $model_page->getall(array("where" => "page = 0 and visible = 1", "order" => "prior desc", "limit" => "4"));
		foreach($Menus as $k => $menu_r) {?>
			<li><a href="<?=$this->url->mk("/".$menu_r->intname)?>"><i class="fa fa-angle-right"></i><?=$menu_r->name?></a></li>
		<?}?>
	</ul>
</div><!-- end col -->
<div class="col-sm-3">
	<h5 class="title"><?=$this->labels['news']?></h5>
	<ul class="list alt-list">
		<?	$News = new Model_Page('news');
		$news = $News->getall(array("where" => "visible = 1", "order" => "prior desc", "limit" => "4"));
		?>
		<?foreach($news as $k2 => $menu_r2) {?>
			<li><a href="<?=$this->url->mk("/articles/".$menu_r2->intname)?>"><i class="fa fa-angle-right"></i><?=$menu_r2->name?></a></li>
		<?}?>
	</ul>
</div><!-- end col -->
<div class="col-sm-3">
	<h5 class="title"><?=$this->labels['articles']?></h5>
	<ul class="list alt-list">
		<?	$Articles = new Model_Page('article');
		$articles = $Articles->getall(array("where" => "visible = 1", "order" => "prior desc", "limit" => "4"));
		?>
		<?foreach($articles as $k2 => $menu_r2) {?>
			<li><a href="<?=$this->url->mk("/articles/".$menu_r2->intname)?>"><i class="fa fa-angle-right"></i> <?=$menu_r2->name?></a></li>
		<?}?>
	</ul>
</div><!-- end col -->