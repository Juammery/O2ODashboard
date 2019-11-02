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
<div class="chart-box up-down" style="height: 523px;text-align: center;" ng-if="<?php echo $ngif ?>" when-scrolled="myFunction1()">
    <div style="min-height: 530px;">
        <ng-echarts id="piecharts" class="echarts piecharts lineBarPiecharts" ng-style="myObj" ec-config="pieConfig"
                    ec-option="setlineBaroption('<?= $kpi ?>','<?= $comparKpi ?>',skuinfo.relation.id,skuinfo.system.id,skuinfo.platform.id,skuinfo.cityLevel.id)"
                    ng-if="(iscapacity == 'unchecked' && isbottle == 'unchecked')&&(relations[skuinfo.relation.id]['checked']==1 && relations[skuinfo.relation.id]['show']&& cityLevelList[skuinfo.cityLevel.id]['checked']==1 && systems[skuinfo.system.id].checked==1 && platforms[skuinfo.platform.id].checked==1 && cityLevelList[skuinfo.cityLevel.id].checked==1)"
                    style="width:750px;height: 460px;display:inline-block"
                    ng-repeat="skuinfo in allskuinfos.bar track by $index">
        </ng-echarts>
        <ng-echarts id="piecharts" class="echarts piecharts lineBarPiecharts" ng-style="myObj" ec-config="pieConfig"
                    ec-option="setlineBaroption('<?= $kpi ?>','<?= $comparKpi ?>',skuinfo.relation.id,skuinfo.system.id,skuinfo.platform.id,skuinfo.cityLevel.id,skuinfo.skuname.id)"
                    ng-if="(iscapacity == 'ischecked' && isbottle == 'unchecked')&&(relations[skuinfo.relation.id]['checked']==1 && relations[skuinfo.relation.id]['show']&& cityLevelList[skuinfo.cityLevel.id]['checked']==1 && systems[skuinfo.system.id].checked==1 && platforms[skuinfo.platform.id].checked==1 && cityLevelList[skuinfo.cityLevel.id].checked==1 && total[skuinfo.skuname.id].checked==1)"
                    style="width:750px;height: 460px;display:inline-block"
                    ng-repeat="skuinfo in allskuinfos.bar track by $index">
        </ng-echarts>
        <ng-echarts id="piecharts" class="echarts piecharts lineBarPiecharts" ng-style="myObj" ec-config="pieConfig"
                    ec-option="setlineBaroption('<?= $kpi ?>','<?= $comparKpi ?>',skuinfo.relation.id,skuinfo.system.id,skuinfo.platform.id,skuinfo.cityLevel.id,skuinfo.skuname.id)"
                    ng-if="(iscapacity == 'unchecked' && isbottle == 'ischecked')&&(relations[skuinfo.relation.id]['checked']==1 && relations[skuinfo.relation.id]['show']&& cityLevelList[skuinfo.cityLevel.id]['checked']==1 && systems[skuinfo.system.id].checked==1 && platforms[skuinfo.platform.id].checked==1 && cityLevelList[skuinfo.cityLevel.id].checked==1 && total[skuinfo.skuname.id].checked==1)"
                    style="width:750px;height: 460px;display:inline-block"
                    ng-repeat="skuinfo in allskuinfos.bar track by $index">
        </ng-echarts>
        <div class="clearfix"></div>
    </div>
</div>