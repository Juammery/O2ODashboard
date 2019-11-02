<?php
/**
 * Created by PhpStorm.
 * User: Vikki1019
 * Date: 2019/8/1
 * Time: 15:19
 */

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id' => 'info',
    'method' => 'POST',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
echo BSHtml::alert('danger', '<p>计算数据时，0代表月报&季报，1代表YTD</p>');
echo BSHtml::textFieldControlGroup('time', '', array('placeholder' => '年-月', 'style' => 'width:200px'));
echo BSHtml::textFieldControlGroup('stage', '', array('placeholder' => '期数', 'style' => 'width:200px'));
echo BSHtml::submitButton('计算', array('class' => 'btn '));
$this->endWidget();
