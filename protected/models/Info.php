<?php

/**
 * This is the model class for table "{{info}}".
 *
 * The followings are the available columns in table '{{info}}':
 * @property integer $id
 * @property string $time_id
 * @property string $time
 * @property integer $relation_id
 * @property integer $cityLevel_id
 * @property integer $system_id
 * @property integer $platform_id
 * @property integer $category_id
 * @property integer $menu_id
 * @property integer $brand_id
 * @property integer $capacity_id
 * @property integer $bottle_id
 * @property double $distribution
 * @property double $last_distribution
 * @property double $sales_numbers
 * @property double $last_sales_numbers
 * @property double $sales_quota
 * @property double $last_sales_quota
 * @property double $saleroom
 * @property double $last_saleroom
 * @property double $sales_share
 * @property double $last_sales_share
 * @property double $enrollment
 * @property double $last_enrollment
 * @property double $store_money
 * @property double $last_store_money
 * @property double $store_number
 * @property double $last_store_number
 * @property double $sku_number
 * @property double $last_sku_number
 * @property double $distribution_store
 * @property double $last_distribution_store
 * @property double $average_selling_price
 * @property double $last_average_selling_price
 * @property double $average_purchase_price
 * @property double $last_average_purchase_price
 * @property double $price_promotion_ratio
 * @property double $last_price_promotion_ratio
 * @property double $average_discount_factor
 * @property double $last_average_discount_factor
 * @property double $average_number_per_unit
 * @property double $last_average_number_per_unit
 * @property double $average_amount_per_order
 * @property double $last_average_amount_per_order
 * @property double $online_stores
 * @property double $last_online_stores
 */
