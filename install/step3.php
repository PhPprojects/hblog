<?php
session_start();
error_reporting(0);
$error = "";
if(isset($_POST['username']) && isset($_POST['password'])){
    $dbhost = session('dbhost');
    $dbname = session('dbname');
    $dbport = session('dbport');
    $dbuser = session('dbuser');
    $dbpass = session('dbpass');
    $tbprefix = session('tbprefix');

    $username = post('username');
    $password = post('password');
    
    //安装数据库
    $db = new mysqli($dbhost,$dbuser,$dbpass,$dbname,$dbport);
                
        $file = 'h.sql';
        
        if (!file_exists($file)) { 
            exit('数据库文件不存在: ' . $file); 
        }
        
        $lines = file($file);
        
        if ($lines) {
            $sql = '';

            foreach($lines as $line) {
                if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')) {
                    $sql .= $line;

                    if (preg_match('/;\s*$/', $line)) {
                       // $sql = str_replace("DROP TABLE IF EXISTS `h_", "DROP TABLE IF EXISTS `" . $tbprefix, $sql);
                        $sql = str_replace("CREATE TABLE IF NOT EXISTS `h_", "CREATE TABLE `" . $tbprefix, $sql);
                        $sql = str_replace("INSERT INTO `h_", "INSERT INTO `" . $tbprefix, $sql);
                        
                        $db->query($sql);
    
                        $sql = '';
                    }
                }
            }
            $db->query("SET CHARACTER SET utf8");
    
            $db->query("SET @@session.sql_mode = 'MYSQL40'");       
            $password = sha1('h1framework'.$password);
            $db->query("UPDATE `" . $tbprefix . "admin` SET `username`='$username',`password` = '$password',add_time=NOW(),modify_time=NOW(),last_login=NOW()");
        }
            
            

$db_content = <<<EOF
<?php
return array(
        'db' => array(
            'driver' => 'mysqli',
            'host' => '$dbhost',
            'database' => '$dbname',
            'username' => '$dbuser',
            'password' => '$dbpass',
            'prefix' => '$tbprefix',
            'charset' => 'utf8',            
            'port' => '$dbport'
        ),
    );
EOF;

    $root_dir = dirname(__DIR__);
    file_put_contents($root_dir.'/etc/db.php', $db_content);

    #写入 htaccess
    $basepath = dirname(dirname($_SERVER['SCRIPT_NAME']));
    if($basepath == '/' || $basepath == '\\'){
        $basepath = '/';
    }
    $htaccess = <<<EOF
RewriteEngine On
RewriteBase $basepath

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-l

RewriteRule ^(.+)$ index.php?r=$1 [QSA,L]
EOF;

    file_put_contents($root_dir.'/.htaccess', $htaccess);
    header('Location:step4.php');

}

function post($key){
    if(isset($_POST[$key])){
        return trim($_POST[$key]);
    }
    return NULL;
}
function session($key){
    if(isset($_SESSION[$key])){
        return trim($_SESSION[$key]);
    }
    return NULL;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>HBlog Install - 安装</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="../themes/default/admin/lib/bootstrap/css/bootstrap.css">
    
    <link rel="stylesheet" type="text/css" href="../themes/default/admin/lib/theme.css">
    <link rel="stylesheet" href="../themes/default/admin/lib/font-awesome/css/font-awesome.css">

    <script src="../themes/default/admin/lib/jquery-1.7.2.min.js" type="text/javascript"></script>

    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
        .table tbody td.success {
  background-color: #AEDD9A;
}
.table tbody td.error {
  background-color: #F55555;
}
    </style>

    
    <!--[if lt IE 9]>
      <script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->

   
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body class=""> 
  <!--<![endif]-->
    
    <div class="navbar">
        <div class="navbar-inner">
                <ul class="nav pull-right">
                    
                </ul>
                <a class="brand" href="http://www.hmvc.cn/projects/hblog.html"><span class="second">HBlog</span></a>
        </div>
    </div>
    


    

    
   <div class="row-fluid">
    <div class="dialog" style="width:600px;">
        <div class="block">
            <p class="block-heading">第三步 - 配置网站</p>
            <div class="block-body">
                <form action="" method="post">
                    <label>网站标题</label>
                    <input type="text" class="span12" value="HBlog" name="site_title">
                    <label>用户名</label>
                    <input type="text" class="span12" value="admin" name="username">
                    <label>密码</label>
                    <input type="text" class="span12" value="" name="password">                   
                    <input type="submit" class="btn btn-primary pull-right" value="下一步" /> 
                 
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        <p><a href="http://www.hmvc.cn/projects/hblog.html" target="_blank">HBlog</a></p>
    </div>
</div>


    


    <script src="../themes/default/admin/lib/bootstrap/js/bootstrap.min.js"></script>
    
  </body>
</html>