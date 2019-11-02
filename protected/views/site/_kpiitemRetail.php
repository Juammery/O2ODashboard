<div class="lattice">
    <div class="row"  style="margin-bottom: 5px;">
        <div class="col-md-12 this-month bs" style="display:inline-block;">
            <div class="kpititle" style="padding-left: 10px;">
                <span ng-bind="<?=$time?> | reverse"></span>
                &nbsp;<b style="color: red" ng-bind="<?=$site?>"></b>
                &nbsp;<?= $kpiname ?><img src="<?=Yii::app()->request->baseUrl.'/images/plaint.png';?>" alt="解释说明" title="<?= $title ?>" class="rulePng">
            </div>
            <span ng-cloak>NARTD</span>
            <div style="display: flex">
                <div class="progress transparent-pro">
                    <div class='progress-bar jidutiao' role="progressbar"
                         aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                         style="width: {{(<?= $kpi["NARTD_value"] > $kpi["ko_value"]; ?>)?((<?= $kpi["NARTD_value"]; ?>/<?= $kpi["NARTD_value"]; ?>)*100):((<?= $kpi["NARTD_value"]; ?>/<?= $kpi["ko_value"]; ?>)*100)}}%">
                        <span ng-if="<?= $kpi["NARTD_value"]; ?> != null" ng-bind="(<?= $kpi["NARTD_value"]; ?>|numParsh)"></span>
                        <span class="change" ng-if="<?= $kpi["NARTD_value"]; ?> == null" ng-bind="nodata"></span>
                    </div>
                </div>
                <!--变化率-->
                <span ng-if="<?= $kpi["NARTD_changerate"]; ?> > 0" ng-cloak style="padding-left: 5px;">
                    <span class="green" ng-bind="((<?= $kpi["NARTD_changerate"]; ?>>1||<?= $kpi["NARTD_changerate"]; ?><-1)?(<?= $kpi["NARTD_changerate"]; ?>|numParsh):(<?= $kpi["NARTD_changerate"]; ?>|numParsh)) + ' pts '" ></span>
                    <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                </span>
                <span ng-if="<?= $kpi["NARTD_changerate"]; ?> != null && <?= $kpi["NARTD_changerate"]; ?> < 0"  style="padding-left: 5px;" ng-cloak>
                    <span class="change" ng-bind="((<?= $kpi["NARTD_changerate"]; ?>>1||<?= $kpi["NARTD_changerate"]; ?><-1)?(<?= $kpi["NARTD_changerate"]; ?>|numParsh):(<?= $kpi["NARTD_changerate"]; ?>|numParsh)) + ' pts '" ></span>
                    <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                </span>
                <span ng-if="<?= $kpi["NARTD_changerate"]; ?> == 0" style="padding-left: 5px;" ng-cloak>
                    <span class="green" ng-bind="((<?= $kpi["NARTD_changerate"]; ?>>1||<?= $kpi["NARTD_changerate"]; ?><-1)?(<?= $kpi["NARTD_changerate"]; ?>|numParsh):(<?= $kpi["NARTD_changerate"]; ?>|numParsh)) + ' pts '" ></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
                </span>
                <span class="change" style="padding-left: 5px;" ng-if="<?= $kpi["NARTD_changerate"]; ?> == null" ng-bind="nodata"></span>
            </div>
            <span ng-cloak>KO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <div style="display: flex">
                <div class="progress transparent-pro">
                    <div class='progress-bar jidutiao1' role="progressbar"
                         aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                         style="width: {{(<?= $kpi["NARTD_value"] > $kpi["ko_value"]; ?>)?(<?= $kpi["ko_value"]; ?>/<?= $kpi["NARTD_value"]; ?>)*100:(<?= $kpi["ko_value"]; ?>/<?= $kpi["ko_value"]; ?>)*100}}%">
                        <span ng-if="<?= $kpi["ko_value"]; ?> != null" ng-bind="(<?= $kpi["ko_value"]; ?>|numParsh)"></span>
                        <span class="change" ng-if="<?= $kpi["ko_value"]; ?> == null" ng-bind="nodata"></span>
                    </div>
                </div>
                <!--变化率-->
                <span ng-if="<?= $kpi["ko_changerate"]; ?> > 0" style="padding-left: 5px;" ng-cloak>
                    <span class="green" ng-bind="((<?= $kpi["ko_changerate"]; ?>>1||<?= $kpi["ko_changerate"]; ?><-1)?(<?= $kpi["ko_changerate"]; ?>|numParsh):(<?= $kpi["ko_changerate"]; ?>|numParsh))+' pts '" ></span>
                    <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                </span>
                <span ng-if="<?= $kpi["ko_changerate"]; ?> != null && <?= $kpi["ko_changerate"]; ?> < 0" style="padding-left: 5px;" ng-cloak>
                    <span class="change" ng-bind="((<?= $kpi["ko_changerate"]; ?>>1||<?= $kpi["ko_changerate"]; ?><-1)?(<?= $kpi["ko_changerate"]; ?>|numParsh):(<?= $kpi["ko_changerate"]; ?>|numParsh))+' pts '" ></span>
                    <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                </span>
                <span ng-if="<?= $kpi["ko_changerate"]; ?> == 0" style="padding-left: 5px;" ng-cloak>
                    <span class="green" ng-bind="((<?= $kpi["ko_changerate"]; ?>>1||<?= $kpi["ko_changerate"]; ?><-1)?(<?= $kpi["ko_changerate"]; ?>|numParsh):(<?= $kpi["ko_changerate"]; ?>|numParsh))+' pts '" ></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
                </span>
                <span class="change" ng-if="<?= $kpi["ko_changerate"]; ?> == null" style="padding-left: 5px;" ng-bind="nodata"></span>
            </div>
        </div>
    </div>
</div>