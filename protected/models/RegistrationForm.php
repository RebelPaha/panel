<?php

class RegistrationForm extends CFormModel
{
    public $username;
    public $password;
    public $password2;
    public $email;

    public function rules(){
        return array(
            array( 'username, password, password2, email', 'required' ),
            array( 'email', 'email' ),
            array( 'username', 'isUserUnique' ),
            array( 'password', 'compare', 'compareAttribute' => 'password2' ),
        );
    }

    public function attributeLabels(){
        return array(
            'username' => 'Login',
            'password' => 'Password',
            'password2' => 'Confirm password',
            'email' => 'E-mail',
        );
    }

    public function isUserUnique( $attribute, $params ){
        $record  = User::model()->findByAttributes( array( 'username' => $this->username ) );

        if( $record ){
            $this->addError( 'username', 'This login is already in use.' );
        }
    }
}