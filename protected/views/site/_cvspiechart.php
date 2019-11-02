<div class="col-md-3 qwe bs">
    <div class="bl">
        <div class="bl1"  ng-bind="(<?= $kpi ?> * 100 | number:2) + '%'"></div>
        <span class="vs">vs <?= Yii::t('app','上月')?></span>
        <div class="bl2">
            <span ng-if="<?= $kpirate ?> > 0">
                <span class="green"  ng-bind="(<?= $kpirate ?> * 100|number:2)+'%'"></span>
                <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
            </span>
            <span ng-if="<?= $kpirate ?> < 0">
                <span class="change" ng-bind="(<?= $kpirate ?> * 100|number:2)+'%'"></span>
                <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
            </span>                                
            <span ng-if="<?= $kpirate ?> == 0 || <?= $kpirate ?> == null">
                <?= Yii::t('app','无数据');?>
            </span>                                      

        </div>
    </div>
    <div  class="center-block">
        <ng-echarts class="echarts" ec-config="pieConfig" ec-option="<?= $kpiname ?>" style="width: 120px;height: 120px;margin: auto;"></ng-echarts>
        <div class="clearfix"></div>
    </div>
</div>