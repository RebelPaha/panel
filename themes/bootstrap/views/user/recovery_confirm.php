
<?php 
$form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
     'id'                     => 'recovery-confirm-form',
     'type'                   => 'vertical',
     'enableClientValidation' => true,
     'clientOptions'          => array(
         'validateOnSubmit'	  => true,
     ),
     'htmlOptions'   	      => array( 'class' => 'span4 form offset4 well' ),
));
if(!$is_isset_hash){ ?>
	
	Неверно указан хеш, либо его срок истек, вернитесь для повторного <a href="/user/recovery">запроса</a>.
	
<?php }elseif(!$is_positiv && $is_isset_hash){ ?>

<div class="form-actions">
<?php echo  $form->passwordFieldRow( $model, 'password',  array( 'class' => 'span3' )); ?>
<?php echo  $form->passwordFieldRow( $model, 'rpassword',  array( 'class' => 'span3' )); ?>
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
<?php 
}elseif($is_positiv && $is_isset_hash){
	?>
	Пароль успешно изменен, Вы можете <a href="/login">авторизироваться</a>.
	<?php
}else{
	?>
	Ошибка  восстановления пароля.
	<?php
}

$this->endWidget(); ?>