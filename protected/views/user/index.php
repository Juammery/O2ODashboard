<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Users',
);

$this->menu=array(
array('label'=>'Create User','url'=>array('create')),
array('label'=>'Manage User','url'=>array('admin')),
);
?>
<?php echo BSHtml::pageHeader('Users') ?>
<?php //$this->widget('bootstrap.widgets.BsListView',array(
//'dataProvider'=>$dataProvider,
//'itemView'=>'_view',
//)); ?>

<?php $this->widget('bootstrap.widgets.BsGridView',array(
	'id'=>'auth-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'username',
		'password',
		'email',
		array(
			'class'=>'bootstrap.widgets.BsButtonColumn',
		),
	),
)); ?>
