<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = Yii::app()->name . ' - Invites';
$this->breadcrumbs = array( 'Invites' );


Yii::app()->clientScript->registerScript('index',"$(document).ready( function(){
        $( '.input-link').focus( function(){
           $(this).select();
        });
    });");
?>

<h1>Invites</h1>

<?php $form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
     'id'                     => 'invite-form',
     'type'                   => 'horizontal',
     'enableClientValidation' => true,
     'clientOptions'          => array(
         'validateOnSubmit' => true,
     ),
     'htmlOptions'            => array( 'class' => 'form' ),
)); ?>

<fieldset>
    <legend>Add new invite</legend>

    <?php echo $form->textFieldRow( $model, 'email'); ?>
    <div class="form-actions">
        <?php $this->widget( 'bootstrap.widgets.TbButton', array(
             'buttonType' => 'submit',
             'label' => 'Add',
             'type' => 'primary',
             'icon' => 'plus'
        )); ?>
    </div>

</fieldset>

<?php $this->endWidget(); ?>

<?php $this->widget( 'bootstrap.widgets.TbGridView',
    array(
         'type'         => 'striped condensed',
         'id'           => 'invite-grid',
         'dataProvider' => $invites->search(),
         'template'     => "{items} {pager}",
//         'ajaxUpdate'=>false,
         'columns'      => array(
             'id',
             'email',
             array(
                 'name'  => 'hash',
                 'type'  => 'raw',
                 'value' => 'CHtml::textField("", "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->createUrl("registration", array("hash" => $data->hash ) ), array( "class" => "input-xxlarge input-link" ) )'
             ),
             'created',
             array(
                 'class'       => 'bootstrap.widgets.TbButtonColumn',
                 'template'    => '{delete}',
                 'htmlOptions' => array( 'style' => 'width: 50px' ),
             ),
         ),
    )
); ?>