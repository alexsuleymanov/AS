<?
$form = new Form_Comment();

if (Func::is_ajax()) {
	if ($form->isValid($_POST)) {
		$Comment = new Model_Comment();

		$data = array(
			'type' => $_POST["type"],
			'par' => $_POST["par"],
			'user' => 0 + $_SESSION['userid'],
			'author' => $_POST['author'],
			'tstamp' => time(),
			'cont' => $_POST['cont'],
			'visible' => 0,
		);

		$Comment->insert($data);
		$form->success($labels["comment_added"]);
		$form->clear();
	}else{
		$form->printErrorMessages();
	}
}
