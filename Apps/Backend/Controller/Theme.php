<?php

namespace Apps\Backend\Controller;

/**
 * 账户管理
 */
class Theme extends \Apps\Backend\Controller\AdminController {

    public function listAction() {
        $this->isAdmin();
        $this->assign('menu_theme', 1);
        $this->saveUrlRef();

      
        //搜索所有主题
        $themes = array();

        $it = new \RecursiveDirectoryIterator(\hmvc\Web\Application::themesPath());
        foreach ($it as $path) {

            if ($path->isDir()) {
                $skin = array();
                $skin['theme_name'] = $path->getFilename();
                $skin['theme_screenshot'] = \hmvc\Web\Application::basePath() .'/themes/'.$path->getFilename().'/screenshot.jpg';
                $themes[]  = $skin;
            }

        }
        $system = \Apps\Common\Setting::getInstance()->group('system');
        $current_theme = $system['theme'];

        $this->render('admin/theme/list',array('themes'=>$themes,'current_theme'=>$current_theme));
    }

    public function changeAction(){
        $this->isAdmin();
        $this->assign('menu_theme', 1);
        if ($this->isGet()) {
           $default = $this->get('default');
           //目录存在
           if(is_dir(\hmvc\Web\Application::themesPath().$default)){
                $system['theme'] = $default;                
                \Apps\Common\Setting::getInstance()->save('system', $system);
           }else{

                $this->showFlashMessage("主题不存在",H_ERROR,$this->urlRef());
           }           
            
        }
         
        $this->showFlashMessage("主题已启用",H_SUCCESS,$this->urlRef());
    }

    //布局管理
    public function layoutsAction() {
        $this->isAdmin();
        $this->assign('menu_theme', 1);
        $this->saveUrlRef();


        $system = \Apps\Common\Setting::getInstance()->group('system');
        $current_theme = $system['theme'];

        $this->assign('current_theme',$current_theme);

        
      
        $total_rows = $this->db()
                ->where('theme', $current_theme)
                ->count('layouts');
        $page = new \Apps\Blog\Model\Pagination($total_rows, $this->get('page', 1), 2);
        $page->setUrl('theme/layouts');
        $layouts = $this->db()->order_by('modify_time', 'DESC')
                ->limit( $page->getPageSize(),$page->getOffset())  
                ->where('theme', $current_theme)              
                ->get('layouts');
        
        $this->assign('page', $page);      
        $this->assign('list', $layouts);

        
        



        $this->render('admin/theme/layouts');
    }


    //布局添加
    public function addLayoutAction() {
        $this->isAdmin();
        $this->assign('menu_theme', 1);
        
        $system = \Apps\Common\Setting::getInstance()->group('system');
        $current_theme = $system['theme'];
        $this->assign('current_theme',$current_theme);

        if($this->isPost()) {
            $title = $this->post('title');
            $description = $this->post('description');
            $content = $this->post('content');
            $filename = $this->post('filename');
            
            $themeDir = \hmvc\Web\Application::themesPath().$current_theme.'/customize/';
            if(!is_dir($themeDir)){
                mkdir($themeDir);
                chmod($themeDir, 0775);
            }
            
            if(is_writeable($themeDir)){
                file_put_contents($themeDir.$filename.'.html', $content);
                //保存数据库
                $this->db()->insert('layouts', array(                    
                    'title' => $title,
                    'description' => $description,
                    'filename' => $filename,
                    'theme' => $current_theme,
                    'modify_time' => time()                    
                ));
                $this->showFlashMessage("保存成功,模版名称:{$filename}.html",H_SUCCESS,$this->urlRef());
            }else{
                $this->showFlashMessage("没有权限写入: $themeDir",H_ERROR);                
            }

        }
        $options = array('syntax'=>'html');
        $this->assign('editor',\Apps\Common\EditArea::create('content',$options));
        $this->render('admin/theme/add_layout');
    }


