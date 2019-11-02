
<div class="chart-box" style="height: 480px; text-align: center"  ng-if="history.<?=$kpi?>==1">
    <div  style="display:inline-block;">
    <ng-echarts class="echarts" ec-config="pieConfig" ec-option="setlineoption('<?= $kpi ?>',skuinfo.relationship.Id,'<?= $min ?>','<?= $max ?>')" style="width: 560px;height: 460px;display:inline-block" ng-repeat="skuinfo in allskuinfos['bar']"
                ng-if="relations[skuinfo.relationship.Id]['checked'] && relations[skuinfo.relationship.Id]['show']">
    </ng-echarts>

    <div class="clearfix"></div>
    </div>
</div>