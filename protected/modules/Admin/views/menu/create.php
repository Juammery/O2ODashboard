<?php
/* @var $this MenuController */
/* @var $model Menu */

$this->breadcrumbs=array(
	'Menus'=>array('index'),
	'Create',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '返回制造商管理页', 'url' => array('admin')),
);
?>

<h1>Create Menu</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>