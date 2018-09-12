<?// Controller - Кабинет пользователя
	use ASweb\Auth\Auth;
	use ASweb\StdLib\Func;
	use ASweb\Mail\Mail;
	
	$opened_sections = array("login", "logoff", "remind", "register");
			
	if(!in_array($args[1], $opened_sections) && !Auth::is_auth()){
		$_SESSION["error"] = $labels["you_must_register"];
		$url->redir("/user/login");
		die();
	}

	$view->bc["/".$args[0]] = $labels["user_cabinet"];

	$action = $args[1];

	if($action == "discounts"){
		$Page = new Model_Page('page');
		$view->page = $Page->getbyname("user/discounts");

		$view->bc["/".$args[0]."/".$args[1]] = $labels["discounts"];

		$view->page->cont = $view->render("user/discounts.php");
		echo $layout->render($view);
		die();
	}

	if($action == "order-history"){
		$Order = new Model_Order();
		$view->orders = $Order->getall(array("where" => "user = '".ASweb\Db\Db::nq(Auth::userid())."'", "order" => "tstamp desc"));

		$Page = new Model_Page('page');
		$view->page = $Page->getbyname("user/order-history");
		$view->bc["/".$args[0]."/".$args[1]] = $labels['order-history'];


//		$view->page->cont = $view->render("user/head.php");
		$view->page->cont = $view->render("user/order-history.php");
		echo $layout->render($view);
		die();
	}

	if($action == "profile"){
		$form = new Form_Profile();
		if($_POST["submit"] && $form->isValid($_POST)){
			$User = new Model_User('client');
			$data = array(
				"name" => $_POST["name"],
				"surname" => $_POST["surname"],
				"country" => $_POST["country"],
				"city" => $_POST["city"],
				"address" => $_POST["address"],
				"phone" => $_POST["phone"],
				"novapost" => $_POST["novapost"],
			);
			$User->save($data, Auth::userid());
			$url->redir("/user/profile");
		}else{
			$Page = new Model_Page('page');
			$User = new Model_User('client');
			$view->user = $User->get(Auth::userid());

			$view->page = $Page->getbyname("user/profile");
			$view->bc["/".$args[0]."/".$args[1]] = $labels['profile'];

			$view->form = $form->render($view);
//			$view->page->cont .= $view->render("user/head.php");
			$view->page->cont .= $view->render("user/profile.php");

			echo $layout->render($view);
		}
		die();
	}

	if($action == "change-pass"){
		$form = new Form_ChangePass();
		if($_POST["submit"] && $form->isValid($_POST)){
			$User = new Model_User('client');
			$data = array(
				"pass" => $_POST["pass"],
			);
			$User->save($data, Auth::userid());
			$url->redir("/user");
		}else{
			$User = new Model_User('client');
			$view->user = $User->get(Auth::userid());

			$Page = new Model_Page('page');
			$view->bc["/".$args[0]."/".$args[1]] = $labels['change-pass'];

			$view->form = $form->render($view);
//			$view->page->cont .= $view->render("user/head.php");
			$view->page->cont .= $view->render("user/change-pass.php");
			echo $layout->render($view);
		}
		die();
	}

	if($action == "remind"){
		$form = new Form_Remind();

		if($_POST["submit"]){
			$values = $form->getValues();

			$User = new Model_User('client');
			$user = $User->getone(array("where" => "email = '".ASweb\Db\Db::nq($values["email"])."'"));

			if(count($user)){
				$params = array(
					"email" => $user->email,
					"pass" => $user->pass,
				);

				Mail::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $values["email"], $labels["remind_message_theme"], Func::mess_from_tmp($templates["remind_message_template"], $params));

				$view->page->cont = "<p align=center><font color=\"green\">".$labels["password_sent"]."</font></p>";
				echo $layout->render($view);
				die();
			}else{
				$view->page->cont = "<p align=center><font color=\"red\">".$labels["user_not_found"]."</font></p>";
				echo $layout->render($view);
				die();
			}
		}

		$Page = new Model_Page('page');
		$view->page = $Page->getbyname("user/remind");

		$view->bc["/".$args[0]] = $view->page->name;

		$view->page->cont = $view->page->cont;
		$view->page->cont .= $form->render($view);
		echo $layout->render($view);

		die();
	}

	if($args[1] == "logoff"){
		Auth::logoff();		
		$url->redir("/");
		die();
	}

	if($action == "login"){
		$form = new Form_Login();
		if($_POST["submit"]){
			$values = $form->getValues();
			$Auth = new Auth(new Model_User('client'));
			if($Auth->auth($values["email"], $values["pass"])){
				if($_POST["redirect"])
					$url->redir($_POST["redirect"]);
				else
				    $url->redir("/user");
				die();
			}else{
				$_SESSION["error"] = $labels["wrong_password"];
				if($_GET["from"])
					$url->redir($_GET["from"]);
				else
					$url->redir("/user/login");
				die();
			}
		}else{
			$view->bc["/".$args[0]] = $view->page->name;

			$view->page->cont .= $form->render($view);
			$view->page->cont .= $view->render("user/login.php");
			echo $layout->render($view);
			die();
		}
	}

	if($action == "register"){
		$form = new Form_Register();

		if($_POST['submit'] && $form->isValid($_POST)){
			$values = $form->getValues();
			$User = new Model_User();

			$data = array(
				"type" => 'client',
				"pass" => $values['pass'],
				"email" => $values['email'],
				"name" => $values['name'],
				"surname" => $values['surname'],
				"phone" => $values['phone'],
				"city" => $values['city'],
				"address" => $values['address'],
				"visible" => 1,
				"points" => 0,
			);
			
			$User->insert($data);
			$userid = $User->last_id();
			
			Auth::register($userid, $values['name'], 'client');

			$params = array(
				"type" => $_POST['type'],
				"pass" => $_POST['pass'],
				"email" => $_POST['email'],
				"name" => $_POST['name'],
				"surname" => $_POST['surname'],
				"phone" => $_POST['phone'],
				"city" => $_POST['city'],
				"address" => $_POST['address'],
			);

			@Mail::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $_POST['email'], $labels["register_message_theme"], Func::mess_from_tmp($templates["register_message_template"], $params));
			@Mail::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $sett['admin_email'], $labels["register_message_theme"], Func::mess_from_tmp($templates["register_message_template"], $params));

			$view->page->cont = "<p align=center><font color=\"green\">".$labels["user_register_congratulation"]."</font></p>";
			echo $layout->render($view);
//			$url->redirjs("/user");
			die();
		}else{
			$view->bc["/".$args[0]] = $labels["register"];
			
			$view->RegisterForm = $form;
			$view->form = $form->render($view);
			$view->page->cont .= $view->render('user/register.php');
			echo $layout->render($view);
		}
	}

	if($action == ""){
		$view->page->cont = $view->render("user/account.php");
		echo $layout->render($view);
		die();
	}