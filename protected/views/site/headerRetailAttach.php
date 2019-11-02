<?php
//全部
//$group = CHtml::listData(Relation::model()->findAll(array("condition" => 'parent=0 or parent=4', "order" => "id desc")), 'id', 'name');
//$factory = CHtml::listData(Relation::model()->findAll("depth=2"), 'id', 'name');
//$citylevel = array_unique(CHtml::listData(Relation::model()->findAll(array('condition' => "depth=3", 'select' => 'name,id')), 'id', 'name'));
//$city = CHtml::listData(Relation::model()->findAll("depth=4"), 'id', 'name');
//$category = CHtml::listData(Category::model()->findAll(), 'id', 'name');
//pd($category);
//pd($factory);
//pd($group);
//print_r($city);

//$brand = CHtml::listData(Sku::model()->findAll('depth=2'), 'id', 'name');
//pd($searchmodel);
function randFloat($min = 0, $max = 1)
{
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}

?>
<style>
    .layui-layer-setwin .layui-layer-close2 {
        right: -3px;
        top: -7px;
    }

    .down-jiantou {
        position: absolute;
        right: 20px;
        top: 1px;
        width: 16px;
        height: 16px;
        background: url("<?php echo Yii::app()->baseUrl.'/css/chosen-sprite.png';?>") 0 2px no-repeat;
    }

    .changeRed {
        color: red;
    }
</style>


<div class="container-fluid">
    <div class="navbar-header">

        <div class="logo" title="首页">
            <img src="<?php echo Yii::app()->baseUrl ?>/images/cvslogo.png">
            <span><?= Yii::t('cvs', '可口可乐新零售商超便利O2O追踪平台'); ?></span>
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
            <!--            <li>-->
            <!--                <span>-->
            <!--                    <a href="--><?php //echo Yii::app()->createUrl('site/market');?><!--">-->
            <!--                        --><?php
            //                        if (Yii::app()->language == 'zh_cn') {
            //                            echo CHtml::image(Yii::app()->baseUrl."/images/rank.png");
            //                        }elseif(Yii::app()->language == 'es'){
            //                            echo CHtml::image(Yii::app()->baseUrl."/images/e_rank.png");
            //                        }
            //                        ?>
            <!--                    </a>-->
            <!--                </span>-->
            <!--            </li>-->
            <!--            <li><span><a href="-->
            <?php //echo Yii::app()->createUrl('site/store'); ?><!--">基本详情页</a></span></li>-->
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
                    <span data-toggle="dropdown" title="下载月报/季报或者期报">
                        <?= Yii::t('cvs', '下载'); ?>
                        <i class="caret"></i>
                    </span>
                    <ul class="dropdown-menu">
                        <!--                        <li id="monthly_Reportz"><a href="#">月报/季报</a></li>-->
                        <li id="monthly_Reportz" data-toggle="modal" data-target="#myModal"><a
                                    href="#"><?= Yii::t('cvs', '报告'); ?></a></li>
                        <!--                        <li><a href="#">--><? //= Yii::t('cvs','报表'); ?><!--</a></li>-->
                    </ul>
                </div>
            </li>

            <li>
                <span title="有疑问？点这里!"><?= Yii::t('cvs', '帮助'); ?></span>
            </li>

            <li>
                <div class="user dropdown">
                    <span data-toggle="dropdown">
                        <?php echo BSHtml::image(Yii::app()->baseUrl . "/images/person.png"); ?>
                        GUEST
                        <i class="caret"></i>
                    </span>
                    <ul class="dropdown-menu">
                        <!--                        <li><a href="#">--><? //= Yii::t('cvs','部门属性'); ?><!--</a></li>-->
                        <!--                        <li><a href="#">--><? //= Yii::t('cvs','密码修改'); ?><!--</a></li>-->
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('site/logout'); ?>"><?= Yii::t('cvs', '退出登录'); ?></a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>

    </div>

