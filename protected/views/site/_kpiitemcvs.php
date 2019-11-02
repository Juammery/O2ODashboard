
<div class="lattice" ng-if="<?=$visitab?>">
    <div class="kpititle"><?= $kpiname ?></div>
    <div class="row">
        <div class="col-md-9 this-month bs" style="width:74.8%;display:inline-block;">
            <span>{{labels.thisvalue}}</span>
            <div class="progress transparent-pro">
                <div class='progress-bar jidutiao {{<?= $kpi["value"]; ?>/<?= $kpi["lastvalue"]; ?>>1?"width50":<?= $kpi["value"]; ?>/<?= $kpi["lastvalue"]; ?><0.85?"width40":"width45"}}' role="progressbar"
                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                </div>
                <span ng-if="<?= $kpi["value"]; ?> != null" ng-bind="<?= $kpi["precent"]; ?>=='1'?((<?= $kpi["value"]; ?>*100|number:2)+'%'):(<?= $kpi["value"]; ?>|number:1)"></span>
                <span class="change" ng-if="<?= $kpi["value"]; ?> == null" ng-bind="nodata"></span>
            </div>
            <span>{{labels.lastvalue}}</span>
            <div class="progress transparent-pro">
                <div class='progress-bar jidutiao1 {{<?= $kpi["lastvalue"]; ?>/<?= $kpi["value"]; ?>>1?"width50":<?= $kpi["lastvalue"]; ?>/<?= $kpi["value"]; ?><0.85?"width40":"width45"}}' role="progressbar"
                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                </div>
                <span ng-if="<?= $kpi["lastvalue"]; ?> != null" ng-bind="<?= $kpi["precent"]; ?>=='1'?((<?= $kpi["lastvalue"]; ?>*100| number:2)+'%'):(<?= $kpi["lastvalue"]; ?>|number:1)"></span>
                <span class="change" ng-if="<?= $kpi["lastvalue"]; ?> == null" ng-bind="nodata"></span>                                         

            </div>
        </div>
        <div class="col-md-3 last-month bs" style="width:24%;float:right;">
           
            <span ng-if="<?= $kpi["changerate"]; ?> > 0">
                <span class="last-month-compare">{{labels.lastcompare}}</span></br>
                <span class="green" ng-bind="(<?= $kpi["changerate"]; ?> * 100|number:2)+'%'" ></span>
                <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
            </span>
            <span ng-if="<?= $kpi["changerate"]; ?> != null && <?= $kpi["changerate"]; ?> < 0">
                <span class="last-month-compare">{{labels.lastcompare}}</span></br>
                <span class="change" ng-bind="(<?= $kpi["changerate"]; ?> * 100|number:2)+'%'"></span>
                <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
            </span>
            <span ng-if="<?= $kpi["changerate"]; ?> == 0">
                <span class="last-month-compare">{{labels.lastcompare}}</span></br>
                <span class="green" ng-bind="(<?= $kpi["changerate"]; ?> * 100|number:2)+'%'"></span>
                <img src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
            </span>
            <span ng-if="<?= $kpi["changerate"]; ?> == null" ng-bind="nodata"></span>     


        </div>
    </div>
</div>