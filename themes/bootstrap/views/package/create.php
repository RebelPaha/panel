<?php
$this->breadcrumbs = array(
    'Packages' => array( 'manage' ),
    'Create',
);

$this->menu = array(
    array( 'label' => 'OPERATIONS' ),
    array( 'label' => 'Create Package', 'icon' => 'plus', 'url' => array( 'create' ), 'active' => true ),
    array(
        'label' => 'Manage Packages',
        'icon' => 'list',
        'url' => array( 'manage' )
    ),
);
?>

<h1>Create Package</h1>

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
        <legend>Submit new package</legend>

        <?php echo $form->dropDownListRow( $package, 'userId', $package->getUsers(), array( 'class' => 'span4' ) ); ?>
        <?php echo $form->textFieldRow( $package, 'name', array( 'class' => 'span4' ) ); ?>
        <?php echo $form->textFieldRow( $package, 'minPrice', array( 'class' => 'span4' ) ); ?>
        <?php echo $form->textFieldRow( $package, 'holder', array( 'class' => 'span4' ) ); ?>
        <?php echo $form->textFieldRow( $package, 'shop', array( 'class' => 'span4' ) ); ?>
        <?php echo $form->dropDownListRow( $package, 'paymentMethod', $package->getPaymentMethods(), array( 'class' => 'span4' ) ); ?>


        <div class="tracks">
            <div class="control-group">
                <?php echo $form->labelEx( $package, 'track', array( 'class' => 'control-label' ) ); ?>

                <div class="controls">
                    <?php echo CHtml::dropDownList( 'Package[shippingMethod][1]', '', $package->getShippingMethods(), array( 'class' => 'span1' ) ); ?>
                    <div class="input-append">
                        <?php echo CHtml::activeTextField( $package, 'track[1]', array( 'class' => 'span2' ) ); ?>
                        <button class="btn track-btn" type="button" title="Add track">+</button>
                    </div>
                </div>
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
        <?php echo $form->textAreaRow( $package, 'comment', array( 'class' => 'span5', 'rows' => '7' ) ); ?>

        <div class="form-actions">
            <?php $this->widget( 'bootstrap.widgets.TbButton',
                array(
                     'buttonType' => 'submit',
                     'label' => 'Save',
                     'type' => 'success',
                     'icon' => 'plus'
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