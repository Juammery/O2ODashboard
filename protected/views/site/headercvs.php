<?php
//装瓶集团
$group = CHtml::listData(Relationship::model()->findAll(array("condition" => 'parent=0 or parent=4', "order" => "Id desc")), 'Id', 'name');
$factory = CHtml::listData(Relationship::model()->findAll("depth=2"), 'Id', 'name');
$city = CHtml::listData(Relationship::model()->findAll("depth=3"), 'Id', 'name');
$category = CHtml::listData(SkuCvs::model()->findAll('depth=1'), 'Id', 'name');
$brand = CHtml::listData(SkuCvs::model()->findAll('depth=2'), 'Id', 'name');
function randFloat($min = 0, $max = 1)
{
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}
?>
<style>
    .layui-layer-setwin .layui-layer-close2{
        right:-3px;
        top:-7px;
    }
    .down-jiantou{
        position: absolute;
        right: 20px;
        top: 1px;
        width: 16px;
        height:16px;
        background: url("<?php echo Yii::app()->baseUrl.'/css/chosen-sprite.png';?>") 0 2px no-repeat;
    }
    .changeRed{
        color: red;
    }
</style>
<div class="container-fluid">
    <div class="navbar-header">

        <div class="logo" title="首页">
            <img src="<?php echo Yii::app()->baseUrl?>/images/cvslogo.png">
            <span><?= Yii::t('cvs','可口可乐便利店核查Dashboard'); ?></span>
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

            <li style="display: none">
                <div class="search input-group col-md-3">
                    <input type="text" class="form-control" placeholder="搜索"/>
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-search">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </li>
            <li>
                <span>
                    <a href="<?php echo Yii::app()->createUrl('site/market');?>">
                        <?php
                            if (Yii::app()->language == 'zh_cn') {
                                echo CHtml::image(Yii::app()->baseUrl."/images/rank.png");
                            }elseif(Yii::app()->language == 'es'){
                                echo CHtml::image(Yii::app()->baseUrl."/images/e_rank.png");
                            }
                        ?>
<!--                        <img src="--><?php //echo Yii::app()->baseUrl?><!--/images/rank.png" alt="">-->
                    </a>
                </span>
            </li>
            <li><span><a href="<?php echo Yii::app()->createUrl('site/store'); ?>">基本详情页</a></span></li>
            <li>
                <span>
                    <?php
                    if (Yii::app()->language == 'zh_cn') {
                        echo CHtml::link('中', array('Site/ChangeLanguage', 'language' => 'zh_cn'), array('class' => 'changeRed','title'=>'切换为中文'));
                        ?>
                        <i class="glyphicon glyphicon-resize-horizontal"></i>
                        <?php
                        echo CHtml::link('En', array('Site/ChangeLanguage', 'language' => 'es'), array('title'=>Yii::t('cvs','切换为英文')));
                    }elseif(Yii::app()->language == 'es'){
                        echo CHtml::link('中', array('Site/ChangeLanguage', 'language' => 'zh_cn'),array('title'=>'切换为中文'));
                        ?>
                        <i class="glyphicon glyphicon-resize-horizontal"></i>
                        <?php
                        echo CHtml::link('En', array('Site/ChangeLanguage', 'language' => 'es'), array('class' => 'changeRed','title'=>Yii::t('cvs','切换为英文')));
                    }
                    ?>
                </span>

            </li>


            <li>
                <div class="dropdown">
                    <span data-toggle="dropdown" title="下载月报或者期报">
                        <?= Yii::t('cvs','下载'); ?>
                        <i class="caret"></i>
                    </span>
                    <ul class="dropdown-menu">
                        <!--                        <li id="monthly_Reportz"><a href="#">月报</a></li>-->
                        <li id="monthly_Reportz" data-toggle="modal" data-target="#myModal"><a href="#"><?= Yii::t('cvs','报告'); ?></a></li>
                        <!--                        <li><a href="#">--><?//= Yii::t('cvs','报表'); ?><!--</a></li>-->
                    </ul>
                </div>
            </li>

