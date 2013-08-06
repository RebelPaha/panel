<?php

class Invite extends CActiveRecord{

    public static function model( $className = __CLASS__ ){
        return parent::model( $className );
    }

    public function tableName(){
        return 'Invite';
    }

    public function rules(){
        return array(
            array( 'email', 'required' ),
            array( 'email', 'email' ),
            array( 'email', 'unique' ),
            array( 'id, created', 'safe', 'on' => 'search' ),
        );
    }

    public function attributeLabels(){
        return array(
            'id'      => 'ID',
            'email'   => 'E-mail',
            'hash'    => 'Hash',
            'created' => 'Created date'
        );
    }

    public function deleteByHash( $hash ){
        return Invite::model()->deleteAllByAttributes( array( 'hash' => $hash ) );
    }

    public function deleteOverdue(){
        Invite::model()->deleteAllByAttributes( array(), new CDbExpression( 'datediff( NOW( ) , created ) > :days ' ), array( ':days' => 10)  );
    }

    protected function beforeSave(){
        if( parent::beforeSave() ){
            if( $this->isNewRecord ){
                $this->created = new CDbExpression('NOW()');
                $this->hash    = md5( time() . $this->email );
            }

            return true;
        }
        else
            return false;
    }

    public function search(){
        $criteria = new CDbCriteria;
        $criteria->compare( 'id', $this->id );
        $criteria->compare( 'email', $this->email, true );
        $criteria->compare( 'created', $this->created, true );

        return new CActiveDataProvider( $this, array(
            'criteria'   => $criteria,
            'pagination' => array( 'pageSize' => 100 )
       ));
    }
}