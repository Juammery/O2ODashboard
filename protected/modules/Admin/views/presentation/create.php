<?php
/* @var $this PresentationController */
/* @var $model Presentation */
?>

<?php
$this->breadcrumbs = array(
    'Presentation Cvs' => array('index'),
    'Create',
);

$this->menu = array(
//    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => 'Manage Presentation', 'url' => array('admin')),
);
?>
<?php //echo BSHtml::pageHeader('Create', 'Presentation') ?>

<?php
    echo BSHtml::alert('danger', '<p>命名规则：期数.xlsx</p><p>压缩包格式: zip格式</p>');
    $form1 = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'id' => 'zip_import',
        'method' => 'POST',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    echo BSHtml::textFieldControlGroup('sj', '', array('placeholder' => '年-月', 'style' => 'width:200px'));
    echo BSHtml::textFieldControlGroup('stage', '', array('placeholder' => '期数', 'style' => 'width:200px'));
    echo BSHtml::fileFieldControlGroup('zipIm');
    echo BSHtml::submitButton('上传zip并解压', array('class' => 'btn '));
    $this->endWidget();
?>
<?php
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseurl . '/css/datepicker3.css');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/bootstrap-datepicker.js");
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/bootstrap-datepicker.zh-CN.js");
//?>
<!--<script>-->
<!--    $(function () {-->
<!--        $('#sj').datepicker({-->
<!--            format: "yyyy-mm",-->
<!--            weekStart: 1,-->
<!--            startView: 'months',-->
<!--            maxViewMode: 'years',-->
<!--            minViewMode: 'months',-->
<!--            language: "zh-CN",-->
<!--            autoclose: true,-->
<!--            todayHighlight: false,-->
<!--        });-->
<!--    });-->
<!--</script>-->
