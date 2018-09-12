<?php
$form = new Form_Subscribe();

if (Func::is_ajax()) {
	if ($form->isValid($_POST)) {
		$User = new Model_User();

		$data = array(
			'type' => 'subscriber',
			'user' => 0,
			'name' => $_POST['name'],
			'email' => $_POST['email'],
			'visible' => 0,
		);

		$User->insert($data);
		$form->success($labels["user_subscribed"]);
		$form->clear();
	}else{
		$form->printErrorMessages();
	}
}