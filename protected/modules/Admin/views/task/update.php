<?php
/* @var $this TaskController */
/* @var $model Task */

$this->breadcrumbs = array(
    'Tasks' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);
$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '返回管理页', 'url' => array('admin')),
);
?>

    <!--<h1>Update Task --><?php //echo $model->id; ?><!--</h1>-->

<?php $this->renderPartial('_form', array('model' => $model)); ?>