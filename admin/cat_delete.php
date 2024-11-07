<?php
require '../config/config.php';
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id=:id");
    $result = $stmt->execute(
        array(
            ':id'=>$id
        )
    );
    if($result){
        echo "<script>alert('Delete successfully');window.location.href='index.php';</script>";

    }else{
        echo "<script>alert('Cannot delete');</script>";

    }
?>