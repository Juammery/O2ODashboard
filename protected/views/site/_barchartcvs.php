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

<div  style="height: 480px; text-align: center" class="chart-box"  ng-if="<?php echo $ngif ?>" >
    <div  style="display:inline-block;">
    <ng-echarts class="echarts" ec-config="pieConfig" ec-option="setbaroption('<?= $kpi ?>',skuinfo.relationship.Id,'<?= $min ?>','<?= $max ?>',skuinfo.system.Id)" style="width:410px;height: 460px;display: inline-block;text-align: center;" ng-repeat="(key,skuinfo) in allskuinfos.bar"
                ng-if="relations[skuinfo.relationship.Id]['checked']==1 && relations[skuinfo.relationship.Id]['show']&&systems[skuinfo.system.Id].checked==1">
    </ng-echarts>

    <div class="clearfix"></div>
    </div>
</div>