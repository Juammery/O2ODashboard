<div class="chart-box up-down" style="height: 523px; text-align: center" ng-if="history.<?= $kpi ?>==1" when-scrolled="myFunction1()">
    <div style="min-height: 530px;">
        <ng-echarts class="echarts" ec-config="pieConfig"
                    ec-option="setlineoption('<?= $kpi ?>',skuinfo.relation.id,skuinfo.system.id,skuinfo.platform.id,skuinfo.cityLevel.id)"
                    style="width:470px;height: 460px;display:inline-block"
                    ng-repeat="skuinfo in all_skuinfos.bar track by $index"
                    ng-if="(iscapacity == 'unchecked' && isbottle == 'unchecked')&&(relations[skuinfo.relation.id]['checked']==1 && relations[skuinfo.relation.id]['show'] && systems[skuinfo.system.id].checked==1 && platforms[skuinfo.platform.id].checked==1 && cityLevelList[skuinfo.cityLevel.id].checked==1)">
        </ng-echarts>
        <ng-echarts class="echarts" ec-config="pieConfig"
                    ec-option="setlineoption('<?= $kpi ?>',skuinfo.relation.id,skuinfo.system.id,skuinfo.platform.id,skuinfo.cityLevel.id,skuinfo.skuname.id)"
                    style="width:470px;height: 460px;display:inline-block"
                    ng-repeat="skuinfo in all_skuinfos.bar track by $index"
                    ng-if="(iscapacity == 'ischecked' && isbottle == 'unchecked')&&(relations[skuinfo.relation.id]['checked']==1 && relations[skuinfo.relation.id]['show'] && systems[skuinfo.system.id].checked==1 && platforms[skuinfo.platform.id].checked==1 &&cityLevelList[skuinfo.cityLevel.id].checked==1 && total[skuinfo.skuname.id].checked==1)">
        </ng-echarts>
        <ng-echarts class="echarts" ec-config="pieConfig"
                    ec-option="setlineoption('<?= $kpi ?>',skuinfo.relation.id,skuinfo.system.id,skuinfo.platform.id,skuinfo.cityLevel.id,skuinfo.skuname.id)"
                    style="width:470px;height: 460px;display:inline-block"
                    ng-repeat="skuinfo in all_skuinfos.bar track by $index"
                    ng-if="(iscapacity == 'unchecked' && isbottle == 'ischecked')&&(relations[skuinfo.relation.id]['checked']==1 && relations[skuinfo.relation.id]['show'] && systems[skuinfo.system.id].checked==1 && platforms[skuinfo.platform.id].checked==1 && cityLevelList[skuinfo.cityLevel.id].checked==1 && total[skuinfo.skuname.id].checked==1)">
        </ng-echarts>
        <div class="clearfix"></div>
    </div>
</div>