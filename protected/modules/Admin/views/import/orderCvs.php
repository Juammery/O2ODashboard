<?php

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id' => 'order_cvs_import',
    'method' => 'POST',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
echo BSHtml::alert('danger', '<p>导入数据时，0代表YTD</p>');
echo BSHtml::textFieldControlGroup('time', '', array('placeholder' => '年-月', 'style' => 'width:200px'));
echo BSHtml::textFieldControlGroup('stage', '', array('placeholder' => '期数', 'style' => 'width:200px'));
//echo  BSHtml::dateFieldControlGroup('time');
echo BSHtml::fileFieldControlGroup('order_cvs');
echo BSHtml::submitButton('上传', array('class' => 'btn '));
$this->endWidget();
?>