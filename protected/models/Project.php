<?php

/**
 * This is the model class for table "Project".
 *
 * The followings are the available columns in table 'Project':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $email
 * @property integer $isDefault
 * @property integer $isMain
 * @property string $smtpServer
 * @property string $smtpDomain
 * @property integer $smptPort
 * @property string $smtpLogin
 * @property string $smtpPassword
 * @property integer $smtpSsl
 */
class Project extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return Project the static model class
     */
    public static function model( $className = __CLASS__ ){
        return parent::model( $className );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(){
        return 'Project';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(){
        return array(
            array( 'name, url, email', 'required' ),
            array( 'isDefault, isMain, smtpPort, smtpSsl', 'numerical', 'integerOnly' => true ),
            array( 'name, smtpLogin, smtpPassword', 'length', 'max' => 32 ),
            array( 'url', 'length', 'max' => 512 ),
            array( 'email, smtpServer, smtpDomain', 'length', 'max' => 64 ),
            array( 'url', 'url' ),
            array( 'email', 'email' ),
            array( 'isMain', 'checkIs' ),
            array( 'id, name, url, email, isDefault, isMain', 'safe', 'on' => 'search' ),
        );
    }

    public function checkIs( $attribute, $params ){
//        var_dump($attribute, $params); exit;

        return false;
    }

    /**
     * @return array relational rules.
     */
    public function relations(){
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'profile' => array( self::HAS_MANY, 'Profile', array( 'id' => 'projectId' ) ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(){
        return array(
            'id'           => 'ID',
            'name'         => 'Name',
            'url'          => 'Url',
            'email'        => 'E-mail',
            'isDefault'    => 'Is Default',
            'isMain'       => 'Is Main',
            'smtpServer'   => 'Server',
            'smtpDomain'   => 'Domain',
            'smptPort'     => 'Port',
            'smtpLogin'    => 'Login',
            'smtpPassword' => 'Password',
            'smtpSsl'      => 'SSL',
        );
    }

    public function beforeDelete(){
        parent::beforeDelete();



        return true;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search(){
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare( 'id', $this->id );
        $criteria->compare( 'name', $this->name, true );
        $criteria->compare( 'url', $this->url, true );
        $criteria->compare( 'email', $this->email, true );
        $criteria->compare( 'isDefault', $this->isDefault );
        $criteria->compare( 'isMain', $this->isMain );

        return new CActiveDataProvider( $this, array(
                                                    'criteria' => $criteria,
                                               ) );
    }
}