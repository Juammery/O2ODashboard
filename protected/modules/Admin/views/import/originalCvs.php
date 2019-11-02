<?php

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id' => 'original_cvs_import',
    'method' => 'POST',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
//echo BSHtml::alert('danger', '<p>导入数据时，0代表YTD</p>');
echo BSHtml::textFieldControlGroup('time', '', array('placeholder' => '年-月', 'style' => 'width:200px'));
echo BSHtml::textFieldControlGroup('stage', '', array('placeholder' => '期数', 'style' => 'width:200px'));
//echo  BSHtml::dateFieldControlGroup('time');
echo BSHtml::fileFieldControlGroup('original_cvs');
echo BSHtml::submitButton('上传', array('class' => 'btn '));
$this->endWidget();
?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseurl . '/css/datepicker3.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/bootstrap-datepicker.js");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/bootstrap-datepicker.zh-CN.js");
?>
<script>
    $(function () {
        $('#time').datepicker({
            format: "yyyy-mm",
            weekStart: 1,
            startView: 'months',
            maxViewMode: 'years',
            minViewMode: 'months',
            language: "zh-CN",
            autoclose: true,
            todayHighlight: false,
        });
    });
</script>
