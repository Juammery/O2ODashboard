<?php
//装瓶集团
$group = CHtml::listData(Relationship::model()->findAll(array("condition" => 'parent=4', "order" => "Id desc")), 'Id', 'name');
$factory = CHtml::listData(Relationship::model()->findAll("depth=2"), 'Id', 'name');
$city = CHtml::listData(Relationship::model()->findAll("depth=3"), 'Id', 'name');
$category = CHtml::listData(Sku::model()->findAll('depth=1'), 'Id', 'name');
$brand = CHtml::listData(Sku::model()->findAll('depth=2 or depth=3'), 'Id', 'name');
?>

<?php
$tabs = array(
    array("label" => Yii::t('app','趋势比较分析'), "class" => "wd-style"),
    array("label" => Yii::t('app','门店数量'),"id"=>"cp4", 'ng-click' => "tabchange('numberOfSalesStores')", 'url' => "#numberOfSalesStores", "class" => "{{visitab == 'numberOfSalesStores' ? 'active':''}}"),
    array("label" => Yii::t('app','上线率'),"id"=>"cp3", 'ng-click' => "tabchange('visirate')",'otype'=>'visirate', 'url' => "#visirate", "class" => "change-map {{visitab == 'visirate' ? 'active':''}}"),
    array("label" => Yii::t('app','配售率'),"id"=>"cp1",'ng-click' => "tabchange('totalorders')",'otype'=>'totalorders', 'url' => "#totalorders", "class" => "change-map {{visitab == 'totalorders' ? 'active':''}}"),
    array("label" => Yii::t('app','点购率'),"id"=>"cp5", 'ng-click' => "tabchange('orders')",'otype'=>'orders', 'url' => "#orders", "class" => "change-map {{visitab == 'orders' ? 'active':''}}"),
    array("label" => Yii::t('app','订单数量'),"id"=>"cp2", 'ng-click' => "tabchange('placingTotalOrderNumber')", 'url' => "#placingTotalOrderNumber", "class" => "{{visitab == 'placingTotalOrderNumber' ? 'active':''}}"),
    array("label" => Yii::t('app','店均点购订单数量'),"id"=>"cp6", 'ng-click' => "tabchange('opo')", 'url' => "#opo", "class" => "{{visitab == 'opo' ? 'active':''}}"),
);
echo BSHtml::nav("tabs", $tabs, array( "id" => 'deepdive',"class"=>"radius active"));

