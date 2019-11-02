<?php
    /* @var $this InfoController */
    /* @var $model Info */
?>

<?php
$this->breadcrumbs=array(
	'Infos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

    $this->menu=array(
    array('icon' => 'glyphicon glyphicon-home','label'=>'Manage Info', 'url'=>array('admin')),
    array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create Info', 'url'=>array('create')),
    array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete Info', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    );
    ?>
<?php echo BSHtml::pageHeader('Update','Info '.$model->id) ?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>