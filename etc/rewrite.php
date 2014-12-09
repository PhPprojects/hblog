<?php

return array(
//            '(\d+)/(\d+)/(\d+)/(.*)' => 'index/index/year/{0}/m/{1}/day/{2}/title/{3}',
            '^(\w+).html'=>'index/{0}',
            'posts/page/(\d+).html'=>'index/index/page/{0}',
            'post/(\d+).html'=>'index/post/id/{0}',
            'category/(\d+).html'=>'index/category/id/{0}'
        );
