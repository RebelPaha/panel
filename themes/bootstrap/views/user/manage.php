<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('manage'),
    'Manage',
);

$this->renderPartial('_menu',array( 'model' => $model ) );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage <?php echo ucfirst( Yii::app()->request->getParam( 'role' ) ); ?>s</h1>

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
          'id'           => 'user-grid',
//          'ajaxUpdate'=>false,
          'dataProvider' => $model->search(),
          'filter'       => $model,
          'template'     => "{items} {pager}",
          'columns'      => array(
              'id',
              array(
                  'name' => 'username',
                  'type' => 'raw',
                  'value' => 'CHtml::link( $data->username, array("user", "id" => $data->id ), array("rel" => "tooltip", "title" => "Click to detail view") )'
              ),
              'email',
              array(
                  'name'   => 'state',
                  'filter' => $model->getStates(),
              ),
              array(
                  'name'  => 'profile.addres',
                  'value' => '$data->profile->address'
              ),
              array(
                  'class'       => 'bootstrap.widgets.TbButtonColumn',
                  'template'    => '{update} {delete}',
                  'htmlOptions' => array( 'style' => 'width: 40px' ),
              ),
          ),
    )
); ?>
