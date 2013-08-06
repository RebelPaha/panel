<?php
$this->breadcrumbs=array(
    'Tickets',
);

$this->menu = array(
    array( 'label' => 'OPERATIONS' ),
    array( 'label' => 'Create Ticket', 'icon' => 'plus', 'url' => array( 'create' ) ),
    array(
        'label'  => 'Manage Tickets' . $this->unreviewedTickets,
        'icon'   => 'list',
        'url'    => array( 'manage' ),
        'active' => true
    ),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<h1>Manage Tickets</h1>

<?php $this->widget( 'bootstrap.widgets.TbGridView',
    array(
         'type'         => 'striped condensed',
         'id'           => 'ticket-grid',
         'dataProvider' => $model->search(),
         'filter'       => $model,
         'template'     => "{items} {pager}",
         'columns'      => array(
             'id',
             array(
                 'name' => 'senderId',
                 'type' => 'raw',
                 'value' => 'CHtml::link($data->sender->username, array("user", "id" => $data->sender->id), array( "title" => "View This User", "rel" => "tooltip"))',
                 'filter' => CHtml::listData( $model->getSenders(), 'id', 'name', 'role'),
                 'visible' => Yii::app()->user->checkAccess( 'ticket.*' )
             ),
             'subject',
             array(
                 'name' => 'isClosed',
                 'type' => 'html',
                 'filter' => false,
                 'value' => '$data->isClosed ? CHtml::tag("span", array( "class" => "label" ), "Closed" ) : ""'
             ),
             array(
                 'name'  => 'msgQty',
                 'type'  => 'html',
                 'filter' => false,
                 'value' => '$data->msgQty ? CHtml::tag("span", array( "class" => "badge badge-warning" ), $data->msgQty ) : ""'
             ),
             array(
                 'name' => 'created',
                 'type' => 'datetime',
                 'filter' => false,
             ),
             array(
                 'class'   => 'bootstrap.widgets.TbButtonColumn',
                 'buttons' => array(
                     'open' => array(
                         'label'   => 'Open',
                         'icon'    => "ok",
                         'url'     => 'Yii::app()->createUrl( "/ticket/toggle", array( "id" => $data->id) )',
                         'tooltip' => 'Open',
                         'visible' => '$data->isClosed'

                     ),
                     'close' => array(
                         'label'   => 'Close',
                         'icon'    => "remove-sign",
                         'url'     => 'Yii::app()->createUrl( "/ticket/toggle", array( "id" => $data->id) )',
                         'tooltip' => 'Close',
                         'visible' => '!$data->isClosed'
                     ),
                 ),
//                 'deleteButtonVisible' => 'false',
                 'template'    => '{view} {open} {close} {delete}',
                 'htmlOptions' => array( 'style' => 'width: 50px' ),
             ),
         ),
    )
); ?>