<?php

class ProjectController extends Controller
{
    public $layout = '//layouts/column2';
    public $defaultAction = 'manage';

    /**
     * @return array action filters
     */
    public function filters(){
        return array(
            array('auth.filters.AuthFilter'),
        );
    }

    public function actionForm( $id = null ){
        if( is_null( $id ) ){
            $actionTitle = 'Add New Project';
            $project = new Project;
            $project->smtpPort = 25;
        }
        else {
            $project = $this->loadModel( $id );
            $actionTitle = 'Edit Project #' . $id;
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if( isset( $_POST[ 'Project' ] ) ){
            $project->attributes = $_POST[ 'Project' ];

            if( $project->save() ){
                Yii::app()->user->setFlash( 'success', "Project \"" . $project->name . "\" successful saved" );

                $this->redirect( array( 'manage' ) );
            }
        }

        $this->render( 'form', array( 'project' => $project, 'actionTitle' => $actionTitle ) );
    }

    /**
     * Manages all models.
     */
    public function actionManage(){
        $model = new Project( 'search' );
        $model->unsetAttributes(); // clear any default values

        if( isset( $_GET[ 'Project' ] ) )
            $model->attributes = $_GET[ 'Project' ];

        $this->render( 'manage', array( 'model' => $model ) );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     *
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete( $id ){
        $this->loadModel( $id )->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if( !isset( $_GET[ 'ajax' ] ) ){
            Yii::app()->user->setFlash( 'success', "Project #$id successful deleted" );
            $this->redirect( isset( $_POST[ 'returnUrl' ] ) ? $_POST[ 'returnUrl' ] : array( 'manage' ) );
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param integer $id the ID of the model to be loaded
     *
     * @return Project the loaded model
     * @throws CHttpException
     */
    public function loadModel( $id ){
        $model = Project::model()->findByPk( $id );
        if( $model === null )
            throw new CHttpException( 404, 'The requested page does not exist.' );

        return $model;
    }
}