<?php

namespace Apps\Blog\Controller;

class Admin extends \Apps\Backend\Controller\AdminController {

    public function indexAction() {
        $this->assign('menu_blog', 1);
        $this->saveUrlRef();


        $total_rows = $this->db()->count('blog_posts');
        $page = new \H1Soft\H\Web\Pagination($total_rows, $this->get('page', 1), 20);
        $page->setUrl('/blog/admin/index');
        $posts = $this->db()->order_by('post_modifyed', 'DESC')
                ->limit( $page->getPageSize(),$page->getOffset())
                ->get('blog_posts');
        
        $this->assign('page', $page);      
        $this->assign('list', $posts);

        $this->render('admin/blog_index');
    }

    /**
     * 写文章
     */
    public function writeAction() {
        $this->assign('menu_blog', 1);
        $id = $this->get('p', 0);
         
        $post = $this->db()->getOne('blog_posts', "`id`=$id");
        if ($id) {//修改
            
            $post_category_result = $this->db()->getAll("blog_to_category", "post_id=$id");
            if ($post_category_result) {
                $post_category = array();
                foreach ($post_category_result as $pc) {
                    $post_category[] = $pc['category_id'];
                }
                $this->assign('post_category', $post_category);
            }
            $this->assign('post', $post);
            
            
        }
        if ($this->isPost()) {
            $category = $this->post('category');
            $content = $this->post('content');
            $title = trim($this->post('title'));
            $post_date = $this->post('post_date');
            if (\H1Soft\H\Utils\Date::isDate($post_date)) {
                $post_date = strtotime($post_date);
            }
            $post_status = $this->post('post_status');
            $comment_status = $this->post('comment_status');

            if(empty($title)){
                $this->showFlashMessage("标题不能为空");
            }
            if (!$post) {
                $post_id = $this->db()->insert('blog_posts', array(
                    'author' => \H1Soft\H\Web\Auth::getInstance()->getId(),
                    'title' => $title,
                    'post_name' => $title,
                    'content' => $content,
                    'post_status' => $post_status,
                    'comment_status' => $comment_status,
                    'post_date' => time(),
                    'post_modifyed' => time(),
                ));
                $post = \Apps\Blog\Model\Post::getInstance();
                $post->updateCategory($post_id, $category);
                $tags = \Apps\Blog\Model\Tags::getInstance();
                $tags->saveTags($this->post('stags'),$post_id);
                $this->showFlashMessage("添加成功", H_SUCCESS);
            } else {
                $post['title'] = $title;
                $post['post_name'] = $title;
                $post['content'] = $content;
                
                $post['post_status'] = $post_status;
                $post['comment_status'] = $comment_status;
                $post['post_modifyed'] = time();
                $this->db()->update('blog_posts', $post, "`id`=$id");
                $post = \Apps\Blog\Model\Post::getInstance();
                $post->updateCategory($id, $category);
                $tags = \Apps\Blog\Model\Tags::getInstance();               
                $tags->saveTags($this->post('stags'),$id);
                $this->showFlashMessage("修改成功", H_SUCCESS);
            }
        }
        $this->assign('category', \H1Soft\H\Web\Extension\Category::query('blog_category'));
        $this->assign('editor', \Apps\UEditor\Helper\UEditor::create('content'));
        $tags = \Apps\Blog\Model\Tags::getInstance();
        $tagname_list = $tags->getTagNamesByPostId($id);
     
        $this->assign('tagname_list', $tagname_list);

        $this->render('admin/blog_write');
    }

    /**
    *   删除文章
    **/
    function removeAction() {
        $this->isSuperAdmin();
        $id = intval($this->get('p'));
        if (!$id) {
            $this->showFlashMessage("文章不存在", H_ERROR, $this->urlRef());
        }      
        $this->db()->delete('blog_posts', "`id`=$id");
        $this->showFlashMessage("删除成功", H_SUCCESS, $this->urlRef());
    }

    public function categoryAction() {
        $this->assign('menu_blog', 1);
        $result = \H1Soft\H\Web\Extension\Category::query('blog_category');

        $this->saveUrlRef();

        $this->render('admin/blog_category', array('list' => $result));
    }

    public function addcategoryAction() {
        $name = $this->post('name');
        $category = $this->post('category');
        $description = $this->post('description');
        $tbname = $this->db()->tb_name('blog_category');
        $parent_row = array(
            'name' => $name,
            'parent' => $category,
            'sort_order' => 1,
            'level' => 0,
            'description' => $description,
            'path' => 0
        );
        if (!empty($category)) {
            $parent_category = $this->db()->getRow("SELECT * FROM $tbname WHERE `id`='{$category}'");
            $parent_row['path'] = $parent_category['path'] . '-' . $parent_category['id'];
            $parent_row['level'] = $parent_category['level'] + 1;
            $parent_row['parent'] = $category;
        }
        $this->db()->insert('blog_category', $parent_row);
    }

    public function editcategoryAction() {
        $this->assign('menu_blog', 1);
        $id = intval($this->get('id'));
        $category = $this->db()->getOne("blog_category", " `id`=$id ");
        if ($this->isPost()) {
            $post = array(
                'name' => $this->post('name'),
                'description' => $this->post('description'),
                'sort_order' => intval($this->post('sort_order')),
            );
            $select_category = $this->post('category');
            if ($category['parent'] != $select_category && $id != $select_category) {
                $post['parent'] = $select_category;
                //更新level
                $parent_category = $this->db()->getOne("blog_category", " `id`=$select_category ");
                $post['level'] = $select_category == 0 ? 0 : $parent_category['level'] + 1;
                $post['path'] = $select_category == 0 ? 0 : $parent_category['path'] . '-' . $select_category;
                unset($parent_category);
            }

            $this->db()->update('blog_category', $post, "id=$id");
            $this->redirect($this->urlRef());
        }

        $result = \H1Soft\H\Web\Extension\Category::query('blog_category');


        $this->render('admin/blog_category_modify', array('item' => $category, 'id' => $id, 'list' => $result));
    }

    function rmcategoryAction() {
        $this->isSuperAdmin();
        $id = intval($this->get('id'));
        if (!$id) {
            $this->showFlashMessage("类别不存在", H_ERROR, $this->urlRef());
        }
        $check = $this->db()->getOne('blog_category', "parent=$id");
        if ($check) {
            $this->showFlashMessage("请先删除子类别", H_ERROR, $this->urlRef());
        }
        $this->db()->delete('blog_category', "`id`=$id");
        $this->showFlashMessage("删除成功", H_SUCCESS, $this->urlRef());
    }

    public function tagsAction() {
        $this->assign('menu_blog', 1);
        $this->saveUrlRef();

        $total_rows = $this->db()->count('blog_tags');
        $page = new \H1Soft\H\Web\Pagination($total_rows, $this->get('page', 1), 20);
        $page->setUrl('/blog/admin/tags');
        $tags = $this->db()
                ->limit( $page->getPageSize(),$page->getOffset())
                ->get('blog_tags');
        
        $this->assign('page', $page);      
        $this->assign('list', $tags);

        $this->render('admin/blog_tags');
    }

    public function getTagsAction() {
        if ($this->isAjax()) {
            $tags = $this->db()->select("name")->get('blog_tags');
            
            echo json_encode($tags);
        }
    }

}
