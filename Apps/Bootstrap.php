<?php

/*
 * This file is part of the HBlog package.
 * (w) http://www.w4u.cn
 * (c) Allen Niu <h@h1soft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Apps;

define('HBLOG', 'HBlog 1.0.1');

define('BASEPATH',\H1Soft\H\Web\Application::basePath());


class Bootstrap extends \H1Soft\H\Web\Bootstarp {

    public function ApplicationStart() {
        date_default_timezone_set('Asia/Shanghai');
    }

}
