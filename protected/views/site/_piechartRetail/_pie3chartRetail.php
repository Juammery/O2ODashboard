<!--'kpiname' => "pie1",-->
<!--'comparName' => Yii::t('cvs', "网店数"),-->
<!--'kpi' => 'kopciinfos.koandpcis.enrollment',-->
<!--'kpirate' => 'kopciinfos.koandpcis.last_enrollment',-->
<!--'intro' => Yii::t('cvs', '网店上线率'),-->
<!--'title' => Yii::t('cvs', '该数据范围内网店数（不同平台之间未打通，即1家线下门店在3个平台上线算3家网店）/该数据范围内线下门店数*3（与网店未打通计算方式保持一致）'),-->


<div class="col-md-6 qwe bs">
    <div class="bl">
        <div class="bl1"  ng-bind="((kosales*1.0/nartdsales*100) |number:1)+'%'" ng-cloak></div>
        <span class="vs" ng-cloak>vs 上月</span>
        <div class="bl2">
            <span ng-if="(kosales/nartdsales-lastkosales/lastnartdsales)>0" ng-cloak>
                <span class="green" ng-bind="((kosales/nartdsales-lastkosales/lastnartdsales)*100).toFixed(1) + '%'"></span>
                <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
            </span>
            <span ng-if="(kosales/nartdsales-lastkosales/lastnartdsales)<0" ng-cloak>
                <span class="change" ng-bind="((kosales/nartdsales-lastkosales/lastnartdsales)*100).toFixed(1) + '%'"></span>
                <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
            </span>
            <span ng-if="lastkosales==null" ng-cloak>
                <?= Yii::t('cvs', 'N/A'); ?>
            </span>
        </div>
    </div>
    <div class="center-block">
        <ng-echarts class="echarts suspend" ec-config="pieConfig" ec-option="setBlendOption('pie3','<?= $comparName ?>')"></ng-echarts>
        <div class="clearfix"></div>
    </div>
    <div style="text-align:center;"><?= $intro ?><img src="<?=Yii::app()->request->baseUrl.'/images/plaint.png';?>" alt="解释说明" title="<?= $title ?>" class="rulePng"></div>
</div>