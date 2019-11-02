<?php
//装瓶集团
$group = CHtml::listData(Relationship::model()->findAll(array("condition" => 'parent=0 or parent=4', "order" => "Id desc")), 'Id', 'name');
$factory = CHtml::listData(Relationship::model()->findAll("depth=2"), 'Id', 'name');
$city = CHtml::listData(Relationship::model()->findAll("depth=3"), 'Id', 'name');
$category = CHtml::listData(Sku::model()->findAll('depth=1'), 'Id', 'name');
$brand = CHtml::listData(Sku::model()->findAll('depth=2'), 'Id', 'name');
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
        background: url("<?php echo Yii::app()->baseUrl . '/css/chosen-sprite.png'; ?>") 0 2px no-repeat;
    }
    .changeRed{
        color: red;
    }
</style>
<div class="container-fluid">

    <div class="navbar-header">

        <div class="logo">
            <img src="<?php echo Yii::app()->baseUrl ?>/images/logo.png">
            <span><?= Yii::t('app', Yii::app()->name); ?></span>
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
                    <!--                    --><?php //echo CHtml::link('中',array('Site/ChangeLanguage','language'=>'zh_cn'),array('class'=>'changeRed'));  ?>
                    <!--                    <i class="glyphicon glyphicon-resize-horizontal"></i>-->
                    <!--                    --><?php //echo CHtml::link('En',array('Site/ChangeLanguage','language'=>'es'),array('class'=>'changeRed'));  ?>

                    <?php
                    if (Yii::app()->language == 'zh_cn') {
                        echo CHtml::link('中', array('Site/ChangeLanguage', 'language' => 'zh_cn'), array('class' => 'changeRed'));
                        ?>
                        <i class="glyphicon glyphicon-resize-horizontal"></i>
                        <?php
                        echo CHtml::link('En', array('Site/ChangeLanguage', 'language' => 'es'));
                    } elseif (Yii::app()->language == 'es') {
                        echo CHtml::link('中', array('Site/ChangeLanguage', 'language' => 'zh_cn'));
                        ?>
                        <i class="glyphicon glyphicon-resize-horizontal"></i>
                        <?php
                        echo CHtml::link('En', array('Site/ChangeLanguage', 'language' => 'es'), array('class' => 'changeRed'));
                    }
                    ?>
                </span>

            </li>

            <?php
            if (Yii::app()->user->checkAccess("download")) {
                ?>
                <li>
                    <div class="dropdown">
                    <span data-toggle="dropdown">
                        <?= Yii::t('app', '下载'); ?>
                        <i class="caret"></i>
                    </span>
                        <ul class="dropdown-menu">
                            <!--                        <li id="monthly_Reportz"><a href="#">月报</a></li>-->
                            <li id="monthly_Reportz" data-toggle="modal" data-target="#myModal"><a
                                    href="#"><?= Yii::t('app', '月报'); ?></a></li>
                            <!--                        <li><a href="#">--><?//= Yii::t('app','报表');
                            ?><!--</a></li>-->
                        </ul>
                    </div>
                </li>
                <?php
            }
            ?>

            <li>
<!--                <span>--><?//= Yii::t('app','帮助'); ?><!--</span>-->
            </li>
            <li>
                <div class="user dropdown">
                    <span data-toggle="dropdown">
                        <?php echo BSHtml::image(Yii::app()->baseUrl . "/images/person.png"); ?>
                        <?php echo yii::app()->user->name ? yii::app()->user->name : "GUEST"; ?>
                        <i class="caret"></i>
                    </span>
                    <ul class="dropdown-menu">
                        <!--                        <li><a href="#">--><?//= Yii::t('app','部门属性'); ?><!--</a></li>-->
                        <!--                        <li><a href="#">--><?//= Yii::t('app','密码修改'); ?><!--</a></li>-->
                        <li><?php
                            $logouturl = array("/site/logout");
                            if (yii::app()->params['kologin'])
                                $logouturl = array("/site/atlogout");

                            echo BSHtml::link(Yii::t('app', '退出登录'), $logouturl);
                            ?>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>

    </div>

