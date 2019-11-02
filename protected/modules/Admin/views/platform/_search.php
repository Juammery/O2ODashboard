<?php
/* @var $this PlatformController */
/* @var $model Platform */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'id'); ?>

                    <?php echo $form->textFieldControlGroup($model,'name',array('maxlength'=>20)); ?>

                    <?php echo $form->textFieldControlGroup($model,'sequence'); ?>

        <div class="form-actions">
        <?php echo BSHtml::submitButton('Search',  array('color' => BSHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->