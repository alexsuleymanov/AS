<?// Controller - Оформление заказа
	use ASweb\Pay\Pay;
	use ASweb\Db\Db;
	use ASweb\Mail\Mail;
	use ASweb\StdLib\Func;
	
	if($args[1] == ''){
		$orderform = new Form_Order();
		$view->orderform = $orderform;

		$view->page->cont .= $view->render('order/anketa.php');
		echo $layout->render($view);
		die();
	}

	if($args[1] == 'oneclick'){
		$phone = trim($_GET['phone']);
		$id = intval($_GET['prid']);
            
		if(!empty($phone) && !empty($id)){
			$Prod = new Model_Prod();
			$prod = $Prod->get($id);
			$data = array(
				"user" => 0 + $_SESSION['userid'],
				"type" => "oneclick",
				"tstamp" => time(),
				"phone" => $phone,
				"esystem" => 0,
				"delivery" => 0,
				"status" => 0,
			);

			$Order = new Model_Order();
			$Order->insert($data);
			$order_id = $Order->last_id();
		
			$Cart->insert(array(
				"order" => $order_id,
				"prod" => $prod->id,
				"price" => $prod->price,
				"num" => 1,
			));
			
			$subject = "Быстрый заказ ".$sett['sitename'];
			$message = "Телефон : ".$phone."<br />";
			$message .= "Продукт : ".$prod->name."<br />";
			$message .= "Ссылка : http://".$_SESSION['HTTP_HOST']."/catalog/prod-".$prod->id."<br />";
                
			$res = Mail::mailhtml($sett['sitename'], "order@".$_SESSION['HTTP_HOST'], $sett['order_email'], $subject, $message);
		}
                
		if($res == true) echo 'ok';
		else echo 'error';
            
		die();
	}

	if($args[1] == 'confirm'){
		$form = new Form_Order();
		$form->setAction("/order/confirm");

		if($_POST['submit']){
			if ($form->isValid($_POST)){
				$User = new Model_User('client');
				$user = $User->getone(array("where" => "`email` = '".Db::nq($_POST["email"])."'"));

				if(!$_SESSION['userid'] && empty($user->id)){
					$password = substr(md5(time()), 0, 8);

					$data = array(
						"type" => 'client',
						"pass" => $password,
						"country" => $_POST['country'],
						"city" => $_POST['city'],
						"address" => $_POST['address'],
						"name" => $_POST['name'],
						"surname" => $_POST['surname'],
						"www" => $_POST['www'],
						"phone" => $_POST['phone'],
						"discount" => 0 + $discount,
					);

					$User->insert($data);
					$userid = $User->last_id();

					$user = $User->get($_SESSION['userid']);

					$_SESSION['userid'] = $userid;
					$_SESSION['username'] = $_POST['name'];
					$_SESSION['usertype'] = 'client';

					$params = array(
						"pass" => $password,
						"email" => $_POST['email'],
						"name" => $_POST['name'],
						"surname" => $_POST['surname'],
						"phone" => $_POST['phone'],
						"city" => $_POST['city'],
						"address" => $_POST['address'],
					);

					@Mail::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $_POST['email'], $labels["register_message_theme"], Func::mess_from_tmp($templates["register_message_template"], $params));
					@Mail::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $sett['admin_email'], $labels["register_message_theme"], Func::mess_from_tmp($templates["register_message_template"], $params));
				}elseif(!$_SESSION['userid'] && $user->id){
					$_SESSION['userid'] = $user->id;
					$_SESSION['username'] = $user->name;
					$_SESSION['usertype'] = 'client';
				}

				$data = array(
					"user" => $_SESSION['userid'],
					"manager" => 0,
					"tstamp" => time(),
					"email" => $_POST['email'],
					"name" => $_POST['surname']." ".$_POST['name'],
					"phone" => $_POST['phone'],
					"city" => $_POST['city'],
					"addr" => $_POST['address'],
					"comment" => $_POST['address'],
					"esystem" => 0 + $_POST["esystem"],
					"delivery" => 0 + $_POST["delivery"],
					"status" => 0,
					"points" => 0,
				);

				$Order = new Model_Order();
				$Order->insert($data);
				
                if($opt['discounts']){
					$Discount = new Model_Discount();

					$order_total = $Order->total($_SESSION['userid']);
					$discount = $Discount->getnakop($order_total);
				}

				$client_data = "<table><tr><td>".$labels['name']."</td><td>".$_POST['name']." ".$_POST['surname']."</td></tr><tr><td>Email</td><td>".$_POST['email']."</td></tr><tr><td>".$labels['phone']."</td><td>".$_POST['phone']."</td></tr><tr><td>".$labels['address']."</td><td>".$_POST['city'].", ".$_POST['address']."</td></tr></table>";

				$order_id = $Order->last_id();
				$Cart->save_cart($order_id);

				$Esystem = new Model_Esystem();
				$Delivery = new Model_Delivery();

				$esystem = $Esystem->get($_POST["esystem"]);
				$delivery = $Delivery->get($_POST["delivery"]);

				$params = array(
					"order_id" => $order_id,
					"client" => $_POST["surname"]." ".$_POST["name"],
					"order_time" => date("d.m.Y (G:i)", time()),
					"order" => $view->render('cart/show.php'),
					"client" => $client_data,
					"payment" => $esystem->cont,
					"delivery" => $delivery->cont,
					"login" => $user->login,
					"pass" => $user->pass,
					"name" => $_POST["name"],
					"surname" => $_POST["surname"],
					"email" => $user->email,
					"phone" => $_POST["phone"],
					"city" => $_POST["city"],
					"address" => $_POST["address"],
				);

				$mess = Func::mess_from_tmp($templates["order_message_template"], $params);

				@Mail::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $sett['order_email'], $labels["order_maked"], $mess);
				@Mail::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $_POST['email'], $labels["order_maked"], $mess);
				
				$order_amount = $Cart->amount();

				$Cart->delete_all();

				if($esystem->auto){
					$url->redir("/order/pay?esystem=".$esystem->id."&order=".$order_id);
					die();
				}

				$view->page->cont = $view->render('order/completed.php');
				echo $layout->render($view);
			}else{
				$view->form = $form;
				$view->page->cont = $view->render('order/confirm.php');
				echo $layout->render($view);
			}
		}else{
			$view->form = $form;
			$view->page->cont = $view->render('order/confirm.php');
			echo $layout->render($view);
		}
	}
	
	if($args[1] == 'completed'){
		$order_id = $args[2];
		$order = $Order->get();

		$view->cartitems = $Cart->cart;
		$view->order_sum = $Cart->amount();
		$view->order = $Order->get($order_id);
		$view->order_id = $order_id;

		$view->page->cont = $view->render('order/completed.php');
		echo $layout->render($view);
		die();
	}

	
	if($args[1] == 'pay' && $_SESSION['userid']){
		$Cart = new Model_Cart();
		$cartitem = $Cart->getone(array("where" => "`order` = '".Db::nq($order_id)."'"));
		$order_sum += $cartitem->price * $cartitem->num;

		Pay::pay($order_sum);
		die();
	}

	if($args[1] == 'pay-result'){
		foreach($args as $k=>$v){
			if(preg_match("/esystem-(\d+)/", $v, $m))
				$esystem_id = 0 + $m[1];
			if(preg_match("/order-(\d+)/", $v, $m))
				$order_id = 0 + $m[1];
		}

		$Esystem = new Model_Esystem();
		$esystem = $Esystem->get($esystem_id);
		
		$Pay = new $esystem->script();
		if($Pay->is_success()){
			$Order = new Model_Order($order_id);
			$Order->save(array("status" => 1));
		}
		die();
	}
	
