<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Apps\Common;

/**
 * Description of AdminController
 *
 * @author h1soft
 */
class Controller extends \H1Soft\H\Web\Controller {
    public function init(){
        parent::init();
        $system = Setting::getInstance()->group('system');
        $this->assign('system',$system);
        \H1Soft\H\Web\Config::set('view.theme', $system['theme']);
    }
}
