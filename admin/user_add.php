<?php
session_start();
  require '../config/config.php';

  if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
    header('Location:login.php');
  }
  if($_SESSION['role'] != 1){
    header('Location:login.php');
  }
  $nameError = '';
  $emailError = '';
  $passwordError = '';
  $phoneError = '';
  $addressError = '';
  if($_POST){
    if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address'])){
      if(empty($_POST['username'])){
        $nameError = "*Name cannot be empty";
      }
      if(empty($_POST['email'])){
        $emailError = "*Email cannot be null.";
      }
      if(empty($_POST['phone'])){
        $phoneError = "* Phone number cannot be empty.";
      }
      if(empty($_POST['address'])){
        $addressError = "* Address cannot be empty.";
      }
       $cc = strlen($_POST['password']);
      if($cc < 6){
        $passwordError = "*Password at lease 6 characters.";
      }
    }else{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare('select * from users where email=:email');
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        echo "<script>alert('Email is already taken..')</script>";
    }else{
        if(isset($_POST['role'])){
            $stmt1 = $pdo->prepare("INSERT INTO users(name,email,password,phone,address,role) VALUES(:name,:email,:password,:phone,:address,:role)");
            $result1 = $stmt1->execute(
                array(
                    ':name'=>$username,
                    ':email'=>$email,
                    ':password'=>$password,
                    ':phone'=> $phone,
                    ':address'=>$address,
                    ':role'=> 1
                )
            );
        }else{
            $stmt1 = $pdo->prepare("INSERT INTO users(name,email,password,phone,address,role) VALUES(:name,:email,:password,:phone,:address,:role)");
            $result1 = $stmt1->execute(
                array(
                    ':name'=>$username,
                    ':email'=>$email,
                    ':password'=>$password,
                    ':phone' => $phone,
                    ':address' => $address,
                    ':role'=> 0
                )
            );
        }
        
        if($result1){
            echo "<script>alert('User added successfully..You can now login');window.location.href='user_list.php';</script>";
        }else{
            echo "<script>alert('Something wrong');window.location.href='user_list.php';</script>";

        }
    }
    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shopping| Create New User</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<?php  
  include 'header.php';
?>
<body class="hold-transition login-page">
<div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Bordered Table</h3>
            </div>
                <div class="card-body">
                  <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label for="name" >Name</label><p class="text-red"><?php echo $nameError; ?></p>
                        <input type="text" class="form-control" name="username" require>
                    </div>
                    <div class="form-group">
                        <label for="email" >Email</label><p class="text-red"><?php echo $emailError; ?></p>
                        <input type="email" name="email" class="form-control"require>
                    </div>
                    <div class="form-group">
                        <label for="phone" >Phone</label><p class="text-red"><?php echo $phoneError; ?></p>
                        <input type="text" class="form-control" name="phone" require>
                    </div>
                    <div class="form-group">
                        <label for="password" >Password</label><p class="text-red"><?php echo $passwordError; ?></p>
                        <input type="password" class="form-control" name="password"require>
                    </div>
                    <div class="form-group">
                        <label for="address" >Address</label><p class="text-red"><?php echo $addressError; ?></p>
                        <input type="text" class="form-control" name="address"require>
                    </div>
                    <div class="form-group">
                        <label for="role" >Role</label><br>
                        <input type="checkbox" name="role"><span style="padding-left:10px;font-weight:bold;color:black;">Admin</span>
                    </div>
                    <div class="form-group mt-2">
                        <input type="submit" name="submit" value="Add user" class="btn btn-success">
                        <a href="user_list.php" class="btn btn-outline-dark">Back</a>
                    </div>
                  </form>
                 
                </div>
              
  </div>
  </div>
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
