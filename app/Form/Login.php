<?
	class Form_Login extends Form_Form{

		public function init(){
			global $labels, $sett, $url;
			parent::init();

			$this->setAction("/user/login");

			$this->setMethod('post');
			$this->setAttrib('id', 'loginform');
				
			if($_GET["redirect"])
				$this->addElement('hidden', 'redirect', array(
					'required'	  => false,
					'label'       => '',
					'value'       => $_GET["redirect"],
				));

			$this->addElement('text', 'email', array(
				'required'	  => true,
				'label'       => $labels["email"],
				'value'       => $_POST['email'],
				'size'		  => 45,
				'maxlength'   => '45',
				'class' => 'form-control',
			));

			$this->addElement('password', 'pass', array(
				'required'	  => true,
				'label'       => $labels["password"],
				'value'       => $_POST['pass'],
				'size'		  => 45,
				'maxlength'   => '45',
				'class' => 'form-control',
			));

	        $this->addElement('submit', 'submit', array(
	            'label'       => $labels["sign_in"],
				'value'		  => $labels["sign_in"],
				'decorators'  => array('ViewHelper'),
		        'class' => 'btn btn-main',
    	    ));

			$this->addDisplayGroup(
				array('email', 'pass'), 'advDataGroup',
				array(
					'legend' => $labels["login_password"],
				)
			);

			$this->addDisplayGroup(
				array('submit'), 'buttonsGroup'
			);
		}
	}