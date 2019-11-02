<?php

class SiteController extends Controller
{

    public $defaultAction = "retail";

    /**
     * Declares class-based actions. 声明基于类的操作
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page 验证码动作呈现在联系人页面上显示的验证码图片
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages' 页面操作呈现“受保护/视图/站点/页面”下存储的“静态”页面
            // They can be accessed via: index.php?r=site/page&view=FileName 可以通过: index .PHP访问它们？r = site / page & view = filename
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    //另存为模板
    public function actionLoad()
    {
        //查询城市
        //查询品牌
    }

    //下载月报/季报
    public function actionDoucument()
    {
        if (Yii::app()->params['kologin']) {
            $this->actionKoDoucument();
        } else {
            $status = 0;
            $info = '您没有权限访问';
            if (isset($_POST['sj'])) {
                $sj = $_POST['sj'];
                $user = User::model()->findByPk(Yii::app()->user->id);
                if (!empty($user)) {
//                    if ($user->is_download == 0) {
//                        echo $this->returnjson(array('info' => $info, 'status' => 1));
//                    }
                    $user->updatedata();
//                    $this->pd($user);
                    $criteria = new CDbCriteria();
                    // $criteria->addInCondition('city',$arr);
                    //$criteria->compare('city',$arr);
                    $criteria->addCondition('time="' . $sj . '"');

                    $arr = [];
                    if ($user->jurisdiction == 'KOProjectTeam') {
                        //全部城市
                    } elseif ($user->jurisdiction == 'BG' || $user->jurisdiction == 'KOFranchiseCl') {
                        //集团
                        $model = Relationship::model()->findAll("parent=" . $user->downloadRange); //得到该集团下的装瓶厂
                        if (!empty($model)) {
                            foreach ($model as $v) {
                                $zpc = Relationship::model()->findAll("parent=" . $v->Id);
                                if (!empty($zpc)) {
                                    foreach ($zpc as $vv) {  //得到城市
                                        $arr[] = $vv->Id;
                                    }
                                }

                                //$arr[]=CHtml::listData($zpc,'Id','Id');
                            }
                        }
                    } elseif ($user->jurisdiction == 'OU' || $user->jurisdiction == 'KOMDM') {
                        //厂
                        $model = Relationship::model()->findAll("parent=" . $user->downloadRange); //得到该装瓶厂下的城市
                        $arr = CHtml::listData($model, 'Id', 'Id');
                        /* if(!empty($model)){
                          foreach($model as $v){
                          $arr[]=  Relationship::model()->findByPk($v->Id)->Id;
                          }
                          } */
                    } else {
                        //echo $this->returnjson(array('info'=>$info,'status'=>$status));die;
                        $arr = [];
                    }
                    if ($user->jurisdiction == 'KOProjectTeam') {

                    } else {
                        if (empty($arr)) {
                            $criteria->addCondition('1=0');
                        } else {
                            $criteria->addInCondition('city', $arr);
                        }
                    }

                    $presentlist = Presentation::model()->findAll($criteria);
