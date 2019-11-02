<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

<!--    --><?php //echo $form->textFieldControlGroup($model, 'Id'); ?>

    <?php echo $form->textFieldControlGroup($model, 'email', array('maxlength' => 30)); ?>

<!--    --><?php //echo $form->textFieldControlGroup($model, 'pwd', array('maxlength' => 100)); ?>

<!--    --><?php //echo $form->textFieldControlGroup($model, 'Frozen'); ?>

<!--    --><?php //echo $form->textFieldControlGroup($model, 'Lately_pwd'); ?>

    <div class="form-actions">
        <?php echo BSHtml::submitButton('Search', array('color' => BSHtml::BUTTON_COLOR_PRIMARY,)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->