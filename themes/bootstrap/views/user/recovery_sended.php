
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

На ваш e-mail ! было отправлено волшебное письмо.

Если вы не получили письмо в течение приемлемого 
срока — запросите его <a href="/user/recovery">ещё раз</a> или свяжитесь с администрацией.

<?php $this->endWidget(); ?>