<!--            <li>-->
<!--                <span title="有疑问？点这里!">--><?//= Yii::t('cvs','帮助'); ?><!--</span>-->
<!--            </li>-->

            <li>
                <div class="user dropdown">
                    <span data-toggle="dropdown">
                        <?php echo BSHtml::image(Yii::app()->baseUrl."/images/person.png"); ?>
                        GUEST
                        <i class="caret"></i>
                    </span>
                    <ul class="dropdown-menu">
<!--                        <li><a href="#">--><?//= Yii::t('cvs','部门属性'); ?><!--</a></li>-->
<!--                        <li><a href="#">--><?//= Yii::t('cvs','密码修改'); ?><!--</a></li>-->
                        <li><a href="<?php echo Yii::app()->createUrl('site/logout');?>"><?= Yii::t('cvs','退出登录'); ?></a></li>
                    </ul>
                </div>
            </li>

        </ul>

    </div>

</div>
<div class="main-content">

    <div class="main" >
<!--        <div class="main-top1 cvs_top" style="height: 62px;">-->
<!--            <p class="china-index {{ytd?'':'active'}}" ng-click="ytdChange(0)">--><?//= Yii::t('cvs','全国指标')?><!--</p>-->
<!--            <p class="china-ytd {{ytd?'active':''}}" ng-click="ytdChange(1)">--><?//= Yii::t('cvs','全国YTD')?><!--</p>-->
<!--        </div>-->
        <div class="top cvs-top">
            <div class="col-md-2">
                <div class="main-top1 col-md-6 ytd-chunk {{ytd?'':'active'}}">
                    <span ng-bind="labels.totalindex"></span><br>
                    <span style="font-size:14px;font-weight: 400;" ng-if="stage > 0">
                        R{{totalfixed[0][1].newStage}}（{{totalfixed[0][1].begin}}-{{totalfixed[0][1].end}}）
                    </span>
                    <p ng-if="stage == -1" style="font-size:14px;font-weight: 400;">R1 - R{{totalfixed[0][1].turnMax}}</p>
                    <p ng-if="stage == 0" style="font-size:14px;font-weight: 400;">{{totalfixed[0][1].month}}</p>
                </div>
                <div class="main-top1 col-md-6 ytd-chunk {{ytd?'active':''}}">
                    <span>全国YTD</span><br>
                    <p style="font-size:14px;font-weight: 400;">R1 - R{{totalfixed[0][1].newStage}}</p>
                </div>
                <div class="main-top1 col-md-6">
