<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/angular.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/ng-echarts.js');

$relations = Relationship::model()->findAll(array("index" => "Id"));

//foreach($relations as $key=> $value){
//  //  $relations[$key]->name = Yii::t('app',$value->name,array(1));
//}
$skus = Sku::model()->findAll(array("index" => "Id"));
$skuss = Sku::model()->findAll(array("order" => "sort"));

?>
<script>

    var app = angular.module('cockdash', ['ng-echarts'], function ($httpProvider) {

    });
    app.controller("optionchg", function ($scope, $http,$filter) {
        $scope.region = "4";
        $scope.factory = "0";
        $scope.city = "0";
        $scope.station="0";
        $scope.month = "<?= $searchmodel->month ?>";
        $scope.category = "0";
        $scope.brand = "0";
        $scope.mode = "0";
        $scope.mode2 = "0";
        $scope.nodata='';
        $scope.deepgroupcheck = 'group';
        $scope.deepbrandcheck = 'catalog';
        //
        $scope.relations = <?php echo CJSON::encode($relations) ?>;
        $scope.skus = <?php echo CJSON::encode($skus) ?>;
        // console.log($scope.skus)
        $scope.skuss = <?php echo CJSON::encode($skuss) ?>;
        $scope.skuslist = $scope.skuss;

//        console.log($scope.skus)
        //
        angular.forEach($scope.relations, function (data, index, array) {
            $scope.relations[index]['checked'] = true;
            $scope.relations[index]['show'] = false;
        });
        //
        angular.forEach($scope.skus, function (data, index, array) {
            if(data.depth=="1")$scope.skus[index]['checked'] = 1;
        });
        $scope.kopciinfos = "";
        $scope.totalfixed = "";
        $scope.orders = "";
        $scope.visitab = "visirate";
        $scope.visichart = "attach_rate";
        $scope.koinfos = "";
        $scope.allskuinfos = "";
        $scope.history = {
            'attach_rate': 0,
            'placingTotalOrderNumber': 0,
            'availability': 0,
            'numberOfSalesStores': 0,
            'Incidence': 0,
            'opo': 0,
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
//            console.log(head);
            layer.open({
                type: 1,
                title: '另存为模板',
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
                    'mode':$scope.mode,
                    'mode2':$scope.mode2,
                    'deepgroupcheck':$scope.deepgroupcheck,
                    'deepbrandcheck':$scope.deepbrandcheck,
                    'skus':$scope.skus,
                    'relations':$scope.relations,
                    'head':$scope.head
                }
                console.log("<?=yii::app()->request->csrfToken;?>");
                $.ajax({
                    type: 'post',
                    url: '<?php echo $this->createUrl('site/settemplate') ?>',
                    dataType: 'json',
                    data: {
                        'YII_CSRF_TOKEN':"<?php echo Yii::app()->getRequest()->getCsrfToken(); ?>",
                        'tempstr':JSON.stringify(templetData),
                        'tempname':$scope.saveName,
                    },
                    success: function (data) {
                        console.log(res)
                    }
                })
                // $http.post(
                //     '<?php echo $this->createurl("site/settemplate"); ?>',
                //     {
                //         'tempstr':JSON.stringify(templetData),
                //         'tempname':$scope.saveName,
                //         'YII_CSRF_TOKEN':"<?php echo Yii::app()->getRequest()->getCsrfToken(); ?>"
                //     }
                // ).then(function successCallback(res){
                //     console.log(res)
                //     $('.conta>.layui-layer-page .layui-layer-close1').trigger('click');
                //     if(res.status == 1){
                //         $scope.ajax_getTemplet();
                //         layer.msg('保存成功！');
                //     }else{
                //         layer.msg('请求失败！');
                //     }
                // },function errorCallback(res){
                //     $('.conta>.layui-layer-page .layui-layer-close1').trigger('click');
                //     layer.msg('请求失败！');
                // })
                
            }

        }
        $scope.ajax_getTemplet = function(){
            $http({
                url:'<?php echo $this->createurl("site/gettemplatelist"); ?>',
                
            }).success(function(res){
                console.log(res);
                let _res = res.data;
                angular.forEach(_res, function (data, key) {
                    console.log(key)
                    _res[key] = JSON.parse(_res[key])
                })
                $scope.templetList = _res;
            })
        }

        $scope.showsel = false;
        $scope.getTemplet = function(key){  //选中模板事件
            if(!key){
                return false
            }
       //     console.log(key)
            var getData = $scope.templetList[key];
        //    console.log(typeof(getData.brand));
            var headArr = getData.head.split(',');
            for(let i=0;i<headArr.length;i++){
                $('#form .chosen-single span').eq(i).html(headArr[i]);
            }
            $('#Search_month').val(headArr[headArr.length-1]);
            $scope.region = getData['region'];
            $scope.factory = getData['factory'];
            $scope.city = getData['city'];
            $scope.month = getData['month'];
            $scope.category = getData['category'];
            $scope.brand = getData['brand'];
            $scope.skus = getData['skus'];
            $scope.relations = getData['relations'];
            $scope.mode = getData['mode'];
            $scope.mode2 = getData['mode2'];
            $scope.deepgroupcheck = getData['deepgroupcheck'];
            $scope.deepbrandcheck = getData['deepbrandcheck'];
            $scope.onoptionchange();
        }
        $scope.lineallskuinfos={};
        $scope.kpibtnchg = function (kpi, history) {
            if($scope.history[kpi] == history)return false
            $scope.history[kpi] = history;
            if(history == 1){
                $scope.getHistoryData();
            }else{
                $('.tabtitle').show()
            }
//            console.log($scope.history[kpi])
        }

        $scope.getHistoryData = function(){
            $('<div>',{
                class:'mb-fff'
            }).appendTo('#chart-view');
            $('#map-view')
            $('.tabtitle').hide();
            var config = {
                'region': $scope.region,
                'factory': $scope.factory,
                'city': $scope.city,
                'month': $scope.month,
                'category': $scope.category,
                'brand': $scope.brand,
                'mode': $scope.mode
            };
            $http({
                url:'<?php echo $this->createurl("site/gethistorydata"); ?>',
                param:config
            }).success(function(res){
                console.log(res)
                $scope.lineallskuinfos = res;
                $('.mb-fff').remove();
            }).error(function(res){
                $('.mb-fff').remove();
            })
        }
        $scope.checkralationshow = function (id) {
            let ret = false;
            // console.log($scope.relations)
            if ($scope.deepgroupcheck == 'group' && $scope.relations[id].depth == 1) ret = true;
            //
            if ($scope.deepgroupcheck == 'factory') {
                if ($scope.factory !== '0' && id == $scope.factory) ret = true;
                if ($scope.factory == '0' && $scope.relations[id].parent == $scope.region && $scope.region != 4) ret = true;
                if ($scope.region == '4' && $scope.relations[id].depth == 2) ret = true;
            }
            if ($scope.deepgroupcheck == 'city' && $scope.factory !== '0') {
                if (($scope.relations[id].parent == $scope.factory) || ($scope.city != '0' && $scope.relations[id].Id == $scope.city)) ret = true;
            }

            if ($scope.deepgroupcheck == 'city' && $scope.factory == '0'&&$scope.relations[id].depth==3) {
                if($scope.city=='0'){
                    if($scope.region != '4'&&($scope.relations[$scope.relations[id].parent].parent == $scope.region)){   
                        ret = true;
                    }
                    if ($scope.region == '4') {    //选择了装瓶集团
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
            $scope.relations[id]['checked'] = $scope.relations[id]['checked'] == 1 ? 0 : 1;
        }
        $scope.skuchgcheck = function (id) {
            $scope.skus[id]['checked'] = $scope.skus[id]['checked'] == 1 ? 0 : 1;
        }
        $scope.brandchg = function () {
            // console.log($scope.skus)
            if ($scope.category == 2) {//汽水单独处理
                angular.forEach($scope.skus, function (data, index, array) {
                    if ($scope.deepbrandcheck == 'catalog') {
                        if (data.parent == $scope.category) {
                            $scope.skus[index]['checked'] = 1;
                        } else if (data.parent == 33 || data.parent == 6) {
                            $scope.skus[index]['checked'] = 0;
                        }
                    } else{
                        if (data.parent == $scope.category) {
                            $scope.skus[index]['checked'] = 0;
                        } else if (data.parent == 33 || data.parent == 6) {
                            if($scope.brand == 0 ){
                                 $scope.skus[index]['checked'] = 1;
                            }else if(data.parent == $scope.brand) {
                                $scope.skus[index]['checked'] = 1;
                            }else if(index == $scope.brand) {
                                $scope.skus[index]['checked'] = 1;
                            }else{
                                $scope.skus[index]['checked'] = 0;
                            }
                        }
                    }
                });
                return 
            }
            // console.log($scope.deepbrandcheck)
            if($scope.category=='0'&&$scope.brand=='0'){
                // console.log($scope.allskuinfos.bar)
                angular.forEach($scope.skus, function (data, index, array) {
                    // console.log(data.depth,data.name)
                    if (data.depth == '2') {
                        $scope.skus[data.Id]['checked'] = 0;
                    }else if(data.depth == '1'&&$scope.deepbrandcheck=='catalog'){
                        // console.log(data.name,data.Id)
                        $scope.skus[data.Id]['checked'] = 1;
                    }else{
                        $scope.skus[data.Id]['checked'] = 0;
                    }
                });
            }
        }

        $scope.mapindex=3;
        $scope.visiname = '上线率';
        $scope.tabchange = function (tab) {
            $scope.nzk=true;
            $scope.visitab = tab;
            switch (tab){
                case 'totalorders':
                $scope.visiname = '配售率';
                $scope.mapindex=3;
                break;
                case 'visirate':
                $scope.visiname = '上线率';
                $scope.mapindex=5;
                break;
                case 'orders':
                $scope.visiname = '点购率';
                $scope.mapindex=6;
                break;
            }
        };
        $scope.chartchange = function (tab) {
            $scope.visichart = tab;
        };
        // console.log($scope.skus)
        $scope.cancelSelect = function(type,boo){
            if(type == 'areacheck'){
                var _depth;
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
            }else if(type == 'brandcheck'){
                var _depth;
                console.log($scope.deepbrandcheck)
                switch ($scope.deepbrandcheck){
                    case 'catalog':
                    _depth = 1;
                    break;
                    case 'brand':
                    _depth = 2;
                    break;
                }
                angular.forEach($scope.skus, function (data, index, array) {
                    console.log(data,_depth)
                    if(_depth == data.depth)$scope.skus[index]['checked'] = boo;
                });
            }
        }
        
        $scope.selcity = '<?= Yii::t('app','全国')?>';
        $scope.regionDisable = false;
        $scope.factoryDisable = false;
        $scope.catalogDisable = false;
        $scope.selbrand = '全品类';
        $scope.modetype = '';
        $scope.showCon = $scope.selcity +' '+ $scope.modetype;
        $scope.onoptionchange = function (level) {
            $('.map-men2').show();
            // $('.radio-inline.disable, .checkbox-inline.disable').css('pointer-events','normal');
        //    console.log($scope.factory, $scope.city);
            if (level == 1) {  //装瓶集团
                $scope.factory = "0";
                $scope.city = "0";
            }
            // return false
            if (level == 2) {  //装瓶厂
                $scope.city = "0";
            }
            if (level == 5) {  //品类
                $scope.brand = '0'
                $scope.mode = '0'
                $scope.mode2 = '0'
                $scope.modetype = '';
            }
            if(level == 6){
                $scope.mode = '0'
                $scope.mode2 = '0'
                $scope.modetype = '';
            }
            if(level == 7){
                if($scope.brand!="0"){
                    let myName = $('#Search_mode option[value='+$scope.mode+']').attr('myname');
                    $scope.mode2 = ''+$('#Search_mode2 option[myname='+myName+']').val()+'';
                    // console.log(myName,$scope.mode2)
                }
                if($scope.mode == '0'){
                    $scope.modetype = '';
                }else{
                    $scope.modetype = '- '+$('#Search_mode option[value='+$scope.mode+']').html();
                }
            }

            if($scope.city!='0'){
                $scope.selcity = $('.map-control').eq(2).find('option[value='+$scope.city+']').html();
                $scope.regionDisable = true;
                $scope.factoryDisable = true;
                $scope.deepgroupcheck = "city";
            }else if($scope.factory!='0'){
                $scope.regionDisable = true;
                $scope.factoryDisable = true;
                $scope.deepgroupcheck = "city";
                $scope.selcity = $('.map-control').eq(1).find('option[value='+$scope.factory+']').html();
            }else if($scope.region!='4'){
                $scope.regionDisable = true;
                $scope.factoryDisable = false;
                $scope.deepgroupcheck = "factory";
                $scope.selcity = $('.map-control').eq(0).find('option[value='+$scope.region+']').html();
            }else{
                $scope.regionDisable = false;
                $scope.factoryDisable = false;
                $scope.deepgroupcheck = "group";
                $scope.selcity = '<?= Yii::t('app','全国')?>';
            }

            if(($scope.category!=0&&$scope.category!=2)||$scope.brand!=0){
                $scope.selbrand = $('#Search_category').find('option[value='+$scope.category+']').html()+' '+$('#Search_brand').find('option[value='+$scope.brand+']').html();
                $scope.catalogDisable = true;
                $scope.deepbrandcheck = 'brand'
            }else{
                $scope.catalogDisable = false;
                $scope.deepbrandcheck = 'catalog'
                $scope.selbrand = $('#Search_category').find('option[value='+$scope.category+']').html()
            }
           
            $scope.showCon = $scope.selcity +' '+ $scope.modetype;
            
            var config = {
                'region': $scope.region,
                'factory': $scope.factory,
                'city': $scope.city,
                'month': $scope.month,
                'category': $scope.category,
                'brand': $scope.brand,
                'mode': $scope.mode
            };
            $http({
                url: '<?php echo $this->createurl("getdata"); ?>',
                params: config
            }).success(function (response) {
                $scope.nodata='<?= Yii::t('app','无数据');?>';
                $scope.kopciinfos = response.kopciinfos;
                // console.log($scope.kopciinfos)
                // console.log($scope.skus)
                $scope.totalfixed = response.totalfixed;
                $scope.orders = response.orders;
                $scope.koinfos = response.koinfos;
                $scope.allskuinfos = response.allskuinfos;
                console.log(response);
                // console.log($scope.allskuinfos.bar)
                $('.map-men2').hide();
                if($scope.brand!='0'){  //选择了品牌
                    $scope.pieLeft = $scope.skus[$scope.brand].name;
                    $scope.pieLeftId = $scope.mode=='0'?$scope.brand:$scope.mode;
                    if($scope.skus[$scope.brand].parent == 6 || $scope.skus[$scope.brand].parent == 33){
                        $scope.pieRight = $scope.skus[$scope.skus[$scope.skus[$scope.brand].parent].parent].name;
                        $scope.pieRightId = $scope.mode=='0'?$scope.skus[$scope.skus[$scope.brand].parent].parent:$scope.mode2;
                    }else{
                        $scope.pieRight = $scope.skus[$scope.skus[$scope.brand].parent].name;
                        $scope.pieRightId = $scope.mode=='0'?$scope.skus[$scope.brand].parent:$scope.mode2;
                    }
                    
                }
                if($scope.category!='0'&&$scope.brand=='0'){ //只选择了品类
                    $scope.pieLeft = $scope.skus[$scope.category].name;
                    $scope.pieRight = '软饮料';
                    $scope.pieLeftId = $scope.mode=='0'?$scope.category:$scope.mode;
                    $scope.pieRightId = $scope.mode=='0'?123:$scope.mode2;
                }
                if($scope.brand=='0'&&$scope.category=='0'){  //品类品牌都没选
                    $scope.pieLeft = '<?= Yii::t('app','KO汽水');?>';
                    $scope.pieRight = '<?= Yii::t('app','软饮料');?>';
                    $scope.pieLeftId = $scope.mode=='0'?6:$scope.mode;
                    $scope.pieRightId = $scope.mode=='0'?123:$scope.mode2;
                }
                $scope.ko_orders.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieLeftId].Incidence, 1 - $scope.kopciinfos.koandpcis[$scope.pieLeftId].Incidence];
                $scope.pci_orders.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieRightId].Incidence, 1 - $scope.kopciinfos.koandpcis[$scope.pieRightId].Incidence];
                $scope.ko_totalorders.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieLeftId].attach_rate, 1 - $scope.kopciinfos.koandpcis[$scope.pieLeftId].attach_rate];
                $scope.pci_totalorders.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieRightId].attach_rate, 1 - $scope.kopciinfos.koandpcis[$scope.pieRightId].attach_rate];
                $scope.ko_visirate.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieLeftId].availability, 1 - $scope.kopciinfos.koandpcis[$scope.pieLeftId].availability];
                $scope.pci_visirate.series[0].data = [$scope.kopciinfos.koandpcis[$scope.pieRightId].availability, 1 - $scope.kopciinfos.koandpcis[$scope.pieRightId].availability];

                $scope.brandchg();

                //$scope.flushskucharts();
            }).error(function (data, header, config, status) {
                $('.map-men2').hide();
//                alert(data);
            });

        };

        $scope.colorList = ['#8fe5c8','#b0cbf0','#f7e7a8','#A8A3E2','#fab0b0','#EB9EF3','#F0B277','#BDE569','#C38072','#FA8D91'];
        $scope.setbaroption = function (kpi, rid,min,max) {
            // console.log(rid)
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
                    if ($scope.relations[subdata[1].relationship_id]['checked'] && $scope.relations[subdata[1].relationship_id]['show'] && $scope.skus[subdata[1].sku_id]['checked']) {
                        $scope.newskus.push(subdata[1][kpi]);
                    }
                });
            })
            angular.forEach($scope.allskuinfos.bar, function (data, index, array) {
                
                if (data.relationship.Id == rid) {
                    $scope.baroption.title.text = data.relationship.name;
                    if (data.self&&data.self[1][kpi]>30) {
                        $scope.baroption.title.subtext = data.self[0].name + '：' + parseInt(data.self[1][kpi]) ;
                    }else if(data.self&&data.self[1][kpi]<30){
                        $scope.baroption.title.subtext = data.self[0].name + '：' + parseInt(data.self[1][kpi] * 100).toFixed(2) + "%";
                    }
                        
                    $scope.baroption.yAxis.data = [];
                    $scope.baroption.legend.data=[];
                    var _max = Math.max.apply(null,$scope.newskus);
                    var _min = Math.min.apply(null,$scope.newskus);
                    console.log(_max)
                    if(_max>10){
                        $scope.baroption.xAxis.max=_max>1000?Math.ceil(_max/100)/10:_max;
                        $scope.baroption.xAxis.min= 0;
                        $scope.baroption.xAxis.axisLabel.formatter = _max>1000?'{value}k':'{value}'
                        $scope.baroption.tooltip.formatter=_max>1000?'{b}:\n{c}k':'{b}:\n{c}',
                        $scope.baroption.series[0].data = [];
    //                    console.log(data.skus)
                        angular.forEach(data.skus, function (subdata, index, array) {

                            let idx = index;

                            if (subdata[1][kpi] == null) subdata[1][kpi] = 0;
                            if ($scope.skus[subdata[1].sku_id]['checked']) {
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
                                $scope.baroption.series[0].data.push({
                                    value: _max>1000?Math.floor(subdata[1][kpi]/10)/100:Math.floor(subdata[1][kpi]),
                                    itemStyle: {
                                        normal:{
                                            color: subdata[0].color
                                        }
                                    },
                                    formatter: _max>1000?'{value}k':'{value}',
                                    label:labelRight
                                })
                                $scope.baroption.legend.data.push(subdata[0].name);
                            }
                        });
                    }else{
                        $scope.baroption.xAxis.max=Math.ceil(_max*1000)/10;
                        $scope.baroption.xAxis.min= Math.min(0,Math.floor(_min*1000)/10);
                        $scope.baroption.xAxis.axisLabel.formatter = '{value}%'
                        $scope.baroption.tooltip.formatter='{b}:\n{c}%',

                        $scope.baroption.series[0].data = [];
    //                    console.log(data.skus)
                        angular.forEach(data.skus, function (subdata, index, array) {

                            let idx = index;

                            if (subdata[1][kpi] == null) subdata[1][kpi] = 0;
                            if ($scope.skus[subdata[1].sku_id]['checked']) {
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
                    
                  //   console.log($scope.baroption.xAxis);
                  //   console.log(rid);
                 //    console.log($scope.newskus);


                }

            });
            return $scope.baroption;
        };

        $scope.setlineoption = function (kpi, rid,min,max) {
            $scope.newskus=[];
            angular.forEach($scope.lineallskuinfos.bar, function (data, index, array) {
                //提取指标的所有数据，用于寻找最大最小值
                angular.forEach(data.skus, function (subdata, index, array) {
                    if ($scope.relations[subdata[1].relationship_id]['checked'] && $scope.relations[subdata[1].relationship_id]['show'] && $scope.skus[subdata[1].sku_id]['checked']) {
                        angular.forEach(subdata[2],function(subsubdata,index,array){
                            $scope.newskus.push(subsubdata[kpi]);
                        })
                        
                    }
                });
            })

            if(max>10){
                let idxs = 0;
                $scope.lineoption.tooltip={
                    trigger: 'axis',
                    formatter: '{b}'
                }
                if(kpi == 'numberOfSalesStores'){
                    angular.forEach($scope.lineallskuinfos.bar, function (data, index, array) {
                        //提取指标的所有数据，用于寻找最大最小值
                        angular.forEach(data.skus, function (subdata, index, array) {
                            if ($scope.relations[subdata[1].relationship_id]['checked'] && $scope.relations[subdata[1].relationship_id]['show'] && $scope.skus[subdata[1].sku_id]['checked']) {
                                angular.forEach(data.storenum, function (subdata, index, array) {
                                    $scope.newskus.push(subdata);
                                });
                            }
                        });
                        
                    })
                }

                $scope.lineoption.yAxis.max=Math.ceil(Math.max.apply(null,$scope.newskus)/1000);
                $scope.lineoption.yAxis.min=Math.floor(Math.min(0, Math.min.apply(null,$scope.newskus))/1000);
                $scope.lineoption.yAxis.axisLabel.formatter = '{value}k';
                angular.forEach($scope.lineallskuinfos.bar, function (data, index, array) {
                    if (data.relationship.Id == rid) {
                        $scope.lineoption.title.text = data.relationship.name;
                        $scope.lineoption.title.subtext = "<?= Yii::t('app','(单位：k/千)');?>";
                        
                        $scope.lineoption.xAxis.data=data.label;
                        // console.log(data)
                        $scope.lineoption.legend.data = [];
                        $scope.lineoption.series = [];
                        console.log(kpi)
                        if(kpi == 'numberOfSalesStores'){
                            let _total = {
                                name:'所有门店数量',
                                type:'line',
                                data: [
                                    data.storenum.length>=6?data.storenum[5]/1000:null,
                                    data.storenum.length>=5?data.storenum[4]/1000:null,
                                    data.storenum.length>=4?data.storenum[3]/1000:null,
                                    data.storenum.length>=3?data.storenum[2]/1000:null,
                                    data.storenum.length>=2?data.storenum[1]/1000:null,
                                    data.storenum.length>=1?data.storenum[0]/1000:null
                                ],
                                itemStyle: {
                                    normal:{
                                        color: '#333',
                                    }
                                }
                            }

                            $scope.lineoption.series.push(_total)
                        }
                        
                        angular.forEach(data.skus, function (subdata, index, array) {
                            let idx = index;
                            if ($scope.skus[subdata[1].sku_id]['checked']) {
                                $scope._showData = $scope.lineoption.series.length>=1?false:true
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
                $scope.lineoption.yAxis.max=Math.ceil(Math.max.apply(null,$scope.newskus)*1000)/10;
                $scope.lineoption.yAxis.min=Math.floor(Math.min(0, Math.min.apply(null,$scope.newskus))*1000)/10;
                $scope.lineoption.tooltip={
                    trigger: 'axis',
                    formatter: '{b}'
                }
                angular.forEach($scope.lineallskuinfos.bar, function (data, index, array) {
                    // console.log(data)
                    if (data.relationship.Id == rid) {
                        $scope.lineoption.title.text = data.relationship.name;
                        $scope.lineoption.title.subtext = '';
                        $scope.lineoption.xAxis.data=data.label;
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
                                $scope._showData = $scope.lineoption.series.length>=1?false:true
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
        //    console.log($scope.skus)
//            console.log($scope.allskuinfos.stackbar.skus)
            $scope.stackbaroption.xAxis[0].data = [];
            $scope.stackbaroption.legend.data = [];
            $scope.stackbaroption.legend.selected = {};
            $scope.stackbaroption.series = [];
        //    console.log($scope.allskuinfos)
            angular.forEach($scope.allskuinfos.stackbar.skus, function (subdata, subindex, array) {
            //    console.log(subdata,subindex)  //数据 名称
                var newseria = [];
                if($scope.skus[subdata[1][1].sku_id]['checked']==1){
                    $scope.stackbaroption.legend.data.push(subindex);
                    $scope.stackbaroption.legend.selected[subindex] = $scope.skus[subdata[1][1].sku_id]['checked'];
                    angular.forEach(subdata, function (subsubdata, ssubindex, array) {
                //    console.log(subsubdata[1])
                        if ($scope.relations[subsubdata[1].relationship_id]['checked']&& $scope.relations[subsubdata[1].relationship_id].show) {
                            if ($scope.stackbaroption.xAxis[0].data.indexOf($scope.allskuinfos.stackbar.relations[subsubdata[1].relationship_id]) == -1){
                                $scope.stackbaroption.xAxis[0].data.push($scope.allskuinfos.stackbar.relations[subsubdata[1].relationship_id]);
                            }
                            // console.log(kpi,subsubdata[1])
                            if (!subsubdata[1][kpi]) {subsubdata[1][kpi]= 0;}
                            subsubdata[1][kpi] = parseInt(subsubdata[1][kpi]);
                            newseria.push({value:subsubdata[1][kpi],name:subindex});
                        }
                    });
                }
                
                $scope.stackbaroption.series.push({name: subindex, 'type': 'bar',itemStyle: {
                    normal:{
                        color: subdata[1][0].color
                    },
                }, stack: 'total',barWidth : 120,'data': newseria});
               
            });
            // console.log($scope.stackbaroption)
            // console.log($scope.stackbaroption.series[$scope.stackbaroption.series.length-1].data.length)
            for(let j=0;j<$scope.stackbaroption.series.length;j++){
                if($scope.stackbaroption.series[j].data&&$scope.stackbaroption.series[j].data.length>0){
                    $scope.myObj = {
                        "width": $scope.stackbaroption.series[j].data.length*130 + 300
                    }
                    break
                }
            }
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
                                    return '总和: '+stackTotal[j]
                                }
                            }
                        }
                    // }
                }
            }
            return $scope.stackbaroption;
        };
        

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
            tooltip: {
                trigger:'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                },
                formatter: '{b}:\n{c}%',
            },
            grid: {
                top: 80,
                left: 80,
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
        //
        //折线图配置项
        $scope.lineoption = {
            title: {
                text: '',
                subtext: ''
            },
            tooltip: {
                trigger: 'axis',
            },
            legend: {
                itemWidth: 10,
                itemHeight: 10,
                left: 120,
                icon: 'circle',
                data: ['', '']
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                axisLabel: {
                    formatter: '{value}'
                },
                data: ['2017-03', '2017-04', '2017-05', '2017-06', '2017-07', '2017-08']
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    formatter: '{value}%'
                },
                splitLine: {show:true},
            },
            series: [

            ]
        };
        //
        $scope.ko_orders = {
            color: ['#F40008', '#FBF5E2'],
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
                    barWidth:30,
                    hoverAnimation:false,
                    animationDurationUpdate: 1000
                }
            ]
        };
        $scope.pci_orders = {
            color: ['#CCCCCC', '#F0F7FC'],
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
        $scope.ko_totalorders = {
            color: ['#F40008', '#FBF5E2'],
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
        $scope.pci_totalorders = {
            color: ['#CCCCCC', '#F0F7FC'],
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
        $scope.ko_visirate = {
            color: ['#F40008', '#FBF5E2'],
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
                    barWidth :30,
                    hoverAnimation:false,
                    animationDurationUpdate: 1000
                }
            ]
        };
        $scope.pci_visirate = {
            color: ['#CCCCCC', '#F0F7FC'],
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
            $('body').addClass('body-active');
            $('#edit-name').val($('#Search_month').val()+'-'+$scope.selcity+$scope.selbrand+$scope.modetype);
        }
        $scope.nzk=false;  //是否显示总括
        $scope.zk = function(){
            $scope.nzk=false
        }
        
        //
        angular.forEach($scope.skus, function (data, index, array) {
            if(data.depth=="1")$scope.skus[index]['checked'] = 1;
        });
    });
</script>

<div ng-app="cockdash" style="padding: 0 15px;">
    <div class="pdftips">
        <div>正在生成文件，大概需要2-3分钟...</div><br>
        <p>当前进度 <span id="progress"></span></p>  
    </div>
    <div class="export-pdf">    
                                                
        <div class="left-view export-public">
            <div class="radius" style="width: 300px;">
                <span><?= Yii::t('app','1');?></span>
                <div><?= Yii::t('app','地图');?></div>
            </div>
            <div class="radius" style="width:170px;">
                <span><?= Yii::t('app','2');?></span>
                <div><?= Yii::t('app','关键指标仪表盘');?></div>
            </div>
            <div class="radius" style="width:480px;">  
                <span><?= Yii::t('app','3');?></span>
                <div><?= Yii::t('app','趋势分析');?></div>
            </div>
        </div>
        <div class="right-select export-public">
            <img class="close" src="<?php echo Yii::app()->baseUrl.'/images/close.png'; ?>" alt="">
            <form class="layui-form" action=""></form>
            <ul class="export-select-list">
                <li>
                    <p><?= Yii::t('app','命名');?>:</p>
                    <label><input id="edit-name" type="text" class="form-control" placeholder="月份-地区-品类品牌" ></label>
                </li>
                <li>
                    <p><?= Yii::t('app','1');?>,<?= Yii::t('app','地图');?></p>
                    <div>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="aap3" checked="checked"><?= Yii::t('app','上线率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="aap4" checked="checked"><?= Yii::t('app','点购率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="aap2" checked="checked"><?= Yii::t('app','配售率');?>
                        </label>
                    </div>
                </li>
                <li>
                    <p><?= Yii::t('app','2');?>,<?= Yii::t('app','关键指标仪表盘');?></p>
                    <div>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap1" checked="checked"><?= Yii::t('app','概括');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap3" checked="checked"><?= Yii::t('app','上线率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap4" checked="checked"><?= Yii::t('app','点购率');?>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="bap2" checked="checked"><?= Yii::t('app','配售率');?>
                        </label>
                        </label>
                    </div>
                </li>
                <li>
                    <p><?= Yii::t('app','3');?>,<?= Yii::t('app','趋势分析');?></p>
                    <div class="kjl-arr">
                        <span><?= Yii::t('app','门店数量');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp4-dp1"><?= Yii::t('app','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp4-dp2"><?= Yii::t('app','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp4-dp3"><?= Yii::t('app','趋势');?>
                        </label>
                    </div>
                    <div class="kjl-arr">
                        <span><?= Yii::t('app','上线率');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp3-dp1"><?= Yii::t('app','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp3-dp2"><?= Yii::t('app','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp3-dp3"><?= Yii::t('app','趋势');?>
                        </label>
                    </div>
                    <div class="dgl-arr">
                        <span><?= Yii::t('app','点购率');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp5-dp1"><?= Yii::t('app','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp5-dp2"><?= Yii::t('app','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp5-dp3"><?= Yii::t('app','趋势');?>
                        </label>
                    </div>
                    <div class="psl-arr">
                        <span><?= Yii::t('app','配售率');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp1-dp1"><?= Yii::t('app','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp1-dp2"><?= Yii::t('app','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp1-dp3"><?= Yii::t('app','趋势');?>
                        </label>
                    </div>
                    <div class="psl-arr">
                        <span><?= Yii::t('app','订单数量');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp2-dp1"><?= Yii::t('app','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp2-dp2"><?= Yii::t('app','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp2-dp3"><?= Yii::t('app','趋势');?>
                        </label>
                    </div>
                    <div class="dgl-arr">
                        <span><?= Yii::t('app','店均点购订单数量');?>:</span>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp6-dp1"><?= Yii::t('app','本期值');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp6-dp2"><?= Yii::t('app','变化率');?>
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="cp6-dp3"><?= Yii::t('app','趋势');?>
                        </label>
                    </div>
                </li>
            </ul>
            <button id="pdf-submit" type="button" class="btn btn-primary"><?= Yii::t('app','提交');?></button>
        </div>
    </div>
    <div class="container-fluid" style="padding: 15px 15px 10px;" ng-controller="optionchg" data-ng-init="onoptionchange()">

        <div id="vitab" ng-bind="visiname" style="width:0;height: 0;overflow:hidden;"></div>
        <nav class="navbar navbar-default navbar-fixed-top">
            <?php $this->renderPartial("header", array("searchmodel" => $searchmodel)) ?>
        </nav>

        <!--主体部分-->
        <div id="body" class="row">
            <div class="col-md-8 map-col" id="map-view" style="position: relative;width: 66.6%;">
                <div class="right-bottom-export js-rb-export" title="导出该模块" t="map" ng-bind="month"></div>
                <div class="map-men map-men1">
                    <?= BSHtml::image(Yii::app()->baseUrl.'/images/temp_08091512529506.gif'); ?>
                </div>
                <div class="map-wrap">
                    <div id="container"></div>
                    <div class="legend">
                        <div ng-if="visitab == 'totalorders' || visitab == 'placingTotalOrderNumber'">KO <?= Yii::t('app','配售率'); ?></div>
                        <div ng-if="visitab == 'visirate' || visitab == 'numberOfSalesStores'">KO <?= Yii::t('app','上线率'); ?></div>
                        <div ng-if="visitab == 'orders' || visitab == 'opo'">KO <?= Yii::t('app','点购率'); ?></div>
                        <div ng-repeat="ko in koinfos" ng-if="ko[0] == 1">
                            <pre class="{{ko[4]==1?'zhuhai':(ko[4]==2?'taiGu':'inMay')}}"></pre>
                            {{ko[7]}}
                            <span ng-if="ko[mapindex] > 0"><?= BSHtml::image(Yii::app()->baseUrl.'/images/up.png'); ?></span>
                            <span ng-if="ko[mapindex] < 0"><?= BSHtml::image(Yii::app()->baseUrl.'/images/down.png'); ?></span>
                            <span ng-if="ko[mapindex] == null" class="change"><?= Yii::t('app','无数据'); ?></span>

                        </div>
                    </div>

                </div>


                
            </div>

            <!--主体部分右侧内容-->
            <div class="col-md-4" style="margin-bottom: 10px;background-color: transparent;padding-right:0;width: 33.3%;">

                <!--饼图部分-->
                <div class="row radius10" id="data-view">
                    <div class="right-bottom-export js-rb-export" title="导出该模块" t="data" ng-bind="month"></div>
                    <div class="map-men map-men2">
                        <?= BSHtml::image(Yii::app()->baseUrl.'/images/temp_08091512529506.gif'); ?>
                    </div>
                    <?php
                    $tabs = array(
                        array("label" => Yii::t('app','概况'), 'id'=>'ap1','con'=>"概况",'otype' => 'blanket', 'url' => "javascript:void(0)", "class" => "blanket","ng-click"=>"zk()","ng-class"=>"nzk?'':'active'"),
                        array("label" => Yii::t('app','上线率'),'id'=>'ap3','con'=>"上线率",'ng-click' => "tabchange('visirate')", 'otype' => 'visirate', 'url' => "javascript:void(0)", "class" => "change-map","ng-class"=>"(nzk&&(visitab == 'visirate' || visitab == 'numberOfSalesStores'))?'active':''"),
                        array("label" => Yii::t('app','配售率'),'id'=>'ap2','con'=>"配售率",'ng-click' => "tabchange('totalorders')", 'otype' => 'totalorders', 'url' => "javascript:void(0)", "class" => "change-map","ng-class"=>"(nzk&&(visitab == 'totalorders' || visitab == 'placingTotalOrderNumber'))?'active':''"),
                        array("label" => Yii::t('app','点购率'),'id'=>'ap4', 'con'=>"点购率",'ng-click' => "tabchange('orders')", 'otype' => 'orders', 'url' => "javascript:void(0)", "class" => "change-map","ng-class"=>"(nzk&&(visitab == 'orders' || visitab == 'opo'))?'active':''"),
                        array("label" => Yii::t('app','趋势比较分析').">", 'url' => "javascript:void(0)", "class" => "pull-right right-more", "id"=>"rate-more"),
                    );
                    echo BSHtml::nav("pills", $tabs);
                    ?>
                    <div id="zongkuo">
                        <div class="row graphica1">
                            <p><?= Yii::t('app','上线率');?> (<b ng-bind="showCon"></b>)</p>
                            <div class="row center">
                                <div style="width:50%;float:left;" class="col-md-6 bs"><?= Yii::t('app','{{pieLeft}}')?></div>
                                <div style="width:50%;display:inline-block;" class="col-md-6 bs"><?= Yii::t('app','{{pieRight}}'); ?></div>
                            </div>
                            <div class="row graphical2">
                                <?php
                                $this->renderpartial("_piechart", array(
                                    'kpiname' => "ko_visirate",
                                    'kpi' => 'kopciinfos.koandpcis[pieLeftId].availability',
                                    'kpirate' => 'kopciinfos.koandpcis[pieLeftId].Preceding_availability',
                                ));
                                $this->renderpartial("_piechart", array(
                                    'kpiname' => "pci_visirate",
                                    'kpi' => 'kopciinfos.koandpcis[pieRightId].availability',
                                    'kpirate' => 'kopciinfos.koandpcis[pieRightId].Preceding_availability',
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="row graphica1">
                            <p><?= Yii::t('app','配售率');?> </p>
                            <div class="row graphical2">
                                <?php
                                $this->renderpartial("_piechart", array(
                                    'kpiname' => "ko_orders",
                                    'kpi' => 'kopciinfos.koandpcis[pieLeftId].Incidence',
                                    'kpirate' => 'kopciinfos.koandpcis[pieLeftId].Preceding_Incidence',
                                ));
                                $this->renderpartial("_piechart", array(
                                    'kpiname' => "pci_orders",
                                    'kpi' => 'kopciinfos.koandpcis[pieRightId].Incidence',
                                    'kpirate' => 'kopciinfos.koandpcis[pieRightId].Preceding_Incidence',
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="row graphica1">
                            <p><?=Yii::t('app','点购率');?></p>
                            <div class="row graphical2">
                                <?php
                                $this->renderpartial("_piechart", array(
                                    'kpiname' => "ko_totalorders",
                                    'kpi' => 'kopciinfos.koandpcis[pieLeftId].attach_rate',
                                    'kpirate' => 'kopciinfos.koandpcis[pieLeftId].Preceding_Attach_Rate',
                                ));
                                $this->renderpartial("_piechart", array(
                                    'kpiname' => "pci_totalorders",
                                    'kpi' => 'kopciinfos.koandpcis[pieRightId].attach_rate',
                                    'kpirate' => 'kopciinfos.koandpcis[pieRightId].Preceding_Attach_Rate',
                                ));
                                ?>
                            </div>
                        </div>
                    </div>

                    <!--点购率-->
                    <div id="rate-box">
                        <div class="row graphica1">
                            <div class="row graphical2" ng-if="visitab == 'orders' || visitab == 'opo'">
                                <?php
                                $this->renderpartial("_piechart", array(
                                    'kpiname' => "ko_orders",
                                    'kpi' => 'kopciinfos.koandpcis[pieLeftId].Incidence',
                                    'kpirate' => 'kopciinfos.koandpcis[pieLeftId].Preceding_Incidence',
                                ));
                                $this->renderpartial("_piechart", array(
                                    'kpiname' => "pci_orders",
                                    'kpi' => 'kopciinfos.koandpcis[pieRightId].Incidence',
                                    'kpirate' => 'kopciinfos.koandpcis[pieRightId].Preceding_Incidence',
                                ));
                                ?>
                            </div>

                            <div class="row graphical2" ng-if="visitab == 'visirate' || visitab == 'numberOfSalesStores'">
                                <?php
                                $this->renderpartial("_piechart", array(
                                    'kpiname' => "ko_visirate",
                                    'kpi' => 'kopciinfos.koandpcis[pieLeftId].availability',
                                    'kpirate' => 'kopciinfos.koandpcis[pieLeftId].Preceding_availability',
                                ));
                                $this->renderpartial("_piechart", array(
                                    'kpiname' => "pci_visirate",
                                    'kpi' => 'kopciinfos.koandpcis[pieRightId].availability',
                                    'kpirate' => 'kopciinfos.koandpcis[pieRightId].Preceding_availability',
                                ));
                                ?>

                            </div>

                            <div class="row graphical2"
                                 ng-if="visitab == 'totalorders' || visitab == 'placingTotalOrderNumber'">
                                <?php
                                $this->renderpartial("_piechart", array(
                                    'kpiname' => "ko_totalorders",
                                    'kpi' => 'kopciinfos.koandpcis[pieLeftId].attach_rate',
                                    'kpirate' => 'kopciinfos.koandpcis[pieLeftId].Preceding_Attach_Rate',
                                ));
                                $this->renderpartial("_piechart", array(
                                    'kpiname' => "pci_totalorders",
                                    'kpi' => 'kopciinfos.koandpcis[pieRightId].attach_rate',
                                    'kpirate' => 'kopciinfos.koandpcis[pieRightId].Preceding_Attach_Rate',
                                ));
                                ?>


                            </div>

                            <div class="row center">
                                <div style="width:50%;float:left;" class="col-md-6 bs"><?= Yii::t('app','{{pieLeft}}')?></div>
                                <div style="width:50%;display:inline-block;" class="col-md-6 bs"><?= Yii::t('app','{{pieRight}}'); ?></div>
                            </div>

                        </div>

                        <!--点购率-->
                        <div class="row">
                            <div class="row">
                                <div class="number"
                                     ng-if="visitab == 'totalorders' || visitab == 'placingTotalOrderNumber'">
                                <span
                                    ng-bind="month[0] + month[1] + month[2] + month[3] + '<?= Yii::t('app','年'); ?>' + month[5] + month[6]"></span> <b ng-bind="showCon"></b> <?= Yii::t('app','配售订单数量');?>
                                </div>
                                <div class="number" ng-if="visitab == 'visirate' || visitab == 'numberOfSalesStores'">
                                <span
                                    ng-bind="month[0] + month[1] + month[2] + month[3] + '<?= Yii::t('app','年'); ?>' + month[5] + month[6]"></span> <b ng-bind="showCon"></b> <?= Yii::t('app','可见门店数量');?>
                                </div>
                                <div class="number" ng-if="visitab == 'orders' || visitab == 'opo'">
                                <span
                                    ng-bind="month[0] + month[1] + month[2] + month[3] + '<?= Yii::t('app','年'); ?>' + month[5] + month[6]"></span> <b ng-bind="showCon"></b> <?= Yii::t('app','外卖平台店均点购订单数量');?>
                                </div>
                                <div class="order-number-more" id="order-more" style="float: right">
                                <?= Yii::t('app','趋势比较分析')?>>
                                </div>
                            </div>
                            <div class="row" style="height: 306px;overflow: hidden;">
                                <?php
                                $this->renderpartial("_kpiitem", array(
                                    'visitab' => "visitab == 'orders'  || visitab == 'opo'",
                                    'vname' => "0",
                                    'kpiname' => Yii::t('app','平均每家店的总订单量（所有门店）'),
                                    'kpi' => array(
                                        'value' => "orders.order.So_ko_order",
                                        'lastvalue' => "orders.lastorder.So_ko_order",
                                        'changerate' => "orders.order.Preceding_So_ko_order_ratio",
                                    )
                                ));

                                $this->renderpartial("_kpiitem", array(
                                    'visitab' => "visitab == 'orders'  || visitab == 'opo'",
                                    'vname' => "1",
                                    'kpiname' => Yii::t('app','平均每家门店的软饮料订单量（售卖软饮料的门店）'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[123].opo",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[123].opo",
                                        'changerate' => "kopciinfos.koandpcis[123].Preceding_opo",
                                    )
                                ));

                                $this->renderpartial("_kpiitem", array(
                                    'visitab' => "visitab == 'orders'  || visitab == 'opo'",
                                    'vname' => "0",
                                    'kpiname' => Yii::t('app','平均每家门店的KO汽水订单量（售卖KO汽水的门店）'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[6].opo",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[6].opo",
                                        'changerate' => "kopciinfos.koandpcis[6].Preceding_opo",
                                    )
                                ));

                                $this->renderpartial("_kpiitem", array(
                                    'visitab' => "visitab == 'visirate' || visitab == 'numberOfSalesStores' ",
                                    'vname' => "0",
                                    'kpiname' => Yii::t('app','门店数量（所有门店）'),
                                    'kpi' => array(
                                        'value' => "orders.order.takeoutfood_order",
                                        'lastvalue' => "orders.lastorder.takeoutfood_order",
                                        'changerate' => "orders.order.Preceding_takeoutfood_order_ratio",
                                    )
                                ));

                                $this->renderpartial("_kpiitem", array(
                                    'visitab' => "visitab == 'visirate' || visitab == 'numberOfSalesStores' ",
                                    'vname' => "0",
                                    'kpiname' => Yii::t('app','门店数量（软饮料销售门店）'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[123].numberOfSalesStores",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[123].numberOfSalesStores",
                                        'changerate' => "kopciinfos.koandpcis[123].numberOfSalesStoresRatio",
                                    )
                                ));

                                $this->renderpartial("_kpiitem", array(
                                    'visitab' => "visitab == 'visirate' || visitab == 'numberOfSalesStores' ",
                                    'vname' => "0",
                                    'kpiname' => Yii::t('app','门店数量（KO汽水销售门店）'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[6].numberOfSalesStores",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[6].numberOfSalesStores",
                                        'changerate' => "kopciinfos.koandpcis[6].numberOfSalesStoresRatio",
                                    )
                                ));


                                $this->renderpartial("_kpiitem", array(
                                    'visitab' => "visitab == 'totalorders' || visitab == 'placingTotalOrderNumber' ",
                                    'vname' => "0",
                                    'kpiname' => Yii::t('app','订单数量（所有门店）'),
                                    'kpi' => array(
                                        'value' => "orders.order.So_deinks_order",
                                        'lastvalue' => "orders.lastorder.So_deinks_order",
                                        'changerate' => "orders.order.Preceding_So_deinks_order_ratio",
                                    )
                                ));

                                $this->renderpartial("_kpiitem", array(
                                    'visitab' => "visitab == 'totalorders' || visitab == 'placingTotalOrderNumber' ",
                                    'vname' => "0",
                                    'kpiname' => Yii::t('app','软饮料订单量（所有门店）'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[123].placingTotalOrderNumber",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[123].placingTotalOrderNumber",
                                        'changerate' => "kopciinfos.koandpcis[123].placingTotalOrderNumberRatio",
                                    )
                                ));

                                $this->renderpartial("_kpiitem", array(
                                    'visitab' => "visitab == 'totalorders' || visitab == 'placingTotalOrderNumber' ",
                                    'vname' => "0",
                                    'kpiname' => Yii::t('app','KO汽水订单量（所有门店）'),
                                    'kpi' => array(
                                        'value' => "kopciinfos.koandpcis[6].placingTotalOrderNumber",
                                        'lastvalue' => "kopciinfos.lastkoandpcis[6].placingTotalOrderNumber",
                                        'changerate' => "kopciinfos.koandpcis[6].placingTotalOrderNumberRatio",
                                    )
                                ));
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
        $this->renderpartial("details_js", array());
        ?>


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
    if (<?php echo !empty($searchmodel->region) ? 1 : 0;?>) {
        $('#Search_region').val(<?php echo $searchmodel->region; ?>);
        $('#Search_region').trigger('change');
    }
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
    $('#SSearch_month_table1,#Search_month').datepicker({
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

    $('.blanket').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
        $('#rate-box').hide();
        $('#zongkuo').show();
    })
    $(document).on('click','#rate-more,#order-more',function(){
        $('body,html').stop().animate({
            scrollTop:$('#deepdive').offset().top-140
        },300);
    })

    // $('#deepdive').hover(function(){
    //     $(this).addClass('active')
    // },function(){
    //     $(this).removeClass('active')
    // })

    $(document).on('click','#order-more',function(){
        let oType;
        for (let i = 0; i < $('.radius10 .nav-pills .change-map').length; i++) {
            if ($('.radius10 .nav-pills .change-map').eq(i).hasClass('active')) {
                oType = i;
            }
        }
        switch (oType) {
            case 0:
                $('#deepdive li').eq(2).trigger('click');
                break;
            case 1:
                $('#deepdive li').eq(3).trigger('click');
                break;
            case 2:
                $('#deepdive li').eq(4).trigger('click');
                break;
        }

    })
    $('.weidu-list li>label').click(function(){
        let i = $('.weidu-list li>label').index(this);
        let oLeft = $('.weidu-list li>label').eq(i).position().left;
        $('.weidu-list li .weidu-item-box').css('left',oLeft-30);
        $(this).parent().find('.weidu-item-box').show();
        $(this).parent().siblings().find('.weidu-item-box').hide()
    })
    $(document).on('click',function(e){
        let target=$(e.target);
        // console.log(target)
        if(!target.is('.weidu-list li') && target.parent() && target.parents('.weidu-list li').length <= 0){
            $('.weidu-item-box').hide();
        }
    })


    $('.chosen-select').chosen();
    $('.filter-city').change(function () {
        $('#cityid').attr('value', $(this).attr('id'));
    });
    //月报处理
    $(document).on('click','#monthly_Reportz,.month',function () {
        if(!$("#SSearch_month_table1").val() || $("#SSearch_month_table1").val().length<=0){
            $("#SSearch_month_table1").val($("#Search_month").val());
        }
        var cont = {'sj': $('#SSearch_month_table1').val(),'YII_CSRF_TOKEN':"<?=yii::app()->request->csrfToken;?>"};
//            console.log(cont)
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('site/doucument') ?>',
            dataType: 'json',
            data: cont,
            success: function (data) {
                $('#showtable').html('');
                var showtable = ' ';
                //console.log(data.status)
                if(data.status==1){
                    var submiturl="<?php echo Yii::app()->createUrl('site/uploadzip',array('id'=>'sid'))?>";
                    for (var i = 0; i < data.info.length; i++) {
                        showtable += '<tr><td>' + data.info[i].city + '</td><td><span><a target="_blank" href="' + submiturl.replace('sid',data.info[i].Id) + '"><?= Yii::t('app','下载')?></a></span></td></tr>'
                    }
                    if(data.info.length=0){
                        showtable = "<center><p style=\"color:red\"><?= Yii::t('app','该月还没有上传数据')?></p></center>";
                    }
                }else{
                    showtable = "<center><p style=\"color:red\"><?= Yii::t('app','该月还没有上传数据')?></p></center>";
                }
//                    console.log(showtable)
                $("#showtable").html(showtable);
            },
            error: function (retMsg) {
                $('#showtable').html();
                $('#showtable').html("<center><p style=\"color:red\"><?= Yii::t('app','你没有权限')?></p></center>");
            }
        });
    });
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
    var iDecode;  //用于小地图中显示区域
    var iArea;  //用于小地图中显示区域
    var timerm1 = null;
    var timerm2 = null;
    var koinfos =<?php echo json_encode($koinfos); ?>;
    console.log('koinfos',koinfos)
    var specificArea = <?php echo json_encode($koinfoss); ?>;
    console.log(specificArea)
    var latlng = ['107.764827,36.104582','117.720126,30.896448','120.554599,31.422918','112.02872,23.557816','116.02872,23.557816','109.897861,37.608898']
    for(let i=0;i<specificArea.length;i++){
        specificArea[i].splice(2,0,latlng[i])
    }
    console.log(specificArea)
    var zoom = 5;
    var oTypes = 'totalorders';
    //划分区域
    var zhongke = [110000, 620000, 640000, 500000, 650000, 630000, 540000, 130000, 430000, 520000, 210000, 230000, 220000, 150000, 370000,140000, 610000, 510000, 120000],
        taigu = [340000, 350000, 450000, 460000, 410000, 420000, 320000, 360000,330000, 530000,310000],
        zhuhai = [];
    var cityList = [110000, 620000, 640000, 500000, 650000, 630000, 540000, 130000, 430000, 520000, 210000, 230000, 220000, 150000, 370000,140000, 610000, 510000, 120000,340000, 350000, 450000, 460000, 410000, 420000, 320000, 360000,330000, 530000,310000];
    var colors = ["#e82d34","#f49e00",  "#ffcc00"];
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
    //        反向镂空区域 -- start
        function getAllRings(feature) {

            var coords = feature.geometry.coordinates,
                rings = [];
            for (var i = 0, len = coords.length; i < len; i++) {
                rings.push(coords[i][0]);
            }

            return rings;
        }

        function getLongestRing(feature) {
            var rings = getAllRings(feature);
            rings.sort(function (a, b) {
                return b.length - a.length;
            });
            return rings[0];
        }

        function initPage(DistrictExplorer) {
            //创建一个实例
            var districtExplorer = new DistrictExplorer({
                map: map
            });
            var countryCode = 440000,
                cityCodes = [
                    440400
                ];
            districtExplorer.loadMultiAreaNodes(
                //只需加载全国和市，全国的节点包含省级
                [countryCode].concat(cityCodes),
                function (error, areaNodes) {

                    var countryNode = areaNodes[0],
                        cityNodes = areaNodes.slice(1);
                    var path = [];
                    //首先放置背景区域，这里是大陆的边界
                    path.push(getLongestRing(countryNode.getParentFeature()));
                    for (var i = 0, len = cityNodes.length; i < len; i++) {
                        //逐个放置需要镂空的市级区域
                        path.push.apply(path, getAllRings(cityNodes[i].getParentFeature()));
                    }

                    //绘制带环多边形
                    //http://lbs.amap.com/api/javascript-api/reference/overlay#Polygon
                    var polygon = new AMap.Polygon({
                        bubble: true,
                        lineJoin: 'round',
                        strokeColor: '#fff', //线颜色
                        strokeOpacity: 0, //线透明度
                        strokeWeight: 0, //线宽
                        fillColor: '#e82d34', //填充色
                        fillOpacity: 0.9, //填充透明度
                        map: map,
                        path: path
                    });
                }
            );

        }

    //        反向镂空区域 -- end

        AMapUI.load(['ui/geo/DistrictExplorer', 'lib/$'], function (DistrictExplorer, $) {
            initPage(DistrictExplorer);
    //            加载珠海区域 -- start
            function renderAreaNode_b(areaNode) {

                //绘制子区域
                districtExplorer.renderSubFeatures(areaNode, function (feature, i) {

                    var fillColor = colors[2];
                    var strokeColor = '#fff';
                    return {
                        cursor: 'default',
                        bubble: true,
                        strokeColor: strokeColor, //线颜色
                        strokeOpacity: 1, //线透明度
                        strokeWeight: 1, //线宽
                        fillColor: fillColor, //填充色
                        fillOpacity: 0.9, //填充透明度
                    };
                });
                //绘制父区域
                districtExplorer.renderParentFeature(areaNode, {
                    cursor: 'default',
                    bubble: true,
                    strokeColor: '#fff', //线颜色
                    strokeOpacity: 1, //线透明度
                    strokeWeight: 2, //线宽
                    fillColor: null, //填充色
                    fillOpacity: 0.9, //填充透明度
                });
            }

            //创建一个实例
            var districtExplorer = new DistrictExplorer({
                map: map
            });
            districtExplorer.loadMultiAreaNodes([440400], function (error, areaNodes) {
                for (var i = 0, len = areaNodes.length; i < len; i++) {
                    renderAreaNode_b(areaNodes[i]);
                }
            });
        })

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
            let o_idx = 4;   //显示哪一个数据
            switch (oTypes) {
                case 'totalorders':
                    o_idx = 4;
                    break;
                case 'visirate':
                    o_idx = 6;
                    break;
                case 'orders':
                    o_idx = 7;
                    break;
            }
            if (specificArea[i][o_idx]) {
                urls = parseFloat(specificArea[i][o_idx]) > 0 ? "<?php echo Yii::app()->baseUrl . '/images/up.png' ?>" : "<?php echo Yii::app()->baseUrl . '/images/down.png' ?>";
            }
            marker.setLabel({//label默认蓝框白底左上角显示，样式className为：amap-marker-label
                offset: new AMap.Pixel(6, 20), //修改label相对于maker的位置
                content: "<div v='" + specificArea[i][5] + "' area="+specificArea[i][1]+"' class='" + leval + " clearfix'><span>" + specificArea[i][8] + "</span>" + "<img src='" + urls + "' /></div>"
            });
            marker.setMap(map);
        }

        for (var i = 0; i < koinfos.length; i++) {

            if (!containss(koinfos[i][1], specificArea)) {
    //                console.log(koinfos[i][1])
                addBeiJing(koinfos[i][0], koinfos[i][1], koinfos[i][2], koinfos[i][3], koinfos[i][4], koinfos[i][5], koinfos[i][6],koinfos[i][7]);
            }
        }


        function addBeiJing(leval, area, peishou, zengzhang, v, kejian, diangou,showarea) {
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
                    console.log(area,result);
                    if(result.districtList){
                        for(let i=0;i<result.districtList.length;i++){
                            if(result.districtList[i].level!=='district'){
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
                            case 'totalorders':
                                s_con = zengzhang;
                                break;
                            case 'visirate':
                                s_con = kejian;
                                break;
                            case 'orders':
                                s_con = diangou;
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
                // $('.amap-marker').css({
                //     opacity: 1,
                //     filter: 'Alpha(Opacity=100)'
                // })
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
                console.log(result)
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
            let i = $(this).index('.legend .ng-binding');
    //            console.log(i);
            switch (i){
                case 0:  //太古
                    $(".map-control").eq(0).val(2);
                    $(".map-control").eq(0).trigger("change");
                    map.setZoomAndCenter(5, specificArea[2][2].split(','));
                    break;
                case 1:  //中可
                    $(".map-control").eq(0).val(3);
                    $(".map-control").eq(0).trigger("change");
                    map.setZoomAndCenter(5, specificArea[1][2].split(','));
                    break;
                case 2:  //珠海
                    $(".map-control").eq(0).val(1);
                    $(".map-control").eq(0).trigger("change");
                    map.setZoomAndCenter(6, [113.576221,22.269047]);
                    break;

            }
        })
        $(document).on('click', '.amap-marker-label', function (e) {
            var clickValue = $(this).find('div span').html();
            var clickId = $(this).find('div').attr('v');
            console.log(clickId,clickValue)
            if(containss(clickValue,specificArea)){
                map.setZoomAndCenter(7, specificArea[containss(clickValue,specificArea)][2].split(','));
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
                console.log('3')
                $("#Search_region").val('4');
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
                        console.log(result.geocodes[0].adcode);
                        iDecode = [result.geocodes[0].adcode];
                        console.log('<?php echo Yii::app()->baseUrl . '/js/sales_map.js' ?>')
                         //创建地图
                        var smap = new AMap.Map('map-box-item', {
                            cursor: 'default',
                            zoom: 8
                        });
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
                $("#Search_region").val('4');
                $("#Search_region").trigger("change");
                $("#Search_city").val(clickId);
                $("#Search_city").trigger("change");
            }
        })
        $(document).on('mouseenter', '.amap-marker', function (e) {
            $(this).css('z-index', 999).siblings().css('z-index', 10);
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
        $('#rate-box').show();
        $('#zongkuo').hide();
        oTypes = $(this).attr('o_type');
        $('.blanket').removeClass('active');
        $('<div id="container"></div>').appendTo('.map-wrap');
        clearTimeout(timerm1);
        clearTimeout(timerm2);
    //        console.log(oTypes)
        init();
    })
    
    
        


    function containss(s, m) {
        for (let i = 0; i < m.length; i++) {
            if (s == m[i][1]) {
                return i
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
<script src="https://cdn.bootcss.com/jquery.form/4.2.2/jquery.form.min.js"></script>
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
        // if($('.chart-box ng-echarts').length>10){
        //     layer.tips('最多选择10个装瓶厂或城市!', '#pdf-submit', {
        //         tips: [1, '#3595CC'],
        //         time: 3500
        //     });
        //     return false
        // }
        $('.js-rb-export').hide();
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
        exportFiles(checkedList,0);
    })


    function exportFiles(arr,i){
        
        var trigger_info = triggerInfo(arr[i]);
        console.log(trigger_info)
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
                            console.log(123414)
                            clearInterval(timerm4);
                            method1(eName,_part);
                        }
                    },100)
                }else{
                    method1(eName,_part);
                    
                }
                
            },trigger_info.loadingtime)
        }else{
            var eName = $('#Search_month').val()+'_'+_part+$('#'+trigger_info.trigger_item[0]).attr('con');
            $('#'+trigger_info.trigger_item[0]).trigger('click');
            method1(eName,_part);

        }
        function method1(eName,_part){
            clearTimeout(timerm3);
            timerm3 = setTimeout(function(){
                $('.chart-box').height('auto');
                html2canvas($(trigger_info.export_part), {
                    background:'#fff',
                    onrendered: function(canvas) {
                        var url = canvas.toDataURL();
                        $("<textarea name='"+eName+"'>"+url+"</textarea>").appendTo("#imgs-form");
                        if(i>=arr.length-1){
                            $('nav').show();
                            $("<input name='"+_part+"'></input>").appendTo("#imgs-form");
                            $('#imgs-form').submit();
                            $('.pdftips').removeClass('active');
                            $('.chart-box').height('480px');
                            $('body').removeClass('body-active');
                            $('.js-rb-export').show();
                        }else{
                            i++;
                            $('#progress').html(i+1+'/'+arr.length);
                            exportFiles(arr,i);
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
            loadingtime = 4600;
        }else if(new RegExp('bap').test(el)){  //仪表盘
            trigger_item = [el.substr(1)]
            export_part = '#data-view';
            loadingtime = 1500;
        }else if(new RegExp('cp').test(el)){  //图表
            trigger_item = el.split('-');
            export_part = '#chart-view';
            loadingtime = 1200;
        }
        return {
            'trigger_item':trigger_item,
            'export_part':export_part,
            'loadingtime':loadingtime
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
                    method2(eName);
                }
                
            },100)
        }else{
            method2(eName)
        }
        function method2(eName){
            clearTimeout(timerm3);
            timerm3 = setTimeout(function(){
                $('.chart-box').height('auto');
                html2canvas($(el), {
                    background:'#fff',
                    onrendered: function(canvas) {
                        var url = canvas.toDataURL();
                        console.log(url.length)
                        $("<textarea name='"+eName+"'>"+url+"</textarea>").appendTo("#imgs-form");
                        i++;
                        if(i<arr.length){
                            exSingle(el,arr,i,time,n,m);
                        }else{
                            console.log($('#imgs-form').find('input').length)
                            $("<input name='"+n+"'></input>").appendTo("#imgs-form");
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
                var _name = $('#Search_month').val()  + '_地图_';
                console.log(_name);
                exSingle('#map-view',arrList,0,0,_name,$('#vitab').html())
                break;
            case 'data':
                var arrList = ['#ap1','#ap2','#ap3','#ap4']
                var _name = $('#Search_month').val() +'_仪表盘_';
                exSingle('#data-view',arrList,0,1200,_name);
                break;
            default:
                var arrList = ['#dp1','#dp2','#dp3']
                var _name = $('#Search_month').val()  + '_图表_';
                exSingle('#chart-view',arrList,0,600,_name);
        }
    })
    
})
</script>