class Info extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public $tableName;
    public static $_models = [];
    public static $_md = [];
    public function __construct($table, $config = [])
    {
        if ($table) {
            $this->tableName = $table;
        }
        parent::__construct($config);
    }
    public function tableName()
    {
        $name = 'cola_info_' . $this->tableName;
        $sql = 'SHOW TABLES LIKE "' . $name . '"';
        $isset = Yii::app()->db->createCommand($sql)->queryAll();
        //var_dump($isset,$name);
        if ($isset == null) {
            $this->tableName = Yii::app()->params['defaultTable'];
        } else {
            $this->tableName = $name;
        }
        return $this->tableName;
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('relation_id, system_id, platform_id, category_id', 'required'),
            array('time_id, relation_id, system_id, platform_id, category_id,menu_id,brand_id', 'numerical', 'integerOnly' => true),
            array(
                'distribution, last_distribution, sales_numbers, last_sales_numbers, sales_quota, last_sales_quota, saleroom, last_saleroom, sales_share,
			last_sales_share, enrollment, last_enrollment, store_money, last_store_money, store_number, last_store_number, sku_number, last_sku_number,
			distribution_store, last_distribution_store, average_selling_price, last_average_selling_price, average_purchase_price, last_average_purchase_price,
			price_promotion_ratio, last_price_promotion_ratio, average_discount_factor, last_average_discount_factor, average_number_per_unit,
			last_average_number_per_unit, average_amount_per_order, last_average_amount_per_order, online_stores, last_online_stores', 'numerical'
            ),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'id, time,time_id,relation_id, system_id, platform_id, sku_id, distribution, last_distribution, sales_numbers,
			last_sales_numbers, sales_quota, last_sales_quota, saleroom, last_saleroom, sales_share, last_sales_share, enrollment,
			last_enrollment, store_money, last_store_money, store_number, last_store_number, sku_number, last_sku_number, distribution_store,
			last_distribution_store, average_selling_price, last_average_selling_price, average_purchase_price, last_average_purchase_price, price_promotion_ratio,
			last_price_promotion_ratio, average_discount_factor, last_average_discount_factor, average_number_per_unit, last_average_number_per_unit,
			average_amount_per_order, last_average_amount_per_order, online_stores, last_online_stores,cityLevel_id,capacity_id,bottle_id', 'safe', 'on' => 'search'
            ),
        );
    }
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'relation' => array(self::BELONGS_TO, 'Relation', 'relation_id'),
            'platform' => array(self::BELONGS_TO, 'Platform', 'platform_id'),
            'time' => array(self::BELONGS_TO, 'Time', 'time_id'),
            'system' => array(self::BELONGS_TO, 'System', 'system_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'menu' => array(self::BELONGS_TO, 'Menu', 'menu_id'),
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
            'cityLevel' => array(self::BELONGS_TO, 'Citylevel', 'cityLevel_id'),
            'capacity' => array(self::BELONGS_TO, 'TotalClassify', 'capacity_id', 'on' => 'capacity.classify = 1'),
            'bottle' => array(self::BELONGS_TO, 'TotalClassify', 'bottle_id', 'on' => 'bottle.classify = 2'),
            'history' => array(self::HAS_MANY, 'Info', '', 'on' => 't.system_id=history.system_id and t.relation_id=history.relation_id and t.sku_id=history.sku_id and t.platform_id = history.platform_id', 'condition' => 'history.stage > 0 and  (history.time < t.time or (history.time=t.time and history.stage <= t.stage))', 'order' => 'history.time desc,history.stage desc'),
            'monhistory' => array(self::HAS_MANY, 'Info', '', 'on' => 't.system_id=monhistory.system_id and t.relation_id=monhistory.relation_id and t.sku_id=monhistory.sku_id and t.platform_id = monhistory.platform_id', 'condition' => 'monhistory.stage = -1 and monhistory.time < t.time', 'order' => 'monhistory.time desc'),
            'monthHistory' => array(self::HAS_MANY, 'Info', '', 'on' => 't.system_id=monthHistory.system_id and t.relation_id=monthHistory.relation_id and t.sku_id=monthHistory.sku_id and t.platform_id = monthHistory.platform_id', 'condition' => 'monthHistory.stage = 0 and monthHistory.time <= t.time', 'order' => 'monthHistory.time desc'),
            //(stage=0)
            'oneHistory' => array(self::HAS_MANY, 'Info', '', 'on' => 't.relation_id=oneHistory.relation_id and t.cityLevel_id = oneHistory.cityLevel_id and t.system_id=oneHistory.system_id and t.platform_id = oneHistory.platform_id  and t.sku_id = oneHistory.sku_id and t.capacity_id = oneHistory.capacity_id and t.bottle_id = oneHistory.bottle_id', 'condition' => 'oneHistory.stage = 0 and oneHistory.time <= t.time', 'order' => 'oneHistory.time desc'),
            //(stage=-1)
            'zeroHistory' => array(self::HAS_MANY, 'Info', '', 'on' => 't.relation_id=zeroHistory.relation_id and t.cityLevel_id = zeroHistory.cityLevel_id and t.system_id=zeroHistory.system_id and t.platform_id = zeroHistory.platform_id and t.sku_id = zeroHistory.sku_id and t.capacity_id = zeroHistory.capacity_id and t.bottle_id = zeroHistory.bottle_id', 'condition' => 'zeroHistory.stage = -1 and zeroHistory.time <= t.time', 'order' => 'zeroHistory.time desc'),
        );
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'time' => '时间',
            'stage' => '期数',
            'relation_id' => '区域',
            'cityLevel_id' => '城市等级',
            'system_id' => '渠道',
            'platform_id' => '平台',
            'sku_id' => 'Sku',
            'capacity' => '容量分级',
            'bottle' => '瓶数分级',
            'distribution' => '铺货率',
            'last_distribution' => '铺货率的比率',
            'sales_numbers' => '销售件数',
            'last_sales_numbers' => '销售件数的比率',
            'sales_quota' => '销售件数占比',
            'last_sales_quota' => '销售件数占比的比率',
            'saleroom' => '销售额',
            'last_saleroom' => '销售额的比率',
            'sales_share' => 'Sales Share',
            'last_sales_share' => 'Last Sales Share',
            'enrollment' => 'Enrollment',
            'last_enrollment' => 'Last Enrollment',
            'store_money' => 'Store Money',
            'last_store_money' => 'Last Store Money',
            'store_number' => 'Store Number',
            'last_store_number' => 'Last Store Number',
            'sku_number' => 'Sku Number',
            'last_sku_number' => 'Last Sku Number',
            'distribution_store' => 'Distribution Store',
            'last_distribution_store' => 'Last Distribution Store',
            'average_selling_price' => 'Average Selling Price',
            'last_average_selling_price' => 'Last Average Selling Price',
            'average_purchase_price' => 'Average Purchase Price',
            'last_average_purchase_price' => 'Last Average Purchase Price',
            'price_promotion_ratio' => 'Price Promotion Ratio',
            'last_price_promotion_ratio' => 'Last Price Promotion Ratio',
            'average_discount_factor' => 'Average Discount Factor',
            'last_average_discount_factor' => 'Last Average Discount Factor',
            'average_number_per_unit' => 'Average Number Per Unit',
            'last_average_number_per_unit' => 'Last Average Number Per Unit',
            'average_amount_per_order' => 'Average Amount Per Order',
            'last_average_amount_per_order' => 'Last Average Amount Per Order',
            'online_stores' => 'Online Stores',
            'last_online_stores' => 'Last Online Stores',
        );
    }
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('time_id', $this->time_id, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('relation_id', $this->relation_id);
        $criteria->compare('cityLevel_id', $this->cityLevel_id);
        $criteria->compare('system_id', $this->system_id);
        $criteria->compare('platform_id', $this->platform_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('menu_id', $this->menu_id);
        $criteria->compare('brand_id', $this->brand_id);
        $criteria->compare('capacity', $this->capacity_id);
        $criteria->compare('bottle', $this->bottle_id);
        $criteria->compare('distribution', $this->distribution);
        $criteria->compare('last_distribution', $this->last_distribution);
        $criteria->compare('sales_numbers', $this->sales_numbers);
        $criteria->compare('last_sales_numbers', $this->last_sales_numbers);
        $criteria->compare('sales_quota', $this->sales_quota);
        $criteria->compare('last_sales_quota', $this->last_sales_quota);
        $criteria->compare('saleroom', $this->saleroom);
        $criteria->compare('last_saleroom', $this->last_saleroom);
        $criteria->compare('sales_share', $this->sales_share);
        $criteria->compare('last_sales_share', $this->last_sales_share);
        $criteria->compare('enrollment', $this->enrollment);
        $criteria->compare('last_enrollment', $this->last_enrollment);
        $criteria->compare('store_money', $this->store_money);
        $criteria->compare('last_store_money', $this->last_store_money);
        $criteria->compare('store_number', $this->store_number);
        $criteria->compare('last_store_number', $this->last_store_number);
        $criteria->compare('sku_number', $this->sku_number);
        $criteria->compare('last_sku_number', $this->last_sku_number);
        $criteria->compare('distribution_store', $this->distribution_store);
        $criteria->compare('last_distribution_store', $this->last_distribution_store);
        $criteria->compare('average_selling_price', $this->average_selling_price);
        $criteria->compare('last_average_selling_price', $this->last_average_selling_price);
        $criteria->compare('average_purchase_price', $this->average_purchase_price);
        $criteria->compare('last_average_purchase_price', $this->last_average_purchase_price);
        $criteria->compare('price_promotion_ratio', $this->price_promotion_ratio);
        $criteria->compare('last_price_promotion_ratio', $this->last_price_promotion_ratio);
        $criteria->compare('average_discount_factor', $this->average_discount_factor);
        $criteria->compare('last_average_discount_factor', $this->last_average_discount_factor);
        $criteria->compare('average_number_per_unit', $this->average_number_per_unit);
        $criteria->compare('last_average_number_per_unit', $this->last_average_number_per_unit);
        $criteria->compare('average_amount_per_order', $this->average_amount_per_order);
        $criteria->compare('last_average_amount_per_order', $this->last_average_amount_per_order);
        $criteria->compare('online_stores', $this->online_stores);
        $criteria->compare('last_online_stores', $this->last_online_stores);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function maxstage($month)
    {
        $maxsql = 'select IFNULL(max(stage),-1) as maxnum from cola_info where time="' . $month . '"';
        $res = Yii::app()->db->createCommand($maxsql)->queryRow();
        return $res['maxnum'];
    }

    public static function monthdata()
    {
        $sql = 'select time from cola_info GROUP BY time';
        $timelist = Yii::app()->db->createCommand($sql)->queryAll();
        $newlist = [];
        for ($i = 0; $i < count($timelist); $i++) {
            $newlist[] = self::onlynumber($timelist[$i]['time']);
        }
        unset($timelist);
        return $newlist;
    }

    public static function onlynumber($str)
    {
        preg_match_all('/\w+/', $str, $arr);
        return implode('', $arr[0]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Info the static model class
     */
    public static function model($table_name = '', $className = __CLASS__)
    {
        $model = new $className($table_name, null);
        return $model;
    }

    public function getMetaData()
    {
        $className = get_class($this);
        //	if(!array_key_exists($className,self::$_md))
        //	{
        self::$_md[$className] = null; // preventing recursive invokes of {@link getMetaData()} via {@link __get()}
        self::$_md[$className] = new CActiveRecordMetaData($this);
        //	}
        return self::$_md[$className];
    }

    protected function instantiate($attributes)
    {
        $name = 'cola_info_' . $this->tableName;
        $class = get_class($this);
        $model = new $class($name, null);
        return $model;
    }

    public static function getTable()
    {
        $sql = "select table_name from information_schema.tables where table_schema='cokeretail' and table_type='BASE TABLE' and TABLE_NAME like 'cola_info_%' ORDER BY TABLE_NAME desc limit 4";
        $table = Yii::app()->db->createCommand($sql)->queryAll();
        $arr = [];
        foreach ($table as $key => $value) {
            $tableName = $value['table_name'];
            $infomation = explode('_', $tableName);
            $arr[] = ['time' => $infomation[2] . '_' . $infomation[3], 'stage' => $infomation[4]];
        }
        return $arr;
    }

    public static function timerTask($month, $stage)
    {
        $relations = [1, 2, 3];//区域，装瓶集团，装瓶厂，城市
        $areaType = [0, 1];//(0:未选中)是否选中城市等级
        $cityLevel = ["t.cityLevel_id = 1", "t.cityLevel_id>0"];//城市等级
        $systemtype = 1;//渠道
        $skufield = [1, 2, 3];//品类(1)，制造商(2)，品牌(3)
        $grading = [0, 1, 2];//1代表选中容量分级，2代表选中瓶量分级，0代表都没选中
        $capafixBottfield = [
            "t.capacity_id = 1 and t.bottle_id = 8 and ",
            "t.capacity_id >0 and t.bottle_id = 8 and ",
            "t.capacity_id = 1 and t.bottle_id >= 8 and "
        ];
        $kpicheckedAll = [1, 2, 4, 7, 8, 10, 11, 12, 13, 14, 15, 16];//选中的是哪个指标，默认是产品铺货率
        $categoryList = CHtml::listData(Category::model()->findAll(), 'id', 'id');
        $menuList = CHtml::listData(Menu::model()->findAll(), 'id', 'id');
        $brandList = CHtml::listData(Brand::model()->findAll(), 'id', 'id');
        foreach ($relations as $relValue) {//装瓶集团，装瓶厂，城市
            $citytype = $relValue;
            foreach ($areaType as $areaValue) {//城市等级
                $cityfield = $cityLevel[$areaValue];
                foreach ($skufield as $skuValue) {//品类，制造商，品牌
                    switch ($skuValue) {
                        case 1:
                            foreach ($categoryList as $categoryValue) {
                                $totalfield = "t.category_id = $categoryValue and t.menu_id = 1 and t.brand_id = 1 and ";
                                self::taskListData($grading, $capafixBottfield, $kpicheckedAll, $month, $stage, $citytype, $cityfield, $systemtype, $totalfield, $skuValue);
                            }
                            break;
                        case 2:
                            foreach ($menuList as $menuValue) {
                                $totalfield = "t.category_id = 1 and t.menu_id = $menuValue and t.brand_id = 1 and ";
                                self::taskListData($grading, $capafixBottfield, $kpicheckedAll, $month, $stage, $citytype, $cityfield, $systemtype, $totalfield, $skuValue);
                            }
                            break;
                        case 3:
                            foreach ($brandList as $brandValue) {
                                $totalfield = "t.category_id = 1 and t.menu_id = 1 and t.brand_id = $brandValue and ";
                                self::taskListData($grading, $capafixBottfield, $kpicheckedAll, $month, $stage, $citytype, $cityfield, $systemtype, $totalfield, $skuValue);
                            }
                            break;
                    }
                }
            }
        }
    }

    public static function generateCache($totalArr)
    {
        foreach ($totalArr as $key => $value) {
            $md5code = self::makecode(array_merge($value['params'], array('lang' => Yii::app()->language)));
//            $returndata = Yii::app()->filecache->get($md5code);
//            if (!empty($returndata)) {
//                continue;
//            }
            $skuinfos = $skudata = [];
            $name = $value['parameter']['time'] . '_' . $value['parameter']['stage'];
            $allskuinfos = Info::model($name)->with(array(
                'category', 'menu', 'brand', 'relation', 'system', 'platform', 'cityLevel', 'capacity', 'bottle'
            ))->findAll($value['condition']);
            if ($value['parameter']['grading'] == 0) {//代表(容量分级、瓶量分级)都没选中
                foreach ($allskuinfos as $skuinfo) {
                    $totalname = $value['parameter']['sku'] == 1 ? ($skuinfo->category) : ($value['parameter']['sku'] == 2 ? $skuinfo->menu : $skuinfo->brand);//品类(1)，制造商(2)，品牌(3)
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['skus'][] = array($totalname, $skuinfo);
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['relation'] = $skuinfo->relation;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['system'] = $skuinfo->system;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['platform'] = $skuinfo->platform;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['cityLevel'] = $skuinfo->cityLevel;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['capacity'] = $skuinfo->capacity;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['bottle'] = $skuinfo->bottle;
                }
            } else {
                foreach ($allskuinfos as $skuinfo) {
                    $grad_value = $value['parameter']['grading'] == 1 ? $skuinfo->capacity : $skuinfo->bottle;
                    $totalid = $value['parameter']['sku'] == 1 ? ($skuinfo->category_id) : ($value['parameter']['sku'] == 2 ? $skuinfo->menu_id : $skuinfo->brand_id);//品类(1)，制造商(2)，品牌(3)
                    $totalname = $value['parameter']['sku'] == 1 ? ($skuinfo->category) : ($value['parameter']['sku'] == 2 ? $skuinfo->menu : $skuinfo->brand);//品类(1)，制造商(2)，品牌(3)
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['skus'][] = array($grad_value, $skuinfo);
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['relation'] = $skuinfo->relation;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['system'] = $skuinfo->system;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['platform'] = $skuinfo->platform;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['cityLevel'] = $skuinfo->cityLevel;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['capacity'] = $skuinfo->capacity;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['bottle'] = $skuinfo->bottle;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['skuname'] = $totalname;
                }
            }
            $skudata = self::getStackbarData($allskuinfos, $skuinfos, $value['parameter']['grading'], $value['parameter']['sku']);//获取stackbar数据
            unset($allskuinfos, $skuinfos);
            $returndata = CJSON::encode($skudata);
            unset($skudata);
//            Yii::app()->filecache->set($md5code, $returndata, Yii::app()->params['cache']['retaildatatime']);
            Yii::app()->filecache->set($md5code, $returndata);
            unset($md5code, $returndata);
            sleep(0.5);
        }
    }

    public static function taskListData($grading, $capafixBottfield, $kpicheckedAll, $month, $stage, $citytype, $cityfield, $systemtype, $totalfield, $skuValue)
    {
        $totalArr = [];
        foreach ($grading as $gradingValue) {//容量分级，瓶量分级
            $capaBottfield = $capafixBottfield[$gradingValue];
            foreach ($kpicheckedAll as $kpichecked) {//指标
                $current = Yii::app()->params['kpichecked'][$kpichecked]['current'];//本期值
                $gradient = Yii::app()->params['kpichecked'][$kpichecked]['gradient'];//变化率
                if ($kpichecked == 2) {
                    $current = "sales_numbers,sales_quota";//本期值(销售件数和销售件数占比)
                    $gradient = "last_sales_numbers,last_sales_quota";//变化率
                } else if ($kpichecked == 4) {
                    $current = "saleroom,sales_share";//本期值(销售金额和销售金额占比)
                    $gradient = "last_saleroom,last_sales_share";//变化率
                }
                $params = array(
                    ':time' => $month, ':stage' => $stage, ':r_depth' => $citytype, ':cityLevel' => $cityfield, ':s_depth' => $systemtype,
                    ':totalfield' => $totalfield, ':capaBottfield' => $capaBottfield, ':kpichecked' => $kpichecked,
                );
                $condition = array(
                    'condition' => "relation.depth=:r_depth and $cityfield and $totalfield $capaBottfield system.depth=:s_depth",
                    'select' => "id,relation_id,cityLevel_id,system_id,platform_id,category_id,menu_id,brand_id,capacity_id,bottle_id,$current,$gradient",
                    'params' => array(':r_depth' => $citytype, ':s_depth' => $systemtype),
                    'order' => "relation.sequence asc,system.sequence asc,platform.id asc,capacity.sequence asc,bottle.sequence asc,category.sequence asc,menu.sequence asc,brand.sequence asc",
                );
                $totalArr[] = ['parameter' => ['time' => $month, 'stage' => $stage, 'grading' => $gradingValue, 'sku' => $skuValue],
                    'condition' => $condition, 'params' => $params];
                unset($params, $condition, $current, $gradient);
            }
        }
        self::generateCache($totalArr);
        //趋势
        self::historyTask($totalArr);
    }

    public static function historyTask($totalArr)
    {
        foreach ($totalArr as $key => $value) {
            $md5code = self::makecode(array_merge($value['params'], array('type' => 'csvhistory', 'lang' => Yii::app()->language)));
//            $returndata = Yii::app()->filecache->get($md5code);
//            if (!empty($returndata)) {
//                continue;
//            }
            $historyLimit = self::getTableLimit($value['parameter']['time'], $value['parameter']['stage']);
            $distinction = explode('-', $value['parameter']['stage']);
            $tableArr = [];
            if ($distinction[0] == '2018') {//2018年的数据
                $tableArr[] = ['cola_info_2018_11_0', 'cola_info_2018_12_0'];
            } else {
                $limit = count($historyLimit);
                for ($i = 0; $i < $limit; $i++) {
                    $timeH = $historyLimit[$i]['time'];
                    $stageH = $historyLimit[$i]['stage'];
                    $tableName = "cola_info_" . $timeH . "_" . $stageH;
                    $tableArr[] = $tableName;
                }
            }
            unset($historyLimit, $distinction);
            $allskuinfos = $submeterLabel = [];
            foreach ($tableArr as $key1 => $value1) {
                $table_name = substr($value1, 10);
                $ingo = Info::model($table_name)->with(array(
                    'category', 'menu', 'brand', 'relation', 'system', 'platform', 'cityLevel', 'capacity', 'bottle'
                ))->findAll($value['condition']);
                $allskuinfos = array_merge($allskuinfos, $ingo);
                unset($ingo);
                $submeterLabel[] = $table_name;
            }
            $skuinfos = $skudata = $label = $arr = [];
            if ($value['parameter']['grading'] == 0) {//代表都没选中
                foreach ($allskuinfos as $key2 => $skuinfo) {
                    $totalid = $value['parameter']['sku'] == 1 ? ($skuinfo->category_id) : ($value['parameter']['sku'] == 2 ? $skuinfo->menu_id : $skuinfo->brand_id);//品类(1)，制造商(2)，品牌(3)
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['relation'] = $skuinfo->relation;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['system'] = $skuinfo->system;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['platform'] = $skuinfo->platform;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['cityLevel'] = $skuinfo->cityLevel;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['capacity'] = $skuinfo->capacity;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['bottle'] = $skuinfo->bottle;
                    $arr[$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid][$skuinfo->capacity_id][$skuinfo->bottle_id][] = $skuinfo;
                }
                foreach ($arr as $relation => $value1) {
                    foreach ($value1 as $cityLevel => $valu) {
                        foreach ($valu as $system => $val) {
                            foreach ($val as $platform => $va) {
                                foreach ($va as $sku => $v) {
                                    foreach ($v as $capactiy => $z) {
                                        foreach ($z as $bottle => $k) {
                                            $totalname = $value['parameter']['sku'] == 1 ? ($k[0]->category) : ($value['parameter']['sku'] == 2 ? $k[0]->menu : $k[0]->brand);//品类(1)，制造商(2)，品牌(3)
                                            $skuinfos['bar'][$k[0]->relation_id][$k[0]->cityLevel_id][$k[0]->system_id][$k[0]->platform_id]['skus'][] = array($totalname, $k[0], $k);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                foreach ($allskuinfos as $skuinfo) {
                    $totalid = $value['parameter']['sku'] == 1 ? ($skuinfo->category_id) : ($value['parameter']['sku'] == 2 ? $skuinfo->menu_id : $skuinfo->brand_id);//品类(1)，制造商(2)，品牌(3)
                    $totalname = $value['parameter']['sku'] == 1 ? ($skuinfo->category) : ($value['parameter']['sku'] == 2 ? $skuinfo->menu : $skuinfo->brand);//品类(1)，制造商(2)，品牌(3)
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['relation'] = $skuinfo->relation;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['system'] = $skuinfo->system;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['platform'] = $skuinfo->platform;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['cityLevel'] = $skuinfo->cityLevel;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['capacity'] = $skuinfo->capacity;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['bottle'] = $skuinfo->bottle;
                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['skuname'] = $totalname;
                    $arr[$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid][$skuinfo->capacity_id][$skuinfo->bottle_id][] = $skuinfo;
                }
                foreach ($arr as $relation => $value1) {
                    foreach ($value1 as $cityLevel => $valu) {
                        foreach ($valu as $system => $val) {
                            foreach ($val as $platform => $va) {
                                foreach ($va as $sku => $v) {
                                    foreach ($v as $capactiy => $z) {
                                        foreach ($z as $bottle => $k) {
                                            $vz = $value['parameter']['grading'] == 1 ? $k[0]->capacity : $k[0]->bottle;
                                            $totalid = $value['parameter']['sku'] == 1 ? ($k[0]->category_id) : ($value['parameter']['sku'] == 2 ? $k[0]->menu_id : $k[0]->brand_id);//品类(1)，制造商(2)，品牌(3)
                                            $skuinfos['bar'][$k[0]->relation_id][$k[0]->cityLevel_id][$k[0]->system_id][$k[0]->platform_id][$totalid]['skus'][] = array($vz, $k[0], $k);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            unset($arr);
            $skudata = self::getStackbarData($allskuinfos, $skuinfos, $value['parameter']['grading'], $value['parameter']['sku']);//获取stackbar数据
            unset($allskuinfos, $skuinfos);
            $skudata['stackbar']['label'] = $submeterLabel;
            $returndata = CJSON::encode($skudata);
            unset($skudata);
//            Yii::app()->filecache->set($md5code, $returndata, Yii::app()->params['cache']['retaildatatime']);
            Yii::app()->filecache->set($md5code, $returndata);
            unset($md5code, $returndata);
            sleep(1);
        }
    }

    public static function getStackbarData($data, $skuinfos, $grading, $skufield)
    {
        $skudata = [];
        foreach ($data as $skuinfo) {
            $totalid = $skufield == 1 ? ($skuinfo->category_id) : ($skufield == 2 ? $skuinfo->menu_id : $skuinfo->brand_id);//品类(1)，制造商(2)，品牌(3)
            $totalname = $skufield == 1 ? ($skuinfo->category->name) : ($skufield == 2 ? $skuinfo->menu->name : $skuinfo->brand->name);//品类(1)，制造商(2)，品牌(3)
            $totalinfo = $skufield == 1 ? ($skuinfo->category) : ($skufield == 2 ? $skuinfo->menu : $skuinfo->brand);//品类(1)，制造商(2)，品牌(3)

            $v = $grading == 0 ? $totalinfo : ($grading == 1 ? $skuinfo->capacity : $skuinfo->bottle);
            $name = $grading == 0 ? ($totalname) : ($grading == 1 ? $skuinfo->capacity->name : $skuinfo->bottle->name);

            $skudata['stackbar']['relations'][$skuinfo->relation_id] = $skuinfo->relation->name;
            $skudata['stackbar']['capacity'][$skuinfo->capacity_id] = $skuinfo->capacity->name;
            $skudata['stackbar']['bottle'][$skuinfo->bottle_id] = $skuinfo->bottle->name;
            $skudata['stackbar']['cityLevel'][$skuinfo->cityLevel_id] = $skuinfo->cityLevel->name;
            $skudata['stackbar']['systems'][$skuinfo->system_id] = $skuinfo->system->name;
            $skudata['stackbar']['platforms'][$skuinfo->platform_id] = $skuinfo->platform->name;
            $skudata['stackbar']['skuname'][$totalid] = $totalname;
            $skudata['stackbar']['skus'][$name][] = array($v, $skuinfo);
        }
        unset($data);
        if ($grading == 0) {//代表都没选中
            foreach ($skuinfos as $v) {
                foreach ($v as $vv) {
                    foreach ($vv as $vvv) {
                        foreach ($vvv as $vvvv) {
                            foreach ($vvvv as $vvvvv) {
                                $skudata['bar'][] = $vvvvv;
                            }
                        }
                    }
                }
            }
        } else {
            foreach ($skuinfos as $v) {
                foreach ($v as $vv) {
                    foreach ($vv as $vvv) {
                        foreach ($vvv as $vvvv) {
                            foreach ($vvvv as $vvvvv) {
                                foreach ($vvvvv as $vvvvvv) {
                                    $skudata['bar'][] = $vvvvvv;
                                }
                            }
                        }
                    }
                }
            }
        }
        unset($skuinfos);
        return $skudata;
    }

    public static function makecode($arr)
    {
        $str = implode(',', $arr);
        return md5($str);
    }

    public static function getTableLimit($month, $stage)
    {
        $table_name = "cola_info_" . $month . "_" . $stage;
        $sql = "select table_name from information_schema.tables where TABLE_NAME <= '" . $table_name . "' and table_schema='cokeretail' and table_type='BASE TABLE' and TABLE_NAME like 'cola_info_%" . $stage . "' ORDER BY TABLE_NAME asc limit 4";
        $table = Yii::app()->db->createCommand($sql)->queryAll();
        $arr = [];
        foreach ($table as $key => $value) {
            $tableName = $value['table_name'];
            $info = substr($tableName, 0, 9);
            if ($info == 'cola_info') {
                $infomation = explode('_', $tableName);
                $arr[] = ['time' => $infomation[2] . "_" . $infomation[3], 'stage' => $infomation[4]];
            }
        }
        return $arr;
    }
    public function split_v($start,$datagroup, $Citylevel, $System, $Platform, $Category, $Relation, $region, $type,$brand)
    {

        set_time_limit('-1');//不限制执行时间
        $base = base64_encode('admin:KYLIN');
        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
        $params = CJSON::encode([
            'sql' => $datagroup,
            'project' => 'O2O_retail',
            "acceptPartial" => false,
            'offset' => $start,
            'limit' => 20000
        ]);
        $data = $this->getRetailCurl($url, $params, $header);
        $data = $data["results"];
        if (!empty($data)) {//不为空的判断
            $info = array();
            foreach ($data as $key => $value) {
                switch($region){
                    case 'zpjt':
                        $info[$key]['relation_id'] = $value[0] == "SCCL" ? 2 : ($value[0] == "CBL" ? 3 : ($value[0] == "ZH" ? 65 : ($value[0] == "全部" ? 1 : 0)));
                        break;
                    case 'zpc':
                        $Relationid = $Relation[$value[0]];
                        $info[$key]['relation_id'] = $Relationid ? $Relationid->id : 0;
                        break;
                    case 'city':
                        $city=rtrim($value[0], "市");
                        $Relationid = $Relation[$city];
                        $info[$key]['relation_id'] = $Relationid ? $Relationid->id : 0;
                        break;
                }

                $city_levelid = isset($Citylevel[$value[1]]) ? $Citylevel[$value[1]]->id : 0;
                $info[$key]['cityLevel_id'] = $city_levelid;
                $channelid = isset($System[$value[2]]) ? $System[$value[2]]->id : 0;
                $info[$key]['system_id'] = $channelid;
                $platformid = isset($Platform[$value[3]]) ? $Platform[$value[3]]->id : 0;
                $info[$key]['platform_id'] = $platformid;
                $skuid = isset($Category[$value[4]]) ? $Category[$value[4]]->id : 0;
                switch($brand){
                    case 'type':
                        $info[$key]['category_id'] = $skuid;
                        $info[$key]['menu_id'] = 1;
                        $info[$key]['brand_id'] = 1;
                        break;
                    case 'manu':
                        $info[$key]['category_id'] = 1;
                        $info[$key]['menu_id'] = $skuid;
                        $info[$key]['brand_id'] = 1;
                        break;
                    case 'pinpai':
                        $info[$key]['category_id'] = 1;
                        $info[$key]['menu_id'] = 1;
                        $info[$key]['brand_id'] = $skuid;
                        break;
                }
                $info[$key]['capacity_id'] = 1;
                $info[$key]['bottle_id'] = 1;
                $info[$key]['distribution'] = isset($value[5]) ? (double)$value[5] : 0;
                $info[$key]['last_distribution'] = isset($value[6]) ? (double)$value[6] : 0;
                $info[$key]['sales_numbers'] = isset($value[7]) ? (double)$value[7] : 0;
                $info[$key]['last_sales_numbers'] = isset($value[8]) ? (double)$value[8] : 0;
                $info[$key]['sales_quota'] = isset($value[9]) ? (double)$value[9] : 0;
                $info[$key]['last_sales_quota'] = isset($value[10]) ? (double)$value[10] : 0;
                $info[$key]['saleroom'] = isset($value[11]) ? (double)$value[11] : 0;
                $info[$key]['last_saleroom'] = isset($value[12]) ? (double)$value[12] : 0;
                $info[$key]['sales_share'] = isset($value[13]) ? (double)$value[13] : 0;
                $info[$key]['last_sales_share'] = isset($value[14]) ? (double)$value[14] : 0;
                $info[$key]['enrollment'] = isset($value[15]) ? (double)$value[15] : 0;
                $info[$key]['last_enrollment'] = isset($value[16]) ? (double)$value[16] : 0;
                $info[$key]['store_money'] = isset($value[17]) ? (double)$value[17] : 0;
                $info[$key]['last_store_money'] = isset($value[18]) ? (double)$value[18] : 0;
                $info[$key]['store_number'] = isset($value[19]) ? (double)$value[19] : 0;
                $info[$key]['last_store_number'] = isset($value[20]) ? (double)$value[20] : 0;
                $info[$key]['sku_number'] = isset($value[21]) ? (double)$value[21] : 0;
                $info[$key]['last_sku_number'] = isset($value[22]) ? (double)$value[22] : 0;
                $info[$key]['distribution_store'] = isset($value[23]) ? (double)$value[23] : 0;
                $info[$key]['last_distribution_store'] = isset($value[24]) ? (double)$value[24] : 0;
                $info[$key]['average_selling_price'] = isset($value[25]) ? (double)$value[25] : 0;
                $info[$key]['last_average_selling_price'] = isset($value[26]) ? (double)$value[26] : 0;
                $info[$key]['average_purchase_price'] = isset($value[27]) ? (double)$value[27] : 0;
                $info[$key]['last_average_purchase_price'] = isset($value[28]) ? (double)$value[28] : 0;
                $info[$key]['price_promotion_ratio'] = isset($value[29]) ? (double)$value[29] : 0;
                $info[$key]['last_price_promotion_ratio'] = isset($value[30]) ? (double)$value[30] : 0;
                $info[$key]['average_discount_factor'] = isset($value[31]) ? (double)$value[31] : 0;
                $info[$key]['last_average_discount_factor'] = isset($value[32]) ? (double)$value[32] : 0;
                $info[$key]['average_number_per_unit'] = isset($value[33]) ? (double)$value[33] : 0;
                $info[$key]['last_average_number_per_unit'] = isset($value[34]) ? (double)$value[34] : 0;
                $info[$key]['average_amount_per_order'] = isset($value[35]) ? (double)$value[35] : 0;
                $info[$key]['last_average_amount_per_order'] = isset($value[36]) ? (double)$value[36] : 0;
                $info[$key]['online_stores'] = isset($value[37]) ? (double)$value[37] : 0;
                $info[$key]['last_online_stores'] = isset($value[38]) ? (double)$value[38] : 0;
            }
            $label = array('relation_id',
                'cityLevel_id', 'system_id', 'platform_id', 'category_id', 'menu_id', 'brand_id', 'capacity_id', 'bottle_id', 'distribution', 'last_distribution',
                'sales_numbers', 'last_sales_numbers', 'sales_quota', 'last_sales_quota', 'saleroom', 'last_saleroom', 'sales_share', 'last_sales_share', 'enrollment', 'last_enrollment', 'store_money', 'last_store_money', 'store_number', 'last_store_number',
                'sku_number', 'last_sku_number', 'distribution_store', 'last_distribution_store', 'average_selling_price', 'last_average_selling_price', 'average_purchase_price', 'last_average_purchase_price', 'price_promotion_ratio', 'last_price_promotion_ratio',
                'average_discount_factor', 'last_average_discount_factor', 'average_number_per_unit', 'last_average_number_per_unit', 'average_amount_per_order', 'last_average_amount_per_order', 'online_stores', 'last_online_stores');
            $arr = array_chunk($info, 2000);
//                                var_dump($arr);exit;
            for ($i = 0; $i < count($arr); $i++) {
                $t1 = microtime(true);
                $this->batchInsert('cola_info_12', $label, $arr[$i]);
                $t2 = microtime(true);
                $res = round($t2 - $t1, 3);
                var_dump('插入数据库' . round($res, 3) . '秒');
            }

        }
        else{
            return 0;
        }


    }

    //    请求调用Kylin接口
    public function getRetailCurl($url, $params, $header = false)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//执行结果是否被返回，0是返回，1是不返回(设置获取的信息以文件流的形式返回，而不是直接输出。)
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, 1);// 发送一个常规的POST请求
        curl_setopt($ch, CURLOPT_URL, $url);//要访问的地址,设置URL

        //把POST的变量加上
        if (!empty($params)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params); //设置POST的数据域
        }
        if ($header) {//头部信息
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //跳过SSL检查
        $output = curl_exec($ch);//执行并获取数据
//        curl_close($ch);
        if ($output === false) {
            die('Curl error: ' . curl_error($ch));
        } else {
            return json_decode($output, true); //如果获得的数据时json格式的，使用json_decode函数解释成数组。如果第二个参数为true，就转为数组的形式。如果不填就为对象的形式
        }
    }
//    插入数据库的封装函数
    public function batchInsert($form = '', $field = array(), $value = array(), $type = false)
    {
        $data = [];
        if (empty($form) || empty($field) || empty($value)) {
            return false;
        }
        if ($type) {
            $field[] = 'error';
            foreach ($value as $key => $v) {
                if ($v[7] == 'KOMHSKU') {
                    $model = 1;
                } else {
                    $bloc = RelationshipCvs::model()->find('depth = 1 and name=:name', array(':name' => $v[2]));     //全部
                    $factory = RelationshipCvs::model()->find('depth = 2 and name=:name', array(':name' => $v[3]));  //装瓶厂
                    $system_cate = SystemCvs::model()->find('depth = 1 and name=:name', array(':name' => $v[4]));   //系统大类
//                    $system_subclass = SystemCvs::model()->find('depth = 1 and name=:name', array(':name' => $v[5]));  //系统类别
                    $system_name = SystemCvs::model()->find('depth = 2 and name=:name', array(':name' => $v[5]));  //系统名称
                    $category = SkuCvs::model()->find('depth = 1 and name=:name', array(':name' => $v[8]));   //品类
                    $brand = SkuCvs::model()->find('(depth = 2 or depth = 4) and name=:name', array(':name' => $v[9]));   //品牌
                    $sku = SkuCvs::model()->find('(depth = 3 or depth = 5) and name=:name', array(':name' => $v[10])); //Sku
//&& ((isset($system_subclass)) || ($system_subclass == ''))
                    if ((isset($bloc) && isset($factory) && isset($system_cate) && isset($system_name) && isset($category) && isset($brand) && isset($sku))) {
                        $brand_parent = SkuCvs::model()->findByPk($sku->parent);  //找寻sku的父级
                        if ($brand_parent->name == $v[9]) {    //如果sku的父级（也就是品牌）与$v[9]相等
                            $c = SkuCvs::model()->findByPk($brand->parent);  //找寻品牌的父级
                            if ($c->name == $v[8]) {    //如果品牌的父级（也就是品类）与$v[8]相等
                                $model = 1;
                            } else {
                                $model = 0;
                            }
                        } else {
                            $model = 0;
                        }
                    } else {
                        $model = 0;
                    }
                }
                $v[] = $model;
                $data[] = $v;
            }
        }
        $field = ' ( `' . implode('`,`', $field) . '`) ';
        $sql = 'INSERT INTO ' . $form . $field . ' VALUES ';
        $valueString = '';
        if ($type) {
            foreach ($data as $k => $v) {
                $valueString .= ' ( "' . implode('","', $v) . '") ,';
            }
        } else {
            foreach ($value as $k => $v) {
                $valueString .= ' ( "' . implode('","', $v) . '") ,';
            }
        }
        $newsql = $sql . substr($valueString, 0, -1);
        //  pd($newsql);
        return Yii::app()->db->createCommand($newsql)->execute();
    }
//    更新数据库的封装函数
    public static function batchUpdate($form = '', $field = array(), $value = array(), $arrayId = array())
    {
        if (empty($form) || empty($field) || empty($value) || empty($arrayId)) {
            return false;
        }
        $sql = "UPDATE " . $form . " SET ";
        //合成sql语句
        foreach ($field as $key) {
            $sql .= "{$key} = CASE id ";
            foreach ($value as $newhouse_clicks_key => $newhouse_clicks_value) {
                $sql .= sprintf("WHEN %d THEN '%s' ", $newhouse_clicks_key, $newhouse_clicks_value[$key]);
            }
            $sql .= "END, ";
        }
        unset($value);
        $sql = substr($sql, 0, strrpos($sql, ','));
        $ids = implode(',', $arrayId);
        $sql .= " WHERE Id IN ({$ids})";
        Yii::app()->db->createCommand($sql)->execute();
        unset($sql, $ids);
    }

    public function actionInsert()
    {

    }
    public function updateList($label, $infoData, $table)
    {
        $count = count($infoData);  //值
        $pageSize = 2000;
        $times = ceil($count / 2000);
        for ($i = 0; $i < $times; $i++) {
            $listCvs = array_slice($infoData, $i * $pageSize, $pageSize, true);
            $arrayId = array_keys($listCvs);
            $this->batchUpdate($table, $label, $listCvs, $arrayId);
        }

    }

    public function Info_for_all($type){
        switch ($type){
            case '1':
                $this->NoChangeRate11();
//                $this->UpdateInfoData11();
                break;
            case '2':
//                $this->HasChangeRate12();
                $this->UpdateInfoData12();
                break;
            case '3':
//                $this->NoChangeRateQ1();
                $this->UpdateInfoDataQ1();
                break;
            case '4':
                $this->HasChangeRateQ2();
                $this->UpdateInfoDataQ2();
                break;
        }
    }
//11月
    public function NoChangeRate11()
    {
        ini_set('memory_limit','-1');
        //判断该期数据是否有VS PP，有则需要获得上期数据，否则不需要
        $zpjt = Relation::model()->findAll(['condition' => 'depth=1', 'index' => 'name']); //装瓶集团，有全部
        $zpc = Relation::model()->findAll(['condition' => 'depth=2', 'index' => 'name']);//装瓶厂，没有全部
        $city = Relation::model()->findAll(['condition' => 'depth=3', 'index' => 'name']);//城市，没有全部
        $city_level = Citylevel::model()->findAll(['index' => 'name']); //城市等级，有全部
        $channel = System::model()->findAll(['index' => 'name']);//渠道，有全部
        $platform = Platform::model()->findAll(['index' => 'name']);//平台，有全部
        $category = Category::model()->findAll(['index' => 'name']);//品类，有全部
        $manu = Menu::model()->findAll(['index' => 'name']);//制造商，有全部
        $pinpai = Brand::model()->findAll(['index' => 'name']);//品牌，有全部
        $level = TotalClassify::model()->findAll(['condition' => 'classify=1', 'index' => 'name']); //容量分级，有全部
        $pack_level = TotalClassify::model()->findAll(['condition' => 'classify=2', 'index' => 'name']); //瓶量分级，有全部
        $this->NoChangeRateCircle11($zpjt,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpjt');
        var_dump('-----------------------------------------1');
        $this->NoChangeRateCircle11($zpc,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpc');
        var_dump('-----------------------------------------2');
        $this->NoChangeRateCircle11($city,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'city');
        var_dump('-----------------------------------------3');
    }
    public function NoChangeRateCircle11($Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level,$region)
    {
        $brand=$pinpai;
        $capacity=$level;
        $bottle=$pack_level;
        $zpjt_arr=["'全部' zpjt",' zpjt'];
        $city_level_arr=["'全部' city_level",'city_level'];
        $channel_arr=["'全部' channel",'channel'];
        $platform_arr=["'全部' platform",'platform'];
        $type_arr=["'全部' type",'type'];
//        $manu_arr=['manu',"'全部' manu"];
        $manu_arr=["'全部' manu",'manu'];
        $pinpai_arr=["'全部' pinpai",'pinpai'];
        $level_arr=["'全部' level",'level'];
        $pack_level_arr=["'全部' pack_level",'pack_level'];
        $datasql = array();
        $times=0;
        switch ($region){
            case 'zpjt':
                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                    foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                        foreach($channel_arr as $channelkey => $channelvalue){
                            foreach($platform_arr as $platformkey => $platformvalue){
                                foreach($type_arr as $typekey => $typevalue){
                                    foreach ($manu_arr as $manukey => $manuvalue){
                                        foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                            foreach ($level_arr as $level => $levelvalue){
                                                foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                    $times++;
                                                    var_dump('这是第'.$times.'次循环');
                                                    Yii::log(print_r($times,true),'warning');
                                                    $select_1=''.$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                    $select_2=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS a_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                    $select_4=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS thiszpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                    $select_6=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as store_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                    $select_8=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as allstore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                    $on_1='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=a_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                    $on_3='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=thiszpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                    $on_5='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=store_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                    $on_7='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=allstore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                    $on_1=rtrim($on_1,'and ');
                                                    $on_3=rtrim($on_3,'and ');
                                                    $on_5=rtrim($on_5,'and ');
                                                    $on_7=rtrim($on_7,'and ');
                                                    $datainfosql="SELECT "
                                                        .$select_1.
                                                        "sum(salescount),
	sum(sales_amount),
	count(distinct storeid_copy),
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	c.ko_amount,
	c.ko_count,
	store.store_num,
	store.store_orders,
	allstore.allstores	
FROM
	sku_2018
	LEFT JOIN (
	SELECT
		count(*) AS a_sku_number,
		sum(cuxiao) as a_cuxiao,
		sum(dis) as a_dis,
		sum(on_sale) as a_on_sale,".$select_2.
                                                        " FROM
		sku_2018 
WHERE
		dt='2018-11-01'
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type
		) AS a ON(".$on_1.") 
	LEFT JOIN (SELECT "." ".$select_4. "sum(sales_amount) ko_amount,
		sum(salescount) ko_count
	FROM
		sku_2018 
	WHERE
		dt='2018-11-01'
	
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS c ON (".$on_3.")
	LEFT JOIN (
	SELECT ".$select_6.
                                                        "COUNT(DISTINCT ID) store_num,
	    sum(salecount) store_orders
	FROM
		stores_2018 
	WHERE
		dt='2018-11-01'
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	
	LEFT JOIN (
	SELECT ".$select_8.
                                                        "sum(xxmd) allstores
	FROM
		xxmd
	GROUP BY
		zpjt,
		city_level,
		channel
		) AS allstore ON (".$on_7.")
WHERE
		dt='2018-11-01'

GROUP BY
	level,
	pack_level,
	zpjt,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	c.ko_amount,
	c.ko_count,
	store.store_num,
	store.store_orders,
	allstore.allstores";

                                                    $datasql[] = $datainfosql;
//                                                    echo"<pre>";var_dump($datainfosql);exit;
                                                    $this->NoChangeRateRequest11($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//                                                    exit;
//                                                    $j=0;
//                                                    $res=true;
//                                                    while($res){
//                                                        $start=$j*100000;
//                                                        $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                        $j++;
//                                                    }
                                                }
                                            }
                                        }
                                    }

                                }
                            }
                        }
                    }
                }
                var_dump('装瓶集团数据已跑完');
                break;
            case 'zpc':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
                                foreach ($manu_arr as $manukey => $manuvalue){
                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                        foreach ($level_arr as $level => $levelvalue){
                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                $times++;
//                                                var_dump('这是第'.$times.'次循环');
                                                $select_1=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                $select_2=' zpc AS a_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                $select_6=' zpc as store_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                $select_8=' zpc as allstore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                $on_1=' zpc=a_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                $on_5=' zpc=store_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                $on_7=' zpc=allstore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                $on_1=rtrim($on_1,'and ');
                                                $on_3=rtrim($on_3,'and ');
                                                $on_5=rtrim($on_5,'and ');
                                                $on_7=rtrim($on_7,'and ');
                                                $datainfosql="SELECT "
                                                    .$select_1.
                                                    "sum(salescount),
	sum(sales_amount),
	count(distinct storeid_copy),
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	c.ko_amount,
	c.ko_count,
	store.store_num,
	store.store_orders,
	allstore.allstores	
FROM
	sku_2018
	LEFT JOIN (
	SELECT 
		count(*) AS a_sku_number,
		sum(cuxiao) as a_cuxiao,
		sum(dis) as a_dis,
		sum(on_sale) as a_on_sale,".$select_2.
                                                    " FROM
		sku_2018 
	WHERE
		dt='2018-11-01'
	
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT  ".$select_4.
                                                    " sum(sales_amount) ko_amount,
		sum(salescount) ko_count
	FROM
		sku_2018
	WHERE
		dt='2018-11-01'
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS c ON (".$on_3.")
	LEFT JOIN (
	SELECT ".$select_6.
                                                    " COUNT(DISTINCT ID) store_num,
	    sum(salecount) store_orders
	FROM
		stores_2018 
	WHERE
		dt='2018-11-01'
	GROUP BY
		zpc,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_8.
                                                    " sum(xxmd) allstores
	FROM
		xxmd
	GROUP BY
		zpc,
		city_level,
		channel
		) AS allstore ON (".$on_7.")
WHERE
		dt='2018-11-01'

GROUP BY
	level,
	pack_level,
	zpc,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	c.ko_amount,
	c.ko_count,
	store.store_num,
	store.store_orders,
	allstore.allstores";
                                                $datasql[] = $datainfosql;
//                                                echo "<pre>";var_dump($datainfosql);exit;
                                                $this->NoChangeRateRequest11($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
//                }
                break;
            case 'city':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
                                foreach ($manu_arr as $manukey => $manuvalue){
                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                        foreach ($level_arr as $level => $levelvalue){
                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                $times++;
                                                var_dump('这是第'.$times.'次循环');
                                                $select_1=' city,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                $select_2=' city AS a_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                $select_6=' city as store_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                $select_8=' city as allstore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                $on_1=' city=a_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                $on_5=' city=store_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                $on_7=' city=allstore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                $on_1=rtrim($on_1,'and ');
                                                $on_3=rtrim($on_3,'and ');
                                                $on_5=rtrim($on_5,'and ');
                                                $on_7=rtrim($on_7,'and ');
                                                $datainfosql="SELECT "
                                                    .$select_1.
                                                    "sum(salescount),
	sum(sales_amount),
	count(distinct storeid_copy),
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	c.ko_amount,
	c.ko_count,
	store.store_num,
	store.store_orders,
	allstore.allstores	
FROM
	sku_2018
	LEFT JOIN (
	SELECT 
		count(*) AS a_sku_number,
		sum(cuxiao) as a_cuxiao,
		sum(dis) as a_dis,
		sum(on_sale) as a_on_sale,".$select_2.
                                                    " FROM
		sku_2018 
	WHERE
		dt='2018-11-01'
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT  ".$select_4.
                                                    " sum(sales_amount) ko_amount,
		sum(salescount) ko_count
	FROM
		sku_2018
	WHERE
		dt='2018-11-01'
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS c ON (".$on_3.")
	LEFT JOIN (
	SELECT ".$select_6.
                                                    " COUNT(DISTINCT ID) store_num,
	    sum(salecount) store_orders
	FROM
		stores_2018
	WHERE
		dt='2018-11-01'
	GROUP BY
		city,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_8.
                                                    " sum(xxmd) allstores
	FROM
		xxmd 
	GROUP BY
		city,
		city_level,
		channel
		) AS allstore ON (".$on_7.")
WHERE
		dt='2018-11-01'
GROUP BY
	level,
	pack_level,
	city,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	c.ko_amount,
	c.ko_count,
	store.store_num,
	store.store_orders,
	allstore.allstores";
                                                $this->NoChangeRateRequest11($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
                var_dump('城市数据已跑完');
                break;
        }
//        $res=true;
//        while($res){
//            $start=$j*20000;
//            $res = $this->getinfo_v($datasql[255],$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//            $j++;
//        }
//        for($i=96;$i<count($datasql);$i++){
//            var_dump('这是第'.$i.'次循环');echo "<br/>";
//            $this->NoChangeRateRequest($datasql[$i],$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//        }
//        exit;
    }
    public function NoChangeRateRequest11($datainfosql, $Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level ,$region)
    {
        $base = base64_encode('admin:KYLIN');
        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
        $params = CJSON::encode([
            'sql' => $datainfosql,
            'project' => 'O2O_retail',
            "acceptPartial" => false,
//            'offset' => $start,
//            'limit' => 100000
        ]);
        $t1 = microtime(true);
        $data = $this->getRetailCurl($url, $params, $header);
        $t2 = microtime(true);
        var_dump('麒麟调用数据耗时' . round($t2 - $t1, 3) . '秒');
        $data = $data["results"];
//       echo "<pre/>";var_dump($data);exit;
        if (!empty($data)) {//不为空的判断
            $info = array();
            foreach ($data as $key => $value) {
                switch($region){
                    case 'zpjt':
                        $info[$key]['relation_id'] = $value[0] == "SCCL" ? 2 : ($value[0] == "CBL" ? 3 : ($value[0] == "ZH" ? 65 : ($value[0] == "全部" ? 1 : 0)));
                        break;
                    case 'zpc':
                        $Relationid = $Relation[$value[0]];
                        $info[$key]['relation_id'] = $Relationid ? $Relationid->id : 0;
                        break;
                    case 'city':
                        $city=rtrim($value[0], "市");
                        $Relationid = $Relation[$city];
                        $info[$key]['relation_id'] = $Relationid ? $Relationid->id : 0;
                        break;
                }
                $city_levelid = isset($Citylevel[$value[1]]) ? $Citylevel[$value[1]]->id : 0;
                $info[$key]['cityLevel_id'] = $city_levelid;
                $channelid = isset($System[$value[2]]) ? $System[$value[2]]->id : 0;
                $info[$key]['system_id'] = $channelid;
                $platformid = isset($Platform[$value[3]]) ? $Platform[$value[3]]->id : 0;
                $info[$key]['platform_id'] = $platformid;
                $skuid = isset($Category[$value[4]]) ? $Category[$value[4]]->id : 0;
                $info[$key]['category_id'] = $skuid;
                $manuid = isset($manu[$value[5]]) ? $manu[$value[5]]->id : 0;
                $info[$key]['menu_id'] = $manuid;
                $pinpaiid = isset($pinpai[$value[6]]) ? $pinpai[$value[6]]->id : 0;
                $info[$key]['brand_id'] = $pinpaiid;
                $info[$key]['capacity_id'] = isset($level[$value[7]]) ? $level[$value[7]]->id : 0;
                $info[$key]['bottle_id'] = isset($pack_level[$value[8]]) ? $pack_level[$value[8]]->id : 0;
                $info[$key]['distribution'] = $value[18]!=0?($value[11]/$value[18]):0;
//                $info[$key]['last_distribution'] = ($value[27]!=0&&$value[29]!=0)?$value[11]/$value[27]-$value[19]/$value[29]:0;
                $info[$key]['sales_numbers'] = $value[9];
//                $info[$key]['last_sales_numbers'] = $value[17]!=0?($value[9]-$value[17])/$value[17]:0;
                $info[$key]['sales_quota'] = $value[17]!=0?($value[9]/$value[17]):0;
//                $info[$key]['last_sales_quota'] = ($value[24]!=0 && $value[26]!=0)?($value[9]/$value[24]-$value[18]/$value[26]):0;
                $info[$key]['saleroom'] = $value[10];
//                $info[$key]['last_saleroom'] =$value[16]!=0?($value[10]-$value[16])/$value[16]:0;
                $info[$key]['sales_share'] = $value[16]!=0?($value[10]/$value[16]):0;
//                $info[$key]['last_sales_share'] = ($value[25]!=0&& $value[23]!=0 && $value[23]!='')?($value[10]/$value[23]-$value[16]/$value[25]):0;
                if($platformid==1){
                    $info[$key]['enrollment'] = $value[20]!=0?($value[18]/$value[20])/3:0;
                }
                else{
                    $info[$key]['enrollment'] = $value[20]!=0 ?($value[18]/$value[20]):0;
                }
//                $info[$key]['last_enrollment'] = $value[31]!=0?($value[27]/$value[31]-$value[29]/$value[31]):0;
                $info[$key]['store_money'] = $value[11]!=0 ?($value[10]/$value[11]):0;
//                $info[$key]['last_store_money'] = ($value[16]!=0 &&$value[19]!=0 &&$value[11]!=0)?($value[10]/$value[11]-$value[16]/$value[19])/($value[16]/$value[19]):0;
                $info[$key]['store_number'] = $value[11]!=0 ?($value[9]/$value[11]):0;
//                $info[$key]['last_store_number'] = ($value[9]!=0&&$value[19]!=0&&$value[17]!=0)?($value[9]/$value[11]-$value[17]/$value[19])/($value[17]/$value[19]):0;
                if($skuid==1){
                    $info[$key]['sku_number'] = $value[18]!=0?($value[12]/$value[18]):0;
//                    $info[$key]['last_sku_number'] = ($value[27]!=0&&$value[29]!=0&&$value[18]!=0)?($value[12]/$value[27]-$value[18]/$value[29])/($value[18]/$value[29]):0;
                }
                else{
                    $info[$key]['sku_number'] = $value[11]!=0?($value[12]/$value[11]):0;
//                    $info[$key]['last_sku_number'] = ($value[27]!=0&&$value[19]!=0&&$value[18]!=0)?($value[12]/$value[11]-$value[18]/$value[19])/($value[18]/$value[19]):0;
                }
                $info[$key]['distribution_store'] = $value[11]!=0?$value[11]:0;
//                $info[$key]['last_distribution_store'] = $value[19]!=0?($value[11]-$value[19])/$value[19]:0;
                $info[$key]['average_selling_price'] = $value[12]!=0?($value[13]/$value[12]):0;
//                $info[$key]['last_average_selling_price'] =  ($value[12]!=0&&$value[20]!=0&&$value[18]!=0)?($value[13]/$value[12]-$value[20]/$value[18])/($value[20]/$value[18]):0;
                $info[$key]['average_purchase_price'] = $value[9]!=0?($value[10]/$value[9]):0;
//                $info[$key]['last_average_purchase_price'] = ($value[16]!=0&&$value[17]!=0&&$value[9]!=0)?($value[10]/$value[9]-$value[16]/$value[17])/($value[16]/$value[17]):0;
                $info[$key]['price_promotion_ratio'] = $value[12]!=0?($value[15]/$value[12]):0;
//                $info[$key]['last_price_promotion_ratio'] = ($value[12]!=0&&$value[20]!=0)?$value[15]/$value[12]-$value[22]/$value[20]:0;
                $info[$key]['average_discount_factor'] = $value[15]!=0?($value[14]/$value[15]):0;
//                $info[$key]['last_average_discount_factor'] =($value[15]!=0&&$value[22]!=0)? ($value[14]/$value[15]-$value[21]/$value[22]):0;
                $info[$key]['average_number_per_unit'] = $value[19]!=0?($value[9]/$value[19]):0;
//                $info[$key]['last_average_number_per_unit'] =  ($value[9]!=0&&$value[17]!=0&&$value[30]!=0)?($value[9]/$value[28]-$value[17]/$value[30])/($value[17]/$value[30]):0;
                $info[$key]['average_amount_per_order'] = $value[19]!=0?$value[10]/$value[19]:0;
//                $info[$key]['last_average_amount_per_order'] = ($value[10]!=0&&$value[16]!=0&&$value[30]!=0)?($value[10]/$value[28]-$value[16]/$value[30])/($value[16]/$value[30]):0;
                if($skuid==1){
                    $info[$key]['online_stores'] = $value[18]!=''?$value[18]:0;
                }
                else{
                    $info[$key]['online_stores'] = $value[11]!=''?$value[11]:0;
                }

//                $info[$key]['last_online_stores'] = $value[29]!=0?(($value[27]-$value[29])/$value[29]):0;
            }
            $label = array('relation_id',
                'cityLevel_id', 'system_id', 'platform_id', 'category_id', 'menu_id', 'brand_id', 'capacity_id', 'bottle_id', 'distribution',
                'sales_numbers',  'sales_quota',  'saleroom',  'sales_share', 'enrollment',  'store_money', 'store_number',
                'sku_number', 'distribution_store',  'average_selling_price', 'average_purchase_price',  'price_promotion_ratio',
                'average_discount_factor',  'average_number_per_unit',  'average_amount_per_order', 'online_stores');
            $arr = array_chunk($info, 2000);
            for ($i = 0; $i < count($arr); $i++) {
                $t1 = microtime(true);
                $this->batchInsert('cola_info_2018_11_0', $label, $arr[$i]);
                $t2 = microtime(true);
                $res = round($t2 - $t1, 3);
                var_dump('插入数据库' . round($res, 3) . '秒');
            }
        }
        else {
            return 0;
        }
    }

    public function UpdateInfoData11()
    {
        ini_set('memory_limit','-1');

        $zpjt = Relation::model()->findAll(['condition' => 'depth=1', 'index' => 'name']); //装瓶集团，有全部
        $zpc = Relation::model()->findAll(['condition' => 'depth=2', 'index' => 'name']);//装瓶厂，没有全部
        $city = Relation::model()->findAll(['condition' => 'depth=3', 'index' => 'name']);//城市，没有全部
        $city_level = Citylevel::model()->findAll(['index' => 'name']); //城市等级，有全部
        $channel = System::model()->findAll(['index' => 'name']);//渠道，有全部
        $platform = Platform::model()->findAll(['index' => 'name']);//平台，有全部
        $category = Category::model()->findAll(['index' => 'name']);//品类，有全部
        $manu = Menu::model()->findAll(['index' => 'name']);//制造商，有全部
        $pinpai = Brand::model()->findAll(['index' => 'name']);//品牌，有全部
        $level = TotalClassify::model()->findAll(['condition' => 'classify=1', 'index' => 'name']); //容量分级，有全部
        $pack_level = TotalClassify::model()->findAll(['condition' => 'classify=2', 'index' => 'name']); //瓶量分级，有全部
        $this->getInfo_update11($zpjt,$city_level,$channel,$platform,$category,$manu,$pinpai,$level,$pack_level,'zpjt');
        var_dump('-----------------------------------------1');
        $this->getInfo_update11($zpc,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpc');
        var_dump('-----------------------------------------2');
        $this->getInfo_update11($city,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'city');
        var_dump('-----------------------------------------3');
    }
    public function getInfo_update11($Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level,$region)
    {
//        Yii::log('123456789465','error');exit;
//        var_dump("123456789");
//        set_time_limit('-1');//不限制执行时间
        $brand=$pinpai;
        $capacity=$level;
        $bottle=$pack_level;
        $zpjt_arr=["'全部' zpjt",' zpjt'];
        $city_level_arr=["'全部' city_level",'city_level'];
        $channel_arr=["'全部' channel",'channel'];
        $platform_arr=["'全部' platform",'platform'];
        $type_arr=["'全部' type",'type'];
//        $type_arr=['type'];
        $manu_arr=["'全部' manu",'manu'];
        $pinpai_arr=["'全部' pinpai",'pinpai'];
        $level_arr=["'全部' level",'level'];
        $pack_level_arr=["'全部' pack_level",'pack_level'];
        $datasql = array();
        $times=0;
//        switch ($region){
//            case 'zpjt':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
//                    foreach($city_level_arr as $city_levelkey => $city_levelvalue){
//                        foreach($channel_arr as $channelkey => $channelvalue){
//                            foreach($platform_arr as $platformkey => $platformvalue){
//                                foreach($type_arr as $typekey => $typevalue){
////                                    foreach ($manu_arr as $manukey => $manuvalue){
//                                        foreach ($pinpai_arr as $pinpai => $pinpaivalue){
//                                            foreach ($level_arr as $level => $levelvalue){
//                                                foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                    $times++;
//                                                    var_dump('这是第'.$times.'次循环');
//                                                    Yii::log(print_r($times,true),'warning');
////                                                   echo '<pre>';var_dump($datasql);exit;
////                                                   exit;
//                                                    $select_1=''.$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
////                                                    $select_3=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS lastzpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
////                                                    $on_2='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastzpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
////                                                    $on_2=rtrim($on_2,'and ');
////                                                    $datainfosql="SELECT ".$select_1."
////	sum(sales_amount),
////	sum(salescount)
////FROM
////	sku_2019
////WHERE
////	dt between '2019-01-01' and '2019-03-01'
////GROUP BY
////	LEVEL,
////	pack_level,
////	zpjt,
////	city_level,
////	channel,
////	platform,
////	type,
////	pinpai";
////                                                    $datainfosql="SELECT ".$select_1."
////	count(*)*1.0/count(distinct storeid)
////FROM
////	sku_2018
////WHERE
////	dt = '2018-11-01'
////GROUP BY
////	LEVEL,
////	pack_level,
////	zpjt,
////	city_level,
////	channel,
////	platform,
////	type,
////	manu,
////	pinpai";
//                                                    $datainfosql="SELECT ".$select_1."
//	count(*)*1.0,count(distinct storeid),
//FROM
//	sku_2018
//	left join (
//	    select count(distinct)
//	)
//WHERE
//	manu='可口可乐' and dt between '2019-01-01' and '2019-03-01'
//GROUP BY
//	LEVEL,
//	pack_level,
//	zpjt,
//	city_level,
//	channel,
//	platform,
//	type,
//	manu,
//	pinpai";
//                                                    $datasql[] = $datainfosql;
////                                                   echo '<pre>';var_dump($datainfosql);exit;
//                                                    $j=0;
//                                                    $res=true;
//                                                    while($res){
//                                                        $start=$j*100000;
//                                                        $res = $this->update_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//                                                        $j++;
//                                                    }
//                                                }
//                                            }
//                                        }
//                                    }
//
////                                }
//                            }
//                        }
//                    }
//                }
//                var_dump('装瓶集团数据已跑完');
//                break;
//            case 'zpc':
////                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
//                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
//                    foreach($channel_arr as $channelkey => $channelvalue){
//                        foreach($platform_arr as $platformkey => $platformvalue){
//                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
//                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
//                                        foreach ($level_arr as $level => $levelvalue){
//                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                $times++;
//                                                var_dump('这是第'.$times.'次循环');
////                                                $select_1=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
////                                                $select_3=' zpc AS lastzpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
////                                                $on_2=' zpc=lastzpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
////                                                $on_2=rtrim($on_2,'and ');
//                                                $select_4=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                $datainfosql="SELECT ".$select_4."
//	count(*)*1.0/count(distinct storeid)
//FROM
//	sku_2018
//WHERE
//	dt = '2018-11-01'
//GROUP BY
//	LEVEL,
//	pack_level,
//	zpc,
//	city_level,
//	channel,
//	platform,
//	type,
//	manu,
//	pinpai";
//                                                $datasql[] = $datainfosql;
////                                                   echo '<pre>';var_dump($datainfosql);exit;
//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->update_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//                                                    $j++;
//                                                }
//                                            }
//                                        }
//                                    }
//                                }
//
//                            }
//                        }
//                    }
//                }
//                var_dump('装瓶厂数据已跑完');
//                break;
//            case 'city':
//                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
//                    foreach($channel_arr as $channelkey => $channelvalue){
//                        foreach($platform_arr as $platformkey => $platformvalue){
//                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
//                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
//                                        foreach ($level_arr as $level => $levelvalue){
//                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                $times++;
//                                                var_dump('这是第'.$times.'次循环');
//                                                $select_4=' city,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                $datainfosql="SELECT ".$select_4."
//	count(*)*1.0/count(distinct storeid)
//FROM
//	sku_2018
//WHERE
//	dt = '2018-11-01'
//GROUP BY
//	LEVEL,
//	pack_level,
//	city,
//	city_level,
//	channel,
//	platform,
//	type,
//	manu,
//	pinpai";
//                                                $datasql[] = $datainfosql;
////                                                echo '<pre>';var_dump($datainfosql);exit;
////                                                $j=0;
////                                                $res=true;
//////                                                   exit;
////                                                while($res){
////                                                    $start=$j*100000;
////                                                    $res = $this->update_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
////                                                    $j++;
////                                                }
//////
//                                            }
//                                        }
//                                    }
//                                }
//
//                            }
//                        }
//                    }
//                }
//                var_dump('城市数据已跑完');
//                break;
//        }
        switch ($region){
            case 'zpjt':
                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                    foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                        foreach($channel_arr as $channelkey => $channelvalue){
                            foreach($platform_arr as $platformkey => $platformvalue){
                                foreach($type_arr as $typekey => $typevalue){
//                                    foreach ($manu_arr as $manukey => $manuvalue){
                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                        foreach ($level_arr as $level => $levelvalue){
                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                $times++;
                                                var_dump('这是第'.$times.'次循环');
                                                Yii::log(print_r($times,true),'warning');
                                                $select_1=''.$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                    $select_2=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS a_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
//                                                    $select_3=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS lastzpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
//                                                    $select_4=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS thiszpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
//                                                    $select_5=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS d_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                                $select_6=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as store_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?'':' AS store_platform');
                                                $select_7=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as laststore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                                $select_8=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as allstore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                $select_9=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as lastoff_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastoff_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastoff_channel,');
//                                                    $on_1='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=a_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
//                                                    $on_2='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastzpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=thiszpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
//                                                    $on_4='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=d_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');
                                                $on_5='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=store_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                $on_6='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=laststore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                                $on_7='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=allstore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                $on_8='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastoff_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastoff_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=lastoff_channel');

//                                                    $on_1=rtrim($on_1,'and ');
//                                                    $on_2=rtrim($on_2,'and ');
//                                                    $on_3=rtrim($on_3,'and ');
//                                                    $on_4=rtrim($on_4,'and ');
                                                $on_5=rtrim($on_5,'and ');
                                                $on_6=rtrim($on_6,'and ');
                                                $on_7=rtrim($on_7,'and ');
                                                $on_8=rtrim($on_8,'and ');

                                                $datainfosql="SELECT "
                                                    .$select_1.
                                                    "
	count(*),
	count( DISTINCT storeid_copy ),	
	store.store_num
FROM
	sku_2018
	LEFT JOIN (
	SELECT
		count(DISTINCT id) as store_num,".$select_6. " FROM
		stores_2018 
	where dt='2018-11-01'	
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel
		) AS store ON(".$on_5.") 
where manu='可口可乐' and dt='2018-11-01'				
GROUP BY
	level,
	pack_level,
	zpjt,
	city_level,
	channel,
	platform,
	type,
	pinpai,
	store.store_num";

                                                $datasql[] = $datainfosql;
//                                                    echo"<pre>";var_dump($datainfosql);exit;
//                                                if($times<118){
                                                $this->update_v11($datainfosql,0,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//                                                }
                                                //
                                                //exit;
//                                                    $j=0;
//                                                    $res=true;
//                                                    while($res){
//                                                        $start=$j*100000;
//                                                        $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                        $j++;
//                                                    }
                                            }
                                        }
                                    }
                                }

//                                }
                            }
                        }
                    }
                }
                var_dump('装瓶集团数据已跑完');
                break;
            case 'zpc':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
                                foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                    foreach ($level_arr as $level => $levelvalue){
                                        foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                            $times++;
                                            var_dump('这是第'.$times.'次循环');
                                            $select_1=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                $select_2=' zpc AS a_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
//                                                $select_3=' zpc AS lastzpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
////                                                    $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ');
////                                                    $select_5=' zpc AS d_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ');
//                                                $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
//                                                $select_5=' zpc AS d_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                            $select_6=' zpc as store_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?'':' AS store_platform');
                                            $select_7=' zpc as laststore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                            $select_8=' zpc as allstore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                            $select_9=' zpc as lastoff_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastoff_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastoff_channel,');

//                                                $on_1=' zpc=a_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
//                                                $on_2=' zpc=lastzpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype  ');
//                                                    $on_4=' zpc=d_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type  ');
//                                                $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
//                                                $on_4=' zpc=d_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');

                                            $on_5=' zpc=store_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                            $on_6=' zpc=laststore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                            $on_7=' zpc=allstore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                            $on_8=' zpc=lastoff_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastoff_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=lastoff_channel');

//                                                $on_1=rtrim($on_1,'and ');
//                                                $on_2=rtrim($on_2,'and ');
//                                                $on_3=rtrim($on_3,'and ');
//                                                $on_4=rtrim($on_4,'and ');
                                            $on_5=rtrim($on_5,'and ');
                                            $on_6=rtrim($on_6,'and ');
                                            $on_7=rtrim($on_7,'and ');
                                            $on_8=rtrim($on_8,'and ');
                                            $datainfosql="SELECT "
                                                .$select_1.
                                                "
	count(*),
	count( DISTINCT storeid_copy ),	
	store.store_num
FROM
	sku_2018
	LEFT JOIN (
	SELECT
		count(DISTINCT id) as store_num,".$select_6. " FROM
		stores_2018
	where dt='2018-11-01'	 
	GROUP BY
		zpc,
		city_level,
		platform,
		channel
		) AS store ON(".$on_5.") 
where manu='可口可乐' and dt='2018-11-01'		
GROUP BY
	level,
	pack_level,
	zpc,
	city_level,
	channel,
	platform,
	type,
	pinpai,
	store.store_num";
//                                                if($region=='zpc'){
//                                                    $datainfosql=str_replace('zpjt','zpc',$datainfosql);
//                                                }
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
                                            $datasql[] = $datainfosql;
//                                                echo "<pre>";var_dump($datainfosql);exit;
                                            $this->update_v11($datainfosql,0,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);

//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                    $j++;
//                                                }
                                        }
                                    }
//                                    }
                                }

                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
//                }
                break;
            case 'city':
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
                                foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                    foreach ($level_arr as $level => $levelvalue){
                                        foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                            $times++;
                                            var_dump('这是第'.$times.'次循环');
                                            $select_1=' city,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                $select_2=' city AS a_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
//                                                $select_3=' city AS lastcity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
////                                                    $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ');
////                                                    $select_5=' city AS d_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ');
//                                                $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
//                                                $select_5=' city AS d_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                            $select_6=' city as store_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?'':' AS store_platform');
                                            $select_7=' city as laststore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                            $select_8=' city as allstore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                            $select_9=' city as lastoff_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastoff_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastoff_channel,');

//                                                $on_1=' city=a_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
//                                                $on_2=' city=lastcity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype  ');
//                                                    $on_4=' city=d_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type  ');
//                                                $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
//                                                $on_4=' city=d_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');

                                            $on_5=' city=store_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                            $on_6=' city=laststore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                            $on_7=' city=allstore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                            $on_8=' city=lastoff_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastoff_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=lastoff_channel');

//                                                $on_1=rtrim($on_1,'and ');
//                                                $on_2=rtrim($on_2,'and ');
//                                                $on_3=rtrim($on_3,'and ');
//                                                $on_4=rtrim($on_4,'and ');
                                            $on_5=rtrim($on_5,'and ');
                                            $on_6=rtrim($on_6,'and ');
                                            $on_7=rtrim($on_7,'and ');
                                            $on_8=rtrim($on_8,'and ');
                                            $datainfosql="SELECT "
                                                .$select_1. "
	count(*),
	count( DISTINCT storeid_copy ),	
	store.store_num
FROM
	sku_2018
	LEFT JOIN (
	SELECT
		count(DISTINCT id) as store_num,".$select_6. " FROM
		stores_2018
	where dt='2018-11-01'	
	GROUP BY
		city,
		city_level,
		platform,
		channel
		) AS store ON(".$on_5.") 			
where manu='可口可乐' and dt='2018-11-01'		
GROUP BY
	level,
	pack_level,
	city,
	city_level,
	channel,
	platform,
	type,
	pinpai,
	store.store_num";
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
                                            $datasql[] = $datainfosql;
//                                                echo "<pre>";var_dump($datainfosql);exit;
                                            $this->update_v11($datainfosql,0,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);

//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                    $j++;
//                                                }
                                        }
                                    }
//                                    }
                                }

                            }
                        }
                    }
                }
                var_dump('城市数据已跑完');
                break;
        }


//        echo "<pre>"; var_dump($datasql[255]);exit;

    }
    public function update_v11($datainfosql,$start, $Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level ,$region)
    {
//        set_time_limit('-1');//不限制执行时间
//        var_dump(1255664);
        $base = base64_encode('admin:KYLIN');
        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
        $params = CJSON::encode([
            'sql' => $datainfosql,
            'project' => 'O2O_retail',
            "acceptPartial" => false,
//            'offset' => $start,
//            'limit' => 20000
        ]);
        $t1 = microtime(true);
        $data = $this->getRetailCurl($url, $params, $header);
        $t2 = microtime(true);
        var_dump('麒麟调用数据耗时' . round($t2 - $t1, 3) . '秒');
        $data = $data["results"];
        $uodatedata=[];
//       echo "<pre/>";var_dump($data);exit;
        if (!empty($data)) {//不为空的判断
            $info = array();
            var_dump('又一次请求');
            foreach ($data as $key => $value) {
                $reg=1;
                switch($region){
                    case 'zpjt':
                        $reg = $value[0] == "SCCL" ? 2 : ($value[0] == "CBL" ? 3 : ($value[0] == "ZH" ? 65 : ($value[0] == "全部" ? 1 : 0)));
                        break;
                    case 'zpc':
                        $Relationid = $Relation[$value[0]];
                        $reg = $Relationid ? $Relationid->id : 0;
                        break;
                    case 'city':
                        $city=rtrim($value[0], "市");
                        $Relationid = $Relation[$city];
                        $reg = $Relationid ? $Relationid->id : 0;
                        break;
                }
                $city_levelid = isset($Citylevel[$value[1]]) ? $Citylevel[$value[1]]->id : 0;
                $info[$key]['cityLevel_id'] = $city_levelid;
                $channelid = isset($System[$value[2]]) ? $System[$value[2]]->id : 0;
                $info[$key]['system_id'] = $channelid;
                $platformid = isset($Platform[$value[3]]) ? $Platform[$value[3]]->id : 0;
                $info[$key]['platform_id'] = $platformid;
                $skuid = isset($Category[$value[4]]) ? $Category[$value[4]]->id : 0;
                $info[$key]['category_id'] = $skuid;
//                $manuid = isset($manu[$value[5]]) ? $manu[$value[5]]->id : 0;
//                $info[$key]['menu_id'] = $manuid;
                $pinpaiid = isset($pinpai[$value[5]]) ? $pinpai[$value[5]]->id : 0;
                $info[$key]['brand_id'] = $pinpaiid;
                $info[$key]['capacity_id'] = isset($level[$value[6]]) ? $level[$value[6]]->id : 0;
                $info[$key]['bottle_id'] = isset($pack_level[$value[7]]) ? $pack_level[$value[7]]->id : 0;
                if($skuid===1){
//                    不选品类
                    $sku_number=$value[10]!=0?$value[8]/$value[10]:0;
                }
                else{
//                    选品类
                    $sku_number=$value[9]!=0?$value[8]/$value[9]:0;
                }

//                    $data1 =Info::model()->tableName('2018_12_0')->find(array('condition'=>'relation_id='.$reg.' and cityLevel_id='.$city_levelid.' and system_id='.$channelid.' and platform_id='.$platformid
//                    .' and category_id='.$skuid.' and menu_id='.$manuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id']));
//                sku_number
                $sql='select id from cola_info_2018_11_0 where relation_id='.$reg.' and cityLevel_id='.$city_levelid.' and system_id='.$channelid.' and platform_id='.$platformid
                    .' and category_id='.$skuid.' and brand_id='.$pinpaiid.' and menu_id=2 and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id'];
//                $sql='select id,saleroom,sales_numbers from cola_info_2019_q1_0 where relation_id='.$reg.' and cityLevel_id='.$city_levelid.' and system_id='.$channelid.' and platform_id='.$platformid
//                    .' and category_id='.$skuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id'];
                $t1 = microtime(true);
//                    $data1=Yii::app()->db->createCommand($sql)->queryRow();
//                var_dump($sql);
                $data1=Yii::app()->db->createCommand($sql)->queryAll();

                foreach ($data1 as $key =>$value1){
//                    echo "<pre>";var_dump($value[8]);var_dump($value1['sku_number']);exit;
                    $uodatedata[$value1['id']]=array(
                        'sku_number' => $sku_number,
//                        'last_sku_number' => $value[9]!=0?($value1['sku_number']-$value[9])/$value[9]:0,
//                        'sales_quota' => $value[9]!=0?$value1['sales_numbers']/$value[9]:0,
                    );
                }
//                $t2 = microtime(true);
//                $res = round($t2 - $t1, 3);
//                var_dump('查询数据库' . round($res, 3) . '秒');
//                    if ($data1) {
//                    $uodatedata[$data1['id']] = array(
//                        'distribution_store' => $value[9]!=0 &&$value[9]!='' ?$value[9]:0,
//                        'last_distribution_store' => $value[10]!=0 &&$value[10]!=''? $value[10]:0,
//                    );
//                }
//              var_dump($reg.'|'.$city_levelid.' system_id='.$channelid.' and platform_id='.$platformid
//                  .' and category_id='.$skuid.' and menu_id='.$manuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id']);
//              echo "<pre>";
//              var_dump($uodatedata);
//              var_dump('__________________________________');exit;
            }
//                var_dump($uodatedata);var_dump('...................');exit;
            $t1 = microtime(true);
//                $this->updateList(['sales_share', 'sales_quota'], $uodatedata, 'cola_info_2019_q1_0');
            $this->updateList(['sku_number'], $uodatedata, 'cola_info_2018_11_0');
            $t2 = microtime(true);
            $res = round($t2 - $t1, 3);
            var_dump('更新数据库' . round($res, 3) . '秒');

        }
        else {
            return 0;
        }
    }
//12月
    public function HasChangeRate12()
    {
        ini_set('memory_limit','-1');
        //判断该期数据是否有VS PP，有则需要获得上期数据，否则不需要
        $zpjt = Relation::model()->findAll(['condition' => 'depth=1', 'index' => 'name']); //装瓶集团，有全部
        $zpc = Relation::model()->findAll(['condition' => 'depth=2', 'index' => 'name']);//装瓶厂，没有全部
        $city = Relation::model()->findAll(['condition' => 'depth=3', 'index' => 'name']);//城市，没有全部
        $city_level = Citylevel::model()->findAll(['index' => 'name']); //城市等级，有全部
        $channel = System::model()->findAll(['index' => 'name']);//渠道，有全部
        $platform = Platform::model()->findAll(['index' => 'name']);//平台，有全部
        $category = Category::model()->findAll(['index' => 'name']);//品类，有全部
        $manu = Menu::model()->findAll(['index' => 'name']);//制造商，有全部
        $pinpai = Brand::model()->findAll(['index' => 'name']);//品牌，有全部
        $level = TotalClassify::model()->findAll(['condition' => 'classify=1', 'index' => 'name']); //容量分级，有全部
        $pack_level = TotalClassify::model()->findAll(['condition' => 'classify=2', 'index' => 'name']); //瓶量分级，有全部
        $this->HasChangeRateCircle12($city,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'city');
        $this->HasChangeRateCircle12($zpjt,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpjt');
        var_dump('-----------------------------------------1');
        $this->HasChangeRateCircle12($zpc,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpc');
        var_dump('-----------------------------------------2');
        $this->HasChangeRateCircle12($city,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'city');
        var_dump('-----------------------------------------3');
    }
    public function HasChangeRateCircle12($Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level,$region)
    {
        $brand=$pinpai;
        $capacity=$level;
        $bottle=$pack_level;
        $zpjt_arr=["'全部' zpjt",' zpjt'];
        $city_level_arr=["'全部' city_level",'city_level'];
        $channel_arr=["'全部' channel",'channel'];
        $platform_arr=["'全部' platform",'platform'];
        $type_arr=["'全部' type",'type'];
        $manu_arr=["'全部' manu",'manu'];
//        $manu_arr=['manu',"'全部' manu"];
        $pinpai_arr=["'全部' pinpai",'pinpai'];
        $level_arr=["'全部' level",'level'];
        $pack_level_arr=["'全部' pack_level",'pack_level'];
        $datasql = array();
        $times=0;
        switch ($region){
            case 'zpjt':
                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                    foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                        foreach($channel_arr as $channelkey => $channelvalue){
                            foreach($platform_arr as $platformkey => $platformvalue){
                                foreach($type_arr as $typekey => $typevalue){
                                    foreach ($manu_arr as $manukey => $manuvalue){
                                        foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                            foreach ($level_arr as $level => $levelvalue){
                                                foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                    $times++;
//                                                    var_dump('这是第'.$times.'次循环');
                                                    Yii::log(print_r($times,true),'warning');
                                                    $select_1=''.$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                    $select_2=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS a_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                    $select_3=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS lastzpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
                                                    $select_4=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS thiszpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                    $select_5=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS d_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                                    $select_6=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as store_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                    $select_7=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as laststore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                                    $select_8=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as allstore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                    $on_1='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=a_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                    $on_2='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastzpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
                                                    $on_3='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=thiszpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                    $on_4='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=d_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');
                                                    $on_5='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=store_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                    $on_6='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=laststore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                                    $on_7='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=allstore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                    $on_1=rtrim($on_1,'and ');
                                                    $on_2=rtrim($on_2,'and ');
                                                    $on_3=rtrim($on_3,'and ');
                                                    $on_4=rtrim($on_4,'and ');
                                                    $on_5=rtrim($on_5,'and ');
                                                    $on_6=rtrim($on_6,'and ');
                                                    $on_7=rtrim($on_7,'and ');

                                                    $datainfosql="SELECT "
                                                        .$select_1.
                                                        "sum(salescount),
	sum(sales_amount),
	count( DISTINCT storeid_copy ),
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	b.lastsaleroom,
	b.lastsales_numbers,
	b.sku_number,
	b.sku_stores, 
	b.cuxiao,
	b.dis,
	b.on_sale,
	c.ko_amount,
	c.ko_count,
	d.lastko_amount,
	d.lastko_count,
	store.store_num,
	store.store_orders,
	laststore.laststore_num,
	laststore.laststore_orders,
	allstore.allstores
FROM
	sku_2018
	LEFT JOIN (
	SELECT
		count(*) AS a_sku_number,
		sum(cuxiao) as a_cuxiao,
		sum(dis) as a_dis,
		sum(on_sale) as a_on_sale,".$select_2.
                                                        " FROM
		sku_2018
	where dt='2018-12-01'
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT
		sum( sales_amount ) AS lastsaleroom,
		sum(salescount) as lastsales_numbers,
		count(*) AS sku_number,
		count( DISTINCT storeid_copy ) as sku_stores,
		sum(cuxiao) cuxiao,
		sum(dis) as dis,
		sum(on_sale) as on_sale,".$select_3. " FROM
		sku_2018 
	where dt='2018-11-01'
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS b ON(".$on_2.") 
	LEFT JOIN (SELECT "." ".$select_4. "sum(sales_amount) ko_amount,
		sum(salescount) ko_count
	FROM
		sku_2018
	where dt='2018-12-01'
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS c ON (".$on_3.")
		LEFT JOIN (
	SELECT ".$select_5.
                                                        " sum(sales_amount) lastko_amount,
		sum(salescount) lastko_count
	FROM
		sku_2018 
	where dt='2018-11-01'
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS d ON (".$on_4.")	
	LEFT JOIN (
	SELECT ".$select_6.
                                                        "COUNT(DISTINCT ID) store_num,
	    sum(salecount) store_orders
	FROM
		stores_2018 
	where dt='2018-12-01'
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_7.
                                                        "COUNT(DISTINCT ID) laststore_num,
	    sum(salecount) laststore_orders
	FROM
		stores_2018
	where dt='2018-11-01'
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel
		) AS laststore ON (".$on_6.")
	
	LEFT JOIN (
	SELECT ".$select_8.
                                                        "sum(xxmd) allstores
	FROM
		xxmd 
	GROUP BY
		zpjt,
		city_level,
		channel
		) AS allstore ON (".$on_7.")
where dt='2018-12-01'		
		
GROUP BY
	level,
	pack_level,
	zpjt,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
    b.lastsaleroom,
	b.lastsales_numbers,
	b.sku_number,
	b.cuxiao,
	b.sku_stores,
	b.dis,
	c.ko_amount,
	c.ko_count,
	d.lastko_amount,
	d.lastko_count,
	store.store_num,
	store.store_orders,
	laststore.laststore_num,
	laststore.laststore_orders,
	allstore.allstores,
	b.on_sale";

                                                    $datasql[] = $datainfosql;
//                                                    echo"<pre>";var_dump($datainfosql);exit;
                                                    $this->HasChangeRateRequest12($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//exit;
//                                                    $j=0;
//                                                    $res=true;
//                                                    while($res){
//                                                        $start=$j*100000;
//                                                        $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                        $j++;
//                                                    }
                                                }
                                            }
                                        }
                                    }

                                }
                            }
                        }
                    }
                }
                var_dump('装瓶集团数据已跑完');
                break;
            case 'zpc':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
                                foreach ($manu_arr as $manukey => $manuvalue){
                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                        foreach ($level_arr as $level => $levelvalue){
                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                $times++;
                                                var_dump('这是第'.$times.'次循环');
                                                $select_1=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                $select_2=' zpc AS a_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                $select_3=' zpc AS lastzpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
//                                                    $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ');
//                                                    $select_5=' zpc AS d_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ');
                                                $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                $select_5=' zpc AS d_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');


                                                $select_6=' zpc as store_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                $select_7=' zpc as laststore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                                $select_8=' zpc as allstore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                $on_1=' zpc=a_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                $on_2=' zpc=lastzpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype  ');
//                                                    $on_4=' zpc=d_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type  ');
                                                $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                $on_4=' zpc=d_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');

                                                $on_5=' zpc=store_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                $on_6=' zpc=laststore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                                $on_7=' zpc=allstore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                $on_1=rtrim($on_1,'and ');
                                                $on_2=rtrim($on_2,'and ');
                                                $on_3=rtrim($on_3,'and ');
                                                $on_4=rtrim($on_4,'and ');
                                                $on_5=rtrim($on_5,'and ');
                                                $on_6=rtrim($on_6,'and ');
                                                $on_7=rtrim($on_7,'and ');
                                                $datainfosql="SELECT "
                                                    .$select_1.
                                                    "sum(salescount),
	sum(sales_amount),
	count( DISTINCT storeid_copy ),
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	b.lastsaleroom,
	b.lastsales_numbers,
	b.sku_number,
	b.sku_stores, 
	b.cuxiao,
	b.dis,
	b.on_sale,
	c.ko_amount,
	c.ko_count,
	d.lastko_amount,
	d.lastko_count,
	store.store_num,
	store.store_orders,
	laststore.laststore_num,
	laststore.laststore_orders,
	allstore.allstores
FROM
	sku_2018
	LEFT JOIN (
	SELECT 
		count(*) AS a_sku_number,
		sum(cuxiao) as a_cuxiao,
		sum(dis) as a_dis,
		sum(on_sale) as a_on_sale,".$select_2.
                                                    " FROM
		sku_2018
	where dt='2018-11-01'
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT
		sum( sales_amount ) AS lastsaleroom,
		sum(salescount) as lastsales_numbers,
		count(distinct storeid_copy) as sku_stores,
		count(*) AS sku_number,
		sum(cuxiao) cuxiao,
		sum(dis) as dis,
		sum(on_sale) as on_sale,".$select_3.
                                                    " FROM
		sku_2018
	where dt='2018-12-01'
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS b ON(".$on_2.") 
	LEFT JOIN (
	SELECT  ".$select_4.
                                                    " sum(sales_amount) ko_amount,
		sum(salescount) ko_count
	FROM
		sku_2018
	where dt='2018-12-01'
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS c ON (".$on_3.")
	
		LEFT JOIN (
	SELECT ".$select_5.
                                                    " sum(sales_amount) lastko_amount,
		sum(salescount) lastko_count
	FROM
		sku_2018 
  where dt='2018-11-01'
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS d ON (".$on_4.")	
	LEFT JOIN (
	SELECT ".$select_6.
                                                    " COUNT(DISTINCT ID) store_num,
	    sum(salecount) store_orders
	FROM
		stores_2018 
	where dt='2018-12-01'
	GROUP BY
		zpc,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_7.
                                                    " COUNT(DISTINCT ID) laststore_num,
	    sum(salecount) laststore_orders
	FROM
		stores_2018 
	 where dt='2018-11-01'
	GROUP BY
		zpc,
		city_level,
		platform,
		channel
		) AS laststore ON (".$on_6.")
	
	LEFT JOIN (
	SELECT ".$select_8.
                                                    " sum(xxmd) allstores
	FROM
		xxmd 
	GROUP BY
		zpc,
		city_level,
		channel
		) AS allstore ON (".$on_7.")
where dt='2018-12-01'			
GROUP BY
	level,
	pack_level,
	zpc,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
    b.lastsaleroom,
	b.lastsales_numbers,
	b.sku_number,
	b.cuxiao,
	b.dis,
	b.sku_stores,
	c.ko_amount,
	c.ko_count,
	d.lastko_amount,
	d.lastko_count,
	store.store_num,
	store.store_orders,
	laststore.laststore_num,
	laststore.laststore_orders,
	allstore.allstores,
	b.on_sale";

//                                                if($region=='zpc'){
//                                                    $datainfosql=str_replace('zpjt','zpc',$datainfosql);
//                                                }
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
                                                $datasql[] = $datainfosql;
                                                $this->HasChangeRateRequest12($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);

//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                    $j++;
//                                                }
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
//                }
                break;
            case 'city':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
                                foreach ($manu_arr as $manukey => $manuvalue){
                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                        foreach ($level_arr as $level => $levelvalue){
                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                $times++;
                                                var_dump('这是第'.$times.'次循环');
                                                $select_1=' city,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                $select_2=' city AS a_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                $select_3=' city AS lastcity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
//                                                    $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ');
//                                                    $select_5=' city AS d_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ');
                                                $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                $select_5=' city AS d_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                                $select_6=' city as store_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                $select_7=' city as laststore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                                $select_8=' city as allstore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                $on_1=' city=a_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                $on_2=' city=lastcity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype  ');
//                                                    $on_4=' city=d_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type  ');
                                                $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                $on_4=' city=d_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');

                                                $on_5=' city=store_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                $on_6=' city=laststore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                                $on_7=' city=allstore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                $on_1=rtrim($on_1,'and ');
                                                $on_2=rtrim($on_2,'and ');
                                                $on_3=rtrim($on_3,'and ');
                                                $on_4=rtrim($on_4,'and ');
                                                $on_5=rtrim($on_5,'and ');
                                                $on_6=rtrim($on_6,'and ');
                                                $on_7=rtrim($on_7,'and ');
                                                $datainfosql="SELECT "
                                                    .$select_1.
                                                    "sum(salescount),
	sum(sales_amount),
	count( DISTINCT storeid_copy ),
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	b.lastsaleroom,
	b.lastsales_numbers,
	b.sku_number,
	b.sku_stores, 
	b.cuxiao,
	b.dis,
	b.on_sale,
	c.ko_amount,
	c.ko_count,
	d.lastko_amount,
	d.lastko_count,
	store.store_num,
	store.store_orders,
	laststore.laststore_num,
	laststore.laststore_orders,
	allstore.allstores
FROM
	sku_2018
	LEFT JOIN (
	SELECT 
		count(*) AS a_sku_number,
		sum(cuxiao) as a_cuxiao,
		sum(dis) as a_dis,
		sum(on_sale) as a_on_sale,".$select_2.
                                                    " FROM
		sku_2018 
	where dt='2018-12-01'
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT
		sum( sales_amount ) AS lastsaleroom,
		sum(salescount) as lastsales_numbers,
		count(*) AS sku_number,
		count(distinct storeid_copy) as sku_stores, 
		sum(cuxiao) cuxiao,
		sum(dis) as dis,
		sum(on_sale) as on_sale,".$select_3.
                                                    " FROM
		sku_2018 
	where dt='2018-11-01'
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS b ON(".$on_2.") 
	LEFT JOIN (
	SELECT  ".$select_4.
                                                    " sum(sales_amount) ko_amount,
		sum(salescount) ko_count
	FROM
		sku_2018
where dt='2018-12-01'
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS c ON (".$on_3.")
	
		LEFT JOIN (
	SELECT ".$select_5.
                                                    " sum(sales_amount) lastko_amount,
		sum(salescount) lastko_count
	FROM
		sku_2018
	where dt='2018-11-01'
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS d ON (".$on_4.")	
	LEFT JOIN (
	SELECT ".$select_6.
                                                    " COUNT(DISTINCT ID) store_num,
	    sum(salecount) store_orders
	FROM
		stores_2018
	where dt='2018-12-01'
	GROUP BY
		city,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_7.
                                                    " COUNT(DISTINCT ID) laststore_num,
	    sum(salecount) laststore_orders
	FROM
		stores_2018 
	where dt='2018-11-01'
	GROUP BY
		city,
		city_level,
		platform,
		channel
		) AS laststore ON (".$on_6.")
	
	LEFT JOIN (
	SELECT ".$select_8.
                                                    " sum(xxmd) allstores
	FROM
		xxmd
	GROUP BY
		city,
		city_level,
		channel
		) AS allstore ON (".$on_7.")
 where dt='2018-12-01'	
GROUP BY
	level,
	pack_level,
	city,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
b.lastsaleroom,
	b.lastsales_numbers,
	b.sku_number,
	b.cuxiao,
	b.dis,
	b.sku_stores, 
	c.ko_amount,
	c.ko_count,
	d.lastko_amount,
	d.lastko_count,
	store.store_num,
	store.store_orders,
	laststore.laststore_num,
	laststore.laststore_orders,
	allstore.allstores,
	b.on_sale";
//                                                echo "<pre>";var_dump($datainfosql);exit;
                                                $this->HasChangeRateRequest12($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
                break;
        }
//        for($i=64;$i<count($datasql);$i++){
//            var_dump('这是第'.$i.'次循环');
//            echo"<pre>";var_dump($datasql[$i]);exit;
//            $this->HasChangeRateRequest($datasql[$i],$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//        }
//        $res=true;
//        while($res){
//            $start=$j*20000;
//            $res = $this->getinfo_v($datasql[255],$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//            $j++;
//        }
//        exit;
    }
    public function HasChangeRateRequest12($datainfosql, $Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level ,$region)
    {
        $base = base64_encode('admin:KYLIN');
        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
        $params = CJSON::encode([
            'sql' => $datainfosql,
            'project' => 'O2O_retail',
            "acceptPartial" => false,
//            'offset' => $start,
//            'limit' => 100000
        ]);
        $t1 = microtime(true);
        $data = $this->getRetailCurl($url, $params, $header);
        $t2 = microtime(true);
        var_dump('麒麟调用数据耗时' . round($t2 - $t1, 3) . '秒');
        $data = $data["results"];
//       echo "<pre/>";var_dump($data);exit;
        if (!empty($data)) {//不为空的判断
            $info = array();
            foreach ($data as $key => $value) {
                switch($region){
                    case 'zpjt':
                        $info[$key]['relation_id'] = $value[0] == "SCCL" ? 2 : ($value[0] == "CBL" ? 3 : ($value[0] == "ZH" ? 65 : ($value[0] == "全部" ? 1 : 0)));
                        break;
                    case 'zpc':
                        $Relationid = $Relation[$value[0]];
                        $info[$key]['relation_id'] = $Relationid ? $Relationid->id : 0;
                        break;
                    case 'city':
                        $city=rtrim($value[0], "市");
                        $Relationid = $Relation[$city];
                        $info[$key]['relation_id'] = $Relationid ? $Relationid->id : 0;
                        break;
                }
                $city_levelid = isset($Citylevel[$value[1]]) ? $Citylevel[$value[1]]->id : 0;
                $info[$key]['cityLevel_id'] = $city_levelid;
                $channelid = isset($System[$value[2]]) ? $System[$value[2]]->id : 0;
                $info[$key]['system_id'] = $channelid;
                $platformid = isset($Platform[$value[3]]) ? $Platform[$value[3]]->id : 0;
                $info[$key]['platform_id'] = $platformid;
                $skuid = isset($Category[$value[4]]) ? $Category[$value[4]]->id : 0;
                $info[$key]['category_id'] = $skuid;
                $manuid = isset($manu[$value[5]]) ? $manu[$value[5]]->id : 0;
                $info[$key]['menu_id'] = $manuid;
                $pinpaiid = isset($pinpai[$value[6]]) ? $pinpai[$value[6]]->id : 0;
                $info[$key]['brand_id'] = $pinpaiid;
                $info[$key]['capacity_id'] = isset($level[$value[7]]) ? $level[$value[7]]->id : 0;
                $info[$key]['bottle_id'] = isset($pack_level[$value[8]]) ? $pack_level[$value[8]]->id : 0;
                $info[$key]['distribution'] = $value[27]!=0?($value[11]/$value[27]):0;
                $info[$key]['last_distribution'] = ($value[27]!=0&&$value[29]!=0)?$value[11]/$value[27]-$value[19]/$value[29]:0;
                $info[$key]['sales_numbers'] = $value[9];
                $info[$key]['last_sales_numbers'] = $value[17]!=0?($value[9]-$value[17])/$value[17]:0;
                $info[$key]['sales_quota'] = $value[24]!=0?($value[9]/$value[24]):0;
                $info[$key]['last_sales_quota'] = ($value[24]!=0 && $value[26]!=0)?($value[9]/$value[24]-$value[17]/$value[26]):0; //由于销售件数份额不对，变量计算错误
                $info[$key]['saleroom'] = $value[10];
                $info[$key]['last_saleroom'] =$value[16]!=0?($value[10]-$value[16])/$value[16]:0;
                $info[$key]['sales_share'] = $value[23]!=0?($value[10]/$value[23]):0;
                $info[$key]['last_sales_share'] = ($value[25]!=0&& $value[23]!=0)?($value[10]/$value[23]-$value[16]/$value[25]):0;
                if($platformid==1){
                    $info[$key]['enrollment'] = $value[31]!=0?($value[27]/$value[31])/3:0;
                    $info[$key]['last_enrollment'] = $value[31]!=0?($value[27]/$value[31]-$value[29]/$value[31])/3:0;
                }
                else{
                    $info[$key]['enrollment'] = $value[31]!=0 ?($value[27]/$value[31]):0;
                    $info[$key]['last_enrollment'] = $value[31]!=0?($value[27]/$value[31]-$value[29]/$value[31]):0;
                }
//                echo"<pre>";var_dump($info[$key]['enrollment']);var_dump($value[29]/$value[31]/3);var_dump($info[$key]['last_enrollment']);exit;
                $info[$key]['store_money'] = $value[11]!=0 ?($value[10]/$value[11]):0;
                $info[$key]['last_store_money'] = ($value[16]!=0 &&$value[19]!=0 &&$value[11]!=0)?($value[10]/$value[11]-$value[16]/$value[19])/($value[16]/$value[19]):0;
                $info[$key]['store_number'] = $value[11]!=0 ?($value[9]/$value[11]):0;
                $info[$key]['last_store_number'] = ($value[9]!=0&&$value[19]!=0&&$value[17]!=0)?($value[9]/$value[11]-$value[17]/$value[19])/($value[17]/$value[19]):0;
                $info[$key]['sku_number'] = $value[27]!=0?($value[12]/$value[27]):0;
                $info[$key]['last_sku_number'] = ($value[27]!=0&&$value[29]!=0&&$value[18]!=0)?($value[12]/$value[27]-$value[18]/$value[29])/($value[18]/$value[29]):0;

//                if($skuid==1){
//                    $info[$key]['sku_number'] = $value[27]!=0?($value[12]/$value[27]):0;
//                    $info[$key]['last_sku_number'] = ($value[27]!=0&&$value[29]!=0&&$value[18]!=0)?($value[12]/$value[27]-$value[18]/$value[29])/($value[18]/$value[29]):0;
//                }
//                else{
//                    $info[$key]['sku_number'] = $value[11]!=0?($value[12]/$value[11]):0;
//                    $info[$key]['last_sku_number'] = ($value[27]!=0&&$value[19]!=0&&$value[18]!=0)?($value[12]/$value[11]-$value[18]/$value[19])/($value[18]/$value[19]):0;
//                }
                $info[$key]['distribution_store'] = $value[11]!=0?$value[11]:0;
                $info[$key]['last_distribution_store'] = $value[19]!=0?($value[11]-$value[19])/$value[19]:0;
                $info[$key]['average_selling_price'] = $value[12]!=0?($value[13]/$value[12]):0;
                $info[$key]['last_average_selling_price'] =  ($value[12]!=0&&$value[20]!=0&&$value[18]!=0)?($value[13]/$value[12]-$value[20]/$value[18])/($value[20]/$value[18]):0;
                $info[$key]['average_purchase_price'] = $value[9]!=0?($value[10]/$value[9]):0;
                $info[$key]['last_average_purchase_price'] = ($value[16]!=0&&$value[17]!=0&&$value[9]!=0)?($value[10]/$value[9]-$value[16]/$value[17])/($value[16]/$value[17]):0;
                $info[$key]['price_promotion_ratio'] = $value[12]!=0?($value[15]/$value[12]):0;
                $info[$key]['last_price_promotion_ratio'] = ($value[12]!=0&&$value[20]!=0)?$value[15]/$value[12]-$value[22]/$value[20]:0;
                $info[$key]['average_discount_factor'] = $value[15]!=0?($value[14]/$value[15]):0;
                $info[$key]['last_average_discount_factor'] =($value[15]!=0&&$value[22]!=0)? ($value[14]/$value[15]-$value[21]/$value[22]):0;
                $info[$key]['average_number_per_unit'] = $value[28]!=0?($value[9]/$value[28]):0;
                $info[$key]['last_average_number_per_unit'] =  ($value[9]!=0&&$value[17]!=0&&$value[30]!=0)?($value[9]/$value[28]-$value[17]/$value[30])/($value[17]/$value[30]):0;
                $info[$key]['average_amount_per_order'] = $value[28]!=0?$value[10]/$value[28]:0;
                $info[$key]['last_average_amount_per_order'] = ($value[10]!=0&&$value[16]!=0&&$value[30]!=0)?($value[10]/$value[28]-$value[16]/$value[30])/($value[16]/$value[30]):0;
                if($skuid==1){
                    $info[$key]['online_stores'] = $value[27];
                    $info[$key]['last_online_stores'] = $value[29]!=0?(($value[27]-$value[29])/$value[29]):0;
                }
                else{
                    $info[$key]['online_stores'] = $value[11];
                    $info[$key]['last_online_stores'] = $value[19]!=0?(($value[11]-$value[19])/$value[19]):0;
                }
            }
            $label = array('relation_id',
                'cityLevel_id', 'system_id', 'platform_id', 'category_id', 'menu_id', 'brand_id', 'capacity_id', 'bottle_id', 'distribution', 'last_distribution',
                'sales_numbers', 'last_sales_numbers', 'sales_quota', 'last_sales_quota', 'saleroom', 'last_saleroom', 'sales_share', 'last_sales_share', 'enrollment', 'last_enrollment', 'store_money', 'last_store_money', 'store_number', 'last_store_number',
                'sku_number', 'last_sku_number', 'distribution_store', 'last_distribution_store', 'average_selling_price', 'last_average_selling_price', 'average_purchase_price', 'last_average_purchase_price', 'price_promotion_ratio', 'last_price_promotion_ratio',
                'average_discount_factor', 'last_average_discount_factor', 'average_number_per_unit', 'last_average_number_per_unit', 'average_amount_per_order', 'last_average_amount_per_order', 'online_stores', 'last_online_stores');
            $arr = array_chunk($info, 2000);
            for ($i = 0; $i < count($arr); $i++) {
                $t1 = microtime(true);
                $this->batchInsert('cola_info_2018_12_0', $label, $arr[$i]);
                $t2 = microtime(true);
                $res = round($t2 - $t1, 3);
                var_dump('插入数据库' . round($res, 3) . '秒');
            }

        }
        else {
            return 0;
        }




    }

    public function UpdateInfoData12()
    {
        ini_set('memory_limit','-1');

        $zpjt = Relation::model()->findAll(['condition' => 'depth=1', 'index' => 'name']); //装瓶集团，有全部
        $zpc = Relation::model()->findAll(['condition' => 'depth=2', 'index' => 'name']);//装瓶厂，没有全部
        $city = Relation::model()->findAll(['condition' => 'depth=3', 'index' => 'name']);//城市，没有全部
        $city_level = Citylevel::model()->findAll(['index' => 'name']); //城市等级，有全部
        $channel = System::model()->findAll(['index' => 'name']);//渠道，有全部
        $platform = Platform::model()->findAll(['index' => 'name']);//平台，有全部
        $category = Category::model()->findAll(['index' => 'name']);//品类，有全部
        $manu = Menu::model()->findAll(['index' => 'name']);//制造商，有全部
        $pinpai = Brand::model()->findAll(['index' => 'name']);//品牌，有全部
        $level = TotalClassify::model()->findAll(['condition' => 'classify=1', 'index' => 'name']); //容量分级，有全部
        $pack_level = TotalClassify::model()->findAll(['condition' => 'classify=2', 'index' => 'name']); //瓶量分级，有全部
        $this->getInfo_update12($zpjt,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpjt');
        var_dump('-----------------------------------------1');
        $this->getInfo_update12($zpc,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpc');
        var_dump('-----------------------------------------2');
        $this->getInfo_update12($city,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'city');
        var_dump('-----------------------------------------3');
    }
    public function getInfo_update12($Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level,$region)
    {
//        Yii::log('123456789465','error');exit;
//        var_dump("123456789");
//        set_time_limit('-1');//不限制执行时间
        $brand=$pinpai;
        $capacity=$level;
        $bottle=$pack_level;
        $zpjt_arr=["'全部' zpjt",' zpjt'];
        $city_level_arr=["'全部' city_level",'city_level'];
        $channel_arr=["'全部' channel",'channel'];
        $platform_arr=["'全部' platform",'platform'];
        $type_arr=["'全部' type",'type'];
//        $type_arr=['type'];
        $manu_arr=["'全部' manu",'manu'];
        $pinpai_arr=["'全部' pinpai",'pinpai'];
        $level_arr=["'全部' level",'level'];
        $pack_level_arr=["'全部' pack_level",'pack_level'];
        $datasql = array();
        $times=0;
//        switch ($region){
//            case 'zpjt':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
//                    foreach($city_level_arr as $city_levelkey => $city_levelvalue){
//                        foreach($channel_arr as $channelkey => $channelvalue){
//                            foreach($platform_arr as $platformkey => $platformvalue){
//                                foreach($type_arr as $typekey => $typevalue){
////                                    foreach ($manu_arr as $manukey => $manuvalue){
//                                        foreach ($pinpai_arr as $pinpai => $pinpaivalue){
//                                            foreach ($level_arr as $level => $levelvalue){
//                                                foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                    $times++;
//                                                    var_dump('这是第'.$times.'次循环');
//                                                    Yii::log(print_r($times,true),'warning');
////                                                   echo '<pre>';var_dump($datasql);exit;
////                                                   exit;
//                                                    $select_1=''.$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
////                                                    $select_3=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS lastzpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
////                                                    $on_2='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastzpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
////                                                    $on_2=rtrim($on_2,'and ');
////                                                    $datainfosql="SELECT ".$select_1."
////	sum(sales_amount),
////	sum(salescount)
////FROM
////	sku_2019
////WHERE
////	dt between '2019-01-01' and '2019-03-01'
////GROUP BY
////	LEVEL,
////	pack_level,
////	zpjt,
////	city_level,
////	channel,
////	platform,
////	type,
////	pinpai";
////                                                    $datainfosql="SELECT ".$select_1."
////	count(*)*1.0/count(distinct storeid)
////FROM
////	sku_2018
////WHERE
////	dt = '2018-11-01'
////GROUP BY
////	LEVEL,
////	pack_level,
////	zpjt,
////	city_level,
////	channel,
////	platform,
////	type,
////	manu,
////	pinpai";
//                                                    $datainfosql="SELECT ".$select_1."
//	count(*)*1.0,count(distinct storeid),
//FROM
//	sku_2018
//	left join (
//	    select count(distinct)
//	)
//WHERE
//	manu='可口可乐' and dt between '2019-01-01' and '2019-03-01'
//GROUP BY
//	LEVEL,
//	pack_level,
//	zpjt,
//	city_level,
//	channel,
//	platform,
//	type,
//	manu,
//	pinpai";
//                                                    $datasql[] = $datainfosql;
////                                                   echo '<pre>';var_dump($datainfosql);exit;
//                                                    $j=0;
//                                                    $res=true;
//                                                    while($res){
//                                                        $start=$j*100000;
//                                                        $res = $this->update_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//                                                        $j++;
//                                                    }
//                                                }
//                                            }
//                                        }
//                                    }
//
////                                }
//                            }
//                        }
//                    }
//                }
//                var_dump('装瓶集团数据已跑完');
//                break;
//            case 'zpc':
////                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
//                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
//                    foreach($channel_arr as $channelkey => $channelvalue){
//                        foreach($platform_arr as $platformkey => $platformvalue){
//                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
//                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
//                                        foreach ($level_arr as $level => $levelvalue){
//                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                $times++;
//                                                var_dump('这是第'.$times.'次循环');
////                                                $select_1=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
////                                                $select_3=' zpc AS lastzpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
////                                                $on_2=' zpc=lastzpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
////                                                $on_2=rtrim($on_2,'and ');
//                                                $select_4=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                $datainfosql="SELECT ".$select_4."
//	count(*)*1.0/count(distinct storeid)
//FROM
//	sku_2018
//WHERE
//	dt = '2018-11-01'
//GROUP BY
//	LEVEL,
//	pack_level,
//	zpc,
//	city_level,
//	channel,
//	platform,
//	type,
//	manu,
//	pinpai";
//                                                $datasql[] = $datainfosql;
////                                                   echo '<pre>';var_dump($datainfosql);exit;
//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->update_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//                                                    $j++;
//                                                }
//                                            }
//                                        }
//                                    }
//                                }
//
//                            }
//                        }
//                    }
//                }
//                var_dump('装瓶厂数据已跑完');
//                break;
//            case 'city':
//                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
//                    foreach($channel_arr as $channelkey => $channelvalue){
//                        foreach($platform_arr as $platformkey => $platformvalue){
//                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
//                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
//                                        foreach ($level_arr as $level => $levelvalue){
//                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                $times++;
//                                                var_dump('这是第'.$times.'次循环');
//                                                $select_4=' city,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                $datainfosql="SELECT ".$select_4."
//	count(*)*1.0/count(distinct storeid)
//FROM
//	sku_2018
//WHERE
//	dt = '2018-11-01'
//GROUP BY
//	LEVEL,
//	pack_level,
//	city,
//	city_level,
//	channel,
//	platform,
//	type,
//	manu,
//	pinpai";
//                                                $datasql[] = $datainfosql;
////                                                echo '<pre>';var_dump($datainfosql);exit;
////                                                $j=0;
////                                                $res=true;
//////                                                   exit;
////                                                while($res){
////                                                    $start=$j*100000;
////                                                    $res = $this->update_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
////                                                    $j++;
////                                                }
//////
//                                            }
//                                        }
//                                    }
//                                }
//
//                            }
//                        }
//                    }
//                }
//                var_dump('城市数据已跑完');
//                break;
//        }
        switch ($region){
            case 'zpjt':
                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                    foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                        foreach($channel_arr as $channelkey => $channelvalue){
                            foreach($platform_arr as $platformkey => $platformvalue){
                                foreach($type_arr as $typekey => $typevalue){
//                                    foreach ($manu_arr as $manukey => $manuvalue){
                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                        foreach ($level_arr as $level => $levelvalue){
                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                $times++;
//                                                    var_dump('这是第'.$times.'次循环');
                                                Yii::log(print_r($times,true),'warning');
                                                $select_1=''.$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                $select_2=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS a_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                $select_3=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS lastzpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
                                                $select_4=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS thiszpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                $select_5=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS d_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                                $select_6=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as store_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                $select_7=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as laststore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                                $select_8=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as allstore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                $on_1='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=a_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                $on_2='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastzpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
                                                $on_3='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=thiszpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                $on_4='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=d_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');
                                                $on_5='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=store_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                $on_6='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=laststore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                                $on_7='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=allstore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                $on_1=rtrim($on_1,'and ');
                                                $on_2=rtrim($on_2,'and ');
                                                $on_3=rtrim($on_3,'and ');
                                                $on_4=rtrim($on_4,'and ');
                                                $on_5=rtrim($on_5,'and ');
                                                $on_6=rtrim($on_6,'and ');
                                                $on_7=rtrim($on_7,'and ');

                                                $datainfosql="SELECT "
                                                    .$select_1.
                                                    "a.a_sku_number,count( DISTINCT storeid_copy ),store.store_num,
	b.sku_number,
	b.sku_stores, 	
	laststore.laststore_num
FROM
	sku_2018
	LEFT JOIN (
	SELECT
		count(*) AS a_sku_number,".$select_2.
                                                    " FROM
		sku_2018
	where manu='可口可乐' and dt='2018-12-01'			
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		level,
		pinpai,
		pack_level,
		type
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT
		count(*) AS sku_number,
		count( DISTINCT storeid_copy ) as sku_stores,".$select_3. " FROM
		sku_2018 
	where manu='可口可乐' and dt='2018-11-01'		
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		level,
		pinpai,
		pack_level,
		type 
		) AS b ON(".$on_2.") 
	LEFT JOIN (
	SELECT ".$select_6.
                                                    "COUNT(DISTINCT ID) store_num
	FROM
		stores_2018
	where dt='2018-12-01'	
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_7.
                                                    "COUNT(DISTINCT ID) laststore_num
	FROM
		stores_2018
	where dt='2018-11-01'	
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel
		) AS laststore ON (".$on_6.")
where manu='可口可乐' and dt='2018-12-01'				
GROUP BY
	level,
	pack_level,
	zpjt,
	city_level,
	channel,
	platform,
	type ,
	pinpai,
	a.a_sku_number,
	b.sku_number,
	b.sku_stores,
	store.store_num,
	laststore.laststore_num";

                                                $datasql[] = $datainfosql;
//                                                    echo"<pre>";var_dump($datainfosql);exit;
                                                $this->update_v12($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//exit;
//                                                    $j=0;
//                                                    $res=true;
//                                                    while($res){
//                                                        $start=$j*100000;
//                                                        $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                        $j++;
//                                                    }
                                            }
                                        }
                                    }
                                }

                            }
//                            }
                        }
                    }
                }
                var_dump('装瓶集团数据已跑完');
                break;
            case 'zpc':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
                                foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                    foreach ($level_arr as $level => $levelvalue){
                                        foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                            $times++;
                                            var_dump('这是第'.$times.'次循环');
                                            $select_1=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                            $select_2=' zpc AS a_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                            $select_3=' zpc AS lastzpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
//                                                    $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ');
//                                                    $select_5=' zpc AS d_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ');
                                            $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                            $select_5=' zpc AS d_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                            $select_6=' zpc as store_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                            $select_7=' zpc as laststore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                            $select_8=' zpc as allstore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                            $on_1=' zpc=a_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                            $on_2=' zpc=lastzpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype  ');
//                                                    $on_4=' zpc=d_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type  ');
                                            $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                            $on_4=' zpc=d_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');

                                            $on_5=' zpc=store_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                            $on_6=' zpc=laststore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                            $on_7=' zpc=allstore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                            $on_1=rtrim($on_1,'and ');
                                            $on_2=rtrim($on_2,'and ');
                                            $on_3=rtrim($on_3,'and ');
                                            $on_4=rtrim($on_4,'and ');
                                            $on_5=rtrim($on_5,'and ');
                                            $on_6=rtrim($on_6,'and ');
                                            $on_7=rtrim($on_7,'and ');
                                            $datainfosql="SELECT "
                                                .$select_1.
                                                "a.a_sku_number,
	count( DISTINCT storeid_copy ),store.store_num,
	b.sku_number,
	b.sku_stores, 
	laststore.laststore_num
FROM
	sku_2018
	LEFT JOIN (
	SELECT 
		count(*) AS a_sku_number,".$select_2.
                                                " FROM
		sku_2018
	where manu='可口可乐' and dt='2018-12-01'		
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT
		count(distinct storeid_copy) as sku_stores,
		count(*) AS sku_number,".$select_3.
                                                " FROM
		sku_2018
	where manu='可口可乐' and dt='2018-11-01'		
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS b ON(".$on_2.") 
	LEFT JOIN (
	SELECT ".$select_6.
                                                " COUNT(DISTINCT ID) store_num
	FROM
		stores_2018 
	where dt='2018-12-01'	
	GROUP BY
		zpc,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_7.
                                                "COUNT(DISTINCT ID) laststore_num
	FROM
		stores_2018
	where dt='2018-11-01'	
	GROUP BY
		zpc,
		city_level,
		platform,
		channel
		) AS laststore ON (".$on_6.")
where manu='可口可乐' and dt='2018-12-01'				
GROUP BY
	level,
	pack_level,
	zpc,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	b.sku_number,
	b.sku_stores,
	store.store_num,
	laststore.laststore_num";

//                                                if($region=='zpc'){
//                                                    $datainfosql=str_replace('zpjt','zpc',$datainfosql);
//                                                }
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
//                                                echo"<pre>";var_dump($datainfosql);exit;
                                            $datasql[] = $datainfosql;
                                            $this->update_v12($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);

//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                    $j++;
//                                                }
                                        }
                                    }
                                }
                            }

//                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
//                }
                break;
            case 'city':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
                                foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                    foreach ($level_arr as $level => $levelvalue){
                                        foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                            $times++;
                                            var_dump('这是第'.$times.'次循环');
                                            $select_1=' city,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                            $select_2=' city AS a_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                            $select_3=' city AS lastcity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
//                                                    $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ');
//                                                    $select_5=' city AS d_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ');
                                            $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                            $select_5=' city AS d_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                            $select_6=' city as store_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                            $select_7=' city as laststore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                            $select_8=' city as allstore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                            $on_1=' city=a_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                            $on_2=' city=lastcity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype  ');
//                                                    $on_4=' city=d_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type  ');
                                            $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                            $on_4=' city=d_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');

                                            $on_5=' city=store_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                            $on_6=' city=laststore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                            $on_7=' city=allstore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                            $on_1=rtrim($on_1,'and ');
                                            $on_2=rtrim($on_2,'and ');
                                            $on_3=rtrim($on_3,'and ');
                                            $on_4=rtrim($on_4,'and ');
                                            $on_5=rtrim($on_5,'and ');
                                            $on_6=rtrim($on_6,'and ');
                                            $on_7=rtrim($on_7,'and ');
                                            $datainfosql="SELECT "
                                                .$select_1.
                                                "a.a_sku_number,
	count( DISTINCT storeid_copy ),store.store_num,
	b.sku_number,
	b.sku_stores, 
	laststore.laststore_num
FROM
	sku_2018
	LEFT JOIN (
	SELECT 
		count(*) AS a_sku_number,".$select_2.
                                                " FROM
		sku_2018
	where manu='可口可乐' and dt='2018-12-01'		
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT
		count(distinct storeid_copy) as sku_stores,
		count(*) AS sku_number,".$select_3.
                                                " FROM
		sku_2018
	where manu='可口可乐' and dt='2018-11-01'		
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS b ON(".$on_2.") 
	LEFT JOIN (
	SELECT ".$select_6.
                                                " COUNT(DISTINCT ID) store_num
	FROM
		stores_2018 
	where dt='2018-12-01'	
	GROUP BY
		city,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_7.
                                                "COUNT(DISTINCT ID) laststore_num
	FROM
		stores_2018
	where dt='2018-11-01'	
	GROUP BY
		city,
		city_level,
		platform,
		channel
		) AS laststore ON (".$on_6.")
where manu='可口可乐' and dt='2018-12-01'				
GROUP BY
	level,
	pack_level,
	city,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	b.sku_number,
	b.sku_stores,
	store.store_num,
	laststore.laststore_num";
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
//                                            $datasql[] = $datainfosql;
                                            $this->update_v12($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);

//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                    $j++;
//                                                }
                                        }
                                    }
                                }
                            }

//                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
                break;
        }



//        echo "<pre>"; var_dump($datasql[255]);exit;

    }
    public function update_v12($datainfosql, $Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level ,$region)
    {
//        set_time_limit('-1');//不限制执行时间
//        var_dump(1255664);
        $base = base64_encode('admin:KYLIN');
        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
        $params = CJSON::encode([
            'sql' => $datainfosql,
            'project' => 'O2O_retail',
            "acceptPartial" => false,
//            'offset' => $start,
//            'limit' => 20000
        ]);
        $t1 = microtime(true);
        $data = $this->getRetailCurl($url, $params, $header);
        $t2 = microtime(true);
        var_dump('麒麟调用数据耗时' . round($t2 - $t1, 3) . '秒');
        $data = $data["results"];
        $uodatedata=[];
//       echo "<pre/>";var_dump($data);exit;
        if (!empty($data)) {//不为空的判断
            $info = array();
            foreach ($data as $key => $value) {
                $reg=1;
                switch($region){
                    case 'zpjt':
                        $reg = $value[0] == "SCCL" ? 2 : ($value[0] == "CBL" ? 3 : ($value[0] == "ZH" ? 65 : ($value[0] == "全部" ? 1 : 0)));
                        break;
                    case 'zpc':
                        $Relationid = $Relation[$value[0]];
                        $reg = $Relationid ? $Relationid->id : 0;
                        break;
                    case 'city':
                        $city=rtrim($value[0], "市");
                        $Relationid = $Relation[$city];
                        $reg = $Relationid ? $Relationid->id : 0;
                        break;
                }
                $city_levelid = isset($Citylevel[$value[1]]) ? $Citylevel[$value[1]]->id : 0;
                $info[$key]['cityLevel_id'] = $city_levelid;
                $channelid = isset($System[$value[2]]) ? $System[$value[2]]->id : 0;
                $info[$key]['system_id'] = $channelid;
                $platformid = isset($Platform[$value[3]]) ? $Platform[$value[3]]->id : 0;
                $info[$key]['platform_id'] = $platformid;
                $skuid = isset($Category[$value[4]]) ? $Category[$value[4]]->id : 0;
                $info[$key]['category_id'] = $skuid;
//                $manuid = isset($manu[$value[5]]) ? $manu[$value[5]]->id : 0;
//                $info[$key]['menu_id'] = $manuid;
                $pinpaiid = isset($pinpai[$value[5]]) ? $pinpai[$value[5]]->id : 0;
                $info[$key]['brand_id'] = $pinpaiid;
                $info[$key]['capacity_id'] = isset($level[$value[6]]) ? $level[$value[6]]->id : 0;
                $info[$key]['bottle_id'] = isset($pack_level[$value[7]]) ? $pack_level[$value[7]]->id : 0;
                if($skuid===1){
//                    不选品类
                    $sku_number=$value[10]!=0?$value[8]/$value[10]:0;
                    $last_sku_number=$value[8]!=0&&$value[10]!=0&&$value[11]!=0?($value[8]/$value[10]-$value[11]/$value[13])/($value[11]/$value[13]):0;
                }
                else{
//                    选品类
                    $sku_number=$value[9]!=0?$value[8]/$value[9]:0;
                    $last_sku_number=$value[9]!=0&&$value[11]!=0&&$value[12]!=0?($value[8]/$value[9]-$value[11]/$value[12])/($value[11]/$value[12]):0;
                }
//                echo "<pre>";var_dump($data);var_dump($sku_number);var_dump($last_sku_number);exit;
//                var_dump($data);echo "<br>";var_dump($sku_number);var_dump($last_sku_number);exit;
//                    $data1 =Info::model()->tableName('2018_12_0')->find(array('condition'=>'relation_id='.$reg.' and cityLevel_id='.$city_levelid.' and system_id='.$channelid.' and platform_id='.$platformid
//                    .' and category_id='.$skuid.' and menu_id='.$manuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id']));
//                sku_number
                $sql='select id from cola_info_2018_12_0 where relation_id='.$reg.' and cityLevel_id='.$city_levelid.' and system_id='.$channelid.' and platform_id='.$platformid
                    .' and category_id='.$skuid.' and brand_id='.$pinpaiid.' and menu_id=2 and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id'];
//                $sql='select id,saleroom,sales_numbers from cola_info_2019_q1_0 where relation_id='.$reg.' and cityLevel_id='.$city_levelid.' and system_id='.$channelid.' and platform_id='.$platformid
//                    .' and category_id='.$skuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id'];
                $t1 = microtime(true);
//                    $data1=Yii::app()->db->createCommand($sql)->queryRow();
//                var_dump($sql);
                $data1=Yii::app()->db->createCommand($sql)->queryAll();
                foreach ($data1 as $key =>$value1){
                    $uodatedata[$value1['id']]=array(
                        'sku_number' => $sku_number,
                        'last_sku_number' => $last_sku_number,
//                        'last_sku_number' => $value[9]!=0?($value1['sku_number']-$value[9])/$value[9]:0,
//                        'sales_quota' => $value[9]!=0?$value1['sales_numbers']/$value[9]:0,
                    );
                }
//                $t2 = microtime(true);
//                $res = round($t2 - $t1, 3);
//                var_dump('查询数据库' . round($res, 3) . '秒');
//                    if ($data1) {
//                    $uodatedata[$data1['id']] = array(
//                        'distribution_store' => $value[9]!=0 &&$value[9]!='' ?$value[9]:0,
//                        'last_distribution_store' => $value[10]!=0 &&$value[10]!=''? $value[10]:0,
//                    );
//                }
//              var_dump($reg.'|'.$city_levelid.' system_id='.$channelid.' and platform_id='.$platformid
//                  .' and category_id='.$skuid.' and menu_id='.$manuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id']);
//              echo "<pre>";
//              var_dump($uodatedata);
//              var_dump('__________________________________');exit;
            }
//                var_dump($uodatedata);var_dump('...................');exit;
            $t1 = microtime(true);
//          $this->updateList(['sales_share', 'sales_quota'], $uodatedata, 'cola_info_2019_q1_0');

            $this->updateList(['sku_number','last_sku_number'], $uodatedata, 'cola_info_2018_12_0');
            $t2 = microtime(true);
            $res = round($t2 - $t1, 3);
            var_dump('更新数据库' . round($res, 3) . '秒');

        }
        else {
            return 0;
        }
    }
//Q1
    public function NoChangeRateQ1()
    {
        ini_set('memory_limit','-1');
        //判断该期数据是否有VS PP，有则需要获得上期数据，否则不需要
        $zpjt = Relation::model()->findAll(['condition' => 'depth=1', 'index' => 'name']); //装瓶集团，有全部
        $zpc = Relation::model()->findAll(['condition' => 'depth=2', 'index' => 'name']);//装瓶厂，没有全部
        $city = Relation::model()->findAll(['condition' => 'depth=3', 'index' => 'name']);//城市，没有全部
        $city_level = Citylevel::model()->findAll(['index' => 'name']); //城市等级，有全部
        $channel = System::model()->findAll(['index' => 'name']);//渠道，有全部
        $platform = Platform::model()->findAll(['index' => 'name']);//平台，有全部
        $category = Category::model()->findAll(['index' => 'name']);//品类，有全部
        $manu = Menu::model()->findAll(['index' => 'name']);//制造商，有全部
        $pinpai = Brand::model()->findAll(['index' => 'name']);//品牌，有全部
        $level = TotalClassify::model()->findAll(['condition' => 'classify=1', 'index' => 'name']); //容量分级，有全部
        $pack_level = TotalClassify::model()->findAll(['condition' => 'classify=2', 'index' => 'name']); //瓶量分级，有全部
        $this->NoChangeRateCircleQ1($zpjt,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpjt');
        var_dump('-----------------------------------------1');
        $this->NoChangeRateCircleQ1($zpc,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpc');
        var_dump('-----------------------------------------2');
        $this->NoChangeRateCircleQ1($city,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'city');
        var_dump('-----------------------------------------3');
    }
    public function NoChangeRateCircleQ1($Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level,$region)
    {
        $brand=$pinpai;
        $capacity=$level;
        $bottle=$pack_level;
        $zpjt_arr=["'全部' zpjt",' zpjt'];
        $city_level_arr=["'全部' city_level",'city_level'];
        $channel_arr=["'全部' channel",'channel'];
        $platform_arr=["'全部' platform",'platform'];
        $type_arr=["'全部' type",'type'];
//        $manu_arr=['manu',"'全部' manu"];
        $manu_arr=["'全部' manu",'manu'];
        $pinpai_arr=["'全部' pinpai",'pinpai'];
        $level_arr=["'全部' level",'level'];
        $pack_level_arr=["'全部' pack_level",'pack_level'];
        $datasql = array();
        $times=0;
        switch ($region){
            case 'zpjt':
                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                    foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                        foreach($channel_arr as $channelkey => $channelvalue){
                            foreach($platform_arr as $platformkey => $platformvalue){
                                foreach($type_arr as $typekey => $typevalue){
                                    foreach ($manu_arr as $manukey => $manuvalue){
                                        foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                            foreach ($level_arr as $level => $levelvalue){
                                                foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                    $times++;
                                                    var_dump('这是第'.$times.'次循环');
                                                    Yii::log(print_r($times,true),'warning');
                                                    $select_1=''.$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                    $select_2=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS a_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                    $select_4=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS thiszpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                    $select_6=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as store_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                    $select_8=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as allstore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                    $on_1='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=a_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                    $on_3='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=thiszpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                    $on_5='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=store_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                    $on_7='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=allstore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                    $on_1=rtrim($on_1,'and ');
                                                    $on_3=rtrim($on_3,'and ');
                                                    $on_5=rtrim($on_5,'and ');
                                                    $on_7=rtrim($on_7,'and ');
                                                    $datainfosql="SELECT "
                                                        .$select_1.
                                                        "sum(salescount),
	sum(sales_amount),
	count(distinct storeid_copy),
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	c.ko_amount,
	c.ko_count,
	store.store_num,
	store.store_orders,
	allstore.allstores	
FROM
	sku_2019
	LEFT JOIN (
	SELECT
		count(*) AS a_sku_number,
		sum(cuxiao) as a_cuxiao,
		sum(dis) as a_dis,
		sum(on_sale) as a_on_sale,".$select_2.
                                                        " FROM
		sku_2019 
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type
		) AS a ON(".$on_1.") 
	LEFT JOIN (SELECT "." ".$select_4. "sum(sales_amount) ko_amount,
		sum(salescount) ko_count
	FROM
		sku_2019 
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS c ON (".$on_3.")
	LEFT JOIN (
	SELECT ".$select_6.
                                                        "COUNT(DISTINCT ID) store_num,
	    sum(salecount) store_orders
	FROM
		stores_2019
	
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	
	LEFT JOIN (
	SELECT ".$select_8.
                                                        "sum(xxmd) allstores
	FROM
		xxmd_2019_q1
	GROUP BY
		zpjt,
		city_level,
		channel
		) AS allstore ON (".$on_7.")


GROUP BY
	level,
	pack_level,
	zpjt,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	c.ko_amount,
	c.ko_count,
	store.store_num,
	store.store_orders,
	allstore.allstores";

                                                    $datasql[] = $datainfosql;
//                                                    echo"<pre>";var_dump($datainfosql);exit;
                                                    $this->NoChangeRateRequestQ1($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//                                                    exit;
//                                                    $j=0;
//                                                    $res=true;
//                                                    while($res){
//                                                        $start=$j*100000;
//                                                        $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                        $j++;
//                                                    }
                                                }
                                            }
                                        }
                                    }

                                }
                            }
                        }
                    }
                }
                var_dump('装瓶集团数据已跑完');
                break;
            case 'zpc':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
                                foreach ($manu_arr as $manukey => $manuvalue){
                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                        foreach ($level_arr as $level => $levelvalue){
                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                $times++;
//                                                var_dump('这是第'.$times.'次循环');
                                                $select_1=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                $select_2=' zpc AS a_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                $select_6=' zpc as store_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                $select_8=' zpc as allstore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                $on_1=' zpc=a_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                $on_5=' zpc=store_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                $on_7=' zpc=allstore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                $on_1=rtrim($on_1,'and ');
                                                $on_3=rtrim($on_3,'and ');
                                                $on_5=rtrim($on_5,'and ');
                                                $on_7=rtrim($on_7,'and ');
                                                $datainfosql="SELECT "
                                                    .$select_1.
                                                    "sum(salescount),
	sum(sales_amount),
	count(distinct storeid_copy),
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	c.ko_amount,
	c.ko_count,
	store.store_num,
	store.store_orders,
	allstore.allstores	
FROM
	sku_2019
	LEFT JOIN (
	SELECT 
		count(*) AS a_sku_number,
		sum(cuxiao) as a_cuxiao,
		sum(dis) as a_dis,
		sum(on_sale) as a_on_sale,".$select_2.
                                                    " FROM
		sku_2019 
	
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT  ".$select_4.
                                                    " sum(sales_amount) ko_amount,
		sum(salescount) ko_count
	FROM
		sku_2019
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS c ON (".$on_3.")
	LEFT JOIN (
	SELECT ".$select_6.
                                                    " COUNT(DISTINCT ID) store_num,
	    sum(salecount) store_orders
	FROM
		stores_2019 
	GROUP BY
		zpc,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_8.
                                                    " sum(xxmd) allstores
	FROM
		xxmd_2019_q1
	GROUP BY
		zpc,
		city_level,
		channel
		) AS allstore ON (".$on_7.")

GROUP BY
	level,
	pack_level,
	zpc,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	c.ko_amount,
	c.ko_count,
	store.store_num,
	store.store_orders,
	allstore.allstores";
                                                $datasql[] = $datainfosql;
//                                                echo "<pre>";var_dump($datainfosql);exit;
                                                $this->NoChangeRateRequestQ1($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
//                }
                break;
            case 'city':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
                                foreach ($manu_arr as $manukey => $manuvalue){
                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                        foreach ($level_arr as $level => $levelvalue){
                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                $times++;
//                                                var_dump('这是第'.$times.'次循环');
                                                $select_1=' city,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                $select_2=' city AS a_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                $select_6=' city as store_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                $select_8=' city as allstore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                $on_1=' city=a_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                $on_5=' city=store_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                $on_7=' city=allstore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                $on_1=rtrim($on_1,'and ');
                                                $on_3=rtrim($on_3,'and ');
                                                $on_5=rtrim($on_5,'and ');
                                                $on_7=rtrim($on_7,'and ');
                                                $datainfosql="SELECT "
                                                    .$select_1.
                                                    "sum(salescount),
	sum(sales_amount),
	count(distinct storeid_copy),
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	c.ko_amount,
	c.ko_count,
	store.store_num,
	store.store_orders,
	allstore.allstores	
FROM
	sku_2019
	LEFT JOIN (
	SELECT 
		count(*) AS a_sku_number,
		sum(cuxiao) as a_cuxiao,
		sum(dis) as a_dis,
		sum(on_sale) as a_on_sale,".$select_2.
                                                    " FROM
		sku_2019 
	
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT  ".$select_4.
                                                    " sum(sales_amount) ko_amount,
		sum(salescount) ko_count
	FROM
		sku_2019
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS c ON (".$on_3.")
	LEFT JOIN (
	SELECT ".$select_6.
                                                    " COUNT(DISTINCT ID) store_num,
	    sum(salecount) store_orders
	FROM
		stores_2019 
	GROUP BY
		city,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_8.
                                                    " sum(xxmd) allstores
	FROM
		xxmd_2019_q1
	GROUP BY
		city,
		city_level,
		channel
		) AS allstore ON (".$on_7.")

GROUP BY
	level,
	pack_level,
	city,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	c.ko_amount,
	c.ko_count,
	store.store_num,
	store.store_orders,
	allstore.allstores";
                                                $datasql[] = $datainfosql;
//                                                echo "<pre>";var_dump($datainfosql);exit;
                                                $this->NoChangeRateRequestQ1($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
                break;
        }
//        $res=true;
//        while($res){
//            $start=$j*20000;
//            $res = $this->getinfo_v($datasql[255],$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//            $j++;
//        }
//        for($i=96;$i<count($datasql);$i++){
//            var_dump('这是第'.$i.'次循环');echo "<br/>";
//            $this->NoChangeRateRequest($datasql[$i],$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//        }
//        exit;
    }
    public function NoChangeRateRequestQ1($datainfosql, $Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level ,$region)
    {
        $base = base64_encode('admin:KYLIN');
        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
        $params = CJSON::encode([
            'sql' => $datainfosql,
            'project' => 'O2O_retail',
            "acceptPartial" => false,
//            'offset' => $start,
//            'limit' => 100000
        ]);
        $t1 = microtime(true);
        $data = $this->getRetailCurl($url, $params, $header);
        $t2 = microtime(true);
        var_dump('麒麟调用数据耗时' . round($t2 - $t1, 3) . '秒');
        $data = $data["results"];
//       echo "<pre/>";var_dump($data);exit;
        if (!empty($data)) {//不为空的判断
            $info = array();
            foreach ($data as $key => $value) {
                switch($region){
                    case 'zpjt':
                        $info[$key]['relation_id'] = $value[0] == "SCCL" ? 2 : ($value[0] == "CBL" ? 3 : ($value[0] == "ZH" ? 65 : ($value[0] == "全部" ? 1 : 0)));
                        break;
                    case 'zpc':
                        $Relationid = $Relation[$value[0]];
                        $info[$key]['relation_id'] = $Relationid ? $Relationid->id : 0;
                        break;
                    case 'city':
                        $city=rtrim($value[0], "市");
                        $Relationid = $Relation[$city];
                        $info[$key]['relation_id'] = $Relationid ? $Relationid->id : 0;
                        break;
                }
                $city_levelid = isset($Citylevel[$value[1]]) ? $Citylevel[$value[1]]->id : 0;
                $info[$key]['cityLevel_id'] = $city_levelid;
                $channelid = isset($System[$value[2]]) ? $System[$value[2]]->id : 0;
                $info[$key]['system_id'] = $channelid;
                $platformid = isset($Platform[$value[3]]) ? $Platform[$value[3]]->id : 0;
                $info[$key]['platform_id'] = $platformid;
                $skuid = isset($Category[$value[4]]) ? $Category[$value[4]]->id : 0;
                $info[$key]['category_id'] = $skuid;
                $manuid = isset($manu[$value[5]]) ? $manu[$value[5]]->id : 0;
                $info[$key]['menu_id'] = $manuid;
                $pinpaiid = isset($pinpai[$value[6]]) ? $pinpai[$value[6]]->id : 0;
                $info[$key]['brand_id'] = $pinpaiid;
                $info[$key]['capacity_id'] = isset($level[$value[7]]) ? $level[$value[7]]->id : 0;
                $info[$key]['bottle_id'] = isset($pack_level[$value[8]]) ? $pack_level[$value[8]]->id : 0;
                $info[$key]['distribution'] = $value[18]!=0?($value[11]/$value[18]):0;
//                $info[$key]['last_distribution'] = ($value[27]!=0&&$value[29]!=0)?$value[11]/$value[27]-$value[19]/$value[29]:0;
                $info[$key]['sales_numbers'] = $value[9];
//                $info[$key]['last_sales_numbers'] = $value[17]!=0?($value[9]-$value[17])/$value[17]:0;
                $info[$key]['sales_quota'] = $value[17]!=0?($value[9]/$value[17]):0;
//                $info[$key]['last_sales_quota'] = ($value[24]!=0 && $value[26]!=0)?($value[9]/$value[24]-$value[18]/$value[26]):0;
                $info[$key]['saleroom'] = $value[10];
//                $info[$key]['last_saleroom'] =$value[16]!=0?($value[10]-$value[16])/$value[16]:0;
                $info[$key]['sales_share'] = $value[16]!=0?($value[10]/$value[16]):0;
//                $info[$key]['last_sales_share'] = ($value[25]!=0&& $value[23]!=0 && $value[23]!='')?($value[10]/$value[23]-$value[16]/$value[25]):0;
                if($platformid==1){
                    $info[$key]['enrollment'] = $value[20]!=0?($value[18]/$value[20])/3:0;
                }
                else{
                    $info[$key]['enrollment'] = $value[20]!=0 ?($value[18]/$value[20]):0;
                }
//                $info[$key]['last_enrollment'] = $value[31]!=0?($value[27]/$value[31]-$value[29]/$value[31]):0;
                $info[$key]['store_money'] = $value[11]!=0 ?($value[10]/$value[11]):0;
//                $info[$key]['last_store_money'] = ($value[16]!=0 &&$value[19]!=0 &&$value[11]!=0)?($value[10]/$value[11]-$value[16]/$value[19])/($value[16]/$value[19]):0;
                $info[$key]['store_number'] = $value[11]!=0 ?($value[9]/$value[11]):0;
//                $info[$key]['last_store_number'] = ($value[9]!=0&&$value[19]!=0&&$value[17]!=0)?($value[9]/$value[11]-$value[17]/$value[19])/($value[17]/$value[19]):0;
                if($skuid==1){
                    $info[$key]['sku_number'] = $value[18]!=0?($value[12]/$value[18]):0;
//                    $info[$key]['last_sku_number'] = ($value[27]!=0&&$value[29]!=0&&$value[18]!=0)?($value[12]/$value[27]-$value[18]/$value[29])/($value[18]/$value[29]):0;
                }
                else{
                    $info[$key]['sku_number'] = $value[11]!=0?($value[12]/$value[11]):0;
//                    $info[$key]['last_sku_number'] = ($value[27]!=0&&$value[19]!=0&&$value[18]!=0)?($value[12]/$value[11]-$value[18]/$value[19])/($value[18]/$value[19]):0;
                }
                $info[$key]['distribution_store'] = $value[11]!=0?$value[11]:0;
//                $info[$key]['last_distribution_store'] = $value[19]!=0?($value[11]-$value[19])/$value[19]:0;
                $info[$key]['average_selling_price'] = $value[12]!=0?($value[13]/$value[12]):0;
//                $info[$key]['last_average_selling_price'] =  ($value[12]!=0&&$value[20]!=0&&$value[18]!=0)?($value[13]/$value[12]-$value[20]/$value[18])/($value[20]/$value[18]):0;
                $info[$key]['average_purchase_price'] = $value[9]!=0?($value[10]/$value[9]):0;
//                $info[$key]['last_average_purchase_price'] = ($value[16]!=0&&$value[17]!=0&&$value[9]!=0)?($value[10]/$value[9]-$value[16]/$value[17])/($value[16]/$value[17]):0;
                $info[$key]['price_promotion_ratio'] = $value[12]!=0?($value[15]/$value[12]):0;
//                $info[$key]['last_price_promotion_ratio'] = ($value[12]!=0&&$value[20]!=0)?$value[15]/$value[12]-$value[22]/$value[20]:0;
                $info[$key]['average_discount_factor'] = $value[15]!=0?($value[14]/$value[15]):0;
//                $info[$key]['last_average_discount_factor'] =($value[15]!=0&&$value[22]!=0)? ($value[14]/$value[15]-$value[21]/$value[22]):0;
                $info[$key]['average_number_per_unit'] = $value[19]!=0?($value[9]/$value[19]):0;
//                $info[$key]['last_average_number_per_unit'] =  ($value[9]!=0&&$value[17]!=0&&$value[30]!=0)?($value[9]/$value[28]-$value[17]/$value[30])/($value[17]/$value[30]):0;
                $info[$key]['average_amount_per_order'] = $value[19]!=0?$value[10]/$value[19]:0;
//                $info[$key]['last_average_amount_per_order'] = ($value[10]!=0&&$value[16]!=0&&$value[30]!=0)?($value[10]/$value[28]-$value[16]/$value[30])/($value[16]/$value[30]):0;
                if($skuid==1){
                    $info[$key]['online_stores'] = $value[18]!=''?$value[18]:0;
                }
                else{
                    $info[$key]['online_stores'] = $value[11]!=''?$value[11]:0;
                }

//                $info[$key]['last_online_stores'] = $value[29]!=0?(($value[27]-$value[29])/$value[29]):0;
            }
            $label = array('relation_id',
                'cityLevel_id', 'system_id', 'platform_id', 'category_id', 'menu_id', 'brand_id', 'capacity_id', 'bottle_id', 'distribution',
                'sales_numbers',  'sales_quota',  'saleroom',  'sales_share', 'enrollment',  'store_money', 'store_number',
                'sku_number', 'distribution_store',  'average_selling_price', 'average_purchase_price',  'price_promotion_ratio',
                'average_discount_factor',  'average_number_per_unit',  'average_amount_per_order', 'online_stores');
            $arr = array_chunk($info, 2000);
            for ($i = 0; $i < count($arr); $i++) {
                $t1 = microtime(true);
                $this->batchInsert('cola_info_2019_q1_0_copy', $label, $arr[$i]);
                $t2 = microtime(true);
                $res = round($t2 - $t1, 3);
                var_dump('插入数据库' . round($res, 3) . '秒');
            }
        }
        else {
            return 0;
        }
    }

    public function UpdateInfoDataQ1()
    {
        ini_set('memory_limit','-1');

        $zpjt = Relation::model()->findAll(['condition' => 'depth=1', 'index' => 'name']); //装瓶集团，有全部
        $zpc = Relation::model()->findAll(['condition' => 'depth=2', 'index' => 'name']);//装瓶厂，没有全部
        $city = Relation::model()->findAll(['condition' => 'depth=3', 'index' => 'name']);//城市，没有全部
        $city_level = Citylevel::model()->findAll(['index' => 'name']); //城市等级，有全部
        $channel = System::model()->findAll(['index' => 'name']);//渠道，有全部
        $platform = Platform::model()->findAll(['index' => 'name']);//平台，有全部
        $category = Category::model()->findAll(['index' => 'name']);//品类，有全部
        $manu = Menu::model()->findAll(['index' => 'name']);//制造商，有全部
        $pinpai = Brand::model()->findAll(['index' => 'name']);//品牌，有全部
        $level = TotalClassify::model()->findAll(['condition' => 'classify=1', 'index' => 'name']); //容量分级，有全部
        $pack_level = TotalClassify::model()->findAll(['condition' => 'classify=2', 'index' => 'name']); //瓶量分级，有全部
        $this->getInfo_updateQ1($zpjt,$city_level,$channel,$platform,$category,$manu,$pinpai,$level,$pack_level,'zpjt');
        var_dump('-----------------------------------------1');
        $this->getInfo_updateQ1($zpc,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpc');
        var_dump('-----------------------------------------2');
        $this->getInfo_updateQ1($city,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'city');
        var_dump('-----------------------------------------3');
    }
    public function getInfo_updateQ1($Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level,$region)
    {
//        Yii::log('123456789465','error');exit;
//        var_dump("123456789");
//        set_time_limit('-1');//不限制执行时间
        $brand=$pinpai;
        $capacity=$level;
        $bottle=$pack_level;
        $zpjt_arr=["'全部' zpjt",' zpjt'];
        $city_level_arr=["'全部' city_level",'city_level'];
        $channel_arr=["'全部' channel",'channel'];
        $platform_arr=["'全部' platform",'platform'];
        $type_arr=["'全部' type",'type'];
//        $type_arr=['type'];
        $manu_arr=["'全部' manu",'manu'];
        $pinpai_arr=["'全部' pinpai",'pinpai'];
        $level_arr=["'全部' level",'level'];
        $pack_level_arr=["'全部' pack_level",'pack_level'];
        $datasql = array();
        $times=0;
//        switch ($region){
//            case 'zpjt':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
//                    foreach($city_level_arr as $city_levelkey => $city_levelvalue){
//                        foreach($channel_arr as $channelkey => $channelvalue){
//                            foreach($platform_arr as $platformkey => $platformvalue){
//                                foreach($type_arr as $typekey => $typevalue){
////                                    foreach ($manu_arr as $manukey => $manuvalue){
//                                        foreach ($pinpai_arr as $pinpai => $pinpaivalue){
//                                            foreach ($level_arr as $level => $levelvalue){
//                                                foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                    $times++;
//                                                    var_dump('这是第'.$times.'次循环');
//                                                    Yii::log(print_r($times,true),'warning');
////                                                   echo '<pre>';var_dump($datasql);exit;
////                                                   exit;
//                                                    $select_1=''.$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
////                                                    $select_3=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS lastzpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
////                                                    $on_2='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastzpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
////                                                    $on_2=rtrim($on_2,'and ');
////                                                    $datainfosql="SELECT ".$select_1."
////	sum(sales_amount),
////	sum(salescount)
////FROM
////	sku_2019
////WHERE
////	dt between '2019-01-01' and '2019-03-01'
////GROUP BY
////	LEVEL,
////	pack_level,
////	zpjt,
////	city_level,
////	channel,
////	platform,
////	type,
////	pinpai";
////                                                    $datainfosql="SELECT ".$select_1."
////	count(*)*1.0/count(distinct storeid)
////FROM
////	sku_2018
////WHERE
////	dt = '2018-11-01'
////GROUP BY
////	LEVEL,
////	pack_level,
////	zpjt,
////	city_level,
////	channel,
////	platform,
////	type,
////	manu,
////	pinpai";
//                                                    $datainfosql="SELECT ".$select_1."
//	count(*)*1.0,count(distinct storeid),
//FROM
//	sku_2018
//	left join (
//	    select count(distinct)
//	)
//WHERE
//	manu='可口可乐' and dt between '2019-01-01' and '2019-03-01'
//GROUP BY
//	LEVEL,
//	pack_level,
//	zpjt,
//	city_level,
//	channel,
//	platform,
//	type,
//	manu,
//	pinpai";
//                                                    $datasql[] = $datainfosql;
////                                                   echo '<pre>';var_dump($datainfosql);exit;
//                                                    $j=0;
//                                                    $res=true;
//                                                    while($res){
//                                                        $start=$j*100000;
//                                                        $res = $this->update_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//                                                        $j++;
//                                                    }
//                                                }
//                                            }
//                                        }
//                                    }
//
////                                }
//                            }
//                        }
//                    }
//                }
//                var_dump('装瓶集团数据已跑完');
//                break;
//            case 'zpc':
////                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
//                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
//                    foreach($channel_arr as $channelkey => $channelvalue){
//                        foreach($platform_arr as $platformkey => $platformvalue){
//                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
//                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
//                                        foreach ($level_arr as $level => $levelvalue){
//                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                $times++;
//                                                var_dump('这是第'.$times.'次循环');
////                                                $select_1=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
////                                                $select_3=' zpc AS lastzpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
////                                                $on_2=' zpc=lastzpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
////                                                $on_2=rtrim($on_2,'and ');
//                                                $select_4=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                $datainfosql="SELECT ".$select_4."
//	count(*)*1.0/count(distinct storeid)
//FROM
//	sku_2018
//WHERE
//	dt = '2018-11-01'
//GROUP BY
//	LEVEL,
//	pack_level,
//	zpc,
//	city_level,
//	channel,
//	platform,
//	type,
//	manu,
//	pinpai";
//                                                $datasql[] = $datainfosql;
////                                                   echo '<pre>';var_dump($datainfosql);exit;
//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->update_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//                                                    $j++;
//                                                }
//                                            }
//                                        }
//                                    }
//                                }
//
//                            }
//                        }
//                    }
//                }
//                var_dump('装瓶厂数据已跑完');
//                break;
//            case 'city':
//                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
//                    foreach($channel_arr as $channelkey => $channelvalue){
//                        foreach($platform_arr as $platformkey => $platformvalue){
//                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
//                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
//                                        foreach ($level_arr as $level => $levelvalue){
//                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                $times++;
//                                                var_dump('这是第'.$times.'次循环');
//                                                $select_4=' city,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                $datainfosql="SELECT ".$select_4."
//	count(*)*1.0/count(distinct storeid)
//FROM
//	sku_2018
//WHERE
//	dt = '2018-11-01'
//GROUP BY
//	LEVEL,
//	pack_level,
//	city,
//	city_level,
//	channel,
//	platform,
//	type,
//	manu,
//	pinpai";
//                                                $datasql[] = $datainfosql;
////                                                echo '<pre>';var_dump($datainfosql);exit;
////                                                $j=0;
////                                                $res=true;
//////                                                   exit;
////                                                while($res){
////                                                    $start=$j*100000;
////                                                    $res = $this->update_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
////                                                    $j++;
////                                                }
//////
//                                            }
//                                        }
//                                    }
//                                }
//
//                            }
//                        }
//                    }
//                }
//                var_dump('城市数据已跑完');
//                break;
//        }
        switch ($region){
            case 'zpjt':
                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                    foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                        foreach($channel_arr as $channelkey => $channelvalue){
                            foreach($platform_arr as $platformkey => $platformvalue){
                                foreach($type_arr as $typekey => $typevalue){
                                    foreach ($manu_arr as $manukey => $manuvalue){
                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                        foreach ($level_arr as $level => $levelvalue){
                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                $times++;
                                                var_dump('这是第'.$times.'次循环');
                                                Yii::log(print_r($times,true),'warning');
                                                $select_1=''.$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                    $select_2=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS a_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
//                                                    $select_3=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS lastzpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
//                                                    $select_4=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS thiszpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
//                                                    $select_5=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS d_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                                $select_6=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as store_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?'':' AS store_platform');
                                                $select_7=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as laststore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                                $select_8=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as allstore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                $select_9=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as lastoff_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastoff_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastoff_channel,');
//                                                    $on_1='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=a_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
//                                                    $on_2='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastzpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=thiszpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
//                                                    $on_4='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=d_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');
                                                $on_5='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=store_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                $on_6='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=laststore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                                $on_7='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=allstore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                $on_8='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastoff_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastoff_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=lastoff_channel');

//                                                    $on_1=rtrim($on_1,'and ');
//                                                    $on_2=rtrim($on_2,'and ');
//                                                    $on_3=rtrim($on_3,'and ');
//                                                    $on_4=rtrim($on_4,'and ');
                                                $on_5=rtrim($on_5,'and ');
                                                $on_6=rtrim($on_6,'and ');
                                                $on_7=rtrim($on_7,'and ');
                                                $on_8=rtrim($on_8,'and ');

                                                $datainfosql="SELECT "
                                                    .$select_1.
                                                    "
	case when sum(uc)=0 then 0 else sum(value_1)/sum(uc) end,
	store.salecount
FROM
	sku_2019_q3
	LEFT JOIN (
	SELECT
		sum(salecount) as salecount,".$select_6. " FROM
		stores_2019_q3 
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel
		) AS store ON(".$on_5.") 			
GROUP BY
	level,
	pack_level,
	zpjt,
	city_level,
	channel,
	platform,
	type,
	pinpai,
	manu,
	store.salecount";

                                                $datasql[] = $datainfosql;
//                                                    echo"<pre>";var_dump($datainfosql);exit;
//                                                if($times<118){
//                                                $this->update_vQ1($datainfosql,0,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//                                                }
                                                //
                                                //exit;
//                                                    $j=0;
//                                                    $res=true;
//                                                    while($res){
//                                                        $start=$j*100000;
//                                                        $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                        $j++;
//                                                    }
                                            }
                                        }
                                    }
                                }

                                }
                            }
                        }
                    }
                }
                var_dump('装瓶集团数据已跑完');
                break;
            case 'zpc':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
                                foreach ($manu_arr as $manukey => $manuvalue){
                                foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                    foreach ($level_arr as $level => $levelvalue){
                                        foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                            $times++;
                                            var_dump('这是第'.$times.'次循环');
                                            $select_1=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                $select_2=' zpc AS a_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
//                                                $select_3=' zpc AS lastzpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
////                                                    $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ');
////                                                    $select_5=' zpc AS d_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ');
//                                                $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
//                                                $select_5=' zpc AS d_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                            $select_6=' zpc as store_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?'':' AS store_platform');
                                            $select_7=' zpc as laststore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                            $select_8=' zpc as allstore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                            $select_9=' zpc as lastoff_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastoff_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastoff_channel,');

//                                                $on_1=' zpc=a_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
//                                                $on_2=' zpc=lastzpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype  ');
//                                                    $on_4=' zpc=d_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type  ');
//                                                $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
//                                                $on_4=' zpc=d_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');

                                            $on_5=' zpc=store_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                            $on_6=' zpc=laststore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                            $on_7=' zpc=allstore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                            $on_8=' zpc=lastoff_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastoff_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=lastoff_channel');

//                                                $on_1=rtrim($on_1,'and ');
//                                                $on_2=rtrim($on_2,'and ');
//                                                $on_3=rtrim($on_3,'and ');
//                                                $on_4=rtrim($on_4,'and ');
                                            $on_5=rtrim($on_5,'and ');
                                            $on_6=rtrim($on_6,'and ');
                                            $on_7=rtrim($on_7,'and ');
                                            $on_8=rtrim($on_8,'and ');
                                            $datainfosql="SELECT "
                                                .$select_1.
                                                "
	case when sum(uc)=0 then 0 else sum(value_1)/sum(uc) end,
	store.salecount
FROM
	sku_2019_q3
	LEFT JOIN (
	SELECT
		sum(salecount) as salecount,".$select_6. " FROM
		stores_2019_q3 
	GROUP BY
		zpc,
		city_level,
		platform,
		channel
		) AS store ON(".$on_5.") 
GROUP BY
	level,
	pack_level,
	zpc,
	manu,
	city_level,
	channel,
	platform,
	type,
	pinpai,
	store.salecount";
//                                                if($region=='zpc'){
//                                                    $datainfosql=str_replace('zpjt','zpc',$datainfosql);
//                                                }
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
                                            $datasql[] = $datainfosql;
//                                                echo "<pre>";var_dump($datainfosql);exit;
                                            $this->update_vQ1($datainfosql,0,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);

//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                    $j++;
//                                                }
                                        }
                                    }
                                    }
                                }

                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
//                }
                break;
            case 'city':
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
                                foreach ($manu_arr as $manukey => $manuvalue){
                                foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                    foreach ($level_arr as $level => $levelvalue){
                                        foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                            $times++;
                                            var_dump('这是第'.$times.'次循环');
                                            $select_1=' city,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                $select_2=' city AS a_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
//                                                $select_3=' city AS lastcity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
////                                                    $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ');
////                                                    $select_5=' city AS d_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ');
//                                                $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
//                                                $select_5=' city AS d_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                            $select_6=' city as store_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?'':' AS store_platform');
                                            $select_7=' city as laststore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                            $select_8=' city as allstore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                            $select_9=' city as lastoff_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastoff_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastoff_channel,');

//                                                $on_1=' city=a_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
//                                                $on_2=' city=lastcity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype  ');
//                                                    $on_4=' city=d_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type  ');
//                                                $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
//                                                $on_4=' city=d_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');

                                            $on_5=' city=store_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                            $on_6=' city=laststore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                            $on_7=' city=allstore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                            $on_8=' city=lastoff_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastoff_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=lastoff_channel');

//                                                $on_1=rtrim($on_1,'and ');
//                                                $on_2=rtrim($on_2,'and ');
//                                                $on_3=rtrim($on_3,'and ');
//                                                $on_4=rtrim($on_4,'and ');
                                            $on_5=rtrim($on_5,'and ');
                                            $on_6=rtrim($on_6,'and ');
                                            $on_7=rtrim($on_7,'and ');
                                            $on_8=rtrim($on_8,'and ');
                                            $datainfosql="SELECT "
                                                .$select_1. "
	case when sum(uc)=0 then 0 else sum(value_1)/sum(uc) end,
	store.salecount
FROM
	sku_2019_q3
	LEFT JOIN (
	SELECT
		sum(salecount) as salecount,".$select_6. " FROM
		stores_2019_q3
	GROUP BY
		city,
		city_level,
		platform,
		channel
		) AS store ON(".$on_5.") 
GROUP BY
	level,
	pack_level,
	city,
	city_level,
	channel,
	platform,
	type,
	manu,
	pinpai,
	store.salecount";
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
                                            $datasql[] = $datainfosql;
//                                                echo "<pre>";var_dump($datainfosql);exit;
                                            $this->update_vQ1($datainfosql,0,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);

//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                    $j++;
//                                                }
                                        }
                                    }
                                    }
                                }

                            }
                        }
                    }
                }
                var_dump('城市数据已跑完');
                break;
        }


//        echo "<pre>"; var_dump($datasql[255]);exit;
        for($i=40;$i<count($datasql);$i++){
            $this->update_vQ1($datasql[$i],0,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
        }

    }
    public function update_vQ1($datainfosql,$start, $Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level ,$region)
    {
//        set_time_limit('-1');//不限制执行时间
//        var_dump(1255664);
        $base = base64_encode('admin:KYLIN');
        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
        $params = CJSON::encode([
            'sql' => $datainfosql,
            'project' => 'O2O_retail',
            "acceptPartial" => false,
//            'offset' => $start,
//            'limit' => 20000
        ]);
        $t1 = microtime(true);
        $data = $this->getRetailCurl($url, $params, $header);
        $t2 = microtime(true);
        var_dump('麒麟调用数据耗时' . round($t2 - $t1, 3) . '秒');
        $data = $data["results"];
        $uodatedata=[];
//       echo "<pre/>";var_dump($data);exit;
        if (!empty($data)) {//不为空的判断
            $info = array();
            var_dump('又一次请求');
            foreach ($data as $key => $value) {
                $reg=1;
                switch($region){
                    case 'zpjt':
                        $reg = $value[0] == "SCCL" ? 2 : ($value[0] == "CBL" ? 3 : ($value[0] == "ZH" ? 65 : ($value[0] == "全部" ? 1 : 0)));
                        break;
                    case 'zpc':
                        $Relationid = $Relation[$value[0]];
                        $reg = $Relationid ? $Relationid->id : 0;
                        break;
                    case 'city':
                        $city=rtrim($value[0], "市");
                        $Relationid = $Relation[$city];
                        $reg = $Relationid ? $Relationid->id : 0;
                        break;
                }
                $city_levelid = isset($Citylevel[$value[1]]) ? $Citylevel[$value[1]]->id : 0;
                $info[$key]['cityLevel_id'] = $city_levelid;
                $channelid = isset($System[$value[2]]) ? $System[$value[2]]->id : 0;
                $info[$key]['system_id'] = $channelid;
                $platformid = isset($Platform[$value[3]]) ? $Platform[$value[3]]->id : 0;
                $info[$key]['platform_id'] = $platformid;
                $skuid = isset($Category[$value[4]]) ? $Category[$value[4]]->id : 0;
                $info[$key]['category_id'] = $skuid;
                $manuid = isset($manu[$value[5]]) ? $manu[$value[5]]->id : 0;
                $info[$key]['menu_id'] = $manuid;
                $pinpaiid = isset($pinpai[$value[6]]) ? $pinpai[$value[6]]->id : 0;
                $info[$key]['brand_id'] = $pinpaiid;
                $info[$key]['capacity_id'] = isset($level[$value[7]]) ? $level[$value[7]]->id : 0;
                $info[$key]['bottle_id'] = isset($pack_level[$value[8]]) ? $pack_level[$value[8]]->id : 0;
//                if($skuid===1){
////                    不选品类
//                    $sku_number=$value[10]!=0?$value[8]/$value[10]:0;
//                }
//                else{
////                    选品类
//                    $sku_number=$value[9]!=0?$value[8]/$value[9]:0;
//                }

//                    $data1 =Info::model()->tableName('2018_12_0')->find(array('condition'=>'relation_id='.$reg.' and cityLevel_id='.$city_levelid.' and system_id='.$channelid.' and platform_id='.$platformid
//                    .' and category_id='.$skuid.' and menu_id='.$manuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id']));
//                sku_number
                $sql='select id from cola_info_2019_q3_0 where relation_id='.$reg.' and cityLevel_id='.$city_levelid.' and system_id='.$channelid.' and platform_id='.$platformid
                    .' and category_id='.$skuid.' and menu_id='.$manuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id'];
//                $sql='select id,saleroom,sales_numbers from cola_info_2019_q1_0 where relation_id='.$reg.' and cityLevel_id='.$city_levelid.' and system_id='.$channelid.' and platform_id='.$platformid
//                    .' and category_id='.$skuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id'];
                $t1 = microtime(true);
//                    $data1=Yii::app()->db->createCommand($sql)->queryRow();
//                var_dump(1111111); var_dump($sql);exit;

                $data1=Yii::app()->db->createCommand($sql)->queryAll();

                foreach ($data1 as $key =>$value1){
//                    echo "<pre>";var_dump($value[8]);var_dump($value1['sku_number']);exit;
                    $uodatedata[$value1['id']]=array(

                        'salecount' => $value[10],
                        'value_per_uc' => $value[9],
//                        'last_sku_number' => $value[9]!=0?($value1['sku_number']-$value[9])/$value[9]:0,
//                        'sales_quota' => $value[9]!=0?$value1['sales_numbers']/$value[9]:0,
                    );
                }
//                $t2 = microtime(true);
//                $res = round($t2 - $t1, 3);
//                var_dump('查询数据库' . round($res, 3) . '秒');
//                    if ($data1) {
//                    $uodatedata[$data1['id']] = array(
//                        'distribution_store' => $value[9]!=0 &&$value[9]!='' ?$value[9]:0,
//                        'last_distribution_store' => $value[10]!=0 &&$value[10]!=''? $value[10]:0,
//                    );
//                }
//              var_dump($reg.'|'.$city_levelid.' system_id='.$channelid.' and platform_id='.$platformid
//                  .' and category_id='.$skuid.' and menu_id='.$manuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id']);
//              echo "<pre>";
//              var_dump($uodatedata);
//              var_dump('__________________________________');exit;
            }
//                var_dump($uodatedata);var_dump('...................');exit;
            $t1 = microtime(true);
//                $this->updateList(['sales_share', 'sales_quota'], $uodatedata, 'cola_info_2019_q1_0');
            $this->updateList(['salecount','value_per_uc'], $uodatedata, 'cola_info_2019_q3_0');
            $t2 = microtime(true);
            $res = round($t2 - $t1, 3);
            var_dump('更新数据库' . round($res, 3) . '秒');

        }
        else {
            return 0;
        }
    }
//Q2
    public function HasChangeRateQ2()
    {
        ini_set('memory_limit','-1');
        //判断该期数据是否有VS PP，有则需要获得上期数据，否则不需要
        $zpjt = Relation::model()->findAll(['condition' => 'depth=1', 'index' => 'name']); //装瓶集团，有全部
        $zpc = Relation::model()->findAll(['condition' => 'depth=2', 'index' => 'name']);//装瓶厂，没有全部
        $city = Relation::model()->findAll(['condition' => 'depth=3', 'index' => 'name']);//城市，没有全部
        $city_level = Citylevel::model()->findAll(['index' => 'name']); //城市等级，有全部
        $channel = System::model()->findAll(['index' => 'name']);//渠道，有全部
        $platform = Platform::model()->findAll(['index' => 'name']);//平台，有全部
        $category = Category::model()->findAll(['index' => 'name']);//品类，有全部
        $manu = Menu::model()->findAll(['index' => 'name']);//制造商，有全部
        $pinpai = Brand::model()->findAll(['index' => 'name']);//品牌，有全部
        $level = TotalClassify::model()->findAll(['condition' => 'classify=1', 'index' => 'name']); //容量分级，有全部
        $pack_level = TotalClassify::model()->findAll(['condition' => 'classify=2', 'index' => 'name']); //瓶量分级，有全部
        $this->HasChangeRateCircleQ2($zpjt,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpjt');
        var_dump('-----------------------------------------1');
        $this->HasChangeRateCircleQ2($zpc,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpc');
        var_dump('-----------------------------------------2');
        $this->HasChangeRateCircleQ2($city,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'city');
        var_dump('-----------------------------------------3');
    }
    public function HasChangeRateCircleQ2($Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level,$region)
    {
        $brand=$pinpai;
        $capacity=$level;
        $bottle=$pack_level;
        $zpjt_arr=["'全部' zpjt",' zpjt'];
        $city_level_arr=["'全部' city_level",'city_level'];
        $channel_arr=["'全部' channel",'channel'];
        $platform_arr=["'全部' platform",'platform'];
        $type_arr=["'全部' type",'type'];
        $manu_arr=["'全部' manu",'manu'];
//        $manu_arr=['manu',"'全部' manu"];
        $pinpai_arr=["'全部' pinpai",'pinpai'];
        $level_arr=["'全部' level",'level'];
        $pack_level_arr=["'全部' pack_level",'pack_level'];
        $datasql = array();
        $times=0;
        switch ($region){
            case 'zpjt':
                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                    foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                        foreach($channel_arr as $channelkey => $channelvalue){
                            foreach($platform_arr as $platformkey => $platformvalue){
                                foreach($type_arr as $typekey => $typevalue){
                                    foreach ($manu_arr as $manukey => $manuvalue){
                                        foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                            foreach ($level_arr as $level => $levelvalue){
                                                foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                    $times++;
                                                    var_dump('这是第'.$times.'次循环');
//                                                    Yii::log(print_r($times,true),'warning');
                                                    $select_1=''.$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                    $select_2=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS a_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                    $select_3=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS lastzpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
                                                    $select_4=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS thiszpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                    $select_5=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS d_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                                    $select_6=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as store_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                    $select_7=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as laststore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                                    $select_8=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as allstore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                    $select_9=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as lastoff_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastoff_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastoff_channel,');
                                                    $on_1='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=a_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                    $on_2='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastzpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
                                                    $on_3='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=thiszpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                    $on_4='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=d_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');
                                                    $on_5='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=store_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                    $on_6='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=laststore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                                    $on_7='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=allstore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                    $on_8='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastoff_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastoff_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=lastoff_channel');

                                                    $on_1=rtrim($on_1,'and ');
                                                    $on_2=rtrim($on_2,'and ');
                                                    $on_3=rtrim($on_3,'and ');
                                                    $on_4=rtrim($on_4,'and ');
                                                    $on_5=rtrim($on_5,'and ');
                                                    $on_6=rtrim($on_6,'and ');
                                                    $on_7=rtrim($on_7,'and ');
                                                    $on_8=rtrim($on_8,'and ');

                                                    $datainfosql="SELECT "
                                                        .$select_1.
                                                        "sum(salescount),
	sum(sales_amount),
	count( DISTINCT storeid_copy ),
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	b.lastsaleroom,
	b.lastsales_numbers,
	b.sku_number,
	b.sku_stores, 
	b.cuxiao,
	b.dis,
	b.on_sale,
	c.ko_amount,
	c.ko_count,
	d.lastko_amount,
	d.lastko_count,
	store.store_num,
	store.store_orders,
	laststore.laststore_num,
	laststore.laststore_orders,
	allstore.allstores,
	lastoff.lastoff,
    a.per_uc
FROM
	sku_2019_q3
	LEFT JOIN (
	SELECT
		count(*) AS a_sku_number,
		sum(cuxiao) as a_cuxiao,
		sum(dis) as a_dis,
		case when sum(uc)=0 then 0 else sum(value_1)/sum(uc) end as per_uc,
		sum(on_sale) as a_on_sale,".$select_2.
                                                        " FROM
		sku_2019_q3 
	
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT
		sum( sales_amount ) AS lastsaleroom,
		sum(salescount) as lastsales_numbers,
		count(*) AS sku_number,
		count( DISTINCT storeid_copy ) as sku_stores,
		sum(cuxiao) cuxiao,
		sum(dis) as dis,
		sum(on_sale) as on_sale,".$select_3. " FROM
		sku_2019_q2 
	
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS b ON(".$on_2.") 
	LEFT JOIN (SELECT "." ".$select_4. "sum(sales_amount) ko_amount,
		sum(salescount) ko_count
	FROM
		sku_2019_q3 
	
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS c ON (".$on_3.")
		LEFT JOIN (
	SELECT ".$select_5.
                                                        " sum(sales_amount) lastko_amount,
		sum(salescount) lastko_count
	FROM
		sku_2019_q2 
	
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS d ON (".$on_4.")	
	LEFT JOIN (
	SELECT ".$select_6.
                                                        "COUNT(DISTINCT ID) store_num,
	    sum(salecount) store_orders
	FROM
		stores_2019_q3 
	
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_7.
                                                        "COUNT(DISTINCT ID) laststore_num,
	    sum(salecount) laststore_orders
	FROM
		stores_2019_q2
	
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel
		) AS laststore ON (".$on_6.")
	
	LEFT JOIN (
	SELECT ".$select_8.
                                                        "sum(xxmd)*3 allstores
	FROM
		xxmd_2019_q3 
	GROUP BY
		zpjt,
		city_level,
		channel
		) AS allstore ON (".$on_7.")
		
		LEFT JOIN (
	SELECT ".$select_9.
                                                        "sum(xxmd)*3 lastoff
	FROM
		xxmd_2019_q2 
	GROUP BY
		zpjt,
		city_level,
		channel
		) AS lastoff ON (".$on_8.")
		
GROUP BY
	level,
	pack_level,
	zpjt,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
    b.lastsaleroom,
	b.lastsales_numbers,
	b.sku_number,
	b.cuxiao,
	b.sku_stores,
	b.dis,
	c.ko_amount,
	c.ko_count,
	d.lastko_amount,
	d.lastko_count,
	store.store_num,
	store.store_orders,
	laststore.laststore_num,
	laststore.laststore_orders,
	allstore.allstores,
	lastoff.lastoff,
	a.per_uc,	
	b.on_sale";

                                                    $datasql[] = $datainfosql;
//                                                    echo"<pre>";var_dump($datainfosql);exit;
                                                    $this->HasChangeRateRequestQ2($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
                                                }
                                            }
                                        }
                                    }

                                }
                            }
                        }
                    }
                }
                var_dump('装瓶集团数据已跑完');
                break;
            case 'zpc':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
                                foreach ($manu_arr as $manukey => $manuvalue){
                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                        foreach ($level_arr as $level => $levelvalue){
                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                $times++;
                                                var_dump('这是第'.$times.'次循环');
                                                $select_1=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                $select_2=' zpc AS a_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                $select_3=' zpc AS lastzpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
//                                                    $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ');
//                                                    $select_5=' zpc AS d_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ');
                                                $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                $select_5=' zpc AS d_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                                $select_6=' zpc as store_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                $select_7=' zpc as laststore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                                $select_8=' zpc as allstore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                $select_9=' zpc as lastoff_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastoff_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastoff_channel,');

                                                $on_1=' zpc=a_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                $on_2=' zpc=lastzpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype  ');
//                                                    $on_4=' zpc=d_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type  ');
                                                $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                $on_4=' zpc=d_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');

                                                $on_5=' zpc=store_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                $on_6=' zpc=laststore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                                $on_7=' zpc=allstore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                $on_8=' zpc=lastoff_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastoff_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=lastoff_channel');

                                                $on_1=rtrim($on_1,'and ');
                                                $on_2=rtrim($on_2,'and ');
                                                $on_3=rtrim($on_3,'and ');
                                                $on_4=rtrim($on_4,'and ');
                                                $on_5=rtrim($on_5,'and ');
                                                $on_6=rtrim($on_6,'and ');
                                                $on_7=rtrim($on_7,'and ');
                                                $on_8=rtrim($on_8,'and ');
                                                $datainfosql="SELECT "
                                                    .$select_1.
                                                    "sum(salescount),
	sum(sales_amount),
	count( DISTINCT storeid_copy ),
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	b.lastsaleroom,
	b.lastsales_numbers,
	b.sku_number,
	b.sku_stores, 
	b.cuxiao,
	b.dis,
	b.on_sale,
	c.ko_amount,
	c.ko_count,
	d.lastko_amount,
	d.lastko_count,
	store.store_num,
	store.store_orders,
	laststore.laststore_num,
	laststore.laststore_orders,
	allstore.allstores,
	lastoff.lastoff,
	a.per_uc	
FROM
	sku_2019_q3
	LEFT JOIN (
	SELECT 
		count(*) AS a_sku_number,
		sum(cuxiao) as a_cuxiao,
		sum(dis) as a_dis,
		case when sum(uc)=0 then 0 else sum(value_1)/sum(uc) end as per_uc,
		sum(on_sale) as a_on_sale,".$select_2.
                                                    " FROM
		sku_2019_q3
	
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT
		sum( sales_amount ) AS lastsaleroom,
		sum(salescount) as lastsales_numbers,
		count(distinct storeid_copy) as sku_stores,
		count(*) AS sku_number,
		sum(cuxiao) cuxiao,
		sum(dis) as dis,
		sum(on_sale) as on_sale,".$select_3.
                                                    " FROM
		sku_2019_q2
	
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS b ON(".$on_2.") 
	LEFT JOIN (
	SELECT  ".$select_4.
                                                    " sum(sales_amount) ko_amount,
		sum(salescount) ko_count
	FROM
		sku_2019_q3
	
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS c ON (".$on_3.")
	
		LEFT JOIN (
	SELECT ".$select_5.
                                                    " sum(sales_amount) lastko_amount,
		sum(salescount) lastko_count
	FROM
		sku_2019_q2 
  
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS d ON (".$on_4.")	
	LEFT JOIN (
	SELECT ".$select_6.
                                                    " COUNT(DISTINCT ID) store_num,
	    sum(salecount) store_orders
	FROM
		stores_2019_q3 
	
	GROUP BY
		zpc,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_7.
                                                    " COUNT(DISTINCT ID) laststore_num,
	    sum(salecount) laststore_orders
	FROM
		stores_2019_q2 
	 
	GROUP BY
		zpc,
		city_level,
		platform,
		channel
		) AS laststore ON (".$on_6.")
	
	LEFT JOIN (
	SELECT ".$select_8.
                                                    " sum(xxmd)*3 allstores
	FROM
		xxmd_2019_q3 
	GROUP BY
		zpc,
		city_level,
		channel
		) AS allstore ON (".$on_7.")
		
			LEFT JOIN (
	SELECT ".$select_9.
                                                    "sum(xxmd)*3 lastoff
	FROM
		xxmd_2019_q2 
	GROUP BY
		zpc,
		city_level,
		channel
		) AS lastoff ON (".$on_8.")
		
GROUP BY
	level,
	pack_level,
	zpc,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
    b.lastsaleroom,
	b.lastsales_numbers,
	b.sku_number,
	b.cuxiao,
	b.dis,
	b.sku_stores,
	c.ko_amount,
	c.ko_count,
	d.lastko_amount,
	d.lastko_count,
	store.store_num,
	store.store_orders,
	laststore.laststore_num,
	laststore.laststore_orders,
	allstore.allstores,
	lastoff.lastoff,
	a.per_uc,
	b.on_sale";

//                                                if($region=='zpc'){
//                                                    $datainfosql=str_replace('zpjt','zpc',$datainfosql);
//                                                }
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
                                                $datasql[] = $datainfosql;
//                                                echo "<pre>";var_dump($datainfosql);exit;
                                                $this->HasChangeRateRequestQ2($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);

//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                    $j++;
//                                                }
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
//                }
                break;
            case 'city':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
                                foreach ($manu_arr as $manukey => $manuvalue){
                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                        foreach ($level_arr as $level => $levelvalue){
                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
                                                $times++;
                                                var_dump('这是第'.$times.'次循环');
                                                $select_1=' city,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                $select_2=' city AS a_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as a_manu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                $select_3=' city AS lastcity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
//                                                    $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ');
//                                                    $select_5=' city AS d_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ');
                                                $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                $select_5=' city AS d_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                                $select_6=' city as store_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                $select_7=' city as laststore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                                $select_8=' city as allstore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                $select_9=' city as lastoff_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastoff_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastoff_channel,');

                                                $on_1=' city=a_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($manuvalue==$manu_arr[0]?' ':'manu=a_manu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                $on_2=' city=lastcity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype  ');
//                                                    $on_4=' city=d_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type  ');
                                                $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                $on_4=' city=d_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');

                                                $on_5=' city=store_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                $on_6=' city=laststore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                                $on_7=' city=allstore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                $on_8=' city=lastoff_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastoff_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=lastoff_channel');

                                                $on_1=rtrim($on_1,'and ');
                                                $on_2=rtrim($on_2,'and ');
                                                $on_3=rtrim($on_3,'and ');
                                                $on_4=rtrim($on_4,'and ');
                                                $on_5=rtrim($on_5,'and ');
                                                $on_6=rtrim($on_6,'and ');
                                                $on_7=rtrim($on_7,'and ');
                                                $on_8=rtrim($on_8,'and ');
                                                $datainfosql="SELECT "
                                                    .$select_1.
                                                    "sum(salescount),
	sum(sales_amount),
	count( DISTINCT storeid_copy ),
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
	b.lastsaleroom,
	b.lastsales_numbers,
	b.sku_number,
	b.sku_stores, 
	b.cuxiao,
	b.dis,
	b.on_sale,
	c.ko_amount,
	c.ko_count,
	d.lastko_amount,
	d.lastko_count,
	store.store_num,
	store.store_orders,
	laststore.laststore_num,
	laststore.laststore_orders,
	allstore.allstores,
	lastoff.lastoff,
	a.per_uc
FROM
	sku_2019_q3
	LEFT JOIN (
	SELECT 
		count(*) AS a_sku_number,
		sum(cuxiao) as a_cuxiao,
		sum(dis) as a_dis,
		case when sum(uc)=0 then 0 else sum(value_1)/sum(uc) end as per_uc,
		sum(on_sale) as a_on_sale,".$select_2.
                                                    " FROM
		sku_2019_q3
	
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT
		sum( sales_amount ) AS lastsaleroom,
		sum(salescount) as lastsales_numbers,
		count(*) AS sku_number,
		count(distinct storeid_copy) as sku_stores, 
		sum(cuxiao) cuxiao,
		sum(dis) as dis,
		sum(on_sale) as on_sale,".$select_3.
                                                    " FROM
		sku_2019_q2 
	
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS b ON(".$on_2.") 
	LEFT JOIN (
	SELECT  ".$select_4.
                                                    " sum(sales_amount) ko_amount,
		sum(salescount) ko_count
	FROM
		sku_2019_q3

	GROUP BY
		city,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS c ON (".$on_3.")
	
		LEFT JOIN (
	SELECT ".$select_5.
                                                    " sum(sales_amount) lastko_amount,
		sum(salescount) lastko_count
	FROM
		sku_2019_q2 
	
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		type,
		pinpai,
		level,
		pack_level
		) AS d ON (".$on_4.")	
	LEFT JOIN (
	SELECT ".$select_6.
                                                    " COUNT(DISTINCT ID) store_num,
	    sum(salecount) store_orders
	FROM
		stores_2019_q3 
	
	GROUP BY
		city,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_7.
                                                    " COUNT(DISTINCT ID) laststore_num,
	    sum(salecount) laststore_orders
	FROM
		stores_2019_q2 
	
	GROUP BY
		city,
		city_level,
		platform,
		channel
		) AS laststore ON (".$on_6.")
	
	LEFT JOIN (
	SELECT ".$select_8.
                                                    " sum(xxmd)*3 allstores
	FROM
		xxmd_2019_q3 
	GROUP BY
		city,
		city_level,
		channel
		) AS allstore ON (".$on_7.")
		
		LEFT JOIN (
	SELECT ".$select_9.
                                                    " sum(xxmd)*3 lastoff
	FROM
		xxmd_2019_q2 
	GROUP BY
		city,
		city_level,
		channel
		) AS lastoff ON (".$on_8.")
		
 
GROUP BY
	level,
	pack_level,
	city,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	a.a_cuxiao,
	a.a_dis,
	a.a_on_sale,
    b.lastsaleroom,
	b.lastsales_numbers,
	b.sku_number,
	b.cuxiao,
	b.dis,
	b.sku_stores, 
	c.ko_amount,
	c.ko_count,
	d.lastko_amount,
	d.lastko_count,
	store.store_num,
	store.store_orders,
	laststore.laststore_num,
	laststore.laststore_orders,
	allstore.allstores,
	lastoff.lastoff,
	a.per_uc,
	b.on_sale";
//                                                echo "<pre>";var_dump($datainfosql);exit;
                                                $this->HasChangeRateRequestQ2($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
                break;

        }
//        for($i=64;$i<count($datasql);$i++){
//            var_dump('这是第'.$i.'次循环');
//            echo"<pre>";var_dump($datasql[$i]);exit;
//            $this->HasChangeRateRequest($datasql[$i],$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//        }
    }
    public function HasChangeRateRequestQ2($datainfosql, $Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level ,$region)
    {
        $base = base64_encode('admin:KYLIN');
        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
        $params = CJSON::encode([
            'sql' => $datainfosql,
            'project' => 'O2O_retail',
            "acceptPartial" => false,
//            'offset' => $start,
//            'limit' => 100000
        ]);
//        $t1 = microtime(true);
        $data = $this->getRetailCurl($url, $params, $header);
//        $t2 = microtime(true);
//        var_dump('麒麟调用数据耗时' . round($t2 - $t1, 3) . '秒');
        $data = $data["results"];
//        $reg='/(\d{3}(\.\d+)?)/is';//匹配数字的正则表达式
//       echo "<pre/>";var_dump($data);exit;
        if (!empty($data)) {//不为空的判断
            $info = array();
            foreach ($data as $key => $value) {
//              if($value[4]!=='组合'){
                  switch($region){
                      case 'zpjt':
                          $info[$key]['relation_id'] = $value[0] == "SCCL" ? 2 : ($value[0] == "CBL" ? 3 : ($value[0] == "ZH" ? 65 : ($value[0] == "全部" ? 1 : 0)));
                          break;
                      case 'zpc':
                          $Relationid = $Relation[$value[0]];
                          $info[$key]['relation_id'] = $Relationid ? $Relationid->id : 0;
                          break;
                      case 'city':
                          $city=rtrim($value[0], "市");
                          $Relationid = $Relation[$city];
                          $info[$key]['relation_id'] = $Relationid ? $Relationid->id : 0;
                          break;
                  }
                  $city_levelid = isset($Citylevel[$value[1]]) ? $Citylevel[$value[1]]->id : 0;
                  $info[$key]['cityLevel_id'] = $city_levelid;
                  $channelid = isset($System[$value[2]]) ? $System[$value[2]]->id : 0;
                  $info[$key]['system_id'] = $channelid;
                  $platformid = isset($Platform[$value[3]]) ? $Platform[$value[3]]->id : 0;
                  $info[$key]['platform_id'] = $platformid;
                  $skuid = isset($Category[$value[4]]) ? $Category[$value[4]]->id : 0;
                  $info[$key]['category_id'] = $skuid;
                  $manuid = isset($manu[$value[5]]) ? $manu[$value[5]]->id : 0;
                  $info[$key]['menu_id'] = $manuid;
                  $pinpaiid = isset($pinpai[$value[6]]) ? $pinpai[$value[6]]->id : 0;
                  $info[$key]['brand_id'] = $pinpaiid;
                  $info[$key]['capacity_id'] = isset($level[$value[7]]) ? $level[$value[7]]->id : 0;
                  $info[$key]['bottle_id'] = isset($pack_level[$value[8]]) ? $pack_level[$value[8]]->id : 0;
                  $info[$key]['distribution'] = ($value[27]!=0)?($value[11]/$value[27]):0;
                  $info[$key]['last_distribution'] = ($value[27]!=0&&$value[29]!=0)?$value[11]/$value[27]-$value[19]/$value[29]:0;
                  $info[$key]['sales_numbers'] = $value[9];
                  $info[$key]['last_sales_numbers'] = $value[17]!=0?($value[9]-$value[17])/$value[17]:0;
                  $info[$key]['sales_quota'] = $value[24]!=0?($value[9]/$value[24]):0;
                  $info[$key]['last_sales_quota'] = ($value[24]!=0 && $value[26]!=0)?($value[9]/$value[24]-$value[17]/$value[26]):0; //由于销售件数份额不对，变量计算错误
                  $info[$key]['saleroom'] = $value[10];
                  $info[$key]['last_saleroom'] =$value[16]!=0?($value[10]-$value[16])/$value[16]:0;
                  $info[$key]['sales_share'] = $value[23]!=0?($value[10]/$value[23]):0;
                  $info[$key]['last_sales_share'] = ($value[25]!=0&& $value[23]!=0)?($value[10]/$value[23]-$value[16]/$value[25]):0;
                  if($platformid==1){
                      $info[$key]['enrollment'] = $value[31]!=0?($value[27]/$value[31])/3:0;
                  }
                  else{
                      $info[$key]['enrollment'] = $value[31]!=0 ?($value[27]/$value[31]):0;
                  }
                  $info[$key]['last_enrollment'] = $value[31]!=0&&$value[32]!=0?($value[27]/$value[31]-$value[29]/$value[32])/3:0;
                  $info[$key]['store_money'] = $value[11]!=0 ?($value[10]/$value[11]):0;
                  $info[$key]['last_store_money'] = ($value[16]!=0 &&$value[19]!=0 &&$value[11]!=0)?($value[10]/$value[11]-$value[16]/$value[19])/($value[16]/$value[19]):0;
                  $info[$key]['store_number'] = $value[11]!=0 ?($value[9]/$value[11]):0;
                  $info[$key]['last_store_number'] = ($value[9]!=0&&$value[19]!=0&&$value[17]!=0)?($value[9]/$value[11]-$value[17]/$value[19])/($value[17]/$value[19]):0;
                  if($skuid==1){
                      $info[$key]['sku_number'] = $value[27]!=0?($value[12]/$value[27]):0;
                      $info[$key]['last_sku_number'] = ($value[27]!=0&&$value[29]!=0&&$value[18]!=0)?($value[12]/$value[27]-$value[18]/$value[29])/($value[18]/$value[29]):0;
                  }
                  else {
                      $info[$key]['sku_number'] = $value[11]!=0?($value[12]/$value[11]):0;
                      $info[$key]['last_sku_number'] = ($value[27]!=0&&$value[19]!=0&&$value[18]!=0)?($value[12]/$value[11]-$value[18]/$value[19])/($value[18]/$value[19]):0;
                  }
                  $info[$key]['distribution_store'] = $value[11]!=0?$value[11]:0;
                  $info[$key]['last_distribution_store'] = $value[19]!=0?($value[11]-$value[19])/$value[19]:0;
                  $info[$key]['average_selling_price'] = $value[12]!=0?($value[13]/$value[12]):0;
                  $info[$key]['last_average_selling_price'] =  ($value[12]!=0&&$value[20]!=0&&$value[18]!=0)?($value[13]/$value[12]-$value[20]/$value[18])/($value[20]/$value[18]):0;
                  $info[$key]['average_purchase_price'] = $value[9]!=0?($value[10]/$value[9]):0;
                  $info[$key]['last_average_purchase_price'] = ($value[16]!=0&&$value[17]!=0&&$value[9]!=0)?($value[10]/$value[9]-$value[16]/$value[17])/($value[16]/$value[17]):0;
                  $info[$key]['price_promotion_ratio'] = $value[12]!=0?($value[15]/$value[12]):0;
                  $info[$key]['last_price_promotion_ratio'] = ($value[12]!=0&&$value[20]!=0)?$value[15]/$value[12]-$value[22]/$value[20]:0;
                  $info[$key]['average_discount_factor'] = $value[15]!=0?($value[14]/$value[15]):0;
                  $info[$key]['last_average_discount_factor'] =($value[15]!=0&&$value[22]!=0)? ($value[14]/$value[15]-$value[21]/$value[22]):0;
                  $info[$key]['average_number_per_unit'] = $value[28]!=0?($value[9]/$value[28]):0;
                  $info[$key]['last_average_number_per_unit'] =  ($value[28]!=0&&$value[17]!=0&&$value[30]!=0)?($value[9]/$value[28]-$value[17]/$value[30])/($value[17]/$value[30]):0;
                  $info[$key]['average_amount_per_order'] = $value[28]!=0?$value[10]/$value[28]:0;
                  $info[$key]['last_average_amount_per_order'] = ($value[28]!=0&&$value[16]!=0&&$value[30]!=0)?($value[10]/$value[28]-$value[16]/$value[30])/($value[16]/$value[30]):0;
                  if($skuid==1){
                      $info[$key]['online_stores'] = $value[27]!=''&&$value[27]!=0?$value[27]:0;
                      $info[$key]['last_online_stores'] = $value[29]!=0?(($value[27]-$value[29])/$value[29]):0;
                  }
                  else{
                      $info[$key]['online_stores'] = $value[27]!=''&&$value[27]!=0?$value[27]:0;
                      $info[$key]['last_online_stores'] = $value[19]!=0?(($value[11]-$value[19])/$value[19]):0;
                  }
                  $info[$key]['salecount']=$value[28]!=0?$value[28]:0;
                  $info[$key]['value_per_uc']=$value[33]!=0?$value[33]:0;
//                $value_per_uc=0;
//                if($value[10]!=0&&!empty($value[32])&&$value[32]!=='组合装' && $value[32]!=='其他' && $value[32]!=='其他包装' ){
////                    preg_match_all($reg,$value[32],$result);
//                    $uc=$value[9]*(int)$value[32]/5678;
//                    $value_per_uc=$value[10]/$uc;
//                }
//                $info[$key]['value_per_uc']=$value_per_uc;
//                echo "<pre>";var_dump($info);exit;
//              }
            }

            $label = array('relation_id',
                'cityLevel_id', 'system_id', 'platform_id', 'category_id', 'menu_id', 'brand_id', 'capacity_id', 'bottle_id', 'distribution', 'last_distribution',
                'sales_numbers', 'last_sales_numbers', 'sales_quota', 'last_sales_quota', 'saleroom', 'last_saleroom', 'sales_share', 'last_sales_share', 'enrollment', 'last_enrollment', 'store_money', 'last_store_money', 'store_number', 'last_store_number',
                'sku_number', 'last_sku_number', 'distribution_store', 'last_distribution_store', 'average_selling_price', 'last_average_selling_price', 'average_purchase_price', 'last_average_purchase_price', 'price_promotion_ratio', 'last_price_promotion_ratio',
                'average_discount_factor', 'last_average_discount_factor', 'average_number_per_unit', 'last_average_number_per_unit', 'average_amount_per_order', 'last_average_amount_per_order', 'online_stores', 'last_online_stores','salecount','value_per_uc');
            $arr = array_chunk($info, 2000);
            for ($i = 0; $i < count($arr); $i++) {
//                $t1 = microtime(true);
                try{
                    $this->batchInsert('cola_info_2019_q3_0', $label, $arr[$i]);
                }
                catch(\Exception $e){
                    echo "<pre>";var_dump('错了哟',$e);
                }

//                $t2 = microtime(true);
//                $res = round($t2 - $t1, 3);
//                var_dump('插入数据库' . round($res, 3) . '秒');
            }

        }
        else {
            var_dump('麒麟调用数据失败' );
            return 0;
        }




    }

    public function UpdateInfoDataQ2()
    {
        ini_set('memory_limit','-1');
        $zpjt = Relation::model()->findAll(['condition' => 'depth=1', 'index' => 'name']); //装瓶集团，有全部
        $zpc = Relation::model()->findAll(['condition' => 'depth=2', 'index' => 'name']);//装瓶厂，没有全部
        $city = Relation::model()->findAll(['condition' => 'depth=3', 'index' => 'name']);//城市，没有全部
        $city_level = Citylevel::model()->findAll(['index' => 'name']); //城市等级，有全部
        $channel = System::model()->findAll(['index' => 'name']);//渠道，有全部
        $platform = Platform::model()->findAll(['index' => 'name']);//平台，有全部
        $category = Category::model()->findAll(['index' => 'name']);//品类，有全部
        $manu = Menu::model()->findAll(['index' => 'name']);//制造商，有全部
        $pinpai = Brand::model()->findAll(['index' => 'name']);//品牌，有全部
        $level = TotalClassify::model()->findAll(['condition' => 'classify=1', 'index' => 'name']); //容量分级，有全部
        $pack_level = TotalClassify::model()->findAll(['condition' => 'classify=2', 'index' => 'name']); //瓶量分级，有全部
        $this->getInfo_updateQ2($zpjt,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpjt');
        var_dump('-----------------------------------------1');
        $this->getInfo_updateQ2($zpc,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'zpc');
        var_dump('-----------------------------------------2');
        $this->getInfo_updateQ2($city,$city_level, $channel, $platform, $category,$manu,$pinpai, $level,$pack_level,'city');
        var_dump('-----------------------------------------3');
    }
    public function getInfo_updateQ2($Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level,$region)
    {
//        Yii::log('123456789465','error');exit;
//        var_dump("123456789");
//        set_time_limit('-1');//不限制执行时间
        $brand=$pinpai;
        $capacity=$level;
        $bottle=$pack_level;
        $zpjt_arr=["'全部' zpjt",' zpjt'];
        $city_level_arr=["'全部' city_level",'city_level'];
        $channel_arr=["'全部' channel",'channel'];
        $platform_arr=["'全部' platform",'platform'];
        $type_arr=["'全部' type",'type'];
//        $type_arr=['type'];
        $manu_arr=["'全部' manu",'manu'];
        $pinpai_arr=["'全部' pinpai",'pinpai'];
        $level_arr=["'全部' level",'level'];
        $pack_level_arr=["'全部' pack_level",'pack_level'];
        $datasql = array();
        $times=0;
//        switch ($region){
//            case 'zpjt':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
//                    foreach($city_level_arr as $city_levelkey => $city_levelvalue){
//                        foreach($channel_arr as $channelkey => $channelvalue){
//                            foreach($platform_arr as $platformkey => $platformvalue){
//                                foreach($type_arr as $typekey => $typevalue){
////                                    foreach ($manu_arr as $manukey => $manuvalue){
//                                        foreach ($pinpai_arr as $pinpai => $pinpaivalue){
//                                            foreach ($level_arr as $level => $levelvalue){
//                                                foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                    $times++;
//                                                    var_dump('这是第'.$times.'次循环');
//                                                    Yii::log(print_r($times,true),'warning');
////                                                   echo '<pre>';var_dump($datasql);exit;
////                                                   exit;
//                                                    $select_1=''.$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
////                                                    $select_3=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS lastzpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
////                                                    $on_2='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastzpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
////                                                    $on_2=rtrim($on_2,'and ');
////                                                    $datainfosql="SELECT ".$select_1."
////	sum(sales_amount),
////	sum(salescount)
////FROM
////	sku_2019
////WHERE
////	dt between '2019-01-01' and '2019-03-01'
////GROUP BY
////	LEVEL,
////	pack_level,
////	zpjt,
////	city_level,
////	channel,
////	platform,
////	type,
////	pinpai";
////                                                    $datainfosql="SELECT ".$select_1."
////	count(*)*1.0/count(distinct storeid)
////FROM
////	sku_2018
////WHERE
////	dt = '2018-11-01'
////GROUP BY
////	LEVEL,
////	pack_level,
////	zpjt,
////	city_level,
////	channel,
////	platform,
////	type,
////	manu,
////	pinpai";
//                                                    $datainfosql="SELECT ".$select_1."
//	count(*)*1.0,count(distinct storeid),
//FROM
//	sku_2018
//	left join (
//	    select count(distinct)
//	)
//WHERE
//	manu='可口可乐' and dt between '2019-01-01' and '2019-03-01'
//GROUP BY
//	LEVEL,
//	pack_level,
//	zpjt,
//	city_level,
//	channel,
//	platform,
//	type,
//	manu,
//	pinpai";
//                                                    $datasql[] = $datainfosql;
////                                                   echo '<pre>';var_dump($datainfosql);exit;
//                                                    $j=0;
//                                                    $res=true;
//                                                    while($res){
//                                                        $start=$j*100000;
//                                                        $res = $this->update_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//                                                        $j++;
//                                                    }
//                                                }
//                                            }
//                                        }
//                                    }
//
////                                }
//                            }
//                        }
//                    }
//                }
//                var_dump('装瓶集团数据已跑完');
//                break;
//            case 'zpc':
////                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
//                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
//                    foreach($channel_arr as $channelkey => $channelvalue){
//                        foreach($platform_arr as $platformkey => $platformvalue){
//                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
//                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
//                                        foreach ($level_arr as $level => $levelvalue){
//                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                $times++;
//                                                var_dump('这是第'.$times.'次循环');
////                                                $select_1=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
////                                                $select_3=' zpc AS lastzpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$manuvalue.($manuvalue==$manu_arr[0]?',':' as lastmanu,').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
////                                                $on_2=' zpc=lastzpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($manuvalue==$manu_arr[0]?' ':'manu=lastmanu and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
////                                                $on_2=rtrim($on_2,'and ');
//                                                $select_4=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                $datainfosql="SELECT ".$select_4."
//	count(*)*1.0/count(distinct storeid)
//FROM
//	sku_2018
//WHERE
//	dt = '2018-11-01'
//GROUP BY
//	LEVEL,
//	pack_level,
//	zpc,
//	city_level,
//	channel,
//	platform,
//	type,
//	manu,
//	pinpai";
//                                                $datasql[] = $datainfosql;
////                                                   echo '<pre>';var_dump($datainfosql);exit;
//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->update_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//                                                    $j++;
//                                                }
//                                            }
//                                        }
//                                    }
//                                }
//
//                            }
//                        }
//                    }
//                }
//                var_dump('装瓶厂数据已跑完');
//                break;
//            case 'city':
//                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
//                    foreach($channel_arr as $channelkey => $channelvalue){
//                        foreach($platform_arr as $platformkey => $platformvalue){
//                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
//                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
//                                        foreach ($level_arr as $level => $levelvalue){
//                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                $times++;
//                                                var_dump('这是第'.$times.'次循环');
//                                                $select_4=' city,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$manuvalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
//                                                $datainfosql="SELECT ".$select_4."
//	count(*)*1.0/count(distinct storeid)
//FROM
//	sku_2018
//WHERE
//	dt = '2018-11-01'
//GROUP BY
//	LEVEL,
//	pack_level,
//	city,
//	city_level,
//	channel,
//	platform,
//	type,
//	manu,
//	pinpai";
//                                                $datasql[] = $datainfosql;
////                                                echo '<pre>';var_dump($datainfosql);exit;
////                                                $j=0;
////                                                $res=true;
//////                                                   exit;
////                                                while($res){
////                                                    $start=$j*100000;
////                                                    $res = $this->update_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
////                                                    $j++;
////                                                }
//////
//                                            }
//                                        }
//                                    }
//                                }
//
//                            }
//                        }
//                    }
//                }
//                var_dump('城市数据已跑完');
//                break;
//        }
        switch ($region){
            case 'zpjt':
                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                    foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                        foreach($channel_arr as $channelkey => $channelvalue){
                            foreach($platform_arr as $platformkey => $platformvalue){
                                foreach($type_arr as $typekey => $typevalue){
//                                    foreach ($manu_arr as $manukey => $manuvalue){
                                    foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                        foreach ($level_arr as $level => $levelvalue){
                                            foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                                $times++;
////                                                    var_dump('这是第'.$times.'次循环');
//                                                Yii::log(print_r($times,true),'warning');
                                                $select_1=''.$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                                $select_2=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS a_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                                $select_3=''.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS lastzpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
                                                $select_4=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS thiszpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                                $select_5=' '.$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' AS d_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                                $select_6=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as store_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                                $select_7=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as laststore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                                $select_8=" ".$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?' ,':' as allstore_zpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                                $on_1='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=a_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                                $on_2='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=lastzpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
                                                $on_3='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=thiszpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                                $on_4='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=d_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');
                                                $on_5='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=store_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                                $on_6='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=laststore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                                $on_7='1=1 and '.($zpjtvalue==$zpjt_arr[0]?'':' zpjt=allstore_zpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                                $on_1=rtrim($on_1,'and ');
                                                $on_2=rtrim($on_2,'and ');
                                                $on_3=rtrim($on_3,'and ');
                                                $on_4=rtrim($on_4,'and ');
                                                $on_5=rtrim($on_5,'and ');
                                                $on_6=rtrim($on_6,'and ');
                                                $on_7=rtrim($on_7,'and ');

                                                $datainfosql="SELECT "
                                                    .$select_1.
                                                    "a.a_sku_number,count( DISTINCT storeid_copy ),store.store_num,
	b.sku_number,
	b.sku_stores, 	
	laststore.laststore_num
FROM
	sku_2019_q3
	LEFT JOIN (
	SELECT
		count(*) AS a_sku_number,".$select_2.
                                                    " FROM
		sku_2019_q3
	where manu='可口可乐'		
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		level,
		pinpai,
		pack_level,
		type
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT
		count(*) AS sku_number,
		count( DISTINCT storeid_copy ) as sku_stores,".$select_3. " FROM
		sku_2019_q2 
	where manu='可口可乐'		
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel,
		level,
		pinpai,
		pack_level,
		type 
		) AS b ON(".$on_2.") 
	LEFT JOIN (
	SELECT ".$select_6.
                                                    "COUNT(DISTINCT ID) store_num
	FROM
		stores_2019_q3 
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_7.
                                                    "COUNT(DISTINCT ID) laststore_num
	FROM
		stores_2019_q2
	GROUP BY
		zpjt,
		city_level,
		platform,
		channel
		) AS laststore ON (".$on_6.")
where manu='可口可乐'				
GROUP BY
	level,
	pack_level,
	zpjt,
	city_level,
	channel,
	platform,
	type ,
	pinpai,
	a.a_sku_number,
	b.sku_number,
	b.sku_stores,
	store.store_num,
	laststore.laststore_num";

                                                $datasql[] = $datainfosql;
//                                                    echo"<pre>";var_dump($datainfosql);exit;
                                                $this->update_vQ2($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);
//exit;
//                                                    $j=0;
//                                                    $res=true;
//                                                    while($res){
//                                                        $start=$j*100000;
//                                                        $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                        $j++;
//                                                    }
                                            }
                                        }
                                    }
                                }

                            }
//                            }
                        }
                    }
                }
                var_dump('装瓶集团数据已跑完');
                break;
            case 'zpc':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
                                foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                    foreach ($level_arr as $level => $levelvalue){
                                        foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                            $times++;
//                                            var_dump('这是第'.$times.'次循环');
                                            $select_1=' zpc,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                            $select_2=' zpc AS a_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                            $select_3=' zpc AS lastzpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
//                                                    $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ');
//                                                    $select_5=' zpc AS d_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ');
                                            $select_4=' zpc AS thiszpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                            $select_5=' zpc AS d_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                            $select_6=' zpc as store_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                            $select_7=' zpc as laststore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                            $select_8=' zpc as allstore_zpc,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                            $on_1=' zpc=a_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                            $on_2=' zpc=lastzpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype  ');
//                                                    $on_4=' zpc=d_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type  ');
                                            $on_3=' zpc=thiszpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                            $on_4=' zpc=d_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');

                                            $on_5=' zpc=store_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                            $on_6=' zpc=laststore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                            $on_7=' zpc=allstore_zpc and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                            $on_1=rtrim($on_1,'and ');
                                            $on_2=rtrim($on_2,'and ');
                                            $on_3=rtrim($on_3,'and ');
                                            $on_4=rtrim($on_4,'and ');
                                            $on_5=rtrim($on_5,'and ');
                                            $on_6=rtrim($on_6,'and ');
                                            $on_7=rtrim($on_7,'and ');
                                            $datainfosql="SELECT "
                                                .$select_1.
                                                "a.a_sku_number,
	count( DISTINCT storeid_copy ),store.store_num,
	b.sku_number,
	b.sku_stores, 
	laststore.laststore_num
FROM
    sku_2019_q3
	LEFT JOIN (
	SELECT 
		count(*) AS a_sku_number,".$select_2.
                                                " FROM
		sku_2019_q3
	where manu='可口可乐'	
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT
		count(distinct storeid_copy) as sku_stores,
		count(*) AS sku_number,".$select_3.
                                                " FROM
		sku_2019_q2
	where manu='可口可乐'	
	GROUP BY
		zpc,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS b ON(".$on_2.") 
	LEFT JOIN (
	SELECT ".$select_6.
                                                " COUNT(DISTINCT ID) store_num
	FROM
		stores_2019_q3
	GROUP BY
		zpc,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_7.
                                                "COUNT(DISTINCT ID) laststore_num
	FROM
		stores_2019_q2 
	GROUP BY
		zpc,
		city_level,
		platform,
		channel
		) AS laststore ON (".$on_6.")
where manu='可口可乐'			
GROUP BY
	level,
	pack_level,
	zpc,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	b.sku_number,
	b.sku_stores,
	store.store_num,
	laststore.laststore_num";

//                                                if($region=='zpc'){
//                                                    $datainfosql=str_replace('zpjt','zpc',$datainfosql);
//                                                }
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
//                                                echo"<pre>";var_dump($datainfosql);exit;
                                            $datasql[] = $datainfosql;
                                            $this->update_vQ2($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);

//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                    $j++;
//                                                }
                                        }
                                    }
                                }
                            }

//                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
//                }
                break;
            case 'city':
//                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                foreach($city_level_arr as $city_levelkey => $city_levelvalue){
                    foreach($channel_arr as $channelkey => $channelvalue){
                        foreach($platform_arr as $platformkey => $platformvalue){
                            foreach($type_arr as $typekey => $typevalue){
//                                foreach ($manu_arr as $manukey => $manuvalue){
                                foreach ($pinpai_arr as $pinpai => $pinpaivalue){
                                    foreach ($level_arr as $level => $levelvalue){
                                        foreach ($pack_level_arr as $pack_level => $pack_levelvalue){
//                                            $times++;
//                                            var_dump('这是第'.$times.'次循环');
                                            $select_1=' city,'.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.','.$pinpaivalue.','.$levelvalue.','.$pack_levelvalue.',';
                                            $select_2=' city AS a_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS a_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS a_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS a_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS a_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as a_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as a_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as a_pack_level ');
                                            $select_3=' city AS lastcity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as lastpinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as lastlevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?' ':' as lastpack_level ');
//                                                    $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ');
//                                                    $select_5=' city AS d_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ');
                                            $select_4=' city AS thiscity,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS thiscitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS thischannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS thisplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS thistype, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as thispinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as thislevel,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as thispack_level, ');
                                            $select_5=' city AS d_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS d_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS d_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS d_platform,').$typevalue.($typevalue==$type_arr[0]?',':' AS d_type, ').$pinpaivalue.($pinpaivalue==$pinpai_arr[0]?',':' as d_pinpai,').$levelvalue.($levelvalue==$level_arr[0]?',':' as d_level,').$pack_levelvalue.($pack_levelvalue==$pack_level_arr[0]?', ':' as d_pack_level, ');
                                            $select_6=' city as store_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS store_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS store_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS store_platform,');
                                            $select_7=' city as laststore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS laststore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS laststore_channel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS laststore_platform,');
                                            $select_8=' city as allstore_city,'.$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS allstore_citylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS allstore_channel,');
                                            $on_1=' city=a_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=a_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=a_channel and ').($platformvalue==$platform_arr[0]?'':'platform=a_platform and ').($typevalue==$type_arr[0]?' ':'type=a_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=a_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=a_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=a_pack_level ');
                                            $on_2=' city=lastcity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=lastpinpai and ').($levelvalue==$level_arr[0]?' ':'level=lastlevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=lastpack_level ');
//                                                    $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype  ');
//                                                    $on_4=' city=d_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type  ');
                                            $on_3=' city=thiscity and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=thiscitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=thischannel and ').($platformvalue==$platform_arr[0]?'':'platform=thisplatform and ').($typevalue==$type_arr[0]?' ':'type=thistype and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=thispinpai and ').($levelvalue==$level_arr[0]?' ':'level=thislevel and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=thispack_level ');
                                            $on_4=' city=d_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=d_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=d_channel and ').($platformvalue==$platform_arr[0]?'':'platform=d_platform and ').($typevalue==$type_arr[0]?' ':'type=d_type and ').($pinpaivalue==$pinpai_arr[0]?' ':'pinpai=d_pinpai and ').($levelvalue==$level_arr[0]?' ':'level=d_level and ').($pack_levelvalue==$pack_level_arr[0]?' ':'pack_level=d_pack_level ');

                                            $on_5=' city=store_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=store_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=store_channel and ').($platformvalue==$platform_arr[0]?'':'platform=store_platform ');
                                            $on_6=' city=laststore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=laststore_citylevel and ').($channelvalue==$channel_arr[0]?'':'channel=laststore_channel and ').($platformvalue==$platform_arr[0]?'':' platform=laststore_platform ');
                                            $on_7=' city=allstore_city and '.($city_levelvalue==$city_level_arr[0]?'':' city_level=allstore_citylevel and ').($channelvalue==$channel_arr[0]?'':' channel=allstore_channel');
                                            $on_1=rtrim($on_1,'and ');
                                            $on_2=rtrim($on_2,'and ');
                                            $on_3=rtrim($on_3,'and ');
                                            $on_4=rtrim($on_4,'and ');
                                            $on_5=rtrim($on_5,'and ');
                                            $on_6=rtrim($on_6,'and ');
                                            $on_7=rtrim($on_7,'and ');
                                            $datainfosql="SELECT "
                                                .$select_1.
                                                "a.a_sku_number,
	count( DISTINCT storeid_copy ),store.store_num,
	b.sku_number,
	b.sku_stores, 
	laststore.laststore_num
FROM
sku_2019_q3
	LEFT JOIN (
	SELECT 
		count(*) AS a_sku_number,".$select_2.
                                                " FROM
		sku_2019_q3
	where manu='可口可乐'		
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS a ON(".$on_1.") 
	LEFT JOIN (
	SELECT
		count(distinct storeid_copy) as sku_stores,
		count(*) AS sku_number,".$select_3.
                                                " FROM
		sku_2019_q2
	where manu='可口可乐'		
	GROUP BY
		city,
		city_level,
		platform,
		channel,
		level,
		manu,
		pinpai,
		pack_level,
		type 
		) AS b ON(".$on_2.") 
	LEFT JOIN (
	SELECT ".$select_6.
                                                " COUNT(DISTINCT ID) store_num
	FROM
		stores_2019_q3 
	GROUP BY
		city,
		city_level,
		platform,
		channel
		) AS store ON (".$on_5.")
	LEFT JOIN (
	SELECT ".$select_7.
                                                "COUNT(DISTINCT ID) laststore_num
	FROM
		stores_2019_q2 
	GROUP BY
		city,
		city_level,
		platform,
		channel
		) AS laststore ON (".$on_6.")
where manu='可口可乐'			
GROUP BY
	level,
	pack_level,
	city,
	city_level,
	channel,
	platform,
	type ,
	manu,
	pinpai,
	a.a_sku_number,
	b.sku_number,
	b.sku_stores,
	store.store_num,
	laststore.laststore_num";

//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
//                                                if($region=='city'){
//                                                    $datainfosql=str_replace('zpjt','city',$datainfosql);
//                                                }
                                            $datasql[] = $datainfosql;
                                            $this->update_vQ2($datainfosql,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region);

//                                                $j=0;
//                                                $res=true;
//                                                while($res){
//                                                    $start=$j*100000;
//                                                    $res = $this->getinfo_v($datainfosql,$start,$Relation,$Citylevel, $System, $Platform, $Category,$manu,$brand,$capacity,$bottle,$region,$table_name,$has_vs);
//                                                    $j++;
//                                                }
                                        }
                                    }
                                }
                            }

//                            }
                        }
                    }
                }
                var_dump('装瓶厂数据已跑完');
                break;
        }



//        echo "<pre>"; var_dump($datasql[255]);exit;

    }
    public function update_vQ2($datainfosql, $Relation,$Citylevel, $System, $Platform, $Category,$manu,$pinpai,$level,$pack_level ,$region)
    {
//        set_time_limit('-1');//不限制执行时间
//        var_dump(1255664);
        $base = base64_encode('admin:KYLIN');
        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
        $params = CJSON::encode([
            'sql' => $datainfosql,
            'project' => 'O2O_retail',
            "acceptPartial" => false,
//            'offset' => $start,
//            'limit' => 20000
        ]);
//        $t1 = microtime(true);
        $data = $this->getRetailCurl($url, $params, $header);
//        $t2 = microtime(true);
//        var_dump('麒麟调用数据耗时' . round($t2 - $t1, 3) . '秒');
        $data = $data["results"];
        $uodatedata=[];
//       echo "<pre/>";var_dump($data);exit;
        if (!empty($data)) {//不为空的判断
            $info = array();
            foreach ($data as $key => $value) {
                $reg=1;
                switch($region){
                    case 'zpjt':
                        $reg = $value[0] == "SCCL" ? 2 : ($value[0] == "CBL" ? 3 : ($value[0] == "ZH" ? 65 : ($value[0] == "全部" ? 1 : 0)));
                        break;
                    case 'zpc':
                        $Relationid = $Relation[$value[0]];
                        $reg = $Relationid ? $Relationid->id : 0;
                        break;
                    case 'city':
                        $city=rtrim($value[0], "市");
                        $Relationid = $Relation[$city];
                        $reg = $Relationid ? $Relationid->id : 0;
                        break;
                }
                $city_levelid = isset($Citylevel[$value[1]]) ? $Citylevel[$value[1]]->id : 0;
                $info[$key]['cityLevel_id'] = $city_levelid;
                $channelid = isset($System[$value[2]]) ? $System[$value[2]]->id : 0;
                $info[$key]['system_id'] = $channelid;
                $platformid = isset($Platform[$value[3]]) ? $Platform[$value[3]]->id : 0;
                $info[$key]['platform_id'] = $platformid;
                $skuid = isset($Category[$value[4]]) ? $Category[$value[4]]->id : 0;
                $info[$key]['category_id'] = $skuid;
//                $manuid = isset($manu[$value[5]]) ? $manu[$value[5]]->id : 0;
//                $info[$key]['menu_id'] = $manuid;
                $pinpaiid = isset($pinpai[$value[5]]) ? $pinpai[$value[5]]->id : 0;
                $info[$key]['brand_id'] = $pinpaiid;
                $info[$key]['capacity_id'] = isset($level[$value[6]]) ? $level[$value[6]]->id : 0;
                $info[$key]['bottle_id'] = isset($pack_level[$value[7]]) ? $pack_level[$value[7]]->id : 0;
                if($skuid===1){
//                    不选品类
                    $sku_number=$value[10]!=0?$value[8]/$value[10]:0;
                    $last_sku_number=$value[8]!=0&&$value[10]!=0&&$value[11]!=0?($value[8]/$value[10]-$value[11]/$value[13])/($value[11]/$value[13]):0;
                }
                else{
//                    选品类
                    $sku_number=$value[9]!=0?$value[8]/$value[9]:0;
                    $last_sku_number=$value[9]!=0&&$value[11]!=0&&$value[12]!=0?($value[8]/$value[9]-$value[11]/$value[12])/($value[11]/$value[12]):0;
                }
//                echo "<pre>";var_dump($data);var_dump($sku_number);var_dump($last_sku_number);exit;
//                var_dump($data);echo "<br>";var_dump($sku_number);var_dump($last_sku_number);exit;
//                    $data1 =Info::model()->tableName('2018_12_0')->find(array('condition'=>'relation_id='.$reg.' and cityLevel_id='.$city_levelid.' and system_id='.$channelid.' and platform_id='.$platformid
//                    .' and category_id='.$skuid.' and menu_id='.$manuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id']));
//                sku_number
                $sql='select id from cola_info_2019_q3_0 where relation_id='.$reg.' and cityLevel_id='.$city_levelid.' and system_id='.$channelid.' and platform_id='.$platformid
                    .' and category_id='.$skuid.' and brand_id='.$pinpaiid.' and menu_id=2 and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id'];
//                $sql='select id,saleroom,sales_numbers from cola_info_2019_q1_0 where relation_id='.$reg.' and cityLevel_id='.$city_levelid.' and system_id='.$channelid.' and platform_id='.$platformid
//                    .' and category_id='.$skuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id'];
                $t1 = microtime(true);
//                    $data1=Yii::app()->db->createCommand($sql)->queryRow();
//                var_dump($sql);
                $data1=Yii::app()->db->createCommand($sql)->queryAll();
                foreach ($data1 as $key =>$value1){
                    $uodatedata[$value1['id']]=array(
                        'sku_number' => $sku_number,
                        'last_sku_number' => $last_sku_number,
//                        'last_sku_number' => $value[9]!=0?($value1['sku_number']-$value[9])/$value[9]:0,
//                        'sales_quota' => $value[9]!=0?$value1['sales_numbers']/$value[9]:0,
                    );
                }
//                $t2 = microtime(true);
//                $res = round($t2 - $t1, 3);
//                var_dump('查询数据库' . round($res, 3) . '秒');
//                    if ($data1) {
//                    $uodatedata[$data1['id']] = array(
//                        'distribution_store' => $value[9]!=0 &&$value[9]!='' ?$value[9]:0,
//                        'last_distribution_store' => $value[10]!=0 &&$value[10]!=''? $value[10]:0,
//                    );
//                }
//              var_dump($reg.'|'.$city_levelid.' system_id='.$channelid.' and platform_id='.$platformid
//                  .' and category_id='.$skuid.' and menu_id='.$manuid.' and brand_id='.$pinpaiid.' and capacity_id='.$info[$key]['capacity_id'].' and bottle_id='.$info[$key]['bottle_id']);
//              echo "<pre>";
//              var_dump($uodatedata);
//              var_dump('__________________________________');exit;
            }
//                var_dump($uodatedata);var_dump('...................');exit;
//            $t1 = microtime(true);
//          $this->updateList(['sales_share', 'sales_quota'], $uodatedata, 'cola_info_2019_q1_0');

            $this->updateList(['sku_number','last_sku_number'], $uodatedata, 'cola_info_2019_q3_0');
//            $t2 = microtime(true);
//            $res = round($t2 - $t1, 3);
//            var_dump('更新数据库' . round($res, 3) . '秒');

        }
        else {
            var_dump('调用麒麟数据失败');
            return 0;
        }
    }



}
