<?php

/**
 * This is the model class for table "recover".
 *
 * The followings are the available columns in table 'recover':
 * @property integer $user_id
 * @property string $code
 */
class Recover extends CActiveRecord
{
	public $user_id;
	public $code;
	public $date_expire;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Recover the static model class
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
		return 'recover';
	}

	/**Установка нового хеш кода для восстановления пароля пользователю*/
	public function setNewCode($user_email){
		
		$res = User::model()->find('email=:email', array(':email'=>$user_email));
		//print_r($res->id);
		if($res){
			$this->code = md5(uniqid("gogo").uniqid("nono"));
			$this->user_id = $res->id;
			$this->date_expire = time() + 24*60*60;
			$this->deleteAll('user_id=:user_id', array(':user_id'=>$res->id));
			$this->insert();
			return true;
		}else{
			return false;
		}
	}
	/**активен ли данный хеш код для восстановления, любой код имеет срок 1 сутки**/
	public function isUserCode($code){
		return 	$res = $this->find('code=:code AND date_expire > :date', 
							array(':code'=>$code, ':date'=>time()));
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>255),
			array('date_expire', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, code', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'code' => 'Code',
			'date_expire'=>'Expire date'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('code',$this->code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}