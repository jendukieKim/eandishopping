<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['userid']) && empty($_SESSION['loggin'])){
  header('Location:login.php');
}
if($_SESSION['role'] != 1){
    header('Location:login.php');
  }

  $nameError = '';
  $descERROR = '';
  $id = $_GET['id'];
  //retrieve value according to category id
            $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=:id");
                        $stmt->execute(
                            array(
                                ':id'=>$id
                            )
                        );
            $result = $stmt->fetchAll();
            $name = $result[0]['name'];
            $description = $result[0]['description'];

    if($_POST){
       $catname = $_POST['name'];
       $catdesc = $_POST['description'];
       if(empty($_POST['name']) || empty($_POST['description'])){
          if(empty($_POST['name'])){
            $nameError = "Category name cannot be empty..";
          }
          if(empty($_POST['description'])){
            $descERROR = "Description cannot be empty..";
          }
          
        
       }else{
            $stmt1 = $pdo->prepare("UPDATE categories SET name='$catname',description='$catdesc' WHERE id='$id'");
            $result1 = $stmt1->execute();
            if($result1){
                echo "<script>alert('Update successfulle');window.location.href='index.php';</script>";
            }else{
                echo "<script>alert('Update unsuccess');</script>";
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
              <h3 class="card-title">Category Table</h3>
            </div>
                <div class="card-body">
                  <form action="#" method="post">
                    <div class="form-group">
                        <label for="name" >Name</label><p style="color: red;"><?php echo $nameError; ?></p>
                        <input type="text" class="form-control" name="name" value="<?php echo $name ?>">
                    </div>
                    <div class="form-group">
                        <label for="description" >Description</label><p style="color:red;"><?php echo $descERROR; ?></p>
                        <textarea name="description" rows="8" cols="80"   class="form-control"><?php echo $description ?></textarea>
                    </div>
                    
                    <div class="form-group mt-2">
                        <input type="submit" name="add" value="Edit Category" class="btn btn-success">
                        <a href="index.php" class="btn btn-outline-dark">Back</a>
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