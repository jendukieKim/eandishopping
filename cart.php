<?php
 session_start();
 require 'config/config.php';
 if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
	header('Location:login.php');
  }
  if($_SESSION['role'] != 0){
	header("Location:admin/login.php");
}
 include 'header.php';
 

//  print_r($_SESSION['cart']);
//  exit();
?>


    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                   <?php 
                    if(isset($_SESSION['cart'])){
                        ?>
                             <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $total = 0;
                                foreach($_SESSION['cart'] as $key => $qty) { 
                                    $id = str_replace('id','',$key);
                                    $stmt = $pdo->prepare("SELECT * FROM products  WHERE id =$id");
                                    $stmt->execute();
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $total += $result['price'] * $qty;
                                
                                ?>
                              <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="admin/images/<?php echo $result['image'] ?>" alt="" class="img-fluid" width="150px">
                                        </div>
                                        <div class="media-body">
                                            <p><?php  echo $result['name']; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo number_format($result['price']); ?></h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" name="qty" id="sst" maxlength="12" value="<?php echo $qty; ?>" title="Quantity:"
                                            class="input-text qty" readonly>
                                       </div>
                                </td>
                                <td>
                                    <h5><?php echo number_format($result['price']*$qty); ?></h5>
                                </td>
                                <td><a href="cart_item_clear.php?pid=<?php echo $result['id']; ?>" class="btn btn-danger">Clear</a></td>
                            </tr>
                            <?php }
                            ?>
                           
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
                                    <h5><?php echo number_format($total); ?></h5>
                                </td>
                                <td>

                                </td>
                            </tr>
                          
                            <tr class="out_button_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td></td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a href="clearall.php" class="gray_btn">Clear All</a>
                                        <a class="primary-btn" href="index.php">Continue Shopping</a>
                                        <a class="gray_btn" href="sale_order.php">Order Submit</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    }
                   ?>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    <!-- start footer Area -->
    <footer class="footer-area section_gap">
        <div class="container">
            
            <div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
                <p class="footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</p>
            </div>
        </div>
    </footer>
    <!-- End footer Area -->

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="js/gmaps.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>