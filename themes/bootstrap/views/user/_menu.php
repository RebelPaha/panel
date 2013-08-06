<?php

$this->menu = array(
    array( 'label' => 'OPERATIONS' ),
    array(
        'label' => 'Advanced Search',
        'icon' => 'search',
        'url' => '#',
        'linkOptions' => array( 'class' => 'search-button' )
    ),
);

foreach( $this->userRoles as $role ){
    if( Yii::app()->user->checkAccess( 'user.manage.' . $role['name'] ) && ! $manageUsers ) {
        $this->menu[] = array( 'label' => 'Manage Users', 'icon' => 'list' );
        $manageUsers = true;
    }

    $this->menu[] = array(
        'label'   => $role['label'] . 's',
        'url'     => array( 'manage', 'role' => $role['name'] ),
        'active'  => $this->createUrl( 'user/manage', array('role' => $role['name'] ) ) === Yii::app()->request->requestUri,
        'visible' => Yii::app()->user->checkAccess( 'user.manage.' . $role['name'] )
    );
}

foreach( $this->userRoles as $role ){
    if( Yii::app()->user->checkAccess( 'user.create.' . $role['name'] ) && ! $addNewUser ) {
        $this->menu[] = array( 'label'  => 'Add New User',  'icon'   => 'plus' );
        $addNewUser = true;
    }

    $this->menu[] = array(
        'label'   => $role['label'],
        'url'     => array( 'create', 'role' => $role['name'] ),
        'active'  => $this->createUrl( 'user/create', array('role' => $role['name'] ) ) === Yii::app()->request->requestUri,
        'visible' => Yii::app()->user->checkAccess( 'user.create.' . $role['name'] )
    );
}
