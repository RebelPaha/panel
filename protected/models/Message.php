<?php

/**
 * This is the model class for table "Message".
 *
 * The followings are the available columns in table 'Message':
 * @property integer $id
 * @property string $text
 */
class Message extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Message the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array ('text', 'required'),
            array( 'created, senderId,', 'unsafe' ),
            array( 'id, text, ticketId', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'ticket' => array( self::BELONGS_TO, 'Ticket', 'ticketId' ),
            'sender' => array( self::HAS_ONE, 'User', array( 'id' => 'senderId' ) ),
		);
	}

    public function scopes(){
        return array(
            'unreviewed' => array( 'condition' => 'isReviewed = 0' )
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'       => 'ID',
            'ticketId' => 'Ticket',
            'senderId'   => 'Sender',
			'text'     => 'Your Message',
            'created'  => 'Created date'

        );
	}

    public function beforeSave(){
        parent::beforeSave();

        if( $this->isNewRecord ){
            $this->created = new CDbExpression('NOW()');
        }

        return true;
    }

    public function setReviewed( $ticketId ){
        Message::model()->updateAll(
            array( 'isReviewed' => 1),
            'isReviewed = :isReviewed AND ticketId = :ticketId AND senderId != :senderId',
            array( ':isReviewed' => 0, ':ticketId' => $ticketId, ':senderId' => Yii::app()->user->id )
        );
    }

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare( 'id', $this->id );
		$criteria->compare( 'text', $this->text, true );

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}