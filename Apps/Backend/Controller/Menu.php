<?php

namespace Apps\Backend\Controller;

/**
 * 菜单管理
 */
class Menu extends \Apps\Backend\Controller\AdminController {

    public function init(){
        parent::init();
        $this->isAdmin();
        $this->assign('menu_theme', 1);
    }

    public function listAction() {
       
      
        $result = \H1Soft\H\Web\Extension\Category::query('menu');

        $this->saveUrlRef();

        $this->render('admin/menu/list', array('list' => $result));

       
    }

    public function addcategoryAction() {
        $name = $this->post('name');
        $category = $this->post('category');
        $description = $this->post('description');
        $menu_type = $this->post('menu_type');
        $target = $this->post('target');
        $menu_value = $this->post('menu_value');
        $tbname = $this->db()->tb_name('menu');
        $parent_row = array(
            'name' => $name,
            'parent' => $category,
            'sort_order' => 1,
            'level' => 0,
            'description' => $description,
            'path' => 0,
            'menu_type'=>$menu_type,
            'target'=>$target,
            'menu_value'=>$menu_value
        );
        if (!empty($category)) {
            $parent_category = $this->db()->getRow("SELECT * FROM $tbname WHERE `id`='{$category}'");
            $parent_row['path'] = $parent_category['path'] . '-' . $parent_category['id'];
            $parent_row['level'] = $parent_category['level'] + 1;
            $parent_row['parent'] = $category;
        }
        $this->db()->insert('menu', $parent_row);
    }

    public function editcategoryAction() {
       
        $id = intval($this->get('id'));
        $category = $this->db()->getOne("menu", " `id`=$id ");
        if ($this->isPost()) {
            $menu_type = $this->post('menu_type');
            $target = $this->post('target');
            $menu_value = $this->post('menu_value');
            $post = array(
                'name' => $this->post('name'),
                'description' => $this->post('description'),
                'sort_order' => intval($this->post('sort_order')),
                'menu_type'=>$menu_type,
                'target'=>$target,
                'menu_value'=>$menu_value
            );
            $select_category = $this->post('category');
            if ($category['parent'] != $select_category && $id != $select_category) {
                $post['parent'] = $select_category;
                //更新level
                $parent_category = $this->db()->getOne("menu", " `id`=$select_category ");
                $post['level'] = $select_category == 0 ? 0 : $parent_category['level'] + 1;
                $post['path'] = $select_category == 0 ? 0 : $parent_category['path'] . '-' . $select_category;
                unset($parent_category);
            }

            $this->db()->update('menu', $post, "id=$id");
            $this->redirect($this->urlRef());
        }

        $result = \H1Soft\H\Web\Extension\Category::query('menu');


        $this->render('admin/menu/add', array('item' => $category, 'id' => $id, 'list' => $result));
    }


    function rmcategoryAction() {
        $this->isSuperAdmin();
        $id = intval($this->get('id'));
        if (!$id) {
            $this->showFlashMessage("类别不存在", H_ERROR, $this->urlRef());
        }
        $check = $this->db()->getOne('menu', "parent=$id");
        if ($check) {
            $this->showFlashMessage("请先删除子类别", H_ERROR, $this->urlRef());
        }
        $this->db()->delete('menu', "`id`=$id");
        $this->showFlashMessage("删除成功", H_SUCCESS, $this->urlRef());
    }

}
