<?php

// change the following paths if necessary
$yii='./framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
//常用的配置
$basic=dirname(__FILE__).'/protected/config/basic.php';

// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',false);
// specify how many levels of call stack should be shown in each log message
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
date_default_timezone_set("Asia/Shanghai");
require_once($yii);
require_once($basic); //导入常用配置
Yii::createWebApplication($config)->run();
function pd($pm1, $pm2 = 'aaaaa2', $pm3 = 'bbbbb3', $pm4 = 'ccccc4', $pm5 = 'ddddd5')
{
    header("Content-type: text/html; charset=utf-8");

    echo '<div style="color: red">-----------------参数1打印--------------------</div>';
    echo '<hr>';
    echo '<pre>';
    print_r($pm1);
    echo '</pre>';
    if ($pm2 != 'aaaaa2') {
        echo '<hr>';
        echo '<div style="color: red">-----------------参数2打印--------------------</div>';
        echo '<hr>';
        echo '<pre>';
        print_r($pm2);
        echo '</pre>';
    }
    if ($pm3 != 'bbbbb3') {
        echo '<hr>';
        echo '<div style="color: red">-----------------参数3打印--------------------</div>';
        echo '<hr>';
        echo '<pre>';
        print_r($pm3);
        echo '</pre>';
    }
    if ($pm4 != 'ccccc4') {
        echo '<hr>';
        echo '<div style="color: red">-----------------参数4打印--------------------</div>';
        echo '<hr>';
        echo '<pre>';
        print_r($pm4);
        echo '</pre>';
    }
    if ($pm5 != 'ddddd5') {
        echo '<hr>';
        echo '<div style="color: red">-----------------参数5打印--------------------</div>';
        echo '<hr>';
        echo '<pre>';
        print_r($pm5);
        echo '</pre>';
    }
    die;
}
