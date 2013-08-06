<?php
$this->breadcrumbs = array( 'Projects' );

$this->menu = array(
    array( 'label' => 'OPERATIONS' ),
    array( 'label' => 'Manage Projects', 'icon' => 'list', 'url' => array( 'manage' ), 'active' => true ),
    array( 'label' => 'Add New Project', 'icon' => 'plus', 'url' => array( 'form' ) ),
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
<h1>Manage Projects</h1>

<?php $this->widget( 'bootstrap.widgets.TbGridView',
    array(
         'type'         => 'striped condensed',
         'id'           => 'user-grid',
         'dataProvider' => $model->search(),
         'template'     => "{items}",
         'columns'      => array(
             'id',
             array(
                 'name' => 'name',
                 'type' => 'raw',
                 'value' => 'CHtml::link( $data->name, array("project/form", "id" => $data->id ), array("rel" => "tooltip", "title" => "Click to detail view") )'
             ),
             array(
                 'name' => 'email',
                 'type' => 'email',
             ),
             array(
                 'name'   => 'url',
                 'type' => 'url'
             ),
             array(
                 'name' => 'isMain',
                 'type' => 'html',
                 'filter' => false,
                 'value' => '$data->isMain ? CHtml::tag("span", array( "class" => "label label-info" ), "Main" ) : ""'
             ),
             array(
                 'name' => 'isDefault',
                 'type' => 'html',
                 'filter' => false,
                 'value' => '$data->isDefault ? CHtml::tag("span", array( "class" => "label label-info" ), "Default" ) : ""'
             ),
             array(
                 'class'       => 'bootstrap.widgets.TbButtonColumn',
                 'template'    => '{update} {delete}',
                 'updateButtonUrl' => 'Yii::app()->createUrl( "project/form", array("id" => $data->id ) )',
                 'htmlOptions' => array( 'style' => 'width: 50px' ),
             ),
         ),
    )
); ?>