<?php
/* @var $this CitylevelController */
/* @var $model Citylevel */
?>

<?php
$this->breadcrumbs = array(
    'Citylevels' => array('index'),
    'Create',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '返回管理页', 'url' => array('admin')),
);
?>
<?php echo BSHtml::pageHeader('Create', 'Citylevel') ?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>