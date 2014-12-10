<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Apps\Backend\Controller;

/**
 * Description of AdminController
 *
 * @author Administrator
 */
class AdminController extends \hmvc\Web\Controller {
    public function init(){
        parent::init();
        $this->isAdmin();
        \hmvc\Web\Config::set('view.theme','default');
        $auth = \hmvc\Web\Auth::getInstance();
        $this->assign('system_nickname',$auth->getName());
        $this->assign('HBLOG',HBLOG);
    }
}
