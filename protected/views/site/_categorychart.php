<div class="chart-box" style="height: 480px;text-align: center;" ng-if="history.<?=$kpi?>==0">
     <div  style="width: 100%;height: 95%;text-align: center;">
            <ng-echarts id="piecharts" class="echarts piecharts" ng-style="myObj" ec-config="pieConfig" ec-option="setstackbaroption('<?=$kpi?>')" style="height: 100%;display: inline-block;"></ng-echarts>
     </div>
</div>