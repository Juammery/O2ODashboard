<?php
    /* @var $this InfoController */
    /* @var $model Info */
?>

<?php
$this->breadcrumbs=array(
	'Infos'=>array('index'),
	'Create',
);

    $this->menu=array(
    array('icon' => 'glyphicon glyphicon-home','label'=>'Manage Info', 'url'=>array('admin')),
    );
    ?>
<?php echo BSHtml::pageHeader('Create','Info') ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>