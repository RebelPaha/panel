<?php

class Settings extends CApplicationComponent
{
    public $cache = 0;
    public $dependency = null;
    public $startupGroup = 'general';

    protected $data = array();

    public function init(){
        $this->loadItems( $this->startupGroup );
    }

    public function get( $key  ){
        $group = $this->startupGroup;

        if( strpos( $key, '.') !== false ){
            list( $group, $key ) = explode( '.', $key );
        }

        if( $group !== $this->startupGroup ){
            $this->loadItems( $group );
        }

        if( isset( $this->data[ $key ] ) )
            return $this->data[ $key ];
        else{
            throw new CException( 'Undefined key ' . $key );
        }
    }

    public function set( $key, $value ){
        $model = Setting::model()->findByAttributes( array( 'key' => $key ) );
        if( !$model )
            throw new CException( 'Undefined key ' . $key );
        $model->value = $value;
        if( $model->save() )
            $this->data[ $key ] = $value;

    }

    public function loadItems( $group = null ){
        $group = $group ? $group : $this->startupGroup;

        $db = $this->getDbConnection();
        $items = $db->createCommand( "SELECT * FROM `Setting` WHERE `group` = '" . $group . "'" )->queryAll();

        foreach( $items as $item ){
            if( $item[ 'key' ] )
                $this->data[ $item[ 'key' ] ] = $item[ 'value' ];
        }
    }

    protected function getDbConnection(){
        if( $this->cache )
            $db = Yii::app()->db->cache( $this->cache, $this->dependency );
        else
            $db = Yii::app()->db;

        return $db;
    }
}