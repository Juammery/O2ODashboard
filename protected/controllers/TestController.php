<?php

/**
 * Created by PhpStorm.
 * User: rick
 * Date: 2018/1/4
 * Time: 11:28
 */
class  TestController extends Controller
{

    public function unicode_encode($input)
    {
        //header('Content-Type:text/html; Charset=utf-8;');
        $output = preg_replace_callback("/(&#[0-9]+;)/", function ($m) {
            return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES");
        }, $input);
        /* Plain UTF-8. */
        return $output;
    }

    function excelData($datas, $titlename, $filename)
    {
        $table = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>\r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body>";
        $table .= "<table style='width: 100%;border: 1px solid #aa2a59'><head>" . $titlename . "</head>";
        $body = '';
        //var_dump($datas);exit;
        foreach ($datas as $key => $rt) {
            $strAttr = '';
            $strAttr = "<tr><td style='height: 80px;line-height: 80px;border: 1px solid #aa2a59'>$rt->id</td><td style='height: 80px;line-height: 80px;border: 1px solid #aa2a59'>$rt->name</td></tr>\n";
            $body .= $strAttr;
        }
        $table .= $body;
        $table .= "</table></body></html>";
        echo $table;
        header("Content-Type: application/vnd.ms-excel; name='excel'");
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $filename);
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        header("Expires: 0");
        ob_end_flush();
//        flush();
        exit();
    }

    public function actionTest()
    {
        ob_start();
        $data = Test::model()->findAll();
        //var_dump($data);exit;
        $title = "条形码";
        $titlename = "<tr>
                <th style='width:300px;height: 80px;line-height: 80px;'>ID</th>
                <th style='width:300px;height: 80px;line-height: 80px;'>图片</th>
            </tr>";
        $filename = $title . ".xls";
        $this->excelData($data, $titlename, $filename);
        echo 'success';
        $this->render('test');
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

    public function getExcel($fileName, $headArr, $data)
    {

        /* $this->load->library('PHPExcel');
         $this->load->library('PHPExcel/IOFactory');*/
        Yii::$enableIncludePath = false;
        Yii::import('application.extensions.PHPExcel.PHPExcel', 1);
//        Yii::import('application.extensions.PHPExcel.PHPExcel.IOFactory') ;

        if (empty($data) || !is_array($data)) {
            die("data must be a array");
        }
        if (empty($fileName)) {
            exit;
        }
        $fileName .= ".xls";

        //创建新的PHPExcel对象
        $objPHPExcel = new PHPExcel();
        //$objProps = $objPHPExcel->getProperties();

        //设置表头
        $key = ord("A");
        $key1 = ord("A");
        if (!empty($headArr)) {
            foreach ($headArr as $v) {
                if ($key >= 91) {
                    $colum1 = chr($key1);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $colum1 . '1', $v);
                    $key += 1;
                    $key1 += 1;
                } else {
                    $colum = chr($key);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
                    $key += 1;
                }
            }
        }


        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();
        foreach ($data as $key => $rows) { //行写入
            $span = ord("A");
            $span1 = ord("A");
            foreach ($rows as $keyName => $value) {// 列写入
                if ($span >= 91) {
                    $colum1 = chr($span1);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $colum1 . $column, $value);
                    $span += 1;
                    $span1 += 1;
                } else {
                    $j = chr($span);
                    $objActSheet->setCellValue($j . $column, $value);
                    $span++;
                }
            }
            $column++;
        }
        $fileName = iconv("utf-8", "utf-8", $fileName);
        //重命名表
        $objPHPExcel->getActiveSheet()->setTitle('Simple');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        //表格居中
        $objPHPExcel->getActiveSheet()->getStyle('A1:AD1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(70);
        // 设置行高
//        $objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(20);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');
        //$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter = new PHPExcel_Writer_HTML($objPHPExcel);
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
    }
}