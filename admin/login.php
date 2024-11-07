<?php
session_start();
  require '../config/config.php';

  $emailError = '';
  $passwordError = '';
  
  if($_POST){
  
    if(empty($_POST['email']) || empty($_POST['password'])){
      if(empty($_POST['email'])){
        $emailError = "*Email cannot be null.";
      }
      if(empty($_POST['password'])){
        $passwordError = "Password cannot be null";
      }
      if( strlen($_POST['password']) < 6){
        $passwordError = 'Password has at least 6 characters..';
      }
    }else{
      $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('select * from users where email=:email');
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
      if(password_verify($password,$result['password'])){
        $_SESSION['userId'] = $result['id'];
        $_SESSION['username'] = $result['name'];
        $_SESSION['loggin'] = time();
        $_SESSION['role'] = $result['role'];
        if($_SESSION['role'] == 1){
          echo "<script>alert('Login Successful');window.location.href='index.php'</script>";
        }else{
          echo "<script>alert('Login Successful');window.location.href='../index.php'</script>";
        }
        

      }else{
        echo "<script>alert('Incorrect crendital..');window.location.href='login.php'</script>";

      }
    }else{
      echo "<script>alert('Login Unsuccess');window.location.href='login.php'</script>";

    }

    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shopping| Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="shortcut icon" href="logo/market.png" />
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Blog</b>PHP</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="#" method="post">
        <p class="text-red"><?php echo $emailError; ?></p>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <p class="text-red"><?php echo $passwordError; ?></p>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
