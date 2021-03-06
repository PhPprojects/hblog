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
                <form>
                    <h2>系统环境检测</h2>
                    <table class="table ">
      <thead>
        <tr>
          <th>名称</th>
          <th>最低要求</th>
          <th>当前系统</th>        
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>PHP版本</td>
          <td>PHP5.3+</td>
          <?php 
if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
 echo '<td class="success">',phpversion();
}else{
    echo '<td class="error">',phpversion();
}
          ?></td>
         
        </tr>
        <tr>
          <td>MYSQLi</td>
          <td>必须</td>
          <?php 
if (function_exists('mysqli_connect')) {
 echo '<td class="success">支持';
}else{
    echo '<td class="error">不支持';
}
          ?>

          </td>
          
        </tr>
        
      </tbody>
    </table>

    <h2>目录权限</h2>
                    <table class="table ">
      <thead>
        <tr>
          <th>目录名称</th>
          <th>权限</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td width="60%">etc/</td>
          <?php 
if (is_writeable("../etc")) {
 echo '<td class="success">pass';
}else{
    echo '<td class="error">无权限';
}
          ?></td>
         
        </tr>
        <tr>
          <td>etc/config.php</td>
          <?php 
if (is_writeable("../etc/config.php")) {
 echo '<td class="success">pass';
}else{
    echo '<td class="error">无权限';
}
          ?></td>
         
        </tr>
        <tr>
          <td>etc/db.php</td>
          <?php 
if (is_writeable("../etc/db.php")) {
 echo '<td class="success">pass';
}else{
    echo '<td class="error">无权限';
}
          ?></td>
         
        </tr>

        <tr>
          <td>upload/</td>
          <?php 
if (is_writeable("../upload/")) {
 echo '<td class="success">pass';
}else{
    echo '<td class="error">无权限';
}
          ?></td>
         
        </tr>
      </tbody>
    </table>

                    <a href="step2.php" class="btn btn-primary pull-right">开始安装</a>
                  
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        <p><a href="http://www.hmvc.cn/hblog.html" target="_blank">HBlog</a></p>
    </div>
</div>


    


    <script src="../themes/default/admin/lib/bootstrap/js/bootstrap.min.js"></script>
    
  </body>
</html>


