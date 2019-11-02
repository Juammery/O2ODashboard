<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    const ERROR_FROZEN = 3; //账号已经被冻结了
    const ERROR_UNQIUE = 4; //账号已经登录了

    private $email;
    private $pwd;
    private $id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    /* public function __construct($email,$pwd)
      {
      $this->email=$email;
      $this->pwd=$pwd;
      } */

    public function authenticate() {
        $userInfo = User::model()->find('email=:name', array(':name' => $this->username));
        //var_dump($userInfo);die;
        if ($userInfo == NULL) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            //return false;
        } else if (!$userInfo->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            //return false;
        } else if ($userInfo->Frozen == 0) {
            $this->errorCode = self::ERROR_FROZEN;  //账号被冻结了
            //return false;
        } else if ($this->isOverdue($userInfo->Lately_pwd)) {  //判断修改密码的时间是否超过过期时间
            /* $arr = array(
              'AddAddress' => 'jj.zhang@cntoge.com',
              'FromName' => '121',
              'Body' => '你好',
              'Subject' => '11',
              );
              $this-> mail($arr); */
        } else {
            $this->errorCode = self::ERROR_NONE;
            $this->id = $userInfo->Id;
        }
        return $this->errorCode;
    }

    //判断密码是否过期
    public function isOverdue($time) {
        $sign = false;
        $date = date("Y-m-d H:i:s", strtotime("+" . Yii::app()->params['pwdModificationTime'] . "day"));
        if ($time >= $date)
            $sign = true;
        return $sign;
    }

    //发送邮箱的方法
    public function mail($arr) {
        $email = Yii::app()->params['email'];
        $mailer = Yii::createComponent('application.extensions.EMailer');
        $mailer->Host = $email['smtphost'];    //简单邮件传输协议
        $mailer->IsSMTP();
        $mailer->SMTPAuth = true;
        $mailer->From = $email['smtpuser'];         //SMTP用户
        $mailer->AddReplyTo($email['smtpuser']);     //  添加回复    SMTP用户
        $mailer->AddAddress($arr['AddAddress']);  //添加地址
        $mailer->FromName = $arr['FromName'];    //发信人姓名
        $mailer->Username = $email['smtpuser'];  //     SMTP用户
        $mailer->Password = $email['smtppass'];  //    SMTP密码
        $mailer->SMTPDebug = false;
        $mailer->CharSet = 'UTF-8';
        $mailer->ContentType = 'text/html';
        $mailer->Subject = $arr['Subject'];   //主题
        $mailer->Body = $arr['Body'];   //主体
        $mailer->Send();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        $this->email;
    }

}
