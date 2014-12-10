<?php

return array(    
    'router' => array(
        'app' => 'Catalog',
        'controller' => 'Index',
        'action' => 'Index',        
        'suffix' => '.html',
        'showscriptname'=>false,
        'uri_protocol'=> 'PATH_INFO',  
        'rewrite'=> require('rewrite.php') 
    ),
    'alias' => array(
        'hadmin' => 'backend'
    ),
    'src' => 'Apps',
    'autoload' => array(
        'psr0' => array(),
        'psr4' => array(),
    ),
    // database settings
    'databases' => require('db.php'),
    'debug' => true,
    'view' => array(
        'theme' => 'default',
        'template' => 'Twig',
        'cache' => false
    ),
);
