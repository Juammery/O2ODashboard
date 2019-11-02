<?php
/* @var $this InfoController */
/* @var $model Info */
?>

<?php
$this->breadcrumbs=array(
	'Infos'=>array('index'),
	$model->id,
);

$this->menu=array(
array('icon' => 'glyphicon glyphicon-home','label'=>'Manage Info', 'url'=>array('admin')),
array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create Info', 'url'=>array('create')),
array('icon' => 'glyphicon glyphicon-edit','label'=>'Update Info', 'url'=>array('update', 'id'=>$model->id)),
array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete Info', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php echo BSHtml::pageHeader('View','Info '.$model->id) ?>

<?php $this->widget('zii.widgets.CDetailView',array(
'htmlOptions' => array(
'class' => 'table table-striped table-condensed table-hover',
),
'data'=>$model,
'attributes'=>array(
		'id',
		'time',
		'stage',
		'relation_id',
		'system_id',
		'platform_id',
		'sku_id',
		'distribution',
		'last_distribution',
		'sales_numbers',
		'last_sales_numbers',
		'sales_quota',
		'last_sales_quota',
		'saleroom',
		'last_saleroom',
		'sales_share',
		'last_sales_share',
		'enrollment',
		'last_enrollment',
		'store_money',
		'last_store_money',
		'store_number',
		'last_store_number',
		'sku_number',
		'last_sku_number',
		'distribution_store',
		'last_distribution_store',
		'average_selling_price',
		'last_average_selling_price',
		'average_purchase_price',
		'last_average_purchase_price',
		'price_promotion_ratio',
		'last_price_promotion_ratio',
		'average_discount_factor',
		'last_average_discount_factor',
		'average_number_per_unit',
		'last_average_number_per_unit',
		'average_amount_per_order',
		'last_average_amount_per_order',
		'online_stores',
		'last_online_stores',
),
)); ?>