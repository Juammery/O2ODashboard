<?php
$ngif = "history." . $kpi . "==0";
//$max = 0.1;
//变化率也使用这个图表
if (isset($lastrate)) {
    $ngif = "history." . $kpi . "==2";
    $kpi = $lastrate;
//    $max = 0.1;
}
?>
<div style="height:523px;text-align: center;" class="chart-box" ng-if="visitab=='store_money' && history.store_money==0">
    <ng-echarts ng-repeat="skuinfo in bardata1 track by $index" class="echarts"
                ng-if="(iscapacity == 'unchecked' && isbottle == 'unchecked')"
                ng-init="test(skuinfo.groupname,$index)"
                style="width:470px;height: 460px;display: inline-block;"
                ec-config="pieConfig"
                ec-option="baroptionlist[$index]">
    </ng-echarts>
<!--        选择了容量分级-->
    <ng-echarts ng-repeat="skuinfo in bardata1 track by $index" class="echarts"
                ng-if="(iscapacity == 'ischecked' && isbottle == 'unchecked')"
                style="width:470px;height: 460px;display: inline-block;"
                ng-init="test(skuinfo.groupname,$index)"
                ec-config="pieConfig"
                ec-option="baroptionlist[$index]">
    </ng-echarts>
<!--        选择了瓶量分级-->
    <ng-echarts ng-repeat="skuinfo in bardata1 track by $index" class="echarts"
                ng-if="(iscapacity == 'unchecked' && isbottle == 'ischecked')"
                style="width:470px;height: 460px;display: inline-block;"
                ng-init="test(skuinfo.groupname,$index)"
                ec-config="pieConfig"
                ec-option="baroptionlist[$index]">
    </ng-echarts>
    <div class="clearfix"></div>
</div>