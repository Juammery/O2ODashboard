<?php

class PresentationController extends Controller
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
        if(Yii::app()->request->isPostRequest){
            $file_zip= CUploadedFile::getInstanceByName('zipIm');  //获取上传zip文件的名字
            //$dir_url = Yii::app()->params['uploadZip'];            //路径 参数定义在params.php
            $dir_url='./uploads/retail/' .trim($_POST['sj']).'/'.trim($_POST['stage']).'/';
            //$img_url = date('YmdHis') . rand(10000, 99999) . '.' . $file_zip->extensionName;
           // print_r($_POST);
            if(!empty($file_zip)&&$this->makeDir($dir_url)&&!empty($_POST['sj'])&&isset($_POST['stage'])){//处理zip    makeDir上传目录
                if(!in_array($file_zip->type, Yii::app()->params['zip_or_excel'])){    //in_array搜索是否存在指定的值
                    $this->hint('danger','文件类型错误');
                    $this->redirect(Yii::app()->request->urlReferrer);die;
                }
                if($file_zip->size > Yii::app()->params['zip_max_size']){
                    $this->hint('danger','文件过大');
                    $this->redirect(Yii::app()->request->urlReferrer);die;
                }
                $file_zip->saveAs($dir_url.$file_zip->name); //保存上传文件。
//                $zipA=new ZipArchive();  //一个压缩的文件归档文件。
//                if($zipA->open($dir_url.$file_zip->name)===TRUE){   //要打开的ZIP归档文件的文件名。
//                    $zipA->extractTo($dir_url);  //提取档案内容
//                    $zipA->close(); //关闭活动存档(打开或新创建)
//                    @unlink($dir_url.$file_zip->name);
//                    $files = glob('./uploads/cvs/'.$_POST['sj'].'/*.xlsx');
//                    if(!empty($files)) {
//                        for ($i = 0; $i < count($files); $i++) {
//                            $path = pathinfo($files[$i]);
//                            if(isset($path)&&is_numeric($path['filename'])){
//                                 $ex = Presentation::model()->find('time=:time and stage=:stage', array(':time' => $_POST['sj'], ':stage' => $path['filename']));
//                                if (file_exists($files[$i]) && empty($ex)) {
                                    $model = new Presentation();
                                    $model->time = $_POST['sj'];
//                                    $model->stage = $path['filename'];
                                    $model->stage = $_POST['stage'];
                                    $model->downloadLinks = $dir_url.$file_zip->name;
                                    $model->save();
//                                }
//                            }
//                        }
//                    }
//                        }
//                    }
                    $this->hint('success','成功导入并解压');
                    $this->redirect(Yii::app()->request->urlReferrer);die;
//                }else{
//                    $this->hint('danger','文件夹创建失败');
//                    $this->redirect(Yii::app()->request->urlReferrer);die;
//                }

            }else{
                $this->hint('danger','信息不完全');
                $this->redirect(Yii::app()->request->urlReferrer);die;
            }//处理zip

        }//ispost
        $this->render('create');
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

        if (isset($_POST['Presentation'])) {
            $model->attributes = $_POST['Presentation'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->Id));
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
        $dataProvider = new CActiveDataProvider('Presentation');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Presentation('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Presentation']))
            $model->attributes = $_GET['Presentation'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Presentation the loaded model
     * @throws CHttpException
     */
    public function loadInternModel($id)
    {
        $model = Presentation::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Presentation $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'presentation-cvs-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}