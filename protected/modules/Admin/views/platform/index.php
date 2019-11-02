<?php
/* @var $this PlatformController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Platforms',
);

$this->menu=array(
array('label'=>'Create Platform','url'=>array('create')),
array('label'=>'Manage Platform','url'=>array('admin')),
);
?>
<?php echo BSHtml::pageHeader('Platforms') ?>
<?php $this->widget('bootstrap.widgets.BsListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>