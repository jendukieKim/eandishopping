<?php
    session_start();
    require 'config/config.php';
    if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
        header('Location:login.php');
      }
      if($_SESSION['role'] != 0){
        header("Location:admin/login.php");
    }
    if($_POST){
        $id = $_POST['id'];
        $qty = $_POST['qty'];

        $stmt = $pdo->prepare("SELECT * FROM products WHERE id=$id");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($qty > $result['quantity']){
            echo "<script>alert('Not enough stock');window.location.href='product_details.php?id=$id'</script>";
        }else{
            if(isset($_SESSION['cart'][$id])){
                $_SESSION['cart'][$id] += $qty;
            }else{
                $_SESSION['cart'][$id] = $qty;
            }
    
            header("Location:cart.php");
        }
    
 
    }

?>