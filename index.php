<?php

/*
 * This file is part of the HBlog package.
 * (w) http://www.w4u.cn
 * (c) Allen Niu <h@h1soft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
#error_reporting(E_ERROR | E_WARNING | E_PARSE);



require 'vendor/autoload.php';


$app = new \hmvc\Web\Application();

$app->bootstrap('\Apps\Bootstrap')->run();


