<?php

/**
 * Created by PhpStorm.
 * User: cookie
 * Date: 2017/12/20
 * Time: 15:12
 */
class ImportController extends Controller
{
    //上传sku之类的
    public function actionSku()
    {
        header('Content-Type:text/html;charset=utf8');
        set_time_limit(0);
        if (Yii::app()->request->isPostRequest) {
            $phpexcel = $this->excelimport('importfile');
            $total_line = $phpexcel->getHighestRow();
            $total_column = $phpexcel->getHighestColumn();
            $infos = array();
            for ($row = 2; $row <= $total_line; $row++) {
                $data = [];
                for ($column = 0; $column <= PHPExcel_Cell::columnIndexFromString($total_column) - 1; $column++) {
                    $data[] = $phpexcel->getCell(PHPExcel_Cell::stringFromColumnIndex($column) . $row)->getValue();
                }
                $shop = Sku::model()->find(array("condition" => 'depth = 1 and name = "' . $data[0] . '"'));//品类
                if ($shop) {
                    $shop_id = $shop->id;
                } else {
                    $new = new Sku();
                    $new->name = $data[0];
                    $new->parent = 0;
                    $new->depth = 1;
                    $new->save();
                    $shop_id = $new->id;
                }
                $brand = Sku::model()->find(array("condition" => 'depth = 2 and name = "' . $data[1] . '" and parent = ' . $shop_id));//制造商
                if ($brand) {
                    $brand_id = $brand->id;
                } else {
                    $new = new Sku();
                    $new->name = $data[1];
                    $new->parent = $shop_id;
                    $new->depth = 2;
                    $new->save();
                    $brand_id = $new->id;
                }
                $series = Sku::model()->find(array("condition" => 'depth = 3 and name = "' . $data[2] . '" and parent = ' . $brand_id));//品牌
                if ($series) {
                    $series_id = $series->id;
                } else {
                    $new = new Sku();
                    $new->name = $data[2];
                    $new->parent = $brand_id;
                    $new->depth = 3;
                    $new->save();
                    $series_id = $new->id;
                }
                $depth = Sku::model()->find(array("condition" => 'depth = 4 and name = "' . $data[3] . '" and parent = ' . $series_id));//系列
                if ($depth) {
                    $depth_id = $depth->id;
                } else {
                    $new = new Sku();
                    $new->name = $data[3];
                    $new->parent = $series_id;
                    $new->depth = 4;
                    $new->save();
                    $depth_id = $new->id;
                }
//                $bottle = ['单瓶装', '多瓶装', '箱装'];
//                foreach ($bottle as $v) {
//                    $new = new Sku();
//                    $new->name = $v;
//                    $new->parent = $depth_id;
//                    $new->depth = 6;
//                    $new->save();
//                }
            }
        }
        $this->render("info");
    }

    //区域
//    public function actionInfo()
//    {
//        header('Content-Type:text/html;charset=utf8');
//        set_time_limit(0);
//        if (Yii::app()->request->isPostRequest) {
//            $phpexcel = $this->excelimport('info');
//            $total_line = $phpexcel->getHighestRow();
//            $total_column = $phpexcel->getHighestColumn();
//            $infos = array();
//            for ($row = 2; $row <= $total_line; $row++) {
//                $data = [];
//                for ($column = 0; $column <= PHPExcel_Cell::columnIndexFromString($total_column) - 1; $column++) {
//                    $data[] = $this->trimall($phpexcel->getCell(PHPExcel_Cell::stringFromColumnIndex($column) . $row)->getValue());
//                }
//                $model = Relation::model()->find(array("condition" => 'depth = 1 and name = "' . $data[0] . '"'));//集团
//                if ($model) {
//                    $group_id = $model->id;
//                } else {
//                    $new = new Relation();
//                    $new->name = $data[0];
//                    $new->parent = 1;
//                    $new->depth = 1;
//                    $new->save();
//                    $group_id = $new->id;
//                }
//                $shop = Relation::model()->find(array("condition" => 'depth = 2 and name = "' . $data[1] . '" and parent = ' . $group_id));//装瓶厂
//                if ($shop) {
//                    $shop_id = $shop->id;
//                } else {
//                    $new = new Relation();
//                    $new->name = $data[1];
//                    $new->parent = $group_id;
//                    $new->depth = 2;
//                    $new->save();
//                    $shop_id = $new->id;
//                }
//                $brand = Relation::model()->find(array("condition" => 'depth = 3 and name = "' . $data[2] . '" and parent = ' . $shop_id));//城市等级
//                if ($brand) {
//                    $brand_id = $brand->id;
//                } else {
//                    $new = new Relation();
//                    $new->name = $data[2];
//                    $new->parent = $shop_id;
//                    $new->depth = 3;
//                    $new->save();
//                    $brand_id = $new->id;
//                }
//                $series = Relation::model()->find(array("condition" => 'depth = 4 and name = "' . $data[3] . '" and parent = ' . $brand_id));//城市
//                if ($series) {
//                    $series_id = $series->id;
//                } else {
//                    $new = new Relation();
//                    $new->name = $data[3];
//                    $new->parent = $brand_id;
//                    $new->depth = 4;
//                    $new->save();
//                    $series_id = $new->id;
//                }
//            }
//        }
//        $this->render("info");
//    }

