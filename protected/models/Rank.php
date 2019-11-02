<?php

/**
 * This is the model class for table "{{rank}}".
 *
 * The followings are the available columns in table '{{rank}}':
 * @property integer $id
 * @property string $time
 * @property integer $stage
 * @property integer $relation_id
 * @property integer $cityLevel_id
 * @property integer $system_id
 * @property integer $platform_id
 * @property integer $sku_id
 * @property integer $classify
 * @property integer $ranking
 * @property string $sku_name
 * @property string $bottle
 * @property string $sales_amount
 * @property string $last_sales_amount
 * @property integer $status
 * @property string $remark
 */
class Rank extends CActiveRecord
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
        $name = 'cola_rank_' . $this->tableName;
        $sql = 'SHOW TABLES LIKE "' . $name . '"';
        $isset = Yii::app()->db->createCommand($sql)->queryAll();
        //var_dump($isset,$name);
        if ($isset == null) {
            $this->tableName = Yii::app()->params['defaultTable1'];
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
            array('time, stage, relation_id, system_id, platform_id, sku_id, classify', 'required'),
            array('stage, relation_id, system_id, platform_id, sku_id, classify', 'numerical', 'integerOnly' => true),
            array('time', 'length', 'max' => 30),
            array('sku_name', 'length', 'max' => 100),
            array('ranking', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, time,sales_amount, stage, relation_id, system_id, platform_id, sku_id, classify, sku_name,last_sales_amount, ranking,remark,status,cityLevel_id,material,bottle', 'safe', 'on' => 'search'),
        );
    }
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
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
            'sku_id' => '品类',
            'classify' => '分类',
            'ranking' => '排名',
            'sku_name' => '名称',
            'bottle' => '瓶数',
            'sales_amount' => '销售金额',
            'last_sales_amount' => '销售金额的变化率',
            'remark' => "备注",
            'status' => '状态',
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
        $criteria->compare('time', $this->time, true);
        $criteria->compare('stage', $this->stage);
        $criteria->compare('relation_id', $this->relation_id);
        $criteria->compare('cityLevel_id', $this->cityLevel_id);
        $criteria->compare('system_id', $this->system_id);
        $criteria->compare('platform_id', $this->platform_id);
        $criteria->compare('sku_id', $this->sku_id);
        $criteria->compare('classify', $this->classify);
        $criteria->compare('sku_name', $this->sku_name, true);
        $criteria->compare('ranking', $this->ranking, true);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('bottle', $this->bottle, true);
        $criteria->compare('sales_amount', $this->sales_amount, true);
        $criteria->compare('last_sales_amount', $this->last_sales_amount, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => '10'
            )
        ));
    }
    public function  getlastMonthDays($date){
        $firstday = date("Y-m-01",strtotime($date));
        return array($firstday);
}
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Rank the static model class
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
        $name = 'cola_rank_' . $this->tableName;
        $class = get_class($this);
        $model = new $class($name, null);
        return $model;
    }
    public static function dropDown($column, $value = null) {
        $dropDownList = [
            'is_status' => [
                '1' => '正确',
                '0' => '失败',
            ],
            'is_stage' => [
                '0' => '月报/季报',
                '-1' => 'YTD',
            ],
            'is_task_status' => [
                '0' => '不执行任务',
                '1' => '执行任务',
                '-1' => '执行任务中',
            ],
            'is_classify' => Yii::app()->params['sku_classify'],
            'is_depth' => [
                '1' => '装瓶集团',
                '2' => '装瓶厂',
                '3' => '城市',
            ],
            'is_cityLevel' => [
                '0' => '空',
                '2' => 'Metro',
                '3' => 'U1',
                '4' => 'U2',
            ]
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
    public static function detectionTime()
    {
        $model = Rank::model()->findAll(array('condition' => '', 'select' => 'distinct(time)', 'order' => 'time desc', 'limit' => 10));
        $list = [];
        for ($i = 0; $i < count($model); $i++) {
            $list[$model[$i]['time']] = $model[$i]['time'];
        }
        return $list;
    }


//判断是否有变化率
    public function Kylin2MySQL($hasvs){
        if($hasvs)   {
            $this->HasChangeRate();//需改变:     1.sql请求的dt字段和切换请求数据来源的表名    2.要插入的rank表的表名    3.表中的time字段
        }
        else{
            $this->NoChangeRate();//需改变:      1.sql请求的dt字段和切换请求数据来源的表名    2.要插入的rank表的表名    3.表中的time字段
        }
    }

//    调用Kylin大数据平台的接口
    public function getRetailCurl($url, $params, $header = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//执行结果是否被返回，0是返回，1是不返回(设置获取的信息以文件流的形式返回，而不是直接输出。)
        curl_setopt($ch, CURLOPT_POST, 1);// 发送一个常规的POST请求
        curl_setopt($ch, CURLOPT_URL, $url);//要访问的地址,设置URL
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //把POST的变量加上
        if (!empty($params)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params); //设置POST的数据域
        }
        if ($header) {//头部信息
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //跳过SSL检查
        $output = curl_exec($ch);//执行并获取数据
        if ($output === false) {
            die('Curl error: ' . curl_error($ch));
        } else {
            return json_decode($output, true); //如果获得的数据时json格式的，使用json_decode函数解释成数组。如果第二个参数为true，就转为数组的形式。如果不填就为对象的形式
        }
    }
    public function addlog($log)
    {
//        $sql="insert into cola_log('log','create_at') value(".$log.",".time().")";
        $sql = 'INSERT INTO ' . $log . ' VALUES ';
        Yii::app()->db->createCommand($sql)->execute();
    }
//    插入数据库封装函数
//  $log[] = $this->batchInsert('cola_rank_2018_11_0', $label, $arr[$i]); 表名  字段名  数据（分页为2000条/次）
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
            //echo "<pre>";var_dump($value[0]);exit;
            foreach ($value as $k => $v) {
                $valueString .= ' ( "' . implode('","', $v) . '") ,';
            }
        }
        $newsql = $sql . substr($valueString, 0, -1);
//          var_dump($newsql);die;
        return Yii::app()->db->createCommand($newsql)->execute();
    }



