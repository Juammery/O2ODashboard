<?php
/* @var $this SkuController */
/* @var $model Sku */
?>

<?php
$this->breadcrumbs = array(
    'Skus' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '品类管理主页', 'url' => array('admin')),
//    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => 'Create Sku', 'url' => array('create')),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>