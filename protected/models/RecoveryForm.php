<?php

class RecoveryForm extends CFormModel
{
    public $email;
	public $captcha;
	
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules(){
        return array(
          
            array( 'email, captcha', 'required' ),
            array( 'email', 'isEmail' ),
			array('captcha', 'captcha', 'allowEmpty'=>!extension_loaded('gd')),
			array('email', 'email', 'allowEmpty'=>!extension_loaded('gd')),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels(){
        return array(
            'email' => 'Your email in system', 'captcha' => 'Captcha',
        );
    }

	public function isEmail($attribute,$params){

		$user = User::model()->find("email = :email ", array(":email" => $this->email));
		if(!$user){
			$this->addError('email','Not isset user with this email');
		}
	}

    public function authenticate( $attribute, $params ){
        if( !$this->hasErrors() ){

        }
    }

  
}
