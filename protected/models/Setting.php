<?php

/**
 * This is the model class for table "Setting".
 *
 * The followings are the available columns in table 'Setting':
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $group
 */
class Setting extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return Setting the static model class
     */
    public static function model( $className = __CLASS__ ){
        return parent::model( $className );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(){
        return 'Setting';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(){
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array( 'value', 'required' ),
            array( 'label', 'safe' ),
            array( 'label, key', 'length', 'max' => 128 ),
            array( 'group', 'length', 'max' => 32 ),
            array( 'key, value, label, group', 'safe', 'on' => 'update' )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(){
        return array(
            'id'    => 'ID',
            'key'   => 'Key',
            'value' => 'Value',
            'label' => 'Label',
            'group' => 'Group',
        );
    }

    public function beforeSave(){
        parent::beforeSave();

        Yii::app()->cache->flush();

        return true;
    }

    public  function getItems( $group ){
        $settings = Setting::model()->findAllByAttributes( array( 'group' => $group ) );

        foreach( $settings as $id => $setting ){
            $settings[ $setting->key ] = $setting;

            unset( $settings[ $id ] );
        }

        return $settings;
    }
}