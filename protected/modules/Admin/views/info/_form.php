<?php
/* @var $this InfoController */
/* @var $model Info */
/* @var $form BSActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'info-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'layout' => BSHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'time',array('maxlength'=>30)); ?>

            <?php echo $form->textFieldControlGroup($model,'stage'); ?>

            <?php echo $form->textFieldControlGroup($model,'relation_id'); ?>

            <?php echo $form->textFieldControlGroup($model,'system_id'); ?>

            <?php echo $form->textFieldControlGroup($model,'platform_id'); ?>

            <?php echo $form->textFieldControlGroup($model,'sku_id'); ?>

            <?php echo $form->textFieldControlGroup($model,'distribution'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_distribution'); ?>

            <?php echo $form->textFieldControlGroup($model,'sales_numbers'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_sales_numbers'); ?>

            <?php echo $form->textFieldControlGroup($model,'sales_quota'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_sales_quota'); ?>

            <?php echo $form->textFieldControlGroup($model,'saleroom'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_saleroom'); ?>

            <?php echo $form->textFieldControlGroup($model,'sales_share'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_sales_share'); ?>

            <?php echo $form->textFieldControlGroup($model,'enrollment'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_enrollment'); ?>

            <?php echo $form->textFieldControlGroup($model,'store_money'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_store_money'); ?>

            <?php echo $form->textFieldControlGroup($model,'store_number'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_store_number'); ?>

            <?php echo $form->textFieldControlGroup($model,'sku_number'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_sku_number'); ?>

            <?php echo $form->textFieldControlGroup($model,'distribution_store'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_distribution_store'); ?>

            <?php echo $form->textFieldControlGroup($model,'average_selling_price'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_average_selling_price'); ?>

            <?php echo $form->textFieldControlGroup($model,'average_purchase_price'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_average_purchase_price'); ?>

            <?php echo $form->textFieldControlGroup($model,'price_promotion_ratio'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_price_promotion_ratio'); ?>

            <?php echo $form->textFieldControlGroup($model,'average_discount_factor'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_average_discount_factor'); ?>

            <?php echo $form->textFieldControlGroup($model,'average_number_per_unit'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_average_number_per_unit'); ?>

            <?php echo $form->textFieldControlGroup($model,'average_amount_per_order'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_average_amount_per_order'); ?>

            <?php echo $form->textFieldControlGroup($model,'online_stores'); ?>

            <?php echo $form->textFieldControlGroup($model,'last_online_stores'); ?>

        <?php echo BSHtml::formActions(array(
    BSHtml::submitButton('Submit', array('color' => BSHtml::BUTTON_COLOR_PRIMARY)),
)); ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->