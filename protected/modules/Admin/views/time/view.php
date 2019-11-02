<?php
/* @var $this timeController */
/* @var $model time */
?>

<?php
$this->breadcrumbs=array(
	'times'=>array('index'),
	$model->Id,
);

$this->menu=array(
array('icon' => 'glyphicon glyphicon-home','label'=>'Manage time', 'url'=>array('admin')),
array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create time', 'url'=>array('create')),
array('icon' => 'glyphicon glyphicon-edit','label'=>'Update time', 'url'=>array('update', 'id'=>$model->Id)),
//array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete time', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php echo BSHtml::pageHeader('View','time '.$model->Id) ?>

<?php $this->widget('zii.widgets.CDetailView',array(
'htmlOptions' => array(
'class' => 'table table-striped table-condensed table-hover',
),
'data'=>$model,
'attributes'=>array(
		'Id',
		'time',
),
)); ?>