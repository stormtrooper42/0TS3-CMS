<?php
session_start();
require 'inc/db.php';
require 'app/Register.php';
$register = new \App\Register($cnx);
if(isset($_SESSION['auth'])){
    $_SESSION['flash']['danger'] = "You're already connected !";
    header('Location: index.php');
    exit();
}

  if(isset($_POST) && !empty($_POST['pseudo']) && !empty($_POST['password']) && !empty($_POST['password_confirm']) && !empty($_POST['email'])){
 
    $pseudo = $register->check_pseudo($_POST['pseudo']);
    $email = $register->check_email($_POST['email']);
    $password = $register->check_password($_POST['password'], $_POST['password_confirm']);

    if($pseudo != false && $email != false && $password != false){
      $register->create_account($pseudo, $email, $password);
      header('Location: login.php');
      exit();
    }
  }


?>
<?php include 'inc/header.php'; ?>

  <body class="hold-transition register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="index2.html"><b>0</b>Network</a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg">Register Now</p>
          <?php if(isset($_SESSION['flash'])): ?>
        <?php foreach($_SESSION['flash'] as $type => $message): ?>
                <div class="alert alert-<?= $type; ?>">
                    <?= $message; ?>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
       
        <form action="" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="pseudo" class="form-control" placeholder="Pseudo">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="email" autocomplete="off" name="email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password"autocomplete="off"  name="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" autocomplete="off" name="password_confirm" class="form-control" placeholder="Retype password">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> I agree to the <a href="tos.php">ToS</a>
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div><!-- /.col -->
          </div>
        </form>

     

        <a href="login.php" class="text-center">I already have a membership</a>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
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
