<?php

class Notification extends CApplicationComponent
{
    public function init(){
//        exit( 'KOKOKO' );
    }

    public  function send( $event ){
        if( empty( $event ) ){
            throw new CException( 'Event ' . $event . ' is not set.' );
        }
        

        return 'POO';
    }
}