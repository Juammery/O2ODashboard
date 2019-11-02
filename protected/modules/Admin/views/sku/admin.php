<?php
/* @var $this SkuController */
/* @var $model Sku */


$this->breadcrumbs = array(
    'Skus' => array('index'),
    'Manage',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => '创建品类', 'url' => array('create')),
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '制造商管理', 'url' => array('menu/admin')),
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '品牌管理', 'url' => array('brand/admin')),
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '容量&瓶量管理', 'url' => array('totalClassify/admin')),
//    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => '导入数据', 'url' => 'javascript:$("#importfile").click()'),
//    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => '导入info数据', 'url' => 'javascript:$("#importfileInfo").click()'),
);

//$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', [
//    'id' => 'importform',
//    'htmlOptions' => ['enctype' => 'multipart/form-data'],
//    'action' => $this->createUrl('import/sku')
//]);
//echo BSHtml::fileField('importfile', '', array("class" => "hide",'accept'=>'.xls,.xlsx', "onchange" => "javascript:$('#importform').submit();"));
//$this->endWidget();

//$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', [
//    'id' => 'importInfo',
//    'htmlOptions' => ['enctype' => 'multipart/form-data'],
//    'action' => $this->createUrl('import/info')
//]);
//echo BSHtml::fileField('importfileInfo', '', array("class" => "hide",'accept'=>'.xls,.xlsx', "onchange" => "javascript:$('#importInfo').submit();"));
//$this->endWidget();

Yii::app()->clientScript->registerScript('search',
    "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$('#sku-grid').yiiGridView('update', {
data: $(this).serialize()
});
return false;
});"
);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <!-- search-form -->

        <?php $this->widget('bootstrap.widgets.BsGridView', array(
            'id' => 'sku-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'name',
                'color',
                'sequence',
                array(
                    'class' => 'bootstrap.widgets.BsButtonColumn',
                    'template'=>'{update} {delete}',
                    'updateButtonOptions'=>array('title'=>'修改'),
                    'deleteButtonOptions'=>array('title'=>'删除'),
                ),
            ),
        )); ?>
    </div>
</div>




