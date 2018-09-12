<?	require("incl.php");

	//---- GENERAL ----

	$title = "Скидки";
	$model = "Model_Discount";
	$default_order = "accum";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	//---- SHOW ----

	$show_cond = array();
	if($_GET['type']) $show_cond = array("where" => "`type` = '".ASweb\Db\Db::nq($_GET['type'])."'");

	function showhead() {
		return $ret;
	}

	function onshow($row) {
		global $url;
		
		return $row;
	}

	$fields = array(
		'name' => array(
			'label' => "Название",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 1,
		),
		'value' => array(
			'label' => "Размер скидки, %",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
		'accum' => array(
			'label' => "Накопления",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
		'type' => array(
			'label' => "",
			'type' => 'hidden',
			'value' => 'accum',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'multylang' => 0,
		),
	);

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	require("lib/admin.php");
