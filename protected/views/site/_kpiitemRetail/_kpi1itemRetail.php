
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
                <div class='progress-bar jidutiao {{(nartdstorecount/storeordernum)>1?"width50":(nartdstorecount/storeordernum)<0.1?"width40":(nartdstorecount/storeordernum)<0.2?"width45":"width50"}}' role="progressbar"
                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                    <span ng-if="sortko_sales_amount != null" ng-bind="((nartdstorecount/storeordernum)|number:2)"></span>
                    <span class="change" ng-if="dissales_amount == null" ng-bind="nodata"></span>
<!--                    <span>{{lastnartdstorecount}}</span>-->
                </div>
<!--                变化率-->


                <div class="progress-gradient">
                    <div ng-if="(nartdstorecount-lastnartdstorecount) > 0 && month!='2018-11-01'" ng-cloak>
                    <span class="green" ng-bind="(nartdstorecount/storeordernum-lastnartdstorecount/laststoreordernum)| number:2" ></span>
                    <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                </div>

                <span ng-if="(nartdstorecount-lastnartdstorecount)  < 0 && month!='2018-11-01'" ng-cloak>
                    <span class="change" ng-bind="(nartdstorecount/storeordernum-lastnartdstorecount/laststoreordernum)| number:2" ></span>
                    <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                </span>
                <span ng-if="(nartdstorecount-lastnartdstorecount) == 0 && month!='2018-11-01'" ng-cloak>
                    <span class="green" ng-bind="(nartdstorecount/storeordernum-lastnartdstorecount/laststoreordernum)| number:2" ></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
                </span>
                <span class="change" ng-if="month =='2018-11-01' " ng-bind="nodata"></span>
                </div>
            </div>

<!--            <div class="progress transparent-pro">-->
<!--                <div class='progress-bar jidutiao {{pie1kpi>1?"width50":pie1kpi<0.85?"width40":"width45"}}' role="progressbar"-->
<!--                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >-->
<!--                </div>-->
<!--                <span ng-if="sortko_sales_amount != null" ng-bind="(sortko_sales_amount/sortko_onlinestores>100)?((sortko_sales_amount/sortko_onlinestores)|number:0):((sortko_sales_amount/sortko_onlinestores)|number:1)"></span>-->
<!--                <span class="change" ng-if="dissales_amount == null" ng-bind="nodata"></span>-->
<!--                <span class="progress-gradient">111</span>-->
<!--            </div>-->

            <span ng-cloak>KO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <div class="progress transparent-pro">
                <div class='progress-bar jidutiao {{(kostorecount/storeordernum)>1?"width50":(kostorecount/storeordernum)<0.1?"width40":(kostorecount/storeordernum)<0.2?"width45":"width50"}}' role="progressbar"
                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                    <span ng-if="kostorecount != null" ng-bind="((kostorecount/storeordernum)|number:2)"></span>
                    <span class="change" ng-if="lastsortko_sales_amount == null" ng-bind="nodata"></span>
                </div>


                <!--                变化率-->
                <div class="progress-gradient">
                    <div ng-if="(kostorecount/storeordernum-lastkostorecount/laststoreordernum) > 0 && month!='2018-11-01'" ng-cloak>
                        <span class="green" ng-bind="(kostorecount/storeordernum-lastkostorecount/laststoreordernum) | number:2" ></span>
                        <img src="<?php echo Yii::app()->baseUrl?>/images/small_up.png">
                    </div>
                    <span ng-if="(kostorecount/storeordernum-lastkostorecount/laststoreordernum)  < 0 && month!='2018-11-01'" ng-cloak>
                    <span class="change" ng-bind="(kostorecount/storeordernum-lastkostorecount/laststoreordernum) | number:2" ></span>
<!--                        <span ng-bind="(lastkostorecount/laststoreordernum) | number:2" ></span>-->
                    <img src="<?php echo Yii::app()->baseUrl?>/images/small_down.png">
                </span>
                    <span ng-if="(kostorecount/storeordernum-lastkostorecount/laststoreordernum) == 0 && month!='2018-11-01'" ng-cloak>
                    <span class="green" ng-bind="(kostorecount/storeordernum-lastkostorecount/laststoreordernum) | number:2" ></span>

                    <img src="<?php echo Yii::app()->baseUrl ?>/images/balance.png">
                </span>
                    <span class="change" ng-if="month == '2018-11-01'" ng-bind="nodata"></span>
                </div>
            </div>


<!--            <div class="progress transparent-pro">-->
<!--                <div class='progress-bar jidutiao1 {{sortko_sales_amount/ko_sales_amount>1?"width50":sortko_sales_amount/ko_sales_amount<0.85?"width40":"width45"}}' role="progressbar"-->
<!--                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">-->
<!--                </div>-->
<!--                <span ng-if="sortko_sales_amount != null" ng-bind="(sortko_sales_amount/sortko_onlinestores>100)?((sortko_sales_amount/sortko_onlinestores)|number:0):((sortko_sales_amount/sortko_onlinestores)|number:1)"></span>-->
<!--                <span class="change" ng-if="sortko_sales_amount== null" ng-bind="nodata"></span>-->
<!--                <span class="progress-gradient">111</span>-->
<!--            </div>-->
        </div>
    </div>
</div>