</div>
<div class="main-content">

    <div class="main">
        <div class="top cvs-top row">
            <div class="col-md-3 row">
                <div class="main-top1 col-md-7" style="text-align: center;font-size: 18px;font-weight: bold">
                    <span class="header-span span-ko" ng-bind="month | reverse" ng-clock></span><span class="span-ko">KO全国KPI</span><br>
                </div>
                <div class="main-top1 col-md-5 header-select">
                    <select ng-disabled="forbid" class="form-control map-control optionsType" ng-model="myselect" ng-change="getDataType()"
                            id="myselect">
                        <option value="0">VS PP</option>
                        <option value="-1">VS LY</option>
                    </select>
                </div>
            </div>
            <div class="col-md-9 row">
                <div class="main-top1 col-md-2 row">
                    <div class="col-md-7">
                        <span class="header-span"><?= Yii::t('cvs', '产品铺货率'); ?></span>
                        <img src="<?=Yii::app()->request->baseUrl.'/images/rule.png';?>" alt="产品铺货率：全国该时间内线上在售任一KO产品的网店数/全国该时间内全部网店数" title="产品铺货率：全国该时间内线上在售任一KO产品的网店数/全国该时间内全部网店数">
                    </div>
                    <div class="col-md-5 total-header">

                        <span ng-bind="(ko_onlinestores/onlinestores * 100| number:1) + '%'"></span><br/>
                        <span ng-if="(ko_onlinestores/onlinestores * 100| number:1) - (lastko_onlinestores/lastonlinestores * 100| number:1) > 0 && (lastko_onlinestores!=null)" ng-cloak>
                            <span ng-bind="(ko_onlinestores/onlinestores * 100| number:1) - (lastko_onlinestores/lastonlinestores * 100| number:1) + '%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                        </span>
                        <span ng-if="(ko_onlinestores/onlinestores * 100| number:1) - (lastko_onlinestores/lastonlinestores * 100| number:1) < 0 && (lastko_onlinestores!=null)" ng-cloak>
                            <span class="change"
                                  ng-bind="(lastko_onlinestores/lastonlinestores * 100| number:1) - (ko_onlinestores/onlinestores * 100| number:1) + '%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                        </span>
                        <span ng-if="(ko_onlinestores/onlinestores * 100| number:1) - (lastko_onlinestores/lastonlinestores * 100| number:1) == 0 && (lastko_onlinestores!=null)" ng-cloak>
                            <span class="change"
                                  ng-bind="0 + '%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
                        </span>
                        <span ng-if="lastko_onlinestores/lastonlinestores == null || (lastko_onlinestores==null)" ng-cloak>
                            <?= Yii::t('cvs', 'N/A'); ?>
                        </span>
                    </div>
                </div>
                <div class="main-top1 col-md-5 row">
                    <div class="col-md-4">
                        <span class="header-span"><?= Yii::t('cvs', '销售件数（件）'); ?></span>
                        <img src="<?=Yii::app()->request->baseUrl.'/images/rule.png';?>" alt="销售件数(件)：全国该时间内KO产品销售件数的总和" title="销售件数(件)：全国该时间内KO产品销售件数的总和">
                    </div>
                    <div class="col-md-2 total-header">
                        <span ng-bind="(ko_salescount |number:0)"></span><br/>
                        <span ng-if="ko_salescount -lastko_salescount > 0 && (lastko_salescount!=null)" ng-cloak>
                            <span ng-bind="((ko_salescount-lastko_salescount)/lastko_salescount*100 | number:1)+'%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                        </span>
                        <span ng-if="ko_salescount-lastko_salescount < 0 && (lastko_salescount!=null)" ng-cloak>
                            <span class="change"
                                  ng-bind="((lastko_salescount-ko_salescount)/lastko_salescount*100 |number:1)+'%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                        </span>
                        <span ng-if="ko_salescount-lastko_salescount== 0 && (lastko_salescount!=null)" ng-cloak>
                            <span class="change"
                                  ng-bind="((lastko_salescount-ko_salescount)/lastko_salescount * 100| number:1)+'%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
                        </span>
                        <span ng-if="lastko_salescount == null || (lastko_salescount==null)" ng-cloak>
                            <?= Yii::t('cvs', 'N/A'); ?>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <span class="header-span"><?= Yii::t('cvs', '销售件数份额'); ?></span>
                        <img src="<?=Yii::app()->request->baseUrl.'/images/rule.png';?>" alt="销售件数份额：全国该时间内KO产品销售件数/全国该时间内全部软饮销售件数" title="销售件数份额：全国该时间内KO产品销售件数/全国该时间内全部软饮销售件数">
                    </div>
                    <div class="col-md-2 total-header">
                        <!--销售件数份额-->
                        <span ng-bind="(ko_salescount/salescount * 100|number:1) + '%'"></span><br/>
                        <span ng-if="(ko_salescount/salescount-lastko_salescount/lastsalescount) > 0 && (lastko_salescount!=null)" ng-cloak>
                            <span ng-bind="((ko_salescount/salescount-lastko_salescount/lastsalescount) * 100|number:1) + '%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                        </span>
                        <span ng-if="(ko_salescount/salescount-lastko_salescount/lastsalescount) < 0 && (lastsalescount!=null)" ng-cloak>
                            <span class="change"
                                  ng-bind="((lastko_salescount/lastsalescount-ko_salescount/salescount) * 100|number:1) + '%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                        </span>
                        <span ng-if="(ko_salescount/salescount-lastko_salescount/lastsalescount) == 0 && (lastko_salescount!=null)" ng-cloak>
                            <span class="change"
                                  ng-bind="0 + '%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
                        </span>
                        <span ng-if="lastko_salescount/lastsalescount == null || (lastko_salescount==null)" ng-cloak>
                            <?= Yii::t('cvs', 'N/A'); ?>
                        </span>
                    </div>
                </div>
                <div class="main-top1 col-md-5 row">
                    <div class="col-md-4">
                        <span class="header-span"><?= Yii::t('cvs', '销售金额（元）'); ?></span>
                        <img src="<?=Yii::app()->request->baseUrl.'/images/rule.png';?>" alt="销售金额(元)：全国该时间内KO产品销售件数乘以KO产品实际销售价格（含折扣、特价，不含红包、立减、满减）乘积的总和" title="销售金额(元)：全国该时间内KO产品销售件数乘以KO产品实际销售价格（含折扣、特价，不含红包、立减、满减）乘积的总和">
                    </div>
                    <div class="col-md-2 total-header">
                        <span ng-bind="(ko_sales_amount |number:0)"></span><br/>
                        <span ng-if="ko_sales_amount-lastko_sales_amount > 0 && lastko_sales_amount!=null" ng-cloak>
                            <span ng-bind="((ko_sales_amount-lastko_sales_amount)/lastko_sales_amount * 100|number:1) + '%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                        </span>
                        <span ng-if="ko_sales_amount-lastko_sales_amount < 0 && lastko_sales_amount!=null" ng-cloak>
                            <span class="change"
                                  ng-bind="((lastko_sales_amount-ko_sales_amount)/lastko_sales_amount * 100|number:1) + '%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                        </span>
                        <span ng-if="ko_sales_amount-lastko_sales_amount== 0 && lastko_sales_amount!=null" ng-cloak>
                            <span class="change"
                                  ng-bind="0 + '%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
                        </span>
                        <span ng-if="lastko_sales_amount == null || lastko_sales_amount==null" ng-cloak>
                            <?= Yii::t('cvs', 'N/A'); ?>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <span class="header-span"><?= Yii::t('cvs', '销售金额份额'); ?></span>
                        <img src="<?=Yii::app()->request->baseUrl.'/images/rule.png';?>" alt="销售金额份额：全国该时间内KO产品销售金额/全国该时间内全部软饮销售金额" title="销售金额份额：全国该时间内KO产品销售金额/全国该时间内全部软饮销售金额">
                    </div>
                    <div class="col-md-2 total-header">
                        <!--销售额份额-->
                        <span  ng-bind="((ko_sales_amount/sales_amount * 100|number:1) + '%')"></span><br/>
                        <span ng-if="ko_sales_amount/sales_amount-lastko_sales_amount/lastsales_amount > 0 && lastko_sales_amount!=null" ng-cloak>
                            <span ng-bind="((ko_sales_amount/sales_amount-lastko_sales_amount/lastsales_amount) * 100|number:1)+ '%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                        </span>
                        <span ng-if="ko_sales_amount/sales_amount-lastko_sales_amount/lastsales_amount < 0 && lastko_sales_amount!=null" ng-cloak>
                            <span class="change"
                                  ng-bind="((lastko_sales_amount/lastsales_amount-ko_sales_amount/sales_amount) * 100|number:1) + '%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                        </span>
                        <span ng-if="ko_sales_amount/sales_amount-lastko_sales_amount/lastsales_amount == 0 && lastko_sales_amount!=null" ng-cloak>
                            <span class="change"
                                  ng-bind="((ko_sales_amount/sales_amount-lastko_sales_amount/lastsales_amount) * 100|number:1)  + '%'"></span>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
                        </span>
                        <span ng-if="lastko_sales_amount/lastsales_amount == null || lastko_sales_amount==null" ng-cloak>
                            <?= Yii::t('cvs', 'N/A'); ?>
                        </span>
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
                'layout' => 'inline',
            ));
            echo BSHtml::tag('div',array('class'=>'wd-title data-scope'),'数据范围',false);
            echo BSHtml::image(Yii::app()->request->baseUrl.'/images/plaint.png',"下拉菜单只可单选，可以限定的数据范围包括：装瓶集团、装瓶厂、城市等级、城市、渠道、平台、品类、时间",array("style"=>"margin-left:5px;cursor:pointer","title"=>"下拉菜单只可单选，可以限定的数据范围包括：装瓶集团、装瓶厂、城市等级、城市、渠道、平台、品类、时间"));
            echo BSHtml::closeTag("div");
            $regionoptions = BSHtml::tag('option', array('value' => '全部'), Yii::t('cvs', '全部'));
            //$regionoptions .= BSHtml::tag('option', array( 'ng-repeat' => 'item in zpjtlist0', 'ng-value' => 'item[0]','ng-bind' => 'item[0]','ng-selected' => ""), '');
            $regionoptions .= BSHtml::tag('option', array( 'ng-repeat' => 'item in zpjtlist0','ng-if' => 'item[0]!="全部"','ng-value' => 'item[0]','ng-bind' => 'item[0]','ng-selected' => ""), '');

            $selregion = BSHtml::tag('select', array("id" => "Search_region", "class" => "form-control map-control", 'ng-model' => 'zpjt1','ng-change' => 'onoptionchange(1)', 'name' => 'Search[region]'), $regionoptions);
            echo $form->custominputControlGroup($selregion, Yii::t('cvs', '装瓶集团'), array("groupOptions" => array("class" => "header-overall"), "controlOptions" => array("style" => "display:inline-block;")));

            $factoryoptions = BSHtml::tag('option', array('value' => '全部'), Yii::t('cvs', '全部'));
            $factoryoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in zpclist0','ng-if' => 'item[0]!="全部"', 'ng-value' =>'item[0]', 'ng-bind' => 'item[0]', 'ng-selected' => ""), '');
            $selfactory = BSHtml::tag('select', array("id" => "Search_factory", "class" => "form-control map-control", 'ng-model' => 'zpc1', 'ng-change' => 'onoptionchange(2)', 'name' => 'Search[factory]'), $factoryoptions);
            echo $form->custominputControlGroup($selfactory, Yii::t('cvs', '装瓶厂'), array("groupOptions" => array("class" => "header-overall"), "controlOptions" => array("style" => "display:inline-block;")));

            $cityleveloptions = BSHtml::tag('option', array('value' => '全部'), Yii::t('cvs', '全部'));
            $cityleveloptions .= BSHtml::tag('option', array('ng-repeat' => 'item in cityclasslist0','ng-if' => 'item[0]!="全部"','ng-value' =>'item[0]', 'ng-bind' => 'item[0]', 'ng-selected' => ""), '');
            $selcitylevel = BSHtml::tag('select', array("id" => "Search_cityLevel", "class" => "form-control map-control", 'ng-model' => 'city_level1', 'ng-change' => 'onoptionchange(3)', 'name' => 'Search[cityLevel]'), $cityleveloptions);
            echo $form->custominputControlGroup($selcitylevel, Yii::t('cvs', '城市等级'), array("groupOptions" => array("class" => "header-overall header-level"), "controlOptions" => array("style" => "display:inline-block;")));

            $cityoptions = BSHtml::tag('option', array('value' => '全部'), Yii::t('cvs', '全部'));
            $cityoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in citylist0','ng-if' => 'item[0]!="全部"','ng-value' => 'item[0]', 'ng-bind' => 'item[0]', 'ng-selected' => ""), '');
            $selcity = BSHtml::tag('select', array("id" => "Search_city", "class" => "form-control map-control", 'ng-model' => 'city1', 'ng-change' => 'onoptionchange(4)', 'name' => 'Search[city]'), $cityoptions);
            echo $form->custominputControlGroup($selcity, Yii::t('cvs', '城市'), array("groupOptions" => array("class" => "header-overall"), "controlOptions" => array("style" => "display:inline-block;")));

            $systemtypeoptions = BSHtml::tag('option', array('value' => '全部'), Yii::t('cvs', '全部'));
            $systemtypeoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in channellist0', 'ng-if' => 'item[0]!="全部"', 'ng-value' =>'item[0]','ng-bind' => 'item[0]','ng-selected' => ""), '');
            $systemtype = BSHtml::tag('select', array("id" => "Search_channel", "class" => "form-control", 'ng-model' => 'channel1', 'ng-change' => 'onoptionchange(5)', 'name' => 'Search[systemtype]'), $systemtypeoptions);
            echo $form->custominputControlGroup($systemtype, Yii::t('cvs', '渠道'), array("groupOptions" => array("class" => "header-overall"), "controlOptions" => array("style" => "display:inline-block;")));

            $platformoptions = BSHtml::tag('option', array('value' => '全部'), Yii::t('cvs', '全部'));
            $platformoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in platformlist0','ng-if' => 'item[0]!="全部"','ng-value' =>'item[0]', 'ng-bind' => 'item[0]', 'ng-selected' => ""), '');
            $selplatform = BSHtml::tag('select', array("ng-disabled"=>"forbid","id" => "Search_platform", "class" => "form-control", 'ng-model' => 'platform1', 'ng-change' => 'onoptionchange(6)', 'name' => 'Search[platform]'), $platformoptions);
            echo $form->custominputControlGroup($selplatform, Yii::t('cvs', '平台'), array("groupOptions" => array("class" => "header-overall"), "controlOptions" => array("style" => "display:inline-block;")));

            // echo BSHtml::tag("span",array(), '时间：').$form->textFieldControlGroup($searchmodel, 'month', array('labelOptions' =>array("label"=> '时间'),  "onchange"=>"javascript:form.submit()"));
            $skusoptions = BSHtml::tag('option', array('value' => '全部'), Yii::t('cvs', '全部'));
            $skusoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in typelist0','ng-if' => 'item[0]!="全部"','ng-value' =>'item[0]', 'ng-bind' => 'item[0]', 'ng-selected' => ""), '');
            $selcategory = BSHtml::tag('select', array("id" => "Search_type", "class" => "form-control map-screen","ng-disabled" => 'forbid', 'ng-model' => 'type1', 'ng-change' => 'onoptionchange(7)', 'name' => 'Search[category]'), $skusoptions);

            echo $form->custominputControlGroup($selcategory, Yii::t('cvs', '品类'), array("groupOptions" => array("class" => "header-overall category_over"), "controlOptions" => array("style" => "display:inline-block;")));
            $timeoptions = '';
            $timeoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in timelist', 'ng-value' => 'item', 'ng-bind' => 'item', 'ng-selected' => "item==month?'selected':''"), '');
            $seltime = BSHtml::tag('select', array("ng-disabled"=>"forbid","id" => "Search_month", "class" => "form-control map-control", 'ng-model' => 'month','ng-change' => 'onoptionchange(0)', 'name' => 'Search[month]'), $timeoptions);

            $turnsoptions = '';
            $turnsoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in stages', 'ng-value' => 'item.id', 'ng-bind' => 'item.value'), '');
