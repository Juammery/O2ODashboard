<?php
/* @var $this TotalClassifyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Total Classifies',
);

$this->menu=array(
	array('label'=>'Create TotalClassify', 'url'=>array('create')),
	array('label'=>'Manage TotalClassify', 'url'=>array('admin')),
);
?>

<h1>Total Classifies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
