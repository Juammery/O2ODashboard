<?php
$ngif = "history." . $kpi . "==0";
//$max = 0.1;
//变化率也使用这个图表(移除了变化率功能，与本期合并显示变化率)
//if (isset($lastrate)) {
//    $ngif = "history." . $kpi . "==2";
//    $kpi = $lastrate;
//}
?>
<div style="height:523px;text-align: center;" id="scrollHeight" class="scrollHeight chart-box up-down" ng-if="<?php echo $ngif ?>" when-scrolled="myFunction1()">
    <div style="min-height: 530px;">
        <ng-echarts class="echarts" ec-config="pieConfig"
                    ec-option="setVerticalityBarOption('<?= $kpi ?>','<?= $lastrate ?>',skuinfo.relation.id,'<?= $min ?>','<?= $max ?>',skuinfo.system.id,skuinfo.platform.id,skuinfo.cityLevel.id)"
                    style="width:700px;height: 460px;display: inline-block;"
                    ng-repeat="skuinfo in allskuinfos.bar"
                    ng-if="(iscapacity == 'unchecked' && isbottle == 'unchecked')&&(relations[skuinfo.relation.id]['checked']==1 && relations[skuinfo.relation.id]['show'] &&systems[skuinfo.system.id].checked==1&&platforms[skuinfo.platform.id].checked==1&&cityLevelList[skuinfo.cityLevel.id].checked==1)">
        </ng-echarts>
        <ng-echarts class="echarts" ec-config="pieConfig"
                    ec-option="setVerticalityBarOption('<?= $kpi ?>','<?= $lastrate ?>',skuinfo.relation.id,'<?= $min ?>','<?= $max ?>',skuinfo.system.id,skuinfo.platform.id,skuinfo.cityLevel.id,skuinfo.skuname.id)"
                    style="width:700px;height: 460px;display: inline-block;"
                    ng-repeat="skuinfo in allskuinfos.bar track by $index"
                    ng-if="(iscapacity == 'ischecked' && isbottle == 'unchecked')&&(relations[skuinfo.relation.id]['checked']==1 && relations[skuinfo.relation.id]['show'] &&systems[skuinfo.system.id].checked==1&&platforms[skuinfo.platform.id].checked==1&&cityLevelList[skuinfo.cityLevel.id].checked==1&&total[skuinfo.skuname.id].checked==1)">
        </ng-echarts>
        <ng-echarts class="echarts" ec-config="pieConfig"
                    ec-option="setVerticalityBarOption('<?= $kpi ?>','<?= $lastrate ?>',skuinfo.relation.id,'<?= $min ?>','<?= $max ?>',skuinfo.system.id,skuinfo.platform.id,skuinfo.cityLevel.id,skuinfo.skuname.id)"
                    style="width:700px;height: 460px;display: inline-block;"
                    ng-repeat="skuinfo in allskuinfos.bar track by $index"
                    ng-if="(iscapacity == 'unchecked' && isbottle == 'ischecked')&&(relations[skuinfo.relation.id]['checked']==1 && relations[skuinfo.relation.id]['show'] &&systems[skuinfo.system.id].checked==1&&platforms[skuinfo.platform.id].checked==1&&cityLevelList[skuinfo.cityLevel.id].checked==1&&total[skuinfo.skuname.id].checked==1)">
        </ng-echarts>
        <div class="clearfix"></div>
    </div>
</div>