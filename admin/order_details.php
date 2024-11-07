<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
    header('Location:login.php');
}

if($_SESSION['role'] != 1){
    header('Location:login.php');
}

if(!empty($_GET['pageno'])){
    $pageno = (int) $_GET['pageno'];
    $pageno = $pageno > 0 ? $pageno : 1;
}else{
    $pageno = 1;
}

$numOfrecs = 2;
$offset = ($pageno - 1) * $numOfrecs;

if(!empty($_GET['id'])) {
    $saleOrderId = $_GET['id'];

    // Get total records count for pagination
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM sale_order_detail WHERE id = :id");
    $stmt->execute([':id' => $saleOrderId]);
    $total_records = $stmt->fetchColumn();
    $total_pages = ceil($total_records / $numOfrecs);

    // Retrieve paginated sale order details with joined data
    $stmt = $pdo->prepare("
    SELECT sale_order_detail.*, users.name AS user_name, products.name AS product_name, 
           products.price, products.image, categories.name AS category_name
    FROM sale_order_detail
    INNER JOIN sale_orders ON sale_orders.id = sale_order_detail.sale_order_id
    INNER JOIN users ON users.id = sale_orders.user_id
    INNER JOIN products ON products.id = sale_order_detail.product_id
    INNER JOIN categories ON categories.id = products.category_id
    WHERE sale_order_detail.sale_order_id = :sale_order_id
    ORDER BY sale_order_detail.id DESC
    LIMIT :offset, :numOfrecs
");
    $stmt->bindValue(':sale_order_id', $_GET['id'], PDO::PARAM_INT);

    //$stmt->bindValue(':id', $saleOrderId, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':numOfrecs', $numOfrecs, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product Listing</h3>
                </div>
                <div class="card-body">
                    <a href="print.php" class="btn btn-success">Print Voucher</a>
                    <table class="table table-bordered mt-2">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>User</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Image</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($result) {
                            $i = 1 + $offset;
                            foreach ($result as $value) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo htmlspecialchars($value['user_name']); ?></td>
                                    <td><?php echo htmlspecialchars($value['product_name']); ?></td>
                                    <td><?php echo htmlspecialchars($value['category_name']); ?></td>
                                    <td><?php echo htmlspecialchars($value['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars($value['price']); ?></td>
                                    <td>
                                        <img src="images/<?php echo htmlspecialchars($value['image']); ?>" class="img-fluid pad" alt="Photo" style="height:50px;">
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        } else {
                            echo "<tr><td colspan='7'>No sale order details found.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example" class="mt-2">
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?php if ($pageno <= 1) { echo 'disabled'; } ?>">
                                <a class="page-link" href="?id=<?php echo $saleOrderId; ?>&pageno=1">First</a>
                            </li>
                            <li class="page-item <?php if ($pageno <= 1) { echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php echo $pageno <= 1 ? '#' : '?id='.$saleOrderId.'&pageno='.($pageno - 1); ?>">Previous</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#"><?php echo $pageno; ?></a>
                            </li>
                            <li class="page-item <?php if ($pageno >= $total_pages) { echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php echo $pageno >= $total_pages ? '#' : '?id='.$saleOrderId.'&pageno='.($pageno + 1); ?>">Next</a>
                            </li>
                            <li class="page-item <?php if ($pageno >= $total_pages) { echo 'disabled'; } ?>">
                                <a class="page-link" href="?id=<?php echo $saleOrderId; ?>&pageno=<?php echo $total_pages; ?>">Last</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php include 'footer.php'; ?>
