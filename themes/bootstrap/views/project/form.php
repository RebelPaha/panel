<?php
$this->pageTitle = Yii::app()->name . ' - ' . $actionTitle;

$this->breadcrumbs = array(
    'Projects' => array('manage'),
    $actionTitle,
);

$activeAddLabel = (bool) $project->isNewrecord;

$this->menu = array(
    array( 'label' => 'OPERATIONS' ),
    array( 'label' => 'Manage Projects', 'icon' => 'list', 'url' => array( 'manage' ) ),
    array( 'label' => 'Add New Project', 'icon' => 'plus', 'url' => array( 'form' ), 'active' => $activeAddLabel ),
);

Yii::app()->clientScript->registerScript( 'form', "
$('#smtpBtn').click(function(){
	$('.smpt-block').show();
});
$('#sendmailBtn').click(function(){
	$('.smpt-block').hide();
});
");

$form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
                                                                         'id'                     => 'project-form',
                                                                         'type'                   => 'horizontal',
                                                                         'enableClientValidation' => true,
                                                                         'clientOptions'          => array(
                                                                             'validateOnSubmit' => true,
                                                                         ),
                                                                         'htmlOptions'            => array( 'class' => 'form' ),
                                                                    )); ?>

<fieldset>
    <legend><?php echo $actionTitle; ?></legend>

    <?php echo $form->textFieldRow( $project, 'name', array( 'class' => 'span3' ) ); ?>

    <?php echo $form->textFieldRow( $project, 'url', array( 'class' => 'span3', 'hint' => 'With "http(s)://"' )); ?>

    <?php echo $form->textFieldRow( $project, 'email',  array( 'class' => 'span3' )); ?>

    <?php
    if( ! Project::model()->count( 'isMain = :isMain', array( ':isMain' => 1 ) ) ){
        echo $form->checkboxRow( $project, 'isDefault', array( 'hint' => 'will be assigned to new users' ) );
    }
    if( ! Project::model()->count( 'isMain = :isMain', array( ':isMain' => 1 ) ) ){
        echo $form->checkboxRow( $project, 'isMain' );
    }
    ?>

    <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
                                                                'toggle'  => 'radio', // 'checkbox' or 'radio'
                                                                'buttons' => array(
                                                                    array(
                                                                        'label' => 'Sendmail',
                                                                        'htmlOptions' => array( 'id' => 'sendmailBtn' ),
                                                                        'active' => (bool) ! $project->smtpServer ),
                                                                    array(
                                                                        'label' => 'SMTP',
                                                                        'htmlOptions' => array( 'id' => 'smtpBtn' ),
                                                                        'active' => (bool) $project->smtpServer
                                                                    ),
                                                                ),
                                                           )
    ); ?>

    <div class="smpt-block<?php if( (bool) ! $project->smtpServer ) echo ' hide'; ?>">
        <legend>SMTP settings</legend>

        <?php echo $form->textFieldRow( $project, 'smtpServer', array( 'class' => 'span3' ) ); ?>

        <?php echo $form->textFieldRow( $project, 'smtpDomain', array( 'class' => 'span3' ) ); ?>

        <?php echo $form->textFieldRow( $project, 'smtpPort', array( 'class' => 'span3' ) ); ?>

        <?php echo $form->textFieldRow( $project, 'smtpLogin', array( 'class' => 'span3' ) ); ?>

        <?php echo $form->textFieldRow( $project, 'smtpPassword', array( 'class' => 'span3' ) ); ?>

        <?php echo $form->checkboxRow( $project, 'smtpSsl' ); ?>


    </div>

    <div class="form-actions">
        <?php $this->widget( 'bootstrap.widgets.TbButton',
            array(
                 'buttonType' => 'submit',
                 'label' => $project->isNewRecord ? 'Add' : 'Save',
                 'type' => 'primary',
                 'icon' => $project->isNewRecord ? 'plus' : 'save'
            )
        ); ?>
        <?php
        if( ! $project->isNewRecord ){
            $this->widget( 'bootstrap.widgets.TbButton', array(
                                                              'label'       => 'Delete',
                                                              'type'        => 'danger',
                                                              'icon'        => 'trash',
                                                              'url'         => array( 'delete', 'id' => $project->id ),
                                                              'htmlOptions' => array(
                                                                  'confirm' => 'Are you sure you want to delete this item?'
                                                              )
                                                         )
            );
        }
        ?>
        <?php $this->widget( 'bootstrap.widgets.TbButton',
        array(
             'label' => 'Cancel',
             'type' => 'link',
             'url' => array( 'project/manage' )
        )
    ); ?>
    </div>

</fieldset>

<?php $this->endWidget(); ?>
