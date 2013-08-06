<?php

class RecoveryConfirmForm extends CFormModel
{
    public $password;
	public $rpassword;
	
  
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules(){
        return array(
            array( 'password, rpassword', 'required' ),
            array('password', 'compare', 'compareAttribute'=>'rpassword'),
           // array( 'email', 'isEmail' ),

        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels(){
        return array(
            'password' => 'Enter new password', 'rpassword' => 'Repeat password',
        );
    }



  
}
