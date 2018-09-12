<?	require("incl.php");
	//---- GENERAL ----

	$title = "Цвета";
	$model = "Model_Color";
	$default_order = "prior";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	//---- SHOW ----
	$show_cond = array();

	function showhead() {
	}

	function onshow($row) {
		return $row;
	}

	$fields = array(
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
		'pic' => array(
			'label' => "Иконка",
			'type' => 'image',
			'comment' => "",
			'location' => "pic/color",
//			'width' => 120,
//			'height' => 120,
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'watermark' => 0,
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
	);

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	
	require("lib/admin.php");