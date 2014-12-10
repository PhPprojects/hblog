<?php

namespace Apps\Blog\Model;

class Tags extends \hmvc\Web\Model {
    
    public function saveTags($tags,$post_id){

        if(is_string($tags)){
            $tags = explode(',', $tags);
        }
        $this->db()->delete('blog_tags_to_post', array(                
                'post_id'=>$post_id
                ));

        foreach ($tags as $value) {
            if(empty($value)){
                continue;
            }

            $tag = $this->db()->getOne('blog_tags', array('name'=> $value));
            if($tag){
                $tag_id = $tag['id'];
            }else{                
                $this->db()->insert('blog_tags', array('name'=>  $value));    
                $tag_id = $this->db()->lastId();
            }

            $this->db()->insert('blog_tags_to_post', array(
                'tag_id'=>$tag_id,
                'post_id'=>$post_id
                ));  

                echo $this->db()->last_query();
        
        }

        #更新文章数
        //$this->db()->update('blog_tags', $_data, $_where);
        
    }


    public function getTagsByPostId($post_id) {
        return $this->db()->from('blog_tags_to_post','tp')->join('blog_tags t','tp.tag_id=t.id')->where('post_id',$post_id)->get();
    }

    public function getTagNamesByPostId($post_id) {
        $list = $this->getTagsByPostId($post_id);
        $names = array();
        foreach ($list as $value) {
            $names[] = $value['name'];
        }
        return $names;
    }
}