//    无变化率的
    public function NoChangeRate()
    {
        ini_set('memory_limit','-1');
        set_time_limit('-1');//不限制执行时间
        $zpjt = Relation::model()->findAll(['condition' => 'depth=1', 'index' => 'name']); //装瓶集团，有全部
        $zpc = Relation::model()->findAll(['condition' => 'depth=2', 'index' => 'name']);//装瓶厂，没有全部
        $city = Relation::model()->findAll(['condition' => 'depth=3', 'index' => 'name']);//城市，没有全部
        $city_level = Citylevel::model()->findAll(['index' => 'name']); //城市等级，有全部
        $channel = System::model()->findAll(['index' => 'name']);//渠道，有全部
        $platform = Platform::model()->findAll(['index' => 'name']);//平台，有全部
        $category = Category::model()->findAll(['index' => 'name']);//品类，有全部
        $this->NoChangeRateCircle($city_level, $channel, $platform, $category, $zpjt, 'zpjt', 'ko');
        var_dump('Rank表中的ko-zpjt已跑完');
        $this->NoChangeRateCircle($city_level, $channel, $platform, $category, $zpjt, 'zpjt', 'compe');
        var_dump('Rank表中的compe-zpjt已跑完');
        $this->NoChangeRateCircle($city_level, $channel, $platform, $category, $zpjt, 'zpjt', 'nartd');
        var_dump('Rank表中的nartd-zpjt已跑完');
        $this->NoChangeRateCircle($city_level, $channel, $platform, $category, $zpc, 'zpc', 'ko');
        var_dump('Rank表中的ko-zpc已跑完');
        $this->NoChangeRateCircle($city_level, $channel, $platform, $category, $zpc, 'zpc', 'compe');
        var_dump('Rank表中的compw-zpc已跑完');
        $this->NoChangeRateCircle($city_level, $channel, $platform, $category, $zpc, 'zpc', 'nartd');
        var_dump('Rank表中的zpc-nartd已跑完');
        $this->NoChangeRateCircle( $city_level, $channel, $platform, $category, $city, 'city', 'ko');
        var_dump('Rank表中的ko-city已跑完');
        $this->NoChangeRateCircle( $city_level, $channel, $platform, $category, $city, 'city', 'compe');
        var_dump('Rank表中的compe-city已跑完');
        $this->NoChangeRateCircle( $city_level, $channel, $platform, $category, $city, 'city', 'nartd');
        var_dump('Rank表中的nartd-city已跑完');
    }
    public function NoChangeRateCircle($Citylevel, $System, $Platform, $Category, $Relation, $region, $type)
    {
        $zpjt_arr = ["'全部' zpjt", 'zpjt'];
        $city_level_arr = ["'全部' city_level", 'city_level'];
        $channel_arr = ["'全部' channel", 'channel'];
        $platform_arr = ["'全部' platform", 'platform'];
        $type_arr = ["'全部' type", 'type'];
        $time=0;
        switch ($region) {
            case 'zpjt':
                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                    foreach ($city_level_arr as $city_levelkey => $city_levelvalue) {
                        foreach ($channel_arr as $channelkey => $channelvalue) {
                            foreach ($platform_arr as $platformkey => $platformvalue) {
                                foreach ($type_arr as $typekey => $typevalue) {
                                   $time++;
                                   var_dump('这是第'.$time.'次循环');echo'<br/>';
                                   $select_1=$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.',';
                                   $orderby=($zpjtvalue==$zpjt_arr[0]?'':'zpjt,').($city_levelvalue==$city_level_arr[0]?'':' city_level,').($channelvalue==$channel_arr[0]?'':'channel,').($platformvalue==$platform_arr[0]?'':'platform,').($typevalue==$type_arr[0]?'':'type ');
                                   $orderby=rtrim($orderby,',');
                                   if($orderby==''){
                                       $datagroup="SELECT $select_1
	shangpin,
	pack,
	SUM( sales_amount ) sales_amount,
	RANK() OVER (ORDER BY SUM( sales_amount ) DESC ) 
FROM
	sku_2018 
	WHERE
	dt='2018-11-01' and 
	 shangpin != '其他' 
	AND pack != '其他包装' 
	and is_ko=1
GROUP BY
	zpjt,
	city_level,
	platform,
	channel,
	type,
	shangpin,
	platform,
	pack HAVING
	sum( salescount ) >0;";
                                   }
                                   else{
                                       $datagroup="SELECT $select_1
	shangpin,
	pack,
	SUM( sales_amount ) sales_amount,
	RANK () OVER (PARTITION BY $orderby ORDER BY SUM( sales_amount ) DESC )  
FROM
	sku_2018 
	WHERE
	dt='2018-11-01' and 
	 shangpin != '其他' 
	AND pack != '其他包装' 
	and is_ko=1
GROUP BY
	zpjt,
	city_level,
	platform,
	channel,
	type,
	shangpin,
	platform,
	pack HAVING
	sum( salescount ) >0;";
                                   }
                                   if ($type == 'compe') {
                                        $datagroup = str_replace('is_ko=1', 'is_ko=0', $datagroup);
                                    }
                                   else if ($type == 'nartd') {
                                        $datagroup = str_replace('and is_ko=1', '', $datagroup);
                                    }
                                   //echo "<pre>";var_dump($datagroup);
                                   $this->NoChangeRateRequest($datagroup,$Citylevel, $System, $Platform, $Category, $Relation,$region,$type);

                                }
                            }
                        }
                    }
                }
                break;
            case 'zpc':
                $j = 0;
                foreach ($city_level_arr as $city_levelkey => $city_levelvalue) {
                    foreach ($channel_arr as $channelkey => $channelvalue) {
                        foreach ($platform_arr as $platformkey => $platformvalue) {
                            foreach ($type_arr as $typekey => $typevalue) {
                                $j++;
                                $select_1 = ' zpc' . ',' . $city_levelvalue . ',' . $channelvalue . ',' . $platformvalue . ',' . $typevalue . ',';
                                $orderby='zpc,'.($city_levelvalue==$city_level_arr[0]?'':' city_level,').($channelvalue==$channel_arr[0]?'':'channel,').($platformvalue==$platform_arr[0]?'':'platform,').($typevalue==$type_arr[0]?'':'type ');
                                $orderby=rtrim($orderby,',');
                                $datagroup="SELECT $select_1
	shangpin,
	pack,
	SUM( sales_amount ) sales_amount,
	RANK () OVER (PARTITION BY $orderby ORDER BY SUM( sales_amount ) DESC ) 
FROM
	sku_2018 
	WHERE
	dt='2018-11-01' and 
	 shangpin != '其他' 
	AND pack != '其他包装' 
	and is_ko=1
GROUP BY
	zpc,
	city_level,
	platform,
	channel,
	type,
	shangpin,
	platform,
	pack HAVING
	sum( salescount ) >0;";

                                if ($type == 'compe') {
                                    $datagroup = str_replace('is_ko=1', 'is_ko=0', $datagroup);
                                }
                                else if ($type == 'nartd') {
                                    $datagroup = str_replace('and is_ko=1', '', $datagroup);
                                }
//                                $res=true;
//                                $j=0;
//                                while ($res){
//                                    $start=$j*100000;
//                                    $j++;
//                                    $res=$this->KylinRank_11($start,$datagroup,$Citylevel, $System, $Platform, $Category, $Relation,$region,$type);
//                                }
                                $this->NoChangeRateRequest($datagroup,$Citylevel, $System, $Platform, $Category, $Relation,$region,$type);


                            }
                        }
                    }
                }
//                echo "<pre>";
//                var_dump($datasql);
//                exit;
                break;
            case 'city':

                foreach ($city_level_arr as $city_levelkey => $city_levelvalue) {
                    foreach ($channel_arr as $channelkey => $channelvalue) {
                        foreach ($platform_arr as $platformkey => $platformvalue) {
                            foreach ($type_arr as $typekey => $typevalue) {
                                $select_1 = ' city' . ',' . $city_levelvalue . ',' . $channelvalue . ',' . $platformvalue . ',' . $typevalue . ',';
                                $orderby='city,'.($city_levelvalue==$city_level_arr[0]?'':' city_level,').($channelvalue==$channel_arr[0]?'':'channel,').($platformvalue==$platform_arr[0]?'':'platform,').($typevalue==$type_arr[0]?'':'type ');
                                $orderby=rtrim($orderby,',');
                                $datagroup="SELECT $select_1
	shangpin,
	pack,
	SUM( sales_amount ) sales_amount,
	RANK () OVER (PARTITION BY $orderby ORDER BY SUM( sales_amount ) DESC ) 
FROM
	sku_2018 
	WHERE
  dt='2018-11-01' and 
	 shangpin != '其他' 
	AND pack != '其他包装' 
	and is_ko=1
GROUP BY
	city,
	city_level,
	platform,
	channel,
	type,
	shangpin,
	platform,
	pack HAVING
	sum( salescount ) >0;";
                                if ($type == 'compe') {
                                    $datagroup = str_replace('is_ko=1', 'is_ko=0', $datagroup);
                                }
                                else if ($type == 'nartd') {
                                    $datagroup = str_replace('and is_ko=1', '', $datagroup);
                                }
                                $this->NoChangeRateRequest($datagroup,$Citylevel, $System, $Platform, $Category, $Relation,$region,$type);
                            }
                        }
                    }
                }
                break;
        }
    }
    public function NoChangeRateRequest($datagroup, $Citylevel, $System, $Platform, $Category, $Relation, $region, $type)
    {

        set_time_limit('-1');//不限制执行时间
        $base = base64_encode('admin:KYLIN');
        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
        $params = CJSON::encode([
            'sql' => $datagroup,
            'project' => 'O2O_retail',
            "acceptPartial" => false,
//            'offset' => $start,
//            'limit' => 100000
        ]);
        $data = $this->getRetailCurl($url, $params, $header);
        $data = $data["results"];
        if (!empty($data)) {//不为空的判断
            $info = array();
            $newdata = [];
            foreach ($data as $key1 => $value1) {
                if($value1[8]<=10){
//                    echo "<pre>";var_dump($value1);var_dump('_______________________');
                    switch ($region) {
                        case 'zpjt':
                            $info[$key1]['relation_id'] = $value1[0] == "SCCL" ? 2 : ($value1[0] == "CBL" ? 3 : ($value1[0] == "ZH" ? 65 : ($value1[0] == "全部" ? 1 : 0)));
                            break;
                        case 'zpc':
                            $Relationid = $Relation[$value1[0]];
                            $info[$key1]['relation_id'] = $Relationid ? $Relationid->id : 0;
                            break;
                        case 'city':
                            $city = rtrim($value1[0], '市');
                            $Relationid = $Relation[$city];
                            $info[$key1]['relation_id'] = $Relationid ? $Relationid->id : 0;
                            break;
                    }
                    $city_levelid = isset($Citylevel[$value1[1]]) ? $Citylevel[$value1[1]]->id : 0;
                    $info[$key1]['cityLevel_id'] = $city_levelid;
                    $channelid = isset($System[$value1[2]]) ? $System[$value1[2]]->id : 0;
                    $info[$key1]['system_id'] = $channelid;
                    $platformid = isset($Platform[$value1[3]]) ? $Platform[$value1[3]]->id : 0;
                    $info[$key1]['platform_id'] = $platformid;
                    $skuid = isset($Category[$value1[4]]) ? $Category[$value1[4]]->id : 0;
                    $info[$key1]['sku_id'] = $skuid;
                    $info[$key1]['time'] = "2018_11";
//                    $info[$key1]['time'] = "2019_q1";
                    $info[$key1]['stage'] = 0;
                    $info[$key1]['status'] = 1;
                    switch ($type) {
                        case 'ko':
                            $info[$key1]['classify'] = 1;
                            break;
                        case 'compe':
                            $info[$key1]['classify'] = 2;
                            break;
                        case 'nartd':
                            $info[$key1]['classify'] = 3;
                            break;
                    }
                    $info[$key1]['sku_name'] = $value1[5];
                    $info[$key1]['bottle'] = $value1[6];
                    $info[$key1]['sales_amount'] = $value1[7];
                }
            }
//            echo "<pre>";var_dump($info);
            $label = array('relation_id', 'cityLevel_id', 'system_id', 'platform_id', 'sku_id', 'time', 'stage','status', 'classify', 'sku_name', 'bottle',
                'sales_amount');
            $log = [];
            $arr = array_chunk($info, 2000);
//            echo "<pre>";var_dump($arr);exit;
            for ($i = 0; $i < count($arr); $i++) {
                $t1 = microtime(true);
                $log[] = $this->batchInsert('cola_rank_2018_11_0', $label, $arr[$i]);
                $t2 = microtime(true);
                $res = round($t2 - $t1, 3);
                var_dump('插入数据库' . round($res, 3) . '秒');
            }
        }
        else{
            return 0;
        }


    }
