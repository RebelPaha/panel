<?php

/**
 * This is the model class for table "Package".
 *
 * The followings are the available columns in table 'Package':
 * @property integer $id
 * @property string $name
 * @property string $holder
 * @property string $minPrice
 * @property integer $userId
 * @property integer $adminId
 * @property string $status
 * @property integer $isProblem
 * @property string $shippingDate
 * @property string $shippingInvoice
 * @property string $shippingReceipt
 * @property integer $shippingLabelCopy
 * @property integer $label
 * @property integer $labelTrack
 * @property string $instructions
 * @property integer $comment
 * @property integer $privateComment
 */
class Package extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return Package the static model class
     */
    public static function model( $className = __CLASS__ ){
        return parent::model( $className );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(){
        return 'Package';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(){
        return array(
//            array(
//                'name, holder, track, minPrice, userId, adminId, isProblem, shippingMethod, shippingDate, shippingInvoice, shippingReceipt, shippingLabelCopy, label, labelTrack, instructions, comment, privateComment',
//                'required'
//            ),
            array(
                'name, holder, track, minPrice, userId, adminId, shippingDate',
                'required',
                'on' => 'insert'
            ),
            array(
                'name, holder, track, minPrice, userId, adminId, shippingDate, status',
                'required',
                'on' => 'update'
            ),
            array(
                'userId, adminId, isProblem, shippingLabelCopy, label, labelTrack',
                'numerical',
                'integerOnly' => true
            ),
            array( 'name, holder', 'length', 'max' => 512 ),
            array( 'minPrice', 'length', 'max' => 10 ),
            array( 'shippingInvoice, shippingReceipt', 'length', 'max' => 256 ),
            array( 'status, shop, comment, privateComment, instructions, track, paymentMethod', 'safe' ),
            array(
                'id, name, holder, minPrice, creatorId, userId, adminId, status, isProblem, shippingDate, shippingInvoice, shippingReceipt, shippingLabelCopy, label, labelTrack, instructions, comment, privateComment',
                'safe',
                'on' => 'search'
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations(){
        return array(
            'user'   => array( self::HAS_ONE, 'User', 'userId' ),
            'admin'  => array( self::HAS_ONE, 'User', 'adminId' ),
            'tracks' => array( self::HAS_MANY, 'PackageTrack', 'psckageId' )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(){
        return array(
            'id'                => 'ID',
            'name'              => 'Name',
            'holder'            => 'Holder',
            'minPrice'          => 'Price',
            'userId'            => 'User',
            'adminId'           => 'Admin',
            'status'            => 'Status',
            'track'             => 'Track',
            'isProblem'         => 'Mark As Problem',
            'shop'              => 'From (Shop)',
            'paymentMethod'     => 'Payment Method',
            'shippingDate'      => 'Estimated Delivery date ',
            'shippingInvoice'   => 'Shipping Invoice',
            'shippingReceipt'   => 'Shipping Receipt',
            'shippingLabelCopy' => 'Shipping Label Copy',
            'label'             => 'Label',
            'labelTrack'        => 'Label Track',
            'instructions'      => 'Instructions',
            'comment'           => 'Comment for Stuffer',
            'privateComment'    => 'Comment for Admin',
        );
    }

    public function getUsers(){
        $users = array();
        $sql = "SELECT DISTINCT u.id, u.username
                FROM `AuthAssignment` a
                INNER JOIN `User` u ON u.id = a.userId
                WHERE a.itemname = 'user'";

        foreach( User::model()->findAllBySql( $sql ) as $user ){
            $users[ $user->id ] = $user->username;
        }

        return $users;
    }

    public function getStuffers(){
        $users = array();
        $sql = "SELECT DISTINCT u.id, u.username
                FROM `AuthAssignment` a
                INNER JOIN `User` u ON u.id = a.userId
                WHERE a.itemname = 'stuffer'";

        foreach( User::model()->findAllBySql( $sql ) as $user ){
            $users[ $user->id ] = $user->username;
        }

        return $users;
    }

    public function getShippingMethods(){
        return array( 1 => 'unknown', 'UPS', 'DHL', 'FedEx', 'USPS' );
    }

    public function getPaymentMethods(){
        return array( 1 => '%', '50/50 - STAFER PACKAGE', '50/50 - SERVICE PACKAGE', 'DHL', 'Transfer' );
    }

    public function  getStatuses(){
        return array(
            'unknown'  => 'Unknown',
            'new'      => 'New',
            'received' => 'Received',
            'shipped'  => 'Shipped',
            'checked'  => 'Checked'
        );
    }

    public function prepareTrack( $shippingMethods, $tracks ){
        $tmp = array();

        foreach( $tracks as $key => $track ){
            if( empty( $shippingMethods[ $key ] ) || empty( $track ) )
                continue;

            $tmp[] =  $shippingMethods[ $key ] . ':' . $track;
        }

        $this->track = join( '|', $tmp );
    }

    protected function afterFind(){
        parent::afterFind();

        $items = explode( '|', $this->track );
        $tracks = array();
        $i = 0;

        foreach( $items as $item ){
            $tmp = explode( ':', $item);
            $tracks[ $i ] = array( 'shippingMethod' => $tmp[0], 'track' => $tmp[1] );
            $i++;
        }

        $this->track = $tracks;
    }

    protected function beforeValidate(){
        parent::beforeValidate();

        if( $this->isNewRecord )
            $this->adminId = Yii::app()->user>id;

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
        $criteria->compare( 'holder', $this->holder, true );
        $criteria->compare( 'minPrice', $this->minPrice, true );
        $criteria->compare( 'userId', $this->userId );
        $criteria->compare( 'adminId', $this->adminId );
        $criteria->compare( 'status', $this->status, true );
        $criteria->compare( 'isProblem', $this->isProblem );
        $criteria->compare( 'shippingDate', $this->shippingDate, true );
        $criteria->compare( 'shippingInvoice', $this->shippingInvoice, true );
        $criteria->compare( 'shippingReceipt', $this->shippingReceipt, true );
        $criteria->compare( 'shippingLabelCopy', $this->shippingLabelCopy );
        $criteria->compare( 'label', $this->label );
        $criteria->compare( 'labelTrack', $this->labelTrack );
        $criteria->compare( 'instructions', $this->instructions, true );
        $criteria->compare( 'comment', $this->comment );
        $criteria->compare( 'privateComment', $this->privateComment );

        return new CActiveDataProvider( $this, array( 'criteria' => $criteria, ) );
    }

}