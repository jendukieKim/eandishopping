<?php
    session_start();
    $id = $_GET['pid'];
    unset($_SESSION['cart'][$id]);
    header("Location:cart.php");
?>