?>
<div class="conta" xmlns="http://www.w3.org/1999/html">
    <div class="mapp radius">
        <div class="weidu-box col-md-12">
            <div class="wd-title">
                <?= Yii::t('app','比较维度');?>
            </div>
            <ul class="weidu-list col-md-9">
                <li id="cityselect" class="col-md-6">
                    <div class="weidu-item-box">
                        <div class="sel-con a">
                            <div id="group">
                                <label class="checkbox-inline" ng-repeat="item in relations" ng-if="checkralationshow(item.Id)">
                                    <div class="checkboxdiv">
                                        <input ng-value="item.Id"  type="checkbox" name="group[]" ng-checked="item.checked" ng-click="chgcheck(item.Id)">
                                        <div class="checkdiv {{item.checked?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                                        <span>{{item.name}}</span>        <!--复选框-->
                                    </div>
                                </label><br>
                                <button type="button" class="js-cancel-select btn btn-primary" ng-click="cancelSelect('areacheck',1)"><?= Yii::t('app','全部选中')?></button>
                                <button type="button" class="js-cancel-select btn btn-default" ng-click="cancelSelect('areacheck',0)"><?= Yii::t('app','取消全部')?></button>
                            </div>
                        </div>
                    </div>
                    <label class="radio-inline {{regionDisable?'disable':''}}">
                        <div class="radiodiv">
                            <input value="group" id="cityselect_0" type="radio" name="cityselect" checked="checked" ng-model="deepgroupcheck">
                            <div class="checkdiv {{deepgroupcheck=='group'?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                            <span><?= Yii::t('app','装瓶集团'); ?></span>
                        </div>
                    </label>
                    <label class="radio-inline {{factoryDisable?'disable':''}}">
                        <div class="radiodiv">
                            <input value="factory" id="cityselect_1" type="radio" name="cityselect"  ng-model="deepgroupcheck">
                            <div class="checkdiv {{deepgroupcheck=='factory'?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                            <span><?= Yii::t('app','装瓶厂'); ?></span>
                        </div>
                    </label>
                    <label class="radio-inline">
                        <div class="radiodiv">
                            <input value="city" id="cityselect_2" type="radio" name="cityselect"  ng-model="deepgroupcheck">
                            <div class="checkdiv {{deepgroupcheck=='city'?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                            <span><?= Yii::t('app','城市'); ?></span>
                        </div>
                    </label>
                </li>
                <li class="col-md-5">
                    <div class="weidu-item-box">
                        <div class="sel-con b" >
                            <label class="checkbox-inline checkboxdiv" ng-repeat="item in skus" ng-if="deepbrandcheck == 'catalog' && (category=='0' ? (item.depth == 1):(category==2 && item.parent==2 && (item.depth==0 || item.depth==2)))">
                                <div class="checkboxdiv">
                                    <input ng-value="item.Id"  type="checkbox" name="category[]" ng-checked="item.checked" ng-click="skuchgcheck(item.Id)">
                                    <div class="checkdiv {{item.checked?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                                    <span>{{item.name}}</span>
                                </div>
                            </label>
                            <label class="checkbox-inline checkboxdiv" ng-repeat="item in skus" ng-if="deepbrandcheck == 'brand' && ( (item.depth==2&&((item.parent==category||(item.parent==6||item.parent==33)&&category==2)||(brand==0&&category==0))) )">
                                <div class="checkboxdiv">
                                    <input ng-value="item.Id"  type="checkbox" name="category[]" ng-checked="item.checked" ng-click="skuchgcheck(item.Id)">
                                    <div class="checkdiv {{item.checked?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                                    <span>{{item.name}}</span>
                                </div>
                            </label><br>
                            <button type="button"  class="btn btn-primary js-cancel-select " ng-click="cancelSelect('brandcheck',1)"><?= Yii::t('app','全部选中')?></button>
                            <button type="button" class="js-cancel-select btn btn-default" ng-click="cancelSelect('brandcheck',0)"><?= Yii::t('app','取消全部')?></button>
                        </div>
                    </div>
                    <label class="radio-inline {{catalogDisable?'disable':''}}">
                        <div class="radiodiv">
                            <input ng-model="deepbrandcheck" ng-click="brandchg()" value="catalog" id="brandselect_0" checked="checked" type="radio" name="brandselect" class="ng-valid ng-dirty ng-touched ng-valid-parse">
                            <div class="checkdiv {{deepbrandcheck=='catalog'?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                            <span><?= Yii::t('app','品类'); ?></span>
                        </div>

                    </label>
                    <label class="radio-inline">
                        <div class="radiodiv">
                            <input ng-model="deepbrandcheck" ng-click="brandchg()" value="brand" id="brandselect_1" type="radio" name="brandselect" class="ng-valid ng-dirty ng-touched">
                            <div class="checkdiv {{deepbrandcheck=='brand'?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                            <span><?= Yii::t('app','品牌'); ?></span>
                        </div>

                    </label>
                </li>
            </ul>
            <div class="clearfix"></div>

        </div>

        <div class="export">
            <div class="btn btn-info" id="export-pdf" ng-click="exportpdf()"><?= Yii::t('app','导出报告'); ?></div>
            <div class="save-template btn btn-info" id="zjjhy" ng-click="openSave()"><?= Yii::t('app','另存为模板'); ?></div>
            <div class="dropdown" style="height: 36px;" ng-init="ajax_getTemplet()">
                <span data-toggle="dropdown" id="zhanbtn">
                    <?= Yii::t('app','展开模板'); ?>
                    <i class="caret"></i>
                </span>
                <ul class="dropdown-menu droptemlist dropdown-menu-right ">
                    <li><a style="color: #999;"><?= Yii::t('app','请选择'); ?></a></li>
                    <li ng-repeat="(name,data) in templetList" ng-click="getTemplet(name)"><a>{{name}}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="template">
        <div>
            <span><?= Yii::t('app','命名'); ?>：</span>
            <input type="text" ng-model="saveName" />
        </div>
        <div>
            <span><?= Yii::t('app','范围'); ?>：</span>
            <span id="ffww">{{head}}</span>
        </div>
        <div class="dimension" style="overflow: hidden;">
            <span style="float: left;"><?= Yii::t('app','维度'); ?>：</span>
            <p style="float: left;width: 80%;">
                <span><?= Yii::t('app','地区'); ?>：</span><span id="city_sx">{{middle1}}</span></br>
                <span class="dimension-brand"><?= Yii::t('app','分类'); ?>：</span><sapn class="pp_sx">{{middle2}}</sapn>
            </p>
        </div>
        <button class="save-file btn btn-info" ng-click="saveTemplet()" id="save_template"><?= Yii::t('app','保存'); ?></button>
    </div>

    <div ng-if="visitab == 'totalorders'" class="placing-match radius" id="chart-view">
        <?php
        $this->renderpartial("_chartheader", array(
            'kpi' => 'attach_rate',
            "btnleft" => Yii::t('app','配售率').Yii::t('app','比较'),
            "btnright" => Yii::t('app','配售率').Yii::t('app','趋势'),
            "lineleft" => Yii::t('app','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_barchart", array("kpi" => "attach_rate",'min'=>'0','max'=>'0'));
        $this->renderpartial("_linechart", array("kpi" => "attach_rate",'min'=>'0','max'=>'0.1'));
        $this->renderpartial("_barchart", array('kpi' => "attach_rate", 'lastrate' => 'Preceding_Attach_Rate','min'=>'-0.01','max'=>'0.01'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp1" ng-bind="month"></div>
    </div>
    <div ng-if="visitab == 'placingTotalOrderNumber'" class="placing-match radius" id="chart-view">

        <?php
        $this->renderpartial("_chartheader", array(
            'kpi' => 'placingTotalOrderNumber',
            "btnleft" => Yii::t('app','订单数量').Yii::t('app','比较'),
            "btnright" => Yii::t('app','订单数量').Yii::t('app','趋势'),
            "lineleft" => Yii::t('app','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_barchart", array("kpi" => "placingTotalOrderNumber",'min'=>'0','max'=>'0'));
        $this->renderpartial("_linechart", array("kpi" => "placingTotalOrderNumber",'min'=>'0','max'=>'17000000'));
        $this->renderpartial("_barchart", array('kpi' => "placingTotalOrderNumber", 'lastrate' => 'placingTotalOrderNumberRatio','min'=>'-0.6','max'=>'0.6'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp2" ng-bind="month"></div>
    </div>
    <div ng-if="visitab == 'visirate'" class="placing-match radius" id="chart-view">

        <?php
        $this->renderpartial("_chartheader", array(
            'kpi' => 'availability',
            "btnleft" => Yii::t('app','上线率').Yii::t('app','比较'),
            "btnright" => Yii::t('app','上线率').Yii::t('app','趋势'),
            "lineleft" => Yii::t('app','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_barchart", array("kpi" => "availability",'min'=>'0','max'=>'0.8'));
        $this->renderpartial("_linechart", array("kpi" => "availability",'min'=>'0','max'=>'1.2'));
        $this->renderpartial("_barchart", array('kpi' => "availability", 'lastrate' => 'Preceding_availability','min'=>'-0.1','max'=>'0.1'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp3" ng-bind="month"></div>
    </div>
    <div ng-if="visitab == 'numberOfSalesStores'" class="placing-match radius" id="chart-view">
        <?php
        $this->renderpartial("_chartheader", array(
            'kpi' => 'numberOfSalesStores',
            "btnleft" => Yii::t('app','门店数量').Yii::t('app','比较'),
            "btnright" => Yii::t('app','门店数量').Yii::t('app','趋势'),
            "lineleft" => "本期门店数量",
            "lineright" => "",
        ));
        $this->renderpartial("_barchart", array("kpi" => "numberOfSalesStores",'min'=>'0','max'=>'0'));
        $this->renderpartial("_linechart", array("kpi" => "numberOfSalesStores",'min'=>'0','max'=>'400000'));
        $this->renderpartial("_barchart", array('kpi' => "numberOfSalesStores", 'lastrate' => 'numberOfSalesStoresRatio','min'=>'-0.3','max'=>'0.3'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp4" ng-bind="month"></div>
    </div>
    <div ng-if="visitab == 'orders'" class="placing-match radius" id="chart-view">

        <?php
        $this->renderpartial("_chartheader", array(
            'kpi' => 'Incidence',
            "btnleft" => Yii::t('app','点购率').Yii::t('app','比较'),
            "btnright" => Yii::t('app','点购率').Yii::t('app','趋势'),
            "lineleft" => Yii::t('app','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_barchart", array("kpi" => "Incidence",'min'=>'0','max'=>'0.15'));
        $this->renderpartial("_linechart", array("kpi" => "Incidence",'min'=>'0','max'=>'0.16'));
        $this->renderpartial("_barchart", array('kpi' => "Incidence", 'lastrate' => 'Preceding_Incidence','min'=>'-0.1','max'=>'0.1'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp5" ng-bind="month"></div>

    </div>
    <div ng-if="visitab == 'opo'" class="placing-match radius" id="chart-view">
        <?php
        $this->renderpartial("_chartheader", array(
            'kpi' => 'opo',
            "btnleft" => Yii::t('app','店均点购订单数量').Yii::t('app','比较'),
            "btnright" => Yii::t('app','店均点购订单数量').Yii::t('app','趋势'),
            "lineleft" => Yii::t('app','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_barchart", array("kpi" => "opo",'min'=>'0','max'=>'0'));
        $this->renderpartial("_linechart", array("kpi" => "opo",'min'=>'0','max'=>'100'));
        $this->renderpartial("_barchart", array('kpi' => "opo", 'lastrate' => 'Preceding_opo','min'=>'-0.3','max'=>'0.3'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp6" ng-bind="month"></div>
    </div>
    <div class="clearfix"></div>
</div>




