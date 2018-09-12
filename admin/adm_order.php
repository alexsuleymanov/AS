<?	require("incl.php");

	$Plugins->loadplugin("order_prods");

	//---- GENERAL ----

	$title = "Заказы";
	$model = "Model_Order";
	
	$default_order = "id";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$id = 0 + $_GET['id'];
	$Model = new $model();
	$order = $Model->get($id);

	//---- SHOW ----
	$show_cond = array();
	if($_GET['user']) $show_cond = array("where" => "`user` = '".ASweb\Db\Db::nq($_GET['user'])."'");
	if($_GET['manager']) $show_cond = array("where" => "`manager` = '".ASweb\Db\Db::nq($_GET['manager'])."'");

	function showhead() {
	}

	function onshow($row) {
		global $title, $cat, $url, $opt;

//		$Order = new Model_Order($row->id);
//		$Order->recount();

		$row->export = "<a href=\"".$url->gvar("export=1&id=".$row->id)."\" target=\"_blank\"> [Экспорт CSV] </a>";
//		$row->sum = Func::fmtmoney($Order->to_pay);
//		$row->tstamp = $r;
		return $row;
	}

	$fields = array(
		'id' => array(
			'label' => "Номер заказа",
			'type' => 'custom',
			'content' => "#".$id."<input type=\"hidden\" name=\"id\" value=\"".$id."\">",
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'tstamp' => array(
			'label' => "Дата",
			'type' => 'date',
			'value' => time(),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
			'multylang' => 0,
		),
		'user' => array(
			'label' => "Заказчик",
			'type' => 'custom',
			'content' => "<a href=\"adm_user.php?usertype=client&action=edit&id=".$order->user."\" target=\"_blank\">Просмотреть</a><input type=\"hidden\" name=\"user\" value=\"".$order->user."\">",
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
		'manager' => array(
			'label' => "Менеджер",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
/*		'esystem' => array(
			'label' => "Способ оплаты",
			'type' => 'select',
			'items' => array(),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
			'multylang' => 0,
		),
*/
		'name' => array(
			'label' => "Имя",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'sum' => array(
			'label' => "Сумма заказа",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'city' => array(
			'label' => "Город",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'addr' => array(
			'label' => "Адрес",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'phone' => array(
			'label' => "Телефон",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'email' => array(
			'label' => "E-mail",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'esystem' => array(
			'label' => "Способ оплаты",
			'type' => 'select',
			'items' => array(),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'delivery' => array(
			'label' => "Способ доставки",
			'type' => 'select',
			'items' => array(),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'comment' => array(
			'label' => "Комментарий",
			'type' => 'textarea',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'status' => array(
			'label' => "Статус",
			'type' => 'select',
			'items' => array(
				0 => 'не оплачен',
				1 => 'оплачен',
				2 => 'обрабатывается',
				3 => 'доставлен',
			),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
			'multylang' => 0,
		),
		'informclient' => array(
			'label' => "Уведомить клиента",
			'type' => 'checkbox',
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'points' => array(
			'label' => "Списать баллов",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'prods' => array(
			'label' => "Содержимое заказа",
			'type' => 'custom',
			'content' => $Plugins->get('order_prods')->render($view),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'export' => array(
			'label' => "Экспорт в CSV",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'multylang' => 0,
		),
	);

	if(!$id){
	    $fields['user'] = array(
			'label' => "Клиент",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		);

		$Client = new Model_User('client');
		$clients = $Client->getall(array("order" => "email"));
		foreach($clients as $r) $fields['user']['items'][$r->id] = $r->email." (тел.) ".$r->phone." - ".$r->name." ".$r->surname;
	}

	if($opt['managers']){
		$Manager = new Model_User('manager');
		$managers = $Manager->getall(array("where" => "visible = 1", "order" => "name"));
		$fields['manager']['items'][0] = "нет";
		foreach($managers as $r) $fields['manager']['items'][$r->id] = $r->name;
	}else{
		unset($fields['manager']);
	}

	$Esystem = new Model_Esystem();
	$esystems = $Esystem->getall(array("where" => "visible = 1", "order" => "name"));
	foreach($esystems as $r) $fields['esystem']['items'][$r->id] = $r->name;

	$Delivery = new Model_Delivery();
	$deliveris = $Delivery->getall(array("where" => "visible = 1", "order" => "name"));
	foreach($deliveris as $r) $fields['delivery']['items'][$r->id] = $r->name;

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
		global $templates;

		if($_POST['informclient']){
			$status = array(
				0 => 'не оплачен',
				1 => 'оплачен',
				2 => 'обрабатывается',
				3 => 'доставлен',
			);

			$Order = new Model_Order();
			$order = $Order->get($id);

			$params = array(
				"order_id" => $order->id,
				"order_time" => date("d.m.Y (G:i)", $order->tstamp),
				"order_status" => $status[$order->status],
			);

			$mess = Func::mess_from_tmp($templates["order_status_message_template"], $params);
			@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $order->email, "Статус заказ изменен", $mess);			
		}
	}
	
	require("lib/admin.php");