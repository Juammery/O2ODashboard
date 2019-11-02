<div class="chart-box" style="height: 523px;" ng-if="visitab=='distribution_store' && history.distribution_store=='0'" >
<!--    ng-init="setstackbaroption('distribution_store')"-->
<!--    <ng-echarts id="piecharts" class="echarts piecharts" ng-style="myObj" ec-config="pieConfig"-->
<!--                ec-option="baroption"-->
<!--                style="height: 490px;display: inline-block;"></ng-echarts>-->

    <ng-echarts class="echarts piecharts"
                style="min-width:5024px;text-align: center;height: 490px;display:inline-block;" ng-style="myObj"
                ec-config="pieConfig"
                ec-option="stackbaroption">
    </ng-echarts>
</div>