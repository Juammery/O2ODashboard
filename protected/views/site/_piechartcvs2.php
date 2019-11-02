<div class="col-md-6 qwe bs" ng-repeat="item in kopciinfos.koandpcis[pieLeftId]" ng-if="<?= $visible ?>">
    <div class="bl">
        <div class="bl1"  ng-bind="(<?= $kpi ?> * 100 | number:2) + '%'"></div>
        <span class="vs">vs {{labels.lastvalue}}</span>
        <div class="bl2">
            <span ng-if="<?= $kpirate ?> > 0">
                <span class="green"  ng-bind="(<?= $kpirate ?> * 100|number:2)+'%'"></span>
                <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
            </span>
            <span ng-if="<?= $kpirate ?> < 0">
                <span class="change" ng-bind="(<?= $kpirate ?> * 100|number:2)+'%'"></span>
                <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
            </span>
            <span ng-if="<?= $kpirate ?> == 0">
                <span class="change" ng-bind="(<?= $kpirate ?> * 100|number:2)+'%'"></span>
                <img style="width: 11px;height: 3px;" src="<?php echo Yii::app()->baseUrl?>/images/balance.png">
            </span>
            <span ng-if="<?= $kpirate ?> == null">
                <?= Yii::t('cvs','无数据');?>
            </span>      
        </div>
    </div>
    <div  class="center-block">
        <ng-echarts class="echarts" ec-config="pieConfig" ec-option="setpieoption(<?= $kpi ?>)" style="width: 120px;height: 120px;margin: auto;"></ng-echarts>
        <div class="clearfix"></div>
    </div>
    <div style="text-align:center;">{{<?= $intro ?>}}</div>
</div>     