<?php
/**
 * Created by PhpStorm.
 * User: RickLwy
 * Date: 2017/5/8
 * Time: 18:38
 */
Yii::import('zii.widgets.jui.CJuiSortable');

class DmJuiSortable extends CJuiSortable{
    public $liclass='';
    public $itemTemplate='<li id="{id}">{content}</li>';
    public $itemTemplateClass='<li id="{id}" class="{class}">{content}</li>';
    public function run()
    {
        $id=$this->getId();
        if(isset($this->htmlOptions['id']))
            $id=$this->htmlOptions['id'];
        else
            $this->htmlOptions['id']=$id;

        $options=CJavaScript::encode($this->options);
        Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id,"jQuery('#{$id}').sortable({$options});");

        echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
        foreach($this->items as $id=>$content){
            if(empty($this->liclass)){
                echo strtr($this->itemTemplate,array('{id}'=>$id,'{content}'=>$content))."\n";
            }else{
                echo strtr($this->itemTemplateClass,array('{id}'=>$id,'{content}'=>$content,'{class}'=>$this->liclass))."\n";
            }

        }

        echo CHtml::closeTag($this->tagName);
    }
}