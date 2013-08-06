<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Packages' => array('manage'),
    'Manage',
);

$this->menu = array(
    array( 'label' => 'OPERATIONS' ),
    array(
        'label'  => 'Create Package',
        'icon'   => 'plus',
        'url'    => '#',
        'active' => Yii::app()->controller->action->id === 'create',
    ),
    array(
        'label' => 'Manage Packages',
        'icon' => 'list',
        'url' => array( 'manage' ), 'active' => true
    ),
    array(
        'label' => 'Advanced Search',
        'icon' => 'search',
        'url' => '#',
        'linkOptions' => array( 'class' => 'search-button' )
    ),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#package-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Packages</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<div class="search-form hide">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget( 'bootstrap.widgets.TbGridView',
    array(
          'type'         => 'striped bordered condensed',
          'id'           => 'package-grid',
          'dataProvider' => $model->search(),
          'filter'       => $model,
          'template'     => "{items} {pager}",
          'columns'      => array(
              'id',
              array(
                  'name'   => 'userId',
                  'filter' => $model->getUsers(),
                  'type'   => 'raw',
                  'value'  => 'CHtml::link( $data->userId, array("user", "id" => $data->userId ), array("rel" => "tooltip", "title" => "Click to detail view") )'
              ),
              'name',
              array(
                  'name'   => 'status',
                  'filter' => $model->getStatuses()
              ),
              array(
                  'class'       => 'bootstrap.widgets.TbButtonColumn',
                  'template'    => '{update} {delete}',
                  'htmlOptions' => array( 'style' => 'width: 40px' ),
              ),
          ),
    )
); ?>
