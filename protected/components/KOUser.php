<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KOUser
 *
 * @author jacka
 */
class KOUser  extends CWebUser {
    //put your code here
    //private  $_roles=array();
    
    public function  getRoles(){
        if(empty($this->getState('_roles')))
            return array();
        
        return $this->getState('_roles');
    }
    
    public function setRoles($value){
        //$this->_roles = $value;
        $this->setState('_roles', $value);
       // yii::log(print_r($this->_roles,true),'warning');
    }
    
    public function setUserinfo($value){
        $this->setState('_userinfo', $value);
    }
    
    public function getUserinfo(){
        return $this->getState('_userinfo');
    }    
}
