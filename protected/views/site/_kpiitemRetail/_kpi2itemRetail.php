
<div class="lattice">
    <div class="row"  style="margin-bottom: 5px;">
        <div class="col-md-12 this-month bs" style="display:inline-block;">
            <div class="kpititle" style="padding-left: 10px;">
                <span ng-bind="month | reverse"></span>
                &nbsp;<b style="color: red" ng-bind="city1"></b>
                &nbsp;<?= $kpiname ?><img src="<?=Yii::app()->request->baseUrl.'/images/plaint.png';?>" alt="解释说明" title="<?= $title ?>" class="rulePng">
            </div>
            <span ng-cloak>NARTD</span>
            <div class="progress transparent-pro">
                <div class='progress-bar jidutiao {{ (nartd_storesku/stores)>20?"width50":(nartd_storesku/stores)<10?"width40":"width45"}}' role="progressbar"
                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                    <span ng-if="dissalescount != null" ng-bind="(nartd_storesku/stores>100)?((nartd_storesku/stores)|number:0):((nartd_storesku/stores)|number:1)"></span>
                    <span class="change" ng-if="dissalescount == null" ng-bind="nodata"></span>
                </div>
                <!--                比较上月，不显示，这里用作测试-->
<!--                <div class='progress-bar jidutiao {{pie1kpi>1?"width50":pie1kpi<0.85?"width40":"width45"}}' role="progressbar"-->
<!--                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">-->
<!--                    <span ng-if="last_dissalescount != null" ng-bind="(last_dissalescount/last_disonlinestores>100)?((last_dissalescount/last_disonlinestores)|number:0):((last_dissalescount/last_disonlinestores)|number:1)"></span>-->
<!--                    <span class="change" ng-if="last_dissalescount == null" ng-bind="nodata"></span>-->
<!--                </div>-->

                <!--                变化率-->
                <div class="progress-gradient">
                    <div ng-if="(nartd_storesku/stores-lastnartd_storesku/laststores)  > 0 && month!='2018-11-01'" ng-cloak>
                        <span class="green" ng-bind="(nartd_storesku/stores-lastnartd_storesku/laststores) | number:1" ></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                    </div>
                    <div ng-if="(nartd_storesku/stores-lastnartd_storesku/laststores) < 0 && month!='2018-11-01'" ng-cloak>
                        <span class="change" ng-bind="(nartd_storesku/stores-lastnartd_storesku/laststores) | number:1"  ></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                    </div>
                    <div ng-if="(nartd_storesku/stores-lastnartd_storesku/laststores) == 0 && month!='2018-11-01'" ng-cloak>
                        <span class="green" ng-bind="(nartd_storesku/stores-lastnartd_storesku/laststores) | number:1" " ></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/balance.png">
                    </div>
                    <span class="change" ng-if="month=='2018-11-01'" ng-bind="nodata"></span>
                </div>
            </div>
<!--            <div class="progress transparent-pro">-->
<!--                <div class='progress-bar jidutiao {{pie2kpi>1?"width50":pie1kpi<0.85?"width40":"width45"}}' role="progressbar"-->
<!--                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >-->
<!--                </div>-->
<!--                <span ng-if="(sortko_salescount/sortko_onlinestores) != null" ng-bind="((sortko_salescount/sortko_onlinestores)|number:0)"></span>-->
<!--                <span class="change" ng-if="(sortko_salescount/sortko_onlinestores) == null" ng-bind="nodata"></span>-->
<!--            </div>-->
            <span ng-cloak>KO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <div class="progress transparent-pro">
                <div class='progress-bar jidutiao {{(ko_storesku/stores)>20?"width50":(ko_storesku/stores)<10?"width40":"width45"}}' role="progressbar"
                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                    <span ng-if="ko_storesku != null" ng-bind="(ko_storesku/stores>100)?((ko_storesku/stores)|number:0):((ko_storesku/stores)|number:1)"></span>
                    <span class="change" ng-if="sortko_salescount == null" ng-bind="nodata"></span>
                </div>

                <!--                变化率-->
                <div class="progress-gradient">
                    <div ng-if="(ko_storesku/stores-lastko_storesku/laststores)  > 0 && month!='2018-11-01'" ng-cloak>
                        <span class="green" ng-bind="(ko_storesku/stores-lastko_storesku/laststores) | number:2" ></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                    </div>
                    <span ng-if="(ko_storesku/stores-lastko_storesku/laststores)  < 0 && month!='2018-11-01'" ng-cloak>
                    <span class="change" ng-bind="(ko_storesku/stores-lastko_storesku/laststores) | number:2" ></span>
                    <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                </span>
                    <span ng-if="(ko_storesku/stores-lastko_storesku/laststores) == 0 && month!='2018-11-01'" ng-cloak>
                    <span class="green" ng-bind="(ko_storesku/stores-lastko_storesku/laststores) | number:2" ></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
                </span>
                    <span class="change" ng-if="month=='2018-11-01'" ng-bind="nodata"></span>
                </div>
            </div>

<!--            <div class="progress transparent-pro">-->
<!--                <div class='progress-bar jidutiao1 {{pie2kpi>1?"width50":pie2kpi<0.85?"width40":"width45"}}' role="progressbar"-->
<!--                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >-->
<!--                </div>-->
<!--                <span ng-if="(sortko_salescount/sortko_onlinestores) != null" ng-bind="((sortko_salescount/sortko_onlinestores)|number:0)"></span>-->
<!--                <span class="change" ng-if="(sortko_salescount/sortko_onlinestores)== null" ng-bind="nodata"></span>-->
<!--            </div>-->
        </div>
    </div>
</div>