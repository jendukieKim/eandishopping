<?php
    session_start();
    require '../config/config.php';

    if(empty($_SESSION['userid']) && empty($_SESSION['loggin'])){
    header('Location:login.php');
    }
    $userid = $_GET['id'];

    if($_SESSION['role'] != 1){
        header('Location:login.php');
      }
    //retrieve value according to userid
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id=$userid");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $name = $result[0]['name'];
    $email = $result[0]['email'];
    $password = $result[0]['password'];
    $phone = $result[0]['phone'];
    $address = $result[0]['address'];
    $role = $result[0]['role'];
    

    $nameError = '';
    $emailError = '';
    $phoneError = '';
    $addressError = '';
    //update two conditions (checkbox check or not)
    if(isset($_POST['submit'])){
       if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address'])){
        if(empty($_POST['username'])){
            $nameError = "*Name cannot be empty";
        }
        if(empty($_POST['email'])){
            $emailError = "*Email cannot be null";
        }
        if(empty($_POST['phone'])){
            $phoneError = "* Phone number cannot be empty.";
          }
        if(empty($_POST['address'])){
            $addressError = "* Address cannot be empty.";
          }

       }else{
        $upname = $_POST['username'];
        $upemail = $_POST['email'];
        $upphone = $_POST['phone'];
        $upaddress = $_POST['address'];
            if($_POST['role'] != null){
                $stmt1 = $pdo->prepare("UPDATE users SET name='$upname',email='$upemail',phone = '$upphone',address = '$upaddress',role=1 WHERE id = $userid");
                $result1 = $stmt1->execute();
                if($result1){
                    echo "<script>alert('Succcessfully updated');window.location.href='user_list.php'</script>";

                }else{
                    echo "<script>alert('Update unsuccess');window.location.href='user_list.php'</script>";

                }

            }else{
                $stmt1 = $pdo->prepare("UPDATE users SET name='$upname',email='$upemail',phone = '$upphone',address = '$upaddress',role=0 WHERE id = $userid");
                $result1 = $stmt1->execute();
                if($result1){
                    echo "<script>alert('Succcessfully updated');window.location.href='user_list.php'</script>";

                }else{
                    echo "<script>alert('Update unsuccess');window.location.href='user_list.php'</script>";

                }
            }
       }
    }


?>

<!DOCTYPE html>

  
    <?php
        

     include 'header.php';
    ?>
    <!-- Main content -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">User Edit</h3>
            </div>
                <div class="card-body">
                  <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label for="name" >Name</label><p class="text-red"><?php echo $nameError; ?></p>
                        <input type="text" class="form-control" name="username" value="<?php echo $name; ?>" require>
                    </div>
                    <div class="form-group">
                        <label for="email" >Email</label><p class="text-red"><?php echo $emailError; ?></p>
                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" require>
                    </div>
                    <div class="form-group">
                        <label for="phone" >Phone</label><p class="text-red"><?php echo $phoneError; ?></p>
                        <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" require>
                    </div>
                    <div class="form-group">
                        <label for="address" >Address</label><p class="text-red"><?php echo $addressError; ?></p>
                        <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" require>
                    </div>
                    <div class="form-group">
                        <label for="role" >Role</label><br>
                        <input type="checkbox" name="role" <?php if($role == 1){echo 'checked';} ?> ><span style="padding-left:10px;font-weight:bold;color:black;">Admin</span>
                    </div>
                    <div class="form-group mt-2">
                        <input type="submit" name="submit" value="Update User" class="btn btn-success">
                        <a href="user_list.php" class="btn btn-outline-dark">Back</a>
                    </div>
                  </form>
                 
                </div>
              
  </div>
  </div>
  </div>
  </div>
  <!-- /.card -->
    <!-- /.content -->
 <?php
include 'footer.php';
 ?>