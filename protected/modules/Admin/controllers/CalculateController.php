<?php
/**
 * Created by PhpStorm.
 * User: Vikki1019
 * Date: 2019/8/1
 * Time: 15:17
 */

class CalculateController extends Controller
{
    public function actionIndex(){
        set_time_limit(0);
        ini_set('memory_limit','-1');
        if(Yii::app()->request->isPostRequest){

            pd($_POST);
            $this->hint('success','计算完成，你可以在前台界面浏览数据了');
        }
        $this->render('index');
    }

    //创建info表
    public function createInfoTable($info_table_name){
        $sql = "
        create table $info_table_name(
        id int AUTO_INCREMENT,
        time varchar(50),
        relation_id int default 0 not null,
        cityLevel_id int default 0 not null,
        system_id int default 0 not null,
        platform_id int default 0 not null,
        category_id int default 0 not null,
        menu_id int default 0 not null,
        brand_id int default 0 not null,
        capacity_id int default 0 not null,
        bottle_id int default 0 not null,
        distribution double,
        last_distribution double,
        sales_numbers double,
        last_sales_numbers double,
        sales_quota double,
        last_sales_quota double,
        saleroom double,
        last_saleroom double,
        sales_share double,
        last_sales_share double,
        enrollment double,
        last_enrollment double,
        store_money double,
        last_store_money double,
        store_number double,
        last_store_number double,
        sku_number double,
        last_sku_number double,
        distribution_store double,
        last_distribution_store double,
        average_selling_price double,
        last_average_selling_price double,
        average_purchase_price double,
        last_average_purchase_price double,
        price_promotion_ratio double,
        last_price_promotion_ratio double,
        average_discount_factor double,
        last_average_discount_factor double,
        average_number_per_unit double,
        last_average_number_per_unit double,
        average_amount_per_order double,
        last_average_amount_per_order double,
        online_stores double,
        last_online_stores double,
        PRIMARY KEY (id)
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;
        create index total on $info_table_name(relation_id,cityLevel_id,system_id,platform_id,category_id,menu_id,brand_id,capacity_id,bottle_id);
        ";
        Yii::app()->db->createCommand($sql)->execute();
    }

    //创建rank表
    public function createRankTable($rank_table_name){
        $sql = "
        create table $rank_table_name(
        id int AUTO_INCREMENT,
        time varchar(30) not null,
        stage int not null,
        relation_id int not null,
        cityLevel_id int not null,
        system_id int not null,
        platform_id int not null,
        sku_id int not null,
        classify int not null,
        ranking int,
        sku_name varchar(100),
        bottle varchar(50),
        sales_amount decimal(10),
        last_sales_amount double,
        status int default 0,
        remark varchar(255),
        PRIMARY KEY (id)
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;
        create index total on $rank_table_name(time,stage,relation_id,cityLevel_id,system_id,platform_id,sku_id,status);
        ";
        Yii::app()->db->createCommand($sql)->execute();
    }

}