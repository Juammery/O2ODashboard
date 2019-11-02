<?php
/* @var $this CitylevelController */
/* @var $model Citylevel */


$this->breadcrumbs = array(
    'Citylevels' => array('index'),
    'Manage',
);

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => '新建', 'url' => array('create')),
    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => '返回区域管理页', 'url' => array('relation/admin')),
);

Yii::app()->clientScript->registerScript('search',
    "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$('#citylevel-grid').yiiGridView('update', {
data: $(this).serialize()
});
return false;
});"
);
?>
<?php //echo BSHtml::pageHeader('Manage', 'Citylevels') ?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BsGridView', array(
            'id' => 'citylevel-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'name',
                array(
                    'class' => 'bootstrap.widgets.BsButtonColumn',
                    'template'=>'{update}{delete}'
                ),
            ),
        )); ?>
    </div>
</div>




