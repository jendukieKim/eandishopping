

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
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body id="category">

	<!-- Start Header Area -->
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

<script>
    // Toggle search box visibility
    document.getElementById('search-icon').onclick = function() {
        document.getElementById('search_input_box').style.display = 'block';
    };
    document.getElementById('close_search').onclick = function() {
        document.getElementById('search_input_box').style.display = 'none';
    };
</script>

	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb" style="margin-bottom:0 !important">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Welcome</h1>
                    <h3><?php echo $_SESSION['username']; ?></h3>
					<p>Fashion isn’t just about clothes – it’s about self-expression. Dress to inspire!</p>
                    <a href="logout.php" class="btn btn-outline-danger">Logout</a>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->
	
		

			
			
