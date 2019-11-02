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
<!--ng-if="--><?php //echo $ngif ?>
<div style="height:523px;text-align: center;" class="chart-box" ng-if="visitab=='distribution' && history.distribution==0">
<!--    容量分级和瓶量分级都未选-->
<!--    <ng-echarts class="echarts" ec-config="pieConfig"-->
<!--         ec-option="te('--><?//= $kpi ?><!--','--><?//= $min ?><!--','--><?//= $max ?><!--')"-->
<!--         style="width:410px;height:460px;display:inline-block;background-color:blue;margin:10px;"-->
<!--         ng-repeat="skuinfo in bardata1 track by $index"-->
<!--         ng-if="(iscapacity == 'unchecked' && isbottle == 'unchecked')">-->
<!--    </ng-echarts>-->
<!--    ng-init="test(skuinfo.groupname,$index)"-->
<!--    ng-init="test(skuinfo.groupname,$index)"-->
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