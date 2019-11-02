<div class="chart-box up-down" style="height: 523px; text-align: center"  ng-if="history.distribution==1 && visitab=='distribution'" when-scrolled="myFunction1()">
    <div style="min-height: 530px;">
        <ng-echarts class="echarts" ec-config="pieConfig"
                    ng-repeat="skuinfo in bardata1 track by $index"
                    ng-init="setlineoption(skuinfo.groupname,$index)"
                    ec-option="lineoptionlist[$index]"
                    style="width:470px;height: 460px;display:inline-block"
                    ng-if="iscapacity == 'unchecked' && isbottle == 'unchecked'">
        </ng-echarts>
        <ng-echarts class="echarts" ec-config="pieConfig"
                    ng-repeat="skuinfo in bardata1 track by $index"
                    ng-init="setlineoption(skuinfo.groupname,$index)"
                    ec-option="lineoptionlist[$index]"
                    style="width:470px;height: 460px;display:inline-block"
                    ng-if="iscapacity == 'ischecked' && isbottle == 'unchecked'">
        </ng-echarts>
        <ng-echarts class="echarts" ec-config="pieConfig"
                    ng-repeat="skuinfo in bardata1 track by $index"
                    ng-init="setlineoption(skuinfo.groupname,$index)"
                    ec-option="lineoptionlist[$index]"
                    style="width:470px;height: 460px;display:inline-block"
                    ng-if="iscapacity == 'unchecked' && isbottle == 'ischecked'">
        </ng-echarts>
<!--        <ng-echarts class="echarts" ec-config="pieConfig"-->
<!--                    ec-option="lineoption"-->
<!--                    style="width:470px;height: 460px;display:inline-block">-->
<!--        </ng-echarts>-->
        <div class="clearfix"></div>
    </div>
</div>