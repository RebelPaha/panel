<?php

$this->breadcrumbs = array(
    'Users' => array('manage'),
    'update',
);

//$this->menu = array(
//    array( 'label' => 'OPERATIONS' ),
//    array( 'label' => 'Manage Users', 'icon' => 'list', 'url' => array( 'manage' ), 'active' => true ),
//    array(
//        'label'  => 'Add New User',
//        'icon'   => 'plus',
//        'url'    => '#',
//        'active' => Yii::app()->controller->action->id === 'create',
//        'items'  => $this->userCreateItem
//    ),
//);

?>

<h1>Update User</h1>

<?php $this->renderPartial('_form', $renderModels ); ?>
