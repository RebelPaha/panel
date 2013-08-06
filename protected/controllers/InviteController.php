<?php

class InviteController extends Controller
{
    public function init(){
        Invite::model()->deleteOverdue();
    }

    public function filters(){
        return array(
            array('auth.filters.AuthFilter'),
        );
    }

    public function actionIndex(){
        $model = new Invite();
        $invites = new Invite( 'search') ;
        $invites->unsetAttributes();

        if( ! empty( $_POST['Invite'] ) ){
            $model->email = $_POST[ 'Invite' ][ 'email' ];

            if($model->save()){
                Yii::app()->user->setFlash( 'success', 'The invitation has been successfully created' );

                $this->redirect( '/invite' );
            }
        }

        $this->render( 'index', array( 'model' => $model, 'invites' => $invites ) );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     *
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete( $id ){
        Invite::model()->findByPk( $id )->delete();

        if( ! isset( $_GET[ 'ajax' ] ) )
            $this->redirect( '/invite' );
    }
}