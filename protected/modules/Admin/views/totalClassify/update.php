<?php
/* @var $this TotalClassifyController */
/* @var $model TotalClassify */

$this->breadcrumbs=array(
	'Total Classifies'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '返回容量/瓶量主页', 'url' => array('totalClassify/admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>