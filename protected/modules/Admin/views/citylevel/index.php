<?php
/* @var $this CitylevelController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Citylevels',
);

$this->menu=array(
array('label'=>'Create Citylevel','url'=>array('create')),
array('label'=>'Manage Citylevel','url'=>array('admin')),
);
?>
<?php echo BSHtml::pageHeader('Citylevels') ?>
<?php $this->widget('bootstrap.widgets.BsListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>