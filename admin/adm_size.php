<?	require("incl.php");
	//---- GENERAL ----

	$title = "Размеры";
	$model = "Model_Size";
	$default_order = "id";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$par = 0 + $_GET['par'];

	//---- SHOW ----
	$show_cond = array();

	function showhead() {
	}

	function onshow($row) {
		return $row;
	}

	$fields = array(
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
		'name_uk' => array(
			'label' => "UK",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
		'name_us' => array(
			'label' => "US",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
	);

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	
	require("lib/admin.php");