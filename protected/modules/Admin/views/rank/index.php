<?php
/* @var $this RankController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Ranks',
);

$this->menu=array(
array('label'=>'Create Rank','url'=>array('create')),
array('label'=>'Manage Rank','url'=>array('admin')),
);
?>
<?php echo BSHtml::pageHeader('Ranks') ?>
<?php $this->widget('bootstrap.widgets.BsListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>