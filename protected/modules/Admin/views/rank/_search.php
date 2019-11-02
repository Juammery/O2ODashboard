<?php
/* @var $this RankController */
/* @var $model Rank */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'id'); ?>

                    <?php echo $form->textFieldControlGroup($model,'time',array('maxlength'=>30)); ?>

                    <?php echo $form->textFieldControlGroup($model,'stage'); ?>

                    <?php echo $form->textFieldControlGroup($model,'relation_id'); ?>

                    <?php echo $form->textFieldControlGroup($model,'system_id'); ?>

                    <?php echo $form->textFieldControlGroup($model,'platform_id'); ?>

                    <?php echo $form->textFieldControlGroup($model,'sku_id'); ?>

                    <?php echo $form->textFieldControlGroup($model,'classify'); ?>

                    <?php echo $form->textFieldControlGroup($model,'sku_name',array('maxlength'=>100)); ?>

                    <?php echo $form->textFieldControlGroup($model,'ranking',array('maxlength'=>10)); ?>

        <div class="form-actions">
        <?php echo BSHtml::submitButton('Search',  array('color' => BSHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->