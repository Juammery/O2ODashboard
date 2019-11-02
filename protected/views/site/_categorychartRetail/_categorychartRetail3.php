<div class="chart-box" style="height: 523px;" ng-if="visitab=='average_purchase_price' && history.average_purchase_price==0" ng-init="setstackbaroption('average_purchase_price')">
<!--    <ng-echarts id="piecharts" class="echarts piecharts" ng-style="myObj" ec-config="pieConfig"-->
<!--                ec-option="baroption"-->
<!--                style="height: 490px;display: inline-block;"></ng-echarts>-->

    <ng-echarts class="echarts piecharts"
                style="width:10240px;text-align: center;height: 490px;display:inline-block;" ng-style="myObj"
                ec-config="pieConfig"
                ec-option="stackbaroption">
    </ng-echarts>
</div>