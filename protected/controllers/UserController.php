<?php

class UserController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'manage';


    /**
     * @return array action filters
     */
    public function filters(){
        return array(
            array( 'auth.filters.AuthFilter - login logout registration recovery captcha' ),
        );
    }

    public function actions(){
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
            ),
        );
    }

    public function accessRules(){
        return array(// если используется проверка прав, не забывайте разрешить доступ к
            // действию, отвечающему за генерацию изображения
//            array('allow',
//              //  'actions'=>array('captcha','recovery'),
//                'users'=>array('*'),
//            ),
//            array('deny',
//                'users'=>array('*'),
//            ),
        );
    }


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate( $role = 'user' ){
        if( !in_array( $role, array_keys( Yii::app()->authManager->getRoles() ) ) ){
            throw new CHttpException( '404', 'Role ' . $role . ' is not exist.' );
        }
        elseif( Yii::app()->user->checkAccess( 'user.crate.' . $role ) ){
            throw new CHttpException( 401, 'You are not allowed to create user who have the role of "' . $role . '".'  );
        }

        $user         = new User;
//        var_dump( $user->getUsersFromRole() );exit;
        $renderModels = array( 'user' => $user );

        if( $role === 'user' ){
            $profile                            = new Profile;
            $renderModels[ 'profile' ]          = $profile;
            $renderModels[ 'projectsProvider' ] = new CActiveDataProvider( 'Project' );
        }

        if( isset( $_POST[ 'User' ] ) ){
            $user->attributes = $_POST[ 'User' ];
            $user->created    = 'NOW()';
            if( $role === 'user' )
                $isValid = $user->validate() && $profile->validate();
            else
                $isValid = $user->validate();
            if( $user->save( false ) ){
                if( $role === 'user' ){
                    $profile->attributes = $_POST[ 'Profile' ];
                    $profile->userId     = $user->id;
                    $profile->save( false );
                }

                // Set role to user
                Yii::app()->authManager->assign( $role, $user->id );
                Yii::app()->authManager->save();

                Yii::app()->user->setFlash( 'success', ucfirst( $role ) . ' "' . $user->username . '" successful created' );
                $this->redirect( array( 'manage' ) );
            }
        }

        $this->render( 'create', array( 'renderModels' => $renderModels, 'role' => $role ) );
    }

    public function actionUpdate( $id ){
        $userWith = array( 'profile' );

//        if( $)

        $user         = $this->loadModel( $id, $userWith );
        $renderModels = array( 'user' => $user );
        if( $user->profile ){
            $profile                            = $user->profile;
            $renderModels[ 'profile' ]          = $profile;
            $renderModels[ 'projectsProvider' ] = new CActiveDataProvider( 'Project' );
        }
        if( isset( $_POST[ 'User' ] ) ){
            $user->attributes = $_POST[ 'User' ];
            $user->created    = 'NOW()';
            if( isset( $_POST[ 'Profile' ] ) )
                $isValid = $user->validate() && $profile->validate();
            else
                $isValid = $user->validate();
            if( $user->save( false ) ){
                if( isset( $_POST[ 'Profile' ] ) ){
                    $profile->attributes = $_POST[ 'Profile' ];
                    $profile->userId     = $user->id;
                    $profile->save( false );
                }

                //Yii::app()->user->setFlash( 'success', 'User "' . $user->username . '" successful updated' );
                // $this->redirect( array( 'manage' ) );
            }
        }
        $this->render( 'update', array( 'renderModels' => $renderModels ) );
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
        if( !isset( $_GET[ 'ajax' ] ) )
            $this->redirect( isset( $_POST[ 'returnUrl' ] ) ? $_POST[ 'returnUrl' ] : array( 'manage' ) );
    }

    /**
     * Manages all models.
     */
    public function actionManage( $role ){
        if( $role && ! Yii::app()->user->checkAccess( 'user.manage.' . $role ) ){
            throw new CHttpException( 404, 'You are not allowed to manage users who have the role of "' . $role . '".'  );
        }

        $model = new User( 'search' );
        $model->unsetAttributes(); // clear any default values

        if( isset( $_GET[ 'User' ] ) )
            $model->attributes = $_GET[ 'User' ];

        $this->render( 'manage', array( 'model' => $model ) );
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param integer $id the ID of the model to be loaded
     *
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel( $id, $with = array() ){
        $model = User::model()->with( $with )->findByPk( $id );
        if( $model === null )
            throw new CHttpException( 404, 'The requested page does not exist.' );

        return $model;
    }

    /**
     * Displays the login page
     */
    public function actionLogin(){
        if( !Yii::app()->user->isGuest ){
            Yii::app()->user->setFlash( 'success', 'You are currently logged' );
            $this->redirect( Yii::app()->user->returnUrl );
        }
        $this->layout = 'clear';
        $model = new LoginForm;
        // if it is ajax validation request
        if( isset( $_POST[ 'ajax' ] ) && $_POST[ 'ajax' ] === 'login-form' ){
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }
        // collect user input data
        if( isset( $_POST[ 'LoginForm' ] ) ){
            $model->attributes = $_POST[ 'LoginForm' ];
            // validate user input and redirect to the previous page if valid
            if( $model->validate() && $model->login() )
                $this->redirect( Yii::app()->user->returnUrl );
        }
        // display the login form
        $this->render( 'login', array( 'model' => $model ) );
    }

    public function actionRegistration( $hash ){
        Invite::model()->deleteOverdue();
        if( empty( $hash ) || !$invite = Invite::model()->findByAttributes( array( 'hash' => $hash ) ) ){
            throw new CHttpException( 404, 'This invite is overdue' );
        }
        $this->layout = 'clear';
        $model        = new RegistrationForm;
        $model->email = $invite->email;
        $newUser      = new User;
        // if it is ajax validation request
        if( isset( $_POST[ 'ajax' ] ) && $_POST[ 'ajax' ] === 'registration-form' ){
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }
        // collect user input data
        if( isset( $_POST[ 'RegistrationForm' ] ) ){
            $model->attributes = $_POST[ 'RegistrationForm' ];
            // validate user input and redirect to the previous page if valid
            if( $model->validate() ){
                $newUser->attributes = $_POST[ 'RegistrationForm' ];
                $newUser->state      = 'new';
                $newUser->save();
                Invite::model()->deleteByHash( $hash );
                $this->redirect( Yii::app()->user->loginUrl );
            }
        }
        // display the registration form
        $this->render( 'registration', array( 'model' => $model ) );
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout(){
        Yii::app()->user->logout();
        $this->redirect( Yii::app()->user->loginUrl );
    }

    public function actionRecovery( $hash = "" ){
        $modelRecover = new Recover;
        $this->layout = 'clear';
        if( !empty( $hash ) ){ //получаем хэш, проверяем его и задаем пароли
            $is_positiv    = false; //результат введения новых паролей
            $is_isset_hash = false; //действителен данный хеш
            //echo $hash;
            $modelRC = new RecoveryConfirmForm;
            if( $user_tmp = $modelRecover->isUserCode( $hash ) ){
                $is_isset_hash = true;
            }
            if( isset( $_POST[ 'RecoveryConfirmForm' ] ) && $is_isset_hash ){
                $modelRC->attributes = $_POST[ 'RecoveryConfirmForm' ];
                if( $modelRC->validate() ){
                    $old_user_imp = User::model()->findByPk( $user_tmp->user_id );
                    $_identity    = new UserIdentity( $old_user_imp->username, $modelRC->password );
                    $pass_hash = $_identity->cryptPass( $modelRC->password );
                    User::model()->updateByPk( $user_tmp->user_id, array( 'password' => $pass_hash ) );
                    $modelRecover->deleteAll( 'user_id=:user_id', array( ':user_id' => $user_tmp->user_id ) );
                    $is_positiv = true;
                }
            }
            $this->render( 'recovery_confirm', array( 'model'         => $modelRC,
                                                      "is_positiv"    => $is_positiv,
                                                      "is_isset_hash" => $is_isset_hash
                                               )
            );
            Yii::app()->end();
        }
        $model = new RecoveryForm;

        if( isset( $_POST[ 'RecoveryForm' ] ) ){ //формируем и отправляем запрос на восстановление пароля
            $model->attributes = $_POST[ 'RecoveryForm' ];
            // validate user input and redirect to the previous page if valid
            if( $model->validate() ){ //тут сразу идет проверка наличия этого email в системе
                $tmp_res = $modelRecover->setNewCode( $model->email );
                $hash_url = Yii::app()->getBaseUrl( true ) . "/user/recovery/hash/" . $modelRecover->code;
                $text = "Чтобы установить новый пароль, откройте эту ссылку: " .
                    "<a href='" . $hash_url . "'>" . $hash_url . "</a>";
                $message = new YiiMailMessage;
                $message->setBody( $text, 'text/html' );
                $message->subject = 'Password recovery';
                $message->addTo( $model->email );
                $message->from = Yii::app()->params[ 'adminEmail' ];
                Yii::app()->mail->send( $message );
                $this->render( 'recovery_sended', array( 'model' => $model ) );
                Yii::app()->end();

            }
        }
        $this->render( 'recovery', array( 'model' => $model ) );
    }

    /**
     * Performs the AJAX validation.
     *
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation( $model ){
        if( isset( $_POST[ 'ajax' ] ) && $_POST[ 'ajax' ] === 'user-form' ){
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }
    }
}
