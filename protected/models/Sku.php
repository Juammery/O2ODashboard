<?php

/**
 * This is the model class for table "{{sku}}".
 *
 * The followings are the available columns in table '{{sku}}':
 * @property integer $id
 * @property string $name
 * @property integer $parent
 * @property integer $depth
 * @property integer $sequence
 * @property string $color
 */
class Sku extends CActiveRecord
{
    public $category;
    public $manufacturer;
    public $brand;
    public $series;
    public $capacity;
    public $bottle;
    public $explain;
    public $categorys;
    public $manufacturers;
    public $brands;
    public $seriess;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{sku}}';
    }
    protected function afterFind()
    {
        $this->name = Yii::t('cvs', $this->name);
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('parent, depth, sequence', 'numerical', 'integerOnly' => true),
            array('name,color', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, parent, depth, sequence,color,category,manufacturer,brand,series,explain,categorys,manufacturers,brands,seriess,capacity,bottle', 'safe', 'on' => 'search'),
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
            'name' => '名称',
            'parent' => 'Parent',
            'depth' => '层级',
            'sequence' => '顺序',
            'color' => '颜色',
            'category' => "品类",
            'manufacturer' => '制造商',
            'brand' => "品牌",
            'series' => "系列",
            'explain' => "说明",
            'categorys' => "品类",
            'manufacturers' => '制造商',
            'brands' => "品牌",
            'seriess' => "系列",
            'capacity'=>'容量',
            'bottle'=>'瓶量'
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
        $list = null;
        if ($this->category) {
            $list = self::all_li_list($this->category, 'category');
        }
        if ($this->manufacturer) {
            $list = self::manufacturer_li_list($this->manufacturer, 'manufacturer');
        }
        if ($this->brand) {
            $list = self::brand_li_list($this->brand, 'brand');
        }
        if ($this->series) {
            $list = $this->series;
        }
        $criteria->compare('Id', $list);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('parent', $this->parent);
        $criteria->compare('depth', $this->depth);
        $criteria->compare('sequence', $this->sequence);
        $criteria->compare('color', $this->color);
//        $criteria->compare('category', $list);
//        $criteria->compare('manufacturer', $this->manufacturer);
//        $criteria->compare('brand', $this->brand);
//        $criteria->compare('series', $this->series);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Sku the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    //GridView显示品类
    public static function showCategory($data)
    {
//        pd($data);
        $id = isset($data) ? $data->id : "";
        $depth = isset($data) ? $data->depth : "";
        if ($depth == 0 || $depth == 1) {
            return $data->name;
        } elseif ($depth == 2) {
            $model = self::model()->find("id='" . $id . "'");
            if ($model) {
                $a = self::model()->find("id='" . $model->parent . "'");
                if ($a) {
                    return $a->name;
                }
            }
        } elseif ($depth == 3) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $parent = self::model()->find("id='" . $parent->parent . "'");
                if ($parent) {
                    $a = self::model()->find("id='" . $parent->parent . "'");
                    if ($a) {
                        return $a->name;
                    }
                }
            }
        } elseif ($depth == 4) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $parent = self::model()->find("id='" . $parent->parent . "'");
                if ($parent) {
                    $parent = self::model()->find("id='" . $parent->parent . "'");
                    if ($parent) {
                        $a = self::model()->find("id='" . $parent->parent . "'");
                        if ($a) {
                            return $a->name;
                        }
                    }
                }
            }
        } elseif ($depth == 5) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $parent = self::model()->find("id='" . $parent->parent . "'");
                if ($parent) {
                    $parent = self::model()->find("id='" . $parent->parent . "'");
                    if ($parent) {
                        $parent = self::model()->find("id='" . $parent->parent . "'");
                        if ($parent) {
                            $a = self::model()->find("id='" . $parent->parent . "'");
                            if($a){
                                return $a->name;
                            }
                        }
                    }
                }
            }
        } elseif ($depth == 6) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $parent = self::model()->find("id='" . $parent->parent . "'");
                if ($parent) {
                    $parent = self::model()->find("id='" . $parent->parent . "'");
                    if ($parent) {
                        $parent = self::model()->find("id='" . $parent->parent . "'");
                        if ($parent) {
                            $parent = self::model()->find("id='" . $parent->parent . "'");
                            if($parent){
                                $a = self::model()->find("id='" . $parent->parent . "'");
                                if($a){
                                    return $a->name;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    //GridView显示制造商
    public static function showManufacturer($data)
    {
        $id = isset($data) ? $data->id : "";
        $depth = isset($data) ? $data->depth : "";
        if ($depth == 2) {
            $a = self::model()->find("id='" . $id . "'");
            if ($a) {
                return $a->name;
            }
        } elseif ($depth == 3) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $a = self::model()->find("id='" . $parent->parent . "'");
                if ($a) {
                    return $a->name;
                }
            }
        } elseif ($depth == 4) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $parent = self::model()->find("id='" . $parent->parent . "'");
                if ($parent) {
                    $a = self::model()->find("id='" . $parent->parent . "'");
                    if ($a) {
                        return $a->name;
                    }
                }
            }
        } elseif ($depth == 5) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $parent = self::model()->find("id='" . $parent->parent . "'");
                if ($parent) {
                    $parent = self::model()->find("id='" . $parent->parent . "'");
                    if ($parent) {
                        $a = self::model()->find("id='" . $parent->parent . "'");
                        if ($a) {
                            return $a->name;
                        }
                    }
                }
            }
        } elseif ($depth == 6) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $parent = self::model()->find("id='" . $parent->parent . "'");
                if ($parent) {
                    $parent = self::model()->find("id='" . $parent->parent . "'");
                    if ($parent) {
                        $parent = self::model()->find("id='" . $parent->parent . "'");
                        if ($parent) {
                            $a = self::model()->find("id='" . $parent->parent . "'");
                            if ($a) {
                                return $a->name;
                            }
                        }
                    }
                }
            }
        }
    }

    //GridView显示品牌
    public static function showBrand($data)
    {
        $id = isset($data) ? $data->id : "";
        $depth = isset($data) ? $data->depth : "";
        if ($depth == 3) {
            $a = self::model()->find("id='" . $id . "'");
            if ($a) {
                return $a->name;
            }
        } elseif ($depth == 4) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $a = self::model()->find("id='" . $parent->parent . "'");
                if ($a) {
                    return $a->name;
                }
            }
        } elseif ($depth == 5) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $parent = self::model()->find("id='" . $parent->parent . "'");
                if ($parent) {
                    $a = self::model()->find("id='" . $parent->parent . "'");
                    if ($a) {
                        return $a->name;
                    }
                }
            }
        } elseif ($depth == 6) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $parent = self::model()->find("id='" . $parent->parent . "'");
                if ($parent) {
                    $parent = self::model()->find("id='" . $parent->parent . "'");
                    if ($parent) {
                        $a = self::model()->find("id='" . $parent->parent . "'");
                        if ($a) {
                            return $a->name;
                        }
                    }
                }
            }
        }
    }

    //GridView显示系列
    public static function showSeries($data)
    {
        $id = isset($data) ? $data->id : "";
        $depth = isset($data) ? $data->depth : "";
        if ($depth == 4) {
            $a = self::model()->find("id='" . $id . "'");
            if ($a) {
                return $a->name;
            }
        } elseif ($depth == 5) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $a = self::model()->find("id='" . $parent->parent . "'");
                if ($a) {
                    return $a->name;
                }
            }
        } elseif ($depth == 6) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $parent = self::model()->find("id='" . $parent->parent . "'");
                if ($parent) {
                    $a = self::model()->find("id='" . $parent->parent . "'");
                    if ($a) {
                        return $a->name;
                    }
                }
            }
        }
    }

    //GridView显示容量
    public static function showCapacity($data)
    {
        $id = isset($data) ? $data->id : "";
        $depth = isset($data) ? $data->depth : "";
        if ($depth == 5) {
            $a = self::model()->find("id='" . $id . "'");
            if ($a) {
                return $a->name;
            }
        } elseif ($depth == 6) {
            $parent = self::model()->find("id='" . $id . "'");
            if ($parent) {
                $a = self::model()->find("id='" . $parent->parent . "'");
                if ($a) {
                    return $a->name;
                }
            }
        }
    }

    //下拉筛选品类下面的全部信息
    public static function all_li_list($condition = '', $type = '')
    {
        $arr = array();
//        if ($type == "category") {
        //品类的
        $category = self::model()->findAll('id=' . $condition);
        if ($category) {
            foreach ($category as $v) {
                $arr[] = $v->id;
            }
        }
//        } elseif ($type == "manufacturer") {
        //制造商的
        $brand = self::model()->findAll('parent=' . $condition);
        if ($brand) {
            foreach ($brand as $v) {
                $arr[] = $v->id;
            }
        }
//        } elseif ($type == "brand") {
        //制造商下面的
        $max = self::model()->findAll('parent=' . $condition);
        if ($max) {
            foreach ($max as $v) {
                $max_a = self::model()->findAll('parent=' . $v->id);
                if ($max_a) {
                    foreach ($max_a as $values) {
                        $arr[] = $values->id;
                    }
                }
            }
        }
//        } elseif ($type == "series") {
        //品牌下面的
        $max = self::model()->findAll('parent=' . $condition);
        if ($max) {
            foreach ($max as $v) {
                $max_a = self::model()->findAll('parent=' . $v->id);
                if ($max_a) {
                    foreach ($max_a as $values) {
                        $series = self::model()->findAll('parent=' . $values->id);
                        if (isset($series)) {
                            foreach ($series as $series_a) {
                                $arr[] = $series_a->id;
                            }
                        }
                    }
                }
            }
        }
//        }
        return $arr;
    }

    //下拉筛选制造商下面的全部信息
    public static function manufacturer_li_list($condition = '', $type = '')
    {
        $arr = array();
        //制造商的
        $brand = self::model()->findAll('id=' . $condition);
        if ($brand) {
            foreach ($brand as $v) {
                $arr[] = $v->id;
            }
        }
        //品牌下面的
        $brand = self::model()->findAll('parent=' . $condition);
        if ($brand) {
            foreach ($brand as $v) {
                $arr[] = $v->id;
            }
        }
        //系列下面的
        $max = self::model()->findAll('parent=' . $condition);
        if ($max) {
            foreach ($max as $v) {
                $max_a = self::model()->findAll('parent=' . $v->id);
                if ($max_a) {
                    foreach ($max_a as $values) {
                        $arr[] = $values->id;
                    }
                }
            }
        }
        return $arr;
    }

    //下拉筛选品牌下面的全部信息
    public static function brand_li_list($condition = '', $type = '')
    {
        $arr = array();
        //品牌的
        $brand = self::model()->findAll('id=' . $condition);
        if ($brand) {
            foreach ($brand as $v) {
                $arr[] = $v->id;
            }
        }
        //系列下面的
        $brand = self::model()->findAll('parent=' . $condition);
        if ($brand) {
            foreach ($brand as $v) {
                $arr[] = $v->id;
            }
        }
        return $arr;
    }
}
