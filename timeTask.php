<?php
/**
 * Created by PhpStorm.
 * User: Toge
 * Date: 2019/3/22
 * Time: 17:54
 */
$yii='./framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
defined('YII_DEBUG') or define('YII_DEBUG',true);
error_reporting(E_ALL & ~ (E_STRICT | E_NOTICE));
date_default_timezone_set("Asia/Shanghai");
require_once($yii);
Yii::createWebApplication($config);

set_time_limit(0);//程序执行时间无限制
$model = Task::model()->find(array('condition' => 'status = 1'));
if ($model) {
    echo "缓存执行时间".date("Y-m-d H:i:s")."<br>";
    $model->status = -1;//任务进行中
    $model->save();
    Info::timerTask($model->time, $model->stage);//生成缓存文件
    $model->status = 0;//定时任务完成
    $model->save();
    echo "缓存结束时间".date("Y-m-d H:i:s")."<br>";
} else {
    Yii::log('没有新数据进入，未生成缓存', 'warning');
}
