<?php

$this->pageTitle = Yii::app()->name . ' - Registration';
?>

<?php $form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
     'id'                     => 'registration-form',
     'type'                   => 'horizontal',
     'enableClientValidation' => true,
     'clientOptions'          => array(
         'validateOnSubmit' => true,
     ),
     'htmlOptions'            => array( 'class' => 'span5 form offset4 well' ),
)); ?>

<fieldset>
    <legend>Registration</legend>

    <?php echo $form->textFieldRow( $model, 'username',
        array(
            'class' => 'span3'
        )
    ); ?>

    <?php echo $form->passwordFieldRow( $model, 'password',
        array(
             'class' => 'span3'
        )
    ); ?>

    <?php echo $form->passwordFieldRow( $model, 'password2',
        array(
             'class' => 'span3'
        )
    ); ?>

    <?php echo $form->textFieldRow( $model, 'email',
        array(
             'class' => 'span3'
        )
    ); ?>


    <div class="form-actions">
        <?php $this->widget( 'bootstrap.widgets.TbButton',
            array(
                 'buttonType' => 'submit', 'label' => 'Register', 'type' => 'primary', 'icon' => 'ok',
            )
        ); ?>
    </div>

</fieldset>

<?php $this->endWidget(); ?>
