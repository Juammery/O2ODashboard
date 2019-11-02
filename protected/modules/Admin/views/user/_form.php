<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form BSActiveForm */
?>
<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'id' => 'user-form',
        'enableClientValidation' => true,//开启前台客户端验证
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        //'enableAjaxValidation'=>false,
        'clientOptions' => array(//客户端验证
            'validateOnSubmit' => true, //提交的时候进行验证
        ),
        'layout' => BSHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>
    <!--    <p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model, 'email', array('maxlength' => 30)); ?>
    <?php echo $form->error($model, 'emaill'); ?>

    <?php
    $model->pwd = "";
    echo $form->textFieldControlGroup($model, 'pwd', array('maxlength' => 100));
    ?>
    <?php echo $form->error($model, 'pwd'); ?>

<!--    --><?php //echo $form->dropDownListControlGroup($model, 'group', CHtml::listData(Relation::model()->findAll('depth=1'), 'id', 'name'),
//        array(
//            'empty' => '请选择集团',
//            'ajax' => array(
//                'type' => 'post',
//                'url' => Yii::app()->createUrl('Admin/info/bottler'),
//                'update' => '#bottler_id',
//                'data' => array('aid' => 'js:this.value'),
//            ),
//        )
//    ) ?>
<!--    --><?php
//    echo $form->dropDownListControlGroup($model, 'bottler', CHtml::listData(Relation::model()->findAll('depth=2'), 'id', 'name'),
//        array(
//            'empty' => '请选择装瓶厂',
//            'id' => 'bottler_id',
//        )
//    );
//    ?>
<!--    --><?php //echo $form->dropDownListControlGroup($model, 'jurisdiction', CHtml::listData(AuthItem::model()->findAll("type=2"), 'name', 'name')); ?>
<!--    --><?php //echo $form->dropDownListControlGroup($model, 'is_download', array('0' => '否', '1' => '是')) ?>
    <?php echo BSHtml::formActions(array(
        BSHtml::submitButton('Submit', array('color' => BSHtml::BUTTON_COLOR_PRIMARY)),
    )); ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->