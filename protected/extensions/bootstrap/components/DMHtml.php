<?php
/**
 * Created by PhpStorm.
 * User: RickLwy
 * Date: 2017/5/3
 * Time: 10:13
 */
class DMHtml extends BSHtml{

    public static function chosenselect($name,$select,$data,$htmlOptions=array())
    {
        $htmlOptions['multiple']=true;
        $htmlOptions['class']='chosen-select';
        self::addCssClass('form-control', $htmlOptions);
        return parent::dropDownList($name, $select, $data, $htmlOptions);

    }
    public static function chosenselectControlGroup($name, $select = '', $data = array(), $htmlOptions = array()) {
        $htmlOptions['multiple']=true;
        $htmlOptions['class']='chosen-select';
        return self::controlGroup(self::INPUT_TYPE_DROPDOWNLIST, $name, $select, $htmlOptions, $data);
    }
    public static function activeChosenselect($model, $attribute, $data, $htmlOptions = array()) {
        $htmlOptions['multiple']=true;
        $htmlOptions['class']='chosen-select';
        return parent::activeDropDownList($model, $attribute, $data, $htmlOptions);
    }
   /* public static function activeChosenselectControlGroup($model, $attribute, $data = array(), $htmlOptions = array()) {
        $htmlOptions['multiple']=true;
        $htmlOptions['class']='chosen-select';
        self::addCssClass('form-control', $htmlOptions);
        return self::activeControlGroup(self::INPUT_TYPE_DROPDOWNLIST, $model, $attribute, $htmlOptions, $data);
    }*/
    public static function deptselect($name,$select,$data,$htmlOptions=array())
    {
        $htmlOptions['class']='dept-select';
        self::addCssClass('form-control', $htmlOptions);
        return parent::dropDownList($name, $select, $data, $htmlOptions);

    }
    public static function deptselectControlGroup($name, $select = '', $data = array(), $htmlOptions = array()) {
        $htmlOptions['class']='dept-select';
        return self::controlGroup(self::INPUT_TYPE_DROPDOWNLIST, $name, $select, $htmlOptions, $data);
    }
    public static function activeDeptselect($model, $attribute, $data, $htmlOptions = array()) {
        $htmlOptions['class']='dept-select';
        return parent::activeDropDownList($model, $attribute, $data, $htmlOptions);
    }
   /* public static function activeDeptselectControlGroup($model, $attribute, $data = array(), $htmlOptions = array()) {
        $htmlOptions['class']='dept-select';
        self::addCssClass('form-control', $htmlOptions);
        return self::activeControlGroup(self::INPUT_TYPE_DROPDOWNLIST, $model, $attribute, $htmlOptions, $data);
    }*/
}