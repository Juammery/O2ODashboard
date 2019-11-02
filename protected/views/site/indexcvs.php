<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/echarts.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/angular.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/ng-echarts.js');

$relations = RelationshipCvs::model()->findAll(array("index" => "Id"));
$relationss = RelationshipCvs::model()->findAll(array("order" => "sort"));
//foreach($relations as $key=> $value){
//  //  $relations[$key]->name = Yii::t('cvs',$value->name,array(1));
//}
$skus = SkuCvs::model()->findAll(array("index" => "Id"));
$skuss = SkuCvs::model()->findAll(array("order" => "sort"));
$systems=SystemCvs::model()->findAll(array('index'=>'Id'));
$systemss=SystemCvs::model()->findAll(array('order'=>'sort'));
$db=Yii::app()->db;
$sql='select stage as id,stage from cola_info_cvs where time="'.$searchmodel->month.'" GROUP BY  stage order by stage asc';
$stages=$db->createCommand($sql)->queryAll();
//$stages=array_column($stages,'stage');
$stage = 0;
for($i=0;$i<count($stages);$i++){
    if(isset($stages[$i]['id'])&&$stages[$i]['id']==-1){
        $stages[$i]['stage']=Yii::t('cvs','YTD');
    }
    if(isset($stages[$i]['id'])&&$stages[$i]['id']==0){
        $stages[$i]['stage']=Yii::t('cvs','月报');
    }
    if(isset($stages[$i]['id'])&&$stages[$i]['id'] >0){
        $stages[$i]['stage']=Yii::t('cvs','第').$stages[$i]['id'].Yii::t('cvs','期');
    }

    $stage = $stages[$i]['id'];
}

//pd($searchmodel);
//$lastlabel=isset($searchmodel->stage)&&$searchmodel->stage==0 ? '本月':'本期';

?>

