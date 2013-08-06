<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body>

<?php

$this->widget('bootstrap.widgets.TbNavbar', array(
    'collapse' => true,
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'encodeLabel' => false,
            'items'=>array(
                array('label'=>'Home', 'icon' => 'home large', 'url' => array('/site/index')),
                array(
                    'label' => 'Tickets' . $this->unreviewedTickets,
                    'icon'  => 'envelope-alt',
                    'url'   => array( '/ticket' ),
                    'active' => Yii::app()->controller->id === 'ticket',
                    'visible' => Yii::app()->user->checkAccess( 'ticket.to.admin' )
                ),
                array(
                    'label'   => 'Users',
                    'icon'    => 'group large',
                    'url'     => array('/user/manage' ),
                    'visible' => Yii::app()->user->checkAccess( 'user.*' ) &&
                        !Yii::app()->user->checkAccess( 'invite.*' ) &&
                        !Yii::app()->user->isAdmin
                ),
                array(
                    'label'   => 'Users',
                    'icon'    => 'group large',
                    'url'     => '#',
                    'visible' => Yii::app()->user->checkAccess( 'invite.*' ) && Yii::app()->user->checkAccess( 'user.*' ),
                    'active'  => in_array( Yii::app()->controller->id, array( 'user', 'invite' ) ) ||
                                 Yii::app()->controller->module->id === 'auth',
                    'items' => array(
                        array(
                            'label'  => 'Create',
                            'icon'   => 'plus',
                            'url'    => '#',
                            'active' => Yii::app()->controller->action->id === 'create',
//                            'items'  => $this->userCreateItem
                        ),
                        array( 'label' => 'Manage', 'icon' => 'list', 'url' => array('/user/manage' ) ),
                        array(
                            'label'   => 'Permissions',
                            'icon'    => 'certificate',
                            'url'     => array( '/auth' ),
                            'visible' => Yii::app()->user->isAdmin
                        ),
                        '---',
                        array(
                            'label'  => 'Invites',
                            'icon'   => 'coffee',
                            'url'    => array( '/invite' ),
                            'visible'=> Yii::app()->user->checkAccess('invite.*')
                        )
                    )
                ),
                array(
                    'label'   => 'Packages',
                    'icon'    => 'download-alt',
                    'url'     => '#',
//                    'visible' => Yii::app()->user->checkAccess('package.*'),
                    'items'   => array(
                        array(
                            'label'  => 'Create',
                            'icon'   => 'plus',
                            'url'    => '#',
                            'active' => Yii::app()->controller->action->id === 'create',
                        ),
                        array( 'label' => 'Manage', 'icon' => 'list', 'url' => array('/package/manage' ) ),
                    )
                ),
                array(
                    'label'   => 'Setting',
                    'icon'    => 'cogs large',
                    'url'     => '#',
                    'visible' => Yii::app()->user->isAdmin,
                    'items' => array(
                        array( 'label' => 'General', 'icon' => 'globe', 'url' => array('/settings/general' ) ),
                        array( 'label' => 'SMS', 'icon' => 'mobile-phone', 'url' => array('/settings/sms' ) ),
                        array( 'label' => 'E-mail templates', 'icon' => 'envelope', 'url' => array('/settings/templates' ) ),
                        '---',
                        array( 'label' => 'Projects', 'icon' => 'tasks', 'url' => array('/project' ) ),
                    )
                ),
                array('label'=>'Login', 'url'=>array('/login'), 'visible'=>Yii::app()->user->isGuest),
            ),
        ),
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                '---',
                array('label'=>'Logout', 'icon' => 'off large', 'url'=>array('/logout') )
            ),
        ),
        '<span class="navbar-text pull-right">Hello, <strong>' . Yii::app()->user->name . "</strong></span>",
    ),
)); ?>

<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links' => $this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'     => true, // display a larger alert block?
        'fade'      => true, // use transitions?
        'closeText' => '&times;', // close link text - if set to false, no close link is displayed
        'alerts'    => array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        )
    )); ?>

	<?php echo $content; ?>
</div><!-- page -->

</body>
</html>