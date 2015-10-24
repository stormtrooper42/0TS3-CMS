<?php
session_start();
require 'inc/db.php';
require 'app/Login.php';
$login = new \App\Login($cnx);
if(isset($_SESSION['auth'])){
    $_SESSION['flash']['danger'] = "You're already connected !";
    header('Location: index.php');
    exit();
}

  if(isset($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    $login->check_login($_POST['username'], $_POST['password']);
    if(isset($_SESSION['auth'])){
      header('Location: index.php');
      exit();
    }
  }

?>
<?php include 'inc/header.php'; ?>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href=""><b>0</b>Network</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="" method="post">
          <?php if(isset($_SESSION['flash'])): ?>
              <?php foreach($_SESSION['flash'] as $type => $message): ?>
                  <div class="alert alert-<?= $type; ?>">
                      <?= $message; ?>
                  </div>
              <?php endforeach; ?>
              <?php unset($_SESSION['flash']); ?>
          <?php endif; ?>
          <div class="form-group has-feedback">
            <input type="text" autocomplete="off" maxlength="255" name="username" class="form-control" placeholder="Email or Pseudo">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" autocomplete="off" maxlength="255" name="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
         
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
           
            </div><!-- /.col -->
          </div>
        </form>

        
        <a href="register.php" class="text-center">Create a new account</a>
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="../../plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
