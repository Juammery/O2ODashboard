<?php
/**
 * Created by PhpStorm.
 * User: bane
 * Date: 2018/3/1
 * Time: 14:59
 * 发送邮件给销售
 */
$yii='./framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
defined('YII_DEBUG') or define('YII_DEBUG',false);
error_reporting(E_ALL & ~ (E_STRICT | E_NOTICE));
date_default_timezone_set("Asia/Shanghai");
require_once($yii);
Yii::createWebApplication($config);

Rank::model()->Kylin2MySQL(1);
exit;
Info::model()->Info_for_all(4);
exit;


Info::model()->KylinInfoData12();
exit;
Info::model()->KylinInfoData('2018_12','0');
exit;
Rank::model()->KylinRankData($table_prefix,$table_subfix);  //表名前缀和后缀，比如cola_rank_2018_11_0,$table_prefix的实参值为2018_11，$table_subfix的实参值为0
?>




