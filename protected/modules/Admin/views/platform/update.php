<?php
/* @var $this PlatformController */
/* @var $model Platform */
?>

<?php
$this->breadcrumbs = array(
    'Platforms' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '返回管理页', 'url' => array('admin')),
);
?>
<?php echo BSHtml::pageHeader('Update', 'Platform ' . $model->id) ?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>