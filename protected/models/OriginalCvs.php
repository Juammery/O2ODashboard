<?php

/**
 * This is the model class for table "{{original_cvs}}".
 *
 * The followings are the available columns in table '{{original_cvs}}':
 * @property integer $Id
 * @property integer $time
 * @property integer $stage
 * @property string $bloc
 * @property string $factory
 * @property string $system_cate
 * @property string $system_name
 * @property integer $store_id
 * @property string $classes
 * @property string $category
 * @property string $brand
 * @property string $sku
 * @property integer $full_surface
 * @property integer $normal_surface
 * @property integer $refrigeration_surface
 * @property integer $warm_surface
 * @property string $mechanism
 * @property string $activity
 * @property string $secondary_display
 * @property string $equipment
 * @property integer $error
 * @property string $freezer_shop
 */
class OriginalCvs extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{original_cvs}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('time, stage,bloc,factory, system_cate, system_name, store_id, category, brand, sku', 'required'),
            array('time, stage, store_id, full_surface, normal_surface, refrigeration_surface, warm_surface, error', 'numerical', 'integerOnly' => true),
            array('bloc, factory, system_cate, system_name, category, brand, sku', 'length', 'max' => 50),
            array('classes, mechanism, activity, secondary_display, equipment', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Id, time, stage, bloc, factory, system_cate, system_name, store_id, classes, category, brand, sku, full_surface,normal_surface,refrigeration_surface,warm_surface,mechanism,activity,secondary_display,equipment,error,freezer_shop', 'safe', 'on' => 'search'),
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
            'blocs' => array(self::BELONGS_TO, 'RelationshipCvs', array('bloc' => 'name'), 'select' => 'Id,name'),
            'factorys' => array(self::BELONGS_TO, 'RelationshipCvs', array('factory' => 'name'), 'select' => 'Id,name'),
            'system_cates' => array(self::BELONGS_TO, 'SystemCvs', array('system_cate' => 'name'), 'select' => 'Id,name'),
//            'system_subclasss' => array(self::BELONGS_TO, 'SystemCvs', array('system_subclass' => 'name'),'select'=>'Id,name'),
            'system_names' => array(self::BELONGS_TO, 'SystemCvs', array('system_name' => 'name'), 'select' => 'Id,name'),
            'categorys' => array(self::BELONGS_TO, 'SkuCvs', array('category' => 'name'), 'select' => 'Id,name'),
            'brands' => array(self::BELONGS_TO, 'SkuCvs', array('brand' => 'name'), 'select' => 'Id,name'),
            'skus' => array(self::BELONGS_TO, 'SkuCvs', array('sku' => 'name'), 'select' => 'Id,name'),
//            'equipment'=>array(self::BELONGS_TO,'EquipmentCvs',array('equipment'=>'equipment')),
//            'activity'=>array(self::BELONGS_TO,'ActivityCvs',array('activity'=>'activity')),
//            'mechanism'=>array(self::BELONGS_TO,'MechanismCvs',array('mechanism'=>'mechanism'))
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'Id' => 'ID',
            'time' => '时间',
            'stage' => '期数',
            'bloc' => '全部',
            'factory' => '装瓶厂',
            'system_cate' => '系统大类',
//            'system_subclass' => '系统类别',
            'system_name' => '系统名称',
            'store_id' => '门店',
            'classes' => '品类类别',
            'category' => '品类',
            'brand' => '品牌',
            'sku' => 'Sku',
            'full_surface' => '全部排面',
            'normal_surface' => '常温排面',
            'refrigeration_surface' => '冷藏排面',
            'warm_surface' => '暖柜排面',
            'mechanism' => '促销机制',
            'activity' => '活动主题',
            'secondary_display' => '额外二次陈列',
            'equipment' => '设备',
            'error' => '状态',
            'freezer_shop' => '可口可乐冰柜门数',
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

        $criteria->compare('Id', $this->Id);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('stage', $this->stage, true);
        $criteria->compare('bloc', $this->bloc, true);
        $criteria->compare('factory', $this->factory, true);
        $criteria->compare('system_cate', $this->system_cate);
//        $criteria->compare('system_subclass', $this->system_subclass, true);
        $criteria->compare('system_name', $this->system_name, true);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('classes', $this->classes, true);
        $criteria->compare('category', $this->category, true);
        $criteria->compare('brand', $this->brand, true);
        $criteria->compare('sku', $this->sku, true);
        $criteria->compare('full_surface', $this->full_surface);
        $criteria->compare('normal_surface', $this->normal_surface);
        $criteria->compare('refrigeration_surface', $this->refrigeration_surface);
        $criteria->compare('warm_surface', $this->warm_surface);
        $criteria->compare('mechanism', $this->mechanism, true);
        $criteria->compare('activity', $this->activity, true);
        $criteria->compare('secondary_display', $this->secondary_display, true);
        $criteria->compare('equipment', $this->equipment, true);
        $criteria->compare('error', $this->error, true);
        $criteria->compare('freezer_shop', $this->freezer_shop, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OriginalCvs the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function dropDown($column, $value = null)
    {
        $dropDownList = [
            'is_hot' => [
                '1' => '正确',
                '0' => '错误',
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

    public static function getTime($newTime, $index)
    {
        $list = InfoCvs::model()->findAll(array("condition" => 'time = "' . $newTime . '" and stage = -1', "index" => $index, 'select' => 'DISTINCT(' . $index . ')'));
        $list_id = array_keys($list);
        return $list_id;
    }

    public static function getList($newTime, $a, $type)
    {
        $relation = InfoCvs::model()->findAll(array("condition" => 't.time <= "' . $newTime . '" and t.time >= "' . $a . '" and stage != -1 and stage != 0', "index" => "$type", 'select' => 'DISTINCT(' . $type . ')'));
        $relation_id = array_keys($relation);
        return $relation_id;
    }

    public static function removeZero($array)
    {
        $arr = array();
        foreach ($array as $i => $d) {
            if ($d != 0) {
                $arr[] = $d;
            }
        }
        return $arr;
    }
//    public static function list_sort($table = '', $field = '')
//    {
//        $sql = 'select * from ' . $table . ' Group BY ' . $field . ' ORDER BY ' . $field . ' asc';
//        if ($sql) {
//            $rank = Yii::app()->db->createCommand($sql)->queryAll();
//            $list = [];
//            for ($i = 0; $i < count($rank); $i++) {
//                $list[$rank[$i][$field]] = $rank[$i][$field];
//            }
//            return array_values($list);
//        }else{
//            return '';
//        }
//    }
    /**
     * 计算YTD
     * @param $relation_id
     * @param $newTime
     * @param $stage
     * @param $turn
     * @param $a
     * @param $type
     * @param $index
     */
    //参数，（区域ID数组,YTD的时间,期数,轮次,年份,首月,指标相关的东西,指标）
    public static function ytdDistribution($relation_id, $newTime, $stage, $turn, $a, $type = '', $index = '')
    {
        $tt = microtime(true);
        $info = $list = $listUpdate = [];
        foreach ($relation_id as $relationValue) {    //区域
            //查询1月到当前月，区域等于$relationValue的所有数据
            $system = InfoCvs::model()->findAll(array("condition" => 'time <= "' . $newTime . '" and time >= "' . $a . '" and stage != -1 and stage != 0 and relationship_id = ' . $relationValue, 'select' => 'Id,relationship_id,system_id,sku_id,' . $type . ',' . $index,));
            foreach ($system as $skuValue) {  //渠道
                if ($skuValue[$type] != 0) {
                    if (isset($info[$skuValue['relationship_id']][$skuValue['system_id']][$skuValue['sku_id']][$skuValue[$type]])) {
                        $info[$skuValue['relationship_id']][$skuValue['system_id']][$skuValue['sku_id']][$skuValue[$type]] += $skuValue[$index] / $turn;
                    } else {
                        $info[$skuValue['relationship_id']][$skuValue['system_id']][$skuValue['sku_id']][$skuValue[$type]] = $skuValue[$index] / $turn;
                    }
                }
            }
            unset($system);
        }
        unset($relation_id);
        $t1 = microtime(true);
        foreach (array_keys($info) as $relationId) {
            foreach (array_keys($info[$relationId]) as $systemId) {
                foreach (array_keys($info[$relationId][$systemId]) as $skuId) {
                    foreach (array_keys($info[$relationId][$systemId][$skuId]) as $listId) {
                        $value = $info[$relationId][$systemId][$skuId][$listId];
                        $infoCount = InfoCvs::model()->find('time = :time and stage = :stage and relationship_id = :relation and system_id = :system and sku_id = :sku and ' . $type . ' = :' . $type,
                            array(':time' => $newTime, ':stage' => $stage, ':relation' => $relationId, ':system' => $systemId, ':sku' => $skuId, ":$type" => $listId));
                        if ($infoCount) {
//                            InfoCvs::model()->updateAll(
//                                array($index=>$info[$relationId][$systemId][$skuId][$listId]),
//                                'time = :time and stage = :stage and relationship_id = :relation and system_id = :system and sku_id = :sku and '.$type.' = :'.$type,
//                                array(':time'=>$newTime,':stage'=>$stage,':relation'=>$relationId,':system'=>$systemId,':sku'=>$skuId,":$type"=>$listId)
//                            );
                            $listUpdate[$infoCount['Id']] = array($index => $value);
                        } else {
                            $list[] = array($newTime, $stage, $relationId, $systemId, $skuId, $listId, $value);
                        }
                        unset($infoCount);
                    }
                }
            }
        }
        unset($info);
//        pd(count($listUpdate),$listUpdate);
        $t2 = microtime(true);
        $arr = array_chunk($list, 1000);
//        $arr1 = array_chunk($listUpdate, 100);  //修改
        $label1 = array($index);
        $label = array('time', 'stage', 'relationship_id', 'system_id', 'sku_id', $type, $index);
        $count = count($listUpdate);
        $pageSize = 1000;
        $times = ceil($count / 1000);
        $t5 = microtime(true);
        for ($i = 0; $i < $times; $i++) {
            $listCvs = array_slice($listUpdate, $i * $pageSize, $pageSize, true);
            $arrayId = array_keys($listCvs);
//            pd($arrayId,$listCvs);
            $return = self::batchUpdate('cola_info_cvs', $label1, $listCvs, $arrayId);
        }
        unset($listUpdate, $listCvs, $arrayId, $return);
        $t6 = microtime(true);
        $t4 = $t3 = '';
        for ($i = 0; $i < count($arr); $i++) {
            self::ytdInsert('cola_info_cvs', $label, $arr[$i]);
        }
        $t7 = microtime(true);
        Yii::log($index . "YTD指标计算总时间：" . round($t7 - $tt, 3), 'warning');
        //echo '<pre>';var_dump("总时间".round($t7-$tt,3),"大循环：".round($t2-$t1,3),"第一次修改时间：".round($t6-$t5,3),"二次修改的数组：".round($t4-$t3,3),"dadada:".round($t7-$t6,3));
//        exit();
    }

    public static function batchUpdate($form = '', $field = array(), $value = array(), $arrayId = array())
    {
//        pd($field,$value);
        if (empty($form) || empty($field) || empty($value) || empty($arrayId)) {
            return false;
        }
        $sql = "UPDATE cola_info_cvs SET ";
        //合成sql语句
        foreach ($field as $key) {
            $sql .= "{$key} = CASE id ";
            foreach ($value as $newhouse_clicks_key => $newhouse_clicks_value) {
                $sql .= sprintf("WHEN %d THEN %.15f ", $newhouse_clicks_key, $newhouse_clicks_value[$key]);
            }
            $sql .= "END, ";
        }
        unset($value);
        //把最后一个,去掉
        $sql = substr($sql, 0, strrpos($sql, ','));
        //合并所有id
        $ids = implode(',', $arrayId);
        //拼接sql
        $sql .= " WHERE Id IN ({$ids})";
        Yii::app()->db->createCommand($sql)->execute();
        unset($sql, $ids);
    }

    public static function ytdInsert($form = '', $field = array(), $value = array())
    {
        $listInfo = $list = [];
        if (empty($form) || empty($field) || empty($value)) {
            return false;
        }
        $t3 = microtime(true);
        foreach ($value as $k => $v) {
            $tab = ['shelves' => 1, 'activity' => 16, 'mechanism' => 6, 'equipment' => 4, 'extraSku' => 1];
            unset($collect, $info);
            $collect = InfoCvs::model()->find('time = :time and stage = :stage and relationship_id = :relation and system_id = :system and sku_id = :sku and (shelves = 1 or activity = 16 or mechanism = 6 or equipment = 4 or extraSku = 1)', array(
                ':time' => $v[0], ':stage' => $v[1], ':relation' => $v[2], ':system' => $v[3], ':sku' => $v[4]
            ));
            $strcomp = self::strcomp($v[5], $tab[$field[5]]);
            if ($collect && $strcomp) {
                unset($value[$k]);
                $listInfo[$collect['Id']] = array($field[5] => $v[5], $field[6] => $v[6]);
                unset($collect);
            } else {
                $a = InfoCvs::model()->find('time ="' . $v[0] . '" and stage =' . $v[1] . ' and relationship_id =' . $v[2] .
                    ' and system_id = ' . $v[3] . ' and sku_id = ' . $v[4] . ' and ' . $field[5] . '= 0 and (shelves != 1 and activity != 16 and mechanism != 6 and equipment != 4 and extraSku != 1)');
                if ($a) {
                    unset($value[$k]);
                    $list[$a['Id']] = array($field[5] => $v[5], $field[6] => $v[6]);
                    unset($a);
                }
            }
        }
        $t4 = microtime(true);
        $label = [$field[5], $field[6]];
        $count = count($listInfo);
        $count1 = count($list);
        $pageSize = 1000;
        $times = ceil($count / 1000);
        $times1 = ceil($count1 / 1000);
        for ($i = 0; $i < $times; $i++) {
            $listCvs = array_slice($listInfo, $i * $pageSize, $pageSize, true);
            $arrayId = array_keys($listCvs);
            $log[] = self::batchUpdate('cola_info_cvs', $label, $listCvs, $arrayId);
        }
        for ($i = 0; $i < $times1; $i++) {
            $listCvs1 = array_slice($list, $i * $pageSize, $pageSize, true);
            $arrayId1 = array_keys($listCvs1);
            $log[] = self::batchUpdate('cola_info_cvs', $label, $listCvs1, $arrayId1);
        }
        $field = ' ( `' . implode('`,`', $field) . '`) ';
        if (!empty($value)) {
            $sql = 'INSERT INTO ' . $form . $field . ' VALUES ';
            $valueString = '';
            foreach ($value as $k => $v) {
                $valueString .= ' ( "' . implode('","', $v) . '") ,';
            }

            $newsql = $sql . substr($valueString, 0, -1);
            return Yii::app()->db->createCommand($newsql)->execute();
        }
    }

    /**
     * 计算YTD的变化率
     * @param $oldTime
     * @param $newTime
     * @param $type
     * @param $index
     * @param $gradient
     */
    public static function variation($newTime,$oldTime, $type, $index, $gradient)
    {
//        $test = InfoCvs::model()->find(array("condition" => 'time != "' . $newTime . '" and stage = -1 ', 'select' => 'time', 'order' => 'time desc'));
//        $oldTime = '';
//        if ($test) {
//            $oldTime = isset($test['time']) ? $test['time'] : '0';
//        }
//        unset($test);
        $newData = InfoCvs::model()->findAll(array("condition" => 'time = "' . $newTime . '" and stage = -1 ', 'select' => 'relationship_id,system_id,sku_id,' . $type . ',' . $index,));
        $oldData = InfoCvs::model()->findAll(array("condition" => 'time = "' . $oldTime . '" and stage = -1 ', 'select' => 'relationship_id,system_id,sku_id,' . $type . ',' . $index,));

        $newInfo = self::getArray($newData, $type, $index);   //本次YTD的数据
        $oldInfo = self::getArray($oldData, $type, $index);   //上次YTD的数据
        unset($newData, $oldData);
        $data = $listUpdate = [];
        foreach (array_keys($newInfo) as $relation) {
            foreach (array_keys($newInfo[$relation]) as $system) {
                foreach (array_keys($newInfo[$relation][$system]) as $sku) {
                    foreach (array_keys($newInfo[$relation][$system][$sku]) as $list) {
                        if (isset($oldInfo[$relation][$system][$sku][$list])) {
                            $data[$relation][$system][$sku][$list] = round($newInfo[$relation][$system][$sku][$list] - $oldInfo[$relation][$system][$sku][$list], 15);  //本次-上次
                        } else {
                            $data[$relation][$system][$sku][$list] = round($newInfo[$relation][$system][$sku][$list] - 0, 15);  //本次-上次
                        }
                        $value = $data[$relation][$system][$sku][$list];
                        $model = InfoCvs::model()->find('time = "' . $newTime . '" and stage = -1 and relationship_id = '
                            . $relation . ' and system_id = ' . $system . ' and sku_id = ' . $sku . ' and ' . $type . ' = ' . $list);
                        if ($model) {
                            $listUpdate[$model['Id']] = array($gradient => $value);
                        }
                        unset($model, $data);
//                        InfoCvs::model()->updateAll(array($gradient=>$value),'time = "' .$newTime.'" and stage = -1 and relationship_id = '
//                            .$relation.' and system_id = '.$system.' and sku_id = '.$sku.' and '.$type.' = '.$list);
                    }
                }
            }
        }
        unset($newInfo, $oldInfo);
//        pd($listUpdate);
        $label1 = array($gradient);
        $count = count($listUpdate);
        $pageSize = 1000;
        $times = ceil($count / 1000);
        for ($i = 0; $i < $times; $i++) {
            $listCvs = array_slice($listUpdate, $i * $pageSize, $pageSize, true);
            $arrayId = array_keys($listCvs);
            self::batchUpdate('cola_info_cvs', $label1, $listCvs, $arrayId);
        }
        unset($listUpdate, $listCvs, $arrayId);
    }

    public static function getArray($newData, $type, $index)
    {
        $info = [];
        if ($newData) {
            foreach ($newData as $value) {
                if ($value->$type != 0) {
                    $info[$value->relationship_id][$value->system_id][$value->sku_id][$value->$type] = $value->$index;
                }
            }
        }
        return $info;
    }

    /**
     * 计算铺货率
     * @param $data
     * @param $time
     * @param $stage
     * @return string
     *
     * 品类、品牌、sku的计算方法
     * 铺货率的（classes）不涉及（KOMHSKU）
     * 总total:分子，全部排面（full_surface）大于0的重复的门店数（store_id），分母,（store_id）重复的门店数.
     * 常温：分子，常温排面（normal_surface）大于0的重复的门店数（store_id），分母,（store_id）不重复的门店数.
     * 冷藏：分子，冷藏排面（refrigeration_surface）大于0的重复的门店数（store_id），分母,（store_id）不重复的门店数.
     * 暖柜：分子，暖柜排面（warm_surface）大于0的重复的门店数（store_id），分母,（store_id）不重复的门店数.
     *
     * 可乐必备品的计算方法
     *（classes）只涉及（KOMHSKU）
     * 总total:分子，全部排面（full_surface）大于0的重复的门店数（store_id），分母,（store_id）重复的门店数.
     * 常温：分子，常温排面（normal_surface）大于0的重复的门店数（store_id），分母,（store_id）重复的门店数.
     * 冷藏：分子，冷藏排面（refrigeration_surface）大于0的重复的门店数（store_id），分母,（store_id）重复的门店数.
     * 暖柜：分子，暖柜排面（warm_surface）大于0的重复的门店数（store_id），分母,（store_id）重复的门店数.
     */
    public static function distribution($data, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::medicData($data, 'other');      //去除（KOMHSKU），返回数组
        $must_info = self::medicData($data, 'KOMHSKU');    //可乐必备品，返回品类类别为（KOMHSKU）数组
        unset($data);
        //总Total（常温+冷藏+暖柜）
        $molecule = self::transit($info, 'medic');   //做区域，渠道，产品的处理，返回数组  分子
        $denominator = self::adc($info, 'medic');   //常温+冷藏+暖柜(总total)的分母
        //常温、冷藏、暖柜
        $molecule1 = self::transit($info, 'medic1');   //做区域，渠道，产品的处理，返回数组  分子
        $denominator1 = self::adc($info, 'medic1');   //常温,冷藏,暖柜的分母
        unset($info);
        //可乐必备品，常温+冷藏+暖柜(总Total)
        $mustMolecule = self::transitData($must_info, 'koMust');   //可乐必备品：做区域，渠道，产品的处理，返回数组  分子
        $mustdenominator = self::transitData($must_info, 'ko_Must');   //可乐必备品：做区域，渠道，产品的处理，返回数组  分母

//        //可乐必备品，常温、冷藏、暖柜
//        $mustMolecule1 = self::transitData($must_info,'koMust1');   //可乐必备品：做区域，渠道，产品的处理，返回数组  分子
//        $mustdenominator1 = self::transitData($must_info,'ko_Must1');   //可乐必备品：做区域，渠道，产品的处理，返回数组  分母
        unset($must_info);
        //品类、品牌、sku的计算结果
        $groupData1 = self::broadHeading($molecule, $denominator, '', '');    //计算总Total的数据结果
        unset($molecule, $denominator);
        $groupData2 = self::broadHeading($molecule1, $denominator1, $groupData1, 'other');    //计算常温、冷藏、的数据结果
        unset($molecule1, $denominator1, $groupData1);
        //可乐必备品的计算结果
        $groupData3 = self::broadHeading($mustMolecule, $mustdenominator, '', $groupData2);    //计算总Total的数据结果
        unset($mustMolecule, $mustdenominator);
//        $groupData4 = self::broadHeading($mustMolecule1, $mustdenominator1,$groupData3,'other');    //计算常温、冷藏、暖柜的数据结果
        $groupData = self::conformity($groupData2, $groupData3);
        self::indexInsert($groupData, $time, $stage, 'distribution', 'shelves');
        unset($groupData);
        $t2 = microtime(true);
        Yii::log("铺货率的总时间：" . round($t2 - $t1, 3), 'warning');
    }

    public static function conformity($data, $oldData = [])
    {
        $groupData = $oldData;
        foreach (array_keys($data) as $group) {
            foreach (array_keys($data[$group]) as $items) {
                foreach (array_keys($data[$group][$items]) as $list) {
                    foreach (array_keys($data[$group][$items][$list]) as $shelf) {
                        $groupData[$group][$items][$list][$shelf] = $data[$group][$items][$list][$shelf];
                    }
                }
            }
        }
        return $groupData;
    }

    public static function medicData($data, $type = '')
    {
        $info = $info1 = [];
        foreach ($data as $value) {
            if ($value->classes != 'KOMHSKU') {
                $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->full_surface,
                    $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
            }
            if ($value->classes == 'KOMHSKU') {
                $info1[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->full_surface, $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
            }
        }
        if ($type == 'KOMHSKU') {
            return $info1;
        } else {
            return $info;
        }
    }

    public static function transitData($params, $type = '')
    {
        $infos = [];
        for ($i = 1; $i <= 4; $i++) {
            $infos = self::countData($params, $infos, $i, $type);
        }
        return $infos;
    }

    private function countData($params, $infos, $sum, $type)
    {
        foreach ($params as $value) {
            if ($type == 'koMust') {
                if ($value[($sum + 3)] > 0) {
//                    if ($sum == 1) {
                    //全国
                    $infos[1][1][80][$sum][] = $value;   //总系统可乐必备品不去重(铺货率)
                    $infos[1][$value[2]][80][$sum][] = $value;   //系统大类可乐必备品不去重(铺货率)
                    $infos[1][$value[3]][80][$sum][] = $value;   //系统名称下可乐必备品不去重(铺货率)

                    //全部
                    $infos[$value[0]][1][80][$sum][] = $value;   //总系统可乐必备品不去重(铺货率)
                    $infos[$value[0]][$value[2]][80][$sum][] = $value;   //系统大类下可乐必备品不去重(铺货率)
                    $infos[$value[0]][$value[3]][80][$sum][] = $value;   //系统名称下可乐必备品不去重(铺货率)

                    //装瓶厂
                    $infos[$value[1]][1][80][$sum][] = $value;   //总系统可乐必备品不去重(铺货率)
                    $infos[$value[1]][$value[2]][80][$sum][] = $value;   //系统大类下可乐必备品不去重(铺货率)
                    $infos[$value[1]][$value[3]][80][$sum][] = $value;   //系统名称下可乐必备品不去重(铺货率)
//                    }
                }
            } elseif ($type == 'koMust1') {
                if ($value[($sum + 3)] > 0) {
                    if ($sum != 1) {
                        //全国
                        $infos[1][1][80][$sum][$value[9]] = $value;   //总系统可乐必备品去重(铺货率)
                        $infos[1][$value[2]][80][$sum][$value[9]] = $value;   //系统大类可乐必备品去重(铺货率)
                        $infos[1][$value[4]][80][$sum][$value[9]] = $value;   //系统名称下可乐必备品去重(铺货率)
                        //全部
                        $infos[$value[0]][1][80][$sum][$value[9]] = $value;   //总系统可乐必备品去重(铺货率)
                        $infos[$value[0]][$value[2]][80][$sum][$value[9]] = $value;   //系统大类下可乐必备品去重(铺货率)
                        $infos[$value[0]][$value[4]][80][$sum][$value[9]] = $value;   //系统名称下可乐必备品去重(铺货率)
                        //装瓶厂
                        $infos[$value[1]][1][80][$sum][$value[9]] = $value;   //总系统可乐必备品去重(铺货率)
                        $infos[$value[1]][$value[2]][80][$sum][$value[9]] = $value;   //系统大类下可乐必备品去重(铺货率)
                        $infos[$value[1]][$value[4]][80][$sum][$value[9]] = $value;   //系统名称下可乐必备品去重(铺货率)
                    }
                }
            } elseif ($type == 'ko_Must') {
//                if ($sum == 1) {
                //全国
                $infos[1][1][80][$sum][] = $value;   //总系统分母不去重
                $infos[1][$value[2]][80][$sum][] = $value;   //系统大类分母不去重
                $infos[1][$value[3]][80][$sum][] = $value;   //系统名称分母不去重
                //全部
                $infos[$value[0]][1][80][$sum][] = $value;   //总系统分母不去重
                $infos[$value[0]][$value[2]][80][$sum][] = $value;   //系统大类分母不去重
                $infos[$value[0]][$value[3]][80][$sum][] = $value;   //系统名称分母不去重
                //装瓶厂
                $infos[$value[1]][1][80][$sum][] = $value;   //总系统分母不去重
                $infos[$value[1]][$value[2]][80][$sum][] = $value;   //系统大类分母不去重
                $infos[$value[1]][$value[3]][80][$sum][] = $value;   //系统名称分母不去重
//                }
            } elseif ($type == 'ko_Must1') {
                if ($value[($sum + 4)] > 0) {
                    //全国
                    $infos[1][1][$sum][$value[9]] = $value;   //总系统分母去重
                    $infos[1][$value[2]][$sum][$value[9]] = $value;   //系统大类分母去重
                    $infos[1][$value[3]][$sum][$value[9]] = $value;   //系统类别分母去重
                    $infos[1][$value[4]][$sum][$value[9]] = $value;   //系统名称分母去重
                    //全部
                    $infos[$value[0]][1][$sum][$value[9]] = $value;   //总系统分母去重
                    $infos[$value[0]][$value[2]][$sum][$value[9]] = $value;   //系统大类分母去重
                    $infos[$value[0]][$value[3]][$sum][$value[9]] = $value;   //系统类别分母去重
                    $infos[$value[0]][$value[4]][$sum][$value[9]] = $value;   //系统名称分母去重
                    //装瓶厂
                    $infos[$value[1]][1][$sum][$value[9]] = $value;   //总系统分母去重
                    $infos[$value[1]][$value[2]][$sum][$value[9]] = $value;   //系统大类分母去重
                    $infos[$value[1]][$value[3]][$sum][$value[9]] = $value;   //系统类别分母去重
                    $infos[$value[1]][$value[4]][$sum][$value[9]] = $value;   //系统名称分母去重
                }
            }
        }
        return $infos;
    }

    /**
     * 计算铺货门店数
     * @param $data
     * @param $time
     * @param $stage
     * @return string
     *
     * 品类类别（classes）不涉及（其他）和（可乐其他）和（KOMHSKU）
     * 总total:全部排面（full_surface）大于0的不重复门店数（store_id）
     * 常温：常温排面（normal_surface）大于0的不重复的门店数（store_id）
     * 冷藏：冷藏排面（refrigeration_surface）大于0的不重复的门店数（store_id）
     * 暖柜：暖柜排面（warm_surface）大于0的不重复的门店数（store_id）
     *
     * 计算可乐必备品时（classes）只涉及（可乐必备品）
     */
    public static function distributionStores($data, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::list_data($data, 'other');      //去除（其他）和（可乐其他），返回数组
        $mustInfo = self::list_data($data, 'koMust');    //可乐必备品，返回数组
        unset($data); //释放内存
        $infos1 = self::transit($info, 'other');     //其他品类，品牌，sku
        unset($info);  //释放内存
        $infos2 = self::transit($mustInfo, 'koStore');     //可乐必备品

        unset($mustInfo);   //释放内存
        $groupData1 = self::stores($infos1);
        unset($infos1);
        $groupData2 = self::stores($infos2, $groupData1);
        unset($infos2, $groupData1);
//        pd($groupData2);
        self::indexInsert($groupData2, $time, $stage, 'distribution_stores', 'shelves');
        unset($groupData2);
        $t2 = microtime(true);
        Yii::log("铺货门店数的总时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算店均货架排面数
     * @param $data
     * @param $time
     * @param $stage
     * @return string
     * [0] => 中可    全部
     * [1] => 山西    装瓶厂
     * [2] => CCMG    系统大类
     * [3] => CCMG本土  系统类别
     * [4] => 金虎    客户系统
     * [5] => 汽水   品类
     * [6] => 可口可乐   品牌
     * [7] => 330可口可乐零度摩登罐   sku
     * [8] => 3    全部排面
     * [9] => 1    常温排面
     * [10] => 0   冷藏排面
     * [11] => 5   暖柜排面
     * [12] => 2147483647   门店Id
     *
     * 店均货架排面数的品类类别（classes）不涉及（其他）和（可乐其他）和（KOMHSKU）
     * 总total:分子：全部排面（full_surface）中的数字相加，分母:全部排面（full_surface）> 0 的不重复的门店数.
     * 常温：分子：常温排面（normal_surface）中的数字相加，分母:常温排面（normal_surface）> 0 的不重复的门店数.
     * 冷藏：分子：冷藏排面（refrigeration_surface）中的数字相加，分母:冷藏排面（refrigeration_surface）> 0 的不重复的门店数.
     * 暖柜：分子：暖柜排面（warm_surface）中的数字相加，分母:暖柜排面（warm_surface）> 0 的不重复的门店数.
     *
     *计算可乐必备品时（classes）只涉及（可乐必备品）
     */
    public static function shelfNumber($data, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::list_data($data, 'other');      //去除（其他）和（可乐其他）和（KOMHSKU），返回数组
        $must_info = self::list_data($data);      //可乐必备品，返回数组
        unset($data);
        $denominator = self::adc($info, 'other');   //做区域，渠道，的处理，返回数组 分母
        $must_denominator = self::adc($must_info, 'ko_other');   //可乐必备品做区域，渠道，的处理，返回数组 分母
        //分子
        $groupData = $aa = $aaa = [];
        $aaa = self::shelf($info);
        unset($info);
        $aa = self::shelfMethod($aaa);      //分子
        unset($aaa);
//        pd($aa);
        //可乐必备品分子
        $bbb = self::shelf($must_info, 'shelfMust');
        unset($must_info);
        $bb = self::shelfMethod($bbb);     //分子
        unset($bbb);
//        pd($denominator,$aa);
        $groupData1 = self::shelfNumberCount($aa, $denominator);   //其他品类，品牌，sku
        unset($aa, $denominator);
        $groupData2 = self::shelfNumberCount($bb, $must_denominator, $groupData1);  //可乐必备品
//        pd($groupData2);
//        pd($denominator,$info);
//        return $groupData;
        //pd($groupData2);
//        pd($groupData2);
        unset($bb, $must_denominator, $groupData1);
//        pd($groupData2);
        self::indexInsert($groupData2, $time, $stage, 'shelf_number', 'shelves');
        unset($groupData2);
        $t2 = microtime(true);
        Yii::log("店均货架排面数的总时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算活动发生率
     * @param $data
     * @param $time
     * @param $stage
     * @return string
     * 品类类别（classes）不涉及（其他）和（可乐其他）和（KOMHSKU）
     * [0] => 太古
     * [1] => 粤东
     * [2] => Non-CCMG
     * [3] => CCMG本土
     * [4] => 金虎
     * [5] => 汽水
     * [6] => 可口可乐
     * [7] => 330可口可乐罐
     * [8] =>                  活动
     * [9] => 140105013199
     * 分子：活动（activity）中包含例如< 1 >的 > 0 的 （store_id）的门店数）
     * 分母:（store_id不重复的门店数）
     */
    public static function thematicActivity($data, $time, $stage)
    {
        $t1 = microtime(true);
        $info = $info_must = $infos = $activityData = $denominator = [];
        foreach ($data as $value) {
            if ($value->classes != '其他' && $value->classes != '可乐其他' && $value->classes != 'KOMHSKU') {
                $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id,
                    $value->skus->Id, $value->activity, $value->store_id, $value->mechanism);
            }
            if ($value->classes == '可乐必备品') {
                $info_must[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->activity,
                    $value->store_id, $value->mechanism);

            }
        }
        unset($data);
        //品类，品牌，sku
        $infos = self::thematicCountSales($info, 'infos');    //分子
        $denominator = self::thematicCountSales($info, 'denominator');   //分母
        $mechanism = self::thematicCountSales($info, 'mechanism');   //用于计算总活动的辅助关系机制
        unset($info);
        //可乐必备品
        $must_infos = self::thematicCountSales($info_must, 'must_infos');    //分子
        $must_denominator = self::thematicCountSales($info_must, 'must_denominator');   //分母
        $must_mechanism = self::thematicCountSales($info_must, 'must_mechanism');   //用于计算总活动的辅助关系机制

        unset($info_must);
        $gainData1 = self::countTwoActivity($infos, $denominator, $mechanism);
        unset($infos, $denominator, $mechanism);
        $gainData2 = self::countTwoActivity($must_infos, $must_denominator, $must_mechanism, $gainData1);  //可乐必备品
        unset($must_infos, $must_denominator, $must_mechanism, $gainData1);

        self::indexInsert($gainData2, $time, $stage, 'thematic_activity', 'activity');
        unset($groupData2);
        $t2 = microtime(true);
        Yii::log("活动发生率的总时间：" . round($t2 - $t1, 3), 'warning');
    }

    //活动发生率算法
    public static function countTwoActivity($infos, $denominator, $mechanism = [], $olddata = [])
    {
        $gainData = $olddata;
        foreach (array_keys($infos) as $group) {    //区域
            foreach (array_keys($infos[$group]) as $system) {   //渠道
                if ($system != null) {
                    foreach (array_keys($infos[$group][$system]) as $product) {   //产品
                        $e = [];
                        foreach (array_keys($infos[$group][$system][$product]) as $activity) {
                            $a = array_merge(array_filter(array_unique(explode(',', $activity))));
                            foreach ($a as $v) {
//                            $activityData[$group][$system][$product][$v] = isset($activityData[$group][$system][$product][$v]) ? $activityData[$group][$system][$product][$v] : 0;
//                            $activityData[$group][$system][$product][$v] += count($infos[$group][$system][$product][$activity]);
//                            pd($denominator[$group][$system]);
                                if (empty($denominator[$group][$system][$product])) {
                                    $gainData[$group][$system][$product][$v] = 0;
                                } else {
                                    if ($v == '16') {
                                        if (isset($mechanism[$group][$system][$product])) {
                                            $c = [];
//                                            pd($mechanism[$group][$system][$product]);
                                            foreach ($mechanism[$group][$system][$product] as $key => $value) {
                                                $d = array_merge(array_filter(array_unique(explode(',', $key))));
                                                if (array_search($v, $d)) {
                                                    $c = array_merge($value, $c);
                                                }
                                            }
                                            $e = array_merge($infos[$group][$system][$product][$activity], $e);
                                            //pd($group,$system,$product,count($c),count($infos[$group][$system][$product][$activity]));
//                                            $b = explode(',',array_keys(current($mechanism[$group][$system]))[0]);
//                                            pd($b);
//                                            $c = array_search($v,$b) ? current($mechanism[$group][$system][$product]): array();
//                                            $aaa[] = $c;
                                            $gainData[$group][$system][$product][$v] = ((count($e) / count($denominator[$group][$system][$product]))
                                                    + (count($c) / count($denominator[$group][$system][$product]))) / 2;
                                        } else {
                                            $gainData[$group][$system][$product][$v] = (count($infos[$group][$system][$product][$activity]) / count($denominator[$group][$system][$product])) / 2;
                                        }
                                    } else {
                                        if (isset($gainData[$group][$system][$product][$v])) {
                                            $gainData[$group][$system][$product][$v] += count($infos[$group][$system][$product][$activity]) / count($denominator[$group][$system][$product]);  //某个活动去除重复门店之后的门店数量
                                            //pd($gainData[$group][$system][$product][$v]);
                                        } else {
                                            $gainData[$group][$system][$product][$v] = count($infos[$group][$system][$product][$activity]) / count($denominator[$group][$system][$product]);  //某个活动去除重复门店之后的门店数量
                                        }

                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
//        pd($gainData);
        return $gainData;
    }

    //活动发生率（转换成我需要的格式）
    public static function thematicCountSales($data, $type)
    {
        $infos = $denominator = $must_infos = $must_denominator = $mechanism = $must_mechanism = $must_mechanism = [];
        foreach ($data as $value) {

            if (isset($value[9]) && $value[9] > 0) {   //辅助计算总活动的机制列（包含活动并且机制列要有文本）
                //全国
                $mechanism[1][1][$value[4]][$value[7]][$value[8]] = $value;      //总系统下品类下某个活动(或某个设备)的门店
                $mechanism[1][1][$value[5]][$value[7]][$value[8]] = $value;      //总系统下品牌下某个活动(或某个设备)的门店
                $mechanism[1][1][$value[6]][$value[7]][$value[8]] = $value;      //总系统下Sku下某个活动(或某个设备)的门店

                $mechanism[1][$value[2]][$value[4]][$value[7]][$value[8]] = $value;      //系统大类下品类下某个活动(或某个设备)的门店
                $mechanism[1][$value[2]][$value[5]][$value[7]][$value[8]] = $value;      //系统大类下品牌下某个活动(或某个设备)的门店
                $mechanism[1][$value[2]][$value[6]][$value[7]][$value[8]] = $value;      //系统大类下Sku下某个活动(或某个设备)的门店

                $mechanism[1][$value[3]][$value[4]][$value[7]][$value[8]] = $value;      //系统名称下品类下某个活动的门店
                $mechanism[1][$value[3]][$value[5]][$value[7]][$value[8]] = $value;      //系统名称下品牌下某个活动的门店
                $mechanism[1][$value[3]][$value[6]][$value[7]][$value[8]] = $value;      //系统名称下Sku下某个活动的门店

                //全部
                $mechanism[$value[0]][1][$value[4]][$value[7]][$value[8]] = $value;      //总系统下品类下某个活动的门店
                $mechanism[$value[0]][1][$value[5]][$value[7]][$value[8]] = $value;      //总系统下品牌下某个活动的门店
                $mechanism[$value[0]][1][$value[6]][$value[7]][$value[8]] = $value;      //总系统下Sku下某个活动的门店

                $mechanism[$value[0]][$value[2]][$value[4]][$value[7]][$value[8]] = $value;      //系统大类下品类下某个活动的门店
                $mechanism[$value[0]][$value[2]][$value[5]][$value[7]][$value[8]] = $value;      //系统大类下品牌下某个活动的门店
                $mechanism[$value[0]][$value[2]][$value[6]][$value[7]][$value[8]] = $value;      //系统大类下Sku下某个活动的门店

                $mechanism[$value[0]][$value[3]][$value[4]][$value[7]][$value[8]] = $value;      //系统名称下品类下某个活动的门店
                $mechanism[$value[0]][$value[3]][$value[5]][$value[7]][$value[8]] = $value;      //系统名称下品牌下某个活动的门店
                $mechanism[$value[0]][$value[3]][$value[6]][$value[7]][$value[8]] = $value;      //系统名称下Sku下某个活动的门店
                //装瓶厂
                $mechanism[$value[1]][1][$value[4]][$value[7]][$value[8]] = $value;      //总系统下品类下某个活动的门店
                $mechanism[$value[1]][1][$value[5]][$value[7]][$value[8]] = $value;      //总系统下品牌下某个活动的门店
                $mechanism[$value[1]][1][$value[6]][$value[7]][$value[8]] = $value;      //总系统下Sku下某个活动的门店

                $mechanism[$value[1]][$value[2]][$value[4]][$value[7]][$value[8]] = $value;      //系统大类下品类下某个活动的门店
                $mechanism[$value[1]][$value[2]][$value[5]][$value[7]][$value[8]] = $value;      //系统大类下品牌下某个活动的门店
                $mechanism[$value[1]][$value[2]][$value[6]][$value[7]][$value[8]] = $value;      //系统大类下Sku下某个活动的门店

                $mechanism[$value[1]][$value[3]][$value[4]][$value[7]][$value[8]] = $value;      //系统名称下品类下某个活动的门店
                $mechanism[$value[1]][$value[3]][$value[5]][$value[7]][$value[8]] = $value;      //系统名称下品牌下某个活动的门店
                $mechanism[$value[1]][$value[3]][$value[6]][$value[7]][$value[8]] = $value;      //系统名称下Sku下某个活动的门店

                //可乐必备品辅助计算总活动的机制列（包含活动并且机制列要有文本）
                //全国
                $must_mechanism[1][1][80][$value[7]][$value[8]] = $value;      //总系统下可乐必备品下某个活动(或某个设备)的门店
                $must_mechanism[1][$value[2]][80][$value[7]][$value[8]] = $value;      //系统大类下可乐必备品下某个活动(或某个设备)的门店
                $must_mechanism[1][$value[3]][80][$value[7]][$value[8]] = $value;      //系统名称下可乐必备品下某个活动的门店

                //全部
                $must_mechanism[$value[0]][1][80][$value[7]][$value[8]] = $value;      //总系统下可乐必备品下某个活动的门店
                $must_mechanism[$value[0]][$value[2]][80][$value[7]][$value[8]] = $value;      //系统大类下可乐必备品下某个活动的门店
                $must_mechanism[$value[0]][$value[3]][80][$value[7]][$value[8]] = $value;      //系统名称下可乐必备品下某个活动的门店
                //装瓶厂
                $must_mechanism[$value[1]][1][80][$value[7]][$value[8]] = $value;      //总系统下可乐必备品下某个活动的门店
                $must_mechanism[$value[1]][$value[2]][80][$value[7]][$value[8]] = $value;      //系统大类下可乐必备品下某个活动的门店
                $must_mechanism[$value[1]][$value[3]][80][$value[7]][$value[8]] = $value;      //系统名称下可乐必备品下某个活动的门店
            }
//                pd($value);
            //全国
            $infos[1][1][$value[4]][$value[7]][$value[8]] = $value;      //总系统下品类下某个活动(或某个设备)的门店
            $infos[1][1][$value[5]][$value[7]][$value[8]] = $value;      //总系统下品牌下某个活动(或某个设备)的门店
            $infos[1][1][$value[6]][$value[7]][$value[8]] = $value;      //总系统下Sku下某个活动(或某个设备)的门店

            $infos[1][$value[2]][$value[4]][$value[7]][$value[8]] = $value;      //系统大类下品类下某个活动(或某个设备)的门店
            $infos[1][$value[2]][$value[5]][$value[7]][$value[8]] = $value;      //系统大类下品牌下某个活动(或某个设备)的门店
            $infos[1][$value[2]][$value[6]][$value[7]][$value[8]] = $value;      //系统大类下Sku下某个活动(或某个设备)的门店

            $infos[1][$value[3]][$value[4]][$value[7]][$value[8]] = $value;      //系统名称下品类下某个活动的门店
            $infos[1][$value[3]][$value[5]][$value[7]][$value[8]] = $value;      //系统名称下品牌下某个活动的门店
            $infos[1][$value[3]][$value[6]][$value[7]][$value[8]] = $value;      //系统名称下Sku下某个活动的门店

            //全部
            $infos[$value[0]][1][$value[4]][$value[7]][$value[8]] = $value;      //总系统下品类下某个活动的门店
            $infos[$value[0]][1][$value[5]][$value[7]][$value[8]] = $value;      //总系统下品牌下某个活动的门店
            $infos[$value[0]][1][$value[6]][$value[7]][$value[8]] = $value;      //总系统下Sku下某个活动的门店

            $infos[$value[0]][$value[2]][$value[4]][$value[7]][$value[8]] = $value;      //系统大类下品类下某个活动的门店
            $infos[$value[0]][$value[2]][$value[5]][$value[7]][$value[8]] = $value;      //系统大类下品牌下某个活动的门店
            $infos[$value[0]][$value[2]][$value[6]][$value[7]][$value[8]] = $value;      //系统大类下Sku下某个活动的门店

            $infos[$value[0]][$value[3]][$value[4]][$value[7]][$value[8]] = $value;      //系统名称下品类下某个活动的门店
            $infos[$value[0]][$value[3]][$value[5]][$value[7]][$value[8]] = $value;      //系统名称下品牌下某个活动的门店
            $infos[$value[0]][$value[3]][$value[6]][$value[7]][$value[8]] = $value;      //系统名称下Sku下某个活动的门店
            //装瓶厂
            $infos[$value[1]][1][$value[4]][$value[7]][$value[8]] = $value;      //总系统下品类下某个活动的门店
            $infos[$value[1]][1][$value[5]][$value[7]][$value[8]] = $value;      //总系统下品牌下某个活动的门店
            $infos[$value[1]][1][$value[6]][$value[7]][$value[8]] = $value;      //总系统下Sku下某个活动的门店

            $infos[$value[1]][$value[2]][$value[4]][$value[7]][$value[8]] = $value;      //系统大类下品类下某个活动的门店
            $infos[$value[1]][$value[2]][$value[5]][$value[7]][$value[8]] = $value;      //系统大类下品牌下某个活动的门店
            $infos[$value[1]][$value[2]][$value[6]][$value[7]][$value[8]] = $value;      //系统大类下Sku下某个活动的门店

            $infos[$value[1]][$value[3]][$value[4]][$value[7]][$value[8]] = $value;      //系统名称下品类下某个活动的门店
            $infos[$value[1]][$value[3]][$value[5]][$value[7]][$value[8]] = $value;      //系统名称下品牌下某个活动的门店
            $infos[$value[1]][$value[3]][$value[6]][$value[7]][$value[8]] = $value;      //系统名称下Sku下某个活动的门店

            //可乐必备品分子
            //全国
            $must_infos[1][1][70][$value[7]][$value[8]] = $value;      //总系统下可乐必备品下某个活动(或某个设备)的门店
            $must_infos[1][$value[2]][70][$value[7]][$value[8]] = $value;      //系统大类下可乐必备品下某个活动(或某个设备)的门店
            $must_infos[1][$value[3]][70][$value[7]][$value[8]] = $value;      //系统名称下可乐必备品下某个活动的门店
            //全部
            $must_infos[$value[0]][1][70][$value[7]][$value[8]] = $value;      //总系统下可乐必备品下某个活动的门店
            $must_infos[$value[0]][$value[2]][70][$value[7]][$value[8]] = $value;      //系统大类下可乐必备品下某个活动的门店
            $must_infos[$value[0]][$value[3]][70][$value[7]][$value[8]] = $value;      //系统名称下可乐必备品下某个活动的门店
            //装瓶厂
            $must_infos[$value[1]][1][70][$value[7]][$value[8]] = $value;      //总系统下可乐必备品下某个活动的门店
            $must_infos[$value[1]][$value[2]][70][$value[7]][$value[8]] = $value;      //系统大类下可乐必备品下某个活动的门店
            $must_infos[$value[1]][$value[3]][70][$value[7]][$value[8]] = $value;      //系统名称下可乐必备品下某个活动的门店
            //分母
            //全国
            $denominator[1][1][$value[4]][$value[8]] = $value; //总系统下品类门店
            $denominator[1][1][$value[5]][$value[8]] = $value; //总系统下品牌门店
            $denominator[1][1][$value[6]][$value[8]] = $value; //总系统下sku门店

            $denominator[1][$value[2]][$value[4]][$value[8]] = $value; //系统大类下品类门店
            $denominator[1][$value[2]][$value[5]][$value[8]] = $value; //系统大类下品牌门店
            $denominator[1][$value[2]][$value[6]][$value[8]] = $value; //系统大类下sku门店

            $denominator[1][$value[3]][$value[4]][$value[8]] = $value; //系统名称品类下门店
            $denominator[1][$value[3]][$value[5]][$value[8]] = $value; //系统名称品牌下门店
            $denominator[1][$value[3]][$value[6]][$value[8]] = $value; //系统名称Sku下门店

            //全部
            $denominator[$value[0]][1][$value[4]][$value[8]] = $value; //总系统下品类门店
            $denominator[$value[0]][1][$value[5]][$value[8]] = $value; //总系统下品牌门店
            $denominator[$value[0]][1][$value[6]][$value[8]] = $value; //总系统下Sku门店

            $denominator[$value[0]][$value[2]][$value[4]][$value[8]] = $value; //系统大类下品类门店
            $denominator[$value[0]][$value[2]][$value[5]][$value[8]] = $value; //系统大类下品牌门店
            $denominator[$value[0]][$value[2]][$value[6]][$value[8]] = $value; //系统大类下Sku门店

            $denominator[$value[0]][$value[3]][$value[4]][$value[8]] = $value; //系统名称下品类门店
            $denominator[$value[0]][$value[3]][$value[5]][$value[8]] = $value; //系统名称下品牌门店
            $denominator[$value[0]][$value[3]][$value[6]][$value[8]] = $value; //系统名称下Sku门店

            //装瓶厂
            $denominator[$value[1]][1][$value[4]][$value[8]] = $value; //总系统下品类门店
            $denominator[$value[1]][1][$value[5]][$value[8]] = $value; //总系统下品牌门店
            $denominator[$value[1]][1][$value[6]][$value[8]] = $value; //总系统下Sku门店

            $denominator[$value[1]][$value[2]][$value[4]][$value[8]] = $value; //系统大类下品类门店
            $denominator[$value[1]][$value[2]][$value[5]][$value[8]] = $value; //系统大类下品牌门店
            $denominator[$value[1]][$value[2]][$value[6]][$value[8]] = $value; //系统大类下Sku门店

            $denominator[$value[1]][$value[3]][$value[4]][$value[8]] = $value; //系统名称下品类门店
            $denominator[$value[1]][$value[3]][$value[5]][$value[8]] = $value; //系统名称下品牌门店
            $denominator[$value[1]][$value[3]][$value[6]][$value[8]] = $value; //系统名称下Sku门店

            //可乐必备品分母
            //全国
            $must_denominator[1][1][80][$value[8]] = $value; //总系统下可乐必备品门店
            $must_denominator[1][$value[2]][80][$value[8]] = $value; //系统大类下可乐必备品门店
            $must_denominator[1][$value[3]][80][$value[8]] = $value; //系统名称下可乐必备品门店
            //全部
            $must_denominator[$value[0]][1][80][$value[8]] = $value; //总系统下可乐必备品门店
            $must_denominator[$value[0]][$value[2]][80][$value[8]] = $value; //系统大类下可乐必备品门店
            $must_denominator[$value[0]][$value[3]][80][$value[8]] = $value; //系统名称下可乐必备品门店
            //装瓶厂
            $must_denominator[$value[1]][1][80][$value[8]] = $value; //总系统下可乐必备品门店
            $must_denominator[$value[1]][$value[2]][80][$value[8]] = $value; //系统大类下可乐必备品门店
            $must_denominator[$value[1]][$value[3]][80][$value[8]] = $value; //系统名称下可乐必备品门店
        }
        if ($type == 'infos') {
            return $infos;
        } elseif ($type == 'must_infos') {
            return $must_infos;
        } elseif ($type == 'must_denominator') {
            return $must_denominator;
        } elseif ($type == 'must_mechanism') {
            return $must_mechanism;
        } elseif ($type == 'mechanism') {
            return $mechanism;
        } else {
            return $denominator;
        }
    }

    /**
     * 计算促销店次占比
     * @param $data
     * @param $time
     * @param $stage
     * @return string
     *
     * 品类类别（classes）不涉及（其他）和（可乐其他）和（KOMHSKU）
     * [0] => 太古
     * [1] => 粤东
     * [2] => Non-CCMG
     * [3] => CCMG本土
     * [4] => 金虎
     * [5] => 汽水
     * [6] => 可口可乐
     * [7] => 330可口可乐罐
     * [8] =>                  促销机制
     * [9] => 140105013199
     * 分子：机制（mechanism）中包含例如< 1 >的 > 0 的 （store_id）的门店数）
     * 分母:（store_id不重复的门店数）
     */
    public static function promotion($data, $time, $stage)
    {
        $t1 = microtime(true);
        $info = $infos = $activityData = $denominator = $info1 = [];
        foreach ($data as $value) {
            if ($value->classes != '其他' && $value->classes != '可乐其他' && $value->classes != 'KOMHSKU') {
                $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->mechanism, $value->store_id);
            }
            if ($value->classes == '可乐必备品') {
                $info1[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->mechanism, $value->store_id);
            }
        }
        unset($data);
        //其他品类，品牌，Sku
        $infos = self::infoCount($info, 'infos');
        $denominator = self::infoCount($info, 'denominator');

        unset($info);
//        pd($denominator);
        //可乐必备品
        $must_infos = self::infoCount($info1, 'must_infos');
        $must_denominator = self::infoCount($info1, 'must_denominator');
        unset($info1);
        //计算
        $gainData1 = self::countTwo($infos, $denominator);
        unset($infos, $denominator);
        $gainData2 = self::countTwo($must_infos, $must_denominator, $gainData1);  //计算可乐必备品并把其他的数据带过去
        unset($must_infos, $must_denominator, $gainData1);
        self::indexInsert($gainData2, $time, $stage, 'promotion', 'mechanism');
        unset($groupData2);
        $t2 = microtime(true);
        Yii::log("促销店次占比的总时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算设备卖进率
     * @param $data
     * @param $time
     * @param $stage
     * @return string
     *
     * 品类类别（classes）不涉及（其他）和（可乐其他）和（KOMHSKU）
     * [0] => 太古
     * [1] => 粤东
     * [2] => Non-CCMG
     * [3] => CCMG本土
     * [4] => 金虎
     * [5] => 汽水
     * [6] => 可口可乐
     * [7] => 330可口可乐罐
     * [8] =>                  设备
     * [9] => 140105013199
     * 总设备：分子，设备（equipment）中有文本的 > 0 的 （store_id）的门店数）
     * 乔雅咖啡机：分子：设备（equipment）中包含例如< 1 >的 > 0 的 （store_id）的门店数）
     * 分母:（store_id不重复的门店数）
     */
    public static function equipmentSales($data, $time, $stage)
    {
        $t1 = microtime(true);
        $info = $info1 = $infos = $activityData = $denominator = [];
        foreach ($data as $value) {
            if ($value->classes != '其他' && $value->classes != '可乐其他' && $value->classes != 'KOMHSKU') {
                $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->equipment, $value->store_id);
            }
            if ($value->classes == '可乐必备品') {
                $info1[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->equipment, $value->store_id);
            }
        }
        unset($data);
        //品类、品牌、sku的分子分母
        $infos = self::infoCountSales($info, 'infos');    //分子
        $denominator = self::infoCountSales($info, 'denominator');   //分母

        unset($info);
        //可乐必备品分子，分母
        $must_infos = self::infoCountSales($info1, 'must_infos');    //分子
        $must_denominator = self::infoCountSales($info1, 'must_denominator');   //分母
        unset($info1);
        //计算
        $gainData1 = self::countTwo($infos, $denominator);
        unset($infos, $denominator);
        //计算可乐必备品
        $gainData2 = self::countTwo($must_infos, $must_denominator, $gainData1);
        unset($must_infos, $must_denominator, $gainData1);
        self::indexInsert($gainData2, $time, $stage, 'equipment_sales', 'equipment');
        unset($groupData2);
        $t2 = microtime(true);
        Yii::log("设备卖进率的总时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算额外二次陈列
     * @param $data
     * @param $time
     * @param $stage
     * @return string
     *
     * 品类类别（classes）不涉及（其他）和（可乐其他）和（KOMHSKU）
     * [0] => 太古
     * [1] => 粤东
     * [2] => Non-CCMG
     * [3] => CCMG本土
     * [4] => 金虎
     * [5] => 汽水
     * [6] => 可口可乐
     * [7] => 330可口可乐罐
     * [8] =>                  额外二次陈列
     * [9] => 140105013199
     * 分子：二次陈列（secondary_display）中等于例如< 1 >的 > 0 的 F 列的门店数
     * 分母:（store_id不重复的门店数）
     */
    public static function extraDisplays($data, $time, $stage)
    {
        $t1 = microtime(true);
        $info = $infos = $activityData = $denominator = $info1 = [];
        foreach ($data as $value) {
            if ($value->classes != '其他' && $value->classes != '可乐其他' && $value->classes != 'KOMHSKU') {
                $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->secondary_display, $value->store_id);
            }
            if ($value->classes == '可乐必备品') {
                $info1[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->secondary_display, $value->store_id);
            }
        }
        unset($data);
        $infos = self::infoCountSales($info, 'infos');    //分子
        $denominator = self::infoCountSales($info, 'denominator');   //分母
        unset($info);
        //可乐必备品分子分母
        $must_infos = self::infoCountSales($info1, 'must_infos');    //分子
        $must_denominator = self::infoCountSales($info1, 'must_denominator');   //分母
        unset($info1);
        //计算
        $gainData1 = self::countTwo($infos, $denominator);
        unset($infos, $denominator);
        $gainData2 = self::countTwo($must_infos, $must_denominator, $gainData1);
        unset($must_infos, $must_denominator, $gainData1);
        //pd($gainData2);
        self::indexInsert($gainData2, $time, $stage, 'extra_displays', 'extraSku');
        unset($groupData2);
        $t2 = microtime(true);
        Yii::log("额外二次陈列的总时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算二次陈列门店数
     * @param $data
     * @param $time
     * @param $stage
     * @return string
     *
     * 品类类别（classes）不涉及（其他）和（可乐其他）和（KOMHSKU）
     * [0] => 太古
     * [1] => 粤东
     * [2] => Non-CCMG
     * [3] => CCMG本土
     * [4] => 金虎
     * [5] => 汽水
     * [6] => 可口可乐
     * [7] => 330可口可乐罐
     * [8] =>                  额外二次陈列
     * [9] => 140105013199
     * 二次陈列（secondary_display）中等于例如< 1 >的 > 0 的 F 列的门店数
     */
    public static function extraStores($data, $time, $stage)
    {
        $t1 = microtime(true);
        $info = $infos = $activityData = $info1 = [];
        foreach ($data as $value) {
            if ($value->classes != '其他' && $value->classes != '可乐其他' && $value->classes != 'KOMHSKU') {
                $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->secondary_display, $value->store_id);
            }
            if ($value->classes == '可乐必备品') {
                $info1[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->secondary_display, $value->store_id);
            }
        }
        unset($data);
        $infos = self::infoCountSales($info, 'infos');
        unset($info);
        //可乐必备品
        $must_infos = self::infoCountSales($info1, 'must_infos');
        unset($info1);
        //计算
        $gainData1 = self::stores($infos);
        unset($infos);
        $gainData2 = self::stores($must_infos, $gainData1);
        unset($must_infos, $gainData1);
        //pd($gainData2);
        self::indexInsert($gainData2, $time, $stage, 'extra_stores', 'extraSku');
        unset($groupData2);
        $t2 = microtime(true);
        Yii::log("二次陈列门店数的总时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算排面占比
     * @param $data
     * @param $time
     * @param $stage
     * @return string
     *
     * classes涉及（其他）和（可乐其他），不涉及（KOMHSKU）
     *
     * [0] => 中可    全部
     * [1] => 山西    装瓶厂
     * [2] => CCMG    系统大类
     * [3] => CCMG本土  系统类别
     * [4] => 金虎    客户系统
     * [5] => 汽水   品类
     * [6] => 可口可乐   品牌
     * [7] => 330可口可乐零度摩登罐   sku
     * [8] => 3    全部排面
     * [9] => 1    常温排面
     * [10] => 0   冷藏排面
     * [11] => 5   暖柜排面
     * [12] => 2147483647   门店Id
     *
     * 可乐必备品：分子：品类类别（classes）等于‘可乐必备品’的各排面数相加，分母:品类类别（classes）涉及other，ko other 的 排面列 中的数字相加
     *
     * 其他：分子：分子：（品类不涉及）（品牌、sku涉及）other，ko other 的 排面列 中的数字相加，分母: 所选sku的 品类 的排面列 中的数字相加
     *
     */
    public static function sovi($data, $time, $stage)
    {
        $t1 = microtime(true);
        $info = $infos = $category = $ko_must = [];
        foreach ($data as $value) {
            if ($value->classes != 'KOMHSKU') {
                //(用于计算(可乐必备品的分母)&品类、品牌、sku的分子
                $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->full_surface,
                    $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
            }
            //classes（品类类别）是可乐必备品的（用于计算可乐必备品的分子）// || $value->classes == '果奶' || $value->classes = '可乐其他'
            if ($value->classes == '可乐必备品') {
                $ko_must[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->brands->Id, $value->brands->Id, $value->skus->Id, $value->full_surface,
                    $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
            }
        }
        unset($data);
        $groupData = $aa = $aaa = $bb = $bbb = $cc = $ccc = $ddd = $dd = [];

        //可乐必备品的分子
        $coke = self::Coke($ko_must);

        unset($ko_must);
        $bb = self::shelfMethod($coke);      //计算，返回相加的总数

        unset($coke);
//        pd($bb);

        //可乐必备品的分母
        $aaa = self::Coke($info);
        $aa = self::shelfMethod($aaa);      //计算，返回相加的总数

        unset($aaa);
//        pd($aa);
        //（品类、品牌、sku）的分子
        $category_molecule = self::shelf($info);
        $category_result = self::shelfMethod($category_molecule);      //计算，返回相加的总数
        unset($category_molecule);

//        //其他的(例如：品牌、sku)的分子
//        $ccc = self::shelf($infos);
//        $cc = self::shelfMethod($ccc);      //计算，返回相加的总数

        //例如：品类、品牌、sku)的分母：（所属（品牌、sku）的品类的排面的数字相加
        $cokes = $country = $groups = $factorys = $brands = $skus = $cokeData = $s_big = $s_name = $s_sum = $categorys = [];
        $cokeData1 = $cokeData2 = $cokeData3 = $cokeData4 = $cokeData5 = $cokeData6 = $cokeData7 = $cokeData8 = [];
        for ($i = 1; $i <= 4; $i++) {
            $j = 0;
            $infoCount = array_column($info, ($i + 7));
            //pd($infoCount);
            $count = count(array_filter($infoCount));
            //echo "<pre>";var_dump($info);exit;
            foreach ($info as $v) {
                if ($v[($i + 6)] > 0) {
                    //全国
                    $cokes[1][1][$v[4]][$i][] = $v;   //总系统下品类
                    $cokes[1][$v[2]][$v[4]][$i][] = $v;   //系统大类下品类
                    $cokes[1][$v[3]][$v[4]][$i][] = $v;   //系统名称下品类
                    //全部
                    $cokes[$v[0]][1][$v[4]][$i][] = $v;   //总系统下品类
                    $cokes[$v[0]][$v[2]][$v[4]][$i][] = $v;   //系统大类下品类
                    $cokes[$v[0]][$v[3]][$v[4]][$i][] = $v;   //系统名称下品类
//                    //装瓶厂
                    $cokes[$v[1]][1][$v[4]][$i][] = $v;   //总系统下品类
                    $cokes[$v[1]][$v[2]][$v[4]][$i][] = $v;   //系统大类下品类
                    $cokes[$v[1]][$v[3]][$v[4]][$i][] = $v;   //系统名称下品类
                    //if($j==($count-1)){
                    //$cokes[$v[0]][1][$v[6]][$i][]=$v[$i+7]>0?$v:'';   //总系统下品类
                    //$cokeData1[$v[0]][1][$v[6]] = $cokes[$v[0]][1][$v[5]];
                    //echo "<pre>";var_dump($cokes);echo "</br>";
                    //$cokes[$v[0]][1][$v[7]]=$cokes[$v[0]][1][$v[5]];   //总系统下品类


                    //echo "<pre>";var_dump($cokes);echo $j."</br>";
                    //$cokes[$v[0]][1][$v[7]]=$cokes[$v[0]][1][$v[5]];   //总系统下品类
                    //}
                    $country[] = 1;
                    $groups[] = $v[0];
                    $factorys[] = $v[1];
                    $s_sum[] = 1;
                    $s_big[] = $v[2];
                    $s_name[] = $v[3];
                    $categorys[] = $v[4];
                    $brands[] = $v[5];
                    $skus[] = $v[6];

                    $j++;
                }
            }
        }//exit;
        $relation = [];
        $parent = SkuCvs::model()->findAll(["condition" => "depth=1", 'index' => 'Id']);
        if ($parent) {
            $parents = array_keys($parent);
            foreach ($parents as $v) {
                $relation[$v] = $v;
                $brand = SkuCvs::model()->findAll(['condition' => 'parent =' . $v . ' and (depth = 2 or depth = 4)', 'index' => 'Id']);
                if ($brand) {
                    $brandArr = array_keys($brand);
                    foreach ($brandArr as $v1) {
                        $relation[$v1] = $v;
                        $sku = SkuCvs::model()->findAll(['condition' => 'parent =' . $v1 . ' and (depth = 3 or depth = 5)', 'index' => 'Id']);
                        if ($sku) {
                            $skuArr = array_keys($sku);
                            foreach ($skuArr as $v2) {
                                $relation[$v2] = $v;
                            }
                        }
                    }
                }
            }
        }

//        pd($relation);
        //echo "<pre>";var_dump($cokes);exit;
        $groupsData = array_merge(array_unique($country), array_unique($groups), array_unique($factorys));
        $systemsData = array_merge(array_unique($s_big), array_unique($s_name), array_unique($s_sum));
        $productsData = array_merge(array_unique($brands), array_unique($skus), array_unique($categorys));
        //$k=0;
//        echo "<pre>";var_dump($groupsData,$systemsData,$productsData);exit;
        foreach ($groupsData as $groups) {//区域
            foreach ($systemsData as $systems) {//渠道
                foreach ($productsData as $products) {//产品
                    //for($i=1;$i<=8;$i++){
                    if (isset($cokes[$groups][$systems][$relation[$products]])) {
                        $cokesData[$groups][$systems][$products] = $cokes[$groups][$systems][$relation[$products]];
                    }
                    //$k++;
                    //}
                }
            }
        }
        unset($cokes);
        $ee = self::shelf($info, 'cateShelf');//品类的分母
        unset($info);
        $cate_list = [];
        //计算品类的分母排面数相加
        foreach (array_keys($ee) as $group) {     //区域
            foreach (array_keys($ee[$group]) as $system) {    //渠道
                if ($system != null) {
                    foreach (array_keys($ee[$group][$system]) as $shelf) { //货架
                        $cate_list[$group][$system][$shelf] = 0;
                        foreach (array_keys($ee[$group][$system][$shelf]) as $count) {  //多个门店数组
                            if ($shelf == 1) {
                                //$aa[$group][$system][$product][$shelf]['count'] = (isset($aa[$group][$system][$product][$shelf]['count'])?$aa[$group][$system][$product][$shelf]['count']:0)+$aaa[$group][$system][$product][$shelf][$count][8];
                                $cate_list[$group][$system][$shelf] += $ee[$group][$system][$shelf][$count][8];
                            }
                            if ($shelf == 2) {
                                $cate_list[$group][$system][$shelf] += $ee[$group][$system][$shelf][$count][9];
                            }
                            if ($shelf == 3) {
                                $cate_list[$group][$system][$shelf] += $ee[$group][$system][$shelf][$count][10];
                            }
                            if ($shelf == 4) {
                                $cate_list[$group][$system][$shelf] += $ee[$group][$system][$shelf][$count][11];
                            }
                        }
                    }
                }
            }
        }
        unset($ee);
        $dd = self::shelfMethod($cokesData);      //计算，返回相加的总数(品牌、sku的分母)
        unset($cokeData);

        $groupData1 = self::soviCount($category_result, $dd, [], $cate_list);
        unset($category_result, $dd, $cate_list);
        //可乐必备品的计算结果(参数$bb为分子，$aa为分母)
        $groupData2 = self::soviCount($bb, $aa, $groupData1);
        unset($bb, $aa, $groupData1);
        self::indexInsert($groupData2, $time, $stage, 'sovi', 'shelves');
        unset($groupData2);
        $t2 = microtime(true);
        Yii::log("排面占比全部时间：" . round($t2 - $t1, 3), 'warning');
    }
//    public static function sovi($data,$time,$stage)
//    {
//        $info = $infos =$category= $ko_must = [];
////        var_dump($data->brands->Id);die();
//        foreach ($data as $value) {
//            if ($value->system_subclasss == null) {
//
//                //涉及other、ko other 的数据(用于计算品类、品牌、sku分母)
//                $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id, '',
//                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->full_surface,
//                    $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
//
//                //品牌、sku涉及other ko other（用于计算品牌、sku的分子）
//                $category[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id, '',
//                    $value->system_names->Id, '', $value->brands->Id, $value->skus->Id, $value->full_surface,
//                    $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
//
//                //classes（品类类别）是可乐必备品的（用于计算可乐必备品的分子）
//                if($value->classes == '可乐必备品'){
//                    $ko_must[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id, '',
//                        $value->system_names->Id,$value->brands->Id, $value->brands->Id, $value->skus->Id, $value->full_surface,
//                        $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
//                }
//
//                if ($value->classes != '其他' && $value->classes != '可乐其他') {   //品类类别去除了其他和可乐其他之后的数据
//
//                    $infos[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id, '',
//                        $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->full_surface,
//                        $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
//
//                    //品类不涉及other、ko other（用于计算品类的分子）
//                    $category[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id, '',
//                        $value->system_names->Id, $value->categorys->Id, '', '', $value->full_surface,
//                        $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
//                }
//            } else {
//
//                //涉及other、ko other的数据(用于计算品类、品牌、sku分母)
//                $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id, $value->system_subclasss->Id,
//                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->full_surface,
//                    $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
//
//                //品牌、sku涉及other ko other（用于计算品牌、sku的分子）
//                $category[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id, $value->system_subclasss->Id,
//                    $value->system_names->Id, '', $value->brands->Id, $value->skus->Id, $value->full_surface,
//                    $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
//
//                //classes（品类类别）是可乐必备品的（用于计算可乐必备品的分子）
//                if($value->classes == '可乐必备品'){
//                    $ko_must[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,$value->system_subclasss->Id,
//                        $value->system_names->Id,$value->brands->Id, $value->brands->Id, $value->skus->Id, $value->full_surface,
//                        $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
//                }
//                if ($value->classes != '其他' && $value->classes != '可乐其他') {   //品类类别去除了其他和可乐其他之后的数据
//
//                    $infos[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id, $value->system_subclasss->Id,
//                        $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->full_surface,
//                        $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
//
//                    //品类不涉及other、ko other（用于计算品类的分子）
//                    $category[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id, $value->system_subclasss->Id,
//                        $value->system_names->Id, $value->categorys->Id, '', '', $value->full_surface,
//                        $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
//
//                }
//            }
//
//        }
////        pd($ko_must);
//        $groupData = $aa = $aaa = $bb = $bbb = $cc = $ccc = $ddd = $dd = [];
//
//        //可乐必备品的分子
//        $coke = self::Coke($ko_must);
//        $bb = self::shelfMethod($coke);      //计算，返回相加的总数
////        pd($bb);
//
//        //可乐必备品的分母
//        $aaa = self::Coke($info);
//        $aa = self::shelfMethod($aaa);      //计算，返回相加的总数
////        pd($aa);
//
//        //其他的（品类、品牌、sku）的分子
//        $category_molecule = self::shelf($category);
//        $category_result = self::shelfMethod($category_molecule);      //计算，返回相加的总数
////        pd($category_result);die();
//
////        //其他的(例如：品牌、sku)的分子
////        $ccc = self::shelf($infos);
////        $cc = self::shelfMethod($ccc);      //计算，返回相加的总数
//
//        //其他的(例如：品类、品牌、sku)的分母：（所属（品牌、sku）的品类的排面的数字相加）
//        $cokes = $country = $groups = $factorys = $brands = $skus = $cokeData = $s_big = $s_cate = $s_name = $s_sum = $categorys = [];
//        $cokeData1 = $cokeData2 = $cokeData3 = $cokeData4 = $cokeData5 = $cokeData6 = $cokeData7 = $cokeData8 = [];
//        for ($i = 1; $i <= 4; $i++) {
//            $j = 0;
//            $infoCount = array_column($info, ($i + 7));
//            //pd($infoCount);
//            $count = count(array_filter($infoCount));
//            //echo "<pre>";var_dump($info);exit;
//            foreach ($info as $v) {
//                if ($v[($i + 7)] > 0) {
//                    //全国
//                    $cokes[1][1][$v[5]][$i][] = $v;   //总系统下品类
//                    $cokes[1][$v[2]][$v[5]][$i][] = $v;   //系统大类下品类
//                    $cokes[1][$v[3]][$v[5]][$i][] = $v;   //系统类别下品类
//                    $cokes[1][$v[4]][$v[5]][$i][] = $v;   //系统名称下品类
//                    //全部
//                    $cokes[$v[0]][1][$v[5]][$i][] = $v;   //总系统下品类
//                    $cokes[$v[0]][$v[2]][$v[5]][$i][] = $v;   //系统大类下品类
//                    $cokes[$v[0]][$v[3]][$v[5]][$i][] = $v;   //系统类别下品类
//                    $cokes[$v[0]][$v[4]][$v[5]][$i][] = $v;   //系统名称下品类
////                    //装瓶厂
//                    $cokes[$v[1]][1][$v[5]][$i][] = $v;   //总系统下品类
//                    $cokes[$v[1]][$v[2]][$v[5]][$i][] = $v;   //系统大类下品类
//                    $cokes[$v[1]][$v[3]][$v[5]][$i][] = $v;   //系统类别下品类
//                    $cokes[$v[1]][$v[4]][$v[5]][$i][] = $v;   //系统名称下品类
//                    //if($j==($count-1)){
//                    //$cokes[$v[0]][1][$v[6]][$i][]=$v[$i+7]>0?$v:'';   //总系统下品类
//                    //$cokeData1[$v[0]][1][$v[6]] = $cokes[$v[0]][1][$v[5]];
//                    //echo "<pre>";var_dump($cokes);echo "</br>";
//                    //$cokes[$v[0]][1][$v[7]]=$cokes[$v[0]][1][$v[5]];   //总系统下品类
//
//
//                    //echo "<pre>";var_dump($cokes);echo $j."</br>";
//                    //$cokes[$v[0]][1][$v[7]]=$cokes[$v[0]][1][$v[5]];   //总系统下品类
//                    //}
//                    $country[] = 1;
//                    $groups[] = $v[0];
//                    $factorys[] = $v[1];
//                    $s_sum[] = 1;
//                    $s_big[] = $v[2];
//                    $s_cate[] = $v[3];
//                    $s_name[] = $v[4];
//                    $categorys[] = $v[5];
//                    $brands[] = $v[6];
//                    $skus[] = $v[7];
//
//                    /*$cokeData[$v[0]][1][$v[6]] = $cokes[$v[0]][1][$v[5]];
//                    $cokeData[$v[0]][1][$v[7]] = $cokes[$v[0]][1][$v[5]];
//
//                    $cokeData[$v[0]][$v[2]]= $cokes[$v[0]][$v[2]][$v[5]];
//                    $cokeData[$v[0]][$v[3]]= $cokes[$v[0]][$v[3]][$v[5]];
//                    $cokeData[$v[0]][$v[4]]= $cokes[$v[0]][$v[4]][$v[5]];
//
//                    $cokeData[$v[1]][1]= $cokes[$v[1]][1][$v[5]];
//                    $cokeData[$v[1]][$v[2]]= $cokes[$v[1]][$v[2]][$v[5]];
//                    $cokeData[$v[1]][$v[3]] = $cokes[$v[1]][$v[3]][$v[5]];
//                    $cokeData[$v[1]][$v[4]] = $cokes[$v[1]][$v[4]][$v[5]];*/
//
//                    $j++;
//                }
//            }
//        }//exit;
//        $relation = [];
//        $parent = SkuCvs::model()->findAll(["condition" => "depth=1", 'index' => 'Id']);
//        if ($parent) {
//                $parents = array_keys($parent);
//                foreach ($parents as $v) {
//                    $relation[$v] = $v;
//                    $brand = SkuCvs::model()->findAll(['condition' => 'parent =' . $v . ' and (depth = 2 or depth = 4)', 'index' => 'Id']);
//                    if ($brand) {
//                        $brandArr = array_keys($brand);
//                        foreach ($brandArr as $v1) {
//                            $relation[$v1] = $v;
//                            $sku = SkuCvs::model()->findAll(['condition' => 'parent =' . $v1 . ' and (depth = 3 or depth = 5)', 'index' => 'Id']);
//                            if ($sku) {
//                                $skuArr = array_keys($sku);
//                                foreach ($skuArr as $v2) {
//                                    $relation[$v2] = $v;
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//
////        pd($relation);
//        //echo "<pre>";var_dump($cokes);exit;
//        $groupsData = array_merge(array_unique($country),array_unique($groups), array_unique($factorys));
//        $systemsData = array_merge(array_unique($s_big), array_unique($s_cate), array_unique($s_name), array_unique($s_sum));
//        $productsData = array_merge(array_unique($brands), array_unique($skus), array_unique($categorys));
//        //$k=0;
////        echo "<pre>";var_dump($groupsData,$systemsData,$productsData);exit;
//        foreach ($groupsData as $groups) {//区域
//            foreach ($systemsData as $systems) {//渠道
//                foreach ($productsData as $products) {//产品
//                    //for($i=1;$i<=8;$i++){
//                    if (isset($cokes[$groups][$systems][$relation[$products]])) {
//                        $cokesData[$groups][$systems][$products] = $cokes[$groups][$systems][$relation[$products]];
//                    }
//                    //$k++;
//                    //}
//                }
//            }
//        }
////        var_dump($cokesData);die();
//        //echo "<pre>";var_dump($cokesData);exit;
//        /*
//            if($parent){
//                $parentArr=array_keys($parent);
//            }
//
//            //echo "<pre>";var_dump(array_merge(array_unique($groups), array_unique($factorys)),array_merge(array_unique($s_big), array_unique($s_cate), array_unique($s_name), array_unique($s_sum)));exit;
//            foreach ($groupsData as $group) {
//                foreach ($systemsData as $system) {
//                    foreach ($productsData as $product) {
//                        foreach($total as $sum){
//                            if(!empty($sum[$group][$system][$product])){
//                                $cokes[$group][$system][$product] = $sum[$group][$system][$product];   //全部的总系统的品牌、sku
//                            }
//                        }
//                    }
//                }
//            }*/
//
//        //pd($cokesData);
//        $dd = self::shelfMethod($cokesData);      //计算，返回相加的总数
//
////        pd($dd);
//        //可乐必备品
////        foreach (array_keys($aa) as $group) {
////            foreach (array_keys($aa[$group]) as $items) {
////                if($items != null){    //渠道的系统类别可能为空
////                    foreach (array_keys($aa[$group][$items]) as $list) {
////                        foreach (array_keys($aa[$group][$items][$list]) as $shelf) {
////                            $groupData[$group][$items][$list][$shelf] = $bb[$group][$items][$list][$shelf] / $aa[$group][$items][$list][$shelf];
////                        }
////                    }
////                }
////
////            }
////        }
//
//        //其他（例如品类、品牌、sku）的计算结果(参数$category_result为分子，$dd为分母)
//        $groupData1 = self::soviCount($category_result,$dd);
//
//        //可乐必备品的计算结果(参数$bb为分子，$aa为分母)
//        $groupData2 = self::soviCount($bb,$aa,$groupData1);
//
////        pd($groupData1,$groupData2);
////        $groupData = array_merge_recursive($groupData1,$groupData2);
////        pd($groupData2);die();
//
////        return $groupData;
//        self::indexInsert($groupData2,$time,$stage,'sovi','shelves');
//
//    }

    /**
     * 计算可口可乐店均门数
     * @param $data
     * @param $time
     * @param $stage
     */
    public static function freezerShop($data, $time, $stage)
    {
        $t1 = microtime(true);
        $info = $gainData = $info1 = [];
        foreach ($data as $value) {
            if ($value->classes != '其他' && $value->classes != '可乐其他' && $value->classes != 'KOMHSKU') {
                $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->equipment, $value->freezer_shop, $value->store_id);
            }
            if ($value->classes == '可乐必备品') {
                $info1[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                    $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->equipment, $value->freezer_shop, $value->store_id);
            }
        }
        unset($data);
        //品类、品牌、sku
        $molecule = self::freezerCount($info, 'molecule');//分子
        $denominator = self::freezerCount($info, 'denominator');//分母

        unset($info);
        //可乐必备品
        $must_molecule = self::freezerCount($info1, 'must_molecule');//分子
        $must_denominator = self::freezerCount($info1, 'must_denominator');//分母

        unset($info1);
        //计算
        $gainData1 = self::freezerCalculate($molecule, $denominator);
        unset($molecule, $denominator);
        $gainData2 = self::freezerCalculate($must_molecule, $must_denominator, $gainData1);
        unset($must_molecule, $must_denominator, $gainData1);
        self::indexInsert($gainData2, $time, $stage, 'freezer_shop', 'equipment');
        unset($groupData2);
        $t2 = microtime(true);
        Yii::log("可口可乐店均门数的全部时间：" . round($t2 - $t1, 3), 'warning');
    }

    public static function freezerCalculate($molecule, $denominator, $olddata = [])
    {
        $gainData = $olddata;
        foreach (array_keys($molecule) as $group) {
            foreach (array_keys($molecule[$group]) as $system) {
                foreach (array_keys($molecule[$group][$system]) as $product) {
                    foreach (array_keys($molecule[$group][$system][$product]) as $list) {
                        $a = explode(',', $list);
                        foreach ($a as $v) {
                            if (empty($denominator[$group][$system][$product])) {
                                $gainData[$group][$system][$product][$v] = 0;
                            } else {
                                if (isset($gainData[$group][$system][$product][$v])) {
                                    $gainData[$group][$system][$product][$v] += array_sum($molecule[$group][$system][$product][$list]) / count($denominator[$group][$system][$product][$list]);  //某个活动去除重复门店之后的门店数量
                                } else {
                                    $gainData[$group][$system][$product][$v] = array_sum($molecule[$group][$system][$product][$list]) / count($denominator[$group][$system][$product][$list]);  //某个活动去除重复门店之后的门店数量
                                }
                            }
                        }
                    }
                }
            }
        }
        return $gainData;
    }

    public static function freezerCount($info, $type)
    {
        $infos = $denominator = $must_molecule = $must_denominator = [];
        foreach ($info as $v) {
            if ($v[7] > 0 && $v[8] > 0) {
                //品类、品牌、sku的分子
                //全国
                $infos[1][1][$v[4]][$v[7]][] = $v[8];      //总系统下品类下某个活动(或某个设备)的门店
                $infos[1][1][$v[5]][$v[7]][] = $v[8];      //总系统下品牌下某个活动(或某个设备)的门店
                $infos[1][1][$v[6]][$v[7]][] = $v[8];      //总系统下Sku下某个活动(或某个设备)的门店

                $infos[1][$v[2]][$v[4]][$v[7]][] = $v[8];      //系统大类下品类下某个活动(或某个设备)的门店
                $infos[1][$v[2]][$v[5]][$v[7]][] = $v[8];      //系统大类下品牌下某个活动(或某个设备)的门店
                $infos[1][$v[2]][$v[6]][$v[7]][] = $v[8];      //系统大类下Sku下某个活动(或某个设备)的门店

                $infos[1][$v[3]][$v[4]][$v[7]][] = $v[8];      //系统名称下品类下某个活动的门店
                $infos[1][$v[3]][$v[5]][$v[7]][] = $v[8];      //系统名称下品牌下某个活动的门店
                $infos[1][$v[3]][$v[6]][$v[7]][] = $v[8];      //系统名称下Sku下某个活动的门店
                //全部
                $infos[$v[0]][1][$v[4]][$v[7]][] = $v[8];      //总系统下品类下某个活动的门店
                $infos[$v[0]][1][$v[5]][$v[7]][] = $v[8];      //总系统下品牌下某个活动的门店
                $infos[$v[0]][1][$v[6]][$v[7]][] = $v[8];      //总系统下Sku下某个活动的门店

                $infos[$v[0]][$v[2]][$v[4]][$v[7]][] = $v[8];      //系统大类下品类下某个活动的门店
                $infos[$v[0]][$v[2]][$v[5]][$v[7]][] = $v[8];      //系统大类下品牌下某个活动的门店
                $infos[$v[0]][$v[2]][$v[6]][$v[7]][] = $v[8];      //系统大类下Sku下某个活动的门店

                $infos[$v[0]][$v[3]][$v[4]][$v[7]][] = $v[8];      //系统名称下品类下某个活动的门店
                $infos[$v[0]][$v[3]][$v[5]][$v[7]][] = $v[8];      //系统名称下品牌下某个活动的门店
                $infos[$v[0]][$v[3]][$v[6]][$v[7]][] = $v[8];      //系统名称下Sku下某个活动的门店
                //装瓶厂
                $infos[$v[1]][1][$v[4]][$v[7]][] = $v[8];      //总系统下品类下某个活动的门店
                $infos[$v[1]][1][$v[5]][$v[7]][] = $v[8];      //总系统下品牌下某个活动的门店
                $infos[$v[1]][1][$v[6]][$v[7]][] = $v[8];      //总系统下Sku下某个活动的门店

                $infos[$v[1]][$v[2]][$v[4]][$v[7]][] = $v[8];      //系统大类下品类下某个活动的门店
                $infos[$v[1]][$v[2]][$v[5]][$v[7]][] = $v[8];      //系统大类下品牌下某个活动的门店
                $infos[$v[1]][$v[2]][$v[6]][$v[7]][] = $v[8];      //系统大类下Sku下某个活动的门店

                $infos[$v[1]][$v[3]][$v[4]][$v[7]][] = $v[8];      //系统名称下品类下某个活动的门店
                $infos[$v[1]][$v[3]][$v[5]][$v[7]][] = $v[8];      //系统名称下品牌下某个活动的门店
                $infos[$v[1]][$v[3]][$v[6]][$v[7]][] = $v[8];      //系统名称下Sku下某个活动的门店

                //品类、品牌、sku的分母
                //全国
                $denominator[1][1][$v[4]][$v[7]][] = $v;      //总系统下品类下某个活动(或某个设备)的门店
                $denominator[1][1][$v[5]][$v[7]][] = $v;      //总系统下品牌下某个活动(或某个设备)的门店
                $denominator[1][1][$v[6]][$v[7]][] = $v;      //总系统下Sku下某个活动(或某个设备)的门店

                $denominator[1][$v[2]][$v[4]][$v[7]][] = $v;      //系统大类下品类下某个活动(或某个设备)的门店
                $denominator[1][$v[2]][$v[5]][$v[7]][] = $v;      //系统大类下品牌下某个活动(或某个设备)的门店
                $denominator[1][$v[2]][$v[6]][$v[7]][] = $v;      //系统大类下Sku下某个活动(或某个设备)的门店

                $denominator[1][$v[3]][$v[4]][$v[7]][] = $v;      //系统名称下品类下某个活动的门店
                $denominator[1][$v[3]][$v[5]][$v[7]][] = $v;      //系统名称下品牌下某个活动的门店
                $denominator[1][$v[3]][$v[6]][$v[7]][] = $v;      //系统名称下Sku下某个活动的门店
                //全部
                $denominator[$v[0]][1][$v[4]][$v[7]][] = $v;      //总系统下品类下某个活动的门店
                $denominator[$v[0]][1][$v[5]][$v[7]][] = $v;      //总系统下品牌下某个活动的门店
                $denominator[$v[0]][1][$v[6]][$v[7]][] = $v;      //总系统下Sku下某个活动的门店

                $denominator[$v[0]][$v[2]][$v[4]][$v[7]][] = $v;      //系统大类下品类下某个活动的门店
                $denominator[$v[0]][$v[2]][$v[5]][$v[7]][] = $v;      //系统大类下品牌下某个活动的门店
                $denominator[$v[0]][$v[2]][$v[6]][$v[7]][] = $v;      //系统大类下Sku下某个活动的门店

                $denominator[$v[0]][$v[3]][$v[4]][$v[7]][] = $v;      //系统名称下品类下某个活动的门店
                $denominator[$v[0]][$v[3]][$v[5]][$v[7]][] = $v;      //系统名称下品牌下某个活动的门店
                $denominator[$v[0]][$v[3]][$v[6]][$v[7]][] = $v;      //系统名称下Sku下某个活动的门店
                //装瓶厂
                $denominator[$v[1]][1][$v[4]][$v[7]][] = $v;      //总系统下品类下某个活动的门店
                $denominator[$v[1]][1][$v[5]][$v[7]][] = $v;      //总系统下品牌下某个活动的门店
                $denominator[$v[1]][1][$v[6]][$v[7]][] = $v;      //总系统下Sku下某个活动的门店

                $denominator[$v[1]][$v[2]][$v[4]][$v[7]][] = $v;      //系统大类下品类下某个活动的门店
                $denominator[$v[1]][$v[2]][$v[5]][$v[7]][] = $v;      //系统大类下品牌下某个活动的门店
                $denominator[$v[1]][$v[2]][$v[6]][$v[7]][] = $v;      //系统大类下Sku下某个活动的门店

                $denominator[$v[1]][$v[3]][$v[4]][$v[7]][] = $v;      //系统名称下品类下某个活动的门店
                $denominator[$v[1]][$v[3]][$v[5]][$v[7]][] = $v;      //系统名称下品牌下某个活动的门店
                $denominator[$v[1]][$v[3]][$v[6]][$v[7]][] = $v;      //系统名称下Sku下某个活动的门店

                //可乐必备品的分子
                //全国
                $must_molecule[1][1][80][$v[7]][] = $v[8];      //总系统下品类下某个活动(或某个设备)的门店
                $must_molecule[1][$v[2]][80][$v[7]][] = $v[8];      //系统大类下品类下某个活动(或某个设备)的门店
                $must_molecule[1][$v[3]][80][$v[7]][] = $v[8];      //系统名称下品类下某个活动的门店
                //全部
                $must_molecule[$v[0]][1][80][$v[7]][] = $v[8];      //总系统下品类下某个活动的门店
                $must_molecule[$v[0]][$v[2]][80][$v[7]][] = $v[8];      //系统大类下品类下某个活动的门店
                $must_molecule[$v[0]][$v[3]][80][$v[7]][] = $v[8];      //系统名称下品类下某个活动的门店
                //装瓶厂
                $must_molecule[$v[1]][1][80][$v[7]][] = $v[8];      //总系统下品类下某个活动的门店
                $must_molecule[$v[1]][$v[2]][80][$v[7]][] = $v[8];      //系统大类下品类下某个活动的门店
                $must_molecule[$v[1]][$v[3]][80][$v[7]][] = $v[8];      //系统名称下品类下某个活动的门店

                //可乐必备品的分母
                //全国
                $must_denominator[1][1][80][$v[7]][] = $v;      //总系统下品类下某个活动(或某个设备)的门店
                $must_denominator[1][$v[2]][80][$v[7]][] = $v;      //系统大类下品类下某个活动(或某个设备)的门店
                $must_denominator[1][$v[3]][80][$v[7]][] = $v;      //系统名称下品类下某个活动的门店
                //全部
                $must_denominator[$v[0]][1][80][$v[7]][] = $v;      //总系统下品类下某个活动的门店
                $must_denominator[$v[0]][$v[2]][80][$v[7]][] = $v;      //系统大类下品类下某个活动的门店
                $must_denominator[$v[0]][$v[3]][80][$v[7]][] = $v;      //系统名称下品类下某个活动的门店
                //装瓶厂
                $must_denominator[$v[1]][1][80][$v[7]][] = $v;      //总系统下品类下某个活动的门店
                $must_denominator[$v[1]][$v[2]][80][$v[7]][] = $v;      //系统大类下品类下某个活动的门店
                $must_denominator[$v[1]][$v[3]][80][$v[7]][] = $v;      //系统名称下品类下某个活动的门店
            }
        }
        if ($type == 'molecule') {
            return $infos;
        } elseif ($type == 'must_molecule') {
            return $must_molecule;
        } elseif ($type == 'must_denominator') {
            return $must_denominator;
        } else {
            return $denominator;
        }
    }

    //期数的变化率
    public static function Rate($data, $time, $stage, $index, $type)
    {
        $listUpdate = [];
        foreach (array_keys($data) as $group) {   //区域
            foreach (array_keys($data[$group]) as $system) {  //渠道
                foreach (array_keys($data[$group][$system]) as $product) {  //产品
                    foreach (array_keys($data[$group][$system][$product]) as $use) {  //排面或者活动或者机制
                        $value = $data[$group][$system][$product][$use];
                        $model = InfoCvs::model()->find('time =  "' . date('Y-m', $time) . '" and stage = ' . $stage . ' and relationship_id = ' . $group .
                            ' and system_id = ' . $system . ' and sku_id = ' . $product . ' and ' . $type . ' = ' . $use);
                        if ($model) {
                            $listUpdate[$model['Id']] = array($index => $value);
                        }
//                        InfoCvs::model()->updateAll(array($index=>$value),'time =  "'.date('Y-m', $time).'" and stage = ' . $stage . ' and relationship_id = ' . $group .
//                            ' and system_id = ' . $system . ' and sku_id = ' . $product . ' and ' . $type . ' = ' . $use);
                    }
                }
            }
        }
        $label = array($index);
        $count = count($listUpdate);
        $pageSize = 500;
        $times = ceil($count / 500);  //每500条数据分一批
        for ($i = 0; $i < $times; $i++) {
            $listCvs = array_slice($listUpdate, $i * $pageSize, $pageSize, true);
            $arrayId = array_keys($listCvs);
            self::batchUpdate('cola_info_cvs', $label, $listCvs, $arrayId);
        }

    }

    /**
     * 计算铺货率的变化率
     * 用本期的值减去上期的值
     * @param $current
     * @param $last
     * @param $time
     * @param $stage
     */
    public static function lastDistribution($current, $last, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::lastCurrent($current);   //本期的数据
        unset($current);
        $Lastinfo = self::lastCurrent($last);   //上期的数据
        unset($last);
        $gradient = self::lastPercent($info, $Lastinfo);
        unset($info, $Lastinfo);
//        pd($gradient);
        self::Rate($gradient, $time, $stage, 'Last_distribution_radio', 'shelves');
        unset($gradient);
        $t2 = microtime(true);
        Yii::log("铺货率的变化率的全部时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算铺货门店数的变化率
     * （当期的值-上期的值）/上期的值
     * @param $current
     * @param $last
     * @param $time
     * @param $stage
     */
    public static function lastDistributionStores($current, $last, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::lastCurrent($current, 'distributionStores');   //本期的数据
        unset($current);
        $Lastinfo = self::lastCurrent($last, 'distributionStores');   //上期的数据
        unset($last);
        $gradient = self::lastChange($info, $Lastinfo);
        unset($info, $Lastinfo);
        self::Rate($gradient, $time, $stage, 'Last_distribution_stores_radio', 'shelves');
        unset($gradient);
        $t2 = microtime(true);
        Yii::log("铺货门店数的变化率的全部时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算店均货架排面数的变化率
     * (本期-上期)/上期
     * @param $current
     * @param $last
     * @param $time
     * @param $stage
     */
    public static function lastShelfNumber($current, $last, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::lastCurrent($current, 'shelfNumber');   //本期的数据
        unset($current);
        $Lastinfo = self::lastCurrent($last, 'shelfNumber');   //上期的数据
        unset($last);
        $gradient = self::lastChange($info, $Lastinfo);
        unset($info, $Lastinfo);
//        pd($gradient);
        self::Rate($gradient, $time, $stage, 'Last_shelf_number_radio', 'shelves');
        unset($gradient);
        $t2 = microtime(true);
        Yii::log("店均货架排面数的变化率的全部时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算活动发生率的变化率
     * 本期-上期
     * @param $current
     * @param $last
     * @param $time
     * @param $stage
     */
    public static function lastThematicActivity($current, $last, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::lastCurrent($current, 'activity');   //本期的数据
        unset($current);
        $Lastinfo = self::lastCurrent($last, 'activity');   //上期的数据
        unset($last);
//        pd($info);
        $gradient = self::lastPercent($info, $Lastinfo);
        unset($info, $Lastinfo);
//        pd($gradient);
        self::Rate($gradient, $time, $stage, 'Last_thematic_activity_radio', 'activity');
        unset($gradient);
        $t2 = microtime(true);
        Yii::log("活动发生率的变化率的全部时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算促销店次占比的变化率
     * 本期-上期
     * @param $current
     * @param $last
     * @param $time
     * @param $stage
     */
    public static function lastPromotion($current, $last, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::lastCurrent($current, 'promotion');   //本期的数据
        unset($current);
        $Lastinfo = self::lastCurrent($last, 'promotion');   //上期的数据
        unset($last);
//        pd($info,$Lastinfo);
        $gradient = self::lastPercent($info, $Lastinfo);
        unset($info, $Lastinfo);
//        pd($gradient);
        self::Rate($gradient, $time, $stage, 'Last_promotion_radio', 'mechanism');
        unset($gradient);
        $t2 = microtime(true);
        Yii::log("促销店次占比的变化率的全部时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算设备卖进率的变化率
     * 本期-上期
     * @param $current
     * @param $last
     * @param $time
     * @param $stage
     */
    public static function lastEquipmentSales($current, $last, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::lastCurrent($current, 'equipmentSales');   //本期的数据
        unset($current);
        $Lastinfo = self::lastCurrent($last, 'equipmentSales');   //上期的数据
        unset($last);
//        pd($info);
        $gradient = self::lastPercent($info, $Lastinfo);
        unset($info, $Lastinfo);
//        pd($gradient);
        self::Rate($gradient, $time, $stage, 'Last_equipment_sales_radio', 'equipment');
        unset($gradient);
        $t2 = microtime(true);
        Yii::log("设备卖进率的变化率的全部时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算排面占比的变化率
     * 本期-上期
     * @param $current
     * @param $last
     * @param $time
     * @param $stage
     */
    public static function lastSovi($current, $last, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::lastCurrent($current, 'sovi');   //本期的数据
        unset($current);
        $Lastinfo = self::lastCurrent($last, 'sovi');   //上期的数据
        unset($last);
//        pd($info);
        $gradient = self::lastPercent($info, $Lastinfo);
        unset($info, $Lastinfo);
//        pd($gradient);
        self::Rate($gradient, $time, $stage, 'Last_sovi_radio', 'shelves');
        unset($gradient);
        $t2 = microtime(true);
        Yii::log("排面占比的变化率的全部时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算额外二次陈列的变化率
     * 本期-上期
     * @param $current
     * @param $last
     * @param $time
     * @param $stage
     */
    public static function lastExtraDisplays($current, $last, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::lastCurrent($current, 'extraDisplays');   //本期的数据
        unset($current);
        $Lastinfo = self::lastCurrent($last, 'extraDisplays');   //上期的数据
        unset($last);
//        pd($info);
        $gradient = self::lastPercent($info, $Lastinfo);
        unset($info, $Lastinfo);
//        pd($gradient);
        self::Rate($gradient, $time, $stage, 'Last_extra_displays_radio', 'extraSku');
        unset($gradient);
        $t2 = microtime(true);
        Yii::log("额外二次陈列的变化率的全部时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算二次陈列门店数的变化率
     * 本期-上期
     * @param $current
     * @param $last
     * @param $time
     * @param $stage
     */
    public static function lastExtraStores($current, $last, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::lastCurrent($current, 'extraStores');   //本期的数据
        unset($current);
        $Lastinfo = self::lastCurrent($last, 'extraStores');   //上期的数据
        unset($last);
//        pd($info);
        $gradient = self::lastChange($info, $Lastinfo);//(本期-上期)/上期
        unset($info, $Lastinfo);
//        pd($gradient);
        self::Rate($gradient, $time, $stage, 'Last_extra_stores', 'extraSku');
        unset($gradient);
        $t2 = microtime(true);
        Yii::log("二次陈列门店数的变化率的全部时间：" . round($t2 - $t1, 3), 'warning');
    }

    /**
     * 计算可口可乐冰柜店均门数的变化率
     * @param $current
     * @param $last
     * @param $time
     * @param $stage
     */
    public static function lastFreezerShop($current, $last, $time, $stage)
    {
        $t1 = microtime(true);
        $info = self::lastCurrent($current, 'lastFreezerShop');   //本期的数据
        unset($current);
        $Lastinfo = self::lastCurrent($last, 'lastFreezerShop');   //上期的数据
        unset($last);
//        pd($info);
        $gradient = self::lastChange($info, $Lastinfo);   //(本期-上期)/上期
        unset($info, $Lastinfo);
//        pd($gradient);
        self::Rate($gradient, $time, $stage, 'Last_freezer_shop', 'equipment');
        unset($gradient);
        $t2 = microtime(true);
        Yii::log("可口可乐冰柜店均门数的变化率的全部时间：" . round($t2 - $t1, 3), 'warning');
    }

    public static function infoCountSales($data, $type)
    {
        $infos = $denominator = $must_infos = $must_denominator = $mechanism = $must_mechanism = $must_mechanism = [];
        foreach ($data as $value) {
            if ($value[8] > 0) {
                if (isset($value[10]) && $value[10] > 0) {   //辅助计算总活动的机制列（包含活动并且机制列要有文本）
                    //全国
                    $mechanism[1][1][$value[5]][$value[8]][$value[9]] = $value;      //总系统下品类下某个活动(或某个设备)的门店
                    $mechanism[1][1][$value[6]][$value[8]][$value[9]] = $value;      //总系统下品牌下某个活动(或某个设备)的门店
                    $mechanism[1][1][$value[7]][$value[8]][$value[9]] = $value;      //总系统下Sku下某个活动(或某个设备)的门店

                    $mechanism[1][$value[2]][$value[5]][$value[8]][$value[9]] = $value;      //系统大类下品类下某个活动(或某个设备)的门店
                    $mechanism[1][$value[2]][$value[6]][$value[8]][$value[9]] = $value;      //系统大类下品牌下某个活动(或某个设备)的门店
                    $mechanism[1][$value[2]][$value[7]][$value[8]][$value[9]] = $value;      //系统大类下Sku下某个活动(或某个设备)的门店

                    $mechanism[1][$value[3]][$value[5]][$value[8]][$value[9]] = $value;      //系统类别下品类下某个活动的门店
                    $mechanism[1][$value[3]][$value[6]][$value[8]][$value[9]] = $value;      //系统类别下品牌下某个活动的门店
                    $mechanism[1][$value[3]][$value[7]][$value[8]][$value[9]] = $value;      //系统类别下Sku下某个活动的门店

                    $mechanism[1][$value[4]][$value[5]][$value[8]][$value[9]] = $value;      //系统名称下品类下某个活动的门店
                    $mechanism[1][$value[4]][$value[6]][$value[8]][$value[9]] = $value;      //系统名称下品牌下某个活动的门店
                    $mechanism[1][$value[4]][$value[7]][$value[8]][$value[9]] = $value;      //系统名称下Sku下某个活动的门店

                    //全部
                    $mechanism[$value[0]][1][$value[5]][$value[8]][$value[9]] = $value;      //总系统下品类下某个活动的门店
                    $mechanism[$value[0]][1][$value[6]][$value[8]][$value[9]] = $value;      //总系统下品牌下某个活动的门店
                    $mechanism[$value[0]][1][$value[7]][$value[8]][$value[9]] = $value;      //总系统下Sku下某个活动的门店

                    $mechanism[$value[0]][$value[2]][$value[5]][$value[8]][$value[9]] = $value;      //系统大类下品类下某个活动的门店
                    $mechanism[$value[0]][$value[2]][$value[6]][$value[8]][$value[9]] = $value;      //系统大类下品牌下某个活动的门店
                    $mechanism[$value[0]][$value[2]][$value[7]][$value[8]][$value[9]] = $value;      //系统大类下Sku下某个活动的门店

                    $mechanism[$value[0]][$value[3]][$value[5]][$value[8]][$value[9]] = $value;      //系统类别下品类下某个活动的门店
                    $mechanism[$value[0]][$value[3]][$value[6]][$value[8]][$value[9]] = $value;      //系统类别下品牌下某个活动的门店
                    $mechanism[$value[0]][$value[3]][$value[7]][$value[8]][$value[9]] = $value;      //系统类别下Sku下某个活动的门店

                    $mechanism[$value[0]][$value[4]][$value[5]][$value[8]][$value[9]] = $value;      //系统名称下品类下某个活动的门店
                    $mechanism[$value[0]][$value[4]][$value[6]][$value[8]][$value[9]] = $value;      //系统名称下品牌下某个活动的门店
                    $mechanism[$value[0]][$value[4]][$value[7]][$value[8]][$value[9]] = $value;      //系统名称下Sku下某个活动的门店
                    //装瓶厂
                    $mechanism[$value[1]][1][$value[5]][$value[8]][$value[9]] = $value;      //总系统下品类下某个活动的门店
                    $mechanism[$value[1]][1][$value[6]][$value[8]][$value[9]] = $value;      //总系统下品牌下某个活动的门店
                    $mechanism[$value[1]][1][$value[7]][$value[8]][$value[9]] = $value;      //总系统下Sku下某个活动的门店

                    $mechanism[$value[1]][$value[2]][$value[5]][$value[8]][$value[9]] = $value;      //系统大类下品类下某个活动的门店
                    $mechanism[$value[1]][$value[2]][$value[6]][$value[8]][$value[9]] = $value;      //系统大类下品牌下某个活动的门店
                    $mechanism[$value[1]][$value[2]][$value[7]][$value[8]][$value[9]] = $value;      //系统大类下Sku下某个活动的门店

                    $mechanism[$value[1]][$value[3]][$value[5]][$value[8]][$value[9]] = $value;      //系统类别下品类下某个活动的门店
                    $mechanism[$value[1]][$value[3]][$value[6]][$value[8]][$value[9]] = $value;      //系统类别下品牌下某个活动的门店
                    $mechanism[$value[1]][$value[3]][$value[7]][$value[8]][$value[9]] = $value;      //系统类别下Sku下某个活动的门店

                    $mechanism[$value[1]][$value[4]][$value[5]][$value[8]][$value[9]] = $value;      //系统名称下品类下某个活动的门店
                    $mechanism[$value[1]][$value[4]][$value[6]][$value[8]][$value[9]] = $value;      //系统名称下品牌下某个活动的门店
                    $mechanism[$value[1]][$value[4]][$value[7]][$value[8]][$value[9]] = $value;      //系统名称下Sku下某个活动的门店

                    //可乐必备品辅助计算总活动的机制列（包含活动并且机制列要有文本）
                    //全国
                    $must_mechanism[1][1][80][$value[8]][$value[9]] = $value;      //总系统下品类下某个活动(或某个设备)的门店
                    $must_mechanism[1][$value[2]][80][$value[8]][$value[9]] = $value;      //系统大类下品类下某个活动(或某个设备)的门店
                    $must_mechanism[1][$value[3]][80][$value[8]][$value[9]] = $value;      //系统类别下品类下某个活动的门店
                    $must_mechanism[1][$value[4]][80][$value[8]][$value[9]] = $value;      //系统名称下品类下某个活动的门店

                    //全部
                    $must_mechanism[$value[0]][1][80][$value[8]][$value[9]] = $value;      //总系统下品类下某个活动的门店
                    $must_mechanism[$value[0]][$value[2]][80][$value[8]][$value[9]] = $value;      //系统大类下品类下某个活动的门店
                    $must_mechanism[$value[0]][$value[3]][80][$value[8]][$value[9]] = $value;      //系统类别下品类下某个活动的门店
                    $must_mechanism[$value[0]][$value[4]][80][$value[8]][$value[9]] = $value;      //系统名称下品类下某个活动的门店
                    //装瓶厂
                    $must_mechanism[$value[1]][1][80][$value[8]][$value[9]] = $value;      //总系统下品类下某个活动的门店
                    $must_mechanism[$value[1]][$value[2]][80][$value[8]][$value[9]] = $value;      //系统大类下品类下某个活动的门店
                    $must_mechanism[$value[1]][$value[3]][80][$value[8]][$value[9]] = $value;      //系统类别下品类下某个活动的门店
                    $must_mechanism[$value[1]][$value[4]][80][$value[8]][$value[9]] = $value;      //系统名称下品类下某个活动的门店
                }
//                pd($value);
                //全国
                $infos[1][1][$value[4]][$value[7]][$value[8]] = $value;      //总系统下品类下某个活动(或某个设备)的门店
                $infos[1][1][$value[5]][$value[7]][$value[8]] = $value;      //总系统下品牌下某个活动(或某个设备)的门店
                $infos[1][1][$value[6]][$value[7]][$value[8]] = $value;      //总系统下Sku下某个活动(或某个设备)的门店

                $infos[1][$value[2]][$value[4]][$value[7]][$value[8]] = $value;      //系统大类下品类下某个活动(或某个设备)的门店
                $infos[1][$value[2]][$value[5]][$value[7]][$value[8]] = $value;      //系统大类下品牌下某个活动(或某个设备)的门店
                $infos[1][$value[2]][$value[6]][$value[7]][$value[8]] = $value;      //系统大类下Sku下某个活动(或某个设备)的门店

                $infos[1][$value[3]][$value[4]][$value[7]][$value[8]] = $value;      //系统名称下品类下某个活动的门店
                $infos[1][$value[3]][$value[5]][$value[7]][$value[8]] = $value;      //系统名称下品牌下某个活动的门店
                $infos[1][$value[3]][$value[6]][$value[7]][$value[8]] = $value;      //系统名称下Sku下某个活动的门店

                //全部
                $infos[$value[0]][1][$value[4]][$value[7]][$value[8]] = $value;      //总系统下品类下某个活动的门店
                $infos[$value[0]][1][$value[5]][$value[7]][$value[8]] = $value;      //总系统下品牌下某个活动的门店
                $infos[$value[0]][1][$value[6]][$value[7]][$value[8]] = $value;      //总系统下Sku下某个活动的门店

                $infos[$value[0]][$value[2]][$value[4]][$value[7]][$value[8]] = $value;      //系统大类下品类下某个活动的门店
                $infos[$value[0]][$value[2]][$value[5]][$value[7]][$value[8]] = $value;      //系统大类下品牌下某个活动的门店
                $infos[$value[0]][$value[2]][$value[6]][$value[7]][$value[8]] = $value;      //系统大类下Sku下某个活动的门店

                $infos[$value[0]][$value[3]][$value[4]][$value[7]][$value[8]] = $value;      //系统名称下品类下某个活动的门店
                $infos[$value[0]][$value[3]][$value[5]][$value[7]][$value[8]] = $value;      //系统名称下品牌下某个活动的门店
                $infos[$value[0]][$value[3]][$value[6]][$value[7]][$value[8]] = $value;      //系统名称下Sku下某个活动的门店
                //装瓶厂
                $infos[$value[1]][1][$value[4]][$value[7]][$value[8]] = $value;      //总系统下品类下某个活动的门店
                $infos[$value[1]][1][$value[5]][$value[7]][$value[8]] = $value;      //总系统下品牌下某个活动的门店
                $infos[$value[1]][1][$value[6]][$value[7]][$value[8]] = $value;      //总系统下Sku下某个活动的门店

                $infos[$value[1]][$value[2]][$value[4]][$value[7]][$value[8]] = $value;      //系统大类下品类下某个活动的门店
                $infos[$value[1]][$value[2]][$value[5]][$value[7]][$value[8]] = $value;      //系统大类下品牌下某个活动的门店
                $infos[$value[1]][$value[2]][$value[6]][$value[7]][$value[8]] = $value;      //系统大类下Sku下某个活动的门店

                $infos[$value[1]][$value[3]][$value[4]][$value[7]][$value[8]] = $value;      //系统名称下品类下某个活动的门店
                $infos[$value[1]][$value[3]][$value[5]][$value[7]][$value[8]] = $value;      //系统名称下品牌下某个活动的门店
                $infos[$value[1]][$value[3]][$value[6]][$value[7]][$value[8]] = $value;      //系统名称下Sku下某个活动的门店

                //可乐必备品分子
                //全国
                $must_infos[1][1][80][$value[7]][$value[8]] = $value;      //总系统下可乐必备品下某个活动(或某个设备)的门店
                $must_infos[1][$value[2]][80][$value[7]][$value[8]] = $value;      //系统大类下可乐必备品下某个活动(或某个设备)的门店
                $must_infos[1][$value[3]][80][$value[7]][$value[8]] = $value;      //系统名称下可乐必备品下某个活动的门店
                //全部
                $must_infos[$value[0]][1][80][$value[7]][$value[8]] = $value;      //总系统下可乐必备品下某个活动的门店
                $must_infos[$value[0]][$value[2]][80][$value[7]][$value[8]] = $value;      //系统大类下可乐必备品下某个活动的门店
                $must_infos[$value[0]][$value[3]][80][$value[7]][$value[8]] = $value;      //系统名称下可乐必备品下某个活动的门店
                //装瓶厂
                $must_infos[$value[1]][1][80][$value[7]][$value[8]] = $value;      //总系统下可乐必备品下某个活动的门店
                $must_infos[$value[1]][$value[2]][80][$value[7]][$value[8]] = $value;      //系统大类下可乐必备品下某个活动的门店
                $must_infos[$value[1]][$value[3]][80][$value[7]][$value[8]] = $value;      //系统名称下可乐必备品下某个活动的门店
            }
            //分母
            //全国
            $denominator[1][1][$value[4]][$value[8]] = $value; //总系统下品类门店
            $denominator[1][1][$value[5]][$value[8]] = $value; //总系统下品牌门店
            $denominator[1][1][$value[6]][$value[8]] = $value; //总系统下sku门店

            $denominator[1][$value[2]][$value[4]][$value[8]] = $value; //系统大类下品类门店
            $denominator[1][$value[2]][$value[5]][$value[8]] = $value; //系统大类下品牌门店
            $denominator[1][$value[2]][$value[6]][$value[8]] = $value; //系统大类下sku门店

            $denominator[1][$value[3]][$value[4]][$value[8]] = $value; //系统名称品类下门店
            $denominator[1][$value[3]][$value[5]][$value[8]] = $value; //系统名称品牌下门店
            $denominator[1][$value[3]][$value[6]][$value[8]] = $value; //系统名称Sku下门店

            //全部
            $denominator[$value[0]][1][$value[4]][$value[8]] = $value; //总系统下品类门店
            $denominator[$value[0]][1][$value[5]][$value[8]] = $value; //总系统下品牌门店
            $denominator[$value[0]][1][$value[6]][$value[8]] = $value; //总系统下Sku门店

            $denominator[$value[0]][$value[2]][$value[4]][$value[8]] = $value; //系统大类下品类门店
            $denominator[$value[0]][$value[2]][$value[5]][$value[8]] = $value; //系统大类下品牌门店
            $denominator[$value[0]][$value[2]][$value[6]][$value[8]] = $value; //系统大类下Sku门店

            $denominator[$value[0]][$value[3]][$value[4]][$value[8]] = $value; //系统名称下品类门店
            $denominator[$value[0]][$value[3]][$value[5]][$value[8]] = $value; //系统名称下品牌门店
            $denominator[$value[0]][$value[3]][$value[6]][$value[8]] = $value; //系统名称下Sku门店

            //装瓶厂
            $denominator[$value[1]][1][$value[4]][$value[8]] = $value; //总系统下品类门店
            $denominator[$value[1]][1][$value[5]][$value[8]] = $value; //总系统下品牌门店
            $denominator[$value[1]][1][$value[6]][$value[8]] = $value; //总系统下Sku门店

            $denominator[$value[1]][$value[2]][$value[4]][$value[8]] = $value; //系统大类下品类门店
            $denominator[$value[1]][$value[2]][$value[5]][$value[8]] = $value; //系统大类下品牌门店
            $denominator[$value[1]][$value[2]][$value[6]][$value[8]] = $value; //系统大类下Sku门店

            $denominator[$value[1]][$value[3]][$value[4]][$value[8]] = $value; //系统名称下品类门店
            $denominator[$value[1]][$value[3]][$value[5]][$value[8]] = $value; //系统名称下品牌门店
            $denominator[$value[1]][$value[3]][$value[6]][$value[8]] = $value; //系统名称下Sku门店
            //可乐必备品分母
            //全国
            $must_denominator[1][1][80][$value[8]] = $value; //总系统下可乐必备品门店
            $must_denominator[1][$value[2]][80][$value[8]] = $value; //系统大类下可乐必备品门店
            $must_denominator[1][$value[3]][80][$value[8]] = $value; //系统名称可乐必备品下门店
            //全部
            $must_denominator[$value[0]][1][80][$value[8]] = $value; //总系统下可乐必备品门店
            $must_denominator[$value[0]][$value[2]][80][$value[8]] = $value; //系统大类下可乐必备品门店
            $must_denominator[$value[0]][$value[3]][80][$value[8]] = $value; //系统名称下可乐必备品门店
            //装瓶厂
            $must_denominator[$value[1]][1][80][$value[8]] = $value; //总系统下可乐必备品门店
            $must_denominator[$value[1]][$value[2]][80][$value[8]] = $value; //系统大类下可乐必备品门店
            $must_denominator[$value[1]][$value[3]][80][$value[8]] = $value; //系统名称下可乐必备品门店
        }
        if ($type == 'infos') {
            return $infos;
        } elseif ($type == 'must_infos') {
            return $must_infos;
        } elseif ($type == 'must_denominator') {
            return $must_denominator;
        } elseif ($type == 'must_mechanism') {
            return $must_mechanism;
        } elseif ($type == 'mechanism') {
            return $mechanism;
        } else {
            return $denominator;
        }
    }

    public static function shelfNumberCount($params, $denominator, $olddata = '')
    {
        $groupData = $olddata;
        foreach (array_keys($params) as $group) {    //区域
            foreach (array_keys($params[$group]) as $items) {   //渠道
                if ($items != null) {
                    foreach (array_keys($params[$group][$items]) as $list) {   //产品
                        foreach (array_keys($params[$group][$items][$list]) as $shelf) {   //
//                        pd($denominator[$group][$items][$shelf]);
                            $groupData[$group][$items][$list][$shelf] = $params[$group][$items][$list][$shelf] / count($denominator[$group][$items][$list][$shelf]);
                        }
                    }
                }
            }
        }
        return $groupData;
    }

    public static function lastPercent($params, $Lastinfo)
    {
        $gradient = [];
        foreach (array_keys($params) as $group) {   //全部
            foreach (array_keys($params[$group]) as $system) {   //渠道
                foreach (array_keys($params[$group][$system]) as $list) {   //产品
                    foreach (array_keys($params[$group][$system][$list]) as $shelf) {   //货架(促销机制、活动、设备等)
                        if ($shelf != 0) {
                            if (isset($Lastinfo[$group][$system][$list][$shelf])) {
                                $gradient[$group][$system][$list][$shelf] = $params[$group][$system][$list][$shelf] - $Lastinfo[$group][$system][$list][$shelf];
                            } else {
                                $gradient[$group][$system][$list][$shelf] = $params[$group][$system][$list][$shelf] - 0;    //如果本期存在的数据，上期不存在，就让本期-0
                            }
                        }
                    }
                }
            }
        }
        return $gradient;
    }

    public static function lastChange($params, $Lastinfo)
    {
        $gradient = [];
        foreach (array_keys($params) as $group) {   //全部
            foreach (array_keys($params[$group]) as $system) {   //渠道
                foreach (array_keys($params[$group][$system]) as $list) {   //产品
                    foreach (array_keys($params[$group][$system][$list]) as $shelf) {   //货架
                        if ($shelf != 0) {
                            if (isset($Lastinfo[$group][$system][$list][$shelf]) && ($Lastinfo[$group][$system][$list][$shelf] != 0)) { //分母不为0
                                $gradient[$group][$system][$list][$shelf] = (($params[$group][$system][$list][$shelf] - $Lastinfo[$group][$system][$list][$shelf]) / $Lastinfo[$group][$system][$list][$shelf]);
                            } else {
                                $gradient[$group][$system][$list][$shelf] = 0;
                            }
                        }
                    }
                }
            }
        }
        return $gradient;
    }

    public static function lastCurrent($params, $type = '')
    {
        $info = $gradient = [];
        foreach ($params as $value) {
            switch ($type) {
                case 'activity':    //活动发生率
                    $list = $value->activity;
                    $index = $value->thematic_activity;
                    break;
                case 'distributionStores':   //铺货门店数
                    $list = $value->shelves;
                    $index = $value->distribution_stores;
                    break;
                case 'shelfNumber':      //店均货架门店数
                    $list = $value->shelves;
                    $index = $value->shelf_number;
                    break;
                case 'promotion':   //促销店次占比
                    $list = $value->mechanism;
                    $index = $value->promotion;
                    break;
                case 'equipmentSales':   //设备卖进率
                    $list = $value->equipment;
                    $index = $value->equipment_sales;
                    break;
                case 'sovi':   //排面占比
                    $list = $value->shelves;
                    $index = $value->sovi;
                    break;
                case 'extraDisplays':   //额外二次陈列
                    $list = $value->extraSku;
                    $index = $value->extra_displays;
                    break;
                case 'extraStores':    //二次陈列门店数
                    $list = $value->extraSku;
                    $index = $value->extra_stores;
                    break;
                case 'lastFreezerShop' : //可口可乐冰柜店均门数
                    $list = $value->equipment;
                    $index = $value->freezer_shop;
                    break;
                default:    //铺货率
                    $list = $value->shelves;
                    $index = $value->distribution;
                    break;
            }
            $info[] = array($value->time, $value->stage, $value->relationship_id, $value->system_id, $value->sku_id, $list, $index);
        }
        foreach ($info as $value) {
            $gradient[$value[2]][$value[3]][$value[4]][$value[5]] = $value[6];
        }
        return $gradient;
    }

    public static function soviCount($data, $denominator, $olddata = [], $cateShelf = '')
    {
        $groupData = $olddata;
        foreach (array_keys($data) as $group) {   //全部
            foreach (array_keys($data[$group]) as $items) {   //渠道
                if ($items != null) {     //渠道的系统类别可能为空
                    foreach (array_keys($data[$group][$items]) as $list) {   //产品
                        $a = [146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161];
                        if ($list != null && !in_array($list, $a)) {
                            $b = [1, 2, 3, 4, 5, 6, 7, 119, 125];
                            if (in_array($list, $b)) {   //品类
                                foreach (array_keys($data[$group][$items][$list]) as $shelf) {   //货架
                                    if ($cateShelf[$group][$items][$shelf] == 0) {
                                        $groupData[$group][$items][$list][$shelf] = 0;
                                    } else {
                                        $groupData[$group][$items][$list][$shelf] = $data[$group][$items][$list][$shelf] / $cateShelf[$group][$items][$shelf];
                                    }
                                }
                            } else {   //品牌，sku
                                foreach (array_keys($data[$group][$items][$list]) as $shelf) {   //货架
                                    if ($denominator[$group][$items][$list][$shelf] == 0) {
                                        $groupData[$group][$items][$list][$shelf] = 0;
                                    } else {
                                        $groupData[$group][$items][$list][$shelf] = $data[$group][$items][$list][$shelf] / $denominator[$group][$items][$list][$shelf];
                                    }
                                }
                            }

                        }
                    }
                }
            }
        }
//        pd($groupData1);
        return $groupData;
    }

    public static function transit($params, $type = '')
    {
        $infos = [];
        for ($i = 1; $i <= 4; $i++) {
            $infos = self::countParams($params, $infos, $i, $type);
        }
        return $infos;
    }

    private function countParams($params, $infos, $sum, $type)
    {
        foreach ($params as $value) {
            if ($value[($sum + 6)] > 0) {
                if ($type == 'other') {
                    //全国
                    $infos[1][1][$value[4]][$sum][$value[11]] = $value;   //总系统品类门店去重
                    $infos[1][1][$value[5]][$sum][$value[11]] = $value;   //总系统品牌门店去重
                    $infos[1][1][$value[6]][$sum][$value[11]] = $value;   //总系统Sku门店去重

                    $infos[1][$value[2]][$value[4]][$sum][$value[11]] = $value;   //系统大类下品类门店去重
                    $infos[1][$value[2]][$value[5]][$sum][$value[11]] = $value;   //系统大类品牌门店去重
                    $infos[1][$value[2]][$value[6]][$sum][$value[11]] = $value;   //系统大类Sku门店去重

                    $infos[1][$value[3]][$value[4]][$sum][$value[11]] = $value;   //系统名称下品类门店去重
                    $infos[1][$value[3]][$value[5]][$sum][$value[11]] = $value;   //系统名称品牌门店去重
                    $infos[1][$value[3]][$value[6]][$sum][$value[11]] = $value;   //系统名称Sku门店去重

                    //全部
                    $infos[$value[0]][1][$value[4]][$sum][$value[11]] = $value;   //总系统品类门店去重
                    $infos[$value[0]][1][$value[5]][$sum][$value[11]] = $value;   //总系统品牌门店去重
                    $infos[$value[0]][1][$value[6]][$sum][$value[11]] = $value;   //总系统Sku门店去重

                    $infos[$value[0]][$value[2]][$value[4]][$sum][$value[11]] = $value;   //系统大类下品类门店去重
                    $infos[$value[0]][$value[2]][$value[5]][$sum][$value[11]] = $value;   //系统大类品牌门店去重
                    $infos[$value[0]][$value[2]][$value[6]][$sum][$value[11]] = $value;   //系统大类Sku门店去重

                    $infos[$value[0]][$value[3]][$value[4]][$sum][$value[11]] = $value;   //系统名称下品类门店去重
                    $infos[$value[0]][$value[3]][$value[5]][$sum][$value[11]] = $value;   //系统名称品牌门店去重
                    $infos[$value[0]][$value[3]][$value[6]][$sum][$value[11]] = $value;   //系统名称Sku门店去重

                    //装瓶厂
                    $infos[$value[1]][1][$value[4]][$sum][$value[11]] = $value;   //总系统品类门店去重
                    $infos[$value[1]][1][$value[5]][$sum][$value[11]] = $value;   //总系统品牌门店去重
                    $infos[$value[1]][1][$value[6]][$sum][$value[11]] = $value;   //总系统Sku门店去重

                    $infos[$value[1]][$value[2]][$value[4]][$sum][$value[11]] = $value;   //系统大类下品类门店去重
                    $infos[$value[1]][$value[2]][$value[5]][$sum][$value[11]] = $value;   //系统大类品牌门店去重
                    $infos[$value[1]][$value[2]][$value[6]][$sum][$value[11]] = $value;   //系统大类Sku门店去重

                    $infos[$value[1]][$value[3]][$value[4]][$sum][$value[11]] = $value;   //系统名称下品类门店去重
                    $infos[$value[1]][$value[3]][$value[5]][$sum][$value[11]] = $value;   //系统名称品牌门店去重
                    $infos[$value[1]][$value[3]][$value[6]][$sum][$value[11]] = $value;   //系统名称Sku门店去重
                } elseif ($type == 'medic') {
                    if ($sum == 1) {
                        //全国
                        $infos[1][1][$value[4]][$sum][$value[11]] = $value;   //总系统品类门店不去重
                        $infos[1][1][$value[5]][$sum][$value[11]] = $value;   //总系统品牌门店不去重
                        $infos[1][1][$value[6]][$sum][$value[11]] = $value;   //总系统Sku门店不去重

                        $infos[1][$value[2]][$value[4]][$sum][$value[11]] = $value;   //系统大类下品类门店不去重
                        $infos[1][$value[2]][$value[5]][$sum][$value[11]] = $value;   //系统大类品牌门店不去重
                        $infos[1][$value[2]][$value[6]][$sum][$value[11]] = $value;   //系统大类Sku门店不去重

                        $infos[1][$value[3]][$value[4]][$sum][$value[11]] = $value;   //系统名称下品类门店不去重
                        $infos[1][$value[3]][$value[5]][$sum][$value[11]] = $value;   //系统名称品牌门店不去重
                        $infos[1][$value[3]][$value[6]][$sum][$value[11]] = $value;   //系统名称Sku门店不去重

                        //全部
                        $infos[$value[0]][1][$value[4]][$sum][$value[11]] = $value;   //总系统品类门店不去重
                        $infos[$value[0]][1][$value[5]][$sum][$value[11]] = $value;   //总系统品牌门店不去重
                        $infos[$value[0]][1][$value[6]][$sum][$value[11]] = $value;   //总系统Sku门店不去重

                        $infos[$value[0]][$value[2]][$value[4]][$sum][$value[11]] = $value;   //系统大类下品类门店不去重
                        $infos[$value[0]][$value[2]][$value[5]][$sum][$value[11]] = $value;   //系统大类品牌门店不去重
                        $infos[$value[0]][$value[2]][$value[6]][$sum][$value[11]] = $value;   //系统大类Sku门店不去重

                        $infos[$value[0]][$value[3]][$value[4]][$sum][$value[11]] = $value;   //系统名称下品类门店不去重
                        $infos[$value[0]][$value[3]][$value[5]][$sum][$value[11]] = $value;   //系统名称品牌门店不去重
                        $infos[$value[0]][$value[3]][$value[6]][$sum][$value[11]] = $value;   //系统名称Sku门店不去重

                        //装瓶厂
                        $infos[$value[1]][1][$value[4]][$sum][$value[11]] = $value;   //总系统品类门店不去重
                        $infos[$value[1]][1][$value[5]][$sum][$value[11]] = $value;   //总系统品牌门店不去重
                        $infos[$value[1]][1][$value[6]][$sum][$value[11]] = $value;   //总系统Sku门店不去重

                        $infos[$value[1]][$value[2]][$value[4]][$sum][$value[11]] = $value;   //系统大类下品类门店不去重
                        $infos[$value[1]][$value[2]][$value[5]][$sum][$value[11]] = $value;   //系统大类品牌门店不去重
                        $infos[$value[1]][$value[2]][$value[6]][$sum][$value[11]] = $value;   //系统大类Sku门店不去重

                        $infos[$value[1]][$value[3]][$value[4]][$sum][$value[11]] = $value;   //系统名称下品类门店不去重
                        $infos[$value[1]][$value[3]][$value[5]][$sum][$value[11]] = $value;   //系统名称品牌门店不去重
                        $infos[$value[1]][$value[3]][$value[6]][$sum][$value[11]] = $value;   //系统名称Sku门店不去重
                    }
                } elseif ($type == 'koStore') {
                    //全国
                    $infos[1][1][80][$sum][$value[11]] = $value;   //总系统可乐必备品去重
                    $infos[1][$value[2]][80][$sum][$value[11]] = $value;   //系统大类可乐必备品去重
                    $infos[1][$value[3]][80][$sum][$value[11]] = $value;   //系统名称下可乐必备品去重

                    //全部
                    $infos[$value[0]][1][80][$sum][$value[11]] = $value;   //总系统可乐必备品去重
                    $infos[$value[0]][$value[2]][80][$sum][$value[11]] = $value;   //系统大类下可乐必备品去重
                    $infos[$value[0]][$value[3]][80][$sum][$value[11]] = $value;   //系统名称下可乐必备品去重

                    //装瓶厂
                    $infos[$value[1]][1][80][$sum][$value[11]] = $value;   //总系统可乐必备品去重
                    $infos[$value[1]][$value[2]][80][$sum][$value[11]] = $value;   //系统大类下可乐必备品去重
                    $infos[$value[1]][$value[3]][80][$sum][$value[11]] = $value;   //系统名称下可乐必备品去重
                } elseif ($type == 'medic1') {
                    if ($sum != 1) {
                        //全国
                        $infos[1][1][$value[4]][$sum][$value[11]] = $value;   //总系统品类门店去重
                        $infos[1][1][$value[5]][$sum][$value[11]] = $value;   //总系统品牌门店去重
                        $infos[1][1][$value[6]][$sum][$value[11]] = $value;   //总系统Sku门店去重

                        $infos[1][$value[2]][$value[4]][$sum][$value[11]] = $value;   //系统大类下品类门店去重
                        $infos[1][$value[2]][$value[5]][$sum][$value[11]] = $value;   //系统大类品牌门店去重
                        $infos[1][$value[2]][$value[6]][$sum][$value[11]] = $value;   //系统大类Sku门店去重

                        $infos[1][$value[3]][$value[4]][$sum][$value[11]] = $value;   //系统名称下品类门店去重
                        $infos[1][$value[3]][$value[5]][$sum][$value[11]] = $value;   //系统名称品牌门店去重
                        $infos[1][$value[3]][$value[6]][$sum][$value[11]] = $value;   //系统名称Sku门店去重

                        //全部
                        $infos[$value[0]][1][$value[4]][$sum][$value[11]] = $value;   //总系统品类门店去重
                        $infos[$value[0]][1][$value[5]][$sum][$value[11]] = $value;   //总系统品牌门店去重
                        $infos[$value[0]][1][$value[6]][$sum][$value[11]] = $value;   //总系统Sku门店去重

                        $infos[$value[0]][$value[2]][$value[4]][$sum][$value[11]] = $value;   //系统大类下品类门店去重
                        $infos[$value[0]][$value[2]][$value[5]][$sum][$value[11]] = $value;   //系统大类品牌门店去重
                        $infos[$value[0]][$value[2]][$value[6]][$sum][$value[11]] = $value;   //系统大类Sku门店去重

                        $infos[$value[0]][$value[3]][$value[4]][$sum][$value[11]] = $value;   //系统名称下品类门店去重
                        $infos[$value[0]][$value[3]][$value[5]][$sum][$value[11]] = $value;   //系统名称品牌门店去重
                        $infos[$value[0]][$value[3]][$value[6]][$sum][$value[11]] = $value;   //系统名称Sku门店去重

                        //装瓶厂
                        $infos[$value[1]][1][$value[4]][$sum][$value[11]] = $value;   //总系统品类门店去重
                        $infos[$value[1]][1][$value[5]][$sum][$value[11]] = $value;   //总系统品牌门店去重
                        $infos[$value[1]][1][$value[6]][$sum][$value[11]] = $value;   //总系统Sku门店去重

                        $infos[$value[1]][$value[2]][$value[4]][$sum][$value[11]] = $value;   //系统大类下品类门店去重
                        $infos[$value[1]][$value[2]][$value[5]][$sum][$value[11]] = $value;   //系统大类品牌门店去重
                        $infos[$value[1]][$value[2]][$value[6]][$sum][$value[11]] = $value;   //系统大类Sku门店去重

                        $infos[$value[1]][$value[3]][$value[4]][$sum][$value[11]] = $value;   //系统名称下品类门店去重
                        $infos[$value[1]][$value[3]][$value[5]][$sum][$value[11]] = $value;   //系统名称品牌门店去重
                        $infos[$value[1]][$value[3]][$value[6]][$sum][$value[11]] = $value;   //系统名称Sku门店去重
                    }
                } elseif ($type == 'koMust') {
                    if ($sum == 1) {
                        //全国
                        $infos[1][1][80][$sum][] = $value;   //总系统可乐必备品不去重(铺货率)
                        $infos[1][$value[2]][80][$sum][] = $value;   //系统大类可乐必备品不去重(铺货率)
                        $infos[1][$value[3]][80][$sum][] = $value;   //系统类别下可乐必备品不去重(铺货率)
                        $infos[1][$value[4]][80][$sum][] = $value;   //系统名称下可乐必备品不去重(铺货率)

                        //全部
                        $infos[$value[0]][1][80][$sum][] = $value;   //总系统可乐必备品不去重(铺货率)
                        $infos[$value[0]][$value[2]][80][$sum][] = $value;   //系统大类下可乐必备品不去重(铺货率)
                        $infos[$value[0]][$value[3]][80][$sum][] = $value;   //系统类别下可乐必备品不去重(铺货率)
                        $infos[$value[0]][$value[4]][80][$sum][] = $value;   //系统名称下可乐必备品不去重(铺货率)

                        //装瓶厂
                        $infos[$value[1]][1][80][$sum][] = $value;   //总系统可乐必备品不去重(铺货率)
                        $infos[$value[1]][$value[2]][80][$sum][] = $value;   //系统大类下可乐必备品不去重(铺货率)
                        $infos[$value[1]][$value[3]][80][$sum][] = $value;   //系统类别下可乐必备品不去重(铺货率)
                        $infos[$value[1]][$value[4]][80][$sum][] = $value;   //系统名称下可乐必备品不去重(铺货率)
                    }
                } elseif ($type == 'koMust1') {
                    if ($sum != 1) {
                        //全国
                        $infos[1][1][80][$sum][$value[9]] = $value;   //总系统可乐必备品去重(铺货率)
                        $infos[1][$value[2]][80][$sum][$value[9]] = $value;   //系统大类可乐必备品去重(铺货率)
                        $infos[1][$value[3]][80][$sum][$value[9]] = $value;   //系统类别下可乐必备品去重(铺货率)
                        $infos[1][$value[4]][80][$sum][$value[9]] = $value;   //系统名称下可乐必备品去重(铺货率)
                        //全部
                        $infos[$value[0]][1][80][$sum][$value[9]] = $value;   //总系统可乐必备品去重(铺货率)
                        $infos[$value[0]][$value[2]][80][$sum][$value[9]] = $value;   //系统大类下可乐必备品去重(铺货率)
                        $infos[$value[0]][$value[3]][80][$sum][$value[9]] = $value;   //系统类别下可乐必备品去重(铺货率)
                        $infos[$value[0]][$value[4]][80][$sum][$value[9]] = $value;   //系统名称下可乐必备品去重(铺货率)
                        //装瓶厂
                        $infos[$value[1]][1][80][$sum][$value[9]] = $value;   //总系统可乐必备品去重(铺货率)
                        $infos[$value[1]][$value[2]][80][$sum][$value[9]] = $value;   //系统大类下可乐必备品去重(铺货率)
                        $infos[$value[1]][$value[3]][80][$sum][$value[9]] = $value;   //系统类别下可乐必备品去重(铺货率)
                        $infos[$value[1]][$value[4]][80][$sum][$value[9]] = $value;   //系统名称下可乐必备品去重(铺货率)
                    }
                } else {
                    //全国
                    $infos[1][1][80][$sum][] = $value;   //总系统可乐必备品不去重(铺货率)
                    $infos[1][$value[2]][80][$sum][] = $value;   //系统大类可乐必备品不去重(铺货率)
                    $infos[1][$value[3]][80][$sum][] = $value;   //系统类别下可乐必备品不去重(铺货率)
                    $infos[1][$value[4]][80][$sum][] = $value;   //系统名称下可乐必备品不去重(铺货率)

                    //全部
                    $infos[$value[0]][1][80][$sum][] = $value;   //总系统可乐必备品不去重(铺货率)
                    $infos[$value[0]][$value[2]][80][$sum][] = $value;   //系统大类下可乐必备品不去重(铺货率)
                    $infos[$value[0]][$value[3]][80][$sum][] = $value;   //系统类别下可乐必备品不去重(铺货率)
                    $infos[$value[0]][$value[4]][80][$sum][] = $value;   //系统名称下可乐必备品不去重(铺货率)

                    //装瓶厂
                    $infos[$value[1]][1][80][$sum][] = $value;   //总系统可乐必备品不去重(铺货率)
                    $infos[$value[1]][$value[2]][80][$sum][] = $value;   //系统大类下可乐必备品不去重(铺货率)
                    $infos[$value[1]][$value[3]][80][$sum][] = $value;   //系统类别下可乐必备品不去重(铺货率)
                    $infos[$value[1]][$value[4]][80][$sum][] = $value;   //系统名称下可乐必备品不去重(铺货率)
                }

            }
        }
        return $infos;
    }

    public static function stores($prams, $olddata = [])
    {
        $groupData = $olddata;
        foreach (array_keys($prams) as $group) {   //区域
            foreach (array_keys($prams[$group]) as $items) {   //渠道
                if ($items != null) {
                    foreach (array_keys($prams[$group][$items]) as $list) {
//                    $groupData[$group][$items][$list][] = count($prams[$group][$items][$list]);
                        foreach (array_keys($prams[$group][$items][$list]) as $li) {
                            $groupData[$group][$items][$list][$li] = count($prams[$group][$items][$list][$li]);
                        }
                    }
                }
            }
        }
        return $groupData;
    }

    public static function list_data($prams, $type = '')
    {
        $info = [];
        foreach ($prams as $value) {
            if ($type == 'other') {
                if ($value->classes != '其他' && $value->classes != '可乐其他' && $value->classes != 'KOMHSKU') {
                    $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                        $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->full_surface,
                        $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
                }
            } elseif ($type == 'koSku') {
                if ($value->classes == 'KUMHSKU') {
                    $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                        $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->full_surface,
                        $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
                }
            } else {
                if ($value->classes == '可乐必备品') {
                    $info[] = array($value->blocs->Id, $value->factorys->Id, $value->system_cates->Id,
                        $value->system_names->Id, $value->categorys->Id, $value->brands->Id, $value->skus->Id, $value->full_surface,
                        $value->normal_surface, $value->refrigeration_surface, $value->warm_surface, $value->store_id);
                }
            }

        }
//        pd($info);
        return $info;
    }

    public static function broadHeading($molecule, $denominator, $olddata = [], $type)
    {
        $groupData = $olddata;
        foreach (array_keys($molecule) as $group) {
            foreach (array_keys($molecule[$group]) as $items) {
                if ($items != null) {
                    foreach (array_keys($molecule[$group][$items]) as $list) {
                        $a = [146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161];
                        if ($list != null && !in_array($list, $a)) {
                            foreach (array_keys($molecule[$group][$items][$list]) as $shelf) {
                                if ($type == 'other') {
                                    $groupData[$group][$items][$list][$shelf] = count($molecule[$group][$items][$list][$shelf]) / count($denominator[$group][$items][$shelf]);
                                } else {
                                    $groupData[$group][$items][$list][$shelf] = count($molecule[$group][$items][$list][$shelf]) / count($denominator[$group][$items][$list][$shelf]);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $groupData;
    }

    public static function adc($params, $type = '')
    {
        $infos = [];
        for ($i = 1; $i <= 4; $i++) {
            $infos = self::countAdc($params, $infos, $i, $type);
        }
        return $infos;
    }

    private function countAdc($params, $infos, $sum, $type = '')
    {
        foreach ($params as $v) {
            if ($type == 'other') {
                if ($v[($sum + 6)] > 0) {
                    //全国
                    $infos[1][1][$v[4]][$sum][$v[11]] = $v;   //总系统品类分母去重
                    $infos[1][1][$v[5]][$sum][$v[11]] = $v;   //总系统品牌分母去重
                    $infos[1][1][$v[6]][$sum][$v[11]] = $v;   //总系统sku分母去重

                    $infos[1][$v[2]][$v[4]][$sum][$v[11]] = $v;   //系统大类品类分母去重
                    $infos[1][$v[2]][$v[5]][$sum][$v[11]] = $v;   //系统大类品牌分母去重
                    $infos[1][$v[2]][$v[6]][$sum][$v[11]] = $v;   //系统大类Sku分母去重

                    $infos[1][$v[3]][$v[4]][$sum][$v[11]] = $v;   //系统名称品类分母去重
                    $infos[1][$v[3]][$v[5]][$sum][$v[11]] = $v;   //系统名称品牌分母去重
                    $infos[1][$v[3]][$v[6]][$sum][$v[11]] = $v;   //系统名称Sku分母去重

                    //全部
                    $infos[$v[0]][1][$v[4]][$sum][$v[11]] = $v;   //总系统品类分母去重
                    $infos[$v[0]][1][$v[5]][$sum][$v[11]] = $v;   //总系统品牌分母去重
                    $infos[$v[0]][1][$v[6]][$sum][$v[11]] = $v;   //总系统sku分母去重

                    $infos[$v[0]][$v[2]][$v[4]][$sum][$v[11]] = $v;   //系统大类品类分母去重
                    $infos[$v[0]][$v[2]][$v[5]][$sum][$v[11]] = $v;   //系统大类品牌分母去重
                    $infos[$v[0]][$v[2]][$v[6]][$sum][$v[11]] = $v;   //系统大类sku分母去重

                    $infos[$v[0]][$v[3]][$v[4]][$sum][$v[11]] = $v;   //系统名称品类分母去重
                    $infos[$v[0]][$v[3]][$v[5]][$sum][$v[11]] = $v;   //系统名称品牌分母去重
                    $infos[$v[0]][$v[3]][$v[6]][$sum][$v[11]] = $v;   //系统名称Sku分母去重

                    //装瓶厂
                    $infos[$v[1]][1][$v[4]][$sum][$v[11]] = $v;   //总系统品类分母去重
                    $infos[$v[1]][1][$v[5]][$sum][$v[11]] = $v;   //总系统品牌分母去重
                    $infos[$v[1]][1][$v[6]][$sum][$v[11]] = $v;   //总系统Sku分母去重

                    $infos[$v[1]][$v[2]][$v[4]][$sum][$v[11]] = $v;   //系统大类品类分母去重
                    $infos[$v[1]][$v[2]][$v[5]][$sum][$v[11]] = $v;   //系统大类品牌分母去重
                    $infos[$v[1]][$v[2]][$v[6]][$sum][$v[11]] = $v;   //系统大类Sku分母去重

                    $infos[$v[1]][$v[3]][$v[4]][$sum][$v[11]] = $v;   //系统名称品类分母去重
                    $infos[$v[1]][$v[3]][$v[5]][$sum][$v[11]] = $v;   //系统名称品牌分母去重
                    $infos[$v[1]][$v[3]][$v[6]][$sum][$v[11]] = $v;   //系统名称Sku分母去重
                }
            } elseif ($type == 'medic') {
                if ($sum == 1) {
                    //全国
                    $infos[1][1][$v[4]][$sum][$v[11]] = $v;   //总系统品类门店不去重
                    $infos[1][1][$v[5]][$sum][$v[11]] = $v;   //总系统品牌门店不去重
                    $infos[1][1][$v[6]][$sum][$v[11]] = $v;   //总系统Sku门店不去重

                    $infos[1][$v[2]][$v[4]][$sum][$v[11]] = $v;   //系统大类下品类门店不去重
                    $infos[1][$v[2]][$v[5]][$sum][$v[11]] = $v;   //系统大类品牌门店不去重
                    $infos[1][$v[2]][$v[6]][$sum][$v[11]] = $v;   //系统大类Sku门店不去重

                    $infos[1][$v[3]][$v[4]][$sum][$v[11]] = $v;   //系统名称下品类门店不去重
                    $infos[1][$v[3]][$v[5]][$sum][$v[11]] = $v;   //系统名称品牌门店不去重
                    $infos[1][$v[3]][$v[6]][$sum][$v[11]] = $v;   //系统名称Sku门店不去重

                    //全部
                    $infos[$v[0]][1][$v[4]][$sum][$v[11]] = $v;   //总系统品类门店不去重
                    $infos[$v[0]][1][$v[5]][$sum][$v[11]] = $v;   //总系统品牌门店不去重
                    $infos[$v[0]][1][$v[6]][$sum][$v[11]] = $v;   //总系统Sku门店不去重

                    $infos[$v[0]][$v[2]][$v[4]][$sum][$v[11]] = $v;   //系统大类下品类门店不去重
                    $infos[$v[0]][$v[2]][$v[5]][$sum][$v[11]] = $v;   //系统大类品牌门店不去重
                    $infos[$v[0]][$v[2]][$v[6]][$sum][$v[11]] = $v;   //系统大类Sku门店不去重

                    $infos[$v[0]][$v[3]][$v[4]][$sum][$v[11]] = $v;   //系统名称下品类门店不去重
                    $infos[$v[0]][$v[3]][$v[5]][$sum][$v[11]] = $v;   //系统名称品牌门店不去重
                    $infos[$v[0]][$v[3]][$v[6]][$sum][$v[11]] = $v;   //系统名称Sku门店不去重

                    //装瓶厂
                    $infos[$v[1]][1][$v[4]][$sum][$v[11]] = $v;   //总系统品类门店不去重
                    $infos[$v[1]][1][$v[5]][$sum][$v[11]] = $v;   //总系统品牌门店不去重
                    $infos[$v[1]][1][$v[6]][$sum][$v[11]] = $v;   //总系统Sku门店不去重

                    $infos[$v[1]][$v[2]][$v[4]][$sum][$v[11]] = $v;   //系统大类下品类门店不去重
                    $infos[$v[1]][$v[2]][$v[5]][$sum][$v[11]] = $v;   //系统大类品牌门店不去重
                    $infos[$v[1]][$v[2]][$v[6]][$sum][$v[11]] = $v;   //系统大类Sku门店不去重

                    $infos[$v[1]][$v[3]][$v[4]][$sum][$v[11]] = $v;   //系统名称下品类门店不去重
                    $infos[$v[1]][$v[3]][$v[5]][$sum][$v[11]] = $v;   //系统名称品牌门店不去重
                    $infos[$v[1]][$v[3]][$v[6]][$sum][$v[11]] = $v;   //系统名称Sku门店不去重
                }
            } elseif ($type == 'ko_other') {
                if ($v[($sum + 6)] > 0) {
                    //全国
                    $infos[1][1][80][$sum][$v[11]] = $v;   //总系统品类分母去重
                    $infos[1][$v[2]][80][$sum][$v[11]] = $v;   //系统大类品类分母去重
                    $infos[1][$v[3]][80][$sum][$v[11]] = $v;   //系统名称品类分母去重
                    //全部
                    $infos[$v[0]][1][80][$sum][$v[11]] = $v;   //总系统品类分母去重
                    $infos[$v[0]][$v[2]][80][$sum][$v[11]] = $v;   //系统大类品类分母去重
                    $infos[$v[0]][$v[3]][80][$sum][$v[11]] = $v;   //系统名称品类分母去重
                    //装瓶厂
                    $infos[$v[1]][1][80][$sum][$v[11]] = $v;   //总系统品类分母去重
                    $infos[$v[1]][$v[2]][80][$sum][$v[11]] = $v;   //系统大类品类分母去重
                    $infos[$v[1]][$v[3]][80][$sum][$v[11]] = $v;   //系统名称品类分母去重
                }
            } elseif ($type == 'ko_Must') {
                if ($sum == 1) {
                    //全国
                    $infos[1][1][80][$sum][] = $v;   //总系统分母不去重
                    $infos[1][$v[2]][80][$sum][] = $v;   //系统大类分母不去重
                    $infos[1][$v[3]][80][$sum][] = $v;   //系统类别分母不去重
                    $infos[1][$v[4]][80][$sum][] = $v;   //系统名称分母不去重
                    //全部
                    $infos[$v[0]][1][80][$sum][] = $v;   //总系统分母不去重
                    $infos[$v[0]][$v[2]][80][$sum][] = $v;   //系统大类分母不去重
                    $infos[$v[0]][$v[3]][80][$sum][] = $v;   //系统类别分母不去重
                    $infos[$v[0]][$v[4]][80][$sum][] = $v;   //系统名称分母不去重
                    //装瓶厂
                    $infos[$v[1]][1][80][$sum][] = $v;   //总系统分母不去重
                    $infos[$v[1]][$v[2]][80][$sum][] = $v;   //系统大类分母不去重
                    $infos[$v[1]][$v[3]][80][$sum][] = $v;   //系统类别分母不去重
                    $infos[$v[1]][$v[4]][80][$sum][] = $v;   //系统名称分母不去重
                }
            } elseif ($type == 'medic1') {
                if ($sum != 1) {
                    if ($v[($sum + 6)] > 0) {
                        //全国
                        $infos[1][1][$sum][$v[11]] = $v;   //总系统品类门店去重
                        $infos[1][$v[2]][$sum][$v[11]] = $v;   //系统大类下品类门店去重
                        $infos[1][$v[3]][$sum][$v[11]] = $v;   //系统名称下品类门店去重
                        //全部
                        $infos[$v[0]][1][$sum][$v[11]] = $v;   //总系统品类门店去重
                        $infos[$v[0]][$v[2]][$sum][$v[11]] = $v;   //系统大类下品类门店去重
                        $infos[$v[0]][$v[3]][$sum][$v[11]] = $v;   //系统名称下品类门店去重
                        //装瓶厂
                        $infos[$v[1]][1][$sum][$v[11]] = $v;   //总系统品类门店去重
                        $infos[$v[1]][$v[2]][$sum][$v[11]] = $v;   //系统大类下品类门店去重
                        $infos[$v[1]][$v[3]][$sum][$v[11]] = $v;   //系统名称下品类门店去重
                    }
                }
            } elseif ($type == 'ko_Must1') {
                //全国
                $infos[1][1][$sum][$v[12]] = $v;   //总系统分母去重
                $infos[1][$v[2]][$sum][$v[12]] = $v;   //系统大类分母去重
                $infos[1][$v[3]][$sum][$v[12]] = $v;   //系统类别分母去重
                $infos[1][$v[4]][$sum][$v[12]] = $v;   //系统名称分母去重
                //全部
                $infos[$v[0]][1][$sum][$v[12]] = $v;   //总系统分母去重
                $infos[$v[0]][$v[2]][$sum][$v[12]] = $v;   //系统大类分母去重
                $infos[$v[0]][$v[3]][$sum][$v[12]] = $v;   //系统类别分母去重
                $infos[$v[0]][$v[4]][$sum][$v[12]] = $v;   //系统名称分母去重
                //装瓶厂
                $infos[$v[1]][1][$sum][$v[12]] = $v;   //总系统分母去重
                $infos[$v[1]][$v[2]][$sum][$v[12]] = $v;   //系统大类分母去重
                $infos[$v[1]][$v[3]][$sum][$v[12]] = $v;   //系统类别分母去重
                $infos[$v[1]][$v[4]][$sum][$v[12]] = $v;   //系统名称分母去重
            } else {
                //全国
                $infos[1][1][$sum][] = $v;   //总系统分母不去重
                $infos[1][$v[2]][$sum][] = $v;   //系统大类分母不去重
                $infos[1][$v[3]][$sum][] = $v;   //系统类别分母不去重
                $infos[1][$v[4]][$sum][] = $v;   //系统名称分母不去重
                //全部
                $infos[$v[0]][1][$sum][] = $v;   //总系统分母不去重
                $infos[$v[0]][$v[2]][$sum][] = $v;   //系统大类分母不去重
                $infos[$v[0]][$v[3]][$sum][] = $v;   //系统类别分母不去重
                $infos[$v[0]][$v[4]][$sum][] = $v;   //系统名称分母不去重
                //装瓶厂
                $infos[$v[1]][1][$sum][] = $v;   //总系统分母不去重
                $infos[$v[1]][$v[2]][$sum][] = $v;   //系统大类分母不去重
                $infos[$v[1]][$v[3]][$sum][] = $v;   //系统类别分母不去重
                $infos[$v[1]][$v[4]][$sum][] = $v;   //系统名称分母不去重
            }
        }
        return $infos;
    }

    public static function shelf($params, $type = '')
    {
        $infos = [];
        for ($i = 1; $i <= 4; $i++) {
            $infos = self::countShelf($params, $infos, $i, $type);
        }
        return $infos;
    }

    private function countShelf($params, $infos, $sum, $type = '')
    {
//        pd(array_sum(array_column($params,8)));
        foreach ($params as $v) {
            if ($v[($sum + 6)] > 0) {
                if ($type == 'shelfMust') {
                    //全国
                    $infos[1][1][80][$sum][] = $v;   //总系统下可乐必备品
                    $infos[1][$v[2]][80][$sum][] = $v;   //系统大类下可乐必备品
                    $infos[1][$v[3]][80][$sum][] = $v;   //系统名称下可乐必备品
                    //全部
                    $infos[$v[0]][1][80][$sum][] = $v;   //总系统下可乐必备品
                    $infos[$v[0]][$v[2]][80][$sum][] = $v;   //系统大类下可乐必备品
                    $infos[$v[0]][$v[3]][80][$sum][] = $v;   //系统名称下可乐必备品
                    //装瓶厂
                    $infos[$v[1]][1][80][$sum][] = $v;   //总系统下可乐必备品
                    $infos[$v[1]][$v[2]][80][$sum][] = $v;   //系统大类下可乐必备品
                    $infos[$v[1]][$v[3]][80][$sum][] = $v;   //系统名称下可乐必备品

                } elseif ($type == 'cateShelf') {
                    //全国
                    $infos[1][1][$sum][] = $v;   //总系统
                    $infos[1][$v[2]][$sum][] = $v;   //系统大类
                    $infos[1][$v[3]][$sum][] = $v;   //系统类别
                    $infos[1][$v[4]][$sum][] = $v;   //系统名称
                    //全部
                    $infos[$v[0]][1][$sum][] = $v;   //总系统
                    $infos[$v[0]][$v[2]][$sum][] = $v;   //系统大类
                    $infos[$v[0]][$v[3]][$sum][] = $v;   //系统类别
                    $infos[$v[0]][$v[4]][$sum][] = $v;   //系统名称
//                    //装瓶厂
                    $infos[$v[1]][1][$sum][] = $v;   //总系统
                    $infos[$v[1]][$v[2]][$sum][] = $v;   //系统大类
                    $infos[$v[1]][$v[3]][$sum][] = $v;   //系统类别
                    $infos[$v[1]][$v[4]][$sum][] = $v;   //系统名称
                } else {
                    //全国
                    $infos[1][1][$v[4]][$sum][] = $v;   //总系统下品类
                    $infos[1][1][$v[5]][$sum][] = $v;   //总系统下品牌
                    $infos[1][1][$v[6]][$sum][] = $v;   //总系统下Sku

                    $infos[1][$v[2]][$v[4]][$sum][] = $v;   //系统大类下品类
                    $infos[1][$v[2]][$v[5]][$sum][] = $v;   //系统大类下品牌
                    $infos[1][$v[2]][$v[6]][$sum][] = $v;   //系统大类下Sku

                    $infos[1][$v[3]][$v[4]][$sum][] = $v;   //系统名称下品类
                    $infos[1][$v[3]][$v[5]][$sum][] = $v;   //系统名称下品牌
                    $infos[1][$v[3]][$v[6]][$sum][] = $v;   //系统名称下Sku

                    //全部
                    $infos[$v[0]][1][$v[4]][$sum][] = $v;   //总系统下品类
                    $infos[$v[0]][1][$v[5]][$sum][] = $v;   //总系统下品牌
                    $infos[$v[0]][1][$v[6]][$sum][] = $v;   //总系统下Sku

                    $infos[$v[0]][$v[2]][$v[4]][$sum][] = $v;   //系统大类下品类
                    $infos[$v[0]][$v[2]][$v[5]][$sum][] = $v;   //系统大类下品牌
                    $infos[$v[0]][$v[2]][$v[6]][$sum][] = $v;   //系统大类下Sku

                    $infos[$v[0]][$v[3]][$v[4]][$sum][] = $v;   //系统名称下品类
                    $infos[$v[0]][$v[3]][$v[5]][$sum][] = $v;   //系统名称下品牌
                    $infos[$v[0]][$v[3]][$v[6]][$sum][] = $v;   //系统名称下Sku

                    //装瓶厂
                    $infos[$v[1]][1][$v[4]][$sum][] = $v;   //总系统下品类
                    $infos[$v[1]][1][$v[5]][$sum][] = $v;   //总系统下品牌
                    $infos[$v[1]][1][$v[6]][$sum][] = $v;   //总系统下Sku

                    $infos[$v[1]][$v[2]][$v[4]][$sum][] = $v;   //系统大类下品类
                    $infos[$v[1]][$v[2]][$v[5]][$sum][] = $v;   //系统大类下品牌
                    $infos[$v[1]][$v[2]][$v[6]][$sum][] = $v;   //系统大类下Sku

                    $infos[$v[1]][$v[3]][$v[4]][$sum][] = $v;   //系统名称下品类
                    $infos[$v[1]][$v[3]][$v[5]][$sum][] = $v;   //系统名称下品牌
                    $infos[$v[1]][$v[3]][$v[6]][$sum][] = $v;   //系统名称下Sku
                }
            }
        }
        return $infos;
    }

    public static function shelfMethod($aaa)
    {
        $aa = [];
        foreach (array_keys($aaa) as $group) {     //区域
            foreach (array_keys($aaa[$group]) as $system) {    //渠道
                if ($system != null) {
                    foreach (array_keys($aaa[$group][$system]) as $product) {   //产品
                        if ($product != null) {
                            foreach (array_keys($aaa[$group][$system][$product]) as $shelf) { //货架
                                $aa[$group][$system][$product][$shelf] = 0;
                                foreach (array_keys($aaa[$group][$system][$product][$shelf]) as $count) {  //多个门店数组
                                    if ($shelf == 1) {
                                        //$aa[$group][$system][$product][$shelf]['count'] = (isset($aa[$group][$system][$product][$shelf]['count'])?$aa[$group][$system][$product][$shelf]['count']:0)+$aaa[$group][$system][$product][$shelf][$count][8];
                                        $aa[$group][$system][$product][$shelf] += $aaa[$group][$system][$product][$shelf][$count][8];
                                    }
                                    if ($shelf == 2) {
                                        $aa[$group][$system][$product][$shelf] += $aaa[$group][$system][$product][$shelf][$count][9];
                                    }
                                    if ($shelf == 3) {
                                        $aa[$group][$system][$product][$shelf] += $aaa[$group][$system][$product][$shelf][$count][10];
                                    }
                                    if ($shelf == 4) {
                                        $aa[$group][$system][$product][$shelf] += $aaa[$group][$system][$product][$shelf][$count][11];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
//        pd($aa);
        return $aa;
    }

    public static function infoCount($data, $type)
    {
//        pd($data);
        $infos = $denominator = $must_infos = $must_denominator = [];
        foreach ($data as $value) {
            if ($value[7] > 0) {
                //全国
                $infos[1][1][$value[4]][$value[7]][] = $value;      //总系统下品类下某个机制(或某个设备)的门店
                $infos[1][1][$value[5]][$value[7]][] = $value;      //总系统下品牌下某个机制(或某个设备)的门店
                $infos[1][1][$value[6]][$value[7]][] = $value;      //总系统下Sku下某个机制(或某个设备)的门店

                $infos[1][$value[2]][$value[4]][$value[7]][] = $value;      //系统大类下品类下某个机制(或某个设备)的门店
                $infos[1][$value[2]][$value[5]][$value[7]][] = $value;      //系统大类下品牌下某个机制(或某个设备)的门店
                $infos[1][$value[2]][$value[6]][$value[7]][] = $value;      //系统大类下Sku下某个机制(或某个设备)的门店

                $infos[1][$value[3]][$value[4]][$value[7]][] = $value;      //系统名称下品类下某个机制的门店
                $infos[1][$value[3]][$value[5]][$value[7]][] = $value;      //系统名称下品牌下某个机制的门店
                $infos[1][$value[3]][$value[6]][$value[7]][] = $value;      //系统名称下Sku下某个机制的门店

                //全部
                $infos[$value[0]][1][$value[4]][$value[7]][] = $value;      //总系统下品类下某个机制的门店
                $infos[$value[0]][1][$value[5]][$value[7]][] = $value;      //总系统下品牌下某个机制的门店
                $infos[$value[0]][1][$value[6]][$value[7]][] = $value;      //总系统下Sku下某个机制的门店

                $infos[$value[0]][$value[2]][$value[4]][$value[7]][] = $value;      //系统大类下品类下某个机制的门店
                $infos[$value[0]][$value[2]][$value[5]][$value[7]][] = $value;      //系统大类下品牌下某个机制的门店
                $infos[$value[0]][$value[2]][$value[6]][$value[7]][] = $value;      //系统大类下Sku下某个机制的门店

                $infos[$value[0]][$value[3]][$value[4]][$value[7]][] = $value;      //系统名称下品类下某个机制的门店
                $infos[$value[0]][$value[3]][$value[5]][$value[7]][] = $value;      //系统名称下品牌下某个机制的门店
                $infos[$value[0]][$value[3]][$value[6]][$value[7]][] = $value;      //系统名称下Sku下某个机制的门店
                //装瓶厂
                $infos[$value[1]][1][$value[4]][$value[7]][] = $value;      //总系统下品类下某个机制的门店
                $infos[$value[1]][1][$value[5]][$value[7]][] = $value;      //总系统下品牌下某个机制的门店
                $infos[$value[1]][1][$value[6]][$value[7]][] = $value;      //总系统下Sku下某个机制的门店

                $infos[$value[1]][$value[2]][$value[4]][$value[7]][] = $value;      //系统大类下品类下某个机制的门店
                $infos[$value[1]][$value[2]][$value[5]][$value[7]][] = $value;      //系统大类下品牌下某个机制的门店
                $infos[$value[1]][$value[2]][$value[6]][$value[7]][] = $value;      //系统大类下Sku下某个机制的门店

                $infos[$value[1]][$value[3]][$value[4]][$value[7]][] = $value;      //系统名称下品类下某个机制的门店
                $infos[$value[1]][$value[3]][$value[5]][$value[7]][] = $value;      //系统名称下品牌下某个机制的门店
                $infos[$value[1]][$value[3]][$value[6]][$value[7]][] = $value;      //系统名称下Sku下某个机制的门店

                //分母
                //全国
                $denominator[1][1][$value[4]][] = $value; //总系统下品类门店($value[9]F列重复的门店数)
                $denominator[1][1][$value[5]][] = $value; //总系统下品牌门店($value[9]F列重复的门店数)
                $denominator[1][1][$value[6]][] = $value; //总系统下sku门店($value[9]F列重复的门店数)

                $denominator[1][$value[2]][$value[4]][] = $value; //系统大类下品类门店($value[9]F列重复的门店数)
                $denominator[1][$value[2]][$value[5]][] = $value; //系统大类下品牌门店($value[9]F列重复的门店数)
                $denominator[1][$value[2]][$value[6]][] = $value; //系统大类下sku门店($value[9]F列重复的门店数)

                $denominator[1][$value[3]][$value[4]][] = $value; //系统类别下品类门店($value[9]F列重复的门店数)
                $denominator[1][$value[3]][$value[5]][] = $value; //系统类别下品牌门店($value[9]F列重复的门店数)
                $denominator[1][$value[3]][$value[6]][] = $value; //系统类别下Sku门店($value[9]F列重复的门店数)

                //全部
                $denominator[$value[0]][1][$value[4]][] = $value; //总系统下品类门店($value[9]F列重复的门店数)
                $denominator[$value[0]][1][$value[5]][] = $value; //总系统下品牌门店($value[9]F列重复的门店数)
                $denominator[$value[0]][1][$value[6]][] = $value; //总系统下Sku门店($value[9]F列重复的门店数)

                $denominator[$value[0]][$value[2]][$value[4]][] = $value; //系统大类下品类门店($value[9]F列重复的门店数)
                $denominator[$value[0]][$value[2]][$value[5]][] = $value; //系统大类下品牌门店($value[9]F列重复的门店数)
                $denominator[$value[0]][$value[2]][$value[6]][] = $value; //系统大类下Sku门店($value[9]F列重复的门店数)

                $denominator[$value[0]][$value[3]][$value[4]][] = $value; //系统类别下品类门店($value[9]F列重复的门店数)
                $denominator[$value[0]][$value[3]][$value[5]][] = $value; //系统类别下品牌门店($value[9]F列重复的门店数)
                $denominator[$value[0]][$value[3]][$value[6]][] = $value; //系统类别下Sku门店($value[9]F列重复的门店数)

                //装瓶厂
                $denominator[$value[1]][1][$value[4]][] = $value; //总系统下品类门店($value[9]F列重复的门店数)
                $denominator[$value[1]][1][$value[5]][] = $value; //总系统下品牌门店($value[9]F列重复的门店数)
                $denominator[$value[1]][1][$value[6]][] = $value; //总系统下Sku门店($value[9]F列重复的门店数)

                $denominator[$value[1]][$value[2]][$value[4]][] = $value; //系统大类下品类门店($value[9]F列重复的门店数)
                $denominator[$value[1]][$value[2]][$value[5]][] = $value; //系统大类下品牌门店($value[9]F列重复的门店数)
                $denominator[$value[1]][$value[2]][$value[6]][] = $value; //系统大类下Sku门店($value[9]F列重复的门店数)

                $denominator[$value[1]][$value[3]][$value[4]][] = $value; //系统类别下品类门店($value[9]F列重复的门店数)
                $denominator[$value[1]][$value[3]][$value[5]][] = $value; //系统类别下品牌门店($value[9]F列重复的门店数)
                $denominator[$value[1]][$value[3]][$value[6]][] = $value; //系统类别下Sku门店($value[9]F列重复的门店数)

                //可乐必备品分子
                //全国
                $must_infos[1][1][80][$value[7]][] = $value;      //总系统下可乐必备品下某个机制(或某个设备)的门店
                $must_infos[1][$value[2]][80][$value[7]][] = $value;      //系统大类下可乐必备品下某个机制(或某个设备)的门店
                $must_infos[1][$value[3]][80][$value[7]][] = $value;      //系统名称下可乐必备品下某个机制的门店
                //全部
                $must_infos[$value[0]][1][80][$value[7]][] = $value;      //总系统下可乐必备品下某个机制的门店
                $must_infos[$value[0]][$value[2]][80][$value[7]][] = $value;      //系统大类下可乐必备品下某个机制的门店
                $must_infos[$value[0]][$value[3]][80][$value[7]][] = $value;      //系统名称下可乐必备品下某个机制的门店
                //装瓶厂
                $must_infos[$value[1]][1][80][$value[7]][] = $value;      //总系统下可乐必备品下某个机制的门店
                $must_infos[$value[1]][$value[2]][80][$value[7]][] = $value;      //系统大类下可乐必备品下某个机制的门店
                $must_infos[$value[1]][$value[3]][80][$value[7]][] = $value;      //系统名称下可乐必备品下某个机制的门店

                //可乐必备品分母
                //全国
                $must_denominator[1][1][80][] = $value; //总系统下品类门店($value[9]F列重复的门店数)
                $must_denominator[1][$value[2]][80][] = $value; //系统大类下品类门店($value[9]F列重复的门店数)
                $must_denominator[1][$value[3]][80][] = $value; //系统类别下品类门店($value[9]F列重复的门店数)
                //全部
                $must_denominator[$value[0]][1][80][] = $value; //总系统下品类门店($value[9]F列重复的门店数)
                $must_denominator[$value[0]][$value[2]][80][] = $value; //系统大类下品类门店($value[9]F列重复的门店数)
                $must_denominator[$value[0]][$value[3]][80][] = $value; //系统类别下品类门店($value[9]F列重复的门店数)
                //装瓶厂
                $must_denominator[$value[1]][1][80][] = $value; //总系统下品类门店($value[9]F列重复的门店数)
                $must_denominator[$value[1]][$value[2]][80][] = $value; //系统大类下品类门店($value[9]F列重复的门店数)
                $must_denominator[$value[1]][$value[3]][80][] = $value; //系统类别下品类门店($value[9]F列重复的门店数)
            }
        }
        if ($type == 'infos') {
            return $infos;
        } elseif ($type == 'must_infos') {
            return $must_infos;
        } elseif ($type == 'must_denominator') {
            return $must_denominator;
        } else {
            return $denominator;
        }
    }

    public static function countTwo($infos, $denominator, $olddata = '')
    {
        $gainData = $olddata;
        foreach (array_keys($infos) as $group) {    //区域
            foreach (array_keys($infos[$group]) as $system) {   //渠道
                if ($system != null) {
                    foreach (array_keys($infos[$group][$system]) as $product) {   //产品
                        foreach (array_keys($infos[$group][$system][$product]) as $activity) {
                            $a = explode(',', $activity);
                            foreach ($a as $v) {
//                            $activityData[$group][$system][$product][$v] = isset($activityData[$group][$system][$product][$v]) ? $activityData[$group][$system][$product][$v] : 0;
//                            $activityData[$group][$system][$product][$v] += count($infos[$group][$system][$product][$activity]);
//                            pd($denominator[$group][$system]);
                                if (empty($denominator[$group][$system][$product])) {
                                    $gainData[$group][$system][$product][$v] = 0;
                                } else {
                                    if (isset($gainData[$group][$system][$product][$v])) {
                                        $gainData[$group][$system][$product][$v] += count($infos[$group][$system][$product][$activity]) / count($denominator[$group][$system][$product]);  //某个活动去除重复门店之后的门店数量
                                    } else {
                                        $gainData[$group][$system][$product][$v] = count($infos[$group][$system][$product][$activity]) / count($denominator[$group][$system][$product]);  //某个活动去除重复门店之后的门店数量
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }
        return $gainData;
    }

    public static function Coke($params)
    {
        $coke = [];
        for ($i = 1; $i <= 4; $i++) {
            foreach ($params as $v) {
                if ($v[($i + 6)] > 0) {
                    //全国
                    $coke[1][1][80][$i][] = $v;   //总系统下可乐必备品
                    $coke[1][$v[2]][80][$i][] = $v;   //系统大类下可乐必备品
                    $coke[1][$v[3]][80][$i][] = $v;   //系统名称下可乐必备品

                    //全部
                    $coke[$v[0]][1][80][$i][] = $v;   //总系统下可乐必备品
                    $coke[$v[0]][$v[2]][80][$i][] = $v;   //系统大类下可乐必备品
                    $coke[$v[0]][$v[3]][80][$i][] = $v;   //系统名称下可乐必备品

                    //装瓶厂
                    $coke[$v[1]][1][80][$i][] = $v;   //总系统下可乐必备品
                    $coke[$v[1]][$v[2]][80][$i][] = $v;   //系统大类下可乐必备品
                    $coke[$v[1]][$v[3]][80][$i][] = $v;   //系统名称下可乐必备品

                }
            }
        }
        return $coke;
    }

    /**
     * 数据插入
     * @param $data
     * @param $time
     * @param $stage
     * @param $index
     * @param $type
     *
     *
     */
    public static function indexInsert($data, $time, $stage, $index = '', $type = '')
    {
        $infos = self::useManager($data, $time, $stage, $index, $type);
        $t9 = microtime(true);
        $arr = array_chunk($infos, 1000);
        unset($infos, $data);
        $label = array('time', 'stage', 'relationship_id', 'system_id', 'sku_id', $type, $index);
        for ($i = 0; $i < count($arr); $i++) {
//            pd($arr);
            self::useInsert('cola_info_cvs', $label, $arr[$i]);
        }
        $t8 = microtime(true);
        $t10 = round($t8 - $t9, 3);
        //Yii::log("二三次查询+数据插入的时间：".$t10,'warning');
    }

    public static function strcomp($str1, $str2)
    {
        if ($str1 == $str2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $form
     * @param array $field
     * @param array $value
     * @return bool
     */
    public static function useInsert($form = '', $field = array(), $value = array())
    {
        $listUpdate = $list = $listCvs = [];
        if (empty($form) || empty($field) || empty($value)) {
            return false;
        }
        $z1 = microtime(true);
        foreach ($value as $k => $v) {
            $tab = ['shelves' => 1, 'activity' => 16, 'mechanism' => 6, 'equipment' => 4, 'extraSku' => 1];
            $collect = InfoCvs::model()->find('time = "' . $v[0] . '" and stage = ' . $v[1] . ' and relationship_id = ' . $v[2] . ' and system_id = ' . $v[3] . '
            and sku_id = ' . $v[4] . ' and (shelves = 1 or activity = 16 or mechanism = 6 or equipment = 4 or extraSku = 1)');
            $strcomp = self::strcomp($v[5], $tab[$field[5]]);
            if ($collect && $strcomp) {
                unset($value[$k]);
                $listUpdate[$collect['Id']] = array($field[5] => $v[5], $field[6] => $v[6]);
//                $collect->$field[5] = $v[5];
//                $collect->$field[6] = $v[6];
//                $collect->save();
            } else {
                $a = InfoCvs::model()->find('time ="' . $v[0] . '" and stage =' . $v[1] . ' and relationship_id =' . $v[2] .
                    ' and system_id = ' . $v[3] . ' and sku_id = ' . $v[4] . ' and ' . $field[5] . '= 0 and (shelves != 1 and activity != 16 and mechanism != 6 and equipment != 4 and extraSku != 1)');
                if ($a) {
                    unset($value[$k]);
                    $list[$a['Id']] = array($field[5] => $v[5], $field[6] => $v[6]);
//                    $a->$field[5] = $v[5];
//                    $a->$field[6] = $v[6];
//                    if (!$a->save()) {
//                        Yii::log('update错误信息' . current($a->getErrors())[0], 'warning');
//                    }
                }
            }
        }
        $z2 = microtime(true);
        //Yii::log("第二次、第三次修改查询时间（数组）：".round($z2-$z1,3),'warning');
        $label = array($field[5], $field[6]);
        $count = count($listUpdate);
        $pageSize = 1000;
        $times = ceil($count / 1000);  //每1000条数据分一批
        for ($i = 0; $i < $times; $i++) {
            $listCvs = array_slice($listUpdate, $i * $pageSize, $pageSize, true);
            $arrayId = array_keys($listCvs);
            self::batchUpdate('cola_info_cvs', $label, $listCvs, $arrayId);
        }

        $count1 = count($list);
        $times1 = ceil($count1 / 1000);  //每1000条数据分一批
        for ($i = 0; $i < $times1; $i++) {
            $listCvs1 = array_slice($list, $i * $pageSize, $pageSize, true);
            $arrayId1 = array_keys($listCvs1);
            self::batchUpdate('cola_info_cvs', $label, $listCvs1, $arrayId1);
        }
        $z3 = microtime(true);
        //Yii::log("第二次、第三次修改的时间：".round($z3-$z2,3),'warning');
        $field = ' ( `' . implode('`,`', $field) . '`) ';
        if (!empty($value)) {
            $sql = 'INSERT INTO ' . $form . $field . ' VALUES ';
            $valueString = '';
            foreach ($value as $k => $v) {
                $valueString .= ' ( "' . implode('","', $v) . '") ,';
            }

            $newsql = $sql . substr($valueString, 0, -1);
            Yii::app()->db->createCommand($newsql)->execute();
            $z4 = microtime(true);
            //Yii::log("数据插入的时间：".round($z4-$z3,3),'warning');
        }
    }

    /**
     * @param $data
     * @param $time
     * @param $stage
     * @param $index
     * @param $type
     * @return array
     */
    public static function useManager($data, $time, $stage, $index, $type)
    {
        $infos = $listUpdate = [];
        if (isset($type)) {
            $t3 = 0;
            foreach (array_keys($data) as $group) {   //区域
                foreach (array_keys($data[$group]) as $system) {  //渠道
                    foreach (array_keys($data[$group][$system]) as $product) {  //产品
                        foreach (array_keys($data[$group][$system][$product]) as $use) {  //排面或者活动或者机制
                            if($use != ""){
                                $t1 = microtime(true);
                                $model = InfoCvs::model()->find(array('condition' => 'time = "' . date('Y-m', $time) . '" and stage = ' . $stage . ' and relationship_id = ' . $group .
                                    ' and system_id = ' . $system . ' and sku_id = ' . $product . ' and ' . $type . ' = ' . $use,
                                    'select' => 'Id,time,stage,relationship_id,system_id,sku_id,' . $type . ',' . $index));
                                $t2 = microtime(true);
                                $t3 += round($t2 - $t1, 3);
                                if ($model) {
                                    $listUpdate[$model['Id']] = array($index => $data[$group][$system][$product][$use]);
//                                $model->$index = $data[$group][$system][$product][$use];
//                                if (!$model->save()) {
//                                    Yii::log('update错误信息' . current($model->getErrors())[0], 'warning');
//                                }
                                } else {
                                    $infos[] = array(date('Y-m', $time), $stage, $group, $system, $product, $use, $data[$group][$system][$product][$use]);
                                }
                                unset($model);
                            }
                        }
                    }
                }
            }
            unset($data);
            //Yii::log("第一次修改时查询时间时间：".$t3,'warning');
            $t7 = microtime(true);
            if ($listUpdate) {
                $label = array($index);
                $count = count($listUpdate);
                $pageSize = 1000;
                $times = ceil($count / 1000);  //每1000条数据分一批
                for ($i = 0; $i < $times; $i++) {
                    $listCvs = array_slice($listUpdate, $i * $pageSize, $pageSize, true);
                    $arrayId = array_keys($listCvs);
                    self::batchUpdate('cola_info_cvs', $label, $listCvs, $arrayId);
                }
            }
            unset($listUpdate);
            $t6 = microtime(true);
            //Yii::log("第一次修改时间：".round($t6-$t7,3),'warning');
        }
        return $infos;
    }

    /**
     * 计算一个月的值,参数（区域Id数组，当前输入的月份，多少期，货架，指标）
     * @param $relations
     * @param $time
     * @param $sum
     * @param $type
     * @param $index
     */
    public static function monthValue($relations,$time,$sum,$type,$index){
        $t1 = microtime(true);
        $info = $list = $listUpdate = [];
        foreach ($relations as $relationValue) {    //区域
            //查询本月，区域等于$relationValue的所有数据
            $system = InfoCvs::model()->findAll(array("condition" => 'time = "' . $time . '" and stage != -1 and stage != 0 and relationship_id = ' . $relationValue, 'select' => 'Id,relationship_id,system_id,sku_id,' . $type . ',' . $index,));
            foreach ($system as $skuValue) {  //渠道
                if ($skuValue->$type != 0) {
                    if (isset($info[$skuValue['relationship_id']][$skuValue['system_id']][$skuValue['sku_id']][$skuValue[$type]])) {
                        $info[$skuValue['relationship_id']][$skuValue['system_id']][$skuValue['sku_id']][$skuValue[$type]] += $skuValue[$index] / $sum;
                    } else {
                        $info[$skuValue['relationship_id']][$skuValue['system_id']][$skuValue['sku_id']][$skuValue[$type]] = $skuValue[$index] / $sum;
                    }
                }
            }
            unset($system);
        }
        foreach (array_keys($info) as $relationId) {
            foreach (array_keys($info[$relationId]) as $systemId) {
                foreach (array_keys($info[$relationId][$systemId]) as $skuId) {
                    foreach (array_keys($info[$relationId][$systemId][$skuId]) as $listId) {
                        $value = $info[$relationId][$systemId][$skuId][$listId];
                        $infoCount = InfoCvs::model()->find('time = :time and stage = 0 and relationship_id = :relation and system_id = :system and sku_id = :sku and ' . $type . ' = :' . $type,
                            array(':time' => $time, ':relation' => $relationId, ':system' => $systemId, ':sku' => $skuId, ":$type" => $listId));
                        if ($infoCount) {
//                            InfoCvs::model()->updateAll(
//                                array($index=>$info[$relationId][$systemId][$skuId][$listId]),
//                                'time = :time and stage = :stage and relationship_id = :relation and system_id = :system and sku_id = :sku and '.$type.' = :'.$type,
//                                array(':time'=>$newTime,':stage'=>$stage,':relation'=>$relationId,':system'=>$systemId,':sku'=>$skuId,":$type"=>$listId)
//                            );
                            $listUpdate[$infoCount['Id']] = array($index => $value);
                        } else {
                            $list[] = array($time, 0, $relationId, $systemId, $skuId, $listId, $value);
                        }
                        unset($infoCount);
                    }
                }
            }
        }
        unset($info);
        //先执行插入
        $arr = array_chunk($list, 1500);//每1500条插入一次数据库
        $label = array('time', 'stage', 'relationship_id', 'system_id', 'sku_id', $type, $index);
        for ($i = 0; $i < count($arr); $i++) {
            self::monthInsert('cola_info_cvs', $label, $arr[$i]);
        }
        if(!empty($listUpdate)){
            //执行修改
            $count = count($listUpdate);
            $pageSize = 1500;
            $times = ceil($count / 1500);
            $label1 = array($index);

            for ($i = 0; $i < $times; $i++) {
                $listCvs = array_slice($listUpdate, $i * $pageSize, $pageSize, true);
                $arrayId = array_keys($listCvs);
                self::batchUpdate('cola_info_cvs', $label1, $listCvs, $arrayId);
            }
            unset($listCvs, $arrayId);
        }
        unset($listUpdate);
        $t2 = microtime(true);
        Yii::log($time.$index . "月指标计算总时间：" . round($t2 - $t1, 3), 'warning');
    }

    public static function getListMonth($newTime, $type)
    {
        $relation = InfoCvs::model()->findAll(array('condition'=>'time = "'.$newTime.'" and stage != -1 and stage != 0', "index" => "$type",'select' => 'DISTINCT(' . $type . ')'));
        $relation_id = array_keys($relation);
        return $relation_id;
    }

    public static function monthInsert($form = '', $field = array(), $value = array())
    {
        $listInfo = $list = [];
        if (empty($form) || empty($field) || empty($value)) {
            return false;
        }
        foreach ($value as $k => $v) {
            $tab = ['shelves' => 1, 'activity' => 16, 'mechanism' => 6, 'equipment' => 4, 'extraSku' => 1];
            unset($collect, $info);
            $collect = InfoCvs::model()->find('time = :time and stage = :stage and relationship_id = :relation and system_id = :system and sku_id = :sku and (shelves = 1 or activity = 16 or mechanism = 6 or equipment = 4 or extraSku = 1)', array(
                ':time' => $v[0], ':stage' => $v[1], ':relation' => $v[2], ':system' => $v[3], ':sku' => $v[4]
            ));
            $strcomp = self::strcomp($v[5], $tab[$field[5]]);
            if ($collect && $strcomp) {
                unset($value[$k]);
                $listInfo[$collect['Id']] = array($field[5] => $v[5], $field[6] => $v[6]);
                unset($collect);
            } else {
                $a = InfoCvs::model()->find('time ="' . $v[0] . '" and stage =' . $v[1] . ' and relationship_id =' . $v[2] .
                    ' and system_id = ' . $v[3] . ' and sku_id = ' . $v[4] . ' and ' . $field[5] . '= 0 and (shelves != 1 and activity != 16 and mechanism != 6 and equipment != 4 and extraSku != 1)');
                if ($a) {
                    unset($value[$k]);
                    $list[$a['Id']] = array($field[5] => $v[5], $field[6] => $v[6]);
                    unset($a);
                }
            }
        }
        $label = [$field[5], $field[6]];
        $count = count($listInfo);
        $count1 = count($list);
        $pageSize = 1000;
        $times = ceil($count / 1000);
        $times1 = ceil($count1 / 1000);
        for ($i = 0; $i < $times; $i++) {
            $listCvs = array_slice($listInfo, $i * $pageSize, $pageSize, true);
            $arrayId = array_keys($listCvs);
            $log[] = self::batchUpdate('cola_info_cvs', $label, $listCvs, $arrayId);
        }
        for ($i = 0; $i < $times1; $i++) {
            $listCvs1 = array_slice($list, $i * $pageSize, $pageSize, true);
            $arrayId1 = array_keys($listCvs1);
            $log[] = self::batchUpdate('cola_info_cvs', $label, $listCvs1, $arrayId1);
        }
        $field = ' ( `' . implode('`,`', $field) . '`) ';
        if (!empty($value)) {
            $sql = 'INSERT INTO ' . $form . $field . ' VALUES ';
            $valueString = '';
            foreach ($value as $k => $v) {
                $valueString .= ' ( "' . implode('","', $v) . '") ,';
            }

            $newsql = $sql . substr($valueString, 0, -1);
            return Yii::app()->db->createCommand($newsql)->execute();
        }
    }

    /**
     * 计算月值得变化率 参数（当前输入的月份，类型（例：货架，活动，机制）的字段名，本期值的字段名，变化率的字段名）
     * @param $newTime
     * @param $type
     * @param $index
     * @param $gradient
     */
    public static function LastMonthValue($newTime, $type, $index, $gradient)
    {
        $test = InfoCvs::model()->find(array("condition" => 'time != "' . $newTime . '" and stage = 0 ', 'select' => 'time', 'order' => 'time desc'));
        $oldTime = '';
        if ($test) {
            $oldTime = isset($test['time']) ? $test['time'] : '0';
        }
        unset($test);
        $newData = InfoCvs::model()->findAll(array("condition" => 'time = "' . $newTime . '" and stage = 0 ', 'select' => 'relationship_id,system_id,sku_id,' . $type . ',' . $index,));
        $oldData = InfoCvs::model()->findAll(array("condition" => 'time = "' . $oldTime . '" and stage = 0 ', 'select' => 'relationship_id,system_id,sku_id,' . $type . ',' . $index,));

        $newInfo = self::getArray($newData, $type, $index);   //本月的数据
        $oldInfo = self::getArray($oldData, $type, $index);   //上月的数据
        unset($newData, $oldData);
        $data = $listUpdate = [];
        foreach (array_keys($newInfo) as $relation) {
            foreach (array_keys($newInfo[$relation]) as $system) {
                foreach (array_keys($newInfo[$relation][$system]) as $sku) {
                    foreach (array_keys($newInfo[$relation][$system][$sku]) as $list) {
                        if (isset($oldInfo[$relation][$system][$sku][$list])) {
                            $data[$relation][$system][$sku][$list] = round($newInfo[$relation][$system][$sku][$list] - $oldInfo[$relation][$system][$sku][$list], 15);  //本月-上月
                        } else {
                            $data[$relation][$system][$sku][$list] = round($newInfo[$relation][$system][$sku][$list] - 0, 15);  //本月-上月
                        }
                        $value = $data[$relation][$system][$sku][$list];
                        $model = InfoCvs::model()->find('time = "' . $newTime . '" and stage = 0 and relationship_id = '
                            . $relation . ' and system_id = ' . $system . ' and sku_id = ' . $sku . ' and ' . $type . ' = ' . $list);
                        if ($model) {
                            $listUpdate[$model['Id']] = array($gradient => $value);
                        }
                        unset($model, $data);
                    }
                }
            }
        }
        unset($newInfo, $oldInfo);
        $label1 = array($gradient);
        $count = count($listUpdate);
        $pageSize = 1000;
        $times = ceil($count / 1000);
        for ($i = 0; $i < $times; $i++) {
            $listCvs = array_slice($listUpdate, $i * $pageSize, $pageSize, true);
            $arrayId = array_keys($listCvs);
            self::batchUpdate('cola_info_cvs', $label1, $listCvs, $arrayId);
        }
        unset($listUpdate, $listCvs, $arrayId);
    }
}
