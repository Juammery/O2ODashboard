<?php
/* @var $this UserController */
/* @var $model User */
?>

<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->Id,
);

$this->menu=array(
array('icon' => 'glyphicon glyphicon-home','class'=>'btn  admin-btn','label'=>'管理用户', 'url'=>array('admin')),
//array('icon' => 'glyphicon glyphicon-plus-sign','class'=>'btn  admin-btn','label'=>'Create User', 'url'=>array('create')),
//array('icon' => 'glyphicon glyphicon-edit','class'=>'btn  admin-btn','label'=>'Update User', 'url'=>array('update', 'id'=>$model->Id)),
//array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php echo BSHtml::pageHeader('View','User '.$model->Id) ?>

<?php $this->widget('zii.widgets.CDetailView',array(
'htmlOptions' => array(
'class' => 'table table-striped table-condensed table-hover',
),
'data'=>$model,
'attributes'=>array(
		//'Id',
		'email',
		'pwd',
	array(
		'name'=>'Frozen',
		'value'=>function($data){
			if($data->Frozen==0){
				return '冻结';
			}else{
				return '不冻结';
			}
		}
	),
		'Lately_pwd',
	array(
		'name' => 'jurisdiction',
		'value' =>function($model){
            $roles = yii::app()->authmanager->getroles($model->Id);
            $roles=array_keys($roles);
            return implode(',',$roles);
		}
			/*function($data){
			$auth = Assignments::model()->find('userid='.$data->Id);
			if($auth){
				return $auth->itemname;
			}else{
				return ;
			}
			},*/
		),
	array(
		'name' => 'downloadRange',
		'value' => function($data){
			$downloadRange = $data->downloadRange;
			if(!$downloadRange){
				return '全部';
			}else{
				return Relation::model()->findByPk($downloadRange)->name;

			}
		},
	),
	array(
		'name' => 'is_download',
		'value' => function($data){
			$is_download = $data->is_download;
			if($is_download){
				return '是';
			}else{
				return '否';
			}
		},
	),
),
)); ?>