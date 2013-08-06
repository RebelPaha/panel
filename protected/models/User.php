<?php

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $email
 */
class User extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return User the static model class
     */
    public static function model( $className = __CLASS__ ){
        return parent::model( $className );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(){
        return 'User';
    }

    public function behaviors(){
        return array( 'EAdvancedArBehavior' => array(
            'class' => 'application.extensions.EAdvancedArBehavior'));
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(){
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array( 'username, email, state', 'required' ),
            array( 'password', 'required', 'on' => 'insert' ),
            array( 'username, password, email', 'length', 'max' => 128 ),
            array( 'jabber', 'length', 'max' => 64 ),
            array( 'created', 'unsafe' ),
            array( 'email', 'unique' ),
            array( 'id, username, state, email', 'safe', 'on' => 'search' ),
            array( 'id, username, state, email', 'safe', 'on' => 'search' ),
        );
    }

    public function beforeDelete(){
        parent::beforeDelete();

        Yii::app()->authManager->revoke( 'user', $this->id );
        Yii::app()->authManager->save();

        $this->profile->delete();

        return true;
    }

    protected function beforeSave(){
        if( parent::beforeSave() ){
            if( $this->isNewRecord ){
                $this->created = new CDbExpression('NOW()');
            }

            if( !empty( $this->password ) ){
                $identity = new UserIdentity( $this->username, $this->password );
                $this->password = $identity->cryptPass( $this->password );
            }
            else
                unset( $this->password );

            return true;
        }
        else
            return false;
    }

    protected function afterSave(){
        parent::afterSave();

        return true;
    }


    /**
     * @return array relational rules.
     */
    public function relations(){
        return array(
            'sendMessages'     => array( self::HAS_MANY,  'Ticket', 'id' ),
            'receivedMessages' => array( self::HAS_MANY,  'Ticket', 'id' ),
            'profile'          => array( self::HAS_ONE,   'Profile', array( 'userId' => 'id' ) ),
            'managers'         => array( self::MANY_MANY, 'User',    'UserManager(userId, managerId)', 'together' => true ),
            'users'            => array( self::MANY_MANY, 'User',    'UserManager(managerId, userId)', 'together' => true ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(){
        return array(
            'id'       => 'ID',
            'username' => 'Login',
            'password' => 'Password',
            'password2' => 'Confirm Password',
            'email'    => 'E-mail',
            'state'    => 'State',
            'created'  => 'Created date'
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
        $criteria->compare( 'id', $this->id );
        $criteria->compare( 'username', $this->username, true );
        $criteria->compare( 'email', $this->email, true );
        $criteria->compare( 'state', $this->state, true );

        // If role selected
        if( Yii::app()->request->getParam( 'role' ) ){
            $criteria->join = 'LEFT OUTER JOIN `AuthAssignment` aa ON aa.userId = t.id';
            $criteria->addCondition( "aa.itemname = :role" );
            $criteria->params += array( 'role' => Yii::app()->request->getParam( 'role' ) );
        }

        return new CActiveDataProvider( $this, array(
            'criteria'   => $criteria,
            'pagination' => array( 'pageSize' => 20 )
        ));
    }

    public function getStates(){
        return array( 'new' => 'New', 'problem' => 'Problem', 'ready' => 'Ready' );
    }

    public function getUsersFromRole( $role = 'user' ){
        $criteria = new CDbCriteria;
        $criteria->join = 'LEFT OUTER JOIN `AuthAssignment` aa ON aa.userId = t.id';
        $criteria->addCondition( "aa.itemname = :role" );
        $criteria->params += array( 'role' => $role );

        return User::model()->findAll( $criteria );
    }
}