<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends SBaseController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = 'admin';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();


    //发送邮箱的方法
    public function mail($arr)
    {
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

    function pd($pm1, $pm2 = 'aaaaa2', $pm3 = 'bbbbb3', $pm4 = 'ccccc4', $pm5 = 'ddddd5')
    {
        header("Content-type: text/html; charset=utf-8");

        echo '<div style="color: red">-----------------参数1打印--------------------</div>';
        echo '<hr>';
        echo '<pre>';
        print_r($pm1);
        echo '</pre>';
        if ($pm2 != 'aaaaa2') {
            echo '<hr>';
            echo '<div style="color: red">-----------------参数2打印--------------------</div>';
            echo '<hr>';
            echo '<pre>';
            print_r($pm2);
            echo '</pre>';
        }
        if ($pm3 != 'bbbbb3') {
            echo '<hr>';
            echo '<div style="color: red">-----------------参数3打印--------------------</div>';
            echo '<hr>';
            echo '<pre>';
            print_r($pm3);
            echo '</pre>';
        }
        if ($pm4 != 'ccccc4') {
            echo '<hr>';
            echo '<div style="color: red">-----------------参数4打印--------------------</div>';
            echo '<hr>';
            echo '<pre>';
            print_r($pm4);
            echo '</pre>';
        }
        if ($pm5 != 'ddddd5') {
            echo '<hr>';
            echo '<div style="color: red">-----------------参数5打印--------------------</div>';
            echo '<hr>';
            echo '<pre>';
            print_r($pm5);
            echo '</pre>';
        }
        die;
    }
    //$tmpfile 打开临时文件
    //$changename 改名
    public function savefile($tmpfile, $changename = false, $imgthumb = true, $forcethumb = false, $thumbwidth = 150)
    {
        if (empty($tmpfile))  //判断这个文件是否存在 不存在返回null
            return null;

        // Yii::getPathOfAlias('webroot')    网站地址  绝对地址

        $uploaddir = Yii::getPathOfAlias('webroot') . '/' . yii::app()->params['uploaddir']; //getPathOfAlias 获取别名路径   uploaddir  上传目录     $uploaddir 为上传文件到哪个目录的地址
        //echo $uploaddir;die;
        if (!file_exists($uploaddir)) { //判断文件是否存在 不存在的话就创建目录
            $this->remkdir($uploaddir);
        }

        $tmpfilename = ""; //文件名字

        if ($changename || in_array($tmpfile->extensionName, array('xlsx'))) {  //extensionName 扩展名
            $randname = date("Ymdhis") . rand(1000, 9999);
            $tmpfilename = $randname . '.' . $tmpfile->extensionName; //新文件名称
        } else {
            $tmpfilename = $tmpfile->name; //iconv('utf-8', 'gb2312', $tmpfile->name);   旧文件名称
        }

        $filename = $uploaddir . '/' . $tmpfilename;  //上传文件到哪个目录的地址+文件名
        $tmpfile->saveAs($filename); //保存

        if ((in_array(strtolower($tmpfile->extensionName), array('jpg', 'jpeg', 'png', '')) && $imgthumb) || $forcethumb) {
            $thumb = Yii::app()->phpThumb->create($filename);
            $thumb->resize($thumbwidth);
            $thumb->save($filename . ".jpg");
        }
        return yii::app()->params['uploaddir'] . '/' . $tmpfilename;
    }

    public function makeDir($url)
    {
        if (!is_dir($url)) {
            if (@mkdir($url, 0777, true)) {
                return true;
            } else {
                return false;
            }

        } else {
            return true;
        }
    }

    function hint($type, $msg)
    {
        Yii::app()->user->setflash('hint', array('message' => $msg, 'type' => $type));
    }

    function trimall($str)//删除空格
    {
        $qian = array(" ", "　", "\t", "\n", "\r");
        $hou = array("", "", "", "", "");
        return str_replace($qian, $hou, trim($str));
    }

    function batchInsert($form = '', $field = array(), $value = array(), $type = false)
    {
        $data = [];
        if (empty($form) || empty($field) || empty($value)) {
            return false;
        }
        if ($type) {
            $field[] = 'error';
            foreach($value as $key=>$v){
                if($v[7] == 'KOMHSKU'){
                    $model = 1;
                }else{
                    $bloc = RelationshipCvs::model()->find('depth = 1 and name=:name', array(':name' => $v[2]));     //全部
                    $factory = RelationshipCvs::model()->find('depth = 2 and name=:name', array(':name' => $v[3]));  //装瓶厂
                    $system_cate = SystemCvs::model()->find('depth = 1 and name=:name', array(':name' => $v[4]));   //系统大类
//                    $system_subclass = SystemCvs::model()->find('depth = 1 and name=:name', array(':name' => $v[5]));  //系统类别
                    $system_name = SystemCvs::model()->find('depth = 2 and name=:name', array(':name' => $v[5]));  //系统名称
                    $category = SkuCvs::model()->find('depth = 1 and name=:name', array(':name' => $v[8]));   //品类
                    $brand = SkuCvs::model()->find('(depth = 2 or depth = 4) and name=:name', array(':name' => $v[9]));   //品牌
                    $sku = SkuCvs::model()->find('(depth = 3 or depth = 5) and name=:name', array(':name' => $v[10])); //Sku
//&& ((isset($system_subclass)) || ($system_subclass == ''))
                    if((isset($bloc) && isset($factory) && isset($system_cate) && isset($system_name) && isset($category) && isset($brand) && isset($sku))){
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
                    }else{
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
            foreach($data as $k=>$v){
                $valueString .= ' ( "' . implode('","', $v) . '") ,';
            }
        }else{
            foreach ($value as $k => $v) {
                $valueString .= ' ( "' . implode('","', $v) . '") ,';
            }
        }
        $newsql = $sql . substr($valueString, 0, -1);
        //  pd($newsql);
        return Yii::app()->db->createCommand($newsql)->execute();
    }
}