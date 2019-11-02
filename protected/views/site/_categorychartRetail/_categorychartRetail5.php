<div class="chart-box" style="height: 523px;" ng-if="visitab=='store_number' && history.store_number==0" ng-init="setstackbaroption('store_number')">
<!--    <ng-echarts id="piecharts" class="echarts piecharts" ng-style="myObj" ec-config="pieConfig"-->
<!--                ec-option="baroption"-->
<!--                style="height: 490px;display: inline-block;"></ng-echarts>-->

    <ng-echarts class="echarts piecharts"
                style="width:10240px;text-align: center;height: 490px;display:inline-block;" ng-style="myObj"
                ec-config="pieConfig"
                ec-option="stackbaroption">
    </ng-echarts>
</div>