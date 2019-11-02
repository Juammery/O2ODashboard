<?php
/* @var $this UserController */
/* @var $model User */


$this->breadcrumbs = array(
    'Users' => array('index'),
    'Manage',
);

$this->menu = array(
//array('icon' => 'glyphicon glyphicon-home','class'=>'btn  admin-btn','label'=>'Manage User', 'url'=>array('admin')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'class' => 'btn  admin-btn', 'label' => '新建用户', 'url' => array('create')),
    //array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'add Jurisdiction', 'url'=>array('addJurisdiction')),
);

Yii::app()->clientScript->registerScript('search',
    "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$('#user-grid').yiiGridView('update', {
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
            'id' => 'user-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'email',
                array(
                    'name' => 'Frozen',
                    'value' => function ($data) {
                        if ($data->Frozen == 0) {
                            return '冻结';
                        } else {
                            return '不冻结';
                        }
                    }
                ),
                'Lately_pwd',
                array(
                    'name' => 'jurisdiction',
                    'value' => function ($data) {
                        $auth = Assignments::model()->find('userid=' . $data->Id . ' and itemname!="download"');
                        if ($auth) {
                            return $auth->itemname;
                        } else {
                            return "";
                        }
                    },
                ),
//                array(
//                    'name' => 'downloadRange',
//                    'value' => function ($data) {
//                        $downloadRange = $data->downloadRange;
//                        pd($downloadRange);
//                        if(isset($downloadRange)){
//                            if (!$downloadRange) {
//                                return '全部';
//                            } else {
//                                $model = Relation::model()->findByPk($downloadRange)->name;
//                                if($model){
//                                    return $model;
//                                }else{
//                                    return "";
//                                }
//                            }
//                        }
//                    },
//                ),
                array(
                    'name' => 'is_download',
                    'value' => function ($data) {
                        if ($data->is_download) {
                            return '是';
                        } else {
                            return '否';
                        }
                    }
                ),
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




