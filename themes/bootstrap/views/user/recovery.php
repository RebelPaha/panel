
<?php 
$form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
     'id'                     => 'recovery-form',
     'type'                   => 'vertical',
     'enableClientValidation' => true,
     'clientOptions'          => array(
         'validateOnSubmit'	  => true,
     ),
     'htmlOptions'   	      => array( 'class' => 'span4 form offset4 well' ),
));
?>
Введите e-mail, на который была зарегистрирована ваша учетная запись, 
и вы получите инструкции 
для восстановления пароля.
<div class="form-actions">
<?php

echo  $form->textFieldRow( $model, 'email',  array( 'class' => 'span3' ));
?>
<?php // echo CHtml::activeLabelEx($model, 'captcha')?>
<?php $this->widget('CCaptcha') ?>
<?php //echo CHtml::activeTextField($model, 'captcha',  array( 'class' => 'span3' ))
echo  $form->textFieldRow( $model, 'captcha',  array( 'class' => 'span3' )); ?>
</div>
<div class="form-actions">
<?php
$this->widget(
            'bootstrap.widgets.TbButton',
            array(
                 'buttonType' => 'submit',
                 'label' =>  'Save',
                 'type' => 'success',
                 'icon' =>  'save'
            )
);

 $this->widget( 'bootstrap.widgets.TbButton', array( 'label' => 'Cancel', 'type' => 'link', 'url' => array( 'manage' ) ) );
?>
</div><!--form-actions-->
<?php $this->endWidget(); ?>