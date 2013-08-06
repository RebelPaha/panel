<?php

class PackageController extends Controller
{
    public $layout = '//layouts/column2';
    public $defaultAction = 'manage';

//    public function filters(){
//        return array(
//            array( 'auth.filters.AuthFilter' ),
//            'accessControl'
//        );
//    }

    public function actionCreate(){
        $package = new Package;

        if( isset( $_POST[ 'Package' ] ) ){
            $package->prepareTrack( $_POST[ 'Package' ]['shippingMethod'], $_POST[ 'Package' ]['track'] );

            unset( $_POST[ 'Package' ]['shippingMethod'], $_POST[ 'Package' ]['track'] );

            $package->attributes = $_POST[ 'Package' ];

            if( $package->save() ){
                Yii::app()->user->setFlash( 'success', "Package #" .$package->id . " successful created" );

                $this->redirect( array( 'manage' ) );
            }
        }

        $this->render( 'create', array( 'package' => $package ) );
    }

    public function actionEdit( $id ){
        $package = $this->loadModel( $id );

        if( isset( $_POST[ 'Package' ] ) ){
            $package->prepareTrack( $_POST[ 'Package' ]['shippingMethod'], $_POST[ 'Package' ]['track'] );

            unset( $_POST[ 'Package' ]['shippingMethod'], $_POST[ 'Package' ]['track'] );

            $package->attributes = $_POST[ 'Package' ];

//            var_dump( $_POST );exit;

            if( $package->save() ){
                Yii::app()->user->setFlash( 'success', "Package #" .$package->id . " successful edited" );

                $this->redirect( array( 'manage' ) );
            }
        }

        $this->render( 'edit', array( 'package' => $package ) );
    }

    public function actionManage(){
        $model = new Package( 'search' );
        $model->unsetAttributes(); // clear any default values

        if( isset( $_GET[ 'Package' ] ) )
            $model->attributes = $_GET[ 'Package' ];

        $this->render( 'manage', array( 'model' => $model ) );
    }

    public function actionView( $id ){
        $ticket = Ticket::model()->findByPk( $id );

        if( ! Yii::app()->user->checkAccess( 'ticket.to.admin', $ticket->senderId ) )
            throw new CHttpException(401);

        if( !empty( $_POST ) ){
            /// Automatically open this ticket

            $ticket->isClosed = 0;
            $ticket->save( false );

            $message = new Message;
            $message->attributes = $_POST[ 'Message' ];
            $message->ticketId = $ticket->id;
            $message->senderId = Yii::app()->user->id;
            $message->save();
        }

        $this->render( 'view', array( 'ticket' => $ticket, 'message' => Message::model() ) );

        // Mark messages as reviewed
        Message::model()->setReviewed( $id );
    }

    public function actionDelete( $id ){
        $this->loadModel( $id )->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if( !isset( $_GET[ 'ajax' ] ) ){
            Yii::app()->user->setFlash( 'success', "Package #$id successful deleted" );
            $this->redirect( isset( $_POST[ 'returnUrl' ] ) ? $_POST[ 'returnUrl' ] : array( 'manage' ) );
        }
    }

    public function loadModel( $id ){
        $model = Package::model()->findByPk( $id );

        if( $model === null ){
            throw new CHttpException( 404, 'The requested package does not exist.' );
        }

        return $model;
    }
}