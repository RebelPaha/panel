<?php

class Ticket extends CActiveRecord
{
    public static function model( $className = __CLASS__ ){
        return parent::model( $className );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(){
        return 'Ticket';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(){
        return array(
            array( 'subject', 'required' ),
            array( 'subject', 'length', 'max' => 256 ),
            array( 'created, senderId', 'unsafe', 'on' => 'created' ),
            array( 'isClosed', 'unsafe', 'on' => 'close' ),
            array( 'subject', 'safe' ),
            array( 'senderId, created, msgQty, isClosed', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations(){
        return array(
            'messages' => array( self::HAS_MANY, 'Message', 'ticketId', 'order' => 'messages.created ASC' ),
            'msgQty'  => array(
                self::STAT,
                'Message',
                'ticketId',
                'condition' => 'isReviewed = :isReviewed',
                'params' => array( ':isReviewed' => 0 )
            ),
            'sender'  => array( self::HAS_ONE, 'User', array( 'id' => 'senderId' ) ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(){
        return array(
            'id'       => 'ID',
            'senderId' => 'Sender',
            'subject'  => 'Subject',
            'created'  => 'Created date',
            'isClosed' => 'Closed',
            'msgQty'   => 'Unread',
        );
    }

    public function getSenders(){
        $senders = array();
        $users = Yii::app()->db->createCommand()
            ->select( 'u.id, u.username, COUNT(t.id) msgQty' )
            ->from( 'Ticket t' )
            ->join( 'User u', 'u.id = t.senderId' )
            ->group( 't.senderId' )
            ->queryAll();

        foreach( $users as $user ){
            $roles = array_keys( Yii::app()->authManager->getAuthItems( 2, $user['id'] ) );

            foreach( $roles as $role ){
                $senders[] = array(
                    'id'   => $user['id'],
                    'name' => $user['username'] . " (" . $user->msgQty . ")",
                    'role' => $role
                );
            }
        }

        return $senders;
    }

    /**
     * @return int quantity of tickets with unreviewed messages
     */
    public function getCounter(){
        $criteria = new CDbCriteria;
        $criteria->scopes = 'unreviewed';
        $criteria->group = 'ticketId';

        if( ! Yii::app()->user->checkAccess( 'ticket.*' ) ){
            $criteria->addCondition( 'senderId != :senderId' );
            $criteria->params = array( ':senderId' => Yii::app()->user->id );
        }

        return (int) Message::model()->count( $criteria );
    }

    public function toggle(){
        $this->isClosed = (int) ! $this->isClosed;

        return $this->save( false );
    }

    public function beforeSave(){
        parent::beforeSave();

        if( $this->isNewRecord ){
            $this->senderId = Yii::app()->user->id;
            $this->created = new CDbExpression('NOW()');
        }

        return true;
    }

    public function beforeDelete() {
        parent::beforeDelete();

        return Message::model()->deleteAll( 'ticketId = :ticketId', array( ':ticketId' => $this->id ) );
    }

    public function search(){
        $criteria = new CDbCriteria;
        $criteria->compare( 'id', $this->id );
        $criteria->compare( 'subject', $this->subject, true );
        $criteria->compare( 'created', $this->created );

        if( ! Yii::app()->user->checkAccess( 'ticket.*' ) ){
            $criteria->condition = 'senderId = :senderId';
            $criteria->params = array( ':senderId' => Yii::app()->user->id );
        }
        else {
            $criteria->compare( 'senderId', $this->senderId );
        }

        return new CActiveDataProvider( $this, array(
            'criteria'   => $criteria,
            'pagination' => array( 'pageSize' => 20 )
        ));
    }
}