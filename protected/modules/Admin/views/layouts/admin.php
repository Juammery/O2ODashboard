<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- basic styles -->

    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="shortcut icon" type="images/x-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/cvslogo.png">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/css/font-awesome.min.css"/>

    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl;?>/css/assets/css/font-awesome-ie7.min.css"/>
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts -->

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300"/>

    <!-- ace styles -->

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/css/ace.min.css"/>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/css/ace-rtl.min.css"/>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/css/ace-skins.min.css"/>

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl;?>/css/assets/css/ace-ie.min.css"/>


    <?php
	$cs = Yii::app()->clientScript;
    $themePath = Yii::app()->baseUrl;

    $cs
    ->registerCssFile($themePath.'/public/bootstrap/css/bootstrap.css')
    ->registerCssFile($themePath.'/public/bootstrap/css/bootstrap-theme.css')
    ->registerCssFile($themePath.'/css/chosen.css')
    // ->registerCssFile($themePath.'/css/index.css')
    ->registerCoreScript('jquery',CClientScript::POS_END)
    ->registerCoreScript('jquery.ui',CClientScript::POS_END)
    ->registerScriptFile($themePath.'/public/bootstrap/js/bootstrap.min.js',CClientScript::POS_END)
    ->registerScriptFile($themePath.'/js/chosen.jquery.js')
    ->registerScriptFile($themePath.'/js/echarts.min.js')

    ->registerScriptFile('http://cache.amap.com/lbs/static/es5.min.js')
    ->registerScriptFile('http://webapi.amap.com/maps?v=1.4.0&key=257c0ee3c27ad6d5fdf021405555b8a8&plugin=AMap.DistrictSearch')
    ->registerCssFile('http://cache.amap.com/lbs/static/main.css?v=1.0?v=1.0')
    ->registerScriptFile('http://cache.amap.com/lbs/static/addToolbar.js')
    ->registerScriptFile('https://webapi.amap.com/demos/js/liteToolbar.js')
    ->registerCssFile($themePath.'/css/assets/css/admin.css')
    ?>

    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="<?php echo Yii::app()->request->baseUrl;?>/css/assets/js/html5shiv.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl;?>/css/assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try {
            ace.settings.check('navbar', 'fixed')
        } catch (e) {
        }
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/cvslogo.png">
                    <span id="logo">可口可乐新零售商超便利O2O追踪平台</span>
                </small>
            </a><!-- /.brand -->
        </div><!-- /.navbar-header -->

        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a class="" href="<?php echo $this->createUrl('user/logout') ?>">退出登录</a>
                </li>
        </div><!-- /.navbar-header -->
    </div><!-- /.container -->
</div>

<div class="main-container" id="main-container">
    <script type="text/javascript">
        try {
            ace.settings.check('main-container', 'fixed')
        } catch (e) {
        }
    </script>
    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>

        <div class="sidebar" id="sidebar">
            <script type="text/javascript">
                try {
                    ace.settings.check('sidebar', 'fixed')
                } catch (e) {
                }
            </script>

            <div class="sidebar-shortcuts" id="sidebar-shortcuts">

                <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                    <span class="btn btn-success"></span>

                    <span class="btn btn-info"></span>

                    <span class="btn btn-warning"></span>

                    <span class="btn btn-danger"></span>
                </div>
            </div><!-- #sidebar-shortcuts -->

            <ul class="nav nav-list li-selected">
                <li class="selected">
                    <a href="<?php echo $this->createUrl('user/admin') ?>" class="dropdown-toggle">
                        <i class="icon-desktop"></i>
                        <span class="menu-text">账号管理</span>
                    </a>
                </li>
