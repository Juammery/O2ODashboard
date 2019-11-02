<?php
/* @var $this InfoController */
/* @var $model Info */


$this->breadcrumbs = array(
    'Infos' => array('index'),
    'Manage',
);

$this->menu = array(
//    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => 'Create Info', 'url' => array('create')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => '导入数据', 'url' => 'javascript:$("#importfile").click()'),
);

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', [
    'id' => 'importform',
    'htmlOptions' => ['enctype' => 'multipart/form-data'],
    'action' => $this->createUrl('import/info')
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
$('#info-grid').yiiGridView('update', {
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
            'id' => 'info-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'time',
                'stage',
                'relation_id',
                'system_id',
                'platform_id',
                'sku_id',
                'distribution',
                'last_distribution',
                'sales_numbers',
                'last_sales_numbers',
                'sales_quota',
                'last_sales_quota',
                'saleroom',
                'last_saleroom',
                /*
'sales_share',
'last_sales_share',
'enrollment',
'last_enrollment',

'store_money',
'last_store_money',
'store_number',
'last_store_number',
'sku_number',
'last_sku_number',
'distribution_store',
'last_distribution_store',
'average_selling_price',
'last_average_selling_price',
'average_purchase_price',
'last_average_purchase_price',
'price_promotion_ratio',
'last_price_promotion_ratio',
'average_discount_factor',
'last_average_discount_factor',
'average_number_per_unit',
'last_average_number_per_unit',
'average_amount_per_order',
'last_average_amount_per_order',
'online_stores',
'last_online_stores',
*/
                array(
                    'class' => 'bootstrap.widgets.BsButtonColumn',
                ),
            ),
        )); ?>
    </div>
</div>




