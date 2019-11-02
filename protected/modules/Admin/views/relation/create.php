<?php
    /* @var $this RelationController */
    /* @var $model Relation */
?>

<?php
$this->breadcrumbs=array(
	'Relations'=>array('index'),
	'Create',
);

    $this->menu=array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn','label'=>'返回管理页', 'url'=>array('admin')),
    );
    ?>
<?php //echo BSHtml::pageHeader('Create','Relation') ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>