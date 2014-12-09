<?php


namespace Apps\Backend\Controller;


class Page extends \Apps\Backend\Controller\AdminController {
    public function listAction() {
  		$this->assign('menu_page', 1);
        $this->saveUrlRef();


        $total_rows = $this->db()->count('pages');
        $page = new \H1Soft\H\Web\Pagination($total_rows, $this->get('page', 1), 2);
        $page->setUrl('page/list');
        $pages = $this->db()->order_by('modify_at', 'DESC')
                ->limit( $page->getPageSize(),$page->getOffset())
                ->get('pages');
        
        $this->assign('page', $page);      
        $this->assign('list', $pages);



        $this->render('admin/page/list');
    }
    
    public function addAction() {
        $this->assign('menu_page', 1);
        if($this->isPost()) {
            $title = $this->post('title');
            $description = $this->post('description');
            $content = $this->post('content');
            $keywords = $this->post('keywords');
            
            
            $this->db()->insert('pages', array(                    
                'title' => $title,
                'description' => $description,
                'keywords' => $keywords,
                'content' => $content,
                'created_at' => time(),
                'modify_at' => time()
            ));
            $this->showFlashMessage("保存成功",H_SUCCESS,$this->urlRef());
           

        }



    	$this->assign('editor', \Apps\UEditor\Helper\UEditor::create('content'));
        $this->render('admin/page/add');
    }
    
    public function editAction() {
        $this->assign('menu_page', 1);
        $id = $this->get('id');
        $page = $this->db()->getOne('pages',array('page_id'=>$id));
        if($this->isPost()) {
            $title = $this->post('title');
            $description = $this->post('description');
            $content = $this->post('content');
            $keywords = $this->post('keywords');
            
            
            $this->db()->update('pages', array(                    
                'title' => $title,
                'description' => $description,
                'keywords' => $keywords,      
                'content' => $content,          
                'modify_at' => time()
            ),
            array(
                'page_id'=>$id
                ));
            $this->showFlashMessage("保存成功",H_SUCCESS,$this->urlRef());
           

        }



        $this->assign('item', $page);
        $this->assign('editor', \Apps\UEditor\Helper\UEditor::create('content'));
        $this->render('admin/page/add');
    }
}
