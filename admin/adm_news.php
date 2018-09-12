<?	require("incl.php");

	if($opt['news_rating']) $Plugins->loadplugin("news_rating");

	//---- GENERAL ----

	$title = "Новости";
	$model = "Model_Page";
	$model_type = "news";
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

		$row->intname = "<span class=\"lnk\">http://".$_SERVER[HTTP_HOST]."/news/".trim($row->intname, "/")."</span>";
		$row->comments = "<a href=\"adm_comments.php?type=news&par=".$row->id."\"> [Отзывы] </a>";

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
			'location' => "pic/news",
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
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
			'content' => $Plugins->get('news_rating')->render($view),
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

	if(!$opt["news_comments"]){
		unset($fields["comments"]);
	}

	if(!$opt['news_rating']) unset($fields['rating']);

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	
	require("lib/admin.php");