<script>

    var app = angular.module('cockdash', ['ng-echarts'], function ($httpProvider) {

    });
    app.factory('datadService',['$window',function($window) {//datadService是用来装数据的
        return{
            set :function(key,value){
                $window.localStorage[key]=value;
            },
            get:function(key,defaultValue){
                return $window.localStorage[key] || defaultValue;
            },
            setObject:function(key,value){    //存储对象，以JSON格式存储
                $window.localStorage[key]=JSON.stringify(value);
            },
            getObject: function (key) {    //读取对象
                return JSON.parse($window.localStorage[key] || '{}');
            }
        }
    }]);
    app.controller("optionchg", function ($scope,datadService, $http) {
        $scope.templetList = datadService.getObject('templetList');
        $scope.region = "1";//区域
        $scope.factory = "0";//装品场
        $scope.city = "0";//城市
        $scope.station="0";
        $scope.month = "<?= $searchmodel->month ?>";//月
        $scope.stage="<?= $searchmodel->stage ?>";//轮次
        $scope.category = "0";  //品类
        $scope.brand = "0";  //品牌
        $scope.SKU = "0";  //sku
        $scope.nodata='';
        $scope.system='0';
        $scope.systemtype='0';
        $scope.deepgroupcheck = 'group';
        $scope.deepbrandcheck = 'catalog';
        $scope.deepsystemcheck = 'systemtype';
        $scope.deepgroupcheck2 = '';  //用来判断折线图是否需要请求数据
        $scope.deepbrandcheck2 = '';
        $scope.deepsystemcheck2 = '';
        $scope.skuvisible = true;

        $scope.brandreadonly = {category:false,brand:false,sku:false};

        $scope.relations = <?php echo CJSON::encode($relations) ?>;
        $scope.relationss = <?php echo CJSON::encode($relationss) ?>;
        $scope.relationslist = $scope.relationss;
        console.log('relations',$scope.relations)

        $scope.skus = <?php echo CJSON::encode($skus) ?>;
        $scope.skuss = <?php echo CJSON::encode($skuss) ?>;
        $scope.skuslist = $scope.skuss;

        $scope.systems=<?php echo CJSON::encode($systems)?>;
        $scope.systemslist = <?php echo CJSON::encode($systemss)?>;
        console.log('systemss',$scope.systemslist)

        $scope.stages=<?php echo CJSON::encode($stages)?>;
        console.log("期数",$scope.stages);
        //下拉框
        $scope.typeData =  [
            {"label" : "1", "value" : "VS PP"},
            {"label" : "0", "value" : "VS LM"},
            {"label" : "-1", "value" : "VS LY"}
        ];
        $scope.myselect = "1";
        $("#myselect").find("option[value='1']").prop("selected",true);
        $scope.getDataType = function(){
            switch($scope.myselect){
                case "1" :   //期数的值
                    angular.forEach($scope.stages, function (data, index, array) {
                        $scope.maxStage = data.id;
                    });
                    $scope.stage = $scope.maxStage;
                    $("#Search_stage").find("option[value='{{stage}}']").prop("selected",true);
                    break;
                case "0" :  //月值
                    $scope.stage = 0;
                    $("#Search_stage").find("option[value='0']").prop("selected",true);
                    break;
                case "-1" :  //YTD
                    $scope.stage = -1;
                    $("#Search_stage").find("option[value='-1']").prop("selected",true);
                    break;
            }
            $scope.onoptionchange(6);
            console.log("头部下拉框选中的值：",$scope.myselect);
        };

        $scope.labels=<?php echo CJSON::encode($datas['labels'])?>;

        console.log('labels',$scope.labels);

        angular.forEach($scope.relations, function (data, index, array) {
            $scope.relations[index]['checked'] = true;
            $scope.relations[index]['show'] = false;
        });
        angular.forEach($scope.skus, function (data, index, array) {
            if(data.depth == 1) {
                $scope.skus[index]['checked'] = 1;
            }else {
                $scope.skus[index]['checked'] = 0;
            }
        });
        angular.forEach($scope.relationss, function (data, index, array) {
            $scope.relationss[index]['checked'] = true;
            $scope.relationss[index]['show'] = false;
        });
        // console.log($scope.relations)

        angular.forEach($scope.skuss, function (data, index, array) {
            if(data.depth == 1) {
                $scope.skuss[index]['checked'] = 1;
            }else {
                $scope.skuss[index]['checked'] = 0;
            }
        });
        console.log('skuss',$scope.skuss)
        angular.forEach($scope.systems, function (data, index, array) {
            if(data.depth == 1) {
                $scope.systems[index]['checked'] = 1;
            }else {
                $scope.systems[index]['checked'] = 0;
            }
        });
        console.log('systems',$scope.systems)
        $scope.kopciinfos = <?php echo CJSON::encode($datas['kopciinfos'])?>;
        $scope.totalfixed = <?php echo CJSON::encode($datas['totalfixed'])?>;

        $scope.koinfos = <?php echo CJSON::encode($datas['koinfos'])?>;
        //console.log('kopciinfos',$scope.kopciinfos)

        $scope.allskuinfos = "";
        $scope.visitab = "distribution";
        $scope.visitab2 = "Last_distribution_radio";
        // $scope.visichart = "attach_rate";
        $scope.history = {
            'distribution': 0,
            'distribution_stores': 0,
            'sovi': 0,
            'shelf_number': 0,
            'price_anomaly': 0,
            'thematic_activity': 0,
            'promotion':0,
            'equipment_sales':0,
            'extra_displays':0
        };
        $scope.saveName = '';
        $scope.openSave = function(){
            $scope.saveName = '';
            var head = '';
            for(let i=0;i<$('#form .chosen-single span').length;i++){
                head += '' + $('#form .chosen-single span').eq(i).html() + ',';
            }
            head += '' + $('#Search_month').val();
            var middle1 = '';
            var middle2 = '';
            if($('.sel-con.a .active').length>12){
                for(let i=0;i<12;i++){
                    middle1 += '' + $('.sel-con.a .active').eq(i).siblings('span').html() + ',';
                }
                middle1 += '...'
            }else{
                for(let i=0;i<$('.sel-con.a .active').length;i++){
                    middle1 += '' + $('.sel-con.a .active').eq(i).siblings('span').html() + ',';
                }
            }
            if($('.sel-con.b .active').length>12){
                for(let i=0;i<12;i++){
                    middle2 += '' + $('.sel-con.b .active').eq(i).siblings('span').html() + ',';
                }
                middle2 += '...'
            }else{
                for(let i=0;i<$('.sel-con.b .active').length;i++){
                    middle2 += '' + $('.sel-con.b .active').eq(i).siblings('span').html() + ',';
                }
            }
            $scope.head = head;
            $scope.middle1 = middle1;
            $scope.middle2 = middle2;
            layer.open({
                type: 1,
                title: '<?= Yii::t('cvs','另存为模板'); ?>',
                content: $('.template'), //这里content是一个普通的String
                area: ['450px', '320px']
            });
        }

        $scope.saveTemplet = function(){  //保存模板事件
            var judgment = true;
            if($scope.saveName.length<=0){
                layer.tips('命名不能为空', '#save_template', {
                    tips: [1, '#3595CC'],
                    time: 2400
                });
                judgment = false;
                return false
            }
            angular.forEach($scope.templetList,function(data,key){
           //     console.log(data,key);
                if(key == $scope.saveName){
                    layer.tips('命名与已有模板重复了，修改后再试试', '#save_template', {
                        tips: [1, '#3595CC'],
                        time: 2400
                    });
                    judgment = false;
                    return false
                }
            })
            if(judgment){
                var templetData = {
                    'region':$scope.region,
                    'factory':$scope.factory,
                    'city':$scope.city,
                    'month':$scope.month,
                    'category':$scope.category,
                    'brand':$scope.brand,
                    'deepgroupcheck':$scope.deepgroupcheck,
                    'deepbrandcheck':$scope.deepbrandcheck,
                    'relations':$scope.relations,
                    'skus':$scope.skus,
                    'head':$scope.head,
                    'SKU':$scope.SKU,
                    'system':$scope.system,
                    'systemtype':$scope.systemtype,
                    'systems':$scope.systems,
                    'stages':$scope.stages,
                }
//                console.log($scope.templetList)
                $scope.templetList[$scope.saveName] = templetData;
//                console.log(JSON.stringify($scope.templetList));
                datadService.setObject("templetList", $scope.templetList);
                $('.conta>.layui-layer-page .layui-layer-close1').trigger('click');
                layer.msg('保存成功！');
            }

        }

        $scope.showsel = false;
        $scope.getTemplet = function(key){  //选中模板事件
            if(!key){
                return false
            }
       //     console.log(key)
            var getData = datadService.getObject("templetList")[key];
        //    console.log(typeof(getData.brand));
            var headArr = getData.head.split(',');
            for(let i=0;i<headArr.length;i++){
                $('#form .chosen-single span').eq(i).html(headArr[i]);
            }
            $('#Search_month').val(headArr[headArr.length-1]);
            $scope.region = getData.region;
            $scope.factory = getData.factory;
            $scope.city = getData.city;
            $scope.month = getData.month;
            $scope.category = getData.category;
            $scope.brand = getData.brand;
            $scope.deepgroupcheck = getData.deepgroupcheck;
            $scope.deepbrandcheck = getData.deepbrandcheck;
            $scope.relations = getData.relations;
            $scope.skus = getData.skus;
            $scope.SKU = getData.SKU;
            $scope.system = getData.system;
            $scope.systemtype = getData.systemtype;
            $scope.systems = getData.systems;
            $scope.stages = getData.stages;
            $scope.onoptionchange();
        }

        $scope.kpibtnchg = function (kpi, history) {
            if($scope.history[kpi] == history)return false
            $scope.history[kpi] = history;
            if(history == 1){
                $('.tabtitle').hide()
                if($scope.deepgroupcheck!= $scope.deepgroupcheck2||$scope.deepbrandcheck!=$scope.deepbrandcheck2||$scope.deepsystemcheck!=$scope.deepsystemcheck2){
                    $scope.deepgroupcheck2 = $scope.deepgroupcheck;
                    $scope.deepbrandcheck2 = $scope.deepbrandcheck;
                    $scope.deepsystemcheck2 = $scope.deepsystemcheck;
                    $scope.getLineData();
                }

            }else{
                $('.tabtitle').show()
            }
        }
        $scope.getLineData = function(){
            $('<div>',{
                class:'mb-fff'
            }).appendTo('#chart-view');
            let citytype = $scope.deepgroupcheck == 'group'?1:$scope.deepgroupcheck == 'factory'?2:$scope.deepgroupcheck == 'city'?3:null;
            let systemtype = $scope.deepsystemcheck == 'systemtype'?1:$scope.deepsystemcheck == 'system'?2:null;
            let skutype = $scope.deepbrandcheck == 'catalog'?1:$scope.deepbrandcheck == 'brand'?2:$scope.deepbrandcheck == 'SKU'?3:null;
            let config = {
                'citytype': citytype,
                'systemtype':systemtype,
                'skutype':skutype,
                'month': $scope.month,
                'stage':$scope.stage,
            };
            $http({
                url: '<?php echo $this->createurl("site/Historycvsdata"); ?>',
                params: config
            }).success(function (res) {
                console.log('折线图数据',res)
                $('.mb-fff').remove();
                $scope.all_skuinfos = res;
            }).error(function (data, header, config, status) {
                $('.mb-fff').remove();
            });
        }


        $scope.checkralationshow = function (id) {
            let ret = false;
            // console.log($scope.relations)
            if ($scope.deepgroupcheck == 'group' && $scope.relations[id].depth == 1) ret = true;
            //
            if ($scope.deepgroupcheck == 'factory') {
                if ($scope.factory !== '0' && id == $scope.factory) ret = true;
                if ($scope.factory == '0' && $scope.relations[id].parent == $scope.region && $scope.region != 1) ret = true;
                if ($scope.region == '1' && $scope.relations[id].depth == 2) ret = true;
            }
            if ($scope.deepgroupcheck == 'city' && $scope.factory !== '0') {
                if (($scope.relations[id].parent == $scope.factory) || ($scope.city != '0' && $scope.relations[id].Id == $scope.city)) ret = true;
            }

            if ($scope.deepgroupcheck == 'city' && $scope.factory == '0'&&$scope.relations[id].depth==3) {
                if($scope.city=='0'){
                    if($scope.region != '1'&&($scope.relations[$scope.relations[id].parent].parent == $scope.region)){
                        ret = true;
                    }
                    if ($scope.region == '1') {    //选择了装瓶集团
                        ret = true;
                    }
                }else if(id == $scope.city){
                    ret = true;
                }
            }

            $scope.relations[id]['show'] = ret;
            return ret;
        }

        $scope.chgcheck = function (id) {
            angular.forEach($scope.relationss,function(data,index,array){
                if(data.Id==id){
                    $scope.relationss[index].checked = $scope.relationss[index].checked==1?0:1;
                }
            })
            $scope.relations[id]['checked'] = $scope.relations[id]['checked'] == 1 ? 0 : 1;
        }
        $scope.skuchgcheck = function (id) {
            angular.forEach($scope.skuss,function(data,index,array){
                if(data.Id==id){
                    $scope.skuss[index].checked = $scope.skuss[index].checked==1?0:1;
                }
            })
            $scope.skus[id]['checked'] = $scope.skus[id]['checked'] == 1 ? 0 : 1;
        }
        $scope.syschgcheck = function (id) {
            $scope.systems[id]['checked'] = $scope.systems[id]['checked'] == 1 ? 0 : 1;
        }
        $scope.mapindex = 2;
        function pieChartsChange(){
            let v = $scope.visitab;
            if(v=='distribution_stores')v='distribution'
            if(v=='shelf_number')v='sovi'
            if(v=='extra_displays' || v=='Last_extra_displays_radio'||'promotion')v='thematic_activity'
     //       $scope.pie1.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieLeftId][0][v], 1 - $scope.kopciinfos.koandpcis[$scope.pieLeftId][0][v]];
     //       $scope.pie2.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieLeftId][1][v], 1 - $scope.kopciinfos.koandpcis[$scope.pieLeftId][1][v]];
     //       $scope.pie3.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieLeftId][2][v], 1 - $scope.kopciinfos.koandpcis[$scope.pieLeftId][2][v]];
      //      $scope.pie4.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieLeftId][3][v], 1 - $scope.kopciinfos.koandpcis[$scope.pieLeftId][3][v]];
        }

        function brandsreadonlycheck(){
            switch ($scope.visitab){
                case 'thematic_activity':
                case 'extra_displays':
                case 'equipment_sales':
                        $scope.brandreadonly = {category:true,brand:true,sku:true};
                    break;
                case 'sovi':
                        $scope.brandreadonly = {category:false,brand:false,sku:false};
                    break;
                default:
                        $scope.brandreadonly = {category:false,brand:false,sku:false};
                    break;
            }
        }

        $scope.tabchange = function (tab) {
            if($scope.visitab == tab)return false;
            // console.log("zzz");
            // console.log(tab);
            $scope.visitab = tab;
            pieChartsChange();
            //brandsreadonlycheck();
            switch (tab){
                case 'distribution':
                    $scope.mapindex = 2;    //地图显示API
                    $scope.visitab2 = 'Last_distribution_radio';
                    $scope.skuvisible = true;
                    break;
                case 'sovi':
                    $scope.mapindex = 3;
                    $scope.visitab2 = 'Last_sovi_radio';
                    $scope.skuvisible = true;
                    break;
                case 'extra_displays':
                    $scope.mapindex = 5;
                    $scope.visitab2 = 'Last_extra_displays_radio';
                    $scope.skuvisible = false;
                    break;
                case 'thematic_activity':
                    $scope.mapindex = 6;
                    $scope.visitab2 = 'Last_thematic_activity_radio';
                    $scope.skuvisible = false;
                    break;
                case 'equipment_sales':
                    $scope.mapindex = 7;
                    $scope.visitab2 = 'Last_equipment_sales_radio';
                    //$scope.visitab2 = 'equipment_sales';
                    $scope.kpibtnchg('equipment_sales',1)
                    $scope.skuvisible = false;
                    break;
                case 'distribution_stores':
                    $scope.mapindex = 2;
                    $scope.visitab2 = 'Last_distribution_stores_radio';
                    $scope.skuvisible = true;
                    break;
                case 'shelf_number':
                    $scope.mapindex = 3;
                    $scope.visitab2 = 'Last_shelf_number_radio';
                    $scope.skuvisible = true;
                    break;
                case 'promotion':
                    $scope.mapindex = 6;
                    $scope.visitab2 = 'Last_promotion_radio';
                    $scope.skuvisible = false;
                    break;
            }
        };
        $scope.chartchange = function (tab) {
            $scope.visichart = tab;
        };

        $scope.cancelSelect = function(type,boo){
          var _depth;
            if(type == 'areacheck'){

                console.log($scope.deepgroupcheck)
                switch ($scope.deepgroupcheck){
                    case 'group':
                    _depth = 1;
                    break;
                    case 'factory':
                    _depth = 2;
                    break;
                    case 'city':
                    _depth = 3;
                    break
                }
                angular.forEach($scope.relations, function (data, index, array) {
                    if(_depth == data.depth)$scope.relations[index]['checked'] = boo;
                });
                angular.forEach($scope.relationss, function (data, index, array) {
                    if(_depth == data.depth)$scope.relationss[index]['checked'] = boo;
                });
            }else if(type == 'brandcheck'){
                console.log($scope.deepbrandcheck);
                switch ($scope.deepbrandcheck){
                    case 'catalog':   //品类
                    angular.forEach($scope.skus, function (data, index, array) {
                        //console.log(data,_depth)
                        if($scope.category=='0' ? (data.depth == 1):($scope.category==2 && data.parent==2 && (data.depth==0 || item.depth==2))){
                            $scope.skus[index]['checked'] = boo;
                        }else{
                            $scope.skus[index]['checked'] = false;
                        }
                    });
                    angular.forEach($scope.skuss, function (data, index, array) {
                        if($scope.category=='0' ? (data.depth == 1):($scope.category==2 && data.parent==2 && (data.depth==0 || item.depth==2))){
                            $scope.skuss[index]['checked'] = boo;
                        }else{
                            $scope.skuss[index]['checked'] = false;
                        }
                    });
                    break;
                    case 'brand':   //品牌
                    angular.forEach($scope.skus, function (data, index, array) {
                        if((data.depth==2&&((data.parent==$scope.category)||($scope.brand==0&&$scope.category==0))) ){
                            $scope.skus[index]['checked'] = boo;
                        }else{
                            $scope.skus[index]['checked'] = false;
                        }
                    });
                    angular.forEach($scope.skuss, function (data, index, array) {
                        if((data.depth==2&&((data.parent==$scope.category)||($scope.brand==0&&$scope.category==0)))){
                            $scope.skuss[index]['checked'] = boo;
                        }else{
                            $scope.skuss[index]['checked'] = false;
                        }
                    });
                    break;
                    case 'SKU':   //sku
                    angular.forEach($scope.skus, function (data, index, array) {
                        if(data.depth==3&&( ($scope.category==0&&$scope.brand==0)||($scope.category!=0&&$scope.brand==0&&$scope.skus[data.parent].parent==$scope.category)||($scope.brand!=0&&data.parent==$scope.brand) )){
                            $scope.skus[index]['checked'] = boo;
                        }else{
                            $scope.skus[index]['checked'] = false;
                        }
                    });
                    angular.forEach($scope.skuss, function (data, index, array) {
                        if(data.depth==3&&( ($scope.category==0&&$scope.brand==0)||($scope.category!=0&&$scope.brand==0&&$scope.skus[data.parent].parent==$scope.category)||($scope.brand!=0&&data.parent==$scope.brand) )){
                            $scope.skuss[index]['checked'] = boo;
                        }else{
                            $scope.skuss[index]['checked'] = false;
                        }
                    });
                    break;
                }

            }else if(type == 'systemcheck'){
                switch ($scope.deepsystemcheck){
                    case 'systemtype':
                    angular.forEach($scope.systems, function (data, index, array) {
                        console.log(data,_depth)
                        if(data.depth==1){
                            $scope.systems[index]['checked'] = boo;
                        }else{
                            $scope.systems[index]['checked'] = false;
                        }
                    });
                    break;
                    case 'system':
                    angular.forEach($scope.systems, function (data, index, array) {
                        console.log(data,_depth)
                        if((data.depth==2&&$scope.systemtype!=0&&data.parent==$scope.systemtype)||(data.depth==2&&$scope.systemtype==0)){
                            $scope.systems[index]['checked'] = boo;
                        }else{
                            $scope.systems[index]['checked'] = false;
                        }
                    });
                    break;
                }

            }
        }
        $scope.nodata='<?= Yii::t('cvs','无数据');?>';
        $scope.visitab = 'distribution';
        $scope.selcity = '<?= Yii::t('cvs','全国')?>';
        $scope.regionDisable = false;
        $scope.factoryDisable = false;
        $scope.catalogDisable = false;
        $scope.skuDisable = false;
        $scope.systemDisable = false;
        $scope.selbrand = '全品类';
        $scope.pieLeftId = 80;
        $scope.onoptionchange = function (level) {
            $('.map-men2').show();
            switch (level){
                case 1:    //装瓶集团
                    $scope.factory = "0";
                    $scope.city = "0";
                    break;
                case 2:  //装瓶厂

                    $scope.city = "0";
                //    if($scope.factory!=='0'){  // 控制是否禁用选择
                //    }else{
              //          $scope.factoryDisable = false;
                //        if($scope.region==1){$scope.regionDisable = false;$scope.deepgroupcheck = "group";}
                  //  }
                    break;
                case 4:
                    if($scope.systemtype == 0) $scope.system =0;

                    angular.forEach($scope.systems, function (data, index, array) {
                        if(data.depth==2 && data.parent==$scope.systemtype){
                            $scope.systems[index]['checked'] = true;
                        }else if(data.depth==2){
                            $scope.systems[index]['checked'] = false;
                        }
                    });
                    break;
                case 6:
                    $scope.getTotalData($scope.stage);
                    break;
                case 7:  //品类
                    $scope.brand = '0';
                    $scope.SKU = '0';

                    if($scope.category){
                    angular.forEach($scope.skus, function (data, index, array) {
                        if(data.depth==2 && data.parent == $scope.category){
                            $scope.skus[index]['checked'] = true;
                        }else{
                            $scope.skus[index]['checked'] = false;
                        }
                    });
                    angular.forEach($scope.skuss, function (data, index, array) {
                      if(data.depth==2 && data.parent == $scope.category){
                          $scope.skuss[index]['checked'] = true;
                      }else{
                          $scope.skuss[index]['checked'] = false;
                      }
                    });
                  }else{
                    angular.forEach($scope.skus, function (data, index, array) {
                        if(data.depth==2 ){
                            $scope.skus[index]['checked'] = true;
                        }else{
                            $scope.skus[index]['checked'] = false;
                        }
                    });
                    angular.forEach($scope.skuss, function (data, index, array) {
                      if(data.depth==2){
                          $scope.skuss[index]['checked'] = true;
                      }else{
                          $scope.skuss[index]['checked'] = false;
                      }
                    });
                  }
                    break;
                case 8:  //品牌
                    $scope.SKU = '0';
                    if($scope.brand !=0){
                      angular.forEach($scope.skus, function (data, index, array) {
                          if(data.depth==3 && data.parent == $scope.brand){
                              $scope.skus[index]['checked'] = true;
                          }else{
                              $scope.skus[index]['checked'] = false;
                          }
                      });
                      angular.forEach($scope.skuss, function (data, index, array) {
                          if(data.depth==3 && data.parent == $scope.brand){
                              $scope.skuss[index]['checked'] = true;
                          }else{
                              $scope.skuss[index]['checked'] = false;
                          }
                      });
                    }else{
                      angular.forEach($scope.skus, function (data, index, array) {
                          if(data.depth==2 && data.parent == $scope.category){
                              $scope.skus[index]['checked'] = true;
                          }else{
                              $scope.skus[index]['checked'] = false;
                          }
                      });
                      angular.forEach($scope.skuss, function (data, index, array) {
                        if(data.depth==2 && data.parent == $scope.category){
                            $scope.skuss[index]['checked'] = true;
                        }else{
                            $scope.skuss[index]['checked'] = false;
                        }
                      });
                    }
                    break;

            }

            if($scope.city!='0'){
                $scope.deepgroupcheck = "city";
                $scope.factoryDisable = true;
                $scope.regionDisable = true;
                $scope.selcity = $('#Search_city').find('option[value='+$scope.city+']').html();
            }else if($scope.factory!='0'){
            //    $scope.deepgroupcheck = "city";
            //    $scope.factoryDisable = true;
            //    $scope.regionDisable = true;
                $scope.selcity = $('#Search_factory').find('option[value='+$scope.factory+']').html();
            }else if($scope.region!='1'){
                $scope.regionDisable = true;
                $scope.factoryDisable = false;
                $scope.deepgroupcheck = "factory";
                $scope.selcity = $('#Search_region').find('option[value='+$scope.region+']').html();
            }else{
                $scope.factoryDisable = false;
                $scope.factoryDisable = false;
                $scope.deepgroupcheck = "group";
                $scope.selcity = '<?= Yii::t('cvs','全国')?>';
            }

            if($scope.SKU!=0||$scope.brand!=0){
                $scope.deepbrandcheck = "SKU";
                $scope.catalogDisable = true;
                $scope.brandDisable = true;
            }else if($scope.category!=0){
                $scope.deepbrandcheck = "brand";
                $scope.catalogDisable = true;
                $scope.brandDisable = false;
            }else{
                $scope.deepbrandcheck = "catalog";
                $scope.catalogDisable = false;
                $scope.brandDisable = false;
            }
            if($scope.system!=0||$scope.systemtype!=0){
                $scope.deepsystemcheck = 'system';
                $scope.systemDisable = true;
            }else{
                $scope.deepsystemcheck = 'systemtype';
                $scope.systemDisable = false;
            }
            let config = {
                'region': $scope.region,
                'factory': $scope.factory,
                'city': $scope.city,
                'month': $scope.month,
                'category': $scope.category,
                'brand': $scope.brand,
                'mode':$scope.SKU,
                'stage':$scope.stage,
                'systemtype':$scope.systemtype,
                'system':$scope.system
            };
            $http({
                url: '<?php echo $this->createurl("getcvsdata"); ?>',
                params: config
            }).success(function (response) {
                console.log(response)
                $scope.kopciinfos = response.kopciinfos;   //饼图数据
                $scope.koinfos = response.koinfos;  //地图用的数据
                $scope.koinfoss = response.koinfoss;  //地图用的数据
                $scope.labels = response.labels;
                $scope.lastlabel=response.lastlabel;
                $('.map-men2').hide();

                $scope.pieLeftId = 80;//
                if($scope.SKU!=0){
                     $scope.pieLeftId=$scope.SKU;
                }else if($scope.brand!=0){
                    $scope.pieLeftId=$scope.brand;
                }else if($scope.category!=0){
                    $scope.pieLeftId=$scope.category;
                }
                pieChartsChange()
                // console.log($scope.pieLeftId)
            }).error(function (data, header, config, status) {
                $('.map-men2').hide();
            });
            $scope.getChartsData()

        };
        $scope.ytd = false;    //header按钮，控制header显示YTD还是最新一期
        $scope.ytdChange = function(i){
            if(i==0){
                $scope.ytd = false;
                $scope.getTotalData($scope.stage);  // -1 YTD，最新一期
            }else if(i == 1){
                $scope.ytd = true;
                $scope.getTotalData(-1);
            }
        }

        $scope.getTotalData = function(stage){
            $("#myselect").find("option").prop("selected",false);
            if(stage == 0){//月值（VS LM）
                $("#myselect").find("option[value='0']").prop("selected",true);
            }else if(stage == -1){//YTD（VS LY）
                $("#myselect").find("option[value='-1']").prop("selected",true);
            }else if(stage > 0){//期数（VS PP）
                $("#myselect").find("option[value='1']").prop("selected",true);
            }
            let _params = {
                stage: stage,
                month:$scope.month,
                mstage:$scope.stage,
            }
            console.log('headerApiParams',_params)
            $http({
                url: '<?php echo $this->createurl("site/hearder"); ?>',
                params: _params
            }).success(function (res) {
                console.log('totalfixed',res)
                $scope.totalfixed = [res];
            }).error(function (data, header, config, status) {

            });
        }
        $scope.getTotalData($scope.stage)

        $scope.getChartsData = function(){
            if($scope.history[$scope.visitab] == 1){
                $scope.getLineData()
            }else{
                $('<div>',{
                    class:'mb-fff'
                }).appendTo('#chart-view');
                let citytype = $scope.deepgroupcheck == 'group'?1:$scope.deepgroupcheck == 'factory'?2:$scope.deepgroupcheck == 'city'?3:null;
                let systemtype = $scope.deepsystemcheck == 'systemtype'?1:$scope.deepsystemcheck == 'system'?2:null;
                let skutype = $scope.deepbrandcheck == 'catalog'?1:$scope.deepbrandcheck == 'brand'?2:$scope.deepbrandcheck == 'SKU'?3:null;
                let config = {
                    'citytype': citytype,
                    'systemtype':systemtype,
                    'skutype':skutype,
                    'month': $scope.month,
                    'stage':$scope.stage,
                };
                $http({
                    url: '<?php echo $this->createurl("site/cvsdata"); ?>',
                    params: config
                }).success(function (res) {
                    //console.log('柱图/堆叠柱图数据',res)
                    $scope.allskuinfos2 = res;  //备份，打乱排序使用
                    $scope.allskuinfos = res;
                    $('.mb-fff').remove();
                }).error(function (data, header, config, status) {
                    $('.mb-fff').remove();
                });
            }

        }
        $scope.getChartsData();
        $scope.exportExcel = function(){
            window.location.href = "<?php echo Yii::app()->createUrl('site/excel') ?>"+"?region="+$scope.region+"&factory="+$scope.factory+"&city="+$scope.city+"&month="+$scope.month+"&category="+$scope.category+"&brand="+$scope.brand+"&mode="+$scope.SKU+"&stage="+$scope.stage+"&systemtype="+$scope.systemtype+"&system="+$scope.system;
        }

        $scope.compare = function(i,property,zheng){   //柱状图的排序功能
            if(zheng==1){
                return function(a,b){
                    return  a[i][property] - b[i][property];
                }
            }else{
                return function(a,b){
                    return  b[i][property] - a[i][property];
                }
            }

        }
        $scope.nosort = '<?= Yii::t('cvs','排序');?>';
        $scope.nocompare = true;
        $scope.chartsSort = function(){
            if($scope.nocompare){
                angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                    $scope.allskuinfos.bar[index].skus.sort($scope.compare('1',$scope.kpi,1));
                })
                $scope.nocompare = false;
                $scope.nosort = '<?= Yii::t('cvs','取消排序');?>';
            }else{
                angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                    $scope.allskuinfos.bar[index].skus.sort($scope.compare('0','sort',0));
                })
                $scope.nocompare = true;
                $scope.nosort = '<?= Yii::t('cvs','排序');?>';
            }

        }
        $scope.resetFilter =function(){
            $scope.region = "1";//区域
            $scope.factory = "0";//装品场
            $scope.city = "0";//城市
            $scope.station="0";
            $scope.category = "0";  //品类
            $scope.brand = "0";  //品牌
            $scope.SKU = "0";  //sku
            $scope.nodata='';
            $scope.system='0';
            $scope.systemtype='0';
            $scope.deepgroupcheck = 'group';
            $scope.deepbrandcheck = 'catalog';
            $scope.deepsystemcheck = 'systemtype'
            $scope.deepbrandcheck2 = '';
            $scope.deepsystemcheck2 = ''
            $scope.onoptionchange();
        }

        $scope.setbaroption = function (kpi, rid,min,max,sid) {
            // console.log('sid',sid)
            // console.log('kpi',kpi)
            // console.log('skus',$scope.skus)
            $scope.kpi = kpi;
            var labelRight = {
                normal: {
                    color:'#363636',
                    position: 'left'
                }
            };

            $scope.newskus=[];
            angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                //提取指标的所有数据，用于寻找最大最小值
                angular.forEach(data.skus, function (subdata, index, array) {
                    if ($scope.relations[subdata[1].relationship_id].checked && $scope.relations[subdata[1].relationship_id]['show'] && $scope.skus[subdata[1].sku_id].checked) {
                        $scope.newskus.push(parseFloat(subdata[1][kpi]));
                    }
                });
            })
            angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                if (data.relationship.Id == rid&&data.system.Id==sid) {
                    // console.log(data.system.name)
                    $scope.baroption.title.text = data.relationship.name+ ' - ' + data.system.name;
                    if (data.self) {
                        $scope.baroption.title.subtext = data.self[0].name + '：' + parseFloat(data.self[1][kpi] * 100).toFixed(2) + "%";
                    } else {
                        $scope.baroption.title.subtext = '';
                    }
                    $scope.baroption.yAxis.data = [];
                    $scope.baroption.legend.data=[];

                    $scope.baroption.xAxis.max=Math.max.apply(null,$scope.newskus)*100;
                    $scope.baroption.xAxis.min= Math.min(0, Math.min.apply(null,$scope.newskus))*100;

                    $scope.baroption.series[0].data = [];
//                    console.log(data.skus)

                    angular.forEach(data.skus, function (subdata, index, array) {
                        if (subdata[1][kpi] == null) subdata[1][kpi] = 0;
                        if ($scope.skus[subdata[1].sku_id].checked) {
                            // console.log(subdata[1].sku_id)
                            if(subdata[1][kpi]>0){
                                labelRight = {
                                    normal: {
                                        color:'#363636',
                                        position: 'left'
                                    }
                                };
                            }else{
                                labelRight = {
                                    normal: {
                                        color:'#363636',
                                        position: 'right'
                                    }
                                };
                            }
                            $scope.baroption.yAxis.data.push(subdata[0].name);
                            // console.log(Math.floor(subdata[1][kpi]*10000)/100)
                            $scope.baroption.series[0].data.push({
                                value: Math.floor(subdata[1][kpi]*10000)/100,
                                itemStyle: {
                                    normal:{
                                        color: subdata[0].color
                                    }
                                },
                                formatter: '{value}%',
                                label:labelRight
                            })
                            $scope.baroption.legend.data.push(subdata[0].name);
                        }

                    });
                }

            });


            return $scope.baroption;
        };

        $scope.setlineoption = function (kpi, rid,systemId) {
            $scope.kpi = kpi;
            $scope.newskus=[];
            angular.forEach($scope.all_skuinfos.bar, function (data, index, array) {
                //提取指标的所有数据，用于寻找最大最小值
                angular.forEach(data.skus, function (subdata, index, array) {
                    if ($scope.relations[subdata[1].relationship_id]['checked'] && $scope.relations[subdata[1].relationship_id]['show'] && $scope.skus[subdata[1].sku_id]['checked']&&$scope.systems[subdata[1].system_id]['checked']) {
                        angular.forEach(subdata[2],function(subsubdata,index,array){
                            $scope.newskus.push(subsubdata[kpi]);
                        })

                    }
                });
            })
            if($('.weidu-item-box .sel-con.c input:checked').length>10){
                $scope.lineoption.legend['show'] = false;
            }
            $scope._showData = $('.weidu-item-box .sel-con.c input:checked').length>2?false:true;
            let max = Math.max.apply(null,$scope.newskus);
            let min = Math.min(0, Math.min.apply(null,$scope.newskus));
            if(max>100){
                let idxs = 0;
                $scope.lineoption.tooltip={
                    trigger: 'axis',
                    formatter: '{b}'
                }
                $scope.lineoption.yAxis.max=Math.ceil(max/1000);
                $scope.lineoption.yAxis.min=Math.floor(min/1000);
                $scope.lineoption.yAxis.axisLabel.formatter = '{value}k';
                $scope.lineoption.xAxis.data=$scope.all_skuinfos.stackbar.label;
                angular.forEach($scope.all_skuinfos.bar, function (data, index, array) {
                    if (data.relationship.Id == rid&&data.system.Id == systemId) {
                        $scope.lineoption.title.text = data.relationship.name+'-'+data.system.name;
                        $scope.lineoption.title.subtext = "<?= Yii::t('cvs','单位：k/千');?>";
                        // console.log(data)
                        $scope.lineoption.legend.data = [];
                        $scope.lineoption.series = [];
                        angular.forEach(data.skus, function (subdata, index, array) {
                            let idx = index;
                            if ($scope.skus[subdata[1].sku_id]['checked']) {
                                // console.log(subdata)
                                $scope.lineoption.legend.data.push(subdata[0].name);
                                $scope.lineoption.tooltip.formatter+='<br>{a'+idxs+'}:{c'+ idxs+'}k'
                                idxs++;
                                if (subdata[1][kpi] == null) subdata[1][kpi] = 0;
                                let _data;
                                if(subdata.length>=3){
                                    _data = [
                                        subdata[2].length>=5? parseInt(subdata[2][4][kpi]/10)/100:null,
                                        subdata[2].length>=4? parseInt(subdata[2][3][kpi]/10)/100:null,
                                        subdata[2].length>=3? parseInt(subdata[2][2][kpi]/10)/100:null,
                                        subdata[2].length>=2? parseInt(subdata[2][1][kpi]/10)/100:null,
                                        subdata[2].length>=1? parseInt(subdata[2][0][kpi]/10)/100:null,
                                        parseInt(subdata[1][kpi]/10)/100
                                    ]

                                }
                                $scope.lineoption.series.push({
                                    name: subdata[0].name,
                                    type: 'line',
                                    data: _data,
                                    itemStyle: {
                                        normal:{
                                            color: subdata[0].color,
                                            label: {
                                                show: $scope._showData
                                            }
                                        }
                                    }

                                });
                            }
                        });
                    }

                });
            }else{
                let idxs = 0;
                $scope.lineoption.yAxis.max=Math.ceil(max*100);
                $scope.lineoption.yAxis.min=Math.floor(min*100);
                $scope.lineoption.tooltip={
                    trigger: 'axis',
                    formatter: '{b}'
                }
                $scope.lineoption.xAxis.data=$scope.all_skuinfos.stackbar.label;
                angular.forEach($scope.all_skuinfos.bar, function (data, index, array) {
                    if (data.relationship.Id == rid&&data.system.Id == systemId) {
                        $scope.lineoption.title.text = data.relationship.name+'-'+data.system.name;
                        $scope.lineoption.title.subtext = '<?= Yii::t('cvs','')?>';
                        $scope.lineoption.yAxis.axisLabel = {
                            formatter: '{value}%'
                        }
                        // console.log(data)
                        $scope.lineoption.legend.data = [];
                        $scope.lineoption.series = [];

                        angular.forEach(data.skus, function (subdata, index, array) {
                            let idx = index;
                            // console.log(subdata);
                            if ($scope.skus[subdata[1].sku_id]['checked']) {
                                $scope.lineoption.legend.data.push(subdata[0].name);
                                $scope.lineoption.tooltip.formatter+='<br>{a'+idxs+'}:{c'+ idxs+'}%'
                                idxs++;
                                if (subdata[1][kpi] == null) subdata[1][kpi] = 0;

                                let _data;
                                if(subdata.length>=3){
                                    _data = [
                                        subdata[2].length>=5? parseInt(subdata[2][4][kpi]*10000)/100:null,
                                        subdata[2].length>=4? parseInt(subdata[2][3][kpi]*10000)/100:null,
                                        subdata[2].length>=3? parseInt(subdata[2][2][kpi]*10000)/100:null,
                                        subdata[2].length>=2? parseInt(subdata[2][1][kpi]*10000)/100:null,
                                        subdata[2].length>=1? parseInt(subdata[2][0][kpi]*10000)/100:null,
                                        parseInt(subdata[1][kpi]*10000)/100
                                    ]

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
                                    },
                                });
                            }
                        });
                    }

                });
            }

            return $scope.lineoption;
        };

        $scope.setstackbaroption = function (kpi) {    //堆叠柱状图
            $scope.kpi = kpi;
            //    console.log($scope.skus)
            //    console.log($scope.allskuinfos.stackbar.skus)
            $scope.stackbaroption.xAxis[0].data = [];
            $scope.stackbaroption.legend.data = [];
            $scope.stackbaroption.legend.selected = {};
            $scope.stackbaroption.series = [];
            //    console.log($scope.allskuinfos)
            angular.forEach($scope.allskuinfos.stackbar.skus, function (subdata, subindex, array) {
            //    console.log(subdata,subindex)  //数据 名称
                var newseria = [];
                if($scope.skus[subdata[1][1].sku_id]['checked']){
                    $scope.stackbaroption.legend.data.push(subindex);
                    $scope.stackbaroption.legend.selected[subindex] = $scope.skus[subdata[1][1].sku_id]['checked'];
                    angular.forEach(subdata, function (subsubdata, ssubindex, array) {
                //    console.log(subsubdata[1])
                        if ($scope.relations[subsubdata[1].relationship_id]['checked']&& $scope.relations[subsubdata[1].relationship_id].show&&$scope.systems[subsubdata[1].system_id].checked) {
                            if ($scope.stackbaroption.xAxis[0].data.indexOf($scope.allskuinfos.stackbar.relations[subsubdata[1].relationship_id]+'-'+$scope.allskuinfos.stackbar.systems[subsubdata[1].system_id]) == -1){
                                $scope.stackbaroption.xAxis[0].data.push($scope.allskuinfos.stackbar.relations[subsubdata[1].relationship_id]+'-'+$scope.allskuinfos.stackbar.systems[subsubdata[1].system_id]);
                            }
                            // console.log(kpi,subsubdata[1])
                            if (!subsubdata[1][kpi]) {subsubdata[1][kpi]= 0;}
//                            subsubdata[1][kpi] = parseInt(subsubdata[1][kpi]);此方法取整，数据有误差，例如：9.888，返回的是9
                            subsubdata[1][kpi] = Math.round(subsubdata[1][kpi]);//四舍五入取整

                            newseria.push({
                                value:subsubdata[1][kpi],
                                name:subindex,
                            });
                        }
                    });

                }


                $scope.stackbaroption.series.push({
                    name: subindex,
                    type: 'bar',
                    itemStyle: {
                        normal:{
                            color: subdata[1][0].color
                        },
                    },
                    stack: 'total',
               //     barWidth : 108,
                    data: newseria,

                });

            });
            // console.log($scope.stackbaroption)
            // console.log($scope.stackbaroption.series[$scope.stackbaroption.series.length-1].data.length)
            for(let j=0;j<$scope.stackbaroption.series.length;j++){
                if($scope.stackbaroption.series[j].data&&$scope.stackbaroption.series[j].data.length>0){
                    $scope.myObj = {
                        "width": $scope.stackbaroption.series[j].data.length*128 + 300
                    }
                    break
                }
            }
            console.log('stackbaroption.series',$scope.stackbaroption.series)
            var stackTotal = [];
            for(let i=0;i<$scope.stackbaroption.series.length;i++){
                var _length = $scope.stackbaroption.series[i].data.length;
                for(let j=0;j<_length;j++){
                    if(!stackTotal[j])stackTotal[j]=0;
                    stackTotal[j]+=$scope.stackbaroption.series[i].data[j].value
                    // if(i==$scope.stackbaroption.series.length-1){
                        console.log(j,stackTotal[j])
                        $scope.stackbaroption.series[i].data[j]['label']={
                            normal: {
                                show: true,
                                position: 'top',
                                formatter:function(){
                                    return '<?= Yii::t('cvs','总和')?>: '+stackTotal[j]
                                }
                            }
                        }
                    // }
                }
            }
            return $scope.stackbaroption;
        };


        $scope.setpieoption = function (val){
            if(!val){
                val = 0.01;
            }

            $scope.pie1.series[0].data = [val,1-val];
            return $scope.pie1;
        }

        //
        $scope.pieConfig = {
            theme: 'default',
            dataLoaded: true,
            notMerge:true,
        };
        //正负轴柱状图
        $scope.baroption = {
            title: {
                text: '交错正负轴标签',
                subtext: 'From ExcelHome',
            },
            legend: {
                x: 'right',
                itemWidth: 10,
                itemHeight: 10,
                icon: 'circle',
                data: [],
                selected: {},
            },
            toolbox: {
                feature: {
                    saveAsImage: {},
                    myExcel:{
                        show:true,
                        title:"导出Excel",
                        icon:"image://http://echarts.baidu.com/images/favicon.png",
                        onclick:function(opts){
                            var series = opts.option.series; //交错正负轴数据
                            var axisData = opts.option.yAxis[0].data; //坐标数据
                            var title = opts.option.title[0].text;//标题（区域-渠道）
                            console.log(series,axisData);
                            console.log(title);
                            var tdTimes = '<td style="text-align:center;padding: 5px 0;">时间</td>'+'<td style="text-align:center;">期数</td>'+'<td style="text-align:center;">产品</td>'+'<td style="text-align:center;">数据</td>'; //表头第一列
                            var tdBodys = ''; //表数据

                            var table = '<table id="tableExcel_Day" border="1" class="table-bordered table-striped" style="width:40%;text-align:center"><tbody><tr>' + tdTimes +' </tr>';
                            console.log(table);
                            var time = $("#Search_month").val();
                            var stage = $("#Search_stage").val();
                            //组装表数据
                            for (var lt = 0;lt < axisData.length;lt++) {//axisData坐标数据
                                //详细数据
                                for (var j = 0; j < series.length ; j++) {
                                    var temp = series[j].data[lt].value;
                                    console.log(temp);
                                    if (temp != null && temp != undefined) {
                                        tdBodys += '<td style="text-align:center;padding: 5px 0;">' +time+ '</td>' +'<td style="text-align:center;">' +stage+ '</td>' +'<td style="text-align:center;">' +axisData[lt]+ '</td>' + '<td style="text-align:center;">' + temp.toFixed(2) + '</td>';
                                    } else {
                                        tdBodys += '<td></td>';
                                    }
                                }
                                table += '<tr>' + tdBodys + '</tr>';
                                tdBodys = '';
                            }
                            table += '</tbody></table>';
                            console.log(table);
//                            return false;
                            $(".downExcel").empty();
                            $(".downExcel").append(table);
                            var oHtml = document.getElementsByClassName('table-bordered')[0].outerHTML;
                            var excelBlob = new Blob([oHtml], {type: 'application/vnd.ms-excel'});
                            // 创建一个a标签
                            var oA = document.createElement('a');
                            // 利用URL.createObjectURL()方法为a元素生成blob URL
                            oA.href = URL.createObjectURL(excelBlob);
                            // 给文件命名
                            oA.download = title+'.xls';
                            // 模拟点击
                            oA.click();
                        }
                    }
                }
            },
            tooltip: {
                trigger:'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                },
                formatter: '{b}:\n{c}%',
            },
            grid: {
                top: 80,
                left: 180,
                bottom: 30
            },
            xAxis: {
                //min:'0.1',
                max:'0.1',
                type: 'value',
                position: 'top',
                splitLine: {show:false},
                axisLabel: {
                    formatter: '{value}%'
                },
            },
            yAxis: {
                type: 'category',
                axisLine: {show: false},
                axisLabel: {show: false},
                axisTick: {show: false},
                splitLine: {show: false},
                data: [],
            },
            series: [
                {
                    type: 'bar',
                    barWidth:22,
                    data:[],
                    label:{
                        normal: {
                            show: true,
                            formatter: '{b}'
                        }
                    },

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
                selected: {},
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {},
                    myExcel:{
                        show:true,
                        title:"导出Excel",
                        icon:"image://http://echarts.baidu.com/images/favicon.png",
                        onclick:function(opts){
                            var target = $("#deepdive>li.active>a").text();//获取指标
                            var series = opts.option.series; //堆叠柱形图数据
                            var axisData = opts.option.xAxis[0].data; //坐标数据
                            console.log(series,axisData);
                            var tdTimes = '<td style="text-align:center;">时间</td>'+'<td style="text-align:center;">期数</td>'+'<td style="text-align:center;">区域</td>'+'<td style="text-align:center;">渠道</td>'; //表头第一列
                            var tdBodys = ''; //表数据
                            for(var tdHead = 0 ;tdHead < series.length; tdHead++){
                                tdTimes +='<td style="text-align:center;">'+series[tdHead].name+'</td>';
                            }
                            var table = '<table id="tableExcel_Day" border="1" class="table-bordered table-striped" style="width:100%;text-align:center"><tbody><tr>' + tdTimes +' </tr>';
                            var time = $("#Search_month").val();//获取时间
                            var stage = $("#Search_stage").val();//获取期数
                            //组装表数据
                            var th = '<td style="text-align:center;padding: 5px 0;">' + time + '</td>' + '<td style="text-align:center;">' + stage + '</td>';
                            //详细数据
                            for (var lt = 0; lt < axisData.length; lt++) {//axisData坐标数据
                                var arr = axisData[lt].split("-");//分离区域和渠道
                                var area = "";
                                var ditch = "";
                                //分离区域和渠道
                                for (var nt = 0;nt < arr.length;nt++){
                                    area = '<td style="text-align:center;">'+arr[0]+'</td>';
                                    if(arr[1] == 'Non'){
                                        ditch = '<td style="text-align:center;">'+arr[1]+'-CCMG</td>';
                                    }else{
                                        ditch = '<td style="text-align:center;">'+arr[1]+'</td>';
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
                                table += '<tr>' + th + area + ditch +  tdBodys + '</tr>';
                                tdBodys = '';
                            }
                            table += '</tbody></table>';
                            $(".downExcel").empty();
                            $(".downExcel").append(table);
                            var oHtml = document.getElementsByClassName('table-bordered')[0].outerHTML;
                            var excelBlob = new Blob([oHtml], {type: 'application/vnd.ms-excel'});
                            // 创建一个a标签
                            var oA = document.createElement('a');
                            // 利用URL.createObjectURL()方法为a元素生成blob URL
                            oA.href = URL.createObjectURL(excelBlob);
                            // 给文件命名
                            oA.download = target+'.xls';
                            // 模拟点击
                            oA.click();
                        }
                    }
                }
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
        //折线图配置项
        $scope.lineoption = {
            title: {
                text: '未来一周气温变化',
                subtext: '纯属虚构'
            },
            tooltip: {
                trigger: 'axis',
            },
            legend: {
                itemWidth: 10,
                itemHeight: 10,
                left: 140,
                icon: 'circle',
                data: ['最高气温', '最低气温']
            },
            toolbox: {
                feature: {
                    saveAsImage: {},
                    myExcel:{
                        show:true,
                        title:"导出Excel",
                        icon:"image://http://echarts.baidu.com/images/favicon.png",
                        onclick:function(opts){
                            var series = opts.option.series; //折线图数据
                            var axisData = opts.option.xAxis[0].data; //坐标数据
                            console.log(series,opts);
                            var title = opts.option.title[0].text;
                            var tdTimes = '<td>时间</td>'+'<td>期数</td>'; //表头第一列
                            var tdBodys = ''; //表数据

                            //组装表头
                            for (var product = 0; product < series.length; product++) {
                                tdTimes += '<td>' + series[product].name + '</td>';
                            }
                            var table = '<table id="tableExcel_Day" border="1" class="table-bordered table-striped" style="width:100%;text-align:center"><tbody><tr>' + tdTimes +' </tr>';
                            //组装表数据
                            console.log(series,opts);

                            for (var lt = 0;lt < axisData.length;lt++) {//axisData坐标数据
                                var arr = axisData[lt].split("-");
                                var time = "";
                                var stage = "";
                                //分离时间和期数
                                for (var nt = 0;nt < arr.length;nt++){
                                    time = arr[0] +"-"+arr[1];
                                    stage = arr[2];
                                }
                                //详细数据
                                for (var j = 0; j < series.length ; j++) {
                                    var temp = series[j].data[lt];
                                    if (temp != null && temp != undefined) {
                                        tdBodys += '<td>' + temp.toFixed(2) + '</td>';
                                    } else {
                                        tdBodys += '<td></td>';
                                    }
                                }
                                table += '<tr><td>'+time+'</td><td>'+stage + tdBodys + '</tr>';
                                tdBodys = '';
                            }
                            table += '</tbody></table>';
                            $(".downExcel").empty();
                            $(".downExcel").append(table);
                            var oHtml = document.getElementsByClassName('table-bordered')[0].outerHTML;
                            var excelBlob = new Blob([oHtml], {type: 'application/vnd.ms-excel'});
                            // 创建一个a标签
                            var oA = document.createElement('a');
                            // 利用URL.createObjectURL()方法为a元素生成blob URL
                            oA.href = URL.createObjectURL(excelBlob);
                            // 给文件命名
                            oA.download = title+'.xls';
                            // 模拟点击
                            oA.click();
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
                axisLabel: {
                    formatter: '{value}'
                },
                splitLine: {show:false},
            },
            series: [

            ]
        };
        //饼图
        $scope.pie1 = {
            color: ['#FFC738', '#eeeeee'],
            series: [
                {
                    type: 'pie',
                    label: {
                        normal: {
                            show: false
                        }
                    },
                    radius: ['65%', '80%'],
                    data: ['3.44059989', '97'],
                    barWidth : 30,
                    hoverAnimation:false,
                    animationDurationUpdate: 1000
                }
            ]
        };
        $scope.pie2 = {
            color: ['#FFC738', '#eeeeee'],
            series: [
                {
                    type: 'pie',
                    label: {
                        normal: {
                            show: false
                        }
                    },
                    radius: ['65%', '80%'],
                    data: ['3.44059989', '97'],
                    barWidth : 30,
                    hoverAnimation:false,
                    animationDurationUpdate: 1000
                }
            ]
        };
        $scope.pie3 = {
            color: ['#FFC738', '#eeeeee'],
            series: [
                {
                    type: 'pie',
                    label: {
                        normal: {
                            show: false
                        }
                    },
                    radius: ['65%', '80%'],
                    data: ['3.44059989', '97'],
                    barWidth : 30,
                    hoverAnimation:false,
                    animationDurationUpdate: 1000
                }
            ]
        };
        $scope.pie4 = {
            color: ['#FFC738', '#eeeeee'],
            series: [
                {
                    type: 'pie',
                    label: {
                        normal: {
                            show: false
                        }
                    },
                    radius: ['65%', '80%'],
                    data: ['3.44059989', '97'],
                    barWidth : 30,
                    hoverAnimation:false,
                    animationDurationUpdate: 1000
                }
            ]
        };

        $scope.exportpdf = function(){
            $('.export-pdf').show();
         //   $('body').addClass('body-active');
            $('#edit-name').val($('#Search_month').val()+'-'+$scope.selcity);
        }


    });
</script>

<div id="cvs" ng-app="cockdash" style="padding: 0 8px;">
    <div class="pdftips">
        <div><?= Yii::t('cvs','正在生成文件，大概需要2-3分钟');?>...</div><br>
        <p><?= Yii::t('cvs','当前进度');?> <span id="progress"></span></p>
    </div>
    <div class="export-pdf">
        <div class="left-view export-public">
            <div class="radius" style="width: 300px;">
                <span>1</span>
                <div><?= Yii::t('cvs','地图');?></div>
            </div>
            <div class="radius" style="width:170px;">
                <span>2</span>
                <div><?= Yii::t('cvs','关键指标仪表盘');?></div>
            </div>
            <div class="radius" style="width:480px;">
                <span>3</span>
                <div><?= Yii::t('cvs','趋势分析');?></div>
            </div>
        </div>
        <div class="right-select export-public">
            <img class="close" src="<?php echo Yii::app()->baseUrl.'/images/close.png'; ?>" alt="">
            <form class="layui-form" action=""></form>
            <ul class="export-select-list">
                <li>
                    <p><?= Yii::t('cvs','命名');?>:</p>
                    <label><input id="edit-name" type="text" class="form-control" placeholder="<?= Yii::t('cvs','月份-地区-品类品牌');?>" ></label>
                    <div class="btn btn-info" id="export-whole" ><?= Yii::t('cvs','导出当前页'); ?></div>

                </li>
                <li>
                    <p>1,<?= Yii::t('cvs','地图');?></p>
                    <div>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="aap1" checked="checked"><?= Yii::t('cvs','铺货率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="aap4" checked="checked"><?= Yii::t('cvs','KO当月活动发生率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="aap3" checked="checked"><?= Yii::t('cvs','KO二次陈列');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="aap2" checked="checked"><?= Yii::t('cvs','排面占比');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="aap5" checked="checked"><?= Yii::t('cvs','设备发生率');?>
                        </label>
                    </div>
                </li>
                <li>
                    <p>2,<?= Yii::t('cvs','关键指标仪表盘');?></p>
                    <div>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap1" checked="checked"><?= Yii::t('cvs','铺货率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap4" checked="checked"><?= Yii::t('cvs','KO当月活动发生率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap3" checked="checked"><?= Yii::t('cvs','KO二次陈列');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap2" checked="checked"><?= Yii::t('cvs','排面占比');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap5" checked="checked"><?= Yii::t('cvs','设备发生率');?>
                        </label>
                    </div>
                </li>
                <li>
                    <p>3,<?= Yii::t('cvs','趋势分析');?></p>
                    <div class="psl-arr">
                        <span><?= Yii::t('cvs','铺货率');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp1-dp1"><?= Yii::t('cvs','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp1-dp2"><?= Yii::t('cvs','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp1-dp3"><?= Yii::t('cvs','趋势');?>
                        </label>
                    </div>
                    <div class="dgl-arr">
                        <span><?= Yii::t('cvs','KO当月活动发生率');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp7-dp1"><?= Yii::t('cvs','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp7-dp2"><?= Yii::t('cvs','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp7-dp3"><?= Yii::t('cvs','趋势');?>
                        </label>
                    </div>
                    <div class="psl-arr">
                        <span><?= Yii::t('cvs','KO二次陈列');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp5-dp1"><?= Yii::t('cvs','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp5-dp2"><?= Yii::t('cvs','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp5-dp3"><?= Yii::t('cvs','趋势');?>
                        </label>
                    </div>
                    <div class="kjl-arr">
                        <span><?= Yii::t('cvs','排面占比');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp3-dp1"><?= Yii::t('cvs','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp3-dp2"><?= Yii::t('cvs','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp3-dp3"><?= Yii::t('cvs','趋势');?>
                        </label>
                    </div>
                    <div class="dgl-arr">
                        <span><?= Yii::t('cvs','设备卖进率');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp8-dp1"><?= Yii::t('cvs','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp8-dp2"><?= Yii::t('cvs','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp8-dp3"><?= Yii::t('cvs','趋势');?>
                        </label>
                    </div>
                    <div class="psl-arr">
                        <span><?= Yii::t('cvs','铺货门店数');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp2-dp1"><?= Yii::t('cvs','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp2-dp2"><?= Yii::t('cvs','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp2-dp3"><?= Yii::t('cvs','趋势');?>
                        </label>
                    </div>
                    <div class="dgl-arr">
                        <span><?= Yii::t('cvs','零售价格店次占比');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp6-dp1"><?= Yii::t('cvs','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp6-dp2"><?= Yii::t('cvs','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp6-dp3"><?= Yii::t('cvs','趋势');?>
                        </label>
                    </div>
                    <div class="dgl-arr">
                        <span><?= Yii::t('cvs','促销店次占比');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp9-dp1"><?= Yii::t('cvs','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp9-dp2"><?= Yii::t('cvs','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp9-dp3"><?= Yii::t('cvs','趋势');?>
                        </label>
                    </div>
                </li>
            </ul>
            <button id="pdf-submit" type="button" class="btn btn-primary"><?= Yii::t('cvs','提交');?></button>
        </div>
    </div>
    <div class="container-fluid" style="padding: 15px 0 10px;" ng-controller="optionchg">

        <nav class="navbar navbar-default navbar-fixed-top">
            <?php $this->renderPartial("headercvs", array("searchmodel" => $searchmodel)) ?>
        </nav>

        <!--主体部分-->
        <div id="body" class="row">
            <div class="col-md-7 map-col" style="position: relative;">
                <div class="map-men map-men1">
                    <?= BSHtml::image(Yii::app()->baseUrl.'/images/temp_08091512529506.gif'); ?>
                </div>
                <div class="map-wrap" id="map-view">
                    <div class="right-bottom-export js-rb-export" title="导出该模块" t="map"></div>
                    <div id="container"></div>
                    <div class="legend">
                        <div ng-if="visitab == 'distribution' || visitab == 'distribution_stores'"><?= Yii::t('cvs','铺货率'); ?></div>
                        <div ng-if="visitab == 'sovi' || visitab == 'shelf_number'"><?= Yii::t('cvs','排面占比'); ?></div>
                        <div ng-if="visitab == 'extra_displays'"><?= Yii::t('cvs','KO二次陈列'); ?></div>
                        <div ng-if="visitab == 'thematic_activity'||visitab == promotion"><?= Yii::t('cvs','KO当月活动发生率'); ?></div>
                        <div ng-if="visitab == 'equipment_sales'"><?= Yii::t('cvs','设备卖进率'); ?></div>
                        <div ng-repeat="ko in koinfos" sid="{{ko[4]}}" ng-if="ko[0] == 1">
                            <pre class="{{ko[4]==1?'zhuhai':(ko[4]==2?'taiGu':'inMay')}}"></pre>
                            {{ko[8]}}
                            <span ng-if="ko[mapindex] > 0"><?= BSHtml::image(Yii::app()->baseUrl.'/images/up.png'); ?></span>
                            <span ng-if="ko[mapindex] < 0"><?= BSHtml::image(Yii::app()->baseUrl.'/images/down.png'); ?></span>
                            <span ng-if="ko[mapindex] == null" class="change"><?= Yii::t('cvs','无数据'); ?></span>

                        </div>
                    </div>

                </div>



            </div>

            <!--主体部分右侧内容-->
            <div class="col-md-5" style="margin-bottom: 10px;background-color: transparent;padding-right:0;">

                <!--饼图部分-->
                <div class="row radius10" id="data-view" style="position:relative;overflow:hidden;">
                    <div class="right-bottom-export js-rb-export" title="导出该模块" t="data"></div>
                    <div class="map-men map-men2">
                        <?= BSHtml::image(Yii::app()->baseUrl.'/images/temp_08091512529506.gif'); ?>
                    </div>
                    <?php
                    $tabs = array(
                        array("label" => Yii::t('cvs','铺货率'),'id'=>'ap1','con'=>"铺货率",'ng-click' => "tabchange('distribution')", 'otype' => 'distribution', 'url' => "javascript:void(0)", "class" => "change-map {{(visitab == 'distribution'||visitab=='distribution_stores') ? 'active':''}}"),
                        array("label" => Yii::t('cvs','KO当月活动发生率'),'id'=>'ap4','con'=>"KO当月活动发生率", 'ng-click' => "tabchange('thematic_activity')", 'otype' => 'thematic_activity', 'url' => "javascript:void(0)", "class" => "change-map {{(visitab == 'thematic_activity'||visitab == 'promotion') ? 'active':''}}"),
                        array("label" => Yii::t('cvs','KO二次陈列'),'id'=>'ap3','con'=>"零售价格", 'ng-click' => "tabchange('extra_displays')", 'otype' => 'extra_displays', 'url' => "javascript:void(0)", "class" => "change-map {{visitab == 'extra_displays' ? 'active':''}}"),
                        array("label" => Yii::t('cvs','排面占比'),'id'=>'ap2','con'=>"SOVI",'ng-click' => "tabchange('sovi')", 'otype' => 'sovi', 'url' => "javascript:void(0)", "class" => "change-map {{(visitab == 'sovi'||visitab=='shelf_number') ? 'active':''}}"),
                        array("label" => Yii::t('cvs','设备卖进率'),'id'=>'ap5','con'=>"设备卖进率", 'ng-click' => "tabchange('equipment_sales')", 'otype' => 'equipment_sales', 'url' => "javascript:void(0)", "class" => "change-map {{visitab == 'equipment_sales' ? 'active':''}}"),
                        array("label" => Yii::t('cvs','趋势分析').'>', 'url' => "javascript:void(0)", "class" => "right-more", "id"=>"rate-more"),
                    );
                    echo BSHtml::nav("pills", $tabs);
                    ?>
                    <div class="row graphica1" style="width: 70%;height: 285px;float:left;">
                        <div class="row graphical2" ng-if="visitab=='distribution' || visitab=='distribution_stores'">
                            <?php
                            //只显示数据库中有的
//                            $this->renderpartial("_piechartcvs2", array(
//                                'visible' => "item.shelves != ''",
//                                'kpi' => 'item.distribution',
//                                'kpirate' => 'item.Last_distribution_radio',
//                                'intro'=> 'item.shelves'
//                            ));
                            //总total，常温，冷藏，暖柜都需要显示
                            $this->renderpartial("_piechartcvs", array(
                                'kpiname' => "pie1",
                                'kpi' => 'kopciinfos.koandpcis[pieLeftId][0].distribution',
                                'kpirate' => 'kopciinfos.koandpcis[pieLeftId][0].Last_distribution_radio',
                                'intro'=> Yii::t('cvs','常温+冷藏+暖柜'),
                            ));
                            $this->renderpartial("_piechartcvs", array(
                                'kpiname' => "pie2",
                                'kpi' => 'kopciinfos.koandpcis[pieLeftId][1].distribution',
                                'kpirate' => 'kopciinfos.koandpcis[pieLeftId][1].Last_distribution_radio',
                                'intro'=> Yii::t('cvs','常温'),
                            ));
                            $this->renderpartial("_piechartcvs", array(
                                'kpiname' => "pie3",
                                'kpi' => 'kopciinfos.koandpcis[pieLeftId][2].distribution',
                                'kpirate' => 'kopciinfos.koandpcis[pieLeftId][2].Last_distribution_radio',
                                'intro'=> Yii::t('cvs','冷藏'),
                            ));
                            $this->renderpartial("_piechartcvs", array(
                                'kpiname' => "pie4",
                                'kpi' => 'kopciinfos.koandpcis[pieLeftId][3].distribution',
                                'kpirate' => 'kopciinfos.koandpcis[pieLeftId][3].Last_distribution_radio',
                                'intro'=> Yii::t('cvs','暖柜'),
                            ));
                            ?>

                        </div>
                        <div class="row graphical2" ng-if="visitab=='sovi' || visitab=='shelf_number'">
                            <?php
                            //只显示数据库中有的
//                            $this->renderpartial("_piechartcvs2", array(
//                                'visible' => "item.shelves != ''",
//                                'kpi' => 'item.sovi',
//                                'kpirate' => 'item.Last_sovi_radio',
//                                'intro'=> 'item.shelves'
//                            ));
                            //总total，常温，冷藏，暖柜都需要显示
                            $this->renderpartial("_piechartcvs", array(
                                'kpiname' => "pie1",
                                'kpi' => 'kopciinfos.koandpcis[pieLeftId][0].sovi',
                                'kpirate' => 'kopciinfos.koandpcis[pieLeftId][0].Last_sovi_radio',
                                'intro'=> Yii::t('cvs','常温+冷藏+暖柜'),
                            ));
                            $this->renderpartial("_piechartcvs", array(
                                'kpiname' => "pie2",
                                'kpi' => 'kopciinfos.koandpcis[pieLeftId][1].sovi',
                                'kpirate' => 'kopciinfos.koandpcis[pieLeftId][1].Last_sovi_radio',
                                'intro'=> Yii::t('cvs','常温'),
                            ));
                            $this->renderpartial("_piechartcvs", array(
                                'kpiname' => "pie3",
                                'kpi' => 'kopciinfos.koandpcis[pieLeftId][2].sovi',
                                'kpirate' => 'kopciinfos.koandpcis[pieLeftId][2].Last_sovi_radio',
                                'intro'=> Yii::t('cvs','冷藏'),
                            ));
                            $this->renderpartial("_piechartcvs", array(
                                'kpiname' => "pie4",
                                'kpi' => 'kopciinfos.koandpcis[pieLeftId][3].sovi',
                                'kpirate' => 'kopciinfos.koandpcis[pieLeftId][3].Last_sovi_radio',
                                'intro'=> Yii::t('cvs','暖柜'),
                            ));
                            ?>

                        </div>
                        <div class="row graphical2" ng-if="visitab=='extra_displays' || visitab=='Last_extra_displays_radio'">

                            <?php
                            $this->renderpartial("_piechartcvs2", array(
                                'visible' => "item.extraSku == '1'",
                                'kpi' => 'item.extra_displays',
                                'kpirate' => 'item.Last_extra_displays_radio',
                                'intro'=> ''
                            ));
                            ?>


                        </div>
                        <div class="row graphical2" ng-if="visitab=='thematic_activity' || visitab=='Last_thematic_activity_radio'||visitab == 'promotion'">

                            <?php
                            $this->renderpartial("_piechartcvs2", array(
                                'visible' => "item.activity != '0' && item.activity != '16'",
                                'kpi' => 'item.thematic_activity',
                                'kpirate' => 'item.Last_thematic_activity_radio',
                                'intro'=> 'item.activity'
                            ));
                            ?>

                        </div>
                        <div class="row graphical2" ng-if="visitab=='equipment_sales' || visitab=='Last_equipment_sales_radio'">


                            <?php
                            $this->renderpartial("_piechartcvs2", array(
                                'visible' => "item.equipment != '0' && item.equipment != '4'",
                                'kpi' => 'item.equipment_sales',
                                'kpirate' => 'item.Last_equipment_sales_radio',
                                'intro'=> 'item.equipment'
                            ));
                            ?>

                        </div>
                    </div>

                    <!-- 饼图 -->
                    <div class="clearfix"></div>
                    <div id="rate-box">

                        <div class="row">
                            <div class="row">
                                <div class="number"
                                     ng-if="visitab == 'distribution' || visitab == 'distribution_stores'">
                                     <span ng-bind="month[0] + month[1] + month[2] + month[3] + '<?= Yii::t('cvs','年'); ?>' + month[5] + month[6] + ''"></span> <b ng-bind="selcity"></b> <?= Yii::t('cvs','铺货门店数');?>
                                </div>
                                <div class="number" ng-if="visitab == 'sovi' || visitab == 'shelf_number'">
                                    <span ng-bind="month[0] + month[1] + month[2] + month[3] + '<?= Yii::t('cvs','年'); ?>' + month[5] + month[6] + ''"></span> <b ng-bind="selcity"></b> <?= Yii::t('cvs','店均排面数');?>
                                </div>
                                <div class="number" ng-if="visitab == 'extra_displays' || visitab == 'Last_extra_displays_radio'">
                                    <span ng-bind="month[0] + month[1] + month[2] + month[3] + '<?= Yii::t('cvs','年'); ?>' + month[5] + month[6] + ''"></span> <b ng-bind="selcity"></b> <?= Yii::t('cvs','KO二次陈列门店数');?>
                                </div>
                                <div class="number" ng-if="visitab == 'thematic_activity' || visitab == 'Last_thematic_activity_radio'">
                                    <span ng-bind="month[0] + month[1] + month[2] + month[3] + '<?= Yii::t('cvs','年'); ?>' + month[5] + month[6] + ''"></span> <b ng-bind="selcity"></b> <?= Yii::t('cvs','促销机制店次占比');?>
                                </div>
                                <div class="number" ng-if="visitab == 'equipment_sales' || visitab == 'Last_equipment_sales_radio'">
                                    <span ng-bind="month[0] + month[1] + month[2] + month[3] + '<?= Yii::t('cvs','年'); ?>' + month[5] + month[6] + ''"></span> <b ng-bind="selcity"></b> <?= Yii::t('cvs','可口可乐冰柜店均门数');?>
                                </div>
                                <div class="order-number-more" id="order-more" style="float: right">
                                    <?= Yii::t('cvs','趋势分析')?>>
                                </div>
                            </div>
                            <div class="row" style="height: 306px;overflow: auto;">
                                <?php
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'distribution'  || visitab == 'distribution_stores'||visitab == 'Last_distribution_radio'",
                                    'kpiname' => Yii::t('cvs','{{kopciinfos.koandpcis[pieLeftId][0].shelves}}铺货门店数'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][0].distribution_stores",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][0].distribution_stores",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][0].Last_distribution_stores_radio",
                                        'precent'=>"0"
                                    )
                                ));
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'distribution'  || visitab == 'distribution_stores'||visitab == 'Last_distribution_radio'",
                                    'kpiname' => Yii::t('cvs','{{kopciinfos.koandpcis[pieLeftId][1].shelves}}铺货门店数'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][1].distribution_stores",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][1].distribution_stores",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][1].Last_distribution_stores_radio",
                                        'precent'=>"0"
                                    )
                                ));
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'distribution'  || visitab == 'distribution_stores'||visitab == 'Last_distribution_radio'",
                                    'kpiname' => Yii::t('cvs','{{kopciinfos.koandpcis[pieLeftId][2].shelves}}铺货门店数'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][2].distribution_stores",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][2].distribution_stores",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][2].Last_distribution_stores_radio",
                                        'precent'=>"0"
                                    )
                                ));
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'distribution'  || visitab == 'distribution_stores'||visitab == 'Last_distribution_radio'",
                                    'kpiname' => Yii::t('cvs','{{kopciinfos.koandpcis[pieLeftId][3].shelves}}铺货门店数'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][3].distribution_stores",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][3].distribution_stores",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][3].Last_distribution_stores_radio",
                                        'precent'=>"0"
                                    )
                                ));

                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'sovi' || visitab == 'shelf_number' ||visitab == 'Last_shelf_number_radio'",
                                    'kpiname' => Yii::t('cvs','{{kopciinfos.koandpcis[pieLeftId][0].shelves}}店均排面数'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][0].shelf_number",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][0].shelf_number",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][0].Last_shelf_number_radio",
                                        'precent'=>"0"
                                    )
                                ));
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'sovi' || visitab == 'shelf_number' ||visitab == 'Last_shelf_number_radio'",
                                    'kpiname' =>  Yii::t('cvs','{{kopciinfos.koandpcis[pieLeftId][1].shelves}}店均排面数'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][1].shelf_number",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][1].shelf_number",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][1].Last_shelf_number_radio",
                                        'precent'=>"0"
                                    )
                                ));
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'sovi' || visitab == 'shelf_number' ||visitab == 'Last_shelf_number_radio' ",
                                    'kpiname' =>  Yii::t('cvs','{{kopciinfos.koandpcis[pieLeftId][2].shelves}}店均排面数'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][2].shelf_number",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][2].shelf_number",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][2].Last_shelf_number_radio",
                                        'precent'=>"0"
                                    )
                                ));
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'sovi' || visitab == 'shelf_number' ||visitab == 'Last_shelf_number_radio' ",
                                    'kpiname' =>  Yii::t('cvs','{{kopciinfos.koandpcis[pieLeftId][3].shelves}}店均排面数'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][3].shelf_number",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][3].shelf_number",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][3].Last_shelf_number_radio",
                                        'precent'=>"0"
                                    )
                                ));

                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'extra_displays' || visitab == 'Last_extra_displays_radio' ",
                                    'kpiname' => Yii::t('cvs','二次陈列门店数'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][0].extra_stores",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][0].extra_stores",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][0].Last_extra_stores",
                                        'precent'=>"0"
                                    )
                                ));
                                /*
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'extra_displays' || visitab == 'Last_extra_displays_radio' ",
                                    'kpiname' => Yii::t('cvs','KO二次陈列冷藏铺货门店数'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][3].shelf_number",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][3].shelf_number",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][3].Last_shelf_number_radio",
                                        'precent'=>"0"
                                    )
                                ));
                                 *
                                 */

                                /*
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'thematic_activity' || visitab == 'Last_thematic_activity_radio'||visitab == 'promotion' ",
                                    'kpiname' => Yii::t('cvs','套餐促销机制店次占比'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][0].promotion",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][0].promotion",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][0].Last_promotion_radio",
                                        'precent'=>"1"
                                    )
                                ));
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'thematic_activity' || visitab == 'Last_thematic_activity_radio' ||visitab == 'promotion'",
                                    'kpiname' => Yii::t('cvs','N件X折促销机制店次占比'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][1].promotion",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][1].promotion",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][1].Last_promotion_radio",
                                        'precent'=>"1"
                                    )
                                ));
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'thematic_activity' || visitab == 'Last_thematic_activity_radio'||visitab == 'promotion' ",
                                    'kpiname' => Yii::t('cvs','会员促销机制店次占比'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][2].promotion",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][2].promotion",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][2].Last_promotion_radio",
                                        'precent'=>"1"
                                    )
                                ));
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'thematic_activity' || visitab == 'Last_thematic_activity_radio' ||visitab == 'promotion'",
                                    'kpiname' => Yii::t('cvs','赠品促销机制店次占比'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][3].promotion",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][3].promotion",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][3].Last_promotion_radio",
                                        'precent'=>"1"
                                    )
                                ));
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'thematic_activity' || visitab == 'Last_thematic_activity_radio' ||visitab == 'promotion' ",
                                    'kpiname' => Yii::t('cvs','特价促销机制店次占比'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][4].promotion",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][4].promotion",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][4].Last_promotion_radio",
                                        'precent'=>"1"
                                    )
                                ));

                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'equipment_sales' || visitab == 'Last_equipment_sales_radio' ",
                                    'kpiname' => Yii::t('cvs','可口可乐冰柜卖进门店占比'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][1].equipment_sales",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][1].equipment_sales",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][1].Last_equipment_sales_radio",
                                        'precent'=>"1"
                                    )
                                ));
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'equipment_sales' || visitab == 'Last_equipment_sales_radio' ",
                                    'kpiname' => Yii::t('cvs','可口可乐暖柜卖进门店占比'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][2].equipment_sales",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][2].equipment_sales",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][2].Last_equipment_sales_radio",
                                        'precent'=>"1"
                                    )
                                ));
                                $this->renderpartial("_kpiitemcvs", array(
                                    'visitab' => "visitab == 'equipment_sales' || visitab == 'Last_equipment_sales_radio' ",
                                    'kpiname' => Yii::t('cvs','可口可乐咖啡机卖进门店占比'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[pieLeftId][0].equipment_sales",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[pieLeftId][0].equipment_sales",
                                        'changerate' => "kopciinfos.koandpcis[pieLeftId][0].Last_equipment_sales_radio",
                                        'precent'=>"1"
                                    )
                                ));
                                 *
                                 */

                                $this->renderpartial("_kpiitemcvs3", array());

                                $this->renderpartial("_kpiitemcvs2", array());
                                ?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
        $this->renderpartial("detailscvs", array());
        ?>


    </div>
