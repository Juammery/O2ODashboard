<?php
    /* @var $this UserController */
    /* @var $model User */
?>

<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

    $this->menu=array(
    array('icon' => 'glyphicon glyphicon-home','class'=>'btn  admin-btn','label'=>'管理用户', 'url'=>array('admin')),
//    array('icon' => 'glyphicon glyphicon-plus-sign','class'=>'btn  admin-btn','label'=>'Create User', 'url'=>array('create')),
   // array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
    );
    ?>
<?php echo BSHtml::pageHeader('Update','User '.$model->Id) ?>
<?php $this->renderPartial('_updateForm', array('model'=>$model)); ?>