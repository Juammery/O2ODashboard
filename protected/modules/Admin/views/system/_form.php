<?php
/* @var $this SystemController */
/* @var $model System */
/* @var $form BSActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'id' => 'system-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'layout' => BSHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model, 'name', array('maxlength' => 50)); ?>

    <?php echo $form->textFieldControlGroup($model, 'parent'); ?>

    <?php echo $form->textFieldControlGroup($model, 'depth'); ?>

    <?php echo $form->textFieldControlGroup($model, 'sequence'); ?>

    <?php echo BSHtml::formActions(array(
        BSHtml::submitButton('Submit', array('color' => BSHtml::BUTTON_COLOR_PRIMARY)),
    )); ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->