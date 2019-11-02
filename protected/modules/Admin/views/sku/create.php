<?php
/* @var $this SkuController */
/* @var $model Sku */
?>

<?php
$this->breadcrumbs = array(
    'Skus' => array('index'),
    'Create',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '返回', 'url' => array('admin')),
);
?>
<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'id' => 'sku-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'layout' => BSHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model, 'name'); ?>

    <?php echo $form->textFieldControlGroup($model, 'color'); ?>

    <?php echo $form->textFieldControlGroup($model, 'sequence'); ?>

    <?php echo BSHtml::formActions(array(
        BSHtml::submitButton('Submit', array('color' => BSHtml::BUTTON_COLOR_PRIMARY)),
    )); ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    $(function () {
        var explain = $('#Sku_explain').val();
        if (explain) {
            changeRole(explain);
        }
        $('#sku-form').on('change', '#Sku_explain', function () {
//            $('.location').val('');
            changeRole($(this).val())
        });

        $('.submitButton').click(function () {
            var error = false;
            var msg = '';
            $('.require').each(function (k, v) {
                if (!$(v).val()) {
                    msg = $(v).parent().prev().text();
                    error = true;
                    return false;
                }
            });
            if (error) {
                layer.msg(msg + '不能为空');
                return false;
            }
        });
    });
    function changeRole(explain) {
        $('.location').parent().parent().addClass('hide');
        if (explain == '1') {
            $('.category').parent().parent().removeClass('hide');
            $('.category').addClass('require');
        } else if (explain == '2') {
            $('.category1').parent().parent().removeClass('hide');
            $('.category1').addClass('require');
            $('.manufacturer').parent().parent().removeClass('hide');
            $('.manufacturer').addClass('require');
        } else if (explain == '3') {
            $('.category1').parent().parent().removeClass('hide');
            $('.category1').addClass('require');
            $('.manufacturer1').parent().parent().removeClass('hide');
            $('.manufacturer1').addClass('require');
            $('.brand').parent().parent().removeClass('hide');
            $('.brand').addClass('require');
        } else if (explain == '4') {
            $('.category1').parent().parent().removeClass('hide');
            $('.category1').addClass('require');
            $('.manufacturer1').parent().parent().removeClass('hide');
            $('.manufacturer1').addClass('require');
            $('.brand1').parent().parent().removeClass('hide');
            $('.brand1').addClass('require');
            $('.series').parent().parent().removeClass('hide');
            $('.series').addClass('require');
        }
    }
</script>