<?php
	namespace ASweb\Form;
	
	class Order extends Form
	{
		public function init(){
			global $labels, $sett, $db_prefix, $url;
			parent::init();

			$this->setAction("/order/confirm".$url->gvar("lkhylaskdghl="));
			$this->setMethod('post');
			$this->setAttrib('id', 'orderform');
	
			$User = new \Model_User('client');
			$user = $User->get(Auth::userid());

			$this->addElement('text', 'email', array(
				'required'	  => true,
				'label'       => $labels["email"],
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => $user->email,
				'validators'  => array(
					array('StringLength', true, array(0, 60)),
					array('EmailAddress', true),
				),
				'class' => 'form-control',
			));
/*			if($_SESSION['userid']){
				$this->email->setAttrib('readonly', 1);
			}else{
        		$this->email->addValidator('UniqueEmail');
			}
*/
			$this->addElement('text', 'name', array(
				'required'	  => true,
				'label'       => $labels["name"],
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => ($_POST['name']) ? $_POST['name'] : $user->name,
				'validators'  => array(
					array('StringLength', true, array(0, 30))
				),
				'class' => 'form-control',
			));

			$this->addElement('text', 'surname', array(
				'required'	  => true,
				'label'       => $labels["surname"],
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => ($_POST['surname']) ? $_POST['surname'] : $user->surname,
				'validators'  => array(
					array('StringLength', true, array(0, 30))
				),
				'class' => 'form-control',
			));

			$this->addElement('text', 'phone', array(
				'required'	  => false,
				'label'       => $labels["phone"],
				'description' => $labels["enter_real_phone"],
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => ($_POST['phone']) ? $_POST['phone'] : $user->phone,
				'validators'  => array(),
				'class' => 'form-control',
			));
			$this->phone->addDecorator('Description');

			$this->addElement('text', 'city', array(
				'required'	  => false,
				'label'       => $labels["city"],
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => ($_POST['city']) ? $_POST['city'] : $user->city,
				'validators'  => array(),
				'class' => 'form-control',
			));

			$this->addElement('text', 'address', array(
				'required'	  => true,
				'label'       => $labels["address"],
				'description' => $labels["enter_real_address"],
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => ($_POST['address']) ? $_POST['address'] : $user->address,
				'validators'  => array(),
				'class' => 'form-control',
			));
			$this->address->addDecorator('Description');

			$Esystem = new \Model_Esystem();
			$esystems = $Esystem->getall(array("where" => "visible = 1", "order" => "prior desc, name"));
			$esys = array();
			foreach($esystems as $k => $v)
				$esys[$v->id] = $v->name;

			$this->addElement('select', 'esystem', array(
				'required'	  => true,
				'label'       => $labels["payment_method"],
				'value'       => $_POST['esystem'],
				'multiOptions' => $esys,
				'class' => 'form-control',
			));

			$Delivery = new \Model_Delivery();
			$delivery = $Delivery->getall(array("where" => "visible = 1", "order" => "prior desc, name"));
			$delivs = array();
			foreach($delivery as $k => $v)
				$delivs[$v->id] = $v->name;

			$this->addElement('select', 'delivery', array(
				'required'	  => true,
				'label'       => $labels["delivery_method"],
				'value'       => $_POST['delivery'],
				'multiOptions' => $delivs,
				'class' => 'form-control',
			));

	        $this->addElement('submit', 'submit', array(
	            'label'       => $labels["confirm"],
				'decorators'  => array('ViewHelper'),
		        'class' => 'btn btn-main',
    	    ));

			$this->addDisplayGroup(
				array('email', 'name', 'surname', 'phone', 'city', 'address'), 'advDataGroup',
				array(
					'legend' => $labels["your_registration_data"],
				)
			);

			$this->addDisplayGroup(
				array('esystem', 'delivery'), 'paymentDataGroup',
				array(
					'legend' => $labels["chose_payment_method"]
				)
			);

			$this->addDisplayGroup(
				array('submit'), 'buttonsGroup'
			);
		}
	}