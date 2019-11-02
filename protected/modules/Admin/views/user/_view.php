
<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id),array('view','id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pwd')); ?>:</b>
	<?php echo CHtml::encode($data->pwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Frozen')); ?>:</b>
	<?php echo CHtml::encode($data->Frozen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Lately_pwd')); ?>:</b>
	<?php echo CHtml::encode($data->Lately_pwd); ?>
	<br />


</div>