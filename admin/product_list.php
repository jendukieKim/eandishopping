<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
  header('Location:login.php');
}

if($_SESSION['role'] != 1){
  header('Location:login.php');
}

if (isset($_POST['search'])) {
  setcookie('search', $_POST['search'], time() + (86400 * 30), "/"); // 86400 seconds = 1 day
} else {
  if (empty($_GET['pageno'])) {
      unset($_COOKIE['search']);
      setcookie('search', '', time() - 3600, "/"); // Set past time to delete cookie
  }
}
  
?>

<!DOCTYPE html>

  
    <?php

        if(!empty($_GET['pageno'])){
          $pageno = $_GET['pageno'];
        }else{
          $pageno = 1;
        }
        $numOfrecs = 2;
        $offset = ($pageno-1)*$numOfrecs;

          if(empty($_POST['search']) && empty($_COOKIE['search'])){
            $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
            $stmt->execute();
            $rawResult = $stmt->fetchAll();
            $total_pages = ceil(count($rawResult)/$numOfrecs);
    
            $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offset,$numOfrecs ");
            $stmt->execute();
            $result = $stmt->fetchAll();
    
          }else{
            $searchKey = isset($_POST['search']) ? $_POST['search'] : (isset($_COOKIE['search']) ? $_COOKIE['search'] : '');
            $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
            $stmt->execute();
            $rawResult = $stmt->fetchAll();
            $total_pages = ceil(count($rawResult)/$numOfrecs);
    
            $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs ");
            $stmt->execute();
            $result = $stmt->fetchAll();
    
          }
        include 'header.php';
    ?>
    <!-- Main content -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Product Listing</h3>
            </div>
                <div class="card-body">
                  <div class="mb-2">
                    <a href="product_add.php" class="btn btn-success">New Product</a>
                  </div>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th style="width: fit-content;">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($result){
                      $i = 1;
                        foreach($result as $value){
                            //retrieve category name
                            // $cateId = $_GET['cate'];
                            $stmt2 = $pdo->prepare("SELECT * FROM categories WHERE id=:id");
                            $stmt2->execute(array(':id'=>$value['category_id']));
                            $result2 = $stmt2->fetchAll();
                          ?>
                        <tr>
                        <td><?php echo $i;  ?></td>
                        <td><?php echo $value['name']  ?></td>
                        <td>
                            <?php echo substr($value['description'],0,50);  ?> 
                        </td>
                        <td>
                            <?php echo substr($result2[0]['name'],0,50);  ?> 
                        </td>
                        <td>
                            <?php echo substr($value['quantity'],0,50);  ?> 
                        </td>
                        <td>
                            <?php echo $value['price'];  ?> 
                        </td>
                        <td>
                            
                            <img src="images/<?php echo $value['image']; ?>" class="img-fluid pad" alt="Photo"  style="height:50px !important">
                        </td>
                        <td>
                          <div class="btn-group">
                            <div class="container">
                              <a href="product_edit.php?id=<?php echo $value['id'] ?>&cate=<?php echo $value['category_id'] ?>" class="btn btn-warning">Edit</a>
                            </div>
                            <div class="container">
                              <a href="product_delete.php?id=<?php echo $value['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php
                      $i++;
                        }
                      }
                      ?>
                      
                      
                    </tbody>
                  </table>
                
                <nav aria-label="Page navigation example" class="mt-2">
                  <ul class="pagination justify-content-end">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno<=1){echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno<=1){echo '#';}else{echo "?pageno=".($pageno-1);} ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno>=$total_pages){echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno>=$total_pages){echo '#';}else{echo "?pageno=".($pageno+1);} ?>">Next</a></li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                  </ul>
                </nav>
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