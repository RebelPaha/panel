<?php

class SettingController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters(){
        return array(
            array( 'auth.filters.AuthFilter' )
        );
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id the ID of the model to be updated
     */
    public function actionIndex( $group = 'general' ){
        $settings = Setting::model()->getItems( $group );

        if( !empty( $_POST ) ){
            foreach( $_POST[ 'Setting' ] as $key => $value ){
                $settings[ $key ]->value = ! empty($value['value']) ? $value['value'] : '';
                $settings[ $key ]->save( false );
            }

            Yii::app()->user->setFlash( 'success', "Template \"" . $settings[ $key ]->key . "\" successful saved" );
        }


        $this->render( $group, array( 'settings' => $settings ) );
    }

    public function actionTemplates( $id = null ){
        $renderVars = array(
            'templates' => Setting::model()->findAllByAttributes( array( 'group' => 'templates' ), array( 'select' => array( 'id', 'label' ) ) )
        );

        if( !empty( $id ) && $template = Setting::model()->findByPk( $id ) ){
            $renderVars['template'] = $template;

            if( !empty( $_POST['Setting'] ) && $template->validate() ){
                $template->label = $_POST['Setting']['label'];
                $template->value = $_POST['Setting']['value'];
                $template->save( false );
                Yii::app()->user->setFlash( 'success', "Template \"" . $template->key . "\" successful saved" );
            }

        }

        $this->render( 'templates', $renderVars );
    }
}
