<?php
session_start();
require('config/config.php');

    $nameError = '';
	$emailError = '';
    $phoneError = '';
	$passwordError = '';
    $addressError = '';
	if($_POST){
        if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address'])){
          if(empty($_POST['name'])){
            $nameError = "*Name cannot be empty";
          }
          if(empty($_POST['email'])){
            $emailError = "*Email cannot be null.";
          }
          if(empty($_POST['phone'])){
            $phoneError = "* Phone number cannot be empty.";
          }
          if(empty($_POST['address'])){
            $addressError = "* Address cannot be empty.";
          }
           $cc = strlen($_POST['password']);
          if($cc < 6){
            $passwordError = "*Password at lease 6 characters.";
          }
        }else{
        $username = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare('select * from users where email=:email');
        $stmt->bindValue(':email',$email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            echo "<script>alert('Email is already taken..')</script>";
        }else{
            if(isset($_POST['role'])){
                $stmt1 = $pdo->prepare("INSERT INTO users(name,email,password,phone,address,role) VALUES(:name,:email,:password,:phone,:address,:role)");
                $result1 = $stmt1->execute(
                    array(
                        ':name'=>$username,
                        ':email'=>$email,
                        ':password'=>$password,
                        ':phone'=> $phone,
                        ':address'=>$address,
                        ':role'=> 1
                    )
                );
            }else{
                $stmt1 = $pdo->prepare("INSERT INTO users(name,email,password,phone,address,role) VALUES(:name,:email,:password,:phone,:address,:role)");
                $result1 = $stmt1->execute(
                    array(
                        ':name'=>$username,
                        ':email'=>$email,
                        ':password'=>$password,
                        ':phone' => $phone,
                        ':address' => $address,
                        ':role'=> 0
                    )
                );
            }
            
            if($result1){
                echo "<script>alert('User added successfully..You can now login');window.location.href='login.php';</script>";
            }else{
                echo "<script>alert('Something wrong');window.location.href='register.php';</script>";
    
            }
        }
        }
    
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
				<div class="container" style="height: 60px;">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.php"><h4>E&I Shopping<h4></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item"><a href="#" class="cart"><span class="ti-bag"></span></a></li>
							<li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between">
					<input type="text" class="form-control" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
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
					<h1>Login/Register</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="register.php">Register</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				
				<div class="col-lg-12">
					<div class="login_form_inner">
						<h3>Register New Account</h3>
						<form class="row login_form" action="register.php" method="post" id="contactForm" novalidate="novalidate">
						<div class="col-md-12 form-group">
							<p class="text-red"><?php echo $nameError; ?></p>
								<input type="text"  class="form-control" id="name" name="name" style="<?php echo empty($nameError) ?  '' : 'border:1px solid red;'; ?>"
								 placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Userrname'">
							</div>	
                        <div class="col-md-12 form-group">
								<p class="text-red"><?php echo $emailError; ?></p>
								<input type="text"  class="form-control" id="email" name="email" style="<?php echo empty($emailError) ?  '' : 'border:1px solid red;'; ?>"
								placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							</div>
							<div class="col-md-12 form-group">
							<p class="text-red"><?php echo $phoneError; ?></p>
								<input type="text"  class="form-control" name="phone" style="<?php echo empty($phoneError) ?  '' : 'border:1px solid red;'; ?>"
								placeholder="Phone" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone}'">
							</div>
							<div class="col-md-12 form-group">
							<p class="text-red"><?php echo $passwordError; ?></p>
								<input type="password"  class="form-control"  name="password" style="<?php echo empty($passwordError) ?  '' : 'border:1px solid red;'; ?>"
								 placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
                            <div class="col-md-12 form-group">
							<p class="text-red"><?php echo $addressError; ?></p>
                            <textarea name="address" class="form-control" style="<?php echo empty($addressError) ?  '' : 'border:1px solid red;'; ?>"
							placeholder="Address" row="8" cols="80"></textarea>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Register</button>
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->

	<!-- start footer Area -->
	<footer class="footer-area section_gap">
		<div class="container">
			<div class="row">
			<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
				<p class="footer-text text-align-center"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				</p>
			</div>
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