//                     $this->pd($presentlist);
                    $info = [];
                    if (!empty($presentlist)) {
                        foreach ($presentlist as $v) {
                            if (isset($v->relationship->name)) {
                                $add = array();
                                $add['Id'] = $v->Id;
                                $add['city'] = $v->relationship->name;
                                $add['url'] = $v->downloadLinks;
                                $info[] = $add;
                            }
                        }
                    }
                    if (empty($info)) {
                        $status = 0;
                    } else {
                        $status = 1;
                    }
                    //$this->pd($info);
                }

            }
            echo $this->returnjson(array('info' => $info, 'status' => $status));
            /* else {
              $criteria = new CDbCriteria;
              $criteria->select = 'time';
              $criteria->order = 'time DESC';
              $time = Presentation::model()->find($criteria);
              $sj = '2017-08';
              } */
            /* $Id = Yii::app()->user->Id;  //读取用户的下载范围

              $user = User::model()->findByPk($Id);
              $roles = yii::app()->authmanager->getroles($Id);
              $roles=array_keys($roles);
              for($i=0;$i<count($roles);$i++){
              if($roles[$i]!='download'){
              $this->jurisdiction=$roles[$i];
              break;
              }
              }
              $jb = Relationship::model()->findByPk($user->downloadRange);  //获取该用户是那个级别的
              $arr = array();
              if($jb->depth==1){
              $model = Relationship::model()->findAll("parent=".$jb->Id); //得到该集团下的装瓶厂
              foreach($model as $v){
              $zpc =  Relationship::model()->findAll("parent=".$v->Id);
              foreach($zpc as $vv){  //得到城市
              $arr[]= $vv->Id;
              }
              }
              }else if($jb->depth==2){
              $model = Relationship::model()->findAll("parent=".$jb->Id); //得到该装瓶厂下的城市
              foreach($model as $v){
              $arr[]=  Relationship::model()->findByPk($v->Id)->Id;
              }
              }
              $pj = null;
              for($i=0;$i<count($arr);$i++){
              if($i==(count($arr)-1)){
              $pj.= $arr[$i];
              }else{
              $pj.= $arr[$i].',';
              }
              }

              $pre =  Presentation::model()->findAll('time="'.$sj.'"'.' and city in( '.$pj.')');
              $arr =array();
              if($pre){
              foreach($pre as $v){
              if(isset($v->relationship->name)){
              $add=array();
              $add['city']=$v->relationship->name;
              $add['url']=$v->downloadLinks;
              $arr[]=$add;
              }
              }
              $info=$arr;
              $status=1;
              }else{
              $status=0;
              $info=[];
              } */
        }
    }

    public function actionKoDoucument()
    {
        $status = 0;
        $info = '您没有权限访问!!!';
        if (isset($_POST['sj'])) {
            $kouser = Yii::app()->user->getUserinfo();
            if (!empty($kouser)) {
//                if (!in_array('download', $kouser['role'])) {
//                    echo $this->returnjson(array('info' => $info, 'status' => 1));
//                }
                $criteria1 = new CDbCriteria();
                $criteria1->addCondition('time="' . $_POST['sj'] . '"');
                $city = $kouser['city'];
                $kocity = Relationship::model()->findAll('depth = 3 and name in (:name)', array(':name' => implode(',', $city)));
                $arr = CHtml::listData($kocity, 'Id', 'Id');

                if (empty($arr)) {
                    $criteria1->addCondition('1=0');
                } else {
                    $criteria1->addInCondition('city', $arr);
                }
                $presentlist = Presentation::model()->findAll($criteria1);
                $info = [];
                if (!empty($presentlist)) {
                    foreach ($presentlist as $v) {
                        if (isset($v->relationship->name)) {
                            $add = array();
                            $add['Id'] = $v->Id;
                            $add['city'] = $v->relationship->name;
                            $add['url'] = $v->downloadLinks;
                            $info[] = $add;
                        }
                    }
                }
                if (empty($info)) {
                    $status = 0;
                } else {
                    $status = 1;
                }
            }
        }
        echo $this->returnjson(array('info' => $info, 'status' => $status));
    }

    public function actionIndexjs()
    {
        $searchmodel = new Search('search');
        $searchmodel->region = 4;
        $date = Time::model()->find(array('order' => 'Id desc'));
        $searchmodel->month = $date->time;
        //全部

        if (isset($_GET['Search'])) {
            //$searchmodel->month = $_GET['Search']['month'];
            $searchmodel->attributes = $_GET['Search'];
        }
        //$this->pd($searchmodel->city);
        //print_r($searchmodel);
        $citymap = array_values(CHtml::listData(Relationship::model()->findAll('depth=3'), 'Id', 'city_coordinate'));

        $datas = $this->actionGetdata(true);


        //pd($datas,$citymap,$searchmodel);
        $this->render("indexjs", array(
            'koinfos' => $datas['koinfos'],
            'koinfoss' => $datas['koinfoss'],
            'searchmodel' => $searchmodel,
            'citymap' => json_encode($citymap),
        ));
    }

    public function actionGetdata($return = false)
    {
        $time1 = microtime();

        set_time_limit(0);
        //print_r(yii::app()->request->getPapram());exit;
        $params = isset($_GET['Search']) ? $_GET['Search'] : $_GET;
        $date = Info::model()->with('time')->find(array('order' => 'time.time desc'));
        $defaultsku = array(
            6 => "KO",
            33 => "软饮料",
        );

        $koandpci = "(id=6 or id=33)";

        $relationid = 4;
        $skuid = $mode = $category = $brand = 0;

        $month = $date->time->time;
        if (count($params) > 1) {
            if ($params['region']) {
                $relationid = $params['region'];
            }
            if (!empty($params['factory'])) {
                $relationid = $params['factory'];
            }
            if (!empty($params['city'])) {
                $relationid = $params['city'];
            }

            $month = empty($params['month']) ? '2017-08' : $params['month'];


            if (!empty($params['category'])) {
                $skuid = $params['category'];
                $category = $params['category'];
            }
            if (!empty($params['brand'])) {
                $skuid = $params['brand'];
                $brand = $params['brand'];
            }
            if (!empty($params['mode'])) {
                $mode = $params['mode'];
            }
        }

        $condition = "relationship_id = $relationid";


        if ($mode) {
            $skucondition = "(parent=6 or parent=33) and name='$mode'";
        }
        if ($skuid) {
            if ($category && $brand == 0)
                $skucondition = "(id=$category or id=33)";
            if ($category && $brand)
                $skucondition = "(id=$category or id=$brand)";
        } else {
            $skucondition = "$koandpci";
        }
        // $timeid = Time::model()->find("time='$month'");
        // $condition .= " and time.time='$month'";
        //print_r($params,$skucondition);
        $lastmonth = $this->GetLastMonth($month);

        //当月KO&PCI数据
        //pd($condition);
        $koandpcis = Info::model()->with(array("time" => array("condition" => "time='$month'")))->findAll(array("condition" => $condition, "index" => "sku_id"));
        //pd($koandpcis);
        //$koandpcis = Info::model()->with(array("time" => array("condition" => "time='$month'")),array("sku" => array("condition" => "$skucondition")))->findAll(array("condition" => $condition, "index" => "sku_id"));
        //当月全国KO数据
        $totalfixed = Info::model()->with(array("time" => array("condition" => "time='$month'")))->find('relationship_id=4 and sku_id=6');
        //当月总订单数量数据
        $orderModel = Order::model()->with(array("time" => array("condition" => "time='$month'")))->find("relationship_id=$relationid");

        //当月全国KO各层级KO数据
        $allkos = Info::model()->with(array("time" => array("condition" => "time='$month'"), 'relationship'))->findall(array("condition" => 'sku_id=6'));
//        $aaa = $allkos->relationship_id;
//        $this->pd($aaa);

        $koinfos = array();
        if (Yii::app()->language == 'zh_cn') {
            foreach ($allkos as $ko) {
                $koinfos[] = array($ko->relationship->depth, $ko->relationship->name, $ko->attach_rate, $ko->Preceding_Attach_Rate, $ko->relationship->Id, $ko->Preceding_availability, $ko->Preceding_Incidence, $ko->relationship->name);
            }
        } else {
            foreach ($allkos as $ko) {
                $koinfos[] = array($ko->relationship->depth, Yii::app()->params['map_china'][$ko->relationship->name], $ko->attach_rate, $ko->Preceding_Attach_Rate, $ko->relationship->Id, $ko->Preceding_availability, $ko->Preceding_Incidence, $ko->relationship->name);
            }
        }
        //$this->pd($koinfos);
        //特殊的区域名
        $allkoss = Info::model()->with(array("time" => array("condition" => "time='$month'"), 'relationship'))->findall(array("condition" => "sku_id=80 and relationship_id in(2,3,4,24,30,31)"));
        $koinfoss = array();
        if (Yii::app()->language == 'zh_cn') {
            foreach ($allkoss as $ko) {
                //$koinfoss[] = array($ko->relationship->depth, $ko->relationship->name, $ko->attach_rate, $ko->Preceding_Attach_Rate, $ko->relationship->Id, $ko->Preceding_availability, $ko->Preceding_Incidence, $ko->relationship->name);
                //加入特殊区域坐标
                $koinfoss[] = array($ko->relationship->depth, $ko->relationship->name, yii::app()->params['specialLocate'][$ko->relationship->name], $ko->attach_rate, $ko->Preceding_Attach_Rate, $ko->relationship->Id, $ko->Preceding_availability, $ko->Preceding_Incidence, $ko->relationship->name);
            }
        } else {
            foreach ($allkoss as $ko) {
                $koinfoss[] = array($ko->relationship->depth, Yii::app()->params['map_china'][$ko->relationship->name], yii::app()->params['specialLocate'][$ko->relationship->name], $ko->attach_rate, $ko->Preceding_Attach_Rate, $ko->relationship->Id, $ko->Preceding_availability, $ko->Preceding_Incidence, $ko->relationship->name);
            }
        }
        //上月KO&PCI数据
        $lastkoandpcis = Info::model()->with(array("time" => array("condition" => "time='$lastmonth'")))->findAll(array("condition" => $condition, "index" => "sku_id"));
        //$lastkoandpcis = Info::model()->with(array("time" => array("condition" => "time='$lastmonth'")),array("sku" => array("condition" => "$skucondition")))->findAll(array("condition" => $condition, "index" => "sku_id"));
        //上月总订单数量数据
        $lastorderModel = Order::model()->with(array("time" => array("condition" => "time='$lastmonth'")))->find("relationship_id=$relationid");
        //当月全国各层级所有SKU数据,选择的relation的下一层级所有
        //当选定品类时，展示下一级别数据
        $infocondition = "relationship.parent=$relationid";
        if (isset($params['city']) && $params['city'])
            $infocondition = "relationship.Id=$relationid";

        if (isset($params['brand']) && $params['brand']) {
            $allskuinfos = Info::model()->with(array("time" => array("condition" => "time='$month'"), 'relationship', 'sku'))->findall(array("condition" => "sku.Id=$skuid"));
        }
        if (isset($params['category']) && $params['category']) {
            if ($params['category'] == 2) {//汽水
                $allskuinfos = Info::model()->with(array("time" => array("condition" => "time='$month'"), 'relationship', 'sku'))->findall(array("condition" => "t.sku_id=$skuid or (sku.parent=$skuid and sku.depth!=3) or ((sku.parent=6 or sku.parent=33) and sku.depth=2)"));
            } else
                $allskuinfos = Info::model()->with(array("time" => array("condition" => "time='$month'"), 'relationship', 'sku'))->findall(array("condition" => "t.sku_id=$skuid or (sku.parent=$skuid and sku.depth=2)"));
        } else {
            $allskuinfos = Info::model()->with(array("time" => array("condition" => "time='$month'"), 'relationship', 'sku' => array("condition" => "sku.depth=2 or sku.depth=1")))->findall();
            //$allskuinfos = Info::model()->with(array("time" => array("condition" => "time='$month'"), 'relationship', 'sku'))->findall(array("condition" => " sku_id=$skuid or (sku.parent=$skuid)"));
        }

        $timelist = CHtml::listData(Time::model()->findAll(), 'Id', 'time');
        $skuinfos = array();
        foreach ($allskuinfos as $skuinfo) {
            $skuinfos['bar'][$skuinfo->relationship_id]['relationship'] = $skuinfo->relationship;

            /* $label=[];
              $labelValue=[];
              $label[]=$skuinfo->time_id;

              $label=array_merge($label,CHtml::listData($skuinfo->history,'Id','time_id'));
              for($i=0;$i<count($label);$i++){
              if(isset($timelist[$label[$i]])){
              $labelValue[]=$timelist[$label[$i]];
              }
              }
              if(count($label)<6){
              $add=[];
              for($i=0;$i<(6-count($label));$i++){
              $time=strtotime(end($labelValue).'-01 -'.($i+1).' month');
              $add[]=date('Y-m',$time);
              }
              }
              $labelValue=array_reverse(array_merge($labelValue,$add));


              $skuinfos['bar'][$skuinfo->relationship_id]['label']=$labelValue; */
            // $skuinfos['stackbar']['legend'][] = $skuinfo->sku->name;
            $skuinfos['stackbar']['relations'][$skuinfo->relationship_id] = $skuinfo->relationship->name;
            //$skuinfos['stackbar']['skus'][$skuinfo->sku->name][] = $skuinfo;

            if ($skuinfo->sku_id == $skuid) {
                $skuinfos['bar'][$skuinfo->relationship_id]['self'] = array($skuinfo->sku, $skuinfo);
                $skuinfos['stackbar']['self'] = array($skuinfo->sku, $skuinfo);
            } else {
                $skuinfos['bar'][$skuinfo->relationship_id]['skus'][] = array($skuinfo->sku, $skuinfo->attributes);
                //   $skuinfos['bar'][$skuinfo->relationship_id]['skus']['history'] = $skuinfo->history;
                $skuinfos['stackbar']['skus'][$skuinfo->sku->name][] = array($skuinfo->sku, $skuinfo);
                //    print_r( $skuinfos['bar'][$skuinfo->relationship_id]['skus']);exit;
            }
        }

        $orders = array(
            'order' => $orderModel,
            'lastorder' => $lastorderModel,
        );


        $kopciinfos = array(
            'koandpcis' => $koandpcis,
            'lastkoandpcis' => $lastkoandpcis
        );

        //数据返回
        $infos['totalfixed'] = $totalfixed;
        $infos['kopciinfos'] = $kopciinfos;
        $infos['orders'] = $orders;
        $infos['koinfos'] = $koinfos;
        $infos['koinfoss'] = $koinfoss;
        $infos['allskuinfos'] = $skuinfos;

        $time2 = microtime();
        $time = $time2 - $time1;

        //yii::log("cpu test , t1:$time1,t2:$time2, t:$time",'warning');
        //pd($infos);
        if ($return) {
            return $infos;
        } else
            echo CJSON::encode($infos);
    }

    public function actionGethistorydata()
    {
        set_time_limit(0);

        $params = isset($_GET['Search']) ? $_GET['Search'] : $_GET;
        $date = Time::model()->find(array('order' => 'Id desc'));
        $month = $date->time;
        $skuid = 0;


        $month = isset($params['month']) ? $params['month'] : $month;

        $arr = [
            'route' => 'gethistorydata',
            'month' => $month
        ];
        $code = $this->makecode($arr);


        $returndata = Yii::app()->filecache->get($code);
        if (!empty($returndata)) {

            echo $returndata;

            die;
        }
        /*if (count($params) > 1) {

            $month = empty($params['month']) ? '2017-08' : $params['month'];


            if (!empty($params['category'])) {
                $skuid = $params['category'];
            }
            if (!empty($params['brand'])) {
                $skuid = $params['brand'];
            }
        }*/
        /* if (isset($params['brand']) && $params['brand']) {
             $allskuinfos = Info::model()->with(array("time" => array("condition" => "time='$month'"), 'relationship', 'sku', 'history'))->findall(array("condition" => "sku.Id=$skuid"));
         }*/
        /* if (isset($params['category']) && $params['category']) {
             if ($params['category'] == 2) {//汽水
                 $allskuinfos = Info::model()->with(array("time" => array("condition" => "time='$month'"), 'relationship', 'sku', 'history'))->findall(array("condition" => "t.sku_id=$skuid or (sku.parent=$skuid and sku.depth!=3) or ((sku.parent=6 or sku.parent=33) and sku.depth=2)"));
             } else
                 $allskuinfos = Info::model()->with(array("time" => array("condition" => "time='$month'"), 'relationship', 'sku', 'history'))->findall(array("condition" => "t.sku_id=$skuid or (sku.parent=$skuid and sku.depth=2)"));
         } else {*/
        $allskuinfos = Info::model()->with(array("time" => array("condition" => "time='$month'"), 'relationship', 'history', 'sku' => array("condition" => "sku.depth=2 or sku.depth=1")))->findall();
        //}

        $timelist = CHtml::listData(Time::model()->findAll(), 'Id', 'time');
        $skuinfos = array();


        $sql = 'select o.relationship_id, GROUP_CONCAT(t.time order  by t.Id desc ),GROUP_CONCAT(o.takeoutfood_order order  by t.Id desc ) as takeoutfood from cola_order as o right JOIN (select * from cola_time ORDER BY Id desc limit 6) as t on o.time_id=t.Id GROUP BY o.relationship_id';

        $orderdata = Yii::app()->db->createCommand($sql)->queryAll();

        $neworderdata = [];

        for ($i = 0; $i < count($orderdata); $i++) {
            $neworderdata[$orderdata[$i]['relationship_id']] = $orderdata[$i];
        }

        foreach ($allskuinfos as $skuinfo) {
            $skuinfos['bar'][$skuinfo->relationship_id]['relationship'] = $skuinfo->relationship;

            $label = [];
            $labelValue = [];
            $label[] = $skuinfo->time_id;

            $label = array_merge($label, CHtml::listData($skuinfo->history, 'Id', 'time_id'));
            for ($i = 0; $i < count($label); $i++) {
                if (isset($timelist[$label[$i]])) {
                    $labelValue[] = $timelist[$label[$i]];
                }
            }
            $add = [];
            if (count($label) < 6) {

                for ($i = 0; $i < (6 - count($label)); $i++) {
                    $time = strtotime(end($labelValue) . '-01 -' . ($i + 1) . ' month');
                    // array_push($label,date('Y-m',$time));
                    $add[] = date('Y-m', $time);
                }

                $labelValue = array_reverse(array_merge($labelValue, $add));
            } elseif (count($label) > 6) {
                $labelValue = array_reverse(array_slice($labelValue, 0, 6));
            }
            //pd($labelValue);
            //pd($labelValue);
            $skuinfos['bar'][$skuinfo->relationship_id]['label'] = $labelValue;
            // $skuinfos['stackbar']['legend'][] = $skuinfo->sku->name;
            $skuinfos['stackbar']['relations'][$skuinfo->relationship_id] = $skuinfo->relationship->name;
            //$skuinfos['stackbar']['skus'][$skuinfo->sku->name][] = $skuinfo;


            if (isset($neworderdata[$skuinfo->relationship_id])) {


                $arrvalue = explode(',', $neworderdata[$skuinfo->relationship_id]['takeoutfood']);
                $intvalvalue = [];
                for ($k = 0; $k < count($arrvalue); $k++) {
                    $intvalvalue[] = intval($arrvalue[$k]);
                }
                $skuinfos['bar'][$skuinfo->relationship_id]['storenum'] = $intvalvalue;
            }
            if ($skuinfo->sku_id == $skuid) {
                $skuinfos['bar'][$skuinfo->relationship_id]['self'] = array($skuinfo->sku, $skuinfo);
                $skuinfos['stackbar']['self'] = array($skuinfo->sku, $skuinfo);
            } else {
                $skuinfos['bar'][$skuinfo->relationship_id]['skus'][] = array($skuinfo->sku, $skuinfo->attributes, array_slice($skuinfo->history, 0, 5));
                $skuinfos['stackbar']['skus'][$skuinfo->sku->name][] = array($skuinfo->sku, $skuinfo);
            }
        }
        $skuinfos = CJSON::encode($skuinfos);
        Yii::app()->filecache->set($code, $skuinfos, Yii::app()->params['cache']['cvsdatatime']);

        //pd($skuinfos);
        echo CJSON::encode($skuinfos);
    }

    private function getnewtimecvs()
    {
        $newlist = InfoCvs::monthdata();
        $maxmonth = max($newlist);
        return substr($maxmonth, 0, 4) . '-' . substr($maxmonth, 4, 2);
    }

    public function actionIndexcvs($m_city = 0)
    {
        $searchmodel = new Search('search');
        $searchmodel->region = 1;
        //$date = Time::model()->find(array('order' => 'Id desc'));
        $searchmodel->month = $this->getnewtimecvs();
        $searchmodel->stage = InfoCvs::model()->maxstage($searchmodel->month);
        if ($m_city) $searchmodel->factory = $m_city;
        //全部
        //     $maxsql = 'select IFNULL(max(stage),1) as maxnum from cola_info_cvs where time="' . $searchmodel->month . '"';
        //     $res = Yii::app()->db->createCommand($maxsql)->queryRow();

        //      $searchmodel->stage = $res['maxnum'];
        if (isset($_GET['Search'])) {
            //$searchmodel->month = $_GET['Search']['month'];
            $searchmodel->attributes = $_GET['Search'];
        }
        //$this->pd($searchmodel->city);
        //print_r($searchmodel);
        $citymap = array_values(CHtml::listData(RelationshipCvs::model()->findAll('depth=3'), 'Id', 'city_coordinate'));

        $datas = $this->actionGetcvsdata(true, $m_city);
        // pd($datas);
        $this->render("indexcvs", array(
            'datas' => $datas,
            'searchmodel' => $searchmodel,
            'citymap' => json_encode($citymap),
        ));
    }

    public function actionGetcvsdata($return = false, $factory = false)
    {


        // ini_set('max_execution_time', '3600');  //由于本方法执行时间过长，则要把执行时间调长些：
        set_time_limit(0);
        ini_set('memory_limit', '1280M');


        //print_r(yii::app()->request->getPapram());exit;
        $params = isset($_GET['Search']) ? $_GET['Search'] : $_GET;

        //$date = Time::model()->find(array('order' => 'Id desc'));
        $month = $this->getnewtimecvs();
        $relationid = 1; //全国
        $mode = $category = $brand = 0;

        $stage = InfoCvs::model()->maxstage($month);

        $systemid = 1; //总系统


        if ($factory) $relationid = $factory;//传入的装瓶厂ID


        if (count($params) > 1) {
            if ($params['region']) {
                $relationid = $params['region'];
            }
            if (!empty($params['factory'])) {
                $relationid = $params['factory'];
            }

            if (!empty($params['city'])) {
                $relationid = $params['city'];
            }

            $month = empty($params['month']) ? $month : $params['month'];
            $stage = isset($params['stage']) && !empty($params['stage']) ? $params['stage'] : 0;
            if ($stage > InfoCvs::model()->maxstage($month)) $stage = InfoCvs::model()->maxstage($month);

            /* if (!empty($params['category'])) {
              $skuid = $params['category'];
              $category = $params['category'];
              }
              if (!empty($params['brand'])) {
              $skuid = $params['brand'];
              $brand = $params['brand'];
              }
              if (!empty($params['mode'])) {
              $skuid = $params['mode'];
              $mode = $params['mode'];
              } */

            if (!empty($params['systemtype'])) {
                $systemid = $params['systemtype'];
            }
            if (!empty($params['system'])) {
                $systemid = $params['system'];
            }
        }

        $condition = "relationship_id = $relationid and system_id = $systemid ";

//        $koandpcis = InfoCvs::model()->findAll(array("condition" => $condition . " and time='$month' and stage='$stage'"));
        $koandpcis = InfoCvs::model()->findAll(array('condition' => 'time = "' . $month . '" and stage = ' . $stage . ' and ' . $condition));
//        pd($koandpciss);
        $koandpcisnew = [];
        for ($i = 0; $i < count($koandpcis); $i++) {
            //if(isset($koandpcis[$i]->shelves)&&!empty($koandpcis[$i]->shelves)){
            if ($koandpcis[$i]->activity && $koandpcis[$i]->activity != 16) {
                $koandpcis[$i]->activity = $koandpcis[$i]->activityinfo->activity;
            }

            if ($koandpcis[$i]->equipment && $koandpcis[$i]->equipment != 4) $koandpcis[$i]->equipment = $koandpcis[$i]->equipmentinfo->equipment;

            if ($koandpcis[$i]->mechanism && $koandpcis[$i]->mechanism != 6) $koandpcis[$i]->mechanism = $koandpcis[$i]->mechanisminfo->mechanism;

            if (isset(yii::app()->params['shelves'][$koandpcis[$i]->shelves])) $koandpcis[$i]->shelves = yii::app()->params['shelves'][$koandpcis[$i]->shelves];

            $koandpcisnew[$koandpcis[$i]->sku_id][] = $koandpcis[$i];
            //}
        }

        // pd($koandpcisnew);
        //$koandpcis = Info::model()->with(array("time" => array("condition" => "time='$month'")),array("sku" => array("condition" => "$skucondition")))->findAll(array("condition" => $condition, "index" => "sku_id"));
        //当月全国KO数据
        $totalfixed = InfoCvs::model()->with('progress')->find("relationship_id=1 and system_id=1 and sku_id=80 and t.time='$month' and t.stage='$stage' and shelves=1");
        //当月总订单数量数据
//pd($totalfixed);
        //$orderModel = OrderCvs::model()->findAll("$condition and time='$month' and stage='$stage'");
        //当月全国KO各层级KO数据
        $allkos = InfoCvs::model()->findall(array("condition" => "sku_id=80  and time='$month' and stage='$stage' and shelves=1 and system_id
        =1"));
//        $aaa = $allkos->relationship_id;
//        $this->pd($aaa);

        $koinfos = array();

        if (Yii::app()->language == 'zh_cn') {
            foreach ($allkos as $ko) {
                $koinfos[] = array($ko->relationship->depth, $ko->relationship->name, $ko->Last_distribution_radio, $ko->Last_sovi_radio, $ko->relationship->Id, $ko->Last_extra_displays_radio, $ko->Last_thematic_activity_radio, $ko->Last_equipment_sales_radio, $ko->relationship->name);
            }
        } else {
            foreach ($allkos as $ko) {
                $koinfos[] = array($ko->relationship->depth, Yii::app()->params['cvs_map_china'][$ko->relationship->name], $ko->Last_distribution_radio, $ko->Last_sovi_radio, $ko->relationship->Id, $ko->Last_extra_displays_radio, $ko->Last_thematic_activity_radio, $ko->Last_equipment_sales_radio, $ko->relationship->name);
            }
        }
        //特殊的区域名
        $allkoss = InfoCvs::model()->findall(array("condition" => "sku_id=80  and time='$month' and stage='$stage' and shelves=1 and system_id
        =1 and relationship_id in(1,2,3,4,5,6)"));
        $koinfoss = array();
        if (Yii::app()->language == 'zh_cn') {
            foreach ($allkoss as $value) {

                //$koinfoss[] = array($value->relationship->depth, $value->relationship->name, $value->Last_distribution_radio, $value->Last_sovi_radio, $value->relationship->Id, $value->Last_price_anomaly_radio, $value->Last_thematic_activity_radio, $value->Last_equipment_sales_radio, $value->relationship->name);
                //插入特殊区域坐标
                $koinfoss[] = array($value->relationship->depth, $value->relationship->name, yii::app()->params['specialLocate'][$value->relationship->name], $value->Last_distribution_radio, $value->Last_sovi_radio, $value->relationship->Id, $value->Last_extra_displays_radio, $value->Last_thematic_activity_radio, $value->Last_equipment_sales_radio, $value->relationship->name);
            }
        } else {
            foreach ($allkoss as $value) {
                $koinfoss[] = array($value->relationship->depth, Yii::app()->params['cvs_map_china'][$value->relationship->name], yii::app()->params['eng_specialLocate'][$value->relationship->name], $value->Last_distribution_radio, $value->Last_sovi_radio, $value->relationship->Id, $value->Last_extra_displays_radio, $value->Last_thematic_activity_radio, $value->Last_equipment_sales_radio, $value->relationship->name);
            }
        }
        //$m1=memory_get_usage();
        //$this->pd($koinfos);
        // pd($koandpcis,$totalfixed,$orderModel,$allkos,$koinfos);
        //上月KO&PCI数据

        $change = strtotime($month);
        $lastmonth = $this->getLastStage($month, $stage);
//        if($stage == -1){// YTD,对比的数据是去年的。例如：2018-07的YTD对比的是2017-07的YTD
//            $ytdMonth = date("Y-m", strtotime("-1 year",$change));
//            $ytdStage = -1;
//            $lastkoandpcis = InfoCvs::model()->findAll(array("condition" => $condition . " and time='$ytdMonth'  and stage='$ytdStage'"));
//        }elseif($stage == 0){//月值，对比的数据是上月的。例如：2018-07的月值对比的是2018-06的月值
//            $ytdMonth = date("Y-m", strtotime("-1 month",$change));
//            $ytdStage = 0;
//            $lastkoandpcis = InfoCvs::model()->findAll(array("condition" => $condition . " and time='$ytdMonth'  and stage='$ytdStage'"));
//        }else{
//            $lastkoandpcis = InfoCvs::model()->findAll(array("condition" => $condition . " and time='$lastmonth[0]'  and stage='$lastmonth[1]'"));
//        }
        if ($stage == -1) {// YTD,对比的数据是去年的。例如：2018-07的YTD对比的是2017-07的YTD
            $ytdMonth = date("Y-m", strtotime("-1 year", $change));
            $ytdStage = -1;
            $lastkoandpcis = InfoCvs::model()->findAll(array("condition" => $condition . " and time='$ytdMonth'  and stage='$ytdStage'"));
        } else {
            $lastkoandpcis = InfoCvs::model()->findAll(array("condition" => $condition . " and time='$lastmonth[0]'  and stage='$lastmonth[1]'"));
        }
        // pd($lastmonth,$lastkoandpcis);
        $lastkoandpcisnew = [];
        for ($i = 0; $i < count($lastkoandpcis); $i++) {

            if ($lastkoandpcis[$i]->equipment && $lastkoandpcis[$i]->equipment != 4) $lastkoandpcis[$i]->equipment = $lastkoandpcis[$i]->equipmentinfo->equipment;

            if ($lastkoandpcis[$i]->mechanism && $lastkoandpcis[$i]->mechanism != 6) $lastkoandpcis[$i]->mechanism = $lastkoandpcis[$i]->mechanisminfo->mechanism;

            $lastkoandpcisnew[$lastkoandpcis[$i]->sku_id][] = $lastkoandpcis[$i];
        }

        // $m2=memory_get_usage();
        //$lastkoandpcis = Info::model()->with(array("time" => array("condition" => "time='$lastmonth'")),array("sku" => array("condition" => "$skucondition")))->findAll(array("condition" => $condition, "index" => "sku_id"));
        //上月总订单数量数据
        /* $lastorderModel = OrderCvs::model()->findAll("relationship_id=$relationid and  time='$lastmonth[0]'  and stage='$lastmonth[1]'"); */
        //当月全国各层级所有SKU数据,选择的relation的下一层级所有
        //当选定品类时，展示下一级别数据
        /*  $infocondition = "relationship.parent=$relationid";
          if (isset($params['city']) && $params['city'])
          $infocondition = "relationship.Id=$relationid"; */
        /*
          if (isset($params['brand']) && $params['brand']) {
          $allskuinfos = InfoCvs::model()->findall(array("condition" => "sku.Id=$skuid and  time='$month'  and stage='$stage'"));
          }
          if (isset($params['category']) && $params['category']) {

          $allskuinfos = InfoCvs::model()->with('relationship', 'sku')->findall(array("condition" => " time='$month' and stage='$stage' and sku_id=$skuid or (sku.parent=$skuid and sku.depth=2)"));
          } else {
          $allskuinfos = InfoCvs::model()->with(array('relationship'=>array('condition'=>'relationship.depth=1'), 'sku' => array("condition" => "sku.depth=1")))->findall(" time='$month'  and stage='$stage'");
          } */
        /* if($skuid==0){
          $allskuinfos = InfoCvs::model()->with(array('relationship'=>array('condition'=>'relationship.depth=1'), 'sku' => array("condition" => "sku.depth=1")))->findall(" time='$month'  and stage='$stage'");
          }else{

          $allskuinfos=InfoCvs::model()->with('sku','relationship')->findAll('time=:time and stage=:stage and (sku_id=:sku_id or sku.parent=:sku_id) and (relationship_id=:r_id or relationship.parent=:r_id)',array(':time'=>$month,':stage'=>$stage,':sku_id'=>$skuid,':r_id'=>$relationid));
          } */

        $condition = '';

        /*
         * sku 单独接口
         *
          if($skuid==0){//sku 不选
          $condition=array('condition'=>'relationship.depth=1 and sku.depth=1 and time=:time and stage=:stage and shelves=1 and system_id=:system_id','params'=>array(':time'=>$month,':stage'=>$stage,':system_id'=>$systemid));
          }else{
          $condition=array('condition'=>'time=:time  and shelves=1 and system_id=:system_id and stage=:stage and (sku_id=:sku_id or sku.parent=:sku_id) and (relationship_id=:r_id or relationship.parent=:r_id)','params'=>array(':time'=>$month,':stage'=>$stage,':sku_id'=>$skuid,':r_id'=>$relationid,':system_id'=>$systemid));
          }

          $allskuinfos=InfoCvs::model()->with('sku','relationship','system')->findAll($condition);


          $skuinfos = array();
          foreach ($allskuinfos as $skuinfo) {
          $skuinfos['bar'][$skuinfo->relationship_id]['relationship'] = $skuinfo->relationship;
          $skuinfos['bar'][$skuinfo->relationship_id]['system']= $skuinfo->system;
          $skuinfos['stackbar']['relations'][$skuinfo->relationship_id] = $skuinfo->relationship->name;

          if ($skuinfo->sku_id == $skuid) {
          $skuinfos['bar'][$skuinfo->relationship_id]['self'] = array($skuinfo->sku, $skuinfo);
          $skuinfos['stackbar']['self'] = array($skuinfo->sku, $skuinfo);
          } else {
          $skuinfos['bar'][$skuinfo->relationship_id]['skus'][] = array($skuinfo->sku, $skuinfo);
          $skuinfos['stackbar']['skus'][$skuinfo->sku->name][] = array($skuinfo->sku, $skuinfo);
          }

          }
         */
        /* $orders = array(
          'order' => $orderModel,
          'lastorder' => $lastorderModel,
          ); */

        $kopciinfos = array(
            'koandpcis' => $koandpcisnew,
            'lastkoandpcis' => $lastkoandpcisnew
        );
        //数据返回


        $progress = isset($totalfixed->progress) ? $totalfixed->progress : "";
        $infos['totalfixed'] = array($totalfixed, $progress);
        // $infos['totalfixed'] = $totalfixed;
        $infos['kopciinfos'] = $kopciinfos;
        //  $infos['orders'] = $orders;
        $infos['koinfos'] = $koinfos;
        $infos['koinfoss'] = $koinfoss;
        //-1代表YTD，0代表月，1代表期数
        $ismonth = isset($totalfixed->stage) && $totalfixed->stage == -1 ? -1 : (isset($totalfixed->stage) && $totalfixed->stage == 0 ? 0 : 1);
//        $ismonths = ;//月
        $infos['labels'] = [
            'lastvalue' => Yii::t('cvs', $ismonth == -1 ? '去年' : ($ismonth == 1 ? '上期' : '上月')),
            'thisvalue' => Yii::t('cvs', $ismonth == -1 ? '今年' : ($ismonth == 1 ? '本期' : "本月")),
            'totalindex' => Yii::t('cvs', $ismonth == -1 ? '全国指标' : ($ismonth == 1 ? '全国指标' : "全国指标")),
            'schedule' => Yii::t('cvs', $ismonth == -1 ? '核查完成度' : ($ismonth == 1 ? '核查完成度' : "核查完成度")),
            'lastcompare' => Yii::t('cvs', $ismonth == -1 ? '同去年相比' : ($ismonth == 1 ? '同上期相比' : "同上月相比")),
        ];
        // $infos['allskuinfos'] = $skuinfos;
        //pd(CJSON::encode($infos));
        if ($return) {
            return $infos;
        } else
            echo CJSON::encode($infos);
    }

    /**
     * This is the default 'index' action that is invoked  这是调用的默认“索引”操作
     * when an action is not explicitly requested by users. 当用户没有明确请求操作时。
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php' 呈现视图文件“protected / views / site / index .PHP”
        // using the default layout 'protected/views/layouts/main.php' 使用默认布局“protected / views /布局/main.php”
        //$lastMonth = $this->GetMonth();

        $searchmodel = new Search('search');
        $time = Info::model()->with('time')->find(array('order' => 't.time_id desc'));
        $infoList = null;
        if (isset($_GET['Search'])) {
            $searchmodel->unsetAttributes();
            $searchmodel->attributes = $_GET['Search'];
            //清空下拉菜单
            if (isset($_GET['cityid'])) {
                if ($_GET['cityid'] == 'Search_region') {
                    $searchmodel->factory = '';
                    $searchmodel->city = '';
                } elseif ($_GET['cityid'] == 'Search_factory') {
                    $searchmodel->city = '';
                }
            }
        }
        //饼图的配售，可见，点购数据
        $criteria_ko = new CDbCriteria();
        $criteria_pci = new CDbCriteria();
        if (!empty($searchmodel->city)) {
            $criteria_ko->addCondition('t.relationship_id=' . $searchmodel->city);
            $criteria_pci->addCondition('t.relationship_id=' . $searchmodel->city);
        } elseif (!empty($searchmodel->factory)) {
            $criteria_ko->addCondition('t.relationship_id=' . $searchmodel->factory);
            $criteria_pci->addCondition('t.relationship_id=' . $searchmodel->factory);
        } elseif (!empty($searchmodel->region)) {
            $criteria_ko->addCondition('t.relationship_id=' . $searchmodel->region);
            $criteria_pci->addCondition('t.relationship_id=' . $searchmodel->region);
        } else {
            $criteria_ko->addCondition('t.relationship_id=4');
            $criteria_pci->addCondition('t.relationship_id=4');
        }
        if (empty($searchmodel->mode)) {
            $criteria_ko->addCondition('sku_id=6');
            $criteria_pci->addCondition('sku_id=33');
        } else {
            if ($searchmodel->mode == 1) {
                $conditionmode_ko = 'parent=6 and name="单品"';
                $conditionmode_pci = 'parent=33 and name="单品"';
            } else {
                $conditionmode_ko = 'parent=6 and name="套餐"';
                $conditionmode_pci = 'parent=33 and name="套餐"';
            }
            $criteria_ko->addInCondition('sku_id', CHtml::listData(Sku::model()->findAll($conditionmode_ko), 'Id', 'Id'));
            $criteria_pci->addInCondition('sku_id', CHtml::listData(Sku::model()->findAll($conditionmode_pci), 'Id', 'Id'));
        }
        $criteria_ko->index = 'sku_id';
        $criteria_ko->with = array('time');
        $criteria_pci->index = 'sku_id';
        $criteria_pci->with = array('time');
        if (empty($searchmodel->month)) {
            $searchmodel->month = $time->time->time;
        }
        $criteria_ko->compare('time.time', $searchmodel->month);
        $infoList_ko = Info::model()->find($criteria_ko);
        $criteria_pci->compare('time.time', $searchmodel->month);
        $infoList_pci = Info::model()->find($criteria_pci);

        //表格里面的总订单数量数据
        $criteria1 = new CDbCriteria();
        if (!empty($searchmodel->city)) {
            $criteria1->addCondition('relationship_id=' . $searchmodel->city);
        } elseif (!empty($searchmodel->factory)) {
            $criteria1->addCondition('relationship_id=' . $searchmodel->factory);
        } elseif (!empty($searchmodel->region)) {
            $criteria1->addCondition('relationship_id=' . $searchmodel->region);
        } else {
            $criteria1->addCondition('relationship_id=4');
        }
        $criteria1->with = array('time', 'relationship');
        $criteria1->compare('time.time', $searchmodel->month);
        $orderModel = Order::model()->find($criteria1);

        //上月表格里面的总订单数量数据
        $dateTime = $this->GetLastMonth($searchmodel->month);
        $lastCriteria1 = new CDbCriteria();
        if (!empty($searchmodel->city)) {
            $lastCriteria1->addCondition('relationship_id=' . $searchmodel->city);
        } elseif (!empty($searchmodel->factory)) {
            $lastCriteria1->addCondition('relationship_id=' . $searchmodel->factory);
        } elseif (!empty($searchmodel->region)) {
            $lastCriteria1->addCondition('relationship_id=' . $searchmodel->region);
        } else {
            $lastCriteria1->addCondition('relationship_id=4');
        }
        $lastCriteria1->with = array('time', 'relationship');
        $lastCriteria1->compare('time.time', $dateTime);
        $lastOrderModel = Order::model()->find($lastCriteria1);

        //表格中可见订单数量
        $visibleCriteria1 = new CDbCriteria();
        if (empty($searchmodel->category)) {
            if (empty($searchmodel->mode)) {
                $categ = 'Id=6';
            } else {
                if ($searchmodel->mode == 1) {
                    $categ = 'parent=6 and name="单品"';
                } else {
                    $categ = 'parent=6 and name="套餐"';
                }
            }
        } else {
            if (empty($searchmodel->mode)) {
                $categ = 'Id=' . $searchmodel->category;
            } else {
                if ($searchmodel->mode == 1) {
                    $categ = "parent=$searchmodel->category and name='单品'";
                } else {
                    $categ = "parent=$searchmodel->category and name='套餐'";
                }
            }
        }
        $sku_Id = Sku::model()->find($categ);
        if (!empty($searchmodel->city)) {
            $visibleCriteria1->addCondition('relationship_id=' . $searchmodel->city);
        } elseif (!empty($searchmodel->factory)) {
            $visibleCriteria1->addCondition('relationship_id=' . $searchmodel->factory);
        } elseif (!empty($searchmodel->region)) {
            $visibleCriteria1->addCondition('relationship_id=' . $searchmodel->region);
        } else {
            $visibleCriteria1->addCondition('relationship_id=4');
        }
        $visibleCriteria1->addCondition('t.sku_id=' . (isset($sku_Id->Id) ? $sku_Id->Id : '0'));
        $visibleCriteria1->with = array('time', 'relationship');
        $visibleCriteria1->compare('time.time', $searchmodel->month);
        $upModel = Info::model()->find($visibleCriteria1);

        //$upModel = Order::model()->find($criteria2);
        //上月表格中可见订单数量
        $lastVisibleCriteria1 = new CDbCriteria();
        if (empty($searchmodel->category)) {
            if (empty($searchmodel->mode)) {
                $lastCateg = 'Id=6';
            } else {
                if ($searchmodel->mode == 1) {
                    $lastCateg = 'parent=6 and name="单品"';
                } else {
                    $lastCateg = 'parent=6 and name="套餐"';
                }
            }
        } else {
            if (empty($searchmodel->mode)) {
                $lastCateg = 'Id=' . $searchmodel->category;
            } else {
                if ($searchmodel->mode == 1) {
                    $lastCateg = "parent=$searchmodel->category and name='单品'";
                } else {
                    $lastCateg = "parent=$searchmodel->category and name='套餐'";
                }
            }
        }
        $last_sku_Id = Sku::model()->find($lastCateg);
        if (!empty($searchmodel->city)) {
            $lastVisibleCriteria1->addCondition('relationship_id=' . $searchmodel->city);
        } elseif (!empty($searchmodel->factory)) {
            $lastVisibleCriteria1->addCondition('relationship_id=' . $searchmodel->factory);
        } elseif (!empty($searchmodel->region)) {
            $lastVisibleCriteria1->addCondition('relationship_id=' . $searchmodel->region);
        } else {
            $lastVisibleCriteria1->addCondition('relationship_id=4');
        }
        $lastVisibleCriteria1->addCondition('t.sku_id=' . (isset($last_sku_Id->Id) ? $last_sku_Id->Id : '0'));
        $lastVisibleCriteria1->with = array('time', 'relationship');
        $lastVisibleCriteria1->compare('time.time', $dateTime);
        $lastUpModel = Info::model()->find($lastVisibleCriteria1);

        //上月软饮料表格中数据
        $lastCriteria_pci = new CDbCriteria();
        if (!empty($searchmodel->city)) {
            $lastCriteria_pci->addCondition('t.relationship_id=' . $searchmodel->city);
        } elseif (!empty($searchmodel->factory)) {
            $lastCriteria_pci->addCondition('t.relationship_id=' . $searchmodel->factory);
        } elseif (!empty($searchmodel->region)) {
            $lastCriteria_pci->addCondition('t.relationship_id=' . $searchmodel->region);
        } else {
            $lastCriteria_pci->addCondition('t.relationship_id=4');
        }
        if (empty($searchmodel->mode)) {
            $lastCriteria_pci->addCondition('sku_id=33');
        } else {
            if ($searchmodel->mode == 1) {
                $lastConditionmode_pci = 'parent=33 and name="单品"';
            } else {
                $lastConditionmode_pci = 'parent=33 and name="套餐"';
            }
            $lastCriteria_pci->addInCondition('sku_id', CHtml::listData(Sku::model()->findAll($lastConditionmode_pci), 'Id', 'Id'));
        }
        $lastCriteria_pci->index = 'sku_id';
        $lastCriteria_pci->with = array('time');
        if (empty($searchmodel->month)) {
            $searchmodel->month = $time->time->time;
        }
        $lastCriteria_pci->compare('time.time', $dateTime);
        $lastInfoList_pci = Info::model()->find($lastCriteria_pci);

        //固定全国KO配售，可见，点购 relationship_id=4为全国,sku_id=6为KO
        $fixed = Info::model()->with('time')->find('time.time =:time and relationship_id=4 and sku_id=6', array(':time' => $time->time->time));

        //全部
        $group = CHtml::listData(Relationship::model()->findAll('parent=0'), 'Id', 'name');

        //固定集团KO配售率增长率
        $mapCriteria = new CDbCriteria();
        $mapCriteria->addInCondition('relationship_id', array(1, 2, 3));
        $mapCriteria->compare('time.time', $time->time->time);
        $mapCriteria->addCondition('sku_id=6');
        $mapCriteria->index = 'relationship_id';
        $map = Info::model()->with('time')->findAll($mapCriteria);
        //$this->pd($map);
        //装瓶厂
        if (!empty($searchmodel->region) && $searchmodel->region != 4) {
            $groupcondition = 'depth=2 and parent=' . $searchmodel->region;
        } else {
            $groupcondition = 'depth=2';
        }
        $factory = CHtml::listData(Relationship::model()->findAll($groupcondition), 'Id', 'name');

        //城市
        if (!empty($searchmodel->factory)) {
            $factorycondition = 'depth=3 and parent=' . $searchmodel->factory;
        } else {
            $factorycondition = 'depth=3';
        }
        $city = CHtml::listData(Relationship::model()->findAll($factorycondition), 'Id', 'name');

        //地图
        if (!empty($searchmodel->city)) {
            $citymap = array_values(CHtml::listData(Relationship::model()->findAllByPk($searchmodel->city), 'Id', 'city_coordinate'));
            $address = isset($city[$searchmodel->city]) ? $city[$searchmodel->city] : '';
        } elseif (!empty($searchmodel->factory)) {
            $citymap = array_values(CHtml::listData(Relationship::model()->findAll('Id in (' . implode(',', array_flip($city)) . ')'), 'Id', 'city_coordinate'));
            $address = isset($factory[$searchmodel->factory]) ? $factory[$searchmodel->factory] : '';
        } elseif (!empty($searchmodel->region)) {
            $citymap = array_values(CHtml::listData(Relationship::model()->findAll('Id in (' . implode(',', CHtml::listData(Relationship::model()->findAll('parent in (' . implode(',', array_flip($factory)) . ')'), 'Id', 'Id')) . ')'), 'Id', 'city_coordinate'));
            $address = isset($group[$searchmodel->region]) ? $group[$searchmodel->region] : '';
        } else {
            $citymap = array_values(CHtml::listData(Relationship::model()->findAll('depth=3'), 'Id', 'city_coordinate'));
            $address = '全国';
        }
        //print_r($citymap);
        //全品类
        $category = CHtml::listData(Sku::model()->findAll('depth=1 or depth = 2'), 'Id', 'name');
        if (!empty($searchmodel->category)) {
            $cate = isset($category[$searchmodel->category]) ? $category[$searchmodel->category] : '';
        } else {
            $cate = 'KO';
        }

        $categorys = CHtml::listData(Sku::model()->findAll('depth=1'), 'Id', 'name');
        if (!empty($searchmodel->category)) {
            $cates = isset($category[$searchmodel->category]) ? $category[$searchmodel->category] : '';
        } else {
            $cates = '全品类';
        }
        //$this->pd($categorys);
        //方式
        //$mode = CHtml::listData(Sku::model()->findAll('depth=3'),'Id','name');
        //品类
        $brand = CHtml::listData(Sku::model()->findAll('depth=2'), 'Id', 'name');
        //$this->pd($brands);
        //$this->pd($searchmodel);
        //时间
        //配售率上海
        $pslsh = Info::model()->with('sku')->findAll('time_id = 29 and relationship_id = 76');

        $info = array();
        foreach ($pslsh as $k => $v) {
            $info[$v->sku->name] = $v->attach_rate * 10;
        }
        //全国品类
        //$national =Info::model()->with('sku')->with('relationship')->findAll('sku.depth=1 and relationship.depth=3 ');
        //全国瓶装集团（默认瓶装集团的汽水）
        //$bottlingg =Info::model()->with('sku')->with('relationship')->findAll('sku.parent=2 and relationship.parent=0 ');
        //$this->pd($national);
        //时间
        $totalfixed = Info::model()->with('time')->find('time.time =:time and relationship_id=4 and sku_id=6', array(':time' => $time->time->time));
        if (empty($searchmodel->category)) {
            $searchmodel->category = 0;
        }
        $skulist = Sku::model()->findAll('parent=:parent', array(':parent' => $searchmodel->category));
//		if(empty($searchmodel->category)){
//			$sku = 2;
//		}else{
//			$sku = $searchmodel->category;
//		}
        $skulist = Sku::model()->findAll('parent=:parent', array(':parent' => $categ));
        $searchmodel->brand = CHtml::listData($skulist, 'Id', 'name');
        //$this->pd($searchmodel->category);
        $infoz = Info::model()->with('sku')->with('relationship')->findAll(' sku.parent=' . $searchmodel->category . ' and relationship.depth=3 and city_coordinate in ( ' . implode(',', $citymap) . ')');
        if ($cates == '全品类') {
            $infos = Info::model()->with('sku')->with('relationship')->findAll('relationship.depth=3 and city_coordinate in ( ' . implode(',', $citymap) . ')');
        } else {
            $infos = Info::model()->with('sku')->with('relationship')->findAll('sku.name="' . $cates . '" and relationship.depth=3  and city_coordinate in ( ' . implode(',', $citymap) . ')');
        }


        $sj = '"2017-05","2017-06","2017-07","2017-08","2017-09"';
        //$infoss  = Info::model()->with('sku')->with('relationship')->findAll('sku.name="果汁" and relationship.depth=3  and city_coordinate in ( '.implode(',',$citymap).')');
        //$this->pd($infoss);
        //$this->pd($searchmodel->city);
        if ($searchmodel->city) {
            $cityzz = Relationship::model()->find('Id="' . $searchmodel->city . '"')->name;
        } else {
            $cityzz = "上海";
        }
        $infoss = Info::model()->with('time')->with('sku')->with('relationship')->findAll('time.time in (' . $sj . ') and  sku.parent=' . $searchmodel->category . '  and relationship.depth=3  and relationship.name = "' . $cityzz . '"');
        //$this->pd($infoss);
        $aa = array();
        foreach ($infoss as $k => $v) {
            $aa[$v->sku->name]['Preceding_availability'][] = 1;
            $aa[$v->sku->name]['Preceding_availability'][] = 1;
            $aa[$v->sku->name]['Preceding_availability'][] = 1;
            $aa[$v->sku->name]['Preceding_availability'][] = 1;
            $aa[$v->sku->name]['Preceding_availability'][] = $v->Preceding_availability;
        }
        //可见率1
        $infossb = Info::model()->with('time')->with('sku')->with('relationship')->findAll('time.time in(' . $sj . ') and  sku.parent=' . $searchmodel->category . ' and relationship.depth=3 and relationship.name="' . $cityzz . '" ');
        $bb = array();
        foreach ($infossb as $k => $v) {
            $bb[$v->sku->name]['availability'][] = 1;
            $bb[$v->sku->name]['availability'][] = 1;
            $bb[$v->sku->name]['availability'][] = 1;
            $bb[$v->sku->name]['availability'][] = 1;
            $bb[$v->sku->name]['availability'][] = $v->availability;
        }
        //配售率2
        $infossa = Info::model()->with('time')->with('sku')->with('relationship')->findAll('time.time in (' . $sj . ') and sku.parent=' . $searchmodel->category . ' and relationship.depth=3  and relationship.name = "' . $cityzz . '"');
        //$this->pd($infossa);
        $cc = array();
        foreach ($infossa as $kk => $v) {
            $cc[$v->sku->name]['Preceding_Attach_Rate'][] = 1;
            $cc[$v->sku->name]['Preceding_Attach_Rate'][] = 1;
            $cc[$v->sku->name]['Preceding_Attach_Rate'][] = 1;
            $cc[$v->sku->name]['Preceding_Attach_Rate'][] = 1;
            $cc[$v->sku->name]['Preceding_Attach_Rate'][] = $v->Preceding_Attach_Rate;
        }
        //$this->pd($cc);
        $arry = array();
        $arrr = array();
        foreach ($infos as $v) {
            $arrr[$v->relationship->name][$v->sku->name]['availability'] = $v->availability;
            $arrr[$v->relationship->name][$v->sku->name]['Incidence'] = $v->Incidence;
            $arrr[$v->relationship->name][$v->sku->name]['attach_rate'] = $v->attach_rate;
            $arrr[$v->relationship->name][$v->sku->name]['Preceding_availability'] = $v->Preceding_availability;
            $arrr[$v->relationship->name][$v->sku->name]['Preceding_Incidence'] = $v->Preceding_Incidence;
            $arrr[$v->relationship->name][$v->sku->name]['Preceding_Attach_Rate'] = $v->Preceding_Attach_Rate;
        }
        //$this->pd($arrr);
        foreach ($infoz as $v) {
            //$array[$v->relationship_id]
            $arry[$v->relationship->name][$v->sku->name]['availability'] = $v->availability;
            $arry[$v->relationship->name][$v->sku->name]['Incidence'] = $v->Incidence;
            $arry[$v->relationship->name][$v->sku->name]['attach_rate'] = $v->attach_rate;
            $arry[$v->relationship->name][$v->sku->name]['Preceding_availability'] = $v->Preceding_availability;
            $arry[$v->relationship->name][$v->sku->name]['Preceding_Incidence'] = $v->Preceding_Incidence;
            $arry[$v->relationship->name][$v->sku->name]['Preceding_Attach_Rate'] = $v->Preceding_Attach_Rate;
        }
        //$this->pd($arry);
        //$this->pd($searchmodel);

        $this->render('index', array(
            'fixed' => $fixed,
            'group' => $group,
            'factory' => $factory,
            'city' => $city,
            'category' => $category,
            'brand' => $brand,
            'searchmodel' => $searchmodel,
            'infoList_ko' => $infoList_ko,
            'infoList_pci' => $infoList_pci,
            'info' => $info,
            'orderModel' => $orderModel,
//			'lastMonth'=>$lastMonth,
            'totalfixed' => $totalfixed,
            'citymap' => json_encode($citymap),
            'address' => $address,
            'upModel' => $upModel,
            'cate' => $cate,
            'arry' => $arry,
            'arrr' => $arrr,
            'aa' => $aa,
            'bb' => $bb,
            'cc' => $cc,
            'sj' => $sj,
            'cityzz' => $cityzz,
            'categorys' => $categorys,
            'cates' => $cates,
            //'$national'=>$national,
            //'$bottlingg'=>$bottlingg,
            'time' => $time,
            'lastOrderModel' => $lastOrderModel,
            'lastUpModel' => $lastUpModel,
            'lastInfoList_pci' => $lastInfoList_pci,
            'map' => $map
        ));
    }

    public function actionMap()
    {
        $city = $_GET['city'];
        print_r($city);
    }

    //单品 套餐
    /* public function isZZ($city='',$pinglie='',$taochang=''){
      $relModel = Relationship::model()->findAll('parent='.$city);
      if($relModel->depth==1){  //判断是集团吗

      }else if($relModel->depth==2){  //判读是装瓶厂吗

      }else if($relModel->depth==3){  //判断是城市吗

      }
      $skuModel = Sku::model()->findAll('parent='.$pinglie);
      if($skuModel==1){  //判断是否为大品类

      }else if($skuModel==2){ //判断是否为小品类

      }

      } */

    /**
     * This is the action to handle external exceptions. 这是处理外部异常的操作。
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

//	public function actionNum(){
//		set_time_limit(0);
//		 $model = Info::model()->findAll('time_id=31');
//		foreach ($model as $value){
//			$data = Order::model()->find('time_id=29');
//			if(!empty($data)){
//				$value->time_id=$data->time_id;
//				$value->save();
//			}
//		}
//	}

    /**
     * Displays the contact page 显示联系人页面46
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page 显示登录页46
     */
    public function actionLogin()
    {
        if (Yii::app()->params['kologin']) {
            $this->actionTestlogin();
        } else {
            $this->layout = false;
            $loginFormModel = new LoginForm();
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
                echo CActiveForm::validate($loginFormModel);
                Yii::app()->end();
            }
            if (isset($_POST['LoginForm'])) {
                $loginFormModel->attributes = $_POST['LoginForm'];


                if ($loginFormModel->validate() && $loginFormModel->login()) {
                    Yii::app()->session['logintime'] = time();
                    $this->redirect(array(yii::app()->user->returnurl));
                }
            }
            $this->render('login', array('loginFormModel' => $loginFormModel));
        }
    }

    /**
     * Logs out the current user and redirect to homepage. 注销当前用户并重定向到主页。
     */
    public function actionLogout()
    {
        echo "<pre>";var_dump($_COOKIE);

        Yii::app()->user->logout();
//        Yii::app()->session->clear();  //删除session变量
//        Yii::app()->session->destroy(); //删除服务器的session信息
        echo "<pre>";var_dump($_COOKIE);
        unset($_COOKIE);
        $this->clear();
        $this->redirect(array('login'));
    }
    public function clear() {
        $cookies = Yii::app()->request->getCookies();
//        $cookies->clear();
        unset($cookies);
    }
    public function actionBottlerzz()
    {
        $cs = $_POST['zb'];
        $Id = Sku::model()->find('name="' . $cs . '"')->Id;
        $rel = Sku::model()->findAll('parent=' . $Id);
        $arr = array();
        foreach ($rel as $v) {
            $arr[] = $v->name;
        }
        echo json_encode($arr);
    }

    public function actionTest()
    {
        $a = $this->getLastStage('2017-09', 2);
        pd($a);
    }

    public function actionChangeLanguage($language = 'zh_cn')
    {
        Yii::app()->session['language'] = $language;
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionZipimg()
    {
        $postdata = $_POST;
        if (isset($postdata['YII_CSRF_TOKEN'])) {
            unset($postdata['YII_CSRF_TOKEN']);
        }
        $file = "download/";
        $ziparr = [];
        $zip = 'download/' . time() . rand(100000, 9999999) . '.zip';
        $labelKey = Yii::app()->params['ziplabel'];
        if ($this->makeDir($file) && count($postdata) > 0) {
            foreach ($postdata as $key => $value) {
                $show_label = '';
                if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $value, $result)) {
                    $type = $result[2];
                    if (in_array(strtolower($type), array('jpg', 'png', 'gif', 'jpeg'))) {
                        $label_key = explode('_', $key);
                        if (isset($label_key[0]) && isset($label_key[1]) && isset($label_key[2]) && isset($labelKey[$label_key[1]]) && isset($labelKey[$label_key[2]])) {
                            $show_label = $label_key[0] . '-' . $labelKey[$label_key[1]] . '-' . $labelKey[$label_key[2]];
                        } else {
//                            $show_label = isset($label_key[0]) ? $label_key[0] : '';
//                            $show_label .= time() . rand(1000, 9999);
                            $show_label .= $key.rand(1000, 9999);
                        }
                        $new_file = $file . $show_label . ".{$type}";
//                        pd($new_file,$result,$value);
                        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $value)))) {
                            $ziparr[] = $new_file;
                        }
                    }
                }
            }
            if (count($postdata) == 1 && isset($ziparr[0])) {//下载单个PDF
                $mime = 'application/force-download';
                header('Pragma: public'); // required
                header('Expires: 0'); // no cache
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Cache-Control: private', false);
                header('Content-Type: ' . $mime);
                //header('Content-Disposition: attachment; filename=1.png');
                header('Content-Disposition: attachment; filename="' . basename($ziparr[0]) . '"');
                header('Content-Transfer-Encoding: binary');
                header('Connection: close');
                @readfile($ziparr[0]); // push it out
            } else {//压缩包
                $this->addimg($zip, $ziparr);
                header("Cache-Control: public");
                header('Expires: 0'); // no cache
                header("Content-Description: File Transfer");
                header('Content-disposition: attachment; filename=' . basename($zip)); //文件名
                header("Content-Type: application/zip"); //zip格式的
                header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
                header('Content-Length: ' . filesize($zip)); //告诉浏览器，文件大小
                @readfile($zip);
                //Yii::app()->request->sendFile('123.zip', file_get_contents($zip));
            }
        }
    }

    private function addimg($zipurl, $ziparr)
    {
        $zip = new ZipArchive();
        if ($zip->open($zipurl, ZipArchive::OVERWRITE | ZipArchive::CREATE)) {
            for ($i = 0; $i < count($ziparr); $i++) {
                $zip->addFile($ziparr[$i]);
            }
            $zip->close(); //关闭处理的zip文件
        }
    }

