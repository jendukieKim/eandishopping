<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['userid']) && empty($_SESSION['loggin'])){
  header('Location:/admin/login.php');
}
if($_SESSION['role'] != 1){
    header('Location:../login.php');
  }

  $nameError = '';
  $descERROR = '';
  
  
    if($_POST){
       if(empty($_POST['name']) || empty($_POST['description'])){
          if(empty($_POST['name'])){
            $nameError = "Category name cannot be empty..";
          }
          if(empty($_POST['desccription'])){
            $descERROR = "Description cannot be empty..";
          }
          
        
       }else{
       
            $name = $_POST['name'];
            $description = $_POST['description'];
            $author_id = $_SESSION['userId'];
           
            //check category already exist or not
            $stmt1 = $pdo->prepare("SELECT * FROM categories WHERE name = :name ");
            $stmt1->execute(
              array(
                ':name' => $name
              )
            );
            $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            if($result1){
              echo "<script>alert('Already exists..');window.location.href='cat_add.php';</script>";
            }else{
              $stmt = $pdo->prepare("INSERT INTO categories(name,description) values(:name,:description)");
            $result = $stmt->execute(
                array(
                    ':name'=> $name,
                    ':description'=> $description,
          
                )
            );
           

            if($result){
                echo "<script>alert('New category successfully added');window.location.href='index.php';</script>";
            }else{
                echo "<script>alert('New category added unsuccessful');</script>";
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
              <h3 class="card-title">Category Table</h3>
            </div>
                <div class="card-body">
                  <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name" >Name</label><p style="color: red;"><?php echo $nameError; ?></p>
                        <input type="text" class="form-control" name="name" value="">
                    </div>
                    <div class="form-group">
                        <label for="description" >Description</label><p style="color:red;"><?php echo $descERROR; ?></p>
                        <textarea name="description" rows="8" cols="80"  value="" class="form-control"></textarea>
                    </div>
                    
                    <div class="form-group mt-2">
                        <input type="submit" name="add" value="Add Post" class="btn btn-success">
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