<?php

namespace Apps\Backend\Controller;

/**
 * 账户管理
 */
class Setting extends \Apps\Backend\Controller\AdminController {

    public function changeAction() {
        $this->isAdmin();
        $this->assign('menu_setting', 1);
//        \H1Soft\H\Web\Config::set('view.theme','hello');
//        echo \H1Soft\H\Web\Config::get('view.theme');
      
        if ($this->isPost()) {
            \Apps\Common\Setting::getInstance()->save('system', $this->post('system'));
            \Apps\Common\Setting::getInstance()->save('mail', $this->post('mail'));
            $this->showFlashMessage("修改成功", H_SUCCESS);
        }
        //System
        #$this->assign('themes', $this->listDir(\H1Soft\H\Web\Application::$rootPath . 'themes/'));
        $this->assign('system', \Apps\Common\Setting::getInstance()->group('system'));

        $this->assign('mail', \Apps\Common\Setting::getInstance()->group('mail'));        
        #$this->assign('currencies', \Module\Model\Currency::model()->getCurrencies());        


        $this->render('admin/setting');
    }

}
