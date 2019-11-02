<?php
/* @var $this TotalClassifyController */
/* @var $model TotalClassify */

$this->breadcrumbs=array(
	'Total Classifies'=>array('index'),
	'Create',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '返回容量/瓶量管理页', 'url' => array('totalClassify/admin')),
);
?>

<h1>创建容量/瓶量</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>