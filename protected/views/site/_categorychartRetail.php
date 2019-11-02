<div class="chart-box pile-draw left-right" style="height: 523px;" ng-if="history.<?= $kpi ?>==0" around-scrolled="myFunction1()">
    <div class="chart-box-div">
        <ng-echarts id="piecharts" class="echarts piecharts" ng-style="myObj" ec-config="pieConfig"
                    ec-option="setstackbaroption('<?= $kpi ?>')"
                    style="height: 490px;display: inline-block;">
        </ng-echarts>
        <div class="clearfix"></div>
    </div>
</div>