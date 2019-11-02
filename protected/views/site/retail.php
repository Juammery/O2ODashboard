<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/echarts.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/angular.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/ng-echarts.js');

$relations = Relation::model()->findAll(array("index" => "id"));

$platforms = Platform::model()->findAll(array("index" => "id"));
$relationss = Relation::model()->findAll(array("order" => "sequence"));
$cityLevel_id = Citylevel::model()->findAll(array("index" => "id"));
//foreach($relations as $key=> $value){
//  //  $relations[$key]->name = Yii::t('cvs',$value->name,array(1));
//}
//品类
$category = Category::model()->findAll(array("index" => "id"));
$categorys = Category::model()->findAll(array("order" => "sequence"));
//制造商
$menu = Menu::model()->findAll(array("index" => "id"));
$menus = Menu::model()->findAll(array("order" => "sequence"));
//品牌
$brand = Brand::model()->findAll(array("index" => "id"));
$brands = Brand::model()->findAll(array("order" => "sequence"));
//$skuss = Sku::model()->findAll(array("order" => "sequence"));
$cate_classify = TotalClassify::model()->findAll(array("order" => "sequence"));
$cate_classifys = TotalClassify::model()->findAll(array("index" => "id"));

$changeCityLevel = array(
    0 => array(
        'id' => 1,
        'name' => 'Metro'
    ),
    1 => array(
        'id' => 2,
        'name' => 'U1'
    ),
    2 => array(
        'id' => 3,
        'name' => 'U2'
    )
);
$systems = System::model()->findAll(array('index' => 'id'));
$systemss = System::model()->findAll(array('order' => 'sequence'));
$citylevel = array_unique(CHtml::listData(Relation::model()->findAll(array('condition' => "depth=3", 'select' => 'name,id')), 'id', 'name'));

$db = Yii::app()->db;
//$sql = 'select stage as id,stage from cola_info where time="' . $searchmodel->month . '" GROUP BY  stage order by stage asc';
//$stages = $db->createCommand($sql)->queryAll();

$sql = "select table_name from information_schema.tables where TABLE_SCHEMA='cokeretail' and table_type='BASE TABLE' and TABLE_NAME like 'cola_info_%' ORDER BY TABLE_NAME desc";
$table = Yii::app()->db->createCommand($sql)->queryAll();
$arr = $maxStage = [];
foreach ($table as $key => $value) {
    $tableName = $value['table_name'];
    $infomation = explode('_', $tableName);
    if(isset($infomation[2],$infomation[3],$infomation[4])){
        $arr[] = ['time' => $infomation[2] . "_" . $infomation[3], 'stage' => $infomation[4]];
    }
}
foreach ($arr as $key => $value) {
    $value['time'] = str_replace('q','Q',$value['time']);
    $arr1[] = $value['time'];
    $maxStage[$value['time']][] = $value['stage'];
}
$stagess = $maxStage[$searchmodel->month];
$stage = 0;
for ($i = 0; $i < count($stagess); $i++) {
    if (isset($stagess[$i]) && $stagess[$i] == 1) {
        $stages[$i]['id'] = 1;
        $stages[$i]['value'] = Yii::t('cvs', 'YTD');
    }
    if (isset($stagess[$i]) && $stagess[$i] == 0) {
        $stages[$i]['id'] = 0;
        $stages[$i]['value'] = Yii::t('cvs', 'VS PP');
    }
    $stage = $stages[$i]['id'];
}

$timelist = array_unique($arr1);
//$lastlabel=isset($searchmodel->stage)&&$searchmodel->stage==0 ? '本月':'本期';

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
        $scope.templetList = datadService.getObject('templetList');
        $scope.colors = ['#95CCB5','#7DB3CD','#6782CF','#AC78DA','#95CC95','#78CDC8','#9E96FD','#C9A1D3',
            '#51B8BF','#77C289','#73AAED','#D17ED0', '#80C0E4','#5972E9','#5FC9A5','#E094D2'];
        $scope.region = "1";//区域
        $scope.factory = "0";//装瓶厂
        $scope.cityLevel = "0";//城市等级
        $scope.city = "0";//城市
        $scope.platform = "0";//平台
        $scope.cityLevelListtype = '0';
        $scope.station = "0";
        $scope.month = "<?= $searchmodel->month ?>";//月
        $scope.downMonth = "<?= $searchmodel->month ?>";//月
        $scope.stage = "<?= $searchmodel->stage ?>";//轮次
        $scope.category = "0";  //品类
        $scope.menu = "0";  //制造商
        $scope.brand = "0";  //品牌
        $scope.capacity = "0";  //容量分级
        $scope.bottle = "0";  //瓶量分级
        $scope.SKU = "0";  //sku
        $scope.system = '0';
        $scope.systemtype = '0';
        $scope.nodata = '<?= Yii::t('cvs', 'N/A');?>';
        $scope.deepgroupcheck = 'group';
        $scope.deepcityLevelcheck = 'cityLevel';
        $scope.deepbrandcheck = 'catalog';
        $scope.total = $scope.categoryList;
        $scope.deepsystemcheck = 'systemtype';
        $scope.deepplatformcheck = 'platform';
        $scope.deepgradingcheck = 'capacity';
        $scope.cityLevelListcheck = '';
        $scope.cityLevelListcheck2 = '';
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
        $scope.kpichecked = 1;//默认产品铺货率
        $scope.brandreadonly = {
            category: false,
            manufacturer: false,
            brand: false,
            SKU: false,
            capacity: false,
            bottle: false
        };
        $scope.relations = <?php echo CJSON::encode($relations) ?>;
        $scope.relationss = <?php echo CJSON::encode($relationss) ?>;
        $scope.platforms = <?php echo CJSON::encode($platforms) ?>;
        $scope.citylevel = <?php echo CJSON::encode($citylevel) ?>;
        $scope.cityLevel_id = <?php echo CJSON::encode($cityLevel_id) ?>;
        $scope.timelist = <?php echo CJSON::encode($timelist) ?>;
        $scope.puzzle = <?php echo CJSON::encode(Yii::app()->params['puzzle']);?>;
        $scope.relationslist = $scope.relationss;
        $scope.categoryList = <?php echo CJSON::encode($category) ?>;
        $scope.categorys = <?php echo CJSON::encode($categorys) ?>;
        $scope.menuList = <?php echo CJSON::encode($menu) ?>;
        $scope.menus = <?php echo CJSON::encode($menus) ?>;
        $scope.brandList = <?php echo CJSON::encode($brand) ?>;
        $scope.brands = <?php echo CJSON::encode($brands) ?>;
        $scope.cate_classify = <?php echo CJSON::encode($cate_classify) ?>;
        $scope.cate_classifys = <?php echo CJSON::encode($cate_classifys) ?>;
        $scope.skuslist = $scope.skuss;
        $scope.forbid = false;//控制禁止
        $scope.systems =<?php echo CJSON::encode($systems)?>;
        $scope.systemslist = <?php echo CJSON::encode($systemss)?>;
        //筛选
        $scope.cityLevelList = <?php echo CJSON::encode($cityLevel_id)?>;
        $scope.stages =<?php echo CJSON::encode($stages)?>;
        $scope.pageNumber = 1;//第一页(本期值、变化率)
        $scope.pageNum = 11;
        $scope.optionKpi = "distribution";
        $scope.optionLastKpi = "last_distribution";
        $scope.kpiOption = <?=CJSON::encode(Yii::app()->params['kpichecked'])?>;
        $scope.myFunction1 = function () {
            $scope.pageNumber += 1;
            console.log("数据请求第", $scope.pageNumber, '次','进度条触动第', $scope.pageNumber-1, '次');
            $scope.getChartsData('',false);
        };
        //下拉框
        $scope.typeData = [
            {"label": "0", "value": "VS LM / VS QT"},
            {"label": "-1", "value": "VS LY"}
        ];
        $scope.myselect = "0";
        $("#myselect").find("option[value='1']").prop("selected", true);
        $scope.getDataType = function () {
            switch ($scope.myselect) {
                case "0" :  //月值
                    $scope.stage = 0;
                    $("#Search_stage").find("option[value='0']").prop("selected", true);
                    break;
                case "-1" :  //YTD
                    $scope.stage = -1;
                    $("#Search_stage").find("option[value='-1']").prop("selected", true);
                    break;
            }
            console.log("头部下拉框选中的值：", $scope.myselect);
        };

        $scope.totalfixed = <?php echo CJSON::encode($datas['totalfixed'])?>;
        //console.log('头部数据', $scope.totalfixed);
        $scope.groupInfo = <?php echo CJSON::encode($datas['groupInfo'])?>;
        $scope.rank = <?php echo CJSON::encode($datas['rank'])?>;
        $scope.pieData = <?php echo CJSON::encode($datas['pieData'])?>;
        console.log('$scope.pieData:进度条数据', $scope.pieData);
        console.log('$scope.rank:排行数据', $scope.rank);
        $scope.classify = 1;
        $scope.koCompeting = function (classify) {
            $scope.classify = classify;
            if (classify == 1) {
                $("#ko_ummarize").attr('style', 'background-color:red;color: white;');
                $("#no_ummarize").attr('style', 'background-color:white;color: red;');
                $("#NARTD_ummarize").attr('style', 'background-color:white;color: red;');
            } else if (classify == 2) {
                $("#no_ummarize").attr('style', 'background-color:red;color: white;');
                $("#ko_ummarize").attr('style', 'background-color:white;color: red;');
                $("#NARTD_ummarize").attr('style', 'background-color:white;color: red;');
            }else{
                $("#no_ummarize").attr('style', 'background-color:white;color: red;');
                $("#ko_ummarize").attr('style', 'background-color:white;color: red;');
                $("#NARTD_ummarize").attr('style', 'background-color:red;color: white;');
            }
        };

        //饼图数据
        $scope.labels =<?php echo CJSON::encode($datas['labels'])?>;
        //console.log('labels', $scope.labels);
        $scope.getTotal = function () {
            switch ($scope.deepbrandcheck) {
                case "catalog":
                    $scope.total = $scope.categoryList;
                    break;
                case "manufacturer":
                    $scope.total = $scope.menuList;
                    break;
                case "brand":
                    $scope.total = $scope.brandList;
                    break;
            }
        };
        angular.forEach($scope.relations, function (data, index, array) {
            $scope.relations[index]['checked'] = true;
            $scope.relations[index]['show'] = true;
        });
        angular.forEach($scope.relationss, function (data, index, array) {
            $scope.relationss[index]['checked'] = true;
            $scope.relationss[index]['show'] = true;
        });
        angular.forEach($scope.skus, function (data, index, array) {
            $scope.skus[index]['checked'] = true;
            $scope.skus[index]['show'] = false;
        });
        angular.forEach($scope.skuss, function (data, index, array) {
            $scope.skuss[index]['checked'] = true;
            $scope.skuss[index]['show'] = false;
        });
        angular.forEach($scope.cate_classifys, function (data, index, array) {
            $scope.cate_classifys[index]['checked'] = 1;
            $scope.cate_classifys[index]['show'] = 0;
        });
        angular.forEach($scope.cate_classify, function (data, index, array) {
            $scope.cate_classify[index]['checked'] = 1;
            $scope.cate_classify[index]['show'] = 0;
        });
        angular.forEach($scope.categoryList, function (data, index, array) {
            $scope.categoryList[index]['checked'] = 1;
            $scope.categoryList[index]['show'] = 1;
        });
        angular.forEach($scope.categorys, function (data, index, array) {
            $scope.categorys[index]['checked'] = 1;
            $scope.categorys[index]['show'] = 1;
        });
        angular.forEach($scope.menuList, function (data, index, array) {
            $scope.menuList[index]['checked'] = 0;
            $scope.menuList[index]['show'] = 0;
        });
        angular.forEach($scope.menus, function (data, index, array) {
            $scope.menus[index]['checked'] = 0;
            $scope.menus[index]['show'] = 0;
        });
        angular.forEach($scope.brandList, function (data, index, array) {
            $scope.brandList[index]['checked'] = 0;
            $scope.brandList[index]['show'] = 0;
        });
        angular.forEach($scope.brands, function (data, index, array) {
            $scope.brands[index]['checked'] = 0;
            $scope.brands[index]['show'] = 0;
        });
        angular.forEach($scope.cityLevelList, function (data, index, array) {
            $scope.cityLevelList[index]['checked'] = true;
            $scope.cityLevelList[index]['show'] = false;
        });
        angular.forEach($scope.platforms, function (data, index, array) {
            $scope.platforms[index]['checked'] = true;
            $scope.platforms[index]['show'] = false;
        });
        angular.forEach($scope.systems, function (data, index, array) {
            if (data.depth == 1) {
                $scope.systems[index]['checked'] = 1;
            } else {
                $scope.systems[index]['checked'] = 0;
            }
        });

        $scope.koinfos = <?php echo CJSON::encode($datas['koinfos'])?>;
        $scope.allskuinfos = "";
        $scope.visitab = "distribution";
        $scope.visitab3 = "distribution";
        $scope.visitab2 = "last_distribution";
        // $scope.visichart = "attach_rate";
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
        $scope.saveName = '';
        $scope.openSave = function () {
            $scope.saveName = '';
            var head = '';
            for (let i = 0; i < $('#form .chosen-single span').length; i++) {
                head += '' + $('#form .chosen-single span').eq(i).html() + ',';
            }
            head += '' + $('#Search_month').val();
            var middle1 = '';
            var middle2 = '';
            var middle3 = '';
            var middle4 = '';
            var middle5 = '';
            var middle6 = '';//容量分级或者瓶量分级
            var isgradingTemp = ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') ? 1 : ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') ? 2 : 0;

            if ($('.sel-con.a .active').length > 12) {
                for (let i = 0; i < 12; i++) {
                    middle1 += '' + $('.sel-con.a .active').eq(i).siblings('span').html() + ',';
                }
                middle1 += '...'
            } else {
                for (let i = 0; i < $('.sel-con.a .active').length; i++) {
                    middle1 += '' + $('.sel-con.a .active').eq(i).siblings('span').html() + ',';
                }
            }
            if ($scope.iscityleveltype == 'ischecked') {//如果选中了城市等级
                if ($('#cityLevel .sel-con.b .active').length > 12) {
                    for (let i = 0; i < 12; i++) {
                        middle3 += '' + $('#cityLevel .sel-con.b .active').eq(i).siblings('span').html() + ',';
                    }
                    middle3 += '...'
                } else {
                    for (let i = 0; i < $('#cityLevel .sel-con.b .active').length; i++) {
                        middle3 += '' + $('#cityLevel .sel-con.b .active').eq(i).siblings('span').html() + ',';
                    }
                }
            } else {
                middle3 = '全部';
            }
            //渠道
            if ($('#system .sel-con.b .active').length > 12) {
                for (let i = 0; i < 12; i++) {
                    middle4 += '' + $('#system .sel-con.b .active').eq(i).siblings('span').html() + ',';
                }
                middle4 += '...'
            } else {
                for (let i = 0; i < $('#system .sel-con.b .active').length; i++) {
                    middle4 += '' + $('#system .sel-con.b .active').eq(i).siblings('span').html() + ',';
                }
            }
            //平台
            if ($('#platform .sel-con.b .active').length > 12) {
                for (let i = 0; i < 12; i++) {
                    middle5 += '' + $('#platform .sel-con.b .active').eq(i).siblings('span').html() + ',';
                }
                middle5 += '...'
            } else {
                for (let i = 0; i < $('#platform .sel-con.b .active').length; i++) {
                    middle5 += '' + $('#platform .sel-con.b .active').eq(i).siblings('span').html() + ',';
                }
            }
            //品类，制造商，品牌
            if ($('.sel-con.c .active').length > 12) {
                for (let i = 0; i < 12; i++) {
                    middle2 += '' + $('.sel-con.c .active').eq(i).siblings('span').html() + ',';
                }
                middle2 += '...'
            } else {
                for (let i = 0; i < $('.sel-con.c .active').length; i++) {
                    middle2 += '' + $('.sel-con.c .active').eq(i).siblings('span').html() + ',';
                }
            }

            if (isgradingTemp == 1) {//选中容量分级
                for (let i = 0; i < $('#gradingTemp .sel-con.b .capacityTemp .active').length; i++) {
                    middle6 += '' + $('#gradingTemp .sel-con.b .capacityTemp .active').eq(i).siblings('span').html() + ',';
                }
            } else if (isgradingTemp == 2) {//选中瓶量分级
                for (let i = 0; i < $('#gradingTemp .sel-con.b .bottleTemp .active').length; i++) {
                    middle6 += '' + $('#gradingTemp .sel-con.b .bottleTemp .active').eq(i).siblings('span').html() + ',';
                }
            } else {
                middle6 = '全部';
            }
            $scope.head = head;
            $scope.middle1 = middle1;
            $scope.middle2 = middle2;
            $scope.middle3 = middle3;
            $scope.middle4 = middle4;
            $scope.middle5 = middle5;
            $scope.middle6 = middle6;
            layer.open({
                type: 1,
                title: '<?= Yii::t('cvs', '另存为模板'); ?>',
                content: $('.template'), //这里content是一个普通的String
                area: ['450px', '420px']
            });
        };

        $scope.saveTemplet = function () {  //保存模板事件
            var judgment = true;
            if ($scope.saveName.length <= 0) {
                layer.tips('命名不能为空', '#save_template', {
                    tips: [1, '#3595CC'],
                    time: 2400
                });
                judgment = false;
                return false;
            }
            angular.forEach($scope.templetList, function (data, key) {
                //     console.log(data,key);
                if (key == $scope.saveName) {
                    layer.tips('命名与已有模板重复了，修改后再试试', '#save_template', {
                        tips: [1, '#3595CC'],
                        time: 2400
                    });
                    judgment = false;
                    return false;
                }
            });
            if (judgment) {
                var templetData = {
                    //单选
                    'month': $scope.month,
                    'stage': $scope.stage,
                    'region': $scope.region,
                    'factory': $scope.factory,
                    'city': $scope.city,
                    'cityLevel': $scope.cityLevel,
                    'systemtype': $scope.systemtype,
                    'platform': $scope.platform,
                    'category': $scope.category,
                    //多选
                    'deepgroupcheck': $scope.deepgroupcheck,//区域
                    'iscityleveltype': $scope.iscityleveltype,//是否选中城市等级
                    'deepsystemcheck': $scope.deepsystemcheck,//渠道
                    'deepplatformcheck': $scope.deepplatformcheck,//平台
                    'deepbrandcheck': $scope.deepbrandcheck,//品类，品牌，制造商
                    'deepgradingcheck': $scope.deepgradingcheck,
                    'iscapacity': $scope.iscapacity,//是否选中容量分级
                    'isbottle': $scope.isbottle,//是否选中瓶量分级

                    'relations': $scope.relations,//区域数组
                    'cityLevelList': $scope.cityLevelList,//城市等级数组
                    'systems': $scope.systems,//渠道数组
                    'platforms': $scope.platforms,//平台数组
                    'categoryList': $scope.categoryList,//品类数组
                    'menuList': $scope.menuList,//制造商数组
                    'brandList': $scope.brandList,//品牌数组
                    'cate_classifys': $scope.cate_classifys,//容量分级&瓶量分级
                    //
                    'relationss': $scope.relationss,//区域数组
                    'systemss': $scope.systemss,//渠道数组
                    'categorys': $scope.categorys,//品类数组
                    'menus': $scope.menus,//制造商数组
                    'brands': $scope.brands,//品牌数组
                    'cate_classify': $scope.cate_classify//容量分级&瓶量分级
                };
                $scope.templetList[$scope.saveName] = templetData;
//                console.log(JSON.stringify($scope.templetList));
                datadService.setObject("templetList", $scope.templetList);
                $('.conta>.layui-layer-page .layui-layer-close1').trigger('click');
                layer.msg('保存成功！');
            }
        };

        $scope.showsel = false;
        $scope.getTemplet = function (key) {  //选中模板事件
            if (!key) {
                return false
            }
            //     console.log(key)
            var getData = datadService.getObject("templetList")[key];
            //    console.log(typeof(getData.brand));
            var headArr = getData.month.split(',');
            for (let i = 0; i < headArr.length; i++) {
                $('#form .chosen-single span').eq(i).html(headArr[i]);
            }
            $('#Search_month').val(headArr[headArr.length - 1]);
            $scope.month = getData.month;
            $scope.stage = getData.stage;
            $scope.region = getData.region;
            $scope.factory = getData.factory;
            $scope.city = getData.city;
            $scope.cityLevel = getData.cityLevel;
            $scope.systemtype = getData.systemtype;
            $scope.platform = getData.platform;
            $scope.category = getData.category;

            $scope.deepgroupcheck = getData.deepgroupcheck;
            $scope.iscityleveltype = getData.iscityleveltype;
            $scope.deepsystemcheck = getData.deepsystemcheck;
            $scope.deepplatformcheck = getData.deepplatformcheck;
            $scope.deepbrandcheck = getData.deepbrandcheck;
            $scope.deepgradingcheck = getData.deepgradingcheck;//
            $scope.iscapacity = getData.iscapacity;
            $scope.isbottle = getData.isbottle;

            $scope.relations = getData.relations;//区域
            $scope.cityLevelList = getData.cityLevelList;//城市等级数组
            $scope.systems = getData.systems;//渠道数组
            $scope.platforms = getData.platforms;//平台数组
            $scope.categoryList = getData.categoryList;//品类数组
            $scope.menuList = getData.menuList;//制造商数组
            $scope.brandList = getData.brandList;//品牌数组
            $scope.cate_classifys = getData.cate_classifys;//容量分级&瓶量分级
            //
            $scope.relationss = getData.relationss;//区域数组
            $scope.systemss = getData.systemss;//渠道数组
            $scope.categorys = getData.categorys;//品类数组
            $scope.menus = getData.menus;//制造商数组
            $scope.brands = getData.brands;//品牌数组
            $scope.cate_classify = getData.cate_classify;//容量分级&瓶量分级
            if ($scope.iscityleveltype == 'unchecked') {
                $scope.typeValue = false;
            } else {
                $scope.typeValue = true;
            }
            if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {
                $scope.capacitycheck = false;
                $scope.bottlecheck = false;
            } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {
                $scope.capacitycheck = true;
                $scope.bottlecheck = false;
            } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {
                $scope.capacitycheck = false;
                $scope.bottlecheck = true;
            }
            $scope.onoptionchange(13);
        };

        $scope.kpibtnchg = function (kpi, history) {
            if($scope.history[kpi] == history) return false;
            $scope.history[kpi] = history;
            $scope.getbrowser();//滚动条重新归为0，切换指标比较和趋势图时页数也改为第一页
            if (history == 1) {
                $('.tabtitle').hide();
                // if($scope.deepgroupcheck!= $scope.deepgroupcheck2||$scope.deepbrandcheck!=$scope.deepbrandcheck2||$scope.deepsystemcheck!=$scope.deepsystemcheck2){
                //     $scope.deepgroupcheck2 = $scope.deepgroupcheck;
                //     $scope.deepbrandcheck2 = $scope.deepbrandcheck;
                //     $scope.deepsystemcheck2 = $scope.deepsystemcheck;
                // $('.map-men2').show();
                // $('.map-men2').show();chart-view
                // $("#chart-view").addClass("mb-fff");

                $scope.getLineData(true);

                // }
            } else {
                $('.tabtitle').show();
                $scope.getBarData(true);
            }
        };
        $scope.getLineData = function (removeData) {
            // $('#chart-view').append("<div class='mb-fff'></div>");
            $('#chart-view').append("<div class='mb-fff'></div>");
            console.log("$scope.deepbrandcheck:", $scope.deepbrandcheck);
            $scope.getPageSize();
            $scope.getTotalId();//获取区域checked项的id
            if(removeData){
                $scope.emptyData();//置空变量数据
            }
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let systemtype = $scope.deepsystemcheck == 'systemtype' ? 1 : $scope.deepsystemcheck == 'system' ? 2 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : $scope.deepbrandcheck == 'capacity' ? 4 : $scope.deepbrandcheck == 'bottle' ? 5 : null;
            let platform = $scope.deepplatformcheck == 'platform' ? 1 : null;
            let cityLevelListtype = $scope.cityLevelListcheck == 'cityLevelListtype' ? 1 : 0;
            let iscityleveltype = $scope.iscityleveltype == 'ischecked' ? 1 : 0;
            let isgrading = ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') ? 1 : ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') ? 2 : 0;
            let kpichecked = $scope.kpichecked;
            let pageNum = $scope.pageNum;
            let pageNumber = $scope.pageNumber;
            let config = {
                'citytype': citytype,
                'systemtype': systemtype,
                'cityLevelListtype': cityLevelListtype,
                'skutype': skutype,
                'platform': platform,
                'month': $scope.month,
                'stage': $scope.stage,
                'iscityleveltype': iscityleveltype,//判断是否选择了城市等级
                'isgrading': isgrading,
                'kpichecked': kpichecked,
                'pageNum': pageNum,
                'pageNumberTrend': pageNumber,
                'removeCache': removeData,
                'relationsArr': $scope.relationsArr,//区域字符串
                'cityLevelsArr': $scope.cityLevelsArr,//区域字符串
                'systemsArr': $scope.systemsArr,//渠道字符串
                'platformsArr': $scope.platformsArr,//平台字符串
                'categorysArr': $scope.categorysArr,//品类字符串
                'menusArr': $scope.menusArr,//制造商字符串
                'brandsArr': $scope.brandsArr,//品牌字符串
                'capacitysArr': $scope.capacitysArr,//容量分级字符串
                'bottlesArr': $scope.bottlesArr//瓶量分级字符串
            };
            $http({
                url: '<?php echo $this->createurl("site/Historyretaildata"); ?>',
                params: config
            }).success(function (res) {
                // $scope.all_skuinfos = res;
                $scope.all_skuinfos = $scope.gather($scope.all_skuinfos,res);//汇总每次分批传递过来的数据
                // $scope.visitab = $scope.visitab3;
                console.log('折线图数据&双折线数据', $scope.all_skuinfos);
                $('.mb-fff').remove();
            }).error(function (data, header, config, status) {
                $('.mb-fff').remove();

            });
            // $('#chart-view').append("<div class='mb-fff'></div>");
            // $("#chart-view").removeClass("mb-fff");
            // $('.mb-fff').hide();

        };

        $scope.checkralationshow = function (id) {
            let ret = false;
            if ($scope.deepgroupcheck == 'group' && $scope.relations[id].depth == 1){
                if($scope.region != '1'){
                    if($scope.region == id){
                        ret = true;
                    }
                }else{
                    ret = true;
                }
            }
            if ($scope.deepgroupcheck == 'factory') {
                if ($scope.factory !== '0' && id == $scope.factory) ret = true;
                if ($scope.factory == '0' && $scope.relations[id].parent == $scope.region && $scope.region != 1) ret = true;
                if ($scope.region == '1' && $scope.factory== '0' && $scope.relations[id].depth == 2) ret = true;
            }
            if ($scope.deepgroupcheck == 'city' && $scope.factory !== '0') {
                if ($scope.city == '0' && $scope.relations[id].parent == $scope.factory) {
                    ret = true;
                } else if ($scope.city != '0' && $scope.relations[id].id == $scope.city) {
                    ret = true;
                }
            }
            if ($scope.deepgroupcheck == 'city' && $scope.factory == '0' && $scope.relations[id].depth == 3) {
                if ($scope.city == '0') {
                    if ($scope.region != '1' && ($scope.relations[$scope.relations[id].parent].parent == $scope.region)) {
                        ret = true;
                    }
                    if ($scope.region == '1') {    //选择了装瓶集团
                        ret = true;
                    }
                } else if (id == $scope.city) {
                    ret = true;
                }
            }
            $scope.relations[id]['show'] = ret;
            return ret;
        };
        $scope.checkcityLevelshow = function (id) {
            let ret = false;
            if ($scope.deepcityLevelcheck == 'cityLevel') {
                if ($scope.cityLevel =='0') {
                    ret = true;
                }
                if ($scope.cityLevel != '0' && $scope.cityLevelList[id].id == $scope.cityLevel) {
                    ret = true;
                }
            }
            $scope.cityLevelList[id]['show'] = ret;
            return ret;
        };
        $scope.checksystemshow = function (id) {
            let ret = false;
            if ($scope.deepsystemcheck == 'systemtype') {
                if ($scope.systemtype =='0') {
                    ret = true;
                }
                if ($scope.systemtype != '0' && $scope.systems[id].id == $scope.systemtype) {
                    ret = true;
                }
            }
            $scope.systems[id]['show'] = ret;
            return ret;
        };
        $scope.checkplatformshow = function (id) {
            let ret = false;
            if ($scope.deepplatformcheck == 'platform') {
                if ($scope.platform =='0') {
                    ret = true;
                }
                if ($scope.platform != '0' && $scope.platforms[id].id == $scope.platform) {
                    ret = true;
                }
            }
            $scope.platforms[id]['show'] = ret;
            return ret;
        };
        $scope.checkcategoryshow = function (id) {
            let ret = false;
            if ($scope.deepbrandcheck == 'catalog') {
                if ($scope.category =='0') {
                    ret = true;
                }
                if ($scope.category != '0' && $scope.categoryList[id].id == $scope.category) {
                    ret = true;
                }
            }
            $scope.categoryList[id]['show'] = ret;
            return ret;
        };

        $scope.chgcheck = function (id) {
            angular.forEach($scope.relationss, function (data, index, array) {
                if (data.id == id) {
                    $scope.relationss[index].checked = $scope.relationss[index].checked == 1 ? 0 : 1;
                    $scope.relationss[index].show = $scope.relationss[index].show == 1 ? 0 : 1;
                }
            })
            $scope.relations[id]['checked'] = $scope.relations[id]['checked'] == 1 ? 0 : 1;
            $scope.relations[id]['show'] = $scope.relations[id]['show'] == 1 ? 0 : 1;
        }
        $scope.categorychgcheck = function (id) {
            angular.forEach($scope.cate_classifys, function (data, index, array) {
                if (data.id == id) {
                    $scope.cate_classifys[index].checked = $scope.cate_classifys[index].checked == 1 ? 0 : 1;
                }
            });
            $scope.cate_classify[id]['checked'] = $scope.cate_classifys[id]['checked'] == 1 ? 0 : 1;
        };
        $scope.gradingchgcheck = function (id) {
            angular.forEach($scope.cate_classify, function (data, index, array) {
                if (data.id == id) {
                    $scope.cate_classify[index].checked = $scope.cate_classify[index].checked == 1 ? 0 : 1;
                }
            });
            angular.forEach($scope.cate_classifys, function (data, index, array) {
                if (data.id == id) {
                    $scope.cate_classifys[index].checked = $scope.cate_classifys[index].checked == 1 ? 0 : 1;
                }
            });
        };
        $scope.skuchgcheck = function (id, type) {
            switch (type) {
                case "category" :
                    angular.forEach($scope.categorys, function (data, index, array) {
                        if (data.id == id) {
                            $scope.categorys[index].checked = $scope.categorys[index].checked == 1 ? 0 : 1;
                        }
                    });
                    angular.forEach($scope.categoryList, function (data, index, array) {
                        if (data.id == id) {
                            $scope.categoryList[index].checked = $scope.categoryList[index].checked == 1 ? 0 : 1;
                        }
                    });
                    // $scope.category[id]['checked'] = $scope.category[id]['checked'] == 1 ? 0 : 1;
                    break;
                case "menu":
                    angular.forEach($scope.menus, function (data, index, array) {
                        if (data.id == id) {
                            $scope.menus[index].checked = $scope.menus[index].checked == 1 ? 0 : 1;
                        }
                    });
                    angular.forEach($scope.menuList, function (data, index, array) {
                        if (data.id == id) {
                            $scope.menuList[index].checked = $scope.menuList[index].checked == 1 ? 0 : 1;
                        }
                    });
                    // $scope.menus[id]['checked'] = $scope.menu[id]['checked'] == 1 ? 0 : 1;
                    break;
                case "brand":
                    angular.forEach($scope.brands, function (data, index, array) {
                        if (data.id == id) {
                            $scope.brands[index].checked = $scope.brands[index].checked == 1 ? 0 : 1;
                        }
                    });
                    angular.forEach($scope.brandList, function (data, index, array) {
                        if (data.id == id) {
                            $scope.brandList[index].checked = $scope.brandList[index].checked == 1 ? 0 : 1;
                        }
                    });
                    // $scope.brands[id]['checked'] = $scope.brand[id]['checked'] == 1 ? 0 : 1;
                    break;
            }
        };
        $scope.syschgcheck = function (id) {
            $scope.systems[id]['checked'] = $scope.systems[id]['checked'] == 1 ? 0 : 1;
        };
        $scope.citylevelchk = function (id) {
            $scope.cityLevelList[id]['checked'] = $scope.cityLevelList[id]['checked'] == 1 ? 0 : 1;
        };
        $scope.platformcheck = function (id) {
            $scope.platforms[id]['checked'] = $scope.platforms[id]['checked'] == 1 ? 0 : 1;
        };
        $scope.mapindex = 2;

        function pieChartsChange() {
            // console.log($scope);
            // console.log('gyf');
            let v = $scope.visitab;
            // console.log(v);
//            if (v == 'distribution_stores')v = 'distribution'
//            if (v == 'shelf_number')v = 'sovi'
//            if (v == 'extra_displays' || v == 'Last_extra_displays_radio' || 'promotion')v = 'thematic_activity'
            //       $scope.pie1.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieLeftid][0][v], 1 - $scope.kopciinfos.koandpcis[$scope.pieLeftid][0][v]];
            //       $scope.pie2.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieLeftid][1][v], 1 - $scope.kopciinfos.koandpcis[$scope.pieLeftid][1][v]];
            //       $scope.pie3.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieLeftid][2][v], 1 - $scope.kopciinfos.koandpcis[$scope.pieLeftid][2][v]];
            //      $scope.pie4.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieLeftid][3][v], 1 - $scope.kopciinfos.koandpcis[$scope.pieLeftid][3][v]];
        }

        function brandsreadonlycheck() {
            switch ($scope.visitab) {
                case 'thematic_activity':
                case 'extra_displays':
                case 'equipment_sales':
                    $scope.brandreadonly = {category: true, brand: true, sku: true, capacity: true, bottle: true};
                    break;
                case 'sovi':
                    $scope.brandreadonly = {category: false, brand: false, sku: false, capacity: false, bottle: false};
                    break;
                default:
                    $scope.brandreadonly = {category: false, brand: false, sku: false, capacity: false, bottle: false};
                    break;
            }
        }

        $scope.tabchange = function (tab, kpichecked){
            if ($scope.visitab == tab) {

                return false;
            }
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
            };//本期值和趋势的切换（指标切换时，图表一开始都显示为本期值）
            $scope.visitab = tab;//先触发无数据报错TypeError: Cannot use 'in' operator to search for '_ec_inner' in undefined
            $scope.kpichecked = kpichecked;
            $scope.optionKpi = tab;
            $scope.optionLastKpi = $scope.kpiOption[kpichecked]['gradient'];
            //pieChartsChange();
            // $scope.allskuinfos = $scope.allskuinfos2 = [];
            // $scope.visitab3 = tab;
            $scope.getbrowser();//滚动条重新归为0，切换指标时页数也改为第一页
            // console.log('iiiiii');
            $scope.getChartsData('', true);
            //brandsreadonlycheck();
