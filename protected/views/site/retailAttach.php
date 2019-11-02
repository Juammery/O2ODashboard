<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/echarts.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/angular.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/ng-echarts.js');
//$db = Yii::app()->db;
//$sql = 'select stage as id,stage from cola_info where time="' . $searchmodel->month . '" GROUP BY  stage order by stage asc';
//$stages = $db->createCommand($sql)->queryAll();
//$sql = "select table_name from information_schema.tables where table_schema='cokeretail' and table_type='BASE TABLE' and TABLE_NAME like 'cola_info_%' ORDER BY TABLE_NAME desc";

//$table = Yii::app()->db->createCommand($sql)->queryAll();
//var_dump($table);
//$arr = $maxStage = [];
//foreach ($table as $key => $value) {
//    $tableName = $value['table_name'];
//    //var_dump($tableName);
//    $infomation = explode('_', $tableName); //把字符串打散为数组
//    //array(5) {
//    // [0]=> string(4) "cola"
//    // [1]=> string(4) "info"
//    // [2]=> string(4) "2018"
//    // [3]=> string(2) "11"
//    // [4]=> string(1) "0"
//    // }
//
//    $arr[] = ['time' => $infomation[2] . "_" . $infomation[3], 'stage' => $infomation[4]];
//    //time=2018_11,stage=0
//    //var_dump($arr[0]['stage']);
//}
//foreach ($arr as $key => $value) {
//    $arr1[] = $value['time'];
//
//    $maxStage[$value['time']][] = $value['stage'];
//    //var_dump($maxStage[$value['time']]);
//}
?>
<script>
    angular.module('common', []).filter('unique', function () {
        return function (collection, keyname) {
            // console.info(collection);
            // console.info(keyname);
            var output = [],
                keys = [];
            angular.forEach(collection, function (item) {
                var key = item[keyname];
                if (keys.indexOf(key) === -1) {
                    keys.push(key);
                    output.push(item);
                }
            });
            return output;
        }
    });
    // 'ng-echarts',
    var app = angular.module('cockdash', ['common'], function ($httpProvider) {
    });

    app.directive('bar', function() {
        return {
            scope: {
                id: "@",
                legend: "=",
                item: "=",
                data: "="
            },
            restrict: 'E',
            template: '<div style="height:400px;width:598px; "></div>',
            replace: true,
            link: function($scope, element, attrs, controller) {
                myChart = echarts.init(document.getElementById($scope.id),'macarons');
                var option = {
                    // 提示框，鼠标悬浮交互时的信息提示
                    tooltip: {
                        show: true,
                        trigger: 'item'
                    },
                    // 图例
                    legend: {
                        data: []
                    },
                    // 横轴坐标轴
                    xAxis: [{
                        type: 'category',
                        data: [],
                        boundaryGap : false
                    }],
                    dataZoom: [{   // 这个dataZoom组件，默认控制x轴。
                        type: 'slider', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                        start: 40,      // 左边在 40% 的位置。
                        end: 100         // 右边在 100% 的位置。
                    },
                        {   // 这个dataZoom组件，也控制x轴。
                            type: 'inside', // 这个 dataZoom 组件是 inside 型 dataZoom 组件
                            start: 40,      // 左边在 40% 的位置。
                            end: 100         // 右边在 100% 的位置。
                        }],
                    // 纵轴坐标轴
                    yAxis: [{
                        type: 'value'
                    }],
                    // 数据内容数组
                    series: function(){
                        var serie=[];
                        return serie;
                    }()
                };
                myChart.setOption(option);

                $scope.$watch('data',function(newValue, oldValue, scope){
                    if(newValue.length == 0){
                        myChart.clear();
                        var option = {
                            // 提示框，鼠标悬浮交互时的信息提示
                            tooltip: {
                                show: true,
                                trigger: 'item'
                            },
                            // 图例
                            legend: {
                                data: []
                            },
                            // 横轴坐标轴
                            xAxis: [{
                                type: 'category',
                                data: [],
                                boundaryGap : false
                            }],
                            dataZoom: [{   // 这个dataZoom组件，默认控制x轴。
                                type: 'slider', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                                start: 40,      // 左边在 40% 的位置。
                                end: 100         // 右边在 100% 的位置。
                            },
                                {   // 这个dataZoom组件，也控制x轴。
                                    type: 'inside', // 这个 dataZoom 组件是 inside 型 dataZoom 组件
                                    start: 40,      // 左边在 40% 的位置。
                                    end: 100         // 右边在 100% 的位置。
                                }],
                            // 纵轴坐标轴
                            yAxis: [{
                                type: 'value'
                            }],
                            // 数据内容数组
                            series: function(){
                                var serie=[];
                                return serie;
                            }()
                        };
                        myChart.setOption(option);
                    }
                    var option = {
                        // 提示框，鼠标悬浮交互时的信息提示
                        tooltip: {
                            show: true,
                            trigger: 'item'
                        },
                        // 图例
                        legend: {
                            orient: 'horizontal',      // 布局方式，默认为水平布局，可选为：'horizontal' ¦ 'vertical'
                            x: 'center',               // 水平安放位置，默认为全图居中，可选为：'center' ¦ 'left' ¦ 'right' ¦ {number}（x坐标，单位px）
                            y: 'top',                  // 垂直安放位置，默认为全图顶端，可选为：'top' ¦ 'bottom' ¦ 'center' ¦ {number}（y坐标，单位px）
                            backgroundColor: 'rgba(0,0,0,0)',
                            borderColor: '#ccc',       // 图例边框颜色
                            borderWidth: 0,            // 图例边框线宽，单位px，默认为0（无边框）
                            padding: 30,               // 图例内边距，单位px，默认各方向内边距为5，接受数组分别设定上右下左边距，同css
                            itemGap: 10,               // 各个item之间的间隔，单位px，默认为10，横向布局时为水平间隔，纵向布局时为纵向间隔
                            itemWidth: 20,             // 图例图形宽度
                            itemHeight: 14,            // 图例图形高度
                            textStyle: {
                                color: '#333'          // 图例文字颜色
                            },
                            data: $scope.legend
                        },
                        // 横轴坐标轴
                        xAxis: [{
                            type: 'category',
                            data: $scope.item,
                            boundaryGap : false
                        }],
                        // 纵轴坐标轴
                        yAxis: [{
                            type: 'value'
                        }],
                        // 数据内容数组
                        series: function(){
                            var serie=[];
                            for(var i=0;i<$scope.legend.length;i++){
                                var item = {
                                    name : $scope.legend[i],
                                    type: 'line',
                                    data: $scope.data[i]
                                };
                                serie.push(item);
                            }
                            return serie;
                        }()
                    };
                    myChart.setOption(option);
                }, true);
            }
        };
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

    app.factory("getData",function($http,$q) {
        var factory={};
        factory.getHttp=function ($sql) {
               // console.log('$q',$q);
           var deferred=$q.defer();
               // console.log('deferred',deferred);
            var promise=deferred.promise;
               // console.log(data.status);
            $http({
                method:"POST",
                url: 'http://data.togedata.com:16030/kylin/api/query',
                headers: {'Content-Type':'application/json;charset=UTF-8','Authorization':'Basic YWRtaW46S1lMSU4='},
                data: {
                    'sql':$sql,
                    "offset":0,
                    // "limit":50000,
                    "acceptPartial":false,
                    'project':'O2O_retail'
                }
            }).success(function (res) {
                    //console.log(res.data);
                    //console.log('ddd',res.results);
                    deferred.resolve(res);
            }).error(function (res) {
                    console.log("啊哦，网页丢了");
                    deferred.reject(res)
            });
            return promise;
            };
            return factory;
    });

    app.controller("optionchg", ["$scope","getData",function ($scope, getData,datadService, $http) {
//上半部分的筛选项
        $scope.zpjt1='全部';//装瓶集团,默认为全部
        $scope.zpc1='全部';//装瓶厂,默认为全部
        $scope.city_level1='全部';//城市等级,默认为全部
        $scope.city1='全部';//参数,默认为全部
        $scope.channel1='全部';//渠道,默认为全部
        $scope.platform1='全部';//平台,默认为全部
        $scope.type1='全部';  //品类,默认为全部
//下半部分的筛选项
//         $scope.zpjt2='0';//装瓶集团,默认为全部
//         $scope.zpc2='0';//装瓶厂,默认为全部
//         $scope.city_level2='0';//城市等级,默认为全部
//         $scope.city2='全国';//参数,默认为全部
//         $scope.channel2='0';//渠道,默认为全部
//         $scope.platform2='0';//平台,默认为全部
//         $scope.type2='0';  //品类,默认为全部
//         $scope.manu='0'; //制造商
//         $scope.pack_level='0'; //瓶量分级
//         $scope.level='0'; //容量分
        $scope.factory = "0";//装瓶厂
        $scope.cityLevel = "0";//城市等级
        $scope.city = "全国";//城市
        $scope.platform = "0";//平台
        $scope.cityLevelListtype = '0';
        $scope.station = "0";
        $scope.category = "0";  //品类
        $scope.menu = "0";  //制造商
        $scope.brand = "0";  //品牌
        $scope.capacity = "0";  //容量分级
        $scope.bottle = "0";  //瓶量分级
        $scope.SKU = "0";  //sku
        $scope.nodata = '';
        $scope.system = '0';
        $scope.systemtype = '0';
        $scope.groupallcheck='0';
        $scope.factoryallcheck='0';
        $scope.cityallcheck='0';
        $scope.city_levelallcheck='0';
        $scope.channelallcheck='0';
        $scope.platformallcheck='0';
        $scope.categoryallcheck='0';
        $scope.manuallcheck='0';
        $scope.brandallcheck='0';
        $scope.capacityallcheck='0';
        $scope.bottleallcheck='0';

        if(!$scope.month){
            $scope.month='2018-12-01';
            var date = new Date($scope.month);
            $scope.month_next=''+date.getFullYear()+'-'+(date.getMonth()+2)+'-'+(date.getDate()-1);
        }
        // $scope.basesql='(select * from sku_2018 where dt between'+'\''+$scope.month+'\''+ ' and ' +'\''+$scope.month_next+'\')';
        $scope.basesql='(select zpjt,\'全部\' city_level,platform,channel,type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,platform,channel,type union\n' +
            'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type  from  (select * from sku_2018 where dt =\'2018-12-01\') group by platform,channel,type union\n' +
            'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type  from  (select * from sku_2018 where dt =\'2018-12-01\') group by channel,type union\n' +
            'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type from  (select * from sku_2018 where dt =\'2018-12-01\') group by type union\n' +
            'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') group by channel union\n' +
            'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type  from  (select * from sku_2018 where dt =\'2018-12-01\') group by platform,type union\n' +
            'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') group by platform union\n' +
            'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type  from  (select * from sku_2018 where dt =\'2018-12-01\') group by platform,channel union\n' +
            'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,channel,type union\n' +
            'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,type union \n' +
            'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt union \n' +
            'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,channel union \n' +
            'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,platform,type union \n' +
            'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,platform union \n' +
            'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,platform,channel union \n' +
            'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') \n)';

        $scope.queryfield='select type,zpjt,channel,platform,city_level from '+$scope.basesql;
        $scope.condition1='where zpjt in (\'SCCL\',\'ZH\',\'CBL\')'; //第一个分组的where条件
        $scope.citylevelcon=''; //第一个分组的where条件
        $scope.condition2=' and channel in (\'CVS\' ,\'Super\',\'Mini\' ,\'Hyper\',\'GT及其他\')';//第二个分组的where条件
        $scope.condition3=' and platform in (\'pdj\' ,\'饿了么\' ,\'美团外卖\',\'京东到家\')';//第三个分组的where条件
        $scope.condition4=' and type in (\'乳味饮料\',\'功能饮料\',\'咖啡\',\'果汁饮料\' ,\'植物蛋白饮料\',\'植物饮料\' ,\'水\',\'汽水\' ,\'组合\',\'茶\' )';//第四个分组的where条件
        $scope.condition5='';
        $scope.groupbyfield='group by channel,platform,city_level,type,zpjt';
        $scope.sql1=$scope.queryfield+$scope.condition1+$scope.citylevelcon+$scope.condition2+$scope.condition3+$scope.condition4+$scope.condition5+$scope.groupbyfield;
        $scope.deepgroupcheck = 'group';
        $scope.deepbrandcheck = 'catalog';
        $scope.deepsystemcheck = 'systemtype';
        $scope.deepplatformcheck = 'platform';
        $scope.deepgradingcheck = 'capacity';
        $scope.cityLevelListcheck = '';
        $scope.deepcapacitycheck = '';
        $scope.deepcapacitycheck2 = '';
        $scope.deepgroupcheck2 = '';  //用来判断折线图是否需要请求数据
        $scope.deepbrandcheck2 = '';
        $scope.deepsystemcheck2 = '';
        $scope.skuvisible = true;
        $scope.typeValue = false;
        $scope.capacitycheck = false;
        $scope.bottlecheck = false;
        $scope.iscityleveltype = 'unchecked'; //判断是否选择城市等级
        $scope.iscapacity = 'unchecked'; //判断是否选择容量分级
        $scope.isbottle = 'unchecked'; //判断是否选择瓶量分级
        $scope.visitab ='distribution';
        $scope.kpichecked = 1;//默认产品铺货率
        $scope.stackbardata=[];
        $scope.brandreadonly = {
            category: false,
            manufacturer: false,
            brand: false,
            SKU: false,
            capacity: false,
            bottle: false
        };
        $scope.history = {
            'distribution': 0,
            'sales_numbers': 0,
            'sales_quota': 0,
            'saleroom': 0,
            'sales_share': 0,
            'enrollment': 0,
            'store_money': 0,
            'store_number': 0,
            'distribution_store': 0,
            'average_selling_price': 0,
            'average_purchase_price': 0,
            'price_promotion_ratio': 0,
            'average_discount_factor': 0,
            'average_number_per_unit': 0,
            'average_amount_per_order': 0,
            'online_stores': 0
        };
        $scope.nocompare = true; //是否排序
        $scope.nosort = '排序';
        $scope.baroptionlist=new Array();

        // 时间列表，关系到要查询的数据表
        getData.getHttp('select dt from SKU_2018 group by dt').then(function (data){
            $scope.timelist = data.results;
            // 初始化$scope.month值
            $scope.month='2018-12-01'; //默认为2018年12月数据
            var date = new Date($scope.month);
            $scope.lastmonth=''+date.getFullYear()+'-'+(date.getMonth())+'-01'; //表示上一个月的开始日期
            console.log('$scope.lastmonth',$scope.lastmonth);
            //$scope.basesql='(select * from sku_2018 where dt between'+'\''+$scope.month+'\''+ ' and ' +'\''+$scope.month_next+'\')';
            $scope.basesql='(select zpjt,\'全部\' city_level,platform,channel,type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,platform,channel,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type  from  (select * from sku_2018 where dt =\'2018-12-01\') group by platform,channel,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type  from  (select * from sku_2018 where dt =\'2018-12-01\') group by channel,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type from  (select * from sku_2018 where dt =\'2018-12-01\') group by type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') group by channel union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type  from  (select * from sku_2018 where dt =\'2018-12-01\') group by platform,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') group by platform union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type  from  (select * from sku_2018 where dt =\'2018-12-01\') group by platform,channel union\n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,channel,type union\n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,type union \n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt union \n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,channel union \n' +
                'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,platform,type union \n' +
                'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,platform union \n' +
                'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') group by zpjt,platform,channel union \n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt =\'2018-12-01\') \n)';

            $scope.basesql0='(select * from sku_2018 where dt ='+'\''+$scope.month+'\')';
            $scope.lastbasesql0='(select * from sku_2018 where dt ='+'\''+$scope.lastmonth+'\')';
            //console.log('basesql',$scope.basesql);
            //获取列表数据的sql语句
           $scope.zpjtlistsql='select \'全部\' zpjt  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\')  union\n' +
                'select zpjt from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\')';
//装瓶集团列表$scope.zpjtlist
            getData.getHttp($scope.zpjtlistsql).then(function (data){
                $scope.zpjtlist0 = data.results;
                $scope.zpjtlist = data.results;
                angular.forEach($scope.zpjtlist,function (item,index,array) {
                    $scope.zpjtlist[index].checked=1;
                });
                // console.log('zpjtlist',$scope.zpjtlist);
            },function (data) {
                console.log(data);
            });
// 装瓶厂列表$scope.zpclist
            var reg = new RegExp( 'zpjt' , "g" );
            $scope.zpclistsql=$scope.zpjtlistsql.replace(reg,'zpc');
            getData.getHttp($scope.zpclistsql).then(function (data){
                $scope.zpclist0 = data.results;
                $scope.zpclist = data.results;
                // console.log("$scope.zpclist",$scope.zpclist);
            },function (data) {
                console.log(data);
            });
// 城市列表$scope.citylist
            $scope.citylistsql=$scope.zpjtlistsql.replace(reg,'city');
            getData.getHttp($scope.citylistsql).then(function (data){
                $scope.citylist0 = data.results;
                $scope.citylist = data.results;
            },function (data) {
                console.log(data);
            });
// 城市等级列表$scope.cityclasslist
            $scope.city_levellistsql=$scope.zpjtlistsql.replace(reg,'city_level');
            getData.getHttp($scope.city_levellistsql).then(function (data){
                $scope.cityclasslist0 = data.results;
                $scope.cityclasslist = data.results;
            },function (data) {
                console.log(data);
            });
// 渠道列表$scope.channellist
            $scope.channellistsql=$scope.zpjtlistsql.replace(reg,'channel');
            getData.getHttp($scope.channellistsql).then(function (data){
                $scope.channellist0 = data.results;
                $scope.channellist = data.results;
                angular.forEach($scope.channellist,function (item,index,array) {
                    $scope.channellist[index].checked=1;
                });
            },function (data) {
                console.log(data);
            });
// 平台列表$scope.platformlist
            $scope.platformlistsql=$scope.zpjtlistsql.replace(reg,'platform');
            getData.getHttp($scope.platformlistsql).then(function (data){
                $scope.platformlist0 = data.results;
                $scope.platformlist = data.results;
                angular.forEach($scope.platformlist,function (item,index,array) {
                    $scope.platformlist[index].checked=1;
                });
            },function (data) {
                console.log(data);
            });
// 品类列表$scope.typelist
            $scope.typelistsql=$scope.zpjtlistsql.replace(reg,'type');
            // console.log('$scope.typelistsql',$scope.typelistsql);
            getData.getHttp($scope.typelistsql).then(function (data){
                $scope.typelist0 = data.results;
                $scope.typelist = data.results;
                console.log('ttt',$scope.typelist);
                $scope.typelistarray=[];
                angular.forEach($scope.typelist,function (item,index,array) {
                    $scope.typelist[index].checked=1;
                    $scope.typelistarray.push(item[0]);
                });
            },function (data) {
                console.log(data);
            });
// 制造商列表$scope.manulist
            $scope.manulistsql=$scope.zpjtlistsql.replace(reg,'manu');
            getData.getHttp($scope.manulistsql).then(function (data){
                $scope.manulist = data.results;
                //console.log('$scope.manulist',$scope.manulist);
                $scope.manulistarray=[];
                angular.forEach($scope.manulist,function (item,index,array) {
                    $scope.manulistarray.push(item[0]);
                });
            },function (data) {
                console.log(data);
            });
// 品牌列表$scope.pinpailist
            $scope.pinpailistsql=$scope.zpjtlistsql.replace(reg,'pinpai');
            getData.getHttp($scope.pinpailistsql).then(function (data){
                $scope.pinpailist = data.results;
                $scope.pinpailistarray=[];
                angular.forEach($scope.pinpailist,function (item,index,array) {
                    $scope.pinpailistarray.push(item[0]);
                });
            },function (data) {
                console.log(data);
            });
// 容量等级列表$scope.capacitylist
            $scope.capacitylistsql=$scope.zpjtlistsql.replace(reg,'level');
            getData.getHttp($scope.capacitylistsql).then(function (data){
                $scope.capacitylist = data.results;
                // $scope.capacitylist=new Array();
                // angular.forEach($scope.capacitylist_,function (item) {
                //     if(item[0]=='null'){
                //         item[0]="其他";
                //     }
                //     $scope.capacitylist.push(item[0]);
                // });
                // console.log('容量分级列表',$scope.capacitylist);
            },function (data) {
                console.log(data);
            });
// 瓶量等级列表$scope.bottlelist
            $scope.bottlelistsql=$scope.zpjtlistsql.replace(reg,'pack_level');
            getData.getHttp($scope.bottlelistsql).then(function (data){
                $scope.bottlelist = data.results;
                // $scope.bottlelist=new Array();
                // angular.forEach($scope.bottlelist_,function (item) {
                //     if(item[0]=='null'){
                //         item[0]="其他";
                //     }
                //     // console.log("$scope.bottlelist",item[0]);
                //     $scope.bottlelist.push(item[0]);
                // });
                //console.log("$scope.bottlelist",$scope.bottlelist);
            },function (data) {
                console.log(data);
            });

// 头部数据
            //全国该时间内线上在售任一KO产品的网店数
            getData.getHttp('select count(distinct storeid_copy) from '+$scope.basesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
                $scope.ko_onlinestores = data.results[0][0];
                //console.log('任一KO产品的网店数',$scope.ko_onlinestores);
                $scope.sortko_onlinestores=$scope.ko_onlinestores; //页面初始化时分组默认全部，此处给分组数据赋初始值
            },function (data) {
                console.log(data);
            });
            //上月
            getData.getHttp('select count(distinct storeid_copy) from '+$scope.lastbasesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
                //console.log('任一KO产品的网店数','select count(distinct storeid_copy) from '+$scope.lastbasesql0+' where is_ko=1 group by is_ko,dt');
                $scope.lastko_onlinestores = data.results.length!=0?data.results[0][0]:null;
                //console.log('任一KO产品的网店数',$scope.ko_onlinestores);
                $scope.lastsortko_onlinestores=data.results.length!=0?$scope.lastko_onlinestores:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
            },function (data) {
                console.log(data);
            });
             //全国该时间内全部网店数
            console.log('$scope.basesql',$scope.basesql0);
            getData.getHttp('select count(distinct storeid) from '+$scope.basesql0+' group by dt').then(function (data){
                $scope.onlinestores = data.results[0][0];
                //上半部分网店数
                $scope.sortonlinestores= $scope.onlinestores; //页面初始化时分组默认全部，此处给分组数据赋初始值
                $scope.disonlinestores=$scope.sortonlinestores;
                //下半部分网店数
                $scope.sortonlinestores1= $scope.onlinestores; //页面初始化时分组默认全部，此处给分组数据赋初始值
                $scope.disonlinestores1=$scope.sortonlinestores1;
            },function (data) {
                console.log(data);
            });
            //上月全国该时间内全部网店数
            getData.getHttp('select count(distinct storeid) from '+$scope.lastbasesql0+' group by dt').then(function (data){
                $scope.lastonlinestores = data.results.length!=0?data.results[0][0]:null;
                //上半部分网店数
                $scope.lastsortonlinestores= data.results.length!=0?$scope.lastonlinestores:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
                $scope.lastdisonlinestores=data.results.length!=0?$scope.lastsortonlinestores:null;
                //下半部分网店数
                $scope.lastsortonlinestores1= data.results.length!=0?$scope.lastonlinestores:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
                $scope.lastdisonlinestores1=data.results.length!=0?$scope.lastsortonlinestores1:null;
            },function (data) {
                console.log(data);
            });
            //全国该时间内全部软饮销售件数
            getData.getHttp('select sum(salescount) from '+$scope.basesql0+' group by dt').then(function (data){
                $scope.salescount = data.results[0][0];  //全国该时间全部（软饮）产品销售总件数
                //上半部分销售件数
                $scope.sortsalescount=$scope.salescount; //页面初始化时分组默认全部，此处给分组数据赋初始值
                $scope.dissalescount=$scope.sortsalescount;
                //下半部分销售件数
                $scope.sortsalescount1=$scope.salescount; //页面初始化时分组默认全部，此处给分组数据赋初始值
                $scope.dissalescount1=$scope.sortsalescount1;
            },function (data) {
                console.log(data);
            });
            //全国上月内全部软饮销售件数
            getData.getHttp('select sum(salescount) from '+$scope.lastbasesql0+' group by dt').then(function (data){
                $scope.lastsalescount = data.results.length!=0?data.results[0][0]:null;  //全国该时间全部（软饮）产品销售总件数
                //上半部分销售件数
                $scope.lastsortsalescount=data.results.length==0? $scope.lastsalescount:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
                $scope.lastdissalescount=data.results.length==0? $scope.lastsortsalescount:null;
                //下半部分销售件数
                $scope.lastsortsalescount1=data.results.length==0?$scope.lastsalescount:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
                $scope.lastdissalescount1=data.results.length==0?$scope.lastsortsalescount1:null;
            },function (data) {
                console.log(data);
            });
            //全国该时间内KO产品销售件数
            getData.getHttp('select sum(salescount) from '+$scope.basesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
                $scope.ko_salescount = data.results[0][0];  //KO产品销售件数
                console.log('KO产品销售件数',$scope.ko_salescount);
                $scope.sortko_salescount=$scope.ko_salescount;//页面初始化时分组默认全部，此处给分组数据赋初始值
            },function (data) {
                console.log(data);
            });
            //全国上月内KO产品销售件数
            getData.getHttp('select sum(salescount) from '+$scope.lastbasesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
                $scope.lastko_salescount = data.results.length!=0?data.results[0][0]:null;  //KO产品销售件数
                console.log('上月KO产品销售件数',$scope.ko_salescount);
                $scope.lastsortko_salescount=data.results.length!=0?$scope.lastko_salescount:null;//页面初始化时分组默认全部，此处给分组数据赋初始值
            },function (data) {
                console.log(data);
            });
            //全国该时间内全部软饮销售金额
            getData.getHttp('select sum(sales_amount) from '+$scope.basesql0+' group by dt').then(function (data){
                $scope.sales_amount = data.results[0][0];  //全国该时间销售总金额、全部软饮销售总额
                //下半部分销售金额
                $scope.sortsales_amount=$scope.sales_amount;  //页面初始化时分组默认全部，此处给分组数据赋初始值
                $scope.dissales_amount=$scope.sortsales_amount;
                //下半部分销售金额
                $scope.sortsales_amount1=$scope.sales_amount;  //页面初始化时分组默认全部，此处给分组数据赋初始值
                $scope.dissales_amount1=$scope.sortsales_amount1;
            },function (data) {
                console.log(data);
            });
            //全国上月内全部软饮销售金额
            getData.getHttp('select sum(sales_amount) from '+$scope.basesql0+' group by dt').then(function (data){
                $scope.lastsales_amount = data.results.length!=0?data.results[0][0]:null;  //全国该时间销售总金额、全部软饮销售总额
                //下半部分销售金额
                $scope.lastsortsales_amount=data.results.length!=0?$scope.sales_amount:null;  //页面初始化时分组默认全部，此处给分组数据赋初始值
                $scope.lastdissales_amount=data.results.length!=0?$scope.lastsortsales_amount:null;
                //下半部分销售金额
                $scope.lastsortsales_amount1=data.results.length!=0?$scope.lastsales_amount:null;  //页面初始化时分组默认全部，此处给分组数据赋初始值
                $scope.lastdissales_amount1=data.results.length!=0?$scope.lastsortsales_amount1:null;
            },function (data) {
                console.log(data);
            });
            //全国该时间内KO产品销售金额
            getData.getHttp('select sum(sales_amount) from '+$scope.basesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
                $scope.ko_sales_amount = data.results[0][0];  //KO产品销售金额
                //console.log('KO产品销售金额',$scope.ko_sales_amount);
                $scope.sortko_sales_amount=$scope.ko_sales_amount; //页面初始化时分组默认全部，此处给分组数据赋初始值
            },function (data){
                console.log(data);
            });
            //全国上个月内KO产品销售金额
            getData.getHttp('select sum(sales_amount) from '+$scope.lastbasesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
                $scope.lastko_sales_amount = data.results.length!=0?data.results[0][0]:null;  //KO产品销售金额
                //console.log('KO产品销售金额',$scope.ko_sales_amount);
                $scope.lastsortko_sales_amount=data.results.length!=0?$scope.lastko_sales_amount:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
            },function (data) {
                console.log(data);
            });
//分组后数据
            //线下总门店数
            // getData.getHttp('select count(distinct storeid)*3 from '+$scope.basesql0+'group by dt').then(function (data){
            //     //上部分线下门店数
            //     $scope.offlinestores = data.results[0][0];
            //     $scope.sortofflinestores= $scope.offlinestores;
            //     //下部分线下门店数
            //     $scope.offlinestores1 = data.results[0][0];
            //     $scope.sortofflinestores1= $scope.offlinestores1;
            // },function (data) {
            //     console.log(data);
            // });
            // //TOP 10
            // getData.getHttp('select sum(salescount) from '+$scope.basesql0+' group by dt').then(function (data){
            //     $scope.kotopten = data.results[0][0];  //KO TOP 10
            //     //console.log('KO TOP 10',$scope.kotopten);
            // },function (data) {
            //     console.log(data);
            // });
            // getData.getHttp('select pinpai,sum(salescount),level from '+$scope.basesql0+' group by dt,pinpai,level order by sum(salescount) desc limit 10').then(function (data){
            //     $scope.competopten = data.results;  //竞品 TOP 10
            //     //console.log('竞品 TOP 10',$scope.competopten);
            // },function (data) {
            //     console.log(data);
            // });

            getData.getHttp('select count(*) from (select storeid,count(distinct storeid) from '+$scope.basesql0+' group by storeid,dt)').then(function (data){
                $scope.order_count = data.results[0][0];  //线上在售网店总订单数
                console.log('线上在售网店总订单数',$scope.order_count);
            },function (data) {
                console.log(data);
            });

            getData.getHttp('select count(*) from '+$scope.basesql0+' group by dt').then(function (data){
                $scope.online_pro_count = data.results[0][0];  //线上在售产品总数量
                //console.log('线上在售产品总数量',$scope.online_pro_count);
            },function (data) {
                console.log(data);
            });
            console.log('select sum(on_sale) from '+$scope.basesql0+' group by dt');
            getData.getHttp('select sum(on_sale) from '+$scope.basesql0+' group by dt').then(function (data){

                $scope.discount_count = data.results[0][0];  //每件产品实际销售价格
                //console.log('折扣产品数量',$scope.discount_count);
            },function (data) {
                console.log(data);
            });
            getData.getHttp('select sum(dis) from '+$scope.basesql0+' group by dt').then(function (data){
                $scope.online_pro_count = data.results[0][0];  //折扣产品的差价
                //console.log('折扣产品的差价',$scope.online_pro_count);
            },function (data) {
                console.log(data);
            });
            $scope.forbid = false;//控制禁止
//             $scope.deepbrandcheckChang = function (fig) {
//                 switch (fig) {
//                     case 2:
//                         $scope.deepbrandcheck = 'manufacturer';
//                         $scope.total = $scope.menuList;
//                         break;
//                     case 3:
//                         $scope.deepbrandcheck = 'brand';
//                         $scope.total = $scope.brandList;
//                         break;
//                     default:
//                         $scope.deepbrandcheck = 'catalog';
//                         $scope.total = $scope.categoryList;
//                         break;
// //                case 4:
// //                    $scope.deepbrandcheck = 'capacity';
// //                    break;
// //                case 5:
// //                    $scope.deepbrandcheck = 'bottle';
// //                    break;
//                 }
//             };

        },function (data) {
            console.log(data);
        });
        $scope.checkall=function(all){
            if(all=='groupall'){
                console.log('groupall',$scope.groupallcheck);
                $scope.groupallchecked=$scope.groupallchecked=='1' ? 0 : 1;
            }
            if(all=='factoryall'){
                $scope.factoryallcheck=$scope.factoryallcheck=='1' ? 0 : 1;
            }
            if(all=='cityall'){
                $scope.cityallcheck=$scope.cityallcheck=='1' ? 0 : 1;
            }
            if(all=='city_levelall'){
                $scope.city_levelallcheck=$scope.city_levelallcheck=='1' ? 0 : 1;
            }
            if(all=='channelall'){
                $scope.channelallcheck=$scope.channelallcheck=='1' ? 0 : 1;
            }
            if(all=='platformall'){
                $scope.platformallcheck=$scope.platformallcheck=='1' ? 0 : 1;
            }
            if(all=='categoryall'){
                $scope.categoryallcheck=$scope.categoryallcheck=='1' ? 0 : 1;
            }
            if(all=='manuall'){
                $scope.manuallcheck=$scope.manuallcheck=='1' ? 0 : 1;
            }
            if(all=='brandall'){
                $scope.brandallcheck=$scope.brandallcheck=='1' ? 0 : 1;
            }
            if(all=='capacityall'){
                $scope.capacityallcheck=$scope.capacityallcheck=='1' ? 0 : 1;
            }
            if(all=='bottleall'){
                $scope.bottleallcheck=$scope.bottleallcheck=='1' ? 0 : 1;
            }
        }
        //全选
        $scope.cancelSelect = function (type, boo) {
            console.log();
            switch (type) {
                case "areacheck"://区域
                    switch ($scope.deepgroupcheck) {
                        case 'group':
                            angular.forEach($scope.zpjtlist,function (item,index,array) {
                                $scope.zpjtlist[index].checked=boo;
                                // console.log($scope.zpjtlist[index][0]);
                                if(boo==1){
                                    $scope.condition1 = $scope.condition1.replace(')', ',\''+$scope.zpjtlist[index][0]+'\''+')');
                                }
                                else{
                                    let word=',\''+$scope.zpjtlist[index][0]+'\'';
                                    let word0='\''+$scope.zpjtlist[index][0]+'\'';
                                    $scope.condition1 = $scope.condition1.replace(new RegExp(word,'g'),"");
                                    $scope.condition1 = $scope.condition1.replace(new RegExp(word0,'g'),"");
                                    $scope.condition1=$scope.condition1.replace('in ()','in ('+'\'\')');
                                }
                            });
                            break;
                        case 'factory':
                            angular.forEach($scope.zpclist,function (item,index,array) {
                                $scope.zpclist[index].checked=boo;
                                if(boo==1){
                                    $scope.condition1 = $scope.condition1.replace(')', ',\''+$scope.zpclist[index][0]+'\''+')');
                                }
                                else {
                                    let word=',\''+$scope.zpclist[index][0]+'\'';
                                    let word0='\''+$scope.zpclist[index][0]+'\'';
                                    $scope.condition1 = $scope.condition1.replace(new RegExp(word,'g'),"");
                                    $scope.condition1 = $scope.condition1.replace(new RegExp(word0,'g'),"");
                                }
                                $scope.condition1=$scope.condition1.replace('in ()','in ('+'\'\')');
                            });
                            break;
                        case 'city':
                            angular.forEach($scope.citylist,function (item,index,array) {
                                $scope.citylist[index].checked=boo;
                                if(boo){
                                    $scope.condition1 = $scope.condition1.replace(')', ',\''+$scope.citylist[index][0]+'\''+')');
                                }
                                else {
                                    let word=',\''+$scope.citylist[index][0]+'\'';
                                    $scope.condition1 = $scope.condition1.replace(new RegExp(word,'g'),"");
                                    $scope.condition1=$scope.condition1.replace('in ()','in ('+'\'\')');

                                }
                            });
                            break;
                    }
                    break;
                case "brandcheck"://品类、制造商、品牌
                    switch ($scope.deepbrandcheck) {
                        case 'catalog':   //品类
                            angular.forEach($scope.typelist,function (item,index,array) {
                                $scope.typelist[index].checked=boo;
                                if(boo==1){
                                    $scope.condition4= $scope.condition4.replace(')', ',\''+$scope.typelist[index][0]+'\''+')');
                                }
                                else {
                                    let word=',\''+$scope.typelist[index][0]+'\'';
                                    $scope.condition4 = $scope.condition4.replace(new RegExp(word,'g'),"");
                                    $scope.condition4=$scope.condition4.replace('in ()','in ('+'\'\')');
                                }
                            });
                            break;
                        case 'manufacturer':   //制造商
                            angular.forEach($scope.manulist,function (item,index,array) {
                                $scope.manulist[index].checked=boo;
                                if(boo==1){
                                    $scope.condition4= $scope.condition4.replace(')', ',\''+$scope.manulist[index][0]+'\''+')');
                                }
                                else{
                                    let word=',\''+$scope.manulist[index][0]+'\'';
                                    $scope.condition4 = $scope.condition4.replace(new RegExp(word,'g'),"");
                                    $scope.condition4=$scope.condition4.replace('in ()','in ('+'\'\')');
                                }
                            });
                            break;
                        case 'brand':   //品牌
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                $scope.pinpailist[index].checked=boo;
                                if(boo==1){
                                    $scope.condition4= $scope.condition4.replace(')', ',\''+$scope.pinpailist[index][0]+'\''+')');
                                }
                                else {
                                    let word=',\''+$scope.pinpailist[index][0]+'\'';
                                    $scope.condition4 = $scope.condition4.replace(new RegExp(word,'g'),"");
                                    $scope.condition4=$scope.condition4.replace('in ()','in ('+'\'\')');
                                }
                            });
                            break;
                    }
                    break;
                case "systemcheck"://渠道
                    angular.forEach($scope.channellist, function (data, index, array) {
                        $scope.platforms[index]['checked'] = boo;
                        if(boo){
                            $scope.condition2 = $scope.condition2.replace(')', ',\''+$scope.platforms[index][0]+'\''+')');
                        }
                        else {
                            let word=',\''+$scope.platforms[index][0]+'\'';
                            $scope.condition2 = $scope.condition2.replace(new RegExp(word,'g'),"");
                            $scope.condition2=$scope.condition2.replace('in ()','in ('+'\'\')');
                        }
                    });
                    break;
                case "platformcheck"://平台
                    angular.forEach($scope.platformlist, function (data, index, array) {
                        $scope.platformlist[index]['checked'] = boo;
                        if(boo){
                            $scope.condition3= $scope.condition3.replace(')', ',\''+$scope.platformlist[index][0]+'\''+')');
                        }
                        else {
                            let word=',\''+$scope.platformlist[index][0]+'\'';
                            $scope.condition3 = $scope.condition3.replace(new RegExp(word,'g'),"");
                            $scope.condition3=$scope.condition3.replace('in ()','in ('+'\'\')');

                        }
                    });
                    break;
                case "cityLevelListcheck"://城市等级
                    angular.forEach($scope.cityclasslist,function (item,index,array) {
                        $scope.cityclasslist[index].checked=boo;
                        if(item.checked){
                            $scope.citylevelcon = $scope.citylevelcon.replace(')', ',\''+$scope.cityclasslist[index][0]+'\''+')');
                        }
                        else {
                            let word=',\''+$scope.cityclasslist[index][0]+'\'';
                            let word0='\''+$scope.cityclasslist[index][0]+'\'';
                            $scope.citylevelcon = $scope.citylevelcon.replace(new RegExp(word,'g'),"");
                            $scope.citylevelcon = $scope.citylevelcon.replace(new RegExp(word0,'g'),"\'\'");
                            $scope.citylevelcon=$scope.citylevelcon.replace('in ()','in ('+'\'\')');
                        }
                    });
                    break;
                case "gradingListcheck"://分级
                    switch ($scope.deepgradingcheck) {
                        case "capacity"://容量分级
                        case "capacity"://容量分级
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                $scope.capacitylist[index].checked=boo;
                            });
                            break;
                        case "bottle"://瓶量分级
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                $scope.bottlelist[index].checked=boo;
                            });
                            break;
                    }
                    break;
            }
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            // if(iscityleveltype==0){
            //     $scope.citylevelcon='';
            //     $scope.sql1=$scope.queryfield+$scope.condition1+$scope.citylevelcon+$scope.condition2+$scope.condition3+$scope.condition4+$scope.condition5+$scope.groupbyfield;
            //     $scope.sql1=$scope.sql1.replace(',city_level','');
            // }
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            console.log('$scope.queryfield',$scope.groupbyfield);
            $scope.orderbyfield=$scope.groupbyfield.replace('group',' order');
            $scope.sql1=$scope.queryfield+$scope.condition1+$scope.citylevelcon+$scope.condition2+$scope.condition3+$scope.condition4+$scope.condition5+$scope.groupbyfield+$scope.orderbyfield;
            $scope.sql1=$scope.sql1.replace('(,','(');
            // console.log('$scope.sql1测试子选项chkcheck',$scope.sql1);
            getData.getHttp($scope.sql1).then(function (data){
                var temp = data.results;
                var arr = [];
                for (var i = 0; i < temp.length; i++) {
                    let ai = temp[i];
                    var group='';
                    //容量分级和瓶量分级均未选择
                    if(isgrading==0){

                        group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]; //装瓶集团（装瓶厂、城市）- 全部（城市等级） - 渠道 - 平台
                        // console.log(group);
                        if(iscityleveltype==1){
                            group = ai[1] + '-' + ai[4] + '-' + ai[2] + '-' + ai[3]; //装瓶集团（装瓶厂、城市）- 城市等级 - 渠道 - 平台
                        }
                    }
                    //选择了容量分级或瓶量分级
                    else{
                        group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]+ '-' +ai[0]; //装瓶集团（装瓶厂、城市）-全部（城市等级）-渠道-平台-品类（制造商、品牌）
                        if(iscityleveltype==1){
                            group = ai[1] + '-' + ai[4] + '-' + ai[2] + '-' + ai[3]+ '-' +ai[0];//装瓶集团（装瓶厂、城市）-城市等级-渠道-平台-品类（制造商、品牌）
                        }
                    }
                    var map = {};
                    arr.push({
                        'groupname': group,
                    });
                }
                var output = [],
                    keys = [];
                angular.forEach(arr, function (item) {
                    var key = item.groupname;
                    if (keys.indexOf(key) === -1) {
                        keys.push(key);
                        output.push(item);
                        // console.log(output);
                    }
                });
                $scope.bardata1 = output;
                // console.log('测试ya',$scope.bardata1);
                switch($scope.visitab){
                    case 'distribution':
                    case 'price_promotion_ratio':
                    case 'average_discount_factor':
                        angular.forEach($scope.bardata1,function (item,i,array) {
                            $scope.test(item.groupname,i);
                        });
                        break;
                    case 'distribution_store':
                        $scope.setstackbaroption('distribution_store');
                        break;
                }
            },function (data) {
                console.log(data);
            });
            //$scope.getBarData("", true);
            //$scope.getChartsData();
        };
        $scope.forbid = false;//控制禁止
        $scope.deepbrandcheckChang = function (fig) {
            switch (fig) {
                case 2:
                    $scope.deepbrandcheck = 'manufacturer';
                    $scope.total = $scope.menuList;
                    break;
                case 3:
                    $scope.deepbrandcheck = 'brand';
                    $scope.total = $scope.brandList;
                    break;
                default:
                    $scope.deepbrandcheck = 'catalog';
                    $scope.total = $scope.categoryList;
                    break;
//                case 4:
//                    $scope.deepbrandcheck = 'capacity';
//                    break;
//                case 5:
//                    $scope.deepbrandcheck = 'bottle';
//                    break;
            }
        };
        $scope.deepgroupcheckChang = function () {
            switch ($scope.deepgroupcheck) {
                case 'factory':
                    angular.forEach($scope.zpjtlist,function (item,index,array) {
                        $scope.zpjtlist[index].checked=1;
                    });
                    angular.forEach($scope.citylist,function (item,index,array) {
                        $scope.citylist[index].checked=0;
                    });
                    break;
                case 'city':
                    angular.forEach($scope.zpclist,function (item,index,array) {
                        $scope.zpclist[index].checked=0;
                    });
                    angular.forEach($scope.zpjtlist,function (item,index,array) {
                        $scope.zpjtlist[index].checked=1;
                    });
                    break;
                default:
                    angular.forEach($scope.zpclist,function (item,index,array) {
                        $scope.zpclist[index].checked=0;
                    });
                    angular.forEach($scope.citylist,function (item,index,array) {
                        $scope.citylist[index].checked=0;
                    });
                    break;
            }
            switch ($scope.deepbrandcheck) {
                case 'manufacturer':
                    angular.forEach($scope.typelist,function (item,index,array) {
                        $scope.typelist[index].checked=1;
                    });
                    angular.forEach($scope.pinpailist,function (item,index,array) {
                        $scope.pinpailist[index].checked=0;
                    });
                    break;
                case 'brand':
                    angular.forEach($scope.typelist,function (item,index,array) {
                        $scope.typelist[index].checked=1;
                    });
                    angular.forEach($scope.manulist,function (item,index,array) {
                        $scope.manulist[index].checked=0;
                    });
                    break;
                default:
                    angular.forEach($scope.manulist,function (item,index,array) {
                        $scope.manulist[index].checked=0;
                    });
                    angular.forEach($scope.pinpailist,function (item,index,array) {
                        $scope.pinpailist[index].checked=0;
                    });
                    break;
            }
        };


        // 上半部分逻辑控制
        $("#myselect").find("option[value='1']").prop("selected", true);//设置或返回
        $scope.getDataType = function () {
            switch ($scope.myselect){
                case "0" :  //月值
                    $scope.stage = 0;
                    $("#Search_stage").find("option[value='0']").prop("selected", true);
                    break;
                case "-1" :  //YTD
                    $scope.stage = -1;
                    $("#Search_stage").find("option[value='-1']").prop("selected", true);
                    break;
            }
            // console.log("头部下拉框选中的值：", $scope.myselect);
        };
        //初始化需参与计算的变量
        //请求表名
//         $scope.gettable=function() {
//             $.ajax({
//                 type: "GET",
//                 url: "http://192.168.10.211:7070/kylin/api/tables_and_columns",
//                 headers: {'Content-Type':'application/json;charset=UTF-8','Authorization':'Basic YWRtaW46S1lMSU4='},
//                 data: {
//                     project:'O2O_retail'
//                 },
//                 success: function (data) {
// //                console.log("测试",JSON.parse(data));
//                     console.log("测试",data);
//                     $scope.skutable=new Array();
//                     $scope.timelist = new Array();
//                     $scope.month=data[0].table_NAME.substr(4,9);
//                     angular.forEach(data,function (date) {
//                         let temp=date.table_NAME;
//                         if(temp.indexOf("STORES") < 0){
//                             $scope.skutable.push(date.table_NAME);
//                             let timelistitem=date.table_NAME.substr(4,9);
//                             $scope.timelist.push(timelistitem);
//                         }
//                     });
//                     console.log("测试",$scope.timelist);
//                 },
//                 error: function (e) {
//                     alert(e);
//                 }
//             });
//         }
//         $scope.gettable();

        //地图数据改变
        $scope.map=function(info) {
            var cityLevel = $("#Search_cityLevel").val();
            var ditch = $("#Search_channel").val();
            var platform = $("#Search_platform").val();
            var category = $("#Search_type").val();
            var month = $("#Search_month").val();
            var stage = $("#Search_stage").val();
            var info =
                setMap(true, info);
            console.log('地图数据改变是否执行了');
            setMap(true, info);
        };
        $scope.setmapdata=function(){
            //请求地图数据
            $scope.mapdata=[];
            $scope.specialmapdata=[
                ["1", "全部", "107.764827,36.104582", "-0.03662514475791262", "1", "1", "全部"],
                ["1", "太古", "117.720126,30.896448", "0.17722025558093585", "1", "2", "太古"],
                ["1", "中可", "109.897861,37.608898", "0.10325467512314646", "1", "3", "中可"],
                ["2", "粤西", "112.02872,23.557816", "-0.23494569355151212", "1", "9", "粤西"],
                ["2", "粤东", "116.02872,23.557816", "0.0719237636513298", "1", "10", "粤东"]];
            $scope.count=0;
            var zpjtreg=new RegExp('zpjt','g');
            let zpcbasesql=$scope.basesql.replace(zpjtreg,'zpc');
            let citybasesql=$scope.basesql.replace(zpjtreg,'city');
            var lastreg0=new RegExp('XYZ','g');
            var lastreg1=new RegExp('XYZ','g');
            if($scope.month=='2018-12-01'){
                 lastreg0=new RegExp('2018-12-01','g');
                 lastreg1=new RegExp('2019-01-0','g');
            }
            var length0=0;
            //装瓶集团
            let zpjtsql='select zpjt,sum(salescount) from ' + $scope.basesql+' where city_level='+'\''+$scope.city_level1+'\' and channel='+'\''+$scope.channel1+'\' and platform='+'\''+$scope.platform1+'\' and type='+'\''+$scope.type1+'\' group by zpjt order by zpjt desc';
            let zpjtsql0='select sum(salescount) from ' + $scope.basesql+' where city_level='+'\''+$scope.city_level1+'\' and channel='+'\''+$scope.channel1+'\' and platform='+'\''+$scope.platform1+'\' ';
            console.log('zpjtsql',zpjtsql);
            let lastzpjtsql=zpjtsql.replace(lastreg0,'2018-11-01');
            lastzpjtsql=lastzpjtsql.replace(lastreg1,'2018-12-0');
            let lastzpjtsql0=zpjtsql0.replace(lastreg0,'2018-11-01');
            lastzpjtsql0=lastzpjtsql0.replace(lastreg1,'2018-12-0');
            getData.getHttp(zpjtsql0).then(function (data0){
                var salesamount=data0.results[0][0];
                getData.getHttp(lastzpjtsql0).then(function (data1){
                    var lastsalesamount=data1.results[0][0];
                    getData.getHttp(lastzpjtsql).then(function (data2){
                        let lastzpjtlist_map = data2.results;
                        getData.getHttp(zpjtsql).then(function (data){
                            let zpjtlist_map = data.results;
                            length0=zpjtlist_map.length;
                            for(var i=0;i<length0;i++){
                                let name=zpjtlist_map[i][0];
                                $scope.mapdata[$scope.count]=[];
                                $scope.mapdata[$scope.count].push('1');
                                $scope.mapdata[$scope.count].push(zpjtlist_map[i][0]);
                                $scope.mapdata[$scope.count].push(zpjtlist_map[i][1]/salesamount-lastzpjtlist_map[i][1]/lastsalesamount);
                                $scope.mapdata[$scope.count].push('1');
                                $scope.mapdata[$scope.count].push('0');
                                $scope.mapdata[$scope.count].push(name);
                                $scope.count++;
                                if(name=='全部'){
                                    $scope.specialmapdata[0][3]=zpjtlist_map[i][1]/salesamount-lastzpjtlist_map[i][1]/lastsalesamount;
                                }
                                else if(name=='SCCL'){
                                    $scope.specialmapdata[1][3]=zpjtlist_map[i][1]/salesamount-lastzpjtlist_map[i][1]/lastsalesamount;
                                }
                                else if(name=='ZH'){
                                    $scope.specialmapdata[2][3]=zpjtlist_map[i][1]/salesamount-lastzpjtlist_map[i][1]/lastsalesamount;
                                }

                            }},function (data) {
                            console.log(data);
                        });
                       },function (data) {
                        console.log(data);
                    });


                });

                },function (data) {
                console.log(data);
            });
            //装瓶厂
            let zpcsql='select zpc,sum(salescount) from ' + zpcbasesql+' where city_level='+'\''+$scope.city_level1+'\' and channel='+'\''+$scope.channel1+'\' and platform='+'\''+$scope.platform1+'\' and type='+'\''+$scope.type1+'\' group by zpc order by zpc desc';
            let zpcsql0='select sum(salescount) from ' + zpcbasesql+' where city_level='+'\''+$scope.city_level1+'\' and channel='+'\''+$scope.channel1+'\' and platform='+'\''+$scope.platform1+'\' and type='+'\''+$scope.type1+'\'';
            //上一期或上月
            let lastzpcsql=zpcsql.replace(lastreg0,'2018-11-01');
            lastzpcsql=lastzpcsql.replace(lastreg1,'2018-12-0');
            let lastzpcsql0=zpcsql0.replace(lastreg0,'2018-11-01');
            lastzpcsql0=lastzpcsql0.replace(lastreg1,'2018-12-0');

            getData.getHttp(zpcsql0).then(function (data0){
                var salesamount=data0.results[0][0];
                getData.getHttp(lastzpcsql0).then(function (data1){
                    var lastsalesamount=data1.results[0][0];
                    getData.getHttp(lastzpcsql).then(function (data2){
                        let lastzpclist_map = data2.results;
                        getData.getHttp(zpcsql).then(function (data){
                            let zpclist_map = data.results;
                            length0=zpclist_map.length;
                            for(var i=0;i<length0;i++){
                                let name=zpclist_map[i][0];
                                $scope.mapdata[$scope.count]=[];
                                $scope.mapdata[$scope.count].push('1');
                                $scope.mapdata[$scope.count].push(zpclist_map[i][0]);
                                $scope.mapdata[$scope.count].push(zpclist_map[i][1]/salesamount-lastzpclist_map[i][1]/lastsalesamount);
                                $scope.mapdata[$scope.count].push('1');
                                $scope.mapdata[$scope.count].push('0');
                                $scope.mapdata[$scope.count].push(name);
                                $scope.count++;
                                if(name=='粤西'){
                                    $scope.specialmapdata[3][3]=zpclist_map[i][1]/salesamount-lastzpclist_map[i][1]/lastsalesamount;
                                }
                                else if(name=='粤东'){
                                    $scope.specialmapdata[4][3]=zpclist_map[i][1]/salesamount-lastzpclist_map[i][1]/lastsalesamount;
                                }

                            }},function (data) {
                            console.log(data);
                        });
                    },function (data) {
                        console.log(data);
                    });


                });
            },function (data) {
                console.log(data);
            });
            //城市
            let citysql='select city,sum(salescount) from ' + citybasesql+' where city_level='+'\''+$scope.city_level1+'\' and channel='+'\''+$scope.channel1+'\' and platform='+'\''+$scope.platform1+'\' and type='+'\''+$scope.type1+'\' group by city order by city desc';
            let citysql0='select sum(salescount) from ' + citybasesql+' where city_level='+'\''+$scope.city_level1+'\' and channel='+'\''+$scope.channel1+'\' and platform='+'\''+$scope.platform1+'\' and type='+'\''+$scope.type1+'\'';
            let lastcitysql=citysql.replace(lastreg0,'2018-11-01');
            lastcitysql=lastcitysql.replace(lastreg1,'2018-12-0');
            let lastcitysql0=citysql0.replace(lastreg0,'2018-11-01');
            lastcitysql0=lastcitysql0.replace(lastreg1,'2018-12-0');

            getData.getHttp(citysql0).then(function (data0){
                var salesamount=data0.results[0][0];
                getData.getHttp(lastcitysql0).then(function (data1){
                    var lastsalesamount=data1.results[0][0];
                    getData.getHttp(lastcitysql).then(function (data2){
                        let lastcitylist_map = data2.results;
                        getData.getHttp(citysql).then(function (data){
                            let citylist_map = data.results;
                            length0=citylist_map.length;
                            for(var i=0;i<length0;i++){
                                let name=citylist_map[i][0];
                                $scope.mapdata[$scope.count]=[];
                                $scope.mapdata[$scope.count].push('1');
                                $scope.mapdata[$scope.count].push(citylist_map[i][0]);
                                $scope.mapdata[$scope.count].push(citylist_map[i][1]/salesamount-lastcitylist_map[i][1]/lastsalesamount);
                                $scope.mapdata[$scope.count].push('1');
                                $scope.mapdata[$scope.count].push('0');
                                $scope.mapdata[$scope.count].push(name);
                                $scope.count++;
                            }
                            let mapdata=$scope.mapdata;
                            let specialmapdata=$scope.specialmapdata;
                            setMap(false, mapdata,specialmapdata);
                            },function (data) {
                            console.log(data);
                        });
                    },function (data) {
                        console.log(data);
                    });
                });
            },function (data) {
                console.log(data);
            });
        };
        $scope.setmapdata();
        //筛选条件改变
      //  $scope.setmapdata();
        var date = new Date($scope.month);
        $scope.lastmonth=''+date.getFullYear()+'-'+(date.getMonth())+'-'+'01'; //表示上一个月的开始日期
        console.log('$scope.lastmonth',$scope.lastmonth);
        $scope.getbasesql=function(param1,param2){
            let ko_forall=$scope.zpjt1=='全部'?'(select \'全部\' zpjt,':'(select zpjt,';
            ko_forall+=($scope.zpc1=='全部'?'\'全部\' zpc,':'zpc,');
            ko_forall+=($scope.city_level1=='全部'?'\'全部\' city_level,':'city_level,');
            ko_forall+=($scope.city1=='全部'?'\'全部\' city,':'city,');
            ko_forall+=($scope.channel1=='全部'?'\'全部\' channel,':'channel,');
            ko_forall+=($scope.platform1=='全部'?'\'全部\' platform,':'platform,');
            ko_forall+=($scope.type1=='全部'?'\'全部\' type,':'type,');

            ko_forall+=(param1+' from sku_2018 where dt=\''+$scope.month+'\' and is_ko=1'); //KO销售金额，由于门店表没有is_ko字段，这里暂时使用sku中的storeid
            //  let nartd_forallsql+=('sum(sales_amount) sales_amount from sku_2018 where dt=\''+$scope.month+'\''); //全部软饮销售金额
            // ko_forallsql+=('count(distinct id) id from stores_2018 where dt=\''+$scope.month+'\'');//网店数
            if(!($scope.zpjt1=='全部'&&$scope.zpc1=='全部'&&$scope.city_level1=='全部'&&$scope.city1=='全部'&&$scope.channel1=='全部'&&$scope.platform1=='全部'&&$scope.type1=='全部')){
                ko_forall+=' group by ';
                ko_forall+=($scope.zpjt1=='全部'?'':'zpjt,');
                ko_forall+=($scope.zpc1=='全部'?'':'zpc,');
                ko_forall+=($scope.city_level1=='全部'?'':'city_level,');
                ko_forall+=($scope.city1=='全部'?'':'city,');
                ko_forall+=($scope.channel1=='全部'?'':'channel,');
                ko_forall+=($scope.platform1=='全部'?'':'platform,');
                ko_forall+=($scope.type1=='全部'?'':'type,');
                ko_forall=ko_forall.replace(/(.*)[,，]$/, '$1');
            }
             // let ko_forallsql='select ' +param2 +' from'+ko_forall+') where zpjt=\''+$scope.zpjt1+'\' and zpc='+'\''+$scope.zpc1+'\' and city='+'\''+$scope.city1+'\' and city_level='+'\''+$scope.city_level1+'\' and channel='+'\''+$scope.channel1+'\'and platform='+'\''+$scope.platform1+'\'and type='+'\''+$scope.type1+'\'';
             let ko_forallsql='select ' +param2 +' from'+ko_forall+')';

            //  let nartd_forallsql=ko_forallsql.replace('and is_ko=1',''); //全部软饮销售金额
            return ko_forallsql;
        }
        $scope.getlastmonthdata=function(thismonthdatasql){
            let lastdatasql=0;
            if($scope.month!='2018-11-0'){
                var reg=new RegExp($scope.month,'g');
                lastdatasql=thismonthdatasql.replace(reg,$scope.lastmonth);
            }
            else lastdatasql=0;
            return lastdatasql;
        }
        $scope.onoptionchange = function(level){
            if(level=='0'){
                if($scope.month!='2018-11-01'){
                    var date = new Date($scope.month);
                    $scope.lastmonth=''+date.getFullYear()+'-'+(date.getMonth())+'-01'; //表示上一个月的开始日期
                }
                else{
                    $scope.lastmonth=$scope.month;
                }
                $scope.basesql0='(select * from sku_2018 where dt ='+'\''+$scope.month+'\')';
                $scope.lastbasesql0='(select * from sku_2018 where dt ='+'\''+$scope.lastmonth+'\')';
                // console.log('lastbasesql0',$scope.month);
                //重新请求数据
                //全国该时间内线上在售任一KO产品的网店数
                getData.getHttp('select count(distinct storeid_copy) from '+$scope.basesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
                    $scope.ko_onlinestores = data.results[0][0];
                    //console.log('任一KO产品的网店数',$scope.ko_onlinestores);
                    $scope.sortko_onlinestores=$scope.ko_onlinestores; //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.sortko_onlinestores2=$scope.ko_onlinestores; //饼图
                    $scope.disko_onlinestores=$scope.sortko_onlinestores;
                },function (data) {
                    console.log(data);
                });
                //上月
                getData.getHttp('select count(distinct storeid_copy) from '+$scope.lastbasesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
                    //console.log('任一KO产品的网店数','select count(distinct storeid_copy) from '+$scope.lastbasesql0+' where is_ko=1 group by is_ko,dt');
                    $scope.lastko_onlinestores = data.results.length!=0?data.results[0][0]:null;
                    //console.log('任一KO产品的网店数',$scope.ko_onlinestores);
                    $scope.lastsortko_onlinestores=data.results.length!=0?$scope.lastko_onlinestores:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
                },function (data) {
                    console.log(data);
                });
                //全国该时间内全部网店数
                console.log('$scope.basesql',$scope.basesql0);
                getData.getHttp('select count(distinct storeid) from '+$scope.basesql0+' group by dt').then(function (data){
                    $scope.onlinestores = data.results[0][0];
                    //上半部分网店数
                    $scope.sortonlinestores= $scope.onlinestores; //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.disonlinestores=$scope.sortonlinestores;
                    //下半部分网店数
                    $scope.sortonlinestores1= $scope.onlinestores; //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.disonlinestores1=$scope.sortonlinestores1;
                },function (data) {
                    console.log(data);
                });
                //上月全国该时间内全部网店数
                getData.getHttp('select count(distinct storeid) from '+$scope.lastbasesql0+' group by dt').then(function (data){
                    $scope.lastonlinestores = data.results.length!=0?data.results[0][0]:null;
                    //上半部分网店数
                    $scope.lastsortonlinestores= data.results.length!=0?$scope.lastonlinestores:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.lastdisonlinestores=data.results.length!=0?$scope.lastsortonlinestores:null;
                    //下半部分网店数
                    $scope.lastsortonlinestores1= data.results.length!=0?$scope.lastonlinestores:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.lastdisonlinestores1=data.results.length!=0?$scope.lastsortonlinestores1:null;
                },function (data) {
                    console.log(data);
                });
                //全国该时间内全部软饮销售件数
                getData.getHttp('select sum(salescount) from '+$scope.basesql0+' group by dt').then(function (data){
                    $scope.salescount = data.results[0][0];  //全国该时间全部（软饮）产品销售总件数
                    //上半部分销售件数
                    $scope.sortsalescount=$scope.salescount; //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.dissalescount=$scope.sortsalescount;
                    //下半部分销售件数
                    $scope.sortsalescount1=$scope.salescount; //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.dissalescount1=$scope.sortsalescount1;
                },function (data) {
                    console.log(data);
                });
                //全国上月内全部软饮销售件数
                getData.getHttp('select sum(salescount) from '+$scope.lastbasesql0+' group by dt').then(function (data){
                    $scope.lastsalescount = data.results.length!=0?data.results[0][0]:null;  //全国该时间全部（软饮）产品销售总件数
                    //上半部分销售件数
                    $scope.lastsortsalescount=data.results.length!=0?$scope.lastsalescount:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.lastdissalescount=data.results.length!=0?$scope.lastsortsalescount:null;
                    //下半部分销售件数
                    $scope.lastsortsalescount1=data.results.length!=0?$scope.lastsalescount:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.lastdissalescount1=data.results.length!=0?$scope.lastsortsalescount1:null;
                },function (data) {
                    console.log(data);
                });
                //全国该时间内KO产品销售件数
                getData.getHttp('select sum(salescount) from '+$scope.basesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
                    $scope.ko_salescount = data.results[0][0];  //KO产品销售件数
                    console.log('KO产品销售件数',$scope.ko_salescount);
                    $scope.sortko_salescount=$scope.ko_salescount;//页面初始化时分组默认全部，此处给分组数据赋初始值
                },function (data) {
                    console.log(data);
                });
                //全国上月内KO产品销售件数
                getData.getHttp('select sum(salescount) from '+$scope.lastbasesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
                    $scope.lastko_salescount = data.results.length!=0?data.results[0][0]:null;  //KO产品销售件数
                    console.log('上月KO产品销售件数',$scope.ko_salescount);
                    $scope.lastsortko_salescount=data.results.length!=0?$scope.lastko_salescount:null;//页面初始化时分组默认全部，此处给分组数据赋初始值
                },function (data) {
                    console.log(data);
                });
                //全国该时间内全部软饮销售金额
                getData.getHttp('select sum(sales_amount) from '+$scope.basesql0+' group by dt').then(function (data){
                    $scope.sales_amount = data.results[0][0];  //全国该时间销售总金额、全部软饮销售总额
                    //上半部分销售金额
                    $scope.sortsales_amount=$scope.sales_amount;  //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.dissales_amount=$scope.sortsales_amount;

                    //下半部分销售金额
                    $scope.sortsales_amount1=$scope.sales_amount;  //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.dissales_amount1=$scope.sortsales_amount1;
                },function (data) {
                    console.log(data);
                });
                //全国上月内全部软饮销售金额
                getData.getHttp('select sum(sales_amount) from '+$scope.basesql0+' group by dt').then(function (data){
                    $scope.lastsales_amount = data.results.length!=0?data.results[0][0]:null;  //全国该时间销售总金额、全部软饮销售总额
                    //下半部分销售金额
                    $scope.lastsortsales_amount=data.results.length!=0?$scope.sales_amount:null;  //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.lastdissales_amount=data.results.length!=0?$scope.lastsortsales_amount:null;
                    //下半部分销售金额
                    $scope.lastsortsales_amount1=data.results.length!=0?$scope.lastsales_amount:null;  //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.lastdissales_amount1=data.results.length!=0?$scope.lastsortsales_amount1:null;
                },function (data) {
                    console.log(data);
                });
                //全国该时间内KO产品销售金额
                getData.getHttp('select sum(sales_amount) from '+$scope.basesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
                    $scope.ko_sales_amount = data.results[0][0];  //KO产品销售金额
                    //console.log('KO产品销售金额',$scope.ko_sales_amount);
                    $scope.sortko_sales_amount=$scope.ko_sales_amount; //页面初始化时分组默认全部，此处给分组数据赋初始值
                    $scope.disko_sales_amount=$scope.sortko_sales_amount;
                    $scope.sortsales_amount2=$scope.ko_sales_amount; //饼图
                },function (data) {
                    console.log(data);
                });
                //全国上个月内KO产品销售金额
                getData.getHttp('select sum(sales_amount) from '+$scope.lastbasesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
                    $scope.lastko_sales_amount = data.results.length!=0 ? data.results[0][0]:null;  //KO产品销售金额
                    //console.log('KO产品销售金额',$scope.ko_sales_amount);
                    $scope.lastsortko_sales_amount=data.results.length!=0 ? $scope.lastko_sales_amount:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
                },function (data) {
                    console.log(data);
                });
                $scope.onoptionchange();

                //console.log('month',$scope.month_next);
            }
            //网店上线率分母
            let allstoressql=$scope.zpjt1=='全部'?'(select \'全部\' zpjt,':'(select zpjt,';
            allstoressql+=($scope.zpc1=='全部'?'\'全部\' zpc,':'zpc,');
            allstoressql+=($scope.city_level1=='全部'?'\'全部\' city_level,':'city_level,');
            allstoressql+=($scope.city1=='全部'?'\'全部\' city,':'city,');
            allstoressql+=($scope.channel1=='全部'?'\'全部\' channel,':'channel,');
            let storessql=allstoressql+($scope.platform1=='全部'?'\'全部\' platform,id from stores_2018 where dt=\''+$scope.month+'\'':'platform,id from stores_2018 where dt=\''+$scope.month+'\'');
            allstoressql+=('sum(xxmd) a from xxmd');
            allstoressql+=' group by id,';
            if(!($scope.zpjt1=='全部'&&$scope.zpc1=='全部'&&$scope.city_level1=='全部'&&$scope.city1=='全部'&&$scope.channel1=='全部')){
                allstoressql+=($scope.zpjt1=='全部'?'':'zpjt,');
                allstoressql+=($scope.zpc1=='全部'?'':'zpc,');
                allstoressql+=($scope.city_level1=='全部'?'':'city_level,');
                allstoressql+=($scope.city1=='全部'?'':'city,');
                allstoressql+=($scope.channel1=='全部'?'':'channel,');

            }
            allstoressql=allstoressql.replace(/(.*)[,，]$/, '$1');
            storessql+=' group by id,';
            if(!($scope.zpjt1=='全部'&&$scope.zpc1=='全部'&&$scope.city_level1=='全部'&&$scope.city1=='全部'&&$scope.channel1=='全部'&&$scope.platform1=='全部')){

                storessql+=($scope.zpjt1=='全部'?'':'zpjt,');
                storessql+=($scope.zpc1=='全部'?'':'zpc,');
                storessql+=($scope.city_level1=='全部'?'':'city_level,');
                storessql+=($scope.city1=='全部'?'':'city,');
                storessql+=($scope.channel1=='全部'?'':'channel,');
                storessql+=($scope.platform1=='全部'?'':'platform,');
            }
            storessql=storessql.replace(/(.*)[,，]$/, '$1');
            allstoressql='select a from'+allstoressql+') where zpjt=\''+$scope.zpjt1+'\' and zpc='+'\''+$scope.zpc1+'\' and city='+'\''+$scope.city1+'\' and city_level='+'\''+$scope.city_level1+'\' and channel='+'\''+$scope.channel1+'\'';
            allstoressql=allstoressql.replace('from xxmd group by id','from xxmd');
            storessql='select count(id) from'+storessql+') where zpjt=\''+$scope.zpjt1+'\' and zpc='+'\''+$scope.zpc1+'\' and city='+'\''+$scope.city1+'\' and city_level='+'\''+$scope.city_level1+'\' and channel='+'\''+$scope.channel1+'\' ';

            //and platform='+'\''+$scope.platform1+'\'  分子中是否加平台
            //网店数
            getData.getHttp(storessql).then(function (data){
                 console.log('分子',storessql);
                $scope.stores=data.results[0][0];
            },function (data) {
                console.log(data);
            });
            let laststoressql='';
            //上月网店数
            if($scope.month=='2018-12-01'){
                laststoressql=storessql.replace($scope.month,'2018-11-01');
                console.log('laststoressql',$scope.month);
                getData.getHttp(laststoressql).then(function (data){
                    console.log('分子',data.results[0][0]);
                    $scope.laststores=data.results[0][0];
                },function (data) {
                    console.log(data);
                });
            }
            else{
                $scope.laststores=null;
            }
            //门店订单数
            let storeordernumsql=storessql.replace('count(id)','salecount');
            storeordernumsql=storeordernumsql.replace('id','sum(salecount) salecount');
            storeordernumsql=storeordernumsql.replace('group by id','');
            storeordernumsql=storeordernumsql.replace('xxmd','stores_2018');
            console.log('门店订单数',storeordernumsql);
            getData.getHttp(storeordernumsql).then(function (data){
                console.log('分子0',data.results[0][0]);
                $scope.storeordernum=data.results[0][0];
            },function (data) {
                console.log(data);
            });
            //上月门店订单数
            if($scope.month!='2018-11-01'){
                let laststoreordernumsql=storeordernumsql.replace($scope.month,$scope.lastmonth);
                getData.getHttp(laststoreordernumsql).then(function (data){
                    $scope.laststoreordernum=data.results[0][0];
                },function (data) {
                    console.log(data);
                });
            }
            else{
                $scope.laststoreordernum=null;
            }


            // KO网店数,未使用到
            let ko_storessql=storessql.replace('stores_2018','sku_2018');
            var idreg=new RegExp('id','g');
            ko_storessql=ko_storessql.replace(idreg,'storeid');
            getData.getHttp(ko_storessql).then(function (data){
                // console.log('分子',data.results[0][0]);
                $scope.ko_stores=data.results[0][0];
            },function (data) {
                console.log(data);
            })
//           上月KO网店数(网店数与是否KO无关)
            if($scope.month!='2018-11-01'){
                let lastko_storessql=ko_storessql.replace($scope.month,'2018-11-01');
                getData.getHttp(lastko_storessql).then(function (data){
                    // console.log('分子',data.results[0][0]);
                    $scope.lastko_stores=data.results[0][0];
                },function (data) {
                    console.log(data);
                });
            }
            else{$scope.lastko_stores=null;}


//门店上线率中的分母
            getData.getHttp(allstoressql).then(function (data){
                console.log('分母',allstoressql);
                if($scope.platform1=='全部'){
                    $scope.allstores=data.results[0][0]*3;
                }
                else{
                    $scope.allstores=data.results[0][0];
                }
            },function (data) {
                console.log(data);
            });


            //KO铺货数、KO销售金额份额、KO销售件数份额
            let ko_forall=$scope.zpjt1=='全部'?'(select \'全部\' zpjt,':'(select zpjt,';
            ko_forall+=($scope.zpc1=='全部'?'\'全部\' zpc,':'zpc,');
            ko_forall+=($scope.city_level1=='全部'?'\'全部\' city_level,':'city_level,');
            ko_forall+=($scope.city1=='全部'?'\'全部\' city,':'city,');
            ko_forall+=($scope.channel1=='全部'?'\'全部\' channel,':'channel,');
            ko_forall+=($scope.platform1=='全部'?'\'全部\' platform,':'platform,');
            ko_forall+=($scope.type1=='全部'?'\'全部\' type,':'type,');
            ko_forall+=('sum(sales_amount) sales_amount from sku_2018 where dt=\''+$scope.month+'\' and is_ko=1'); //KO销售金额，由于门店表没有is_ko字段，这里暂时使用sku中的storeid
            //  let nartd_forallsql+=('sum(sales_amount) sales_amount from sku_2018 where dt=\''+$scope.month+'\''); //全部软饮销售金额
            // ko_forallsql+=('count(distinct id) id from stores_2018 where dt=\''+$scope.month+'\'');//网店数
            if(!($scope.zpjt1=='全部'&&$scope.zpc1=='全部'&&$scope.city_level1=='全部'&&$scope.city1=='全部'&&$scope.channel1=='全部'&&$scope.platform1=='全部'&&$scope.type1=='全部')){
                ko_forall+=' group by ';
                ko_forall+=($scope.zpjt1=='全部'?'':'zpjt,');
                ko_forall+=($scope.zpc1=='全部'?'':'zpc,');
                ko_forall+=($scope.city_level1=='全部'?'':'city_level,');
                ko_forall+=($scope.city1=='全部'?'':'city,');
                ko_forall+=($scope.channel1=='全部'?'':'channel,');
                ko_forall+=($scope.platform1=='全部'?'':'platform,');
                ko_forall+=($scope.type1=='全部'?'':'type,');
                ko_forall=ko_forall.replace(/(.*)[,，]$/, '$1');
            }
            //KO 销售金额
            let ko_forallsql='select sales_amount from'+ko_forall+') where zpjt=\''+$scope.zpjt1+'\' and zpc='+'\''+$scope.zpc1+'\' and city='+'\''+$scope.city1+'\' and city_level='+'\''+$scope.city_level1+'\' and channel='+'\''+$scope.channel1+'\'and platform='+'\''+$scope.platform1+'\'and type='+'\''+$scope.type1+'\'';
            let nartd_forallsql=ko_forallsql.replace('and is_ko=1',''); //全部软饮销售金额
            //ko_forallsql='select kostores from'+ko_forallsql+') where zpjt=\''+$scope.zpjt1+'\' and zpc='+'\''+$scope.zpc1+'\' and city='+'\''+$scope.city1+'\' and city_level='+'\''+$scope.city_level1+'\' and channel='+'\''+$scope.channel1+'\'and platform='+'\''+$scope.platform1+'\'';
            //Top10
            let ko_topforall='';
            if(ko_forall.indexOf('group by')>-1){
                ko_topforall=ko_forall+' ,shangpin,pack'
            }
            else{
                ko_topforall=ko_forall+' group by shangpin,pack';
            }
            let ko_topsql='select shangpin,pack,sales_amount from'+ko_topforall.replace('sum','shangpin,pack,sum')+') where zpjt=\''+$scope.zpjt1+'\' and zpc='+'\''+$scope.zpc1+'\' and city='+'\''+$scope.city1+'\' and city_level='+'\''+$scope.city_level1+'\' and channel='+'\''+$scope.channel1+'\'and platform='+'\''+$scope.platform1+'\'and type='+'\''+$scope.type1+'\' order by sales_amount desc limit 10';
            let sku_topsql=ko_topsql.replace('is_ko=1','is_ko=0'); //目前我认为的全部软饮料是不加入is_ko字段的情况
            let nartd_topsql=ko_topsql.replace('and is_ko=1',''); //目前我认为的全部软饮料是不加入is_ko字段的情况

            getData.getHttp(ko_topsql).then(function (data){
                $scope.kotopten = data.results;  //KO TOP 10
                // console.log('KO TOP 10',$scope.kotopten);
                if($scope.month!='2018-11-01') {
                    angular.forEach(data.results, function (item, index, array) {
                        let sql = 'select sum(sales_amount) from' + ko_topforall.replace('sum', 'shangpin,pack,sum') + ') where zpjt=\'' + $scope.zpjt1 + '\' and zpc=' + '\'' + $scope.zpc1 + '\' and city=' + '\'' + $scope.city1 + '\' and city_level=' + '\'' + $scope.city_level1 + '\' and channel=' + '\'' + $scope.channel1 + '\'and platform=' + '\'' + $scope.platform1 + '\'and type=' + '\'' + $scope.type1 + '\'and shangpin=' + '\'' + item[0] + '\'and pack=' + '\'' + item[1] + '\'';
                        sql = sql.replace('2018-12-01', '2018-11-01');
                        console.log('data0', sql);
                        getData.getHttp(sql).then(function (data0) {
                            console.log('data0', data0.results[0]);
                            $scope.kotopten[index][3]=(item[2]-data0.results[0][0]).toFixed(0);
                        }, function (data) {
                            console.log(data);
                        });
                    });
                }
            },function (data) {
                console.log(data);
            });
            getData.getHttp(sku_topsql).then(function (data){
                $scope.competopten = data.results;  //竞品 TOP 10
                //console.log('竞品 TOP 10',$scope.competopten);
                if($scope.month!='2018-11-01') {
                    angular.forEach(data.results, function (item, index, array) {
                        let sql = 'select sum(sales_amount) from' + ko_topforall.replace('sum', 'shangpin,pack,sum') + ') where zpjt=\'' + $scope.zpjt1 + '\' and zpc=' + '\'' + $scope.zpc1 + '\' and city=' + '\'' + $scope.city1 + '\' and city_level=' + '\'' + $scope.city_level1 + '\' and channel=' + '\'' + $scope.channel1 + '\'and platform=' + '\'' + $scope.platform1 + '\'and type=' + '\'' + $scope.type1 + '\'and shangpin=' + '\'' + item[0] + '\'and pack=' + '\'' + item[1] + '\'';
                        sql = sql.replace('2018-12-01', '2018-11-01');
                        sql=sql.replace('is_ko=1','is_ko=0');
                        console.log('data1', sql);
                        getData.getHttp(sql).then(function (data0) {
                            console.log('data0', data0.results[0]);
                            $scope.competopten[index][3]=(item[2]-data0.results[0][0]).toFixed(0);
                        }, function (data) {
                            console.log(data);
                        });
                    });
                    // console.log('竞品 TOP 10',$scope.competopten);
                }
            },function (data) {
                console.log(data);
            });
            getData.getHttp(nartd_topsql).then(function (data){
                $scope.nartdtopten = data.results;  //竞品 TOP 10
                if($scope.month!='2018-11-01') {
                    angular.forEach(data.results, function (item, index, array) {
                        let sql = 'select sum(sales_amount) from' + ko_topforall.replace('sum', 'shangpin,pack,sum') + ') where zpjt=\'' + $scope.zpjt1 + '\' and zpc=' + '\'' + $scope.zpc1 + '\' and city=' + '\'' + $scope.city1 + '\' and city_level=' + '\'' + $scope.city_level1 + '\' and channel=' + '\'' + $scope.channel1 + '\'and platform=' + '\'' + $scope.platform1 + '\'and type=' + '\'' + $scope.type1 + '\'and shangpin=' + '\'' + item[0] + '\'and pack=' + '\'' + item[1] + '\'';
                        sql = sql.replace('2018-12-01', '2018-11-01');
                        sql=sql.replace('and is_ko=1','');
                        // console.log('data2', sql);
                        getData.getHttp(sql).then(function (data0) {
                            // console.log('data0', data0.results[0]);
                            $scope.nartdtopten[index][3]=(item[2]-data0.results[0][0]).toFixed(0);
                        }, function (data) {
                            console.log(data);
                        });
                    });
                    // console.log('竞品 TOP 10',$scope.nartdtopten);
                }

            },function (data) {
                console.log(data);
            });

            //平均单店饮料件数
            //该筛选范围内销售件数
            // console.log('nartd_forallsql',nartd_forallsql);

            let ko_storecountsql=$scope.getbasesql('sum(salescount)*1.0 storeordercount','storeordercount');// 该筛选范围内门店订单数,由于把KO作为了判断条件，这里需要替换
            // ko_storecountsql=ko_storecountsql.replace('sku_2018','stores_2018');
            let nartd_storecountsql=ko_storecountsql.replace('and is_ko=1','');

            //Nartd 平均每单饮料件数
             console.log('storesalescount分母',nartd_storecountsql);
            getData.getHttp(nartd_storecountsql).then(function (data){
                 console.log('storesalescount分母0');
                $scope.nartdstorecount=data.results[0][0]; //Nardt总销售件数
            },function (data) {
                console.log(data);
            });
            // console.log('uu',$scope.getlastmonthdata(storecountsql));
            if($scope.getlastmonthdata(nartd_storecountsql)){
                getData.getHttp($scope.getlastmonthdata(nartd_storecountsql)).then(function (data){
                    $scope.lastnartdstorecount=data.results[0][0]; //销售件数
                    console.log('storesalescount分母2',data.results[0][0]);
                },function (data) {
                    console.log(data);
                });
            }
            else{
                $scope.lastnartd_storecount=null;
            }
            //KO 平均每单饮料件数
            getData.getHttp(ko_storecountsql).then(function (data){
                console.log('storesalescount分母',data.results[0][0]);
                $scope.kostorecount=data.results[0][0]; //销售件数
            },function (data) {
                console.log(data);
            });
             console.log('uu',$scope.getlastmonthdata(ko_storecountsql));
            if($scope.getlastmonthdata(ko_storecountsql)){
                getData.getHttp($scope.getlastmonthdata(ko_storecountsql)).then(function (data){
                    $scope.lastkostorecount=data.results[0][0]; //销售件数
                    console.log('storesalescount分母2',data.results[0][0]);
                },function (data) {
                    console.log(data);
                });
            }
            else{
                $scope.lastnartd_storecount=null;
            }
            // getData.getHttp(storeordersql).then(function (data){
            //     // console.log('分母',data.results[0][0]);
            //     $scope.storeordercount=data.results[0][0]; //订单数
            // },function (data) {
            //     console.log(data);
            // });
            //平均单店SKU数
            let ko_storeskusql=$scope.getbasesql('count(*) storesku','storesku');// 该筛选范围内门店订单数,由于把KO作为了判断条件，这里需要替换
            let nartd_storeskusql=ko_storeskusql.replace('and is_ko=1','');
            getData.getHttp(ko_storeskusql).then(function (data){
                $scope.ko_storesku=data.results[0][0];
            },function (data) {
                console.log(data);
            });
            if($scope.getlastmonthdata(ko_storeskusql)){
                getData.getHttp($scope.getlastmonthdata(ko_storeskusql)).then(function (data){
                    $scope.lastko_storesku=data.results[0][0]; //销售件数
                    console.log('storesalescount分母2',data.results[0][0]);
                },function (data) {
                    console.log(data);
                });
            }
            else{
                $scope.lastko_storesku=null;
            }
            getData.getHttp(nartd_storeskusql).then(function (data){
                $scope.nartd_storesku=data.results[0][0];
            },function (data) {
                console.log(data);
            });
            if($scope.getlastmonthdata(nartd_storeskusql)){
                getData.getHttp($scope.getlastmonthdata(nartd_storeskusql)).then(function (data){
                    $scope.lastnartd_storesku=data.results[0][0]; //销售件数
                    console.log('storesalescount分母2',data.results[0][0]);
                },function (data) {
                    console.log(data);
                });
            }
            else{
                $scope.lastnartd_storesku=null;
            }

            getData.getHttp(ko_forallsql).then(function (data){
                // console.log('分母',data.results[0][0]);
                $scope.kosales=data.results[0][0];
            },function (data) {
                console.log(data);
            });
            getData.getHttp(nartd_forallsql).then(function (data){
                // console.log('分母',data.results[0][0]);
                $scope.nartdsales=data.results[0][0];
            },function (data) {
                console.log(data);
            });
            //上月KO销售金额
            let lastko_forallsql=ko_forallsql.replace($scope.month,'2018-11-01');
            let lastnartd_forallsql=nartd_forallsql.replace($scope.month,'2018-11-01');
            if($scope.month=='2018-12-01'){
                getData.getHttp(lastko_forallsql).then(function (data){
                    // console.log('分母',data.results[0][0]);
                    $scope.lastkosales=data.results[0][0];
                },function (data) {
                    console.log(data);
                });
                getData.getHttp(lastnartd_forallsql).then(function (data){
                    // console.log('分母',data.results[0][0]);
                    $scope.lastnartdsales=data.results[0][0];
                },function (data) {
                    console.log(data);
                });
            }
            else{
                $scope.lastkosales=null;
                $scope.lastnartdsales=null;
            }

            // KO销售件数
            var countreg=new RegExp('sales_amount','g');
            let ko_salescountsql=ko_forallsql.replace(countreg,'salescount');
            let nartd_salescountsql=nartd_forallsql.replace(countreg,'salescount');
            getData.getHttp(ko_salescountsql).then(function (data){
                // console.log('分母',data.results[0][0]);
                $scope.kocount=data.results[0][0];
            },function (data) {
                console.log(data);
            });
            getData.getHttp(nartd_salescountsql).then(function (data){
                // console.log('分母',data.results[0][0]);
                $scope.nartdcount=data.results[0][0];
            },function (data) {
                console.log(data);
            });
            //上月KO销售件数
            let lastko_salescountsql=ko_salescountsql.replace($scope.month,'2018-11-01');
            let lastnartd_salescountsql=nartd_salescountsql.replace($scope.month,'2018-11-01');
            if($scope.month!='2018-11-01'){
                getData.getHttp(lastko_salescountsql).then(function (data){
                    // console.log('分母',data.results[0][0]);
                    $scope.lastkocount=data.results[0][0];
                },function (data) {
                    console.log(data);
                });
                getData.getHttp(lastnartd_salescountsql).then(function (data){
                    // console.log('分母',data.results[0][0]);
                    $scope.lastnartdcount=data.results[0][0];
                },function (data) {
                    console.log(data);
                });
            }
            else{
                $scope.lastkocount=null;
                $scope.lastnartdcount=null;
            }

            //销售金额
            // if(level=='0'){
            //     var date = new Date($scope.month);
            //     //$scope.month_next=''+date.getFullYear()+'-'+(date.getMonth()+2)+'-'+(date.getDate()-1);
            //     $scope.lastmonth=''+date.getFullYear()+'-'+(date.getMonth())+'-'+(date.getDate()-1); //表示上一个月的开始日期
            //     console.log('$scope.lastmonth',$scope.lastmonth);
            //     $scope.month_next=''+(date.getFullYear()+1)+'-'+'01'+'-'+(date.getDate()-1);
            //     $scope.lastmonth_next=''+date.getFullYear()+'-'+(date.getMonth()+1)+'-'+(date.getDate()-1);//上一个月的结束日期
            //     $scope.basesql0='(select * from sku_2018 where dt between'+'\''+$scope.month+'\''+ ' and ' +'\''+$scope.month_next+'\')';
            //     $scope.lastbasesql0='(select * from sku_2018 where dt between'+'\''+$scope.lastmonth+'\''+ ' and ' +'\''+$scope.lastmonth_next+'\')';
            //     //重新请求数据
            //     //全国该时间内线上在售任一KO产品的网店数
            //     getData.getHttp('select count(distinct storeid_copy) from '+$scope.basesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
            //         $scope.ko_onlinestores = data.results[0][0];
            //         //console.log('任一KO产品的网店数',$scope.ko_onlinestores);
            //         $scope.sortko_onlinestores=$scope.ko_onlinestores; //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.sortko_onlinestores2=$scope.ko_onlinestores; //饼图
            //         $scope.disko_onlinestores=$scope.sortko_onlinestores;
            //     },function (data) {
            //         console.log(data);
            //     });
            //     //上月
            //     getData.getHttp('select count(distinct storeid_copy) from '+$scope.lastbasesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
            //         //console.log('任一KO产品的网店数','select count(distinct storeid_copy) from '+$scope.lastbasesql0+' where is_ko=1 group by is_ko,dt');
            //         $scope.lastko_onlinestores = data.results.length!=0?data.results[0][0]:null;
            //         //console.log('任一KO产品的网店数',$scope.ko_onlinestores);
            //         $scope.lastsortko_onlinestores=data.results.length!=0?$scope.lastko_onlinestores:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
            //     },function (data) {
            //         console.log(data);
            //     });
            //
            //     //全国该时间内全部网店数
            //     console.log('$scope.basesql',$scope.basesql0);
            //     getData.getHttp('select count(distinct storeid) from '+$scope.basesql0+' group by dt').then(function (data){
            //         $scope.onlinestores = data.results[0][0];
            //         //上半部分网店数
            //         $scope.sortonlinestores= $scope.onlinestores; //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.disonlinestores=$scope.sortonlinestores;
            //         //下半部分网店数
            //         $scope.sortonlinestores1= $scope.onlinestores; //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.disonlinestores1=$scope.sortonlinestores1;
            //     },function (data) {
            //         console.log(data);
            //     });
            //     //上月全国该时间内全部网店数
            //     getData.getHttp('select count(distinct storeid) from '+$scope.lastbasesql0+' group by dt').then(function (data){
            //         $scope.lastonlinestores = data.results.length!=0?data.results[0][0]:null;
            //         //上半部分网店数
            //         $scope.lastsortonlinestores= data.results.length!=0?$scope.lastonlinestores:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.lastdisonlinestores=data.results.length!=0?$scope.lastsortonlinestores:null;
            //         //下半部分网店数
            //         $scope.lastsortonlinestores1= data.results.length!=0?$scope.lastonlinestores:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.lastdisonlinestores1=data.results.length!=0?$scope.lastsortonlinestores1:null;
            //     },function (data) {
            //         console.log(data);
            //     });
            //     //全国该时间内全部软饮销售件数
            //     getData.getHttp('select sum(salescount) from '+$scope.basesql0+' group by dt').then(function (data){
            //         $scope.salescount = data.results[0][0];  //全国该时间全部（软饮）产品销售总件数
            //         //上半部分销售件数
            //         $scope.sortsalescount=$scope.salescount; //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.dissalescount=$scope.sortsalescount;
            //         //下半部分销售件数
            //         $scope.sortsalescount1=$scope.salescount; //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.dissalescount1=$scope.sortsalescount1;
            //     },function (data) {
            //         console.log(data);
            //     });
            //     //全国上月内全部软饮销售件数
            //     getData.getHttp('select sum(salescount) from '+$scope.lastbasesql0+' group by dt').then(function (data){
            //         $scope.lastsalescount = data.results.length!=0?data.results[0][0]:null;  //全国该时间全部（软饮）产品销售总件数
            //         //上半部分销售件数
            //         $scope.lastsortsalescount=data.results.length!=0?$scope.lastsalescount:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.lastdissalescount=data.results.length!=0?$scope.lastsortsalescount:null;
            //         //下半部分销售件数
            //         $scope.lastsortsalescount1=data.results.length!=0?$scope.lastsalescount:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.lastdissalescount1=data.results.length!=0?$scope.lastsortsalescount1:null;
            //     },function (data) {
            //         console.log(data);
            //     });
            //     //全国该时间内KO产品销售件数
            //     getData.getHttp('select sum(salescount) from '+$scope.basesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
            //         $scope.ko_salescount = data.results[0][0];  //KO产品销售件数
            //         console.log('KO产品销售件数',$scope.ko_salescount);
            //         $scope.sortko_salescount=$scope.ko_salescount;//页面初始化时分组默认全部，此处给分组数据赋初始值
            //     },function (data) {
            //         console.log(data);
            //     });
            //     //全国上月内KO产品销售件数
            //     getData.getHttp('select sum(salescount) from '+$scope.lastbasesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
            //         $scope.lastko_salescount = data.results.length!=0?data.results[0][0]:null;  //KO产品销售件数
            //         console.log('上月KO产品销售件数',$scope.ko_salescount);
            //         $scope.lastsortko_salescount=data.results.length!=0?$scope.lastko_salescount:null;//页面初始化时分组默认全部，此处给分组数据赋初始值
            //     },function (data) {
            //         console.log(data);
            //     });
            //     //全国该时间内全部软饮销售金额
            //     getData.getHttp('select sum(sales_amount) from '+$scope.basesql0+' group by dt').then(function (data){
            //         $scope.sales_amount = data.results[0][0];  //全国该时间销售总金额、全部软饮销售总额
            //         //上半部分销售金额
            //         $scope.sortsales_amount=$scope.sales_amount;  //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.dissales_amount=$scope.sortsales_amount;
            //
            //         //下半部分销售金额
            //         $scope.sortsales_amount1=$scope.sales_amount;  //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.dissales_amount1=$scope.sortsales_amount1;
            //     },function (data) {
            //         console.log(data);
            //     });
            //     //全国上月内全部软饮销售金额
            //     getData.getHttp('select sum(sales_amount) from '+$scope.basesql0+' group by dt').then(function (data){
            //         $scope.lastsales_amount = data.results.length!=0?data.results[0][0]:null;  //全国该时间销售总金额、全部软饮销售总额
            //         //下半部分销售金额
            //         $scope.lastsortsales_amount=data.results.length!=0?$scope.sales_amount:null;  //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.lastdissales_amount=data.results.length!=0?$scope.lastsortsales_amount:null;
            //         //下半部分销售金额
            //         $scope.lastsortsales_amount1=data.results.length!=0?$scope.lastsales_amount:null;  //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.lastdissales_amount1=data.results.length!=0?$scope.lastsortsales_amount1:null;
            //     },function (data) {
            //         console.log(data);
            //     });
            //     //全国该时间内KO产品销售金额
            //     getData.getHttp('select sum(sales_amount) from '+$scope.basesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
            //         $scope.ko_sales_amount = data.results[0][0];  //KO产品销售金额
            //         //console.log('KO产品销售金额',$scope.ko_sales_amount);
            //         $scope.sortko_sales_amount=$scope.ko_sales_amount; //页面初始化时分组默认全部，此处给分组数据赋初始值
            //         $scope.disko_sales_amount=$scope.sortko_sales_amount;
            //         $scope.sortsales_amount2=$scope.ko_sales_amount; //饼图
            //     },function (data) {
            //         console.log(data);
            //     });
            //     //全国上个月内KO产品销售金额
            //     getData.getHttp('select sum(sales_amount) from '+$scope.lastbasesql0+' where is_ko=1 group by is_ko,dt').then(function (data){
            //         $scope.lastko_sales_amount = data.results.length!=0 ? data.results[0][0]:null;  //KO产品销售金额
            //         //console.log('KO产品销售金额',$scope.ko_sales_amount);
            //         $scope.lastsortko_sales_amount=data.results.length!=0 ? $scope.lastko_sales_amount:null; //页面初始化时分组默认全部，此处给分组数据赋初始值
            //     },function (data) {
            //         console.log(data);
            //     });
            //
            //
            //     //console.log('month',$scope.month_next);
            // }
            //$('.map-men2').show();

            //改变装瓶集团、装瓶厂、城市、城市等级
            if(level==1 || level==2 || level==3 || level==4){
                let tabledata='(select zpjt,zpc,city,city_level from sku_2018 where dt between'+'\''+$scope.month+'\' and \''+$scope.month_next+'\' union\n' +
                    '\n' +
                    'select \'全部\' zpjt,zpc,city,city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by zpc,city,city_level  union\n' +
                    'select  zpjt,\'全部\' zpc,city,city_level from sku_2018 where dt between'+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by zpjt,city,city_level  union\n' +
                    'select zpjt,zpc,\'全部\' city,city_level from sku_2018 where dt between'+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by zpjt,zpc,city_level  union\n' +
                    'select  zpjt,zpc,city,\'全部\'city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by zpjt,zpc,city  union\n' +
                    '\n' +
                    'select \'全部\' zpjt,\'全部\' zpc,city,city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by city,city_level  union\n' +
                    'select \'全部\' zpjt,zpc,\'全部\' city,city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by zpc,city_level  union\n' +
                    'select \'全部\' zpjt,zpc,city,\'全部\' city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by zpc,city  union\n' +
                    'select zpjt,\'全部\' zpc,\'全部\' city,city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by zpjt,city_level  union\n' +
                    'select zpjt,\'全部\' zpc,city,\'全部\' city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by zpjt,city  union\n' +
                    'select zpjt,zpc,\'全部\' city,\'全部\' city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by zpc,zpjt  union\n' +
                    '\n' +
                    'select \'全部\' zpjt,\'全部\' zpc,\'全部\' city,city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by city_level  union\n' +
                    'select \'全部\' zpjt,\'全部\' zpc,city,\'全部\' city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by city  union\n' +
                    'select \'全部\' zpjt,zpc,\'全部\' city,\'全部\' city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by zpc  union\n' +
                    'select zpjt, \'全部\' zpc, \'全部\' city, \'全部\' city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\' group by zpjt  union\n' +
                    '\n' +
                    'select \'全部\' zpjt,\'全部\' zpc,\'全部\' city,\'全部\' city_level from sku_2018 where dt between '+'\''+$scope.month+'\' and \''+$scope.month_next+'\')';
                let condition='';
                //装瓶集团列表$scope.zpjtlist
                if(level==1){
                    condition=' where zpjt=\''+$scope.zpjt1+'\' and city=\''+$scope.city1+'\' and city_level=\''+$scope.city_level1+'\'';
                    let zpclistsql='select  zpc  from '+tabledata+condition;
                    $scope.zpc1='全部';
                    $scope.city1='全部';
// 装瓶厂列表$scope.zpclist
                    getData.getHttp(zpclistsql).then(function (data){
                        $scope.zpclist0 = data.results;
                        $scope.zpclist = data.results;
                    },function (data) {
                        console.log(data);
                    });
// 城市列表$scope.citylist
                    condition=' where zpjt=\''+$scope.zpjt1+'\' and zpc=\''+$scope.zpc1+'\' and city_level=\''+$scope.city_level1+'\'';
                    let citylistsql='select  city  from '+tabledata+condition;
                    getData.getHttp(citylistsql).then(function (data){
                        $scope.citylist0 = data.results;
                        $scope.citylist = data.results;
                    },function (data) {
                        console.log(data);
                    });
// 城市等级列表$scope.cityclasslist
                    condition=' where zpjt=\''+$scope.zpjt1+'\' and zpc=\''+$scope.zpc1+'\' and city=\''+$scope.city1+'\'';
                    let city_levellistsql='select city_level  from  '+tabledata+condition;
                    getData.getHttp(city_levellistsql).then(function (data){
                        $scope.cityclasslist0 = data.results;
                        $scope.cityclasslist = data.results;
                    },function (data) {
                        console.log(data);
                    });
                }
                if(level==2){
                    // condition=' where zpc=\''+$scope.zpc1+'\' and city=\''+$scope.city1+'\' and city_level=\''+$scope.city_level1+'\'';
                    // let zpjtlistsql='select  zpjt  from  '+tabledata+condition;
                    // getData.getHttp(zpjtlistsql).then(function (data){
                    //     $scope.zpjtlist0 = data.results;
                    // },function (data) {
                    //     console.log(data);
                    // });
                    condition=' where zpjt=\''+$scope.zpjt1+'\' and zpc=\''+$scope.zpc1+'\' and city_level=\''+$scope.city_level1+'\'';
                    let citylistsql='select  city  from '+tabledata+condition;
                    $scope.city1='全部';
                    getData.getHttp(citylistsql).then(function (data){
                        $scope.citylist0 = data.results;
                        $scope.citylist = data.results;
                    },function (data) {
                        console.log(data);
                    });
// 城市等级列表$scope.cityclasslist
                    condition=' where zpjt=\''+$scope.zpjt1+'\' and zpc=\''+$scope.zpc1+'\' and city=\''+$scope.city1+'\'';
                    let city_levellistsql='select city_level  from  '+tabledata+condition;
                    getData.getHttp(city_levellistsql).then(function (data){
                        $scope.cityclasslist0 = data.results;
                        $scope.cityclasslist = data.results;
                    },function (data) {
                        console.log(data);
                    });
                }
                if(level==3){
                    // 城市列表$scope.citylist
                    condition=' where zpjt=\''+$scope.zpjt1+'\' and zpc=\''+$scope.zpc1+'\' and city_level=\''+$scope.city_level1+'\'';
                    let citylistsql='select  city  from '+tabledata+condition;
                    getData.getHttp(citylistsql).then(function (data){
                        $scope.citylist0 = data.results;
                        $scope.citylist = data.results;
                    },function (data) {
                        console.log(data);
                    });
                }
                if(level==4){
//                     condition=' where zpc=\''+$scope.zpc1+'\' and city=\''+$scope.city1+'\' and city_level=\''+$scope.city_level1+'\'';
//                     let zpjtlistsql='select  zpjt  from  '+tabledata+condition;
//                     getData.getHttp(zpjtlistsql).then(function (data){
//                         $scope.zpjtlist0 = data.results;
//                     },function (data) {
//                         console.log(data);
//                     });
//                     condition=' where zpjt=\''+$scope.zpjt1+'\' and city=\''+$scope.city1+'\' and city_level=\''+$scope.city_level1+'\'';
//                     let zpclistsql='select  zpc  from '+tabledata+condition;
// // 装瓶厂列表$scope.zpclist
//                     getData.getHttp(zpclistsql).then(function (data){
//                         $scope.zpclist0 = data.results;
//                     },function (data) {
//                         console.log(data);
//                     });
// // 城市列表$scope.citylist
//                     condition=' where zpjt=\''+$scope.zpjt1+'\' and zpc=\''+$scope.zpc1+'\' and city_level=\''+$scope.city_level1+'\'';
//                     let citylistsql='select  city  from '+tabledata+condition;
//                     getData.getHttp(citylistsql).then(function (data){
//                         $scope.citylist0 = data.results;
//                     },function (data) {
//                         console.log(data);
//                     });
                }
            }


            if(level==3||level==5||level==6||level==7){
                $scope.setmapdata();
                setMap(false,$scope.mapdata,$scope.specialmapdata);
            }
            // $('.map-men2').hide();
            // $scope.getChartsData();
        };

        $scope.onoptionchange();
        $scope.typeData = [
            {"label": "0", "value": "VS LM / VS QT"},
            {"label": "-1", "value": "VS LY"}
        ];
        $scope.stages=[
            {"id": "0", "value": "VS PP"}
        ];
        $scope.myselect = "0";
        $scope.classify = 1; //判断是查看KO top 10还是竞品 top 10，默认展示的是KO top 10
        //切换KO top 10 和 竞品 top 10
        $("#nitd_ummarize").attr('style', 'background-color:white;color: red;');
        $scope.koCompeting = function (classify) {
            $scope.classify = classify;
            if (classify == 1) {
                $("#ko_ummarize").attr('style', 'background-color:red;color: white;');
                $("#no_ummarize").attr('style', 'background-color:white;color: red;');
                $("#nitd_ummarize").attr('style', 'background-color:white;color: red;');
            } else if (classify == 2) {
                $("#no_ummarize").attr('style', 'background-color:red;color: white;');
                $("#ko_ummarize").attr('style', 'background-color:white;color: red;');
                $("#nitd_ummarize").attr('style', 'background-color:white;color: red;');
            }else{
                $("#no_ummarize").attr('style', 'background-color:white;color: red;');
                $("#ko_ummarize").attr('style', 'background-color:white;color: red;');
                $("#nitd_ummarize").attr('style', 'background-color:red;color: white;');
            }
        };
        //重置上半部分下拉框
        $scope.resetFilter = function () {
            $scope.zpjt1='全部';//装瓶集团,默认为全部
            $scope.zpc1='全部';//装瓶厂,默认为全部
            $scope.city_level1='全部';//城市等级,默认为全部
            $scope.city1='全部';//参数,默认为全部
            $scope.channel1='全部';//渠道,默认为全部
            $scope.platform1='全部';//平台,默认为全部
            $scope.type1='全部';  //品类,默认为全部
            $scope.onoptionchange();
        }
        //画饼图函数
        // 配置项
        $scope.pieConfig = {
            theme: 'default',
            dataLoaded: true,
            notMerge: true,
        };
        //双环
        //$scope.pie1 = {
        //    color: ['#FFC738', '#eeeeee'],
        //    tooltip: {
        //        trigger: 'item',
        //        formatter: "{a} <br/>{b}: {c} ({d}%)",
        //        enterable: true,//鼠标是否可进入提示框浮层
        //        // renderMode: 'richText',
        //        confine: true,//是否将 tooltip 框限制在图表的区域内。
        //        position: "top"
        //    },
        //    series: [
        //        {
        //            name: "<?//= Yii::t('cvs', '上线门店数')?>//",
        //            type: 'pie',
        //            label: {
        //                normal: {
        //                    show: false,
        //                    position: 'center'
        //                },
        //                emphasis: {
        //                    show: true,
        //                    textStyle: {
        //                        fontSize: '30',
        //                        fontWeight: 'bold'
        //                    }
        //                }
        //            },
        //            labelLine: {
        //                normal: {
        //                    show: false
        //                }
        //            },
        //            radius: ['60%', '80%'],
        //             data: ['32.333', '60'],
        //            avoidLabelOverlap: false
        //        }
        //    ]
        //};
        //$scope.pie2 = {
        //    color: ['#FFC738', '#eeeeee'],
        //    tooltip: {
        //        trigger: 'item',
        //        formatter: "{a} <br/>{b} {c} ({d}%)",
        //        enterable: true,//鼠标是否可进入提示框浮层
        //        // renderMode: 'richText',
        //        confine: true,//是否将 tooltip 框限制在图表的区域内。
        //        position: "right"
        //    },
        //    series: [
        //        {
        //            name:'软饮产品铺货网店数',
        //            type:'pie',
        //            radius: ['60%', '80%'],
        //            label: {
        //                normal: {
        //                    show: false
        //                }
        //            },
        //            data:[
        //                {value:310},
        //                {value:335}
        //            ]
        //        },
        //        {
        //             name:'KO产品铺货网店数',
        //            type:'pie',
        //            radius: ['30%', '50%'],
        //            label: {
        //                normal: {
        //                    show: false
        //                }
        //            },
        //            data:[
        //                {value:135},
        //                {value:679}
        //            ]
        //        }
        //
        //    ]
        //};
        //$scope.pie3 = {
        //    color: ['#FFC738', '#eeeeee'],
        //    tooltip: {
        //        trigger: 'item',
        //        formatter: "{a} <br/>{b} {c} ({d}%)",
        //        enterable: true,//鼠标是否可进入提示框浮层
        //        // renderMode: 'richText',
        //        confine: true,//是否将 tooltip 框限制在图表的区域内。
        //        position: "right"
        //    },
        //    series: [
        //
        //        {
        //            name:'软饮销售金额',
        //            type:'pie',
        //            radius: ['60%', '80%'],
        //            label: {
        //                normal: {
        //                    show: false
        //                }
        //            },
        //            data:[
        //                {value:310},
        //                {value:335}
        //            ]
        //        },
        //        {
        //            name:'KO销售金额',
        //            type:'pie',
        //            radius: ['30%', '50%'],
        //            label: {
        //                normal: {
        //                    show: false
        //                }
        //            },
        //            data:[
        //                {value:135},
        //                {value:679}
        //            ]
        //        }
        //    ]
        //};
        //饼图
        $scope.pie1 = {
            color: ['#FFC738', '#eeeeee'],
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)",
                enterable: true,//鼠标是否可进入提示框浮层
                // renderMode: 'richText',
                confine: true,//是否将 tooltip 框限制在图表的区域内。
                position: "top"
            },
            series: [
                {
                    name: "<?= Yii::t('cvs', '上线门店数')?>",
                    type: 'pie',
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: true,
                            textStyle: {
                                fontSize: '30',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    radius: ['65%', '80%'],
                    data: ['32.333', '60'],
                    avoidLabelOverlap: false
                }
            ]
        };
        $scope.pie2 = {
            color: ['#FFC738', '#eeeeee'],
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)",
                enterable: true,
                // renderMode: 'richText',
                confine: true,
                position: "top"
            },
            series: [
                {
                    type: 'pie',
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: true,
                            textStyle: {
                                fontSize: '30',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    radius: ['65%', '80%'],
                    data: ['32.333', '60'],
                    avoidLabelOverlap: false
                }
            ]
        };
        $scope.pie3 = {
            color: ['#FFC738', '#eeeeee'],
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)",
                enterable: true,
                // renderMode: 'richText',
                confine: true,
                position: "top"
            },
            series: [
                {
                    type: 'pie',
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: true,
                            textStyle: {
                                fontSize: '30',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    radius: ['65%', '80%'],
                    data: ['32.333', '60'],
                    avoidLabelOverlap: false
                }
            ]
        };
        $scope.pie4 = {
            color: ['#FFC738', '#eeeeee'],
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)",
                enterable: true,
                // renderMode: 'richText',
                confine: true,
                position: "top"
            },
            series: [
                {
                    type: 'pie',
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: true,
                            textStyle: {
                                fontSize: '30',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    radius: ['65%', '80%'],
                    data: ['32.333', '60'],
                    avoidLabelOverlap: false,
                }
            ]
        };
        $scope.setBlendOption = function (kpiname, comparName) {
            // console.log('jjj');
            var kpi = 0;
            var lastkpi=0;
            var comparKpi = 0;
            switch (kpiname) {
                case "pie1":
                    kpi=$scope.stores*1.0/$scope.allstores;//网店上线率
                    // kpi= !kpi?0:kpi;
                    $scope.pie1kpi=kpi;
                    // console.log('kpi',$scope.disonlinestores);
                    //  console.log('kpi2',kpi);
                    // comparKpi=$scope.stores;//网店数
                    comparKpi=$scope.number_format($scope.stores);
                    $scope.pie1.series[0].data = [kpi, 1 - kpi];
                    $scope.pie1.tooltip.formatter = comparName + '<img src="<?=Yii::app()->request->baseUrl.'/images/plaint.png';?>" title="该数据范围内网店数（不同平台之间未打通，即1家线下门店在3个平台上线算3家网店）" class="rulePng">'+'：' + comparKpi+'<br/>'+'网店上线率：'+(Math.floor(kpi*1000)/10)+'%';
                    //$scope.pie1.tooltip.formatter = '<img src="<?//=Yii::app()->request->baseUrl.'/images/plaint.png';?>//" title="该数据范围内网店数（不同平台之间未打通，即1家线下门店在3个平台上线算3家网店）" class="rulePng">'+'网店上线率：'+(Math.floor(kpi*10000)/100)+'%';
                    //console.log('$scope.pie1',$scope.pie1);
                    return $scope.pie1;
                    break;
                case "pie2":
                    //kpi = $scope.kopciinfos.koandpcis.distribution == null ? 0 : $scope.kopciinfos.koandpcis.distribution;//产品铺货率
                    //comparKpi = $scope.kopciinfos.koandpcis.distribution_store == null ? 0 : $scope.conversion(Math.floor($scope.kopciinfos.koandpcis.distribution_store));//铺货门店数
                    // console.log('disonlinestores',$scope.disonlinestores);
                    // console.log('sortonlinestores',$scope.sortonlinestores);

                    kpi=$scope.ko_stores/$scope.stores;//KO产品铺货率
                    kpi= !kpi?0:kpi;
                    //$scope.pie2kpi=kpi;
                    // comparKpi=$scope.ko_stores;//铺货网店数
                    comparKpi=$scope.number_format($scope.ko_stores);
                    $scope.pie2.series[0].data = [kpi, 1 - kpi];
                    //$scope.pie2.series[0].data[0].value=$scope.ko_stores;
                   // $scope.pie2.series[0].data[1].value=$scope.sortonlinestores-$scope.disonlinestores;
                    // $scope.pie2.series[1].data[0].value=$scope.disko_onlinestores;
                    // $scope.pie2.series[1].data[1].value=$scope.sortko_onlinestores2-$scope.disko_onlinestores;
                    $scope.pie2.tooltip.formatter = comparName + '<img src="<?=Yii::app()->request->baseUrl.'/images/plaint.png';?>" title="该数据范围内线上在售任一产品网店数" class="rulePng">'+ '：' + comparKpi+'<br/>'+'KO铺货率：'+(Math.floor(kpi*1000)/10)+'%';
                    //$scope.pie2.tooltip.formatter ='<img src="<?//=Yii::app()->request->baseUrl.'/images/plaint.png';?>//" title="该数据范围内线上在售任一产品网店数" class="rulePng">'+ 'KO产品铺货率：'+(Math.floor(kpi*10000)/100)+'%';

                    //console.log($scope.pie2);
                    return $scope.pie2;
                    break;
                case "pie3":
                    kpi=$scope.kosales*1.0/$scope.nartdsales;//销售金额占比
                    //kpi= !kpi?0:kpi;
                    //$scope.pie3kpi=kpi;
                    comparKpi=new Number(''+$scope.kosales);//KO销售金额
                   //  comparKpi=($scope.kosales).toLocaleString();
                    //$scope.pie3.series[0].data = [kpi, 1 - kpi];
                    $scope.pie3.series[0].data[0].value=$scope.kosales; //$scope.last_dissales_amount
                  //  $scope.pie3.series[0].data[1].value=$scope.sortsales_amount-$scope.dissales_amount;
                    //原来的双环
                    //$scope.pie3.series[1].data[0].value=$scope.disko_sales_amount;//$scope.lastsortko_sales_amount
                    //$scope.pie3.series[1].data[1].value=$scope.allsortko_sales_amount-$scope.sortko_sales_amount;
                    $scope.pie3.tooltip.formatter = comparName + '<img src="<?=Yii::app()->request->baseUrl.'/images/plaint.png';?>" title="该数据范围内每一产品销售件数乘以实际销售价格（含折扣、特价，不含红包、立减、满减）乘积的总和" class="rulePng">'+ '：' + Math.floor(comparKpi)+'<br/>'+'KO销售金额份额：'+(Math.floor(kpi*1000)/10)+'%';

                    //$scope.pie3.tooltip.formatter = comparName +'<img src="<?//=Yii::app()->request->baseUrl.'/images/plaint.png';?>//" title="该数据范围内每一产品销售件数乘以实际销售价格（含折扣、特价，不含红包、立减、满减）乘积的总和" class="rulePng">'+ '：' + comparKpi;
                    //$scope.pie3.tooltip.formatter = '<img src="<?//=Yii::app()->request->baseUrl.'/images/plaint.png';?>//" title="该数据范围内每一产品销售件数乘以实际销售价格（含折扣、特价，不含红包、立减、满减）乘积的总和" class="rulePng">' + 'KO销售金额份额：'+(Math.floor(kpi*10000)/100)+'%';

                    return $scope.pie3;
                    break;
                case "pie4":
                    kpi=$scope.kocount*1.0/$scope.nartdcount; //销售件数占比
                    kpi= !kpi?0:kpi;
                    // $scope.pie4kpi=($scope.kocount/$scope.nartdcount;
                    $scope.lastpie4kpi=kpi;
                    // comparKpi=$scope.kocount; //KO销售件数
                    comparKpi=$scope.number_format($scope.kocount);
                    $scope.pie4.series[0].data = [kpi, 1 - kpi];
                    $scope.pie4.series[0].data[0].value=$scope.kocount;
                  //  $scope.pie4.series[0].data[1].value=$scope.sortsalescount-$scope.dissalescount;
                    // $scope.pie4.series[1].data[0].value=$scope.sortko_salescount;//
                    // $scope.pie4.series[1].data[1].value=$scope.allko_salescount-$scope.sortko_salescount;
                    //$scope.pie4.tooltip.formatter = comparName + '<img src="<?//=Yii::app()->request->baseUrl.'/images/plaint.png';?>//" title="该数据范围内每一产品销售件数的总和" class="rulePng">'+ '：' + comparKpi;
                    //$scope.pie4.tooltip.formatter = comparName +'<img src="<?//=Yii::app()->request->baseUrl.'/images/plaint.png';?>//" title="该数据范围内每一产品销售件数的总和" class="rulePng">'+ '：' + comparKpi;
                    $scope.pie4.tooltip.formatter = comparName + '<img src="<?=Yii::app()->request->baseUrl.'/images/plaint.png';?>" title="该数据范围内每一产品销售件数的总和" class="rulePng">'+ '：' + comparKpi+'<br/>'+'KO销售件数份额：'+(Math.floor(kpi*1000)/10)+'%';

                    //$scope.pie4.tooltip.formatter = '<img src="<?//=Yii::app()->request->baseUrl.'/images/plaint.png';?>//" title="该数据范围内每一产品销售件数的总和" class="rulePng">'+ 'KO销售件数份额：'+(Math.floor(kpi*10000)/100)+'%';

                    return $scope.pie4;
                    break;
            }
        };

        //下半部分逻辑控制
       //  $scope.visitab='distribution';//页面加载默认为产品铺货率tab页
       // // $scope.visitab='distribution_store';
       //  $scope.kpichecked = 1;//默认产品铺货率
       //  // $scope.getBarData = function () {
       //  //     // $('<div>', {
       //  //     //     class: 'mb-fff'
       //  //     // }).appendTo('#chart-view');
       //  //     let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
       //  //     let systemtype = $scope.deepsystemcheck == 'systemtype' ? 1 : $scope.deepsystemcheck == 'system' ? 2 : null;
       //  //     let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
       //  //     let platform = $scope.deepplatformcheck == 'platform' ? 1 : null;
       //  //     let cityLevelListtype = $scope.cityLevelListcheck == 'cityLevelListtype' ? 1 : 0;
       //  //      let iscityleveltype = $scope.typeValue == true ? 1 : 0; ? 1 : 0;
       //  //     let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
       //  //     let kpichecked = $scope.kpichecked;
       //  //     if(!$scope.month){
       //  //         $scope.month='2018-11-01';
       //  //         var date = new Date($scope.month);
       //  //         $scope.month_next=''+date.getFullYear()+'-'+(date.getMonth()+2)+'-'+(date.getDate()-1);
       //  //         //console.log('month',$scope.month_next);
       //  //     }
       //  //    $scope.basesql='(select * from sku_2018 where dt between'+'\''+$scope.month+'\''+ ' and ' +'\''+$scope.month_next+'\')';
       //  //    let basesql='(select * from sku_2018 where dt between'+'\''+$scope.month+'\''+ ' and ' +'\''+$scope.month_next+'\')';
       //  //
       //  //     //console.log('sqlbase',sqlbase);
       //  //     $scope.condition=' ';
       //  //     $scope.sql1='select type,zpjt,channel,platform,city_level from '+$scope.basesql+$scope.condition+' group by dt,channel,platform,city_level';
       //  //     $scope.sql1=($scope.sql1).replace(' where','');
       //  //     $scope.sql2='select count(distinct storeid) from '+$scope.basesql+' group by dt,channel,platform,city_level';
       //  //    // $scope.sql2=($scope.sql2).replace('where','');
       //  //     let sqlall='';
       //  //     if(isgrading==1){
       //  //         $scope.sql1='select level,zpjt,channel,platform,city_level,type from '+$scope.basesql+' where '+$scope.condition+' group by dt,channel,platform,city_level,level' ;
       //  //         $scope.sql2='select count(distinct storeid) from '+$scope.basesql+' group by dt,channel,platform,city_level,level';
       //  //         switch(citytype){
       //  //             case 1:
       //  //                 $scope.sql1+=' ,zpjt';
       //  //                 $scope.sql2+=' ,zpjt';
       //  //                 break;
       //  //             case 2:
       //  //                 $scope.sql1=$scope.sql1.replace('zpjt','zpc');
       //  //                 $scope.sql1+=' ,zpc';
       //  //                 $scope.sql2+=' ,zpc';
       //  //                 break;
       //  //             case 3:
       //  //                 $scope.sql1=$scope.sql1.replace('zpjt','city');
       //  //                 $scope.sql1+=',city';
       //  //                 $scope.sql2+=',city';
       //  //                 break;
       //  //         }
       //  //         switch(skutype){
       //  //             case 1:
       //  //                 $scope.sql1+=',type';
       //  //                 $scope.sql2+=',type';
       //  //                 break;
       //  //             case 2:
       //  //                 $scope.sql1=$scope.sql1.replace('type','manu');
       //  //                 $scope.sql1+=',manu';
       //  //                 $scope.sql2+=',manu';
       //  //                 break;
       //  //             case 3:
       //  //                 $scope.sql1=$scope.sql1.replace('type','pinpai');
       //  //                 $scope.sql1+=',pinpai';
       //  //                 $scope.sql2+=',pinpai';
       //  //                 break;
       //  //
       //  //         }
       //  //     }
       //  //     else if(isgrading==2){
       //  //         $scope.sql1='select pack_level,zpjt,channel,platform,city_level,type from '+$scope.basesql+' group by dt,channel,platform,city_level,pack_level' ;
       //  //         $scope.sql2='select count(distinct storeid) from '+$scope.basesql+' group by dt,channel,platform,city_level,pack_level';
       //  //         switch(citytype){
       //  //             case 1:
       //  //                 $scope.sql1+=' ,zpjt';
       //  //                 $scope.sql2+=' ,zpjt';
       //  //                 break;
       //  //             case 2:
       //  //                 $scope.sql1=sql1.replace('zpjt','zpc');
       //  //                 $scope.sql1+=' ,zpc';
       //  //                 $scope.sql2+=' ,zpc';
       //  //                 break;
       //  //             case 3:
       //  //                 $scope.sql1=$scope.sql1.replace('zpjt','city');
       //  //                 $scope.sql1+=',city';
       //  //                 $scope.sql2+=',city';
       //  //                 break;
       //  //         }
       //  //         switch(skutype){
       //  //             case 1:
       //  //                 $scope.sql1+=',type';
       //  //                 $scope.sql2+=',type';
       //  //                 break;
       //  //             case 2:
       //  //                 $scope.sql1=$scope.sql1.replace('type','manu');
       //  //                 $scope.sql1+=',manu';
       //  //                 $scope.sql2+=',manu';
       //  //                 break;
       //  //             case 3:
       //  //                 $scope.sql1=$scope.sql1.replace('type','pinpai');
       //  //                 $scope.sql1+=',pinpai';
       //  //                 $scope.sql2+=',pinpai';
       //  //                 break;
       //  //         }
       //  //     }
       //  //     else if(isgrading==0){
       //  //         switch(citytype){
       //  //             case 1:
       //  //                 $scope.sql1+=' ,zpjt';
       //  //                 $scope.sql2+=' ,zpjt';
       //  //                 break;
       //  //             case 2:
       //  //                 $scope.sql2=$scope.sql2.replace('zpjt','zpc');
       //  //                 $scope.sql2+=' ,zpc';
       //  //                 $scope.sql2+=' ,zpc';
       //  //                 break;
       //  //             case 3:
       //  //                 $scope.sql1=$scope.sql1.replace('zpjt','city');
       //  //                 $scope.sql1+=',city';
       //  //                 $scope.sql2+=',city';
       //  //                 break;
       //  //         }
       //  //         switch(skutype){
       //  //             case 1:
       //  //                 $scope.sql1+=',type';
       //  //                 $scope.sql2+=',type';
       //  //                 break;
       //  //             case 2:
       //  //                 $scope.sql1=$scope.sql1.replace('type','manu');
       //  //                 $scope.sql1+=',manu';
       //  //                 $scope.sql2+=',manu';
       //  //                 break;
       //  //             case 3:
       //  //                 $scope.sql1=$scope.sql1.replace('type','pinpai');
       //  //                 $scope.sql1+=',pinpai';
       //  //                 $scope.sql2+=',pinpai';
       //  //                 break;
       //  //
       //  //         }
       //  //
       //  //     }
       //  //     if(iscityleveltype==0){
       //  //         $scope.sql1=$scope.sql1.replace(',city_level',' ');
       //  //     }
       //  //         getData.getHttp($scope.sql1).then(function (data) {
       //  //             var temp = data.results;
       //  //             var arr = [];
       //  //             for (var i = 0; i < temp.length; i++) {
       //  //                 let ai = temp[i];
       //  //                 //console.log('ai',ai);
       //  //                 var group='';
       //  //                 if(isgrading==0){
       //  //                     group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3];
       //  //                     if(iscityleveltype==1){
       //  //                         group = ai[1] + '-' + ai[4] + '-' + ai[2] + '-' + ai[3];
       //  //                     }
       //  //                 }
       //  //
       //  //                 else{
       //  //                     group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]+ '-' +ai[4];
       //  //                     if(iscityleveltype==1){
       //  //                         group = ai[1] + '-' + ai[5] + '-' + ai[2] + '-' + ai[3]+ '-' +ai[4];
       //  //                     }
       //  //                 }
       //  //                 var map = {};
       //  //                 //console.log('temp',ai[0]);
       //  //                 arr.push({
       //  //                     // 'category': ai[0],
       //  //                     // 'citytype': ai[1],
       //  //                     // 'systemtype': ai[2],
       //  //                     // 'platform': ai[3],
       //  //                     'groupname': group,
       //  //                     //'distri': ai[4],
       //  //                 });
       //  //             }
       //  //             var output = [],
       //  //                 keys = [];
       //  //             angular.forEach(arr, function (item) {
       //  //                 var key = item.groupname;
       //  //
       //  //                 if (keys.indexOf(key) === -1) {
       //  //                     keys.push(key);
       //  //                     output.push(item);
       //  //                 }
       //  //             });
       //  //              $scope.bardata = output;
       //  //             console.log("数据：",$scope.bardata);
       //  //         }, function (data) {
       //  //             console.log('错了',data);
       //  //         });
       //  //
       //  //
       //  // }
       //  //折线图配置项
        $scope.lineoption = {
            title: {
                text: '未来一周气温变化',
                subtext: '纯属虚构'
            },
            tooltip: {
                trigger: 'axis',
            },
            grid: {
                height: "70%"
            },
            legend: {
                itemWidth: 10,
                itemHeight: 10,
                // left: 180,
                // width: 300,
                icon: 'circle',
                data: [],
                // orient: 'vertical',
                bottom: 5
            },
            toolbox: {
                right: 30,
                feature: {
                    saveAsImage: {},
                    myExcel: {
                        show: true,
                        title: "导出CSV",
                        icon: "image://http://echarts.baidu.com/images/favicon.png",
                        onclick: function (opts) {
                            var series = opts.option.series; //折线图数据
                            var axisData = opts.option.xAxis[0].data; //坐标数据
                            console.log(series, opts);
                            var title = opts.option.title[0].text;
                            var str = '时间,期数,';
                            //组装表头
                            for (var product = 0; product < series.length; product++) {
                                // str += series[product].name + `,`;
                                str += series[product].name + ',';
                            }
                            str += '\n';
                            //组装表数据
                            for (var lt = 0; lt < axisData.length; lt++) {//axisData坐标数据
                                var arr = axisData[lt].split("_");
                                var time = "";
                                var stage = "";
                                //分离时间和期数
                                for (var nt = 0; nt < arr.length; nt++) {
                                    time = arr[0] + "-" + arr[1];
                                    stage = arr[2];
                                }
                                // str += time + `,` + stage + `,`;
                                str += time + ',' + stage + ',';
                                //详细数据
                                for (var j = 0; j < series.length; j++) {
                                    var temp = series[j].data[lt];
                                    if (temp != null && temp != undefined) {
                                        str += temp.toFixed(4) + ',';
                                    } else {
                                        str += '';
                                    }
                                }
                                str += '\n';
                            }
                            //encodeURIComponent解决中文乱码
                            let uri = 'data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(str);
                            //通过创建a标签实现
                            var link = document.createElement("a");
                            link.href = uri;
                            //对下载的文件命名
                            link.download = title + ".csv";
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                    }
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                axisLabel: {
                    formatter: '{value}'
                },
                data: ['2018-11', '2018-12']
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    formatter: '{value}'
                },
                splitLine: {show: false},
            },
            //series: []
            series:[
                {
                    name:'邮件营销',
                    type:'line',
                    stack: '总量',
                    data:[120, 132, 101, 134, 90, 230, 210]
                },
                {
                    name:'联盟广告',
                    type:'line',
                    stack: '总量',
                    data:[220, 182, 191, 234, 290, 330, 310]
                },
                {
                    name:'视频广告',
                    type:'line',
                    stack: '总量',
                    data:[150, 232, 201, 154, 190, 330, 410]
                },
                {
                    name:'直接访问',
                    type:'line',
                    stack: '总量',
                    data:[320, 332, 301, 334, 390, 330, 320]
                },
                {
                    name:'搜索引擎',
                    type:'line',
                    stack: '总量',
                    data:[820, 932, 901, 934, 1290, 1330, 1320]
                }
            ]
        };
        $scope.lineoptionlist=[];
        $scope.getLineData1 = function () {
            // console.log('jjjjj');
            // $('<div>', {
            //     class: 'mb-fff'
            // }).appendTo('#chart-view');
            // $scope.lastbasesql
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let systemtype = $scope.deepsystemcheck == 'systemtype' ? 1 : $scope.deepsystemcheck == 'system' ? 2 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let platform = $scope.deepplatformcheck == 'platform' ? 1 : null;
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let kpichecked = $scope.kpichecked;
            if(isgrading==1){
                angular.forEach($scope.capacitylist,function (item,index,array) {
                    $scope.capacitylist[index].checked=1;
                });
                switch(citytype){
                    case 1:
                        $scope.queryfield='select type,zpjt,channel,platform,city_level,level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,zpjt,level';
                        $scope.condition1='where zpjt in (\'SCCL\',\'ZH\',\'CBL\')'; //第一个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield='select type,zpc,channel,platform,city_level,level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,zpc,level';
                        $scope.condition1='where zpc in ()'; //第一个分组的where条件
                        break;
                    case 3:
                        $scope.queryfield='select type,city,channel,platform,city_level,level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,city,level';
                        $scope.condition1='where city in ()'; //第一个分组的where条件
                        break;
                }
                switch(skutype){
                    case 1:
                        $scope.condition4=' and type in (\'乳味饮料\',\'功能饮料\',\'咖啡\',\'果汁饮料\' ,\'植物蛋白饮料\',\'植物饮料\' ,\'水\',\'汽水\' ,\'组合\',\'茶\' )';//第四个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield=$scope.queryfield.replace('type','manu');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','manu');
                        $scope.condition4='and manu in ()';
                        break;
                    case 3:
                        $scope.queryfield=$scope.queryfield.replace('type','pinpai');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','pinpai');
                        $scope.condition4='and pinpai in ()';
                        break;
                }
                $scope.condition5='and level in (\'SMS(801-1250ml)\',\'MS(1251-2000ml)\',\'SS(401-800ml)\',\'其他\',\'LMS(2001-3000ml)\',\'SSS(0-400ml)\',\'BULK（3L, above）\')';

            }
            else if(isgrading==2){
                angular.forEach($scope.bottlelist,function (item,index,array) {
                    $scope.bottlelist[index].checked=1;
                });
                switch(citytype){
                    case 1:
                        $scope.queryfield='select type,zpjt,channel,platform,city_level,pack_level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,zpjt,pack_level';
                        $scope.condition1='where zpjt in (\'SCCL\',\'ZH\',\'CBL\')'; //第一个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield='select type,zpc,channel,platform,city_level,pack_level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,zpc,pack_level';
                        $scope.condition1='where zpc in ()'; //第一个分组的where条件
                        break;
                    case 3:
                        $scope.queryfield='select type,city,channel,platform,city_level,pack_level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,city,pack_level';
                        $scope.condition1='where city in ()'; //第一个分组的where条件
                        break;
                }
                switch(skutype){
                    case 1:
                        $scope.condition4=' and type in (\'乳味饮料\',\'功能饮料\',\'咖啡\',\'果汁饮料\' ,\'植物蛋白饮料\',\'植物饮料\' ,\'水\',\'汽水\' ,\'组合\',\'茶\' )';//第四个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield=$scope.queryfield.replace('type','manu');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','manu');
                        $scope.condition4='and manu in ()';
                        break;
                    case 3:
                        $scope.queryfield=$scope.queryfield.replace('type','pinpai');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','pinpai');
                        $scope.condition4='and pinpai in ()';
                        break;
                }
                $scope.condition5="and pack_level in (\'整箱装\',\'其他\',\'多瓶装\',\'单瓶装\')";

            }
            else if(isgrading==0){
                switch(citytype){
                    case 1:
                        $scope.queryfield='select type,zpjt,channel,platform,city_level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,zpjt';
                        $scope.condition1='where zpjt in (\'SCCL\',\'ZH\',\'CBL\')'; //第一个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield='select type,zpc,channel,platform,city_level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,zpc';
                        $scope.condition1='where zpc in ()'; //第一个分组的where条件
                        break;
                    case 3:
                        $scope.queryfield='select type,city,channel,platform,city_level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,city';
                        $scope.condition1='where city in ()'; //第一个分组的where条件
                        break;
                }
                switch(skutype){
                    case 1:
                        $scope.condition4=' and type in (\'乳味饮料\',\'功能饮料\',\'咖啡\',\'果汁饮料\' ,\'植物蛋白饮料\',\'植物饮料\' ,\'水\',\'汽水\' ,\'组合\',\'茶\' )';//第四个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield=$scope.queryfield.replace('type','manu');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','manu');
                        $scope.condition4='and manu in ()';
                        break;
                    case 3:
                        $scope.queryfield=$scope.queryfield.replace('type','pinpai');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','pinpai');
                        $scope.condition4='and pinpai in ()';
                        break;
                }
            }
            if(iscityleveltype==0){
                $scope.citylevelcon='';
                $scope.sql1=$scope.queryfield+$scope.condition1+$scope.citylevelcon+$scope.condition2+$scope.condition3+$scope.condition4+$scope.condition5+$scope.groupbyfield;
                $scope.sql1=$scope.sql1.replace(',city_level',' ');
            }
            else {
                angular.forEach($scope.cityclasslist,function (item,index,array) {
                    $scope.cityclasslist[index].checked=1;
                });
                $scope.citylevelcon='and city_level in (\'Metro\',\'U1\',\'U2\')'; //第一个分组的where条件
            }
            $scope.sql1=$scope.sql1.replace('(,','(');
            $scope.sql1=$scope.sql1.replace('in ()',"in (\'\')");
            //console.log('$scope.sql1测试getparams',$scope.sql1);
            getData.getHttp($scope.sql1).then(function (data){
                var temp = data.results;
                var arr = [];
                for (var i = 0; i < temp.length; i++) {
                    let ai = temp[i];
                    var group='';
                    //容量分级和瓶量分级均未选择
                    if(isgrading==0){
                        group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]; //装瓶集团（装瓶厂、城市）- 全部（城市等级） - 渠道 - 平台
                        if(iscityleveltype==1){
                            group = ai[1] + '-' + ai[4] + '-' + ai[2] + '-' + ai[3]; //装瓶集团（装瓶厂、城市）- 城市等级 - 渠道 - 平台
                        }
                    }
                    //选择了容量分级或瓶量分级
                    else{
                        group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]+ '-' +ai[0]; //装瓶集团（装瓶厂、城市）-全部（城市等级）-渠道-平台-品类（制造商、品牌）
                        if(iscityleveltype==1){
                            group = ai[1] + '-' + ai[4] + '-' + ai[2] + '-' + ai[3]+ '-' +ai[0];//装瓶集团（装瓶厂、城市）-城市等级-渠道-平台-品类（制造商、品牌）
                        }
                    }
                    var map = {};
                    arr.push({
                        // 'category': ai[0],
                        // 'citytype': ai[1],
                        // 'systemtype': ai[2],
                        // 'platform': ai[3],
                        'groupname': group,
                        //'distri': ai[4],
                    });
                }
                var output = [],
                    keys = [];
                angular.forEach(arr, function (item) {
                    var key = item.groupname;
                    if (keys.indexOf(key) === -1) {
                        keys.push(key);
                        output.push(item);
                    }
                });
                $scope.linedata = output;
                console.log('测试子选项请求数据',$scope.linedata);
            },function (data) {
                console.log(data);
            });
            // $http({
            //     url: '',
            //     //params: config
            // }).success(function (res) {
            //     console.log('折线图数据&双折线数据', res);
            //     $scope.all_skuinfos = res;
            //     $scope.visitab = $scope.visitab3;
            //     $('.mb-fff').remove();
            // }).error(function (data, header, config, status) {
            //     $('.mb-fff').remove();
            // });
        };
        $scope.getLineData=function(){
            //重新请求数据时需要改变$scope.basesql的值
            console.log('month',$scope.month);
            console.log('lastmonth',$scope.lastmonth);
            /*$('<div>', {
                class: 'mb-fff'
            }).appendTo('#chart-view');*/
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let kpichecked = $scope.kpichecked;
            if(isgrading==1){
                angular.forEach($scope.capacitylist,function (item,index,array) {
                    $scope.capacitylist[index].checked=1;
                });
                switch(citytype){
                    case 1:
                        $scope.queryfield='select type,zpjt,channel,platform,city_level,level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,zpjt,level';
                        $scope.condition1='where zpjt in (\'SCCL\',\'ZH\',\'CBL\')'; //第一个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield='select type,zpc,channel,platform,city_level,level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,zpc,level';
                        $scope.condition1='where zpc in ()'; //第一个分组的where条件
                        break;
                    case 3:
                        $scope.queryfield='select type,city,channel,platform,city_level,level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,city,level';
                        $scope.condition1='where city in ()'; //第一个分组的where条件
                        break;
                }
                switch(skutype){
                    case 1:
                        $scope.condition4=' and type in (\'乳味饮料\',\'功能饮料\',\'咖啡\',\'果汁饮料\' ,\'植物蛋白饮料\',\'植物饮料\' ,\'水\',\'汽水\' ,\'组合\',\'茶\' )';//第四个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield=$scope.queryfield.replace('type','manu');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','manu');
                        $scope.condition4='and manu in ()';
                        break;
                    case 3:
                        $scope.queryfield=$scope.queryfield.replace('type','pinpai');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','pinpai');
                        $scope.condition4='and pinpai in ()';
                        break;
                }
                $scope.condition5='and level in (\'SMS(801-1250ml)\',\'MS(1251-2000ml)\',\'SS(401-800ml)\',\'其他\',\'LMS(2001-3000ml)\',\'SSS(0-400ml)\',\'BULK （3L, above）\')';

            }
            else if(isgrading==2){
                angular.forEach($scope.bottlelist,function (item,index,array) {
                    $scope.bottlelist[index].checked=1;
                });
                switch(citytype){
                    case 1:
                        $scope.queryfield='select type,zpjt,channel,platform,city_level,pack_level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,zpjt,pack_level';
                        $scope.condition1='where zpjt in (\'SCCL\',\'ZH\',\'CBL\')'; //第一个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield='select type,zpc,channel,platform,city_level,pack_level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,zpc,pack_level';
                        $scope.condition1='where zpc in ()'; //第一个分组的where条件
                        break;
                    case 3:
                        $scope.queryfield='select type,city,channel,platform,city_level,pack_level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,city,pack_level';
                        $scope.condition1='where city in ()'; //第一个分组的where条件
                        break;
                }
                switch(skutype){
                    case 1:
                        $scope.condition4=' and type in (\'乳味饮料\',\'功能饮料\',\'咖啡\',\'果汁饮料\' ,\'植物蛋白饮料\',\'植物饮料\' ,\'水\',\'汽水\' ,\'组合\',\'茶\' )';//第四个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield=$scope.queryfield.replace('type','manu');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','manu');
                        $scope.condition4='and manu in ()';
                        break;
                    case 3:
                        $scope.queryfield=$scope.queryfield.replace('type','pinpai');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','pinpai');
                        $scope.condition4='and pinpai in ()';
                        break;
                }
                $scope.condition5="and pack_level in (\'整箱装\',\'其他\',\'多瓶装\',\'单瓶装\')";

            }
            else if(isgrading==0){
                switch(citytype){
                    case 1:
                        $scope.queryfield='select type,zpjt,channel,platform,city_level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,zpjt';
                        $scope.condition1='where zpjt in (\'SCCL\',\'ZH\',\'CBL\')'; //第一个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield='select type,zpc,channel,platform,city_level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,zpc';
                        $scope.condition1='where zpc in ()'; //第一个分组的where条件
                        break;
                    case 3:
                        $scope.queryfield='select type,city,channel,platform,city_level from '+$scope.basesql;
                        $scope.groupbyfield='group by channel,platform,city_level,type,city';
                        $scope.condition1='where city in ()'; //第一个分组的where条件
                        break;
                }
                switch(skutype){
                    case 1:
                        $scope.condition4=' and type in (\'乳味饮料\',\'功能饮料\',\'咖啡\',\'果汁饮料\' ,\'植物蛋白饮料\',\'植物饮料\' ,\'水\',\'汽水\' ,\'组合\',\'茶\' )';//第四个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield=$scope.queryfield.replace('type','manu');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','manu');
                        $scope.condition4='and manu in ()';
                        break;
                    case 3:
                        $scope.queryfield=$scope.queryfield.replace('type','pinpai');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','pinpai');
                        $scope.condition4='and pinpai in ()';
                        break;
                }
            }
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            if(iscityleveltype==0){
                $scope.citylevelcon='';
                var r = new RegExp(',city_level' , "g" );
                $scope.queryfield=$scope.queryfield.replace(r,'');
                $scope.groupbyfield=$scope.groupbyfield.replace(r,'');
                // $scope.sql1=$scope.sql1.replace(r,'');
            }
            else {
                angular.forEach($scope.cityclasslist,function (item,index,array) {
                    $scope.cityclasslist[index].checked=1;
                });
                $scope.citylevelcon='and city_level in (\'Metro\',\'U1\',\'U2\')'; //第一个分组的where条件
            }
            $scope.sql1=$scope.queryfield+$scope.condition1+$scope.citylevelcon+$scope.condition2+$scope.condition3+$scope.condition4+$scope.condition5+$scope.groupbyfield;
            $scope.sql1=$scope.sql1.replace('(,','(');
            $scope.sql1=$scope.sql1.replace('in ()',"in (\'\')");
            //console.log('$scope.sql1测试getparams',$scope.sql1);
            getData.getHttp($scope.sql1).then(function (data){
                var temp = data.results;
                var arr = [];
                for (var i = 0; i < temp.length; i++){
                    let ai = temp[i];
                    var group='';
                    //容量分级和瓶量分级均未选择
                    if(isgrading==0){
                        group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]; //装瓶集团（装瓶厂、城市）- 全部（城市等级） - 渠道 - 平台
                        // console.log(group);
                        if(iscityleveltype==1){
                            group = ai[1] + '-' + ai[4] + '-' + ai[2] + '-' + ai[3]; //装瓶集团（装瓶厂、城市）- 城市等级 - 渠道 - 平台
                        }
                    }
                    //选择了容量分级或瓶量分级
                    else{
                        group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]+ '-' +ai[0]; //装瓶集团（装瓶厂、城市）-全部（城市等级）-渠道-平台-品类（制造商、品牌）
                        if(iscityleveltype==1){
                            group = ai[1] + '-' + ai[4] + '-' + ai[2] + '-' + ai[3]+ '-' +ai[0];//装瓶集团（装瓶厂、城市）-城市等级-渠道-平台-品类（制造商、品牌）
                        }
                    }
                    var map = {};
                    //console.log('temp',ai[0]);
                    arr.push({
                        // 'category': ai[0],
                        // 'citytype': ai[1],
                        // 'systemtype': ai[2],
                        // 'platform': ai[3],
                        'groupname': group,
                        //'distri': ai[4],
                    });
                }
                var output = [],
                    keys = [];
                angular.forEach(arr, function (item) {
                    var key = item.groupname;
                    if (keys.indexOf(key) === -1) {
                        keys.push(key);
                        output.push(item);
                        // console.log(output);
                    }
                });
                $scope.linedata = output;
                console.log('jkhjkjj',$scope.linedata);

                // angular.forEach($scope.linedata,function (item,i,array) {
                //      $scope.setlineoption(item.groupname,i);
                // });

                // switch($scope.visitab){
                //     case 'distribution':
                //     case 'price_promotion_ratio':
                //     case 'average_discount_factor':
                //         angular.forEach($scope.bardata1,function (item,i,array) {
                //             $scope.test(item.groupname,i);
                //         });
                //         break;
                //     case 'distribution_store':
                //         $scope.setstackbaroption('distribution_store');
                //         console.log('tempitem');
                //         break;
                //     case 'average_selling_price':
                //         $scope.setstackbaroption('average_selling_price');
                //         break;
                //     case 'average_purchase_price':
                //         $scope.setstackbaroption('average_purchase_price');
                //         break;
                //     case 'store_money':
                //         $scope.setstackbaroption('store_money');
                //         break;
                //     case 'store_number':
                //         $scope.setstackbaroption('store_number');
                //         break;
                //     case 'average_amount_per_order':
                //         $scope.setstackbaroption('average_amount_per_order');
                //
                //         break;
                //     case 'saleroom':
                //         angular.forEach($scope.bardata1,function (item,i,array) {
                //             $scope.setlineBaroption(item.groupname,i);
                //         });
                //         break;
                //     case 'sales_numbers':
                //         angular.forEach($scope.bardata1,function (item,i,array) {
                //             $scope.setlineBaroption(item.groupname,i);
                //         });
                //
                //         break;
                //
                // }
                // $('.mb-fff').remove();
                // console.log('测试子选项请求数据',$scope.bardata1);

            },function (data) {
                console.log(data);
                // $('.mb-fff').remove();
            });

        }
        $scope.setlineoption = function (groupname,index){
            $scope.lineoptionlist[index] = {
                title: {
                    text: '未来一周气温变化',
                    subtext: '纯属虚构'
                },
                tooltip: {
                    trigger: 'axis',
                },
                grid: {
                    height: "70%"
                },
                legend: {
                    itemWidth: 10,
                    itemHeight: 10,
                    // left: 180,
                    // width: 300,
                    icon: 'circle',
                    data: [],
                    // orient: 'vertical',
                    bottom: 5
                },
                toolbox: {
                    right: 30,
                    feature: {
                        saveAsImage: {},
                        myExcel: {
                            show: true,
                            title: "导出CSV",
                            icon: "image://http://echarts.baidu.com/images/favicon.png",
                            onclick: function (opts) {
                                var series = opts.option.series; //折线图数据
                                var axisData = opts.option.xAxis[0].data; //坐标数据
                                console.log(series, opts);
                                var title = opts.option.title[0].text;
                                var str = '时间,期数,';
                                //组装表头
                                for (var product = 0; product < series.length; product++) {
                                    // str += series[product].name + `,`;
                                    str += series[product].name + ',';
                                }
                                str += '\n';
                                //组装表数据
                                for (var lt = 0; lt < axisData.length; lt++) {//axisData坐标数据
                                    var arr = axisData[lt].split("_");
                                    var time = "";
                                    var stage = "";
                                    //分离时间和期数
                                    for (var nt = 0; nt < arr.length; nt++) {
                                        time = arr[0] + "-" + arr[1];
                                        stage = arr[2];
                                    }
                                    // str += time + `,` + stage + `,`;
                                    str += time + ',' + stage + ',';
                                    //详细数据
                                    for (var j = 0; j < series.length; j++) {
                                        var temp = series[j].data[lt];
                                        if (temp != null && temp != undefined) {
                                            // str += temp.toFixed(4) + `,`;
                                            str += temp.toFixed(4) + ',';
                                        } else {
                                            str += '';
                                        }
                                    }
                                    str += '\n';
                                }
                                //encodeURIComponent解决中文乱码
                                let uri = 'data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(str);
                                //通过创建a标签实现
                                var link = document.createElement("a");
                                link.href = uri;
                                //对下载的文件命名
                                link.download = title + ".csv";
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }
                        }
                    }
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    axisLabel: {
                        formatter: '{value}'
                    },
                    data: ['2018-11', '2018-12']
                },
                yAxis: {
                    type: 'value',
                    axisLabel: {
                        formatter: '{value}'
                    },
                    splitLine: {show: false},
                },
                //series: []
                series:[]
            };
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let kpichecked = $scope.kpichecked;
            var params=groupname.split('-');
            let condition01='';
            let groupbyfield01='group by channel,platform';
            switch(citytype){
                case 1:
                    condition01+=' zpjt='+'\''+params[0]+'\'';
                    groupbyfield01+=',zpjt ';
                    break;
                case 2:
                    condition01+=' zpc='+'\''+params[0]+'\'';
                    groupbyfield01+=',zpc ';
                    break;
                case 3:
                    condition01+=' city='+'\''+params[0]+'\'';
                    groupbyfield01+=',city ';
                    break;
            }
            let comparelist=new Array();
            let count=0;
            if($scope.visitab=='distribution'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesqlline('count(distinct storeid) storeid ','type,storeid,dt',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesqlline('count(distinct storeid) storeid ','type,storeid,dt',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesqlline('count(distinct storeid) storeid ','type,storeid,dt',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesqlline('count(distinct storeid) storeid ','type,storeid,dt',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesqlline('count(distinct storeid) storeid ','type,storeid,dt',groupname,index,comparelist);
                            break;
                    }

                }

            }
        }
        // $scope.ischeckGrading = function (level) {
        //
        //     switch (level) {
        //         case 1://容量分级
        //             $scope.bottlecheck = false;
        //             $scope.isbottle = 'unchecked';
        //             if($scope.capacitycheck){
        //                 $scope.capacitycheck = false;
        //                 $scope.iscapacity = 'unchecked';
        //                 document.getElementById("isGrading").style.display = "none";
        //             }
        //             else{
        //                 $scope.capacitycheck = true;
        //                 $scope.iscapacity = 'ischecked';
        //                 $scope.deepgradingcheck='capacity';
        //                 document.getElementById("isGrading").style.display = "";
        //             }
        //             $scope.getChartsData();
        //             break;
        //         case 2://瓶量分级
        //             $scope.capacitycheck = false;
        //             $scope.iscapacity = 'unchecked';
        //             if ($scope.bottlecheck) {
        //                 $scope.bottlecheck = false;
        //                 $scope.isbottle = 'unchecked';
        //                 document.getElementById("isGrading").style.display = "none";
        //             }
        //             else {
        //                 $scope.bottlecheck = true;
        //                 $scope.isbottle = 'ischecked';
        //                 $scope.deepgradingcheck='bottle';
        //                 document.getElementById("isGrading").style.display = "";
        //             }
        //             $scope.getChartsData();
        //             break;
        //     }
        // };
        $scope.ischeckGrading = function (level) {
            if(level==1){
                $scope.bottlecheck = false;
                if ($scope.capacitycheck){
                    $scope.capacitycheck = false;
                    document.getElementById("isGrading").style.display = "none";
                }
                else{
                    $scope.capacitycheck = true;
                    document.getElementById("isGrading").style.display = "";
                }
            }
            else if(level==2){
                $scope.capacitycheck = false;
                if ($scope.bottlecheck){
                    $scope.bottlecheck = false;
                    document.getElementById("isGrading").style.display = "none";
                }
                else{
                    $scope.bottlecheck = true;
                    document.getElementById("isGrading").style.display = "";
                }
            }
            $scope.getChartsData();
        };
        $scope.tabchange = function (tab) {
            console.log('tab',tab);
            console.log('$scope.visitab',$scope.visitab);
            if ($scope.visitab == tab){
                return false;
            }
            $scope.visitab = tab;
            // if($scope.visitab=='distribution_store'){
            //     $scope.setstackbaroption();
            //     console.log('HJHJKJ');
            // }
            //$scope.kpichecked = kpichecked;
            //pieChartsChange();
            // $scope.allskuinfos = $scope.allskuinfos2 = [];
            //$scope.visitab3 = tab;
            //$scope.getChartsData();
            //brandsreadonlycheck();

        };
        $scope.getChartsData = function (fig) {
            $scope.deepgroupcheckChang();
            $scope.deepbrandcheckChang(fig);//改变$scope.deepbrandcheck的值
            console.log('deepgroupcheck',$scope.deepgroupcheck);
            $scope.basesql='(select zpjt,\'全部\' city_level,platform,channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type from (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel union\n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type union\n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type union \n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt union \n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel union \n' +
                'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type union \n' +
                'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform union \n' +
                'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel union \n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') \n)';
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            if(isgrading!=0){

                // function  将勾中的框进行组合得到所有组合的集合
                // function 2 遍历组合，sql查询，
                // function3将结果拼接或结果输出echarts
                $scope.basesql='(select zpjt,\'全部\' city_level,platform,channel,type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type,level   from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,level union\n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type,level union\n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type,level union \n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,level union \n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,level union \n' +
                    'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type,level union \n' +
                    'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,level union \n' +
                    'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,level union \n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by level union \n' +
                    'select zpjt,\'全部\' city_level,platform,channel,type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type,\'全部\' level   from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel union\n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type union\n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type union \n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt union \n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel union \n' +
                    'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type union \n' +
                    'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform union \n' +
                    'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel union \n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') \n)';


                if(iscityleveltype==1){
                    $scope.basesql='(select zpjt,\'全部\' city_level,platform,channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,level union\n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type,level union\n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type,level union \n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,level union \n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,level union \n' +
                        'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type,level union \n' +
                        'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,level union \n' +
                        'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,level union \n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by level union \n' +
                        'select zpjt,\'全部\' city_level,platform,channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type,union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel union\n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type union\n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type union \n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt union \n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel union \n' +
                        'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type union \n' +
                        'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform union \n' +
                        'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel union \n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') union \n'+
                        'select zpjt,city_level,platform,channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type,level union\n' +
                        'select \'全部\' zpjt,city_level,platform,channel,type,level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type,level,city_level union\n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type,level,city_level union\n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,\'全部\' channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type,level,city_level union\n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,level,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform, \'全部\' channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type,level,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform, \'全部\' channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,level,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform,channel, \'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,level,city_level union\n' +
                        'select zpjt,city_level,\'全部\' platform,channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type,level,city_level union\n' +
                        'select zpjt,city_level,\'全部\' platform,\'全部\' channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type,level,city_level union \n' +
                        'select zpjt,city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,level,city_level union \n' +
                        'select zpjt,city_level,\'全部\' platform,channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,level,city_level union \n' +
                        'select zpjt,city_level,platform,\'全部\' channel,type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type,level,city_level union \n' +
                        'select zpjt,city_level,platform,\'全部\' channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,level,city_level union \n' +
                        'select zpjt,city_level, platform,channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,level,city_level union \n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by level,city_level union \n' +
                        'select zpjt,city_level,platform,channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform,channel,type,\'全部\' level  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type,city_level union\n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type,city_level union\n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,\'全部\' channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type,city_level union\n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform, \'全部\' channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform, \'全部\' channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform,channel, \'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,city_level union\n' +
                        'select zpjt,city_level,\'全部\' platform,channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type,city_level union\n' +
                        'select zpjt,city_level,\'全部\' platform,\'全部\' channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type,city_level union \n' +
                        'select zpjt,city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,city_level union \n' +
                        'select zpjt,city_level,\'全部\' platform,channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,city_level union \n' +
                        'select zpjt,city_level,platform,\'全部\' channel,type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type,city_level union \n' +
                        'select zpjt,city_level,platform,\'全部\' channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,city_level union \n' +
                        'select zpjt,city_level, platform,channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,city_level union \n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,\'全部\' level from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by city_level\n)';

                }
                if(isgrading==2){
                    var reg3 = new RegExp('level' , "g" );
                    $scope.basesql=$scope.basesql.replace(reg3,'pack_level');
                }
            }
            if(isgrading==0 && iscityleveltype==1){
                $scope.basesql='(select zpjt,\'全部\' city_level,platform,channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel union\n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type union\n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type union \n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt union \n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel union \n' +
                    'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type union \n' +
                    'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform union \n' +
                    'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel union \n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') union \n' +
                    'select zpjt,city_level,platform,channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type,city_level union \n' +
                    'select \'全部\' zpjt,city_level,platform,channel,type  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type,city_level union\n' +
                    'select \'全部\' zpjt,city_level, \'全部\' platform,channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type,city_level union\n' +
                    'select \'全部\' zpjt,city_level, \'全部\' platform,\'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type,city_level union\n' +
                    'select \'全部\' zpjt,city_level, \'全部\' platform,channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,city_level union\n' +
                    'select \'全部\' zpjt,city_level,platform, \'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type,city_level union\n' +
                    'select \'全部\' zpjt,city_level,platform, \'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,city_level union\n' +
                    'select \'全部\' zpjt,city_level,platform,channel, \'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,city_level union\n' +
                    'select zpjt,city_level,\'全部\' platform,channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type,city_level union\n' +
                    'select zpjt,city_level,\'全部\' platform,\'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type,city_level union \n' +
                    'select zpjt,city_level,\'全部\' platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,city_level union \n' +
                    'select zpjt,city_level,\'全部\' platform,channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,city_level union \n' +
                    'select zpjt,city_level,platform,\'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type,city_level union \n' +
                    'select zpjt,city_level,platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,city_level union \n' +
                    'select zpjt,city_level, platform,channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,city_level union \n' +
                    'select \'全部\' zpjt,city_level, \'全部\' platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by city_level \n)';
            }
            var reg1 = new RegExp( 'zpjt' , "g" );
            switch(citytype){
                case 2:
                    $scope.basesql=$scope.basesql.replace(reg1,'zpc');
                    break;
                case 3:
                    $scope.basesql=$scope.basesql.replace(reg1,'city');
                    break;
                default:
                    break;
            }
            var reg2 = new RegExp('type' , "g" );
            switch(skutype){
                case 2:
                    $scope.basesql=$scope.basesql.replace(reg2,'manu');
                    break;
                case 3:
                    $scope.basesql=$scope.basesql.replace(reg2,'pinpai');
                    break;
                default:
                    break;
            }
            $scope.basesqllist=[];
            $scope.basesqllist.push($scope.basesql);

            let regex1 = new RegExp('2018-12-01' , "g" );
            var baseitem1=$scope.basesql.replace(regex1,'2018-11-01');
            let regex2 = new RegExp('2019-01-0' , "g" );
            baseitem1=baseitem1.replace(regex2,'2018-12-0');
            $scope.basesqllist.push(baseitem1);
            //  console.log('$scope.basesqllist',$scope.basesqllist);
            if ($scope.history[$scope.visitab] == 1) {
                $scope.getLineData();
            } else {
                $scope.getBarData();
            }
        };
        $scope.getChartsData1 = function (fig) {
            $scope.deepgroupcheckChang();
            $scope.deepbrandcheckChang(fig);//改变$scope.deepbrandcheck的值
            console.log('deepgroupcheck',$scope.deepgroupcheck);
            $scope.basesql='(select zpjt,\'全部\' city_level,platform,channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type from (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel union\n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type union\n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type union \n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt union \n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel union \n' +
                'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type union \n' +
                'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform union \n' +
                'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel union \n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') \n)';

            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            if ($scope.history[$scope.visitab] == 1) {
                $scope.getLineData();
            } else {
                $scope.getBarData();
            }
        }
        $scope.getChartsData0 = function (fig) {
            $scope.deepgroupcheckChang();
            $scope.deepbrandcheckChang(fig);//改变$scope.deepbrandcheck的值
            console.log('deepgroupcheck',$scope.deepgroupcheck);
            $scope.basesql='(select zpjt,\'全部\' city_level,platform,channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform union\n' +
                'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel union\n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type union\n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type union \n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt union \n' +
                'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel union \n' +
                'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type union \n' +
                'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform union \n' +
                'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel union \n' +
                'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') \n)';
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            if(isgrading!=0){

                // function  将勾中的框进行组合得到所有组合的集合
            // function 2 遍历组合，sql查询，
                // function3将结果拼接或结果输出echarts

                $scope.basesql='(select zpjt,\'全部\' city_level,platform,channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,level union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,level union\n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type,level union\n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type,level union \n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,level union \n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,level union \n' +
                    'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type,level union \n' +
                    'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,level union \n' +
                    'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,level union \n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by level union \n' +
                    'select zpjt,\'全部\' city_level,platform,channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel union\n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type union\n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type union \n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt union \n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel union \n' +
                    'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type union \n' +
                    'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform union \n' +
                    'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel union \n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') \n)';
                if(iscityleveltype==1){
                    $scope.basesql='(select zpjt,\'全部\' city_level,platform,channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,level union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,level union\n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type,level union\n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type,level union \n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,level union \n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,level union \n' +
                        'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type,level union \n' +
                        'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,level union \n' +
                        'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,level union \n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by level union \n' +
                        'select zpjt,\'全部\' city_level,platform,channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type,union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform union\n' +
                        'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel union\n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type union\n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type union \n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt union \n' +
                        'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel union \n' +
                        'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type union \n' +
                        'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform union \n' +
                        'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel union \n' +
                        'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') union \n'+
                        'select zpjt,city_level,platform,channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type,level union\n' +
                        'select \'全部\' zpjt,city_level,platform,channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type,level,city_level union\n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type,level,city_level union\n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,\'全部\' channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type,level,city_level union\n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,level,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform, \'全部\' channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type,level,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform, \'全部\' channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,level,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform,channel, \'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,level,city_level union\n' +
                        'select zpjt,city_level,\'全部\' platform,channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type,level,city_level union\n' +
                        'select zpjt,city_level,\'全部\' platform,\'全部\' channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type,level,city_level union \n' +
                        'select zpjt,city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,level,city_level union \n' +
                        'select zpjt,city_level,\'全部\' platform,channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,level,city_level union \n' +
                        'select zpjt,city_level,platform,\'全部\' channel,type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type,level,city_level union \n' +
                        'select zpjt,city_level,platform,\'全部\' channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,level,city_level union \n' +
                        'select zpjt,city_level, platform,channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,level,city_level union \n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by level,city_level union \n' +
                        'select zpjt,city_level,platform,channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform,channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type,city_level union\n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type,city_level union\n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,\'全部\' channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type,city_level union\n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform, \'全部\' channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform, \'全部\' channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,city_level union\n' +
                        'select \'全部\' zpjt,city_level,platform,channel, \'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,city_level union\n' +
                        'select zpjt,city_level,\'全部\' platform,channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type,city_level union\n' +
                        'select zpjt,city_level,\'全部\' platform,\'全部\' channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type,city_level union \n' +
                        'select zpjt,city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,city_level union \n' +
                        'select zpjt,city_level,\'全部\' platform,channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,city_level union \n' +
                        'select zpjt,city_level,platform,\'全部\' channel,type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type,city_level union \n' +
                        'select zpjt,city_level,platform,\'全部\' channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,city_level union \n' +
                        'select zpjt,city_level, platform,channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,city_level union \n' +
                        'select \'全部\' zpjt,city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,\'全部\' level,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by city_level\n)';
                }
                if(isgrading==2){
                var reg3 = new RegExp('level' , "g" );
                $scope.basesql=$scope.basesql.replace(reg3,'pack_level');
            }
            }
            if(isgrading==0 && iscityleveltype==1){
                $scope.basesql='(select zpjt,\'全部\' city_level,platform,channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform,channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform, \'全部\' channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform union\n' +
                    'select \'全部\' zpjt,\'全部\' city_level,platform,channel, \'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel union\n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type union\n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type union \n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt union \n' +
                    'select zpjt,\'全部\' city_level,\'全部\' platform,channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel union \n' +
                    'select zpjt,\'全部\' city_level,platform,\'全部\' channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type union \n' +
                    'select zpjt,\'全部\' city_level,platform,\'全部\' channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform union \n' +
                    'select zpjt,\'全部\' city_level, platform,channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel union \n' +
                    'select \'全部\' zpjt,\'全部\' city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') union \n' +
                    'select zpjt,city_level,platform,channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,type,city_level union \n' +
                    'select \'全部\' zpjt,city_level,platform,channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total  from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,type,city_level union\n' +
                    'select \'全部\' zpjt,city_level, \'全部\' platform,channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,type,city_level union\n' +
                    'select \'全部\' zpjt,city_level, \'全部\' platform,\'全部\' channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by type,city_level union\n' +
                    'select \'全部\' zpjt,city_level, \'全部\' platform,channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by channel,city_level union\n' +
                    'select \'全部\' zpjt,city_level,platform, \'全部\' channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,type,city_level union\n' +
                    'select \'全部\' zpjt,city_level,platform, \'全部\' channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,city_level union\n' +
                    'select \'全部\' zpjt,city_level,platform,channel, \'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by platform,channel,city_level union\n' +
                    'select zpjt,city_level,\'全部\' platform,channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,type,city_level union\n' +
                    'select zpjt,city_level,\'全部\' platform,\'全部\' channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,type,city_level union \n' +
                    'select zpjt,city_level,\'全部\' platform,\'全部\' channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,city_level union \n' +
                    'select zpjt,city_level,\'全部\' platform,channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,channel,city_level union \n' +
                    'select zpjt,city_level,platform,\'全部\' channel,type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,type,city_level union \n' +
                    'select zpjt,city_level,platform,\'全部\' channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,city_level union \n' +
                    'select zpjt,city_level, platform,channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by zpjt,platform,channel,city_level union \n' +
                    'select \'全部\' zpjt,city_level, \'全部\' platform,\'全部\' channel,\'全部\' type,sum(salescount) as salescount,sum(sales_amount)as sales_amount,sum(cuxiao) as cuxiao,count(distinct storeid_copy) as storeid,sum(on_sale) as on_sale,count(*) as total from  (select * from sku_2018 where dt between\'2018-12-01\' and \'2019-01-0\') group by city_level \n)';
            }
            var reg1 = new RegExp( 'zpjt' , "g" );
            switch(citytype){
                case 2:
                    $scope.basesql=$scope.basesql.replace(reg1,'zpc');
                    break;
                case 3:
                    $scope.basesql=$scope.basesql.replace(reg1,'city');
                    break;
                default:
                    break;
            }
            var reg2 = new RegExp('type' , "g" );
            switch(skutype){
                case 2:
                    $scope.basesql=$scope.basesql.replace(reg2,'manu');
                    break;
                case 3:
                    $scope.basesql=$scope.basesql.replace(reg2,'pinpai');
                    break;
                default:
                    break;
            }
            $scope.basesqllist=[];
            $scope.basesqllist.push($scope.basesql);

            let regex1 = new RegExp('2018-12-01' , "g" );
            var baseitem1=$scope.basesql.replace(regex1,'2018-11-01');
            let regex2 = new RegExp('2019-01-0' , "g" );
            baseitem1=baseitem1.replace(regex2,'2018-12-0');
            $scope.basesqllist.push(baseitem1);
          //  console.log('$scope.basesqllist',$scope.basesqllist);
            if ($scope.history[$scope.visitab] == 1) {
                $scope.getLineData();
            } else {
                $scope.getBarData();
            }
        };
        $scope.getbelowbasesql=function(param1,param2,groupname,index,comparelist){
            // console.log('comparelist',comparelist);
            $('<div>', {
                class: 'mb-fff'
            }).appendTo('#chart-view');
            var params=groupname.split('-');
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let below_forall='';
            switch(citytype){
                case 1:
                    below_forall=(params[0]=='全部'?'(select \'全部\' zpjt,':'(select zpjt,');
                    break;
                case 2:
                    below_forall=(params[0]=='全部'?'(select \'全部\' zpc,':'(select zpc,');
                    break;
                case 3:
                    below_forall=(params[0]=='全部'?'(select \'全部\' city,':'(select city,');
                    break;
            }
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            if(iscityleveltype==1){
                below_forall+=(params[1]=='全部'?'\'全部\' city_level,':'city_level,');
            }
            below_forall+=(params[2]=='全部'?'\'全部\' channel,':'channel,');
            below_forall+=(params[3]=='全部'?'\'全部\' platform,':'platform,');
            $scope.baroptionlist[index].yAxis.data=[];
            $scope.baroptionlist[index].series[0].data=[];
            var sql='';
            if(isgrading==0){
                switch(skutype){
                    case 1:
                        // if($scope.typelist==undefined){
                        //     var now = new Date();
                        //     var exitTime = now.getTime() + 2;
                        //     while (true) {
                        //         now = new Date();
                        //         if (now.getTime() > exitTime)
                        //             return;
                        //     }
                        // }
                        // if($scope.typelist==undefined){
                        //
                        // }

                        console.log($scope.typelist);
                        if(!$scope.typelist){
                            $scope.typelist=[["咖啡"],["乳味饮料"],["果汁饮料"],["植物蛋白饮料"],["水"],["植物饮料"],["茶"],["全部"],["汽水"],["组合"],["功能饮料"]];
                        }
                        angular.forEach($scope.typelist,function (item,index,array) {
                            let skusql='';
                            if($scope.typelist[index].checked=1){
                                skusql=below_forall+(item[0]=='全部'?'\'全部\' type,':'type,');
                                skusql+=(param1+' from sku_2018 where dt=\''+$scope.month+'\'');

                                switch(citytype){
                                    case 1:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpjt,');
                                        break;
                                    case 2:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpc,');
                                        break;
                                    case 3:
                                        skusql+=(params[0]=='全部'?' group by ':' group by city,');
                                        break;
                                }
                                if(iscityleveltype==1){
                                    // console.log('xuanzhong');
                                    skusql+=(params[1]=='全部'?'':'city_level,');
                                    // console.log('xuanzhong',params[1]);
                                }
                                skusql+=(params[2]=='全部'?'':'channel,');
                                skusql+=(params[3]=='全部'?'':'platform,');
                                skusql+=(item[0]=='全部'?'':'type,');
                                skusql=skusql.replace(/(.*)[,，]$/, '$1');
                                switch(citytype){
                                    case 1:
                                        skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+item[0]+'\'';
                                        break;
                                    case 2:
                                        skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+item[0]+'\'';
                                        break;
                                    case 3:
                                        skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+item[0]+'\'';
                                        break;
                                }
                                if(iscityleveltype==1){
                                    skusql+=('and city_level=\''+params[1]+'\'');
                                }
                                sql+=(skusql+'union ');
                                console.log('sql',sql);
                            }

                        });
                        break;
                    case 2:
                        angular.forEach($scope.manulist,function (item,index,array) {
                            let skusql='';
                            if($scope.manulist[index].checked=1){
                                skusql=below_forall+(item[0]=='全部'?'\'全部\' manu,':'manu,');
                                skusql+=(param1+' from sku_2018 where dt=\''+$scope.month+'\'');

                                switch(citytype){
                                    case 1:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpjt,');
                                        break;
                                    case 2:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpc,');
                                        break;
                                    case 3:
                                        skusql+=(params[0]=='全部'?' group by ':' group by city,');
                                        break;
                                }
                                if(iscityleveltype==1){
                                    skusql+=(params[1]=='全部'?'':'city_level,');
                                }
                                skusql+=(params[2]==1?'':'channel,');
                                skusql+=(params[3]==1?'':'platform,');
                                skusql+=(item[0]=='全部'?'':'manu,');


                                skusql=skusql.replace(/(.*)[,，]$/, '$1');
                                switch(citytype){
                                    case 1:
                                        skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+item[0]+'\'';
                                        break;
                                    case 2:
                                        skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+item[0]+'\'';
                                        break;
                                    case 3:
                                        skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+item[0]+'\'';
                                        break;
                                }
                                sql+=(skusql+'union ');
                            }

                        });
                        break;
                    case 3:
                        angular.forEach($scope.pinpailist,function (item,index,array) {
                            let skusql='';
                            if($scope.pinpailist[index].checked=1){
                                skusql=below_forall+(item[0]=='全部'?'\'全部\' pinpai,':'pinpai,');
                                skusql+=(param1+' from sku_2018 where dt=\''+$scope.month+'\'');

                                switch(citytype){
                                    case 1:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpjt,');
                                        break;
                                    case 2:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpc,');
                                        break;
                                    case 3:
                                        skusql+=(params[0]=='全部'?' group by ':' group by city,');
                                        break;
                                }
                                if(iscityleveltype==1){
                                    skusql+=(params[1]=='全部'?'':'city_level,');
                                }
                                skusql+=(params[2]==1?'':'channel,');
                                skusql+=(params[3]==1?'':'platform,');
                                skusql+=(item[0]=='全部'?'':'pinpai,');


                                skusql=skusql.replace(/(.*)[,，]$/, '$1');
                                switch(citytype){
                                    case 1:
                                        skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+item[0]+'\'';
                                        break;
                                    case 2:
                                        skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+item[0]+'\'';
                                        break;
                                    case 3:
                                        skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+item[0]+'\'';
                                        break;
                                }
                                sql+=(skusql+'union ');
                            }
                            console.log(sql)

                        });
                        break;
                }
            }
            else{
                switch(skutype){
                    case 1:
                        below_forall+=(params[4]=='全部'?'\'全部\' type,':'type,');
                        break;
                    case 2:
                        below_forall+=(params[4]=='全部'?'\'全部\' manu,':'manu,');
                        break;
                    case 3:
                        below_forall+=(params[4]=='全部'?'\'全部\' pinpai,':'pinpai,');
                        break;
                }

                switch(isgrading){
                    case 1:
                        below_forall+=(item[0]=='全部'?'\'全部\' level,':'level,');
                        angular.forEach($scope.capacitylist,function (item,index,array) {
                            let skusql='';
                            if($scope.capacitylist[index].checked=1){
                                skusql=below_forall+(item[0]=='全部'?'\'全部\' level,':'level,');
                                skusql+=(param1+' from sku_2018 where dt=\''+$scope.month+'\'');
                                switch(citytype){
                                    case 1:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpjt,');
                                        break;
                                    case 2:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpc,');
                                        break;
                                    case 3:
                                        skusql+=(params[0]=='全部'?' group by ':' group by city,');
                                        break;
                                }
                                if(iscityleveltype==1){
                                    // console.log('xuanzhong');
                                    skusql+=(params[1]=='全部'?'':'city_level,');
                                    // console.log('xuanzhong',params[1]);
                                }
                                skusql+=(params[2]=='全部'?'':'channel,');
                                skusql+=(params[3]=='全部'?'':'platform,');
                                switch(skutype){
                                    case 1:
                                        skusql+=(params[4]=='全部'?'':'type,');
                                        break;
                                    case 2:
                                        skusql+=(params[4]=='全部'?'':'manu,');
                                        break;
                                    case 3:
                                        skusql+=(params[4]=='全部'?'':'pinpai,');
                                        break;
                                }
                                skusql+=(item[0]=='全部'?'':'level,');
                                skusql=skusql.replace(/(.*)[,，]$/, '$1');
                                switch(skutype){
                                    case 1:
                                        switch(citytype){
                                            case 1:
                                                skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+params[4]+'\' and level='+'\''+item[0]+'\'';
                                                break;
                                            case 2:
                                                skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                            case 3:
                                                skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                        }
                                        break;
                                    case 2:
                                        switch(citytype){
                                            case 1:
                                                skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+params[4]+'\' and level='+'\''+item[0]+'\'';
                                                break;
                                            case 2:
                                                skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                            case 3:
                                                skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                        }
                                        break;
                                    case 3:
                                        switch(citytype){
                                            case 1:
                                                skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+params[4]+'\' and level='+'\''+item[0]+'\'';
                                                break;
                                            case 2:
                                                skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                            case 3:
                                                skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                        }
                                        break;
                                }

                                if(iscityleveltype==1){
                                    skusql+=('and city_level=\''+params[1]+'\'');
                                }
                                sql+=(skusql+'union ');
                            }

                        });
                        break;
                    case 2:
                        angular.forEach($scope.bottlelist,function (item,index,array) {
                            let skusql='';
                            if($scope.bottlelist[index].checked=1){
                                skusql=below_forall+(item[0]=='全部'?'\'全部\' level,':'level,');
                                skusql+=(param1+' from sku_2018 where dt=\''+$scope.month+'\'');
                                switch(citytype){
                                    case 1:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpjt,');
                                        break;
                                    case 2:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpc,');
                                        break;
                                    case 3:
                                        skusql+=(params[0]=='全部'?' group by ':' group by city,');
                                        break;
                                }
                                if(iscityleveltype==1){
                                    // console.log('xuanzhong');
                                    skusql+=(params[1]=='全部'?'':'city_level,');
                                    // console.log('xuanzhong',params[1]);
                                }
                                skusql+=(params[2]=='全部'?'':'channel,');
                                skusql+=(params[3]=='全部'?'':'platform,');
                                switch(skutype){
                                    case 1:
                                        skusql+=(params[4]=='全部'?'':'type,');
                                        break;
                                    case 2:
                                        skusql+=(params[4]=='全部'?'':'manu,');
                                        break;
                                    case 3:
                                        skusql+=(params[4]=='全部'?'':'pinpai,');
                                        break;
                                }
                                skusql+=(item[0]=='全部'?'':'level,');
                                skusql=skusql.replace(/(.*)[,，]$/, '$1');
                                switch(skutype){
                                    case 1:
                                        switch(citytype){
                                            case 1:
                                                skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+params[4]+'\' and level='+'\''+item[0]+'\'';
                                                break;
                                            case 2:
                                                skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                            case 3:
                                                skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                        }
                                        break;
                                    case 2:
                                        switch(citytype){
                                            case 1:
                                                skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+params[4]+'\' and level='+'\''+item[0]+'\'';
                                                break;
                                            case 2:
                                                skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                            case 3:
                                                skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                        }
                                        break;
                                    case 3:
                                        switch(citytype){
                                            case 1:
                                                skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+params[4]+'\' and level='+'\''+item[0]+'\'';
                                                break;
                                            case 2:
                                                skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                            case 3:
                                                skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                        }
                                        break;
                                }

                                if(iscityleveltype==1){
                                    skusql+=('and city_level=\''+params[1]+'\'');
                                }
                                sql+=(skusql+'union ');
                            }

                        });
                        break;
                }
            }
            sql=sql.substring(0,sql.length-6);
            // console.log('sql',sql);
            // $('<div>', {
            //     class: 'mb-fff'
            // }).appendTo('#chart-view');
            getData.getHttp(sql).then(function (data){
                var labelRight = {
                    normal: {
                        color: '#363636',
                        position: 'left'
                    }
                };
                let lastsql=0;
                $('<div>', {
                    class: 'mb-fff'
                }).appendTo('#chart-view');
                if($scope.getlastmonthdata(sql)){
                    let lastsql=$scope.getlastmonthdata(sql);
                    let reg=new RegExp('2018-11-0','g');
                    lastsql=lastsql.replace(reg,'2018-11-01');
                    // console.log('$scope.getlastmonthdata(sql)',lastsql);
                    getData.getHttp(lastsql).then(function (data0){


                        let yaxis=[];
                        let seriesaxis=[];
                        let total=1;
                        var results="";
                        let lasttotal=1;
                        var lastresults="";
                        var markpointdata=[];
                        if($scope.visitab=='distribution_store'){
                            //本期
                            if(data.results.length!=0){
                                angular.forEach(data.results,function (item,index,array) {
                                    results+=item[0]+',';
                                    if(item[0]=='全部'){
                                        total=item[1];
                                    }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(results.indexOf(item0)>-1){
                                        angular.forEach(data.results,function (item,index,array) {
                                            if(item0==item[0]){
                                                comparelist[index0].push(item[1]);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(0);
                                    }
                                });
                            }
                            //上一期
                            if(data0.results.length!=0){
                                angular.forEach(data0.results,function (item,index,array) {
                                    lastresults+=item[0]+',';
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(lastresults.indexOf(item0[0])>-1){
                                        angular.forEach(data0.results,function (item,index,array) {
                                            if(item0[0]==item[0]){
                                                let changerate=((item0[1]-item[1])/item[1]*100).toFixed(1);
                                                comparelist[index0].push(changerate);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(comparelist[index0][1]);
                                    }
                                });
                            }
                            comparelist.sort(
                                function compareFunction(param1, param2) {
                                    return param2[0].localeCompare(param1[0],"zh");
                                });
                            var markpointdata=[];
                            let max=0;
                            angular.forEach(comparelist,function (item,index1,array1) {
                                yaxis.push(item[0]);
                                if (item[1] >= 0) {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'left'
                                        }
                                    };
                                }
                                else {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'right'
                                        }
                                    };
                                }
                                let barcolor='red';
                                if(max<item[1]){
                                    max=item[1];
                                }
                                seriesaxis.push({
                                    value:item[1],
                                    formatter: '{value}',
                                    itemStyle: {
                                        normal: {
                                            color:$scope.color[index1]
                                        }
                                    },
                                    label: labelRight
                                });
                                if(data0.results.length!=0){
                                    // console.log(item);
                                    if(item[2]){
                                        // if(item[2]>0){
                                        //     $scope.baroptionlist[index].series[0].markPoint.label.rich.c.color='red';
                                        // }
                                        markpointdata.push({
                                            // name:item[2]>0?'上升':'下降',

                                            value:item[2],
                                            xAxis:item[1],
                                            yAxis:item[0]
                                        });
                                    }
                                    else{
                                        markpointdata.push({
                                            // name:item[2]>0?'上升':'下降',
                                            value:0,
                                            xAxis:0,
                                            yAxis:item[0]
                                        });
                                    }
                                }
                                // console.log('kk',data0.results);
                                $scope.baroptionlist[index].yAxis.data=yaxis;
                                $scope.baroptionlist[index].series[0].data=seriesaxis;
                                $scope.baroptionlist[index].series[0].markPoint.data=markpointdata;
                                // $scope.baroptionlist[index].series[0].markPoint.label.normal.formatter='{b|{b}}{c|{c}}';
                                $scope.baroptionlist[index].xAxis.axisLabel.formatter='{value}';
                                $scope.baroptionlist[index].tooltip.formatter='{b}:\n{c}';
                            });

                        }
                        if($scope.visitab=='distribution' && $scope.history.distribution==0){
                            //本期
                            if(data.results.length!=0){
                                angular.forEach(data.results,function (item,index,array) {
                                    results+=item[0]+',';
                                    if(item[0]=='全部'){
                                        total=item[1];
                                    }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(results.indexOf(item0)>-1){
                                        angular.forEach(data.results,function (item,index,array) {
                                            if(item0==item[0]){
                                                comparelist[index0].push(Math.floor(item[1]/total*10000)/100);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(0);
                                    }
                                });
                            }
                            //上一期
                            if(data0.results.length!=0){
                                angular.forEach(data0.results,function (item,index,array) {
                                    lastresults+=item[0]+',';
                                    if(item[0]=='全部'){
                                        lasttotal=item[1];
                                    }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(lastresults.indexOf(item0[0])>-1){
                                        angular.forEach(data0.results,function (item,index,array) {
                                            if(item0[0]==item[0]){
                                                let changerate=(item0[1]-Math.floor(item[1]/lasttotal*10000)/100).toFixed(1);
                                                comparelist[index0].push(changerate);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(comparelist[index0][1]);
                                    }
                                });
                            }
                            comparelist.sort(
                                function compareFunction(param1, param2) {
                                    return param2[0].localeCompare(param1[0],"zh");
                                });
                            angular.forEach(comparelist,function (item,index1,array1) {
                                yaxis.push(item[0]);
                                if (item[1] >= 0) {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'left'
                                        }
                                    };
                                }
                                else {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'right'
                                        }
                                    };
                                }
                                // let barcolor='red';
                                // angular.forEach($scope.color,function (dataitem,index,array) {
                                //     if(dataitem.name==item[0]){
                                //         barcolor=dataitem.color;
                                //     }
                                // });
                                seriesaxis.push({
                                    value:item[1],
                                    formatter: '{value}%',
                                    itemStyle: {
                                        normal: {
                                            color:$scope.color[index1]
                                        }
                                    },
                                    label: labelRight
                                });
                                if(data0.results.length!=0){
                                    // console.log(item);
                                    if(item[2]){
                                        markpointdata.push({
                                            value:item[2],
                                            xAxis:Math.abs(item[1])*0.9,
                                            yAxis:item[0]
                                        });
                                    }
                                    else{
                                        markpointdata.push({
                                            // name:item[2]>0?'上升':'下降',
                                            value:0,
                                            xAxis:0,
                                            yAxis:item[0]
                                        });
                                    }
                                }
                                $scope.baroptionlist[index].yAxis.data=yaxis;
                                $scope.baroptionlist[index].series[0].data=seriesaxis;
                                $scope.baroptionlist[index].series[0].markPoint.data=markpointdata;
                                // console.log($scope.baroptionlist[index].series[0].markPoint);
                                // console.log('distribution',$scope.baroptionlist[index]);

                            });

                        }
                        if($scope.visitab=='store_money'){
                            //本期
                            if(data.results.length!=0){
                                angular.forEach(data.results,function (item,index,array) {
                                    results+=item[0]+',';
                                    // if(item[0]=='全部'){
                                    //     total=item[1];
                                    // }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(results.indexOf(item0)>-1){
                                        angular.forEach(data.results,function (item,index,array) {
                                            if(item0==item[0]){
                                                comparelist[index0].push((item[1]/item[2]).toFixed(1));
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(0);
                                    }
                                });
                            }
                            //上一期
                            if(data0.results.length!=0){
                                angular.forEach(data0.results,function (item,index,array) {
                                    lastresults+=item[0]+',';
                                    // if(item[0]=='全部'){
                                    //     lasttotal=item[1];
                                    // }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(lastresults.indexOf(item0[0])>-1){
                                        angular.forEach(data0.results,function (item,index,array) {
                                            if(item0[0]==item[0]){
                                                let changerate=(item0[1]-item[1]/item[2]).toFixed(1);
                                                comparelist[index0].push(changerate);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(comparelist[index0][1]);
                                    }
                                });
                            }
                            comparelist.sort(
                                function compareFunction(param1, param2) {
                                    return param2[0].localeCompare(param1[0],"zh");
                                });
                            angular.forEach(comparelist,function (item,index1,array1) {
                                yaxis.push(item[0]);
                                if (item[1] >= 0) {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'left'
                                        }
                                    };
                                }
                                else {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'right'
                                        }
                                    };
                                }

                                seriesaxis.push({
                                    value:item[1],
                                    formatter: '{value}',
                                    itemStyle: {
                                        normal: {
                                            color:$scope.color[index1]
                                        }
                                    },
                                    label: labelRight
                                });
                                if(data0.results.length!=0){
                                    // console.log(item);
                                    if(item[2]){
                                        markpointdata.push({
                                            value:item[2],
                                            xAxis:Math.abs(item[1])*0.9,
                                            yAxis:item[0]
                                        });
                                    }
                                    else{
                                        markpointdata.push({
                                            // name:item[2]>0?'上升':'下降',
                                            value:0,
                                            xAxis:0,
                                            yAxis:item[0]
                                        });
                                    }
                                }
                                $scope.baroptionlist[index].yAxis.data=yaxis;
                                $scope.baroptionlist[index].series[0].data=seriesaxis;
                                $scope.baroptionlist[index].series[0].markPoint.data=markpointdata;
                                // console.log($scope.baroptionlist[index].series[0].markPoint);
                                $scope.baroptionlist[index].xAxis.axisLabel.formatter='{value}';
                                $scope.baroptionlist[index].tooltip.formatter='{b}:\n{c}';
                                $scope.baroptionlist[index].series[0].markPoint.label.normal.formatter='{b|{b}}{c|{c}}';

                            });

                        }
                        if($scope.visitab=='store_number'){
                            //本期
                            if(data.results.length!=0){
                                angular.forEach(data.results,function (item,index,array) {
                                    results+=item[0]+',';
                                    // if(item[0]=='全部'){
                                    //     total=item[1];
                                    // }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(results.indexOf(item0)>-1){
                                        angular.forEach(data.results,function (item,index,array) {
                                            if(item0==item[0]){
                                                comparelist[index0].push((item[1]*1.0/item[2]).toFixed(1));
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(0);
                                    }
                                });
                            }
                            //上一期
                            if(data0.results.length!=0){
                                angular.forEach(data0.results,function (item,index,array) {
                                    lastresults+=item[0]+',';
                                    // if(item[0]=='全部'){
                                    //     lasttotal=item[1];
                                    // }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(lastresults.indexOf(item0[0])>-1){
                                        angular.forEach(data0.results,function (item,index,array) {
                                            if(item0[0]==item[0]){
                                                let changerate=(item0[1]-item[1]*1.0/item[2]).toFixed(1);
                                                comparelist[index0].push(changerate);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(comparelist[index0][1]);
                                    }
                                });
                            }
                            comparelist.sort(
                                function compareFunction(param1, param2) {
                                    return param2[0].localeCompare(param1[0],"zh");
                                });
                            angular.forEach(comparelist,function (item,index1,array1) {
                                yaxis.push(item[0]);
                                if (item[1] >= 0) {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'left'
                                        }
                                    };
                                }
                                else {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'right'
                                        }
                                    };
                                }

                                seriesaxis.push({
                                    value:item[1],
                                    formatter: '{value}',
                                    itemStyle: {
                                        normal: {
                                            color:$scope.color[index1]
                                        }
                                    },
                                    label: labelRight
                                });
                                if(data0.results.length!=0){
                                    // console.log(item);
                                    if(item[2]){
                                        markpointdata.push({
                                            value:item[2],
                                            xAxis:Math.abs(item[1])*0.9,
                                            yAxis:item[0]
                                        });
                                    }
                                    else{
                                        markpointdata.push({
                                            // name:item[2]>0?'上升':'下降',
                                            value:0,
                                            xAxis:0,
                                            yAxis:item[0]
                                        });
                                    }
                                }
                                $scope.baroptionlist[index].yAxis.data=yaxis;
                                $scope.baroptionlist[index].series[0].data=seriesaxis;
                                $scope.baroptionlist[index].series[0].markPoint.data=markpointdata;
                                // console.log($scope.baroptionlist[index].series[0].markPoint);
                                $scope.baroptionlist[index].xAxis.axisLabel.formatter='{value}';
                                $scope.baroptionlist[index].tooltip.formatter='{b}:\n{c}';
                                $scope.baroptionlist[index].series[0].markPoint.label.normal.formatter='{b|{b}}{c|{c}}';

                            });

                        }
                        if($scope.visitab=='average_amount_per_order'){
                            //本期
                            if(data.results.length!=0){
                                angular.forEach(data.results,function (item,index,array) {
                                    results+=item[0]+',';
                                    if(item[0]=='全部'){
                                        total=item[1];
                                    }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(results.indexOf(item0)>-1){
                                        angular.forEach(data.results,function (item,index,array) {
                                            if(item0==item[0]){
                                                comparelist[index0].push(Math.floor(item[1]/total*10000)/100);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(0);
                                    }
                                });
                            }
                            //上一期
                            if(data0.results.length!=0){
                                angular.forEach(data0.results,function (item,index,array) {
                                    lastresults+=item[0]+',';
                                    if(item[0]=='全部'){
                                        lasttotal=item[1];
                                    }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(lastresults.indexOf(item0[0])>-1){
                                        angular.forEach(data0.results,function (item,index,array) {
                                            if(item0[0]==item[0]){
                                                let changerate=(item0[1]-Math.floor(item[1]/lasttotal*10000)/100).toFixed(1);
                                                comparelist[index0].push(changerate);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(comparelist[index0][1]);
                                    }
                                });
                            }
                            comparelist.sort(
                                function compareFunction(param1, param2) {
                                    return param2[0].localeCompare(param1[0],"zh");
                                });
                            angular.forEach(comparelist,function (item,index1,array1) {
                                yaxis.push(item[0]);
                                if (item[1] >= 0) {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'left'
                                        }
                                    };
                                }
                                else {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'right'
                                        }
                                    };
                                }
                                // let barcolor='red';
                                // angular.forEach($scope.color,function (dataitem,index,array) {
                                //     if(dataitem.name==item[0]){
                                //         barcolor=dataitem.color;
                                //     }
                                // });
                                seriesaxis.push({
                                    value:item[1],
                                    formatter: '{value}%',
                                    itemStyle: {
                                        normal: {
                                            color:$scope.color[index1]
                                        }
                                    },
                                    label: labelRight
                                });
                                if(data0.results.length!=0){
                                    if(item[2]){
                                        markpointdata.push({
                                            value:item[2],
                                            xAxis:Math.abs(item[1])*0.9,
                                            yAxis:item[0]
                                        });
                                    }
                                    else{
                                        markpointdata.push({
                                            // name:item[2]>0?'上升':'下降',
                                            value:0,
                                            xAxis:0,
                                            yAxis:item[0]
                                        });
                                    }
                                }
                                $scope.baroptionlist[index].yAxis.data=yaxis;
                                $scope.baroptionlist[index].series[0].data=seriesaxis;
                                $scope.baroptionlist[index].series[0].markPoint.data=markpointdata;
                                // console.log($scope.baroptionlist[index].series[0].markPoint);

                            });

                        }
                        if($scope.visitab=='average_number_per_unit'){
                            //本期
                            if(data.results.length!=0){
                                angular.forEach(data.results,function (item,index,array) {
                                    results+=item[0]+',';
                                    if(item[0]=='全部'){
                                        total=item[1];
                                    }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(results.indexOf(item0)>-1){
                                        angular.forEach(data.results,function (item,index,array) {
                                            if(item0==item[0]){
                                                comparelist[index0].push(Math.floor(item[1]/total*10000)/100);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(0);
                                    }
                                });
                            }
                            //上一期
                            if(data0.results.length!=0){
                                angular.forEach(data0.results,function (item,index,array) {
                                    lastresults+=item[0]+',';
                                    if(item[0]=='全部'){
                                        lasttotal=item[1];
                                    }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(lastresults.indexOf(item0[0])>-1){
                                        angular.forEach(data0.results,function (item,index,array) {
                                            if(item0[0]==item[0]){
                                                let changerate=(item0[1]-Math.floor(item[1]/lasttotal*10000)/100).toFixed(1);
                                                comparelist[index0].push(changerate);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(comparelist[index0][1]);
                                    }
                                });
                            }
                            comparelist.sort(
                                function compareFunction(param1, param2) {
                                    return param2[0].localeCompare(param1[0],"zh");
                                });
                            angular.forEach(comparelist,function (item,index1,array1) {
                                yaxis.push(item[0]);
                                if (item[1] >= 0) {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'left'
                                        }
                                    };
                                }
                                else {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'right'
                                        }
                                    };
                                }
                                // let barcolor='red';
                                // angular.forEach($scope.color,function (dataitem,index,array) {
                                //     if(dataitem.name==item[0]){
                                //         barcolor=dataitem.color;
                                //     }
                                // });
                                seriesaxis.push({
                                    value:item[1],
                                    formatter: '{value}%',
                                    itemStyle: {
                                        normal: {
                                            color:$scope.color[index1]
                                        }
                                    },
                                    label: labelRight
                                });
                                if(data0.results.length!=0){
                                    if(item[2]){
                                        markpointdata.push({
                                            value:item[2],
                                            xAxis:Math.abs(item[1])*0.9,
                                            yAxis:item[0]
                                        });
                                    }
                                    else{
                                        markpointdata.push({
                                            // name:item[2]>0?'上升':'下降',
                                            value:0,
                                            xAxis:0,
                                            yAxis:item[0]
                                        });
                                    }
                                }
                                $scope.baroptionlist[index].yAxis.data=yaxis;
                                $scope.baroptionlist[index].series[0].data=seriesaxis;
                                $scope.baroptionlist[index].series[0].markPoint.data=markpointdata;
                                // console.log($scope.baroptionlist[index].series[0].markPoint);

                            });

                        }
                        if($scope.visitab=='average_selling_price'){
                            //本期
                            if(data.results.length!=0){
                                angular.forEach(data.results,function (item,index,array) {
                                    results+=item[0]+',';
                                    if(item[0]=='全部'){
                                        total=item[1];
                                    }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(results.indexOf(item0)>-1){
                                        angular.forEach(data.results,function (item,index,array) {
                                            if(item0==item[0]){
                                                comparelist[index0].push(item[1]);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(0);
                                    }
                                });
                            }
                            //上一期
                            if(data0.results.length!=0){
                                angular.forEach(data0.results,function (item,index,array) {
                                    lastresults+=item[0]+',';
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(lastresults.indexOf(item0[0])>-1){
                                        angular.forEach(data0.results,function (item,index,array) {
                                            if(item0[0]==item[0]){
                                                let changerate=((item0[1]-item[1])/item[1]*100).toFixed(1);
                                                comparelist[index0].push(changerate);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(comparelist[index0][1]);
                                    }
                                });
                            }
                            comparelist.sort(
                                function compareFunction(param1, param2) {
                                    return param2[0].localeCompare(param1[0],"zh");
                                });
                            var markpointdata=[];
                            let max=0;
                            angular.forEach(comparelist,function (item,index1,array1) {
                                yaxis.push(item[0]);
                                if (item[1] >= 0) {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'left'
                                        }
                                    };
                                }
                                else {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'right'
                                        }
                                    };
                                }
                                let barcolor='red';
                                if(max<item[1]){
                                    max=item[1];
                                }
                                seriesaxis.push({
                                    value:item[1],
                                    formatter: '{value}',
                                    itemStyle: {
                                        normal: {
                                            color:$scope.color[index1]
                                        }
                                    },
                                    label: labelRight
                                });
                                if(data0.results.length!=0){
                                    // console.log(item);
                                    if(item[2]){
                                        // if(item[2]>0){
                                        //     $scope.baroptionlist[index].series[0].markPoint.label.rich.c.color='red';
                                        // }
                                        markpointdata.push({
                                            // name:item[2]>0?'上升':'下降',

                                            value:item[2],
                                            xAxis:item[1],
                                            yAxis:item[0]
                                        });
                                    }
                                    else{
                                        markpointdata.push({
                                            // name:item[2]>0?'上升':'下降',
                                            value:0,
                                            xAxis:0,
                                            yAxis:item[0]
                                        });
                                    }
                                }
                                // console.log('kk',data0.results);
                                $scope.baroptionlist[index].yAxis.data=yaxis;
                                $scope.baroptionlist[index].series[0].data=seriesaxis;
                                $scope.baroptionlist[index].series[0].markPoint.data=markpointdata;
                                // $scope.baroptionlist[index].series[0].markPoint.label.normal.formatter='{b|{b}}{c|{c}}';
                                $scope.baroptionlist[index].xAxis.axisLabel.formatter='{value}';
                                $scope.baroptionlist[index].tooltip.formatter='{b}:\n{c}';
                            });

                        }
                        if($scope.visitab=='average_purchase_price'){
                            //本期
                            if(data.results.length!=0){
                                angular.forEach(data.results,function (item,index,array) {
                                    results+=item[0]+',';
                                    if(item[0]=='全部'){
                                        total=item[1];
                                    }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(results.indexOf(item0)>-1){
                                        angular.forEach(data.results,function (item,index,array) {
                                            if(item0==item[0]){
                                                comparelist[index0].push(item[1]);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(0);
                                    }
                                });
                            }
                            //上一期
                            if(data0.results.length!=0){
                                angular.forEach(data0.results,function (item,index,array) {
                                    lastresults+=item[0]+',';
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(lastresults.indexOf(item0[0])>-1){
                                        angular.forEach(data0.results,function (item,index,array) {
                                            if(item0[0]==item[0]){
                                                let changerate=((item0[1]-item[1])/item[1]*100).toFixed(1);
                                                comparelist[index0].push(changerate);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(comparelist[index0][1]);
                                    }
                                });
                            }
                            comparelist.sort(
                                function compareFunction(param1, param2) {
                                    return param2[0].localeCompare(param1[0],"zh");
                                });
                            var markpointdata=[];
                            let max=0;
                            angular.forEach(comparelist,function (item,index1,array1) {
                                yaxis.push(item[0]);
                                if (item[1] >= 0) {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'left'
                                        }
                                    };
                                }
                                else {
                                    labelRight = {
                                        normal: {
                                            color: '#363636',
                                            position: 'right'
                                        }
                                    };
                                }
                                let barcolor='red';
                                if(max<item[1]){
                                    max=item[1];
                                }
                                seriesaxis.push({
                                    value:item[1],
                                    formatter: '{value}',
                                    itemStyle: {
                                        normal: {
                                            color:$scope.color[index1]
                                        }
                                    },
                                    label: labelRight
                                });
                                if(data0.results.length!=0){
                                    // console.log(item);
                                    if(item[2]){
                                        // if(item[2]>0){
                                        //     $scope.baroptionlist[index].series[0].markPoint.label.rich.c.color='red';
                                        // }
                                        markpointdata.push({
                                            // name:item[2]>0?'上升':'下降',

                                            value:item[2],
                                            xAxis:item[1],
                                            yAxis:item[0]
                                        });
                                    }
                                    else{
                                        markpointdata.push({
                                            // name:item[2]>0?'上升':'下降',
                                            value:0,
                                            xAxis:0,
                                            yAxis:item[0]
                                        });
                                    }
                                }
                                // console.log('kk',data0.results);
                                $scope.baroptionlist[index].yAxis.data=yaxis;
                                $scope.baroptionlist[index].series[0].data=seriesaxis;
                                $scope.baroptionlist[index].series[0].markPoint.data=markpointdata;
                                // $scope.baroptionlist[index].series[0].markPoint.label.normal.formatter='{b|{b}}{c|{c}}';
                                $scope.baroptionlist[index].xAxis.axisLabel.formatter='{value}';
                                $scope.baroptionlist[index].tooltip.formatter='{b}:\n{c}';
                            });

                        }
                        if($scope.visitab=='price_promotion_ratio'){
                            //本期
                            if(data.results.length!=0){
                                angular.forEach(data.results,function (item,index,array) {
                                    results+=item[0]+',';
                                    // if(item[0]=='全部'){
                                    //     total=item[1];
                                    // }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(results.indexOf(item0)>-1){
                                        angular.forEach(data.results,function (item,index,array) {
                                            if(item0==item[0]){
                                                comparelist[index0].push((item[1]/item[2]*100).toFixed(1));
                                                comparelist[index0].push((item[3]/item[1]).toFixed(1));
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(0);
                                        comparelist[index0].push(0);
                                    }
                                });
                            }
                            //上一期
                            if(data0.results.length!=0){
                                angular.forEach(data0.results,function (item,index,array) {
                                    lastresults+=item[0]+',';
                                    if(item[0]=='全部'){
                                        lasttotal=item[1];
                                    }
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(lastresults.indexOf(item0[0])>-1){
                                        angular.forEach(data0.results,function (item,index,array) {
                                            if(item0[0]==item[0]){
                                                let last1=(item[1]/item[2]*100).toFixed(1);
                                                let last2=(item[3]/item[1]).toFixed(1);
                                                let changerate=((item0[1]-last1)/last1).toFixed(1);
                                                let changerate1=((item0[2]-last2)/last2).toFixed(1);
                                                comparelist[index0].push(changerate);
                                                comparelist[index0].push(changerate1);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(comparelist[index0][1]);
                                        comparelist[index0].push(comparelist[index0][2]);
                                    }
                                });
                            }
                            comparelist.sort(
                                function compareFunction(param1, param2) {
                                    return param2[0].localeCompare(param1[0],"zh");
                                });
                            let xaxis=[];
                            let depth=[];
                            let rate=[];
                            // console.log('comparelist',comparelist);
                            angular.forEach(comparelist,function (item,index1,array1) {
                                xaxis.push(item[0]);
                                rate.push(item[1]);
                                depth.push(item[2]);

                            });
                            $scope.linebaroption0list[index].xAxis[0].data=xaxis;
                            $scope.linebaroption0list[index].series[0].data=depth;
                            $scope.linebaroption0list[index].series[1].data=rate;

                        }
                        if($scope.visitab=='saleroom'){
                            //本期

                            if(data.results.length!=0){
                                angular.forEach(data.results,function (item,index,array) {
                                    results+=item[0]+',';
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(results.indexOf(item0)>-1){
                                        angular.forEach(data.results,function (item,index,array) {
                                            if(item0==item[0]){
                                                var sale=Math.floor(item[1]);
                                                comparelist[index0].push(sale);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(0);
                                    }
                                });
                            }
                            //上一期
                            if(data0.results.length!=0){
                                angular.forEach(data0.results,function (item,index,array) {
                                    lastresults+=item[0]+',';
                                    if(item[0]=='全部'){
                                        lasttotal=item[1];
                                    }
                                });
                                console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(lastresults.indexOf(item0[0])>-1){
                                        angular.forEach(data0.results,function (item,index,array) {
                                            if(item0[0]==item[0]){
                                                // var last=(item[1]).toFixed(0);
                                                if(item[1]==0){
                                                    comparelist[index0].push(100);
                                                }
                                                else{
                                                    let changerate=((item0[1]-item[1])/item[1]*100).toFixed(1);
                                                    comparelist[index0].push(changerate);
                                                }
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(comparelist[index0][1]);
                                    }
                                });
                            }
                            comparelist.sort(
                                function compareFunction(param1, param2) {
                                    return param2[0].localeCompare(param1[0],"zh");
                                });
                            let xaxis=[];
                            let amount=[];
                            let rate=[];
                            // console.log('comparelist',comparelist);
                            angular.forEach(comparelist,function (item,index1,array1) {
                                xaxis.push(item[0]);
                                amount.push(item[1]);
                                rate.push(item[2]);

                            });
                            $scope.linebaroption0list[index]={
                                title:{
                                    text:groupname+'\n',
                                    y:'top',
                                    x:'center',
                                    padding:20
                                },
                                tooltip: {
                                    trigger: 'axis',
                                    formatter:'{c}%',
                                    axisPointer: {
                                        type: 'cross',
                                        crossStyle: {
                                            color: '#999'
                                        },

                                    }
                                },
                                toolbox: {
                                    right: 30,
                                    feature: {
                                        saveAsImage: {show: true},
                                        myExcel: {
                                            show: true,
                                            title: "导出CSV",
                                            icon: "image://http://echarts.baidu.com/images/favicon.png",
                                            onclick: function (opts) {
                                                var series = opts.option.series; //折线图数据
                                                var axisData = opts.option.xAxis[0].data; //x坐标数据
                                                console.log(series, opts);
                                                var title = opts.option.title[0].text;
                                                var str = '产品,';
                                                //组装表头
                                                for (var product = 0; product < series.length; product++) {
                                                    // str += series[product].name + `,`;
                                                    str += series[product].name + ',';
                                                }
                                                str += '\n';
                                                //组装表数据
                                                for (var lt = 0; lt < axisData.length; lt++) {//axisData坐标数据
                                                    // str += axisData[lt] + `,`;
                                                    str += axisData[lt] + ',';
                                                    //详细数据
                                                    for (var j = 0; j < series.length; j++) {
                                                        var temp = series[j].data[lt];
                                                        if (temp != null && temp != undefined) {
                                                            // str += `${parseFloat(temp.toFixed(4)) + '\t'}` + `,`;
                                                            str += "${parseFloat(temp.toFixed(4)) + '\t'}" + ',';
                                                        } else {
                                                            str += '';
                                                        }
                                                    }
                                                    str += '\n';
                                                }
                                                //encodeURIComponent解决中文乱码
                                                let uri = 'data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(str);
                                                //通过创建a标签实现
                                                var link = document.createElement("a");
                                                link.href = uri;
                                                //对下载的文件命名
                                                link.download = title + ".csv";
                                                document.body.appendChild(link);
                                                link.click();
                                                document.body.removeChild(link);
                                            }
                                        }
                                    }
                                },
                                legend: {
                                    data: ['平均折扣深度', '价格促销渗透率'],
                                    right: '15%',
                                },
                                xAxis: [
                                    {
                                        type: 'category',
                                        data: ['全部', '茶', '汽水', '果汁'],
                                        axisPointer: {
                                            type: 'shadow'
                                        },
                                    }
                                ],
                                yAxis: [


                                    {
                                        type: 'value',
                                        name: '绝对值',
                                        // interval: 50,
                                        splitLine: {show: false},
                                        axisLabel: {
                                            formatter: '{value}'
                                        }
                                    },
                                    {
                                        type: 'value',
                                        name: '百分比',
                                        // interval: 5,
                                        splitLine: {show: false},
                                        axisLabel: {
                                            formatter: '{value}%'
                                        }
                                    },
                                ],
                                series: [
                                    {
                                        name: '平均折扣深度',
                                        type: 'bar',
                                        itemStyle: {        //上方显示数值
                                            normal: {
                                                color:'#E094D2',
                                                label: {
                                                    show: true, //开启显示
                                                    formatter:function(params){
                                                        if(params.value==0){
                                                            return '';
                                                        }else
                                                        {
                                                            return params.value;
                                                        }},
                                                    position: 'top', //在上方显示
                                                    textStyle: { //数值样式
                                                        color: 'black',
                                                        fontSize: 16
                                                    }
                                                }
                                            }
                                        },
                                        data: [2.0, 4.9, 7.0, 23.2]
                                    },

                                    {
                                        name: '价格促销渗透率',
                                        type: 'line',
                                        yAxisIndex: 1,
                                        itemStyle :
                                            {
                                                normal: {
                                                    color:'#75AAEE',
                                                    label : {
                                                        show: true,
                                                        formatter:function(params){
                                                            if(params.value==0){
                                                                return '';
                                                            }else
                                                            {
                                                                return params.value+'%';
                                                            }},
                                                    }
                                                }
                                            },
                                        data: [2.0, 2.2, 3.3, -4.5]
                                    }
                                ]
                            };
                            $scope.lineBarOptionlist[index].xAxis[0].data=xaxis;
                            $scope.lineBarOptionlist[index].series[0].data=amount;
                            $scope.lineBarOptionlist[index].series[1].data=rate;


                        }
                        if($scope.visitab=='sales_numbers'){
                            //本期
                            if(data.results.length!=0){
                                angular.forEach(data.results,function (item,index,array) {
                                    results+=item[0]+',';
                                });
                                // console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(results.indexOf(item0)>-1){
                                        angular.forEach(data.results,function (item,index,array) {
                                            if(item0==item[0]){
                                                var sale=Math.floor(item[1]);
                                                comparelist[index0].push(sale);
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(0);
                                    }
                                });
                            }
                            //上一期
                            if(data0.results.length!=0){
                                angular.forEach(data0.results,function (item,index,array) {
                                    lastresults+=item[0]+',';
                                    if(item[0]=='全部'){
                                        lasttotal=item[1];
                                    }
                                });
                                console.log('comparelist',comparelist);
                                angular.forEach(comparelist,function (item0,index0,array0) {
                                    if(lastresults.indexOf(item0[0])>-1){
                                        angular.forEach(data0.results,function (item,index,array) {
                                            if(item0[0]==item[0]){
                                                // var last=(item[1]).toFixed(0);
                                                if(item[1]==0){
                                                    comparelist[index0].push(100);
                                                }
                                                else{
                                                    let changerate=((item0[1]-item[1])/item[1]*100).toFixed(1);
                                                    comparelist[index0].push(changerate);
                                                }
                                            }
                                        });
                                    }
                                    else{
                                        comparelist[index0].push(comparelist[index0][1]);
                                    }
                                });
                            }
                            comparelist.sort(
                                function compareFunction(param1, param2) {
                                    return param2[0].localeCompare(param1[0],"zh");
                                });
                            let xaxis=[];
                            let countnum=[];
                            let rate=[];
                            // console.log('comparelist',comparelist);
                            angular.forEach(comparelist,function (item,index1,array1) {
                                xaxis.push(item[0]);
                                countnum.push(item[1]);
                                rate.push(item[2]);

                            });
                            $scope.lineBarOptionlist[index]={
                                title:{
                                    text:groupname+'\n',
                                    y:'top',
                                    x:'center',
                                    padding:20
                                },
                                tooltip: {
                                    trigger: 'axis',
                                    formatter:'{c}%',
                                    axisPointer: {
                                        type: 'cross',
                                        crossStyle: {
                                            color: '#999'
                                        },

                                    }
                                },
                                toolbox: {
                                    right: 30,
                                    feature: {
                                        saveAsImage: {show: true},
                                        myExcel: {
                                            show: true,
                                            title: "导出CSV",
                                            icon: "image://http://echarts.baidu.com/images/favicon.png",
                                            onclick: function (opts) {
                                                var series = opts.option.series; //折线图数据
                                                var axisData = opts.option.xAxis[0].data; //x坐标数据
                                                console.log(series, opts);
                                                var title = opts.option.title[0].text;
                                                var str = '产品,';
                                                //组装表头
                                                for (var product = 0; product < series.length; product++) {
                                                    // str += series[product].name + `,`;
                                                    str += series[product].name + ',';
                                                }
                                                str += '\n';
                                                //组装表数据
                                                for (var lt = 0; lt < axisData.length; lt++) {//axisData坐标数据
                                                    // str += axisData[lt] + `,`;
                                                    str += axisData[lt] + ',';
                                                    //详细数据
                                                    for (var j = 0; j < series.length; j++) {
                                                        var temp = series[j].data[lt];
                                                        if (temp != null && temp != undefined) {
                                                            // str += `${parseFloat(temp.toFixed(4)) + '\t'}` + `,`;
                                                            str += "${parseFloat(temp.toFixed(4)) + '\t'}" + ',';
                                                        } else {
                                                            str += '';
                                                        }
                                                    }
                                                    str += '\n';
                                                }
                                                //encodeURIComponent解决中文乱码
                                                let uri = 'data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(str);
                                                //通过创建a标签实现
                                                var link = document.createElement("a");
                                                link.href = uri;
                                                //对下载的文件命名
                                                link.download = title + ".csv";
                                                document.body.appendChild(link);
                                                link.click();
                                                document.body.removeChild(link);
                                            }
                                        }
                                    }
                                },
                                legend: {
                                    data: ['平均折扣深度', '价格促销渗透率'],
                                    right: '15%',
                                },
                                xAxis: [
                                    {
                                        type: 'category',
                                        data: ['全部', '茶', '汽水', '果汁'],
                                        axisPointer: {
                                            type: 'shadow'
                                        },
                                    }
                                ],
                                yAxis: [


                                    {
                                        type: 'value',
                                        name: '绝对值',
                                        // interval: 50,
                                        splitLine: {show: false},
                                        axisLabel: {
                                            formatter: '{value}'
                                        }
                                    },
                                    {
                                        type: 'value',
                                        name: '百分比',
                                        // interval: 5,
                                        splitLine: {show: false},
                                        axisLabel: {
                                            formatter: '{value}%'
                                        }
                                    },
                                ],
                                series: [
                                    {
                                        name: '平均折扣深度',
                                        type: 'bar',
                                        itemStyle: {        //上方显示数值
                                            normal: {
                                                color:'#E094D2',
                                                label: {
                                                    show: true, //开启显示
                                                    formatter:function(params){
                                                        if(params.value==0){
                                                            return '';
                                                        }else
                                                        {
                                                            return params.value;
                                                        }},
                                                    position: 'top', //在上方显示
                                                    textStyle: { //数值样式
                                                        color: 'black',
                                                        fontSize: 16
                                                    }
                                                }
                                            }
                                        },
                                        data: [2.0, 4.9, 7.0, 23.2]
                                    },

                                    {
                                        name: '价格促销渗透率',
                                        type: 'line',
                                        yAxisIndex: 1,
                                        itemStyle :
                                            {
                                                normal: {
                                                    color:'#75AAEE',
                                                    label : {
                                                        show: true,
                                                        formatter:function(params){
                                                            if(params.value==0){
                                                                return '';
                                                            }else
                                                            {
                                                                return params.value+'%';
                                                            }},
                                                    }
                                                }
                                            },
                                        data: [2.0, 2.2, 3.3, -4.5]
                                    }
                                ]
                            };
                            $scope.lineBarOptionlist[index].xAxis[0].data=xaxis;
                            $scope.lineBarOptionlist[index].series[0].data=countnum;
                            $scope.lineBarOptionlist[index].series[1].data=rate;
                            $scope.lineBarOptionlist[index].series[0].name='销售件数';
                            $scope.lineBarOptionlist[index].series[1].name='销售件变化率';

                        }
                        $('.mb-fff').remove();

                    },function (data) {
                        $('.mb-fff').remove();
                    });
                }
            },function (data) {
                $('.mb-fff').remove();
            });
        };
        $scope.getbelowbasesqlline=function(param1,param2,groupname,index,comparelist){
             console.log('哦哦',comparelist);
             $scope.lineoptionlist[index].title.text=groupname;
            // $('<div>', {
            //     class: 'mb-fff'
            // }).appendTo('#chart-view');
            var params=groupname.split('-');
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let below_forall='';
            switch(citytype){
                case 1:
                    below_forall=(params[0]=='全部'?'(select \'全部\' zpjt,dt,':'(select zpjt,dt,');
                    break;
                case 2:
                    below_forall=(params[0]=='全部'?'(select \'全部\' zpc,dt,':'(select zpc,dt,');
                    break;
                case 3:
                    below_forall=(params[0]=='全部'?'(select \'全部\' city,dt,':'(select city,dt,');
                    break;
            }
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            if(iscityleveltype==1){
                below_forall+=(params[1]=='全部'?'\'全部\' city_level,':'city_level,');
            }
            below_forall+=(params[2]=='全部'?'\'全部\' channel,':'channel,');
            below_forall+=(params[3]=='全部'?'\'全部\' platform,':'platform,');
            let legend=[];
            if($scope.month=='2018-11-01'){
                legend.push('2018-11-01');
            }
            else{
                legend.push('2018-11-01');
                legend.push('2018-12-01');
            }

            $scope.lineoptionlist[index].xAxis.data=legend;
            $scope.baroptionlist[index].series=[];
            // $scope.lineoptionlist[index].title
            var sql='';
            if(isgrading==0){
                switch(skutype){
                    case 1:
                        $scope.lineoptionlist[index].title.subtext='品类';
                        angular.forEach($scope.typelist,function (item,index,array) {
                            let skusql='';
                            if($scope.typelist[index].checked=1){
                                skusql=below_forall+(item[0]=='全部'?'\'全部\' type,':'type,');
                                skusql+=(param1+' from sku_2018 where dt<=\''+$scope.month+'\'');

                                switch(citytype){
                                    case 1:
                                        skusql+=(params[0]=='全部'?' group by dt,':' group by zpjt,dt,');
                                        break;
                                    case 2:
                                        skusql+=(params[0]=='全部'?' group by dt,':' group by zpc,dt,');
                                        break;
                                    case 3:
                                        skusql+=(params[0]=='全部'?' group by dt,':' group by city,dt,');
                                        break;
                                }
                                if(iscityleveltype==1){
                                    skusql+=(params[1]=='全部'?'':'city_level,');
                                }
                                skusql+=(params[2]=='全部'?'':'channel,');
                                skusql+=(params[3]=='全部'?'':'platform,');
                                skusql+=(item[0]=='全部'?'':'type,');
                                skusql=skusql.replace(/(.*)[,，]$/, '$1');
                                switch(citytype){
                                    case 1:
                                        skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+item[0]+'\'';
                                        break;
                                    case 2:
                                        skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+item[0]+'\'';
                                        break;
                                    case 3:
                                        skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+item[0]+'\'';
                                        break;
                                }
                                if(iscityleveltype==1){
                                    skusql+=('and city_level=\''+params[1]+'\'');
                                }
                                sql+=(skusql+'union ');
                                console.log('sql',sql);
                            }

                        });
                        break;
                    case 2:
                        $scope.lineoptionlist[index].title.subtext='制造商';
                        angular.forEach($scope.manulist,function (item,index,array) {
                            let skusql='';
                            if($scope.manulist[index].checked=1){
                                skusql=below_forall+(item[0]=='全部'?'\'全部\' manu,':'manu,');
                                skusql+=(param1+' from sku_2018 where dt=\''+$scope.month+'\'');

                                switch(citytype){
                                    case 1:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpjt,');
                                        break;
                                    case 2:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpc,');
                                        break;
                                    case 3:
                                        skusql+=(params[0]=='全部'?' group by ':' group by city,');
                                        break;
                                }
                                if(iscityleveltype==1){
                                    skusql+=(params[1]=='全部'?'':'city_level,');
                                }
                                skusql+=(params[2]==1?'':'channel,');
                                skusql+=(params[3]==1?'':'platform,');
                                skusql+=(item[0]=='全部'?'':'manu,');


                                skusql=skusql.replace(/(.*)[,，]$/, '$1');
                                switch(citytype){
                                    case 1:
                                        skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+item[0]+'\'';
                                        break;
                                    case 2:
                                        skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+item[0]+'\'';
                                        break;
                                    case 3:
                                        skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+item[0]+'\'';
                                        break;
                                }
                                sql+=(skusql+'union ');
                            }

                        });
                        break;
                    case 3:
                        $scope.lineoptionlist[index].title.subtext='品牌';
                        angular.forEach($scope.pinpailist,function (item,index,array) {
                            let skusql='';
                            if($scope.pinpailist[index].checked=1){
                                skusql=below_forall+(item[0]=='全部'?'\'全部\' pinpai,':'pinpai,');
                                skusql+=(param1+' from sku_2018 where dt=\''+$scope.month+'\'');

                                switch(citytype){
                                    case 1:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpjt,');
                                        break;
                                    case 2:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpc,');
                                        break;
                                    case 3:
                                        skusql+=(params[0]=='全部'?' group by ':' group by city,');
                                        break;
                                }
                                if(iscityleveltype==1){
                                    skusql+=(params[1]=='全部'?'':'city_level,');
                                }
                                skusql+=(params[2]==1?'':'channel,');
                                skusql+=(params[3]==1?'':'platform,');
                                skusql+=(item[0]=='全部'?'':'pinpai,');


                                skusql=skusql.replace(/(.*)[,，]$/, '$1');
                                switch(citytype){
                                    case 1:
                                        skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+item[0]+'\'';
                                        break;
                                    case 2:
                                        skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+item[0]+'\'';
                                        break;
                                    case 3:
                                        skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+item[0]+'\'';
                                        break;
                                }
                                sql+=(skusql+'union ');
                            }
                            console.log(sql)

                        });
                        break;
                }
            }
            else{
                switch(skutype){
                    case 1:
                        below_forall+=(params[4]=='全部'?'\'全部\' type,':'type,');
                        break;
                    case 2:
                        below_forall+=(params[4]=='全部'?'\'全部\' manu,':'manu,');
                        break;
                    case 3:
                        below_forall+=(params[4]=='全部'?'\'全部\' pinpai,':'pinpai,');
                        break;
                }

                switch(isgrading){
                    case 1:
                        $scope.lineoptionlist[index].title.subtext='容量分级';
                        below_forall+=(item[0]=='全部'?'\'全部\' level,':'level,');
                        angular.forEach($scope.capacitylist,function (item,index,array) {
                            let skusql='';
                            if($scope.capacitylist[index].checked=1){
                                skusql=below_forall+(item[0]=='全部'?'\'全部\' level,':'level,');
                                skusql+=(param1+' from sku_2018 where dt=\''+$scope.month+'\'');
                                switch(citytype){
                                    case 1:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpjt,');
                                        break;
                                    case 2:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpc,');
                                        break;
                                    case 3:
                                        skusql+=(params[0]=='全部'?' group by ':' group by city,');
                                        break;
                                }
                                if(iscityleveltype==1){
                                    // console.log('xuanzhong');
                                    skusql+=(params[1]=='全部'?'':'city_level,');
                                    // console.log('xuanzhong',params[1]);
                                }
                                skusql+=(params[2]=='全部'?'':'channel,');
                                skusql+=(params[3]=='全部'?'':'platform,');
                                switch(skutype){
                                    case 1:
                                        skusql+=(params[4]=='全部'?'':'type,');
                                        break;
                                    case 2:
                                        skusql+=(params[4]=='全部'?'':'manu,');
                                        break;
                                    case 3:
                                        skusql+=(params[4]=='全部'?'':'pinpai,');
                                        break;
                                }
                                skusql+=(item[0]=='全部'?'':'level,');
                                skusql=skusql.replace(/(.*)[,，]$/, '$1');
                                switch(skutype){
                                    case 1:
                                        switch(citytype){
                                            case 1:
                                                skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+params[4]+'\' and level='+'\''+item[0]+'\'';
                                                break;
                                            case 2:
                                                skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                            case 3:
                                                skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                        }
                                        break;
                                    case 2:
                                        switch(citytype){
                                            case 1:
                                                skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+params[4]+'\' and level='+'\''+item[0]+'\'';
                                                break;
                                            case 2:
                                                skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                            case 3:
                                                skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                        }
                                        break;
                                    case 3:
                                        switch(citytype){
                                            case 1:
                                                skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+params[4]+'\' and level='+'\''+item[0]+'\'';
                                                break;
                                            case 2:
                                                skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                            case 3:
                                                skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                        }
                                        break;
                                }

                                if(iscityleveltype==1){
                                    skusql+=('and city_level=\''+params[1]+'\'');
                                }
                                sql+=(skusql+'union ');
                            }

                        });
                        break;
                    case 2:
                        $scope.lineoptionlist[index].title.subtext='瓶量分级';
                        angular.forEach($scope.bottlelist,function (item,index,array) {
                            let skusql='';
                            if($scope.bottlelist[index].checked=1){
                                skusql=below_forall+(item[0]=='全部'?'\'全部\' level,':'level,');
                                skusql+=(param1+' from sku_2018 where dt=\''+$scope.month+'\'');
                                switch(citytype){
                                    case 1:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpjt,');
                                        break;
                                    case 2:
                                        skusql+=(params[0]=='全部'?' group by ':' group by zpc,');
                                        break;
                                    case 3:
                                        skusql+=(params[0]=='全部'?' group by ':' group by city,');
                                        break;
                                }
                                if(iscityleveltype==1){
                                    // console.log('xuanzhong');
                                    skusql+=(params[1]=='全部'?'':'city_level,');
                                    // console.log('xuanzhong',params[1]);
                                }
                                skusql+=(params[2]=='全部'?'':'channel,');
                                skusql+=(params[3]=='全部'?'':'platform,');
                                switch(skutype){
                                    case 1:
                                        skusql+=(params[4]=='全部'?'':'type,');
                                        break;
                                    case 2:
                                        skusql+=(params[4]=='全部'?'':'manu,');
                                        break;
                                    case 3:
                                        skusql+=(params[4]=='全部'?'':'pinpai,');
                                        break;
                                }
                                skusql+=(item[0]=='全部'?'':'level,');
                                skusql=skusql.replace(/(.*)[,，]$/, '$1');
                                switch(skutype){
                                    case 1:
                                        switch(citytype){
                                            case 1:
                                                skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+params[4]+'\' and level='+'\''+item[0]+'\'';
                                                break;
                                            case 2:
                                                skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                            case 3:
                                                skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and type='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                        }
                                        break;
                                    case 2:
                                        switch(citytype){
                                            case 1:
                                                skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+params[4]+'\' and level='+'\''+item[0]+'\'';
                                                break;
                                            case 2:
                                                skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                            case 3:
                                                skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and manu='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                        }
                                        break;
                                    case 3:
                                        switch(citytype){
                                            case 1:
                                                skusql='select ' +param2 +' from'+skusql+') where zpjt=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+params[4]+'\' and level='+'\''+item[0]+'\'';
                                                break;
                                            case 2:
                                                skusql='select ' +param2 +' from'+skusql+') where zpc=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                            case 3:
                                                skusql='select ' +param2 +' from'+skusql+') where city=\''+params[0]+'\' and channel='+'\''+params[2]+'\'and platform='+'\''+params[3]+'\'and pinpai='+'\''+params[4]+'\'and level='+'\''+item[0]+'\'';
                                                break;
                                        }
                                        break;
                                }

                                if(iscityleveltype==1){
                                    skusql+=('and city_level=\''+params[1]+'\'');
                                }
                                sql+=(skusql+'union ');
                            }

                        });
                        break;
                }
            }

            sql=sql.substring(0,sql.length-6);
            console.log('sql0',sql);
            getData.getHttp(sql).then(function (data){
                var labelRight = {
                    normal: {
                        color: '#363636',
                        position: 'left'
                    }
                };
                // $('<div>', {
                //     class: 'mb-fff'
                // }).appendTo('#chart-view');
                console.log('line',data.results);
                let yaxis=[];
                let seriesaxis=[];
                let total=1;
                var results="";
                let lasttotal=1;
                var lastresults="";
                var markpointdata=[];
                if($scope.visitab=='distribution_store' ){
                    //本期
                    if(data.results.length!=0){
                        angular.forEach(data.results,function (item,index,array) {
                            results+=item[0]+',';
                            if(item[0]=='全部'){
                                total=item[1];
                            }
                        });
                        // console.log('comparelist',comparelist);
                        angular.forEach(comparelist,function (item0,index0,array0) {
                            if(results.indexOf(item0)>-1){
                                angular.forEach(data.results,function (item,index,array) {
                                    if(item0==item[0]){
                                        comparelist[index0].push(item[1]);
                                    }
                                });
                            }
                            else{
                                comparelist[index0].push(0);
                            }
                        });
                    }

                    comparelist.sort(
                        function compareFunction(param1, param2) {
                            return param2[0].localeCompare(param1[0],"zh");
                        });
                    var markpointdata=[];
                    let max=0;
                    angular.forEach(comparelist,function (item,index1,array1) {
                        console.log('测试distribution_store');

                    });

                }
                if($scope.visitab=='distribution'){
                    //本期
                    if(data.results.length!=0){
                        angular.forEach(data.results,function (item,index,array) {
                            results+=item[0]+',';
                            if(item[0]=='全部'){
                                total=item[1];
                            }
                        });
                        // console.log('comparelist',comparelist);
                        for(var i=0;i<legend.length;i++){
                            let series=[];
                            let all=0;
                            angular.forEach(data.results,function (item,index,array) {
                                if(legend[i]==item[2] && item[0]=='全部'){
                                    all=item[1];
                                }
                            });
                            angular.forEach(data.results,function (item,index,array) {
                                if(legend[i]==item[2]){
                                    var rate=Math.floor(item[1]*1.0/all*10000)/100+'%';
                                    series.push(rate);
                                }
                            });

                            $scope.lineoptionlist[index].series.push(
                                {
                                    name:legend[i],
                                    type:'line',
                                    stack: '总量',
                                    data:series
                                }
                            );

                        }
                        angular.forEach(comparelist,function (item0,index0,array0) {
                            if(results.indexOf(item0)>-1){
                                angular.forEach(data.results,function (item,index,array) {
                                    if(item0==item[0]){
                                        comparelist[index0].push(Math.floor(item[1]/total*10000)/100);
                                    }
                                });
                            }
                            else{
                                comparelist[index0].push(0);
                            }
                        });
                        console.log('comparelist',comparelist);
                    }
                    comparelist.sort(
                        function compareFunction(param1, param2) {
                            return param2[0].localeCompare(param1[0],"zh");
                        });
                }
                if($scope.visitab=='store_money'){
                    //本期
                    if(data.results.length!=0){
                        angular.forEach(data.results,function (item,index,array) {
                            results+=item[0]+',';
                            // if(item[0]=='全部'){
                            //     total=item[1];
                            // }
                        });
                         console.log('comparelist',comparelist);
                        angular.forEach(comparelist,function (item0,index0,array0) {
                            if(results.indexOf(item0)>-1){
                                angular.forEach(data.results,function (item,index,array) {
                                    if(item0==item[0]){
                                        comparelist[index0].push((item[1]/item[2]).toFixed(1));
                                    }
                                });
                            }
                            else{
                                comparelist[index0].push(0);
                            }
                        });
                    }
                    comparelist.sort(
                        function compareFunction(param1, param2) {
                            return param2[0].localeCompare(param1[0],"zh");
                        });


                }
                if($scope.visitab=='store_number'){
                    //本期
                    if(data.results.length!=0){
                        angular.forEach(data.results,function (item,index,array) {
                            results+=item[0]+',';
                            // if(item[0]=='全部'){
                            //     total=item[1];
                            // }
                        });
                        // console.log('comparelist',comparelist);
                        angular.forEach(comparelist,function (item0,index0,array0) {
                            if(results.indexOf(item0)>-1){
                                angular.forEach(data.results,function (item,index,array) {
                                    if(item0==item[0]){
                                        comparelist[index0].push((item[1]*1.0/item[2]).toFixed(1));
                                    }
                                });
                            }
                            else{
                                comparelist[index0].push(0);
                            }
                        });
                    }

                    comparelist.sort(
                        function compareFunction(param1, param2) {
                            return param2[0].localeCompare(param1[0],"zh");
                        });

                }
                if($scope.visitab=='average_amount_per_order'){
                    //本期
                    if(data.results.length!=0){
                        angular.forEach(data.results,function (item,index,array) {
                            results+=item[0]+',';
                            if(item[0]=='全部'){
                                total=item[1];
                            }
                        });
                        // console.log('comparelist',comparelist);
                        angular.forEach(comparelist,function (item0,index0,array0) {
                            if(results.indexOf(item0)>-1){
                                angular.forEach(data.results,function (item,index,array) {
                                    if(item0==item[0]){
                                        comparelist[index0].push(Math.floor(item[1]/total*10000)/100);
                                    }
                                });
                            }
                            else{
                                comparelist[index0].push(0);
                            }
                        });
                    }

                    comparelist.sort(
                        function compareFunction(param1, param2) {
                            return param2[0].localeCompare(param1[0],"zh");
                        });

                }
                if($scope.visitab=='average_number_per_unit'){
                    //本期
                    if(data.results.length!=0){
                        angular.forEach(data.results,function (item,index,array) {
                            results+=item[0]+',';
                            if(item[0]=='全部'){
                                total=item[1];
                            }
                        });
                        // console.log('comparelist',comparelist);
                        angular.forEach(comparelist,function (item0,index0,array0) {
                            if(results.indexOf(item0)>-1){
                                angular.forEach(data.results,function (item,index,array) {
                                    if(item0==item[0]){
                                        comparelist[index0].push(Math.floor(item[1]/total*10000)/100);
                                    }
                                });
                            }
                            else{
                                comparelist[index0].push(0);
                            }
                        });
                    }

                    comparelist.sort(
                        function compareFunction(param1, param2) {
                            return param2[0].localeCompare(param1[0],"zh");
                        });

                }
                if($scope.visitab=='average_selling_price'){
                    //本期
                    if(data.results.length!=0){
                        angular.forEach(data.results,function (item,index,array) {
                            results+=item[0]+',';
                            if(item[0]=='全部'){
                                total=item[1];
                            }
                        });
                        // console.log('comparelist',comparelist);
                        angular.forEach(comparelist,function (item0,index0,array0) {
                            if(results.indexOf(item0)>-1){
                                angular.forEach(data.results,function (item,index,array) {
                                    if(item0==item[0]){
                                        comparelist[index0].push(item[1]);
                                    }
                                });
                            }
                            else{
                                comparelist[index0].push(0);
                            }
                        });
                    }
                    comparelist.sort(
                        function compareFunction(param1, param2) {
                            return param2[0].localeCompare(param1[0],"zh");
                        });
                    var markpointdata=[];
                    let max=0;

                }
                if($scope.visitab=='average_purchase_price'){
                    //本期
                    if(data.results.length!=0){
                        angular.forEach(data.results,function (item,index,array) {
                            results+=item[0]+',';
                            if(item[0]=='全部'){
                                total=item[1];
                            }
                        });
                        // console.log('comparelist',comparelist);
                        angular.forEach(comparelist,function (item0,index0,array0) {
                            if(results.indexOf(item0)>-1){
                                angular.forEach(data.results,function (item,index,array) {
                                    if(item0==item[0]){
                                        comparelist[index0].push(item[1]);
                                    }
                                });
                            }
                            else{
                                comparelist[index0].push(0);
                            }
                        });
                    }
                    comparelist.sort(
                        function compareFunction(param1, param2) {
                            return param2[0].localeCompare(param1[0],"zh");
                        });
                    var markpointdata=[];
                    let max=0;


                }
                if($scope.visitab=='price_promotion_ratio'){
                    //本期
                    if(data.results.length!=0){
                        angular.forEach(data.results,function (item,index,array) {
                            results+=item[0]+',';
                            // if(item[0]=='全部'){
                            //     total=item[1];
                            // }
                        });
                        // console.log('comparelist',comparelist);
                        angular.forEach(comparelist,function (item0,index0,array0) {
                            if(results.indexOf(item0)>-1){
                                angular.forEach(data.results,function (item,index,array) {
                                    if(item0==item[0]){
                                        comparelist[index0].push((item[1]/item[2]*100).toFixed(1));
                                        comparelist[index0].push((item[3]/item[1]).toFixed(1));
                                    }
                                });
                            }
                            else{
                                comparelist[index0].push(0);
                                comparelist[index0].push(0);
                            }
                        });
                    }

                    comparelist.sort(
                        function compareFunction(param1, param2) {
                            return param2[0].localeCompare(param1[0],"zh");
                        });


                }
                if($scope.visitab=='saleroom'){
                    //本期

                    if(data.results.length!=0){
                        angular.forEach(data.results,function (item,index,array) {
                            results+=item[0]+',';
                        });
                        // console.log('comparelist',comparelist);
                        angular.forEach(comparelist,function (item0,index0,array0) {
                            if(results.indexOf(item0)>-1){
                                angular.forEach(data.results,function (item,index,array) {
                                    if(item0==item[0]){
                                        var sale=Math.floor(item[1]);
                                        comparelist[index0].push(sale);
                                    }
                                });
                            }
                            else{
                                comparelist[index0].push(0);
                            }
                        });
                    }
                    comparelist.sort(
                        function compareFunction(param1, param2) {
                            return param2[0].localeCompare(param1[0],"zh");
                        });

                }
                if($scope.visitab=='sales_numbers'){
                    //本期
                    if(data.results.length!=0){
                        angular.forEach(data.results,function (item,index,array) {
                            results+=item[0]+',';
                        });
                        // console.log('comparelist',comparelist);
                        angular.forEach(comparelist,function (item0,index0,array0) {
                            if(results.indexOf(item0)>-1){
                                angular.forEach(data.results,function (item,index,array) {
                                    if(item0==item[0]){
                                        var sale=Math.floor(item[1]);
                                        comparelist[index0].push(sale);
                                    }
                                });
                            }
                            else{
                                comparelist[index0].push(0);
                            }
                        });
                    }
                    comparelist.sort(
                        function compareFunction(param1, param2) {
                            return param2[0].localeCompare(param1[0],"zh");
                        });
                }
            },function (data) {
                console.log(data);
            });
             // console.log('sql',sql);
            // $('<div>', {
            //     class: 'mb-fff'
            // }).appendTo('#chart-view');
        };
        $scope.getBarData0=function(){
            // $('<div>', {
            //     class: 'mb-fff'
            //  }).appendTo('#chart-view');

        }
        $scope.getBarData=function(){
            //重新请求数据时需要改变$scope.basesql的值
            // console.log('jjkjkk');
            $('<div>', {
                class: 'mb-fff'
            }).appendTo('#chart-view');
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let kpichecked = $scope.kpichecked;
            if(isgrading==1){
                angular.forEach($scope.capacitylist,function (item,index,array) {
                    $scope.capacitylist[index].checked=1;
                });
                switch(citytype){
                    case 1:
                        $scope.queryfield='select type,zpjt,channel,platform,city_level,level from '+$scope.basesql;
                        $scope.groupbyfield='group by zpjt,city_level,channel,platform,type,level';
                        $scope.condition1='where zpjt in (\'SCCL\',\'ZH\',\'CBL\')'; //第一个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield='select type,zpc,channel,platform,city_level,level from '+$scope.basesql;
                        $scope.groupbyfield='group by zpc,city_level,channel,platform,type,level';
                        $scope.condition1='where zpc in ()'; //第一个分组的where条件
                        break;
                    case 3:
                        $scope.queryfield='select type,city,channel,platform,city_level,level from '+$scope.basesql;
                        $scope.groupbyfield='group by city,city_level,channel,platform,type,level';
                        $scope.condition1='where city in ()'; //第一个分组的where条件
                        break;
                }
                switch(skutype){
                    case 1:
                        $scope.condition4=' and type in (\'乳味饮料\',\'功能饮料\',\'咖啡\',\'果汁饮料\' ,\'植物蛋白饮料\',\'植物饮料\' ,\'水\',\'汽水\' ,\'组合\',\'茶\' )';//第四个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield=$scope.queryfield.replace('type','manu');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','manu');
                        $scope.condition4='and manu in ()';
                        break;
                    case 3:
                        $scope.queryfield=$scope.queryfield.replace('type','pinpai');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','pinpai');
                        $scope.condition4='and pinpai in ()';
                        break;
                }
                $scope.condition5='and level in (\'SMS(801-1250ml)\',\'MS(1251-2000ml)\',\'SS(401-800ml)\',\'其他\',\'LMS(2001-3000ml)\',\'SSS(0-400ml)\',\'BULK （3L, above）\')';
            }
            else if(isgrading==2){
                angular.forEach($scope.bottlelist,function (item,index,array) {
                    $scope.bottlelist[index].checked=1;
                });
                switch(citytype){
                    case 1:
                        $scope.queryfield='select type,zpjt,channel,platform,city_level,pack_level from '+$scope.basesql;
                        $scope.groupbyfield='group by zpjt,city_level,channel,platform,type,pack_level';
                        $scope.condition1='where zpjt in (\'SCCL\',\'ZH\',\'CBL\')'; //第一个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield='select type,zpc,channel,platform,city_level,pack_level from '+$scope.basesql;
                        $scope.groupbyfield='group by zpc,city_level,channel,platform,type,pack_level';
                        $scope.condition1='where zpc in ()'; //第一个分组的where条件
                        break;
                    case 3:
                        $scope.queryfield='select type,city,channel,platform,city_level,pack_level from '+$scope.basesql;
                        $scope.groupbyfield='group by city,city_level,channel,platform,type,pack_level';
                        $scope.condition1='where city in ()'; //第一个分组的where条件
                        break;
                }
                switch(skutype){
                    case 1:
                        $scope.condition4=' and type in (\'乳味饮料\',\'功能饮料\',\'咖啡\',\'果汁饮料\' ,\'植物蛋白饮料\',\'植物饮料\' ,\'水\',\'汽水\' ,\'组合\',\'茶\' )';//第四个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield=$scope.queryfield.replace('type','manu');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','manu');
                        $scope.condition4='and manu in ()';
                        break;
                    case 3:
                        $scope.queryfield=$scope.queryfield.replace('type','pinpai');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','pinpai');
                        $scope.condition4='and pinpai in ()';
                        break;
                }
                $scope.condition5="and pack_level in (\'整箱装\',\'其他\',\'多瓶装\',\'单瓶装\')";

            }
            else if(isgrading==0){
                switch(citytype){
                    case 1:
                        $scope.queryfield='select type,zpjt,channel,platform,city_level from '+$scope.basesql;
                        $scope.groupbyfield='group by zpjt,city_level,channel,platform,type';
                        $scope.condition1='where zpjt in (\'SCCL\',\'ZH\',\'CBL\')'; //第一个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield='select type,zpc,channel,platform,city_level from '+$scope.basesql;
                        $scope.groupbyfield='group by zpc,city_level,channel,platform,type';
                        $scope.condition1='where zpc in ()'; //第一个分组的where条件
                        break;
                    case 3:
                        $scope.queryfield='select type,city,channel,platform,city_level from '+$scope.basesql;
                        $scope.groupbyfield='group by city,city_level,channel,platform,type';
                        $scope.condition1='where city in ()'; //第一个分组的where条件
                        break;
                }
                switch(skutype){
                    case 1:
                        $scope.condition4=' and type in (\'乳味饮料\',\'功能饮料\',\'咖啡\',\'果汁饮料\' ,\'植物蛋白饮料\',\'植物饮料\' ,\'水\',\'汽水\' ,\'组合\',\'茶\' )';//第四个分组的where条件
                        break;
                    case 2:
                        $scope.queryfield=$scope.queryfield.replace('type','manu');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','manu');
                        $scope.condition4='and manu in ()';
                        break;
                    case 3:
                        $scope.queryfield=$scope.queryfield.replace('type','pinpai');
                        $scope.groupbyfield=$scope.groupbyfield.replace('type','pinpai');
                        $scope.condition4='and pinpai in ()';
                        break;
                }
            }
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            if(iscityleveltype==0){
                $scope.citylevelcon='';
                var r = new RegExp(',city_level' , "g" );
                $scope.queryfield=$scope.queryfield.replace(r,'');
                $scope.groupbyfield=$scope.groupbyfield.replace(r,'');
                // $scope.sql1=$scope.sql1.replace(r,'');
            }
            else {
                angular.forEach($scope.cityclasslist,function (item,index,array) {
                    $scope.cityclasslist[index].checked=1;
                });
                $scope.citylevelcon='and city_level in (\'Metro\',\'U1\',\'U2\')'; //第一个分组的where条件
                }
            // console.log('$scope.queryfield',$scope.groupbyfield);
            $scope.orderbyfield=$scope.groupbyfield.replace('group',' order');
            $scope.sql1=$scope.queryfield+$scope.condition1+$scope.citylevelcon+$scope.condition2+$scope.condition3+$scope.condition4+$scope.condition5+$scope.groupbyfield+$scope.orderbyfield;

            $scope.sql1=$scope.sql1.replace('(,','(');
            // var empty=new RegExp('in ()','g');
            // $scope.sql1=$scope.sql1.replace(empty,"in (\'\')");
            $scope.sql1=$scope.sql1.replace('in ()',"in (\'\')");
            // console.log('$scope.sql1',$scope.sql1);
            // console.log('$scope.sql1测试getparams',$scope.sql1);
            getData.getHttp($scope.sql1).then(function (data){
                var temp = data.results;
                console.log(temp);
                var arr = [];
                for (var i = 0; i < temp.length; i++){
                    let ai = temp[i];
                    var group='';
                    //容量分级和瓶量分级均未选择
                    if(isgrading==0){
                        group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]; //装瓶集团（装瓶厂、城市）- 全部（城市等级） - 渠道 - 平台
                        // console.log(group);
                        if(iscityleveltype==1){
                            group = ai[1] + '-' + ai[4] + '-' + ai[2] + '-' + ai[3]; //装瓶集团（装瓶厂、城市）- 城市等级 - 渠道 - 平台
                        }
                    }
                    //选择了容量分级或瓶量分级
                    else{
                        group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]+ '-' +ai[0]; //装瓶集团（装瓶厂、城市）-全部（城市等级）-渠道-平台-品类（制造商、品牌）
                        if(iscityleveltype==1){
                            group = ai[1] + '-' + ai[4] + '-' + ai[2] + '-' + ai[3]+ '-' +ai[0];//装瓶集团（装瓶厂、城市）-城市等级-渠道-平台-品类（制造商、品牌）
                        }
                    }
                    var map = {};
                    //console.log('temp',ai[0]);
                    arr.push({
                        'groupname': group,
                        //'distri': ai[4],
                    });
                }
                var output = [],
                    keys = [];
                angular.forEach(arr, function (item) {
                    var key = item.groupname;
                    if (keys.indexOf(key) === -1) {
                        keys.push(key);
                        output.push(item);
                    }
                });
                $scope.bardata1 = output;
                switch($scope.visitab){
                    case 'distribution':
                    case 'distribution_store':
                    case 'store_money':
                    case 'store_number':
                    case 'average_amount_per_order':
                    case 'average_number_per_unit':
                    case 'average_purchase_price':
                    case 'average_selling_price':
                        // angular.forEach($scope.bardata1,function (item,i,array){
                        //     $scope.test(item.groupname,i);
                        // });
                        console.log('测试执行了几次test');
                        break;
                    // case 'distribution_store':
                    //     $scope.setstackbaroption('distribution_store');
                    //     console.log('tempitem');
                    //     break;
                    // case 'average_selling_price':
                    //     angular.forEach($scope.bardata1,function (item,i,array){
                    //         $scope.setdoublebaroption(item.groupname,i);
                    //     });
                    //     break;
                    case 'price_promotion_ratio':
                        angular.forEach($scope.bardata1,function (item,i,array){
                            $scope.setlinebaroption0(item.groupname,i);
                        });
                        break;

                    // case 'average_discount_factor':
                    // case 'average_purchase_price':
                    //     $scope.setstackbaroption('average_purchase_price');
                    //     break;
                    // case 'store_money':
                    //     $scope.setstackbaroption('store_money');
                    //     break;
                    // case 'store_number':
                    //     $scope.setstackbaroption('store_number');
                    //     break;
                    // case 'average_amount_per_order':
                    //     $scope.setstackbaroption('average_amount_per_order');
                    //
                    //     break;
                    case 'saleroom':
                    case 'sales_numbers':
                        angular.forEach($scope.bardata1,function (item,i,array) {
                            $scope.setlineBaroption2(item.groupname,i);
                        });
                        break;
                    // case 'sales_numbers':
                    //     angular.forEach($scope.bardata1,function (item,i,array) {
                    //         $scope.setlineBaroption(item.groupname,i);
                    //     });
                    //     break;

                }
                $('.mb-fff').remove();

            },function (data) {
                console.log(data);
                $('.mb-fff').remove();
            });
        };
        // $scope.getChartsData=function(){
        //     $scope.getParams(); //设置$scope.queryfield、$scope.groupbyfield的sql语句参数
        // };
        // $scope.getBarData();
        $scope.getChartsData(); //检查是不是因为初始化函数选择不正确导致画图不能默认
        // angular.forEach($scope.bardata1,function (item,i,array) {
        //     $scope.test(item.groupname,i);
        // });
        //2019-06-26注释掉
        //$scope.getChartsData();
        //组装拼接where条件
        // 下半部分选择框中初始化时 对应维度的全部 是否被选中
        $scope.zpjtall=1;
        $scope.zpcall=0;
        $scope.cityall=0;
        $scope.city_levelall=1;
        $scope.channelall=1;
        $scope.platformall=1;
        $scope.typeall=1;
        $scope.manuall=0;
        $scope.pinpaiall=0;
        $scope.levelall=1;
        $scope.pack_levelall=1;
        $scope.chgcheck = function (item,type) {
            if(type==1){
                item.checked = item.checked == 1 ? 0 : 1;
                if(item.checked){
                    $scope.condition1 = $scope.condition1.replace(')', ',\''+item[0]+'\''+')');
                    if(item[0]=='全部'){
                        $scope.zpjtall=1;
                    }
                }
                else {
                    if(item[0]=='全部'){
                        $scope.zpjtall=0;
                    }
                    let word=',\''+item[0]+'\'';
                    let word0='\''+item[0]+'\'';
                    $scope.condition1 = $scope.condition1.replace(new RegExp(word,'g'),"");
                    $scope.condition1 = $scope.condition1.replace(new RegExp(word0,'g'),"");
                    $scope.condition1=$scope.condition1.replace('in ()','in ('+'\'\')');
                }
            }
            if(type==2){
                item.checked = item.checked == 1 ? 0 : 1;
                if(item.checked){
                    $scope.condition1 = $scope.condition1.replace(')', ',\''+item[0]+'\''+')');
                }
                else {
                    let word=',\''+item[0]+'\'';
                    let word0='\''+item[0]+'\'';
                    $scope.condition1 = $scope.condition1.replace(new RegExp(word,'g'),"");
                    $scope.condition1 = $scope.condition1.replace(new RegExp(word0,'g'),"");
                }
                $scope.condition1=$scope.condition1.replace('in ()','in ('+'\'\')');
            }
            if(type==3){
                item.checked = item.checked == 1 ? 0 : 1;
                if(item.checked){
                    $scope.condition1 = $scope.condition1.replace(')', ',\''+item[0]+'\''+')');
                }
                else {
                    let word=',\''+item[0]+'\'';
                    $scope.condition1 = $scope.condition1.replace(new RegExp(word,'g'),"");
                    $scope.condition1=$scope.condition1.replace('in ()','in ('+'\'\')');

                }
            }
            if(type==4){
                item.checked = item.checked == 1 ? 0 : 1;
                if(item.checked){
                    $scope.citylevelcon = $scope.citylevelcon.replace(')', ',\''+item[0]+'\''+')');
                }
                else {
                    let word=',\''+item[0]+'\'';
                    let word0='\''+item[0]+'\'';
                    $scope.citylevelcon = $scope.citylevelcon.replace(new RegExp(word,'g'),"");
                    $scope.citylevelcon = $scope.citylevelcon.replace(new RegExp(word0,'g'),"\'\'");
                    $scope.citylevelcon=$scope.citylevelcon.replace('in ()','in ('+'\'\')');
                }

            }
            if(type==5){
                item.checked = item.checked == 1 ? 0 : 1;
                if(item.checked){
                    $scope.condition2 = $scope.condition2.replace(')', ',\''+item[0]+'\''+')');
                }
                else {
                    let word=',\''+item[0]+'\'';
                    $scope.condition2 = $scope.condition2.replace(new RegExp(word,'g'),"");
                    $scope.condition2=$scope.condition2.replace('in ()','in ('+'\'\')');
                }
            }
            if(type==6){
                item.checked = item.checked == 1 ? 0 : 1;
                if(item.checked){
                    $scope.condition3= $scope.condition3.replace(')', ',\''+item[0]+'\''+')');
                }
                else {
                    let word=',\''+item[0]+'\'';
                    $scope.condition3 = $scope.condition3.replace(new RegExp(word,'g'),"");
                    $scope.condition3=$scope.condition3.replace('in ()','in ('+'\'\')');

                }
            }
            if(type==7){
                item.checked = item.checked == 1 ? 0 : 1;
                if(item.checked){
                    $scope.condition4= $scope.condition4.replace(')', ',\''+item[0]+'\''+')');
                }
                else {
                    let word=',\''+item[0]+'\'';
                    $scope.condition4 = $scope.condition4.replace(new RegExp(word,'g'),"");
                    $scope.condition4=$scope.condition4.replace('in ()','in ('+'\'\')');
                }
            }
            if(type==8){
                item.checked = item.checked == 1 ? 0 : 1;
                if(item.checked){
                    $scope.condition4= $scope.condition4.replace(')', ',\''+item[0]+'\''+')');
                }
                else{
                    let word=',\''+item[0]+'\'';
                    $scope.condition4 = $scope.condition4.replace(new RegExp(word,'g'),"");
                    $scope.condition4=$scope.condition4.replace('in ()','in ('+'\'\')');
                }
            }
            if(type==9){
                item.checked = item.checked == 1 ? 0 : 1;
                if(item.checked){
                    $scope.condition4= $scope.condition4.replace(')', ',\''+item[0]+'\''+')');
                }
                else {
                    let word=',\''+item[0]+'\'';
                    $scope.condition4 = $scope.condition4.replace(new RegExp(word,'g'),"");
                    $scope.condition4=$scope.condition4.replace('in ()','in ('+'\'\')');
                }
            }
            if(type==10){
                //console.log('item',item.checked);
                item.checked = item.checked == 1 ? 0 : 1;
                if(item.checked){
                    $scope.condition5= $scope.condition5.replace('in (', 'in ('+"\'"+item[0]+"\',");
                }
                else {
                    $scope.condition5 = $scope.condition5.replace(',\''+item[0]+'\'',"");
                    $scope.condition5 = $scope.condition5.replace('\''+item[0]+'\'',"");
                    $scope.condition5=$scope.condition5.replace('in ()','in ('+'\'\')');
                }
            }
            if(type==11){
                item.checked = item.checked == 1 ? 0 : 1;
               // console.log('$scope.condition5',$scope.condition5);
                if(item.checked){
                    $scope.condition5 = $scope.condition5.replace(')', ',\''+item[0]+'\''+')');

                }
                else {
                    //console.log('NNN',',\''+item[0]+'\'');
                    $scope.condition5 = $scope.condition5.replace(',\''+item[0]+'\'',"");
                    $scope.condition5 = $scope.condition5.replace('\''+item[0]+'\'',"");
                    $scope.condition5=$scope.condition5.replace('in ()','in ('+'\'\')');
                }
               // console.log('$scope.condition05',$scope.condition5);
            }
             let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            console.log('$scope.queryfield',$scope.groupbyfield);
            $scope.orderbyfield=$scope.groupbyfield.replace('group',' order');
            $scope.sql1=$scope.queryfield+$scope.condition1+$scope.citylevelcon+$scope.condition2+$scope.condition3+$scope.condition4+$scope.condition5+$scope.groupbyfield+$scope.orderbyfield;
            $scope.sql1=$scope.sql1.replace('(,','(');
             // console.log('$scope.sql1测试子选项chkcheck',$scope.sql1);
            getData.getHttp($scope.sql1).then(function (data){
                var temp = data.results;
                var arr = [];
                for (var i = 0; i < temp.length; i++) {
                    let ai = temp[i];
                    var group='';
                    //容量分级和瓶量分级均未选择
                    if(isgrading==0){

                        group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]; //装瓶集团（装瓶厂、城市）- 全部（城市等级） - 渠道 - 平台
                        // console.log(group);
                        if(iscityleveltype==1){
                            group = ai[1] + '-' + ai[4] + '-' + ai[2] + '-' + ai[3]; //装瓶集团（装瓶厂、城市）- 城市等级 - 渠道 - 平台
                        }
                    }
                    //选择了容量分级或瓶量分级
                    else{
                        group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]+ '-' +ai[0]; //装瓶集团（装瓶厂、城市）-全部（城市等级）-渠道-平台-品类（制造商、品牌）
                        if(iscityleveltype==1){
                            group = ai[1] + '-' + ai[4] + '-' + ai[2] + '-' + ai[3]+ '-' +ai[0];//装瓶集团（装瓶厂、城市）-城市等级-渠道-平台-品类（制造商、品牌）
                        }
                    }
                    var map = {};
                    arr.push({
                        'groupname': group,
                    });
                }
                var output = [],
                    keys = [];
                angular.forEach(arr, function (item) {
                    var key = item.groupname;
                    if (keys.indexOf(key) === -1) {
                        keys.push(key);
                        output.push(item);
                        // console.log(output);
                    }
                });
                $scope.bardata1 = output;
                // console.log('测试ya',$scope.bardata1);
                 switch($scope.visitab){
                     case 'distribution_store':
                     case 'distribution':
                     case 'price_promotion_ratio':
                     case 'average_discount_factor':
                         angular.forEach($scope.bardata1,function (item,i,array) {
                             $scope.test(item.groupname,i);
                         });
                         break;
                     // case 'distribution_store':
                     //     $scope.test('distribution_store');
                     //     break;
                 }
                 },function (data) {
                    console.log(data);
                 });


            // getData.getHttp($scope.sql1).then(function (data){
            //     var temp = data.results;
            //     var arr = [];
            //     for (var i = 0; i < temp.length; i++) {
            //         let ai = temp[i];
            //         var group='';
            //         //容量分级和瓶量分级均未选择
            //         if(isgrading==0){
            //             group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]; //装瓶集团（装瓶厂、城市）- 全部（城市等级） - 渠道 - 平台
            //             if(iscityleveltype==1){
            //                 group = ai[1] + '-' + ai[4] + '-' + ai[2] + '-' + ai[3]; //装瓶集团（装瓶厂、城市）- 城市等级 - 渠道 - 平台
            //             }
            //         }
            //         //选择了容量分级或瓶量分级
            //         else{
            //             group = ai[1] + '-' + '全部' + '-' + ai[2] + '-' + ai[3]+ '-' +ai[4]; //装瓶集团（装瓶厂、城市）-全部（城市等级）-渠道-平台-品类（制造商、品牌）
            //
            //             if(iscityleveltype==1){
            //                 group = ai[1] + '-' + ai[5] + '-' + ai[2] + '-' + ai[3]+ '-' +ai[4];//装瓶集团（装瓶厂、城市）-城市等级-渠道-平台-品类（制造商、品牌）
            //             }
            //         }
            //         var map = {};
            //         arr.push({
            //             // 'category': ai[0],
            //             // 'citytype': ai[1],
            //             // 'systemtype': ai[2],
            //             // 'platform': ai[3],
            //             'groupname': group,
            //             //'distri': ai[4],
            //         });
            //     }
            //     var output = [],
            //         keys = [];
            //     angular.forEach(arr, function (item) {
            //         var key = item.groupname;
            //         if (keys.indexOf(key) === -1) {
            //             keys.push(key);
            //             output.push(item);
            //             // console.log(output);
            //         }
            //     });
            //     $scope.bardata1 = output;
            //     console.log('测试子选项请求数据',$scope.bardata1);
            // },function (data) {
            //     console.log(data);
            // });
        };
        $scope.ischeck = function () {
            if ($scope.typeValue) {
                $scope.typeValue = false;
                document.getElementById("iscityLevel").style.display = "none";
            }
            else{
                $scope.typeValue = true;
                document.getElementById("iscityLevel").style.display = "";
            }
            $scope.getChartsData();
        };
        $scope.test0=function(){
            console.log('这里只能执行一次');
        }
        $scope.baroption = {
            legend: {
                // x: 'right',
                itemWidth: 10,
                itemHeight: 10,
                icon: 'circle',
                data: [],
                selected: {},
            },
            toolbox: {
                right: 30,
                feature: {
                    saveAsImage: {},
                    myExcel: {
                        show: true,
                        title: "导出CSV",
                        icon: "image://http://echarts.baidu.com/images/favicon.png",
                        onclick: function (opts) {
                            var series = opts.option.series; //交错正负轴数据
                            var axisData = opts.option.yAxis[0].data; //坐标数据
                            var title = opts.option.title[0].text;//标题（区域-渠道）
                            console.log(series, axisData);
                            //列标题，逗号隔开，每一个逗号就是隔开一个单元格
                            // var str = `产品,数据\n`;
                            var str = '产品,数据\n';
                            //组装表数据
                            for (var lt = 0; lt < axisData.length; lt++) {
                                for (var j = 0; j < series.length; j++) {
                                    var temp = series[j].data[lt].value;
                                    if (temp != null && temp != undefined) {
                                        // str += `${axisData[lt] + '\t'},` + `${temp.toFixed(4) + '\t'},` + `\n`;
                                        str += "${axisData[lt] + '\t'}," + "${temp.toFixed(4) + '\t'}," + '\n';
                                    } else {
                                        str += '';
                                    }
                                }
                            }
                            //encodeURIComponent解决中文乱码
                            var uri = 'data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(str);
                            //通过创建a标签实现
                            var link = document.createElement("a");
                            link.href = uri;
                            //对下载的文件命名
                            link.download = title + ".csv";
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                    }
                },
                iconStyle: {
                    textPosition: 'bottom'
                }
            },
            title: {
                text: '交错正负轴标签',
                subtext: 'From ExcelHome',
                sublink: 'http://e.weibo.com/1341556070/AjwF2AgQm'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                },
                formatter: '{b}:\n{c}%',
            },
            grid: {
                top: 80,
                bottom: 30,
                left:'10%'
            },
            xAxis: {
                type: 'value',
                position: 'top',
                splitLine: {show: false},
                axisLabel: {
                    formatter: '{value}%'
                },
            },
            yAxis: {
                type: 'category',
                axisLine: {show: true},
                axisLabel: {show: false},
                axisTick: {show: true},
                splitLine: {show: false},
                 //data: ["咖啡", "乳味饮料", "果汁饮料", "水", "植物蛋白饮料", "茶", "植物饮料", "汽水", "组合", "功能饮料"]
                data:[]
            },
            series: [
                {
                    name: '生活费',
                    type: 'bar',
                    stack: '总量',
                    barWidth: 22,
                    label: {
                        normal: {
                            show: true,
                            formatter: '{b}'
                        }
                    },
                    //data: ["50942", "59513", "63372", "63520", "54871", "62823", "48523", "63510", "904", "59055"]
                    data:[]
                }
            ]
        };
        $scope.doublebaroptionlist=[];
        $scope.setdoublebaroption=function(groupname,index){
            $scope.doublebaroptionlist[index]={
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'cross',
                        crossStyle: {
                            color: 'red'
                        }
                    }
                },
                title:{
                    text:groupname+'\n',
                    y:'top',
                    x:'center',
                    padding:0
                },
                toolbox: {
                    feature: {
                        dataView: {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar']},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                legend: {
                    data:['平均售价','平均购买价']
                },
                xAxis: [
                    {
                        type: 'category',
                        data: ['1月','2月','3月','4月','5月','6月'],
                        axisPointer: {
                            type: 'shadow'
                        }
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        name: '价格',
                        // min: 0,
                        // max: 250,
                        // interval: 1,
                        axisLabel: {
                            formatter: '{value} 元'
                        }
                    }
                ],
                series: [
                    {
                        name:'平均售价',
                        type:'bar',
                        itemStyle: {
                            normal: {
                                color:'#75AAEE'
                            }
                        },
                        data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
                    },
                    {
                        name:'平均购买价',
                        type:'bar',
                        itemStyle: {
                            normal: {
                                color:'#E094D2'
                            }
                        },
                        data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
                    }
                ]

            }
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let kpichecked = $scope.kpichecked;
            var params=groupname.split('-');
            let condition01='';
            let groupbyfield01='group by channel,platform';
            switch(citytype){
                case 1:
                    condition01+=' zpjt='+'\''+params[0]+'\'';
                    groupbyfield01+=',zpjt ';
                    break;
                case 2:
                    condition01+=' zpc='+'\''+params[0]+'\'';
                    groupbyfield01+=',zpc ';
                    break;
                case 3:
                    condition01+=' city='+'\''+params[0]+'\'';
                    groupbyfield01+=',city ';
                    break;
            }
            let skutype02='';
            let comparelist=new Array();
            let count=0;
            if($scope.visitab=='average_selling_price'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(cuxiao) cuxiao,sum(sales_amount) amount,count(*) num ','type,cuxiao,amount,num',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(cuxiao) cuxiao,sum(sales_amount) amount,count(*) num ','manu,cuxiao,amount,num',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(cuxiao) cuxiao,sum(sales_amount) amount,count(*) num ','pinpai,cuxiao,amount,num',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(cuxiao) cuxiao,sum(sales_amount) amount,count(*) num ','level,cuxiao,amount,num',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(cuxiao) cuxiao,sum(sales_amount) amount,count(*) num ','pack_level,cuxiao,amount,num',groupname,index,comparelist);
                            break;
                    }

                }

            }



        }
        $scope.linebaroption0list=[];
        $scope.setlinebaroption0=function(groupname,index){
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let kpichecked = $scope.kpichecked;
            var params=groupname.split('-');
            let condition01='';
            let groupbyfield01='group by channel,platform';
            switch(citytype){
                case 1:
                    condition01+=' zpjt='+'\''+params[0]+'\'';
                    groupbyfield01+=',zpjt ';
                    break;
                case 2:
                    condition01+=' zpc='+'\''+params[0]+'\'';
                    groupbyfield01+=',zpc ';
                    break;
                case 3:
                    condition01+=' city='+'\''+params[0]+'\'';
                    groupbyfield01+=',city ';
                    break;
            }
            let skutype02='';
            let comparelist=new Array();
            let count=0;
            if($scope.visitab=='price_promotion_ratio'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(on_sale) onsale,count(*) num,sum(dis) depth ','type,onsale,num,depth',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(on_sale) onsale,count(*) num,sum(dis) depth ','manu,onsale,num,depth',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(on_sale) onsale,count(*) num,sum(dis) depth ','pinpai,onsale,num,depth',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(on_sale) onsale,count(*) num,sum(dis) depth ','level,onsale,num,depth',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(on_sale) onsale,count(*) num,sum(dis) depth ','pack_level,onsale,num,depth',groupname,index,comparelist);
                            break;
                    }

                }

            }

        }
        $scope.datalist=[];
        $scope.test = function (groupname,index) {
            //console.log('test执行了吗',$scope.typelist);
            var labelRight = {
                normal: {
                    color: '#363636',
                    position: 'left'
                }
            };
            $scope.baroptionlist[index]={
                legend: {
                    // x: 'right',
                    itemWidth: 10,
                    itemHeight: 10,
                    icon: 'circle',
                    data: [],
                    selected: {},
                },
                itemStyle: {
                    normal: {
                        //每根柱子颜色设置
                        color:'red'
                        }
                },
               toolbox: {
                    right: 30,
                    feature: {
                        saveAsImage: {},
                        myExcel: {
                            show: true,
                            title: "导出CSV",
                            icon: "image://http://echarts.baidu.com/images/favicon.png",
                            onclick: function (opts) {
                                var series = opts.option.series; //交错正负轴数据
                                var axisData = opts.option.yAxis[0].data; //坐标数据
                                var title = opts.option.title[0].text;//标题（区域-渠道）
                                console.log(series, axisData);
                                //列标题，逗号隔开，每一个逗号就是隔开一个单元格
                                // var str = `产品,数据\n`;
                                var str = '产品,数据\n';
                                //组装表数据
                                for (var lt = 0; lt < axisData.length; lt++) {
                                    for (var j = 0; j < series.length; j++) {
                                        var temp = series[j].data[lt].value;
                                        if (temp != null && temp != undefined) {
                                            // str += `${axisData[lt] + '\t'},` + `${temp.toFixed(4) + '\t'},` + `\n`;
                                            str += "${axisData[lt] + '\t'}," + "${temp.toFixed(4) + '\t'}," + '\n';
                                        } else {
                                            str += '';
                                        }
                                    }
                                }
                                //encodeURIComponent解决中文乱码
                                var uri = 'data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(str);
                                //通过创建a标签实现
                                var link = document.createElement("a");
                                link.href = uri;
                                //对下载的文件命名
                                link.download = title + ".csv";
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }
                        }
                    },
                    iconStyle: {
                        textPosition: 'bottom'
                    }
                },
                title: {
                    text: '交错正负轴标签',
                    subtext: 'From ExcelHome',
                    x:'center',
                    sublink: 'http://e.weibo.com/1341556070/AjwF2AgQm'
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                        type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    },
                    formatter: '{b}:\n{c}',
                },
                grid: {
                    top: 80,
                    bottom: 30,
                    left:'20%'
                },
                xAxis: {
                    type: 'value',
                    position: 'top',
                    splitLine: {show: false},
                    axisLabel: {
                        formatter: '{value}%'
                    },
                },
                yAxis: {
                    type: 'category',
                    axisLine: {show: true},
                    axisLabel: {show: false},
                    axisTick: {show: true},
                    splitLine: {show: false},
                    //data: ["咖啡", "乳味饮料", "果汁饮料", "水", "植物蛋白饮料", "茶", "植物饮料", "汽水", "组合", "功能饮料"]
                    data:[]
                },
                series: [
                    {
                        name: '生活费',
                        type: 'bar',
                        stack: '总量',
                        barWidth: 22,
                        label: {
                            normal: {
                                show: true,
                                formatter: '{b}'
                            }
                        },
                        //data: ["50942", "59513", "63372", "63520", "54871", "62823", "48523", "63510", "904", "59055"]
                        data:[],
                        markPoint: {
                            symbolSize: 1,
                            symbolOffset: [0, '50%'],
                            label: {
                                normal: {
                                    // formatter: '{b|{b}}{c|{c}%}',
                                    formatter: function (params) {

                                        // var relVal = params[0].name;
                                        // var value = 0;
                                        // var value2=0;
                                        // var reg=new RegExp('-','g');
                                        // for (var i = 0, l = params.length; i < l; i++) {
                                        //     value += params[i].value;
                                        //     // value2+=$scope.changestack[i].data.join("-").replace(reg,'');
                                        // }
                                        // for (var i = 0; i < params.length; i++) {
                                        //       console.log('params[i]',params); //默认11条数据
                                        //     var seriesName=params[i].seriesName;
                                        //     var name=params[i].name;
                                        //     var gradient=100;
                                        //     // var gradient=$scope.changestack[i].value2;
                                        //     // angular.forEach($scope.changestack,function (item,index,array) {
                                        //     //     angular.forEach(item.data,function (item0,index0,array0) {
                                        //     //         if(item0[0]==name && item0[1]==seriesName){
                                        //     //             gradient=item0[2];
                                        //     //         }
                                        //     //     });
                                        //     // });
                                        //     // relVal += '<br/>' + params[i].seriesName + ' : ' +params[i].value+'('+gradient+'%)';
                                        //
                                        //
                                        // }
                                        // var relVal ='<span>'+params.value'+'</span>';
                                        var relVal =params.value+'%';

                                        return relVal;
                                    },
                                    position: 'right',
                                    distance: 20,
                                    rich: {
                                        b: {
                                            color: '#333'
                                        },
                                        c: {
                                             color: '#00ff00',
                                            // color:'#00BCA0',
                                            fontSize: 10
                                        }
                                    }
                                }
                            },
                            data: [
                                {name:'上升',value:20.65,xAxis:94,yAxis:'咖啡'},
                                {name:'下降',value:30,xAxis:94,yAxis:'乳味饮料'},
                                {name:'下降',value:20,xAxis:94,yAxis:'果汁饮料'},
                                {name:'上升',value:30,xAxis:94,yAxis:'水'},
                                {name:'上升',value:20,xAxis:94,yAxis:'植物饮料'},
                                {name:'上升',value:30,xAxis:94,yAxis:'全部'}
                            ]
                        }
                    }
                ]
            };
            $scope.baroptionlist[index].title.text=groupname;
             //需包含"全部"的数据
            //let basesql='(select * from sku_2018 where dt between'+'\''+$scope.month+'\''+ ' and ' +'\''+$scope.month_next+'\')';
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let kpichecked = $scope.kpichecked;
            var params=groupname.split('-');
            let condition01='';
            let groupbyfield01='group by channel,platform';
            switch(citytype){
                case 1:
                    condition01+=' zpjt='+'\''+params[0]+'\'';
                    groupbyfield01+=',zpjt ';
                    break;
                case 2:
                    condition01+=' zpc='+'\''+params[0]+'\'';
                    groupbyfield01+=',zpc ';
                    break;
                case 3:
                    condition01+=' city='+'\''+params[0]+'\'';
                    groupbyfield01+=',city ';
                    break;
            }
            let skutype02='';
            let comparelist=new Array();
            let count=0;
            if($scope.visitab=='distribution_store'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('count(distinct storeid) storeid ','type,storeid',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('count(distinct storeid) storeid ','manu,storeid',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('count(distinct storeid) storeid ','pinpai,storeid',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('count(distinct storeid) storeid ','level,storeid',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('count(distinct storeid) storeid ','pack_level,storeid',groupname,index,comparelist);
                            break;
                    }

                }

            }
            if($scope.visitab=='distribution'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            if(!$scope.typelist){
                                $scope.typelist=[["咖啡"],["乳味饮料"],["果汁饮料"],["植物蛋白饮料"],["水"],["植物饮料"],["茶"],["全部"],["汽水"],["组合"],["功能饮料"]];
                            }
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('count(distinct storeid) storeid ','type,storeid',groupname,index,comparelist);
                            console.log('拍错');
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('count(distinct storeid) storeid ','manu,storeid',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('count(distinct storeid) storeid ','pinpai,storeid',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('count(distinct storeid) storeid ','level,storeid',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('count(distinct storeid) storeid ','pack_level,storeid',groupname,index,comparelist);
                            break;
                    }

                }

            }
            if($scope.visitab=='average_selling_price'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(cuxiao)*1.0/count(cuxiao) avsell ','type,avsell',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(cuxiao)*1.0/count(cuxiao) avsell ','type,avsell',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(cuxiao)*1.0/count(cuxiao) avsell ','type,avsell',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(cuxiao)*1.0/count(cuxiao) avsell ','type,avsell',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(cuxiao)*1.0/count(cuxiao) avsell ','type,avsell',groupname,index,comparelist);
                            break;
                    }

                }

            }
            if($scope.visitab=='average_purchase_price'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)/sum(salescount) avbuy ','type,avbuy',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)/sum(salescount) avbuy ','type,avbuy',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)/sum(salescount) avbuy ','type,avbuy',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)/sum(salescount) avbuy ','type,avbuy',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)/sum(salescount) avbuy ','type,avbuy',groupname,index,comparelist);
                            break;
                    }

                }

            }
            if($scope.visitab=='store_money'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount) amount,count(distinct storeid) store ','type,amount,store',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)*1.0/count(distinct storeid) storeamount ','manu,storeamount',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)*1.0/count(distinct storeid) storeamount ','pinpai,storeamount',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)*1.0/count(distinct storeid) storeamount ','level,storeamount',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)*1.0/count(distinct storeid) storeamount ','pack_level,storeamount',groupname,index,comparelist);
                            break;
                    }

                }

            }
            if($scope.visitab=='store_number'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount) num,count(distinct storeid) store ','type,num,store',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount) num,count(distinct storeid) store ','manu,num,store',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount) num,count(distinct storeid) store ','pinpai,num,store',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount) count,count(distinct storeid) store ','level,count,store',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount) count,count(distinct storeid) store ','pack_level,count,store',groupname,index,comparelist);
                            break;
                    }

                }

            }
            if($scope.visitab=='average_amount_per_order'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)*1.0/count(*) orderamount ','type,orderamount',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)*1.0/count(*) orderamount ','manu,orderamount',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)*1.0/count(*) orderamount ','pinpai,orderamount',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)*1.0/count(*) orderamount ','level,orderamount',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount)*1.0/count(*) orderamount ','pack_level,orderamount',groupname,index,comparelist);
                            break;
                    }

                }

            }
            if($scope.visitab=='average_number_per_unit'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount)*1.0/count(*) ordercount ','type,ordercount',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount)*1.0/count(*) ordercount ','manu,ordercount',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount)*1.0/count(*) ordercount ','pinpai,ordercount',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount)*1.0/count(*) ordercount ','level,ordercount',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount)*1.0/count(*) ordercount ','pack_level,ordercount',groupname,index,comparelist);
                            break;
                    }

                }

            }


            // else if($scope.visitab=='price_promotion_ratio'){
            //     if(isgrading==0){
            //         switch(skutype){
            //             case 1:
            //                 skutype02='select type,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)) from ';
            //                 //skutype02='select type,count(distinct storeid_copy) from';
            //                 groupbyfield01+=',type ';
            //                 console.log('gg',$scope.typelist);
            //                 angular.forEach($scope.typelist,function (item,index,array) {
            //                     if(item.checked==1){
            //                         // comparelist.push(item[0]);
            //                         comparelist[count]=[];
            //                         comparelist[count].push(item[0]);
            //                         count++;
            //                     }
            //                 });
            //                 //console.log('comparelist',comparelist);
            //                 break;
            //             case 2:
            //                 skutype02='select manu,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)) from';
            //                 groupbyfield01+=',manu ';
            //                 angular.forEach($scope.manulist,function (item,index,array) {
            //                     if(item.checked==1){
            //                         comparelist[count]=[];
            //                         comparelist[count].push(item[0]);
            //                         count++;
            //                     }
            //                 });
            //                 break;
            //             case 3:
            //                 skutype02='select pinpai,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)) from';
            //                 groupbyfield01+=',pinpai';
            //                 angular.forEach($scope.pinpailist,function (item,index,array) {
            //                     if(item.checked==1){
            //                         comparelist[count]=[];
            //                         comparelist[count].push(item[0]);
            //                         count++;
            //                     }
            //                 });
            //                 break;
            //         }
            //     }
            //     else if(isgrading==1){
            //         skutype02='select level,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)) from ';
            //         groupbyfield01='group by level';
            //         angular.forEach($scope.capacitylist,function (item,index,array){
            //             if(item.checked==1){
            //                 comparelist[count]=[];
            //                 comparelist[count].push(item[0]);
            //                 count++;
            //             }
            //         });
            //     }
            //     else if(isgrading==2){
            //         skutype02='select pack_level,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)) from ';
            //         groupbyfield01='group by pack_level';
            //         angular.forEach($scope.bottlelist,function (item,index,array) {
            //             if(item.checked==1){
            //                 comparelist[count]=[];
            //                 comparelist[count].push(item[0]);
            //                 count++;
            //             }
            //         });
            //     }
            // }
            // else if($scope.visitab=='average_discount_factor'){
            //     if(isgrading==0){
            //         switch(skutype){
            //             case 1:
            //                 skutype02='select type,sum(dis)/sum(on_sale) from ';
            //                 //skutype02='select type,count(distinct storeid_copy) from';
            //                 groupbyfield01+=',type ';
            //                 angular.forEach($scope.typelist,function (item,index,array) {
            //                     if(item.checked==1){
            //                         comparelist[count]=[];
            //                         comparelist[count].push(item[0]);
            //                         count++;
            //                     }
            //                 });
            //                 break;
            //             case 2:
            //                 skutype02='select manu,sum(dis)/sum(on_sale) from';
            //                 groupbyfield01+=',manu ';
            //                 angular.forEach($scope.manulist,function (item,index,array) {
            //                     if(item.checked==1){
            //                         comparelist[count]=[];
            //                         comparelist[count].push(item[0]);
            //                         count++;
            //                     }
            //                 });
            //                 break;
            //             case 3:
            //                 skutype02='select pinpai,sum(dis)/sum(on_sale) from';
            //                 groupbyfield01+=',pinpai';
            //                 angular.forEach($scope.pinpailist,function (item,index,array) {
            //                     if(item.checked==1){
            //                         comparelist[count]=[];
            //                         comparelist[count].push(item[0]);
            //                         count++;
            //                     }
            //                 });
            //                 break;
            //         }
            //     }
            //     else if(isgrading==1){
            //         skutype02='select level,sum(dis)/sum(on_sale) from ';
            //         groupbyfield01='group by level';
            //         angular.forEach($scope.capacitylist,function (item,index,array){
            //             if(item.checked==1){
            //                 comparelist[count]=[];
            //                 comparelist[count].push(item[0]);
            //                 count++;
            //             }
            //         });
            //     }
            //     else if(isgrading==2){
            //         skutype02='select pack_level,sum(dis)/sum(on_sale) from ';
            //         groupbyfield01='group by pack_level';
            //         angular.forEach($scope.bottlelist,function (item,index,array) {
            //             if(item.checked==1){
            //                 comparelist[count]=[];
            //                 comparelist[count].push(item[0]);
            //                 count++;
            //             }
            //         });
            //     }
            // }

        }
        $scope.setbaroption = function (kpi, min, max,groupname) {
            let basesql='(select * from sku_2018 where dt between'+'\''+$scope.month+'\''+ ' and ' +'\''+$scope.month_next+'\')';
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let systemtype = $scope.deepsystemcheck == 'systemtype' ? 1 : $scope.deepsystemcheck == 'system' ? 2 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let platform = $scope.deepplatformcheck == 'platform' ? 1 : null;
            let cityLevelListtype = $scope.cityLevelListcheck == 'cityLevelListtype' ? 1 : 0;
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let kpichecked = $scope.kpichecked;
            var labelRight = {
                normal: {
                    color: '#363636',
                    position: 'left'
                }
            };
            var params=groupname.split('-');
            //console.log('groupname',groupname);
            let condition01='';
            let groupbyfield01='group by channel,platform';
            switch(citytype){
                case 1:
                    condition01+=' zpjt='+'\''+params[0]+'\'';
                    groupbyfield01+=',zpjt ';
                    break;
                case 2:
                    condition01+=' zpc='+'\''+params[0]+'\'';
                    groupbyfield01+=',zpc ';
                    break;
                case 3:
                    condition01+=' city='+'\''+params[0]+'\'';
                    groupbyfield01+=',city ';
                    break;
            }
            let skutype02='';
            switch(skutype){
                case 1:
                    skutype02='select type from';
                    groupbyfield01+=',type ';
                    break;
                case 2:
                    skutype02='select manu from';
                    groupbyfield01+=',manu ';
                    break;
                case 3:
                    skutype02='select pinpai from';
                    groupbyfield01+=',pinpai';
                    break;
            }
            let condition02='';
            if(iscityleveltype==1){
                condition02='and city_level='+'\''+params[1]+'\'';
                groupbyfield01+=',city_level'
            }
            let condition03="and channel="+'\''+params[2]+'\'';
            let condition04="and platform="+'\''+params[3]+'\'';
            let sql01=skutype02+basesql+'where '+condition01+condition02+condition03+condition04+groupbyfield01;
            getData.getHttp(sql01).then(function (data){
            },function (data) {
                console.log(data);
            });
            return $scope.baroption;
            // let condition='';
            // switch(citytype){
            //     case 1:
            //         condition+='zpjt='+params[0];
            //         break;
            //     case 2:
            //         condition+='zpc='+params[0];
            //         break;
            //     case 3:
            //         condition+='city='+params[0];
            //         break;
            // }
            // if(iscityleveltype==1){
            //     condition+='city_level='+params[1];
            // }
            // let sql1='select count(distinct storeid) from '+basesql+' where'+condition+'group by dt,channel,platform,city_level';
            // let sql2='select count(distinct storeid) from '+basesql+' group by dt,channel,platform,city_level';
            //
            // if(isgrading!=0){
            //     switch(skutype){
            //         case 1:
            //             condition+='type='+params[4];
            //             break;
            //         case 2:
            //             condition+='manu='+params[0];
            //             break;
            //         case 3:
            //             condition+='pinpai='+params[0];
            //             break;
            //     }
            // }
            // switch(isgrading){
            //     case 1:
            //         sql1+=',level';
            //         sql2+=',level';
            //         break;
            //     case 2:
            //         sql1+=',pack_level';
            //         sql2+=',pack_level';
            //         break;
            //     case 0:
            //         break;
            // }
            $scope.newskus = [];
            // $scope.baroption.title.text=groupname;
            // console.log('到底怎么回事');
            // return $scope.baroption;


        };
        //$scope.test('到底怎么回事');
//堆叠柱状图
        //堆叠柱形图配置项
        $scope.stackbaroption = {
            tooltip: {
                trigger: 'axis',
                position:"top",
                // textStyle:{
                //     fontSize:16
                // },
                // formatter: "{a} {c} ({d}%)",

                formatter: function (params) {
                    var relVal = params[0].name;
                    var value = 0;
                    // var value2=0;
                    // var reg=new RegExp('-','g');
                    for (var i = 0, l = params.length; i < l; i++) {
                        value += params[i].value;
                        // value2+=$scope.changestack[i].data.join("-").replace(reg,'');
                    }
                    for (var i = 0; i < params.length; i++) {
                          // console.log('params[i]',params[0]); //默认11条数据
                        var seriesName=params[i].seriesName;
                        var name=params[i].name;
                        var gradient=100;
                        // var gradient=$scope.changestack[i].value2;
                        angular.forEach($scope.changestack,function (item,index,array) {
                            angular.forEach(item.data,function (item0,index0,array0) {
                                if(item0[0]==name && item0[1]==seriesName){
                                     gradient=item0[2];
                                }
                            });
                        });
                        relVal += '<br/>' + params[i].seriesName + ' : ' +params[i].value+'('+gradient+'%)';

                    }
                    return relVal;
                },

                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                },
            },
            legend: {
                //x: 'left',
                orient: 'vertical',  //垂直显示
                y: 'center',    //延Y轴居中
                x: 'right', //居右显示
                itemWidth: 10,
                itemHeight: 10,
                align: 'left',
                icon: 'circle',
                data: [],
                selected: {},
            },
            grid: {
                left: '0%',
                // right: '1%',
                bottom: '1%',
                width:'100%',
                containLabel: true
            },
            toolbox: {
                right: 30,
                feature: {
                    saveAsImage: {},
                    myExcel: {
                        show: true,
                        title: "导出Excel",
                        icon: "image://http://echarts.baidu.com/images/favicon.png",
                        onclick: function (opts) {
                            var target = $("#deepdive>li.active>a").text();//获取指标
                            var series = opts.option.series; //堆叠柱形图数据
                            var axisData = opts.option.xAxis[0].data; //坐标数据
                            // var str = `筛选项,`; //表头第一列
                             var str = '筛选项,'; //表头第一列
                            for (var tdHead = 0; tdHead < series.length; tdHead++) {
                                str += series[tdHead].name + ',';
                            }
                            str += '\n';
                            //详细数据
                            for (var lt = 0; lt < axisData.length; lt++) {
                                str += axisData[lt] + ',';
                                for (var j = 0; j < series.length; j++) {
                                    var pillar = series[j].data;
                                    var temp = pillar[lt].value;
                                    if (temp != null && temp != undefined) {
                                        str += temp + ',';
                                    } else {
                                        str += '';
                                    }
                                }
                                str += '\n';
                            }
                            //encodeURIComponent解决中文乱码
                            var uri = 'data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(str);
                            //通过创建a标签实现
                            var link = document.createElement("a");
                            link.href = uri;
                            //对下载的文件命名
                            link.download = target + ".csv";
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                    }
                }
            },
            xAxis: [
                {
                    type: 'category',
                    data: [],
//                    axisLabel: {
//                        rotate: 10
//                    }
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

        $scope.color=['#92CCB5','#7DB3CF','#6683CF','#AE77DC','#96CD96','#7ACCCA','#9E96FD','#C9A1D5','#52B7C1','#7BC089','#74ABEE','#D380D2','#80C0E4','#5A73EA','#5FC9A5','#E094D4'];
        // $scope.color= [
        //     {"name":"汽水","color":"#FF0000"},
        //     {"name":"果汁","color":"#FFC000"},
        //     {"name":"植物蛋白","color":"#ccff99"},
        //     {"name":"茶","color":"#92d050"},
        //     {"name":"功能饮料","color":"#CFA72E"},
        //     {"name":"全部","color":"#bb6f60"},
        //     {"name":"咖啡","color":"#c08000"},
        //     {"name":"补水饮料","color":"#47cfff"},
        //     {"name":"水","color":"#0070C0"},
        //     {"name":"可口可乐","color":"#FF0000"},
        //     {"name":"雪碧","color":"#00B050"},
        //     {"name":"怡泉","color":"#00FF99"},
        //     {"name":"芬达","color":"#FFFF00"},
        //     {"name":"百事","color":"#0033CC"},
        //     {"name":"美汁源果汁","color":"#F79646"},
        //     {"name":"康师傅果汁","color":"#ffc000"},
        //     {"name":"统一果汁","color":"#ff6c00"},
        //     {"name":"三得利","color":"#ffde00"},
        //     {"name":"美汁源植物蛋白","color":"#ccff99"},
        //     {"name":"椰树","color":"#91ff61"},
        //     {"name":"乔雅","color":"#c08000"},
        //     {"name":"雀巢","color":"#8b4500"},
        //     {"name":"水动乐","color":"#00deff"},
        //     {"name":"可口可乐水","color":"#DBEEF3"},
        //     {"name":"康师傅水","color":"#0070C0"},
        //     {"name":"农夫山泉水","color":"#558ED5"},
        //     {"name":"依云","color":"#003ea4"},
        //     {"name":"巴黎气泡水","color":"#002aff"},
        //     {"name":"怡宝","color":"#CCFFFF"},
        //     {"name":'乳味饮料',"color":"#47CFFF"},
        //     {"name":'植物蛋白饮料',"color":"#47CFF"},
        //     {"name":'植物饮料',"color":"#FFF7B0"},
        //     {"name":'组合',"color":"#C23531"},
        // ];

        $scope.setstackbaroption = function (type) {    //堆叠柱状图
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let kpichecked = $scope.kpichecked;
            var labelRight = {
                normal: {
                    color: '#363636',
                    position: 'left'
                }
            };
            $scope.stackbaroption.xAxis[0].data = [];
            $scope.stackbaroption.legend.selected = {};
            $scope.stackbaroption.legend.data=[];
            $scope.stackbaroption.series = [];
            $scope.changestack=[];
            $scope.stackbardata = [];
            var groupnamelist=[];
            var stackbardata=new Array();
            var laststackbardata=new Array();
            angular.forEach($scope.bardata1,function (item,index,array) {
                    $scope.stackbaroption.xAxis[0].data.push(item.groupname);
                    var groupname=item.groupname;

                    var params=groupname.split('-');
                    let condition01='';
                    let groupbyfield01='group by channel,platform';
                    switch(citytype){
                        case 1:
                            condition01+=' zpjt='+'\''+params[0]+'\'';
                            groupbyfield01+=',zpjt ';
                            break;
                        case 2:
                            condition01+=' zpc='+'\''+params[0]+'\'';
                            groupbyfield01+=',zpc ';
                            break;
                        case 3:
                            condition01+=' city='+'\''+params[0]+'\'';
                            groupbyfield01+=',city ';
                            break;
                    }
                    let skutype02='';
                    let comparelist=new Array();
                    if(type=='distribution_store'){
                        if(isgrading==0){
                            switch(skutype){
                                case 1:
                                    skutype02='select type,sum(storeid) from ';
                                    //skutype02='select type,count(distinct storeid_copy) from';
                                    groupbyfield01+=',type ';
                                    angular.forEach($scope.typelist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                                case 2:
                                    skutype02='select manu,sum(storeid) from';
                                    groupbyfield01+=',manu ';
                                    angular.forEach($scope.manulist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                                case 3:
                                    skutype02='select pinpai,sum(storeid) from';
                                    groupbyfield01+=',pinpai';
                                    angular.forEach($scope.pinpailist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                            }
                        }
                        else if(isgrading==1){
                            skutype02='select level,sum(storeid) from ';
                            groupbyfield01='group by level';
                            angular.forEach($scope.capacitylist,function (item,index,array){
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });

                        }
                        else if(isgrading==2){
                            skutype02='select pack_level,sum(storeid) from ';
                            groupbyfield01='group by pack_level';
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });
                        }
                    }
                    else if(type=='average_selling_price'){
                        if(isgrading==0){
                            switch(skutype){
                                case 1:
                                    skutype02='select type,sum(cuxiao)*1.0/sum(total) from ';
                                    //skutype02='select type,count(distinct storeid_copy) from';
                                    groupbyfield01+=',type ';
                                    angular.forEach($scope.typelist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    //console.log('comparelist',comparelist);
                                    break;
                                case 2:
                                    skutype02='select manu,sum(cuxiao)*1.0/sum(total) from';
                                    groupbyfield01+=',manu ';
                                    angular.forEach($scope.manulist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                                case 3:
                                    skutype02='select pinpai,sum(cuxiao)*1.0/sum(total) from';
                                    groupbyfield01+=',pinpai';
                                    angular.forEach($scope.pinpailist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                            }
                        }
                        else if(isgrading==1){
                            skutype02='select level,sum(cuxiao)*1.0/sum(total) from ';
                            groupbyfield01='group by level';
                            angular.forEach($scope.capacitylist,function (item,index,array){
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });

                        }
                        else if(isgrading==2){
                            skutype02='select pack_level,sum(cuxiao)*1.0/sum(total) from ';
                            groupbyfield01='group by pack_level';
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });
                        }
                    }
                    else if(type=='average_purchase_price'){
                        if(isgrading==0){
                            switch(skutype){
                                case 1:
                                    skutype02='select type,sum(sales_amount)*1.0/sum(salescount) from ';
                                    //skutype02='select type,count(distinct storeid_copy) from';
                                    groupbyfield01+=',type ';
                                    angular.forEach($scope.typelist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    //console.log('comparelist',comparelist);
                                    break;
                                case 2:
                                    skutype02='select manu,sum(sales_amount)*1.0/sum(salescount) from';
                                    groupbyfield01+=',manu ';
                                    angular.forEach($scope.manulist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                                case 3:
                                    skutype02='select pinpai,sum(sales_amount)*1.0/sum(salescount) from';
                                    groupbyfield01+=',pinpai';
                                    angular.forEach($scope.pinpailist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                            }
                        }
                        else if(isgrading==1){
                            skutype02='select level,sum(sales_amount)*1.0/sum(salescount) from ';
                            groupbyfield01='group by level';
                            angular.forEach($scope.capacitylist,function (item,index,array){
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });
                        }
                        else if(isgrading==2){
                            skutype02='select pack_level,sum(sales_amount)*1.0/sum(salescount) from ';
                            groupbyfield01='group by pack_level';
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });
                        }
                    }
                    else if(type=='store_money'){
                        if(isgrading==0){
                            switch(skutype){
                                case 1:
                                    skutype02='select type,sum(sales_amount)*1.0/sum(storeid) from ';
                                    //skutype02='select type,count(distinct storeid_copy) from';
                                    groupbyfield01+=',type ';
                                    angular.forEach($scope.typelist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    ///console.log('comparelist',comparelist);
                                    break;
                                case 2:
                                    skutype02='select manu,sum(sales_amount)*1.0/sum(storeid) from';
                                    groupbyfield01+=',manu ';
                                    angular.forEach($scope.manulist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                                case 3:
                                    skutype02='select pinpai,sum(sales_amount)*1.0/sum(storeid) from';
                                    groupbyfield01+=',pinpai';
                                    angular.forEach($scope.pinpailist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                            }
                        }
                        else if(isgrading==1){
                            skutype02='select level,sum(sales_amount)*1.0/sum(storeid) from ';
                            groupbyfield01='group by level';
                            angular.forEach($scope.capacitylist,function (item,index,array){
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });
                        }
                        else if(isgrading==2){
                            skutype02='select pack_level,sum(sales_amount)*1.0/sum(storeid) from ';
                            groupbyfield01='group by pack_level';
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });
                        }
                    }
                    else if(type=='store_number'){
                        if(isgrading==0){
                            switch(skutype){
                                case 1:
                                    skutype02='select type,sum(salescount)*1.0/sum(storeid) from ';
                                    //skutype02='select type,count(distinct storeid_copy) from';
                                    groupbyfield01+=',type ';
                                    angular.forEach($scope.typelist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                   // console.log('comparelist',comparelist);
                                    break;
                                case 2:
                                    skutype02='select manu,sum(salescount)*1.0/sum(storeid) from';
                                    groupbyfield01+=',manu ';
                                    angular.forEach($scope.manulist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                                case 3:
                                    skutype02='select pinpai,sum(salescount)*1.0/sum(storeid) from';
                                    groupbyfield01+=',pinpai';
                                    angular.forEach($scope.pinpailist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                            }
                        }
                        else if(isgrading==1){
                            skutype02='select level,sum(salescount)*1.0/sum(storeid) from ';
                            groupbyfield01='group by level';
                            angular.forEach($scope.capacitylist,function (item,index,array){
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });

                        }
                        else if(isgrading==2){
                            skutype02='select pack_level,sum(salescount)*1.0/sum(storeid) from ';
                            groupbyfield01='group by pack_level';
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });
                        }

                    }
                    else if(type=='average_amount_per_order'){
                        if(isgrading==0){
                            switch(skutype){
                                case 1:
                                    skutype02='select type,sum(sales_amount)*1.0/sum(total) from ';
                                    //skutype02='select type,count(distinct storeid_copy) from';
                                    groupbyfield01+=',type ';
                                    angular.forEach($scope.typelist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    //console.log('comparelist',comparelist);
                                    break;
                                case 2:
                                    skutype02='select manu,sum(sales_amount)*1.0/sum(total) from';
                                    groupbyfield01+=',manu ';
                                    angular.forEach($scope.manulist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                                case 3:
                                    skutype02='select pinpai,sum(sales_amount)*1.0/sum(total) from';
                                    groupbyfield01+=',pinpai';
                                    angular.forEach($scope.pinpailist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                            }
                        }
                        else if(isgrading==1){
                            skutype02='select level,sum(sales_amount)*1.0/sum(total) from ';
                            groupbyfield01='group by level';
                            angular.forEach($scope.capacitylist,function (item,index,array){
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });

                        }
                        else if(isgrading==2){
                            skutype02='select pack_level,sum(sales_amount)*1.0/sum(total) from ';
                            groupbyfield01='group by pack_level';
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });
                        }
                    }
                    else if(type=='average_number_per_unit'){
                        if(isgrading==0){
                            switch(skutype){
                                case 1:
                                    skutype02='select type,sum(salescount)*1.0/sum(total) from ';
                                    //skutype02='select type,count(distinct storeid_copy) from';
                                    groupbyfield01+=',type ';
                                    angular.forEach($scope.typelist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    //console.log('comparelist',comparelist);
                                    break;
                                case 2:
                                    skutype02='select manu,sum(salescount)*1.0/sum(total) from';
                                    groupbyfield01+=',manu ';
                                    angular.forEach($scope.manulist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                                case 3:
                                    skutype02='select pinpai,sum(salescount)*1.0/sum(total) from';
                                    groupbyfield01+=',pinpai';
                                    angular.forEach($scope.pinpailist,function (item,index,array) {
                                        if(item.checked==1){
                                            comparelist.push(item[0]);
                                        }
                                    });
                                    break;
                            }
                        }
                        else if(isgrading==1){
                            skutype02='select level,sum(salescount)*1.0/sum(total) from ';
                            groupbyfield01='group by level';
                            angular.forEach($scope.capacitylist,function (item,index,array){
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });

                        }
                        else if(isgrading==2){
                            skutype02='select pack_level,sum(salescount)*1.0/sum(total) from ';
                            groupbyfield01='group by pack_level';
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist.push(item[0]);
                                }
                            });
                        }
                    }
                //    请求数据
                    let condition02='';
                    if(iscityleveltype==1){
                        condition02='and city_level='+'\''+params[1]+'\'';
                        groupbyfield01+=',city_level'
                    }
                    let condition03="and channel="+'\''+params[2]+'\'';
                    let condition04="and platform="+'\''+params[3]+'\'';
                    let sql01=skutype02+$scope.basesql+' where'+condition01+condition02+condition03+condition04+groupbyfield01;
                    var reg1=new RegExp($scope.month,'g');
                    var reg2=new RegExp($scope.month_next,'g');
                    let lastsql01=sql01.replace(reg1,$scope.lastmonth);
                    lastsql01=lastsql01.replace(reg2,$scope.lastmonth_next);
                    getData.getHttp(sql01).then(function (data){
                           getData.getHttp(lastsql01).then(function (data0){
                               var result='';
                               angular.forEach(data.results,function (item,index,array) {
                                   result+=item[0];
                               });
                               var result2='';
                               angular.forEach(data0.results,function (item,index,array) {
                                   result2+=item[0];
                               });
                               let compare=comparelist;
                               // console.log('comparelist',comparelist);
                               angular.forEach(compare,function (item0,index0,array0) {
                                   comparelist[index0]=[];
                                   // console.log('comparelist',comparelist);
                                   if(result.indexOf(item0[0])>-1){
                                       angular.forEach(data.results,function (item,index,array) {
                                           if(item0==item[0]){
                                               comparelist[index0][0]=item0;
                                               comparelist[index0][1]=item[1];
                                           }
                                       });
                                   }
                                   else{
                                       comparelist[index0][0]=item0;
                                       comparelist[index0][1]=0;
                                   }
                               });
                               compare=comparelist;
                               angular.forEach(compare,function (item0,index0,array0) {
                                   if(result2.indexOf(item0[0])>-1){
                                       angular.forEach(data0.results,function (item,index,array) {
                                           if(item0[0]==item[0]){
                                               // comparelist[index0][2]=(comparelist[index0][1]-item[1])/item[1];
                                               // console.log('^^',comparelist[index0][1]);
                                               // let rate=comparelist[index0][1]-item[1];
                                               // console.log('&&',rate);
                                               comparelist[index0].push(item[1]);
                                           }
                                       });
                                   }
                                   else{
                                       comparelist[index0].push(0);
                                   }
                               });


                               comparelist.sort(function(x, y){
                                   return x[1] - y[1];
                               });
                               // console.log('comparelist12',comparelist);
                               stackbardata.push(comparelist);
                                // console.log('comparelist2',comparelist);
                                // console.log('stackbardata ',stackbardata);
                               groupnamelist.push(groupname);

                               if(stackbardata.length==$scope.bardata1.length){
                                   // console.log('stackbardata ',stackbardata);
                                   // console.log('groupname',groupname);
                                   angular.forEach(comparelist,function (item3,index3,array3) {
                                       let items_name='';
                                       let items_data=[];
                                       let items_change=[];
                                       let count=0;
                                       // console.log('groupname',groupname);
                                       angular.forEach(stackbardata,function (dataitem,dataindex,dataarray) {

                                           for(var i= 0;i<dataitem.length;i++){
                                               if(item3[0]==dataitem[i][0]){
                                                   // console.log('dataitem[i]',dataitem[i]);
                                                   // console.log('item3',item3);
                                                   items_name=item3[0];
                                                   items_data.push(Math.floor(dataitem[i][1]));
                                                   items_change[count]=[];
                                                   items_change[count].push(groupnamelist[dataindex]);
                                                   items_change[count].push(items_name);
                                                   if(dataitem[i][2]!=0 && dataitem[i][1]!=0){
                                                       items_change[count].push(Math.floor(((dataitem[i][1]-dataitem[i][2])/dataitem[i][2])*10000)/100);
                                                   }
                                                   else{
                                                       items_change[count].push(100);
                                                   }

                                                   count++;

                                               }
                                           }
                                       });

                                       let barcolor='red';
                                       angular.forEach($scope.color,function (dataitem,index,array) {
                                           if(dataitem.name==item3[0]){
                                               barcolor=dataitem.color;
                                           }
                                       });
                                       console.log('items_data',items_data);
                                       console.log('items_change',items_change);
                                       var tempitem={
                                           name:items_name,
                                           type:'bar',
                                           large:true,
                                           stack:'total',
                                           // barWidth: 35,
                                           itemStyle: {
                                               normal: {
                                                   // color: 'purple'
                                                   color: barcolor
                                               }
                                           },
                                           data: items_data
                                       };
                                       //存放变化率
                                       var tempchange={
                                           name:items_name,
                                           // groupname:groupname,
                                           data: items_change
                                       };

                                        $scope.changestack.push(tempchange);
                                       // console.log('stackbardata',stackbardata);
                                       // console.log('$scope.changestack',$scope.changestack);
                                       $scope.stackbaroption.series.push(tempitem);
                                   });
                                   for (let j = 0; j < $scope.stackbaroption.series.length; j++) {
                                       if ($scope.stackbaroption.series[j].data && $scope.stackbaroption.series[j].data.length > 0) {
                                           $scope.myObj = {
                                               "width": $scope.stackbaroption.series[j].data.length * 128 + 300
                                           };
                                           break
                                       }
                                   }

                               }
                               $('.mb-fff').remove();

                           },function (data0) {
                               console.log(data0);
                           });
                    },function (data) {
                        console.log(data);
                        $('.mb-fff').remove();
                    });
                });

        };
        $scope.setStack = function (index, data, newseria) {
            console.log('newseria',newseria);
            $scope.stackbaroption.series.push({
                name: index,
                type: 'bar',
                large: true,
                itemStyle: {
                    // normal: {
                    //     color: subdata[0][0].color
                    // }
                    normal: {
                        color: 'red'
                    }
                },
                stack: 'total',
                data: newseria
            });
        };
        $scope.setStackTotal = function (index, kpi, data, newseria) {
            angular.forEach(data, function (subdata, subindex, array) {
                //console.log('data',subdata);
                // subsubdata[1][kpi] = Math.round(subsubdata[1][kpi]);//四舍五入取整
                newseria.push({
                    value: subdata.distri,
                    // value: subsubdata[1][kpi],
                    name: subindex.category
                });
            });
        };
        $scope.kpibtnchg = function (kpi, history) {
           // console.log('kpi',kpi);
           //  console.log('history',history);
           //  console.log('$scope.history',$scope.history);
           //  console.log('$scope.history[kpi]',$scope.history[kpi]);
            if ($scope.history[kpi] == history){
                return false;
            }
            $scope.history[kpi] = history;
            if (history == 1) {
                // $('.tabtitle').hide();
                $scope.getLineData();

            } else {
                // $('.tabtitle').show();
                $scope.getBarData();
            }
        }

        //暂时没用到
        $scope.setBarCapacity = function (data, kpi, newskus, labelRight) {
            //console.log('data',data);
            //$scope.baroption.title.subtext = data.self ? data.self[0].name + '：' + parseFloat(data * 100).toFixed(2) + "%" : '';
            //$scope.baroption.yAxis.data = [];
            $scope.baroption.legend.data = [];
            $scope.baroption.xAxis.max = Math.max.apply(null, newskus) * 100;
            //console.log("$scope.baroption.xAxis.max",$scope.baroption.xAxis.max);
            $scope.baroption.xAxis.min = Math.min(Math.min.apply(null, newskus)) * 100;
            //console.log("$scope.baroption.xAxis.min",newskus);
            $scope.baroption.series.data = [];
            if(subdata > 0){
                labelRight = {
                    normal: {
                        color: '#363636',
                        position: 'left'
                    }
                };
            } else {
                labelRight = {
                    normal: {
                        color: '#363636',
                        position: 'right'
                    }
                };
            }
            //$scope.baroption.yAxis.data.push(category);
            $scope.baroption.series.data.push({
                value: Math.floor(subdata * 10000) / 100,
                itemStyle: {
                    // normal: {
                    //     color: subdata[0].color
                    // }
                },
                formatter: '{value}%',
                label: labelRight
            });
            angular.forEach(data.item, function (subdata, index, array) {

                if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {//未选中容量分级和瓶量分级
                    switch ($scope.deepbrandcheck) {
                        case "catalog":
                            $scope.setBar(subdata.distri/data.sum,kpi,labelRight);
                            break;
                        case "manufacturer":
                            if ($scope.total[subdata[1].menu_id].checked) {
                                $scope.setBar(subdata, kpi, labelRight);
                            }
                            break;
                        case "brand":
                            if ($scope.total[subdata[1].brand_id].checked) {
                                $scope.setBar(subdata, kpi, labelRight);
                            }
                            break;
                    }
                } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {
                    if ($scope.cate_classifys[subdata[1].capacity_id].checked) {
                        $scope.setBar(subdata, kpi, labelRight);
                    }
                } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {
                    if ($scope.cate_classifys[subdata[1].bottle_id].checked) {
                        $scope.setBar(subdata, kpi, labelRight);
                    }
                }
            });
        };
        $scope.setBar = function (subdata,labelRight) {
             //console.log('00000',subdata);
            // console.log('11111',kpi);
            // console.log('22222',labelRight);

            if(subdata > 0){
                labelRight = {
                    normal: {
                        color: '#363636',
                        position: 'left'
                    }
                };
            } else {
                labelRight = {
                    normal: {
                        color: '#363636',
                        position: 'right'
                    }
                };
            }
            //$scope.baroption.yAxis.data.push(category);
            $scope.baroption.series.data.push({
                value: Math.floor(subdata * 10000) / 100,
                itemStyle: {
                    // normal: {
                    //     color: subdata[0].color
                    // }
                },
                formatter: '{value}%',
                label: labelRight
            });
            //console.log("iiii",$scope.baroption.series.data);
            //$scope.baroption.legend.data.push(subdata[0].name);
            //$scope.baroption.legend.data.push(subdata[4]);
        };

        //折线图
        $scope.lineoptionlist=[];
        // $scope.setlineoption =function (groupname,index) {
        //     $scope.lineoptionlist[index]={
        //         title: {
        //             text: '未来一周气温变化',
        //             subtext: '纯属虚构'
        //         },
        //         tooltip: {
        //             trigger: 'axis',
        //         },
        //         grid: {
        //             height: "70%"
        //         },
        //         legend: {
        //             itemWidth: 10,
        //             itemHeight: 10,
        //             // left: 180,
        //             // width: 300,
        //             icon: 'circle',
        //             data: [],
        //             // orient: 'vertical',
        //             bottom: 5
        //         },
        //         toolbox: {
        //             right: 30,
        //             feature: {
        //                 saveAsImage: {},
        //                 myExcel: {
        //                     show: true,
        //                     title: "导出CSV",
        //                     icon: "image://http://echarts.baidu.com/images/favicon.png",
        //                     onclick: function (opts) {
        //                         var series = opts.option.series; //折线图数据
        //                         var axisData = opts.option.xAxis[0].data; //坐标数据
        //                         console.log(series, opts);
        //                         var title = opts.option.title[0].text;
        //                         var str = '时间,期数,';
        //                         //组装表头
        //                         for (var product = 0; product < series.length; product++) {
        //                             str += series[product].name + `,`;
        //                         }
        //                         str += '\n';
        //                         //组装表数据
        //                         for (var lt = 0; lt < axisData.length; lt++) {//axisData坐标数据
        //                             var arr = axisData[lt].split("_");
        //                             var time = "";
        //                             var stage = "";
        //                             //分离时间和期数
        //                             for (var nt = 0; nt < arr.length; nt++) {
        //                                 time = arr[0] + "-" + arr[1];
        //                                 stage = arr[2];
        //                             }
        //                             str += time + `,` + stage + `,`;
        //                             //详细数据
        //                             for (var j = 0; j < series.length; j++) {
        //                                 var temp = series[j].data[lt];
        //                                 if (temp != null && temp != undefined) {
        //                                     str += temp.toFixed(4) + `,`;
        //                                 } else {
        //                                     str += '';
        //                                 }
        //                             }
        //                             str += '\n';
        //                         }
        //                         //encodeURIComponent解决中文乱码
        //                         let uri = 'data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(str);
        //                         //通过创建a标签实现
        //                         var link = document.createElement("a");
        //                         link.href = uri;
        //                         //对下载的文件命名
        //                         link.download = title + ".csv";
        //                         document.body.appendChild(link);
        //                         link.click();
        //                         document.body.removeChild(link);
        //                     }
        //                 }
        //             }
        //         },
        //         xAxis: {
        //             type: 'category',
        //             // boundaryGap: false,
        //             axisLabel: {
        //                 formatter: '{value}'
        //             },
        //             data: ['2018-11','2018-12']
        //         },
        //         yAxis: {
        //             type: 'value',
        //             axisLabel: {
        //                 formatter: '{value}'
        //             },
        //             splitLine: {show: false},
        //         },
        //         //series: []
        //         series:[
        //             {
        //                 name:'邮件营销',
        //                 type:'line',
        //                 stack: '总量',
        //                 data:[120, 132, 101, 134, 90, 230, 210]
        //             },
        //             {
        //                 name:'联盟广告',
        //                 type:'line',
        //                 stack: '总量',
        //                 data:[220, 182, 191, 234, 290, 330, 310]
        //             },
        //             {
        //                 name:'视频广告',
        //                 type:'line',
        //                 stack: '总量',
        //                 data:[150, 232, 201, 154, 190, 330, 410]
        //             },
        //             {
        //                 name:'直接访问',
        //                 type:'line',
        //                 stack: '总量',
        //                 data:[320, 332, 301, 334, 390, 330, 320]
        //             },
        //             {
        //                 name:'搜索引擎',
        //                 type:'line',
        //                 stack: '总量',
        //                 data:[820, 932, 901, 934, 1290, 1330, 1320]
        //             }
        //         ]
        //     };
        //     var labelRight = {
        //         normal: {
        //             color: '#363636',
        //             position: 'left'
        //         }
        //     };
        //     $scope.lineoptionlist[index].title.text=groupname;
        //     //需包含"全部"的数据
        //     //let basesql='(select * from sku_2018 where dt between'+'\''+$scope.month+'\''+ ' and ' +'\''+$scope.month_next+'\')';
        //     let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
        //     let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
        //     let platform = $scope.deepplatformcheck == 'platform' ? 1 : null;
        //     let cityLevelListtype = $scope.cityLevelListcheck == 'cityLevelListtype' ? 1 : 0;
        //     let iscityleveltype = $scope.typeValue == true ? 1 : 0;
        //     let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
        //     let kpichecked = $scope.kpichecked;
        //     var params=groupname.split('-');
        //     let condition01='';
        //     let groupbyfield01='group by channel,platform';
        //     switch(citytype){
        //         case 1:
        //             condition01+=' zpjt='+'\''+params[0]+'\'';
        //             groupbyfield01+=',zpjt,dt ';
        //             break;
        //         case 2:
        //             condition01+=' zpc='+'\''+params[0]+'\'';
        //             groupbyfield01+=',zpc,dt ';
        //             break;
        //         case 3:
        //             condition01+=' city='+'\''+params[0]+'\'';
        //             groupbyfield01+=',city,dt ';
        //             break;
        //     }
        //     let skutype02='';
        //     let comparelist=new Array();
        //     if($scope.visitab=='distribution'){
        //         if(isgrading==0){
        //             switch(skutype){
        //                 case 1:
        //                     skutype02='select type,sum(storeid),dt from ';
        //                     //skutype02='select type,count(distinct storeid_copy),dt from';
        //                     groupbyfield01+=',type ';
        //                     angular.forEach($scope.typelist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     // console.log('comparelist',comparelist);
        //                     break;
        //                 case 2:
        //                     skutype02='select manu,sum(storeid),dt from';
        //                     groupbyfield01+=',manu ';
        //                     angular.forEach($scope.manulist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //                 case 3:
        //                     skutype02='select pinpai,sum(storeid),dt from';
        //                     groupbyfield01+=',pinpai';
        //                     angular.forEach($scope.pinpailist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //             }
        //         }
        //         else if(isgrading==1){
        //             skutype02='select level,sum(storeid),dt from ';
        //             groupbyfield01='group by level';
        //             angular.forEach($scope.capacitylist,function (item,index,array){
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //         else if(isgrading==2){
        //             skutype02='select pack_level,sum(storeid),dt from ';
        //             groupbyfield01='group by pack_level';
        //             angular.forEach($scope.bottlelist,function (item,index,array) {
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //         }
        //
        //     }
        //     else if($scope.visitab=='price_promotion_ratio'){
        //         if(isgrading==0){
        //             switch(skutype){
        //                 case 1:
        //                     skutype02='select type,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from ';
        //                     //skutype02='select type,count(distinct storeid_copy) from';
        //                     groupbyfield01+=',type ';
        //                     angular.forEach($scope.typelist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     console.log('comparelist',comparelist);
        //                     break;
        //                 case 2:
        //                     skutype02='select manu,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from';
        //                     groupbyfield01+=',manu ';
        //                     angular.forEach($scope.manulist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //                 case 3:
        //                     skutype02='select pinpai,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from';
        //                     groupbyfield01+=',pinpai';
        //                     angular.forEach($scope.pinpailist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //             }
        //         }
        //         else if(isgrading==1){
        //             skutype02='select level,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from ';
        //             groupbyfield01='group by level';
        //             angular.forEach($scope.capacitylist,function (item,index,array){
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //         else if(isgrading==2){
        //             skutype02='select pack_level,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from ';
        //             groupbyfield01='group by pack_level';
        //             angular.forEach($scope.bottlelist,function (item,index,array) {
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //
        //     }
        //     else if($scope.visitab=='average_discount_factor'){
        //         if(isgrading==0){
        //             switch(skutype){
        //                 case 1:
        //                     skutype02='select type,sum(dis)*1.0/sum(on_sale),dt from ';
        //                     //skutype02='select type,count(distinct storeid_copy) from';
        //                     groupbyfield01+=',type ';
        //                     angular.forEach($scope.typelist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     //console.log('comparelist',comparelist);
        //                     break;
        //                 case 2:
        //                     skutype02='select manu,sum(dis)*1.0/sum(on_sale),dt from';
        //                     groupbyfield01+=',manu ';
        //                     angular.forEach($scope.manulist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //                 case 3:
        //                     skutype02='select pinpai,sum(dis)*1.0/sum(on_sale),dt from';
        //                     groupbyfield01+=',pinpai';
        //                     angular.forEach($scope.pinpailist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //             }
        //         }
        //         else if(isgrading==1){
        //             skutype02='select level,sum(dis)*1.0/sum(on_sale),dt from ';
        //             groupbyfield01='group by level';
        //             angular.forEach($scope.capacitylist,function (item,index,array){
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //         else if(isgrading==2){
        //             skutype02='select pack_level,sum(dis)*1.0/sum(on_sale),dt from ';
        //             groupbyfield01='group by pack_level';
        //             angular.forEach($scope.bottlelist,function (item,index,array) {
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //         }
        //
        //     }
        //     else if($scope.visitab=='distribution_store'){
        //         if(isgrading==0){
        //             switch(skutype){
        //                 case 1:
        //                     skutype02='select type,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from ';
        //                     //skutype02='select type,count(distinct storeid_copy) from';
        //                     groupbyfield01+=',type ';
        //                     angular.forEach($scope.typelist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     console.log('comparelist',comparelist);
        //                     break;
        //                 case 2:
        //                     skutype02='select manu,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from';
        //                     groupbyfield01+=',manu ';
        //                     angular.forEach($scope.manulist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //                 case 3:
        //                     skutype02='select pinpai,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from';
        //                     groupbyfield01+=',pinpai';
        //                     angular.forEach($scope.pinpailist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //             }
        //         }
        //         else if(isgrading==1){
        //             skutype02='select level,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from ';
        //             groupbyfield01='group by level';
        //             angular.forEach($scope.capacitylist,function (item,index,array){
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //         else if(isgrading==2){
        //             skutype02='select pack_level,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from ';
        //             groupbyfield01='group by pack_level';
        //             angular.forEach($scope.bottlelist,function (item,index,array) {
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //
        //     }
        //     else if($scope.visitab=='average_selling_price'){
        //         if(isgrading==0){
        //             switch(skutype){
        //                 case 1:
        //                     skutype02='select type,sum(dis)*1.0/sum(on_sale),dt from ';
        //                     //skutype02='select type,count(distinct storeid_copy) from';
        //                     groupbyfield01+=',type ';
        //                     angular.forEach($scope.typelist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     console.log('comparelist',comparelist);
        //                     break;
        //                 case 2:
        //                     skutype02='select manu,sum(dis)*1.0/sum(on_sale),dt from';
        //                     groupbyfield01+=',manu ';
        //                     angular.forEach($scope.manulist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //                 case 3:
        //                     skutype02='select pinpai,sum(dis)*1.0/sum(on_sale),dt from';
        //                     groupbyfield01+=',pinpai';
        //                     angular.forEach($scope.pinpailist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //             }
        //         }
        //         else if(isgrading==1){
        //             skutype02='select level,sum(dis)*1.0/sum(on_sale),dt from ';
        //             groupbyfield01='group by level';
        //             angular.forEach($scope.capacitylist,function (item,index,array){
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //         else if(isgrading==2){
        //             skutype02='select pack_level,sum(dis)*1.0/sum(on_sale),dt from ';
        //             groupbyfield01='group by pack_level';
        //             angular.forEach($scope.bottlelist,function (item,index,array) {
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //         }
        //
        //     }
        //     else if($scope.visitab=='average_purchase_price'){
        //         if(isgrading==0){
        //             switch(skutype){
        //                 case 1:
        //                     skutype02='select type,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from ';
        //                     //skutype02='select type,count(distinct storeid_copy) from';
        //                     groupbyfield01+=',type ';
        //                     angular.forEach($scope.typelist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     //console.log('comparelist',comparelist);
        //                     break;
        //                 case 2:
        //                     skutype02='select manu,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from';
        //                     groupbyfield01+=',manu ';
        //                     angular.forEach($scope.manulist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //                 case 3:
        //                     skutype02='select pinpai,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from';
        //                     groupbyfield01+=',pinpai';
        //                     angular.forEach($scope.pinpailist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //             }
        //         }
        //         else if(isgrading==1){
        //             skutype02='select level,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from ';
        //             groupbyfield01='group by level';
        //             angular.forEach($scope.capacitylist,function (item,index,array){
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //         else if(isgrading==2){
        //             skutype02='select pack_level,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from ';
        //             groupbyfield01='group by pack_level';
        //             angular.forEach($scope.bottlelist,function (item,index,array) {
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //
        //     }
        //
        //     else if($scope.visitab=='store_money'){
        //         if(isgrading==0){
        //             switch(skutype){
        //                 case 1:
        //                     skutype02='select type,sum(dis)*1.0/sum(on_sale),dt from ';
        //                     //skutype02='select type,count(distinct storeid_copy) from';
        //                     groupbyfield01+=',type ';
        //                     angular.forEach($scope.typelist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     //console.log('comparelist',comparelist);
        //                     break;
        //                 case 2:
        //                     skutype02='select manu,sum(dis)*1.0/sum(on_sale),dt from';
        //                     groupbyfield01+=',manu ';
        //                     angular.forEach($scope.manulist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //                 case 3:
        //                     skutype02='select pinpai,sum(dis)*1.0/sum(on_sale),dt from';
        //                     groupbyfield01+=',pinpai';
        //                     angular.forEach($scope.pinpailist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);d
        //                         }
        //                     });
        //                     break;
        //             }
        //         }
        //         else if(isgrading==1){
        //             skutype02='select level,sum(dis)*1.0/sum(on_sale),dt from ';
        //             groupbyfield01='group by level';
        //             angular.forEach($scope.capacitylist,function (item,index,array){
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //         else if(isgrading==2){
        //             skutype02='select pack_level,sum(dis)*1.0/sum(on_sale),dt from ';
        //             groupbyfield01='group by pack_level';
        //             angular.forEach($scope.bottlelist,function (item,index,array) {
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //         }
        //
        //     }
        //     else if($scope.visitab=='store_number'){
        //         if(isgrading==0){
        //             switch(skutype){
        //                 case 1:
        //                     skutype02='select type,sum(dis)*1.0/sum(on_sale),dt from ';
        //                     //skutype02='select type,count(distinct storeid_copy) from';
        //                     groupbyfield01+=',type ';
        //                     angular.forEach($scope.typelist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     //console.log('comparelist',comparelist);
        //                     break;
        //                 case 2:
        //                     skutype02='select manu,sum(dis)*1.0/sum(on_sale),dt from';
        //                     groupbyfield01+=',manu ';
        //                     angular.forEach($scope.manulist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //                 case 3:
        //                     skutype02='select pinpai,sum(dis)*1.0/sum(on_sale),dt from';
        //                     groupbyfield01+=',pinpai';
        //                     angular.forEach($scope.pinpailist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //             }
        //         }
        //         else if(isgrading==1){
        //             skutype02='select level,sum(dis)*1.0/sum(on_sale),dt from ';
        //             groupbyfield01='group by level';
        //             angular.forEach($scope.capacitylist,function (item,index,array){
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //         else if(isgrading==2){
        //             skutype02='select pack_level,sum(dis)*1.0/sum(on_sale),dt from ';
        //             groupbyfield01='group by pack_level';
        //             angular.forEach($scope.bottlelist,function (item,index,array) {
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //         }
        //
        //     }
        //     else if($scope.visitab=='average_amount_per_order'){
        //         if(isgrading==0){
        //             switch(skutype){
        //                 case 1:
        //                     skutype02='select type,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from ';
        //                     //skutype02='select type,count(distinct storeid_copy) from';
        //                     groupbyfield01+=',type ';
        //                     angular.forEach($scope.typelist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     //console.log('comparelist',comparelist);
        //                     break;
        //                 case 2:
        //                     skutype02='select manu,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from';
        //                     groupbyfield01+=',manu ';
        //                     angular.forEach($scope.manulist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //                 case 3:
        //                     skutype02='select pinpai,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from';
        //                     groupbyfield01+=',pinpai';
        //                     angular.forEach($scope.pinpailist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //             }
        //         }
        //         else if(isgrading==1){
        //             skutype02='select level,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from ';
        //             groupbyfield01='group by level';
        //             angular.forEach($scope.capacitylist,function (item,index,array){
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //         else if(isgrading==2){
        //             skutype02='select pack_level,cast(sum(on_sale)*1.0/sum(total) as decimal(10,2)),dt from ';
        //             groupbyfield01='group by pack_level';
        //             angular.forEach($scope.bottlelist,function (item,index,array) {
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //
        //     }
        //     else if($scope.visitab=='average_number_per_unit'){
        //         if(isgrading==0){
        //             switch(skutype){
        //                 case 1:
        //                     skutype02='select type,sum(dis)*1.0/sum(on_sale),dt from ';
        //                     //skutype02='select type,count(distinct storeid_copy) from';
        //                     groupbyfield01+=',type ';
        //                     angular.forEach($scope.typelist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     //console.log('comparelist',comparelist);
        //                     break;
        //                 case 2:
        //                     skutype02='select manu,sum(dis)*1.0/sum(on_sale),dt from';
        //                     groupbyfield01+=',manu ';
        //                     angular.forEach($scope.manulist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //                 case 3:
        //                     skutype02='select pinpai,sum(dis)*1.0/sum(on_sale),dt from';
        //                     groupbyfield01+=',pinpai';
        //                     angular.forEach($scope.pinpailist,function (item,index,array) {
        //                         if(item.checked==1){
        //                             comparelist.push(item[0]);
        //                         }
        //                     });
        //                     break;
        //             }
        //         }
        //         else if(isgrading==1){
        //             skutype02='select level,sum(dis)*1.0/sum(on_sale),dt from ';
        //             groupbyfield01='group by level';
        //             angular.forEach($scope.capacitylist,function (item,index,array){
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //
        //         }
        //         else if(isgrading==2){
        //             skutype02='select pack_level,sum(dis)*1.0/sum(on_sale),dt from ';
        //             groupbyfield01='group by pack_level';
        //             angular.forEach($scope.bottlelist,function (item,index,array) {
        //                 if(item.checked==1){
        //                     comparelist.push(item[0]);
        //                 }
        //             });
        //         }
        //
        //     }
        //
        //
        //     let condition02='';
        //     if(iscityleveltype==1){
        //         condition02='and city_level='+'\''+params[1]+'\'';
        //         groupbyfield01+=',city_level'
        //     }
        //     let condition03="and channel="+'\''+params[2]+'\'';
        //     let condition04="and platform="+'\''+params[3]+'\'';
        //     let re1=new RegExp('as dis','g');
        //     let re2=new RegExp('group by','g');
        //     let str='dt between\'2018-12-01\' and \'2019-01-0\'';
        //     let strchange='dt <='+'\''+$scope.month+'\'';
        //     let re3=new RegExp(str,'g');
        //     let basesql=$scope.basesql.replace(re1,'as dis,dt');
        //     basesql=basesql.replace(re2,'group by dt,');
        //     basesql = basesql.substring(0, basesql.lastIndexOf('\''))+'\''+' ) group by dt)';
        //     // console.log(basesql);
        //     basesql=basesql.replace(str,strchange);
        //     let sql01=skutype02+basesql+' where'+condition01+condition02+condition03+condition04+groupbyfield01;
        //     if($scope.visitab=='average_discount_factor'){
        //         let regex0 = new RegExp('as cuxiao' , "g" );
        //         sql01=sql01.replace(regex0,'as cuxiao,sum(dis) as dis');
        //     }
        //     $scope.lineoptionlist[index].series=[];
        //      console.log('linebaroption:',sql01);
        //     // return 0;
        //     getData.getHttp(sql01).then(function (data){
        //         console.log('linebaroption:',data.results);
        //         let yaxis=[];
        //         let seriesaxis=[];
        //         let total0=1;
        //         let total1=1;
        //         var results0="";
        //         var results1="";
        //         var firstmonth=[];
        //         var nextmonth=[];
        //         angular.forEach(data.results,function (item,index,array) {
        //            if(item[2]==$scope.month){
        //                nextmonth.push(item);
        //            }
        //             if(item[2]=='2018-11-01'){
        //                 firstmonth.push(item);
        //             }
        //         });
        //         angular.forEach(firstmonth,function (item,index,array) {
        //             results0+=item[0]+',';
        //         });
        //         angular.forEach(nextmonth,function (item,index,array) {
        //             results1+=item[0]+',';
        //         });
        //         var firstmonthdeal=[];
        //         var nextmonthdeal=[];
        //         angular.forEach(comparelist,function (item0,index0,array0) {
        //             if(results0.indexOf(item0)>-1){
        //                 angular.forEach(firstmonth,function (item,index,array) {
        //                     if(item0==item[0]){
        //                         firstmonthdeal.push(item);
        //                     }
        //                 });
        //             }
        //             else{
        //                 firstmonthdeal.push([item0,0,'2018-11-01']);
        //             }
        //             if(results0.indexOf(item0)>-1){
        //                 angular.forEach(firstmonth,function (item,index,array) {
        //                     if(item0==item[0]){
        //                         nextmonthdeal.push(item);
        //                     }
        //                 });
        //             }
        //             else{
        //                 nextmonthdeal.push([item0,0,'2018-12-01']);
        //             }
        //         });
        //         firstmonthdeal.sort(function(x, y){
        //             return x[1] - y[1];
        //         });
        //         nextmonthdeal.sort(function(x, y){
        //             return x[1] - y[1];
        //         });
        //         console.log('nextmonth',nextmonth);
        //         console.log(firstmonth);
        //         if($scope.visitab=='distribution'){
        //             angular.forEach(firstmonthdeal,function (item,index,array) {
        //                 if(item[0]=='全部'){
        //                     total0=item[1];
        //                 }
        //             });
        //             console.log('total0',total0);
        //
        //             angular.forEach(nextmonthdeal,function (item,index,array) {
        //                 if(item[0]=='全部'){
        //                     // total1=item[1];
        //                     total0=item[1];
        //                 }
        //             });
        //             console.log('total1',total1);
        //             angular.forEach(firstmonthdeal,function (item0,index0,array0) {
        //                 let series={};
        //                 seriesaxis[0]=Math.floor(item0[1]/4853*10000)/100;
        //                 seriesaxis[1]=Math.floor(nextmonthdeal[index0][1]/4853*10000)/100;
        //                 series={
        //                     name:item0[0],
        //                     type:'line',
        //                     stack: '总量',
        //                     data:seriesaxis
        //                 };
        //                 $scope.lineoptionlist[index].series.push(series);
        //                 console.log($scope.lineoptionlist[index]);
        //             });
        //
        //         }
        //         else{
        //             angular.forEach(data.results,function (item,index,array) {
        //                 results+=item[0]+',';
        //             });
        //             //console.log('comparelist',comparelist);
        //             angular.forEach(comparelist,function (item0,index0,array0) {
        //                 if(results.indexOf(item0)>-1){
        //                     angular.forEach(data.results,function (item,index,array) {
        //                        // console.log('item,',item[1]);
        //                         if(item0==item[0]){
        //                             yaxis.push(item[0]);
        //                             if (item[0] >= 0) {
        //                                 labelRight = {
        //                                     normal: {
        //                                         color: '#363636',
        //                                         position: 'left'
        //                                     }
        //                                 };
        //                             }
        //                             else {
        //                                 labelRight = {
        //                                     normal: {
        //                                         color: '#363636',
        //                                         position: 'right'
        //                                     }
        //                                 };
        //                             }
        //                             seriesaxis.push({
        //                                 value:Math.floor(item[1]*10000)/100,
        //                                 // itemStyle: {
        //                                 //     normal: {
        //                                 //         color: subdata[0].color
        //                                 //     }
        //                                 // },
        //                                 formatter: '{value}%',
        //                                 label: labelRight
        //                             });
        //                         }
        //                     });
        //                 }
        //                 else{
        //                     yaxis.push(item0);
        //                     seriesaxis.push({
        //                         value:0,
        //                         formatter: '{value}%',
        //                         label: labelRight
        //                     });
        //                 }
        //             });
        //         }
        //
        //     },function (data) {
        //         console.log(data);
        //     }); }
       $scope.setlineGrading = function (data, kpi) {
            $scope.lineoption.title.subtext = '<?= Yii::t('cvs', '')?>';
            $scope.lineoption.yAxis.axisLabel = {
                formatter: '{value}%'
            };
            $scope.lineoption.legend.data = [];
            $scope.lineoption.series = [];
            angular.forEach(data.skus, function (subdata, index, array) {
                let idx = index;
                if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {//未选中容量分级和瓶量分级
                    switch ($scope.deepbrandcheck) {
                        case "catalog":
                                $scope.setlineGradingOption(subdata, kpi);
                            break;
                        case "manufacturer":
                                $scope.setlineGradingOption(subdata, kpi);
                            break;
                        case "brand":
                                $scope.setlineGradingOption(subdata, kpi);
                            break;
                    }
                } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {
                    if ($scope.cate_classifys[subdata[1].capacity_id].checked) {
                        $scope.setlineGradingOption(subdata, kpi);
                    }
                } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {
                    if ($scope.cate_classifys[subdata[1].bottle_id].checked) {
                        $scope.setlineGradingOption(subdata, kpi);
                    }
                }
            });
        };
        $scope.setlineGradingOption = function (subdata, kpi) {
            $scope.lineoption.tooltip.formatter += '<br>{a' + $scope.idxs + '}:{c' + $scope.idxs + '}%';
            $scope.idxs++;
            if (subdata[1][kpi] == null) subdata[1][kpi] = 0;
            let _data = [];
            if (subdata.length >= 0) {
                angular.forEach(subdata[2], function (kpiData, index, array) {
                    _data.push(Math.round(kpiData[kpi] * 100));
                });
                _data.reverse();
            }
            $scope.lineoption.series.push({
                name: subdata[0].name,
                type: 'line',
                data: _data,
                stack: '总量',
                itemStyle: {
                    normal: {
                        color: subdata[0].color,
                        label: {
                            show: $scope._showData
                        }
                    }
                }
            });
        };
        $scope.setMaxLineGrading = function (data, kpi) {
            $scope.lineoption.title.subtext = "<?= Yii::t('cvs', '单位：k/千');?>";
            $scope.lineoption.legend.data = [];
            $scope.lineoption.series = [];
            angular.forEach(data.skus, function (subdata, index, array) {
                let idx = index;
                if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {//未选中容量分级和瓶量分级
                    switch ($scope.deepbrandcheck) {
                        case "catalog":
                            if ($scope.total[subdata[1].category_id].checked) {
                                $scope.setMaxlineGradingOption(subdata, kpi);
                            }
                            break;
                        case "manufacturer":
                            if ($scope.total[subdata[1].menu_id].checked) {
                                $scope.setMaxlineGradingOption(subdata, kpi);
                            }
                            break;
                        case "brand":
                            if ($scope.total[subdata[1].brand_id].checked) {
                                $scope.setMaxlineGradingOption(subdata, kpi);
                            }
                            break;
                    }
                } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {
                    if ($scope.cate_classifys[subdata[1].capacity_id].checked) {
                        $scope.setMaxlineGradingOption(subdata, kpi);
                    }
                } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {
                    if ($scope.cate_classifys[subdata[1].bottle_id].checked) {
                        $scope.setMaxlineGradingOption(subdata, kpi);
                    }
                }
            });
        };
        $scope.setMaxlineGradingOption = function (subdata, kpi) {
            // $scope.lineoption.legend.data.push(subdata[0].name);
            $scope.lineoption.tooltip.formatter += '<br>{a' + $scope.idxs + '}:{c' + $scope.idxs + '}k';
            $scope.idxs++;
            if (subdata[1][kpi] == null) subdata[1][kpi] = 0;
            let _data = [];
            if (subdata.length >= 0) {
                angular.forEach(subdata[2], function (kpiData, index, array) {
                    _data.push(parseInt(kpiData[kpi] / 10) / 100);
                });
                _data.reverse();
            }
            $scope.lineoption.series.push({
                name: subdata[0].name,
                type: 'line',
                data: _data,
                itemStyle: {
                    normal: {
                        color: subdata[0].color,
                        label: {
                            show: $scope._showData
                        }
                    }
                }

            });
        };

        //折线柱状双拼图
        //折线图&柱状图双拼
        $scope.lineBarOption = {
            title: {
                text: "折线图&柱状图"
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    crossStyle: {
                        color: '#999'
                    }
                }
            },
            toolbox: {
                right: 30,
                feature: {
                    saveAsImage: {show: true},
                    myExcel: {
                        show: true,
                        title: "导出CSV",
                        icon: "image://http://echarts.baidu.com/images/favicon.png",
                        onclick: function (opts) {
                            var series = opts.option.series; //折线图数据
                            var axisData = opts.option.xAxis[0].data; //x坐标数据
                            console.log(series, opts);
                            var title = opts.option.title[0].text;
                            var str = '产品,';
                            //组装表头
                            for (var product = 0; product < series.length; product++) {
                                // str += series[product].name + `,`;
                                str += series[product].name + ',';
                            }
                            str += '\n';
                            //组装表数据
                            for (var lt = 0; lt < axisData.length; lt++) {//axisData坐标数据
                                // str += axisData[lt] + `,`;
                                str += axisData[lt] + ',';
                                //详细数据
                                for (var j = 0; j < series.length; j++) {
                                    var temp = series[j].data[lt];
                                    if (temp != null && temp != undefined) {
                                        // str += `${parseFloat(temp.toFixed(4)) + '\t'}` + `,`;
                                        str += "${parseFloat(temp.toFixed(4)) + '\t'}" + ',';
                                    } else {
                                        str += '';
                                    }
                                }
                                str += '\n';
                            }
                            //encodeURIComponent解决中文乱码
                            let uri = 'data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(str);
                            //通过创建a标签实现
                            var link = document.createElement("a");
                            link.href = uri;
                            //对下载的文件命名
                            link.download = title + ".csv";
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                    }
                }
            },
            legend: {
                data: ['销售金额', '销售金额占比'],
                right: '15%',
            },
            xAxis: [
                {
                    type: 'category',
                    data: ['全部', '茶', '汽水', '果汁'],
                    axisPointer: {
                        type: 'shadow'
                    },
                    // axisLabel:{
                    //     rotate:90
                    // }
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    name: '绝对值',
                    min: 0,
                    max: 250,
                    interval: 50,
                    splitLine: {show: false},
                    axisLabel: {
                        formatter: '{value}'
                    }
                },
                {
                    type: 'value',
                    name: '百分比',
                    min: 0,
                    max: 25,
                    // interval: 5,
                    splitLine: {show: false},
                    axisLabel: {
                        formatter: '{value}'
                    }
                }
            ],
            series: [
                {
                    name: '销售金额',
                    type: 'bar',
                    data: [2.0, 4.9, 7.0, 23.2]
                },
                {
                    name: '销售金额占比',
                    type: 'line',
                    yAxisIndex: 1,
                    data: [2.0, 2.2, 3.3, 4.5]
                }
            ]
        };

        $scope.lineBarOptionlist=[];
        $scope.setlineBaroption2=function(groupname,index){
            $scope.lineBarOptionlist[index]={
                title:{
                    text:groupname+'\n',
                    y:'top',
                    x:'center',
                    padding:20
                },
                tooltip: {
                    trigger: 'axis',
                    formatter:'{c}',
                    axisPointer: {
                        type: 'cross',
                        crossStyle: {
                            color: '#999'
                        },

                    }
                },
                toolbox: {
                    right: 30,
                    feature: {
                        saveAsImage: {show: true},
                        myExcel: {
                            show: true,
                            title: "导出CSV",
                            icon: "image://http://echarts.baidu.com/images/favicon.png",
                            onclick: function (opts) {
                                var series = opts.option.series; //折线图数据
                                var axisData = opts.option.xAxis[0].data; //x坐标数据
                                console.log(series, opts);
                                var title = opts.option.title[0].text;
                                var str = '产品,';
                                //组装表头
                                for (var product = 0; product < series.length; product++) {
                                    // str += series[product].name + `,`;
                                    str += series[product].name + ',';
                                }
                                str += '\n';
                                //组装表数据
                                for (var lt = 0; lt < axisData.length; lt++) {//axisData坐标数据
                                    // str += axisData[lt] + `,`;
                                    str += axisData[lt] + ',';
                                    //详细数据
                                    for (var j = 0; j < series.length; j++) {
                                        var temp = series[j].data[lt];
                                        if (temp != null && temp != undefined) {
                                            // str += `${parseFloat(temp.toFixed(4)) + '\t'}` + `,`;
                                            str += "${parseFloat(temp.toFixed(4)) + '\t'}" + ',';
                                        } else {
                                            str += '';
                                        }
                                    }
                                    str += '\n';
                                }
                                //encodeURIComponent解决中文乱码
                                let uri = 'data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(str);
                                //通过创建a标签实现
                                var link = document.createElement("a");
                                link.href = uri;
                                //对下载的文件命名
                                link.download = title + ".csv";
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }
                        }
                    }
                },
                legend: {
                    data: ['平均折扣深度', '价格促销渗透率'],
                    right: '15%',
                },
                xAxis: [
                    {
                        type: 'category',
                        data: ['全部', '茶', '汽水', '果汁'],
                        axisPointer: {
                            type: 'shadow'
                        },
                    }
                ],
                yAxis: [


                    {
                        type: 'value',
                        name: '绝对值',
                        // interval: 50,
                        splitLine: {show: false},
                        axisLabel: {
                            formatter: '{value}'
                        }
                    },
                    {
                        type: 'value',
                        name: '百分比',
                        // interval: 5,
                        splitLine: {show: false},
                        axisLabel: {
                            formatter: '{value}%'
                        }
                    },
                ],
                series: [
                    {
                        name: '销售金额',
                        type: 'bar',
                        itemStyle: {        //上方显示数值
                            normal: {
                                color:'#E094D2',
                                label: {
                                    show: true, //开启显示
                                    formatter:function(params){
                                        if(params.value==0){
                                            return '';
                                        }else
                                        {
                                            return params.value;
                                        }},
                                    position: 'top', //在上方显示
                                    textStyle: { //数值样式
                                        color: 'black',
                                        fontSize: 16
                                    }
                                }
                            }
                        },
                        data: [2.0, 4.9, 7.0, 23.2]
                    },

                    {
                        name: '销售金额变化率',
                        type: 'line',
                        yAxisIndex: 1,
                        itemStyle :
                            {
                                normal: {
                                    color:'#75AAEE',
                                    label : {
                                        show: true,
                                        formatter:function(params){
                                            if(params.value==0){
                                                return '';
                                            }else
                                            {
                                                return params.value+'%';
                                            }},
                                    }
                                }
                            },
                        data: [2.0, 2.2, 3.3, -4.5]
                    }
                ]
            };
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let iscityleveltype = $scope.typeValue == true ? 1 : 0;
            let isgrading = $scope.capacitycheck ? 1 : $scope.bottlecheck ? 2 : 0;
            let kpichecked = $scope.kpichecked;
            var params=groupname.split('-');
            let condition01='';
            let groupbyfield01='group by channel,platform';
            switch(citytype){
                case 1:
                    condition01+=' zpjt='+'\''+params[0]+'\'';
                    groupbyfield01+=',zpjt ';
                    break;
                case 2:
                    condition01+=' zpc='+'\''+params[0]+'\'';
                    groupbyfield01+=',zpc ';
                    break;
                case 3:
                    condition01+=' city='+'\''+params[0]+'\'';
                    groupbyfield01+=',city ';
                    break;
            }
            let comparelist=new Array();
            let count=0;
            if($scope.visitab=='saleroom'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount) amount','type,amount',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount) amount','type,amount',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount) amount','type,amount',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount) amount','type,amount',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(sales_amount) amount','type,amount',groupname,index,comparelist);
                            break;
                    }

                }

            }
            if($scope.visitab=='sales_numbers'){
                if(isgrading==0){
                    switch(skutype){
                        case 1:
                            angular.forEach($scope.typelist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount) num','type,num',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.manulist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount) num','type,num',groupname,index,comparelist);
                            break;
                        case 3:
                            angular.forEach($scope.pinpailist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount) num','type,num',groupname,index,comparelist);
                            break;

                    }
                }
                else{
                    switch(isgrading){
                        case 1:
                            angular.forEach($scope.capacitylist,function (item,index,array) {
                                if(item.checked==1){
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount) num','type,num',groupname,index,comparelist);
                            break;
                        case 2:
                            angular.forEach($scope.bottlelist,function (item,index,array) {
                                if(item.checked==1){
                                    // comparelist.push(item[0]);
                                    comparelist[count]=[];
                                    comparelist[count].push(item[0]);
                                    count++;
                                }
                            });
                            $scope.getbelowbasesql('sum(salescount) num','type,num',groupname,index,comparelist);
                            break;
                    }

                }

            }

        }
        //未使用

        $scope.setBarLine = function (subdata,compare) {
            let _dataKpi = [];
            let _dataComparKpi = [];
            $scope.lineBarOption.xAxis[0].data.push(subdata[0]);
            if (subdata.length >= 0) {
                _dataKpi.push(parseInt(subdata[1]));
                _dataComparKpi.push(parseInt(compare));
            }
            // console.log(comparKpi,_dataComparKpi);
            $scope.lineBarOption.series = [];
            $scope.lineBarOption.series.push({
               // name: $scope.puzzle[kpi],
                type: 'bar',
                data: _dataKpi,
                itemStyle: {
                    normal: {
                        //color: subdata[0].color,
                        color: '#bb6f60',
                        label: {
                            show: $scope._showData
                        }
                    }
                },
            });
            $scope.lineBarOption.series.push({
                //name: $scope.puzzle[comparKpi],
                type: 'line',
                yAxisIndex: 1,
                data: _dataComparKpi,
                itemStyle: {
                    normal: {
                        color: '#92d050',
                        label: {
                            show: $scope._showData
                        }
                    }
                },
            });
        };
        $scope.chartsSort = function () {
            if ($scope.nocompare) {
                angular.forEach($scope.baroptionlist,function(data,index,array){
                    var sortcomparelist=new Array();
                    for(var i=0;i<$scope.baroptionlist[index].series[0].data.length;i++){
                        sortcomparelist[i]=[];
                        sortcomparelist[i][0]=data.yAxis.data[i];
                        sortcomparelist[i][1]=$scope.baroptionlist[index].series[0].data[i].value;
                    }
                    console.log('beforecomparelist',sortcomparelist);
                    sortcomparelist.sort(function(x, y){
                        return x[1] - y[1];
                    });
                    var labelRight = {
                        normal: {
                            color: '#363636',
                            position: 'left'
                        }
                    };
                    let yaxis=[];
                    let seriesaxis=[];
                    console.log('sortcomparelist',sortcomparelist);
                    angular.forEach(sortcomparelist,function (item,index1,array1) {
                        yaxis.push(item[0]);
                        if (item[1] >= 0) {
                            labelRight = {
                                normal: {
                                    color: '#363636',
                                    position: 'left'
                                }
                            };
                        }
                        else {
                            labelRight = {
                                normal: {
                                    color: '#363636',
                                    position: 'right'
                                }
                            };
                        }
                        seriesaxis.push({
                            value:item[1],
                            formatter: '{value}%',
                            itemStyle: {
                                normal: {
                                    color:$scope.color[index1]
                                }
                            },
                            label: labelRight
                        });


                    });
                    $scope.baroptionlist[index].yAxis.data=yaxis;
                    $scope.baroptionlist[index].series[0].data=seriesaxis;
                });
                $scope.nocompare = false;
                $scope.nosort = '<?= Yii::t('cvs', '取消排序');?>';
            }
            else {
                angular.forEach($scope.baroptionlist,function(data,index,array){
                    var sortcomparelist=new Array();
                    for(var i=0;i<$scope.baroptionlist[index].series[0].data.length;i++){
                        sortcomparelist[i]=[];
                        sortcomparelist[i][0]=data.yAxis.data[i];
                        sortcomparelist[i][1]=$scope.baroptionlist[index].series[0].data[i].value;
                    }
                    console.log('beforecomparelist',sortcomparelist);
                    sortcomparelist.sort(function(x, y){
                        return x[1] - y[1];
                    });
                    var labelRight = {
                        normal: {
                            color: '#363636',
                            position: 'left'
                        }
                    };
                    let yaxis=[];
                    let seriesaxis=[];
                    console.log('sortcomparelist',sortcomparelist);
                    sortcomparelist.sort(
                        function compareFunction(param1, param2) {
                            return param2[0].localeCompare(param1[0],"zh");
                        });
                    angular.forEach(sortcomparelist,function (item,index1,array1) {
                        yaxis.push(item[0]);
                        if (item[1] >= 0) {
                            labelRight = {
                                normal: {
                                    color: '#363636',
                                    position: 'left'
                                }
                            };
                        }
                        else {
                            labelRight = {
                                normal: {
                                    color: '#363636',
                                    position: 'right'
                                }
                            };
                        }
                        seriesaxis.push({
                            value:item[1],
                            formatter: '{value}%',
                            itemStyle: {
                                normal: {
                                    color:$scope.color[index1]
                                }
                            },
                            label: labelRight
                        });

                    });
                    $scope.baroptionlist[index].yAxis.data=yaxis;
                    $scope.baroptionlist[index].series[0].data=seriesaxis;
                });

                $scope.nocompare = true;
                $scope.nosort = '<?= Yii::t('cvs', '排序');?>';
            }

        };
    }]);

    app.filter('reverse', function () { //返回时间
        return function (text) {
            if (text != null) {
                return (text.slice(5, 6) == 'Q' || text.slice(5, 6) == 'q') ? text.slice(0, 4) + '年第' + text.slice(6, 7) + '季度' : text.slice(0, 4) + '年' + text.slice(5, 7) + '月';
            }
        }
    });

</script>
<div id="cvs" ng-app="cockdash" style="padding: 0 8px;">

    <div class="pdftips">
        <div><?= Yii::t('cvs', '正在生成文件，大概需要2-3分钟'); ?>...</div>
        <br>
        <p><?= Yii::t('cvs', '当前进度'); ?> <span id="progress"></span></p>
    </div>
    <div class="export-pdf">
        <div class="left-view export-public">
            <div class="radius" style="width: 300px;">
                <span>1</span>
                <div><?= Yii::t('cvs', '地图'); ?></div>
            </div>
            <div class="radius" style="width:170px;">
                <span>2</span>
                <div><?= Yii::t('cvs', '概括'); ?></div>
            </div>
            <div class="radius" style="width:480px;">
                <span>3</span>
                <div><?= Yii::t('cvs', '趋势分析'); ?></div>
            </div>
        </div>
        <div class="right-select export-public">
            <img class="close" src="<?php echo Yii::app()->baseUrl . '/images/close.png'; ?>" alt="">
            <form class="layui-form" action=""></form>
            <ul class="export-select-list">
                <li>
                    <p><?= Yii::t('cvs', '命名'); ?>:</p>
                    <label><input id="edit-name" type="text" class="form-control"
                                  placeholder="<?= Yii::t('cvs', '月份-地区-品类品牌'); ?>"></label>
                    <div class="btn btn-info" id="export-whole"><?= Yii::t('cvs', '导出当前页'); ?></div>
                </li>
                <li>
                    <p>1,<?= Yii::t('cvs', '地图'); ?></p>
                    <div>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="aap1" checked="checked"><?= Yii::t('cvs', 'KO销售金额占比'); ?>
                        </label>
                    </div>
                </li>
                <li>
                    <p>2,<?= Yii::t('cvs', '概括'); ?></p>
                    <div>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap1" checked="checked"><?= Yii::t('cvs', '饼图'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap2" checked="checked"><?= Yii::t('cvs', '进度条'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap3" checked="checked"><?= Yii::t('cvs', 'KO TOP10'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap4" checked="checked"><?= Yii::t('cvs', '竞品 TOP10'); ?>
                        </label>
                    </div>
                </li>
                <li>
                    <p>3,<?= Yii::t('cvs', '趋势分析'); ?></p>
                    <div class="psl-arr">
                        <span><?= Yii::t('cvs', '铺货门店数'); ?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp1-dp1"><?= Yii::t('cvs', '本期值'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp1-dp2"><?= Yii::t('cvs', '变化率'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp1-dp3"><?= Yii::t('cvs', '趋势'); ?>
                        </label>
                    </div>
                    <div class="psl-arr">
                        <span><?= Yii::t('cvs', '产品铺货率'); ?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp2-dp1"><?= Yii::t('cvs', '本期值'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp2-dp2"><?= Yii::t('cvs', '变化率'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp2-dp3"><?= Yii::t('cvs', '趋势'); ?>
                        </label>
                    </div>
                    <div class="dgl-arr">
                        <span><?= Yii::t('cvs', '平均售价及购买价'); ?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp3-dp1"><?= Yii::t('cvs', '本期值'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp3-dp2"><?= Yii::t('cvs', '变化率'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp3-dp3"><?= Yii::t('cvs', '趋势'); ?>
                        </label>
                    </div>
<!--                    <div class="psl-arr">-->
<!--                        <span>--><?//= Yii::t('cvs', '平均购买价'); ?><!--:</span>-->
<!--                        <label class="checkbox-inline">-->
<!--                            <input type="checkbox" value="cp4-dp1">--><?//= Yii::t('cvs', '本期值'); ?>
<!--                        </label>-->
<!--                        <label class="checkbox-inline">-->
<!--                            <input type="checkbox" value="cp4-dp2">--><?//= Yii::t('cvs', '变化率'); ?>
<!--                        </label>-->
<!--                        <label class="checkbox-inline">-->
<!--                            <input type="checkbox" value="cp4-dp3">--><?//= Yii::t('cvs', '趋势'); ?>
<!--                        </label>-->
<!--                    </div>-->
                    <div class="psl-arr">
                        <span><?= Yii::t('cvs', '价格促销渗透率'); ?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp5-dp1"><?= Yii::t('cvs', '本期值'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp5-dp2"><?= Yii::t('cvs', '变化率'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp5-dp3"><?= Yii::t('cvs', '趋势'); ?>
                        </label>
                    </div>
                    <div class="kjl-arr">
                        <span><?= Yii::t('cvs', '平均价格深度'); ?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp6-dp1"><?= Yii::t('cvs', '本期值'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp6-dp2"><?= Yii::t('cvs', '变化率'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp6-dp3"><?= Yii::t('cvs', '趋势'); ?>
                        </label>
                    </div>
                    <div class="dgl-arr">
                        <span><?= Yii::t('cvs', '销售金额'); ?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp7-dp1"><?= Yii::t('cvs', '本期值'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp7-dp2"><?= Yii::t('cvs', '变化率'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp7-dp3"><?= Yii::t('cvs', '趋势'); ?>
                        </label>
                    </div>
                    <div class="psl-arr">
                        <span><?= Yii::t('cvs', '销售件数'); ?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp8-dp1"><?= Yii::t('cvs', '本期值'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp8-dp2"><?= Yii::t('cvs', '变化率'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp8-dp3"><?= Yii::t('cvs', '趋势'); ?>
                        </label>
                    </div>
                    <div class="dgl-arr">
                        <span><?= Yii::t('cvs', '单店产出(金额)'); ?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp9-dp1"><?= Yii::t('cvs', '本期值'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp9-dp2"><?= Yii::t('cvs', '变化率'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp9-dp3"><?= Yii::t('cvs', '趋势'); ?>
                        </label>
                    </div>
                    <div class="dgl-arr">
                        <span><?= Yii::t('cvs', '单店产出(件数)'); ?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp10-dp1"><?= Yii::t('cvs', '本期值'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp10-dp2"><?= Yii::t('cvs', '变化率'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp10-dp3"><?= Yii::t('cvs', '趋势'); ?>
                        </label>
                    </div>
                    <div class="dgl-arr">
                        <span><?= Yii::t('cvs', '平均每单金额'); ?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp11-dp1"><?= Yii::t('cvs', '本期值'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp11-dp2"><?= Yii::t('cvs', '变化率'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp11-dp3"><?= Yii::t('cvs', '趋势'); ?>
                        </label>
                    </div>
                    <div class="dgl-arr">
                        <span><?= Yii::t('cvs', '平均每单件数'); ?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp12-dp1"><?= Yii::t('cvs', '本期值'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp12-dp2"><?= Yii::t('cvs', '变化率'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp12-dp3"><?= Yii::t('cvs', '趋势'); ?>
                        </label>
                    </div>
                </li>
            </ul>
            <button id="pdf-submit" type="button" class="btn btn-primary"><?= Yii::t('cvs', '提交'); ?></button>
        </div>
    </div>
    <div class="container-fluid" style="padding: 15px 0 10px;" ng-controller="optionchg">
        <nav class="navbar navbar-default navbar-fixed-top">
            <?php $this->renderPartial("headerRetailAttach")?>
        </nav>
        <!--主体部分-->
        <div id="body" class="row">
            <div class="map-col" style="position: relative;margin-left: 0" id="map-derive">
                <div class="map-men map-men1">
                    <?= BSHtml::image(Yii::app()->baseUrl . '/images/temp_08091512529506.gif'); ?>
                </div>
                <div class="map-wrap" id="map-view">
                    <div class="right-bottom-export js-rb-export" title="导出该模块" t="map"></div>
                    <div id="container"></div>
                </div>
            </div>
            <!--主体部分中侧内容-->
            <div class="map-col">
                <div class="row radius10" id="data-view">
                    <div class="right-bottom-export js-rb-export" title="导出该模块" t="data"></div>
                    <div class="map-men map-men2">
                        <?= BSHtml::image(Yii::app()->baseUrl . '/images/temp_08091512529506.gif'); ?>
                    </div>
                    <!-- 饼图-->
                    <div class="row graphica1" style="margin: 16px 0;">
                        <!-- 饼图 -->
                        <div class="col-md-12" style="padding:0" id="gr1" con="饼图">
                            <div class="col-md-12 summarize"
                                 style="border: 1px solid #DDDDDD"><?= Yii::t('cvs', '概括') ?></div>
                            <div class="graphical2">
                                <?php
                                //总total，常温，冷藏，暖柜都需要显示
                                $this->renderpartial("_piechartRetail/_pie1chartRetail", array(
                                    'kpiname' => "pie1",
                                    'comparName' => Yii::t('cvs', "网店数"),
                                    'intro' => Yii::t('cvs', '网店上线率'),
                                    'title' => Yii::t('cvs', '该数据范围内网店数（不同平台之间未打通，即1家线下门店在3个平台上线算3家网店）/该数据范围内线下门店数*3（与网店未打通计算方式保持一致）'),
                                ));
                                $this->renderpartial("_piechartRetail/_pie2chartRetail", array(
                                    'kpiname' => "pie2",
                                    'comparName' => Yii::t('cvs', '铺货网店数'),
                                    'intro' => Yii::t('cvs', 'KO铺货率'),
                                    'title' => Yii::t('cvs', '该数据范围内线上在售任一产品网店数/该数据范围内全部网店数'),
                                ));
                                ?>
                            </div>
                            <div class="graphical2">
                                <?php
                                $this->renderpartial("_piechartRetail/_pie3chartRetail", array(
                                    'kpiname' => "pie3",
                                    'comparName' => Yii::t('cvs', "销售金额（元）"),
                                    'intro' => Yii::t('cvs', 'KO销售金额份额'),
                                    'title' => Yii::t('cvs', '该数据范围内销售金额/该数据范围内全部软饮销售金额'),
                                ));
                                $this->renderpartial("_piechartRetail/_pie4chartRetail", array(
                                    'kpiname' => "pie4",
                                    'comparName' => Yii::t('cvs', "销售件数（件）"),
                                    'intro' => Yii::t('cvs', 'KO销售件数份额'),
                                    'title' => Yii::t('cvs', '该数据范围内销售件数/该数据范围内全部软饮销售件数'),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- 进度条 -->
                    <div id="rate-box-left">
                        <div class="row" style="overflow: auto;">
                            <?php
                            $this->renderpartial("_kpiitemRetail/_kpi1itemRetail", array(
                                'precent' => "1",
                                'kpiname' => Yii::t('cvs', '平均每单饮料件数（搭售率）'),
                                'title' => Yii::t('cvs', '该数据范围内KO产品销售件数/该数据范围内线上在售任一KO产品的网店数'),
//                                'kpi' => array(
//                                    'value' => "koinfosPlarn.koPlan.store_money",
//                                    'lastvalue' => "koinfosPlarn.lastkoPlan.store_money",
//                                    'changerate' => "koinfosPlarn.koPlan.last_store_money",
//                                    'precent' => "1"
//                                )
                            ));
                            $this->renderpartial("_kpiitemRetail/_kpi2itemRetail", array(
                                'precent' => "0",
                                'kpiname' => Yii::t('cvs', '平均单店SKU数'),
                                'title' => Yii::t('cvs', '该数据范围内KO产品销售金额/该数据范围内线上在售任一KO产品的网店数'),
//                                'kpi' => array(
//                                    'value' => "koinfosPlarn.koPlan.store_number",
//                                    'lastvalue' => "koinfosPlarn.lastkoPlan.store_number",
//                                    'changerate' => "koinfosPlarn.koPlan.last_store_number",
//                                    'precent' => "0"
//                                )
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!--主体部分右侧内容-->
            <div class="map-col">
                <div class="row radius10" id="data-view" style="position:relative;overflow:hidden;">
                    <div class="right-bottom-export js-rb-export" title="导出该模块" t="data"></div>
                    <div class="map-men map-men2">
                        <?= BSHtml::image(Yii::app()->baseUrl . '/images/temp_08091512529506.gif'); ?>
                    </div>
                    <!-- 排行 -->
                    <div class="row graphica1" style="margin: 16px 0;">
                        <div class="col-md-12" style="padding:0" id="gr2" con="KO TOP10">
                            <div class="row">
                                <div title="该数据范围内销售金额排名前十的KO产品（排除其他包装及销量为0的产品）" class="col-md-4 k_summarize" id="ko_ummarize" ng-click="koCompeting(1)">
                                    <?= Yii::t('cvs', 'KO') ?> TOP10 SKU
                                </div>
                                <div title="该数据范围内销售金额排名前十的竞品产品（排除其他包装及销量为0的产品）" class="col-md-4 k_summarize" id="no_ummarize" ng-click="koCompeting(2)">
                                    <?= Yii::t('cvs', '竞品') ?> TOP10 SKU
                                </div>
                                <div title="该数据范围内销售金额排名前十的竞品产品（排除其他包装及销量为0的产品）" class="col-md-4 k_summarize" id="nitd_ummarize" ng-click="koCompeting(3)">
                                    <?= Yii::t('cvs', 'NARTD') ?> TOP10 SKU
                                </div>
                            </div>
                            <div class="col-md-12 main-right-right" style="position: relative;">
                              <div class="row" style="display: flex;margin-top:0.8em;font-weight:bold;" >
                                  <div class="col-md-2">排名</div>
                                  <div class="col-md-4" >商品名称</div>
                                  <div class="col-md-2" style="padding: 0">包装瓶数</div>
                                  <div class="col-md-2" style="padding: 0">销售金额</div>
                                  <div class="col-md-2" >VS PP</div>
                              </div>
                                <div ng-if="classify==1" ng-repeat="itemRank in kotopten">
                                    <div class="top_class">
                                        <table>
                                            <tr class="row">
                                                <td class="col-md-2">
                                                    <span class="common first-top" ng-if="$index==0" ng-cloak> 1</span>
                                                    <span class="common second-top" ng-if="$index==1"ng-cloak> 2</span>
                                                    <span class="common thirdly-top"  ng-if="$index==2" ng-cloak> 3</span>
                                                    <span class="common" ng-if="$index!=2&&$index!=1&&$index!=0"ng-cloak> {{$index+1}}</span>
                                                </td>
                                                <td class="col-md-4" ng-bind="itemRank[0]"></td>
                                                <td class="col-md-2" ng-bind="itemRank[1]"></td>
                                                <td class="col-md-2" ng-bind="itemRank[2] | number:0"></td>
                                                <td class="col-md-2" >
<!--                                                    ng-bind="itemRank[3]+'%'"-->
                                                    <span ng-if="itemRank[3]>0" ng-cloak>
                                                            <span class="green" ng-bind="itemRank[3]"></span>
                                                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                                                    </span>
                                                    <span ng-if="itemRank[3]<0" ng-cloak>
                                                            <span class="change" ng-bind="itemRank[3]*(-1)"></span>
                                                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                                                    </span>
                                                    <span ng-if="month=='2018-11-01'" ng-cloak>
                                                            <?= Yii::t('cvs', 'N/A'); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div ng-if="classify==2" ng-repeat="itemRank in competopten">
                                    <div class="top_class">
                                        <table>
                                            <tr>
                                                <td class="col-md-2">
                                                    <span class="common first-top" ng-if="$index==0" ng-cloak>1</span>
                                                    <span class="common second-top" ng-if="$index==1"ng-cloak>2</span>
                                                    <span class="common thirdly-top"  ng-if="$index==2" ng-cloak>3</span>
                                                    <span class="common"  ng-if="$index!=2&&$index!=1&&$index!=0"ng-cloak>TOP {{$index+1}}</span>
                                                </td>
                                                <td class="col-md-4" ng-bind="itemRank[0]"></td>
                                                <td class="col-md-2" ng-bind="itemRank[1]"></td>
                                                <td class="col-md-2" ng-bind="itemRank[2] |number:0"></td>
                                                <td class="col-md-2" >
                                                    <!--                                                    ng-bind="itemRank[3]+'%'"-->
                                                    <span ng-if="itemRank[3]>0" ng-cloak>
                                                            <span class="green" ng-bind="itemRank[3]"></span>
                                                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                                                    </span>
                                                    <span ng-if="itemRank[3]<0" ng-cloak>
                                                            <span class="change" ng-bind="itemRank[3]*(-1)"></span>
                                                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                                                    </span>
                                                    <span ng-if="month=='2018-11-01'" ng-cloak>
                                                            <?= Yii::t('cvs', 'N/A'); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div ng-if="classify==3" ng-repeat="itemRank in nartdtopten">
                                    <div class="top_class">
                                        <table>
                                            <tr class="row">
                                                <td class="col-md-2">
                                                    <span class="common first-top" ng-if="$index==0" ng-cloak> 1</span>
                                                    <span class="common second-top" ng-if="$index==1"ng-cloak> 2</span>
                                                    <span class="common thirdly-top"  ng-if="$index==2" ng-cloak> 3</span>
                                                    <span class="common" ng-if="$index!=2&&$index!=1&&$index!=0"ng-cloak>TOP {{$index+1}}</span>
                                                </td>
                                                <td class="col-md-4" ng-bind="itemRank[0]"></td>
                                                <td class="col-md-2" ng-bind="itemRank[1]"></td>
                                                <td class="col-md-2" ng-bind="itemRank[2]|number:0"></td>
                                                <td class="col-md-2" >
                                                    <!--                                                    ng-bind="itemRank[3]+'%'"-->
                                                    <span ng-if="itemRank[3]>0" ng-cloak>
                                                            <span class="green" ng-bind="itemRank[3]"></span>
                                                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                                                    </span>
                                                    <span ng-if="itemRank[3]<0" ng-cloak>
                                                            <span class="change" ng-bind="itemRank[3]*(-1)"></span>
                                                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                                                    </span>
                                                    <span ng-if="month=='2018-11-01'" ng-cloak>
                                                            <?= Yii::t('cvs', 'N/A'); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
<!--        --><?php
//            $this->renderpartial("detailsRetailAttach", array());
//        ?>
    </div>
</div>
<div style="display: none" class="downExcel"></div>
<div id="returnTop" style="display: none">
    <div id="test" style="position:fixed;right:30px;bottom:30px;cursor: pointer;z-index:1000;">
        <img src="<?= Yii::app()->baseUrl . '/images/top.png' ?>">
    </div>
</div>
</div>
<script>
    window.onload = function (e) {
        //区域
        $('.chosen-select').chosen();
        $('#header-month').datepicker({
            format: "yyyy-mm",
            startView: 'months',
            maxViewMode: 'years',
            minViewMode: 'months',
            weekStart: 1,
            language: "<?php if (Yii::app()->language == 'zh_cn') {
                echo 'zh-CN';
            } else {
                echo 'en';
            }?>",
            autoclose: true,
            todayHighlight: true,
        });
        $(document).scroll(function () {
            //    console.log($(document).scrollTop())
            if ($(document).scrollTop() > 50) {
                $('nav .container-fluid').slideUp(300);
            } else {
                $('nav .container-fluid').slideDown(300);
            }
        })
        // $('.change-map').eq(0).trigger('click')

        $(document).on('click', '#rate-more,#order-more', function () {
            $('body,html').stop().animate({
                scrollTop: $('#deepdive').offset().top - 140
            }, 300);
        });

        $(document).on('click', '#order-more', function () {
            let oType;
            for (let i = 0; i < $('.radius10 .nav-pills .change-map').length; i++) {
                //console.log('oooo',$('.radius10 .nav-pills .change-map'));
                if ($('.radius10 .nav-pills .change-map').eq(i).hasClass('active')) {
                    oType = i;
                }
            }
            switch (oType) {
                case 0:
                    $('#deepdive li').eq(5).trigger('click');
                    break;
                case 1:
                    $('#deepdive li').eq(7).trigger('click');
                    break;
                case 3:
                    $('#deepdive li').eq(6).trigger('click');
                    break;
            }

        });
        $('.weidu-list li>label').click(function () {
            let i = $('.weidu-list li>label').index(this);
            let oLeft = $('.weidu-list li>label').eq(i).position().left;
            if (i >= 7) {
                $('.weidu-list li .weidu-item-box').css('left', oLeft - 200);
            } else {
                $('.weidu-list li .weidu-item-box').css('left', oLeft - 30);
            }
            $(this).parent().find('.weidu-item-box').show();
            $(this).parent().siblings().find('.weidu-item-box').hide()
        });
        $(document).on('click', function (e) {
            let target = $(e.target);
            if (!target.is('.weidu-list li') && target.parent() && target.parents('.weidu-list li').length <= 0) {
                $('.weidu-item-box').hide();
            }
        })


        $('.chosen-select').chosen();
        $('.filter-city').change(function () {
            $('#cityid').attr('value', $(this).attr('id'));
        });
        //期报处理
        $(document).on('change', '#stage', function () {
            getMonthReport();
        });
        $(document).on('click', '#monthly_Reportz,.month', function () {
            getMonthReport();
        });

        function getMonthReport() {
            if (!$(".SSearch_month_table").val() || $(".SSearch_month_table").val().length <= 0) {
                $(".SSearch_month_table").val($("#Search_month").val());
            }
            var cont = {
                'sj': $('.SSearch_month_table').val(),
                'YII_CSRF_TOKEN': "<?=yii::app()->request->csrfToken;?>"
            };
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('site/reportRetail') ?>',
                dataType: 'json',
                data: cont,
                success: function (data) {
                    console.log("data", data);
                    $('#showtable').html('');
                    var showtable = ' ';
                    if (data.status == 1) {
                        var submiturl = "<?php echo Yii::app()->createUrl('site/uploadExcelRetail', array('id' => 'sid'))?>";
                        var no = "<?= Yii::t('cvs', '第');?>";
                        var run = "<?= Yii::t('cvs', '期');?>";
                        for (var i = 0; i < data.info.length; i++) {
                            if (data.info[i].stage == -1) {
                                showtable += '<tr><td><?= Yii::t('cvs', 'YTD')?></td><td><span><a  target="_blank" href="' + submiturl.replace('sid', data.info[i].id) + '"><?= Yii::t('cvs', '下载')?></a></span></td></tr>'
                            } else if (data.info[i].stage == 0) {
                                showtable += '<tr><td><?= Yii::t('cvs', '月报/季报')?></td><td><span><a  target="_blank" href="' + submiturl.replace('sid', data.info[i].id) + '"><?= Yii::t('cvs', '下载')?></a></span></td></tr>'
                            } else {
                                showtable += '<tr><td>' + no + data.info[i].stage + run + '</td><td><span><a  target="_blank" href="' + submiturl.replace('sid', data.info[i].id) + '"><?= Yii::t('cvs', '下载')?></a></span></td></tr>'
                            }
                        }
                        if (data.info.length = 0) {
                            showtable = "<center><p style=\"color:red\"><?= Yii::t('cvs', '该月还没有上传数据')?></p></center>";
                        }
                    } else {
                        showtable = "<center><p style=\"color:red\"><?= Yii::t('cvs', '该月还没有上传数据')?></p></center>";
                    }
                    $("#showtable").html(showtable);
                },
                error: function (retMsg) {
                    $('#showtable').html();
                    $('#showtable').html("<center><p style=\"color:red\"><?= Yii::t('cvs', '你没有权限!')?></p></center>");
                }
            });
        }

        $('.report a').click(function () {
            var i = $('.report a').index(this);
            //console.log(9);
            $(this).addClass('active');
            $('.report a:not(:eq(' + i + '))').removeClass('active');
        });

        setMap(false, '','');//调用地图
    }
</script>
<script src="https://webapi.amap.com/maps?v=1.4.1&key=6e4d02aa84a4cc6669b16788c01ac14a&plugin=AMap.Geocoder"></script>
<script src="https://webapi.amap.com/ui/1.0/main.js?v=1.0.11"></script>
<script>
    function setMap(type, data,specialdata) {

        //var koinfos = new Array();
        // if (type) {
        //     koinfos = ['1', "0.03972260555226598", "1", "26", "辽宁"];
        //     specificArea = ["1", "全部", "107.764827,36.104582", "-0.03662514475791262", "1", "1", "全部"];
        //     console.log('地图数据1', koinfos);
        //     console.log('特殊区域地图数据1', specificArea);
        // } else {
        //     koinfos =data;
        //     specificArea = specialdata;
        //     console.log('地图数据', koinfos);
        //     console.log('特殊区域地图数据', specificArea);
        // }
        koinfos =data;
        specificArea = specialdata;
        console.log('地图数据', koinfos);
        console.log('特殊区域地图数据', specificArea);
        var timerm1 = null;
        var timerm2 = null;
        var zoom = 5;
        var oTypes = 'distribution';
        function init() {
            $('.map-men1').show();
            for (let i = 0; i < $('.radius10 .nav-pills .change-map').length; i++) {
                if ($('.radius10 .nav-pills .change-map').eq(i).hasClass('active')) {
                    oTypes = $('.radius10 .nav-pills .change-map').eq(i).attr('otype');
                }
            }
            var map = new AMap.Map('container', {
                zooms: [4, 6],
                zoom: 4,
                resizeEnable: true
            });
            map.plugin(["AMap.ToolBar"], function () {
                map.addControl(new AMap.ToolBar());
            });
//划分区域
            var zhongke = [110000, 620000, 640000, 500000, 650000, 630000, 540000, 130000, 430000, 520000, 210000, 230000, 220000, 150000, 370000, 140000, 610000, 510000, 120000],
                taigu = [340000, 350000, 450000, 460000, 410000, 420000, 320000, 360000, 330000, 530000, 310000, 440100],
                ZH = [];
            var cityList = zhongke.concat(taigu).concat(ZH);
            var colors = ["#e82d34", "#f49e00", "#ffcc00"];

            function loadmap() {
                AMapUI.load(['ui/geo/DistrictExplorer', 'lib/$'], function (DistrictExplorer, $) {

                    //创建一个实例
                    var districtExplorer = new DistrictExplorer({
                        eventSupport: true, //打开事件支持
                        map: map
                    });
                    //当前聚焦的区域
                    var currentAreaNode = null;

//绘制区域面板的节点
                    function renderAreaPanelNode(ele, props, color) {

                        var $box = $('<li/>').addClass('lv_' + props.level);
                        var $h2 = $('<h2/>').addClass('lv_' + props.level).attr({
                            'data-adcode': props.adcode,
                            'data-level': props.level,
                            'data-children-num': props.childrenNum || void(0)
                        }).html(props.name).appendTo($box);
                        if (color) {
                            $h2.css('borderColor', color);
                        }

                        //如果存在子节点
                        if (props.childrenNum > 0) {

                            //显示隐藏
                            $('<div class="showHideBtn"></div>').appendTo($box);
                            //子区域列表
                            $('<ul/>').addClass('sublist lv_' + props.level).appendTo($box);
                            $('<div class="clear"></div>').appendTo($box);
                            if (props.level !== 'country') {
                                $box.addClass('hide-sub');
                            }
                        }

                        $box.appendTo(ele);
                    }

                    //填充某个节点的子区域列表
                    function renderAreaPanel(areaNode) {

                        var props = areaNode.getProps();
                        var $subBox = $('#area-tree').find('h2[data-adcode="' + props.adcode + '"]').siblings('ul.sublist');
                        if (!$subBox.length) {
                            //父节点不存在，先创建
                            renderAreaPanelNode($('#area-tree'), props);
                            $subBox = $('#area-tree').find('ul.sublist');
                        }

                        if ($subBox.attr('data-loaded') === 'rendered') {
                            return;
                        }

                        $subBox.attr('data-loaded', 'rendered');
                        var subFeatures = areaNode.getSubFeatures();
                        //填充子区域
                        for (var i = 0, len = subFeatures.length; i < len; i++) {
                            renderAreaPanelNode($subBox, areaNode.getPropsOfFeature(subFeatures[i]), colors[i % colors.length]);
                        }
                    }

                    //绘制某个区域的边界
                    function renderAreaPolygons(areaNode) {

                        //更新地图视野
                        map.setBounds(areaNode.getBounds(), null, null, true);
                        //清除已有的绘制内容
                        districtExplorer.clearFeaturePolygons();
                        //绘制子区域
                        districtExplorer.renderSubFeatures(areaNode, function (feature, i) {

                            var fillColor;
                            var num = feature.properties.adcode;
                            if (contains(taigu, num)) {
                                fillColor = colors[0];
                            }
                            if (contains(zhongke, num)) {
                                fillColor = colors[1];
                            }
                            if (contains(ZH, num)) {
                                fillColor = colors[2];
                            }
                            // var strokeColor = colors[colors.length - 1 - i % colors.length];

                            if (!contains(cityList, num)) {
                                fillColor = 'transparent';
                                strokeColor = '#ffffff'
                            }
                            return {
                                cursor: 'default',
                                bubble: true,
                                strokeColor: '#ffffff', //线颜色
                                strokeOpacity: 1, //线透明度
                                strokeWeight: 2, //线宽
                                fillColor: fillColor, //填充色
                                fillOpacity: 0.9, //填充透明度
                            };
                        });
                        //绘制父区域
                        districtExplorer.renderParentFeature(areaNode, {
                            cursor: 'default',
                            bubble: true,
                            strokeColor: '#666', //线颜色
                            strokeOpacity: 1, //线透明度
                            strokeWeight: 1, //线宽
                            fillColor: null, //填充色
                            fillOpacity: 0.9, //填充透明度
                        });
                    }

                    //切换区域后刷新显示内容
                    function refreshAreaNode(areaNode) {

                        districtExplorer.setHoverFeature(null);
                        renderAreaPolygons(areaNode);
                        //更新选中节点的class
                        var $nodeEles = $('#area-tree').find('h2');
                        $nodeEles.removeClass('selected');
                        var $selectedNode = $nodeEles.filter('h2[data-adcode=' + areaNode.getAdcode() + ']').addClass('selected');
                        //展开下层节点
                        $selectedNode.closest('li').removeClass('hide-sub');
                        //折叠下层的子节点
                        $selectedNode.siblings('ul.sublist').children().addClass('hide-sub');
                    }

                    //切换区域
                    function switch2AreaNode(adcode, callback) {

                        if (currentAreaNode && ('' + currentAreaNode.getAdcode() === '' + adcode)) {
                            return;
                        }

                        loadAreaNode(adcode, function (error, areaNode) {

                            if (error) {

                                if (callback) {
                                    callback(error);
                                }

                                return;
                            }
                            currentAreaNode = window.currentAreaNode = areaNode;
                            //设置当前使用的定位用节点
                            districtExplorer.setAreaNodesForLocating([currentAreaNode]);
                            refreshAreaNode(areaNode);
                            if (callback) {
                                callback(null, areaNode);

                            }
                        });
                    }

                    //加载区域
                    function loadAreaNode(adcode, callback) {

                        districtExplorer.loadAreaNode(adcode, function (error, areaNode) {

                            if (error) {

                                if (callback) {
                                    callback(error);
                                }

                                console.error(error);
                                return;
                            }

                            renderAreaPanel(areaNode);
                            if (callback) {
                                callback(null, areaNode);
                            }
                            map.setZoomAndCenter(4, [105.576221, 36.269047]);
                        });
                    }

                    switch2AreaNode(100000);

                })
            }
            loadmap();
            $('.amap-marker').hide();
            for (let i = 0; i < specificArea.length; i++) {
                console.log('specificArea',specificArea);
                console.log('specificArea.length',specificArea.length);
                marker = new AMap.Marker({
                    //position: specificArea[i][2].split(',')
                });
                var leval;
                switch (specificArea[i][0]) {
                    case '0':
                        leval = 'leval1';
                        break;
                    case '1':
                        leval = 'leval2';
                        break;
                    case '2':
                        leval = 'leval3';
                        break;
                    case '3':
                        leval = 'leval4';
                        break;
                    default :
                        leval = 'default'

                }
                let urls = '';   //显示向上或向下箭头
                let o_idx = 3;   //显示哪一个数据
                switch (oTypes) {
                    case 'distribution':
                        o_idx = 3;
                        break;
                    case 'sovi':
                        o_idx = 4;
                        break;
                    case 'extra_displays':
                        o_idx = 6;
                        break;
                    case 'thematic_activity':
                        o_idx = 7;
                        break;
                    case 'equipment_sales':
                        o_idx = 8;
                        break;
                }
                if (specificArea[i][o_idx]) {
                    urls = parseFloat(specificArea[i][o_idx]) > 0 ? "<?php echo Yii::app()->baseUrl . '/images/up.png' ?>" : "<?php echo Yii::app()->baseUrl . '/images/down.png' ?>";
                }
                marker.setLabel({//label默认蓝框白底左上角显示，样式className为：amap-marker-label
                    offset: new AMap.Pixel(6, 20), //修改label相对于maker的位置
                    content: "<div v='" + specificArea[i][5] + "' area=" + specificArea[i][1] + "' class='" + leval + " clearfix'><span>" + specificArea[i][6] + "</span>" + "<img src='" + urls + "' /></div>"
                });
                // console.log('map',map);
                marker.setMap(map);
            }
            for (var i = 0; i < koinfos.length; i++) {
                console.log('koinfos.length',koinfos.length);
                if (!containss(koinfos[i][1], specificArea)) {
                    addBeiJing(koinfos[i][0], koinfos[i][1], koinfos[i][2],
                        koinfos[i][2], koinfos[i][4], koinfos[i][2], koinfos[i][2], koinfos[i][2], koinfos[i][5]);
                }
            }
            function addBeiJing(leval, area, puhuo, sovi, v, yichang, huodong, salesShare, showarea) {
                //加载行政区划插件
                AMap.service('AMap.DistrictSearch', function () {
                    var opts = {
                        subdistrict: 1, //返回下一级行政区
                        extensions: 'base',
                        level: 'province'  //查询行政级别为 市
                    };
                    //实例化DistrictSearch
                    district = new AMap.DistrictSearch(opts);
                    //  district.setLevel('country');
                    //行政区查询
                    district.search(area, function (status, result) {
                        var subDistricts;
                        for (let i = 0; i < result.districtList.length; i++) {
                            if (result.districtList[i].level !== 'district') {
                                subDistricts = result.districtList[i];
                                break;
                            }
                        }
//                    console.log(status,subDistricts)

                        if (status == 'complete') {
                            var levalClass;
                            switch (leval) {
                                case '0':
                                    levalClass = 'leval1';

                                    break;
                                case '1':
                                    levalClass = 'leval2';
                                    break;
                                case '2':
                                    levalClass = 'leval3';
                                    break;
                                case '3':
                                    levalClass = 'leval4';
                                    break;
                                default :
                                    levalClass = 'default'
                            }
                            var name = subDistricts.name;
                            marker = new AMap.Marker({
                                position: subDistricts.center
                            });
                            let urls = '';
                            var s_con = 3;
                            switch (oTypes) {
                                case 'distribution':
                                    s_con = puhuo;
                                    break;
                                case 'sovi':
                                    s_con = sovi;
                                    break;
                                case 'extra_displays':
                                    s_con = yichang;
                                    break;
                                case 'thematic_activity':
                                    s_con = huodong;
                                    break;
                                case 'equipment_sales':
                                    s_con = shebei;
                                    break;
                                case 'last_sales_share':
                                    s_con = salesShare;
                                    break;
                            }
                            if (s_con) {
                                urls = parseFloat(s_con) > 0 ? "<?php echo Yii::app()->baseUrl . '/images/up.png' ?>" : "<?php echo Yii::app()->baseUrl . '/images/down.png' ?>";
                            }
                            marker.setLabel({//label默认蓝框白底左上角显示，样式className为：amap-marker-label
                                offset: new AMap.Pixel(6, 20), //修改label相对于maker的位置
                                content: "<div v='" + v + "' area='" + area + "' class='" + levalClass + "'><span> " + showarea + "</span>" + "<img src='" + urls + "' /></div>"
                            });
                            marker.setMap(map);//vikki注释的
                        }

                    });
                });
            }

            clearTimeout(timerm1);
            timerm1 = setTimeout(function () {
                $('.leval4').parents('.amap-marker').hide();
                AMap.event.addListener(map, 'zoomend', function () {
//                console.log(213414)
                    zoom = map.getZoom();
                    if (zoom < 6) {
                        $('.amap-marker').hide();
                        $('.leval3').parents('.amap-marker').stop().fadeIn(400);
                    } else if (zoom >= 6) {
                        $('.amap-marker').hide();
                        $('.leval4').parents('.amap-marker').stop().fadeIn(400);
                        $('.leval5').parents('.amap-marker').stop().fadeIn(400);
                    }
                });


            }, 4000);

            function geocoder(area) {
                var geocoder = new AMap.Geocoder({
                    city: "", //城市，默认：“全国”
                    radius: 1000 //范围，默认：500
                });
                //地理编码,返回地理编码结果
                geocoder.getLocation(area, function (status, result) {
                    if (status === 'complete' && result.info === 'OK') {
                        geocoder_CallBack(result);
                    }
                });
            }

            //地理编码返回结果展示
            function geocoder_CallBack(data) {
                //地理编码结果数组
                var geocode = data.geocodes[0].location;
                map.setZoomAndCenter(7, geocode);
//            console.log(geocode)
            }

            $(document).on('click', '.legend .ng-binding', function () {
                let s = $(this).attr('sid');
                console.log(s);
                if (s == '3') {  //zhongke
                    $("#Search_region").val(3);
                    $("#Search_region").trigger("change");
                   // map.setZoomAndCenter(5, specificArea[2][2].split(','));
                } else if (s == '2') {
                    $("#Search_region").val(2);
                    $("#Search_region").trigger("change");
                    //map.setZoomAndCenter(5, specificArea[1][2].split(','));
                }

            })
            $(document).on('click', '.amap-marker-label', function (e) {
                var clickValue = $(this).find('div span').html();
                var clickid = $(this).find('div').attr('v');
                if (containss(clickValue, specificArea)) {
                    for (var i = 0; i < specificArea.length; i++) {
                        if (clickValue == specificArea[i][1]) {
                            //map.setZoomAndCenter(7, specificArea[i][2].split(','));
                            break
                        }
                    }
                } else {
                    geocoder(clickValue)
                }

//            map.setZoom(7);
                if ($(this).hasClass('leval1') || $(this).find('div').hasClass('leval2')) {
                    $("#Search_region").val(clickid);
                    $("#Search_region").trigger("change");
                    $("#Search_factory").val('0');
                    $("#Search_factory").trigger("change");
                    $("#Search_city").val('0');
                    $("#Search_city").trigger("change");
                } else if ($(this).find('div').hasClass('leval3')) {
                    $("#Search_region").val('1');
                    $("#Search_region").trigger("change");
                    $("#Search_factory").val(clickid);
                    $("#Search_factory").trigger("change");
                    $("#Search_city").val('0');
                    $("#Search_city").trigger("change");
                } else if ($(this).find('div').hasClass('leval4')) {
                    $('#map-box').remove();
                    console.log('4')
                    var iArea = clickValue;
                    let _left = ($(this).offset().left + $(this).width() / 2) - $('#map-view').width() * 0.3;
                    let _top = $(this).offset().top - $('#map-view').height() * 0.8;
                    if (_top < 0) {
                        _top = 0;
                    } else if (_top > $('#map-view').height() * 0.2) {
                        _top = $('#map-view').height() * 0.2;
                    }
                    if (_left < 0) {
                        _left = 0
                    } else if (_left > $('#map-view').width() * 0.4) {
                        _left = $('#map-view').width() * 0.4
                    }

                    let icode = $(this).find('div').attr('area');
                    let geocoder = new AMap.Geocoder({
                        city: "", //城市，默认：“全国”
                        radius: 1000 //范围，默认：500
                    });
                    $("<div id='map-box'><div id='map-box-item'></div><div id='area'></div><div class='map-box-close'>关闭</div></div>").appendTo('#map-view');
                    $('#map-box').css({
                        'top': _top,
                        'left': _left
                    })

                    //地理编码,返回地理编码结果
                    geocoder.getLocation(icode, function (status, result) {
                        if (status === 'complete' && result.info === 'OK') {
                            // console.log(result.geocodes[0].adcode);
                            idecode = [result.geocodes[0].adcode];
                            //创建地图
                            var smap = new AMap.Map('map-box-item', {
                                cursor: 'default',
                                zoom: 8
                            });
                            // console.log(iArea)
                            document.getElementById('area').innerHTML = iArea;
                            AMapUI.loadUI(['geo/DistrictExplorer'], function (DistrictExplorer) {
                                //创建一个实例
                                var _districtExplorer = new DistrictExplorer({
                                    map: smap,
                                    eventSupport: true,
                                });

                                function renderAreaNode(areaNode) {

                                    //绘制子区域
                                    _districtExplorer.renderSubFeatures(areaNode, function (feature, i) {
                                        return {
                                            cursor: 'default',
                                            bubble: true,
                                            strokeColor: '#ffffff', //线颜色
                                            strokeOpacity: 1, //线透明度
                                            strokeWeight: 2, //线宽
                                            fillColor: '#F54B4B', //填充色
                                            fillOpacity: 0.9, //填充透明度
                                        };
                                    });

                                    //绘制父区域
                                    _districtExplorer.renderParentFeature(areaNode, {
                                        cursor: 'default',
                                        bubble: true,
                                        strokeColor: '#ffffff', //线颜色
                                        strokeOpacity: 1, //线透明度
                                        strokeWeight: 2, //线宽
                                        fillColor: '#F54B4B', //填充色
                                        fillOpacity: 0, //填充透明度
                                    });
                                }

                                _districtExplorer.loadMultiAreaNodes(idecode, function (error, areaNodes) {

                                    //清除已有的绘制内容
                                    _districtExplorer.clearFeaturePolygons();

                                    for (var i = 0, len = areaNodes.length; i < len; i++) {
                                        renderAreaNode(areaNodes[i]);
                                    }

                                    //更新地图视野
                                    smap.setFitView(_districtExplorer.getAllFeaturePolygons());
                                    smap.setZoom(9)
                                });

                                var pointArr = [
                                    {
                                        'name': '<?= Yii::t('app', '北区');?>',
                                        'site': [121.372863, 31.275032]
                                    }, {
                                        'name': '<?= Yii::t('app', '杨浦');?>',
                                        'site': [121.538905, 31.312967]
                                    }, {
                                        'name': '<?= Yii::t('app', '长宁');?>',
                                        'site': [121.402927, 31.19712]
                                    }, {
                                        'name': '<?= Yii::t('app', '黄浦');?>',
                                        'site': [121.486883, 31.211508]
                                    }, {
                                        'name': '<?= Yii::t('app', '上南');?>',
                                        'site': [121.505394, 31.155407]
                                    }, {
                                        'name': '<?= Yii::t('app', '南汇');?>',
                                        'site': [121.590055, 31.050649]
                                    }, {
                                        'name': '<?= Yii::t('app', '宝山');?>',
                                        'site': [121.402973, 31.447997]
                                    }, {
                                        'name': '<?= Yii::t('app', '松江');?>',
                                        'site': [121.346761, 31.105019]
                                    }, {
                                        'name': '<?= Yii::t('app', '闵行');?>',
                                        'site': [121.394962, 31.056601]
                                    }, {
                                        'name': '<?= Yii::t('app', '浦东');?>',
                                        'site': [121.632402, 31.198802]
                                    }, {
                                        'name': '<?= Yii::t('app', '青浦');?>',
                                        'site': [121.053428, 31.104784]
                                    }, {
                                        'name': '<?= Yii::t('app', '奉贤&金山');?>',
                                        'site': [121.166061, 30.892842]
                                    }, {
                                        'name': '<?= Yii::t('app', '虹口');?>',
                                        'site': [121.48039, 31.312277]
                                    }, {
                                        'name': '<?= Yii::t('app', '嘉定');?>',
                                        'site': [121.318282, 31.31533]
                                    }, {
                                        'name': '<?= Yii::t('app', '川沙');?>',
                                        'site': [121.667695, 31.278765]
                                    }, {
                                        'name': '<?= Yii::t('app', '崇明');?>',
                                        'site': [121.843979, 31.535774]
                                    },
                                ]
                                for (let i = 0; i < pointArr.length; i++) {
                                    addMarker(pointArr[i].name, pointArr[i].site);
                                }
                                $('.leval5').parents('.amap-marker').show();

                                function addMarker(name, site) {
                                    let marker = new AMap.Marker({
                                        position: site
                                    });
                                    // let urls = '';
                                    // var s_con = 3;
                                    // switch (oTypes) {
                                    //     case 'totalorders':
                                    //         s_con = zengzhang;
                                    //         break;
                                    //     case 'visirate':
                                    //         s_con = kejian;
                                    //         break;
                                    //     case 'orders':
                                    //         s_con = diangou;
                                    //         break;
                                    // }
                                    // if (s_con) {
                                    //     urls = parseFloat(s_con) > 0 ? "<?php echo Yii::app()->baseUrl . '/images/up.png' ?>" : "<?php echo Yii::app()->baseUrl . '/images/down.png' ?>";
                                    // }
                                    let urls = "<?php echo Yii::app()->baseUrl . '/images/up.png' ?>";
                                    marker.setLabel({
                                        offset: new AMap.Pixel(6, 20), //修改label相对于maker的位置
                                        content: "<div v='id' class='leval5'><span> " + name + "</span>" + "<img src='" + urls + "' /></div>"
                                    });
                                    marker.setMap(smap); //Vikk注释的
                                }
                            });
                        }
                    });
                    $("#Search_factory").val('0');
                    $("#Search_factory").trigger("change");
                    $("#Search_region").val('1');
                    $("#Search_region").trigger("change");
                    $("#Search_city").val(clickid);
                    $("#Search_city").trigger("change");
                }
            })
            $(document).on('mouseenter', '.amap-marker', function () {
                $(this).css('z-index', 9999).siblings().css('z-index', 10);
            })
            $(document).on('click', '.map-box-close', function () {
                $('#map-box').remove();
            })
            clearTimeout(timerm2);
            timerm2 = setTimeout(function () {
                $('.leval1').parents('.amap-marker').hide();
                $('.leval2').parents('.amap-marker').hide();
                $('.map-men1').fadeOut(300);
            }, 4000)

        }
        init();
        $(document).on('click', '.change-map', function () {
            $('#container').remove();
            $(this).addClass('active').siblings().removeClass('active');
            oTypes = $(this).attr('o_type');
            $('<div id="container"></div>').appendTo('.map-wrap');
            clearTimeout(timerm1);
            clearTimeout(timerm2);
            init();
        });

        function containss(s, m) {
            for (let i = 0; i < m.length; i++) {
                if (s == m[i][1]) {
                    return true
                }
            }
            return false
        }

        function saveTwo(v) {
            if (v && v.length !== 0) {
                v = parseFloat(v);
                return Math.floor(v * 10000) / 100 + '%'
            } else {
                return 'NaN'
            }

        }

        function contains(arr, obj) {
            var i = arr.length;
            if (zoom < 6) {
                while (i--) {
                    if (obj % 10000 == 0 && Math.floor(arr[i] / 10000) == Math.floor(obj / 10000) || Math.floor(arr[i] / 100) == Math.floor(obj / 100)) {
                        return true
                    }
                }
                return false;
            } else if (zoom >= 6) {
                while (i--) {
                    if (Math.floor(arr[i] / 100) == Math.floor(obj / 100)) {
                        return true
                    }
                }
                return false;
            }

        }
    }
</script>


