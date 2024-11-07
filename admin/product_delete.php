<?php
require '../config/config.php';
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id=:id");
    $result = $stmt->execute(
        array(
            ':id'=>$id
        )
    );
    if($result){
        echo "<script>alert('Delete successfully');window.location.href='product_list.php';</script>";

    }else{
        echo "<script>alert('Cannot delete');</script>";

    }
?>