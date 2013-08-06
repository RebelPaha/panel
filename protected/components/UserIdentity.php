<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    const ERROR_USER_DISABLED = 3;

    private $_id;
    private $_solt = '#)js|"Sv__(s1,G';

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate(){
        $record = User::model()->findByAttributes( array( 'username' => $this->username ) );

        if( $record === null ){
            $this->_id       = 'user Null';
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        elseif( $record->password !== $this->cryptPass( $this->password ) ){
            $this->_id       = $this->id;
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        elseif( $record[ 'state' ] !== 'ready' ) //  here I check status as Active in db
        {
            $this->errorCode = self::ERROR_USER_DISABLED;
        }
        else{
            $this->_id = $record[ 'id' ];
            $this->setState( 'title', $record[ 'username' ] );
            $this->errorCode = self::ERROR_NONE;

        }

        return !$this->errorCode;
    }

    public function getId(){
        return $this->_id;
    }

    public function cryptPass( $pass ) {
        $newPass = md5( md5($pass) . md5( $this->_solt ) . $this->_solt . $pass );
//                var_dump( $pass, $newPass );exit;
        return $newPass;
    }

    public  function generatePass(){
        $pass = chr(rand( 0, 9 )) . chr(rand( 0, 9 )) . chr(rand( 0, 9 )) . chr(rand( 0, 9 )) . chr(rand( 0, 9 )) . chr(rand( 0, 9 ));

        return $this->cryptPass($pass);
    }
}