//    public function actionInde()
//    {
//        Yii::app()->language = 'zh_cn';
//        echo Yii::t('app', 'Dashboard');
//    }

    public function actionCvsdata()
    {

        set_time_limit(0);
        ini_set('memory_limit', '1280M');

        $citytype = isset($_GET['citytype']) ? $_GET['citytype'] : 1;
        $systemtype = isset($_GET['systemtype']) ? $_GET['systemtype'] : 1;
        $skutype = isset($_GET['skutype']) ? $_GET['skutype'] : 1;


        $date = Time::model()->find(array('order' => 'Id desc'));
        $month = isset($_GET['month']) ? $_GET['month'] : $date->time;
        $stage = isset($_GET['stage']) ? $_GET['stage'] : 1;

        /**
         * 方法1
         */
        $condition = array('condition' => 'time=:time  and shelves=1 and  stage=:stage and relationship.depth=:r_depth and system.depth=:s_depth   and sku.depth=:sku_depth', 'params' => array(':time' => $month, ':stage' => $stage, ':r_depth' => $citytype, ':s_depth' => $systemtype, ':sku_depth' => $skutype), 'order' => 'sku.sort desc,relationship.sort asc,system.Id asc');

        $md5code = $this->makecode(array_merge($condition['params'], array('lang' => Yii::app()->language)));

        $returndata = Yii::app()->filecache->get($md5code);
        //$returndata=Yii::app()->memcache->get($md5code);
        if (!empty($returndata)) {

            echo $returndata;

            die;
        }


        $allskuinfos = InfoCvs::model()->with('sku', 'relationship', 'system')->findAll($condition);


        //pd($allskuinfos);

        /**
         *
         * 铺货门店数不分sku
         * $ordercondition = array('condition' => 'time=:time  and shelves=1 and  stage=:stage and relationship.depth=:r_depth and system.depth=:s_depth ', 'params' => array(':time' => $month, ':stage' => $stage,':r_depth'=>$citytype,':s_depth'=>$systemtype));
         * $orderinfos = OrderCvs::model()->with('relationship','system')->findAll($ordercondition);
         */
        /**
         * 方法2
         */
        /* $citylist=CHtml::listData(RelationshipCvs::model()->findAll('depth=:depth',array(':depth'=>$citytype)),'Id','Id');
          $systemlist=CHtml::listData(SystemCvs::model()->findAll('depth=:depth',array(':depth'=>$systemtype)),'Id','Id');
          $skulist=CHtml::listData(SkuCvs::model()->findAll('depth=:depth',array(':depth'=>$skutype)),'Id','Id');
          $criteria=new CDbCriteria();
          $criteria->addCondition('time="'.$month.'"');
          $criteria->addCondition('stage='.$stage);
          $criteria->addCondition('shelves=1');
          $criteria->addInCondition('t.relationship_id',$citylist);
          $criteria->addInCondition('t.system_id',$systemlist);
          $criteria->addInCondition('t.sku_id',$skulist);


          $allskuinfos = InfoCvs::model()->with('sku', 'relationship','system')->findAll($criteria); */
        /*  echo time()-$time;
          pd($allskuinfos); */
        // pd($citylist,$systemlist,$skulist);
        $skuinfos = array();
        $skudata = [];
        foreach ($allskuinfos as $skuinfo) {
            $skuinfos['bar'][$skuinfo->relationship_id][$skuinfo->system_id]['skus'][] = array($skuinfo->sku, $skuinfo);
            $skuinfos['bar'][$skuinfo->relationship_id][$skuinfo->system_id]['relationship'] = $skuinfo->relationship;
            $skuinfos['bar'][$skuinfo->relationship_id][$skuinfo->system_id]['system'] = $skuinfo->system;


            $skudata['stackbar']['relations'][$skuinfo->relationship_id] = $skuinfo->relationship->name;
            $skudata['stackbar']['skus'][$skuinfo->sku->name][] = array($skuinfo->sku, $skuinfo);
            $skudata['stackbar']['systems'][$skuinfo->system_id] = $skuinfo->system->name;
        }


        /* $skudata['stackbar']['orderinfo']=$orderinfos; */
        // pd($allskuinfos);

        foreach ($skuinfos as $v) {
            foreach ($v as $vv) {
                foreach ($vv as $vvv) {
                    $skudata['bar'][] = $vvv;
                }
                // $skudata['bar'][]=$vv;
            }
        }
        //
        //  pd($allskuinfos,$skuinfos);

        $returndata = CJSON::encode($skudata);

        // Yii::app()->filecache->set($md5code,$returndata,Yii::app()->params['cache']['cvsdatatime']);
        Yii::app()->filecache->set($md5code, $returndata, Yii::app()->params['cache']['cvsdatatime']);
        // Yii::app()->memcache->set($md5code,$returndata,Yii::app()->params['cache']['cvsdatatime']);

        echo $returndata;
    }

    private function onlynumber($str)
    {
        preg_match_all('/\d+/', $str, $arr);
        return implode('', $arr[0]);
    }

    public function actionHistorycvsdata()
    {

        set_time_limit(0);
        ini_set('memory_limit', '1280M');

        $citytype = isset($_GET['citytype']) ? $_GET['citytype'] : 1;
        $systemtype = isset($_GET['systemtype']) ? $_GET['systemtype'] : 1;
        $skutype = isset($_GET['skutype']) ? $_GET['skutype'] : 1;


        $date = InfoCvs::model()->find(array('order' => 'time desc,stage desc'));
        $month = isset($_GET['month']) ? $_GET['month'] : $date->time;
        $stage = isset($_GET['stage']) ? $_GET['stage'] : $date->stage;
        $label = [];
        /*
        if ($stage == -1) {//月份比较
            $label = InfoCvs::monthdata();
            sort($label);
            // pd($label);
        } else {//期数比较
            $stagesql = 'select DISTINCT(time),stage from cola_info_cvs where stage!=-1 ORDER BY time desc,stage desc LIMIT 6';
            $stagelist = Yii::app()->db->createCommand($stagesql)->queryAll();
            $label = [];
            for ($i = 0; $i < count($stagelist); $i++) {
                $label[] = $stagelist[$i]['time'] . '-' . $stagelist[$i]['stage'];
            }
        }
        //pd($label);
        if (count($label) < 5) {
            $add = array_fill(0, 5 - count($label), '');
            $label = array_merge($add, $label);
        } elseif (count($label) > 5) {
            $label = array_slice($label, 0, 5);
        }

        */
        //pd($label);
        $condition = array('condition' => 't.time=:time  and t.shelves=1 and  t.stage=:stage and relationship.depth=:r_depth and system.depth=:s_depth   and sku.depth=:sku_depth', 'params' => array(':time' => $month, ':stage' => $stage, ':r_depth' => $citytype, ':s_depth' => $systemtype, ':sku_depth' => $skutype));


        $md5code = $this->makecode(array_merge($condition['params'], array('type' => 'csvhistory', 'lang' => Yii::app()->language)));
        // pd(array_merge($condition['params'],array('type'=>'csvhistory')),$md5code);
        $returndata = Yii::app()->filecache->get($md5code);
        if (!empty($returndata)) {

            echo $returndata;

            die;
        }

        if ($stage == -1) { //YTD
            $allskuinfos = InfoCvs::model()->with('sku', 'relationship', 'system', 'monhistory')->findAll($condition);
        } else if ($stage == 0) {  //月值
            $allskuinfos = InfoCvs::model()->with('sku', 'relationship', 'system', 'monthHistory')->findAll($condition);
        } else {//期数的值
            $allskuinfos = InfoCvs::model()->with('sku', 'relationship', 'system', 'history')->findAll($condition);
        }
        $skuinfos = array();
        $skudata = [];
        $label = [];
        $historylabels = [];
        foreach ($allskuinfos as $skuinfo) {
            if ($stage == -1) {
                $skuinfos['bar'][$skuinfo->relationship_id][$skuinfo->system_id]['skus'][] = array($skuinfo->sku, $skuinfo, array_slice($skuinfo->monhistory, 0, 5));
                //$label = array_values(CHtml::listdata(array_slice($skuinfo->monhistory, 0, 5),'time','time'));
                if (empty($historylabels)) $historylabels = array_slice($skuinfo->monhistory, 0, 5);
            } else if ($stage == 0) {
                $skuinfos['bar'][$skuinfo->relationship_id][$skuinfo->system_id]['skus'][] = array($skuinfo->sku, $skuinfo, array_slice($skuinfo->monthHistory, 0, 5));
                //$label = array_values(CHtml::listdata(array_slice($skuinfo->monhistory, 0, 5),'time','time'));
                if (empty($historylabels)) $historylabels = array_slice($skuinfo->monthHistory, 0, 5);
            } else {
                $skuinfos['bar'][$skuinfo->relationship_id][$skuinfo->system_id]['skus'][] = array($skuinfo->sku, $skuinfo, array_slice($skuinfo->history, 0, 5));
                //$label = array_values(CHtml::listdata(array_slice($skuinfo->history, 0, 5),'time','time'));
                if (empty($historylabels)) $historylabels = array_slice($skuinfo->history, 0, 5);
            }
            $skuinfos['bar'][$skuinfo->relationship_id][$skuinfo->system_id]['relationship'] = $skuinfo->relationship;
            $skuinfos['bar'][$skuinfo->relationship_id][$skuinfo->system_id]['system'] = $skuinfo->system;


            $skudata['stackbar']['relations'][$skuinfo->relationship_id] = $skuinfo->relationship->name;
            $skudata['stackbar']['skus'][$skuinfo->sku->name][] = array($skuinfo->sku, $skuinfo);
            $skudata['stackbar']['systems'][$skuinfo->system_id] = $skuinfo->system->name;
        }

        foreach ($historylabels as $hlabel) {
            if ($stage == -1) {
                $label[] = $hlabel->time;
            } elseif ($stage == 0) {
                $label[] = $hlabel->time;
            } else {
                $label[] = $hlabel->time . "-" . $hlabel->stage;
            }
        }

//pd(array_column($skuinfos['bar'],'skus'));

        foreach ($skuinfos as $v) {
            foreach ($v as $vv) {
                foreach ($vv as $vvv) {
                    $skudata['bar'][] = $vvv;
                }
            }
        }
        $label = array_reverse($label);
        $skudata['stackbar']['label'] = $label;


        $returndata = CJSON::encode($skudata);

        Yii::app()->filecache->set($md5code, $returndata, Yii::app()->params['cache']['cvsdatatime']);

        echo $returndata;
    }

    public function cvstime($month = false)
    {
        //$sql='select * from test GROUP by month,stage';

        if ($month) {
            $sql = 'select Id,time,stage from cola_info_cvs where stage=0 GROUP by time,stage';
        } else {
            $sql = 'select Id,time,stage from cola_info_cvs where stage!=0 GROUP by time,stage';
        }


        $res = Yii::app()->db->createCommand($sql)->queryAll();

        $arr = [];
        for ($i = 0; $i < count($res); $i++) {
            $key = $this->onlynumber($res[$i]['time']) . $res[$i]['stage'];
            $arr[$key] = $res[$i];
        }
        krsort($arr);


        return $arr;

        /* $b=array_slice($arr,0,2,true);
          $c=array_reverse($b,true); */
        //pd($res,$arr,$b,$c);
    }

    public function returntime()
    {
        $arr = $this->cvstime();
        $value = '2017102';
        $add = [];
        $i = 0;
        $length = 2; //需要保留的长度
        foreach ($arr as $k => $v) {
            if ($value == $k) {
                $i++;
            }
            if ($i > 0) {
                if ($i > $length) {
                    break;
                }
                $add[] = $v;
                $i++;
            }
        }
        // pd($arr,$add,$i);
    }

    private function makecode($arr)
    {
        $str = implode(',', $arr);
        return md5($str);
    }

    public function getLastStage($month, $stage)
    {

        $laststage = '0000000';
        if ($stage == 0) {
            $arr = $this->cvstime(true);
            $key = $this->onlynumber($month) . '0';
        } else {
            $arr = $this->cvstime();
            $key = $this->onlynumber($month) . $stage;
        }

        // pd($arr,$key);
        if (!empty($arr)) {
            $return = 0;
            foreach ($arr as $k => $v) {
                if ($return == 1) {
                    $laststage = $k;
                    break;
                }
                if ($k == $key) {
                    $return++;
                }
            }
        }
        return array(substr($laststage, 0, 4) . '-' . substr($laststage, 4, 2), substr($laststage, -1, 1));
    }

    public function actionTestlogin()
    {
        $domain = Yii::app()->params['at']['url'];
        $route = 'connect/authorize';

        $hosturl = Yii::app()->request->hostInfo . Yii::app()->createUrl('site/getat');
        //$hosturl='https://www.dashboard.com/callback';
        $params = array(
            'response_type' => 'code',
            'client_id' => Yii::app()->params['at']['client_id'],
            'redirect_uri' => $hosturl,
            'scope' => 'OAuth2Api offline_access',
            //'state'=>'xyz'
        );
        $str_params = '?' . http_build_query($params);
        //  $url=$domain.$route.'?response_type=code&client_id=2&redirect_uri='.$hosturl;
        //pd($params,$str_params,$domain.$route.$str_params);
        $this->redirect($domain . $route . $str_params);
        //Header('Location:'.$url);
    }

    /**
     * http://cokedash.cntoge.com/index.php?r=site/getat
     */
    public function actionGetat()
    {
        if (isset($_GET['code'])) {
            $yiiparams = Yii::app()->params['at'];
            $domain = $yiiparams['url'];
            $route = 'connect/token';

            $params = array(
                'grant_type' => 'authorization_code',
                'code' => $_GET['code'],
                'redirect_uri' => Yii::app()->request->hostInfo . Yii::app()->createUrl('site/getat'),
                'client_id' => $yiiparams['client_id'],
                'client_secret' => $yiiparams['client_secret'],
            );
            // $params=json_encode($params);
            $res = $this->postCurl($params, $domain . $route);
            Yii::log(print_r($res, true), 'warning');
            /*  var_dump($res); */


            Yii::app()->filecache->set('token', $res, 3600);
            // echo '<pre>';
            // print_r($res);

            if ($this->KOLogin()) {
                Yii::app()->session['logintime'] = time();
                $this->redirect(array(Yii::app()->user->returnurl));
            } else {
                $this->redirect(array('login'));
            }
            //  print_r(Yii::app()->filecache->get('token'));
        }else{
            echo "不存在的code";
            die;
        }
    }

    private function KOLogin()
    {
        $KOIdentity = new KOUserIdentity();
        $KOIdentity->authenticate();

        // echo '<pre>';
        //print_r($this);die;
        if ($KOIdentity->errorCode === KOUserIdentity::ERROR_NONE) {

            $duration = 3600; // 7 days
            //var_dump($this->rememberMe ); die;
            if (yii::app()->user->allowAutoLogin)
                Yii::app()->user->login($KOIdentity, $duration);
            else
                Yii::app()->user->login($KOIdentity);
            //var_dump(Yii::app()->user->isGuest);die;
            return true;
        } else {
            //echo 2;die;
            return false;
        }
    }

    public function actionRefreshat()
    {
        $domain = 'https://fedlogin.icoke.cn:8081/';
        $route = 'connect/token';
        $yiiparams = Yii::app()->params['at'];
        $token = Yii::app()->filecache->get('token');
        $params = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => isset($token['refresh_token']) ? $token['refresh_token'] : "", //getat 获得的refresh_token
            'client_id' => $yiiparams['client_id'],
            'client_secret' => $yiiparams['client_secret'],
        );
        //  $params=json_encode($params);

        print_r($params);
        die;
        $res = $this->postCurl($params, $domain . $route);

        echo '<pre>';
        print_r($res);
    }

    public function actionUserinfo()
    {
        $domain = 'https://fedlogin.icoke.cn:8081/';
        $route = 'OAuth2Api/UserInfo';
        $token = Yii::app()->filecache->get('token');


        // print_r($token);die;
        //$at='aaaa';
        $header = array('Authorization:Bearer ' . (isset($token['access_token']) ? $token['access_token'] : ""));
        $res = $this->getCurl('', $domain . $route, $header);

        echo '<pre>';
        print_r($res);
    }

    public function actionAtlogout()
    {
        $domain = Yii::app()->params['at']['url'];
        $route = 'Account/Logout';
        $data = [
            'logoutId' => Yii::app()->params['at']['client_id']
        ];

        $params = '?' . http_build_query($data);
        //pd($domain.$route.$params);
        $this->redirect($domain . $route . $params);
        /* $res=$this->getCurl($data,$domain.$route,false);
          echo '<pre>';
          print_r($res); */
    }

    //CVS期报
