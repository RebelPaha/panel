<?php

class TicketController extends Controller
{
    public $layout = '//layouts/column2';
    public $defaultAction = 'manage';

    public function filters(){
        return array(
            array('auth.filters.AuthFilter'),
            'accessControl'
        );
    }

    public function accessRules(){
        return array(
            array(
                'allow',
                'actions'    => array( 'view', 'create', 'delete', 'toggle', 'manage' ),
                'roles'      => array( 'ticket.to.admin' ),
            )
        );
    }

    public function actionCreate(){
        if( isset( $_POST[ 'Ticket' ] ) ){
            $ticket = new Ticket;
            $message = new Message;
            $ticket->attributes = $_POST[ 'Ticket' ];
            $message->attributes = $_POST[ 'Message' ];

            if( $ticket->save() ){
                $message->ticketId = $ticket->id;
                $message->senderId = $ticket->senderId;

                if( $message->save() ){
                    Yii::app()->user->setFlash( 'success', "Ticket #" .$ticket->id . " successful submitted" );

                    $this->redirect( array( 'manage' ) );
                }
            }
        }
        else {
            $ticket = Ticket::model();
            $message = Message::model();
        }

        $this->render( 'create', array( 'ticket' => $ticket, 'message' => $message ) );
    }

    public function actionManage(){
        $model = new Ticket( 'search' );
        $model->unsetAttributes(); // clear any default values

        if( isset( $_GET[ 'Ticket' ] ) )
            $model->attributes = $_GET[ 'Ticket' ];

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
            Yii::app()->user->setFlash( 'success', "Ticket #$id successful deleted" );
            $this->redirect( isset( $_POST[ 'returnUrl' ] ) ? $_POST[ 'returnUrl' ] : array( 'manage' ) );
        }
    }

    public function actionToggle( $id ){
        $this->loadModel( $id )->toggle();

        if( !isset( $_GET[ 'ajax' ] ) ){
            Yii::app()->user->setFlash( 'success', "State ticket #$id is switched" );
            $this->redirect( isset( $_POST[ 'returnUrl' ] ) ? $_POST[ 'returnUrl' ] : Yii::app()->request->urlReferrer );
        }
    }


    public function loadModel( $id ){
        $model = Ticket::model()->findByPk( $id );

        if( $model === null )
            throw new CHttpException( 404, 'The requested page does not exist.' );

        return $model;
    }
}