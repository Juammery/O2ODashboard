<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'id' => 'task-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'layout' => BSHtml::FORM_LAYOUT_HORIZONTAL,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model, 'time', array('maxlength' => 50)); ?>

    <?php echo $form->textFieldControlGroup($model, 'stage'); ?>

    <?php
        if ($model->isNewRecord) {//true为create操作，false为update操作
            echo $form->dropDownListControlGroup($model, 'status', array('0' => '不执行任务', '1' => '执行任务'), array());
        }else{
            echo $form->dropDownListControlGroup($model, 'status', array('0' => '不执行任务', '1' => '执行任务','-1'=>'执行任务中'), array());
        }
    ?>

    <?php echo BSHtml::formActions(array(
        BSHtml::submitButton('Submit', array('color' => BSHtml::BUTTON_COLOR_PRIMARY)),
    )); ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->