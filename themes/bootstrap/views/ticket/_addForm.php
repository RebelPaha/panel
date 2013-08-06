
<?php $form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
     'id'                     => 'ticket-form',
     'type'                   => 'horizontal',
     'enableClientValidation' => true,
     'clientOptions'          => array(
         'validateOnSubmit' => true,
     ),
     'htmlOptions'            => array( 'class' => 'form' ),
)); ?>

<fieldset>
    <legend>Submit new ticket</legend>

    <?php echo $form->textFieldRow( $ticket, 'subject', array( 'class' => 'span5' ) ); ?>

    <?php echo $form->textAreaRow( $message, 'text', array( 'class' => 'span5', 'rows' => '7' ) ); ?>

    <div class="form-actions">
        <?php $this->widget( 'bootstrap.widgets.TbButton',
        array(
             'buttonType' => 'submit',
             'label' => 'Submit',
             'type' => 'primary',
             'icon' => 'ok'
        )
    ); ?>
    </div>

</fieldset>

<?php $this->endWidget(); ?>