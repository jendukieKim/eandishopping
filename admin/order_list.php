<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
  header('Location:login.php');
}

if($_SESSION['role'] != 1){
  header('Location:login.php');
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
        $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC");
            $stmt->execute();
            $rawResult = $stmt->fetchAll();
            $total_pages = ceil(count($rawResult)/$numOfrecs);
    
            $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC LIMIT $offset,$numOfrecs ");
            $stmt->execute();
            $result = $stmt->fetchAll();

        include 'header.php';
    ?>
    <!-- Main content -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Orders Listing</h3>
            </div>
                <div class="card-body">
                  <div class="mb-2">
                    <a href="cat_add.php" class="btn btn-success">New Categories</a>
                  </div>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Order Date</th>
                        <th style="width: fit-content;">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($result){
                      $i = 1;
                        foreach($result as $value){
                            $stmt2 = $pdo->prepare("SELECT * FROM users WHERE id=:id");
                            $stmt2->execute(array(':id'=>$value['user_id']));
                            $result2 = $stmt2->fetchAll();
                          ?>
                        <tr>
                        <td><?php echo $i;  ?></td>
                        <td><?php echo $result2[0]['name']  ?></td>
                        <td>
                        <?php echo $value['total_price'];  ?> 
                        </td>
                        <td>
                            <?php echo $value['order_date'] ?>
                        </td>
                        <td>
                          <div class="btn-group">
                            <div class="container">
                              <a href="order_details.php?id=<?php echo $value['id'] ?>" class="btn btn-warning">View</a>
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