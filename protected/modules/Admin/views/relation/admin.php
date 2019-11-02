<?php
/* @var $this RelationController */
/* @var $model Relation */


$this->breadcrumbs = array(
    'Relations' => array('index'),
    'Manage',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => '创建', 'url' => array('create')),
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '城市等级管理', 'url' => array('citylevel/admin')),
);

Yii::app()->clientScript->registerScript('search',
    "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$('#relation-grid').yiiGridView('update', {
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
            'id' => 'relation-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'name',
                'parent',
                array(
                    'name' => 'depth',
                    'value' => function ($model) {
                        return Rank::dropDown('is_depth', $model->depth);
                    },
                    'filter' => Rank::dropDown('is_depth'),
                ),
                'sequence',
                array(
                    'name' => 'cityLevel',
                    'value' => function ($model) {
                        return Rank::dropDown('is_cityLevel', $model->cityLevel);
                    },
                    'filter' => Rank::dropDown('is_cityLevel'),
                ),
                array(
                    'class' => 'bootstrap.widgets.BsButtonColumn',
                    'template' => '{update} {delete}',
                    'updateButtonOptions' => array('title' => '修改'),
                    'deleteButtonOptions' => array('title' => '删除'),
                ),
            ),
        )); ?>
    </div>
</div>




