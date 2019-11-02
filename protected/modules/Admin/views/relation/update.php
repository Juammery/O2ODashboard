<?php
/* @var $this RelationController */
/* @var $model Relation */
?>

<?php
$this->breadcrumbs = array(
    'Relations' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '返回管理页', 'url' => array('admin')),
);
?>
<?php //echo BSHtml::pageHeader('Update', 'Relation ' . $model->id) ?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>