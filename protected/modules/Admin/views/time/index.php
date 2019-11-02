<?php
/* @var $this timeController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'times',
);

$this->menu=array(
array('label'=>'Create time','url'=>array('create')),
array('label'=>'Manage time','url'=>array('admin')),
);
?>
<?php echo BSHtml::pageHeader('times') ?>
<?php $this->widget('bootstrap.widgets.BsListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>