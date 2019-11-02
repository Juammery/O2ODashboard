<?php
/* @var $this RankController */
/* @var $model Rank */
/* @var $form BSActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'id' => 'rank-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'layout' => BSHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model, 'time', array('maxlength' => 30)); ?>

    <?php echo $form->textFieldControlGroup($model, 'stage'); ?>

    <?php echo $form->textFieldControlGroup($model, 'relation_id'); ?>

    <?php echo $form->textFieldControlGroup($model, 'system_id'); ?>

    <?php echo $form->textFieldControlGroup($model, 'platform_id'); ?>

    <?php echo $form->textFieldControlGroup($model, 'sku_id'); ?>

    <?php echo $form->textFieldControlGroup($model, 'classify'); ?>

    <?php echo $form->textFieldControlGroup($model, 'sku_name', array('maxlength' => 100)); ?>


    <?php echo $form->textFieldControlGroup($model, 'bottle', array('maxlength' => 50)); ?>

    <?php echo $form->textFieldControlGroup($model, 'ranking', array('maxlength' => 10)); ?>

    <?php echo BSHtml::formActions(array(
        BSHtml::submitButton('Submit', array('color' => BSHtml::BUTTON_COLOR_PRIMARY)),
    )); ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->