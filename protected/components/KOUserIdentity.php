<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class KOUserIdentity extends CUserIdentity {

    const TOKEN_NULL = 3; //账号已经被冻结了
    const TOKEN_ERROR = 4; //账号已经登录了

    private $_userinfo;

    public function __construct() {
        
    }

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

    /* KO userinfo 结构
      {
      "username":"testname",
      "koemployeeId":"100001",
      "phonenumber":"1380000000",
      "email":"testname@ciandt.com",
      "bottlergroup":"SBL",
      "bottler":"ZheJiang",
      "city":["宁波","杭州],
      "role":[:"业代","主任"]
      }
     * 
     */
    public function authenticate() {
        $domain = Yii::app()->params['at']['url'];
        $route = 'OAuth2Api/UserInfo';
        $token = Yii::app()->filecache->get('token');
//        Yii::app()->filecache->delete('token');
       // yii::log(print_r($token, true), 'warning');
        if (isset($token['access_token'])) {
            $header = array('Authorization:Bearer ' . (isset($token['access_token']) ? $token['access_token'] : ""));
            $res = $this->getCurl('', $domain . $route, $header);
            Yii::log(print_r($res, true), 'warning');
            if (isset($res['email'])) {
                $this->_userinfo = $res;
                if(empty($this->_userinfo['role'])){
                    Yii::app()->user->setroles("Looker");//如果没有传角色过来就设置角色都为默认角色：Looker
                }else{
                    Yii::app()->user->setroles($this->_userinfo['role']);
                }
                Yii::app()->user->setuserinfo($this->_userinfo);

                //Yii::app()->user->setroles($this->_userinfo['role']);
                //Yii::app()->user->setuserinfo($this->_userinfo);
                
                $this->errorCode = self::ERROR_NONE;
            } else {
                $this->errorCode = self::TOKEN_ERROR;
            }
        } else {
            $this->errorCode = self::TOKEN_NULL;
        }
        return $this->errorCode;
    }

    public function getId() {
        return $this->_userinfo['email'];
    }

    public function getName() {
        return $this->_userinfo['userName'];
    }
    
    public function getCurl($data, $url,$header=false,$second = 30){
       /* $crl = curl_init($url);
        $headr = array();*/
        if(!empty($data)){
            $url.='?'.http_build_query($data);
        }
       // pd($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置是否返回response header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //当需要通过curl_getinfo来获取发出请求的header信息时，该选项需要设置为true
       // curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $time_out);
        //curl_setopt($ch, CURLOPT_POST, $is_post);
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $response = curl_exec($ch);
        //$request_header = curl_getinfo( $ch, CURLINFO_HEADER_OUT);
       // print_r($request_header);
        curl_close($ch);
        return json_decode($response,true);
    }    
}
