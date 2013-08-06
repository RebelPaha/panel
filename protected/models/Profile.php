<?php

/**
 * This is the model class for table "Profile".
 *
 * The followings are the available columns in table 'Profile':
 * @property integer $userId
 * @property integer $projectId
 * @property string $firstName
 * @property string $middleName
 * @property string $lastName
 * @property integer $countryId
 * @property string $city
 * @property string $address
 * @property string $zip
 * @property string $homephone
 * @property string $cellphone
 * @property string $dob
 * @property string $lastEmployer
 * @property integer $ssn
 * @property string $comment
 * @property integer $docsAlert
 * @property string $lastVisit
 * @property string $regIp
 * @property string $userAgent
 * @property integer $isPaid
 * @property integer $paidAmount
 */
class Profile extends CActiveRecord
{
    public function init(){
        parent::init();

        $this->projectId = Project::model()->findAllByAttributes( array( 'isDefault' => 1 ) );
    }

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return Profile the static model class
     */
    public static function model( $className = __CLASS__ ){
        return parent::model( $className );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(){
        return 'Profile';
    }

    public function primaryKey(){
        return 'userId';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(){
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(
                'userId, projectId, countryId, ssn, docsAlert, isPaid, paidAmount',
                'numerical',
                'integerOnly' => true
            ),
            array( 'firstName, middleName, lastName, homephone, cellphone', 'length', 'max' => 24 ),
            array( 'city, zip', 'length', 'max' => 64 ),
            array( 'address', 'length', 'max' => 128 ),
            array( 'dob', 'type', 'type' => 'date', 'message' => 'Valid date format "yyyy-mm-dd"', 'dateFormat' => 'YYYY-MM-dd', 'on' => 'create, update'),
            array( 'dob, lastEmployer, comment', 'safe'),
            array(
                'userId, projectId, firstName, middleName, lastName, countryId, city, address, zip, homephone, cellphone, dob, lastEmployer, ssn, comment, docsAlert, isPaid, paidAmount',
                'safe',
                'on' => 'search'
            ),
        );
    }

    public function beforeSave(){
        parent::beforeSave();

        if( $this->isNewRecord ){
            $this->regIp = Yii::app()->request->userHostAddress;
        }

        return true;
    }

    /**
     * @return array relational rules.
     */
    public function relations(){
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user'    => array( self::HAS_ONE, 'User',  array( 'id' => 'userId' ) ),
            'project' => array( self::HAS_ONE, 'Project', 'projectId' ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(){
        return array(
            'userId'       => 'User',
            'projectId'    => 'Project',
            'firstName'    => 'First Name',
            'middleName'   => 'Middle Name',
            'lastName'     => 'Last Name',
            'countryId'    => 'Country',
            'city'         => 'City',
            'address'      => 'Address',
            'zip'          => 'Zip',
            'homephone'    => 'Homephone',
            'cellphone'    => 'Cellphone',
            'dob'          => 'Day Of Birth',
            'lastEmployer' => 'Last Employer',
            'ssn'          => 'SSN',
            'comment'      => 'Comment',
            'docsAlert'    => 'Documents Alert',
            'lastVisit'    => 'Last Visit',
            'regIp'        => 'Registration Ip',
            'userAgent'    => 'HTTP User Agent',
            'isPaid'       => 'Is Paid',
            'paidAmount'   => 'Paid Amount',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search(){
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare( 'userId', $this->userId );
        $criteria->compare( 'projectId', $this->projectId );
        $criteria->compare( 'firstName', $this->firstName, true );
        $criteria->compare( 'middleName', $this->middleName, true );
        $criteria->compare( 'lastName', $this->lastName, true );
        $criteria->compare( 'countryId', $this->countryId );
        $criteria->compare( 'city', $this->city, true );
        $criteria->compare( 'address', $this->address, true );
        $criteria->compare( 'zip', $this->zip, true );
        $criteria->compare( 'homephone', $this->homephone, true );
        $criteria->compare( 'cellphone', $this->cellphone, true );
        $criteria->compare( 'dob', $this->dob, true );
        $criteria->compare( 'lastEmployer', $this->lastEmployer, true );
        $criteria->compare( 'ssn', $this->ssn );
        $criteria->compare( 'comment', $this->comment, true );
        $criteria->compare( 'docsAlert', $this->docsAlert );
        $criteria->compare( 'lastVisit', $this->lastVisit, true );
        $criteria->compare( 'regIp', $this->regIp, true );
        $criteria->compare( 'userAgent', $this->userAgent, true );
        $criteria->compare( 'isPaid', $this->isPaid );
        $criteria->compare( 'paidAmount', $this->paidAmount );

        return new CActiveDataProvider( $this, array(
                                                    'criteria' => $criteria,
                                               ) );
    }
}