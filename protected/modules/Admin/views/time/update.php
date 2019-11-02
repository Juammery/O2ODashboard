<?php
    /* @var $this timeController */
    /* @var $model time */
?>

<?php
$this->breadcrumbs=array(
	'times'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

    $this->menu=array(
    array('icon' => 'glyphicon glyphicon-home','label'=>'Manage time', 'url'=>array('admin')),
    array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create time', 'url'=>array('create')),
    //array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete time', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
    );
    ?>
<?php echo BSHtml::pageHeader('Update','time '.$model->Id) ?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>