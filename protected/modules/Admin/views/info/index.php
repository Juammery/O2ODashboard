<?php
/* @var $this InfoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Infos',
);

$this->menu=array(
array('label'=>'Create Info','url'=>array('create')),
array('label'=>'Manage Info','url'=>array('admin')),
);
?>
<?php echo BSHtml::pageHeader('Infos') ?>
<?php $this->widget('bootstrap.widgets.BsListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>