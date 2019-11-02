<div class="col-md-6 qwe bs">
    <div class="bl">
        <div class="bl1"  ng-bind="(ko_stores*1.0/stores*100 |number:1)+'%'" ng-cloak></div>
        <span class="vs" ng-cloak>vs 上月</span>
        <div class="bl2">
            <span ng-if="(ko_stores/stores-lastko_stores/laststores)>0" ng-cloak>
                <span class="green" ng-bind="((ko_stores/stores-lastko_stores/laststores)*100).toFixed(1) + '%'"></span>
                <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
            </span>
            <span ng-if="(ko_stores/stores-lastko_stores/laststores)<0" ng-cloak>
                <span class="change" ng-bind="((ko_stores/stores-lastko_stores/laststores)*100).toFixed(1) + '%'"></span>
                <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
            </span>
            <span ng-if="" ng-cloak>
                <?= Yii::t('cvs', 'N/A'); ?>
            </span>
        </div>
    </div>
    <div class="center-block">
        <ng-echarts class="echarts suspend" ec-config="pieConfig" ec-option="setBlendOption('<?= $kpiname ?>','<?= $comparName ?>')"></ng-echarts>
        <div class="clearfix"></div>
    </div>
    <div style="text-align:center;"><?= $intro ?><img src="<?=Yii::app()->request->baseUrl.'/images/plaint.png';?>" alt="解释说明" title="<?= $title ?>" class="rulePng"></div>
</div>