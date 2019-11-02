

<?php
$tabs = array(
//    array("label" => Yii::t('cvs','数据指标'), "class" => "biao-menu"),
    array("label" => Yii::t('cvs','铺货率'),"id"=>"cp1",'ng-click' => "tabchange('distribution')",'otype'=>'distribution', 'url' => "javascript:void(0)", "class" => "change-map {{visitab == 'distribution' ? 'active':''}}"),
    array("label" => Yii::t('cvs','KO当月活动发生率'),"id"=>"cp7", 'ng-click' => "tabchange('thematic_activity')", 'url' => "javascript:void(0)", "class" => "{{visitab == 'thematic_activity' ? 'active':''}}"),
    array("label" => Yii::t('cvs','KO二次陈列'),"id"=>"cp5", 'ng-click' => "tabchange('extra_displays')", 'url' => "javascript:void(0)", "class" => "{{visitab == 'extra_displays' ? 'active':''}}"),
    array("label" => Yii::t('cvs','排面占比'),"id"=>"cp3", 'ng-click' => "tabchange('sovi')",'otype'=>'sovi', 'url' => "javascript:void(0)", "class" => "change-map {{visitab == 'sovi' ? 'active':''}}"),
    array("label" => Yii::t('cvs','设备卖进率'),"id"=>"cp8", 'ng-click' => "tabchange('equipment_sales')", 'url' => "javascript:void(0)", "class" => "{{visitab == 'equipment_sales' ? 'active':''}}"),
    array("label" => Yii::t('cvs','铺货门店数'),"id"=>"cp2", 'ng-click' => "tabchange('distribution_stores')", 'url' => "javascript:void(0)", "class" => "{{visitab == 'distribution_stores' ? 'active':''}}"),
    array("label" => Yii::t('cvs','店均货架排面数'),"id"=>"cp4", 'ng-click' => "tabchange('shelf_number')", 'url' => "javascript:void(0)", "class" => "{{visitab == 'shelf_number' ? 'active':''}}"),
//    array("label" => Yii::t('cvs','零售价格店次占比'),"id"=>"cp6",'otype'=>'orders', 'url' => "javascript:void(0)", "class" => ""),
    array("label" => Yii::t('cvs','促销店次占比'),"id"=>"cp9", 'ng-click' => "tabchange('promotion')", 'url' => "javascript:void(0)", "class" => "{{visitab == 'promotion' ? 'active':''}}"),
);
echo BSHtml::nav("tabs", $tabs, array( "id" => 'deepdive',"class"=>"radius"));

