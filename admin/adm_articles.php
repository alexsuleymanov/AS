<?	require("incl.php");

	if($opt['articles_rating']) $Plugins->loadplugin("articles_rating");

	//---- GENERAL ----

	$title = "Статьи";
	$model = "Model_Page";
	$model_type = "article";
	$default_order = "tstamp";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$par = 0 + $_GET[par];

	//---- SHOW ----
	$show_cond = array();

	function showhead() {
	}

	function onshow($row) {
		extract($GLOBALS);

		$row->intname = "<span class=\"lnk\">http://".$_SERVER[HTTP_HOST]."/articles/".trim($row->intname, "/")."</span>";
		$row->comments = "<a href=\"adm_comments.php?type=article&par=".$row->id."\"> [Отзывы] </a>";
		return $row;
	}

	$fields = array(
		'tstamp' => array(
			'label' => "Дата добавления",
			'type' => 'date',
			'value' => time(),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
			'multylang' => 0,
		),
		'pic' => array(
			'label' => "Иконка",
			'type' => 'image',
			'location' => "pic/article",
//			'width' => 300,
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'watermark' => 0,
		),
		'intname' => array(
			'label' => "Имя для URL",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'name' => array(
			'label' => "Заголовок для меню",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
        'cont' => array(
			'label' => "Содержимое",
			'type' => 'html',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
        'visible' => array(
			'label' => "Отображать на сайте",
			'type' => 'checkbox',
			'value' => 1,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
        'noindex' => array(
			'label' => "Не индексировать",
			'type' => 'checkbox',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
		'rating' => array(
			'label' => "Рейтинг",
			'comment' => "",
			'type' => 'custom',
			'content' => $Plugins->get('articles_rating')->render($view),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),		
        'cats' => array(
			'label' => 'Категории',
			'type' => 'multiselecttree',
			'relation' => 'cat-article',
			'obj-rel' => 'relation',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'tags' => array(
			'label' => 'Теги',
			'type' => 'multiselect',
			'relation' => 'article-tag',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
        'delim' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<h2 align=center>Параметры для оптимизации</h2><hr>",
			'show' => 0,
			'edit' => 1,
			'set' => 0,
		),
		'title' => array(
			'label' => "Заголовок &lt;title&gt;",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
		'h1' => array(
			'label' => "Заголовок &lt;H1&gt;",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
		'kw' => array(
			'label' => "Keywords",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
		'descr' => array(
			'label' => "Description",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
		'type' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<input type=\"hidden\" name=\"type\" value=\"".$model_type."\">",
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
		'comments' => array(
			'label' => "Отзывы",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'multylang' => 0,
		),
	);

	if(!$opt["articles_comments"]){
		unset($fields["comments"]);
	}

	if(!$opt["articles_rating"]){
		unset($fields["rating"]);
	}

	if($opt["articles_tags"]){
		$Tag = new Model_Tag();
		$rc = $Tag->getall(array("order" => "name"));
		foreach($rc as $k => $v) $fields['tags'][items][$v->id] = $v->name;
	}else{
		unset($fields["tags"]);
	}

	if($opt["articles_cats"]){
		$Cat = new Model_Cat();
		$rc = $Cat->getall(array("order" => "name"));
		foreach($rc as $k => $v){
			$fields['cats']['items'][] = array("id" => $v->id, "par" => $v->cat, "name" => $v->name);
		}
	}else unset($fields["cats"]);

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	
	require("lib/admin.php");