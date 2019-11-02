<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs=array(
	'Brands'=>array('index'),
	'Create',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '返回品牌管理页', 'url' => array('admin')),
);
?>

<h1>Create Brand</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>