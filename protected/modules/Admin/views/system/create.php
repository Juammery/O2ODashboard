<?php
    /* @var $this SystemController */
    /* @var $model System */
?>

<?php
$this->breadcrumbs=array(
	'Systems'=>array('index'),
	'Create',
);

    $this->menu=array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn','label'=>'返回管理页', 'url'=>array('admin')),
    );
    ?>
<?php echo BSHtml::pageHeader('Create','System') ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>