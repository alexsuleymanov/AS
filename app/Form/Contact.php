<?
	class Form_Contact extends Form_Form{
		public function init(){
			global $labels, $sett;
			parent::init();

			$this->setAction("/contact");
			$this->setMethod('post');
			$this->setAttrib('id', 'contactform');
			
			$this->addElement('hidden', 'code', array(
				'required'	  => false,
				'label'       => '',
				'value'       => "",
			));
			
			$this->addElement('text', 'email', array(
				'required'	  => true,
				'label'       => $labels["email"],
//				'description' => $labels["enter_real_email"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => $_POST['email'],
				'validators'  => array(
					array('StringLength', true, array(0, 60)),
					array('EmailAddress', true),
				),
				'class' => 'form-control'
			));
//			$this->email->addDecorator('Description');
			$this->email->addDecorator(new Form_Decorator_AjaxError());

			$this->addElement('text', 'name', array(
				'required'	  => true,
				'label'       => $labels["name"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => $_POST['name'],
				'validators'  => array(
					array('StringLength', true, array(0, 30))
				),
				'class' => 'form-control'
			));
			$this->name->addDecorator(new Form_Decorator_AjaxError());

			$this->addElement('text', 'subj', array(
				'required'	  => true,
				'label'       => $labels['subj'],
				'value'       => $_POST['subj'],
				'size'		  => 60,
				'maxlength'   => '60',
				'validators'  => array(
					array('StringLength', true, array(0, 100))
				),
				'class' => 'form-control'
			));

			$this->addElement('textarea', 'cont', array(
				'required'	  => true,
				'label'       => $labels['message'],
				'rows'		  => 10,
				'cols'		  => 50,
				'value'       => $_POST['cont'],
				'validators'  => array(
					array('StringLength', true, array(10, 500))
				),
				'class' => 'form-control'
			));
			$this->cont->addDecorator(new Form_Decorator_AjaxError());

	        $this->addElement('submit', 'submit', array(
	            'label'       => $labels["send"],
				'decorators'  => array('ViewHelper'),
		        'class'       => 'btn btn-black',
				'id'          => "contact_submit",
    	    ));

			/*$this->addDisplayGroup(
				array('email', 'name', 'subj', 'cont'), 'contactsDataGroup',
				array(
					'legend' => "",
				)
			);

			$this->addDisplayGroup(
				array('submit'), 'buttonsGroup'
			);*/


		}
	}