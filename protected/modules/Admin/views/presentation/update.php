<?php
/* @var $this PresentationController */
/* @var $model Presentation */
?>

<?php
$this->breadcrumbs = array(
    'Presentation Cvs' => array('index'),
    $model->Id => array('view', 'id' => $model->Id),
    'Update',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => 'Manage Presentation', 'url' => array('admin')),
//    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => 'Create Presentation', 'url' => array('create')),
);
?>
<?php echo BSHtml::pageHeader('Update', 'Presentation ' . $model->Id) ?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>