
<div class="lattice">
    <div class="row"  style="margin-bottom: 5px;">
        <div class="col-md-9 this-month bs" style="width:74.8%;display:inline-block;">
            <div class="kpititle" style="padding-left: 10px;">
                <span ng-bind="month | reverse"></span>
                &nbsp;<b style="color: red" ng-bind="city1"></b>
                &nbsp;<?= $kpiname ?><img src="<?=Yii::app()->request->baseUrl.'/images/plaint.png';?>" alt="解释说明" title="<?= $title ?>" class="rulePng">
            </div>

            <span ng-cloak>本月</span>
            <div class="progress transparent-pro">
                <div class='progress-bar jidutiao {{pie2kpi>1?"width50":pie1kpi<0.85?"width40":"width45"}}' role="progressbar"
                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                </div>
                <span ng-if="(dissalescount/disonlinestores) != null" ng-bind="((dissalescount/disonlinestores)|number:0)"></span>
                <span class="change" ng-if="(dissalescount/disonlinestores) == null" ng-bind="nodata"></span>
            </div>

            <span ng-cloak>上月</span>
            <div class="progress transparent-pro">
                <div class='progress-bar jidutiao1 {{pie2kpi>1?"width50":pie2kpi<0.85?"width40":"width45"}}' role="progressbar"
                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                </div>
                <span ng-if="(sortsalescount/sortonlinestores) != null" ng-bind="((sortsalescount/sortonlinestores)|number:0)"></span>
                <span class="change" ng-if="(sortsalescount/sortonlinestores)== null" ng-bind="nodata"></span>
            </div>
        </div>

        <div class="col-md-3 last-month bs" style="width:24%;float:right;">

         <span ng-cloak>
                <span class="last-month-compare" ng-cloak>同上月相比</span></br>
             <span class="green" ng-bind="(((sortsalescount/sortonlinestores)-(sortsalescount/sortonlinestores))/(sortsalescount/sortonlinestores) * 100|number:0)+'%'" ></span>
                <img ng-if="((sortsalescount/sortonlinestores)-(sortsalescount/sortonlinestores))/(sortsalescount/sortonlinestores)> 0" src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                <img ng-if="((sortsalescount/sortonlinestores)-(sortsalescount/sortonlinestores))/(sortsalescount/sortonlinestores) != null && ((sortsalescount/sortonlinestores)-(sortsalescount/sortonlinestores))/(sortsalescount/sortonlinestores) < 0" src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                <img ng-if="((sortsalescount/sortonlinestores)-(sortsalescount/sortonlinestores))/(sortsalescount/sortonlinestores)== 0" src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
            </span>

        </div>
    </div>
</div>