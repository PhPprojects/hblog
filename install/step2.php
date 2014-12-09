<?php
session_start();
error_reporting(0);
$error = "";
if(isset($_POST['dbname']) && isset($_POST['dbuser']) && isset($_POST['dbpass'])){
   
    $dbhost = post('dbhost');
    $dbname = post('dbname');
    $dbport = post('dbport');
    $dbuser = post('dbuser');
    $dbpass = post('dbpass');
    $tbprefix = post('tbprefix');
    try{
        $link = new mysqli($dbhost, $dbuser, $dbpass, $dbname,$dbport);
        
        if ($link->connect_error) {
            $error = "数据库连接失败: " . $link->connect_error;
        }else{
            $_SESSION['dbhost'] = $dbhost;
            $_SESSION['dbname'] = $dbname;
            $_SESSION['dbport'] = $dbport;
            $_SESSION['dbuser'] = $dbuser;
            $_SESSION['dbpass'] = $dbpass;
            $_SESSION['tbprefix'] = $tbprefix;
            header("Location:step3.php");
            exit;
        }
    }catch(Exception $ex){
        
    }
  
}
function post($key){
    if(isset($_POST[$key])){
        return trim($_POST[$key]);
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
            <p class="block-heading">第二步 - 系统环境检测</p>
            <div class="block-body">
                <form action="" method="post">
                    <label>数据库适配器</label>
                    <select class="span12" name="dbada">
                        <option value="mysqli">mysqli</option>
                    </select>
                    <label>数据库名</label>
                    <input type="text" class="span12" value="hblog" name="dbname">
                    <label>数据库主机</label>
                    <input type="text" class="span12" value="localhost" name="dbhost">
                    <label>端口</label>
                    <input type="text" class="span12" value="3306" name="dbport">
                    <label>用户名</label>
                    <input type="text" class="span12" value="root" name="dbuser">
                    <label>密码</label>
                    <input type="password" name="dbpass" class="span12">
                    <label>表前缀</label>
                    <input type="text" name="tbprefix" value="hb_" class="span12">
                    <input type="submit" class="btn btn-primary pull-right" value="下一步" /> 
                    <?php
                    if($error){
                        ?>
            <div class="alert alert-danger" role="alert"><?php echo $error;?></div>
                        <?php
                    }
                    ?>
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


