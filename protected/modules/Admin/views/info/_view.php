<?php
/* @var $this InfoController */
/* @var $data Info */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stage')); ?>:</b>
	<?php echo CHtml::encode($data->stage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('relation_id')); ?>:</b>
	<?php echo CHtml::encode($data->relation_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('system_id')); ?>:</b>
	<?php echo CHtml::encode($data->system_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('platform_id')); ?>:</b>
	<?php echo CHtml::encode($data->platform_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sku_id')); ?>:</b>
	<?php echo CHtml::encode($data->sku_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('distribution')); ?>:</b>
	<?php echo CHtml::encode($data->distribution); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_distribution')); ?>:</b>
	<?php echo CHtml::encode($data->last_distribution); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sales_numbers')); ?>:</b>
	<?php echo CHtml::encode($data->sales_numbers); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_sales_numbers')); ?>:</b>
	<?php echo CHtml::encode($data->last_sales_numbers); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sales_quota')); ?>:</b>
	<?php echo CHtml::encode($data->sales_quota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_sales_quota')); ?>:</b>
	<?php echo CHtml::encode($data->last_sales_quota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('saleroom')); ?>:</b>
	<?php echo CHtml::encode($data->saleroom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_saleroom')); ?>:</b>
	<?php echo CHtml::encode($data->last_saleroom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sales_share')); ?>:</b>
	<?php echo CHtml::encode($data->sales_share); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_sales_share')); ?>:</b>
	<?php echo CHtml::encode($data->last_sales_share); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enrollment')); ?>:</b>
	<?php echo CHtml::encode($data->enrollment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_enrollment')); ?>:</b>
	<?php echo CHtml::encode($data->last_enrollment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_money')); ?>:</b>
	<?php echo CHtml::encode($data->store_money); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_store_money')); ?>:</b>
	<?php echo CHtml::encode($data->last_store_money); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_number')); ?>:</b>
	<?php echo CHtml::encode($data->store_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_store_number')); ?>:</b>
	<?php echo CHtml::encode($data->last_store_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sku_number')); ?>:</b>
	<?php echo CHtml::encode($data->sku_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_sku_number')); ?>:</b>
	<?php echo CHtml::encode($data->last_sku_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('distribution_store')); ?>:</b>
	<?php echo CHtml::encode($data->distribution_store); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_distribution_store')); ?>:</b>
	<?php echo CHtml::encode($data->last_distribution_store); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('average_selling_price')); ?>:</b>
	<?php echo CHtml::encode($data->average_selling_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_average_selling_price')); ?>:</b>
	<?php echo CHtml::encode($data->last_average_selling_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('average_purchase_price')); ?>:</b>
	<?php echo CHtml::encode($data->average_purchase_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_average_purchase_price')); ?>:</b>
	<?php echo CHtml::encode($data->last_average_purchase_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_promotion_ratio')); ?>:</b>
	<?php echo CHtml::encode($data->price_promotion_ratio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_price_promotion_ratio')); ?>:</b>
	<?php echo CHtml::encode($data->last_price_promotion_ratio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('average_discount_factor')); ?>:</b>
	<?php echo CHtml::encode($data->average_discount_factor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_average_discount_factor')); ?>:</b>
	<?php echo CHtml::encode($data->last_average_discount_factor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('average_number_per_unit')); ?>:</b>
	<?php echo CHtml::encode($data->average_number_per_unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_average_number_per_unit')); ?>:</b>
	<?php echo CHtml::encode($data->last_average_number_per_unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('average_amount_per_order')); ?>:</b>
	<?php echo CHtml::encode($data->average_amount_per_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_average_amount_per_order')); ?>:</b>
	<?php echo CHtml::encode($data->last_average_amount_per_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('online_stores')); ?>:</b>
	<?php echo CHtml::encode($data->online_stores); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_online_stores')); ?>:</b>
	<?php echo CHtml::encode($data->last_online_stores); ?>
	<br />

	*/ ?>

</div>