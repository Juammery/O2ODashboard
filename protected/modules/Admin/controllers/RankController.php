<?php

class RankController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
//    public $layout = '//layouts/column_2';

    /**
     * @return array action filters
     */
//    public function filters()
//    {
//        return array(
//            'accessControl', // perform access control for CRUD operations
//            'postOnly + delete', // we only allow deletion via POST request
//        );
//    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
//    public function accessRules()
//    {
//        return array(
//            array('allow',  // allow all users to perform 'index' and 'view' actions
//                'actions' => array('index', 'view'),
//                'users' => array('*'),
//            ),
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('create', 'update'),
//                'users' => array('@'),
//            ),
//            array('allow', // allow admin user to perform 'admin' and 'delete' actions
//                'actions' => array('admin', 'delete'),
//                'users' => array('admin'),
//            ),
//            array('deny',  // deny all users
//                'users' => array('*'),
//            ),
//        );
//    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadInternModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Rank;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Rank'])) {
            $model->attributes = $_POST['Rank'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadInternModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Rank'])) {
            $model->attributes = $_POST['Rank'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadInternModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Rank');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Rank('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Rank']))
            $model->attributes = $_GET['Rank'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Rank the loaded model
     * @throws CHttpException
     */
    public function loadInternModel($id)
    {
        $model = Rank::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Rank $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rank-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function quanbu($data, $str, $sql,$group)
    {

        for ($i = 0; $i < count($data); $i++) {
            if (!strstr($data[$i], '全部')) {
                $select1 = rtrim(str_replace($data[$i], "'全部'".$data[$i], $str),",");
                $select = " select " . $select1;
                $sql .= $select . " from sku_2018 where dt='2018-12-01'" . $group . " union ";
            } else {
//                $str = str_replace($data[$i] . ",", '', $str);
                continue;
            }
            if($i==count($data)-1){
                $select1=str_replace("'全部'".$data[$i],$data[$i],  $str);
            }
        }

        for ($j = 3; $j <= count($data); $j++) {

            if (!strstr($data[$j], '全部')) {
                if ($j == count($data) - 1) {
                    $this->pd(str_replace('rongliang','pack_level',str_replace('province','city_level',$sql))) ;
                }else{
                    $select1 = str_replace($data[$j], "'全部'".$data[$j], $select1);
                    $data[$j]="'全部'".$data[$j];

                }
                $this->quanbu($data, $select1, $sql,$group);
            }
        }
    }

    //麒麟计算数据
    public function actionKylinData()
    {
        //city_level=province;pack_level=rongliang
//        $data = array("province", "channel", "platform", "type", "manu", "pinpai", "level", "rongliang");
//        $str = "province,channel,platform,type,manu,pinpai,level,rongliang,";
//        $sql = '';
//        $sql=$this->quanbu($data, $str, $sql," group by " .rtrim($str,','));
////        print_r($sql);
//        $this->pd($sql);

//
//        die;

//        Yii::log(print_r($res, true), 'warning');
        $t1 = microtime(true);
        $Citylevel = Citylevel::model()->findAll(['index' => 'name']);
        $System = System::model()->findAll(['index' => 'name']);
        $Platform = Platform::model()->findAll(['index' => 'name']);
        $Category = Category::model()->findAll(['index' => 'name']);
//        $Relation = Relation::model()->findAll(['index' => 'name']);
        $Relation = Relation::model()->findAll(['condition'=>'depth=2','index'=>'name']); //装瓶厂 城市
        $t2 = microtime(true);
        $res = round($t2-$t1,3);
        Yii::log('建立索引'.'==='.print_r($res, true), 'warning');
        $t1 = microtime(true);
        $this->getOrder(0, 0, $Citylevel, $System, $Platform, $Category, $Relation);
        $t2 = microtime(true);
        $res = round($t2-$t1,3);
        Yii::log('递归'.'==='.print_r($res, true), 'warning');

    }

//    public function getOrder($start, $j, $Citylevel, $System, $Platform, $Category, $Relation)
//    {
//        set_time_limit('-1');//不限制执行时间
//        $base = base64_encode('admin:KYLIN');
//        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
//        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
//        $datagroup = "select zpjt, city_level,platform,channel,type from sku_2018 where dt = '2018-12-01' group by zpjt,city_level,platform,channel,type union select '全部' zpjt,city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by city_level,platform,channel,type  union select zpjt,'全部' city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,channel,type  union select zpjt,city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,channel,type  union select zpjt,city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,platform,type union select zpjt,city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,platform,channel  union select zpjt,'全部' city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt  union select '全部' zpjt,city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level  union select '全部' zpjt,'全部' city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by platform  union select '全部' zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by channel  union select '全部' zpjt,'全部' city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by type  union select '全部' zpjt,'全部' city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by platform,channel, type union select '全部' zpjt,city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by city_level,channel,type union select '全部' zpjt,city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by platform,city_level,type union select '全部' zpjt,city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,platform,channel union select zpjt,'全部' city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,channel,type union select zpjt,'全部' city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,type union select zpjt,'全部' city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,channel union select zpjt,city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,type union select zpjt,city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,channel union select zpjt,city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,platform union select zpjt,city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level union select zpjt,'全部' city_level,platform, '全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,platform union select zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,channel union select zpjt,'全部' city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,type union select '全部' zpjt,city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,platform union select '全部' zpjt,city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,channel union select '全部' zpjt, city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by city_level,type union select '全部' zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by channel,platform union select '全部' zpjt,'全部' city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by platform,type union select '全部' zpjt,'全部' city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by channel,type union select '全部' zpjt,'全部' city_level, '全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01'";
////        $datagroup = "select zpjt, city_level,platform,channel,type from sku_2018 where dt = '2018-12-01' and zpjt='ZH' group by zpjt,city_level,platform,channel,type union select '全部' zpjt,city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by city_level,platform,channel,type  union select zpjt,'全部' city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,channel,type  union select zpjt,city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,channel,type  union select zpjt,city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,platform,type union select zpjt,city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,platform,channel  union select zpjt,'全部' city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt  union select '全部' zpjt,city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level  union select '全部' zpjt,'全部' city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by platform  union select '全部' zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by channel  union select '全部' zpjt,'全部' city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by type  union select '全部' zpjt,'全部' city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by platform,channel, type union select '全部' zpjt,city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by city_level,channel,type union select '全部' zpjt,city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by platform,city_level,type union select '全部' zpjt,city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,platform,channel union select zpjt,'全部' city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,channel,type union select zpjt,'全部' city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,type union select zpjt,'全部' city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,channel union select zpjt,city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,type union select zpjt,city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,channel union select zpjt,city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,platform union select zpjt,city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level union select zpjt,'全部' city_level,platform, '全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,platform union select zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,channel union select zpjt,'全部' city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,type union select '全部' zpjt,city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,platform union select '全部' zpjt,city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,channel union select '全部' zpjt, city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by city_level,type union select '全部' zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by channel,platform union select '全部' zpjt,'全部' city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by platform,type union select '全部' zpjt,'全部' city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by channel,type union select '全部' zpjt,'全部' city_level, '全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01'";
//                $datagroup=str_replace('zpjt','zpc',$datagroup);
//        $params = CJSON::encode([
//            'sql' => $datagroup,
//            'project' => 'O2O_retail',
//            "acceptPartial" => false,
//            'offset' => $start,
//            'limit' => 2000
//        ]);
//        $data = $this->getRetailCurl($url, $params, $header);
//        $data = $data["results"];
//        $newdata = [];
//        if (!empty($data)) {
//            foreach ($data as $key => $value) {
//                $common = $value[0] == '全部' ? "(select '全部' zpjt," : '(select zpjt,';
//                // $common+=($value[0]=='全部'?' '全部' zpc,':'zpc,');
//                $common .= ($value[1] == '全部' ? " '全部' city_level," : 'city_level,');
//                // $common+=($value[0]=='全部'?' '全部' city,':'city,');
//                $common .= $value[2] == '全部' ? "'全部' platform," : 'platform,';
//                $common .= ($value[3] == '全部' ? "'全部' channel," : 'channel,');
//                $common .= ($value[4] == '全部' ? "'全部' type,shangpin,pack,dt," : 'type,shangpin,pack,dt,');
//                // $common+=("sum(sales_amount) sales_amount from sku_2018 where dt='2018-11-01' '');
////            $common.=('sum(sales_amount) sales_amount from sku_2018 ');
//                $common .= ('sum(sales_amount) sales_amount from sku_2018 '); //where is_ko=1
//                $common .= ' group by shangpin,pack,dt,';
//                if (!($value[0] == '全部' && $value[1] == '全部' && $value[3] == '全部' && $value[2] == '全部' && $value[4] == '全部')) {
//                    $common .= ($value[0] == '全部' ? '' : 'zpjt,');
//                    // $common+=($scope.zpc1=='全部'?'':'zpc,');
//                    $common .= ($value[1] == '全部' ? '' : 'city_level,');
//                    // $common+=($scope.city1=='全部'?'':'city,');
//                    $common .= ($value[2] == '全部' ? '' : 'platform,');
//                    $common .= ($value[3] == '全部' ? '' : 'channel,');
//                    $common .= ($value[4] == '全部' ? '' : 'type,');
//                }
//                //   $common=$common.replace(/(.*)[,，]$/, '$1');
//                $common = rtrim($common, ",");
//                $rightcommon = str_replace('2018-12-01', '2018-11-01', $common);
//
//                $topdata = 'SELECT zpjt,city_level,channel,platform,type,b.packdata AS ad_name,shangpin, SUM(sales_amount) AS sum__imp_pv,b.x  FROM' . $common . ') inner join (SELECT shangpin AS __ad_id,pack AS packdata,sum(sales_amount) AS x,zpjt AS lastzpjt,city_level AS lastcitylevel,channel AS lastchannel,platform AS lastplatform,type AS lasttype FROM ' . $rightcommon . ") where dt='2018-11-01' group by shangpin,pack,zpjt,city_level,platform,channel,type) AS b ON (shangpin = __ad_id and pack=packdata and zpjt=lastzpjt and city_level=lastcitylevel and type=lasttype and channel= lastchannel and platform=lastplatform) WHERE dt = '2018-12-01'  and zpjt='" . $value[0] . "' and city_level='" . $value[1] . "' and platform= '" . $value[2] . "' and type='" . $value[4] . "' and channel='" . $value[3] . "' GROUP by b.packdata, dt,shangpin,b.x,zpjt,city_level,channel,platform,type ORDER by sum(sales_amount) desc limit 10";
////                $topdata = 'SELECT zpjt,city_level,channel,platform,type,b.packdata AS ad_name,shangpin, SUM(sales_amount) AS sum__imp_pv,b.x  FROM' . $common . ') inner join (SELECT shangpin AS __ad_id,pack AS packdata,sum(sales_amount) AS x,zpjt AS lastzpjt,city_level AS lastcitylevel,channel AS lastchannel,platform AS lastplatform,type AS lasttype FROM ' . $rightcommon . ") where dt='2018-11-01' group by shangpin,pack,zpjt,city_level,platform,channel,type) AS b ON (shangpin = __ad_id and pack=packdata and zpjt=lastzpjt and city_level=lastcitylevel and type=lasttype and channel= lastchannel and platform=lastplatform) WHERE dt = '2018-12-01'  and zpjt='" . $value[0] . "' and city_level='" . $value[1] . "' and platform= '" . $value[2] . "' and type='" . $value[4] . "' and channel='" . $value[3] . "' GROUP by b.packdata, dt,shangpin,b.x,zpjt,city_level,channel,platform,type ORDER by sum(sales_amount) desc limit 10";
//
//                                $topdata=str_replace('zpjt','zpc',$topdata);
////                $topdata=str_replace('zpjt','city',$topdata);
//                $params0 = CJSON::encode([
//                    'sql' => $topdata,
//                    'project' => 'O2O_retail',
//                    "acceptPartial" => false
////            'limit'=>5
//                ]);
////                pd($topdata);
//                $toptendata = $this->getRetailCurl($url, $params0, $header);
//
//                $toptendata = $toptendata["results"];
////                var_dump($toptendata);exit;
//                if (!empty($toptendata)) {//不为空的判断
//                    $info = array();
//                    $index = 1;
//                    foreach ($toptendata as $key => $value) {
//
////                $city=rtrim($value[0], "市");
////                var_dump($Relation[$value[0]]->id);exit;
////                $model = Relation::model()->find(array('condition' => 'depth=2 and name = "'.$value[0].'"'));
////                $model = Relation::model()->find(array('condition' => 'depth=3 and name = "'.$city.'"'));
////                $zpjtid = isset($model)?$model->id:0;
////                $info[$key]['relation_id']=$zpjtid;
////                        $info[$key]['relation_id'] = $value[0] == "SCCL" ? 2 : ($value[0] == "CBL" ? 3 : ($value[0] == "ZH" ? 65 : ($value[0] == "全部" ? 1 : 0)));
//
////                        $city=rtrim($value[0], "市");
////                        $Relationid = isset($Relation[$city]) ? $Relation[$city]->id : 0;
////                        $Relationid = isset($Relation[$value[0]]) ? $Relation[$value[0]]->id : 0;
//                        $Relationid=$Relation[$value[0]];
////                        var_dump($Relationid);exit;
//                        $info[$key]['relation_id'] = $Relationid;
//                        $city_levelid = isset($Citylevel[$value[1]]) ? $Citylevel[$value[1]]->id : 0;
//                        $info[$key]['cityLevel_id'] = $city_levelid;
//                        $channelid = isset($System[$value[2]]) ? $System[$value[2]]->id : 0;
//                        $info[$key]['system_id'] = $channelid;
//                        $platformid = isset($Platform[$value[3]]) ? $Platform[$value[3]]->id : 0;
//                        $info[$key]['platform_id'] = $platformid;
//                        $skuid = isset($Category[$value[4]]) ? $Category[$value[4]]->id : 0;
//                        $info[$key]['sku_id'] = $skuid;
//                        $info[$key]['time'] = "2018_12";
//                        $info[$key]['stage'] = 0;
//                        $info[$key]['classify'] = 3;
//                        $info[$key]['ranking'] = $index;
//                        $info[$key]['sku_name'] = $value[6];
//                        $info[$key]['bottle'] = $value[5];
//                        $info[$key]['sales_amount'] = $value[7];
//                        if ($value[8] == 0) {
//                            $info[$key]['last_sales_amount'] = 1;
//                        } else $info[$key]['last_sales_amount'] = ($value[7] - $value[8]) / $value[8];
////                        $info[$key]['last_sales_amount'] = isset($value[8])?$value[8]:0;
//                        $index++;
//                    }
//
//                    $newdata = array_merge($info, $newdata);
////                    pd($newdata);
//
//                } else {
//                    continue;
//                }
//
////            $toptendata=$toptendata["results"];
//
//            }
////        $this->pd($newdata);
//            $label = array('relation_id', 'cityLevel_id', 'system_id', 'platform_id', 'sku_id', 'time', 'stage', 'classify', 'ranking', 'sku_name', 'bottle',
//                'sales_amount', 'last_sales_amount');
//            $log = [];
////        $arr = array_chunk($info, 2000);
//            $arr = array_chunk($newdata, 2000);
//            for ($i = 0; $i < count($arr); $i++) {
//                $log[] = $this->batchInsert('cola_rank', $label, $arr[$i]);
//            }
//            $start = ($j + 1) * 2000;
//            var_dump($start);
//            $this->getOrder($start, $j + 1, $Citylevel, $System, $Platform, $Category, $Relation);
//        } else {
//            $this->pd($data);
//            die("结束");
//        }
//    }

    public function getOrder($start, $j, $Citylevel, $System, $Platform, $Category, $Relation)
    {
        set_time_limit('-1');//不限制执行时间
        $base = base64_encode('admin:KYLIN');
        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
        $header = ["Authorization:Basic $base", "Content-Type: application/json;charset=UTF-8"];
//        $datagroup = "select zpjt, city_level,platform,channel,type from sku_2018 where dt = '2018-12-01' group by zpjt,city_level,platform,channel,type union select '全部' zpjt,city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by city_level,platform,channel,type  union select zpjt,'全部' city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,channel,type  union select zpjt,city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,channel,type  union select zpjt,city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,platform,type union select zpjt,city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,platform,channel  union select zpjt,'全部' city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt  union select '全部' zpjt,city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level  union select '全部' zpjt,'全部' city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by platform  union select '全部' zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by channel  union select '全部' zpjt,'全部' city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by type  union select '全部' zpjt,'全部' city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by platform,channel, type union select '全部' zpjt,city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by city_level,channel,type union select '全部' zpjt,city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by platform,city_level,type union select '全部' zpjt,city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,platform,channel union select zpjt,'全部' city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,channel,type union select zpjt,'全部' city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,type union select zpjt,'全部' city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,channel union select zpjt,city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,type union select zpjt,city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,channel union select zpjt,city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,platform union select zpjt,city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level union select zpjt,'全部' city_level,platform, '全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,platform union select zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,channel union select zpjt,'全部' city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,type union select '全部' zpjt,city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,platform union select '全部' zpjt,city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,channel union select '全部' zpjt, city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by city_level,type union select '全部' zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by channel,platform union select '全部' zpjt,'全部' city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by platform,type union select '全部' zpjt,'全部' city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by channel,type union select '全部' zpjt,'全部' city_level, '全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01'";
//        $datagroup = "select zpc, city_level,platform,channel,type from sku_2018 where dt = '2018-12-01' group by zpc, city_level,platform,channel,type";
        $datagroup = "select zpc,city_level,platform,channel,type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union 
select zpc,'全部' city_level,platform,channel,type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc,city_level,'全部' platform,channel,type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc, city_level,platform,'全部'channel,type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc,city_level,platform,channel,'全部' type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc,'全部' city_level,'全部' platform,channel,type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc,'全部' city_level,platform,'全部' channel,type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc,'全部' city_level,platform,channel,'全部' type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc,city_level,'全部' platform,'全部' channel,type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc, city_level,platform,'全部'channel,'全部' type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc,city_level,platform,'全部' channel,'全部' type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc,'全部' city_level,'全部' platform,'全部' channel,type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc,'全部' city_level,platform,'全部' channel,'全部' type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc,city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type union
select zpc,'全部' city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt='2018-12-01' group by  zpc,city_level,platform,channel,type ";
        //        $datagroup = "select zpjt, city_level,platform,channel,type from sku_2018 where dt = '2018-12-01' and zpjt='ZH' group by zpjt,city_level,platform,channel,type union select '全部' zpjt,city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by city_level,platform,channel,type  union select zpjt,'全部' city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,channel,type  union select zpjt,city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,channel,type  union select zpjt,city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,platform,type union select zpjt,city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,platform,channel  union select zpjt,'全部' city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt  union select '全部' zpjt,city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level  union select '全部' zpjt,'全部' city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by platform  union select '全部' zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by channel  union select '全部' zpjt,'全部' city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by type  union select '全部' zpjt,'全部' city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by platform,channel, type union select '全部' zpjt,city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by city_level,channel,type union select '全部' zpjt,city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by platform,city_level,type union select '全部' zpjt,city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,platform,channel union select zpjt,'全部' city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,channel,type union select zpjt,'全部' city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,type union select zpjt,'全部' city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,channel union select zpjt,city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,type union select zpjt,city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,channel union select zpjt,city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,platform union select zpjt,city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level union select zpjt,'全部' city_level,platform, '全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,platform union select zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,channel union select zpjt,'全部' city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,type union select '全部' zpjt,city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,platform union select '全部' zpjt,city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,channel union select '全部' zpjt, city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by city_level,type union select '全部' zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by channel,platform union select '全部' zpjt,'全部' city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by platform,type union select '全部' zpjt,'全部' city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by channel,type union select '全部' zpjt,'全部' city_level, '全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01'";
//        $datagroup=str_replace('zpjt','zpc',$datagroup);
        $params = CJSON::encode([
            'sql' => $datagroup,
            'project' => 'O2O_retail',
            "acceptPartial" => false,
            'offset' => $start,
            'limit' => 1000
        ]);
        $t1 = microtime(true);
        $data = $this->getRetailCurl($url, $params, $header);
        $t2 = microtime(true);
        $res = round($t2-$t1,3);
        Yii::log('请求组合'.'==='.print_r($res, true), 'warning');
        $data = $data["results"];
        $newdata = [];
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $common = $value[0] == '全部' ? "(select '全部' zpjt," : '(select zpjt,';
                // $common+=($value[0]=='全部'?' '全部' zpc,':'zpc,');
                $common .= ($value[1] == '全部' ? " '全部' city_level," : 'city_level,');
                // $common+=($value[0]=='全部'?' '全部' city,':'city,');
                $common .= $value[2] == '全部' ? "'全部' platform," : 'platform,';
                $common .= ($value[3] == '全部' ? "'全部' channel," : 'channel,');
                $common .= ($value[4] == '全部' ? "'全部' type,shangpin,pack,dt," : 'type,shangpin,pack,dt,');
                // $common+=("sum(sales_amount) sales_amount from sku_2018 where dt='2018-11-01' '');
//            $common.=('sum(sales_amount) sales_amount from sku_2018 ');
                $common .= ('sum(sales_amount) sales_amount from sku_2018'); //where is_ko=1
                $common .= ' group by shangpin,pack,dt,';
                if (!($value[0] == '全部' && $value[1] == '全部' && $value[3] == '全部' && $value[2] == '全部' && $value[4] == '全部')) {
                    $common .= ($value[0] == '全部' ? '' : 'zpjt,');
                    // $common+=($scope.zpc1=='全部'?'':'zpc,');
                    $common .= ($value[1] == '全部' ? '' : 'city_level,');
                    // $common+=($scope.city1=='全部'?'':'city,');
                    $common .= ($value[2] == '全部' ? '' : 'platform,');
                    $common .= ($value[3] == '全部' ? '' : 'channel,');
                    $common .= ($value[4] == '全部' ? '' : 'type,');
                }
                //   $common=$common.replace(/(.*)[,，]$/, '$1');
                $common = rtrim($common, ",");
//                $rightcommon = str_replace('2018-12-01', '2018-11-01', $common);

//                $topdata = 'SELECT zpjt,city_level,channel,platform,type,b.packdata AS ad_name,shangpin, SUM(sales_amount) AS sum__imp_pv,(SUM(sales_amount)-b.x)/b.x  FROM' . $common . ') inner join (SELECT shangpin AS __ad_id,pack AS packdata,sum(sales_amount) AS x,zpjt AS lastzpjt,city_level AS lastcitylevel,channel AS lastchannel,platform AS lastplatform,type AS lasttype FROM ' . $rightcommon . ") where dt='2018-11-01' group by shangpin,pack,zpjt,city_level,platform,channel,type) AS b ON (shangpin = __ad_id and pack=packdata and zpjt=lastzpjt and city_level=lastcitylevel and type=lasttype and channel= lastchannel and platform=lastplatform) WHERE dt = '2018-12-01'  and zpjt='" . $value[0] . "' and city_level='" . $value[1] . "' and platform= '" . $value[2] . "' and type='" . $value[4] . "' and channel='" . $value[3] . "' GROUP by b.packdata, dt,shangpin,b.x,zpjt,city_level,channel,platform,type ORDER by sum(sales_amount) desc limit 10";
//                $topdata = 'SELECT zpjt,city_level,channel,platform,type,b.packdata AS ad_name,shangpin, SUM(sales_amount) AS sum__imp_pv,b.x  FROM' . $common . ') inner join (SELECT shangpin AS __ad_id,pack AS packdata,sum(sales_amount) AS x,zpjt AS lastzpjt,city_level AS lastcitylevel,channel AS lastchannel,platform AS lastplatform,type AS lasttype FROM ' . $rightcommon . ") where dt='2018-11-01' group by shangpin,pack,zpjt,city_level,platform,channel,type) AS b ON (shangpin = __ad_id and pack=packdata and zpjt=lastzpjt and city_level=lastcitylevel and type=lasttype and channel= lastchannel and platform=lastplatform) WHERE dt = '2018-12-01'  and zpjt='" . $value[0] . "' and city_level='" . $value[1] . "' and platform= '" . $value[2] . "' and type='" . $value[4] . "' and channel='" . $value[3] . "' GROUP by b.packdata, dt,shangpin,b.x,zpjt,city_level,channel,platform,type ORDER by sum(sales_amount) desc limit 10";
                $topdata= "select zpjt,city_level,channel,platform,type,shangpin,pack,sales_amount from".$common.") WHERE dt = '2018-11-01'  and zpjt='" . $value[0] . "' and city_level='" . $value[1] . "' and platform= '" . $value[2] . "' and type='" . $value[4] . "' and channel='" . $value[3] ."' ORDER by sales_amount desc limit 10";
                $topdata=str_replace('zpjt','zpc',$topdata);
//                $topdata=str_replace('zpjt','city',$topdata);
                $params0 = CJSON::encode([
                    'sql' => $topdata,
                    'project' => 'O2O_retail',
                    "acceptPartial" => false
//            'limit'=>5
                ]);
//                pd($topdata);
                $t1 = microtime(true);
                $toptendata = $this->getRetailCurl($url, $params0, $header);
                $t2 = microtime(true);
                $res = round($t2-$t1,3);
                Yii::log('请求单次参数'.$key.'==='.print_r($res, true), 'warning');
                $toptendata = $toptendata["results"];

                if (!empty($toptendata)) {//不为空的判断
                    $info = array();
                    $index = 1;
                    foreach ($toptendata as $key => $value) {
//                $city=rtrim($value[0], "市");
//                var_dump($city);
//                $model = Relation::model()->find(array('condition' => 'depth=2 and name = "'.$value[0].'"'));
//                $model = Relation::model()->find(array('condition' => 'depth=3 and name = "'.$city.'"'));
//                $zpjtid = isset($model)?$model->id:0;
//                $info[$key]['relation_id']=$zpjtid;
//                        $info[$key]['relation_id'] = $value[0] == "SCCL" ? 2 : ($value[0] == "CBL" ? 3 : ($value[0] == "ZH" ? 65 : ($value[0] == "全部" ? 1 : 0)));

//                        $city=rtrim($value[0], "市");
//                        $Relationid = isset($Relation[$city]) ? $Relation[$city]->id : 0;
                        $Relationid = isset($Relation[$value[0]]) ? $Relation[$value[0]]->id : 0;
//                        var_dump($Relationid);exit;
                        $info[$key]['relation_id'] = $Relationid;
                        $city_levelid = isset($Citylevel[$value[1]]) ? $Citylevel[$value[1]]->id : 0;
                        $info[$key]['cityLevel_id'] = $city_levelid;
                        $channelid = isset($System[$value[2]]) ? $System[$value[2]]->id : 0;
                        $info[$key]['system_id'] = $channelid;
                        $platformid = isset($Platform[$value[3]]) ? $Platform[$value[3]]->id : 0;
                        $info[$key]['platform_id'] = $platformid;
                        $skuid = isset($Category[$value[4]]) ? $Category[$value[4]]->id : 0;
                        $info[$key]['sku_id'] = $skuid;
                        $info[$key]['time'] = "2018_11";
                        $info[$key]['stage'] = 0;
                        $info[$key]['classify'] = 3;
                        $info[$key]['ranking'] = $index;
                        $info[$key]['sku_name'] = $value[6];
                        $info[$key]['bottle'] = $value[5];
                        $info[$key]['sales_amount'] = $value[7];
//                        if ($value[8] == 0) {
//                            $info[$key]['last_sales_amount'] = 1;
//                        } else $info[$key]['last_sales_amount'] = ($value[7] - $value[8]) / $value[8];
//                        $info[$key]['last_sales_amount'] = $value[8];
//                        $index++;
                    }

                    $newdata = array_merge($info, $newdata);

                } else {
                    continue;
                }

//            $toptendata=$toptendata["results"];

            }
//        $this->pd($newdata);
//            $label = array('relation_id', 'cityLevel_id', 'system_id', 'platform_id', 'sku_id', 'time', 'stage', 'classify', 'ranking', 'sku_name', 'bottle',
//                'sales_amount', 'last_sales_amount');
            $label = array('relation_id', 'cityLevel_id', 'system_id', 'platform_id', 'sku_id', 'time', 'stage', 'classify', 'ranking', 'sku_name', 'bottle',
                'sales_amount');
            $log = [];
//        $arr = array_chunk($info, 2000);
            $arr = array_chunk($newdata, 2000);
            for ($i = 0; $i < count($arr); $i++) {
                $t1 = microtime(true);
                $log[] = $this->batchInsert('cola_rank', $label, $arr[$i]);
                $t2 = microtime(true);
                $res = round($t2-$t1,3);
                Yii::log('插入数据库'.$i.'==='.print_r($res, true), 'warning');
            }
            $start = ($j + 1) * 1000;
//            var_dump($start);
//            exit;
            Yii::log('递归次数：'.$j, 'warning');
            $this->getOrder($start, $j + 1, $Citylevel, $System, $Platform, $Category, $Relation);
        } else {
//            $this->pd($data);
//            die("结束");
            var_dump('结束');
        }
    }

//    public  function  actionKylinData()
//    {
//        $arr = [
//            ['全部','Metro','饿了么'], ['全部','U1','京东到家'], ['CBL','Metro','京东到家'],
//            ['CBL','U1','饿了么'],
//            ['全部','Metro','美团外卖'],
//            ['全部','U2','京东到家'],
//            ['全部','Metro','京东到家']
//        ];
//        $info = [];
//        foreach ($arr as $key => $value){
//            $info[$value[0]][$value[1]][$value[2]][] = $value;
//        }
//        pd($info);
//        set_time_limit('-1');//不限制执行时间
//        ini_set("memory_limit",'1280M');
//        $base = base64_encode('admin:KYLIN');
//        $url = "http://data.togedata.com:16030/kylin/api/query";//查询url
//        $header = ["Authorization:Basic $base","Content-Type: application/json;charset=UTF-8"];
//        $datagroup="select zpjt, city_level,platform,channel,type from sku_2018 where dt = '2018-12-01' group by zpjt,city_level,platform,channel,type union select '全部' zpjt,city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by city_level,platform,channel,type  union select zpjt,'全部' city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,channel,type  union select zpjt,city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,channel,type  union select zpjt,city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,platform,type union select zpjt,city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt, city_level,platform,channel  union select zpjt,'全部' city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt  union select '全部' zpjt,city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level  union select '全部' zpjt,'全部' city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by platform  union select '全部' zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by channel  union select '全部' zpjt,'全部' city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by type  union select '全部' zpjt,'全部' city_level,platform,channel,type from sku_2018 where dt ='2018-12-01' group by platform,channel, type union select '全部' zpjt,city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by city_level,channel,type union select '全部' zpjt,city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by platform,city_level,type union select '全部' zpjt,city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,platform,channel union select zpjt,'全部' city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,channel,type union select zpjt,'全部' city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,type union select zpjt,'全部' city_level,platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,platform,channel union select zpjt,city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,type union select zpjt,city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,channel union select zpjt,city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level,platform union select zpjt,city_level,'全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,city_level union select zpjt,'全部' city_level,platform, '全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,platform union select zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by zpjt,channel union select zpjt,'全部' city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by zpjt,type union select '全部' zpjt,city_level,platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,platform union select '全部' zpjt,city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by city_level,channel union select '全部' zpjt, city_level,'全部' platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by city_level,type union select '全部' zpjt,'全部' city_level,'全部' platform,channel,'全部' type from sku_2018 where dt ='2018-12-01' group by channel,platform union select '全部' zpjt,'全部' city_level,platform,'全部' channel,type from sku_2018 where dt ='2018-12-01' group by platform,type union select '全部' zpjt,'全部' city_level,'全部' platform,channel,type from sku_2018 where dt ='2018-12-01' group by channel,type union select '全部' zpjt,'全部' city_level, '全部' platform,'全部' channel,'全部' type from sku_2018 where dt ='2018-12-01'";
////        echo "<pre>";var_dump($datagroup);
////        $regtest=new RegExp('2018-12-01','g');
////        $regzpc=new RegExp('zpjt','g');
//        $common="(select zpjt, city_level,platform,channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack, zpjt,city_level,platform,channel,type union select '全部' zpjt,city_level,platform,channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  city_level,platform,channel,type  union select zpjt,'全部' city_level,platform,channel,type,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt,platform,channel,type  union select zpjt,city_level,'全部' platform,channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt, city_level,channel,type  union select zpjt,city_level,platform,'全部' channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt, city_level,platform,type union select zpjt,city_level,platform,channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt, city_level,platform,channel  union select zpjt,'全部' city_level,'全部' platform,'全部' channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt  union select '全部' zpjt,city_level,'全部' platform,'全部' channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  city_level  union select '全部' zpjt,'全部' city_level,platform,'全部' channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  platform  union select '全部' zpjt,'全部' city_level,'全部' platform,channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  channel  union select '全部' zpjt,'全部' city_level,'全部' platform,'全部' channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  type  union select '全部' zpjt,'全部' city_level,platform,channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  platform,channel, type union select '全部' zpjt,city_level,'全部' platform,channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  city_level,channel,type union select '全部' zpjt,city_level,platform,'全部' channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  platform,city_level,type union select '全部' zpjt,city_level,platform,channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  city_level,platform,channel union select zpjt,'全部' city_level,'全部' platform,channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt,channel,type union select zpjt,'全部' city_level,platform,'全部' channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt,platform,type union select zpjt,'全部' city_level,platform,channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt,platform,channel union select zpjt,city_level,'全部' platform,'全部' channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt,city_level,type union select zpjt,city_level,'全部' platform,channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt,city_level,channel union select zpjt,city_level,platform,'全部' channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt,city_level,platform union select zpjt,city_level,'全部' platform,'全部' channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt,city_level union select zpjt,'全部' city_level,platform, '全部' channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt,platform union select zpjt,'全部' city_level,'全部' platform,channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt,channel union select zpjt,'全部' city_level,'全部' platform,'全部' channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  zpjt,type union select '全部' zpjt,city_level,platform,'全部' channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  city_level,platform union select '全部' zpjt,city_level,'全部' platform,channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  city_level,channel union select '全部' zpjt, city_level,'全部' platform,'全部' channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  city_level,type union select '全部' zpjt,'全部' city_level,'全部' platform,channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  channel,platform union select '全部' zpjt,'全部' city_level,platform,'全部' channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  platform,type union select '全部' zpjt,'全部' city_level,'全部' platform,channel,type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack,  channel,type union select '全部' zpjt,'全部' city_level, '全部' platform,'全部' channel,'全部' type ,shangpin,pack ,sum(sales_amount) sales_amount ,dt from sku_2018 where dt ='2018-12-01' group by shangpin,dt,pack";
//        $rightcommon=str_replace('2018-12-01','2018-11-01',$common);
//        $topdata='SELECT zpjt,city_level,channel,platform,type,b.packdata AS ad_name,shangpin, SUM(sales_amount) AS sum__imp_pv,b.x FROM'. $common. ') inner join (SELECT shangpin AS __ad_id,pack AS packdata,sum(sales_amount) AS x,zpjt AS lastzpjt,city_level AS lastcitylevel,channel AS lastchannel,platform AS lastplatform,type AS lasttype FROM ' .$rightcommon.") where dt='2018-11-01' group by shangpin,pack,zpjt,city_level,platform,channel,type) AS b ON (shangpin = __ad_id and pack=packdata and zpjt=lastzpjt and city_level=lastcitylevel and type=lasttype and channel= lastchannel and platform=lastplatform) WHERE dt = '2018-12-01' GROUP by b.packdata, dt,shangpin,b.x,zpjt,city_level,channel,platform,type";
//        $params = CJSON::encode([
//            'sql'=>$topdata,
//            'project'=>'O2O_retail',
//            "acceptPartial"=>false
////            'limit'=>5
//        ]);
//        $data = $this->getRetailCurl($url, $params,$header);
//       var_dump($data['results'][502585]);exit;
//
//    }

    public function getRetailCurl($url, $params, $header = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//执行结果是否被返回，0是返回，1是不返回(设置获取的信息以文件流的形式返回，而不是直接输出。)
        curl_setopt($ch, CURLOPT_POST, 1);// 发送一个常规的POST请求
        curl_setopt($ch, CURLOPT_URL, $url);//要访问的地址,设置URL
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
}