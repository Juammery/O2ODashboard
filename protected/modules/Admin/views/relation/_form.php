<?php
/* @var $this RelationController */
/* @var $model Relation */
/* @var $form BSActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'id' => 'relation-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'layout' => BSHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->dropDownListControlGroup($model, 'depth', array('1' => '装瓶集团', '2' => '装瓶厂', '3' => '城市'), array()); ?>

    <?php echo $form->dropDownListControlGroup($model, 'parent', CHtml::listData(Relation::model()->findAll('depth=1'), 'id', 'name'),
        array('empty' => '必须选择一个', 'class' => 'drop_factory'));?>
    <?php echo $form->dropDownListControlGroup($model, 'parent2', CHtml::listData(Relation::model()->findAll('depth=2'), 'id', 'name'),
        array('empty' => '必须选择一个!', 'class' => 'drop_city')); ?>

    <?php echo $form->textFieldControlGroup($model, 'name', array('maxlength' => 20)); ?>

    <?php echo $form->textFieldControlGroup($model, 'sequence'); ?>

    <?php echo $form->dropDownListControlGroup($model, 'cityLevel', array('2' => 'Metro', '3' => 'U1', '4' => 'U2'), array('class' => 'cut_cityLevel')); ?>

    <?php echo BSHtml::formActions(array(
        BSHtml::submitButton('Submit', array('color' => BSHtml::BUTTON_COLOR_PRIMARY)),
    )); ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    $(function () {
        var r_value = $('#Relation_depth').val();
        Myfunction(r_value);

        $('#Relation_depth').change(function () {
            var r_value1 = $('#Relation_depth').val();
            Myfunction(r_value1);
        });

        function Myfunction(r_value) {
            if (r_value == 1) {//装瓶集团
                $('#Relation_cityLevel').parent().parent().css('display', 'none');
                $('.drop_factory').parent().parent().css('display', 'none');
                $('.drop_city').parent().parent().css('display', 'none');
            } else if (r_value == 2) {//装瓶厂
                $('#Relation_cityLevel').parent().parent().css('display', 'none');
                $('.drop_factory').parent().parent().css('display', '');
                $('.drop_city').parent().parent().css('display', 'none');
            } else {//城市
                $('.drop_factory').parent().parent().css('display', 'none');
                $('.drop_city').parent().parent().css('display', '');
                $('#Relation_cityLevel').parent().parent().css('display', '');
            }
        }
    });
</script>