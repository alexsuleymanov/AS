<?	require("incl.php");

	if($opt["actions_prods"]) $Plugins->loadplugin("actions_prods");

	//---- GENERAL ----

	$title = "Акции";
	$model = "Model_Page";
	$model_type = "actions";
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

		$row->intname = "<span class=\"lnk\">http://".$_SERVER[HTTP_HOST]."/actions/".trim($row->intname, "/")."</span>";
		$row->comments = "<a href=\"adm_comments.php?type=actions&par=".$row->id."\"> [Отзывы] </a>";

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
			'location' => "pic/actions",
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
		'href' => array(
			'label' => "Ссылка на страницу",
			'type' => 'text',
			'show' => 0,
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
		'prods' => array(
			'label' => "Товары",
			'type' => 'custom',
			'content' => $Plugins->get('actions_prods')->render($view),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
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

	if(!$opt["actions_comments"]){
		unset($fields["comments"]);
	}

	if(!$opt["actions_prods"]){
		unset($fields["prods"]);
	}

	if(!$opt['actions_prods']) unset($fields["prods"]);

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	
	require("lib/admin.php");