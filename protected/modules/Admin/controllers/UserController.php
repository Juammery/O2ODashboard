<?php

class UserController extends Controller
{
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
        $model = new User;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        
        if (isset($_POST['User'])) {
            //$this->pd($_REQUEST);
          /*  $jurisdiction = new Assignments();
            $jurisdiction1 = new Assignments();*/
            $model->attributes = $_POST['User'];
            $model->Frozen = 1;
            $model->Lately_pwd = date('Y-m-d H:i:s');
            $model->is_download = 1;
            $model->jurisdiction = "koProjectTeam";
//            $model->pwd = $model->hashPassword();
            if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\s\S]{8,16}$/', $model->pwd)){
                $this->hint('danger','至少8-16个字符，至少1个大写字母，1个小写字母和1个数字');
                $this->redirect(Yii::app()->request->urlReferrer);
            }else{
                $model->pwd = $model->hashPassword();
            }
           // $jurisdictionName = $model->jurisdiction;

//            if ($model->group) {
//                $model->downloadRange = $model->group;
//            }
//            if ($model->bottler) {
//                $model->downloadRange = $model->bottler;
//            }
            //echo $model->jurisdiction;die;
           // echo $model->pwd;

            if ($model->save()){
                $auth = yii::app()->authmanager;

                if ($model->is_download==1){
                    $auth->assign('download', $model->Id);
                }
                if(in_array($model->jurisdiction,Yii::app()->params['allowaddroles'])){
                    $auth->assign($model->jurisdiction, $model->Id);
                }


                $this->redirect(array('view', 'id' => $model->Id));
            }
           /*     $jurisdiction->itemname = $jurisdictionName;
            $jurisdiction->userid = $model->Id;
            $jurisdiction1->itemname = $is_download;
            $jurisdiction1->userid = $model->Id;*/
            //var_dump($model->getErrors());die;
           /* $jurisdiction->save();
            $jurisdiction1->save();*/

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
        $model->updatedata();
        //$this->pd($model);
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        if (User::model()->findByPk($id)) {
            $pwd = User::model()->findByPk($id)->pwd;
            //echo $pwd;
        }



        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
          /*  $jurisdiction = new Assignments();
            $jurisdiction1 = new Assignments();
            $ass = Assignments::model()->find('userid=' . $model->Id . ' and itemname != "download"');
            $ass1 = Assignments::model()->find('userid=' . $model->Id . ' and itemname ="download"');*/
            if ($model->group) {
                $model->downloadRange = $model->group;
            }
            if ($model->bottler) {
                $model->downloadRange = $model->bottler;
            }
            if ($model->pwd) {
                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\s\S]{8,16}$/', $model->pwd)) {
                    $this->hint('danger','至少8-16个字符，至少1个大写字母，1个小写字母和1个数字');
                    $this->redirect(Yii::app()->request->urlReferrer);
                }else{
                    $model->pwd = $model->hashPassword();
                }
            } else {
                $model->pwd = $pwd;
            }
            if($model->save()){
                $auth = yii::app()->authmanager;
                $roles = $auth->getroles($model->Id);
                $key_roles=array_keys($roles);
                if($model->is_download==1){
                    if(!in_array('download',$key_roles)){
                        $auth->assign('download', $model->Id);
                    }
                }else{
                    if(in_array('download',$key_roles)){
                        $auth->revoke('download', $model->Id);

                    }

                }
                if(!empty($key_roles)){
                    foreach ($key_roles as $key=>$value){
                        if($value!='download'){
                            $auth->revoke($value, $model->Id);
                        }
                    }
                }

                if(in_array($model->jurisdiction,Yii::app()->params['allowaddroles'])){
                    $auth->assign($model->jurisdiction, $model->Id);
                }
                $this->redirect(array('view', 'id' => $model->Id));

            }


           /* if ($ass || $ass1) { //更新用户角色   //更新下载权限

                $ass->itemname = $model->jurisdiction;
                $ass->userid = $model->Id;
                $count = $ass->update(array('itemname', 'userid'));
                $model->Lately_pwd = date('Y-m-d H:i:s');
                if ($ass1) {
                    if ($model->is_download) {
                        $ass1->itemname = 'download';
                        $ass1->userid = $model->Id;
                        $ass1->update(array('itemname', 'userid'));
                    } else {
                        $ass1->itemname = 'download';
                        $ass1->delete();
                    }
                } else {
                    if ($model->is_download) {
                        $jurisdiction1->itemname = 'download';
                        $jurisdiction1->userid = $model->Id;
                        $jurisdiction1->save();
                    }
                }
                if ($model->save() && $count)
                    $this->redirect(array('view', 'id' => $model->Id));
            } else {
                $jurisdiction->itemname = $model->jurisdiction;
                $jurisdiction->userid = $model->Id;
                if ($model->is_download) {
                    $jurisdiction1->itemname = 'download';
                }
                $jurisdiction1->userid = $model->Id;
                $model->pwd = $model->hashPassword();
                $model->Lately_pwd = date('Y-m-d H:i:s');
                if ($model->save() && $jurisdiction->save() && $jurisdiction1->save())
                    $this->redirect(array('view', 'id' => $model->Id));
            }*/
            //print_r($jurisdiction->getErrors());
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
        $dataProvider = new CActiveDataProvider('User');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadInternModel($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        Yii::app()->user->loginRequired(); //跳转到前台页面
        // $this->redirect(array('site/login'));
        // $this->redirect(Yii::app()->homeUrl);

    }

    public function actionAddJurisdiction()
    {  //为用户添加权限
        $model = new User;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $id = User::model()->find('email="' . $model->email . '"')->Id;
            $jurisdiction = new Assignments();
            $jurisdiction->itemname = $model->jurisdiction;
            $jurisdiction->userid = $id;
            // $model->attributes=$_POST['User'];
            // $model->Frozen = 1;
            //$model->Lately_pwd = date('Y-m-d H:i:s');
            //$model->pwd = $model->hashPassword();
            if ($jurisdiction->save()) {
                echo '添加成功';
            } else {
                print_r($jurisdiction->geterrors());
            }
            //$this->redirect(array('view','id'=>$model->Id));
        }

        $this->render('addJurisdiction', array(
            'model' => $model,
        ));
    }
}