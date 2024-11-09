<?php
	session_start();
	require 'config/config.php';
	if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
		header('Location:login.php');
	  }
	$userId = $_SESSION['userId'];
	$total = 0;

	if(!empty($_SESSION['cart'])){
		foreach($_SESSION['cart'] as $key => $qty){
			$id = str_replace('id','',$key);
			$stmt = $pdo->prepare("SELECT * FROM products WHERE id = $id");
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$total += $result['price'] * $qty;
		}
	
		//insert into sale order table
		$stmt1 = $pdo->prepare("INSERT INTO sale_orders(user_id,total_price,order_date) VALUES(:userid,:totalprice,:odate)");
		$result1 =$stmt1->execute(
			array(
				':userid' => $userId,
				':totalprice' => $total,
				':odate' => date('Y-m-d H:i:s')
			)
		);
		if($result1){
			//insert into sale order details table
			$saleOrderId = $pdo->lastInsertId();
			 $_SESSION['saleorderId'] = $saleOrderId;
			foreach($_SESSION['cart'] as $key => $qty){
				$id = str_replace('id','',$key);//product id
				$stmt = $pdo->prepare("INSERT INTO sale_order_detail(sale_order_id,product_id,quantity) VALUES(:sid,:pid,:quantity)");
				$result = $stmt->execute(
					array(
						':sid' =>$saleOrderId,
						':pid' => $id,
						':quantity' => $qty
					)
				);
				$qtystmt = $pdo->prepare("SELECT quantity FROM products WHERE id = $id");
				$qtystmt->execute();
				$qtyresult = $qtystmt->fetch(PDO::FETCH_ASSOC);
				$updateQty = $qtyresult['quantity'] - $qty;
	
				$stmt = $pdo->prepare("UPDATE products SET quantity=:qty WHERE id=:pid");
				$result = $stmt->execute(
					array(
						':qty' => $updateQty,
						':pid' => $id
					)
				);
	
				
			}
			
			
		}
		unset($_SESSION['cart']);
	}
	

?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>E&I Shop</title>

	<!--
		CSS
		============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body>

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-sm navbar-light main_box">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="index.php"><h4>E&I Shopping</h4></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Cart Count -->
                <?php  
                $cart = 0;
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $qty) {
                        $cart += $qty;
                    }
                }
                ?>

                <!-- Navbar Links, Cart Icon, and Search Icon -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ml-auto d-flex align-items-center">
                        <li class="nav-item d-flex align-items-center">
                            <!-- Cart Icon -->
                            <a href="cart.php" class="nav-link cart">
                                <i class="ti-bag"></i> <span class="badge badge-danger"><?php echo $cart; ?></span>
                            </a>
                            <!-- Search Icon -->
                            <button class="btn p-0 ml-2" type="button" id="search-icon">
                                <span class="lnr lnr-magnifier"></span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- Search Input Box -->
    <div class="search_input" id="search_input_box" style="display: none;">
        <div class="container">
            <form class="d-flex justify-content-between" action="index.php" method="post">
                <input type="text" class="form-control" id="search_input" name="search" placeholder="Search Here">
                <button type="submit" class="btn">Search</button>
                <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
            </form>
        </div>
    </div>
</header>
<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Confirmation</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="category.html">Confirmation</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Order Details Area =================-->
	<section class="order_details section_gap">
		<div class="container">
			<h3 class="title_confirmation">Thank you. Your order has been received.</h3>
			
			<div class="order_details_table">
				<h2>Order Details</h2>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Product</th>
								<th scope="col">Quantity</th>
								<th scope="col">Total</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$sale =  $_SESSION['saleorderId'];
							$stmt = $pdo->prepare("SELECT S.*,p.name as product,p.price as price FROM sale_order_detail as s JOIN products as p ON 
								s.product_id = p.id WHERE sale_order_id =$sale");
							$stmt->execute();
							$result = $stmt->fetchAll();
							foreach($result as $value){
							?>
							
							<tr>
								<td>
									<p><?php echo $value['product']; ?></p>
								</td>
								<td>
									<h5>x <?php echo $value['quantity']; ?></h5>
								</td>
								<td>
									<p><?php  echo $value['price'] * $value['quantity'] ?></p>
								</td>
							</tr>
						<?php
							}
						?>
						
						<?php 
							$stmt1 = $pdo->prepare("SELECT * FROM sale_orders WHERE id=$sale");
							$stmt1->execute();
							$result1 = $stmt1->fetchAll();
						?>
							
							<tr>
								<td>
									<h4>Subtotal</h4>
								</td>
								<td>
									<h5></h5>
								</td>
								<td>
									<p><?php echo $result1[0]['total_price']; ?></p>
								</td>
							</tr>
						
							<tr>
								<td>
									<h4>Total</h4>
								</td>
								<td>
									<h5></h5>
								</td>
								<td>
									<p><?php echo $result1[0]['total_price']; ?></p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
	<!--================End Order Details Area =================-->

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