?>
<div class="conta" xmlns="http://www.w3.org/1999/html">
    <div class="mapp radius" >
        <div class="weidu-box">
            <div class="wd-title">
                <?= Yii::t('cvs','比较维度');?>
            </div>
            <ul class="weidu-list">
                <li id="cityselect">
                    <div class="weidu-item-box">
                        <div class="sel-con a">
                            <div id="group">
                                <button type="button" class="js-cancel-select btn btn-primary" ng-click="cancelSelect('areacheck',1)"><?= Yii::t('cvs','全部选中');?></button>
                                <button type="button" class="js-cancel-select btn btn-default" ng-click="cancelSelect('areacheck',0)"><?= Yii::t('cvs','取消全部');?></button>
                                <br>
                                <label class="checkbox-inline" ng-repeat="item in relationss" ng-if="checkralationshow(item.Id)">
                                    <div class="checkboxdiv">
                                        <input ng-value="item.Id"  type="checkbox" name="group[]" ng-checked="item.checked" ng-click="chgcheck(item.Id)">
                                        <div class="checkdiv {{item.checked?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                                        <span>{{item.name}}</span>        <!--复选框-->
                                    </div>
                                </label><br>
                            </div>
                        </div>
                    </div>
                    <label class="radio-inline {{regionDisable?'disable':''}}">
                        <div class="radiodiv">
                            <input value="group" id="cityselect_0" type="radio" name="cityselect" checked="checked" ng-model="deepgroupcheck" ng-change="getChartsData()">
                            <div class="checkdiv {{deepgroupcheck=='group'?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                            <span><?= Yii::t('cvs','装瓶集团'); ?></span>
                        </div>
                    </label>
                    <label class="radio-inline {{factoryDisable?'disable':''}}">
                        <div class="radiodiv">
                            <input value="factory" id="cityselect_1" type="radio" name="cityselect" ng-change="getChartsData()"  ng-model="deepgroupcheck">
                            <div class="checkdiv {{deepgroupcheck=='factory'?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                            <span><?= Yii::t('cvs','装瓶厂'); ?></span>
                        </div>
                    </label>
                    <!--                    <label class="radio-inline">-->
                    <!--                        <div class="radiodiv">-->
                    <!--                            <input value="city" id="cityselect_2" type="radio" name="cityselect" ng-change="getChartsData()"  ng-model="deepgroupcheck">-->
                    <!--                            <div class="checkdiv {{deepgroupcheck=='city'?'active':''}}"><img src="--><?php //echo Yii::app()->baseUrl.'/images/duihao.png'; ?><!--" alt=""></div>-->
                    <!--                            <span>--><?//= Yii::t('cvs','城市'); ?><!--</span>-->
                    <!--                        </div>-->
                    <!--                    </label>-->
                </li>
                <li>
                    <div class="weidu-item-box">
                        <div class="sel-con b" >

                          <button type="button" class="js-cancel-select btn btn-primary" ng-click="cancelSelect('systemcheck',1)"><?= Yii::t('cvs','全部选中');?></button>
                          <button type="button" class="js-cancel-select btn btn-default" ng-click="cancelSelect('systemcheck',0)"><?= Yii::t('cvs','取消全部');?></button>
                          <br>
                            <label class="checkbox-inline checkboxdiv" ng-repeat="item in systems" ng-if="deepsystemcheck=='systemtype'&& item.depth==1">
                                <div class="checkboxdiv">
                                    <input ng-value="item.Id"  type="checkbox" ng-checked="item.checked" ng-click="syschgcheck(item.Id)">
                                    <div class="checkdiv {{item.checked?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                                    <span>{{item.name}}</span>
                                </div>
                            </label>
                            <label class="checkbox-inline checkboxdiv" ng-repeat="item in systems" ng-if="deepsystemcheck == 'system' && ( (item.depth==2&&systemtype!=0&&item.parent==systemtype)||(item.depth==2&&systemtype==0) )">
                                <div class="checkboxdiv">
                                    <input ng-value="item.Id"  type="checkbox" ng-checked="item.checked" ng-click="syschgcheck(item.Id)">
                                    <div class="checkdiv {{item.checked?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                                    <span>{{item.name}}</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <label class="radio-inline {{systemDisable?'disable':''}}">
                        <div class="radiodiv">
                            <input ng-model="deepsystemcheck" ng-change="getChartsData()" value="systemtype"  checked="checked" type="radio"  class="ng-valid ng-dirty ng-touched ng-valid-parse">
                            <div class="checkdiv {{deepsystemcheck=='systemtype'?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                            <span><?= Yii::t('cvs','系统类型'); ?></span>
                        </div>

                    </label>
                    <label class="radio-inline">
                        <div class="radiodiv">
                            <input ng-model="deepsystemcheck" ng-change="getChartsData()" value="system" type="radio"  class="ng-valid ng-dirty ng-touched">
                            <div class="checkdiv {{deepsystemcheck=='system'?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                            <span><?= Yii::t('cvs','客户系统'); ?></span>
                        </div>

                    </label>
                </li>
                <li  ng-if="skuvisible">
                    <div class="weidu-item-box">
                        <div class="sel-con c" >

                          <button type="button" class="js-cancel-select btn btn-primary" ng-click="cancelSelect('brandcheck',1)"><?= Yii::t('cvs','全部选中');?></button>
                          <button type="button" class="js-cancel-select btn btn-default" ng-click="cancelSelect('brandcheck',0)"><?= Yii::t('cvs','取消全部');?></button>
                          <br>

                            <label class="checkbox-inline checkboxdiv" ng-repeat="item in skuss" ng-if="deepbrandcheck == 'catalog' && (category=='0' ? (item.depth == 1):(category==2 && item.parent==2 && (item.depth==0 || item.depth==2)))">
                                <div class="checkboxdiv">
                                    <input ng-value="item.Id"  type="checkbox" ng-checked="item.checked" ng-click="skuchgcheck(item.Id)">
                                    <div class="checkdiv {{item.checked?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                                    <span>{{item.name}}</span>
                                </div>
                            </label>
                            <label class="checkbox-inline checkboxdiv" ng-repeat="item in skuss" ng-if="deepbrandcheck == 'brand' && ( (item.depth==2&&((item.parent==category)||(brand==0&&category==0))) )">
                                <div class="checkboxdiv">
                                    <input ng-value="item.Id"  type="checkbox" ng-checked="item.checked" ng-click="skuchgcheck(item.Id)">
                                    <div class="checkdiv {{item.checked?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                                    <span>{{item.name}}</span>
                                </div>
                            </label>
                            <label class="checkbox-inline checkboxdiv" ng-repeat="item in skuss" ng-if="deepbrandcheck == 'SKU'&&item.depth==3&&( (category==0&&brand==0)||(category!=0&&brand==0&&skus[item.parent].parent==category)||(brand!=0&&item.parent==brand) )">
                                <div class="checkboxdiv">
                                    <input ng-value="item.Id"  type="checkbox" ng-checked="item.checked" ng-click="skuchgcheck(item.Id)">
                                    <div class="checkdiv {{item.checked?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                                    <span>{{item.name}}</span>
                                </div>
                            </label>

                        </div>
                    </div>
                    <label class="radio-inline {{catalogDisable?'disable':''}}">
                        <div class="radiodiv" ng-show='!brandreadonly.category'>
                            <input ng-model="deepbrandcheck"  ng-change="getChartsData()" value="catalog" id="brandselect_0" checked="checked" type="radio" name="brandselect" class="ng-valid ng-dirty ng-touched ng-valid-parse">
                            <div class="checkdiv {{deepbrandcheck=='catalog'?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                            <span><?= Yii::t('cvs','品类'); ?></span>
                        </div>

                    </label>
                    <label class="radio-inline {{brandDisable?'disable':''}}">
                        <div class="radiodiv" ng-show='!brandreadonly.brand' >
                            <input ng-model="deepbrandcheck"   ng-change="getChartsData()" value="brand" id="brandselect_1" type="radio" name="brandselect" class="ng-valid ng-dirty ng-touched">
                            <div class="checkdiv {{deepbrandcheck=='brand'?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                            <span><?= Yii::t('cvs','品牌'); ?></span>
                        </div>
                    </label>
                    <label class="radio-inline">
                        <div class="radiodiv" ng-show='!brandreadonly.sku' >
                            <input ng-model="deepbrandcheck" ng-change="getChartsData()" value="SKU" id="brandselect_2" type="radio" name="brandselect" class="ng-valid ng-dirty ng-touched">
                            <div class="checkdiv {{deepbrandcheck=='SKU'?'active':''}}"><img src="<?php echo Yii::app()->baseUrl.'/images/duihao.png'; ?>" alt=""></div>
                            <span><?= Yii::t('cvs','SKU'); ?></span>
                        </div>
                    </label>
                </li>
            </ul>
            <div class="clearfix"></div>

        </div>

        <div class="export">
            <div class="btn btn-info" id="export-excel" ng-click="exportExcel()"><?= Yii::t('cvs','导出Excel'); ?></div>
            <div class="btn btn-info" id="export-pdf" ng-click="exportpdf()"><?= Yii::t('cvs','导出报告'); ?></div>
            <div class="save-template btn btn-info" id="zjjhy" ng-click="openSave()"><?= Yii::t('cvs','另存为模板'); ?></div>
            <div class="dropdown" style="height: 36px;">
                <span data-toggle="dropdown" id="zhanbtn">
                    <?= Yii::t('cvs','展开模板'); ?>
                    <i class="caret"></i>
                </span>
                <ul class="dropdown-menu droptemlist dropdown-menu-right ">
                    <li><a style="color: #999;"><?= Yii::t('cvs','请选择'); ?></a></li>
                    <li ng-repeat="(name,data) in templetList" ng-click="getTemplet(name)"><a>{{name}}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="template">
        <div>
            <span><?= Yii::t('cvs','命名'); ?>：</span>
            <input type="text" ng-model="saveName" />
        </div>
        <div>
            <span><?= Yii::t('cvs','范围'); ?>：</span>
            <span id="ffww">{{head}}</span>
        </div>
        <div class="dimension" style="overflow: hidden;">
            <span style="float: left;"><?= Yii::t('cvs','维度'); ?>：</span>
            <p style="float: left;width: 80%;">
                <span><?= Yii::t('cvs','地区'); ?>：</span><span id="city_sx">{{middle1}}</span></br>
                <span class="dimension-brand"><?= Yii::t('cvs','分类'); ?>：</span><sapn class="pp_sx">{{middle2}}</sapn>
            </p>
        </div>
        <button class="save-file btn btn-info" ng-click="saveTemplet()" id="save_template"><?= Yii::t('cvs','保存'); ?></button>
    </div>

    <div ng-if="visitab == 'distribution'" class="placing-match radius" id="chart-view">
        <?php
        $this->renderpartial("_chartheadercvs", array(
            'kpi' => 'distribution',
            "btnleft" => Yii::t('cvs','铺货率').Yii::t('cvs','比较'),
            "btnright" => Yii::t('cvs','铺货率').Yii::t('cvs','趋势'),
            "lineleft" => Yii::t('cvs','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_barchartcvs", array("kpi" => "distribution",'min'=>'0','max'=>'0.8'));
        $this->renderpartial("_linechartcvs", array("kpi" => "distribution",'min'=>'0','max'=>'1.2'));
        $this->renderpartial("_barchartcvs", array('kpi' => "distribution", 'lastrate' => 'Last_distribution_radio','min'=>'-0.1','max'=>'0.1'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp"></div>
        <button type="button" class="btn btn-primary sortcharts"  ng-bind="nosort" ng-click="chartsSort()"></button>
        <!-- <button type="button" class="btn btn-default deback" ng-click="deback()">返回</button> -->
    </div>
    <div ng-if="visitab == 'distribution_stores'" class="placing-match radius" id="chart-view">
        <?php
        $this->renderpartial("_chartheadercvs", array(
            'kpi' => 'distribution_stores',
            "btnleft" => Yii::t('cvs','铺货门店数').Yii::t('cvs','比较'),
            "btnright" => Yii::t('cvs','铺货门店数').Yii::t('cvs','趋势'),
            "lineleft" => Yii::t('cvs','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_categorychartcvs", array("kpi" => "distribution_stores"));
        $this->renderpartial("_linechartcvs", array("kpi" => "distribution_stores",'min'=>'0','max'=>'1000'));
        $this->renderpartial("_barchartcvs", array('kpi' => "distribution_stores", 'lastrate' => 'Last_distribution_stores_radio','min'=>'-0.3','max'=>'0.3'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp"></div>
        <button type="button" class="btn btn-primary sortcharts" ng-bind="nosort" ng-click="chartsSort()"></button>
        <!-- <button type="button" class="btn btn-default deback" ng-click="deback()">返回</button> -->
    </div>
    <div ng-if="visitab == 'sovi'" class="placing-match radius" id="chart-view">
        <?php
        $this->renderpartial("_chartheadercvs", array(
            'kpi' => 'sovi',
            "btnleft" => Yii::t('cvs','排面占比').Yii::t('cvs','比较'),
            "btnright" => Yii::t('cvs','排面占比').Yii::t('cvs','趋势'),
            "lineleft" => Yii::t('cvs','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_barchartcvs", array("kpi" => "sovi",'min'=>'0','max'=>'0.15'));
        $this->renderpartial("_linechartcvs", array("kpi" => "sovi",'min'=>'0','max'=>'0.16'));
        $this->renderpartial("_barchartcvs", array('kpi' => "sovi", 'lastrate' => 'Last_sovi_radio','min'=>'-0.1','max'=>'0.1'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp"></div>
        <button type="button" class="btn btn-primary sortcharts" ng-bind="nosort" ng-click="chartsSort()"></button>
        <!-- <button type="button" class="btn btn-default deback" ng-click="deback()">返回</button> -->
    </div>
    <div ng-if="visitab == 'shelf_number'" class="placing-match radius" id="chart-view">
        <?php
        $this->renderpartial("_chartheadercvs", array(
            'kpi' => 'shelf_number',
            "btnleft" => Yii::t('cvs','店均货架排面数').Yii::t('cvs','比较'),
            "btnright" => Yii::t('cvs','店均货架排面数').Yii::t('cvs','趋势'),
            "lineleft" => Yii::t('cvs','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_categorychartcvs", array("kpi" => "shelf_number"));
        $this->renderpartial("_linechartcvs", array("kpi" => "shelf_number",'min'=>'0','max'=>'100'));
        $this->renderpartial("_barchartcvs", array('kpi' => "shelf_number", 'lastrate' => 'Last_shelf_number_radio','min'=>'-0.3','max'=>'0.3'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp"></div>
        <button type="button" class="btn btn-primary sortcharts" ng-bind="nosort" ng-click="chartsSort()"></button>
        <!-- <button type="button" class="btn btn-default deback" ng-click="deback()">返回</button> -->
    </div>
    <div ng-if="visitab == 'extra_displays'" class="placing-match radius" id="chart-view">
        <?php
        $this->renderpartial("_chartheadercvs", array(
            'kpi' => 'extra_displays',
            "btnleft" => Yii::t('cvs','KO二次陈列').Yii::t('cvs','比较'),
            "btnright" => Yii::t('cvs','KO二次陈列').Yii::t('cvs','趋势'),
            "lineleft" => Yii::t('cvs','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_barchartcvs", array("kpi" => "extra_displays",'min'=>'0','max'=>'0.8'));
        $this->renderpartial("_linechartcvs", array("kpi" => "extra_displays",'min'=>'0','max'=>'100'));
        $this->renderpartial("_barchartcvs", array('kpi' => "extra_displays", 'lastrate' => 'Last_extra_displays_radio','min'=>'-0.3','max'=>'0.3'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp"></div>
        <button type="button" class="btn btn-primary sortcharts" ng-bind="nosort" ng-click="chartsSort()"></button>
        <!-- <button type="button" class="btn btn-default deback" ng-click="deback()">返回</button> -->
    </div>
    <div ng-if="visitab == 'price_anomaly'" class="placing-match radius" id="chart-view">
        <?php
        $this->renderpartial("_chartheadercvs", array(
            'kpi' => 'price_anomaly',
            "btnleft" => Yii::t('cvs','零售价格店次占比').Yii::t('cvs','比较'),
            "btnright" => Yii::t('cvs','零售价格店次占比').Yii::t('cvs','趋势'),
            "lineleft" => Yii::t('cvs','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_barchartcvs", array("kpi" => "price_anomaly",'min'=>'0','max'=>'0.8'));
        $this->renderpartial("_linechartcvs", array("kpi" => "price_anomaly",'min'=>'0','max'=>'100'));
        $this->renderpartial("_barchartcvs", array('kpi' => "price_anomaly", 'lastrate' => 'Last_price_anomaly_radio','min'=>'-0.3','max'=>'0.3'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp"></div>
        <button type="button" class="btn btn-primary sortcharts" ng-bind="nosort" ng-click="chartsSort()"></button>
        <!-- <button type="button" class="btn btn-default deback" ng-click="deback()">返回</button> -->
    </div>
    <div ng-if="visitab == 'thematic_activity'" class="placing-match radius" id="chart-view">
        <?php
        $this->renderpartial("_chartheadercvs", array(
            'kpi' => 'thematic_activity',
            "btnleft" => Yii::t('cvs','KO当月活动发生率').Yii::t('cvs','比较'),
            "btnright" => Yii::t('cvs','KO当月活动发生率').Yii::t('cvs','趋势'),
            "lineleft" => Yii::t('cvs','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_barchartcvs", array("kpi" => "thematic_activity",'min'=>'0','max'=>'0.8'));
        $this->renderpartial("_linechartcvs", array("kpi" => "thematic_activity",'min'=>'0','max'=>'100'));
        $this->renderpartial("_barchartcvs", array('kpi' => "thematic_activity", 'lastrate' => 'Last_thematic_activity_radio','min'=>'-0.3','max'=>'0.3'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp"></div>
        <button type="button" class="btn btn-primary sortcharts" ng-bind="nosort" ng-click="chartsSort()"></button>
        <!-- <button type="button" class="btn btn-default deback" ng-click="deback()">返回</button> -->
    </div>
    <div ng-if="visitab == 'promotion'" class="placing-match radius" id="chart-view">

        <?php
        $this->renderpartial("_chartheadercvs", array(
            'kpi' => 'promotion',
            "btnleft" => Yii::t('cvs','促销店次占比').Yii::t('cvs','比较'),
            "btnright" => Yii::t('cvs','促销店次占比').Yii::t('cvs','趋势'),
            "lineleft" => Yii::t('cvs','本期值'),
            "lineright" => "",
        ));
        $this->renderpartial("_barchartcvs", array("kpi" => "promotion",'min'=>'0','max'=>'0.8'));
        $this->renderpartial("_linechartcvs", array("kpi" => "promotion",'min'=>'0','max'=>'100'));
        $this->renderpartial("_barchartcvs", array('kpi' => "promotion", 'lastrate' => 'Last_promotion_radio','min'=>'-0.3','max'=>'0.3'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp"></div>
        <button type="button" class="btn btn-primary sortcharts" ng-bind="nosort" ng-click="chartsSort()"></button>
        <!-- <button type="button" class="btn btn-default deback" ng-click="deback()">返回</button> -->
    </div>
    <div ng-if="visitab == 'equipment_sales'" class="placing-match radius" id="chart-view">
        <?php
        $this->renderpartial("_chartheadercvs", array(
            'kpi' => 'equipment_sales',
            "btnleft" => '',// Yii::t('cvs','设备卖进率').Yii::t('cvs','比较'),
            "btnright" => Yii::t('cvs','设备卖进率').Yii::t('cvs','趋势'),
            "lineleft" => '', //Yii::t('cvs','本期值'),
            "lineright" => "",
        ));
        //$this->renderpartial("_barchartcvs", array("kpi" => "equipment_sales",'min'=>'0','max'=>'0.8'));
        $this->renderpartial("_linechartcvs", array("kpi" => "equipment_sales",'min'=>'0','max'=>'100'));
      //  $this->renderpartial("_linechartcvs", array("kpi" => "equipment_sales",'min'=>'0','max'=>'100'));
      //  $this->renderpartial("_linechartcvs", array("kpi" => "equipment_sales",'min'=>'0','max'=>'100'));
        //$this->renderpartial("_barchartcvs", array('kpi' => "equipment_sales", 'lastrate' => 'Last_equipment_sales_radio','min'=>'-0.3','max'=>'0.3'));
        ?>
        <div class="right-bottom-export js-rb-export" title="导出该模块" t="cp"></div>
        <button type="button" class="btn btn-primary sortcharts" ng-bind="nosort" ng-click="chartsSort()"></button>
        <!-- <button type="button" class="btn btn-default deback" ng-click="deback()">返回</button> -->
    </div>

    <div class="clearfix"></div>
</div>