<!--                <li class="selected">-->
<!--                    <a href="--><?php //echo $this->createUrl('rank/admin') ?><!--">-->
<!--                        <i class="glyphicon glyphicon-tree-deciduous"></i>-->
<!--                        <span class="menu-text">排名管理</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li class="selected">-->
<!--                    <a href="--><?php //echo $this->createUrl('info/admin') ?><!--">-->
<!--                        <i class="glyphicon glyphicon-tree-deciduous"></i>-->
<!--                        <span class="menu-text">数据管理</span>-->
<!--                    </a>-->
<!--                </li>-->
                <li class="selected">
                    <a href="<?php echo $this->createUrl('Presentation/admin') ?>">
                        <i class="glyphicon glyphicon-tree-deciduous"></i>
                        <span class="menu-text">报告管理</span>
                    </a>
                </li>
                <li class="selected">
                    <a href="<?php echo $this->createUrl('sku/admin') ?>">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span class="menu-text">SKU管理</span>
                    </a>
                </li>
                <li class="selected">
                    <a href="<?php echo $this->createUrl('relation/admin') ?>">
                        <i class="glyphicon glyphicon-tree-deciduous"></i>
                        <span class="menu-text">区域管理</span>
                    </a>
                </li>
                <li class="selected">
                    <a href="<?php echo $this->createUrl('platform/admin') ?>">
                        <i class="glyphicon glyphicon-print"></i>
                        <span class="menu-text">平台管理</span>
                    </a>
                </li>
                <li class="selected">
                    <a href="<?php echo $this->createUrl('system/admin') ?>">
                        <i class="glyphicon glyphicon-blackboard"></i>
                        <span class="menu-text">渠道管理</span>
                    </a>
                </li>
                <li class="selected">
                    <a href="<?php echo $this->createUrl('calculate/index') ?>">
                        <i class="glyphicon glyphicon-blackboard"></i>
                        <span class="menu-text">数据计算</span>
                    </a>
                </li>
                <script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'collapsed')
                    } catch (e) {
                    }
                </script>
            </ul>

        </div>

        <div class="main-content">
            <div class="page-content">
                <div class="row">
                    <?php
                    echo BSHtml::buttonGroup($this->menu);
                    ?>
                    <div class="col-xs-12">
                        <?php
                        if (($hint = yii::app()->user->getflash('hint')) != NULL) {
                            echo BSHtml::alert($hint['type'], $hint['message']);
                        } ?>

                        <!-- PAGE CONTENT BEGINS -->
                        <?php echo $content; ?>

                        <script type="text/javascript">
                            var $assets = "assets";//this will be used in fuelux.tree-sampledata.js
                        </script>

                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div><!-- /.main-content -->

        <div class="ace-settings-container" id="ace-settings-container">
            <div class="ace-settings-box" id="ace-settings-box">
                <div>
                    <div class="pull-left">
                        <select id="skin-colorpicker" class="hide">
                            <option data-skin="default" value="#438EB9">#438EB9</option>
                            <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                            <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                            <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                        </select>
                    </div>
                    <span>&nbsp; Choose Skin</span>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar"/>
                    <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar"/>
                    <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs"/>
                    <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl"/>
                    <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container"/>
                    <label class="lbl" for="ace-settings-add-container">
                        Inside
                        <b>.container</b>
                    </label>
                </div>
            </div>
        </div><!-- /#ace-settings-container -->
    </div><!-- /.main-container-inner -->

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>
</div><!-- /.main-container -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo Yii::app()->request->baseUrl;?>/css/assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo Yii::app()->request->baseUrl;?>/css/assets/js/jquery-1.10.2.min.js'>" + "<" + "/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if ("ontouchend" in document) document.write("<script src='<?php echo Yii::app()->request->baseUrl;?>/css/assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/js/typeahead-bs2.min.js"></script>

<!-- page specific plugin scripts -->

<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/js/fuelux/data/fuelux.tree-sampledata.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/js/fuelux/fuelux.tree.min.js"></script>

<!-- ace scripts -->

<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/js/ace-elements.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/js/ace.min.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function ($) {
        $('#tree1').ace_tree({
            dataSource: treeDataSource,
            multiSelect: true,
            loadingHTML: '<div class="tree-loading"><i class="icon-refresh icon-spin blue"></i></div>',
            'open-icon': 'icon-minus',
            'close-icon': 'icon-plus',
            'selectable': true,
            'selected-icon': 'icon-ok',
            'unselected-icon': 'icon-remove'
        });
        $('#tree2').ace_tree({
            dataSource: treeDataSource2,
            loadingHTML: '<div class="tree-loading"><i class="icon-refresh icon-spin blue"></i></div>',
            'open-icon': 'icon-folder-open',
            'close-icon': 'icon-folder-close',
            'selectable': false,
            'selected-icon': null,
            'unselected-icon': null
        });
        /**
         $('#tree1').on('loaded', function (evt, data) {
		});

         $('#tree1').on('opened', function (evt, data) {
		});

         $('#tree1').on('closed', function (evt, data) {
		});

         $('#tree1').on('selected', function (evt, data) {
		});
         */
    });
</script>
</body>
</html>