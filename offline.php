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
if(!isset($_SESSION['flash']['danger'])){
  header('Location: index.php');
  exit();
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
