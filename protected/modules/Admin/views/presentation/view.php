<?php
/* @var $this PresentationController */
/* @var $model Presentation */
?>

<?php
$this->breadcrumbs = array(
    'Presentation Cvs' => array('index'),
    $model->Id,
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => 'Manage Presentation', 'url' => array('admin')),
//    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => 'Create Presentation', 'url' => array('create')),
//    array('icon' => 'glyphicon glyphicon-edit', 'class' => 'btn  admin-btn', 'label' => 'Update Presentation', 'url' => array('update', 'id' => $model->Id)),
);
?>

<?php echo BSHtml::pageHeader('View', 'Presentation ' . $model->Id) ?>

<?php $this->widget('zii.widgets.CDetailView', array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data' => $model,
    'attributes' => array(
        'Id',
        'time',
        'downloadLinks',
    ),
)); ?>