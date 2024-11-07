<?php
session_start();
require '../config/config.php';

if (empty($_SESSION['userid']) && empty($_SESSION['loggin'])) {
    header('Location: login.php');
    exit();
}
if ($_SESSION['role'] != 1) {
    header('Location: login.php');
    exit();
}

// Retrieve product data from db
$id = $_GET['id'];
$stmt1 = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt1->execute([':id' => $id]);
$result1 = $stmt1->fetch();

//retrieve category name
// $cateId = $_GET['cate'];
$stmt2 = $pdo->prepare("SELECT * FROM categories");
$stmt2->execute();
$result2 = $stmt2->fetchAll();

$nameError = $descERROR = $categoryError = $quantityError = $priceError = $imageError = '';

if ($_POST) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    
    
    // Validate input fields
    if (empty($name)) {
        $nameError = "Name cannot be empty.";
    }
    if (empty($description)) {
        $descERROR = "Description cannot be empty.";
    }
    if (empty($category)) {
        $categoryError = "Category cannot be empty.";
    }
    if (empty($quantity)) {
        $quantityError = "Quantity cannot be empty.";
    }
    if (empty($price)) {
        $priceError = "Price cannot be empty.";
    }

    if (!$nameError && !$descERROR && !$categoryError && !$quantityError && !$priceError) {
        // Check if a new image is uploaded
        if (!empty($_FILES['image']['name'])) {
            $file = 'images/' . $_FILES['image']['name'];
            $imageType = pathinfo($file, PATHINFO_EXTENSION);

            if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
                $imageError = "Image must be in png, jpg, or jpeg format.";
            } else {
                move_uploaded_file($_FILES['image']['tmp_name'], $file);
                $stmt = $pdo->prepare("UPDATE products SET name = :name, description = :description, category_id = :category_id, quantity = :quantity, price = :price, image = :image WHERE id = :id");
                $result = $stmt->execute([
                    ':name' => $name,
                    ':description' => $description,
                    ':category_id' => $category,
                    ':quantity' => $quantity,
                    ':price' => $price,
                    ':image' => $_FILES['image']['name'],
                    ':id' => $id
                ]);
            }
        } else {
            // If no new image, exclude the image field from the update
            $stmt = $pdo->prepare("UPDATE products SET name = :name, description = :description, category_id = :category_id, quantity = :quantity, price = :price WHERE id = :id");
            $result = $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':category_id' => $category,
                ':quantity' => $quantity,
                ':price' => $price,
                ':id' => $id
            ]);
        }

        if ($result) {
            echo "<script>alert('Product updated successfully');window.location.href='product_list.php';</script>";
        } else {
            echo "<script>alert('Failed to update product');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Product</h3>
                </div>
                <div class="card-body">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <p style="color: red;"><?php echo $nameError; ?></p>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($result1['name']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <p style="color: red;"><?php echo $descERROR; ?></p>
                            <textarea name="description" rows="8" cols="80" class="form-control"><?php echo htmlspecialchars($result1['description']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <p style="color: red;"><?php echo $categoryError; ?></p>
                            <select name="category" class="form-control">
                                <?php foreach ($result2 as $cate): ?>
                                    <option value="<?php echo htmlspecialchars($cate['id']); ?>"
                                    <?php if ($cate['id'] == $result1['category_id']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($cate['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <p style="color: red;"><?php echo $quantityError; ?></p>
                            <input type="number" class="form-control" name="quantity" value="<?php echo htmlspecialchars($result1['quantity']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <p style="color: red;"><?php echo $priceError; ?></p>
                            <input type="number" class="form-control" name="price" value="<?php echo htmlspecialchars($result1['price']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <p style="color: red;"><?php echo $imageError; ?></p>
                            <img src="images/<?php echo htmlspecialchars($result1['image']); ?>" alt="" width="150" height="150"><br><br>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="form-group mt-2">
                            <input type="submit" value="Update Product" class="btn btn-success">
                            <a href="product_list.php" class="btn btn-outline-dark">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
