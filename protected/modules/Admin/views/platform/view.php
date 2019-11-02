<?php
/* @var $this PlatformController */
/* @var $model Platform */
?>

<?php
$this->breadcrumbs=array(
	'Platforms'=>array('index'),
	$model->name,
);

$this->menu=array(
array('icon' => 'glyphicon glyphicon-home','label'=>'Manage Platform', 'url'=>array('admin')),
array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create Platform', 'url'=>array('create')),
array('icon' => 'glyphicon glyphicon-edit','label'=>'Update Platform', 'url'=>array('update', 'id'=>$model->id)),
array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete Platform', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php echo BSHtml::pageHeader('View','Platform '.$model->id) ?>

<?php $this->widget('zii.widgets.CDetailView',array(
'htmlOptions' => array(
'class' => 'table table-striped table-condensed table-hover',
),
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'sequence',
),
)); ?>