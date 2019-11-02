<?php

/**
 * This is the model class for table "{{relation}}".
 *
 * The followings are the available columns in table '{{relation}}':
 * @property integer $id
 * @property string $name
 * @property integer $cityLevel
 * @property integer $parent
 * @property integer $depth
 * @property integer $sequence
 */
class Relation extends CActiveRecord
{
    public $parent2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{relation}}';
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
			array('name', 'required'),
			array('parent, depth, sequence', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, parent, depth, sequence,cityLevel', 'safe', 'on'=>'search'),
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
			'factory' => array(self::HAS_ONE, 'Relation', '', 'on' => 't.parent=factory.id'),
			'bloc' => array(self::HAS_ONE, 'Relation', '', 'on' => 'factory.parent=bloc.id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '名称',
			'parent' => '父级',
			'parent2' => '父级',
			'depth' => '层级',
			'sequence' => '顺序',
			'cityLevel'=>'城市等级'
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('parent2',$this->parent2);
		$criteria->compare('depth',$this->depth);
		$criteria->compare('sequence',$this->sequence);
		$criteria->compare('cityLevel',$this->cityLevel);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Relation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
