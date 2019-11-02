<?php
/* @var $this TaskController */
/* @var $model Task */

$this->breadcrumbs=array(
	'Tasks'=>array('index'),
	'Manage',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => '创建任务', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#task-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->widget('bootstrap.widgets.BsGridView', array(
	'id'=>'task-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'time',
		'stage',
        array(
            'name' => 'status',
            'value' => function ($model) {
                return Rank::dropDown('is_task_status', $model->status);
            },
            'filter' => Rank::dropDown('is_task_status'),
        ),
		array(
			'class'=>'bootstrap.widgets.BsButtonColumn',
            'template'=>'{delete}'
		),
	),
)); ?>
