<?php
/* @var $this RankController */
/* @var $model Rank */
?>

<?php
$this->breadcrumbs=array(
	'Ranks'=>array('index'),
	$model->id,
);

$this->menu=array(
array('icon' => 'glyphicon glyphicon-home','label'=>'Manage Rank', 'url'=>array('admin')),
array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create Rank', 'url'=>array('create')),
array('icon' => 'glyphicon glyphicon-edit','label'=>'Update Rank', 'url'=>array('update', 'id'=>$model->id)),
array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete Rank', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php echo BSHtml::pageHeader('View','Rank '.$model->id) ?>

<?php $this->widget('zii.widgets.CDetailView',array(
'htmlOptions' => array(
'class' => 'table table-striped table-condensed table-hover',
),
'data'=>$model,
'attributes'=>array(
		'id',
		'time',
		'stage',
		'relation_id',
		'system_id',
		'platform_id',
		'sku_id',
		'classify',
		'sku_name',
		'ranking',
),
)); ?>