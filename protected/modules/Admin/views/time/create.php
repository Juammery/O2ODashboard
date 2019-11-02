<?php
    /* @var $this timeController */
    /* @var $model time */
?>

<?php
$this->breadcrumbs=array(
	'times'=>array('index'),
	'Create',
);

    $this->menu=array(
    array('icon' => 'glyphicon glyphicon-home','label'=>'Manage time', 'url'=>array('admin')),
    );
    ?>
<?php echo BSHtml::pageHeader('Create','time') ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>