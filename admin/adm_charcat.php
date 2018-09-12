<?	require("incl.php");
	//---- GENERAL ----

	$title = "Группы Характеристик";
	$model = "Model_CharCat";
	$default_order = "prior";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$cat = 0 + $_GET[cat];

	//---- SHOW ----
	$show_cond = array("where" => "cat = '".ASweb\Db\Db::nq($cat)."'");

	function showhead() {
		global $url, $cat;

		$Cat = new Model_Cat();
		$cat = $Cat->get($cat);
		$str .= "<h3>".$cat->name."</h3>";

		$back = $cat->par;
		if(isset($back))
			$str .= "<a href=\"adm_cat.php".$url->gvar("cat=".$back."&p=")."\"><- Назад</a><br><br>";

		return $str;
	}

	function onshow($row) {
		global $title, $cat, $url, $opt;

		$row->char = "<div align=center><a href=\"adm_char.php".$url->gvar("p=&charcat=".$row->id)."\"> [Характеристики] </a></div>";

		return $row;
	}

	$fields = array(
		'cat' => array(
			'label' => "Родительская",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
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
		'char' => array(
			'label' => "Характеристики",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
		),
	);

	if($opt["prod_cats"]){
		if($cat){
			$Cat = new Model_Cat();
			$cats = $Cat->getall(array("where" => "id = $cat"));
			foreach($cats as $k => $r) $fields['cat']['items'][$r->id] = $r->name;
		}else{
			$fields["cat"]["items"][0] = "Нет";
		}
	}else{
		unset($fields["cat"]);
	}

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	
	require("lib/admin.php");