<?php
/* @var $this RankController */
/* @var $data Rank */
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
	<b><?php echo CHtml::encode($data->getAttributeLabel('classify')); ?>:</b>
	<?php echo CHtml::encode($data->classify); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sku_name')); ?>:</b>
	<?php echo CHtml::encode($data->sku_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ranking')); ?>:</b>
	<?php echo CHtml::encode($data->ranking); ?>
	<br />

	*/ ?>

</div>