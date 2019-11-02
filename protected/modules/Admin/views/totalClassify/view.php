<?php
/* @var $this TotalClassifyController */
/* @var $model TotalClassify */

$this->breadcrumbs=array(
	'Total Classifies'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List TotalClassify', 'url'=>array('index')),
	array('label'=>'Create TotalClassify', 'url'=>array('create')),
	array('label'=>'Update TotalClassify', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TotalClassify', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TotalClassify', 'url'=>array('admin')),
);
?>

<h1>View TotalClassify #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'classify',
		'color',
		'sequence',
	),
)); ?>
