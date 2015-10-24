<?php 
session_start();
include 'inc/header.php';
require_once("libraries/TeamSpeak3/TeamSpeak3.php");
require 'app/Verify.php';
require 'app/Infos.php';
require 'app/Keys.php';
require 'inc/db.php';
if(!isset($_SESSION['auth'])){
  header('Location: login.php');
  exit();
}
$verify = new \App\Verify($cnx);
$verify->checkIndex($_SESSION['auth']['pseudo']);
$infos = new \App\Infos($cnx);
$port = $infos->getPort($_SESSION['auth']['pseudo']);
try
{
/* 
  CHANGE THIS LINE WITH YOUR TS3 QUERY INFOS
*/

$ts3_VirtualServer = TeamSpeak3::factory("serverquery://serveradmin:password@127.0.0.1:10011/?server_port=".$port);
}
catch (Exception $e)
{
  $_SESSION['flash']['danger'] = "Error your TS3 server is offline please contact admin to solve this error";
  $offline = true;
  header('Location: offline.php');
  exit();
}

$keys = new \App\Keys($ts3_VirtualServer);
$map = $ts3_VirtualServer->getViewer(new TeamSpeak3_Viewer_Html("images/viewer/", "images/countryflags/", "data:image"));

  if(isset($_GET) && !empty($_GET['key'])){
    $keys->generate($_GET['key']);
  }

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
            <li class="active"><a href="#"><i class="fa fa-home"></i> <span>Home</span></a></li>
            <li><a href="create.php"><i class="fa fa-plus"></i> <span>Create TS3 Server</span></a></li>
            <li><a href="#"><i class="fa fa-link"></i> <span>More Stuff</span></a></li>
            
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Teamspeak Manager
            <small>Manage your teamspeak !</small>
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
         <div class="col-md-6">
         <div class="panel panel-default">
           <div class="panel-heading">
             <h3 class="panel-title">Server Map</h3>
            </div>
            <div class="panel-body">
            <p><strong>IP : <a href="ts3server://ts.0network.co:<?= $port; ?>">ts.0network.co:<?= $port; ?></a></strong><br />
            <strong>Port : <?= $port; ?></a></strong><br />
            <strong>Slots : <?= $infos->getSlots($_SESSION['auth']['pseudo']); ?></strong><br /></p>

                <?= $map; ?>
           </div>
         </div>
         </div>
          <div class="col-md-4">
         <div class="panel panel-default">
           <div class="panel-heading">
             <h3 class="panel-title">Keys</h3>
            </div>
            <div class="panel-body" align="center">
            <?php if(!empty($_SESSION['keys']['admin'])): ?>
            <label>Admin Key :</label>
           <input class="form-control" readonly="true" type="text" value="<?= $_SESSION['keys']['admin'] ?>" >
            <?php endif; ?><br />
               <a href="index.php?key=admin" class="btn btn-danger">New Admin Key</a>
              
           </div>
         </div>
         </div>
         <div class="col-md-2">
         <div class="panel panel-default">
           <div class="panel-heading">
             <h3 class="panel-title">Advert</h3>
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
