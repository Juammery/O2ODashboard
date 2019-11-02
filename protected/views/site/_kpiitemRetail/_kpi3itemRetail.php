
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
                <div class='progress-bar jidutiao {{pie1kpi>1?"width50":pie1kpi<0.85?"width40":"width45"}}' role="progressbar"
                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                </div>
                <span ng-if="dissales_amount != null" ng-bind="(dissales_amount/disonlinestores>100)?((dissales_amount/disonlinestores)|number:0):((dissales_amount/disonlinestores)|number:1)"></span>
                <span class="change" ng-if="sortsales_amount == null" ng-bind="nodata"></span>
            </div>

            <span ng-cloak>上月</span>
            <div class="progress transparent-pro">
                <div class='progress-bar jidutiao1 {{sortsales_amount/ko_sales_amount>1?"width50":sortsales_amount/ko_sales_amount<0.85?"width40":"width45"}}' role="progressbar"
                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                </div>
                <span ng-if="sortsales_amount != null" ng-bind="(sortsales_amount/sortonlinestores>100)?((sortsales_amount/sortonlinestores)|number:0):((sortsales_amount/sortonlinestores)|number:1)"></span>
                <span class="change" ng-if="sortsales_amount== null" ng-bind="nodata"></span>
            </div>
        </div>

        <div class="col-md-3 last-month bs" style="width:24%;float:right;">

            <span ng-cloak>
                <span class="last-month-compare" ng-cloak>同上月相比</span></br>
                <span class="green" ng-bind="(((sortsales_amount/sortonlinestores)-(sortsales_amount/sortonlinestores))/(sortsales_amount/sortonlinestores) * 100|number:0)+'%'" ></span>
                <img ng-if="((sortsales_amount/sortonlinestores)-(sortsales_amount/sortonlinestores))/(sortsales_amount/sortonlinestores)> 0" src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                <img ng-if="((sortsales_amount/sortonlinestores)-(sortsales_amount/sortonlinestores))/(sortsales_amount/sortonlinestores) != null && ((sortsales_amount/sortonlinestores)-(sortsales_amount/sortonlinestores))/(sortsales_amount/sortonlinestores) < 0" src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                <img ng-if="((sortsales_amount/sortonlinestores)-(sortsales_amount/sortonlinestores))/(sortsales_amount/sortonlinestores)== 0" src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
            </span>
        </div>
    </div>
</div>

