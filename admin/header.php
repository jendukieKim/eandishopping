<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shopping | Starter</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="shortcut icon" href="logo/market.png" />
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
      
          <?php
            $link = $_SERVER['PHP_SELF'];
            $link_array = explode('/',$link);
            $page = end($link_array);
            $act = '';
            if($page == "index.php"){
              $act = "index.php";
            }else if($page == "cat_list.php"){
              $act = 'cat_list.php';
            }else if($page == 'product_list.php'){
              $act = 'product_list.php';
            }else if($page == "order_list.php"){
              //echo "<script>var x = document.getElementById('searchform');s.visible=false;</script>";
            }else if($page == "report.php"){
              $act = 'report.php';
            }else{
              $act = "user_list.php";
            }
          ?>

          <?php
            if($page == 'index.php' || $page == 'product_list.php' || $page == 'user_list.php'){

              ?>

              <form action="<?php echo $act; ?>" method="post" class="form-inline ml-3" id="searchform">
                          <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" name="search">
                            <div class="input-group-append">
                              <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                              </button>
                            </div>
                          </div>
               </form>
            <?php
            }
          ?>
          
     
      
  

   
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">PHP Shopping</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['username'] ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Categories
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="product_list.php" class="nav-link">
              <i class="nav-icon fas fa-cube"></i>
              <p>
                Products
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user_list.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="order_list.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Orders
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item menu">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="weekly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Weekly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="monthly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="loyal_user.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Loyal Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="best_selling_item.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Best Seller Items</p>
                </a>
              </li>
            </ul>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <!-- <div class="col-sm-6">
            <h1 class="m-0">Starter Page</h1>
          </div>/.col -->
          <div class="col-sm-6">
           
            
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
