<?php
/* @var $this SystemController */
/* @var $model System */
?>

<?php
$this->breadcrumbs=array(
	'Systems'=>array('index'),
	$model->name,
);

$this->menu=array(
array('icon' => 'glyphicon glyphicon-home','label'=>'Manage System', 'url'=>array('admin')),
array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create System', 'url'=>array('create')),
array('icon' => 'glyphicon glyphicon-edit','label'=>'Update System', 'url'=>array('update', 'id'=>$model->Id)),
array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete System', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php echo BSHtml::pageHeader('View','System '.$model->id) ?>

<?php $this->widget('zii.widgets.CDetailView',array(
'htmlOptions' => array(
'class' => 'table table-striped table-condensed table-hover',
),
'data'=>$model,
'attributes'=>array(
		'Id',
		'name',
		'parent',
		'depth',
		'sequence',
),
)); ?>