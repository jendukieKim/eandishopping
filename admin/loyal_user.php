<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
  header('Location:login.php');
}

if($_SESSION['role'] != 1){
  header('Location:login.php');
}

 
    

    $stmt = $pdo->prepare("SELECT sale_orders.*,u.name,SUM(total_price) as total_price from sale_orders 
            JOIN users u ON sale_orders.user_id = u.id GROUP BY sale_orders.user_id
            HAVING SUM(sale_orders.total_price) > 400000 ");
    $stmt->execute();
    $result = $stmt->fetchAll();

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
              <h3 class="card-title">User above 400,000 purchasing Report Listing</h3>
            </div>
                <div class="card-body">
                 
                  <table id="lyr-table" class="display" style="width:100%">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>User</th>
                        <th>Total Price</th>
                        <th style="width: fit-content;">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($result){
                      $i = 1;
                        foreach($result as $value){
                          ?>
                        <tr>
                        <td><?php echo $i;  ?></td>
                        <td><?php echo $value['name']  ?></td>
                        <td>
                        <?php echo $value['total_price']  ?> 
                        </td>
                        <td>
                          <div class="btn-group">
                            <div class="container">
                              <a href="profile_view.php?id=<?php echo $value['id'] ?>" class="btn btn-warning">View</a>
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

 <script>
   $(document).ready(function() {
    $('#lyr-table').DataTable({
        lengthMenu: [5, 10, 15]  // Sets pagination options to 5, 10, and 15
    });
});


 </script>