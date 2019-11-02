<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $email;
	public $pwd;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('email', 'required','message'=>'用户名必填'),
			array('pwd', 'required','message'=>'密码必填'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('email,pwd', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'邮箱',
			'pwd'=>'密码',
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	//public function authenticate($attribute,$params)
	public function authenticate()
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->email,$this->pwd);
            $code = $this->_identity->authenticate();
			//echo ($code); die;
			if($code == UserIdentity::ERROR_USERNAME_INVALID || $code == UserIdentity::ERROR_PASSWORD_INVALID){
				$this->addError('pwd','用户名或者密码错误');
			}else if($code == UserIdentity::ERROR_FROZEN){
				$this->addError('emaill','该账号已经被冻结，请联系管理员');
			}

			//if(!$this->_identity->authenticate())
			//	$this->addError('pwd','用户名或者密码不正确');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->email,$this->pwd);
			$this->_identity->authenticate();
		}
	   // echo '<pre>';
		//print_r($this);die;
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{

			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			//var_dump($this->rememberMe ); die;
			Yii::app()->user->login($this->_identity,$duration);
			//var_dump(Yii::app()->user->isGuest);die;
			return true;
		} else{
			//echo 2;die;
			return false;
		}

	}
}
