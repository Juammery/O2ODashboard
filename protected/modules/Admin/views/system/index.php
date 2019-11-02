<?php
/* @var $this SystemController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Systems',
);

$this->menu=array(
array('label'=>'Create System','url'=>array('create')),
array('label'=>'Manage System','url'=>array('admin')),
);
?>
<?php echo BSHtml::pageHeader('Systems') ?>
<?php $this->widget('bootstrap.widgets.BsListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>