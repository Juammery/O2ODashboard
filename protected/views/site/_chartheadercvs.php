
<div style="text-align: center;height: 95px" >
    <?php
   if($btnleft)   echo BSHtml::button($btnleft,array('ng-click'=>"kpibtnchg('$kpi',0)",'class'=>"{{history.$kpi==0 || history.$kpi==2?'active':''}}"));
   if($btnright) echo BSHtml::button($btnright,array('id'=>'dp3','con'=>$btnright,'ng-click'=>"kpibtnchg('$kpi',1)",'class'=>"{{history.$kpi==1?'active':''}}"));
    ?>

    <div class="tabtitle" ng-if="history.<?=$kpi?> != 1">
        <span class=" {{history.<?=$kpi?> == 0 ?'active':''}}" id="dp1" con="<?=$btnleft.'1'?>" ng-click="kpibtnchg('<?=$kpi?>',0)"><b><?= Yii::t('cvs','本期值');?></b></span>
        <span class=" {{history.<?=$kpi?> == 2 ?'active':''}}" id="dp2" con="<?=$btnleft.'2'?>" style="margin-left:10px;" ng-click="kpibtnchg('<?=$kpi?>',2)"><b><?= Yii::t('cvs','变化率');?></b></span>
    </div>
</div>
<?php //echo empty($lineright)?'display:none':''?>