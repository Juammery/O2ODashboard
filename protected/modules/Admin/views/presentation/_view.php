<?php
/* @var $this PresentationController */
/* @var $data Presentation */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id' => $data->Id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
    <?php echo CHtml::encode($data->time); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('downloadLinks')); ?>:</b>
    <?php echo CHtml::encode($data->downloadLinks); ?>
    <br/>


</div>