</div>

<div class="main-content">

    <div class="main" >

        <div class="top">
            <div class="main-top1 col-md-3" ><span ng-bind="month[0] + month[1] + month[2] + month[3] + '<?= Yii::t('app', '年'); ?>' + month[5] + month[6] + ' <?= Yii::t('app', 'KO汽水全国KPI'); ?>'"></span></div>

            <div class="main-top1 col-md-3">
                <span><?= Yii::t('app', '上线率'); ?></span>
                <span ng-bind="(totalfixed.availability * 100| number:2) + '%' "></span>
                <span ng-if="totalfixed.Preceding_availability > 0">
                    <span ng-bind="(totalfixed.Preceding_availability * 100|number:2) + '%'"></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                </span>
                <span ng-if="totalfixed.Preceding_availability < 0">
                    <span class="change" ng-bind="(totalfixed.Preceding_availability * 100|number:2) + '%'"></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                </span>
                <span ng-if="totalfixed.Preceding_availability == 0 || totalfixed.Preceding_availability == null">
                    <?= Yii::t('app', '无数据'); ?>
                </span>
            </div>
            <div class="main-top1 col-md-3">
                <span><?= Yii::t('app', '配售率'); ?></span>
                <span ng-bind="(totalfixed.attach_rate * 100| number:2) + '%'"></span>
                <span ng-if="totalfixed.Preceding_Attach_Rate > 0">
                    <span ng-bind="(totalfixed.Preceding_Attach_Rate * 100|number:2) + '%'"></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                </span>
                <span ng-if="totalfixed.Preceding_Attach_Rate < 0">
                    <span class="change" ng-bind="(totalfixed.Preceding_Attach_Rate * 100|number:2) + '%'"></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                </span>
                <span ng-if="totalfixed.Preceding_Attach_Rate == 0 || totalfixed.Preceding_Attach_Rate == null">
                    <?= Yii::t('app', '无数据'); ?>
                </span>


            </div>
            <div class="main-top1 col-md-3">
                <span><?= Yii::t('app', '点购率'); ?></span>
                <span ng-bind="(totalfixed.Incidence * 100|number:2) + '%'"></span>
                <span ng-if="totalfixed.Preceding_Incidence > 0">
                    <span ng-bind="(totalfixed.Preceding_Incidence * 100|number:2) + '%'"></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                </span>
                <span ng-if="totalfixed.Preceding_Incidence < 0">
                    <span class="change" ng-bind="(totalfixed.Preceding_Incidence * 100|number:2) + '%'"></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                </span>
                <span ng-if="totalfixed.Preceding_Incidence == 0 || totalfixed.Preceding_Incidence == null">
                    <?= Yii::t('app', '无数据'); ?>
                </span>
            </div>


        </div>

        <div class="under row">
            <?php
            $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
                'id' => 'form',
                'enableAjaxValidation' => false,
                'method' => 'get',
                'layout' => 'inline',
            ));

            $regionoptions = BSHtml::tag('option', array('value' => '4'), Yii::t('app', '装瓶集团'));
            $regionoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in relations', 'ng-if' => 'item.depth==1', 'ng-value' => 'item.Id', 'ng-bind' => 'item.name', 'ng-selected' => "item.Id==region?'selected':''"), '');
            $selregion = BSHtml::tag('select', array("id" => "Search_region", "class" => "form-control map-control", 'ng-model' => 'region', 'ng-change' => 'onoptionchange(1)', 'name' => 'Search[region]'), $regionoptions);

            $factoryoptions = BSHtml::tag('option', array('value' => '0'), Yii::t('app', '装瓶厂'));
            $factoryoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in relations', 'ng-if' => '(region==4 && item.depth==2)||(region!=4 && item.parent==region)', 'ng-value' => 'item.Id', 'ng-bind' => 'item.name', 'ng-selected' => "item.Id==factory?'selected':''"), '');
            $selfactory = BSHtml::tag('select', array("id" => "Search_factory", "class" => "form-control map-control", 'ng-model' => 'factory', 'ng-change' => 'onoptionchange(2)', 'name' => 'Search[factory]'), $factoryoptions);

            $cityoptions = BSHtml::tag('option', array('value' => '0'), Yii::t('app', '城市'));
            $cityoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in relations', 'ng-if' => 'item.depth==3&&((factory=="0"&&region==4)||(factory!="0" &&item.parent==factory)||(factory=="0"&&region!="4"&&relations[item.parent].parent==region))', 'ng-value' => 'item.Id', 'ng-bind' => 'item.name', 'ng-selected' => "item.Id==city&&city!=='0'?'selected':''"), '');
            $selcity = BSHtml::tag('select', array("id" => "Search_city", "class" => "form-control map-control", 'ng-model' => 'city', 'ng-change' => 'onoptionchange(3)', 'name' => 'Search[city]'), $cityoptions);

            $stationoptions = BSHtml::tag('option', array('value' => '0'), Yii::t('app', '营业所'));
            $stationoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in relations', 'ng-if' => '(city=="0" && item.depth==4)||(city!="0" && item.parent==city)', 'ng-value' => 'item.Id', 'ng-bind' => 'item.name', 'ng-selected' => "item.Id==station?'selected':''"), '');
            $selstation = BSHtml::tag('select', array("id" => "Search_station", "class" => "form-control", 'ng-model' => 'station', 'ng-change' => 'onoptionchange(4)', 'name' => 'Search[station]'), $stationoptions);
            echo '<div class="col-md-1 wd-title">' . Yii::t('app', '数据范围') . '</div>';
            echo $form->custominputControlGroup($selregion . $selfactory . $selcity . $selstation, Yii::t('app', '区域'), array("groupOptions" => array("class" => "col-md-4"), "controlOptions" => array("style" => "display:inline-block;")));
            // echo $form->custominputControlGroup($selfactory, '');
            // echo $form->custominputControlGroup($selcity, '');
            //echo $form->custominputControlGroup($selstation, '');

            $skusoptions = BSHtml::tag('option', array('value' => '0'), Yii::t('app', '全品类'));
            $skusoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in skuslist', 'ng-if' => 'item.depth==1', 'ng-value' => 'item.Id', 'ng-bind' => 'item.name', 'ng-selected' => "item.Id==category?'selected':''"), '');
            $selsku = BSHtml::tag('select', array("id" => "Search_category", "class" => "form-control", 'ng-model' => 'category', 'ng-change' => 'onoptionchange(5)', 'name' => 'Search[category]'), $skusoptions);
            $selcategory = $form->custominputControlGroup($selsku, Yii::t('app', '品类'), array("groupOptions" => array("class" => ""), "controlOptions" => array("style" => "display:inline-block;")));

            $brandsoptions = BSHtml::tag('option', array('value' => '0'), Yii::t('app', '品牌'));
            $brandsoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in skuslist', 'ng-if' => '(item.depth==2 && (category=="0" || (category!=="0"&& (item.parent==category))||(category ==2&&(item.parent==6 || item.parent==33)) )) || (category ==2&&item.parent==2&&item.depth==0) ||(category=="0"&&item.parent==2&&item.depth==0)', 'ng-value' => 'item.Id', 'ng-bind' => 'item.name', 'ng-selected' => "item.Id==brand?'selected':''"), '');
            $selbrand = BSHtml::tag('select', array("id" => "Search_brand", "class" => "form-control", 'ng-model' => 'brand', 'ng-change' => 'onoptionchange(6)', 'name' => 'Search[brand]'), $brandsoptions);
            $selbrand = $form->custominputControlGroup($selbrand, Yii::t('app', '品牌'), array("groupOptions" => array("class" => ""), "controlOptions" => array("style" => "display:inline-block;")));

            $modeoptions = BSHtml::tag('option', array('value' => '0', 'myname' => 'none'), Yii::t('app', '单点/套餐'));
            $modeoptions .= BSHtml::tag('option', array('ng-repeat' => 'item in skuslist', 'ng-if' => 'item.depth==3&&(((brand=="0"&&category!=="0")&&item.parent==category)||(brand!=="0"&&item.parent==brand)||(brand=="0"&&category=="0"&&item.parent==6))', 'ng-value' => 'item.Id', 'ng-bind' => 'item.name', 'myname' => '{{item.name=="单点"?"dandian":item.name=="套餐"?"taocan":""}}', 'ng-selected' => "item.Id==mode?'selected':''"), '');
            $seltype = BSHtml::tag('select', array("id" => "Search_mode", "class" => "form-control", 'ng-model' => 'mode', 'ng-change' => 'onoptionchange(7)', 'name' => 'Search[mode]'), $modeoptions);
            $seltype = $form->custominputControlGroup($seltype, Yii::t('app', '单点/套餐'), array("groupOptions" => array("class" => ""), "controlOptions" => array("style" => "display:inline-block;")));

            $modeoptions2 = BSHtml::tag('option', array('value' => '0', 'myname' => 'none'), Yii::t('app', '单点/套餐'));
            $modeoptions2 .= BSHtml::tag('option', array('ng-repeat' => 'item in skuslist', 'ng-if' => 'item.depth==3&&((brand!="0"&&skus[brand].parent!="33"&&skus[brand].parent!="6"&&item.parent==skus[brand].parent)||(brand!="0"&&(skus[brand].parent=="33"||skus[brand].parent=="6")&&item.parent==skus[skus[brand].parent].parent)||(brand=="0"&&item.parent==33))', 'ng-value' => 'item.Id', 'ng-bind' => 'item.name', 'myname' => '{{item.name=="单点"?"dandian":item.name=="套餐"?"taocan":""}}', 'ng-selected' => "item.Id==mode2?'selected':''"), '');
            $seltype2 = BSHtml::tag('select', array("id" => "Search_mode2", "class" => "form-control", 'ng-model' => 'mode2', 'ng-change' => 'onoptionchange()', 'name' => 'Search[mode]'), $modeoptions2);
            $seltype2 = $form->custominputControlGroup($seltype2, Yii::t('app', '单点/套餐'), array("groupOptions" => array("class" => "", 'style' => 'display:none'), "controlOptions" => array("style" => "display:inline-block;")));


            //   $seltype = $form->custominputControlGroup($form->dropDownList($searchmodel, 'mode', array("single" => Yii::t('app','单点'), "package" => Yii::t('app','套餐')), array("id"=>"Search_mode",'empty' => Yii::t('app','单点/套餐'), 'class' => 'form-control', "ng-model" => "mode", 'ng-change' => 'onoptionchange()')),Yii::t('app','点单方式'),
            //           array("groupOptions"=>array("class"=>""),"controlOptions"=>array("style"=>"display:inline-block;")));

            echo BSHtml::tag("div", array("class" => "col-md-5"), $selcategory . $selbrand . $seltype . $seltype2);


            echo $form->custominputControlGroup($form->textField($searchmodel, 'month', array('placeholder' => '时间', "onchange" => "javascript:form.submit()")), Yii::t('app', '时间'), array("groupOptions" => array("class" => "col-md-2"), "controlOptions" => array("style" => "display:inline-block;")));
            // echo BSHtml::tag("span",array(), '时间：').$form->textFieldControlGroup($searchmodel, 'month', array('labelOptions' =>array("label"=> '时间'),  "onchange"=>"javascript:form.submit()"));


            $this->endWidget();
            ?>

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
                    <?php echo BSHtml::image(Yii::app()->baseUrl . "/images/time.png"); ?>
                    <input type="text" id="SSearch_month_table1" class="SSearch_month_table" value="{{month}}">
                    <?php echo BSHtml::image(Yii::app()->baseUrl . "/images/month.png", '', array('class' => 'month-arrow')); ?>
                </h4>
            </div>
            <div class="modal-body month-modal" style="height: 306px;overflow: auto;">
                <table class="table table-striped" id="showtable">
                </table>
            </div>
        </div>
    </div>
</div>