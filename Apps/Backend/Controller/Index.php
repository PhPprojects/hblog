<?php

namespace Apps\Backend\Controller;

/**
 * 后台主页
 * @authName 后台主页
 * @authDescription 后台主页 登录 退出
 */
class Index extends \H1Soft\H\Web\Controller {

    function indexAction() {  
        $this->isAdmin();
        //php info
        $this->assign('PHP_VERSION', PHP_VERSION);
        $this->assign('UPLOAD_MAX_FILESIZE', ini_get('upload_max_filesize'));
        
        //version
        $this->assign('HVERSION', HVERSION);
        
        //check db        
        $this->assign('MYSQLI', function_exists('mysqli_connect'));
        
        //gd info
        $this->assign('GD_INFO', gd_info());        
        $this->assign('GD_IMGTYPE', $this->getSupportedImageTypes());
        
        $this->assign('HBLOG',HBLOG);
        
        $auth = \H1Soft\H\Web\Auth::getInstance();
        $this->assign('system_nickname',$auth->getName());
        
        $this->render('admin/index');
    }

    /**
     * @skipAuth
     */
    function logoutAction() {
        \H1Soft\H\Web\Auth::getInstance()->logout();
        $this->redirect('index/login');
    }
    
    /**
     * @skipAuth
     */
    function loginAction() {
        $auth = \H1Soft\H\Web\Auth::getInstance();
        $this->assign('HBLOG',HBLOG);
        if ($this->isPost()) {
            $username = $this->post('username');
            $password = $this->post('password');

            if ($auth->login($username, $password)) {
//                $this->setFlashMessage("登录成功");
                $this->assign('lflag', 0);

                $this->redirect('index/index');
            } else {
//                $this->setFlashMessage("登录失败");
                $this->assign('lflag', 1);
            }
        }
        $this->render('admin/login');
    }

    private function getSupportedImageTypes() {
        $aSupportedTypes = array();

        $aPossibleImageTypeBits = array(
            IMG_GIF => 'GIF',
            IMG_JPG => 'JPG',
            IMG_PNG => 'PNG',
            IMG_WBMP => 'WBMP'
        );

        foreach ($aPossibleImageTypeBits as $iImageTypeBits => $sImageTypeString) {
            if (imagetypes() & $iImageTypeBits) {
                $aSupportedTypes[] = $sImageTypeString;
            }
        }

        return $aSupportedTypes;
    }

}