    //排名
    public function actionRank()
    {
        $t1 = microtime(true);
        header('Content-Type:text/html;charset=utf8');
        set_time_limit(0);
        if (Yii::app()->request->isPostRequest) {
            $phpexcel = $this->excelimport('importfile');
            $total_line = $phpexcel->getHighestRow();
            $total_column = $phpexcel->getHighestColumn();
            $infos = array();
            $sku_classify = array_flip(Yii::app()->params['sku_classify']);
            for ($row = 2; $row <= $total_line; $row++) {
                $data = [];
                $relation_id = 1;
                $remark = "";
                $status = 1;
                for ($column = 0; $column <= PHPExcel_Cell::columnIndexFromString($total_column) - 1; $column++) {
                    $data[] = $this->trimall($phpexcel->getCell(PHPExcel_Cell::stringFromColumnIndex($column) . $row)->getValue());
                }
                if ($data[2] != "" && $data[3] == "" && $data[4] == "") {//装瓶集团
                    $model = Relation::model()->find(array('condition' => '(depth = 0 or depth = 1) and name = "' . $data[2] . '"'));
                    $relation_id = isset($model) ? $model->id : 0;
                    if (!$relation_id) {
                        $status = 0;
                        $remark .= "第" . $row . "行装瓶集团在数据库中不存在!";
                    }
                } elseif ($data[2] != "" && $data[3] != "" && $data[4] == "") {//装瓶厂
                    $model = Relation::model()->find(array('condition' => 'depth = 2 and name = "' . $data[3] . '"'));
                    $relation_id = isset($model) ? $model->id : 0;
                    if (!$relation_id) {
                        $status = 0;
                        $remark .= "第" . $row . "行装瓶厂在数据库中不存在!";
                    }
                } elseif ($data[2] != "" && $data[3] != "" && $data[4] != "") {//城市
                    $model = Relation::model()->find(array('condition' => 'depth = 3 and name = "' . $data[4] . '"'));
                    $relation_id = isset($model) ? $model->id : 0;
                    if (!$relation_id) {
                        $status = 0;
                        $remark .= "第" . $row . "行城市在数据库中不存在!";
                    }
                } else {
                    $status = 0;
                    $remark .= "区域不存在，请查看导入模板是否正确!";
                }

                $cityModel = Citylevel::model()->find(array('condition' => 'name = "' . $data[5] . '"'));
                $cityLevel = isset($cityModel) ? $cityModel->id : 0;
                if (!$cityLevel) {
                    $status = 0;
                    $remark .= "第" . $row . "行城市等级在数据库中不存在!";
                }

                $system = System::model()->find(array('condition' => '(depth = 0 or depth = 1) and name = "' . $data[6] . '"'));
                $system_id = isset($system) ? $system->id : 0;
                if (!$system_id) {
                    $status = 0;
                    $remark .= "第" . $row . "行渠道在数据库中不存在!";
                }

                $platform_id = 1;

                $category = Category::model()->find(array('condition' => 'name = "' . $data[8] . '"'));
                $category_id = isset($category) ? $category->id : 0;
                if (!$category_id) {
                    $status = 0;
                    $remark .= "第" . $row . "行品类在数据库中不存在!";
                }
                $infos[] = array(
                    $data[0], $data[1], $relation_id, $cityLevel, $system_id, $platform_id, $category_id,
                    $data[9], $data[10], $data[11], $data[12], $data[13],$data[14], $status, $remark
                );
                unset($model, $system, $platform, $category);
            }
            $arr = array_chunk($infos, 2000);
            unset($infos);
            $label = array('time', 'stage', 'relation_id', 'cityLevel_id', 'system_id', 'platform_id', 'sku_id', 'classify',
                'ranking','sku_name','bottle','sales_amount','last_sales_amount','status', 'remark');
            $log = [];
            $aCount = count($arr);
            for ($i = 0; $i < $aCount; $i++) {
                sleep(2);
                $log[] = $this->batchInsert('cola_rank', $label, $arr[$i]);
            }
            unset($arr);
            $sum = 0;
            $count = count($log);
            for ($i = 0; $i < $count; $i++) {
                $sum = $sum + $log[$i];//通过for循环，去除数组中的元素，累加到sum中
            }
            $t2 = microtime(true);
            $t3 = round($t2 - $t1, 3);
            Yii::log("你共插入了" . print_r($sum, true) . "条数据,耗时" . $t3 . '秒！', "warning");
            $this->hint("danger", "你共插入了" . print_r($sum, true) . "条数据,耗时" . $t3 . '秒！');
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    public function actionInfo()
    {
        $t1 = microtime(true);
        header('Content-Type:text/html;charset=utf8');
        set_time_limit(0);
        if (Yii::app()->request->isPostRequest) {
            $phpexcel = $this->excelimport('importfileInfo');
            $total_line = $phpexcel->getHighestRow();
            $total_column = $phpexcel->getHighestColumn();
            $infos = $errorData = array();
            $status = 1;
            for ($row = 2; $row <= $total_line; $row++) {
                $data = [];
                $remark = "";
                $relation_id = 1;
                $capacity_id = 1;
                $bottle_id = 8;
                for ($column = 0; $column <= PHPExcel_Cell::columnIndexFromString($total_column) - 1; $column++) {
                    $data[] = $phpexcel->getCell(PHPExcel_Cell::stringFromColumnIndex($column) . $row)->getValue();
                }
                if (is_integer($data[0])) {//时间格式不正确
                    $status = 0;
                    $remark .= "第" . $row . "行时间格式不正确!";
                } else {
                    $a = strtr($data[0], '-', '_');
                    $time = "cola_info_" . $a . "_" . $data[1];
                }
                $tableName = strtr($time, '-', '_');
                if ($data[2] != "" && $data[3] == "" && $data[4] == "") {//装瓶集团
                    $model = Relation::model()->find(array('condition' => 'depth = 1 and name = "' . $data[2] . '"'));//装瓶集团
                    $relation_id = isset($model) ? $model->id : 0;
                    if (!$relation_id) {
                        $status = 0;
                        $remark .= "第" . $row . "行装瓶集团在数据库中不存在!";
                    }
                } elseif ($data[2] == "" && $data[3] != "" && $data[4] == "") {//装瓶厂
                    $model = Relation::model()->find(array('condition' => 'depth = 2 and name = "' . $data[3] . '"'));//装瓶厂
                    $relation_id = isset($model) ? $model->id : 0;
                    if (!$relation_id) {
                        $status = 0;
                        $remark .= "第" . $row . "行装瓶厂&&城市等级在数据库中不存在!";
                    }
                } elseif ($data[2] == "" && $data[3] == "" && $data[4] != "") {//城市
                    $model = Relation::model()->find(array('condition' => 'depth = 3 and name = "' . $data[4] . '"'));//城市
                    $relation_id = isset($model) ? $model->id : 0;
                    if (!$relation_id) {
                        $status = 0;
                        $remark .= "第" . $row . "行城市&&城市等级在数据库中不存在!";
                    }
                } else {
                    $status = 0;
                    $remark .= "区域不存在，请查看导入模板是否正确!";
                }

                $cityLevel = Citylevel::model()->find(array('condition' => 'name = "' . $data[5] . '"'));
                $cityLevelid = isset($cityLevel) ? $cityLevel->id : 0;
                if (!$cityLevelid) {
                    $status = 0;
                    $remark .= "第" . $row . "行城市等级在数据库中不存在!";
                }

                $system = System::model()->find(array('condition' => '(depth = 0 or depth = 1) and name = "' . $data[6] . '"'));
                $system_id = isset($system) ? $system->id : 0;
                if (!$system_id) {
                    $status = 0;
                    $remark .= "第" . $row . "行渠道在数据库中不存在!";
                }

                $platform = Platform::model()->find(array('condition' => 'name = "' . $data[7] . '"'));
                $platform_id = isset($platform) ? $platform->id : 0;
                if (!$platform_id) {
                    $status = 0;
                    $remark .= "第" . $row . "行平台在数据库中不存在!";
                }

                $model = Category::model()->find(array('condition' => 'name = "' . $data[8] . '"'));//品类
                $category_id = isset($model) ? $model->id : 0;
                if (!$category_id) {
                    $status = 0;
                    $remark .= "第" . $row . "行品类在数据库中不存在!";
                }

                $model = Menu::model()->find(array('condition' => 'name = "' . $data[9] . '"'));//制造商
                $menu_id = isset($model) ? $model->id : 0;
                if (!$menu_id) {
                    $status = 0;
                    $remark .= "第" . $row . "行制造商在数据库中不存在!";
                }

                $model = Brand::model()->find(array('condition' => 'name = "' . $data[10] . '"'));//品牌
                $brand_id = isset($model) ? $model->id : 0;
                if (!$brand_id) {
                    $status = 0;
                    $remark .= "第" . $row . "行品牌在数据库中不存在!";
                }

                if ($data[11] != "") {//容量分级
                    $capacity = TotalClassify::model()->find(array('condition' => 'classify = 1 and name = "' . $data[11] . '"'));//容量
                    $capacity_id = isset($capacity) ? $capacity->id : 0;
                    if (!$capacity_id) {
                        $status = 0;
                        $remark .= "第" . $row . "行容量分级在数据库中不存在!";
                    }
                }
                if ($data[12] != "") {//瓶量分级
                    $bottle = TotalClassify::model()->find(array('condition' => 'classify = 2 and name = "' . $data[12] . '"'));//瓶量
                    $bottle_id = isset($bottle) ? $bottle->id : 0;
                    if (!$bottle_id) {
                        $status = 0;
                        $remark .= "第" . $row . "行瓶量分级在数据库中不存在!";
                    }
                }
                if ($status) {
                    $infos[] = array(
                        $relation_id, $cityLevelid, $system_id, $platform_id, $category_id, $menu_id, $brand_id, $capacity_id, $bottle_id, $data[13], $data[14], $data[15],
                        $data[16], $data[17], $data[18], $data[19], $data[20], $data[21], $data[22], $data[23], $data[24], $data[25], $data[26], $data[27], $data[28],
                        $data[29], $data[30], $data[31], $data[32], $data[33], $data[34], $data[35], $data[36], $data[37], $data[38], $data[39],
                        $data[40], $data[41], $data[42], $data[43], $data[44], $data[45], $data[46]
                    );
                } else {
                    $errorData[] = $remark;
                }
                unset($model, $system, $platform, $category);
            }
            $arr = array_chunk($infos, 1000);
            unset($infos);
            $label = array(
                'relation_id', 'cityLevel_id', 'system_id', 'platform_id', 'category_id', 'menu_id', 'brand_id', 'capacity_id', 'bottle_id', 'distribution', 'last_distribution',
                'sales_numbers', 'last_sales_numbers', 'sales_quota', 'last_sales_quota', 'saleroom', 'last_saleroom', 'sales_share',
                'last_sales_share', 'enrollment', 'last_enrollment', 'store_money', 'last_store_money', 'store_number', 'last_store_number',
                'sku_number', 'last_sku_number', 'distribution_store', 'last_distribution_store', 'average_selling_price', 'last_average_selling_price',
                'average_purchase_price', 'last_average_purchase_price', 'price_promotion_ratio', 'last_price_promotion_ratio', 'average_discount_factor',
                'last_average_discount_factor', 'average_number_per_unit', 'last_average_number_per_unit', 'average_amount_per_order', 'last_average_amount_per_order',
                'online_stores', 'last_online_stores'
            );
            $log = [];
            $aCount = count($arr);
            for ($i = 0; $i < $aCount; $i++) {
                $log[] = $this->batchInsert("cola_info_2018_11_0", $label, $arr[$i]);
            }
            $sum = 0;
            $count = count($log);
            for ($i = 0; $i < $count; $i++) {
                $sum = $sum + $log[$i];//通过for循环，去除数组中的元素，累加到sum中
            }
            $t2 = microtime(true);
            $t3 = round($t2 - $t1, 3);
            Yii::log("info错误数据" . print_r($errorData, true), "warning");
            Yii::log("你共插入了" . print_r($sum, true) . "条数据,耗时" . $t3 . '秒！', "warning");
            $this->hint("danger", "你共插入了" . print_r($sum, true) . "条数据,耗时" . $t3 . '秒！');
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    public function excelimport($name)
    {
        $file_excel = CUploadedFile::getInstanceByName($name);
        if (!empty($file_excel)) {
            $type = $file_excel->type;
            $excelFile = $file_excel->getTempName();
            Yii::$enableIncludePath = false;
            Yii::import('application.extensions.PHPExcel.PHPExcel', 1);
            if ($type == 'application/vnd.ms-excel') {
                $excelReader = PHPExcel_IOFactory::createReader('Excel5');
            } elseif ($type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                $excelReader = PHPExcel_IOFactory::createReader('Excel2007');
            } else {
                die('检查上传类型');
                $this->hint('danger', '检查上传类型');
                $this->redirect(Yii::app()->request->urlReferrer);
                die;
            }
            $phpexcel = $excelReader->load($excelFile)->getSheet(0);
            return $phpexcel;
        } else {
            die('上传错误');
        }
    }

}