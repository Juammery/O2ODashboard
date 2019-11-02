<div  ng-repeat="item in kopciinfos.koandpcis[pieLeftId] track by $index" ng-if="item.equipment =='可口可乐冰柜' ">
    <div class="lattice" ng-if="visitab == 'equipment_sales' || visitab == 'Last_equipment_sales_radio' ">
        <div class="kpititle">可口可乐冰柜店均门数</div>
        <div class="row">
            <div class="col-md-9 this-month bs" style="width:74.8%;display:inline-block;">
                <span>{{labels.thisvalue}}</span>
                <div class="progress transparent-pro">
                    <div class='progress-bar jidutiao width50' ng-if=" item.freezer_shop  > 1 " role="progressbar"   aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                    </div>
                    <div class='progress-bar jidutiao width40' ng-if="item.freezer_shop < 0.85" role="progressbar"   aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                    </div>
                    <div class='progress-bar jidutiao width45' ng-if="item.freezer_shop   >= 0.85 && item.freezer_shop <= 1" role="progressbar"   aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                    </div>
                    <span ng-if="item.freezer_shop != null" ng-bind="(item.freezer_shop | number:2)"></span>
                    <span class="change" ng-if="item.freezer_shop == null" ng-bind="nodata"></span>
                </div>
                <span>{{labels.lastvalue}}</span>
                <div class="progress transparent-pro" ng-repeat="lastitem in kopciinfos.lastkoandpcis[pieLeftId]"  ng-if="lastitem.equipment == '可口可乐冰柜'">
                    <div class='progress-bar jidutiao1 width50' ng-if="lastitem.freezer_shop > 1 " role="progressbar"   aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                    </div>
                    <div class='progress-bar jidutiao1 width40' ng-if="lastitem.freezer_shop < 0.85" role="progressbar"   aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                    </div>
                    <div class='progress-bar jidutiao1 width45' ng-if="lastitem.freezer_shop >= 0.85 && lastitem.freezer_shop <= 1" role="progressbar"   aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                    </div>
                    <span ng-if="lastitem.freezer_shop != null" ng-bind="(lastitem.freezer_shop | number:2)"></span>
                    <span class="change" ng-if="lastitem.freezer_shop == null" ng-bind="nodata"></span>
                </div>
            </div>
            <div class="col-md-3 last-month bs" style="width:24%;float:right;">

                <span ng-if="item.Last_freezer_shop > 0">
                    <span class="last-month-compare"><?= Yii::t('cvs', '同上期相比'); ?></span></br>
                    <span class="green" ng-bind="(item.Last_freezer_shop * 100|number:2) + '%'" ></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/small_up.png">
                </span>
                <span ng-if="item.Last_freezer_shop != null && item.Last_freezer_shop <= 0">
                    <span class="last-month-compare"><?= Yii::t('cvs', '同上期相比'); ?></span></br>
                    <span class="change" ng-bind="(item.Last_freezer_shop * 100|number:2) + '%'"></span>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/small_down.png">
                </span>
                <span ng-if="item.Last_freezer_shop == null" ng-bind="nodata"></span>


            </div>
        </div>
    </div>
</div>
