<?php

/**
 * This is the model class for table "{{info_cvs}}".
 *
 * The followings are the available columns in table '{{info_cvs}}':
 * @property integer $Id
 * @property string $time
 * @property integer $stage
 * @property integer $relationship_id
 * @property integer $system_id
 * @property integer $sku_id
 * @property integer $shelves
 * @property integer $activity
 * @property integer $mechanism
 * @property integer $equipment
 * @property double $distribution
 * @property double $sovi
 * @property double $price_anomaly
 * @property double $thematic_activity
 * @property double $promotion
 * @property double $equipment_sales
 * @property double $Last_distribution_radio
 * @property double $Last_sovi_radio
 * @property double $Last_price_anomaly_radio
 * @property double $Last_thematic_activity_radio
 * @property double $Last_promotion_radio
 * @property double $Last_equipment_sales_radio
 * @property double $distribution_stores
 * @property double $shelf_number
 * @property double $Last_distribution_stores_radio
 * @property double $Last_shelf_number_radio
 * @property double $extra_displays
 * @property double $Last_extra_displays_radio
 * @property double $Last_extra_stores
 * @property integer $extraSku
 * @property integer $extra_stores
 * @property double $freezer_shop
 */
class InfoCvs extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $bottler;
    public $group;
    public $city;
    public $type;
    public $customer_system;
    public $category;
    public $brand;
    public $news;

    public function tableName() {
        return '{{info_cvs}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('time, stage, relationship_id, system_id, sku_id', 'required'),
            array('stage, relationship_id, system_id, sku_id', 'numerical', 'integerOnly' => true),
            array('distribution, sovi, price_anomaly,thematic_activity, promotion, equipment_sales, Last_distribution_radio, Last_sovi_radio, Last_price_anomaly_radio, Last_thematic_activity_radio, Last_promotion_radio, Last_equipment_sales_radio', 'numerical'),
            array('time, shelves, activity, mechanism, equipment,distribution_stores,shelf_number,Last_distribution_stores_radio,Last_shelf_number_radio', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Id, time, stage, relationship_id, system_id, sku_id, shelves, activity, mechanism, equipment, distribution, sovi, price_anomaly, thematic_activity, promotion, equipment_sales, Last_distribution_radio, Last_sovi_radio, Last_price_anomaly_radio, Last_thematic_activity_radio, Last_promotion_radio, Last_equipment_sales_radio,group,bottler,city,type,customer_system,news,brand,category,distribution_stores,shelf_number,Last_distribution_stores_radio,Last_shelf_number_radio,extra_displays,Last_extra_displays_radio', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'relationship' => array(self::BELONGS_TO, 'RelationshipCvs', 'relationship_id'),
            'system' => array(self::BELONGS_TO, 'SystemCvs', 'system_id'),
            'sku' => array(self::BELONGS_TO, 'SkuCvs', 'sku_id'),
            'progress' => array(self::BELONGS_TO, 'ProgressCvs', '', 'on' => 't.time=progress.time and t.stage=progress.stage'),
            'history' => array(self::HAS_MANY, 'InfoCvs', '', 'on' => 't.system_id=history.system_id and t.relationship_id=history.relationship_id and t.sku_id=history.sku_id', 'condition' => 'history.shelves=1 and history.stage > 0 and  (history.time < t.time or (history.time=t.time and history.stage <= t.stage))','order' => 'history.time  desc,history.stage  desc'),
            'monhistory' => array(self::HAS_MANY, 'InfoCvs', '', 'on' => 't.system_id=monhistory.system_id and t.relationship_id=monhistory.relationship_id and t.sku_id=monhistory.sku_id', 'condition' => 'monhistory.shelves=1 and monhistory.stage = -1 and monhistory.time <= t.time', 'order' => 'monhistory.time desc'),
            'monthHistory' => array(self::HAS_MANY, 'InfoCvs', '', 'on' => 't.system_id=monthHistory.system_id and t.relationship_id=monthHistory.relationship_id and t.sku_id=monthHistory.sku_id', 'condition' => 'monthHistory.shelves=1 and monthHistory.stage = 0 and monthHistory.time <= t.time', 'order' => 'monthHistory.time desc'),
            'activityinfo'=>array(self::BELONGS_TO,'ActivityCvs','activity'),
            'equipmentinfo'=>array(self::BELONGS_TO,'EquipmentCvs','equipment'),
            'mechanisminfo'=>array(self::BELONGS_TO,'MechanismCvs','mechanism'),
            'progressNew' => array(self::BELONGS_TO, 'ProgressCvs', '', 'on' => 't.time=progressNew.time and t.stage=progressNew.stage','select'=>'time,stage,turn'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'time' => 'Time',
            'stage' => 'Stage',
            'relationship_id' => '区域',
            'system_id' => 'Channel',
            'sku_id' => 'Sku',
            'shelves' => 'Shelves',
            'activity' => 'Activity',
            'mechanism' => 'Mechanism',
            'equipment' => 'Equipment',
            'extraSku'=>'extraSku',
            'distribution' => '铺货率',
            'sovi' => '排面占比',
            'price_anomaly' => '零售价格店次占比',
            'thematic_activity' => '主题活动',
            'promotion' => '促销机制',
            'equipment_sales' => '设备卖进',
            'Last_distribution_radio' => '铺货率的变化率',
            'Last_sovi_radio' => '排面占比的变化率',
            'Last_price_anomaly_radio' => '零售价格店次占比的变化率',
            'Last_thematic_activity_radio' => '活动发生率的变化率',
            'Last_promotion_radio' => '促销机制的变化率',
            'Last_equipment_sales_radio' => '设备卖进的变化率',
            'bottler' => 'Factory',
            'group' => 'Group',
            'city' => 'City',
            'type' => 'Type',
            'customer_system' => 'Channel',
            'category' => 'Category',
            'brand' => 'Brand',
            'news' => 'Detailed_Sku',
            'distribution_stores' => '铺货门店数',
            'shelf_number' => '店均货架排面数',
            'Last_distribution_stores_radio' => '铺货门店数的变化率',
            'Last_shelf_number_radio' => '店均货架排面数的变化率',
            'extra_displays' => '额外二次陈列',
            'Last_extra_displays_radio' => '额外二次陈列的变化率',
            'extra_stores'=>'二次陈列门店数',
            'Last_extra_stores'=>'二次陈列门店数的变化率',
            'freezer_shop'=>'可口可乐店均门数'
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $this->checkdata();
        $this->checkCategory();
        $city = RelationshipCvs::model()->findAll();
        $news = SkuCvs::model()->findAll();
        $list = [];
//		$system_list = [];
        $sku_list = [];

        if (!empty($this->news)) {
            $sku_list[] = $this->news;
        } elseif (!empty($this->brand)) {
            $sku_list = CHtml::listData(SkuCvs::sonTree($news, $this->brand), 'Id', 'Id');
            array_push($sku_list, $this->brand);
        } elseif (!empty($this->category)) {
            $sku_list = CHtml::listData(SkuCvs::sonTree($news, $this->category), 'Id', 'Id');
            array_push($sku_list, $this->category);
        }

        if (!empty($this->city)) {
            $list[] = $this->city;
        } elseif (!empty($this->bottler)) {
            $list = CHtml::listData(RelationshipCvs::sonTree($city, $this->bottler), 'Id', 'Id');
            array_push($list, $this->bottler);
        } elseif (!empty($this->group)) {
            $list = CHtml::listData(RelationshipCvs::sonTree($city, $this->group), 'Id', 'Id');
            array_push($list, $this->group);
        }

        $criteria = new CDbCriteria;

        $criteria->compare('Id', $this->Id);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('stage', $this->stage);
//		$criteria->compare('relationship_id',$this->relationship_id);
        $criteria->compare('system_id', $this->system_id);
//		$criteria->compare('sku_id',$this->sku_id);
        $criteria->compare('shelves', $this->shelves, true);
        $criteria->compare('activity', $this->activity, true);
        $criteria->compare('mechanism', $this->mechanism, true);
        $criteria->compare('equipment', $this->equipment, true);
        $criteria->compare('distribution', $this->distribution);
        $criteria->compare('sovi', $this->sovi);
        $criteria->compare('price_anomaly', $this->price_anomaly);
        $criteria->compare('thematic_activity', $this->thematic_activity);
        $criteria->compare('promotion', $this->promotion);
        $criteria->compare('equipment_sales', $this->equipment_sales);
        $criteria->compare('Last_distribution_radio', $this->Last_distribution_radio);
        $criteria->compare('Last_sovi_radio', $this->Last_sovi_radio);
        $criteria->compare('Last_price_anomaly_radio', $this->Last_price_anomaly_radio);
        $criteria->compare('Last_thematic_activity_radio', $this->Last_thematic_activity_radio);
        $criteria->compare('Last_promotion_radio', $this->Last_promotion_radio);
        $criteria->compare('Last_equipment_sales_radio', $this->Last_equipment_sales_radio);
        $criteria->compare('distribution_stores', $this->distribution_stores);
        $criteria->compare('shelf_number', $this->shelf_number);
        $criteria->compare('Last_distribution_stores_radio', $this->Last_distribution_stores_radio);
        $criteria->compare('Last_shelf_number_radio', $this->Last_shelf_number_radio);
        $criteria->compare('extra_displays', $this->extra_displays);
        $criteria->compare('Last_extra_displays_radio', $this->Last_extra_displays_radio);
        $criteria->compare('extraSku',$this->extraSku);
        $criteria->compare('extra_stores',$this->extra_stores);
        $criteria->compare('Last_extra_stores',$this->Last_extra_stores);
        $criteria->compare('relationship_id', $list);
//		$criteria->compare('system_id',$system_list);
        $criteria->compare('sku_id', $sku_list);
        $criteria->compare('freezer_shop',$this->freezer_shop);

        if (!empty($this->system_id) && !empty($this->type)) {
            $sysmodel = SystemCvs::model()->find('Id=' . $this->system_id);
            if (isset($sysmodel) && $sysmodel->parent != $this->type) {
                $this->system_id = '';
            }
        }
        if ($this->type != 1) {
            if (!empty($this->system_id)) {
                $criteria->compare('system_id', $this->system_id);
            } elseif (!empty($this->type)) {
                $systemArr = CHtml::listData(SystemCvs::model()->findAll('parent=' . $this->type), 'Id', 'Id');
                array_push($systemArr, $this->type);
                $criteria->compare('system_id', $systemArr);
            }
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function checkdata() {
        if (!empty($this->city)) {
            $city = RelationshipCvs::model()->find('Id=' . $this->city);
            $bottler = RelationshipCvs::model()->find('Id=' . $city->parent);
            if (!empty($this->bottler) || !empty($this->group)) {
                if (!empty($this->bottler) && $city->parent != $this->bottler) {
                    $this->city = '';
                }
                if (!empty($this->group) && $bottler->parent != $this->group) {
                    $this->city = '';
                    $this->bottler = '';
                }
            } else {
                $this->city = '';
            }
        }
    }

    public function checkCategory() {
        if (!empty($this->news)) {
            $news = SkuCvs::model()->find('Id=' . $this->news);
            $brand = SkuCvs::model()->find('Id=' . $news->parent);
            if (!empty($this->brand) || !empty($this->category)) {
                if (!empty($this->brand) && $news->parent != $this->brand) {
                    $this->news = '';
                }
                if (!empty($this->category) && $brand->parent != $this->category) {
                    $this->news = '';
                    $this->brand = '';
                }
            } else {
                $this->news = '';
            }
        }
    }

    public static function dropDown($column, $value = null) {
        $dropDownList = [
            'is_shelves' => [
                '1' => '常温+冷藏+暖柜',
                '2' => '常温',
                '3' => '冷藏',
                '4' => '暖柜',
                '0' => '0',
            ],
            'is_activity' => [
                '1' => '圣诞节',
                '2' => '北极熊',
                '0' => '0',
            ],
            'is_mechanism' => [
                '1' => 'combo',
                '2' => 'redemption',
                '3' => '会员',
                '4' => '赠品',
                '5' => '特价',
                '0' => '0',
            ],
            'is_equipment' => [
                '1' => '咖啡机',
                '2' => '冰柜',
                '3' => '暖柜',
                '4' => '总设备',
                '0' => '0',
            ],
            'is_number' => [
                '-1' => 'YTD',
                '0' =>'月报',
                '1' => '第一期',
                '2' => '第二期',
                '3' => '第三期',
                '4' => '第四期',
            ],
                //有新的字段要实现下拉规则，可像上面这样进行添加
                // ......
        ];
        //根据具体值显示对应的值
        if ($value !== null)
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        //返回关联数组，用户下拉的filter实现
        else
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InfoCvs the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function onlynumber($str) {
        preg_match_all('/\d+/', $str, $arr);
        return implode('', $arr[0]);
    }

    public static function monthdata() {
        $sql = 'select time from cola_info_cvs GROUP BY time';

        $timelist = Yii::app()->db->createCommand($sql)->queryAll();
        $newlist = [];
        //pd($timelist);
        for ($i = 0; $i < count($timelist); $i++) {
            $newlist[] = self::onlynumber($timelist[$i]['time']);
        }
        return $newlist;
    }

    public static function InfoTime() {
        $sql = 'select time from cola_info_cvs  GROUP BY time order by time asc';
        $rank = Yii::app()->db->createCommand($sql)->queryAll();
        $list = [];
        for ($i = 0; $i < count($rank); $i++) {
            $list[$rank[$i]['time']] = $rank[$i]['time'];
        }
        return $list;
    }

    public function maxstage($month){
       $maxsql = 'select IFNULL(max(stage),1) as maxnum from cola_info_cvs where time="' . $month . '"';
       $res = Yii::app()->db->createCommand($maxsql)->queryRow();

        return $res['maxnum'];
    }
}
