<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */
$this->pageTitle = Yii::app()->name . ' - Sign In';
?>

<?php $form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
     'id'                     => 'login-form',
     'type'                   => 'vertical',
     'enableClientValidation' => true,
     'clientOptions'          => array(
         'validateOnSubmit' => true,
     ),
     'htmlOptions'            => array( 'class' => 'span4 form offset4 well' ),
)); ?>

<fieldset>
    <legend>Sign In</legend>

    <?php echo $form->textFieldRow( $model, 'username', array( 'class' => 'span4' )); ?>

    <?php echo $form->passwordFieldRow( $model, 'password', array( 'class' => 'span4' )); ?>

    <?php echo $form->checkBoxRow( $model, 'rememberMe' ); ?>

    <?php $this->widget( 'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit', 'label' => 'Login',
        'type'       => 'info', 'icon' => 'signin', 'block' => true
    )); ?>

    <div class="pull-left"><?php echo CHtml::link( 'Lost Password?', 'recovery' ); ?></div>
</fieldset>

<?php $this->endWidget(); ?>
