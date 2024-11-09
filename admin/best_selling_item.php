<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
  header('Location:login.php');
}

if($_SESSION['role'] != 1){
  header('Location:login.php');
}

 
    

    $stmt = $pdo->prepare("SELECT sale_order_detail.*,p.name,p.image,SUM(sale_order_detail.quantity) as quantity from sale_order_detail 
            JOIN products p ON sale_order_detail.product_id = p.id GROUP BY sale_order_detail.product_id
            HAVING SUM(sale_order_detail.quantity) > 7 ");
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
              <h3 class="card-title">Items above selling count 7 Report Listing</h3>
            </div>
                <div class="card-body">
                 
                  <table id="lyr-table" class="display" style="width:100%">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>User</th>
                        <th>Total Quantity</th>
                        <th style="width: fit-content;">Image</th>
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
                        <?php echo $value['quantity']  ?> 
                        </td>
                        <td>
                          <div class="btn-group">
                            <div class="container">
                                <img src="images/<?php echo $value['image']  ?>" alt="" width="50px">
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