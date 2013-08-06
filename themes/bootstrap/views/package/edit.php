<?php
$this->breadcrumbs = array(
    'Packages' => array( 'manage' ),
    'Edit #' . $package->id,
);

$this->menu = array(
    array( 'label' => 'OPERATIONS' ),
    array( 'label' => 'Create Package', 'icon' => 'plus', 'url' => array( 'create' )),
    array(
        'label' => 'Manage Packages',
        'icon' => 'list',
        'url' => array( 'manage' )
    ),
);
?>

<h1>Edit Package # <?php echo $package->id; ?></h1>

<script type="text/javascript">
$( document).ready( function(){
    var addTrakcRow = function(){
        var $trackRow = $('.tracks .controls:last').html();
        var lastTrackId = parseInt( $trackRow.match(/\[(\d+)\]/)[1] ) + 1;

        $trackRow = $trackRow.replace( /\[\d+\]/g, '[' + lastTrackId + ']' );
        $trackRow = $( '<div class="controls">' + $trackRow + '</div>' );
        $trackRow
            .find('input, select').val('').end()
            .find('button').remove().end();

        if( ! $trackRow.find('.btn-danger').is('.btn-danger') )
            $trackRow.find('.input-append').append( '<a href="#" rel="tooltip" title="Remove track" class="btn btn-danger"><i class="icon-trash"></i></a>');

        $('.tracks .controls:last').after( $trackRow.clone().before('<br>') );
    };

    $('.track-btn').click( addTrakcRow );
    $('.btn-danger').live('click', function(){
        $(this).parents('.controls').prev().remove();
        $(this).parents('.controls').remove();
    });
});
</script>



<?php $form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
                                                                         'id'                     => 'package-form',
                                                                         'type'                   => 'horizontal',
                                                                         'enableClientValidation' => true,
                                                                         'clientOptions'          => array(
                                                                             'validateOnSubmit' => true,
                                                                         ),
                                                                         'htmlOptions'            => array( 'class' => 'form' ),
                                                                    )); ?>
    <fieldset>
        <?php echo $form->dropDownListRow( $package, 'userId', $package->getUsers(), array( 'class' => 'span4' ) ); ?>
        <?php echo $form->textFieldRow( $package, 'name', array( 'class' => 'span4' ) ); ?>
        <?php echo $form->textFieldRow( $package, 'minPrice', array( 'class' => 'span4' ) ); ?>
        <?php echo $form->dropDownListRow( $package, 'status', $package->getStatuses(), array( 'class' => 'span4' ) ); ?>
        <?php echo $form->textFieldRow( $package, 'holder', array( 'class' => 'span4' ) ); ?>
        <?php echo $form->textFieldRow( $package, 'shop', array( 'class' => 'span4' ) ); ?>
        <?php echo $form->dropDownListRow( $package, 'paymentMethod', $package->getPaymentMethods(), array( 'class' => 'span4' ) ); ?>

        <div class="tracks">
            <div class="control-group">
                <?php echo $form->labelEx( $package, 'track', array( 'class' => 'control-label' ) ); ?>

                <?php $i = 0; foreach( $package->track as $track ): ?>
                <?php if( $i !== 0 ): ?>
                    <br />
                <?php endif; ?>
                <div class="controls">
                    <?php echo CHtml::dropDownList( 'Package[shippingMethod][' . $i . ']', $track['shippingMethod'], $package->getShippingMethods(), array( 'class' => 'span1' ) ); ?>
                    <div class="input-append">
                        <?php echo CHtml::textField( 'Package[track][' . $i . ']', $track['track'], array( 'class' => 'span2' ) ); ?>
                        <a href="#" rel="tooltip" title="Remove track" class="btn btn-danger"><i class="icon-trash"></i></a>
                        <?php if( $i === 0 ): ?>
                            <button class="btn track-btn" type="button" title="Add track">+</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>

        <?php $this->widget('application.components.WasDatepicker.WasDatepicker', array(
                                                                                            'model'     => $package,
                                                                                            'attribute' => 'shippingDate',
                                                                                            'form'      => $form,
                                                                                            //model + attribute or 'name'=>'nameInput',
                                                                                            'options'   => array(
                                                                                                'language'           => 'en',
                                                                                                'format'             => 'yyyy-mm-dd',
                                                                                                'autoclose'          => 'true',
                                                                                                'startDate'          => '2000,1,1',
                                                                                                'endDate'            => '2050,1,1',
                                                                                                'weekStart'          => 1,
                                                                                                'startView'          => 2,
                                                                                                'keyboardNavigation' => true
                                                                                            )
                                                                                       )); ?>
        <?php echo $form->textAreaRow( $package, 'instructions', array( 'class' => 'span5', 'rows' => '7' ) ); ?>
        <?php echo $form->textAreaRow( $package, 'comment', array( 'class' => 'span5', 'rows' => '7' ) ); ?>
        <?php echo $form->textAreaRow( $package, 'privateComment', array( 'class' => 'span5', 'rows' => '7' ) ); ?>

        <?php echo $form->checkBoxRow( $package, 'isProblem' ); ?>

        <div class="form-actions">
            <?php $this->widget( 'bootstrap.widgets.TbButton',
                array(
                     'buttonType' => 'submit',
                     'label' => 'Save',
                     'type' => 'success',
                     'icon' => 'save'
                )
            ); ?>
            <?php $this->widget( 'bootstrap.widgets.TbButton',
                array(
                     'label' => 'Delete',
                     'type' => 'danger',
                     'icon' => 'trash',
                     'url' => array( 'package/delete', 'id' => $package->id ),
                     'htmlOptions' => array(
                         'confirm' => 'Are you sure you want to delete this item?'
                     )
                )
            ); ?>
            <?php $this->widget( 'bootstrap.widgets.TbButton',
                array(
                     'label' => 'Cancel',
                     'type' => 'link',
                     'url' => array( 'package/manage' )
                )
            ); ?>
        </div>

    </fieldset>

<?php $this->endWidget(); ?>