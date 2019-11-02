<?php
/* @var $this CitylevelController */
/* @var $model Citylevel */
?>

<?php
$this->breadcrumbs=array(
	'Citylevels'=>array('index'),
	$model->name,
);

$this->menu=array(
array('icon' => 'glyphicon glyphicon-home','label'=>'Manage Citylevel', 'url'=>array('admin')),
array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create Citylevel', 'url'=>array('create')),
array('icon' => 'glyphicon glyphicon-edit','label'=>'Update Citylevel', 'url'=>array('update', 'id'=>$model->id)),
array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete Citylevel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php echo BSHtml::pageHeader('View','Citylevel '.$model->id) ?>

<?php $this->widget('zii.widgets.CDetailView',array(
'htmlOptions' => array(
'class' => 'table table-striped table-condensed table-hover',
),
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
),
)); ?>