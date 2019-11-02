<?php
/**
 * Created by PhpStorm.
 * User: H
 * Date: 2017/10/25
 * Time: 17:04
 */
class Search extends CActiveRecord{
    public $region;
    public $factory;
    public $cityLevel;
    public $city;
    public $station;
    public $month;
    public $category;
    public $mode;
    public $brand;
    public $stage;
    public $manufacturer;
    public $series;
    public $capacity;
    public $bottle;
    public $platform;
    public static $tableName;
    public function tableName()
    {
        if(self::$tableName === null){
            return Yii::app()->params['defaultTable'];
        }else{
            return self::$tableName;
        }
    }
    public function attributeLabels()
        {
        return array(
           // 'region' => '区域',
        );
    }
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('region,factory,city,month,category,mode,brand,manufacturer,series,capacity,bottle','safe', 'on'=>'search'),
        );
    }
    public static function model($table_name = '', $className = __CLASS__)
    {
        self::$tableName = 'cola_info_'.$table_name;
        return parent::model($className);
    }
   /* public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }*/
}