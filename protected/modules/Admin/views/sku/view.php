<?php
/* @var $this SkuController */
/* @var $model Sku */
?>

<?php
$this->breadcrumbs=array(
	'Skus'=>array('index'),
	$model->name,
);

$this->menu=array(
array('icon' => 'glyphicon glyphicon-home','label'=>'Manage Sku', 'url'=>array('admin')),
array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create Sku', 'url'=>array('create')),
array('icon' => 'glyphicon glyphicon-edit','label'=>'Update Sku', 'url'=>array('update', 'id'=>$model->id)),
array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete Sku', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php echo BSHtml::pageHeader('View','Sku '.$model->id) ?>

<?php $this->widget('zii.widgets.CDetailView',array(
'htmlOptions' => array(
'class' => 'table table-striped table-condensed table-hover',
),
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'parent',
		'depth',
		'sequence',
),
)); ?>