<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Apps\Blog\Model;

/**
 * Description of Page
 *
 * @author Administrator
 */
class Pagination extends \hmvc\Web\Pagination {

    public function toHtml($model='posts') {
        $blog = Blog::getInstance();
        echo '<div class="col-lg-12" style="text-align:center"><ul class="pagination pagination-lg">';
        if ($this->_cur_page <= 1) {
            echo '<li class="disabled" ><a href="javascript:void(0)">&laquo;</a></li>';
//            echo '<li class="paginate_button active " tabindex="0"><a href="#">1</a></li>';
        } else {
            echo '<li ><a href="', $blog->PagebarLink($this->_cur_page - 1,$model), '">&laquo;</a></li>';
        }
        for ($i = 1; $i <= $this->_total_page; $i++) {
            if ($i == $this->_cur_page) {
                echo '<li class="paginate_button active " tabindex="0"><a href="javascript:void(0);">', $i, '</a></li>';
            } else {
                echo '<li class="paginate_button " tabindex="0"><a href="',$blog->PagebarLink($i,$model),'">', $i, '</a></li>';
            }
        }

        
        if ($this->_cur_page == $this->_total_page) {
            echo '<li class="disabled"  ><a href="javascript:void(0)">&raquo;</a></li>';
        } else {
            echo '<li ><a href="', $blog->PagebarLink($this->_cur_page + 1,$model), '">&raquo;</a></li>';
        }


        echo '</ul></div>';
    }

}