//            switch (tab) {
//                case 'distribution':
//                    $scope.mapindex = 2;    //地图显示API
//                    $scope.visitab2 = 'last_distribution';
//                    $scope.skuvisible = true;
//                    break;
//                case 'average_selling_price':
//                    $scope.mapindex = 3;
//                    $scope.visitab2 = 'last_average_selling_price';
//                    $scope.skuvisible = true;
//                    break;
//                case 'average_purchase_price':
//                    $scope.mapindex = 5;
//                    $scope.visitab2 = 'last_average_purchase_price';
//                    $scope.skuvisible = false;
//                    break;
//                case 'thematic_activity':
//                    $scope.mapindex = 6;
//                    $scope.visitab2 = 'Last_thematic_activity_radio';
//                    $scope.skuvisible = false;
//                    break;
//                case 'equipment_sales':
//                    $scope.mapindex = 7;
//                    $scope.visitab2 = 'Last_equipment_sales_radio';
//                    //$scope.visitab2 = 'equipment_sales';
//                    $scope.kpibtnchg('equipment_sales', 1)
//                    $scope.skuvisible = false;
//                    break;
//                case 'distribution_stores':
//                    $scope.mapindex = 2;
//                    $scope.visitab2 = 'Last_distribution_stores_radio';
//                    $scope.skuvisible = true;
//                    break;
//                case 'shelf_number':
//                    $scope.mapindex = 3;
//                    $scope.visitab2 = 'Last_shelf_number_radio';
//                    $scope.skuvisible = true;
//                    break;
//                case 'promotion':
//                    $scope.mapindex = 6;
//                    $scope.visitab2 = 'Last_promotion_radio';
//                    $scope.skuvisible = false;
//                    break;
//            }
        };
        $scope.chartchange = function (tab) {
            $scope.visichart = tab;
        };
        $scope.cancelSelect = function (type, boo) {
            var _depth;
            switch (type) {
                case "areacheck"://区域
                    switch ($scope.deepgroupcheck) {
                        case 'group':
                            _depth = 1;
                            break;
                        case 'factory':
                            _depth = 2;
                            break;
                        case 'city':
                            _depth = 3;
                            break;
                    }
                    angular.forEach($scope.relations, function (data, index, array) {
                        if (_depth == data.depth) {
                            $scope.relations[index]['checked'] = boo;
                        }
                    });
                    angular.forEach($scope.relationss, function (data, index, array) {
                        if (_depth == data.depth) {
                            $scope.relationss[index]['checked'] = boo;
                        }
                    });
                    break;
                case "brandcheck"://品类、制造商、品牌
                    switch ($scope.deepbrandcheck) {
                        case 'catalog':   //品类
                            angular.forEach($scope.categoryList, function (data, index, array) {
                                $scope.categoryList[index]['checked'] = boo;
                            });
                            angular.forEach($scope.categorys, function (data, index, array) {
                                $scope.categorys[index]['checked'] = boo;
                            });
                            break;
                        case 'manufacturer':   //制造商
                            angular.forEach($scope.menuList, function (data, index, array) {
                                $scope.menuList[index]['checked'] = boo;
                            });
                            angular.forEach($scope.menus, function (data, index, array) {
                                $scope.menus[index]['checked'] = boo;
                            });
                            break;
                        case 'brand':   //品牌
                            angular.forEach($scope.brandList, function (data, index, array) {
                                $scope.brandList[index]['checked'] = boo;
                            });
                            angular.forEach($scope.brands, function (data, index, array) {
                                $scope.brands[index]['checked'] = boo;
                            });
                            break;
                    }
                    break;
                case "systemcheck"://渠道
                    switch ($scope.deepsystemcheck) {
                        case 'systemtype':
                            angular.forEach($scope.systems, function (data, index, array) {
                                if (data.depth == 1) {
                                    $scope.systems[index]['checked'] = boo;
                                } else {
                                    $scope.systems[index]['checked'] = false;
                                }
                            });
                            break;
                        case 'system':
                            angular.forEach($scope.systems, function (data, index, array) {
                                if ((data.depth == 2 && $scope.systemtype != 0 && data.parent == $scope.systemtype) || (data.depth == 2 && $scope.systemtype == 0)) {
                                    $scope.systems[index]['checked'] = boo;
                                } else {
                                    $scope.systems[index]['checked'] = false;
                                }
                            });
                            break;
                    }
                    break;
                case "platformcheck"://平台
                    angular.forEach($scope.platforms, function (data, index, array) {
                        $scope.platforms[index]['checked'] = boo;
                    });
                    break;
                case "cityLevelListcheck"://城市等级
                    angular.forEach($scope.cityLevelList, function (data, index, array) {
                        $scope.cityLevelList[index]['checked'] = boo;
                    });
                    break;
                case "gradingListcheck"://分级
                    switch ($scope.deepgradingcheck) {
                        case "capacity"://容量分级
                            angular.forEach($scope.cate_classifys, function (data, index, array) {
                                if (data.classify == 1) {
                                    $scope.cate_classifys[index]['checked'] = boo;
                                } else {
                                    $scope.cate_classifys[index]['checked'] = false;
                                }
                            });
                            angular.forEach($scope.cate_classify, function (data, index, array) {
                                if (data.classify == 1) {
                                    $scope.cate_classify[index]['checked'] = boo;
                                } else {
                                    $scope.cate_classify[index]['checked'] = false;
                                }
                            });
                            break;
                        case "bottle"://瓶量分级
                            angular.forEach($scope.cate_classifys, function (data, index, array) {
                                if (data.classify == 2) {
                                    $scope.cate_classifys[index]['checked'] = boo;
                                } else {
                                    $scope.cate_classifys[index]['checked'] = false;
                                }
                            });
                            angular.forEach($scope.cate_classify, function (data, index, array) {
                                if (data.classify == 2) {
                                    $scope.cate_classify[index]['checked'] = boo;
                                } else {
                                    $scope.cate_classify[index]['checked'] = false;
                                }
                            });
                            break;
                    }
                    break;
            }
            $scope.getChartsData("", true);
        };
        $scope.ischeck = function () {
            $scope.getbrowser();//滚动条重新归为0，当用户发生此点击事件时，不管是选中还是不选中城市等级，页数都初始化为1
            if ($scope.typeValue) {
                $scope.typeValue = false;
                $scope.iscityleveltype = 'unchecked';
                document.getElementById("iscityLevel").style.display = "none";
                $scope.getChartsData('', true);
            } else {
                $scope.typeValue = true;
                $scope.iscityleveltype = 'ischecked';
                document.getElementById("iscityLevel").style.display = "";
                $scope.getChartsData('', true);
            }
        };
        $scope.ischeckGrading = function (level) {
            $scope.getbrowser();//滚动条重新归为0，当用户发生此点击事件时，不管是选中还是不选中容量分级和瓶量分级，页数都初始化为1
            switch (level) {
                case 1://容量分级
                    $scope.bottlecheck = false;
                    $scope.isbottle = 'unchecked';
                    if ($scope.capacitycheck) {
                        $scope.capacitycheck = false;
                        $scope.iscapacity = 'unchecked';
                        document.getElementById("isGrading").style.display = "none";
                        $scope.getChartsData('', true);
                    } else {
                        $scope.capacitycheck = true;
                        $scope.iscapacity = 'ischecked';
                        document.getElementById("isGrading").style.display = "";
                        $scope.getChartsData('', true);
                    }
                    break;
                case 2://瓶量分级
                    $scope.capacitycheck = false;
                    $scope.iscapacity = 'unchecked';
                    if ($scope.bottlecheck) {
                        $scope.bottlecheck = false;
                        $scope.isbottle = 'unchecked';
                        document.getElementById("isGrading").style.display = "none";
                        $scope.getChartsData('', true);
                    } else {
                        $scope.bottlecheck = true;
                        $scope.isbottle = 'ischecked';
                        document.getElementById("isGrading").style.display = "";
                        $scope.getChartsData('', true);
                    }
                    break;
            }
        };
        $scope.transverter = function () {
            switch ($scope.deepbrandcheck) {
                case 'manufacturer':
                    $scope.getSingle('', 'menu', 2);
                    break;
                case 'brand':
                    $scope.getSingle('', 'brand', 3);
                    break;
                case 'catalog':
                    $scope.getSingle('', 'category', 1);
                    break;
            }
        };
        $scope.selcity = '<?= Yii::t('cvs', '全国')?>';
        $scope.regionDisable = false;
        $scope.factoryDisable = false;
        $scope.cityDisable = false;
        $scope.cityLevelDisable = true;
        $scope.platformDisable = false;//平台
        $scope.cityLevelListDisable = false;
        $scope.catalogDisable = false;
        $scope.skuDisable = false;
        $scope.manufacturerDisable = false;
        $scope.capacityDisable = false;
        $scope.bottleDisable = false;
        $scope.systemDisable = false;
        $scope.selbrand = '全品类';
        $scope.selcapacity = '全容量';
        $scope.selbottle = '全瓶量';
        $scope.pieLeftid = 80;
        $scope.upperHalf = function (level) {
            switch (level) {
                case 1:    //装瓶集团
                    $scope.factory = "0";
                    $scope.city = "0";
                    if($scope.region == 1){
                        angular.forEach($scope.relations, function (data, index, array) {
                            if (data.depth == 1) {
                                $scope.relations[index]['checked'] = true;
                                $scope.relations[index]['show'] = true;
                            }else{
                                $scope.relations[index]['checked'] = false;
                                $scope.relations[index]['show'] = false;
                            }
                        });
                        angular.forEach($scope.relationss, function (data, index, array) {
                            if (data.depth == 1) {
                                $scope.relationss[index]['checked'] = true;
                                $scope.relationss[index]['show'] = true;
                            }else{
                                $scope.relationss[index]['checked'] = false;
                                $scope.relationss[index]['show'] = false;
                            }
                        });
                    }else{
                        // angular.forEach($scope.relations, function (data, index, array) {
                        //     if (data.depth == 2 && data.parent == $scope.region) {
                        //         $scope.relations[index]['checked'] = true;
                        //         $scope.relations[index]['show'] = true;
                        //     }else{
                        //         $scope.relations[index]['checked'] = false;
                        //         $scope.relations[index]['show'] = false;
                        //     }
                        // });
                        // angular.forEach($scope.relationss, function (data, index, array) {
                        //     if (data.depth == 2 && data.parent == $scope.region) {
                        //         $scope.relationss[index]['checked'] = true;
                        //         $scope.relationss[index]['show'] = true;
                        //     }else{
                        //         $scope.relationss[index]['checked'] = false;
                        //         $scope.relationss[index]['show'] = false;
                        //     }
                        // });

                        angular.forEach($scope.relations, function (data, index, array) {
                            if (data.id == $scope.region) {
                                $scope.relations[index]['checked'] = true;
                                $scope.relations[index]['show'] = true;
                            }else{
                                $scope.relations[index]['checked'] = false;
                                $scope.relations[index]['show'] = false;
                            }
                        });
                        angular.forEach($scope.relationss, function (data, index, array) {
                            if (data.id == $scope.region) {
                                $scope.relationss[index]['checked'] = true;
                                $scope.relationss[index]['show'] = true;
                            }else{
                                $scope.relationss[index]['checked'] = false;
                                $scope.relationss[index]['show'] = false;
                            }
                        });
                    }
                    break;
                case 2:  //装瓶厂
                    $scope.city = "0";
                    if($scope.factory == '0'){
                        if($scope.region == '1'){
                            angular.forEach($scope.relations, function (data, index, array) {
                                if (data.depth == 1) {
                                    $scope.relations[index]['checked'] = true;
                                    $scope.relations[index]['show'] = true;
                                }else{
                                    $scope.relations[index]['checked'] = false;
                                    $scope.relations[index]['show'] = false;
                                }
                            });
                            angular.forEach($scope.relationss, function (data, index, array) {
                                if (data.depth == 1) {
                                    $scope.relationss[index]['checked'] = true;
                                    $scope.relationss[index]['show'] = true;
                                }else{
                                    $scope.relationss[index]['checked'] = false;
                                    $scope.relationss[index]['show'] = false;
                                }
                            });
                        }else{
                            angular.forEach($scope.relations, function (data, index, array) {
                                if (data.depth == 1 && data.id == $scope.region) {
                                    $scope.relations[index]['checked'] = true;
                                    $scope.relations[index]['show'] = true;
                                }else{
                                    $scope.relations[index]['checked'] = false;
                                    $scope.relations[index]['show'] = false;
                                }
                            });
                            angular.forEach($scope.relationss, function (data, index, array) {
                                if (data.depth == 1 && data.id == $scope.region) {
                                    $scope.relationss[index]['checked'] = true;
                                    $scope.relationss[index]['show'] = true;
                                }else{
                                    $scope.relationss[index]['checked'] = false;
                                    $scope.relationss[index]['show'] = false;
                                }
                            });
                        }
                    }else{
                        angular.forEach($scope.relations, function (data, index, array) {
                            if (data.depth == 2 && data.id == $scope.factory) {
                                $scope.relations[index]['checked'] = true;
                                $scope.relations[index]['show'] = true;
                            }else{
                                $scope.relations[index]['checked'] = false;
                                $scope.relations[index]['show'] = false;
                            }
                        });
                        angular.forEach($scope.relationss, function (data, index, array) {
                            if (data.depth == 2 && data.id == $scope.factory) {
                                $scope.relationss[index]['checked'] = true;
                                $scope.relationss[index]['show'] = true;
                            }else{
                                $scope.relationss[index]['checked'] = false;
                                $scope.relationss[index]['show'] = false;
                            }
                        });
                    }
                    break;
                case 3:  //城市等级
                    if($scope.cityLevel =='0'){
                        angular.forEach($scope.cityLevelList,function(data,index,array){
                            $scope.cityLevelList[index]['checked'] = true;
                            $scope.cityLevelList[index]['show'] = true;
                        });
                    }else{
                        angular.forEach($scope.cityLevelList,function(data,index,array){
                            if(data.id == $scope.cityLevel){
                                $scope.cityLevelList[index]['checked'] = true;
                                $scope.cityLevelList[index]['show'] = true;
                            }else{
                                $scope.cityLevelList[index]['checked'] = false;
                                $scope.cityLevelList[index]['show'] = false;
                            }
                        });
                    }
                    break;
                case 4://城市
                    if($scope.city !='0'){//选中了某个城市
                        angular.forEach($scope.relations, function (data, index, array) {
                            if (data.id == $scope.city) {
                                $scope.relations[index]['checked'] = true;
                                $scope.relations[index]['show'] = true;
                            }else{
                                $scope.relations[index]['checked'] = false;
                                $scope.relations[index]['show'] = false;
                            }
                        });
                        angular.forEach($scope.relationss, function (data, index, array) {
                            if (data.id == $scope.city) {
                                $scope.relationss[index]['checked'] = true;
                                $scope.relationss[index]['show'] = true;
                            }else{
                                $scope.relationss[index]['checked'] = false;
                                $scope.relationss[index]['show'] = false;
                            }
                        });
                    }else{
                        if($scope.factory == '0'){
                            if($scope.region == 1){
                                angular.forEach($scope.relations, function (data, index, array) {
                                    if (data.depth == 1) {
                                        $scope.relations[index]['checked'] = true;
                                        $scope.relations[index]['show'] = true;
                                    }
                                });
                                angular.forEach($scope.relationss, function (data, index, array) {
                                    if (data.depth == 1) {
                                        $scope.relationss[index]['checked'] = true;
                                        $scope.relationss[index]['show'] = true;
                                    }
                                });
                            }else{
                                angular.forEach($scope.relations, function (data, index, array) {
                                    if (data.depth == 2 && data.parent == $scope.region) {
                                        $scope.relations[index]['checked'] = true;
                                        $scope.relations[index]['show'] = true;
                                    }
                                });
                                angular.forEach($scope.relationss, function (data, index, array) {
                                    if (data.depth == 2 && data.parent == $scope.region) {
                                        $scope.relationss[index]['checked'] = true;
                                        $scope.relationss[index]['show'] = true;
                                    }
                                });
                            }
                        }else{
                            angular.forEach($scope.relations, function (data, index, array) {
                                if (data.depth == 2 && data.id == $scope.factory) {
                                    $scope.relations[index]['checked'] = true;
                                    $scope.relations[index]['show'] = true;
                                }
                            });
                            angular.forEach($scope.relationss, function (data, index, array) {
                                if (data.depth == 2 && data.id == $scope.factory) {
                                    $scope.relationss[index]['checked'] = true;
                                    $scope.relationss[index]['show'] = true;
                                }
                            });
                        }
                    }
                    break;
                case 5://渠道
                    if($scope.systemtype =='0'){
                        angular.forEach($scope.systems,function(data,index,array){
                            $scope.systems[index]['checked'] = true;
                            $scope.systems[index]['show'] = true;
                        });
                    }else{
                        angular.forEach($scope.systems,function(data,index,array){
                            if(data.id == $scope.systemtype){
                                $scope.systems[index]['checked'] = true;
                                $scope.systems[index]['show'] = true;
                            }else{
                                $scope.systems[index]['checked'] = false;
                                $scope.systems[index]['show'] = false;
                            }
                        });
                    }
                    break;
                case 6://平台
                    if($scope.platform =='0'){
                        angular.forEach($scope.platforms,function(data,index,array){
                            $scope.platforms[index]['checked'] = true;
                            $scope.platforms[index]['show'] = true;
                        });
                    }else{
                        angular.forEach($scope.platforms,function(data,index,array){
                            if(data.id == $scope.platform){
                                $scope.platforms[index]['checked'] = true;
                                $scope.platforms[index]['show'] = true;
                            }else{
                                $scope.platforms[index]['checked'] = false;
                                $scope.platforms[index]['show'] = false;
                            }
                        });
                    }
                    break;
                case 7:
                    if($scope.category == '0'){
                        angular.forEach($scope.categoryList,function(data,index,array){
                            $scope.categoryList[index]['checked'] = true;
                            $scope.categoryList[index]['show'] = true;
                        });
                        angular.forEach($scope.categorys,function(data,index,array){
                            $scope.categorys[index]['checked'] = true;
                            $scope.categorys[index]['show'] = true;
                        });
                    }else{
                        angular.forEach($scope.categoryList,function(data,index,array){
                            if(data.id == $scope.category){
                                $scope.categoryList[index]['checked'] = true;
                                $scope.categoryList[index]['show'] = true;
                            }else{
                                $scope.categoryList[index]['checked'] = false;
                                $scope.categoryList[index]['show'] = false;
                            }
                        });
                        angular.forEach($scope.categorys,function(data,index,array){
                            if(data.id == $scope.category){
                                $scope.categorys[index]['checked'] = true;
                                $scope.categorys[index]['show'] = true;
                            }else{
                                $scope.categorys[index]['checked'] = false;
                                $scope.categorys[index]['show'] = false;
                            }
                        });
                    }
                    break;
                case 8: //期数
                    $scope.getTotalData($scope.stage);
                    break;
            }
            console.log($scope.relations,$scope.relationss);
            if ($scope.city != '0') {
                $scope.deepgroupcheck = "city";
                $scope.factoryDisable = true;
                $scope.regionDisable = true;
                $scope.cityDisable = false;
                $scope.selcity = $('#Search_city').find('option[value=' + $scope.city + ']').html();
            } else if ($scope.factory != '0') {
                // $scope.deepgroupcheck = "city";//城市
                // $scope.regionDisable = true;
                // $scope.factoryDisable = true;
                // $scope.cityDisable = false;

                $scope.deepgroupcheck = "factory";//装瓶厂
                $scope.regionDisable = true;
                $scope.factoryDisable = false;
                $scope.selcity = $('#Search_factory').find('option[value=' + $scope.factory + ']').html();
            } else if ($scope.region != '1') {
                // $scope.regionDisable = true;
                // $scope.factoryDisable = false;
                // $scope.cityDisable = false;
                //$scope.deepgroupcheck = "factory";//装瓶厂
                $scope.regionDisable = false;
                $scope.factoryDisable = false;
                $scope.cityDisable = false;
                $scope.deepgroupcheck = "group";//装瓶厂
                $scope.selcity = $('#Search_region').find('option[value=' + $scope.region + ']').html();
            } else {
                $scope.regionDisable = false;
                $scope.factoryDisable = false;
                $scope.cityDisable = false;
                $scope.deepgroupcheck = "group"; //装瓶集团
                $scope.selcity = '<?= Yii::t('cvs', '全国')?>';
            }
            if($scope.category !='0'){
                $scope.deepbrandcheck = 'catalog';
                $scope.catalogDisable = false;
            }else{
                $scope.deepbrandcheck = 'catalog';
                $scope.catalogDisable = false;
            }
        };
        $scope.onoptionchange = function (level) {
            $('.map-men2').show();
            $scope.upperHalf(level);
            let config = {
                'region': $scope.region,//装瓶集团
                'factory': $scope.factory,//装瓶厂
                'cityLevel': $scope.cityLevel,//城市等级
                'city': $scope.city,//城市
                'systemtype': $scope.systemtype,//渠道
                'platform': $scope.platform,//平台
                'category': $scope.category,//品类
                'month': $scope.month,//月份
                'stage': $scope.stage//期数
            };
            $http({
                url: '<?php echo $this->createurl("site/getretaildata"); ?>',
                params: config
            }).success(function (response) {
                console.log("成功返回数据：", response);
                $scope.kopciinfos = response.kopciinfos;   //饼图数据
                $scope.pieData = response.pieData;   //饼图数据2019.6.11
                $scope.koinfosPlarn = response.koinfosPlarn;   //左侧进度条数据
                $scope.koinfosPlarns = response.koinfosPlarns;   //右侧进度条数据
                $scope.koinfos = response.koinfos;  //地图用的数据
                $scope.koinfoss = response.koinfoss;  //地图用的数据
                //console.log("$scope.koinfos:",$scope.koinfos);
                //console.log("$scope.koinfoss:",$scope.koinfoss);
                <!--                    --><?php //$datas['koinfos']?>
                <!--                    --><?php //$datas['koinfoss']?>
                $scope.labels = response.labels;
                $scope.lastlabel = response.lastlabel;
                $scope.rank = response.rank;//排行数据
                $scope.groupInfo = response.groupInfo;
                $('.map-men2').hide();
                $scope.pieLeftid = 80;
                if ($scope.SKU != 0) {
                    $scope.pieLeftid = $scope.SKU;
                } else if ($scope.brand != 0) {
                    $scope.pieLeftid = $scope.brand;
                } else if ($scope.category != 0) {
                    $scope.pieLeftid = $scope.category;
                }
                pieChartsChange();
            }).error(function (data, header, config, status) {
                $('.map-men2').hide();
            });
            $scope.getChartsData("", true);
        };
        $scope.ytd = false;    //header按钮，控制header显示YTD还是最新一期
        $scope.ytdChange = function (i) {
            if (i == 0) {
                $scope.ytd = false;
                $scope.getTotalData($scope.stage);  // -1 YTD，最新一期
            } else if (i == 1) {
                $scope.ytd = true;
                $scope.getTotalData(-1);
            }
        }
        $scope.getTotalData = function (stage) {
            $("#myselect").find("option").prop("selected", false);
            if (stage == 0) {//月值（VS LM）
                $("#myselect").find("option[value='0']").prop("selected", true);
            } else if (stage == -1) {//YTD（VS LY）
                $("#myselect").find("option[value='-1']").prop("selected", true);
            }
            let _params = {
                stage: stage,
                month: $scope.month,
                mstage: $scope.stage,
            }
            $http({
                url: '<?php echo $this->createurl("site/hearderRetail"); ?>',
                params: _params
            }).success(function (res) {
                console.log('totalfixed', res);
                $scope.totalfixed = [res];
            }).error(function (data, header, config, status) {

            });
        }
        //改变$scope.deepbrandcheck的值
        $scope.deepbrandcheckChang = function (fig) {
            switch (fig) {
                case 1:
                    $scope.deepbrandcheck = 'catalog';
                    $scope.total = $scope.categoryList;
                    break;
                case 2:
                    $scope.deepbrandcheck = 'manufacturer';
                    $scope.total = $scope.menuList;
                    break;
                case 3:
                    $scope.deepbrandcheck = 'brand';
                    $scope.total = $scope.brandList;
                    break;
            }
        };
        $scope.getChartsData = function (fig, removeData) {
            // $('#chart-view').append("<div class='mb-fff'></div>");
            if (fig != "") {
                $scope.deepbrandcheckChang(fig);//改变$scope.deepbrandcheck的值
            }
            $scope.getTotal();
            if ($scope.history[$scope.visitab] == 1) {
                $scope.getLineData(removeData);
            } else {
                console.log('iiiii');
                $scope.getBarData(removeData);
            }
        };
        $scope.getPageSize = function () {
            $scope.pageArr = [];
            if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {//选中容量分级
                angular.forEach($scope.cate_classifys, function (data, index, array) {
                    if (data.classify == 1 && data.checked == 1) {//选中
                        $scope.pageArr.push(data);
                    }
                });
            } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {//选中瓶量分级
                angular.forEach($scope.cate_classifys, function (data, index, array) {
                    if (data.classify == 2 && data.checked == 1) {//选中
                        $scope.pageArr.push(data);
                    }
                });
            }else{
                switch ($scope.deepbrandcheck) {
                    case 'manufacturer':
                        angular.forEach($scope.menuList, function (data, index, array) {
                            if (data.checked == 1) {//选中
                                $scope.pageArr.push(data);
                            }
                        });
                        break;
                    case 'brand':
                        angular.forEach($scope.brandList, function (data, index, array) {
                            if (data.checked == 1) {//选中
                                $scope.pageArr.push(data);
                            }
                        });
                        break;
                    case 'catalog' :
                        angular.forEach($scope.categoryList, function (data, index, array) {
                            if (data.checked == 1) {//选中
                                $scope.pageArr.push(data);
                            }
                        });
                        break;
                }
            }
            $scope.pageNum = $scope.pageArr.length;
        };
        $scope.getTotalId = function () {
            $scope.relationsArr = $scope.getRelationId();//区域
            $scope.cityLevelsArr = $scope.getIdData($scope.cityLevelList);//城市等级
            $scope.systemsArr = $scope.getIdData($scope.systems);//渠道
            $scope.platformsArr = $scope.getIdData($scope.platforms);//平台
            switch ($scope.deepbrandcheck) {
                case "catalog":
                    $scope.categorysArr = $scope.getIdData($scope.categoryList);//品类
                    $scope.menusArr = 1;//制造商
                    $scope.brandsArr = 1;//品牌
                    break;
                case "manufacturer":
                    $scope.categorysArr = 1;//品类
                    $scope.menusArr = $scope.getIdData($scope.menuList);//制造商
                    $scope.brandsArr = 1;//品牌
                    break;
                case "brand":
                    $scope.categorysArr = 1;//品类
                    $scope.menusArr = 1;//制造商
                    $scope.brandsArr = $scope.getIdData($scope.brandList);//品牌
                    break;
            }
            $scope.capacitysArr = ($scope.iscapacity == 'ischecked') ? ($scope.getIdData($scope.cate_classifys)) : 1;//容量分级
            $scope.bottlesArr = ($scope.isbottle == 'ischecked') ? ($scope.getIdData($scope.cate_classifys)) : 8;//瓶量分级
            // console.log("$scope.relationsArr:",$scope.relationsArr);
            // console.log("$scope.cityLevelList:",$scope.cityLevelsArr);
            // console.log("$scope.systemsArr:",$scope.systemsArr);
            // console.log("$scope.platformsArr:",$scope.platformsArr);
            // console.log("$scope.categorysArr:",$scope.categorysArr);
            // console.log("$scope.menusArr:",$scope.menusArr);
            // console.log("$scope.brandsArr:",$scope.brandsArr);
            // console.log("$scope.capacitysArr:",$scope.capacitysArr);
            // console.log("$scope.bottlesArr:",$scope.bottlesArr);
        };
        $scope.getRelationId = function(){
            $scope.TotalArr = "";
            switch($scope.deepgroupcheck){
                case 'group':
                    angular.forEach($scope.relations,function(data,index,array){
                        if(data.depth == 1 && data.checked == 1){
                            $scope.TotalArr += ($scope.TotalArr == "" ? "" : "_") + data.id;
                        }
                    });
                    break;
                case 'factory':
                    angular.forEach($scope.relations,function(data,index,array){
                        if(data.depth == 2 && data.checked == 1){
                            $scope.TotalArr += ($scope.TotalArr == "" ? "" : "_") + data.id;
                        }
                    });
                    break;
                case 'city':
                    angular.forEach($scope.relations,function(data,index,array){
                        if(data.depth == 3 && data.checked == 1){
                            $scope.TotalArr += ($scope.TotalArr == "" ? "" : "_") + data.id;
                        }
                    });
                    break;
            }
            return $scope.TotalArr;
        };
        $scope.getIdData = function (idArr) {
            // console.log("idArr:",idArr);
            $scope.TotalArr = "";
            angular.forEach(idArr, function (data, index, array) {
                if (data.checked == 1) {//选中
                    $scope.TotalArr += ($scope.TotalArr == "" ? "" : "_") + data.id;
                }
            });
            return $scope.TotalArr;
        };
        $scope.getBarData = function (removeData) {
            $('#chart-view').append("<div class='mb-fff'></div>");
            $scope.getPageSize();
            $scope.getTotalId();//获取区域checked项的id
            if(removeData){
                $scope.emptyData();//置空变量数据
            }
            console.log("$scope.deepgroupcheck:", $scope.deepgroupcheck);
            console.log("$scope.deepbrandcheck:", $scope.deepbrandcheck);
            console.log("$scope.pageNum:", $scope.pageNum,$scope.pageNumber);
            let citytype = $scope.deepgroupcheck == 'group' ? 1 : $scope.deepgroupcheck == 'factory' ? 2 : $scope.deepgroupcheck == 'city' ? 3 : null;
            let systemtype = $scope.deepsystemcheck == 'systemtype' ? 1 : $scope.deepsystemcheck == 'system' ? 2 : null;
            let skutype = $scope.deepbrandcheck == 'catalog' ? 1 : $scope.deepbrandcheck == 'manufacturer' ? 2 : $scope.deepbrandcheck == 'brand' ? 3 : null;
            let platform = $scope.deepplatformcheck == 'platform' ? 1 : null;
            let iscityleveltype = $scope.deepcityLevelcheck == 'cityLevel' ? 1 : 0;
            let isgrading = ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') ? 1 : ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') ? 2 : 0;
            let kpichecked = $scope.kpichecked;
            let pageNum = $scope.pageNum;//每个图表显示多少条数据
            let pageNumber = $scope.pageNumber;
            $scope.isGather = isgrading;
            let config = {
                'citytype': citytype,
                'systemtype': systemtype,
                'skutype': skutype,
                'platform': platform,
                'month': $scope.month,
                'stage': $scope.stage,
                'iscityleveltype': iscityleveltype,
                'isgrading': isgrading,
                'kpichecked': kpichecked,
                'pageNum': pageNum,//每个图表请求多少条数据
                'pageNumber': pageNumber,//在查询的全部数据中处于第几页
                'removeCache': removeData,//是否清理上次请求的数据
                'relationsArr': $scope.relationsArr,//区域字符串
                'cityLevelsArr': $scope.cityLevelsArr,//区域字符串
                'systemsArr': $scope.systemsArr,//渠道字符串
                'platformsArr': $scope.platformsArr,//平台字符串
                'categorysArr': $scope.categorysArr,//品类字符串
                'menusArr': $scope.menusArr,//制造商字符串
                'brandsArr': $scope.brandsArr,//品牌字符串
                'capacitysArr': $scope.capacitysArr,//容量分级字符串
                'bottlesArr': $scope.bottlesArr//瓶量分级字符串
            };
            $('#chart-view').append("<div class='mb-fff'></div>");
            $http({
                url: '<?php echo $this->createurl("site/retailData"); ?>',
                params: config
            }).success(function (res) {
                // $scope.visitab = $scope.visitab3;
                $scope.allskuinfos = $scope.gather($scope.allskuinfos,res);//汇总每次分批传递过来的数据
                $('.mb-fff').remove();
                console.log('柱图/双拼图数据', $scope.allskuinfos);
                //$scope.allskuinfos2 = JSON.parse(JSON.stringify($scope.allskuinfos));  //备份，打乱排序使用
                //angular.forEach($scope.allskuinfos2.bar, function (data, index, array) {
                // $scope.allskuinfos2.bar[index].skus.reverse();
                // });
                //console.log("正负轴柱状图", $scope.allskuinfos2);

                // $scope.allskuinfos = res;//allskuinfos.bar
                // console.log('堆叠柱图/双拼图数据', $scope.allskuinfos);
                // $scope.allskuinfos2 = JSON.parse(JSON.stringify($scope.allskuinfos));  //备份，打乱排序使用
                // angular.forEach($scope.allskuinfos2.bar,function(data,index,array){
                //     $scope.allskuinfos2.bar[index].skus.reverse();
                // });
                // console.log("正负轴柱状图",$scope.allskuinfos2);
                $('.mb-fff').remove();
            }).error(function (data, header, config, status) {
                $('.mb-fff').remove();
            });

        };
        //置空数据
        $scope.emptyData = function(){
            $scope.allskuinfos = "";
            $scope.allskuinfos2 = "";
            $scope.all_skuinfos = "";
        };
        //汇总数据
        $scope.gather = function (oldData,res) {
            if (oldData == "") {
                oldData = res;
            } else {
                switch ($scope.isGather) {
                    case 1:
                        angular.forEach(oldData['bar'], function (data, index, array) {
                            angular.forEach(res['bar'], function (sdata, sindex, array) {
                                if ((data['relation']['id'] == sdata['relation']['id']) && (data['cityLevel']['id'] == sdata['cityLevel']['id'])
                                    && (data['system']['id'] == sdata['system']['id']) && (data['platform']['id'] == sdata['platform']['id'])
                                    && (data['bottle']['id'] == sdata['bottle']['id']) && (data['skuname']['id'] == sdata['skuname']['id'])) {
                                    angular.forEach(sdata['skus'], function (tdata, tindex, array) {
                                        oldData['bar'][index]['skus'].push(res['bar'][sindex]['skus'][tindex]);
                                    });
                                    res['bar'].splice(sindex, 1);
                                }
                            });
                        });
                        angular.forEach(res['bar'], function (data, index, array) {
                            oldData['bar'].push(data);
                        });
                        break;
                    case 2:
                        angular.forEach(oldData['bar'], function (data, index, array) {
                            angular.forEach(res['bar'], function (sdata, sindex, array) {
                                if ((data['relation']['id'] == sdata['relation']['id']) && (data['cityLevel']['id'] == sdata['cityLevel']['id'])
                                    && (data['system']['id'] == sdata['system']['id']) && (data['platform']['id'] == sdata['platform']['id'])
                                    && (data['capacity']['id'] == sdata['capacity']['id']) && (data['skuname']['id'] == sdata['skuname']['id'])) {
                                    angular.forEach(sdata['skus'], function (tdata, tindex, array) {
                                        oldData['bar'][index]['skus'].push(res['bar'][sindex]['skus'][tindex]);
                                    });
                                    res['bar'].splice(sindex, 1);
                                }
                            });
                        });
                        angular.forEach(res['bar'], function (data, index, array) {
                            oldData['bar'].push(data);
                        });
                        break;
                    case 0:
                        angular.forEach(oldData['bar'], function (data, index, array) {
                            angular.forEach(res['bar'], function (sdata, sindex, array) {
                                if ((data['relation']['id'] == sdata['relation']['id']) && (data['cityLevel']['id'] == sdata['cityLevel']['id'])
                                    && (data['system']['id'] == sdata['system']['id']) && (data['platform']['id'] == sdata['platform']['id'])
                                    && (data['capacity']['id'] == sdata['capacity']['id']) && (data['bottle']['id'] == sdata['bottle']['id'])) {
                                    angular.forEach(sdata['skus'], function (tdata, tindex, array) {
                                        oldData['bar'][index]['skus'].push(res['bar'][sindex]['skus'][tindex]);
                                    });
                                    res['bar'].splice(sindex, 1);
                                }
                            });
                        });
                        angular.forEach(res['bar'], function (data, index, array) {
                            oldData['bar'].push(data);
                        });
                        break;
                }
                if(typeof(res['stackbar']) !="undefined"){
                    oldData['stackbar']['relations'] = $scope.uniqueGather(oldData['stackbar']['relations'], (typeof(res['stackbar']['relations']) ==="undefined" ? []: res['stackbar']['relations']));
                    oldData['stackbar']['cityLevel'] = $scope.uniqueGather(oldData['stackbar']['cityLevel'], (typeof(res['stackbar']['cityLevel']) ==="undefined"?[]:res['stackbar']['cityLevel']));
                    oldData['stackbar']['systems'] = $scope.uniqueGather(oldData['stackbar']['systems'], (typeof(res['stackbar']['systems']) ==="undefined" ? []: res['stackbar']['systems']));
                    oldData['stackbar']['platforms'] = $scope.uniqueGather(oldData['stackbar']['platforms'], (typeof(res['stackbar']['platforms']) ==="undefined" ? []:res['stackbar']['platforms'])) ;
                    oldData['stackbar']['skuname'] = $scope.uniqueGather(oldData['stackbar']['skuname'], (typeof(res['stackbar']['skuname']) ==="undefined" ? []: res['stackbar']['skuname']));
                    oldData['stackbar']['capacity'] = $scope.uniqueGather(oldData['stackbar']['capacity'], (typeof(res['stackbar']['capacity']) ==="undefined" ? []: res['stackbar']['capacity']));
                    oldData['stackbar']['capacity'] = $scope.uniqueGather(oldData['stackbar']['bottle'], (typeof(res['stackbar']['bottle']) ==="undefined" ? []: res['stackbar']['bottle']));
                    angular.forEach(oldData['stackbar']['skus'], function (data, index, array) {
                        angular.forEach(res['stackbar']['skus'], function (sdata, sindex, array) {
                            if (index == sindex) {
                                angular.forEach(sdata, function (kdata, kindex, array) {
                                    oldData['stackbar']['skus'][sindex].push(kdata);
                                });
                            }
                        });
                    });
                }
            }
            return oldData;
        };
        $scope.uniqueGather = function (arr1=[], arr2=[]) {
            if(arr2 != []){
                angular.forEach(arr2, function (sdata, sindex, array) {
                    arr1[sindex] = sdata
                });
            }
            return arr1;
        };
        $scope.getChartsData(1, true);
        $scope.exportExcel = function () {
            window.location.href = "<?php echo Yii::app()->createUrl('site/excel') ?>" + "?region=" + $scope.region + "&factory=" + $scope.factory + "&city=" + $scope.city + "&cityLevel=" + $scope.cityLevel + "&month=" + $scope.month + "&category=" + $scope.category + "&capacity=" + $scope.capacity + "&bottle=" + $scope.bottle + "&brand=" + $scope.brand + "&mode=" + $scope.SKU + "&stage=" + $scope.stage + "&systemtype=" + $scope.systemtype + "&system=" + $scope.system;
        }
        $scope.compare = function (i, property, zheng) {   //柱状图的排序功能
            if (zheng == 1) {
                return function (a, b) {
                    return a[i][property] - b[i][property];
                }
            } else {
                return function (a, b) {
                    return b[i][property] - a[i][property];
                }
            }
        }
        $scope.nosort = '<?= Yii::t('cvs', '排序');?>';
        $scope.nocompare = true;
        $scope.chartsSort = function () {
            if ($scope.nocompare) {
                angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                    $scope.allskuinfos.bar[index].skus.sort($scope.compare('1', $scope.kpi, 0));
                });
                // angular.forEach($scope.allskuinfos2.bar, function (data, index, array) {
                //     $scope.allskuinfos2.bar[index].skus.sort($scope.compare('1', $scope.kpi, 1));
                //});
                $scope.nocompare = false;
                $scope.nosort = '<?= Yii::t('cvs', '取消排序');?>';
            } else {
                angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                    $scope.allskuinfos.bar[index].skus.sort($scope.compare('0', 'sequence', 1));
                });
                // angular.forEach($scope.allskuinfos2.bar, function (data, index, array) {
                //     $scope.allskuinfos2.bar[index].skus.sort($scope.compare('0', 'sequence', 0));
                // });
                $scope.nocompare = true;
                $scope.nosort = '<?= Yii::t('cvs', '排序');?>';
            }
        };
        $scope.resetFilter = function () {
            $scope.region = "1";//区域
            $scope.factory = "0";//装瓶厂
            $scope.cityLevel = "0";//城市等级
            $scope.cityLevelList = "0";
            $scope.city = "0";//城市
            $scope.systemtype = '0';//渠道
            $scope.platform = '0';//平台
            $scope.category = "0";  //品类
            $scope.capacity = "0";  //容量分级
            $scope.bottle = "0";  //瓶量分级
            $scope.manufacturer = "0";  //制造商
            $scope.brand = "0";  //品牌
            $scope.SKU = "0";  //sku
            $scope.bottle = "0";  //bottle
            $scope.system = '0';
            $scope.deepgroupcheck = 'group';
            $scope.deepbrandcheck = 'catalog';
            $scope.deepsystemcheck = 'systemtype';
            $scope.deepbrandcheck2 = '';
            $scope.deepsystemcheck2 = '';
            $scope.onoptionchange();
        }
        //懒加载单个请求数据
        $scope.radioEvents = function (type, id) {
            $scope.getbrowser();//滚动条重新归为0,当用户发生此点击事件时，页数都初始化为1
            switch (type) {
                case "region": //区域
                    $scope.chgcheck(id);//区域
                    // console.log('单选区域事件:',$scope.relations);
                    break;
                case "cityLevel": //城市等级
                    $scope.citylevelchk(id);
                    // console.log('单选城市等级事件:',$scope.cityLevelList);
                    break;
                case "system"://渠道
                    $scope.syschgcheck(id);
                    // console.log('单选渠道事件:',$scope.systems);
                    break;
                case "platform"://平台
                    $scope.platformcheck(id);
                    // console.log('单选平台事件:',$scope.platforms);
                    break;
                case "category"://品类
                    $scope.skuchgcheck(id, type);
                    // console.log('单选品类事件:',$scope.categoryList);
                    break;
                case "menu"://制造商
                    $scope.skuchgcheck(id, type);
                    // console.log('单选制造商事件:',$scope.menuList);
                    break;
                case "brand"://品牌
                    $scope.skuchgcheck(id, type);
                    // console.log('单选品牌事件:',$scope.brandList);
                    break;
                case "capacity"://容量分级
                    $scope.gradingchgcheck(id);
                    // console.log('单选容量分级事件:',$scope.cate_classifys);
                    break;
                case "bottle"://瓶量分级
                    $scope.gradingchgcheck(id);
                    // console.log('单选瓶量分级事件:',$scope.cate_classifys);
                    break;
            }
            $scope.getChartsData('', true);
        };
        //切换时滚动条到达顶部或者左边
        $scope.getbrowser = function() {
            $scope.pageNumber = 1;//第一页(本期值、变化率)
            document.getElementsByClassName("up-down").scrollTop = 0;//上下滚动条到达最顶部
            document.getElementsByClassName("left-right").scrollLeft = 0;//左右滚动条到达最左边
        };

        $scope.setBlendOption = function (kpiname, comparName) {
            var kpi = 0;
            var comparKpi = 0;
            if ($scope.pieData.ko == null) {
                switch (kpiname) {
                    case "pie1":
                        $scope.pie1.series[0].data = [kpi, 1 - kpi];
                        $scope.pie1.tooltip.formatter = comparName + '<img src="<?=Yii::app()->request->baseUrl . '/images/plaint.png';?>" title="该数据范围内网店数（不同平台之间未打通，即1家线下门店在3个平台上线算3家网店）" class="rulePng">' + '：' + comparKpi;
                        return $scope.pie1;
                        break;
                    case "pie2":
                        $scope.pie2.series[0].data = [kpi, 1 - kpi];
                        $scope.pie2.tooltip.formatter = comparName + '<img src="<?=Yii::app()->request->baseUrl . '/images/plaint.png';?>" title="该数据范围内线上在售任一产品网店数" class="rulePng">' + '：' + comparKpi;
                        return $scope.pie2;
                        break;
                    case "pie3":
                        $scope.pie3.series[0].data = [kpi, 1 - kpi];
                        $scope.pie3.tooltip.formatter = comparName + '<img src="<?=Yii::app()->request->baseUrl . '/images/plaint.png';?>" title="该数据范围内每一产品销售件数乘以实际销售价格（含折扣、特价，不含红包、立减、满减）乘积的总和" class="rulePng">' + '：' + comparKpi;
                        return $scope.pie3;
                        break;
                    case "pie4":
                        $scope.pie4.series[0].data = [kpi, 1 - kpi];
                        $scope.pie4.tooltip.formatter = comparName + '<img src="<?=Yii::app()->request->baseUrl . '/images/plaint.png';?>" title="该数据范围内每一产品销售件数的总和" class="rulePng">' + '：' + comparKpi;
                        return $scope.pie4;
                        break;
                }
            } else {
                switch (kpiname) {
                    case "pie1":
                        kpi = $scope.pieData.nartd.enrollment == null ? 0 : $scope.pieData.nartd.enrollment;//网店上线率
                        comparKpi = $scope.pieData.nartd.online_stores == null ? 0 : $scope.conversion(Math.floor($scope.pieData.nartd.online_stores));//网店数
                        $scope.pie1.series[0].data = [kpi, 1 - kpi];
                        //$scope.pie1.tooltip.formatter = comparName + '<img src="<?//=Yii::app()->request->baseUrl . '/images/plaint.png';?>//" title="该数据范围内网店数（不同平台之间未打通，即1家线下门店在3个平台上线算3家网店）" class="rulePng">' + '：' + comparKpi;
                        $scope.pie1.series[0].tooltip.formatter = '网店数<img src="<?=Yii::app()->request->baseUrl . '/images/plaint.png';?>" title="该数据范围内网店数（不同平台之间未打通，即1家线下门店在3个平台上线算3家网店）" class="rulePng">：'+ comparKpi+'<br/>网店上线率：'+(kpi*100).toFixed(1)+'%';
                        return $scope.pie1;
                        break;
                    case "pie2":
                        kpi = $scope.pieData.ko.distribution == null ? 0 : $scope.pieData.ko.distribution;//ko铺货率
                        comparKpi = $scope.pieData.ko.distribution_store == null ? 0 : $scope.conversion(Math.floor($scope.pieData.ko.distribution_store));//铺货网店数
                        $scope.pie2.series[0].data = [kpi, 1 - kpi];
                        //$scope.pie2.tooltip[0].formatter = comparName + '<img src="<?//=Yii::app()->request->baseUrl . '/images/plaint.png';?>//" title="该数据范围内线上在售任一产品网店数" class="rulePng">' + '：' + comparKpi;
                        $scope.pie2.series[0].tooltip.formatter = '铺货网店数<img src="<?=Yii::app()->request->baseUrl . '/images/plaint.png';?>" title="该数据范围内线上在售任一KO产品的网店数" class="rulePng">：'+ comparKpi+'<br/>KO铺货率：'+(kpi*100).toFixed(1)+'%';
                        return $scope.pie2;
                        break;
                    case "pie3":
                        kpi = $scope.pieData.ko.sales_share == null ? 0 : $scope.pieData.ko.sales_share;//KO销售金额份额
                        comparKpi = $scope.pieData.ko.saleroom == null ? 0 : $scope.conversion(Math.floor($scope.pieData.ko.saleroom));//销售金额
                        $scope.pie3.series[0].data = [kpi, 1 - kpi];
                        //$scope.pie3.tooltip.formatter = comparName + '<img src="<?//=Yii::app()->request->baseUrl . '/images/plaint.png';?>//" title="该数据范围内每一产品销售件数乘以实际销售价格（含折扣、特价，不含红包、立减、满减）乘积的总和" class="rulePng">' + '：' + comparKpi;
                        $scope.pie3.series[0].tooltip.formatter = '销售金额(元)<img src="<?=Yii::app()->request->baseUrl . '/images/plaint.png';?>" title="该该数据范围内每一KO产品销售件数乘以实际销售价格（含折扣、特价，不含红包、立减、满减）乘积的总和" class="rulePng">：'+ comparKpi+'<br/>KO销售金额份额：'+(kpi*100).toFixed(1)+'%';
                        return $scope.pie3;
                        break;
                    case "pie4":
                        kpi = $scope.pieData.ko.sales_quota == null ? 0 : $scope.pieData.ko.sales_quota;//销售件数份额
                        comparKpi = $scope.pieData.ko.sales_numbers == null ? 0 : $scope.conversion(Math.floor($scope.pieData.ko.sales_numbers));//销售件数
                        $scope.pie4.series[0].data = [kpi, 1 - kpi];
                        //$scope.pie4.tooltip.formatter = comparName + '<img src="<?//=Yii::app()->request->baseUrl . '/images/plaint.png';?>//" title="该数据范围内每一产品销售件数的总和" class="rulePng">' + '：' + comparKpi;
                        $scope.pie4.series[0].tooltip.formatter = '销售件数(件)<img src="<?=Yii::app()->request->baseUrl . '/images/plaint.png';?>" title="该数据范围内每一KO产品销售件数的总和" class="rulePng">：'+ comparKpi+'<br/>KO销售件数份额：'+(kpi*100).toFixed(1)+'%';
                        return $scope.pie4;
                        break;
                }
            }
        };

        $scope.conversion = function (num) {
            var parts = num.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return parts.join(".");
        };

        $scope.setpieoption = function (val) {
            if (!val) {
                val = 0.01;
            }

            $scope.pie1.series[0].data = [val, 1 - val];
            return $scope.pie1;
        }

        //正负轴柱状图
        /**
         * 第一种：用angularjs指令的方式去显示正负轴柱状图（本期值和变化率）
         */
        $scope.$on('ngRepeatBar', function (ngRepeatBarEvent) {
            angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                var myChart = echarts.init(document.getElementById("barchart"+index));
                // 指定图表的配置项和数据
                var option = $scope.baroption;
                $scope.setBarOptionFinished(data);
                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);
            });
        });
        $scope.setBarOptionFinished = function(data){
            var labelRight = {
                normal: {
                    color: '#363636',
                    position: 'left'
                }
            };
            $scope.newskus = [];
            var kpi = $scope.optionKpi;
            switch ($scope.deepbrandcheck) {
                case "catalog":
                    angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.cityLevelList[subdata[1].cityLevel_id].checked && $scope.platforms[subdata[1].platform_id].checked && $scope.total[subdata[1].category_id].checked) {
                                $scope.newskus.push(parseFloat(subdata[1][kpi]));
                            }
                        });
                    });
                    break;
                case "manufacturer":
                    angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.cityLevelList[subdata[1].cityLevel_id].checked && $scope.platforms[subdata[1].platform_id].checked && $scope.total[subdata[1].menu_id].checked) {
                                $scope.newskus.push(parseFloat(subdata[1][kpi]));
                            }
                        });
                    });
                    break;
                case "brand":
                    angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.cityLevelList[subdata[1].cityLevel_id].checked && $scope.platforms[subdata[1].platform_id].checked && $scope.total[subdata[1].brand_id].checked) {
                                $scope.newskus.push(parseFloat(subdata[1][kpi]));
                            }
                        });
                    });
                    break;
            }
            if (Math.min.apply(null, $scope.newskus) > 0) {
                $scope.baroption.grid.left = "15%";
            } else {
                $scope.baroption.grid.left = "10%";
            }
            $scope.baroption.xAxis.max = (Math.max.apply(null, $scope.newskus) * 100).toFixed(0);
            $scope.baroption.xAxis.min = Math.min(0, Math.min.apply(null, $scope.newskus)) * 100;
            $scope.barIdx = 0;
            if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {//未选中容量分级和瓶量分级
                $scope.baroption.title.text = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name;
            } else {
                $scope.baroption.title.text = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name + ' - ' + data.skuname.name;
            }
            $scope.setBarCapacity(data, $scope.optionKpi,$scope.optionLastKpi, $scope.newskus, labelRight);
        }
        /**
         * 第二种方法：使用ng-echarts（注意：由于ng-echarts机制问题必须先设定空值，否则会多出很多数据）
         * @param kpi
         * @param lastkpi
         * @param rid
         * @param min
         * @param max
         * @param sid
         * @param pid
         * @param cid
         * @param skuid
         * @returns {{legend: {itemWidth: number, itemHeight: number, icon: string, data: Array, selected: {}}, toolbox: {right: number, feature: {saveAsImage: {}, myExcel: {show: boolean, title: string, icon: string, onclick: onclick}}, iconStyle: {textPosition: string}}, title: {text: string, subtext: string, sublink: string}, tooltip: {trigger: string, axisPointer: {type: string}, formatter: string}, grid: {top: number, bottom: number, containLabel: boolean, left: string, right: string}, xAxis: {type: string, position: string, max: number, min: number, boundaryGap: number[], splitLine: {show: boolean}, axisLabel: {formatter: string}}, yAxis: {type: string, inverse: boolean, axisLine: {show: boolean}, axisLabel: {show: boolean}, axisTick: {show: boolean}, splitLine: {show: boolean}, data: Array}, series: *[]}|*}
         */
        $scope.setbaroption = function (kpi,lastkpi, rid, min, max, sid, pid, cid, skuid) {
            $scope.kpi = kpi;
            $scope.barIdx = 0;
            var labelRight = {
                normal: {
                    color: '#363636',
                    position: 'left'
                }
            };
            $scope.newskus = [];
            switch ($scope.deepbrandcheck) {
                case "catalog":
                    angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.cityLevelList[subdata[1].cityLevel_id].checked && $scope.platforms[subdata[1].platform_id].checked && $scope.total[subdata[1].category_id].checked) {
                                $scope.newskus.push(parseFloat(subdata[1][kpi]));
                            }
                        });
                    });
                    break;
                case "manufacturer":
                    angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.cityLevelList[subdata[1].cityLevel_id].checked && $scope.platforms[subdata[1].platform_id].checked && $scope.total[subdata[1].menu_id].checked) {
                                $scope.newskus.push(parseFloat(subdata[1][kpi]));
                            }
                        });
                    });
                    break;
                case "brand":
                    angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.cityLevelList[subdata[1].cityLevel_id].checked && $scope.platforms[subdata[1].platform_id].checked && $scope.total[subdata[1].brand_id].checked) {
                                $scope.newskus.push(parseFloat(subdata[1][kpi]));
                            }
                        });
                    });
                    break;
            }
            // if (Math.min.apply(null, $scope.newskus) > 0) {
            //     $scope.baroption.grid.left = "15%";
            // } else {
            //     $scope.baroption.grid.left = "10%";
            // }
            // $scope.baroption.color = $scope.colors;
            if((Math.max.apply(null,$scope.newskus)) <= 1){//率
                $scope.baroption.tooltip = {
                    trigger: 'axis',
                    axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                        type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    },
                    formatter: function (params, ticket, callback) {
                        var htmlStr = '';
                        for(var i=0;i<params.length;i++){
                            var param = params[i];
                            var xName = param.name;//x轴的名称
                            var seriesName = param.seriesName;//图例名称
                            var value = param.value;//y轴值
                            var color = param.color;//图例颜色
                            var dataIndex = param.dataIndex;//y轴哪个系列
                            htmlStr +='<div>';
                            //为了保证和原来的效果一样，这里自己实现了一个点的效果
                            htmlStr += '<span style="margin-right:5px;display:inline-block;width:10px;height:10px;border-radius:5px;background-color:'+color+';"></span>';
                            //圆点后面显示的文本
                            htmlStr += xName + '：' + value + "%";
                            htmlStr += '</div>';
                        }
                        return htmlStr;
                    }
                };
                // $scope.baroption.tooltip.formatter = '{b}:\n{c}%';
                $scope.baroption.xAxis.axisLabel.formatter = '{value}%';
                //$scope.baroption.xAxis.max = (Math.max.apply(null, $scope.newskus) * 100).toFixed(0);
                //$scope.baroption.xAxis.min = Math.min(0, Math.min.apply(null, $scope.newskus)) * 100;
                angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                    if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {//未选中容量分级和瓶量分级
                        if (data.relation.id == rid && data.system.id == sid && data.platform.id == pid && data.cityLevel.id == cid) {
                            $scope.baroption.title.text = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name;
                            $scope.setBarCapacity(data, kpi,lastkpi, $scope.newskus, labelRight);
                        }
                    } else {
                        if (data.relation.id == rid && data.system.id == sid && data.platform.id == pid && data.cityLevel.id == cid && data.skuname.id == skuid) {
                            $scope.baroption.title.text = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name + ' - ' + data.skuname.name;
                            $scope.setBarCapacity(data, kpi,lastkpi, $scope.newskus, labelRight);
                        }
                    }
                });
            }else{ //数
                $scope.baroption.tooltip = {
                    trigger: 'axis',
                    axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                        type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    },
                    formatter: function (params, ticket, callback) {
                        var htmlStr = '';
                        for(var i=0;i<params.length;i++){
                            var param = params[i];
                            var xName = param.name;//x轴的名称
                            var seriesName = param.seriesName;//图例名称
                            var value = param.value;//y轴值
                            var color = param.color;//图例颜色
                            var dataIndex = param.dataIndex;//y轴哪个系列
                            htmlStr +='<div>';
                            //为了保证和原来的效果一样，这里自己实现了一个点的效果
                            htmlStr += '<span style="margin-right:5px;display:inline-block;width:10px;height:10px;border-radius:5px;background-color:'+color+';"></span>';
                            //圆点后面显示的文本
                            htmlStr += xName + '：' + $scope.conversion(value);
                            htmlStr += '</div>';
                        }
                        return htmlStr;
                    }
                };
                // $scope.baroption.tooltip.formatter = '{b}:\n{c}';
                $scope.baroption.xAxis.axisLabel.formatter = '{value}';
                //$scope.baroption.xAxis.max = Math.ceil(Math.max.apply(null, $scope.newskus));
                //$scope.baroption.xAxis.min = Math.min(0, Math.min.apply(null, $scope.newskus));
                angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                    if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {//未选中容量分级和瓶量分级
                        if (data.relation.id == rid && data.system.id == sid && data.platform.id == pid && data.cityLevel.id == cid) {
                            $scope.baroption.title.text = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name;
                            $scope.setBarCapacityNumber(data, kpi,lastkpi, $scope.newskus, labelRight);
                        }
                    } else {
                        if (data.relation.id == rid && data.system.id == sid && data.platform.id == pid && data.cityLevel.id == cid && data.skuname.id == skuid) {
                            $scope.baroption.title.text = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name + ' - ' + data.skuname.name;
                            $scope.setBarCapacityNumber(data, kpi,lastkpi, $scope.newskus, labelRight);
                        }
                    }
                });
            }
            return $scope.baroption;
        };
        $scope.setBarCapacity = function (data, kpi,lastkpi, newskus, labelRight) {
            $scope.baroption.title.subtext = data.self ? data.self[0].name + '：' + parseFloat(data.self[1][kpi] * 100).toFixed(2) + "%" : '';
            $scope.baroption.yAxis.data = [];
            $scope.baroption.legend.data = [];
            $scope.baroption.series[0].markPoint.data = [];
            $scope.baroption.series[0].data = [];
            angular.forEach(data.skus, function (subdata, index, array) {
                if (subdata[1][kpi] == null) {//本期值
                    subdata[1][kpi] = 0;
                }
                if (subdata[1][lastkpi] == null) {//变化率
                    subdata[1][lastkpi] = 0;
                }
                if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {//未选中容量分级和瓶量分级
                    switch ($scope.deepbrandcheck) {
                        case "catalog":
                            if ($scope.total[subdata[1].category_id].checked) {
                                $scope.setBar(subdata, kpi,lastkpi, labelRight);
                            }
                            break;
                        case "manufacturer":
                            if ($scope.total[subdata[1].menu_id].checked) {
                                $scope.setBar(subdata, kpi,lastkpi, labelRight);
                            }
                            break;
                        case "brand":
                            if ($scope.total[subdata[1].brand_id].checked) {
                                $scope.setBar(subdata, kpi,lastkpi, labelRight);
                            }
                            break;
                    }
                } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {
                    if ($scope.cate_classifys[subdata[1].capacity_id].checked) {
                        $scope.setBar(subdata, kpi,lastkpi, labelRight);
                    }
                } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {
                    if ($scope.cate_classifys[subdata[1].bottle_id].checked) {
                        $scope.setBar(subdata, kpi, lastkpi,labelRight);
                    }
                }
            });
        };
        $scope.setBarCapacityNumber = function (data, kpi,lastkpi, newskus, labelRight) {
            // $scope.baroption.title.subtext = data.self ? data.self[0].name + '：' + parseFloat(data.self[1][kpi] * 100).toFixed(2) + "%" : '';
            $scope.baroption.yAxis.data = [];
            $scope.baroption.legend.data = [];
            $scope.baroption.series[0].markPoint.data = [];
            $scope.baroption.series[0].data = [];
            $scope.valArr = [];
            angular.forEach(data.skus, function (subdata, index, array) {
                $scope.valArr.push(parseFloat(subdata[1][kpi]));
                if (subdata[1][kpi] == null) {//本期值
                    subdata[1][kpi] = 0;
                }
                if (subdata[1][lastkpi] == null) {//变化率
                    subdata[1][lastkpi] = 0;
                }
                if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {//未选中容量分级和瓶量分级
                    switch ($scope.deepbrandcheck) {
                        case "catalog":
                            if ($scope.total[subdata[1].category_id].checked) {
                                $scope.setBarNumber(subdata, kpi,lastkpi, labelRight,newskus);
                            }
                            break;
                        case "manufacturer":
                            if ($scope.total[subdata[1].menu_id].checked) {
                                $scope.setBarNumber(subdata, kpi,lastkpi, labelRight,newskus);
                            }
                            break;
                        case "brand":
                            if ($scope.total[subdata[1].brand_id].checked) {
                                $scope.setBarNumber(subdata, kpi,lastkpi, labelRight,newskus);
                            }
                            break;
                    }
                } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {
                    if ($scope.cate_classifys[subdata[1].capacity_id].checked) {
                        $scope.setBarNumber(subdata, kpi,lastkpi, labelRight,newskus);
                    }
                } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {
                    if ($scope.cate_classifys[subdata[1].bottle_id].checked) {
                        $scope.setBarNumber(subdata, kpi, lastkpi,labelRight,newskus);
                    }
                }
            });
        };
        $scope.setBar = function (subdata, kpi, lastkpi,labelRight) {
            if (subdata[1][kpi] > 0) {
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
            $scope.baroption.yAxis.data.push(subdata[0].name);
            $scope.baroption.series[0].itemStyle = {
                normal: {
                    color: function (params) {
                        return $scope.colors[params.dataIndex];
                    }
                }
            };
            var v2 = 0;
            if(kpi == 'distribution'){
                 v2 = Math.round(subdata[1][kpi] *100);
            }else{
                v2 = Math.round(subdata[1][kpi] *1000)/10;
            }

            $scope.baroption.series[0].data.push({
                value: v2,
                formatter: '{value}%',
                label: labelRight,
            });

            var v1 = (parseFloat(subdata[1][lastkpi])).toFixed(1);
            var barColor = 'red';
            var valMark = 0;
            var valName = v2+'%';
            if(subdata[1][lastkpi] > 0){
                barColor = '#00bc73';
                valMark = '+'+v1+' pts';
            }else{
                valMark = v1+' pts';
            }
            $scope.baroption.series[0].markPoint.data.push({
                label: {
                    normal: {
                        formatter: '{b|{b}} {c|{c}}',
                        backgroundColor: 'rgb(242,242,242)',
                        borderColor: '#aaa',
                        padding: [5, 0],
                        position: 'right',
                        distance: 3,
                        rich: {
                            b: {
                                color:'black',
                                fontSize: 10
                            },
                            c: {
                                color:barColor,
                                fontSize: 10,
                                fontStyle:'oblique'
                            }
                        }
                    }
                },
                coord:[v2,$scope.barIdx],
                name:valName,
                value:valMark
            });
            $scope.baroption.legend.data.push(subdata[0].name);
            $scope.barIdx++;
        };
        $scope.setBarNumber = function (subdata, kpi, lastkpi,labelRight,newskus) {
            var barMax = Math.ceil(Math.max.apply(null, $scope.valArr));
            if (subdata[1][kpi] > 0) {
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
            $scope.baroption.yAxis.data.push(subdata[0].name);
            $scope.baroption.series[0].itemStyle = {
                normal: {
                    color: function (params) {
                        return $scope.colors[params.dataIndex];
                    }
                }
            };
            var v1 = 0;
            var subBar = parseFloat(subdata[1][kpi]);

            if(kpi == 'distribution_store'){
                if(barMax <1000){
                    v1 = Math.round(subBar);//小于1000不加单位
                    $scope.baroption.title.subtext = "";
                }else if(barMax >= 1000 && barMax < 100000){//在一千和十万之间
                    v1 = Math.round((subBar/1000))/10;//不保留小数点(单位：千)
                    $scope.baroption.title.subtext = "<?= Yii::t('cvs', '单位：\'000');?>";
                }else if(barMax >= 100000 && barMax < 10000000){//在十万和千万之间
                    v1 = Math.round((subBar/100000))/10;//不保留小数点(单位：百万)
                    $scope.baroption.title.subtext = "<?= Yii::t('cvs', '单位：million/百万');?>";
                }
            }else{
                v1 = Math.round(parseFloat(subdata[1][kpi])*10)/10;//保留一位小数点
                $scope.baroption.title.subtext = "";
            }


            $scope.baroption.series[0].data.push({
                value: v1,
                // itemStyle: {
                //     normal: {
                //         color: subdata[0].color
                //     }
                // },
                formatter: '{value}',
                label: labelRight
            });
            var barColor = 'red';
            var v2 = (parseFloat(subdata[1][lastkpi])).toFixed(1);
            var valMark = 0;
            var valName = v1;
            if(subdata[1][lastkpi] > 0){
                barColor = '#00bc73';
                valMark = '+'+v2+' pts';
            }else{
                valMark = v2+' pts';
            }
            $scope.baroption.series[0].markPoint.data.push({
                label: {
                    normal: {
                        formatter: '{b|{b}} {c|{c}}',
                        backgroundColor: 'rgb(242,242,242)',
                        borderColor: '#aaa',
                        padding: [5, 0],
                        position: 'right',
                        distance: 3,
                        rich: {
                            b: {
                                color:'black',
                                fontSize: 10
                            },
                            c: {
                                color:barColor,
                                fontSize: 10,
                                fontStyle:'oblique'
                            }
                        }
                    }
                },
                coord:[v1,$scope.barIdx],
                name:valName,
                value:valMark
            });

            $scope.baroption.legend.data.push(subdata[0].name);
            $scope.barIdx++;
        };

        //垂直柱状图
        $scope.setVerticalityBarOption = function(kpi,lastkpi, rid, min, max, sid, pid, cid, skuid){
            $scope.kpi = kpi;
            $scope.barIdx = 0;
            var y1;
            switch (kpi){
                case 'saleroom':
                    y1 = '销售金额（元）';
                    break;
                case 'sales_numbers':
                    y1 = '销售件数（件）';
                    break;
            }
            $scope.verticalityOption.tooltip = {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                },
                formatter: function (params, ticket, callback) {
                    var htmlStr = '';
                    for(var i=0;i<params.length;i++){
                        var param = params[i];
                        var xName = param.name;//x轴的名称
                        var value = param.value;//y轴值
                        var color = param.color;//图例颜色
                        htmlStr +='<div>';
                        //为了保证和原来的效果一样，这里自己实现了一个点的效果
                        htmlStr += '<span style="margin-right:5px;display:inline-block;width:10px;height:10px;border-radius:5px;background-color:'+color+';"></span>';
                        //圆点后面显示的文本
                        htmlStr += xName + '：' + $scope.conversion(value);
                        htmlStr += '</div>';
                    }
                    return htmlStr;
                }
            };
            $scope.verticalityOption.yAxis.axisLabel.formatter = '{value}';
            $scope.verticalityOption.title.subtext = y1;
            angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {//未选中容量分级和瓶量分级
                    if (data.relation.id == rid && data.system.id == sid && data.platform.id == pid && data.cityLevel.id == cid) {
                        $scope.verticalityOption.title.text = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name;
                        $scope.setVerticalityBarNumber(data, kpi,lastkpi);
                    }
                } else {
                    if (data.relation.id == rid && data.system.id == sid && data.platform.id == pid && data.cityLevel.id == cid && data.skuname.id == skuid) {
                        $scope.verticalityOption.title.text = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name + ' - ' + data.skuname.name;
                        $scope.setVerticalityBarNumber(data, kpi,lastkpi);
                    }
                }
            });
            return $scope.verticalityOption;
        };
        $scope.setVerticalityBarNumber = function (data, kpi,lastkpi) {
            $scope.verticalityOption.xAxis.data = [];
            //$scope.verticalityOption.legend.data = [];
            $scope.verticalityOption.series[0].markPoint.data = [];
            $scope.verticalityOption.series[0].data = [];
            $scope.valArr = [];
            angular.forEach(data.skus, function (subdata, index, array) {
                $scope.valArr.push(parseFloat(subdata[1][kpi]));
                if (subdata[1][kpi] == null) {//本期值
                    subdata[1][kpi] = 0;
                }
                if (subdata[1][lastkpi] == null) {//变化率
                    subdata[1][lastkpi] = 0;
                }
                if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {//未选中容量分级和瓶量分级
                    switch ($scope.deepbrandcheck) {
                        case "catalog":
                            if ($scope.total[subdata[1].category_id].checked) {
                                $scope.setVerticalityBarNumberInfo(subdata, kpi,lastkpi);
                            }
                            break;
                        case "manufacturer":
                            if ($scope.total[subdata[1].menu_id].checked) {
                                $scope.setVerticalityBarNumberInfo(subdata, kpi,lastkpi);
                            }
                            break;
                        case "brand":
                            if ($scope.total[subdata[1].brand_id].checked) {
                                $scope.setVerticalityBarNumberInfo(subdata, kpi,lastkpi);
                            }
                            break;
                    }
                } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {
                    if ($scope.cate_classifys[subdata[1].capacity_id].checked) {
                        $scope.setVerticalityBarNumberInfo(subdata, kpi,lastkpi);
                    }
                } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {
                    if ($scope.cate_classifys[subdata[1].bottle_id].checked) {
                        $scope.setVerticalityBarNumberInfo(subdata, kpi, lastkpi);
                    }
                }
            });
        };
        $scope.setVerticalityBarNumberInfo = function (subdata, kpi, lastkpi) {
            $scope.verticalityOption.series[0].itemStyle = {
                normal: {
                    color: function (params) {
                        return $scope.colors[params.dataIndex];
                    }
                }
            };
            if(subdata[0]['id'] > 1){//销售件数和销售金额不显示全部的值，以为它的值太大
                var barMax = Math.ceil(Math.max.apply(null, $scope.valArr));
                //console.log(barMax);
                var v1 = 0;
                var subBar = parseFloat(subdata[1][kpi]);//82901480
                if(barMax <1000){
                    if(kpi == 'distribution_store'){
                        v1 = Math.round(subBar);//小于1000不加单位
                    }else{
                        v1 = Math.round(parseFloat(subdata[1][kpi])*10)/10;//保留一位小数点
                    }
                    $scope.verticalityOption.title.subtext = "";
                }else if(barMax >= 1000){//在一千和十万之间( && barMax < 100000)
                    v1 = Math.round((subBar/1000))/10;//不保留小数点(单位：千)
                    $scope.verticalityOption.title.subtext = "<?= Yii::t('cvs', '单位：\'000');?>";
                }
                //else if(barMax >= 100000 && barMax < 100000000){//在十万和千万之间
                //    v1 = Math.round((subBar/100000))/10;//不保留小数点(单位：百万)
                //    $scope.verticalityOption.title.subtext = "<?//= Yii::t('cvs', '单位：million/百万');?>//";
                //}
                $scope.verticalityOption.xAxis.data.push(subdata[0].name);
                $scope.verticalityOption.series[0].data.push({
                    name:subdata[0].name,
                    value: v1,
                    // itemStyle: {
                    //     normal: {
                    //         color: subdata[0].color
                    //     }
                    // },
                    formatter: '{value}'
                });
                var barColor = 'red';
                var v2 = (parseFloat(subdata[1][lastkpi])).toFixed(1);
                var valMark = 0;
                if(subdata[1][lastkpi] > 0){
                    barColor = '#00bc73';
                    valMark = '+'+v2+' pts';
                }else{
                    valMark = v2+' pts';
                }
                $scope.verticalityOption.series[0].markPoint.data.push({
                    label: {
                        normal: {
                            formatter: '{b|{b}}\n{c|{c}}',
                            backgroundColor: 'rgb(242,242,242)',
                            // borderColor: '#aaa',
                            padding: [5, 0],
                            position: 'top',
                            distance: 3,
                            align:'center',
                            rich: {
                                b: {
                                    color:'black',
                                    fontSize: 10
                                },
                                c: {
                                    color:barColor,
                                    fontSize: 10,
                                    fontStyle:'oblique'
                                }
                            }
                        }
                    },
                    coord:[subdata[0].name,v1],
                    name:v1,
                    value:valMark
                });
            }
            //$scope.verticalityOption.legend.data.push(subdata[0].name);
            $scope.barIdx++;
        };

        //折线图
        $scope.setlineoption = function (kpi, rid, systemid, pid, cid, skuid) {
            $scope.kpi = kpi;
            $scope.newskus = [];
            switch ($scope.deepbrandcheck) {
                case "catalog":
                    angular.forEach($scope.all_skuinfos.bar, function (data, index, array) {
                        //提取指标的所有数据，用于寻找最大最小值
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.cityLevelList[subdata[1].cityLevel_id].checked && $scope.platforms[subdata[1].platform_id].checked && $scope.total[subdata[1].category_id]['checked']) {
                                angular.forEach(subdata[2], function (subsubdata, index, array) {
                                    $scope.newskus.push(parseFloat(subsubdata[kpi]));
                                })
                            }
                        });
                    });
                    break;
                case "manufacturer":
                    angular.forEach($scope.all_skuinfos.bar, function (data, index, array) {
                        //提取指标的所有数据，用于寻找最大最小值
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.cityLevelList[subdata[1].cityLevel_id].checked && $scope.platforms[subdata[1].platform_id].checked && $scope.total[subdata[1].menu_id]['checked']) {
                                angular.forEach(subdata[2], function (subsubdata, index, array) {
                                    $scope.newskus.push(parseFloat(subsubdata[kpi]));
                                })
                            }
                        });
                    });
                    break;
                case "brand":
                    angular.forEach($scope.all_skuinfos.bar, function (data, index, array) {
                        //提取指标的所有数据，用于寻找最大最小值
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.cityLevelList[subdata[1].cityLevel_id].checked && $scope.platforms[subdata[1].platform_id].checked && $scope.total[subdata[1].brand_id]['checked']) {
                                angular.forEach(subdata[2], function (subsubdata, index, array) {
                                    $scope.newskus.push(parseFloat(subsubdata[kpi]));
                                })
                            }
                        });
                    });
                    break;
            }
            if ($('.weidu-item-box .sel-con.c input:checked').length > 10) {
                // $scope.lineoption.legend['show'] = false;
            }
            $scope._showData = $('.weidu-item-box .sel-con.c input:checked').length > 2 ? false : true;
            let max = Math.max.apply(null, $scope.newskus);
            let min = Math.min(0, Math.min.apply(null, $scope.newskus));
            if (max > 100) {
                $scope.idxs = 0;
                $scope.lineoption.tooltip = {
                    trigger: 'item',
                    formatter: '{b}'
                }
                //$scope.lineoption.yAxis.max = Math.ceil(max / 1000);
                //$scope.lineoption.yAxis.min = Math.floor(min / 1000);
                $scope.lineoption.yAxis.axisLabel.formatter = '{value}k';
                $scope.lineoption.xAxis.data = $scope.all_skuinfos.stackbar.label;
                angular.forEach($scope.all_skuinfos.bar, function (data, index, array) {
                    if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {
                        if (data.relation.id == rid && data.cityLevel.id == cid && data.system.id == systemid && data.platform.id == pid) {
                            $scope.lineoption.title.text = data.relation.name + '-' + data.cityLevel.name + '-' + data.system.name + '-' + data.platform.name;
                            $scope.setMaxLineGrading(data, kpi);
                        }
                    } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {
                        if (data.relation.id == rid && data.system.id == systemid && data.platform.id == pid && data.cityLevel.id == cid && data.skuname.id == skuid) {
                            $scope.lineoption.title.text = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name + ' - ' + data.skuname.name;
                            $scope.setMaxLineGrading(data, kpi);
                        }
                    } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {
                        if (data.relation.id == rid && data.system.id == systemid && data.platform.id == pid && data.cityLevel.id == cid && data.skuname.id == skuid) {
                            $scope.lineoption.title.text = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name + ' - ' + data.skuname.name;
                            $scope.setMaxLineGrading(data, kpi);
                        }
                    }
                });
                //添加悬浮框里面的东西（本期值和变化率体现在一个图表中）
                $scope.lineoption.tooltip = {
                    trigger: 'item',
                    axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                        type: 'line'        // 默认为直线，可选为：'line' | 'shadow'
                    },
                    formatter: function (params) {
                        var htmlStr = '';
                        var xName = params.name;//x轴的名称
                        var seriesName = params.seriesName;//图例名称
                        var value = params.value;//y轴值
                        var color = params.color;//图例颜色
                        if(i===0){
                            htmlStr += xName + '<br/>';//x轴的名称
                        }
                        htmlStr +='<div>';
                        //为了保证和原来的效果一样，这里自己实现了一个点的效果
                        htmlStr += '<span style="margin-right:5px;display:inline-block;width:10px;height:10px;border-radius:5px;background-color:'+color+';"></span>';
                        //圆点后面显示的文本
                        htmlStr += seriesName + '：' + value + 'k';
                        htmlStr += '</div>';
                        return htmlStr;
                    }
                };
            } else {
                $scope.idxs = 0;
                //$scope.lineoption.yAxis.max = Math.ceil(max * 100);
                //$scope.lineoption.yAxis.min = Math.floor(min * 100);
                $scope.lineoption.tooltip = {
                    trigger: 'item',
                    formatter: '{b}',
                    axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                        type: 'cross'        // 默认为直线，可选为：'line' | 'shadow'
                    },
                };
                $scope.lineoption.xAxis.data = $scope.all_skuinfos.stackbar.label;
                angular.forEach($scope.all_skuinfos.bar, function (data, index, array) {
                    if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {
                        if (data.relation.id == rid && data.cityLevel.id == cid && data.system.id == systemid && data.platform.id == pid) {
                            $scope.lineoption.title.text = data.relation.name + '-' + data.cityLevel.name + '-' + data.system.name + '-' + data.platform.name;
                            $scope.setlineGrading(data, kpi);
                        }
                    } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {
                        if (data.relation.id == rid && data.system.id == systemid && data.platform.id == pid && data.cityLevel.id == cid && data.skuname.id == skuid) {
                            $scope.lineoption.title.text = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name + ' - ' + data.skuname.name;
                            $scope.setlineGrading(data, kpi);
                        }
                    } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {
                        if (data.relation.id == rid && data.system.id == systemid && data.platform.id == pid && data.cityLevel.id == cid && data.skuname.id == skuid) {
                            $scope.lineoption.title.text = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name + ' - ' + data.skuname.name;
                            $scope.setlineGrading(data, kpi);
                        }
                    }
                });
                //添加悬浮框里面的东西（本期值和变化率体现在一个图表中）
                $scope.lineoption.tooltip = {
                    trigger: 'item',
                    axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                        type: 'cross'        // 默认为直线，可选为：'line' | 'shadow'
                    },
                    formatter: function (params) {
                        console.log(params);
                        var htmlStr = '';
                        var xName = params.name;//x轴的名称
                        var seriesName = params.seriesName;//图例名称
                        var value = params.value;//y轴值
                        var color = params.color;//图例颜色
                        htmlStr +='<div>';
                        //为了保证和原来的效果一样，这里自己实现了一个点的效果
                        htmlStr += '<span style="margin-right:5px;display:inline-block;width:10px;height:10px;border-radius:5px;background-color:'+color+';"></span>';
                        //圆点后面显示的文本
                        htmlStr += seriesName + '：' + value + '%';
                        htmlStr += '</div>';
                        return htmlStr;
                    }
                };
            }
            return $scope.lineoption;
        };
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
                            if ($scope.total[subdata[1].category_id].checked) {
                                $scope.setlineGradingOption(subdata, kpi);
                            }
                            break;
                        case "manufacturer":
                            if ($scope.total[subdata[1].menu_id].checked) {
                                $scope.setlineGradingOption(subdata, kpi);
                            }
                            break;
                        case "brand":
                            if ($scope.total[subdata[1].brand_id].checked) {
                                $scope.setlineGradingOption(subdata, kpi);
                            }
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
            $scope.lineoption.legend.data.push(subdata[0].name);
            $scope.lineoption.tooltip.formatter += '{b}<br>{a' + $scope.idxs + '}:{c' + $scope.idxs + '}%';
            $scope.idxs++;
            if (subdata[1][kpi] == null) subdata[1][kpi] = 0;
            let _data = [];
            if (subdata.length >= 0) {
                angular.forEach(subdata[2], function (kpiData, index, array) {
                    _data.push(Math.round((kpiData[kpi] * 100)*10)/10);
                });
                _data.reverse();
            }
            $scope.lineoption.series.push({
                name: subdata[0].name,
                type: 'line',
                data: _data,
                // label: {
                //     normal: {
                //         show: true,
                //         position: 'top'
                //     }
                // },
                // stack: '总量',
                // areaStyle: {normal: {}},
                // itemStyle: {
                    // normal: {
                    //     color: subdata[0].color,
                    //     label: {
                    //         show: $scope._showData
                    //     }
                    // }
                // }
            });
        };
        $scope.setMaxLineGrading = function (data, kpi) {
            $scope.lineoption.title.subtext = "<?= Yii::t('cvs', '单位：\'000');?>";
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
            $scope.lineoption.legend.data.push(subdata[0].name);
            $scope.lineoption.tooltip.formatter += '<br>{a' + $scope.idxs + '}:{c' + $scope.idxs + '} k';
            $scope.idxs++;
            if (subdata[1][kpi] == null) subdata[1][kpi] = 0;
            let _data = [];
            if (subdata.length >= 0) {
                angular.forEach(subdata[2], function (kpiData, index, array) {
                    _data.push(Math.round(((parseFloat(kpiData[kpi]))/1000)*10)/10);
                });
                _data.reverse();
            }
            $scope.lineoption.series.push({
                name: subdata[0].name,
                type: 'line',
                data: _data,
                itemStyle: {
                    // normal: {
                    //     color: subdata[0].color,
                    //     label: {
                    //         show: $scope._showData
                    //     }
                    // }
                }

            });
        };

        //堆叠柱状图
        $scope.setstackbaroption = function (kpi) {    //堆叠柱状图
            $scope.kpi = kpi;
            $scope.stackbaroption.xAxis[0].data = [];
            $scope.stackbaroption.legend.data = [];
            $scope.stackbaroption.legend.selected = {};
            $scope.stackbaroption.series = [];
            if (typeof $scope.allskuinfos.stackbar != "undefined" ? true : false) {
                angular.forEach($scope.allskuinfos.stackbar.skus, function (subdata, subindex, array) {
                    var newseria = [];
                    if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {//未选中容量分级和瓶量分级
                        switch ($scope.deepbrandcheck) {
                            case "catalog":
                                if ($scope.categoryList[subdata[0][1].category_id]['checked']) {
                                    $scope.stackbaroption.legend.data.push(subindex);
                                    $scope.stackbaroption.legend.selected[subindex] = $scope.categoryList[subdata[0][1].category_id]['checked'];
                                    $scope.setStackTotal(subindex, kpi, subdata, newseria);
                                }
                                break;
                            case "manufacturer":
                                if ($scope.menuList[subdata[0][1].menu_id]['checked']) {
                                    $scope.stackbaroption.legend.data.push(subindex);
                                    $scope.stackbaroption.legend.selected[subindex] = $scope.menuList[subdata[0][1].menu_id]['checked'];
                                    $scope.setStackTotal(subindex, kpi, subdata, newseria);
                                }
                                break;
                            case "brand":
                                if ($scope.brandList[subdata[0][1].brand_id]['checked']) {
                                    $scope.stackbaroption.legend.data.push(subindex);
                                    $scope.stackbaroption.legend.selected[subindex] = $scope.brandList[subdata[0][1].brand_id]['checked'];
                                    $scope.setStackTotal(subindex, kpi, subdata, newseria);
                                }
                                break;
                        }
                        $scope.setStack(subindex, subdata, newseria);
                    } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') { //选中容量分级
                        if ($scope.cate_classifys[subdata[1][1].capacity_id]['checked']) {
                            $scope.stackbaroption.legend.data.push(subindex);
                            $scope.stackbaroption.legend.selected[subindex] = $scope.cate_classifys[subdata[1][1].capacity_id].checked;
                            angular.forEach(subdata, function (subsubdata, ssubindex, array) {
                                if ($scope.relations[subsubdata[1].relation_id]['checked'] && $scope.cityLevelList[subsubdata[1].cityLevel_id]['checked'] && $scope.systems[subsubdata[1].system_id].checked && $scope.platforms[subsubdata[1].platform_id].checked && $scope.skus[subsubdata[1].sku_id].checked && $scope.cate_classifys[subdata[1][1].capacity_id].checked) {
                                    if ($scope.stackbaroption.xAxis[0].data.indexOf(
                                        $scope.allskuinfos.stackbar.relations[subsubdata[1].relation_id] + '-' +
                                        $scope.allskuinfos.stackbar.cityLevel[subsubdata[1].cityLevel_id] + '-' +
                                        $scope.allskuinfos.stackbar.systems[subsubdata[1].system_id] + '-' +
                                        $scope.allskuinfos.stackbar.platforms[subsubdata[1].platform_id] + '-' +
                                        $scope.allskuinfos.stackbar.skuname[subsubdata[1].sku_id]) == -1) {
                                        $scope.stackbaroption.xAxis[0].data.push(
                                            $scope.allskuinfos.stackbar.relations[subsubdata[1].relation_id]
                                            + '-' + $scope.allskuinfos.stackbar.cityLevel[subsubdata[1].cityLevel_id] + '-' +
                                            $scope.allskuinfos.stackbar.systems[subsubdata[1].system_id]
                                            + '-' + $scope.allskuinfos.stackbar.platforms[subsubdata[1].platform_id]
                                            + '-' + $scope.allskuinfos.stackbar.skuname[subsubdata[1].sku_id]
                                        );
                                    }
                                    if (!subsubdata[1][kpi]) {
                                        subsubdata[1][kpi] = 0;
                                    }
                                    subsubdata[1][kpi] = Math.round(subsubdata[1][kpi]);//四舍五入取整
                                    newseria.push({
                                        value: subsubdata[1][kpi],
                                        name: subindex
                                    });
                                }
                            });
                        }
                        $scope.setStack(subindex, subdata, newseria);
                    } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') { //选中瓶量分级
                        if ($scope.cate_classifys[subdata[1][1].bottle_id]['checked']) {
                            $scope.stackbaroption.legend.data.push(subindex);
                            $scope.stackbaroption.legend.selected[subindex] = $scope.cate_classifys[subdata[1][1].bottle_id].checked;
                            angular.forEach(subdata, function (subsubdata, ssubindex, array) {
                                if ($scope.relations[subsubdata[1].relation_id]['checked'] && $scope.cityLevelList[subsubdata[1].cityLevel_id]['checked'] && $scope.systems[subsubdata[1].system_id].checked && $scope.platforms[subsubdata[1].platform_id].checked && $scope.skus[subsubdata[1].sku_id].checked) {
                                    if ($scope.stackbaroption.xAxis[0].data.indexOf(
                                        $scope.allskuinfos.stackbar.relations[subsubdata[1].relation_id] + '-' +
                                        $scope.allskuinfos.stackbar.cityLevel[subsubdata[1].cityLevel_id] + '-' +
                                        $scope.allskuinfos.stackbar.systems[subsubdata[1].system_id] + '-' +
                                        $scope.allskuinfos.stackbar.platforms[subsubdata[1].platform_id] + '-' +
                                        $scope.allskuinfos.stackbar.skuname[subsubdata[1].sku_id]) == -1) {
                                        $scope.stackbaroption.xAxis[0].data.push(
                                            $scope.allskuinfos.stackbar.relations[subsubdata[1].relation_id]
                                            + '-' + $scope.allskuinfos.stackbar.cityLevel[subsubdata[1].cityLevel_id] + '-' +
                                            $scope.allskuinfos.stackbar.systems[subsubdata[1].system_id]
                                            + '-' + $scope.allskuinfos.stackbar.platforms[subsubdata[1].platform_id]
                                            + '-' + $scope.allskuinfos.stackbar.skuname[subsubdata[1].sku_id]
                                        );
                                    }
                                    if (!subsubdata[1][kpi]) {
                                        subsubdata[1][kpi] = 0;
                                    }
                                    subsubdata[1][kpi] = Math.round(subsubdata[1][kpi]);//四舍五入取整
                                    newseria.push({
                                        value: subsubdata[1][kpi],
                                        name: subindex
                                    });
                                }
                            });
                        }
                        $scope.setStack(subindex, subdata, newseria);
                    }
                });
                for (let j = 0; j < $scope.stackbaroption.series.length; j++) {
                    if ($scope.stackbaroption.series[j].data && $scope.stackbaroption.series[j].data.length > 0) {
                        $scope.myObj = {
                            "width": $scope.stackbaroption.series[j].data.length * 128 + 300
                        };
                        break
                    }
                }
                var stackTotal = [];
                for (let i = 0; i < $scope.stackbaroption.series.length; i++) {
                    var _length = $scope.stackbaroption.series[i].data.length;
                    for (let j = 0; j < _length; j++) {
                        if (!stackTotal[j]) stackTotal[j] = 0;
                        stackTotal[j] += $scope.stackbaroption.series[i].data[j].value;
                        if (i == $scope.stackbaroption.series.length - 1) {
                            $scope.stackbaroption.series[i].data[j]['label'] = {
                                normal: {
                                    show: true,
                                    position: 'top',
                                    formatter: function () {
                                        return '<?= Yii::t('cvs', '总和')?>: ' + stackTotal[j]
                                    }
                                }
                            }
                        }
                    }
                }

                //添加悬浮框里面的东西（本期值和变化率体现在一个图表中）
                $scope.stackbaroption.tooltip = {
                    trigger: 'axis',
                    axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                        type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    },
                    formatter: function (params, ticket, callback) {
                        var htmlStr = '';
                        for(var i=0;i<params.length;i++){
                            var param = params[i];
                            var xName = param.name;//x轴的名称
                            var seriesName = param.seriesName;//图例名称
                            var value = param.value;//y轴值
                            var color = param.color;//图例颜色
                            var dataIndex = param.dataIndex;//y轴哪个系列
                            var gradient = (parseFloat($scope.allskuinfos.stackbar.skus[seriesName][dataIndex][1][$scope.optionLastKpi])).toFixed(2);
                            if(i===0){
                                htmlStr += xName + '<br/>';//x轴的名称
                            }
                            htmlStr +='<div>';
                            //为了保证和原来的效果一样，这里自己实现了一个点的效果
                            htmlStr += '<span style="margin-right:5px;display:inline-block;width:10px;height:10px;border-radius:5px;background-color:'+color+';"></span>';
                            //圆点后面显示的文本
                            htmlStr += seriesName + '：' + value + "&nbsp;&nbsp;&nbsp;"+gradient;
                            htmlStr += '</div>';
                        }
                        return htmlStr;
                    }
                };

                return $scope.stackbaroption;
            }

        };
        $scope.setStackTotal = function (subindex, kpi, subdata, newseria) {
            angular.forEach(subdata, function (subsubdata, ssubindex, array) {
                if ($scope.relations[subsubdata[1].relation_id]['checked'] && $scope.cityLevelList[subsubdata[1].cityLevel_id]['checked'] && $scope.systems[subsubdata[1].system_id].checked && $scope.platforms[subsubdata[1].platform_id].checked) {
                    if ($scope.stackbaroption.xAxis[0].data.indexOf($scope.allskuinfos.stackbar.relations[subsubdata[1].relation_id] + '-' + $scope.allskuinfos.stackbar.cityLevel[subsubdata[1].cityLevel_id] + '-' + $scope.allskuinfos.stackbar.systems[subsubdata[1].system_id] + '-' + $scope.allskuinfos.stackbar.platforms[subsubdata[1].platform_id]) == -1) {
                        $scope.stackbaroption.xAxis[0].data.push(
                            $scope.allskuinfos.stackbar.relations[subsubdata[1].relation_id]
                            + '-' + $scope.allskuinfos.stackbar.cityLevel[subsubdata[1].cityLevel_id] + '-' +
                            $scope.allskuinfos.stackbar.systems[subsubdata[1].system_id]
                            + '-' + $scope.allskuinfos.stackbar.platforms[subsubdata[1].platform_id]
                        );
                    }
                    if (!subsubdata[1][kpi]) {
                        subsubdata[1][kpi] = 0;
                    }
                    newseria.push({
                        value: Math.round(subsubdata[1][kpi]),//四舍五入取整
                        name: subindex
                    });
                }
            });
        };
        $scope.setStack = function (subindex, subdata, newseria) {
            $scope.stackbaroption.series.push({
                name: subindex,
                type: 'bar',
                large: true,
                barMaxWidth: 150,
                itemStyle: {
                    normal: {
                        color: subdata[0][0].color
                    }
                },
                stack: 'total',
                data: newseria
            });
        };

        //折线柱状双拼图
        $scope.setlineBaroption = function (kpi, comparKpi, rid, sid, pid, cid, skuid) {
            $scope.lastValue = "";
            var y1 =  '';
            var y2 = '';
            switch (kpi){
                case 'average_discount_factor':
                    $scope.lastValue = 'last_average_discount_factor';
                    y1 = '折扣深度（柱状图）';
                    y2 = '价格促销渗透率（折线图）';
                    break;
                case 'saleroom':
                    $scope.lastValue = 'last_saleroom';
                    comparKpi = 'last_saleroom';
                    y1 = '销售金额';
                    break;
                case 'sales_numbers':
                    $scope.lastValue = 'last_sales_numbers';
                    comparKpi = 'last_sales_numbers';
                    y1 = '销售件数';
                    break;
            }
            $scope.kpi = kpi;
            $scope.comparKpi = comparKpi;
            $scope.newskus = [];//绝对值(价格促销渗透率或者销售金额或者销售件数)
            $scope.tagnewskus = [];//百分比(平均价格深度或者销售金额份额或者销售件数份额)
            switch ($scope.deepbrandcheck) {
                case "catalog":
                    angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                        //提取指标的所有数据，用于寻找最大最小值
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.relations[subdata[1].relation_id]['checked'] && $scope.cityLevelList[subdata[1].cityLevel_id]['checked'] && $scope.relations[subdata[1].relation_id]['show'] && $scope.total[subdata[1].category_id]['checked'] && $scope.systems[subdata[1].system_id]['checked']) {
                                $scope.newskus.push(subdata[1][kpi]);
                                $scope.tagnewskus.push(subdata[1][comparKpi]);
                            }
                        });
                    });
                    break;
                case "manufacturer":
                    angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                        //提取指标的所有数据，用于寻找最大最小值
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.relations[subdata[1].relation_id]['checked'] && $scope.cityLevelList[subdata[1].cityLevel_id]['checked'] && $scope.relations[subdata[1].relation_id]['show'] && $scope.total[subdata[1].menu_id]['checked'] && $scope.systems[subdata[1].system_id]['checked']) {
                                $scope.newskus.push(subdata[1][kpi]);
                                $scope.tagnewskus.push(subdata[1][comparKpi]);
                            }
                        });
                    });
                    break;
                case "brand":
                    angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                        //提取指标的所有数据，用于寻找最大最小值
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.relations[subdata[1].relation_id]['checked'] && $scope.cityLevelList[subdata[1].cityLevel_id]['checked'] && $scope.relations[subdata[1].relation_id]['show'] && $scope.total[subdata[1].brand_id]['checked'] && $scope.systems[subdata[1].system_id]['checked']) {
                                $scope.newskus.push(subdata[1][kpi]);
                                $scope.tagnewskus.push(subdata[1][comparKpi]);
                            }
                        });
                    });
                    break;
            }
            //第一个y轴（最大值、最小值）
            let max = Math.max.apply(null, $scope.newskus);
            let min = Math.min(0, Math.min.apply(null, $scope.newskus));
            //第二个y轴（最大值、最小值）
            let max1 = Math.max.apply(null, $scope.tagnewskus);
            let min1 = Math.min(0, Math.min.apply(null, $scope.tagnewskus));
            $scope.lineBarOption.yAxis[0] = {
                name: y1,
                // max: Math.ceil(max),
                // min: Math.floor(min),
                splitLine: {show: false},
                axisLabel: {
                    formatter: '{value}'
                }
            };
            $scope.lineBarOption.yAxis[1] = {
                name: y2,
                // max: Math.ceil(max1 * 100),
                // min: Math.floor(min1 * 100),
                splitLine: {show: false},
                axisLabel: {
                    formatter: '{value}%'
                }
            };
            let idxs = 0;
            $scope.lineBarOption.tooltip = {
                trigger: 'axis',
                //                formatter: '{b}',
                axisPointer: {
                    type: 'cross',
                    crossStyle: {
                        color: '#999'
                    }
                }
            };
            // $scope.lineBarOption.legend.data = [];
            // $scope.lineBarOption.legend.data.push($scope.puzzle[kpi]);//(销售金额或者销售件数)
            // $scope.lineBarOption.legend.data.push($scope.puzzle[comparKpi]);//(销售金额份额或者销售件数份额)
            $scope.lineBarOption.xAxis[0].data = [];//x轴坐标
            $scope.barIdx = 0;
            $scope.lineBarOption.series = [];
            let _dataKpi = [];
            let _dataComparKpi = [];
            let _markPointLastKpi = [];
            angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {//未选中容量分级和瓶量分级
                    if (data.relation.id == rid && data.cityLevel.id == cid && data.system.id == sid && data.platform.id == pid) {
                        $scope.lineBarOption.title.text = data.relation.name + '-' + data.cityLevel.name + '-' + data.system.name + '-' + data.platform.name;
                        angular.forEach(data.skus, function (subdata, index, array) {
                            let idx = index;
                            switch ($scope.deepbrandcheck) {
                                case "catalog":
                                    if ($scope.total[subdata[1].category_id]['checked']) {
                                        $scope.setBarLine(subdata, kpi, comparKpi, _dataKpi, _dataComparKpi,_markPointLastKpi);
                                    }
                                    break;
                                case "manufacturer":
                                    if ($scope.total[subdata[1].menu_id]['checked']) {
                                        $scope.setBarLine(subdata, kpi, comparKpi, _dataKpi, _dataComparKpi,_markPointLastKpi);
                                    }
                                    break;
                                case "brand":
                                    if ($scope.total[subdata[1].brand_id]['checked']) {
                                        $scope.setBarLine(subdata, kpi, comparKpi, _dataKpi, _dataComparKpi,_markPointLastKpi);
                                    }
                                    break;
                            }
                        });
                    }
                } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {//选中容量分级
                    if (data.relation.id == rid && data.cityLevel.id == cid && data.system.id == sid && data.platform.id == pid && data.skuname.id == skuid) {
                        $scope.lineBarOption.title.text = data.relation.name + '-' + data.cityLevel.name + '-' + data.system.name + '-' + data.platform.name + '-' + data.skuname.name;
                        angular.forEach(data.skus, function (subdata, index, array) {
                            let idx = index;
                            if ($scope.cate_classifys[subdata[1].capacity_id].checked) {
                                $scope.setBarLine(subdata, kpi, comparKpi, _dataKpi, _dataComparKpi,_markPointLastKpi);
                            }
                        });
                    }
                } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {//选中瓶量分级
                    if (data.relation.id == rid && data.cityLevel.id == cid && data.system.id == sid && data.platform.id == pid && data.skuname.id == skuid) {
                        $scope.lineBarOption.title.text = data.relation.name + '-' + data.cityLevel.name + '-' + data.system.name + '-' + data.platform.name + '-' + data.skuname.name;
                        angular.forEach(data.skus, function (subdata, index, array) {
                            let idx = index;
                            if ($scope.cate_classifys[subdata[1].bottle_id].checked) {
                                $scope.setBarLine(subdata, kpi, comparKpi, _dataKpi, _dataComparKpi,_markPointLastKpi);
                            }
                        });
                    }
                }
            });

            //添加悬浮框里面的东西（本期值和变化率体现在一个图表中）
            $scope.lineBarOption.tooltip = {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    crossStyle: {
                        color: '#999'
                    }
                },
                formatter: function (params, ticket, callback) {
                    var htmlStr = '';
                    for(var i=0;i<params.length;i++){
                        var param = params[i];
                        var xName = param.name;//x轴的名称
                        var seriesName = param.seriesName;//图例名称
                        var value = (param.seriesIndex ==0)?(param.value):(param.value+'%');//y轴值
                        var color = param.color;//图例颜色
                        var dataIndex = param.dataIndex;//y轴哪个系列
                        // var gradient = (parseFloat($scope.allskuinfos.stackbar.skus[seriesName][dataIndex][1][$scope.optionLastKpi])).toFixed(2);
                        if(i===0){
                            htmlStr += xName + '<br/>';//x轴的名称
                        }
                        htmlStr +='<div>';
                        //为了保证和原来的效果一样，这里自己实现了一个点的效果
                        htmlStr += '<span style="margin-right:5px;display:inline-block;width:10px;height:10px;border-radius:5px;background-color:'+color+';"></span>';
                        //圆点后面显示的文本
                        htmlStr += seriesName + '：' + $scope.conversion(value) + "&nbsp;&nbsp;&nbsp;";
                        htmlStr += '</div>';
                    }
                    return htmlStr;
                }
            };

            // console.log($scope.lineBarOption);
            return $scope.lineBarOption;
        };
        $scope.setBarLine = function (subdata, kpi, comparKpi, _dataKpi, _dataComparKpi,_markPointLastKpi) {
            $scope.lineBarOption.xAxis[0].data.push(subdata[0].name);
            var x0 = subdata[1][kpi];
            var x1 = subdata[1][comparKpi];
            //$scope.lineBarOption.tooltip.formatter += '<br>{a' + idxs + '}:{c' + idxs + '}%'
            //idxs++;
            if (x0 == null || x1 == null) {
                x0 = 0;
                x1 = 0;
            }
            if (subdata.length >= 0) {
                _dataKpi.push((parseFloat(x0)).toFixed(1)),
                    _dataComparKpi.push((parseFloat(x1 * 100)).toFixed(1));
            }

            if(kpi == 'average_discount_factor'){
                var barColor = 'red';
                var valMark = 0;
                var valName = parseFloat(x0).toFixed(1);
                if(subdata[1][$scope.lastValue] > 0){
                    barColor = '#00bc73';
                    valMark = '+'+(parseFloat(subdata[1][$scope.lastValue])).toFixed(1)+' pts';
                }else{
                    valMark = (parseFloat(subdata[1][$scope.lastValue])).toFixed(1)+' pts';
                }
                _markPointLastKpi.push({
                    label: {
                        normal: {
                            formatter: '{b|{b}}\n{c|{c}}',
                            backgroundColor: 'rgb(242,242,242)',
                            position: 'top',
                            padding: [5, 0],
                            distance: 3,
                            align:'center',
                            rich: {
                                b: {
                                    color:'black',
                                    fontSize: 10
                                },
                                c: {
                                    color:barColor,
                                    fontSize: 10,
                                    fontStyle:'oblique'
                                }
                            }
                        }
                    },
                    coord:[subdata[0].name,parseFloat(x0).toFixed(1)],
                    name:valName,
                    value:valMark
                });
            }

            $scope.lineBarOption.series = [];
            $scope.lineBarOption.series.push({
                name: $scope.puzzle[kpi],
                type: 'bar',
                data: _dataKpi,
                itemStyle:{},
                barMaxWidth: 50,
                markPoint: {
                    symbolSize: 1,
                    label: {
                        normal: {
                            formatter: '{b|{b} }{c|{c}}',
                            backgroundColor: 'rgb(242,242,242)',
                            borderColor: '#aaa',
                            // borderWidth: 1,
                            // borderRadius: 4,
                            padding: [5, 0],
                            position: 'top',
                            rich: {
                                b: {
                                    color: '#333',
                                    fontSize: 10
                                },
                                c: {
                                    color: '#ff8811',
                                    fontSize: 10
                                }
                            }
                        }
                    },
                    data: _markPointLastKpi
                }
            });
            $scope.lineBarOption.series[0].itemStyle = {
                normal: {
                    color: function (params) {
                        return $scope.colors[params.dataIndex];
                    }
                }
            };
            $scope.barIdx++;
            $scope.lineBarOption.series.push({
                name: $scope.puzzle[comparKpi],
                type: 'line',
                yAxisIndex: 1,
                data: _dataComparKpi,
                // itemStyle: {
                //     normal: {
                //         color: '#92d050',
                //         label: {
                //             show: $scope._showData
                //         }
                //     }
                // },
            });
        };

        //双折线图
        $scope.setLineTwoOption = function (kpi, comparKpi, rid, sid, pid, cid, skuid) {
            $scope.newskus = [];//(销售金额或者销售件数)
            $scope.tagnewskus = [];//(销售金额份额或者销售件数份额)
            $scope.lineIdxs = 0;
            switch ($scope.deepbrandcheck) {
                case "catalog":
                    angular.forEach($scope.all_skuinfos.bar, function (data, index, array) {
                        //提取指标的所有数据，用于寻找最大最小值
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.relations[subdata[1].relation_id]['checked'] && $scope.cityLevelList[subdata[1].cityLevel_id]['checked'] && $scope.total[subdata[1].category_id]['checked'] && $scope.systems[subdata[1].system_id]['checked']) {
                                angular.forEach(subdata[2], function (subsubdata, index, array) {
                                    $scope.newskus.push(subsubdata[kpi]);
                                    $scope.tagnewskus.push(subsubdata[comparKpi]);
                                })
                            }
                        });
                    });
                    break;
                case "manufacturer":
                    angular.forEach($scope.all_skuinfos.bar, function (data, index, array) {
                        //提取指标的所有数据，用于寻找最大最小值
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.relations[subdata[1].relation_id]['checked'] && $scope.cityLevelList[subdata[1].cityLevel_id]['checked'] && $scope.total[subdata[1].menu_id]['checked'] && $scope.systems[subdata[1].system_id]['checked']) {
                                angular.forEach(subdata[2], function (subsubdata, index, array) {
                                    $scope.newskus.push(subsubdata[kpi]);
                                    $scope.tagnewskus.push(subsubdata[comparKpi]);
                                })
                            }
                        });
                    });
                    break;
                case "brand":
                    angular.forEach($scope.all_skuinfos.bar, function (data, index, array) {
                        //提取指标的所有数据，用于寻找最大最小值
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.relations[subdata[1].relation_id]['checked'] && $scope.cityLevelList[subdata[1].cityLevel_id]['checked'] && $scope.total[subdata[1].brand_id]['checked'] && $scope.systems[subdata[1].system_id]['checked']) {
                                angular.forEach(subdata[2], function (subsubdata, index, array) {
                                    $scope.newskus.push(subsubdata[kpi]);
                                    $scope.tagnewskus.push(subsubdata[comparKpi]);
                                })
                            }
                        });
                    });
                    break;
            }
            //第一个y轴（最大值、最小值）
            let max = Math.max.apply(null, $scope.newskus);
            let min = Math.min(0, Math.min.apply(null, $scope.newskus));
            //第二个y轴（最大值、最小值）
            let max1 = Math.max.apply(null, $scope.tagnewskus);
            let min1 = Math.min(0, Math.min.apply(null, $scope.tagnewskus));
            $scope.lineTwoOption.yAxis[0] = {
                //max: Math.ceil(max),
                //min: Math.floor(min),
                splitLine: {show: false},
                axisLabel: {
                    formatter: '{value}'
                }
            };
            //$scope.lineTwoOption.yAxis[1].max = Math.ceil(max1 * 100);
            //$scope.lineTwoOption.yAxis[1].min = Math.ceil(min1 * 100);
            $scope.lineTwoOption.yAxis[1].axisLabel = {formatter: '{value}%'};

            $scope.lineTwoOption.title[0].subtext = $scope.puzzle[kpi];//副标题
            $scope.lineTwoOption.title[1].subtext = $scope.puzzle[comparKpi];//副标题
            $scope.lineTwoOption.xAxis[0].data = $scope.lineTwoOption.xAxis[1].data = $scope.all_skuinfos.stackbar.label;//x轴
            angular.forEach($scope.all_skuinfos.bar, function (data, index, array) {
                if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {
                    if (data.relation.id == rid && data.cityLevel.id == cid && data.system.id == sid && data.platform.id == pid) {
                        let textData = data.relation.name + '-' + data.cityLevel.name + '-' + data.system.name + '-' + data.platform.name;
                        $scope.setLineTwo(data, kpi, comparKpi, textData);
                    }
                } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {
                    if (data.relation.id == rid && data.system.id == sid && data.platform.id == pid && data.cityLevel.id == cid && data.skuname.id == skuid) {
                        let textData = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name + ' - ' + data.skuname.name;
                        $scope.setLineTwo(data, kpi, comparKpi, textData);
                    }
                } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {
                    if (data.relation.id == rid && data.system.id == sid && data.platform.id == pid && data.cityLevel.id == cid && data.skuname.id == skuid) {
                        let textData = data.relation.name + ' - ' + data.cityLevel.name + ' - ' + data.system.name + ' - ' + data.platform.name + ' - ' + data.skuname.name;
                        $scope.setLineTwo(data, kpi, comparKpi, textData);
                    }
                }
            });
            //添加悬浮框里面的东西
            $scope.lineTwoOption.tooltip = {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                },
                formatter: function (params, ticket, callback) {
                    var htmlStr = '';
                    for(var i=0;i<params.length;i++){
                        var param = params[i];
                        var xName = param.name;//x轴的名称
                        var seriesName = param.seriesName;//图例名称
                        var value = param.value;//y轴值
                        var color = param.color;//图例颜色
                        if(i===0){
                            htmlStr += xName + '<br/>';//x轴的名称
                        }
                        htmlStr +='<div>';
                        //为了保证和原来的效果一样，这里自己实现了一个点的效果
                        htmlStr += '<span style="margin-right:5px;display:inline-block;width:10px;height:10px;border-radius:5px;background-color:'+color+';"></span>';
                        //圆点后面显示的文本
                        if(param.axisIndex == '1'){
                            htmlStr += seriesName + '：' + value+'%';
                        }else{
                            htmlStr += seriesName + '：' + value;
                        }
                        htmlStr += '</div>';
                    }
                    return htmlStr;
                }
            };
            return $scope.lineTwoOption;
        };
        $scope.setLineTwo = function (data, kpi, comparKpi, textData) {
            $scope.lineTwoOption.title[0].text = $scope.lineTwoOption.title[1].text = textData;//标题
            $scope.lineTwoOption.legend.data = [];
            $scope.lineTwoOption.series = [];
            angular.forEach(data.skus, function (subdata, index, array) {
                let idx = index;
                if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'unchecked') {
                    switch ($scope.deepbrandcheck) {
                        case "catalog":
                            if ($scope.total[subdata[1].category_id]['checked']) {
                                $scope.setLineTwoBottle(subdata, kpi, comparKpi);
                            }
                            break;
                        case "manufacturer":
                            if ($scope.total[subdata[1].menu_id]['checked']) {
                                $scope.setLineTwoBottle(subdata, kpi, comparKpi);
                            }
                            break;
                        case "brand":
                            if ($scope.total[subdata[1].brand_id]['checked']) {
                                $scope.setLineTwoBottle(subdata, kpi, comparKpi);
                            }
                            break;
                    }
                } else if ($scope.iscapacity == 'ischecked' && $scope.isbottle == 'unchecked') {
                    if ($scope.cate_classifys[subdata[1].capacity_id].checked) {
                        $scope.setLineTwoBottle(subdata, kpi, comparKpi);
                    }
                } else if ($scope.iscapacity == 'unchecked' && $scope.isbottle == 'ischecked') {
                    if ($scope.cate_classifys[subdata[1].bottle_id].checked) {
                        $scope.setLineTwoBottle(subdata, kpi, comparKpi);
                    }
                }
            });
        };
        $scope.setLineTwoBottle = function (subdata, kpi, comparKpi) {
            //$scope.lineTwoOption.legend.data.push(subdata[0].name);
            //$scope.lineTwoOption.legend[1].data.push(subdata[0].name);
            //$scope.lineTwoOption.tooltip.formatter += '<br>{a' + $scope.lineIdxs + '}:{c' + $scope.lineIdxs + '}%';
//            console.log("subdata",subdata);
            $scope.lineIdxs++;
            if (subdata[1][kpi] == null || subdata[1][comparKpi] == null) {
                subdata[1][kpi] = 0;
                subdata[1][comparKpi] = 0;
            }
            let _data = [];
            let _data2 = [];
            if (subdata.length >= 0) {
                angular.forEach(subdata[2], function (kpiData, index, array) {
                    _data.push(parseFloat(kpiData[kpi]).toFixed(2));
                    _data2.push(parseInt(kpiData[comparKpi] * 10000) / 100);
                });
                _data.reverse();
                _data2.reverse();
            }
            $scope.lineTwoOption.series.push({
                name: subdata[0].name,
                type: 'line',
                data: _data,
                showSymbol: true,
                itemStyle: {
                    normal: {
                        color: subdata[0].color,
                        label: {
                            show: $scope._showData
                        }
                    }
                }
            });
            $scope.lineTwoOption.series.push({
                name: subdata[0].name,
                type: 'line',
                data: _data2,
                xAxisIndex: 1,
                yAxisIndex: 1,
                showSymbol: true,
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

        $scope.pieConfig = {
            theme: 'default',
            dataLoaded: true,
            notMerge: true,
        };
        //正负轴柱状图
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
                            var str = `产品,数据\n`;
                            //组装表数据
                            for (var lt = 0; lt < axisData.length; lt++) {
                                for (var j = 0; j < series.length; j++) {
                                    var temp = series[j].data[lt].value;
                                    if (temp != null && temp != undefined) {
                                        str += `${axisData[lt] + '\t'},` + `${temp.toFixed(4) + '\t'},` + `\n`;
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
                x:'center',
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
                // top: 80,
                // bottom: 30,
                containLabel: true,
                // left: '10%',
                right:'20%'
            },
            xAxis: {
                boundaryGap:['0','15%'],//在设置 min 和 max 后无效
                type: 'value',
                position: 'top',
                splitLine: {show: false},
                axisLabel: {
                    formatter: '{value}%'
                }
            },
            yAxis: {
                type: 'category',
                inverse: true,
                axisLine: {show: true},
                axisLabel: {show: false},
                axisTick: {show: true},
                splitLine: {show: false},
                data: []
            },
            series: [
                {
                    name: '生活费',
                    type: 'bar',
                    barWidth: 22,
                    label: {
                        normal: {
                            show: true,
                            formatter: '{b}'
                        }
                    },
                    data: [],
                    itemStyle:{},
                    markPoint: {
                        symbolSize: 1,
                        data: []
                    }
                }
            ]
        };
        //堆叠柱形图配置项
        $scope.stackbaroption = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                },
            },
            legend: {
                x: 'left',
                itemWidth: 10,
                itemHeight: 10,
                align: 'left',
                icon: 'circle',
                data: [],
                selectedMode: false,
                selected: {},
            },
            grid: {
                left: '0%',
                // right: '1%',
                bottom: '1%',
                width: '100%',
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
                            var str = `筛选项,`; //表头第一列
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
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    splitLine: {show: false}
                }
            ],
            series: [],
            animationDelayUpdate: function (idx) {
                return idx * 5;
            }
        };
        //折线图配置项
        $scope.lineoption = {
            color:$scope.colors,
            title: {
                text: '未来一周气温变化',
                subtext: '纯属虚构'
            },
            tooltip: {
                trigger: 'item',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'cross'        // 默认为直线，可选为：'line' | 'shadow'
                },
            },
            grid: {
                // height: "70%"
                top: "18%",
                left: '0%',
                bottom: '1%',
                width: '90%',
                containLabel: true
            },
            legend: {
                type: 'scroll',
                itemWidth: 10,
                itemHeight: 10,
                top: '10%',
                icon: 'circle',
                data: [],
                // selectedMode:false,
                // itemGap:5
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
                                str += series[product].name + `,`;
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
                                str += time + `,` + stage + `,`;
                                //详细数据
                                for (var j = 0; j < series.length; j++) {
                                    var temp = series[j].data[lt];
                                    if (temp != null && temp != undefined) {
                                        str += temp.toFixed(4) + `,`;
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
                data: ['2017-02', '2017-03', '2017-04', '2017-05', '2017-06', '2017-07', '2017-08']
            },
            yAxis: {
                type: 'value',
                min:'dataMin',
                axisLabel: {
                    formatter: '{value}'
                },
                splitLine: {show: false},
            },
            series: []
        };
        //饼图
        $scope.pie1 = {
            color: ['#FFC738', '#eeeeee'],
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)",
                enterable: true,//鼠标是否可进入提示框浮层
                confine: true,//是否将 tooltip 框限制在图表的区域内。
                position: "top"
            },
            series: [
                {
                    name: "",
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
                    radius: ['60%', '80%'],
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b}: {c} ({d}%)",
                        enterable: true,//鼠标是否可进入提示框浮层
                        confine: true,//是否将 tooltip 框限制在图表的区域内。
                        position: "top"
                    },
                    data: ['0', '60'],
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
                    radius: ['60%', '80%'],
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b}: {c} ({d}%)",
                        enterable: true,
                        confine: true,
                        position: "top"
                    },
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
                    radius: ['60%', '80%'],
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b}: {c} ({d}%)",
                        enterable: true,
                        // renderMode: 'richText',
                        confine: true,
                        position: "top"
                    },
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
                    radius: ['60%', '80%'],
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b}: {c} ({d}%)",
                        // enterable: true,
                        // renderMode: 'richText',
                        // confine: true,
                        position: "top"
                    },
                    data: ['32.333', '60'],
                    avoidLabelOverlap: false,
                }
            ]
        };
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
                                str += series[product].name + `,`;
                            }
                            str += '\n';
                            //组装表数据
                            for (var lt = 0; lt < axisData.length; lt++) {//axisData坐标数据
                                str += axisData[lt] + `,`;
                                //详细数据
                                for (var j = 0; j < series.length; j++) {
                                    var temp = series[j].data[lt];
                                    if (temp != null && temp != undefined) {
                                        str += `${parseFloat(temp.toFixed(4)) + '\t'}` + `,`;
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
            grid:{
                top:'15%'
            },
            // legend: {
            //     data: [],
            //     right: '15%',
            // },
            xAxis: [
                {
                    type: 'category',
                    data: ['全部', '茶', '汽水', '果汁'],
                    boundaryGap: ['10%', '10%'],
                    axisPointer: {
                        type: 'shadow'
                    },
                    axisLabel: {
                        interval: 0,
                    }
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
                        formatter: '{value}%'
                    }
                }
            ],
            series: [
                {
                    name: '销售金额',
                    type: 'bar',
                    barMaxWidth: 50,
                    data: [2.0, 4.9, 7.0, 23.2],
                    markPoint: {
                        symbolSize: 1,
                        data: []
                    }
                },
                {
                    name: '销售金额份额',
                    type: 'line',
                    yAxisIndex: 1,
                    data: [2.0, 2.2, 3.3, 4.5]
                }
            ]
        };
        //单垂直柱状图
        $scope.verticalityOption = {
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                top:'18%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                data: [],
                axisPointer: {
                    type: 'shadow'
                },
                axisLabel: {
                    interval: 0,
                }
            },
            title: {
                x:'center',
                text: '',
                subtext: '',
                sublink: 'http://e.weibo.com/1341556070/AjwF2AgQm'
            },
            tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            yAxis: {
                type: 'value',
                splitLine: {show: false},
                axisLabel: {
                    formatter: '{value}'
                }
            },
            series: [{
                name: '柱图',
                type: 'bar',
                label: {
                    normal: {
                        show: false,
                        formatter: '{b}'
                    }
                },
                data: [],
                itemStyle:{},
                markPoint: {
                     symbolSize: 1,
                     data: []
                }
            }]
        };
        //双折线图
        $scope.lineTwoOption = {
            color:$scope.colors,
            legend: {
                itemWidth: 10,
                itemHeight: 10,
                left: 180,
                width: 300,
                icon: 'circle',
                data: []
            },
            title: [{
                left: 'left',
                text: '销售金额',
                subtext: '纯属虚构'
            }, {
                top: '50%',
                left: 'left',
                text: '销售金额份额',
                subtext: '纯属虚构'
            }],
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
                            var axisData = opts.option.xAxis[0].data; //坐标数据
                            // console.log(opts);
                            var title = opts.option.title[0].text;
                            var str = '时间,期数,';
                            var str1 = '时间,期数,';
                            //组装表头
                            var arrData = [];
                            var nameArr = [];
                            for (var product = 0; product < series.length; product++) {
                                if (nameArr.indexOf(series[product].name) == -1) {
                                    nameArr.push(series[product].name);
                                    str += series[product].name + `,`;
                                    str1 += series[product].name + `,`;
                                }
                                if (arrData[series[product].name]) {
                                    arrData[series[product].name].push(series[product].data);
                                } else {
                                    arrData[series[product].name] = [series[product].data];
                                }
                            }
                            str += `\n`;
                            str1 += `\n`;
                            // console.log(nameArr,arrData);
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
                                str += time + `,` + stage + `,`;
                                str1 += time + `,` + stage + `,`;
                                //详细数据
                                for (var k = 0; k < nameArr.length; k++) {
                                    // console.log(nameArr[k],arrData[nameArr[k]]);
                                    str += `${parseFloat(arrData[nameArr[k]][0][lt].toFixed(4)) + '\t'}` + `,`;
                                    str1 += `${parseFloat(arrData[nameArr[k]][1][lt].toFixed(4)) + '\t'}` + `,`;
                                }
                                str += '\n';
                                str1 += '\n';
                            }
                            var head = opts.option.title[0].subtext + ':\n';
                            var head1 = opts.option.title[1].subtext + ':\n';
                            var total = head + str + head1 + str1;
                            //encodeURIComponent解决中文乱码
                            let uri = 'data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(total);
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
            tooltip: {
                trigger: 'axis',
            },
            xAxis: [{
                type: "category",
                boundaryGap: false,
                data: []
            }, {
                type: "category",
                boundaryGap: false,
                data: [],
                gridIndex: 1
            }],
            yAxis: [{
                splitLine: {show: false},
                gridIndex: 0
            }, {
                splitLine: {show: false},
                gridIndex: 1
            }],
            grid: [{
                bottom: '60%',
                left: '15%'
            }, {
                top: '60%',
                left: '15%'
            }],
            series: [{
                type: 'line',
                // showSymbol: false,
                data: []
            }, {
                type: 'line',
                // showSymbol: false,
                data: [],
                yAxisIndex: 1
            }]
        };
        $scope.exportpdf = function () {
            $('.export-pdf').show();
            //   $('body').addClass('body-active');
            $('#edit-name').val($('#Search_month').val() + '-' + $scope.selcity);
        }
    });
    //上下滚动指令
    app.directive('whenScrolled', function () {
        return function (scope, elm, attr) {
            // console.log(scope, elm, attr);
            // 内层DIV的滚动加载
            var raw = elm[0];
            elm.bind('scroll', function () {
                //scrollHeight:内容高度。scrollTop:网页卷起来的高度。offsetHeight:控件的实际高度+border的宽度
                if (raw.scrollTop + raw.clientHeight >= raw.scrollHeight) {
                    scope.$apply(attr.whenScrolled);
                }
            });
        };
    });
    //左右滚动指令
    app.directive('aroundScrolled', function () {
        return function (scope, elm, attr) {
            var raw = elm[0];
            elm.bind('scroll', function () {
                if (raw.scrollLeft + raw.clientWidth >= raw.scrollWidth) {
                    scope.$apply(attr.aroundScrolled);
                }
            });
        };
    });
    //执行正负轴柱状图表
    app.directive('onFinishBar', function ($timeout) {
        return {
            restrict: 'A',
            link: function(scope, element, attr) {
                if (scope.$last === true) {
                    $timeout(function() {
                        scope.$emit('ngRepeatBar');
                    });
                }
            }
        };
    });
    app.filter('reverse', function () { //返回时间
        return function (text) {
            if (text != null) {
                return (text.slice(5, 6) == 'Q' || text.slice(5, 6) == 'q') ? text.slice(0, 4) + '年第' + text.slice(6, 7) + '季度' : text.slice(0, 4) + '年' + text.slice(5, 7) + '月';
            }
        }
    });
    app.filter('startFrom', function() {
        return function(input, start) {
            if(input) {
                start = +start; //parse to int
                return input.slice(start);
            }
            return [];
        }
    });
    app.filter('numParsh', function() {
        return function(num) {
            return (parseFloat(num)).toFixed(1);
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
                            <input type="checkbox" value="aap1" checked="checked"><?= Yii::t('cvs', 'KO销售金额份额'); ?>
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
                        <span><?= Yii::t('cvs', '平均售价'); ?>:</span>
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
                    <div class="psl-arr">
                        <span><?= Yii::t('cvs', '平均购买价'); ?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp4-dp1"><?= Yii::t('cvs', '本期值'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp4-dp2"><?= Yii::t('cvs', '变化率'); ?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp4-dp3"><?= Yii::t('cvs', '趋势'); ?>
                        </label>
                    </div>
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
            <?php $this->renderPartial("headerRetail", array("searchmodel" => $searchmodel)) ?>
        </nav>
        <!--主体部分-->
        <div id="body" class="row">
            <div class="map-col" style="margin-left:0;position: relative;" id="map-derive">
                <div class="map-men map-men1">
                    <?= BSHtml::image(Yii::app()->baseUrl . '/images/temp_08091512529506.gif'); ?>
                </div>
                <div class="map-wrap" id="map-view">
                    <div class="right-bottom-export js-rb-export" title="导出该模块" t="map"></div>
                    <div id="container"></div>
                    <div class="legend">
                        <div><?= Yii::t('cvs', 'KO销售金额份额'); ?></div>
                        <div ng-repeat="(i,ko) in groupInfo">
                            <pre class="{{i==2?'taiGu':(i==3?'inMay':'ZH')}}"></pre>
                            {{ko[1]}}
                            <span
                                    ng-if="ko[3] > 0"><?= BSHtml::image(Yii::app()->baseUrl . '/images/up.png'); ?></span>
                            <span
                                    ng-if="ko[3] < 0"><?= BSHtml::image(Yii::app()->baseUrl . '/images/down.png'); ?></span>
                            <span ng-if="ko[3] == null || ko[3] == 0" class="change"><?= Yii::t('cvs', 'N/A'); ?></span>

                        </div>
                    </div>
                </div>
            </div>
            <!--主体部分中侧内容-->
            <div class="map-col">
                <div class="row radius10" id="generalize-view" style="position:relative;overflow:hidden;">
                    <div class="right-bottom-export js-rb-export" title="导出该模块" t="generalize"></div>
                    <div class="map-men map-men2">
                        <?= BSHtml::image(Yii::app()->baseUrl . '/images/temp_08091512529506.gif'); ?>
                    </div>
                    <div class="row graphica1" style="margin: 16px 0;">
                        <!-- 饼图 -->
                        <div class="col-md-12" style="padding:0" id="gr1" con="饼图">
                            <div class="col-md-12 summarize"
                                 style="border: 1px solid #DDDDDD"><?= Yii::t('cvs', '概括') ?></div>
                            <div class="graphical2">
                                <?php
                                //总total，常温，冷藏，暖柜都需要显示
                                $this->renderpartial("_piechartRetail", array(
                                    'kpiname' => "pie1",
                                    'comparName' => Yii::t('cvs', "网店数"),
                                    'kpi' => 'pieData.nartd.enrollment',
                                    'kpirate' => 'pieData.nartd.last_enrollment',
                                    'intro' => Yii::t('cvs', '网店上线率'),
                                    'title' => Yii::t('cvs', '该数据范围内网店数（不同平台之间未打通，即1家线下门店在3个平台上线算3家网店）/该数据范围内线下门店数*3（与网店未打通计算方式保持一致）'),
                                ));
                                $this->renderpartial("_piechartRetail", array(
                                    'kpiname' => "pie2",
                                    'comparName' => Yii::t('cvs', '铺货网店数'),
                                    'kpi' => 'pieData.ko.distribution',
                                    'kpirate' => 'pieData.ko.last_distribution',
                                    'intro' => Yii::t('cvs', 'KO铺货率'),
                                    'title' => Yii::t('cvs', '该数据范围内线上在售任一KO产品网店数/该数据范围内全部网店数'),
                                ));
                                ?>
                            </div>
                            <div class="graphical2">
                                <?php
                                $this->renderpartial("_piechartRetail", array(
                                    'kpiname' => "pie3",
                                    'comparName' => Yii::t('cvs', "销售金额（元）"),
                                    'kpi' => 'pieData.ko.sales_share',
                                    'kpirate' => 'pieData.ko.last_sales_share',
                                    'intro' => Yii::t('cvs', 'KO销售金额份额'),
                                    'title' => Yii::t('cvs', '该数据范围内KO销售金额/该数据范围内全部软饮销售金额'),
                                ));
                                $this->renderpartial("_piechartRetail", array(
                                    'kpiname' => "pie4",
                                    'comparName' => Yii::t('cvs', "销售件数（件）"),
                                    'kpi' => 'pieData.ko.sales_quota',
                                    'kpirate' => 'pieData.ko.last_sales_quota',
                                    'intro' => Yii::t('cvs', 'KO销售件数份额'),
                                    'title' => Yii::t('cvs', '该数据范围内KO销售件数/该数据范围内全部软饮销售件数'),
                                ));
                                ?>
                            </div>
                        </div>
                        <!--进度条-->
                        <div class="col-md-12" style="padding:0;margin-top:10px;">
                            <div id="rate-box-left">
                                <div class="row" style="overflow: auto;">
                                    <?php
                                    $this->renderpartial("_kpiitemRetail", array(
                                        'time' => "month",
                                        'site' => "selcity",
                                        'kpiname' => Yii::t('cvs', '平均每单饮料件数（搭售率）'),
                                        'title' => Yii::t('cvs', '该数据范围内销售件数/该数据范围内线上在售网店订单数'),
                                        'kpi' => array(
                                            'ko_value' => "pieData.ko.average_number_per_unit",
                                            'ko_changerate' => "pieData.ko.last_average_number_per_unit",
                                            'NARTD_value' => "pieData.nartd.average_number_per_unit",
                                            'NARTD_changerate' => "pieData.nartd.last_average_number_per_unit",
                                            'precent' => "1"
                                        )
                                    ));
                                    $this->renderpartial("_kpiitemRetail", array(
                                        'time' => "month",
                                        'site' => "selcity",
                                        'kpiname' => Yii::t('cvs', '平均单店SKU数'),
                                        'title' => Yii::t('cvs', '该数据范围内SKU数/该数据范围内网店数'),
                                        'kpi' => array(
                                            'ko_value' => "pieData.ko.sku_number",
                                            'ko_changerate' => "pieData.ko.last_sku_number",
                                            'NARTD_value' => "pieData.nartd.sku_number",
                                            'NARTD_changerate' => "pieData.nartd.last_sku_number",
                                            'precent' => "1"
                                        )
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!--主体部分右侧内容-->
            <div class="map-col">
                <div class="row radius10" id="ranking-view" style="position:relative;overflow:hidden;">
                    <div class="right-bottom-export js-rb-export" title="导出该模块" t="ranking"></div>
                    <div class="map-men map-men2">
                        <?= BSHtml::image(Yii::app()->baseUrl . '/images/temp_08091512529506.gif'); ?>
                    </div>
                    <!-- 排行 -->
                    <div class="row graphica1" style="margin: 16px 0;">
                        <div class="col-md-12" style="padding:0;" id="gr2" con="KO TOP10">
                            <div class="row">
                                <div title="该数据范围内销售金额排名前十的KO产品（排除其他包装及销量为0的产品）" con="KO" class="col-md-4 k_summarize" id="ko_ummarize" ng-click="koCompeting(1)">
                                    <?= Yii::t('cvs', 'KO') ?> TOP10 SKU
                                </div>
                                <div title="该数据范围内销售金额排名前十的竞品产品（排除其他包装及销量为0的产品）" con="竞品" class="col-md-4 k_summarize" id="no_ummarize" ng-click="koCompeting(2)">
                                    <?= Yii::t('cvs', '竞品') ?> TOP10 SKU
                                </div>
                                <div title="该数据范围内销售金额排名前十的竞品产品（排除其他包装及销量为0的产品）" con="NARTD" class="col-md-4 k_summarize" id="NARTD_ummarize" ng-click="koCompeting(3)">
                                    <?= Yii::t('cvs', 'NARTD') ?> TOP10 SKU
                                </div>
                            </div>
                            <div class="col-md-12 main-right-right">
                                <div class="top_class">
                                    <table>
                                        <tr>
                                            <td class="col-md-2"><b>排名</b></td>
                                            <td class="col-md-4"><b>商品名称</b></td>
                                            <td class="col-md-2"><b>包装瓶数</b></td>
                                            <td class="col-md-2"><b>销售金额</b></td>
                                            <td class="col-md-2"><b>VS PP</b></td>
                                        </tr>
                                        <tr ng-repeat="(key,itemRank) in rank[classify] | limitTo:10">
                                            <td class="col-md-2 value-over-{{classify}}-{{key}}">
                                                    <span class="common1 first-top" ng-if="key+1 == 1"
                                                          ng-cloak>{{key+1}}</span>
                                                <span class="common1 second-top" ng-if="key+1 == 2"
                                                      ng-cloak>{{key+1}}</span>
                                                <span class="common1 thirdly-top" ng-if="key+1 == 3"
                                                      ng-cloak>{{key+1}}</span>
                                                <span class="common1" ng-if="key+1 > 3" ng-cloak>{{key+1}}</span>
                                            </td>
                                            <td class="col-md-4 value-over-{{classify}}-{{key}}" ng-bind="itemRank.sku_name"></td>
                                            <td class="col-md-2 value-over-{{classify}}-{{key}}" ng-bind="itemRank.bottle"></td>
                                            <td class="col-md-2 value-over-{{classify}}-{{key}}" ng-bind="(itemRank.sales_amount |number:0)"></td>
                                            <td class="col-md-2 value-over-{{classify}}-{{key}}" ng-if="itemRank.last_sales_amount > 0">
                                                <span class="green"
                                                      ng-bind="'+'+(itemRank.last_sales_amount|numParsh)+' pts '"></span><img
                                                        src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                                            </td>
                                            <td class="col-md-2 value-over-{{classify}}-{{key}}" ng-if="itemRank.last_sales_amount == 0 || itemRank.last_sales_amount == null">
                                                <span class="change">N/A</span>
                                            </td>
                                            <td class="col-md-2 value-over-{{classify}}-{{key}}" ng-if="itemRank.last_sales_amount < 0">
                                                <span class="change"
                                                      ng-bind="(itemRank.last_sales_amount|numParsh)+' pts '"></span><img
                                                        src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <?php
        $this->renderpartial("detailsRetail", array());
        ?>
    </div>
</div>
<div style="display: none" class="downExcel"></div>
<div id="returnTop" style="display: none">
    <div id="test" style="position:fixed;right:30px;bottom:30px;cursor: pointer;z-index:1000;">
        <img src="<?= Yii::app()->baseUrl . '/images/top.png' ?>">
    </div>
</div>
<?php
//支持csrf安全验证
$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id' => 'imgs-form',
    'enableAjaxValidation' => false,
    'action' => array("zipimg"),
    'htmlOptions' => array("class" => "hide")
));

$this->endWidget();
?>
<script>
    $(function () {
        //区域

        if (<?php echo !empty($searchmodel->factory) ? 1 : 0;?>) {
            $('#Search_factory').val(<?php echo $searchmodel->factory; ?>);
            $('#Search_factory').trigger('change');
        }
        if (<?php echo !empty($searchmodel->city) ? 1 : 0;?>) {
            $('#Search_city').val(<?php echo $searchmodel->city; ?>);
            $('#Search_city').trigger('change');
        }
        if (<?php echo !empty($searchmodel->station) ? 1 : 0;?>) {
            $('#Search_station').val(<?php echo $searchmodel->station; ?>);
            $('#Search_station').trigger('change');
        }
        //品类
        if (<?php echo !empty($searchmodel->category) ? 1 : 0;?>) {
            $('#Search_category').val(<?php echo $searchmodel->category; ?>);
            $('#Search_category').trigger('change');
        }
        //容量分级
        if (<?php echo !empty($searchmodel->capacity) ? 1 : 0;?>) {
            $('#Search_category').val(<?php echo $searchmodel->capacity; ?>);
            $('#Search_category').trigger('change');
        }
        //瓶量分级
        if (<?php echo !empty($searchmodel->bottle) ? 1 : 0;?>) {
            $('#Search_category').val(<?php echo $searchmodel->bottle; ?>);
            $('#Search_category').trigger('change');
        }
        if (<?php echo !empty($searchmodel->capacity) ? 1 : 0;?>) {
            $('#Search_category').val(<?php echo $searchmodel->capacity; ?>);
            $('#Search_category').trigger('change');
        }
        if (<?php echo !empty($searchmodel->brand) ? 1 : 0;?>) {
            $('#Search_brand').val(<?php echo $searchmodel->brand; ?>);
            $('#Search_brand').trigger('change');
        }
        if (<?php echo !empty($searchmodel->mode) ? 1 : 0;?>) {
            $('#Search_mode').val(<?php echo $searchmodel->mode; ?>);
            $('#Search_mode').trigger('change');
        }


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
        })

//    $('#deepdive').hover(function(){
//        $(this).addClass('active')
//    },function(){
//        $(this).removeClass('active')
//    })

        $(document).on('click', '#order-more', function () {
            let oType;
            for (let i = 0; i < $('.radius10 .nav-pills .change-map').length; i++) {
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
        })
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

        setMap(false, '');//调用地图

        //NARTD改变样式加粗
        $(document).on('click','#NARTD_ummarize',function(){
            var arrRank = ['冰露','雪碧', '芬达', '可口可乐', '美汁源', '零度可乐', '怡泉', '健怡可乐', '纯悦', '樱桃味可乐','酷儿', '乔雅',
                '乐虎', '神纤水', '唷茶', '淳茶舍', '醒目', '雪菲力'];
            var r_length = <?= CJSON::encode($datas['rank'])?>;
            if(!($.isEmptyObject(r_length))){
                var rankData = <?= CJSON::encode(isset($datas['rank'][3])?$datas['rank'][3]:[]); ?>;
                for(var i =0; i<rankData.length;i++){
                    for(var j =0 ;j<arrRank.length;j++){
                        var match = rankData[i].sku_name.match(arrRank[j]);
                        if(match != "" && match != null ){
                            var dunRank = document.getElementsByClassName("value-over-3-"+i);
                            for(var x =0; x < dunRank.length;x++){
                                dunRank[x].className += ' matchClassName'; //在原来的后面加这个
                            }
                        }
                    }
                }
            }
        });
    });
</script>
<script src="https://webapi.amap.com/maps?v=1.4.1&key=6e4d02aa84a4cc6669b16788c01ac14a&plugin=AMap.Geocoder"></script>
<script src="https://webapi.amap.com/ui/1.0/main.js?v=1.0.11"></script>
<script>
    function setMap(type, data) {
        var koinfos = new Array();
        if (type) {
            koinfos = data['koinfos'];
            specificArea = data['koinfoss'];
            console.log('地图数据1', koinfos);
            console.log('特殊区域地图数据1', specificArea);
        } else {
            koinfos =<?php echo CJSON::encode($datas['koinfos']); ?>;
            specificArea = <?php echo CJSON::encode($datas['koinfoss']); ?>;
            console.log('地图数据', koinfos);
            console.log('特殊区域地图数据', specificArea);
        }
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
            // console.log('cityList',cityList);
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
                        // console.log('subFeatures',subFeatures);
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
                            // console.log('num',num);
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
                marker = new AMap.Marker({
                    position: specificArea[i][2].split(',')
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
                // console.log('marker',marker);
                marker.setMap(map);
            }
            for (var i = 0; i < koinfos.length; i++) {
                if (!containss(koinfos[i][1], specificArea)) {
                    //["2", "安徽", "-0.24606379861576835", "1", "8", "安徽"]
                    addBeiJing(koinfos[i][0], koinfos[i][1], koinfos[i][2],
                        koinfos[i][2], koinfos[i][4], koinfos[i][2], koinfos[i][2], koinfos[i][2], koinfos[i][5]);
                }
            }
            function addBeiJing(leval, area, puhuo, sovi, v, yichang, huodong, salesShare, showarea) {
                //("2","安徽","-0.24606379861576835","-0.24606379861576835","8","-0.24606379861576835","-0.24606379861576835","-0.24606379861576835","安徽")
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
                        if (typeof result.districtList != "undefined" ? true : false) {
                            for (let i = 0; i < result.districtList.length; i++) {
                                if (result.districtList[i].level !== 'district') {
                                    subDistricts = result.districtList[i];
                                    break;
                                }
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
                            marker.setMap(map);
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
            }, 4000)
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
                    map.setZoomAndCenter(5, specificArea[2][2].split(','));
                } else if (s == '2') {
                    $("#Search_region").val(2);
                    $("#Search_region").trigger("change");
                    map.setZoomAndCenter(5, specificArea[1][2].split(','));
                }

            })
            $(document).on('click', '.amap-marker-label', function (e) {
                var clickValue = $(this).find('div span').html();
                var clickid = $(this).find('div').attr('v');
                if (containss(clickValue, specificArea)) {
                    for (var i = 0; i < specificArea.length; i++) {
                        if (clickValue == specificArea[i][1]) {
                            map.setZoomAndCenter(7, specificArea[i][2].split(','));
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
                                    marker.setMap(smap);
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
    function mapScreen() {
        var cityLevel = $("#Search_cityLevel").val();
        var ditch = $("#Search_systemtype").val();
        var platform = $("#Search_platform").val();
        var category = $("#Search_category").val();
        var month = $("#Search_month").val();
        var stage = $("#Search_stage").val();
        $.ajax({
            type: "GET",
            url: "<?php echo $this->createurl("getMapData"); ?>",
            data: {
                cityLevel: cityLevel,//城市等级
                ditch: ditch,//渠道
                platform: platform,//平台
                category: category,//品类
                month: month,//月份
                stage: stage//期数
            },
//            dataType: "json",
            success: function (data) {
//                console.log("测试",JSON.parse(data));
                var info = JSON.parse(data);
                setMap(true, info)
            },
            error: function (e) {
                alert(e);
            }
        });
    }
</script>
<script src="<?php echo Yii::app()->baseUrl . '/js/html2canvas.js'; ?>"></script>
<!--<script src="--><?php //echo Yii::app()->baseUrl . '/js/html2canvas.min.js'; ?><!--"></script>-->
<script>
    $(function () {
        var timerm3 = null;
        var timerm4 = null;
        var timerm5 = null;
        $(document).on('click', '.close', function () {
            $('body').removeClass('body-active');
            $('.export-pdf').hide();
        })
        $(document).on('click', '#pdf-submit', function () {
            // if($('.chart-box ng-echarts').length>16){
            //     layer.tips('最多选择16个对比项!', '#pdf-submit', {
            //         tips: [1, '#3595CC'],
            //         time: 3500
            //     });
            //     return false
            // }
            $('.export-pdf').hide();
            var checkedList = [];
            for (let f = 0; f < $('.export-select-list label').length; f++) {
                if ($('.export-select-list input').eq(f).prop('checked')) {
                    checkedList.push($('.export-select-list input').eq(f).val());
                }
            }
            console.log(checkedList);
            $('#progress').html(1 + '/' + checkedList.length);
            $('.pdftips').addClass('active');
            $(document).scrollTop(0);
            $("#imgs-form input[name!='YII_CSRF_TOKEN']").remove();
            var pdfName = $('#edit-name').val();
            exportFiles(pdfName, checkedList, 0);
        });

        function exportFiles(name, arr, i) {
            var trigger_info = triggerInfo(arr[i]);
            console.log(trigger_info);
            var _part;
            switch (trigger_info.export_part) {
                case '#map-derive':
                    _part = '地图';
                    break;
                case '#data-view':
                    _part = '仪表盘';
                    break;
                case '#chart-view':
                    _part = '图表';
                    break;
            }
            if (trigger_info.trigger_item.length > 1) {
                var eName = $('#Search_month').val() + '_' + _part + $('#' + trigger_info.trigger_item[1]).attr('con');
                console.log(eName)
                $('#' + trigger_info.trigger_item[0]).trigger('click');
                setTimeout(function () {
                    $('#' + trigger_info.trigger_item[1]).trigger('click');
                    if (trigger_info.trigger_item[1] == 'dp3') {
                        clearInterval(timerm4);
                        timerm4 = setInterval(function () {
                            if ($('#chart-view').children('.mb-fff').length <= 0) {
                                // console.log(123414)
                                clearInterval(timerm4);
                                method1();
                            }
                        }, 100)
                    } else {
                        method1();

                    }
                }, trigger_info.loadingtime)
            } else {
                var eName = $('#Search_month').val() + '_' + _part + $('#' + trigger_info.trigger_item[0]).attr('con');
                console.log(eName)
                $('#' + trigger_info.trigger_item[0]).trigger('click');
                method1();

            }

            function method1() {
                setTimeout(function () {
                    $('.chart-box').height('auto');
                    html2canvas($(trigger_info.export_part), {
                        background: '#fff',
                        onrendered: function (canvas) {
                            var url = canvas.toDataURL();
                            $("<textarea name='" + eName + "'>" + url + "</textarea>").appendTo("#imgs-form");
                            if (i >= arr.length - 1) {
                                $('nav').show();
                                $("<input name='" + i + "'>").appendTo("#imgs-form");
                                $('#imgs-form').submit();
                                $('.pdftips').removeClass('active');
                                $('.chart-box').height('480px');
                                $('body').removeClass('body-active');
                                $('.js-rb-export').show();
                            } else {
                                i++;
                                $('#progress').html(i + 1 + '/' + arr.length);
                                exportFiles(name, arr, i);
                            }

                        },
                        width: $(trigger_info.export_part).outerWidth(),
                        height: $(trigger_info.export_part).outerHeight()
                    })
                }, trigger_info.loadingtime)
            }
        }

        function triggerInfo(el) {
            let trigger_item, loadingtime, export_part;
            if (new RegExp('aap').test(el)) {  //地图
                trigger_item = [el.substr(1)]
                export_part = '#map-derive';
                loadingtime = 4500;
            } else if (new RegExp('bap').test(el)) {  //仪表盘
                trigger_item = [el.substr(1)]
                export_part = '#data-view';
                loadingtime = 1500;
            } else if (new RegExp('cp').test(el)) {  //图表
                trigger_item = el.split('-');
                export_part = '#chart-view';
                loadingtime = 1500;
            }
            return {
                'trigger_item': trigger_item,   //模拟点击内容
                'export_part': export_part,    //导出板块
                'loadingtime': loadingtime    //导出等待时间，根据板块自定义
            }
        }

        function exSingle(el, arr, i, time, n, m) {//截图区域，点击数组，从0开始，等待时间，基本名字，
            var eName = n + (m ? m : $(arr[i]).attr('con'));
            console.log(eName);
            if (i > 0) {
                $(arr[i]).trigger('click');
            }
            if (arr[i] == '#dp3') {
                clearInterval(timerm5);
                timerm5 = setInterval(function () {
                    if ($('#chart-view').children('.mb-fff').length <= 0) {
                        clearInterval(timerm5);
                        method2();
                    }
                }, 5000);
            } else {
                method2();
            }
            function method2() {
                clearTimeout(timerm3);
                $('.chart-box').height('auto');
                // $('.chart-box').width('auto');
                timerm3 = setTimeout(function () {
                    html2canvas($(el), {
                        // backgroundColor: '#fff',
                        height: $(el).outerHeight(),
                        // useCORS: true, // 【重要】开启跨域配置
                        // windowHeight:document.body.scrollHeight,
                        // windowWidth:document.body.scrollWidth,
                        onrendered: function (canvas) {
                            var url = canvas.toDataURL();
                            $("<textarea name='" + eName + "'>" + url + "</textarea>").appendTo("#imgs-form");
                            i++;
                            if (i < arr.length) {
                                exSingle(el, arr, i, time, n, m);
                            } else {
                                $("<input name='" + n + "'></input>").appendTo("#imgs-form");
                                $('#imgs-form').submit();
                                $('.fixed-mb').remove();
                                $('.chart-box').height('523px');
                                $('.js-rb-export').show();
                            }
                        },
                    })
                    // let canvas = document.createElement("canvas");
                    // canvas.height = $(el).outerHeight();   // 最终图片高度315px的2倍，以px为单位
                    // let opts = {
                    //     canvas: canvas                       // 将自定义canvas作为配置项
                    // };
                    // // 参数：element为要保存元素的DOM对象，option为可配置项
                    // html2canvas($(el)[0], opts).then(function (canvas) {
                    //     var url = canvas.toDataURL();
                    //     $("<textarea name='" + eName + "'>" + url + "</textarea>").appendTo("#imgs-form");
                    //     i++;
                    //     if (i < arr.length) {
                    //         exSingle(el, arr, i, time, n, m);
                    //     } else {
                    //         $("<input name='" + n + "'></input>").appendTo("#imgs-form");
                    //         $('#imgs-form').submit();
                    //         $('.fixed-mb').remove();
                    //         $('.chart-box').height('523px');
                    //         $('.js-rb-export').show();
                    //     }
                    // });
                }, time);
            }
        }

        $(document).on('click', '#export-whole', function () {
            var text = $('#edit-name').val();
            var reg = new RegExp("[\\u4E00-\\u9FFF]+", "g");
            if (text == '') {
                layer.msg('命名不能为空');
                //     }else if(reg.test(text)){
                //         layer.msg('请避免使用汉字命名');
            } else {
                $(document).scrollTop(0);
                $('<div>', {
                    class: 'fixed-mb'
                }).appendTo('body');
                $("#imgs-form input[name!='YII_CSRF_TOKEN']").remove();
                $(".export-pdf").hide();
                layer.closeAll();
                console.log(text);
                exSingle('#cvs', [''], 0, 300, text);
            }
        });
        //导出ptf
        $(document).on('click', '.js-rb-export', function () {
            $('.js-rb-export').hide();//将导入的图标隐藏
            let clickItem = $(this).attr('t');//获取属性t的值
            $('<div>', {
                class: 'fixed-mb'
            }).appendTo('body');//在body元素的结尾添加一个div，class为“fixed-mb”
            $("#imgs-form input[name!='YII_CSRF_TOKEN']").remove();
            console.log(clickItem);
            switch (clickItem) {
                case 'map'://地图
                    var _name = $('#Search_month').val() + '_'+ $('#Search_stage').val()+'_地图';
                    exSinglePdf('#map-derive', _name);
                    break;
                case 'generalize'://概括
                    var _name = $('#Search_month').val() + '_'+ $('#Search_stage').val()+'_概括';
                    exSinglePdf('#generalize-view', _name);//截图,名字
                    break;
                case 'ranking'://排名
                    var arrList = ['#ko_ummarize','#no_ummarize','#NARTD_ummarize'];//模拟点击
                    var _name = $('#Search_month').val() + '_'+ $('#Search_stage').val()+'_概括_';
                    exMultePdf('#ranking-view', arrList, 0, 600, _name);//截图数组，点击数组，从0开始，执行时间600,名字_name
                    break;
                default:
                    var arrList = ['#dpTotal','#dp3'];//dpTotal:本期值,dp3:趋势
                    var _name = $('#Search_month').val() + '_'+ $('#Search_stage').val();
                    exMultePdf('#chart-view', arrList, 0, 1000, _name);
            }
        });

        //下载单个pdf
        function exSinglePdf(el,n) {//截图区域，点击数组，从0开始，等待时间，基本名字，
            $('.chart-box').height('auto');
            html2canvas($(el), {
                // backgroundColor: '#fff',
                height: $(el).outerHeight(),
                // useCORS: true, // 【重要】开启跨域配置
                // windowHeight:document.body.scrollHeight,
                // windowWidth:document.body.scrollWidth,
                onrendered: function (canvas) {
                    var url = canvas.toDataURL();
                    $("<textarea name='" + n + "'>" + url + "</textarea>").appendTo("#imgs-form");
                    //$("<input name='" + n + "'></input>").appendTo("#imgs-form");
                    $('#imgs-form').submit();
                    $('.fixed-mb').remove();
                    $('.chart-box').height('523px');
                    $('.js-rb-export').show();
                }
            });
        }

        function exMultePdf(el, arr, j, time, _name, m) {//截图数组，点击数组，从0开始，执行时间600,名字_name
            var eName = _name + (m ? m : $(arr[j]).attr('con'));
            if (j > 0) {
                $(arr[j]).trigger('click');
            }
            clearTimeout(timerm3);
            if(arr[j] == '#dpTotal' || arr[j] == '#dp3'){//图表
                var width = $('#scrollHeight').outerWidth();
                var height = $('#scrollHeight').outerHeight();
            }else{//排名
                var width = $(el).outerWidth();
                var height = $(el).outerHeight();
            }
            // $(".main-right-right").height('auto');
            timerm3 = setTimeout(function () {
                html2canvas($(el), {
                    backgroundColor: '#fff',
                    width: width,
                    height: height,
                    onrendered: function (canvas) {
                        var url = canvas.toDataURL();
                        $("<textarea name='" + eName + "'>" + url + "</textarea>").appendTo("#imgs-form");
                        j++;
                        if (j < arr.length) {
                            exMultePdf(el, arr, j, time, _name, m);
                        } else {
                            $("<input name='" + _name + "'></input>").appendTo("#imgs-form");
                            $('#imgs-form').submit();
                            $('.fixed-mb').remove();
                            // $('.main-right-right').height('321px');
                            $('.js-rb-export').show();
                        }
                    }
                })
            }, time);
        }

        function exGeneralize(el, arr, j, time, _name, m) {//截图数组，点击数组，从0开始，执行时间600,名字_name
            var eName = _name + (m ? m : $(arr[j]).attr('con'));
            if (j == 2) {
                $(arr).trigger('click');
                var suffix = "竞争 TOP10";
                eName = _name + suffix;
            }
            console.log("eName:", eName);
            method3();

            function method3() {
                clearTimeout(timerm3);
                $(el[j]).height('auto');
                $(".main-right-right").height('auto');
                timerm3 = setTimeout(function () {
                    html2canvas($(el[j]), {
                        backgroundColor: '#fff',
                        width: $(el[j]).outerWidth(),
                        height: $(el[j]).outerHeight(),
                        onrendered: function (canvas) {
                            var url = canvas.toDataURL();
                            $("<textarea name='" + eName + "'>" + url + "</textarea>").appendTo("#imgs-form");
                            j++;
                            if (j < el.length) {
                                exGeneralize(el, arr, j, time, _name, m);
                            } else {
                                $("<input name='" + _name + "'></input>").appendTo("#imgs-form");
                                $('#imgs-form').submit();
                                $('.fixed-mb').remove();
                                $('.main-right-right').height('321px');
                                $('.js-rb-export').show();
                            }
                        },
                    })
                }, time);
            }
        }
    });
    $(document).scroll(function () {
        getbrowser();
    });

    function getbrowser() {
        var height = $(document).scrollTop(); //获取滚动条到顶部的垂直高度
        if (height > 100) {
            $("#returnTop").show();
            test.onclick = function () {
                document.body.scrollTop = document.documentElement.scrollTop = 0;
            }
        } else {
            $("#returnTop").hide();
        }
    }
</script>