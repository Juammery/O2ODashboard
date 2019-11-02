<?php
/* @var $this TotalClassifyController */
/* @var $model TotalClassify */

$this->breadcrumbs=array(
	'Total Classifies'=>array('index'),
	'Manage',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => '创建容量或瓶量', 'url' => array('create')),
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '返回品类主页', 'url' => array('sku/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#total-classify-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->widget('bootstrap.widgets.BsGridView', array(
	'id'=>'total-classify-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'classify',
		'color',
		'sequence',
		array(
			'class'=>'bootstrap.widgets.BsButtonColumn',
            'template'=>'{update}{delete}',
            'updateButtonOptions'=>array('title'=>'修改'),
            'deleteButtonOptions'=>array('title'=>'删除'),
		),
	),
)); ?>