</div>
<div style="display: none" class="downExcel"></div>
<div id="returnTop" style="display: none">
    <div id="test" style="position:fixed;right:30px;bottom:30px;cursor: pointer;z-index:1000;">
        <img src="<?= Yii::app()->baseUrl.'/images/top.png'?>">
    </div>
</div>
<?php
    //支持csrf安全验证
     $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'imgs-form',
	'enableAjaxValidation'=>false,
                'action'=>array("zipimg"),
                'htmlOptions'=>array("class"=>"hide")
	));

      $this->endWidget();
?>
<script>
window.onload = function (e) {
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
    if (<?php echo !empty($searchmodel->brand) ? 1 : 0;?>) {
        $('#Search_brand').val(<?php echo $searchmodel->brand; ?>);
        $('#Search_brand').trigger('change');
    }
    if (<?php echo !empty($searchmodel->mode) ? 1 : 0;?>) {
        $('#Search_mode').val(<?php echo $searchmodel->mode; ?>);
        $('#Search_mode').trigger('change');
    }



    $('.chosen-select').chosen();
    $('#SSearch_month_table1,#Search_month,#header-month').datepicker({
        format: "yyyy-mm",
        startView: 'months',
        maxViewMode: 'years',
        minViewMode: 'months',
        weekStart: 1,
        language: "<?php if(Yii::app()->language == 'zh_cn'){echo 'zh-CN';}else{echo 'en';}?>",
        autoclose: true,
        todayHighlight: true,
    });
    $(document).scroll(function(){
    //    console.log($(document).scrollTop())
        if($(document).scrollTop()>50){
            $('nav .container-fluid').slideUp(300);
        }else{
            $('nav .container-fluid').slideDown(300);
        }
    })
    // $('.change-map').eq(0).trigger('click')

    $(document).on('click','#rate-more,#order-more',function(){
        $('body,html').stop().animate({
            scrollTop:$('#deepdive').offset().top-140
        },300);
    })

//    $('#deepdive').hover(function(){
//        $(this).addClass('active')
//    },function(){
//        $(this).removeClass('active')
//    })

    $(document).on('click','#order-more',function(){
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

    })
    $('.weidu-list li>label').click(function(){
        let i = $('.weidu-list li>label').index(this);
        let oLeft = $('.weidu-list li>label').eq(i).position().left;
        if(i>=7){
            $('.weidu-list li .weidu-item-box').css('left',oLeft-200);
        }else{
            $('.weidu-list li .weidu-item-box').css('left',oLeft-30);
        }
        $(this).parent().find('.weidu-item-box').show();
        $(this).parent().siblings().find('.weidu-item-box').hide()
    })
    $(document).on('click',function(e){
        let target=$(e.target);
        if(!target.is('.weidu-list li') && target.parent() && target.parents('.weidu-list li').length <= 0){
            $('.weidu-item-box').hide();
        }
    })


    $('.chosen-select').chosen();
    $('.filter-city').change(function () {
        $('#cityid').attr('value', $(this).attr('id'));
    });
        //期报处理
    $(document).on('change','#stage',function(){
        getMonthReport();
    });
    $(document).on('click','#monthly_Reportz,.month',function () {
        getMonthReport();
    });
    function getMonthReport(){
        if(!$(".SSearch_month_table").val() || $(".SSearch_month_table").val().length<=0){
            $(".SSearch_month_table").val($("#Search_month").val());
        }
        var cont = {'sj': $('.SSearch_month_table').val(),'YII_CSRF_TOKEN':"<?=yii::app()->request->csrfToken;?>"};
        // console.log(cont)
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('site/doucumentCvs') ?>',
            dataType: 'json',
            data: cont,
            success: function (data) {
                $('#showtable').html('');
                var showtable = ' ';
                //console.log(data.status)
                if(data.status==1){
                    var submiturl="<?php echo Yii::app()->createUrl('site/uploadexcel',array('id'=>'sid'))?>";
                    var no = "<?= Yii::t('cvs','第');?>";
                    var run = "<?= Yii::t('cvs','期');?>";
                    for (var i = 0; i < data.info.length; i++) {
                        if(data.info[i].stage==-1){
                            showtable += '<tr><td><?= Yii::t('cvs','YTD')?></td><td><span><a  target="_blank" href="' + submiturl.replace('sid',data.info[i].Id) + '"><?= Yii::t('cvs','下载')?></a></span></td></tr>'
                        }else if(data.info[i].stage==0){
                            showtable += '<tr><td><?= Yii::t('cvs','月报')?></td><td><span><a  target="_blank" href="' + submiturl.replace('sid',data.info[i].Id) + '"><?= Yii::t('cvs','下载')?></a></span></td></tr>'
                        }else{
                            showtable += '<tr><td>'+ no + data.info[i].stage + run+'</td><td><span><a  target="_blank" href="' + submiturl.replace('sid',data.info[i].Id) + '"><?= Yii::t('cvs','下载')?></a></span></td></tr>'
                        }
                    }
                    if(data.info.length=0){
                        showtable = "<center><p style=\"color:red\"><?= Yii::t('cvs','该月还没有上传数据')?></p></center>";
                    }
                }else{
                    showtable = "<center><p style=\"color:red\"><?= Yii::t('cvs','该月还没有上传数据')?></p></center>";
                }
//                    console.log(showtable)
                $("#showtable").html(showtable);
            },
            error: function (retMsg) {
                $('#showtable').html();
                $('#showtable').html("<center><p style=\"color:red\"><?= Yii::t('cvs','你没有权限')?></p></center>");
            }
        });
    }
    $('.report a').click(function () {
        var i = $('.report a').index(this);
        //console.log(9);
        $(this).addClass('active');
        $('.report a:not(:eq(' + i + '))').removeClass('active');
    });
}
</script>
<script src="https://webapi.amap.com/maps?v=1.4.1&key=6e4d02aa84a4cc6669b16788c01ac14a&plugin=AMap.Geocoder"></script>
<script src="https://webapi.amap.com/ui/1.0/main.js?v=1.0.11"></script>
<script>

    var koinfos =<?php echo CJSON::encode($datas['koinfos']); ?>;
    var timerm1 = null;
    var timerm2 = null;
    console.log('koinfos',koinfos)
    var specificArea = <?php echo CJSON::encode($datas['koinfoss']); ?>;
    console.log('specificArea',specificArea)

    var zoom = 5;
    var oTypes = 'distribution';
    function init() {
        $('.map-men1').show();
        for (let i = 0; i < $('.radius10 .nav-pills .change-map').length; i++) {
            if ($('.radius10 .nav-pills .change-map').eq(i).hasClass('active')) {
                oTypes = $('.radius10 .nav-pills .change-map').eq(i).attr('otype');
//                console.log(oTypes);
            }
        }
        var map = new AMap.Map('container', {
            zooms: [4, 7],
            zoom: 5,
            resizeEnable: true
        });
        map.plugin(["AMap.ToolBar"], function () {
            map.addControl(new AMap.ToolBar());
        });
//划分区域
        var zhongke = [110000, 620000, 640000, 500000, 650000, 630000, 540000, 130000, 430000, 520000, 210000, 230000, 220000, 150000, 370000,140000, 610000, 510000, 120000],
            taigu = [340000, 350000, 450000, 460000, 410000, 420000, 320000, 360000,330000, 530000,310000,440100],
            zhuhai = [];
        var cityList = zhongke.concat(taigu).concat(zhuhai);
        var colors = ["#e82d34","#f49e00",  "#ffcc00"];

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
                        if (contains(zhuhai, num)) {
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
                        map.setZoomAndCenter(4, [105.576221,36.269047]);
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
                content: "<div v='" + specificArea[i][5] + "' area="+specificArea[i][1]+"' class='" + leval + " clearfix'><span>" + specificArea[i][9] + "</span>" + "<img src='" + urls + "' /></div>"
            });
            marker.setMap(map);
        }

        for (var i = 0; i < koinfos.length; i++) {

            if (!containss(koinfos[i][1], specificArea)) {
//                console.log(koinfos[i][1])
                addBeiJing(koinfos[i][0], koinfos[i][1], koinfos[i][2], koinfos[i][3], koinfos[i][4], koinfos[i][5], koinfos[i][6],koinfos[i][7],koinfos[i][8]);
            }
        }


        function addBeiJing(leval, area, puhuo, sovi, v, yichang, huodong,shebei,showarea) {
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
                    for(let i=0;i<result.districtList.length;i++){
                        if(result.districtList[i].level!=='district'){
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
                        }
                        if (s_con) {
                            urls = parseFloat(s_con) > 0 ? "<?php echo Yii::app()->baseUrl . '/images/up.png' ?>" : "<?php echo Yii::app()->baseUrl . '/images/down.png' ?>";
                        }
                        marker.setLabel({//label默认蓝框白底左上角显示，样式className为：amap-marker-label
                            offset: new AMap.Pixel(6, 20), //修改label相对于maker的位置
                            content: "<div v='" + v + "' area='"+area+"' class='" + levalClass + "'><span> " + showarea + "</span>" + "<img src='" + urls + "' /></div>"
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
            geocoder.getLocation(area, function(status, result) {
                if (status === 'complete' && result.info === 'OK') {
                    geocoder_CallBack(result);
                }
            });
        }
        //地理编码返回结果展示
        function geocoder_CallBack(data) {
            //地理编码结果数组
            var geocode = data.geocodes[0].location;
            map.setZoomAndCenter(7,geocode);
//            console.log(geocode)
        }
        $(document).on('click','.legend .ng-binding',function(){
            let s = $(this).attr('sid');
            console.log(s);
            if(s=='3'){  //zhongke
                $("#Search_region").val(3);
                $("#Search_region").trigger("change");
                map.setZoomAndCenter(5, specificArea[2][2].split(','));
            }else if(s=='2'){
                $("#Search_region").val(2);
                $("#Search_region").trigger("change");
                map.setZoomAndCenter(5, specificArea[1][2].split(','));
            }

        })
        $(document).on('click', '.amap-marker-label', function (e) {
            var clickValue = $(this).find('div span').html();
            var clickId = $(this).find('div').attr('v');
            if(containss(clickValue,specificArea)){
                for (var i = 0; i < specificArea.length; i++) {
                    if (clickValue == specificArea[i][1]) {
                        map.setZoomAndCenter(7, specificArea[i][2].split(','));
                        break
                    }
                }
            }else {
                geocoder(clickValue)
            }

//            map.setZoom(7);
            if ($(this).hasClass('leval1') || $(this).find('div').hasClass('leval2')) {
                $("#Search_region").val(clickId);
                $("#Search_region").trigger("change");
                $("#Search_factory").val('0');
                $("#Search_factory").trigger("change");
                $("#Search_city").val('0');
                $("#Search_city").trigger("change");
            } else if ($(this).find('div').hasClass('leval3')) {
                $("#Search_region").val('1');
                $("#Search_region").trigger("change");
                $("#Search_factory").val(clickId);
                $("#Search_factory").trigger("change");
                $("#Search_city").val('0');
                $("#Search_city").trigger("change");
            } else if ($(this).find('div').hasClass('leval4')) {
                $('#map-box').remove();
                console.log('4')
                var iArea = clickValue;
                let _left=($(this).offset().left+$(this).width()/2)-$('#map-view').width()*0.3;
                let _top=$(this).offset().top-$('#map-view').height()*0.8;
                if(_top<0){
                    _top=0;
                }else if(_top>$('#map-view').height()*0.2){
                    _top = $('#map-view').height()*0.2;
                }
                if(_left<0){
                    _left = 0
                }else if(_left>$('#map-view').width()*0.4){
                    _left = $('#map-view').width()*0.4
                }

                let icode = $(this).find('div').attr('area');
                let geocoder = new AMap.Geocoder({
                    city: "", //城市，默认：“全国”
                    radius: 1000 //范围，默认：500
                });
                $("<div id='map-box'><div id='map-box-item'></div><div id='area'></div><div class='map-box-close'>关闭</div></div>").appendTo('#map-view');
                $('#map-box').css({
                    'top':_top,
                    'left':_left
                })

                //地理编码,返回地理编码结果
                geocoder.getLocation(icode, function(status, result) {
                    if (status === 'complete' && result.info === 'OK') {
                        // console.log(result.geocodes[0].adcode);
                        iDecode = [result.geocodes[0].adcode];
                         //创建地图
                        var smap = new AMap.Map('map-box-item', {
                            cursor: 'default',
                            zoom: 8
                        });
                        // console.log(iArea)
                        document.getElementById('area').innerHTML = iArea;
                        AMapUI.loadUI(['geo/DistrictExplorer'], function(DistrictExplorer){
                            //创建一个实例
                            var _districtExplorer = new DistrictExplorer({
                                map: smap,
                                eventSupport: true,
                            });

                            function renderAreaNode(areaNode) {

                                //绘制子区域
                                _districtExplorer.renderSubFeatures(areaNode, function(feature, i) {

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
                            _districtExplorer.loadMultiAreaNodes(iDecode, function(error, areaNodes) {

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
                                    'name':'<?= Yii::t('app','北区');?>',
                                    'site':[121.372863,31.275032]
                                },{
                                    'name':'<?= Yii::t('app','杨浦');?>',
                                    'site':[121.538905,31.312967]
                                },{
                                    'name':'<?= Yii::t('app','长宁');?>',
                                    'site':[121.402927,31.19712]
                                },{
                                    'name':'<?= Yii::t('app','黄浦');?>',
                                    'site':[121.486883,31.211508]
                                },{
                                    'name':'<?= Yii::t('app','上南');?>',
                                    'site':[121.505394,31.155407]
                                },{
                                    'name':'<?= Yii::t('app','南汇');?>',
                                    'site':[121.590055,31.050649]
                                },{
                                    'name':'<?= Yii::t('app','宝山');?>',
                                    'site':[121.402973,31.447997]
                                },{
                                    'name':'<?= Yii::t('app','松江');?>',
                                    'site':[121.346761,31.105019]
                                },{
                                    'name':'<?= Yii::t('app','闵行');?>',
                                    'site':[121.394962,31.056601]
                                },{
                                    'name':'<?= Yii::t('app','浦东');?>',
                                    'site':[121.632402,31.198802]
                                },{
                                    'name':'<?= Yii::t('app','青浦');?>',
                                    'site':[121.053428,31.104784]
                                },{
                                    'name':'<?= Yii::t('app','奉贤&金山');?>',
                                    'site':[121.166061,30.892842]
                                },{
                                    'name':'<?= Yii::t('app','虹口');?>',
                                    'site':[121.48039,31.312277]
                                },{
                                    'name':'<?= Yii::t('app','嘉定');?>',
                                    'site':[121.318282,31.31533]
                                },{
                                    'name':'<?= Yii::t('app','川沙');?>',
                                    'site':[121.667695,31.278765]
                                },{
                                    'name':'<?= Yii::t('app','崇明');?>',
                                    'site':[121.843979,31.535774]
                                },
                            ]
                            for(let i=0;i<pointArr.length;i++){
                                addMarker(pointArr[i].name,pointArr[i].site);
                            }
                            $('.leval5').parents('.amap-marker').show();
                            function addMarker(name,site){
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
                $("#Search_city").val(clickId);
                $("#Search_city").trigger("change");
            }
        })
        $(document).on('mouseenter', '.amap-marker', function () {
            $(this).css('z-index', 9999).siblings().css('z-index', 10);
        })
        $(document).on('click','.map-box-close',function(){
            $('#map-box').remove();
        })
        clearTimeout(timerm2);
        timerm2 = setTimeout(function () {
            $('.leval1').parents('.amap-marker').hide();
            $('.leval2').parents('.amap-marker').hide();
            $('.map-men1').fadeOut(300);
        }, 4000)

    }
    init()
    $(document).on('click', '.change-map', function () {
        $('#container').remove();
        $(this).addClass('active').siblings().removeClass('active');
        oTypes = $(this).attr('o_type');
        $('<div id="container"></div>').appendTo('.map-wrap');
        clearTimeout(timerm1);
        clearTimeout(timerm2);
        init();
    })


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

</script>
<script src="<?php echo Yii::app()->baseUrl.'/js/html2canvas.js' ;?>"></script>
<script>
$(function(){
    var timerm3 = null;
    var timerm4 = null;
    var timerm5 = null;
    $(document).on('click','.close',function(){
        $('body').removeClass('body-active');
        $('.export-pdf').hide();
    })
    $(document).on('click','#pdf-submit',function(){
        // if($('.chart-box ng-echarts').length>16){
        //     layer.tips('最多选择16个对比项!', '#pdf-submit', {
        //         tips: [1, '#3595CC'],
        //         time: 3500
        //     });
        //     return false
        // }
        $('.export-pdf').hide();
        var checkedList = [];
        for(let f=0;f<$('.export-select-list label').length;f++){
            if($('.export-select-list input').eq(f).prop('checked')){
                checkedList.push($('.export-select-list input').eq(f).val());
            }
        }
        $('#progress').html(1+'/'+checkedList.length);
        $('.pdftips').addClass('active');
        $(document).scrollTop(0);
        $("#imgs-form input[name!='YII_CSRF_TOKEN']").remove();
        var pdfName = $('#edit-name').val();
        exportFiles(pdfName,checkedList,0);
    })

    function exportFiles(name,arr,i){
        var trigger_info = triggerInfo(arr[i]);
        console.log(trigger_info);
        var _part;
        switch (trigger_info.export_part){
            case '#map-view':
            _part = '地图';
            break;
            case '#data-view':
            _part = '仪表盘';
            break;
            case '#chart-view':
            _part = '图表'
            break;
        }
        if(trigger_info.trigger_item.length>1){
            var eName = $('#Search_month').val()+'_'+_part+$('#'+trigger_info.trigger_item[1]).attr('con');
            console.log(eName)
            $('#'+trigger_info.trigger_item[0]).trigger('click');
            setTimeout(function(){
                $('#'+trigger_info.trigger_item[1]).trigger('click');
                if(trigger_info.trigger_item[1]=='dp3'){
                    clearInterval(timerm4);
                    timerm4 = setInterval(function(){
                        if($('#chart-view').children('.mb-fff').length<=0){
                            // console.log(123414)
                            clearInterval(timerm4);
                            method1();
                        }
                    },100)
                }else{
                    method1();

                }
            },trigger_info.loadingtime)
        }else{
            var eName = $('#Search_month').val()+'_'+_part+$('#'+trigger_info.trigger_item[0]).attr('con');
            console.log(eName)
            $('#'+trigger_info.trigger_item[0]).trigger('click');
            method1();

        }
        function method1(){
            setTimeout(function(){
                $('.chart-box').height('auto');
                html2canvas($(trigger_info.export_part), {
                    background:'#fff',
                    onrendered: function(canvas) {
                        var url = canvas.toDataURL();
                        $("<textarea name='"+eName+"'>"+url+"</textarea>").appendTo("#imgs-form");
                        if(i>=arr.length-1){
                            $('nav').show();
                            $("<input name='"+i+"'></input>").appendTo("#imgs-form");
                            $('#imgs-form').submit();
                            $('.pdftips').removeClass('active');
                            $('.chart-box').height('480px');
                            $('body').removeClass('body-active');
                            $('.js-rb-export').show();
                        }else{
                            i++;
                            $('#progress').html(i+1+'/'+arr.length);
                            exportFiles(name,arr,i);
                        }

                    },
                    width: $(trigger_info.export_part).outerWidth(),
                    height: $(trigger_info.export_part).outerHeight(),
                })
            },trigger_info.loadingtime)
        }
    }
    function triggerInfo(el){
        let trigger_item,loadingtime,export_part;
        if(new RegExp('aap').test(el)){  //地图
            trigger_item = [el.substr(1)]
            export_part = '#map-view';
            loadingtime = 4500;
        }else if(new RegExp('bap').test(el)){  //仪表盘
            trigger_item = [el.substr(1)]
            export_part = '#data-view';
            loadingtime = 1500;
        }else if(new RegExp('cp').test(el)){  //图表
            trigger_item = el.split('-');
            export_part = '#chart-view';
            loadingtime = 1500;
        }
        return {
            'trigger_item':trigger_item,   //模拟点击内容
            'export_part':export_part,    //导出板块
            'loadingtime':loadingtime    //导出等待时间，根据板块自定义
        }
    }
    function exSingle(el,arr,i,time,n,m){
        var eName = n + (m?m:$(arr[i]).attr('con'));
        console.log(eName);
        if(arr.length>0){
            $(arr[i]).trigger('click');
        }
        if(arr[i]=='#dp3'){
            clearInterval(timerm5);
            timerm5 = setInterval(function(){
                if($('#chart-view').children('.mb-fff').length<=0){
                    clearInterval(timerm5);
                    method2();
                }

            },100)
        }else{
            method2()
        }
        function method2(){
            clearTimeout(timerm3);
            $('.chart-box').height('auto');
            timerm3 = setTimeout(function(){
                html2canvas($(el), {
                    background:'#fff',
                    onrendered: function(canvas) {
                        var url = canvas.toDataURL();
                        console.log('url.length',url.length)
                        $("<textarea name='"+eName+"'>"+url+"</textarea>").appendTo("#imgs-form");
                        console.log($('#imgs-form textarea').eq(0).val().length)
                        i++;
                        if(i<arr.length){
                            exSingle(el,arr,i,time,n,m);
                        }else{
                            // console.log($('#imgs-form').find('input').length)
                            console.log($(el).outerHeight())
                            $('#imgs-form').submit();
                            $('.fixed-mb').remove();
                            $('.chart-box').height('480px');
                            $('.js-rb-export').show();
                        }

                    },
                    width: $(el).outerWidth(),
                    height: $(el).outerHeight(),
                })
            }, time);
        }

    }

    $(document).on('click','#export-whole',function(){
        var text = $('#edit-name').val();
        var reg = new RegExp("[\\u4E00-\\u9FFF]+","g");
        if(text == ''){
            layer.msg('命名不能为空');
   //     }else if(reg.test(text)){
   //         layer.msg('请避免使用汉字命名');
        }else{
            $(document).scrollTop(0)
            $('<div>',{
                class:'fixed-mb'
            }).appendTo('body');
            $("#imgs-form input[name!='YII_CSRF_TOKEN']").remove();
            $(".export-pdf").hide();
            layer.closeAll();
            console.log(text);
            exSingle('#cvs',[''],0,300,text);
        }

    })

    $(document).on('click','.js-rb-export',function(){
        $('.js-rb-export').hide();
        let clickItem = $(this).attr('t');
        $('<div>',{
            class:'fixed-mb'
        }).appendTo('body');
        $("#imgs-form input[name!='YII_CSRF_TOKEN']").remove();
        console.log(clickItem);
        switch (clickItem){
            case 'map':
                var arrList = [''];
                var _name = $('#Search_month').val()  + '_地图';
                console.log(_name);
                exSingle('#map-view',arrList,0,0,_name,$('#vitab').html())
                break;
            case 'data':
                var arrList = ['#ap1','#ap2','#ap3','#ap4','#ap5']
                var _name = $('#Search_month').val() +'_仪表盘_';
                exSingle('#data-view',arrList,0,1200,_name);
                break;
            default:
                var arrList = ['#dp1','#dp2','#dp3']
                var _name = $('#Search_month').val()  + '_图表_';
                exSingle('#chart-view',arrList,0,600,_name);
        }

    })
});
$(document).scroll(function() {
    getbrowser();
});
function getbrowser(){
    var height = $(document).scrollTop(); //获取滚动条到顶部的垂直高度
    if(height > 100){
        $("#returnTop").show();
        test.onclick = function(){
            document.body.scrollTop = document.documentElement.scrollTop = 0;
        }
    }else{
        $("#returnTop").hide();
    }
}
</script>
