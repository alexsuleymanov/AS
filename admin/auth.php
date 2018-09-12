<?
use ASweb\Db\Db;

$action = $_GET["action"];

if ($action == 'logout') {
	$_SESSION['admin_id'] = 0;
	setcookie("admin_id", '', time() + 60 * 60 * 24 * 30);
	header("Location: /admin/");
	die();
}

$Admin = new Model_Admin();
$admin = $Admin->getone(array("where" => "`login` = '".Db::nq($_POST['login'])."'"));

if ($admin->login && $_POST['login'] == $admin->login && $_POST['pass'] == $admin->pass) {
	setcookie("admin_id", $admin->id, time() + 60 * 60 * 24 * 30);
	header("Location: ".$_SERVER['REQUEST_URI']);
	die();
}
	
if (!isset($_COOKIE['admin_id'])) {
	echo $view->render('auth.php');
	die();
} else {
	$Admin = new Model_Admin();
	$admin = $Admin->get($_COOKIE['admin_id']);

	Zend_Registry::set("admin_level", $admin->level);
	Zend_Registry::set("admin_id", $admin->id);
}