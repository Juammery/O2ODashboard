<?php
/* @var $this RankController */
/* @var $model Rank */


$this->breadcrumbs = array(
    'Ranks' => array('index'),
    'Manage',
);

$this->menu = array(
//    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => '导入数据', 'url' => 'javascript:$("#importfile").click()'),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => '麒麟计算数据', 'url' => array('rank/kylinData')),
);

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', [
    'id' => 'importform',
    'htmlOptions' => ['enctype' => 'multipart/form-data'],
    'action' => $this->createUrl('import/rank')
]);
echo BSHtml::fileField('importfile', '', array("class" => "hide",'accept'=>'.xls,.xlsx', "onchange" => "javascript:$('#importform').submit();"));
$this->endWidget();

Yii::app()->clientScript->registerScript('search',
    "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$('#rank-grid').yiiGridView('update', {
data: $(this).serialize()
});
return false;
});"
);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!-- search-form -->

        <?php $this->widget('bootstrap.widgets.BsGridView', array(
            'id' => 'rank-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
//                'id',
                array(
                    'name'=>'time',
                    'value'=>'isset($data->time)?$data->time:""',
                    'filter'=>Rank::detectiontime(),
                ),
                array(
                    'name' => 'stage',
                    'value' => function ($model) {
                        return Rank::dropDown('is_stage', $model->stage);
                    },
                    'filter' => Rank::dropDown('is_stage'),
                ),
                'relation_id',
                'system_id',
                'platform_id',
                'sku_id',
                array(
                    'name' => 'classify',
                    'value' => function ($model) {
                        return Rank::dropDown('is_classify', $model->classify);
                    },
                    'filter' => Rank::dropDown('is_classify'),
                ),
                'ranking',
                'sku_name',
                'bottle',
                'sales_amount',
                'last_sales_amount',
                array(
                    'name' => 'status',
                    'value' => function ($model) {
                        return Rank::dropDown('is_status', $model->status);
                    },
                    'filter' => Rank::dropDown('is_status'),
                ),
                'remark',
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