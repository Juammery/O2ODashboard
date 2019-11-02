<?php

// This is the database connection configuration.
return array(
    /*'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',*/
    // uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=116.236.241.54;port=16000;dbname=cokeretail',
	'emulatePrepare' => true,
	'username' => 'coke',
	'password' => 'CokeDash2019',
//    'connectionString' => 'mysql:host=192.168.10.210;dbname=cokeretail',
//    'emulatePrepare' => true,
//    'username' => 'coke',
//    'password' => 'CokeDash2019',
    'charset' => 'utf8',
    'tablePrefix' => 'cola_',   //定义表前缀
    'enableParamLogging' => true, //开启调试信息的SQL语句具体值信息
);