//    有变化率
    public function HasChangeRate()
    {
        ini_set('memory_limit','-1');
        $zpjt = Relation::model()->findAll(['condition' => 'depth=1', 'index' => 'name']); //装瓶集团，有全部
        $zpc = Relation::model()->findAll(['condition' => 'depth=2', 'index' => 'name']);//装瓶厂，没有全部
        $city = Relation::model()->findAll(['condition' => 'depth=3', 'index' => 'name']);//城市，没有全部
        $city_level = Citylevel::model()->findAll(['index' => 'name']); //城市等级，有全部
        $channel = System::model()->findAll(['index' => 'name']);//渠道，有全部
        $platform = Platform::model()->findAll(['index' => 'name']);//平台，有全部
        $category = Category::model()->findAll(['index' => 'name']);//品类，有全部
        $this->HasChangeRateCircle($city_level, $channel, $platform, $category, $zpjt, 'zpjt', 'ko');
        var_dump('Rank表中的ko-zpjt已跑完');
        $this->HasChangeRateCircle($city_level, $channel, $platform, $category, $zpjt, 'zpjt', 'compe');
        var_dump('Rank表中的compe-zpjt已跑完');
        $this->HasChangeRateCircle($city_level, $channel, $platform, $category, $zpjt, 'zpjt', 'nartd');
        var_dump('Rank表中的nartd-zpjt已跑完');
        $this->HasChangeRateCircle($city_level, $channel, $platform, $category, $zpc, 'zpc', 'ko');
        var_dump('Rank表中的ko-zpc已跑完');
        $this->HasChangeRateCircle($city_level, $channel, $platform, $category, $zpc, 'zpc', 'compe');
        var_dump('Rank表中的compw-zpc已跑完');
        $this->HasChangeRateCircle($city_level, $channel, $platform, $category, $zpc, 'zpc', 'nartd');
        var_dump('Rank表中的zpc-nartd已跑完');
        $this->HasChangeRateCircle( $city_level, $channel, $platform, $category, $city, 'city', 'ko');
        var_dump('Rank表中的ko-city已跑完');
        $this->HasChangeRateCircle( $city_level, $channel, $platform, $category, $city, 'city', 'compe');
        var_dump('Rank表中的compe-city已跑完');
        $this->HasChangeRateCircle( $city_level, $channel, $platform, $category, $city, 'city', 'nartd');
        var_dump('Rank表中的nartd-city已跑完');

    }
    public function HasChangeRateCircle($Citylevel, $System, $Platform, $Category, $Relation, $region, $type)
    {
        set_time_limit('-1');//不限制执行时间
        $year='2019_Q3';
        $lastyear='2019_Q2';
//        $year='2019';
//        $lastyear='2019';
        $zpjt_arr = ["'全部' zpjt", 'zpjt'];
        $city_level_arr = ["'全部' city_level", 'city_level'];
        $channel_arr = ["'全部' channel", 'channel'];
        $platform_arr = ["'全部' platform", 'platform'];
        $type_arr = ["'全部' type", 'type'];
        $times=0;
        switch ($region) {
            case 'zpjt':
                foreach($zpjt_arr as $zpjtkey => $zpjtvalue){
                    foreach ($city_level_arr as $city_levelkey => $city_levelvalue) {
                        foreach ($channel_arr as $channelkey => $channelvalue) {
                            foreach ($platform_arr as $platformkey => $platformvalue) {
                                foreach ($type_arr as $typekey => $typevalue) {
//                                    $times++;
//                                    var_dump('这是第'.$times.'次循环');echo "<br/>";
                                    $select_1=$zpjtvalue.','.$city_levelvalue.','.$channelvalue.','.$platformvalue.','.$typevalue.',';
                                        $select_2=$zpjtvalue.($zpjtvalue==$zpjt_arr[0]?',':' AS lastzpjt,').$city_levelvalue.($city_levelvalue==$city_level_arr[0]?',':' AS lastcitylevel,').$channelvalue.($channelvalue==$channel_arr[0]?',':' AS lastchannel,').$platformvalue.($platformvalue==$platform_arr[0]?',':' AS lastplatform,').$typevalue.($typevalue==$type_arr[0]?',':' AS lasttype, ')."shangpin as lastshangpin,pack as lastpack,sum(sales_amount) as lastamount";
                                        $on_1='shangpin = lastshangpin and pack = lastpack and '.($zpjtvalue==$zpjt_arr[0]?'':'zpjt=lastzpjt and ').($city_levelvalue==$city_level_arr[0]?'':' city_level=lastcitylevel and ').($channelvalue==$channel_arr[0]?'':'channel=lastchannel and ').($platformvalue==$platform_arr[0]?'':'platform=lastplatform and ').($typevalue==$type_arr[0]?' ':'type=lasttype ');
                                        $on_1=rtrim($on_1,'and ');
//                                        $datagroup="select ".$select_1.",lastmonth.lastamount from sku_$year
//												left join (
//													select ".$select_2." from sku_$lastyear where $last_dt and is_ko=1 group by zpjt,city_level,channel,platform,type,shangpin,pack
//												) as lastmonth on(".$on_1.")
//												where $dt_condition and is_ko=1 and shangpin != '其他' and pack!='其他包装'
//												group by zpjt,city_level,channel,platform,type,shangpin,pack,lastmonth.lastamount
//												having sum(salescount)>0
//												order by salesamount desc";

                                    $orderby=($zpjtvalue==$zpjt_arr[0]?'':'zpjt,').($city_levelvalue==$city_level_arr[0]?'':' city_level,').($channelvalue==$channel_arr[0]?'':'channel,').($platformvalue==$platform_arr[0]?'':'platform,').($typevalue==$type_arr[0]?'':'type ');
                                    $orderby=rtrim($orderby,',');
                                    if($orderby==''){
                                        $datagroup="SELECT $select_1
	shangpin,
	pack,
	SUM( sales_amount ) sales_amount,
	lastmonth.lastamount,
	RANK() OVER (ORDER BY SUM( sales_amount ) DESC ) 
FROM
	sku_$year 
	left join ( select ".$select_2." from sku_$lastyear where is_ko=1 group by zpjt,city_level,channel,platform,type,shangpin,pack) as lastmonth on(".$on_1.")
	WHERE
	shangpin != '其他' 
	AND pack != '其他包装' 
	and is_ko=1
GROUP BY
	zpjt,
	city_level,
	platform,
	channel,
	type,
	lastmonth.lastamount,
	shangpin,
	platform,
	pack HAVING
	sum( salescount ) >0;";
                                    }
                                    else{
                                        $datagroup="SELECT $select_1
	shangpin,
	pack,
	SUM( sales_amount ) sales_amount,
	lastmonth.lastamount,
	RANK () OVER (PARTITION BY $orderby ORDER BY SUM( sales_amount ) DESC )  
FROM
	sku_$year 
	left join ( select ".$select_2." from sku_$lastyear where is_ko=1 group by zpjt,city_level,channel,platform,type,shangpin,pack) as lastmonth on(".$on_1.")
	WHERE
	shangpin != '其他' 
	AND pack != '其他包装' 
	and is_ko=1
GROUP BY
	zpjt,
	city_level,
	platform,
	channel,
	type,
	shangpin,
	platform,
	lastmonth.lastamount,
	pack HAVING
	sum( salescount ) >0;";
                                    }



//                                        var_dump($datagroup);exit;
                                    if ($type == 'compe') {
                                        $datagroup = str_replace('is_ko=1', 'is_ko=0', $datagroup);
                                    }
                                    else if ($type == 'nartd') {
                                        $datagroup = str_replace('and is_ko=1', '', $datagroup);
                                    }
//                                    var_dump($datagroup);exit;
                                    $this->HasChangeRateRequest($datagroup,$Citylevel, $System, $Platform, $Category, $Relation,$region,$type);
                                }
                            }
                        }
                    }
                }
                break;
            case 'zpc':
                foreach ($city_level_arr as $city_levelkey => $city_levelvalue) {
                    foreach ($channel_arr as $channelkey => $channelvalue) {
                        foreach ($platform_arr as $platformkey => $platformvalue) {
                            foreach ($type_arr as $typekey => $typevalue) {
//                                $times++;
//                                var_dump('这是第'.$times.'次循环');echo "<br/>";
                                $select_1 = ' zpc' . ',' . $city_levelvalue . ',' . $channelvalue . ',' . $platformvalue . ',' . $typevalue . ',';
                                    $select_2 = ' zpc as lastzpc,' . $city_levelvalue . ($city_levelvalue == $city_level_arr[0] ? ',' : ' AS lastcitylevel,') . $channelvalue . ($channelvalue == $channel_arr[0] ? ',' : ' AS lastchannel,') . $platformvalue . ($platformvalue == $platform_arr[0] ? ',' : ' AS lastplatform,') . $typevalue . ($typevalue == $type_arr[0] ? ',' : ' AS lasttype, ');
                                    $on_1 = 'shangpin = lastshangpin and pack = lastpack and ' . 'zpc=lastzpc and ' . ($city_levelvalue == $city_level_arr[0] ? '' : ' city_level=lastcitylevel and ') . ($channelvalue == $channel_arr[0] ? '' : 'channel=lastchannel and ') . ($platformvalue == $platform_arr[0] ? '' : 'platform=lastplatform and ') . ($typevalue == $type_arr[0] ? ' ' : 'type=lasttype ');
                                    $on_1 = rtrim($on_1, 'and ');
                                $orderby='zpc,'.($city_levelvalue==$city_level_arr[0]?'':' city_level,').($channelvalue==$channel_arr[0]?'':'channel,').($platformvalue==$platform_arr[0]?'':'platform,').($typevalue==$type_arr[0]?'':'type ');
                                $orderby=rtrim($orderby,',');
                                $datagroup="SELECT $select_1
	shangpin,
	pack,
	SUM( sales_amount ) sales_amount,
	lastmonth.lastamount,
	RANK () OVER (PARTITION BY $orderby ORDER BY SUM( sales_amount ) DESC ) 
FROM
	sku_$year 
	left join (select" . $select_2 . "shangpin as lastshangpin,pack as lastpack,sum(sales_amount) as lastamount from sku_$lastyear where is_ko=1 group by zpc,city_level,channel,platform,type,shangpin,pack) as lastmonth on(" . $on_1 . ")
	WHERE
    shangpin != '其他' 
	AND pack != '其他包装' 
	and is_ko=1
GROUP BY
	zpc,
	city_level,
	platform,
	channel,
	type,
	shangpin,
	platform,
	lastmonth.lastamount,
	pack HAVING
	sum( salescount ) >0;";
                                if ($type == 'compe') {
                                    $datagroup = str_replace('is_ko=1', 'is_ko=0', $datagroup);
                                }
                                else if ($type == 'nartd') {
                                    $datagroup = str_replace('and is_ko=1', '', $datagroup);
                                }
                                $this->HasChangeRateRequest($datagroup,$Citylevel, $System, $Platform, $Category, $Relation,$region,$type);
                            }
                        }
                    }
                }
                break;
            case 'city':
                foreach ($city_level_arr as $city_levelkey => $city_levelvalue) {
                    foreach ($channel_arr as $channelkey => $channelvalue) {
                        foreach ($platform_arr as $platformkey => $platformvalue) {
                            foreach ($type_arr as $typekey => $typevalue) {
//                                $times++;
//                                var_dump('这是第'.$times.'次循环');echo "<br/>";
                                $select_1 = ' city' . ',' . $city_levelvalue . ',' . $channelvalue . ',' . $platformvalue . ',' . $typevalue . ',';
                                    $select_2 = ' city as lastcity,' . $city_levelvalue . ($city_levelvalue == $city_level_arr[0] ? ',' : ' AS lastcitylevel,') . $channelvalue . ($channelvalue == $channel_arr[0] ? ',' : ' AS lastchannel,') . $platformvalue . ($platformvalue == $platform_arr[0] ? ',' : ' AS lastplatform,') . $typevalue . ($typevalue == $type_arr[0] ? ',' : ' AS lasttype, ');
                                    $on_1 = 'shangpin = lastshangpin and pack = lastpack and ' . 'city=lastcity and ' . ($city_levelvalue == $city_level_arr[0] ? '' : ' city_level=lastcitylevel and ') . ($channelvalue == $channel_arr[0] ? '' : 'channel=lastchannel and ') . ($platformvalue == $platform_arr[0] ? '' : 'platform=lastplatform and ') . ($typevalue == $type_arr[0] ? ' ' : 'type=lasttype ');
                                    $on_1 = rtrim($on_1, 'and ');
                                $orderby='city,'.($city_levelvalue==$city_level_arr[0]?'':' city_level,').($channelvalue==$channel_arr[0]?'':'channel,').($platformvalue==$platform_arr[0]?'':'platform,').($typevalue==$type_arr[0]?'':'type ');
                                $orderby=rtrim($orderby,',');
                                $datagroup="SELECT $select_1
	shangpin,
	pack,
	SUM( sales_amount ) sales_amount,
	lastmonth.lastamount,
	RANK () OVER (PARTITION BY $orderby ORDER BY SUM( sales_amount ) DESC ) 
FROM
	sku_$year 
	left join (select" . $select_2 . "shangpin as lastshangpin,pack as lastpack,sum(sales_amount) as lastamount from sku_$lastyear where is_ko=1 group by city,city_level,channel,platform,type,shangpin,pack) as lastmonth on(" . $on_1 . ")
	WHERE
	shangpin != '其他' 
	AND pack != '其他包装' 
	and is_ko=1
GROUP BY
	city,
	city_level,
	platform,
	channel,
	type,
	shangpin,
	lastmonth.lastamount,
	platform,
	pack HAVING
	sum( salescount ) >0;";
                                if ($type == 'compe') {
                                    $datagroup = str_replace('is_ko=1', 'is_ko=0', $datagroup);
                                }
                                else if ($type == 'nartd') {
                                    $datagroup = str_replace('and is_ko=1', '', $datagroup);
                                }
//                                var_dump($datagroup);exit;
                                $this->HasChangeRateRequest($datagroup,$Citylevel, $System, $Platform, $Category, $Relation,$region,$type);

                            }
                        }
                    }
                }
                break;
        }
    }
    public function HasChangeRateRequest($datagroup,$Citylevel, $System, $Platform, $Category, $Relation, $region, $type)
    {
        set_time_limit('-1');//不限制执行时间
        $base = base64_encode('admin:KYLIN');
        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
        $params = CJSON::encode([
            'sql' => $datagroup,
            'project' => 'O2O_retail',
            "acceptPartial" => false,
//            'offset' => $start,
//            'limit' => 20000
        ]);
        $data = $this->getRetailCurl($url, $params, $header);
        $data = $data["results"];
        if (!empty($data)) {//不为空的判断
            $info = array();
            foreach ($data as $key1 => $value1) {
               if($value1[9]<=10){
                   switch ($region) {
                       case 'zpjt':
                           $info[$key1]['relation_id'] = $value1[0] == "SCCL" ? 2 : ($value1[0] == "CBL" ? 3 : ($value1[0] == "ZH" ? 65 : ($value1[0] == "全部" ? 1 : 0)));
                           break;
                       case 'zpc':
                           $Relationid = $Relation[$value1[0]];
                           $info[$key1]['relation_id'] = $Relationid ? $Relationid->id : 0;
                           break;
                       case 'city':
                           $city = rtrim($value1[0], '市');
                           $Relationid = $Relation[$city];
                           $info[$key1]['relation_id'] = $Relationid ? $Relationid->id : 0;
                           break;
                   }
                   $city_levelid = isset($Citylevel[$value1[1]]) ? $Citylevel[$value1[1]]->id : 0;
                   $info[$key1]['cityLevel_id'] = $city_levelid;
                   $channelid = isset($System[$value1[2]]) ? $System[$value1[2]]->id : 0;
                   $info[$key1]['system_id'] = $channelid;
                   $platformid = isset($Platform[$value1[3]]) ? $Platform[$value1[3]]->id : 0;
                   $info[$key1]['platform_id'] = $platformid;
                   $skuid = isset($Category[$value1[4]]) ? $Category[$value1[4]]->id : 0;
                   $info[$key1]['sku_id'] = $skuid;
                   $info[$key1]['time'] = "2019_q3";
                   $info[$key1]['stage'] = 0;
                   $info[$key1]['status'] = 1;
                   switch ($type) {
                       case 'ko':
                           $info[$key1]['classify'] = 1;
                           break;
                       case 'compe':
                           $info[$key1]['classify'] = 2;
                           break;
                       case 'nartd':
                           $info[$key1]['classify'] = 3;
                           break;
                   }
                   $info[$key1]['sku_name'] = $value1[5];
                   $info[$key1]['bottle'] = $value1[6];
                   $info[$key1]['sales_amount'] = $value1[7];
                   if ($value1[8] == 0) {
                       $info[$key1]['last_sales_amount'] = 1;
                   } else $info[$key1]['last_sales_amount'] = ($value1[7]-$value1[8]) / $value1[8];
               }
            }
            $label = array('relation_id', 'cityLevel_id', 'system_id', 'platform_id', 'sku_id', 'time', 'stage','status', 'classify', 'sku_name', 'bottle',
                    'sales_amount', 'last_sales_amount');
            $log = [];
            $arr = array_chunk($info, 2000);
            for ($i = 0; $i < count($arr); $i++) {
//                $t1 = microtime(true);
                try{
                    $log[] = $this->batchInsert('cola_rank_2019_q3_0', $label, $arr[$i]);
                }
                catch (\Exception $e){
                    var_dump('插入失败了哟');
                }
//                $t2 = microtime(true);
//                $res = round($t2 - $t1, 3);
                var_dump('插入数据库');
            }
        }
        else{
            return 0;
        }
    }


}
