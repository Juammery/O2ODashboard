<?php
/* @var $this PresentationController */
/* @var $model Presentation */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    <?php echo $form->textFieldControlGroup($model, 'Id'); ?>

    <?php echo $form->textFieldControlGroup($model, 'time', array('maxlength' => 255)); ?>

    <?php echo $form->textFieldControlGroup($model, 'downloadLinks', array('maxlength' => 255)); ?>

    <div class="form-actions">
        <?php echo BSHtml::submitButton('Search', array('color' => BSHtml::BUTTON_COLOR_PRIMARY,)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->