<?php

namespace Apps\Blog\Model;

/**
 * 博客模块
 */
class Blog extends \H1Soft\H\Web\Model {

    public function init() {
        
    }

    public function Category($category_id = NULL) {
        if ($category_id) {
            return $this->db()->getOne('blog_category', "`id`=$category_id");
        }
        return \H1Soft\H\Web\Extension\Category::query('blog_category');
    }
    
    public function CategoryName($category_id = NULL) {
        if ($category_id) {
            $this->db()->where('id', $category_id)->select("name");
            return $this->db()->scalar('blog_category');
        }
        return NULL;
    }

    /**
     * 获取一条POST
     * @param int $post_id
     * @return Post
     */
    public function Post($post_id) {
        return $this->db()->getOne('blog_posts', "`id`=$post_id");
    }

    public function Posts($params = NULL) {
        if ($params) {            
            parse_str($params);
            $where = '';
            if (isset($category_id)) {
                $where .= " category_id=$category_id";
                $result = $this->db()->join('blog_posts p', "p.id=c.post_id")->order_by('post_date', 'desc')->where('category_id', $category_id)->get('blog_to_category c');;
//                echo $this->db()->last_query();
                return $result; 
            } else {
                
            }
        } else {
            return $this->db()->getAll('blog_posts', NULL, "post_date desc");
        }
    }

    public function post_link($post_id) {
        return sprintf("%s/post/%d.html", \H1Soft\H\Web\Application::basePath(), $post_id);
    }
    
    public function PagebarLink($post_id,$model) {
        return sprintf("%s/%s/page/%d.html", \H1Soft\H\Web\Application::basePath(),$model, $post_id);
    }
    
    public function category_link($category_id) {
        return sprintf("%s/category/%d.html", \H1Soft\H\Web\Application::basePath(), $category_id);
    }

    public function homeUrl() {
        return sprintf("%s/index.html", \H1Soft\H\Web\Application::basePath());
    }

}
