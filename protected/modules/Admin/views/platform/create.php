<?php
    /* @var $this PlatformController */
    /* @var $model Platform */
?>

<?php
$this->breadcrumbs=array(
	'Platforms'=>array('index'),
	'Create',
);

    $this->menu=array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn','label'=>'返回管理页', 'url'=>array('admin')),
    );
    ?>
<?php echo BSHtml::pageHeader('Create','Platform') ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>