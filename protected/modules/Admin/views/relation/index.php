<?php
/* @var $this RelationController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Relations',
);

$this->menu=array(
array('label'=>'Create Relation','url'=>array('create')),
array('label'=>'Manage Relation','url'=>array('admin')),
);
?>
<?php echo BSHtml::pageHeader('Relations') ?>
<?php $this->widget('bootstrap.widgets.BsListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>