<?php
/**
 * Created by PhpStorm.
 * User: Toge
 * Date: 2018/12/12
 * Time: 10:07
 */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/store.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/echarts.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/angular.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/ng-echarts.js');
$relationss = RelationshipCvs::model()->findAll(array("order" => "sort"));
$relations = RelationshipCvs::model()->findAll(array("order" => "Id"));
$systemss = SystemCvs::model()->findAll(array('order' => 'sort'));
$systems = SystemCvs::model()->findAll(array('index' => 'Id'));
?>
<script>
    var app = angular.module('cockdash', ['ng-echarts'], function ($httpProvider) {

    });
    app.factory('datadService', ['$window', function ($window) {//datadService是用来装数据的
        return {
            set: function (key, value) {
                $window.localStorage[key] = value;
            },
            get: function (key, defaultValue) {
                return $window.localStorage[key] || defaultValue;
            },
            setObject: function (key, value) {    //存储对象，以JSON格式存储
                $window.localStorage[key] = JSON.stringify(value);
            },
            getObject: function (key) {    //读取对象
                return JSON.parse($window.localStorage[key] || '{}');
            }
        }
    }]);
    app.controller("optionchg", function ($scope, datadService, $http) {
        $scope.region = "1";//区域
        $scope.factory = "0";//装瓶厂
        $scope.system = '0';//客户系统
        $scope.systemtype = '0';//系统类型
        $scope.selcity = "China";

        $scope.infos = <?php echo CJSON::encode($infos) ?>;   //表格数据（涉及品类&品牌&SKU）
        $scope.datas = <?php echo CJSON::encode($datas) ?>;   //图表数据
        $scope.name = <?php echo CJSON::encode($name) ?>;   //图表x轴数据
        console.log("图表数据：", $scope.datas);
        $scope.relationss = <?php echo CJSON::encode($relationss) ?>;
        $scope.relationslist = $scope.relationss;
        console.log('区域:', $scope.relationslist);

        $scope.systems =<?php echo CJSON::encode($systems)?>;
        $scope.systemslist = <?php echo CJSON::encode($systemss)?>;
        console.log('系统:', $scope.systemslist);

        $scope.onoptionchange = function (level) {
            console.log(level);
            switch (level) {
                case 1:    //装瓶集团
                    $scope.factory = "0";
                    break;
                case 4:
                    if ($scope.systemtype == 0) $scope.system = 0;
                    angular.forEach($scope.systems, function (data, index, array) {
                        if (data.depth == 2 && data.parent == $scope.systemtype) {
                            $scope.systems[index]['checked'] = true;
                        } else if (data.depth == 2) {
                            $scope.systems[index]['checked'] = false;
                        }
                    });
                    break;
            }

            if ($scope.factory != '0') {
                if ($scope.systemtype != 0) {
                    $scope.selcity = $('#Search_factory').find('option[value=' + $scope.factory + ']').html() + " - " + $('#Search_systemtype').find('option[value=' + $scope.systemtype + ']').html();
                } else if ($scope.system != 0) {
                    $scope.selcity = $('#Search_factory').find('option[value=' + $scope.factory + ']').html() + " - " + $('#Search_usersystem').find('option[value=' + $scope.system + ']').html();
                } else {
                    $scope.selcity = $('#Search_factory').find('option[value=' + $scope.factory + ']').html() + " - 总系统";
                }
            } else if ($scope.region != '1') {
                if ($scope.systemtype != 0) {
                    $scope.selcity = $('#Search_region').find('option[value=' + $scope.region + ']').html() + " - " + $('#Search_systemtype').find('option[value=' + $scope.systemtype + ']').html();
                } else if ($scope.system != 0) {
                    $scope.selcity = $('#Search_region').find('option[value=' + $scope.region + ']').html() + " - " + $('#Search_usersystem').find('option[value=' + $scope.system + ']').html();
                } else {
                    $scope.selcity = $('#Search_region').find('option[value=' + $scope.region + ']').html() + " - 总系统";
                }
            } else {
                if ($scope.systemtype != 0) {
                    $scope.selcity = '<?= Yii::t('cvs', '全国')?>' + " - " + $('#Search_systemtype').find('option[value=' + $scope.systemtype + ']').html();
                } else if ($scope.system != 0) {
                    $scope.selcity = '<?= Yii::t('cvs', '全国')?>' + " - " + $('#Search_usersystem').find('option[value=' + $scope.system + ']').html();
                } else {
                    $scope.selcity = '<?= Yii::t('cvs', '全国')?>' + " - 总系统";
                }
            }

            let config = {
                'region': $scope.region,
                'factory': $scope.factory,
                'systemtype': $scope.systemtype,
                'system': $scope.system
            };
            $http({
                url: '<?php echo $this->createurl("getStoreCvs"); ?>',
                params: config
            }).success(function (response) {
                console.log("infos,表格数据：", response);
                $scope.infos = response.infos;   //表格数据（涉及品类&品牌&SKU）
                $scope.datas = response.datas;   //图表数据（不涉及品类&品牌&SKU）
                $scope.name = response.name;   //图表数据（不涉及品类&品牌&SKU）
                $scope.setstackbaroption();
            }).error(function (data, header, config, status) {
                console.log(data, header, config, status);
            });

        };

        //堆叠柱形图配置项
        $scope.stackbaroption = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                x: 'left',
                itemWidth: 10,
                itemHeight: 10,
                align: 'left',
                icon: 'circle',
                data: [],
                selected: {},
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                right:25,
                feature: {
                    saveAsImage: {},
                    myExcel: {
                        show: true,
                        title: "导出Excel",
                        icon: "image://http://echarts.baidu.com/images/favicon.png",
                        onclick: function (opts) {
                            var target = opts.option.xAxis[0].data[0];//名字
                            var series = opts.option.series; //堆叠柱形图数据
                            var axisData = opts.option.xAxis[0].data; //坐标数据
                            console.log(series, axisData);
                            var tdTimes = '<td style="text-align:center;">区域</td>' + '<td style="text-align:center;">渠道</td>'; //表头第一列
                            var tdBodys = ''; //表数据
                            for (var tdHead = 0; tdHead < series.length; tdHead++) {
                                tdTimes += '<td style="text-align:center;">' + series[tdHead].name + '</td>';
                            }
                            var table = '<table id="tableExcel_Day" border="1" class="table-bordered table-striped" style="width:100%;text-align:center"><tbody><tr>' + tdTimes + ' </tr>';
                            //详细数据
                            for (var lt = 0; lt < axisData.length; lt++) {//axisData坐标数据
                                var arr = axisData[lt].split("-");//分离区域和渠道
                                var area = "";
                                var ditch = "";
                                //分离区域和渠道
                                for (var nt = 0; nt < arr.length; nt++) {
                                    area = '<td style="text-align:center;">' + arr[0] + '</td>';
                                    if (arr[1] == 'Non') {
                                        ditch = '<td style="text-align:center;">' + arr[1] + '-CCMG</td>';
                                    } else {
                                        ditch = '<td style="text-align:center;">' + arr[1] + '</td>';
                                    }
                                }
                                for (var j = 0; j < series.length; j++) {
                                    var pillar = series[j].data;
                                    var temp = pillar[lt].value;
                                    if (temp != null && temp != undefined) {
                                        tdBodys += '<td style="text-align:center;">' + temp + '</td>';
                                    } else {
                                        tdBodys += '<td></td>';
                                    }
                                }
                                table += '<tr>' + area + ditch + tdBodys + '</tr>';
                                tdBodys = '';
                            }
                            table += '</tbody></table>';
                            $(".downExcel").empty();
                            $(".downExcel").append(table);
                            var oHtml = "\uFEFF"+document.getElementsByClassName('table-bordered')[0].outerHTML;
                            var excelBlob = new Blob([oHtml], {type: 'application/vnd.ms-excel'});
                            // 创建一个a标签
                            var oA = document.createElement('a');
                            // 利用URL.createObjectURL()方法为a元素生成blob URL
                            oA.href = URL.createObjectURL(excelBlob);
                            // 给文件命名
                            oA.download = target + '.xls';
                            // 模拟点击
                            oA.click();
                        }
                    }
                },
            },

            xAxis: [
                {
                    type: 'category',
                    data: [],
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    splitLine: {show: false},
                }
            ],
            series: [],
            animationDelayUpdate: function (idx) {
                return idx * 5;
            }
        };

        $scope.setstackbaroption = function () {    //堆叠柱状图
            $scope.stackbaroption.xAxis[0].data = [];
            $scope.stackbaroption.legend.data = [];
            $scope.stackbaroption.legend.selected = {};
            $scope.stackbaroption.series = [];
            console.log("测试:", $scope.datas);
            $scope.stackbaroption.xAxis[0].data.push($scope.name);
            //subdata表示数组每个单体元素，subindex为索引号
            angular.forEach($scope.datas, function (subdata, subindex) {
                console.log("值：", subdata);
                console.log("键：", subindex);
                var newseria = [];
                $scope.stackbaroption.legend.data.push(subindex);
//                $scope.stackbaroption.xAxis[0].data.push(subdata[1] + '-' + subdata[3]);
                subdata[5] = Math.round(subdata[5]);
                newseria.push({
                    value: subdata[5],
                    name: subindex
                });
                $scope.stackbaroption.series.push({
                    name: subindex,
                    type: 'bar',
                    itemStyle: {
                        normal: {
                            color: subdata[6]
                        }
                    },
                    barWidth: '100',
                    stack: 'total',
                    data: newseria
                });

            });
            for (let j = 0; j < $scope.stackbaroption.series.length; j++) {
                if ($scope.stackbaroption.series[j].data && $scope.stackbaroption.series[j].data.length > 0) {
                    $scope.myObj = {
                        "width": $scope.stackbaroption.series[j].data.length * 128 + 300
                    };
                    break
                }
            }
            console.log('stackbaroption.series', $scope.stackbaroption.series);
            var stackTotal = [];
//            for (let i = 0; i < $scope.stackbaroption.series.length; i++) {
//                var _length = $scope.stackbaroption.series[i].data.length;
//                for (let j = 0; j < _length; j++) {
//                    if (!stackTotal[j])stackTotal[j] = 0;
//                    stackTotal[j] += $scope.stackbaroption.series[i].data[j].value;
//                    console.log(j, stackTotal[j]);
//                    $scope.stackbaroption.series[i].data[j]['label'] = {
//                        normal: {
//                            show: true,
//                            position: 'top',
//                            formatter: function () {
//                                return '<?//= Yii::t('cvs', '总和')?>//: ' + stackTotal[j]
//                            }
//                        }
//                    };
//                }
//            }
            return $scope.stackbaroption;
        };
        $scope.pieConfig = {
            theme: 'default',
            dataLoaded: true,
            notMerge: true,
        };
    });
