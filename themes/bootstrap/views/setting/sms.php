<?php
//$this->pageTitle =
$this->breadcrumbs = array( 'Settings' );

?>

<h1><i class="icon-cogs"></i> Settings</h1>

<?php $this->widget( 'bootstrap.widgets.TbMenu', array(
                                                      'type'    => 'tabs', // '', 'tabs', 'pills' (or 'list')
                                                      'stacked' => false, // whether this is a stacked menu
                                                      'items'   => array(
                                                          array(
                                                              'label'  => 'General',
                                                              'icon'   => 'globe',
                                                              'url'    => array( '/settings/general' ),
                                                          ),
                                                          array(
                                                              'label' => 'SMS',
                                                              'icon'  => 'mobile-phone',
                                                              'url'   => array( '/settings/sms'),
                                                              'active' => true
                                                          ),
                                                          array(
                                                              'label' => 'E-mail Templates',
                                                              'icon'  => 'envelope',
                                                              'url'   => array( '/settings/templates' ),
                                                          ),
                                                      ),
                                                 )
);
$form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
                                                                   'id'                   => 'setting-form',
                                                                   'type'                 => 'horizontal',
                                                                   'enableAjaxValidation' => false,
                                                              )
);
?>

<div class="control-group ">
    <label class="control-label"><?php echo CHtml::encode( $settings['SMS_ENABLE']->label ); ?></label>

    <div class="controls">
        <?php echo CHtml::activeCheckBox( $settings['SMS_ENABLE'], "[SMS_ENABLE']value" ); ?>
    </div>
</div>

<div class="control-group ">
    <label class="control-label"><?php echo CHtml::encode( $settings['SMSC_ACCOUNT']->label ); ?></label>

    <div class="controls">
        <?php echo CHtml::activeTextField( $settings['SMSC_ACCOUNT'], "[SMSC_ACCOUNT']value", array( 'class' => 'span3' ) ); ?>
    </div>
</div>

<div class="control-group ">
    <label class="control-label"><?php echo CHtml::encode( $settings['SMSC_PASSWORD']->label ); ?></label>

    <div class="controls">
        <?php echo CHtml::activeTextField( $settings['SMSC_PASSWORD'], "[SMSC_PASSWORD']value", array( 'class' => 'span3' ) ); ?>
    </div>
</div>


<div class="form-actions">
    <?php $this->widget( 'bootstrap.widgets.TbButton', array(
                                                            'buttonType' => 'submit',
                                                            'type'       => 'success',
                                                            'icon'       => 'save',
                                                            'label'      => 'Save',
                                                       )
    ); ?>
</div>

<?php $this->endWidget(); ?>