<!--                    <select ng-options="item.label as item.value for item in typeData"  ng-model="myselect" ng-change = "getDataType()" class="form-control map-control optionsType">-->
<!--                    </select>-->
                    <select class="form-control map-control optionsType" ng-model="myselect" ng-change="getDataType()" id="myselect">
                        <option value="1">VS PP</option>
                        <option value="0">VS LM</option>
                        <option value="-1">VS LY</option>
                    </select>
                </div>
            </div>
            

            <div class="col-md-10">
                <div class="main-top1 col-md-2">
                    <span><?= Yii::t('cvs','铺货率'); ?></span><br>
                    <span ng-bind="(totalfixed[0][0].distribution * 100| number:2) + '%'"></span>
                    <span ng-if="totalfixed[0][0].Last_distribution_radio > 0">
                        <span ng-bind="(totalfixed[0][0].Last_distribution_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_distribution_radio < 0">
                        <span class="change" ng-bind="(totalfixed[0][0].Last_distribution_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_distribution_radio == 0">
                        <span class="change" ng-bind="(totalfixed[0][0].Last_distribution_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/balance.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_distribution_radio == null">
                        <?= Yii::t('cvs','无数据'); ?>
                    </span>

                </div>
                <div class="main-top1 col-md-2">
                    <span><?= Yii::t('cvs','主题活动执行率'); ?></span><br>
                    <span ng-bind="(totalfixed[0][0].thematic_activity * 100|number:2) + '%'"></span>
                    <span ng-if="totalfixed[0][0].Last_thematic_activity_radio > 0">
                        <span ng-bind="(totalfixed[0][0].Last_thematic_activity_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_thematic_activity_radio < 0">
                        <span class="change" ng-bind="(totalfixed[0][0].Last_thematic_activity_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_thematic_activity_radio == 0">
                        <span class="change" ng-bind="(totalfixed[0][0].Last_thematic_activity_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/balance.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_thematic_activity_radio == null">
                        <?= Yii::t('cvs','无数据'); ?>
                    </span>
                </div>
                <div class="main-top1 col-md-2">
                    <span><?= Yii::t('cvs','KO二次陈列'); ?></span><br>
                    <span ng-bind="(totalfixed[0][0].extra_displays * 100|number:2) + '%'"></span>
                    <span ng-if="totalfixed[0][0].Last_extra_displays_radio > 0">
                        <span ng-bind="(totalfixed[0][0].Last_extra_displays_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_extra_displays_radio < 0">
                        <span class="change" ng-bind="(totalfixed[0][0].Last_extra_displays_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_extra_displays_radio == 0">
                        <span class="change" ng-bind="(totalfixed[0][0].Last_extra_displays_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/balance.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_extra_displays_radio == null">
                        <?= Yii::t('cvs','无数据'); ?>
                    </span>
                </div>
                <div class="main-top1 col-md-2">
                    <span><?= Yii::t('cvs','排面占比'); ?></span><br>
                    <span ng-bind="(totalfixed[0][0].sovi * 100| number:2) + '%' "></span>
                    <span ng-if="totalfixed[0][0].Last_sovi_radio > 0">
                        <span ng-bind="(totalfixed[0][0].Last_sovi_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_sovi_radio < 0">
                        <span class="change" ng-bind="(totalfixed[0][0].Last_sovi_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_sovi_radio == 0">
                        <span class="change" ng-bind="(totalfixed[0][0].Last_sovi_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/balance.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_sovi_radio == null">
                        <?= Yii::t('cvs','无数据'); ?>
                    </span>
                </div>
                <div class="main-top1 col-md-2">
                    <span><?= Yii::t('cvs','设备卖进率'); ?></span><br>
                    <span ng-bind="(totalfixed[0][0].equipment_sales * 100|number:2) + '%'"></span>
                    <span ng-if="totalfixed[0][0].Last_equipment_sales_radio > 0">
                        <span ng-bind="(totalfixed[0][0].Last_equipment_sales_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_equipment_sales_radio < 0">
                        <span class="change" ng-bind="(totalfixed[0][0].Last_equipment_sales_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_equipment_sales_radio == 0">
                        <span class="change" ng-bind="(totalfixed[0][0].Last_equipment_sales_radio * 100|number:2) + '%'"></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/balance.png">
                    </span>
                    <span ng-if="totalfixed[0][0].Last_equipment_sales_radio == null">
                        <?= Yii::t('cvs','无数据'); ?>
                    </span>
                </div>
                <div class="main-top1 col-md-2" style="border-right:none;">
                    <span>{{labels.schedule}}</span><br>
                    <div class="cvs-progress">
                        <div class="now-progress" style="width: {{(totalfixed[0][1].plan) * 100 |number:2}}%;">
                            {{(totalfixed[0][1].plan)*100 |number:2}}%
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="under row cvs-under">
            <?php
            $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
                'id' => 'form',
                'enableAjaxValidation' => false,
                'method' => 'get',
                'layout'=>'inline',
            ));

            $regionoptions = BSHtml::tag('option',array('value'=>'1'),Yii::t('cvs','装瓶集团'));
            $regionoptions .= BSHtml::tag('option',array('ng-repeat'=>'item in relationslist', 'ng-if'=>'item.depth==1','ng-value'=>'item.Id','ng-bind'=>'item.name','ng-selected'=>"item.Id==region?'selected':''"),'');
            $selregion= BSHtml::tag('select',array("id"=>"Search_region","class"=>"form-control map-control",'ng-model'=>'region','ng-change'=>'onoptionchange(1)','name'=>'Search[region]'),$regionoptions);

            $factoryoptions = BSHtml::tag('option',array('value'=>'0'),Yii::t('cvs','装瓶厂'));
            $factoryoptions .= BSHtml::tag('option',array('ng-repeat'=>'item in relationslist', 'ng-if'=>'(region==1 && item.depth==2)||(region!=1 && item.parent==region)','ng-value'=>'item.Id','ng-bind'=>'item.name','ng-selected'=>"item.Id==factory?'selected':''"),'');
            $selfactory = BSHtml::tag('select',array("id"=>"Search_factory","class"=>"form-control map-control",'ng-model'=>'factory','ng-change'=>'onoptionchange(2)','name'=>'Search[factory]'),$factoryoptions);

