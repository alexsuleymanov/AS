<?	require("incl.php");
	//---- GENERAL ----

	$title = "Пользователи";
	$model = "Model_User";
	$model_type = $_GET['type'];
	$default_order = "name";

	$id = 0 + $_GET['id'];
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	//---- SHOW ----

	$show_cond = array("where" => "`type` = '".ASweb\Db\Db::nq($model_type)."'");

	function showhead() {
		return $ret;
	}

	function onshow($row) {
		extract($GLOBALS);
		if($_GET['type'] == 'manager')
			$row->orders = "<div align=center><a href=\"adm_order.php?manager=".$row->id."\"> [Заказы] </a></div>";
		elseif($_GET['type'] == 'client')
			$row->orders = "<div align=center><a href=\"adm_order.php?user=".$row->id."\"> [Заказы] </a></div>";

		return $row;
	}

	$fields = array(
		'user' => array(
			'label' => "Родитель",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
		'email' => array(
			'label' => "E-mail",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'pass' => array(
			'label' => "Пароль",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'pic' => array(
			'label' => "Фото",
			'type' => 'image',
			'location' => "pic/user",
//			'width' => 300,
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'watermark' => 0,
		),
		'name' => array(
			'label' => "Имя",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,

			'multylang' => 1,
		),
		'surname' => array(
			'label' => "Фамилия",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
		'city' => array(
			'label' => "Город",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
		'address' => array(
			'label' => "Адрес",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 1,
		),
		'phone' => array(
			'label' => "Телефон",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'visible' => array(
			'label' => "Активен",
			'type' => 'checkbox',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
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
		'orders' => array(
			'label' => "Заказы",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
	);

	if($opt['referal']){
		$User = new Model_User();
		$users = $User->getall(array("where" => "visible = 1 and id != ".$id."", "order" => "name"));
		$fields['user']['items'][0] = "нет";
		foreach($users as $r){
			$name = ($r->type == 'manager') ? $r->name."(менеджер)" : $r->name;
			$fields['user']['items'][$r->id] = $name;
		}
	}else{
		unset($fields['user']);
	}

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}
	
	require("lib/admin.php");