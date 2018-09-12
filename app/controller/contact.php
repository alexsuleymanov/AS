<?// Controller - Форма обратной связи

use ASweb\Mail\Mail;
use ASweb\StdLib\Func;

$form = new Form_Contact();
$form->addDecorator(new Form_Decorator_Ajax());

$types = array(
	"Zend_Form_Element_Submit",
	"Zend_Form_Element_File",
	"Zend_Form_Element_Captcha",
	"Zend_Form_Element_Exception",
	"Zend_Form_Element_Hash",
	"Zend_Form_Element_Hidden",
	"Zend_Form_Element_Image",
	"Zend_Form_Element_Reset",
	"Zend_Form_Element_Button",
);

if(Func::is_ajax()){
	if($form->isValid($_POST)){
		foreach($form->getElements() as $k => $v){
			if(in_array($v->getType(), $types)) continue;
			$text .= "<b>".$v->getLabel()."</b>: ".$_POST[$v->getName()]."<br>";
		}

		$params = array(
			"message" => $text,
		);

		$Message = new Model_Message();
		$Message->insert(array(
			"email" => $_POST['email'],
			"phone" => $_POST['phone'],
			"name" => $_POST['name'],
			"cont" => $_POST['cont'],
			"tstamp" => time(),
			"type" => "contact",
		));

		@Mail::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $sett['admin_email'], $labels["message_from_site"], Func::mess_from_tmp($templates["contact_message_template"], $params));
		@Mail::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $_POST['email'], $labels["message_sent"], Func::mess_from_tmp($templates["auto_message_template"], $params));
		$form->success($labels["message_sent"]);
		$form->clear();
	}else{
		$form->printErrorMessages();
	}
	die();
}else{
	$view->bc["/".$args[0]] = $labels["contacts"];

	//$view->page->cont .= $form->render($view);
	$view->page->form = $form->render($view);

	echo $layout->render($view);
}