//            $cityoptions = BSHtml::tag('option',array('value'=>'0'),Yii::t('cvs','城市'));
//            $cityoptions .= BSHtml::tag('option',array('ng-repeat'=>'item in relationslist', 'ng-if'=>'item.depth==3&&((factory=="0"&&region==1)||(factory!="0" &&item.parent==factory)||(factory=="0"&&region!="1"&&relations[item.parent].parent==region))','ng-value'=>'item.Id','ng-bind'=>'item.name','ng-selected'=>"item.Id==city&&city!=='0'?'selected':''"),'');
//            $selcity= BSHtml::tag('select',array("id"=>"Search_city","class"=>"form-control map-control",'ng-model'=>'city','ng-change'=>'onoptionchange(3)','name'=>'Search[city]'),$cityoptions);
//            echo $form->custominputControlGroup($selcity.$selfactory.$selregion, Yii::t('cvs','区域'),array("groupOptions"=>array("class"=>"col-md-4"),"controlOptions"=>array("style"=>"display:inline-block;")));

            echo $form->custominputControlGroup($selfactory.$selregion, Yii::t('cvs','区域'),array("groupOptions"=>array("class"=>"col-md-3"),"controlOptions"=>array("style"=>"display:inline-block;")));
            // echo $form->custominputControlGroup($selfactory, '');
            // echo $form->custominputControlGroup($selcity, '');
            //echo $form->custominputControlGroup($selstation, '');
            $systemtypeoptions = BSHtml::tag('option',array('value'=>'0'),Yii::t('cvs','系统类型'));
            $systemtypeoptions .= BSHtml::tag('option',array('ng-repeat'=>'item in systemslist','ng-value'=>'item.Id','ng-bind'=>'item.name', 'ng-if'=>'item.depth==1','ng-selected'=>"item.Id==systemtype?'selected':''"),'');
            $systemtype= BSHtml::tag('select',array("id"=>"Search_systemtype","class"=>"form-control",'ng-model'=>'systemtype','ng-change'=>'onoptionchange(4)','name'=>'Search[systemtype]'),$systemtypeoptions);

            $usersystemoptions = BSHtml::tag('option',array('value'=>'0'),Yii::t('cvs','客户系统'));
            $usersystemoptions .= BSHtml::tag('option',array('ng-repeat'=>'item in systemslist', 'ng-if'=>'(item.depth==2&&systemtype!=0&&item.parent==systemtype)||(item.depth==2&&systemtype==0)','ng-value'=>'item.Id','ng-bind'=>'item.name','ng-selected'=>"item.Id==system?'selected':''"),'');
            $usersystem= BSHtml::tag('select',array("id"=>"Search_usersystem","class"=>"form-control",'ng-model'=>'system','ng-change'=>'onoptionchange(5)','name'=>'Search[system]'),$usersystemoptions);


            echo $form->custominputControlGroup($usersystem.$systemtype, Yii::t('cvs','客户系统'),array("groupOptions"=>array("class"=>"col-md-3"),"controlOptions"=>array("style"=>"display:inline-block;")));



            // $turnsoptions = BSHtml::tag('option',array('value'=>'0'),Yii::t('cvs','轮次'));
            //$turnsoptions=BSHtml::tag('option',array('value'=>'0'),Yii::t('cvs','轮次'));
            $turnsoptions= '';
            $turnsoptions .= BSHtml::tag('option',array('ng-repeat'=>'item in stages', 'ng-value'=>'item.id','ng-bind'=>'item.stage','ng-selected'=>"item.id==stage?'selected':''"),'');
            $selturns= BSHtml::tag('select',array(

                "id"=>"Search_stage","class"=>"form-control",'ng-model'=>'stage','ng-change'=>'onoptionchange(6)','name'=>'Search[stage]'),$turnsoptions);
            // $selturns=BSHtml::activedropdownlist($searchmodel,'stage',$stages,array('empty'=>'轮次'));
            echo $form->custominputControlGroup($selturns.$form->textField($searchmodel, 'month', array('placeholder' => '时间',"onchange"=>"javascript:form.submit()")), Yii::t('cvs','时间'),array("groupOptions"=>array("class"=>"col-md-2"),"controlOptions"=>array("style"=>"display:inline-block;")));

            // echo BSHtml::tag("span",array(), '时间：').$form->textFieldControlGroup($searchmodel, 'month', array('labelOptions' =>array("label"=> '时间'),  "onchange"=>"javascript:form.submit()"));
            $skusoptions = BSHtml::tag('option',array('value'=>'0'),Yii::t('cvs','必备包装'));
            $skusoptions .= BSHtml::tag('option',array('ng-repeat'=>'item in skuslist', 'ng-if'=>'item.depth==1','ng-value'=>'item.Id','ng-bind'=>'item.name','ng-selected'=>"item.Id==category?'selected':''"),'');
            $selcategory= BSHtml::tag('select',array("id"=>"Search_category","class"=>"form-control","ng-disabled"=>'brandreadonly.category', 'ng-model'=>'category','ng-change'=>'onoptionchange(7)','name'=>'Search[category]'),$skusoptions);

            $brandsoptions = BSHtml::tag('option',array('value'=>'0'),Yii::t('cvs','品牌'));
            $brandsoptions .= BSHtml::tag('option',array('ng-repeat'=>'item in skuslist', 'ng-if'=>'(item.depth==2 && (category=="0" || (category!="0"&& (item.parent==category))))','ng-value'=>'item.Id','ng-bind'=>'item.name','ng-selected'=>"item.Id==brand?'selected':''"),'');
            $selbrand= BSHtml::tag('select',array("id"=>"Search_brand","class"=>"form-control",'ng-model'=>'brand',"ng-disabled"=>'brandreadonly.brand','ng-change'=>'onoptionchange(8)','name'=>'Search[brand]'),$brandsoptions);

            $modeoptions = BSHtml::tag('option',array('value'=>'0','myname'=>'none'),Yii::t('cvs','SKU'));
            $modeoptions .= BSHtml::tag('option',array('ng-repeat'=>'item in skuslist', 'ng-if'=>'(item.depth==3&&((category==0&&brand==0)||(category!=0&&brand==0&&skuslist[item.parent].parent==category)||(brand!=0&&item.parent==brand)))','ng-value'=>'item.Id','ng-bind'=>'item.name','ng-selected'=>"item.Id==SKU?'selected':''"),'');
            $seltype= BSHtml::tag('select',array("id"=>"Search_SKU","class"=>"form-control",'ng-model'=>'SKU',"ng-disabled"=>'brandreadonly.sku','ng-change'=>'onoptionchange(9)','name'=>'Search[SKU]'),$modeoptions);

            echo $form->custominputControlGroup($seltype.$selbrand.$selcategory, Yii::t('cvs','产品'),array("groupOptions"=>array("class"=>"col-md-4"),"controlOptions"=>array("style"=>"display:inline-block;")));


            $this->endWidget();

            ?>
            <button class="btn btn-default reset" ng-click="resetFilter()"><?= Yii::t('cvs','重置');?></button>
        </div>

    </div>

</div>
<!-- Modal月报 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo BSHtml::image(Yii::app()->baseUrl."/images/time.png"); ?>
                    <input type="text" id="SSearch_month_table1" class="SSearch_month_table" value="{{month}}">
                    <?php echo BSHtml::image(Yii::app()->baseUrl."/images/month.png",'',array('class'=>'month-arrow'));?>
                </h4>
            </div>
            <div class="modal-body month-modal" style="height: 306px;overflow: auto;">
                <table class="table table-striped" id="showtable">
                </table>
            </div>
        </div>
    </div>
</div>