<?php

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id' => 'market_import',
    'method' => 'POST',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
echo BSHtml::textFieldControlGroup('time', '', array('placeholder' => '年-月', 'style' => 'width:200px'));
echo BSHtml::textFieldControlGroup('stage', '', array('placeholder' => '期数', 'style' => 'width:200px'));
echo BSHtml::fileFieldControlGroup('market_cvs');
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
