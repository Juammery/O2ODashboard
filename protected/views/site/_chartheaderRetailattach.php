
<div style="text-align: center;height: 80px">
    <?php
    if($btnleft) echo BSHtml::button($btnleft,array('ng-click'=>"kpibtnchg('$kpi',0)",'class'=>"{{history.$kpi==0 || history.$kpi==2?'active':''}}"));
    if($btnright) echo BSHtml::button($btnright,array('id'=>'dp3','con'=>$btnright,'ng-click'=>"kpibtnchg('$kpi',1)",'class'=>"{{history.$kpi==1?'active':''}}"));
    ?>
</div>