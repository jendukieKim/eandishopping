<?php 
require 'config/config.php';
include('header.php');
$id = $_GET['id'];
//retrieve product detail
$stmt = $pdo->prepare("SELECT p.*, c.name AS category
FROM products AS p
JOIN categories AS c ON p.category_id = c.id
WHERE p.id = :id;
");
$stmt->execute(
	array(':id' => $id)
);
$result = $stmt->fetchAll();

?>
				<!--================Single Product Area =================-->
	<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="s_Product_carousel">
						<div class="single-prd-item">
							<img class="img-fluid" src="admin/images/<?php echo $result[0]['image']; ?>" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="admin/images/<?php echo $result[0]['image']; ?>" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="admin/images/<?php echo $result[0]['image']; ?>" alt="">
						</div>
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3><?php echo $result[0]['name']; ?></h3>
						<h2><?php echo $result[0]['price']; ?></h2>
						<ul class="list">
							<li><a class="active" href="#"><span>Category</span> : <?php echo $result[0]['category']; ?></a></li>
							<li><a href="#"><span>Stock</span> : <?php echo $result[0]['quantity']; ?></a></li>
						</ul>
						<p><?php echo $result[0]['description']; ?></p>
						<div class="product_count">
							<label for="qty">Quantity:</label>
							<input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
							 class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp; &amp; sst > 0 ) result.value--;return false;"
							 class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
						
							</div>
						<div class="card_area d-flex align-items-center">
							<a class="primary-btn" href="cart.php">Add to Cart</a>
							
						</div><br><br>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--================End Single Product Area =================-->
			</div>
		</div>
	</div>



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