    //布局修改
    public function modifyLayoutAction() {
        $this->isAdmin();
        $this->assign('menu_theme', 1);

        $p_id = $this->get('p',0);

        if($p_id){
            $layout = $this->db()->getOne('layouts', "`id`=$p_id");         
            $this->assign('item',$layout);
        }else{
            $this->showFlashMessage("布局不存在，请重试!",H_SUCCESS,$this->urlRef());
        }

        #获取当前皮肤
        $system = \Apps\Common\Setting::getInstance()->group('system');
        $current_theme = $system['theme'];
        $this->assign('current_theme',$current_theme);


        $themeDir = \hmvc\Web\Application::themesPath().$current_theme.'/customize/';

        if(!is_dir($themeDir)){
            mkdir($themeDir);
            chmod($themeDir, 0775);
        }
            

        if($this->isPost()) {
            $id = $this->get('p');
            $title = $this->post('title');
            $description = $this->post('description');
            $content = $this->post('content');
            $filename = $this->post('filename');
            
            $layoutFileName = $themeDir.$filename.'.html';
            
            
            if(is_writeable($themeDir)){

                if( $layout['filename'] != $filename){
                 //删除之前的
                    @unlink($themeDir.$layout['filename'].'.html');
                }

                file_put_contents($layoutFileName, $content);
                //保存数据库
                $this->db()->update('layouts', array(                    
                    'title' => $title,
                    'description' => $description,
                    'filename' => $filename,
                    'modify_time' => time()                    
                ), "`id`=$id");
                
                $this->showFlashMessage("保存成功,模版名称:{$filename}.html",H_SUCCESS,$this->urlRef());
            }else{
                $this->showFlashMessage("没有权限写入: $themeDir",H_ERROR);                
            }

        }

        $filename = $layout['filename'];
        $content = file_get_contents($themeDir.$filename.'.html');

        $this->assign('content',$content);

        $options = array('syntax'=>'html');
        $this->assign('editor',\Apps\Common\EditArea::create('content',$options));

        $this->render('admin/theme/add_layout');
    }

    public function removelayoutAction(){
        $this->isAdmin();
        $this->assign('menu_theme', 1);
        $system = \Apps\Common\Setting::getInstance()->group('system');
        $current_theme = $system['theme'];
        $p_id = $this->get('p',0);

        if($p_id){
            $layout = $this->db()->getOne('layouts', "`id`=$p_id");
            $themeDir = \hmvc\Web\Application::themesPath().$current_theme.'/customize/';
            $filename = $layout['filename'];
            @unlink($themeDir.$filename.'.html');
            $this->db()->delete('layouts', "`id`=$p_id");
            $this->showFlashMessage("删除成功",H_SUCCESS,$this->urlRef());

        }else{
            $this->showFlashMessage("删除失败，请重试!",H_SUCCESS,$this->urlRef());
        }
        
    }

    //自定义
    public function customizeAction() {
        $this->isAdmin();
        $this->assign('menu_theme', 1);
        $options = array('syntax'=>'html');
        
        $current_theme = $this->get('themes');
        if($current_theme){
            //切换当前主题
            $_SESSION['ctheme'] = $current_theme;
        }else if(isset($_SESSION['ctheme'])){
            $current_theme = $_SESSION['ctheme'];
        }else{
            $system = \Apps\Common\Setting::getInstance()->group('system');
            $current_theme = $system['theme'];
            $_SESSION['ctheme'] = $current_theme;
        }
        

        //设置打开文件
        $default_filename = "themes/$current_theme/index.html";
        $open_filename = $this->get('openfile');
        if($open_filename){
            if(is_file($open_filename)){
                if($this->isPost() ){
                    if(!is_writeable($open_filename)){
                        $this->showFlashMessage("没有权限写入: $open_filename",H_ERROR);     
                    }
                    $content = $this->post('content');
                    file_put_contents($open_filename, $content);
                    $this->showFlashMessage("保存成功",H_SUCCESS);
                }
                $f_info = pathinfo($open_filename);                
                $options['syntax'] = $f_info['extension'];
                $openfile = file_get_contents($open_filename);
            }else{
                $openfile = "";
            }
        }else{
            if(is_file($default_filename)){
                $open_filename = $default_filename;                
                $openfile = file_get_contents($default_filename);
            }    
        }   
        

        //搜索所有主题
        $themes = array();

        $it = new \RecursiveDirectoryIterator(\hmvc\Web\Application::themesPath());
        foreach ($it as $path) {
            if ($path->isDir()) {
                $skin = array();
                $skin['theme_name'] = $path->getFilename();                
                $themes[]  = $skin;
            }
        }


        $this->assign('fname',$open_filename );
        $this->assign('filecontent',$openfile );
        $this->assign('themes',$themes );
        $this->assign('cthemes',$_SESSION['ctheme'] );

        $this->assign('tree',\Apps\Common\FileBrowser::showTree("themes/{$current_theme}", "javascript:openFile('[link]');",array('html','js','css','php')));
        $this->assign('editor',\Apps\Common\EditArea::create('content',$options));
        $this->render('admin/theme/customize');   
    }

    public function settingAction(){
        
    }
}
