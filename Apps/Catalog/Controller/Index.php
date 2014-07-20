<?php

namespace Apps\Catalog\Controller;

class Index extends \H1Soft\H\Web\Controller {

    public function init() {
        $this->assign('Blog', \Apps\Blog\Model\Blog::getInstance());
    }

    public function indexAction() {
        
        $total_rows = $this->db()
                ->where('post_status', 'publish')
                ->count('blog_posts');
        $page = new \Apps\Blog\Model\Pagination($total_rows, $this->get('page', 1), 2);
        $posts = $this->db()->order_by('post_date', 'DESC')
                ->limit( $page->getPageSize(),$page->getOffset())
                ->get('blog_posts');
        
        $this->assign('page', $page);
        $this->assign('posts', $posts);        

        $this->render('index');
    }

    public function aboutAction() {

//        echo $this->db()->last_query();
//        $this->render('index');
    }

    public function postAction() {
        $this->assign('post_id', $this->get('id'));
        $this->render('post');
    }
    
    public function categoryAction() {
        $this->assign('category_id', $this->get('id'));
        $this->render('category');
    }

}
