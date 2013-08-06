<?php $form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
     'action' => Yii::app()->createUrl( $this->route ),
     'method' => 'get',
     'id'                     => 'search-form',
     'type'                   => 'horizontal',
     'enableClientValidation' => false,
     'clientOptions'          => array(
         'validateOnSubmit' => false,
     ),
     'htmlOptions'            => array( 'class' => 'form' ),
)); ?>


    <?php echo $form->dropDownListRow( $model, 'userId', $model->getUsers(), array( 'class' => 'span3' ) ); ?>

    <?php echo $form->dropDownListRow( $model, 'status', $model->getStatuses(), array( 'class' => 'span3' )); ?>

    <div class="form-actions">
        <?php $this->widget( 'bootstrap.widgets.TbButton',
        array(
             'buttonType' => 'submit',
             'label' => 'Search',
             'icon' => 'search',
        )
    ); ?>
    </div>

<?php $this->endWidget(); ?>