</script>
<div ng-app="cockdash" ng-controller="optionchg">
    <div class="container-fluid">
        <div class="navbar-header">

            <div class="logo" title="首页">
                <img src="<?php echo Yii::app()->baseUrl ?>/images/cvslogo.png">
                <span><?= Yii::t('cvs', '可口可乐便利店核查Dashboard'); ?></span>
            </div>

            <button class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">切换导航</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav nav-tabs navbar-right" style="background-color: white;">
                <li>
                <span>
                    <a href="<?php echo Yii::app()->createUrl('site/market'); ?>">
                        <?php
                        if (Yii::app()->language == 'zh_cn') {
                            echo CHtml::image(Yii::app()->baseUrl . "/images/rank.png");
                        } elseif (Yii::app()->language == 'es') {
                            echo CHtml::image(Yii::app()->baseUrl . "/images/e_rank.png");
                        }
                        ?>
                    </a>
                </span>
                </li>
                <li><span><a href="<?php echo Yii::app()->createUrl('site/indexcvs'); ?>">全国指标</a></span></li>
                <li>
                <span>
                    <?php
                    if (Yii::app()->language == 'zh_cn') {
                        echo CHtml::link('中', array('Site/ChangeLanguage', 'language' => 'zh_cn'), array('class' => 'changeRed', 'title' => '切换为中文'));
                        ?>
                        <i class="glyphicon glyphicon-resize-horizontal"></i>
                        <?php
                        echo CHtml::link('En', array('Site/ChangeLanguage', 'language' => 'es'), array('title' => Yii::t('cvs', '切换为英文')));
                    } elseif (Yii::app()->language == 'es') {
                        echo CHtml::link('中', array('Site/ChangeLanguage', 'language' => 'zh_cn'), array('title' => '切换为中文'));
                        ?>
                        <i class="glyphicon glyphicon-resize-horizontal"></i>
                        <?php
                        echo CHtml::link('En', array('Site/ChangeLanguage', 'language' => 'es'), array('class' => 'changeRed', 'title' => Yii::t('cvs', '切换为英文')));
                    }
                    ?>
                </span>
                </li>
                <li>
                    <div class="dropdown">
                    <span data-toggle="dropdown" title="下载月报或者期报">
                        <?= Yii::t('cvs', '下载'); ?>
                        <i class="caret"></i>
                    </span>
                        <ul class="dropdown-menu">
                            <li id="monthly_Reportz" data-toggle="modal" data-target="#myModal"><a
                                    href="#"><?= Yii::t('cvs', '报告'); ?></a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="user dropdown">
                    <span data-toggle="dropdown">
                        <?php echo BSHtml::image(Yii::app()->baseUrl . "/images/person.png"); ?>
                        GUEST
                        <i class="caret"></i>
                    </span>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo Yii::app()->createUrl('site/logout'); ?>"><?= Yii::t('cvs', '退出登录'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <?php
    $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'id' => 'form',
        'enableAjaxValidation' => false,
        'method' => 'get',
        'layout' => 'inline',
    ));
    $regionoptions = BSHtml::tag('option', array('value' => '1'), Yii::t('cvs', '装瓶集团'));
    $regionoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in relationslist', 'ng-if' => 'item.depth==1', 'ng-value' => 'item.Id', 'ng-bind' => 'item.name', 'ng-selected' => "item.Id==region?'selected':''"), '');
    $selregion = BSHtml::tag('select', array("id" => "Search_region", "class" => "screen-select", 'ng-model' => 'region', 'ng-change' => 'onoptionchange(1)', 'name' => 'Search[region]'), $regionoptions);

    $factoryoptions = BSHtml::tag('option', array('value' => '0'), Yii::t('cvs', '装瓶厂'));
    $factoryoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in relationslist', 'ng-if' => '(region==1 && item.depth==2)||(region!=1 && item.parent==region)', 'ng-value' => 'item.Id', 'ng-bind' => 'item.name', 'ng-selected' => "item.Id==factory?'selected':''"), '');
    $selfactory = BSHtml::tag('select', array("id" => "Search_factory", "class" => "screen-select", 'ng-model' => 'factory', 'ng-change' => 'onoptionchange(2)', 'name' => 'Search[factory]'), $factoryoptions);

    $systemtypeoptions = BSHtml::tag('option', array('value' => '0'), Yii::t('cvs', '系统类型'));
    $systemtypeoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in systemslist', 'ng-value' => 'item.Id', 'ng-bind' => 'item.name', 'ng-if' => 'item.depth==1', 'ng-selected' => "item.Id==systemtype?'selected':''"), '');
    $systemtype = BSHtml::tag('select', array("id" => "Search_systemtype", "class" => "screen-select", 'ng-model' => 'systemtype', 'ng-change' => 'onoptionchange(4)', 'name' => 'Search[systemtype]'), $systemtypeoptions);

    $usersystemoptions = BSHtml::tag('option', array('value' => '0'), Yii::t('cvs', '客户系统'));
    $usersystemoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in systemslist', 'ng-if' => '(item.depth==2&&systemtype!=0&&item.parent==systemtype)||(item.depth==2&&systemtype==0)', 'ng-value' => 'item.Id', 'ng-bind' => 'item.name', 'ng-selected' => "item.Id==system?'selected':''"), '');
    $usersystem = BSHtml::tag('select', array("id" => "Search_usersystem", "class" => "screen-select", 'ng-model' => 'system', 'ng-change' => 'onoptionchange(5)', 'name' => 'Search[system]'), $usersystemoptions);

    ?>
    <div class="screen">
        <div class="col-md-2 col-lg-2"><i>数据范围</i><span>|</span></div>
        <div class="col-md-4 col-lg-3">
            <?php
            echo $form->custominputControlGroup($selregion . $selfactory, Yii::t('cvs', '区域'), array("groupOptions" => array("class" => ""), "controlOptions" => array("style" => "display:inline-block;")));
            ?>
        </div>
        <div class="col-md-4 col-lg-3">
            <?php
            echo $form->custominputControlGroup($systemtype . $usersystem, Yii::t('cvs', '系统'), array("groupOptions" => array("class" => ""), "controlOptions" => array("style" => "display:inline-block;")));
            ?>
        </div>
    </div>
    <?php
    $this->endWidget();
    ?>
    <div class="chart">
        <div class="chart-normal">
            <div class="chart-title">常温货架门店数</div>
            <div class="chart-div">
                <div id="main" style="width: 400px;height:400px;">
                    <ng-echarts id="piecharts" class="echarts piecharts" ng-style="myObj" ec-config="pieConfig"
                                ec-option="setstackbaroption()"
                                style="height: 100%;display: inline-block;"></ng-echarts>
                </div>
            </div>
        </div>
    </div>
    <div class="sku_sum">
        <div class="sum_title">各品牌SKU数量</div>
        <div class="sum_details row">
            <div class="specific col-md-3 col-lg-2 col-sm-6" ng-repeat="x in infos">
                <div class="specific-div">
                    <div class="specific-title"><img src="<?= Yii::app()->baseUrl . '/images/cycle.png'; ?>">{{x[0][1]}}
                    </div>
                    <table>
                        <tr>
                            <td>品牌</td>
                            <td ng-bind="selcity"></td>
                        </tr>
                        <tr ng-repeat="y in x">
                            <td>{{y[3]}}</td>
                            <td>{{y[4] | number:2}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display: none" class="downExcel"></div>
