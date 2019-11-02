<?php
    /* @var $this UserController */
    /* @var $model User */
?>

<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

    $this->menu=array(
    array('icon' => 'glyphicon glyphicon-home','label'=>'Manage User', 'url'=>array('admin')),
    );
    ?>
<?php echo BSHtml::pageHeader('Create','User') ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>