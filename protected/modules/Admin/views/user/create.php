<?php
/* @var $this UserController */
/* @var $model User */
?>

<?php
$this->breadcrumbs = array(
    'Users' => array('index'),
    'Create',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '管理用户', 'url' => array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>