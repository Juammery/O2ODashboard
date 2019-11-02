<?php
/**
 * Created by PhpStorm.
 * User: lwy
 * Date: 2016/12/30
 * Time: 13:25
 */
Yii::import('bootstrap.widgets.BsButtonColumn');

class DiyButtonColumn extends BsButtonColumn
{
    /**
     * @var string the view button icon (defaults to BSHtml::GLYPHICON_EYE_OPEN).
     */
    public $viewButtonIcon = BSHtml::GLYPHICON_EYE_OPEN;
    /**
     * @var string the update button icon (defaults to BSHtml::GLYPHICON_PENCIL).
     */
    public $updateButtonIcon = BSHtml::GLYPHICON_PENCIL;
    /**
     * @var string the delete button icon (defaults to BSHtml::GLYPHICON_TRASH).
     */
    public $deleteButtonIcon = BSHtml::GLYPHICON_TRASH;

    public $viewButtonOptions=array('class'=>'btn btn-xs btn-success');
    public $updateButtonOptions=array('class'=>'btn btn-xs btn-info');
    public $deleteButtonOptions=array('class'=>'btn btn-xs btn-danger');

    public $template='{view}{update}{delete}';

}