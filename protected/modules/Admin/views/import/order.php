<?php

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id' => 'order_import',
    'method' => 'POST',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
echo BSHtml::textFieldControlGroup('time', '', array('placeholder' => '年-月', 'style' => 'width:200px'));
//echo  BSHtml::dateFieldControlGroup('time');
echo BSHtml::fileFieldControlGroup('order');
echo BSHtml::submitButton('上传', array('class' => 'btn '));
$this->endWidget();
?>