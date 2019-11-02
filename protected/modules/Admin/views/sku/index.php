<?php
/* @var $this SkuController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Skus',
);

$this->menu=array(
array('label'=>'Create Sku','url'=>array('create')),
array('label'=>'Manage Sku','url'=>array('admin')),
);
?>
<?php echo BSHtml::pageHeader('Skus') ?>
<?php $this->widget('bootstrap.widgets.BsListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>