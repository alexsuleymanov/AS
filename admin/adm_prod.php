<?	require("incl.php");

	if($opt['prod_photos']) $Plugins->loadplugin("prod_photos");
	if($opt['prod_vars']) $Plugins->loadplugin("prod_vars");
	if($opt['prod_chars'] && $_GET['cat']) $Plugins->loadplugin("prod_chars");
	if($opt['prod_childs']) $Plugins->loadplugin("prod_childs");
	if($opt['prod_analogs']) $Plugins->loadplugin("prod_analogs");
	if($opt['prod_kit']) $Plugins->loadplugin("prod_kit");
	if($opt['prod_colors']) $Plugins->loadplugin("prod_colors");
	if($opt['prod_rating']) $Plugins->loadplugin("prod_rating");
	if($opt['prod_discounts']) $Plugins->loadplugin("prod_discount");

	//---- GENERAL ----

	$title = "Товары";
	$model = "Model_Prod";
	$default_order = "prior";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$cat = 0 + $_GET[cat];
	$brand = 0 + $_GET[brand];
	$id = 0 + $_GET[id];

	//---- SHOW ----
	$show_cond = array("where" => "1");
	if($cat) $show_cond["where"] .= " and cat = '$cat'";
	if($brand) $show_cond["where"] .= " and brand = '$brand'";


	function showhead() {
		global $url, $cat, $char_cat, $opt;

		$Cat = new Model_Cat();
		$cat = $Cat->get($cat);
    	$str = "<h3>".$cat->name."</h3><a href=\"adm_cat.php".$url->gvar("brand=&cat=".$cat->par."&p=")."\"> <- Назад</a><p>";

		if($opt['prod_chars']){
			$Char = new Model_Char();
			$Char->delete_empty_vals();
		}

		return $str;
	}

	function onshow($row) {
		global $url, $opt;

		$row->photos = "<a href=\"adm_photo.php".$url->gvar("p=&type=prod&par=".$row->id)."\"> [Фотографии] </a>";
		$row->comments = "<a href=\"adm_comments.php".$url->gvar("p=&type=prod&par=".$row->id)."\"> [Отзывы] </a>";

		return $row;
	}

	$fields = array(
		'cat' => array(
			'label' => "Категория",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'brand' => array(
			'label' => "Бренд",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'pic' => array(
			'label' => "Большое фото",
			'comment' => "",
			'type' => 'image',
			'ftype' => 'jpg',
			'location' => "pic/prod",
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'watermark' => 1,
		),
/*		'pic2' => array(
			'label' => "Доп. фото",
			'comment' => "",
			'type' => 'custom',
			'content' => $Plugins->get('prod_photos')->render($view),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'watermark' => 1,
		),*/
		'art' => array(
			'label' => "Артикул",
			'type' => 'text',
			'value' => '',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'name' => array(
			'label' => "Заголовок",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
		'price' => array(
			'label' => "Цена",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'discount' => array(
			'label' => "Скидка",
			'comment' => "",
			'type' => 'custom',
			'content' => $Plugins->get('prod_discount')->render($view),
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'short' => array(
			'label' => "Краткое описание",
			'comment' => "",
			'type' => 'textarea',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 1,
		),
		'cont' => array(
			'label' => "Полное описание",
			'comment' => "",
			'type' => 'html',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 1,
		),
        'prior' => array(
			'label' => "Приоритет",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
        'visible' => array(
			'label' => "Отображать на сайте",
			'type' => 'checkbox',
			'value' => 1,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
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
        'inprice' => array(
			'label' => "Отображать в прайсах",
			'type' => 'checkbox',
			'value' => 1,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
		'rating' => array(
			'label' => "Рейтинг",
			'comment' => "",
			'type' => 'custom',
			'content' => $Plugins->get('prod_rating')->render($view),
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
			'name' => 'Теги',
			'type' => 'multiselect',
			'relation' => 'prod-tag',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'additionalphotos' => array(
			'name' => "Доп. Фото",
			'label' => "",
			'comment' => "",
			'type' => 'custom',
			'content' => $Plugins->get('prod_photos')->render($view),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'photos' => array(
			'label' => "Фотографии",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
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
		'vars' => array(
			'name' => "Варианты приобретения",
			'comment' => "",
			'type' => 'custom',
			'content' => $Plugins->get('prod_vars')->render($view),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),		
		'chars' => array(
			'name' => "Характеристики",
			'comment' => "",
			'type' => 'custom',
			'content' => $Plugins->get('prod_chars')->render($view),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),		
		'childs' => array(
			'name' => "Сопутствующие товары",
			'comment' => "",
			'type' => 'custom',
			'content' => $Plugins->get('prod_childs')->render($view),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),		
		'analogs' => array(
			'label' => "Аналоги",
			'comment' => "",
			'type' => 'custom',
			'content' => $Plugins->get('prod_analogs')->render($view),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'colors' => array(
			'label' => "Варианты цветов",
			'comment' => "",
			'type' => 'custom',
			'content' => $Plugins->get('prod_colors')->render($view),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'kit' => array(
			'label' => "Комплект",
			'comment' => "",
			'type' => 'custom',
			'content' => $Plugins->get('prod_kit')->render($view),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'sale' => array(
			'label' => "Скидки",
			'comment' => "",
			'type' => 'custom',
			'content' => $Plugins->get('prod_sale')->render($view),
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
	);

	if($opt["prod_cats"]){
		$Cat = new Model_Cat();
		$rows = $Cat->getall(array("where" => "id = $cat"));
		if(empty($_GET['cat'])){
			$rows = $Cat->getall(array("order" => "name desc"));
			$fields["cat"]["items"][0] = "Нет";
		}
		foreach($rows as $k => $r) $fields["cat"]["items"][$r->id] = $r->name;

		unset($fields['cats']);
	}else{
		unset($fields["cat"]);
	}

	if($opt["prod_multicats"]){
		$Cat = new Model_Cat();
		$rc = $Cat->getall(array("order" => "name"));
		foreach($rc as $k => $v){
			$fields['cats']['items'][] = array("id" => $v->id, "par" => $v->cat, "name" => $v->name);
		}
		unset($fields["cat"]);
	}else{
		unset($fields["cats"]);
	}

	if($opt["prod_brands"]){
		$Brand = new Model_Brand();
		$rows = $Brand->getall(array("order" => "name desc"));
		foreach($rows as $k => $r) $fields["brand"]["items"][$r->id] = $r->name;
	}else{
		unset($fields["brand"]);
	}

	if($opt["prod_tags"]){
		$Tag = new Model_Tag();
		$rc = $Tag->getall(array("order" => "name"));
		foreach($rc as $k => $v) $fields['tags'][items][$v->id] = $v->name;
	}else{
		unset($fields["tags"]);
	}

	if(!$opt["prod_vars"]){
		unset($fields["vars"]);
	}

	if(!$opt["prod_chars"]){
		unset($fields["chars"]);
	}

	if(!$opt["prod_comments"]){
		unset($fields["comments"]);
	}

	if(!$opt["prod_childs"]){
		unset($fields["childs"]);
	}

	if(!$opt["prod_analogs"]){
		unset($fields["analogs"]);
	}

	if(!$opt["prod_points"]){
		unset($fields["points"]);
	}

	if(!$opt["prod_kit"]){
		unset($fields["kit"]);
	}

	if(!$opt["prod_colors"]){
		unset($fields["colors"]);
	}

	if(!$opt["prod_sale"]){
		unset($fields["sale"]);
	}

	if(!$opt["prod_rating"]){
		unset($fields["rating"]);
	}


	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}
	
	require("lib/admin.php");