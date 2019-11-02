<?php
/* @var $this SystemController */
/* @var $model System */

$this->breadcrumbs = array(
    'Systems' => array('index'),
    'Manage',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => '创建', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search',
    "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$('#system-grid').yiiGridView('update', {
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
            'id' => 'system-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'name',
                'parent',
                'depth',
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




