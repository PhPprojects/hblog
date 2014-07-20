<?php

namespace Apps\Blog\Model;

class Tags extends \H1Soft\H\Web\Model {
    
    public function saveTags($tags){
        if(is_string($tags)){
            $tags = explode(',', $tags);
        }
        foreach ($tags as $value) {
            $this->db()->replace('blog_tags', array('name'=>  trim($value)));
        }
        $this->db()->update('', $_data, $_where);
        
    }
}