//    public function actionDoucumentCvs()
//    {
//        $status = 0;
//        $info = '您没有权限访问';
//        if (isset($_POST['sj'])&&isset($_POST['stage'])) {
//            $sj = $_POST['sj'];
//            $stage = $_POST['stage'];
//
//            $user = User::model()->findByPk(Yii::app()->user->id);
//            if (!empty($user)) {
//                if ($user->is_download == 0) {
//                    echo $this->returnjson(array('info' => $info, 'status' => 1));
//                }
//                $user->updatedataCvs();
//                $criteria = new CDbCriteria();
//                $criteria->addCondition('time="' . $sj . '" and stage="'.$stage.'"');
//
//                $arr = [];
//                if ($user->jurisdiction == 'koProjectTeam') {
//                    //全部城市
//                } elseif ($user->jurisdiction == 'BG' || $user->jurisdiction == 'koFranchiseCl') {
//                    //集团
//                    $model = RelationshipCvs::model()->findAll("parent=" . $user->downloadRange); //得到该集团下的装瓶厂
//                    if (!empty($model)) {
//                        foreach ($model as $v) {
//                            $zpc = RelationshipCvs::model()->findAll("parent=" . $v->Id);
//                            if (!empty($zpc)) {
//                                foreach ($zpc as $vv) {  //得到城市
//                                    $arr[] = $vv->Id;
//                                }
//                            }
//                        }
//                    }
//
//
//                } elseif ($user->jurisdiction == 'OU' || $user->jurisdiction == 'koMDM') {
//                    //厂
//                    $model = RelationshipCvs::model()->findAll("parent=" . $user->downloadRange); //得到该装瓶厂下的城市
//                    $arr = CHtml::listData($model, 'Id', 'Id');
//                } else {
//                    $arr = [];
//                }
//                if ($user->jurisdiction == 'koProjectTeam') {
//
//                } else {
//                    if (empty($arr)) {
//                        $criteria->addCondition('1=0');
//                    } else {
//                        $criteria->addInCondition('city', $arr);
//                    }
//
//                }
//
//                $presentlist = Presentation::model()->findAll($criteria);
//                $info = [];
//                if (!empty($presentlist)) {
//                    foreach ($presentlist as $v) {
//                        if (isset($v->relationship->name)) {
//                            $add = array();
//                            $add['Id']=$v->Id;
//                            $add['city'] = $v->relationship->name;
//                            $add['url'] = $v->downloadLinks;
//                            $info[] = $add;
//                        }
//                    }
//                }
//                if (empty($info)) {
//                    $status = 0;
//                } else {
//                    $status = 1;
//
//                }
//            }
//        }
//        echo $this->returnjson(array('info' => $info, 'status' => $status));
//    }
    public function actionDoucumentCvs()
    {
        $status = 0;
        $info = '您没有权限访问';
        if (isset($_POST['sj'])) {
            $sj = $_POST['sj'];
            $criteria = new CDbCriteria();
            $criteria->addCondition('time="' . $sj . '"');
            $criteria->order = "stage asc";
            $presentlist = Presentation::model()->findAll($criteria);
            $info = [];
            if (!empty($presentlist)) {
                foreach ($presentlist as $v) {
                    $add = array();
                    $add['Id'] = $v->Id;
                    $add['stage'] = $v->stage;
                    $add['url'] = $v->downloadLinks;
                    $info[] = $add;
                }
            }
            if (empty($info)) {
                $status = 0;
            } else {
                $status = 1;
            }
        }
        echo $this->returnjson(array('info' => $info, 'status' => $status));
    }

    public function actionUploadexcel()
    {
        if (isset($_GET['id'])) {
            $model = Presentation::model()->findByPk($_GET['id']);
            $runtimeurl = './uploads/cvs/runtime/';

            if (!empty($model) && file_exists($model->downloadLinks) && $this->makeDir($runtimeurl)) {
                $target_name = date('YmdHis') . rand(1000, 9999) . strrchr($model->downloadLinks, '.');
                @copy($model->downloadLinks, $runtimeurl . $target_name);
                yii::app()->request->sendFile($target_name, file_get_contents($runtimeurl . $target_name));
            }
        }
    }

    public function actionMysql()
    {

    }

    public function actionFlushcache()
    {
        if (isset($_GET['code']) && $_GET['code'] == '9ced64dccde2618c97fa77651f00a2ab') {
            var_dump(Yii::app()->filecache->flush());
        }
    }

    public function actionUploadZip()
    {
        if (isset($_GET['id'])) {
            $model = Presentation::model()->with('relationship')->findByPk($_GET['id']);
            $a = array_flip(Yii::app()->params['map_china']);
            if (isset($a[$model->relationship->name])) {
                $english = $a[$model->relationship->name];
            } else {
                $english = date('Ymd');
            }
            $runtimeurl = './uploads/o2o/runtime/';
            if (!empty($model) && file_exists('.' . $model->downloadLinks) && $this->makeDir($runtimeurl)) {
                $target_name = $english . strrchr($model->downloadLinks, '.');
                @copy('.' . $model->downloadLinks, $runtimeurl . $target_name);
                yii::app()->request->sendFile($target_name, file_get_contents($runtimeurl . $target_name));
            }
        }
    }

    public function actionSales()
    {
        $this->renderpartial('sales_map');
    }

    public function actionExcel()
    {
        $relationid = 1;
        $systemid = 1;
        $skuid = 80;
        $stage = 1;
        $month = '2017-09';
        $params = isset($_GET) ? $_GET : $_GET;

        if (count($params) > 1) {
            if ($params['region']) {
                $relationid = $params['region'];
            }
            if (!empty($params['factory'])) {
                $relationid = $params['factory'];
            }
            if (!empty($params['city'])) {
                $relationid = $params['city'];
            }

            $month = empty($params['month']) ? $month : $params['month'];
            $stage = isset($params['stage']) && !empty($params['stage']) ? $params['stage'] : 1;

            if (!empty($params['systemtype'])) {
                $systemid = $params['systemtype'];
            }
            if (!empty($params['system'])) {
                $systemid = $params['system'];
            }
            if (!empty($params['category'])) {
                $skuid = $params['category'];
            }
            if (!empty($params['brand'])) {
                $skuid = $params['brand'];
            }
            if (!empty($params['mode'])) {
                $skuid = $params['mode'];
            }
        }
        $list = InfoCvs::model()->with('sku', 'relationship', 'system', 'activityinfo', 'mechanisminfo', 'equipmentinfo')->findAll(array("condition" => "system_id = '$systemid' and relationship_id = '$relationid' and sku_id = '$skuid' and time='$month' and stage='$stage'"));
        //pd($list);
        for ($i = 0; $i < count($list); $i++) {
            $list[$i]['relationship_id'] = $list[$i]['relationship']->name;
            if ($list[$i]['stage'] == -1) {
                $list[$i]['stage'] = "YTD";
            } elseif ($list[$i]['stage'] > 0) {
                $list[$i]['stage'] = "第" . $list[$i]['stage'] . "期";
            }
            $list[$i]['system_id'] = $list[$i]['system']->name;
            $list[$i]['sku_id'] = $list[$i]['sku']->name;
            $list[$i]['shelves'] = Yii::app()->params['shelves'][$list[$i]['shelves']];
            $list[$i]['activity'] = isset($list[$i]['activityinfo']->activity) ? $list[$i]['activityinfo']->activity : '';
            $list[$i]['mechanism'] = isset($list[$i]['mechanisminfo']->mechanism) ? $list[$i]['mechanisminfo']->mechanism : '';
            $list[$i]['equipment'] = isset($list[$i]['equipmentinfo']->equipment) ? $list[$i]['equipmentinfo']->equipment : '';
        }
        $name = date('YmdHis') . rand(1000, 9999);
        $field = array('编号', '时间', '期数', '区域', '渠道', 'SKU', '货架', '活动', '机制', '设备', '铺货率', '排面占比', '零售价格店次占比', '活动发生率',
            '促销店次占比', '设备卖进率', '铺货率的变化率', '排面占比的变化率', '零售价格店次占比的变化率', '活动发生率的变化率', '促销店次占比的变化率',
            '设备卖进率的变化率', '铺货门店数', '店均货架排面数', '铺货门店数的变化率', '店均货架排面数的变化率', '额外二次陈列', '额外二次陈列的变化率',
            '二次陈列门店数', '二次陈列门店数的变化率', '可口可乐冰柜店均门数', '可口可乐冰柜店均门数的变化率'
        );
        $this->getExcel($name, $field, $list);
    }

    public function actionMarket($type = 'city')
    {
        $date = MarketCvs::model()->find(array('order' => 'time desc,stage desc'));
        $time = isset($date->time) ? $date->time : '2018-01';
        $stage = isset($date->stage) ? $date->stage : 1;
        $sql = 'select * from cola_market_cvs INNER JOIN cola_channel_cvs ON cola_market_cvs.channel_id = cola_channel_cvs.Id WHERE time = "' . $time . '"and stage = "' . $stage . '" and rank = "第一名" GROUP BY competition_grouping';
        $rank = Yii::app()->db->createCommand($sql)->queryAll();
        $list = [];
        for ($i = 0; $i < count($rank); $i++) {
            $list[$rank[$i]['competition_grouping']] = $rank[$i]['name'];
        }
        //查询B,C两组的第二名
        $sqlSecond = 'select * from cola_market_cvs INNER JOIN cola_channel_cvs ON cola_market_cvs.channel_id = cola_channel_cvs.Id WHERE time = "' . $time . '"and stage = "' . $stage . '" and rank = "第二名" and competition_grouping != "TierA" GROUP BY competition_grouping';
        $rankSecond = Yii::app()->db->createCommand($sqlSecond)->queryAll();
        $listSecond = [];
        for ($i = 0; $i < count($rankSecond); $i++) {
            $listSecond[$rankSecond[$i]['competition_grouping']] = $rankSecond[$i]['name'];
        }
        if ($type == 'city') {
            $market = MarketCvs::model()->with('channel')->findAll(array('condition' => 't.time=:time and t.stage = :stage', 'params' => array(':time' => $time, ':stage' => $stage), 'order' => 't.competition_grouping asc,channel.sort asc'));
        } else {
            $market = MarketCvs::model()->with('channel')->findAll(array('condition' => 't.time=:time and t.stage = :stage', 'params' => array(':time' => $time, ':stage' => $stage), 'order' => 't.competition_grouping asc,t.sort asc'));
        }
        $arr = [];
        for ($i = 0; $i < count($market); $i++) {
            $arr[$market[$i]['competition_grouping']][] = $market[$i];
        }
        $data['rank'] = $list;   //谁是第一名
        $data['market'] = $arr;
        $data['rankSecond'] = $listSecond;
        $this->render('market', array(
            'data' => $data,
            'type' => ($type == 'city') ? 'rank' : 'city',
        ));
    }

    public function actionHearder()
    {
//        $date = InfoCvs::model()->find(array('order'=>'time desc,stage desc'));
//        $month = isset($date->time)?$date->time:'2018-01';
//        $stage = isset($date->stage)?$date->stage:1;
        $stage = $turn = '';
        $newStage = $plan = $begin = $end = $turnMax = '';
        $params = isset($_GET['Search']) ? $_GET['Search'] : $_GET;
        $month = $params['month'];
        if (count($params) >= 1) {
            $turn = ProgressCvs::model()->find('time = "' . $params['month'] . '" and stage = ' . $params['mstage'] . '');
            $turnCvs = ProgressCvs::model()->find(array('condition' => 'time = "' . $params['month'] . '"', 'order' => 'turn desc'));
            $turnMax = isset($turnCvs['turn']) ? $turnCvs['turn'] : '';
            $newStage = isset($turn['turn']) ? $turn['turn'] : '';
            $begin = isset($turn['begin']) ? date('n.j', $turn['begin']) : '';
            $end = isset($turn['end']) ? date('n.j', $turn['end']) : '';
            if ($params['stage'] > 0) {
                $stage = $params['mstage'];
                $plan = isset($turn['completion_progress']) ? $turn['completion_progress'] : '';
            } elseif ($params['stage'] == -1) {
                $stage = -1;
                $plan = 1;
            } else {
                $stage = 0;
            }
        }
        $msg = [
            'newStage' => $newStage,
            'plan' => $plan,
            'begin' => $begin,
            'end' => $end,
            'month' => $month,
            'turnMax' => $turnMax
        ];
        $model = InfoCvs::model()->find("relationship_id=1 and system_id=1 and sku_id=80 and t.time='$month' and t.stage='$stage' and shelves=1");
//        pd($model,$msg);
        $total = [$model, $msg];
        echo CJSON::encode($total);
    }

    public function actionSettemplate()
    {

        $status = 0;
        // print_r(Yii::app()->user->getUserinfo());die;
        if (isset($_POST['tempstr'], $_POST['tempname'])) {
            $user = Yii::app()->user->getUserinfo();
            $user['email'] = 'test@qq.com';//测试用，正式删
            if (isset($user['email'])) {
                $temp = Tempstr::model()->find('uid=:uid and tempname=:tempname', [':uid' => $user['email'], ':tempname' => $_GET['tempname']]);
                // pd($temp);
                if (empty($temp)) {
                    $temp = new Tempstr();
                    $temp->uid = $user['email'];
                    $temp->tempname = $_POST['tempname'];
                }
                $temp->tempstr = $_POST['tempstr'];
                //pd($temp);

                if ($temp->save()) {
                    $status = 1;
                }
            }

        }
        echo $this->returnjson(array('status' => $status));
    }

    public function actionGettemplatelist()
    {
        $status = 0;
        $data = [];
        $user = Yii::app()->user->getUserinfo();
        $user['email'] = 'test@qq.com';//测试用，正式删
        if (isset($user['email'])) {
            $temp = Tempstr::model()->findAll('uid=:uid', [':uid' => $user['email']]);
            if (!empty($temp)) {
                $status = 1;
                for ($i = 0; $i < count($temp); $i++) {
                    $data[$temp[$i]->tempname] = $temp[$i]->tempstr;
                }
            }

        }
        echo $this->returnjson(array('status' => $status, 'data' => $data));
    }

    public function actionDeltemplate()
    {
        $status = 0;
        $user = Yii::app()->user->getUserinfo();
        $user['email'] = 'test@qq.com';//测试用，正式删
        if (isset($user['email'], $_POST['tempname'])) {
            $temp = Tempstr::model()->find('uid=:uid and tempname=:tempname', [':uid' => $user['email'], ':tempname' => $_POST['tempname']]);
            if (isset($temp->id)) {
                $status = 1;
                $temp->delete();
            }

        }
        echo $this->returnjson(array('status' => $status));
    }

    public function actionStore()
    {
        $model = StoreCvs::model()->find(array('order' => 'time desc'));
        $time = isset($model) ? $model->time : "2018-09";
        $relationid = 1; //全国
        $systemid = 1; //总系统
        $condition = "relation_id = $relationid and system_id = $systemid ";

        $details = StoreCvs::model()->with('category', 'brand')->findAll(array('condition' => 'time = "' . $time . '" and classify = 1 and status = 1  and ' . $condition));//涉及品类&品牌&SKU的数据
        $infos = [];
        for ($i = 0; $i < count($details); $i++) {
            $infos[$details[$i]->category_id][] = array(
                $details[$i]->category_id, $details[$i]->category->name, $details[$i]->brand_id, $details[$i]->brand->name, $details[$i]->shelft_stores
            );
        }
        //地图数据
        $diagram = StoreCvs::model()->with('relations', 'system')->findAll(array('condition' => 'time = "' . $time . '" and classify = 2 and status = 1  and ' . $condition));//不涉及品类&品牌&SKU的数据
        $datas = [];
        $name = '';
        for ($i = 0; $i < count($diagram); $i++) {
            $datas[Yii::app()->params['classify'][$diagram[$i]->store_endframe][0]] = array($diagram[$i]->relation_id,
                $diagram[$i]->relations->name,
                $diagram[$i]->system_id,
                $diagram[$i]->system->name,
                $diagram[$i]->store_endframe,
                $diagram[$i]->shelft_stores,
                Yii::app()->params['classify'][$diagram[$i]->store_endframe][1]
            );
            $name = $diagram[$i]->relations->name . '-' . $diagram[$i]->system->name;
        }
        $total = [
            'infos' => $infos,
            'datas' => $datas,
        ];
        $this->render('store', array(
            'total' => $total,
            'infos' => $infos,
            'datas' => $datas,
            'name' => $name,
        ));
    }

    public function actionGetStoreCvs()
    {
        $params = isset($_GET['Search']) ? $_GET['Search'] : $_GET;
        $model = StoreCvs::model()->find(array('order' => 'time desc'));
        $time = isset($model) ? $model->time : "2018-09";
        $relationid = 1; //全国
        $systemid = 1; //总系统
        if (count($params) > 1) {
            if ($params['region']) {
                $relationid = $params['region'];
            }
            if (!empty($params['factory'])) {
                $relationid = $params['factory'];
            }

            if (!empty($params['systemtype'])) {
                $systemid = $params['systemtype'];
            }
            if (!empty($params['system'])) {
                $systemid = $params['system'];
            }
        }
        $condition = "relation_id = $relationid and system_id = $systemid ";

        $details = StoreCvs::model()->with('category', 'brand')->findAll(array('condition' => 'time = "' . $time . '" and classify = 1 and status = 1  and ' . $condition));//涉及品类&品牌&SKU的数据
        $infos = [];
        for ($i = 0; $i < count($details); $i++) {
            $infos[$details[$i]->category_id][] = array(
                $details[$i]->category_id, $details[$i]->category->name, $details[$i]->brand_id, $details[$i]->brand->name, $details[$i]->shelft_stores
            );
        }

        //地图数据
        $diagram = StoreCvs::model()->with('relations', 'system')->findAll(array('condition' => 'time = "' . $time . '" and classify = 2 and status = 1  and ' . $condition));//不涉及品类&品牌&SKU的数据
        $datas = [];
        $name = '';
        for ($i = 0; $i < count($diagram); $i++) {
            $datas[Yii::app()->params['classify'][$diagram[$i]->store_endframe][0]] = array($diagram[$i]->relation_id,
                $diagram[$i]->relations->name,
                $diagram[$i]->system_id,
                $diagram[$i]->system->name,
                $diagram[$i]->store_endframe,
                $diagram[$i]->shelft_stores,
                Yii::app()->params['classify'][$diagram[$i]->store_endframe][1]
            );
            $name = $diagram[$i]->relations->name . '-' . $diagram[$i]->system->name;
        }

        $total = [
            'infos' => $infos,
            'datas' => $datas,
            'name' => $name
        ];
        echo CJSON::encode($total);
    }

    //O2O零售
    public function actionRetail($m_city = 0)
    {
        set_time_limit(0);
//        ini_set('memory_limit', '3560M');
        $md5code = $this->makecode(array('type' => 'retailData','lang' => Yii::app()->language));
        $md5code1 = $this->makecode(array('type' => 'retailDataHistory','lang' => Yii::app()->language));
        Yii::app()->filecache->delete($md5code);
        Yii::app()->filecache->delete($md5code1);
        $searchmodel = new Search('search');
        $searchmodel->region = 1;
        $infomation = $this->getMaxTime();//查询最大时间和最大时间的期数
        $month = $infomation['time'];
        $searchmodel->month = str_replace('q','Q',$month);
        $searchmodel->stage = 0;//默认0（季报/月报）
        if ($m_city) {
            $searchmodel->factory = $m_city;
        }
        if (isset($_GET['Search'])) {
//            $searchmodel->month = $_GET['Search']['month'];
            $searchmodel->attributes = $_GET['Search'];
        }
//        pd($_GET['Search'],$searchmodel);
//        $citymap = array_values(CHtml::listData(Relation::model()->findAll('depth=3'), 'id'));
        $datas = $this->actionGetretaildata(true, $m_city,$month);
        $this->render("retail", array(
            'datas' => $datas,
            'searchmodel' => $searchmodel,
        ));
    }

    public function actionGetretaildata($return = false, $factory = false,$infomation = [])
    {
        set_time_limit(0);
        $params = isset($_GET['Search']) ? $_GET['Search'] : $_GET;
        $month = isset($infomation)?$infomation:"2018-11";
        $stage = 0;
        $relationid = 1; //全国
        $cityLevel = 1;//城市等级
        $systemid = 1; //总系统
        $platformid = 1;//全部
        $categoryid = 1;//全部品类
        $menuid = 1;//全部制造商
        $brandid = 1;//全部品牌
        $capacityid = 1;//瓶量分级
        $bottleid = 8;//容量分级
        if ($factory) $relationid = $factory;//传入的装瓶厂ID
        if (count($params) > 1) {
            if ($params['region']) {
                $relationid = $params['region'];
            }
            if (!empty($params['factory'])) {
                $relationid = $params['factory'];
            }
            if (!empty($params['cityLevel'])) {
                $cityLevel = $params['cityLevel'];
            }
            if (!empty($params['city'])) {
                $relationid = $params['city'];
            }
            if (!empty($params['systemtype'])) {
                $systemid = $params['systemtype'];
            }
            if (!empty($params['platform'])) {
                $platformid = $params['platform'];
            }
            if (!empty($params['category'])) {
                $categoryid = $params['category'];
            }
            $month = empty($params['month']) ? $month : str_replace('Q','q',$params['month']);;
            $stage = empty($params['stage']) ? $stage :  $params['stage'];
        }
        $condition = "relation_id = $relationid and cityLevel_id = $cityLevel and system_id = $systemid and platform_id = $platformid";
        $tableName = $month."_".$stage;
        //当月全国KO数据（页面头部数据）
        $totalfixed = Info::model($tableName)->find(array(
            'condition'=>"t.relation_id= 1 and t.cityLevel_id = 1 and t.system_id= 1 and t.platform_id = 1 and t.category_id = 1 and t.menu_id = 253 and t.brand_id = 1 and t.capacity_id = 1 and t.bottle_id = 8",
            'select'=>'id,relation_id,cityLevel_id,system_id,platform_id,category_id,menu_id,brand_id,capacity_id,bottle_id,distribution,last_distribution,sales_numbers,last_sales_numbers,sales_quota,last_sales_quota,saleroom,last_saleroom,sales_share,last_sales_share'
        ));
        $progress = isset($totalfixed->progress) ? $totalfixed->progress : "";
        $infos['totalfixed'] = array($totalfixed, $progress);//头部数据
        unset($totalfixed);
        //当月排行数据（页面右侧排行情况）
        $rank_tableName = 'cola_rank_'.$month.'_'.$stage;
        $link_table = "show tables like '$rank_tableName';";
        $rankFlag = Yii::app()->db->createCommand($link_table)->execute();
        $rankData = $rank = [];
        if($rankFlag){
            $rankSql = "SELECT
	*
FROM
	$rank_tableName
WHERE
	time = '$month'
AND stage = $stage
AND relation_id = $relationid
AND cityLevel_id = $cityLevel
AND system_id = $systemid
AND platform_id = $platformid
AND sku_id = $categoryid
AND `status` = 1
ORDER BY
	sales_amount desc";
            $rankModel = Yii::app()->db->createCommand($rankSql)->queryAll();
            foreach ($rankModel as $value) {
                $rankData[$value['classify']][] = $value;
            }
            foreach ($rankData as $key=>$value){
                $rank[$key] = array_slice($rankData[$key],0,10);
            }
        }
        //当月全国KO各层级KO数据(地图)
        $info_name = 'cola_info_'.$tableName;
        $sqlallkos = "select t.id,t.relation_id,t.cityLevel_id,t.system_id,t.platform_id,t.category_id,t.menu_id,t.brand_id,t.capacity_id,
t.bottle_id,t.sales_share,t.last_sales_share,b.id,b.name,b.depth from ".$info_name." as t INNER JOIN cola_relation as b ON t.relation_id = b.id where t.cityLevel_id = $cityLevel and t.system_id = $systemid and t.platform_id = $platformid and t.category_id = $categoryid and t.menu_id = 253 and t.brand_id = $brandid and t.capacity_id = $capacityid and t.bottle_id = $bottleid";
        $allkos = Yii::app()->db->createCommand($sqlallkos)->queryAll();
        $koinfos = array();
        if (Yii::app()->language == 'zh_cn') {
            foreach ($allkos as $ko) {
                $koinfos[] = array(
                    $ko['depth'], $ko['name'], $ko['last_sales_share'], $ko['sales_share'], $ko['id'], $ko['name']
                );
            }
        } else {
            foreach ($allkos as $ko) {
                $relation = isset(Yii::app()->params['map_china'][$ko['name']]) ? Yii::app()->params['map_china'][$ko['name']] : $ko['name'];
                $koinfos[] = array($ko['depth'], $ko['name'], $ko['last_sales_share'], $ko['sales_share'], $ko['id'], $relation);
            }
        }
        $infos['koinfos'] = $koinfos;//地图数据
        unset($allkos, $koinfos);
        //特殊的区域名
        $sqlallkoss = "select t.id,t.relation_id,t.cityLevel_id,t.system_id,t.platform_id,t.category_id,t.menu_id,t.brand_id,t.capacity_id,
t.bottle_id,t.sales_share,t.last_sales_share,b.id,b.name,b.depth from ".$info_name." as t INNER JOIN cola_relation as b ON t.relation_id = b.id where t.cityLevel_id = $cityLevel and t.system_id = $systemid and t.platform_id = $platformid and t.category_id = $categoryid and t.menu_id = 253 and t.brand_id = $brandid  and t.capacity_id = $capacityid and t.bottle_id = $bottleid and t.relation_id in(1,2,3,5,9,10)";
        $allkoss = Yii::app()->db->createCommand($sqlallkoss)->queryAll();
        $koinfoss = array();
        if (Yii::app()->language == 'zh_cn') {
            foreach ($allkoss as $value) {
                //插入特殊区域坐标
                $koinfoss[] = array(
                    $value['depth'], $value['name'], Yii::app()->params['specialLocate'][$value['name']], $value['last_sales_share'], $value['sales_share'],
                    $value['id'], $value['name']
                );
            }
        } else {
            foreach ($allkoss as $value) {
                $relation = isset(Yii::app()->params['map_china'][$value['name']]) ? Yii::app()->params['map_china'][$value['name']] : $value['name'];
                $eng_specialLocate = isset(Yii::app()->params['specialLocate'][$value['name']]) ? Yii::app()->params['specialLocate'][$value['name']] : $value['name'];
                $koinfoss[] = array(
                    $value['depth'], $value['name'], $eng_specialLocate, $value['last_sales_share'], $value['sales_share'], $value['id'], $relation
                );
            }
        }
        $infos['koinfoss'] = $koinfoss;//地图数据
        unset($allkoss, $koinfoss);

        //饼图&进度条
        //进度条的数据(KO：制造商为可口可乐（id为253），软饮（制造商为全部）的数据)
        $koandpcisPlan = Info::model($tableName)->find(array(
//            'select'=>'id,relation_id,cityLevel_id,system_id,platform_id,category_id,menu_id,brand_id,capacity_id,bottle_id,store_money,last_store_money,store_number,last_store_number',
            'condition' => "$condition and t.category_id = $categoryid and t.menu_id = 253 and t.brand_id = $brandid and t.capacity_id = $capacityid and t.bottle_id = $bottleid"
        ));
        $koandpcisPlans = Info::model($tableName)->find(array(
//            'select'=>'id,relation_id,cityLevel_id,system_id,platform_id,category_id,menu_id,brand_id,capacity_id,bottle_id,store_money,last_store_money,store_number,last_store_number',
            'condition' => "$condition and t.category_id = $categoryid and t.menu_id = 1 and t.brand_id = $brandid and t.capacity_id = $capacityid and t.bottle_id = $bottleid"
        ));
        unset($lastkoandpcis);
        //进度条&&饼图数据
        $pieData = [
            'ko'=>$koandpcisPlan,
            'nartd'=>$koandpcisPlans
        ];
        unset($koandpcisPlan,$koandpcisPlans);

        //地图上面装瓶集团的信息
        $groupInfo = [];
        $group = Info::model($tableName)->with('relation')->findAll(array('condition' => "relation_id in (2,3,65) and t.cityLevel_id = 1 and system_id = $systemid and platform_id = $platformid and t.category_id = $categoryid and t.menu_id = $menuid and t.brand_id = $brandid and t.capacity_id = $capacityid and t.bottle_id = $bottleid"));
        foreach ($group as $k => $v) {
            $groupInfo[$v->relation_id] = array($v->relation_id, $v->relation->name, $v->sales_share, $v->last_sales_share);
        }
        unset($group);

        $infos['pieData'] = $pieData;//饼图&进度条数据
        $infos['rank'] = $rank;//右侧排行数据
        $infos['groupInfo'] = $groupInfo;//地图上面装瓶集团的信息
        //1代表YTD，0代表月/季
        $label = explode('_', $month);
        //1代表2018年的月报，2代表2018年的YTD，3代表2019以及以后的季报，4代表2019以及以后的YTD
        switch ($label[0]){
            case 2018:
                $ismonth = $stage == 0?1:2;
                break;
            default:
                $ismonth = $stage == 0?3:4;
                break;
        }
        $infos['labels'] = [
            'lastvalue' => Yii::t('cvs', ($ismonth == 2 or $ismonth == 4 )? '去年' : ($ismonth == 3 ? '上季度' : '上月')),
            'thisvalue' => Yii::t('cvs', ($ismonth == 2 or $ismonth == 4 ) ? '今年' : ($ismonth == 3 ? '本季度' : "本月")),
            'totalindex' => Yii::t('cvs', ($ismonth == 2 or $ismonth == 4 ) ? '全国指标' : ($ismonth == 3 ? '全国指标' : "全国指标")),
            'schedule' => Yii::t('cvs', ($ismonth == 2 or $ismonth == 4 ) ? '核查完成度' : ($ismonth == 3 ? '核查完成度' : "核查完成度")),
            'lastcompare' => Yii::t('cvs', ($ismonth == 2 or $ismonth == 4 ) ? '同去年相比' : ($ismonth == 3 ? '同上季度相比' : "同上月相比")),
        ];
        unset($rank, $groupInfo, $ismonth);
        if ($return) {
            return $infos;
        } else
            echo CJSON::encode($infos);
    }

    private function getnewtimeretail()
    {
        $newlist = Info::monthdata();
        $maxmonth = max($newlist);
        unset($newlist);
        return substr($maxmonth, 0, 4) . '-' . substr($maxmonth, 4, 2);
    }

    public function getLastStageRetail($month, $stage)
    {
        $laststage = '0000000';
        if ($stage == 0) {
            $arr = $this->cvstimeRetail(true);
            $key = $this->onlynumberRetail($month) . '0';
        } else {
            $arr = $this->cvstimeRetail();
            $key = $this->onlynumberRetail($month) . $stage;
        }

        // pd($arr,$key);
        if (!empty($arr)) {
            $return = 0;
            foreach ($arr as $k => $v) {
                if ($return == 1) {
                    $laststage = $k;
                    break;
                }
                if ($k == $key) {
                    $return++;
                }
            }
        }
        unset($arr, $key);
        return array(substr($laststage, 0, 4) . '-' . substr($laststage, 4, 2), substr($laststage, -1, 1));
    }

    private function onlynumberRetail($str)
    {
        preg_match_all('/\d+/', $str, $arr);
        return implode('', $arr[0]);
    }

    public function cvstimeRetail($month = false)
    {
        if ($month) {
            $sql = 'select id,time,stage from cola_info where stage=0 GROUP by time,stage';
        } else {
            $sql = 'select id,time,stage from cola_info where stage!=0 GROUP by time,stage';
        }
        $res = Yii::app()->db->createCommand($sql)->queryAll();
        $arr = [];
        for ($i = 0; $i < count($res); $i++) {
            $key = $this->onlynumberRetail($res[$i]['time']) . $res[$i]['stage'];
            $arr[$key] = $res[$i];
        }
        unset($res);
        krsort($arr);
        return $arr;
    }

    public function actionHearderRetail()
    {
        $params = isset($_GET['Search']) ? $_GET['Search'] : $_GET;
        $month = $params['month'];
        $stage = $params['stage'];
        $tableName = $month."_".$stage;
        $model = Info::model($tableName)->find("relation_id=1 and cityLevel_id = 1 and system_id=1 and sku_id= 1 and platform_id = 1 and capacity_id = 1 and bottle_id = 8");
        echo CJSON::encode($model);
    }

    public function jointValue($value,$totalArr){
        $infosString = '';
        if($value != '0'){
            $infos = explode(',',$value);
            foreach ($infos as $key => $value){
                $sequence = isset($totalArr[$value]['sequence'])?($totalArr[$value]['sequence']):$totalArr[$value]['id'];
                $infosString .= '('.$value.','.$sequence.')'.',';
            }
            $infosString = substr($infosString,0,strlen($infosString)-1);
        }
        return $infosString;
    }

    public function actionRetailData()
    {
        set_time_limit(0);
        $t1 = microtime(true);
        ini_set('memory_limit', '-1');
        $relationId = strtr(((isset($_GET['relationsArr'])&&$_GET['relationsArr'] !="") ? $_GET['relationsArr'] : 0),"_",",");//区域选中的ID
        $cityLevelId = strtr(((isset($_GET['cityLevelsArr'])&&$_GET['cityLevelsArr'] !="") ? $_GET['cityLevelsArr'] : 0),"_",",");//城市等级选中的ID
        $systemId = strtr(((isset($_GET['systemsArr'])&&$_GET['systemsArr'] !="") ? $_GET['systemsArr'] : 0),"_",",");//渠道选中的ID
        $platformId = strtr(((isset($_GET['platformsArr'])&&$_GET['platformsArr'] !="") ? $_GET['platformsArr'] : 0),"_",",");//平台选中的ID
        $categoryId = strtr(((isset($_GET['categorysArr'])&&$_GET['categorysArr'] !="") ? $_GET['categorysArr'] : 0),"_",",");//品类选中的ID
        $menuId = strtr(((isset($_GET['menusArr'])&&$_GET['menusArr'] !="") ? $_GET['menusArr'] : 0),"_",",");//制造商选中的ID
        $brandId = strtr(((isset($_GET['brandsArr'])&&$_GET['brandsArr'] !="") ? $_GET['brandsArr'] : 0),"_",",");//品牌选中的ID
        $capacityId = strtr(((isset($_GET['capacitysArr'])&&$_GET['capacitysArr'] !="") ? $_GET['capacitysArr'] : 0),"_",",");//容量分级选中的ID
        $bottleId = strtr(((isset($_GET['bottlesArr'])&&$_GET['bottlesArr'] !="") ? $_GET['bottlesArr'] : 0),"_",",");//瓶量分级选中的ID
        $citytype = isset($_GET['citytype']) ? $_GET['citytype'] : 1;//装瓶集团，装瓶厂，城市
        $systemtype = isset($_GET['systemtype']) ? $_GET['systemtype'] : 1;//渠道
        $skufield = isset($_GET['skutype']) ? $_GET['skutype'] : 1;//品类(1)，制造商(2)，品牌(3)
        $grading = isset($_GET['isgrading']) ? $_GET['isgrading'] : 0;//1代表选中容量分级，2代表选中瓶量分级，0代表都没选中
        $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 11;//每个图表显示多少条数据
        $kpichecked = isset($_GET['kpichecked'])?$_GET['kpichecked']:1;//选中的是哪个指标，默认是产品铺货率
        $skuinfos = $skudata = [];
        if(!($relationId == 0 || $cityLevelId == 0 || $systemId==0 || $platformId==0 || $categoryId==0 || $menuId==0 || $brandId==0 || $capacityId==0 || $bottleId==0)){
            switch ($kpichecked){
                case 2:
                    //销售件数
                    $current = Yii::app()->params['kpichecked'][$kpichecked]['current'];//本期值
                    $gradient = Yii::app()->params['kpichecked'][$kpichecked]['gradient'];//变化率
                    //销售件数占比
                    $current1 = Yii::app()->params['kpichecked'][3]['current'];//本期值
                    $gradient1 = Yii::app()->params['kpichecked'][3]['gradient'];//变化率
                    break;
                case 4:
                    //销售金额
                    $current = Yii::app()->params['kpichecked'][$kpichecked]['current'];//本期值
                    $gradient = Yii::app()->params['kpichecked'][$kpichecked]['gradient'];//变化率
                    //销售金额占比
                    $current1 = Yii::app()->params['kpichecked'][5]['current'];//本期值
                    $gradient1 = Yii::app()->params['kpichecked'][5]['gradient'];//变化率
                    break;
                case 13:
                    //价格促销渗透率
                    $current = Yii::app()->params['kpichecked'][$kpichecked]['current'];//本期值
                    $gradient = Yii::app()->params['kpichecked'][$kpichecked]['gradient'];//变化率
                    //价格深度
                    $current1 = Yii::app()->params['kpichecked'][14]['current'];//本期值
                    $gradient1 = Yii::app()->params['kpichecked'][14]['gradient'];//变化率
                    break;
                default:
                    $current = Yii::app()->params['kpichecked'][$kpichecked]['current'];//本期值
                    $gradient = Yii::app()->params['kpichecked'][$kpichecked]['gradient'];//变化率
                    //销售件数占比(此为占位置)
                    $current1 = Yii::app()->params['kpichecked'][3]['current'];//本期值
                    $gradient1 = Yii::app()->params['kpichecked'][3]['gradient'];//变化率
                    break;
            }
            $infomation = $this->getMaxTime();//查询最大时间和最大时间的期数
            $month = isset($_GET['month']) ?str_replace('Q','q', $_GET['month']) : $infomation['time'];
            $stage = isset($_GET['stage']) ? $_GET['stage'] : $infomation['stage'];
            $tableName = $month."_".$stage;
            $pageStrip = 4*$pageNum;//每个图表显示多少条数据（每次显示4个图表）
            $currentPage = isset($_GET['pageNumber']) ? $_GET['pageNumber'] : 1;//当前为第几页
            $startStrip = ($currentPage-1)*$pageStrip;//起始值
//        $condition = array(
//            'condition' => "relation_id in ($relationId) and relation.depth=:r_depth and cityLevel_id in ($cityLevelId) and system_id in ($systemId) and platform_id in ($platformId)
//            and category_id in ($categoryId) and menu_id in ($menuId) and brand_id in ($brandId) and capacity_id in ($capacityId) and bottle_id in ($bottleId) and system.depth=:s_depth",
//            'select'=>"id,relation_id,cityLevel_id,system_id,platform_id,category_id,menu_id,brand_id,capacity_id,bottle_id,$current,$gradient",
//            'params' => array(':r_depth' => $citytype, ':s_depth' => $systemtype),
//            'order' => "relation.sequence asc,cityLevel.id asc,system.sequence asc,platform.id asc,category.sequence asc,menu.sequence asc,brand.sequence asc,capacity.sequence asc,bottle.sequence asc",
//            'offset'=>"$startStrip",
//            'limit'=>"$pageStrip",
//        );
            $totalArr = $this->totalArr();
            $this->createTemporary($totalArr,$relationId,$cityLevelId,$systemId,$platformId,$categoryId,$menuId,$brandId,$capacityId,$bottleId);//创建临时表
            $sql1 = "SELECT
	`t`.`id` AS `info_id`,
	`t`.`relation_id` AS `info_relation_id`,
	`t`.`cityLevel_id` AS `info_cityLevel_id`,
	`t`.`system_id` AS `info_system_id`,
	`t`.`platform_id` AS `info_platform_id`,
	`t`.`category_id` AS `info_category_id`,
	`t`.`menu_id` AS `info_menu_id`,
	`t`.`brand_id` AS `info_brand_id`,
	`t`.`capacity_id` AS `info_capacity_id`,
	`t`.`bottle_id` AS `info_bottle_id`,
	`t`.`$current` AS `info_value`,
	`t`.`$gradient` AS `info_last_value`,
	`t`.`$gradient1` AS `$gradient1`,
	`t`.`$current1` AS `$current1`
FROM
	`cola_info_$tableName` `t`
INNER JOIN relationTemporary as relations on t.relation_id = relations.id
INNER JOIN cityLevelTemporary as cityLevels on t.cityLevel_id = cityLevels.id
INNER JOIN systemTemporary as systems on t.system_id = systems.id
INNER JOIN platformTemporary as platforms on t.platform_id = platforms.id
INNER JOIN categoryTemporary as categorys on t.category_id = categorys.id
INNER JOIN menuTemporary as menus on t.menu_id = menus.id
INNER JOIN brandTemporary as brands on t.brand_id = brands.id
INNER JOIN capacityTemporary as capacitys on t.capacity_id = capacitys.id
INNER JOIN bottleTemporary as bottles on t.bottle_id = bottles.id

ORDER BY
	relations.sequence ASC,
	cityLevels.sequence ASC,
	systems.sequence ASC,
	platforms.sequence ASC,
	categorys.sequence ASC,
	menus.sequence ASC,
	brands.sequence ASC,
	capacitys.sequence ASC,
	bottles.sequence ASC
    LIMIT $pageStrip
    OFFSET $startStrip";
            $allskuinfos = Yii::app()->db->createCommand($sql1)->queryAll();//查询数据
            $this->deleteTemporary();//删除临时表

//        $allskuinfos = Info::model($tableName)->with(array(
//            'category','menu','brand', 'relation', 'system', 'platform', 'cityLevel', 'capacity', 'bottle'))->findAll($condition);
//        $kpiArr = [1,2,4,13,14];
//        if(in_array($kpichecked,$kpiArr)){//正负轴图数据
            if($grading == 0){//代表都没选中
                foreach ($allskuinfos as $skuinfo) {
                    $infoA = $this->transArray($skuinfo,$current,$gradient,$current1,$gradient1,$totalArr);
                    $totalname = $skufield==1?($infoA['r_category']):($skufield==2?$infoA['r_menu']:$infoA['r_brand']);//品类(1)，制造商(2)，品牌(3)
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['skus'][] = array($totalname, $infoA['r_info']);
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['relation'] = $infoA['r_relation'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['system'] = $infoA['r_system'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['platform'] = $infoA['r_platform'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['cityLevel'] = $infoA['r_cityLevel'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['capacity'] = $infoA['r_capacity'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['bottle'] = $infoA['r_bottle'];
                }
            }else{
                foreach ($allskuinfos as $skuinfo) {
                    $infoA = $this->transArray($skuinfo,$current,$gradient,$current1,$gradient1,$totalArr);
                    $value = $grading==1?$infoA['r_capacity']:$infoA['r_bottle'];
                    $totalid = $skufield==1?($skuinfo['info_category_id']):($skufield==2?$skuinfo['info_menu_id']:$skuinfo['info_brand_id']);//品类(1)，制造商(2)，品牌(3)
                    $totalname = $skufield==1?($infoA['r_category']):($skufield==2?$infoA['r_menu']:$infoA['r_brand']);//品类(1)，制造商(2)，品牌(3)

                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['skus'][] = array($value, $infoA['r_info']);
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['relation'] = $infoA['r_relation'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['system'] = $infoA['r_system'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['platform'] = $infoA['r_platform'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['cityLevel'] = $infoA['r_cityLevel'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['capacity'] = $infoA['r_capacity'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['bottle'] = $infoA['r_bottle'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['skuname'] = $totalname;
                }
            }
            if($grading == 0){//代表都没选中
                foreach ($skuinfos as $v) {
                    foreach ($v as $vv) {
                        foreach ($vv as $vvv) {
                            foreach ($vvv as $vvvv) {
                                foreach ($vvvv as $vvvvv) {
                                    $skudata['bar'][] = $vvvvv;
                                }
                            }
                        }
                    }
                }
            }else{
                foreach ($skuinfos as $v) {
                    foreach ($v as $vv) {
                        foreach ($vv as $vvv) {
                            foreach ($vvv as $vvvv) {
                                foreach ($vvvv as $vvvvv) {
                                    foreach ($vvvvv as $vvvvvv) {
                                        $skudata['bar'][] = $vvvvvv;
                                    }
                                }
                            }
                        }
                    }
                }
            }
//        }else{//堆叠柱状图数据
//            $skudata = $this->getStackbarData($allskuinfos,$grading,$skufield,$current,$gradient,$current1,$gradient1);//获取stackbar数据
//        }
            $t5 = microtime(true);
            unset($allskuinfos,$skuinfos);
//        $md5code = $this->makecode(array('type' => 'retailData','lang' => Yii::app()->language));
//        $removeCache = isset($_GET['removeCache']) ? $_GET['removeCache'] : 0;//是否清理缓存
//        if($removeCache){
//            Yii::app()->filecache->delete($md5code);
//        }
//        $cacheData = CJSON::decode(Yii::app()->filecache->get($md5code));//已缓存的数据
//        $totalData = CJSON::encode($this->summarization($cacheData,$skudata,$grading));
//        Yii::app()->filecache->set($md5code, $totalData);//Yii::app()->params['cache']['retaildatatime']);
//        echo $totalData;
        }
        echo CJSON::encode($skudata);
    }

    public function totalArr(){
        $relations = Relation::model()->findAll(array('index'=>'id'));
        $cityLevels = Citylevel::model()->findAll(array('index'=>'id'));
        $systems = System::model()->findAll(array('index'=>'id'));
        $platforms = Platform::model()->findAll(array('index'=>'id'));
        $categorys = Category::model()->findAll(array('index'=>'id'));
        $menus = Menu::model()->findAll(array('index'=>'id'));
        $brands = Brand::model()->findAll(array('index'=>'id'));
        $totalClassifys = TotalClassify::model()->findAll(array('index'=>'id'));
        $info = [
            'relations'=>$relations,
            'cityLevels'=>$cityLevels,
            'systems'=>$systems,
            'platforms'=>$platforms,
            'categorys'=>$categorys,
            'menus'=>$menus,
            'brands'=>$brands,
            'totalClassifys'=>$totalClassifys,
        ];
        return $info;
    }

    public function transArray($skuinfo,$current,$gradient,$current1,$gradient1,$totalArr){
        $info['r_info'] = ['id'=>$skuinfo['info_id'],'relation_id'=>$skuinfo['info_relation_id'],'cityLevel_id'=>$skuinfo['info_cityLevel_id'],
            'system_id'=>$skuinfo['info_system_id'],'platform_id'=>$skuinfo['info_platform_id'], 'category_id'=>$skuinfo['info_category_id'],
            'menu_id'=>$skuinfo['info_menu_id'],'brand_id'=>$skuinfo['info_brand_id'], 'capacity_id'=>$skuinfo['info_capacity_id'],
            'bottle_id'=>$skuinfo['info_bottle_id'],$current=>$skuinfo['info_value']
            ,$current1=>$skuinfo[$current1]];
        foreach ($info['r_info'] as $key=>$value){
            if($gradient){
                $info['r_info'][$gradient] = $skuinfo['info_last_value'];
            }
            if($gradient1){
                $info['r_info'][$gradient1] = $skuinfo[$gradient1];
            }
        }

        $relations = $totalArr['relations'][$skuinfo['info_relation_id']];
        $cityLevels = $totalArr['cityLevels'][$skuinfo['info_cityLevel_id']];
        $systems = $totalArr['systems'][$skuinfo['info_system_id']];
        $platforms = $totalArr['platforms'][$skuinfo['info_platform_id']];
        $categorys = $totalArr['categorys'][$skuinfo['info_category_id']];
        $menus = $totalArr['menus'][$skuinfo['info_menu_id']];
        $brands = $totalArr['brands'][$skuinfo['info_brand_id']];
        $capacity = $totalArr['totalClassifys'][$skuinfo['info_capacity_id']];
        $bottle = $totalArr['totalClassifys'][$skuinfo['info_bottle_id']];

        $info['r_relation'] =['id'=>$skuinfo['info_relation_id'],'name'=>$relations['name'],'sequence'=>$relations['sequence']];
        $info['r_cityLevel'] =['id'=>$skuinfo['info_cityLevel_id'],'name'=>$cityLevels['name']];
        $info['r_system'] =['id'=>$skuinfo['info_system_id'],'name'=>$systems['name'], 'sequence'=>$systems['sequence']];
        $info['r_platform'] =['id'=>$skuinfo['info_platform_id'],'name'=>$platforms['name'],'sequence'=>$platforms['sequence']];
        $info['r_category'] =['id'=>$skuinfo['info_category_id'],'name'=>$categorys['name'],'sequence'=>$categorys['sequence']];
        $info['r_menu'] =['id'=>$skuinfo['info_menu_id'],'name'=>$menus['name'],'sequence'=>$menus['sequence']];
        $info['r_brand'] =['id'=>$skuinfo['info_brand_id'],'name'=>$brands['name'],'sequence'=>$brands['sequence']];
        $info['r_capacity'] =['id'=>$skuinfo['info_capacity_id'],'name'=>$capacity['name'], 'sequence'=>$capacity['sequence']];
        $info['r_bottle'] =['id'=>$skuinfo['info_bottle_id'],'name'=>$bottle['name'], 'sequence'=>$bottle['sequence']];
//        $info['r_relation'] =['id'=>$skuinfo['info_relation_id'],'name'=>$skuinfo['relation_name'],'sequence'=>$skuinfo['relation_sequence']];
//        $info['r_cityLevel'] =['id'=>$skuinfo['info_cityLevel_id'],'name'=>$skuinfo['cityLevel_name']];
//        $info['r_system'] =['id'=>$skuinfo['info_system_id'],'name'=>$skuinfo['system_name'], 'sequence'=>$skuinfo['system_sequence']];
//        $info['r_platform'] =['id'=>$skuinfo['info_platform_id'],'name'=>$skuinfo['platform_name'],'sequence'=>$skuinfo['platform_sequence']];
//        $info['r_category'] =['id'=>$skuinfo['info_category_id'],'name'=>$skuinfo['category_name'],'sequence'=>$skuinfo['category_sequence']];
//        $info['r_menu'] =['id'=>$skuinfo['info_menu_id'],'name'=>$skuinfo['menu_name'],'sequence'=>$skuinfo['menu_sequence']];
//        $info['r_brand'] =['id'=>$skuinfo['info_brand_id'],'name'=>$skuinfo['brand_name'],'sequence'=>$skuinfo['brand_sequence']];
//        $info['r_capacity'] =['id'=>$skuinfo['info_capacity_id'],'name'=>$skuinfo['capacity_name'], 'sequence'=>$skuinfo['capacity_sequence']];
//        $info['r_bottle'] =['id'=>$skuinfo['info_bottle_id'],'name'=>$skuinfo['bottle_name'], 'sequence'=>$skuinfo['bottle_sequence']];
        return $info;
    }

    /**
     * @param array $oldData
     * @param $newData
     * @param $grading
     * @return array
     */
    public function summarization($oldData = [], $newData,$grading)
    {
        $groupData = $oldData;
        if (empty($oldData)) {
            return $newData;
        } else {
            //1代表选中容量分级，2代表选中瓶量分级，0代表都没选中
            switch ($grading){
                case 1:
                    foreach ($oldData['bar'] as $key1 => $value1) {
                        foreach ($newData['bar'] as $key => $value) {
                            if (($value1['relation']['id'] == $value['relation']['id']) && ($value1['cityLevel']['id'] == $value['cityLevel']['id'])
                                && ($value1['system']['id'] == $value['system']['id']) && ($value1['platform']['id'] == $value['platform']['id'])
                                && ($value1['bottle']['id'] == $value['bottle']['id']) && ($value1['skuname']['id'] == $value['skuname']['id'])) {
                                foreach ($value['skus'] as $k => $v) {
                                    array_push($groupData['bar'][$key1]['skus'],$newData['bar'][$key]['skus'][$k]);
                                }
                                unset($newData['bar'][$key]);
                            }
                        }
                    }
                    foreach ($newData['bar'] as $k => $v) {
                        array_push($groupData['bar'],$v);
                    }
                    break;
                case 2:
                    foreach ($oldData['bar'] as $key1 => $value1) {
                        foreach ($newData['bar'] as $key => $value) {
                            if (($value1['relation']['id'] == $value['relation']['id']) && ($value1['cityLevel']['id'] == $value['cityLevel']['id'])
                                && ($value1['system']['id'] == $value['system']['id']) && ($value1['platform']['id'] == $value['platform']['id'])
                                && ($value1['capacity']['id'] == $value['capacity']['id']) && ($value1['skuname']['id'] == $value['skuname']['id'])) {
                                foreach ($value['skus'] as $k => $v) {
                                    array_push($groupData['bar'][$key1]['skus'],$newData['bar'][$key]['skus'][$k]);
                                }
                                unset($newData['bar'][$key]);
                            }
                        }
                    }
                    foreach ($newData['bar'] as $k => $v) {
                        array_push($groupData['bar'],$v);
                    }
                    break;
                default:
                    foreach ($oldData['bar'] as $key1 => $value1) {
                        foreach ($newData['bar'] as $key => $value) {
                            if (($value1['relation']['id'] == $value['relation']['id']) && ($value1['cityLevel']['id'] == $value['cityLevel']['id'])
                                && ($value1['system']['id'] == $value['system']['id']) && ($value1['platform']['id'] == $value['platform']['id'])
                                && ($value1['capacity']['id'] == $value['capacity']['id']) && ($value1['bottle']['id'] == $value['bottle']['id'])) {
                                foreach ($value['skus'] as $k => $v) {
                                    array_push($groupData['bar'][$key1]['skus'],$newData['bar'][$key]['skus'][$k]);
                                }
                                unset($newData['bar'][$key]);
                            }
                        }
                    }
                    foreach ($newData['bar'] as $k => $v) {
                        array_push($groupData['bar'],$v);
                    }
                    break;
            }
            $groupData['stackbar']['relations'] = $this->unique($oldData['stackbar']['relations'],$newData['stackbar']['relations']);
            $groupData['stackbar']['cityLevel'] = $this->unique($oldData['stackbar']['cityLevel'],$newData['stackbar']['cityLevel']);
            $groupData['stackbar']['systems'] = $this->unique($oldData['stackbar']['systems'],$newData['stackbar']['systems']);
            $groupData['stackbar']['platforms'] = $this->unique($oldData['stackbar']['platforms'],$newData['stackbar']['platforms']);
            $groupData['stackbar']['skuname'] = $this->unique($oldData['stackbar']['skuname'],$newData['stackbar']['skuname']);
            $groupData['stackbar']['capacity'] = $this->unique($oldData['stackbar']['capacity'],$newData['stackbar']['capacity']);
            $groupData['stackbar']['bottle'] = $this->unique($oldData['stackbar']['bottle'],$newData['stackbar']['bottle']);
            foreach ($oldData['stackbar']['skus'] as $k1 => $v1) {
                foreach ($newData['stackbar']['skus'] as $k2 => $v2) {
                    if ($k1 == $k2) {
                        foreach ($v2 as $k3 => $v3) {
                            array_push($groupData['stackbar']['skus'][$k2], $v3);
                        }
                    }
                }
            }
            return $groupData;
        }
    }

    public function unique($arr1=[],$arr2=[]){
        $array1 = array_flip($arr1);
        $array2 = array_flip($arr2);
        $result = array_flip(array_merge($array1,$array2));
        return $result;
    }

    private function getStackbarData($data,$grading,$skufield,$current,$gradient,$current1,$gradient1)
    {
        $skudata = [];
        foreach ($data as $skuinfo) {
            $infoA = $this->transArray($skuinfo,$current,$gradient,$current1,$gradient1);
            $totalid = $skufield==1?($skuinfo['info_category_id']):($skufield==2?$skuinfo['info_menu_id']:$skuinfo['info_brand_id']);//品类(1)，制造商(2)，品牌(3)
            $totalname = $skufield==1?($skuinfo['category_name']):($skufield==2?$skuinfo['menu_name']:$skuinfo['brand_name']);//品类(1)，制造商(2)，品牌(3)
            $totalinfo = $skufield==1?($infoA['r_category']):($skufield==2?$infoA['r_menu']:$infoA['r_brand']);//品类(1)，制造商(2)，品牌(3)

            $v = $grading==0?$totalinfo:($grading==1?$infoA['r_capacity']:$infoA['r_bottle']);
            $name = $grading==0?($totalname):($grading==1?$skuinfo['capacity_name']:$skuinfo['bottle_name']);

            $skudata['stackbar']['relations'][$skuinfo['info_relation_id']] = $skuinfo['relation_name'];
            $skudata['stackbar']['capacity'][$skuinfo['info_capacity_id']] = $skuinfo['capacity_name'];
            $skudata['stackbar']['bottle'][$skuinfo['info_bottle_id']] = $skuinfo['bottle_name'];
            $skudata['stackbar']['cityLevel'][$skuinfo['info_cityLevel_id']] = $skuinfo['cityLevel_name'];
            $skudata['stackbar']['systems'][$skuinfo['info_system_id']] = $skuinfo['system_name'];
            $skudata['stackbar']['platforms'][$skuinfo['info_platform_id']] = $skuinfo['platform_name'];
            $skudata['stackbar']['skuname'][$totalid] = $totalname;
            $skudata['stackbar']['skus'][$name][] = array($v, $infoA['r_info']);
        }
        return $skudata;
    }

    //创建临时表
    public function createTemporary($totalArr,$relationId,$cityLevelId,$systemId,$platformId,$categoryId,$menuId,$brandId,$capacityId,$bottleId){
        $relations = $this->jointValue($relationId,$totalArr['relations']);
        $cityLevels = $this->jointValue($cityLevelId,$totalArr['cityLevels']);
        $systems = $this->jointValue($systemId,$totalArr['systems']);
        $platforms = $this->jointValue($platformId,$totalArr['platforms']);
        $categotys = $this->jointValue($categoryId,$totalArr['categorys']);
        $menus = $this->jointValue($menuId,$totalArr['menus']);
        $brands = $this->jointValue($brandId,$totalArr['brands']);
        $capacitys = $this->jointValue($capacityId,$totalArr['totalClassifys']);
        $bottles = $this->jointValue($bottleId,$totalArr['totalClassifys']);
        $sql = "
                # 区域
                DROP TABLE IF EXISTS relationTemporary;
                CREATE TEMPORARY TABLE relationTemporary(id int PRIMARY KEY,sequence int);
                INSERT INTO relationTemporary (id,sequence) VALUES $relations;
                CREATE INDEX index_name ON relationTemporary (sequence);
                #城市等级
                DROP TABLE IF EXISTS cityLevelTemporary;
                CREATE TEMPORARY TABLE cityLevelTemporary(id int PRIMARY KEY,sequence int);
                INSERT INTO cityLevelTemporary (id,sequence) VALUES $cityLevels;
                CREATE INDEX index_name ON cityLevelTemporary (sequence);
                #渠道
                DROP TABLE IF EXISTS systemTemporary;
                CREATE TEMPORARY TABLE systemTemporary(id int PRIMARY KEY,sequence int);
                INSERT INTO systemTemporary (id,sequence) VALUES $systems;
                CREATE INDEX index_name ON systemTemporary (sequence);
                #平台
                DROP TABLE IF EXISTS platformTemporary;
                CREATE TEMPORARY TABLE platformTemporary(id int PRIMARY KEY,sequence int);
                INSERT INTO platformTemporary (id,sequence) VALUES $platforms;
                CREATE INDEX index_name ON platformTemporary (sequence);
                #品类
                DROP TABLE IF EXISTS categoryTemporary;
                CREATE TEMPORARY TABLE categoryTemporary(id int PRIMARY KEY,sequence int);
                INSERT INTO categoryTemporary (id,sequence) VALUES $categotys;
                CREATE INDEX index_name ON categoryTemporary (sequence);
                #制造商
                DROP TABLE IF EXISTS menuTemporary;
                CREATE TEMPORARY TABLE menuTemporary(id int PRIMARY KEY,sequence int);
                INSERT INTO menuTemporary (id,sequence) VALUES $menus;
                CREATE INDEX index_name ON menuTemporary (sequence);
                #品牌
                DROP TABLE IF EXISTS brandTemporary;
                CREATE TEMPORARY TABLE brandTemporary(id int PRIMARY KEY,sequence int);
                INSERT INTO brandTemporary (id,sequence) VALUES $brands;
                CREATE INDEX index_name ON brandTemporary (sequence);
                #容量分级
                DROP TABLE IF EXISTS capacityTemporary;
                CREATE TEMPORARY TABLE capacityTemporary(id int PRIMARY KEY,sequence int);
                INSERT INTO capacityTemporary (id,sequence) VALUES $capacitys;
                CREATE INDEX index_name ON capacityTemporary (sequence);
                #瓶量分级
                DROP TABLE IF EXISTS bottleTemporary;
                CREATE TEMPORARY TABLE bottleTemporary(id int PRIMARY KEY,sequence int);
                INSERT INTO bottleTemporary (id,sequence) VALUES $bottles;
                CREATE INDEX index_name ON bottleTemporary (sequence);
            ";
        Yii::app()->db->createCommand($sql)->execute();//创建临时表
    }

    //删除临时表
    public function deleteTemporary(){
        $sql2 = "
DROP TABLE relationTemporary;
DROP TABLE cityLevelTemporary;
DROP TABLE systemTemporary;
DROP TABLE platformTemporary;
DROP TABLE categoryTemporary;
DROP TABLE menuTemporary;
DROP TABLE brandTemporary;
DROP TABLE capacityTemporary;
DROP TABLE bottleTemporary;
";
        Yii::app()->db->createCommand($sql2)->execute();//删除临时表
    }

    public function actionHistoryretaildata()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $relationId = strtr(((isset($_GET['relationsArr'])&&$_GET['relationsArr'] !="") ? $_GET['relationsArr'] : 0),"_",",");//区域选中的ID
        $cityLevelId = strtr(((isset($_GET['cityLevelsArr'])&&$_GET['cityLevelsArr'] !="") ? $_GET['cityLevelsArr'] : 0),"_",",");//城市等级选中的ID
        $systemId = strtr(((isset($_GET['systemsArr'])&&$_GET['systemsArr'] !="") ? $_GET['systemsArr'] : 0),"_",",");//渠道选中的ID
        $platformId = strtr(((isset($_GET['platformsArr'])&&$_GET['platformsArr'] !="") ? $_GET['platformsArr'] : 0),"_",",");//平台选中的ID
        $categoryId = strtr(((isset($_GET['categorysArr'])&&$_GET['categorysArr'] !="") ? $_GET['categorysArr'] : 0),"_",",");//品类选中的ID
        $menuId = strtr(((isset($_GET['menusArr'])&&$_GET['menusArr'] !="") ? $_GET['menusArr'] : 0),"_",",");//制造商选中的ID
        $brandId = strtr(((isset($_GET['brandsArr'])&&$_GET['brandsArr'] !="") ? $_GET['brandsArr'] : 0),"_",",");//品牌选中的ID
        $capacityId = strtr(((isset($_GET['capacitysArr'])&&$_GET['capacitysArr'] !="") ? $_GET['capacitysArr'] : 0),"_",",");//容量分级选中的ID
        $bottleId = strtr(((isset($_GET['bottlesArr'])&&$_GET['bottlesArr'] !="") ? $_GET['bottlesArr'] : 0),"_",",");//瓶量分级选中的ID

        $citytype = isset($_GET['citytype']) ? $_GET['citytype'] : 1;//装瓶集团，装瓶厂，城市
        $systemtype = isset($_GET['systemtype']) ? $_GET['systemtype'] : 1;//渠道
        $skufield = isset($_GET['skutype']) ? $_GET['skutype'] : 1;//品类(1)，制造商(2)，品牌(3)
        $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 11;//每个图表显示多少条数据
        $grading = isset($_GET['isgrading']) ? $_GET['isgrading'] : 0;//1代表选中容量分级，2代表选中瓶量分级，0代表都没选中
        $infomation = $this->getMaxTime();//查询最大时间和最大时间的期数
        $month = isset($_GET['month']) ? $_GET['month'] : $infomation['time'];
        $stage = isset($_GET['stage']) ? $_GET['stage'] : $infomation['stage'];
        $kpichecked = isset($_GET['kpichecked'])?$_GET['kpichecked']:1;//选中的是哪个指标，默认是产品铺货率
        $current = Yii::app()->params['kpichecked'][$kpichecked]['current'];//本期值
        $current1 = 'sales_quota';//本期值
        $skuinfos = $skudata = $label = $historylabels = $historyValue = $arr = [];
        if(!($relationId == 0 || $cityLevelId == 0 || $systemId==0 || $platformId==0 || $categoryId==0 || $menuId==0 || $brandId==0 || $capacityId==0 || $bottleId==0)) {
            if($kpichecked == 2){
                $current = "sales_numbers";//本期值
                $current1 = "sales_quota";//本期值
//            $gradient = "last_sales_numbers,last_sales_quota";//变化率
            }else if($kpichecked == 4){
                $current = "saleroom";//本期值
                $current1 = "sales_share";//本期值
//            $gradient = "last_saleroom,last_sales_share";//变化率
            }else if($kpichecked == 13){
                $current = "price_promotion_ratio";//本期值
                $current1 = "average_discount_factor";//本期值
//            $gradient = "last_saleroom,last_sales_share";//变化率
            }
            $pageStrip = 4*$pageNum;//每个图表显示多少条数据（每次显示4个图表）
            $currentPage = isset($_GET['pageNumberTrend']) ? $_GET['pageNumberTrend'] : 1;//当前为第几页
            $startStrip = ($currentPage-1)*$pageStrip;//起始值
            $condition = array(
                'condition' => "relation_id in ($relationId) and relation.depth=:r_depth and cityLevel_id in ($cityLevelId) and system_id in ($systemId) and platform_id in ($platformId)
            and category_id in ($categoryId) and menu_id in ($menuId) and brand_id in ($brandId) and capacity_id in ($capacityId) and bottle_id in ($bottleId) and system.depth=:s_depth",
                'select'=>"id,time,relation_id,cityLevel_id,system_id,platform_id,category_id,menu_id,brand_id,capacity_id,bottle_id,$current",
                'params' => array(':r_depth' => $citytype, ':s_depth' => $systemtype),
                'order' => "relation.sequence asc,cityLevel.id asc,system.sequence asc,platform.id asc,category.sequence asc,menu.sequence asc,brand.sequence asc,capacity.sequence asc,bottle.sequence asc",
                'offset'=>"$startStrip",
                'limit'=>"$pageStrip",
            );
            $historyLimit =$this->getAllTableLimit($month,$stage);
            $distinction = explode('-',$month);
            $tableArr = [];
            if($distinction[0] == '2018'){//2018年的数据
                $tableArr[] = ['cola_info_2018_11_0','cola_info_2018_12_0'];
            }else{
                $limit = count($historyLimit);
                for($i=0;$i<$limit;$i++){
                    $timeH = $historyLimit[$i]['time'];
                    $stageH = $historyLimit[$i]['stage'];
                    $tableName = "cola_info_".$timeH."_".$stageH;
                    $tableArr[] = $tableName;
                }
            }
            $allskuinfos = $submeterLabel = [];
            $totalArr = $this->totalArr();
            foreach ($tableArr as $key=>$value ){
                $table_name = substr($value,10);
                $this->createTemporary($totalArr,$relationId,$cityLevelId,$systemId,$platformId,$categoryId,$menuId,$brandId,$capacityId,$bottleId);//创建临时表
                $sql1 = "SELECT
	`t`.`id` AS `info_id`,
	`t`.`relation_id` AS `info_relation_id`,
	`t`.`cityLevel_id` AS `info_cityLevel_id`,
	`t`.`system_id` AS `info_system_id`,
	`t`.`platform_id` AS `info_platform_id`,
	`t`.`category_id` AS `info_category_id`,
	`t`.`menu_id` AS `info_menu_id`,
	`t`.`brand_id` AS `info_brand_id`,
	`t`.`capacity_id` AS `info_capacity_id`,
	`t`.`bottle_id` AS `info_bottle_id`,
	`t`.`$current` AS `info_value`,
	`t`.`$current1` AS `$current1`
FROM
	`$value` `t`
INNER JOIN relationTemporary as relations on t.relation_id = relations.id
INNER JOIN cityLevelTemporary as cityLevels on t.cityLevel_id = cityLevels.id
INNER JOIN systemTemporary as systems on t.system_id = systems.id
INNER JOIN platformTemporary as platforms on t.platform_id = platforms.id
INNER JOIN categoryTemporary as categorys on t.category_id = categorys.id
INNER JOIN menuTemporary as menus on t.menu_id = menus.id
INNER JOIN brandTemporary as brands on t.brand_id = brands.id
INNER JOIN capacityTemporary as capacitys on t.capacity_id = capacitys.id
INNER JOIN bottleTemporary as bottles on t.bottle_id = bottles.id

ORDER BY
	relations.sequence ASC,
	cityLevels.sequence ASC,
	systems.sequence ASC,
	platforms.sequence ASC,
	categorys.sequence ASC,
	menus.sequence ASC,
	brands.sequence ASC,
	capacitys.sequence ASC,
	bottles.sequence ASC
    LIMIT $pageStrip
    OFFSET $startStrip";
                $ingo = Yii::app()->db->createCommand($sql1)->queryAll();//查询数据
                $this->deleteTemporary();//删除临时表
//            $ingo = Info::model($table_name)->with(array('category','menu','brand', 'relation', 'system', 'platform', 'cityLevel', 'capacity', 'bottle'))->findAll($condition);
                $allskuinfos = array_merge($allskuinfos,$ingo);
                $submeterLabel[] = $table_name;
            }
//        if(in_array($kpichecked,$kpiArr)) {//正负轴图数据
            if($grading == 0) {//代表都没选中
                foreach ($allskuinfos as $key => $skuinfo) {
//                $historyValue = $stage == -1 ? ($skuinfo->zeroHistory) : ($skuinfo->oneHistory);
//                if (empty($historylabels)) $historylabels = array_slice($skuinfo, 0, 5);
                    $infoA = $this->transArray($skuinfo,$current,'',$current1,'',$totalArr);
                    $totalid = $skufield==1?($skuinfo['info_category_id']):($skufield==2?$skuinfo['info_menu_id']:$skuinfo['info_brand_id']);//品类(1)，制造商(2)，品牌(3)
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['relation'] = $infoA['r_relation'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['system'] = $infoA['r_system'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['platform'] = $infoA['r_platform'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['cityLevel'] = $infoA['r_cityLevel'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['capacity'] = $infoA['r_capacity'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['bottle'] = $infoA['r_bottle'];

//                    $assembly = $skufield==1?($infoA['r_category']):($skufield==2?$infoA['r_menu']:$infoA['r_brand']);//品类(1)，制造商(2)，品牌(3)
//                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']]['skus'][] = array($assembly,$infoA['r_info']);

//                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['relation'] = $skuinfo->relation;
//                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['system'] = $skuinfo->system;
//                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['platform'] = $skuinfo->platform;
//                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['cityLevel'] = $skuinfo->cityLevel;
//                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['capacity'] = $skuinfo->capacity;
//                    $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['bottle'] = $skuinfo->bottle;
//                $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id]['skus'][] = array($skuinfo->sku, $skuinfo);
                    $arr[$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid][$skuinfo['info_capacity_id']][$skuinfo['info_bottle_id']][] = $infoA;
                }
                foreach ($arr as $relation => $value) {
                    foreach ($value as $cityLevel => $valu) {
                        foreach ($valu as $system => $val) {
                            foreach ($val as $platform => $va) {
                                foreach ($va as $sku => $v) {
                                    foreach ($v as $capactiy => $z) {
                                        foreach ($z as $bottle => $k) {
                                            $totalname = $skufield==1?($k[0]['r_category']):($skufield==2?$k[0]['r_menu']:$k[0]['r_brand']);//品类(1)，制造商(2)，品牌(3)
                                            $infoData = [];
                                            foreach ($k as $pl=>$pl_data){
                                                $infoData[] = $pl_data['r_info'];
                                            }
                                            $skuinfos['bar'][$k[0]['r_info']['relation_id']][$k[0]['r_info']['cityLevel_id']][$k[0]['r_info']['system_id']][$k[0]['r_info']['platform_id']]['skus'][] = array($totalname, $k[0]['r_info'],$infoData);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                foreach ($allskuinfos as $skuinfo) {
//                $historyValue = $stage == -1 ? ($skuinfo->zeroHistory) : ($skuinfo->oneHistory);
//                if (empty($historylabels)){
//                    $historylabels = array_slice($historyValue, 0, 5);
//                }
//                $v = $grading==1 ? $skuinfo->capacity : $skuinfo->bottle;

                    $infoA = $this->transArray($skuinfo,$current,'',$current1,'',$totalArr);
                    $totalid = $skufield==1?($skuinfo['info_category_id']):($skufield==2?$skuinfo['info_menu_id']:$skuinfo['info_brand_id']);//品类(1)，制造商(2)，品牌(3)
                    $totalname = $skufield==1?($infoA['r_category']):($skufield==2?$infoA['r_menu']:$infoA['r_brand']);//品类(1)，制造商(2)，品牌(3)
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['relation'] = $infoA['r_relation'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['system'] = $infoA['r_system'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['platform'] = $infoA['r_platform'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['cityLevel'] = $infoA['r_cityLevel'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['capacity'] = $infoA['r_capacity'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['bottle'] = $infoA['r_bottle'];
                    $skuinfos['bar'][$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid]['skuname'] = $totalname;
                    $arr[$skuinfo['info_relation_id']][$skuinfo['info_cityLevel_id']][$skuinfo['info_system_id']][$skuinfo['info_platform_id']][$totalid][$skuinfo['info_capacity_id']][$skuinfo['info_bottle_id']][] = $infoA;

                    //$totalid = $skufield==1?($skuinfo->category_id):($skufield==2?$skuinfo->menu_id:$skuinfo->brand_id);//品类(1)，制造商(2)，品牌(3)
                    //$totalname = $skufield==1?($skuinfo->category):($skufield==2?$skuinfo->menu:$skuinfo->brand);//品类(1)，制造商(2)，品牌(3)

                    //$skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['relation'] = $skuinfo->relation;
                    //$skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['system'] = $skuinfo->system;
                    //$skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['platform'] = $skuinfo->platform;
                    //$skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['cityLevel'] = $skuinfo->cityLevel;
                    //$skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['capacity'] = $skuinfo->capacity;
                    //$skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['bottle'] = $skuinfo->bottle;
                    //$skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid]['skuname'] = $totalname;
                    //$arr[$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$totalid][$skuinfo->capacity_id][$skuinfo->bottle_id][] = $skuinfo;

//                $skuinfos['bar'][$skuinfo->relation_id][$skuinfo->cityLevel_id][$skuinfo->system_id][$skuinfo->platform_id][$skuinfo->sku_id]['skus'][] = array($v,$skuinfo, array_slice($historyValue, 0, 5));

                }
                foreach ($arr as $relation => $value) {
                    foreach ($value as $cityLevel => $valu) {
                        foreach ($valu as $system => $val) {
                            foreach ($val as $platform => $va) {
                                foreach ($va as $sku => $v) {
                                    foreach ($v as $capactiy => $z) {
                                        foreach ($z as $bottle => $k) {
                                            $vz = $grading==1 ? $k[0]['r_capacity'] : $k[0]['r_bottle'];
                                            $totalid = $skufield==1?($k[0]['r_info']['category_id']):($skufield==2?$k[0]['r_info']['menu_id']:$k[0]['r_info']['brand_id']);//品类(1)，制造商(2)，品牌(3)
                                            $infoData = [];
                                            foreach ($k as $pl=>$pl_data){
                                                $infoData[] = $pl_data['r_info'];
                                            }
                                            $skuinfos['bar'][$k[0]['r_info']['relation_id']][$k[0]['r_info']['cityLevel_id']][$k[0]['r_info']['system_id']][$k[0]['r_info']['platform_id']][$totalid]['skus'][] = array($vz, $k[0]['r_info'],$infoData);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if($grading == 0){//代表都没选中
                foreach ($skuinfos as $v) {
                    foreach ($v as $vv) {
                        foreach ($vv as $vvv) {
                            foreach ($vvv as $vvvv) {
                                foreach ($vvvv as $vvvvv) {
                                    $skudata['bar'][] = $vvvvv;
                                }
                            }
                        }
                    }
                }
            }else{
                foreach ($skuinfos as $v) {
                    foreach ($v as $vv) {
                        foreach ($vv as $vvv) {
                            foreach ($vvv as $vvvv) {
                                foreach ($vvvv as $vvvvv) {
                                    foreach ($vvvvv as $vvvvvv) {
                                        $skudata['bar'][] = $vvvvvv;
                                    }
                                }
                            }
                        }
                    }
                }
            }
//        }
//        else{
//            $skudata = $this->getStackbarData($allskuinfos,$skuinfos,$grading,$skufield);//获取stackbar数据
////        foreach ($historylabels as $hlabel) {
////            if ($stage == -1) {
////                $label[] = $hlabel->time;
////            } elseif ($stage == 0) {
////                $label[] = $hlabel->time;
////            } else {
////                $label[] = $hlabel->time . "-" . $hlabel->stage;
////            }
////        }
////        $label = array_reverse($label);
//        }
            $skudata['stackbar']['label'] = $submeterLabel;

//        $md5code = $this->makecode(array('type' => 'retailDataHistory','lang' => Yii::app()->language));
//        $removeCache = isset($_GET['removeCache']) ? $_GET['removeCache'] : 0;//是否清理缓存
//        if($removeCache){
//            Yii::app()->filecache->delete($md5code);
//        }
//        $cacheData = CJSON::decode(Yii::app()->filecache->get($md5code));//已缓存的数据
//        $totalData = CJSON::encode($this->summarization($cacheData,$skudata,$grading));
//        Yii::app()->filecache->set($md5code, $totalData);//Yii::app()->params['cache']['retaildatatime']);
//        echo $totalData;
        }

        echo CJSON::encode($skudata);
    }

    public function actionGetMapData()
    {
        $params = isset($_GET['Search']) ? $_GET['Search'] : $_GET;
        $month = "2018_11";
        $stage = 0;
        $cityLevelid = 1;//城市等级
        $systemid = 1; //渠道
        $platformid = 1;//平台
        $categoryid = 1;//品类
        if (count($params) > 1) {
            if (!empty($params['cityLevel'])) {
                $cityLevelid = $params['cityLevel'];
            }
            if (!empty($params['ditch'])) {
                $systemid = $params['ditch'] == 0 ? 1 : $params['ditch'];
            }
            if (!empty($params['platform'])) {
                $platformid = $params['platform'] == 0 ? 1 : $params['platform'];
            }
            if (!empty($params['category'])) {
                $categoryid = $params['category'] == 0 ? 1 : $params['category'];
            }
            $month = empty($params['month']) ? $month : $params['month'];
            $stage = !empty($params['stage']) ? $params['stage'] : $stage;
        }
        $tableName = 'cola_info_'.$month.'_'.$stage;
        $link_table = "show tables like '$tableName';";
        $flag = Yii::app()->db->createCommand($link_table)->execute();
        $koinfos = $koinfoss = [];
        if($flag){
            $condition = ($cityLevelid == 1) ? "" : "t.cityLevel =  $cityLevelid";
            $city = Relation::model()->with(array('factory', 'bloc'))->findAll(array("condition" =>$condition));
            $info = $bloc = [];
            $relations = [1, 2, 3, 4, 9, 10];
            foreach ($city as $key => $value) {
                if ($value) {
                    switch ($value->depth) {
                        case 1:
                            array_push($info, $value->id);
                            break;
                        case 2:
                            array_push($info, $value->id);
                            if (isset($value->factory->id)) {
                                array_push($info, $value->factory->id);
                            }
                            break;
                        case 3:
                            array_push($info, $value->id);
                            if (isset($value->factory->id)) {
                                array_push($info, $value->factory->id);
                            }
                            if (isset($value->bloc->id)) {
                                array_push($info, $value->bloc->id);
                            }
                            break;
                    }
                }
            }
            $bloc = array_intersect($relations, $info);//获取两个数组的交集
            //当月全国KO各层级KO数据
            if (!empty($info) && !empty($bloc)) {
                $list = implode(',', array_unique($info));
                $listBloc = implode(',', array_unique($bloc));
                $sqlallkos = "select t.sales_share,t.last_sales_share,b.id,b.name,b.depth from ".$tableName." as t INNER JOIN cola_relation as b ON t.relation_id = b.id where t.relation_id in ($list) and t.cityLevel_id = $cityLevelid and t.system_id = $systemid and t.platform_id = $platformid and t.category_id = $categoryid and t.menu_id = 1 and t.brand_id = 1 and t.capacity_id = 1 and t.bottle_id = 8";
                $allkos = Yii::app()->db->createCommand($sqlallkos)->queryAll();
                if (Yii::app()->language == 'zh_cn') {
                    foreach ($allkos as $ko) {
                        $koinfos[] = array(
                            $ko['depth'], $ko['name'], $ko['last_sales_share'], $ko['sales_share'], $ko['id'], $ko['name']
                        );
                    }
                } else {
                    foreach ($allkos as $ko) {
                        if ($ko['depth'] == 3) {
                            $relation = $ko['name'];
                        } else {
                            $relation = isset(Yii::app()->params['cvs_map_china'][$ko['name']]) ? Yii::app()->params['cvs_map_china'][$ko['name']] : $ko['name'];
                        }
                        $koinfos[] = array($ko['depth'], $ko['name'], $ko['last_sales_share'], $ko['sales_share'], $ko['id'], $relation);
                    }
                }
                //特殊的区域名
                $sqlallkoss = "select t.sales_share,t.last_sales_share,b.id,b.name,b.depth from ".$tableName." as t INNER JOIN cola_relation as b ON t.relation_id = b.id where t.relation_id in($listBloc) and t.cityLevel_id = $cityLevelid and t.system_id = $systemid and t.platform_id = $platformid and t.category_id = $categoryid and t.menu_id = 1 and t.brand_id = 1  and t.capacity_id = 1 and t.bottle_id = 8";
                $allkoss = Yii::app()->db->createCommand($sqlallkoss)->queryAll();
                if (Yii::app()->language == 'zh_cn') {
                    foreach ($allkoss as $value) {
                        //插入特殊区域坐标
                        $koinfoss[] = array(
                            $value['depth'], $value['name'], Yii::app()->params['specialLocate'][$value['name']], $value['last_sales_share'], $value['sales_share'],
                            $value['id'], $value['name']
                        );
                    }
                } else {
                    foreach ($allkoss as $value) {
                        if ($value['depth'] == 3) {
                            $relation = $value['name'];
                        } else {
                            $relation = isset(Yii::app()->params['cvs_map_china'][$value['name']]) ? Yii::app()->params['cvs_map_china'][$value['name']] : $value['name'];
                        }
                        $eng_specialLocate = isset(Yii::app()->params['eng_specialLocate'][$value['name']]) ? Yii::app()->params['eng_specialLocate'][$value['name']] : $value['name'];
                        $koinfoss[] = array(
                            $value['depth'], $value['name'], $eng_specialLocate, $value['last_sales_share'], $value['sales_share'], $value['id'], $relation
                        );
                    }
                }
            }
        }
        $infos['koinfos'] = $koinfos;//地图数据
        $infos['koinfoss'] = $koinfoss;//地图数据
        echo CJSON::encode($infos);
    }

    public function actionReportRetail()
    {
        $status = 0;
        $info = '您没有权限访问！！';
        if (isset($_POST['sj'])) {
            $sj = $_POST['sj'];
            $criteria = new CDbCriteria();
            $criteria->addCondition('time="' . $sj . '"');
            $criteria->order = "stage asc";
            $presentlist = Presentation::model()->findAll($criteria);
            $info = [];
            if (!empty($presentlist)) {
                foreach ($presentlist as $v) {
                    $add = array();
                    $add['id'] = $v->Id;
                    $add['stage'] = $v->stage;
                    $add['url'] = $v->downloadLinks;
                    $info[] = $add;
                }
            }
            if (empty($info)) {
                $status = 0;
            } else {
                $status = 1;
            }
        }
        echo $this->returnjson(array('info' => $info, 'status' => $status));
    }

    public function actionUploadExcelRetail()
    {
        if (isset($_GET['id'])) {
            $model = Presentation::model()->findByPk($_GET['id']);
            $runtimeurl = './uploads/retail/runtime/';

            if (!empty($model) && file_exists($model->downloadLinks) && $this->makeDir($runtimeurl)) {
                $target_name = date('YmdHis') . rand(1000, 9999) . strrchr($model->downloadLinks, '.');
                @copy($model->downloadLinks, $runtimeurl . $target_name);
                Yii::app()->request->sendFile($target_name, file_get_contents($runtimeurl . $target_name));
            }
        }
    }

    private function memory_usage() {
        $memory  = ( ! function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2).'MB';
        return $memory;
    }

    private function getAllTable(){
        $sql = "select table_name from information_schema.tables where table_schema='cokeretail' and table_type='BASE TABLE' and TABLE_NAME like 'cola_info_%' ORDER BY TABLE_NAME desc limit 4";
        $table = Yii::app()->db->createCommand($sql)->queryAll();
        $arr = [];
        foreach ($table as $key=>$value){
            $tableName = $value['table_name'];
            $infomation = explode('_',$tableName);
            if(isset($infomation[2],$infomation[3],$infomation[4])){
                $arr[] = ['time'=>$infomation[2].'_'.$infomation[3],'stage'=>$infomation[4]];
            }
        }
        return $arr;
    }

    private function getMaxTime(){
        $info = $this->getAllTable();
        $arr = $maxStage = [];
        foreach ($info as $key=>$value){
            $arr[] = $value['time'];
            $maxStage[$value['time']][] = $value['stage'];
        }
        $time = max($arr);
        $stage = max($maxStage[$time]);
        $infomation = [
            'time'=>$time,
            'stage'=>$stage
        ];
        return $infomation;
    }

    private function getAllTableLimit($month,$stage){
        $table_name = "cola_info_".$month."_".$stage;
        $sql = "select table_name from information_schema.tables where TABLE_NAME <= '".$table_name."' and table_schema='cokeretail' and table_type='BASE TABLE' and TABLE_NAME like 'cola_info_%".$stage."' ORDER BY TABLE_NAME asc limit 4";
        $table = Yii::app()->db->createCommand($sql)->queryAll();
        $arr = [];
        foreach ($table as $key=>$value){
            $tableName = $value['table_name'];
            $info = substr($tableName,0,9);
            if($info =='cola_info'){
                $infomation = explode('_',$tableName);
                $arr[] = ['time'=>$infomation[2]."_".$infomation[3],'stage'=>$infomation[4]];
            }
        }
        return $arr;
    }

    private function checkTable($tableName){
        $name = 'cola_info_' . $tableName;
        $sql = 'SHOW TABLES LIKE "' . $name . '"';
        $isset = Yii::app()->db->createCommand($sql)->queryAll();
        if(empty($isset)){
            return false;
        }else{
            return true;
        }
    }

    public function actionRetailAttach(){
        $this->render('retailAttach');
    }
}
