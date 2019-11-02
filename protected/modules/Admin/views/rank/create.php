<?php
    /* @var $this RankController */
    /* @var $model Rank */
?>

<?php
$this->breadcrumbs=array(
	'Ranks'=>array('index'),
	'Create',
);

    $this->menu=array(
    array('icon' => 'glyphicon glyphicon-home','label'=>'Manage Rank', 'url'=>array('admin')),
    );
    ?>
<?php echo BSHtml::pageHeader('Create','Rank') ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>