<?php
/* @var $this RankController */
/* @var $model Rank */
?>

<?php
$this->breadcrumbs = array(
    'Ranks' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '返回主页', 'url' => array('admin')),
//    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => 'Create Rank', 'url' => array('create')),
//    array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete Rank', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>
<?php //echo BSHtml::pageHeader('Update', 'Rank ' . $model->id) ?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>