<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $Id
 * @property string $email
 * @property string $pwd
 * @property integer $Frozen
 * @property string $Lately_pwd
 */
class User extends CActiveRecord
{
	public $jurisdiction; //权限
	public $group; //集团
	public $bottler; //装瓶厂
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}
	public function updatedataCvs(){

		$rsmodel=RelationshipCvs::model()->findByPk($this->downloadRange);
		if(!empty($rsmodel)){
			if($rsmodel->depth==1){
				$this->group=$rsmodel->Id;
			}elseif($rsmodel->depth==2){
				$this->bottler=$rsmodel->Id;
				$this->group=$rsmodel->parent;
			}
		}
		$roles = yii::app()->authmanager->getroles($this->Id);
		$roles=array_keys($roles);
		for($i=0;$i<count($roles);$i++){
			if($roles[$i]!='download'){
				$this->jurisdiction=$roles[$i];
				break;
			}
		}
		// $this->jurisdiction=isset($auth['name'])?$auth['name']:'';
	}
    public function updatedata(){

	    $rsmodel=Relationship::model()->findByPk($this->downloadRange);
	    if(!empty($rsmodel)){
            if($rsmodel->depth==1){
                $this->group=$rsmodel->Id;
            }elseif($rsmodel->depth==2){
                $this->bottler=$rsmodel->Id;
                $this->group=$rsmodel->parent;
            }
        }
        $roles = yii::app()->authmanager->getroles($this->Id);
	    $roles=array_keys($roles);
	    for($i=0;$i<count($roles);$i++){
            if($roles[$i]!='download'){
                $this->jurisdiction=$roles[$i];
                break;
            }
        }
	   // $this->jurisdiction=isset($auth['name'])?$auth['name']:'';
    }
    public function beforesave(){
        if($this->jurisdiction=='koProjectTeam'){
            $this->downloadRange='';
        }
        return parent::beforesave();


    }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Frozen', 'numerical', 'integerOnly'=>true),
			array('email,pwd','required'),
			array('email','email','message'=>'邮箱格式错误'),
			array('pwd', 'length', 'max'=>'100'),
			//array('pwd','match','pattern'=>'/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\s\S]{8,16}$/','message'=>'至少8-16个字符，至少1个大写字母，1个小写字母和1个数字.'),
			//array('pwd', 'length', 'max'=>100),
			array('jurisdiction', 'length', 'max'=>'100'),
			array('group', 'length', 'max'=>'100'),
			array('is_download', 'length', 'max'=>'100'),
			array('bottler', 'length', 'max'=>'100'),
			array('Lately_pwd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, email, pwd, Frozen, Lately_pwd', 'safe', 'on'=>'search'),
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
		  //  'range'=>array()
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'email' => '用户邮箱账号',
			'pwd' => '用户密码',
			'Frozen' => '是否冻结',
			'Lately_pwd' => '上次密码修改时间',
			'jurisdiction' => '角色',
			'group' => '集团',
			'bottler' => '装瓶厂',
			'downloadRange' => '下载范围',
			'is_download' => '是否下载'
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('pwd',$this->pwd,true);
		$criteria->compare('Frozen',$this->Frozen);
		$criteria->compare('Lately_pwd',$this->Lately_pwd,true);
       // $criteria->compare('jurisdiction',)
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>'10'
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function validatePassword($pwd) {
		return  CPasswordHelper::verifyPassword($pwd,$this->pwd);
	}

	public function hashPassword() { //加密
		preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\s\S]{8,16}$/', $this->pwd);
		return  CPasswordHelper::hashPassword($this->pwd);//$password
	}
	public function is_pwd() { //加密
		return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\s\S]{8,16}$/', $this->pwd);
	}
}
