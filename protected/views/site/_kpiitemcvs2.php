<div  ng-repeat="item in kopciinfos.koandpcis[pieLeftId] track by $index" ng-if="item.mechanism != '0' && item.mechanism != '6'">
    <div class="lattice" ng-if="visitab == 'thematic_activity' || visitab == 'Last_thematic_activity_radio' || visitab == 'promotion'">
        <div class="kpititle">{{item.mechanism}}促销机制店次占比</div>
        <div class="row">
            <div class="col-md-9 this-month bs" style="width:74.8%;display:inline-block;">
                <span>{{labels.thisvalue}}</span>
                <div class="progress transparent-pro">
                    <div class='progress-bar jidutiao width50' ng-if=" (item.promotion ) > 1 " role="progressbar"   aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                    </div>
                    <div class='progress-bar jidutiao width40' ng-if="item.promotion < 0.85" role="progressbar"   aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                    </div>
                    <div class='progress-bar jidutiao width45' ng-if="item.promotion  >= 0.85 && item.promotion  <= 1" role="progressbar"   aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                    </div>
                    <span ng-if="item.promotion != null" ng-bind="(item.promotion * 100 | number:2) + '%'"></span>
                    <span class="change" ng-if="item.promotion == null" ng-bind="nodata"></span>
                </div>
                <span>{{labels.lastvalue}}</span>
                <div class="progress transparent-pro" ng-repeat="lastitem in kopciinfos.lastkoandpcis[pieLeftId]"  ng-if="lastitem.mechanism == item.mechanism">
                    <div class='progress-bar jidutiao1 width50' ng-if="lastitem.promotion > 1 " role="progressbar"   aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                    </div>
                    <div class='progress-bar jidutiao1 width40' ng-if="lastitem.promotion < 0.85" role="progressbar"   aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                    </div>
                    <div class='progress-bar jidutiao1 width45' ng-if="lastitem.promotion >= 0.85 && lastitem.promotion <= 1" role="progressbar"   aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                    </div>
                    <span ng-if="lastitem.promotion != null" ng-bind="(lastitem.promotion * 100 | number:2) + '%'"></span>
                    <span class="change" ng-if="lastitem.promotion == null" ng-bind="nodata"></span>
                </div>
            </div>
            <div class="col-md-3 last-month bs" style="width:24%;float:right;">

                <span ng-if="item.Last_promotion_radio > 0">
                    <span class="last-month-compare"><?= Yii::t('cvs', '同上期相比'); ?></span></br>
                    <span class="green" ng-bind="(item.Last_promotion_radio * 100|number:2) + '%'" ></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                </span>
                <span ng-if="item.Last_promotion_radio != null && item.Last_promotion_radio <= 0">
                    <span class="last-month-compare"><?= Yii::t('cvs', '同上期相比'); ?></span></br>
                    <span class="change" ng-bind="(item.Last_promotion_radio * 100|number:2) + '%'"></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                </span>
                <span ng-if="item.Last_promotion_radio == null" ng-bind="nodata"></span>


            </div>
        </div>
    </div>
</div>
