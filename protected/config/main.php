<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '可口可乐新零售商超便利O2O追踪平台',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.PHPExcel.PHPExcel', //导入Excel插件
        'ext.bootstrap.behaviors.*',
        'ext.bootstrap.helpers.*',
        'ext.bootstrap.widgets.*',
        'ext.bootstrap.components.*',
        'application.modules.srbac.controllers.SBaseController', //添加Srbac模块
    ),
    'language' => 'zh_cn', // 不设置的话缺省为 en_us
    'sourceLanguage' => 'en_us',
    'aliases' => array(
        'bootstrap' => 'ext.bootstrap',
        'ext' => 'application.extensions',
        'uploads' => 'application.uploads',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'Admin',
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'lwy',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'bootstrap.gii',
            ),
        ),
        'srbac' => array(
            'userclass' => 'User', //可选,默认是 User
            'userid' => 'Id', //可选,默认是 userid
            'username' => 'email', //可选，默认是 username
            'debug' => false, //可选,默认是 false   使用时需要为false
            'pageSize' => 10, //可选，默认是 15
            'superUser' => 'Authority', //可选，默认是 Authorizer
            'css' => 'srbac.css', //可选，默认是 srbac.css
            'layout' => 'application.views.layouts.main', //可选,默认是application.views.layouts.main, 必须是一个存在的路径别名
            'notAuthorizedView' => 'srbac.views.authitem.unauthorized', // 可选,默认是unauthorized.php  srbac.views.authitem.unauthorized, 必须是一个存在的路径别名
            'alwaysAllowed' => array(), //可选,默认是 gui
            'userActions' => array('Show', 'View', 'List'), //可选,默认是空数组
            'listBoxNumberOfLines' => 15,
            'imagesPath' => 'srbac.images',
            'imagesPack' => 'noia',
            'iconText' => true,
            'header' => 'srbac.views.authitem.header',
            'footer' => 'srbac.views.authitem.footer',
            'showHeader' => true,
//            'showFooter' => true,
            'alwaysAllowedPath' => 'srbac.components',
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'class' => 'application.components.KOUser',
            'returnurl'=>"retail",
            'loginUrl'=>array('site/login'),
            'autoRenewCookie' => true,
        ),
        'authManager' => array(
            'class' => 'application.modules.srbac.components.SDbAuthManager',
            'connectionID' => 'db', //使用的数据库组件
            'itemTable' => '{{authitems}}', // 授权项目表 (默认:authitem)
            'assignmentTable' => '{{authassignments}}', // 授权分配表 (默认:authassignment)
            'itemChildTable' => '{{authitemchildren}}', // 授权子项目表 (默认:authitemchild)
            'defaultRoles' => array('site'), //默认角色
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            //'showScriptName'=>false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'dbtest' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=test',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ),
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.BsApi'
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                array(
                    'class' => 'CWebLogRoute',
                ),
            ),
        ),
        'filecache' => array(
            'class' => 'CFileCache'
        ),
        'memcache' => array(
            'class' => 'CMemCache',
            'servers' => array(
                array(
                    'host' => '127.0.0.1',
                    'port' => 11211,
                )
            ),
        ),
        'apccache' => array(
            'class' => 'CApcCache',
        ),
        'request' => array(
            'enableCsrfValidation' => false,
            'enableCookieValidation' => true,
        ),        
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    /* 'params'=>array(
      // this is used in contact page
      'adminEmail'=>'webmaster@example.com',
      'depth_sku'=>array(
      '1'=>'品类',
      '2'=>'品牌',
      '3'=>'价格区间',
      '4'=>'用餐方式',
      ),
      'rel_sku'=>array(
      '0'=>'全国',
      '1'=>'全部',
      '2'=>'装瓶厂',
      '3'=>'城市',
      ),
      ), */
    'params' => require(dirname(__FILE__) . '/params.php')
);