//            $turnsoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in stages', 'ng-value' => 'item.id', 'ng-bind' => 'item.value', 'ng-selected' => "item.id==stage?'selected':''"), '');
            $selturns = BSHtml::tag('select', array("ng-disabled"=>"forbid","id" => "Search_stage", "class" => "form-control map-control","onchange"=>"mapScreen()", 'ng-model' => 'stage', 'ng-change' => 'onoptionchange(8)', 'name' => 'Search[stage]'), $turnsoptions);
            echo $form->custominputControlGroup($selturns.$seltime,Yii::t('cvs', '时间'), array("groupOptions" => array("class" => "header-overall header-time"), "controlOptions" => array("style" => "display:inline-block;")));

            $this->endWidget();

            ?>
            <button class="btn btn-default reset" ng-click="resetFilter()"><?= Yii::t('cvs', '重置'); ?></button>
        </div>

    </div>

</div>
<!-- Modal月报/季报 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo BSHtml::image(Yii::app()->baseUrl . "/images/time.png"); ?>
                    <!--                    <input type="text" id="SSearch_month_table1" class="SSearch_month_table" value="{{month}}">-->
                    <select name="" id="SSearch_month_table1" class="SSearch_month_table" ng-model="downMonth">
                        <option ng-value="item.time" ng-repeat="item in timelist"  ng-bind="item" ng-selected="item==downMonth?'selected':''"></option>
                    </select>
                    <!--                    --><?php //echo BSHtml::image(Yii::app()->baseUrl . "/images/month.png", '', array('class' => 'month-arrow')); ?>
                </h4>
            </div>
            <div class="modal-body month-modal" style="height: 306px;overflow: auto;">
                <table class="table table-striped" id="showtable">
                </table>
            </div>
        </div>
    </div>
</div>