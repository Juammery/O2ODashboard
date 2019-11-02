<?php
/* @var $this PresentationController */
/* @var $model Presentation */


$this->breadcrumbs = array(
    'Presentation Cvs' => array('index'),
    'Manage',
);

$this->menu = array(
//    array('icon' => 'glyphicon glyphicon-home', 'class' => 'btn  admin-btn', 'label' => 'Manage Presentation', 'url' => array('admin')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn admin-btn', 'label' => '新建报告', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search',
    "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$('#presentation-cvs-grid').yiiGridView('update', {
data: $(this).serialize()
});
return false;
});"
);
?>
<?php //echo BSHtml::pageHeader('Manage', 'Presentation Cvs') ?>
<div class="panel panel-default">

    <div class="panel-body">

        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!-- search-form -->

        <?php $this->widget('bootstrap.widgets.BsGridView', array(
            'id' => 'presentation-cvs-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
//                'Id',
                'time',
                'stage',
                'downloadLinks',
                array(
                    'class' => 'bootstrap.widgets.BsButtonColumn',
                    'template'=>'{delete}',
//                    'updateButtonOptions'=>array('title'=>'修改'),
                    'deleteButtonOptions'=>array('title'=>'删除'),
                ),
            ),
        )); ?>
    </div>
</div>




