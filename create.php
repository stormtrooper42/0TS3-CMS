<?php 
session_start();
require_once("libraries/TeamSpeak3/TeamSpeak3.php");
require 'app/Verify.php';
require 'inc/ts.php';
require 'inc/db.php';
if(!isset($_SESSION['auth'])){
  header('Location: login.php');
  exit();
}
$verify = new \App\Verify($cnx);
$verify->checkTS($_SESSION['auth']['pseudo']);

  if(isset($_POST) && !empty($_POST['name']) && !empty($_POST['slots'])){
    $name = $_POST['name'];
    $slots = $_POST['slots'];


      if($slots > 1025){
        $_SESSION['flash']['danger'] = "Max slots = 1024";
        header('Location: create.php');
        exit();
      }elseif(!preg_match('/^[a-zA-Z0-9_]+$/', $name)){
        $_SESSION['flash']['danger'] = "Name must be alphanumeric";
        header('Location: create.php');
        exit();
      }elseif(preg_match('/^[a-zA-Z0-9_]+$/', $name) && $slots < 1025){
        $ts3_serv->serverCreate(array(
         "virtualserver_name" => $name,
         "virtualserver_maxclients" => $slots, 
         "virtualserver_port" => $_SESSION['teamspeak']['port'], 
        ));
        $req = $cnx->prepare("INSERT INTO servers(name, slots, port, username) 
                              VALUES (:name, :slots, :port, :username)");
        $req->execute(array(  
                    'name' => $name, 
                    'slots' => $slots, 
                    'port' => $_SESSION['teamspeak']['port'], 
                    'username' => $_SESSION['auth']['pseudo']
                    ));

        $_SESSION['flash']['success'] = "Teamspeak created !";
        unset($_SESSION['teamspeak']['port']);
        header('Location: index.php');
        exit();
      }

  }else{
        $_SESSION['teamspeak']['port'] = rand(2222,7777);
  }

include 'inc/header.php';
?> 
  <body class="hold-transition skin-red layout-boxed">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>0</b>NT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>0</b>Network</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          
         
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?= $_SESSION['auth']['pseudo']; ?></p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">Menu</li>
            <li><a href="index.php"><i class="fa fa-home"></i> <span>Home</span></a></li>
            <li  class="active"><a href="create.php"><i class="fa fa-plus"></i> <span>Create TS3 Server</span></a></li>
            <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
            
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             Create your TS3 Server
            <small>For FREE !</small>
          </h1>
         
        </section>

        <!-- Main content -->
        <section class="content">
            <?php if(isset($_SESSION['flash'])): ?>
              <?php foreach($_SESSION['flash'] as $type => $message): ?>
                  <div class="alert alert-<?= $type; ?>">
                      <?= $message; ?>
                  </div>
              <?php endforeach; ?>
              <?php unset($_SESSION['flash']); ?>
          <?php endif; ?>
          
          <div class="col-md-8">
              <div class="panel panel-default">
                <div class="panel-body">
                   <form action="" method="post"> 
                    <div class="form-group">
                      <label for="TS3.Name">Teamspeak Name</label>
                      <input type="text" name="name" class="form-control" id="TS3.Name" placeholder="Teamspeak Name">
                    </div>
                    <div class="form-group">
                      <label for="TS3.Slots">Max Slots</label>
                      <input type="text" name="slots" class="form-control" id="TS3.Slots" placeholder="Max Slots">
                    </div>
                     <div class="form-group">
                      <label for="TS3.Port">Port</label>
                      <input type="text" class="form-control" id="TS3.Port" value="<?=$_SESSION['teamspeak']['port']; ?>" disabled>
                    </div>
                 
                    <button type="submit" class="btn btn-default">Create my Teamspeak !</button>
                  </form>
                </div>
              </div>

          </div>
          <div class="col-md-4">
            <div class="panel panel-default">
             <div class="panel-heading">
                <h3 class="panel-title">Advertissement</h3>
              </div>
              <div class="panel-body">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- 0network -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-2576728198449645"
                     data-ad-slot="5554991015"
                     data-ad-format="auto"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>

              </div>
            </div>
          </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          0Network Team
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015-2016 <a href="#">0Network</a>.</strong> All rights reserved.
      </footer>

  
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
  </body>
</html>
