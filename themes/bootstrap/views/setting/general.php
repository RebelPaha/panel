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
                                                              'active' => true
                                                          ),
                                                          array(
                                                              'label' => 'SMS',
                                                              'icon'  => 'mobile-phone',
                                                              'url'   => array( '/settings/sms' )
                                                          ),
                                                          array(
                                                              'label' => 'E-mail Templates',
                                                              'icon'  => 'envelope',
                                                              'url'   => array( '/settings/templates' )
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
    <label class="control-label"><?php echo CHtml::encode( $settings['MAIL_METHOD']->label ); ?></label>

    <div class="controls">
        <?php echo CHtml::activeDropDownList(
            $settings['MAIL_METHOD'],
            "[MAIL_METHOD]value",
            array( 'sendmail' => 'Sendmail', 'smtp' => 'SMTP' ),
            array( 'class' => 'span3')
        ); ?>
    </div>
</div>

<div class="control-group ">
    <label class="control-label"><?php echo CHtml::encode( $settings['INVITE_EXPIRE']->label ); ?></label>

    <div class="controls">
        <div class="input-append">
        <?php echo CHtml::activeTextField( $settings['INVITE_EXPIRE'], "[INVITE_EXPIRE]value", array( 'class' => 'span1' ) ); ?>
            <span class="add-on">days</span>
        </div>
    </div>
</div>

<div class="control-group ">
    <label class="control-label"><?php echo CHtml::encode( $settings['SSN_FIELD']->label ); ?></label>

    <div class="controls">
        <?php echo CHtml::activeCheckBox( $settings['SSN_FIELD'], "[SSN_FIELD]value" ); ?>
    </div>
</div>

<div class="control-group ">
    <label class="control-label"><?php echo CHtml::encode( $settings['REG_COMMENT_ENABLE']->label ); ?></label>

    <div class="controls">
        <?php echo CHtml::activeCheckBox( $settings['REG_COMMENT_ENABLE'], "[REG_COMMENT_ENABLE]value" ); ?>
    </div>
</div>

<div class="control-group ">
    <label class="control-label"><?php echo CHtml::encode( $settings['REG_COMMENT']->label ); ?></label>

    <div class="controls">
        <?php echo CHtml::activeTextArea( $settings['REG_COMMENT'], "[REG_COMMENT]value", array( 'class' => 'span3', 'rows' => 5 ) ); ?>
    </div>
</div>

<div class="control-group ">
    <label class="control-label"><?php echo CHtml::encode( $settings['ITEMS_PER_PAGE']->label ); ?></label>

    <div class="controls">
        <div class="input-append">
            <?php echo CHtml::activeTextField( $settings['ITEMS_PER_PAGE'], "[ITEMS_PER_PAGE]value", array( 'class' => 'span1' ) ); ?>
            <span class="add-on">items</span>
        </div>
        <span class="help-block">On manage pages.</span>
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
