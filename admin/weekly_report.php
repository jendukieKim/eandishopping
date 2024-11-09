<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
  header('Location:login.php');
}

if($_SESSION['role'] != 1){
  header('Location:login.php');
}

    $currentDate = date("Y-m-d");
    $fromDate = date("Y-m-d",strtotime($currentDate.'+1 day'));
    $toDate = date("Y-m-d",strtotime($currentDate.'-7 day'));
    
    $stmt = $pdo->prepare("SELECT sale_orders.*, u.name AS username
            FROM sale_orders
            JOIN users u ON sale_orders.user_id = u.id
            WHERE order_date < :fromdate and order_date >  :todate;
            ");
    $stmt->execute(
        array(
            ':fromdate' => $fromDate,
            ':todate' => $toDate
        )
    );

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
              <h3 class="card-title">Weekly Report Listing</h3>
            </div>
                <div class="card-body">
                 
                  <table id="wr-table" class="display" style="width:100%">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>User</th>
                        <th>Total Price</th>
                        <th>Order Date</th>
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
                        <td><?php echo $value['username']  ?></td>
                        <td>
                        <?php echo $value['total_price']  ?> 
                        </td>
                        <td>
                            <?php echo $value['order_date']; ?>
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
    $('#wr-table').DataTable({
        lengthMenu: [5, 10, 15]  // Sets pagination options to 5, 10, and 15
    });
});


 </script>