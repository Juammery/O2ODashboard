<?php
$ngif = "history." . $kpi . "==0";
//$max = 0.1;
//变化率也使用这个图表
if (isset($lastrate)) {
    $ngif = "history." . $kpi . "==2";
    $kpi = $lastrate;
    if (isset($lastrate2)) {
        $comparKpi = $lastrate2;
    }
//    $max = 0.1;
}
?>
<div class="chart-box" style="height: 523px;text-align: center;" ng-if="visitab=='price_promotion_ratio' && history.price_promotion_ratio==0">
    <ng-echarts id="piecharts" class="echarts piecharts lineBarPiecharts" ng-style="myObj" ec-config="pieConfig"
                ng-repeat="skuinfo in bardata1 track by $index"
                ng-init="setlinebaroption0(skuinfo.groupname,$index)"
                ec-option="linebaroption0list[$index]"
                ng-if="iscapacity == 'unchecked' && isbottle == 'unchecked'"
                style="width:600px;height: 460px;display:inline-block">
    </ng-echarts>
    <ng-echarts id="piecharts" class="echarts piecharts lineBarPiecharts" ng-style="myObj" ec-config="pieConfig"
                ng-repeat="skuinfo in bardata1 track by $index"
                ng-init="setlinebaroption0(skuinfo.groupname,$index)"
                ec-option="linebaroption0list[$index]"
                ng-if="iscapacity == 'ischecked' && isbottle == 'unchecked'"
                style="width:600px;height: 460px;display:inline-block">
    </ng-echarts>
    <ng-echarts id="piecharts" class="echarts piecharts lineBarPiecharts" ng-style="myObj" ec-config="pieConfig"
                ng-repeat="skuinfo in bardata1 track by $index"
                ng-init="setlinebaroption0(skuinfo.groupname,$index)"
                ec-option="linebaroption0list[$index]"
                ng-if="iscapacity == 'unchecked' && isbottle == 'ischecked'"
                style="width:600px;height: 460px;display:inline-block">
    </ng-echarts>
    <div class="clearfix"></div>
</div>