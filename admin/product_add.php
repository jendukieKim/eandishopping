<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['userid']) && empty($_SESSION['loggin'])){
  header('Location:login.php');
}
if($_SESSION['role'] != 1){
    header('Location:login.php');
  }

//retrieve category name
// $cateId = $_GET['cate'];
$stmt2 = $pdo->prepare("SELECT * FROM categories");
$stmt2->execute();
$result2 = $stmt2->fetchAll();

  $nameError = '';
  $descERROR = '';
  $categoryError = '';
  $quantityError = '';
  $priceError = '';
  $imageError = '';
  
    if($_POST){
       if(empty($_POST['name']) || empty($_POST['description']) || empty($_FILES['image'])
          || empty($_POST['category']) || empty($_POST['quantity']) || empty($_POST['price'])  ){
          if(empty($_POST['name'])){
            $nameError = "Name cannot be empty..";
          }
          if(empty($_POST['description'])){
            $descERROR = "Description cannot be empty..";
          }
          if(empty($_FILES['image'])){
            $imageError = "Image cannot be empty";
          }
          if(empty($_POST['category'])){
            $categoryError = 'Category cannot be empty';
          }
          if(empty($_POST['quantity'])){
            $quantityError = 'Quantity cannot be empty';
          }elseif($_POST['quantity'] && (is_int($_POST['quantity']))){
            $quantityError = 'Quantity must be number';
          }
          if(empty($_POST['price'])){
            $priceError = 'Price cannot be empty';
          }elseif($_POST['price'] && (is_int($_POST['price']))){
            $priceError = 'Price must be number';
          }
        
       }else{
        $file = 'images/'.($_FILES['image']['name']);
        $imageType = pathinfo($file,PATHINFO_EXTENSION);

        if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){
            echo "<script>alert('Image must be png,jpg,jpeg');window.location.href='product_add.php';</script>";
        }else{
            $name = $_POST['name'];
            $description = $_POST['description'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $image = $_FILES['image']['name'];
            $author_id = $_SESSION['userId'];
            move_uploaded_file($_FILES['image']['tmp_name'],$file);

            $stmt = $pdo->prepare("INSERT INTO products(name,description,category_id,quantity,price,image) values(:name,:description,:category_id,:quantity,:price,:image)");
            $result = $stmt->execute(
                array(
                    ':name'=> $name,
                    ':description'=> $description,
                    ':category_id' => $category,
                    ':quantity' => $quantity,
                    ':price' => $price,
                    ':image' => $image,
                    
                )
            );

            if($result){
                echo "<script>alert('New product successfully added');window.location.href='product_list.php';</script>";
            }else{
                echo "<script>alert('New product added unsuccessful');</script>";
            }
        }
       }
        
    }

?>

<!DOCTYPE html>

  
    <?php
        

        include 'header.php';
    ?>
    <!-- Main content -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Product</h3>
            </div>
                <div class="card-body">
                  <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name" >Name</label><p style="color: red;"><?php echo $nameError; ?></p>
                        <input type="text" class="form-control" name="name" value="">
                    </div>
                    <div class="form-group">
                        <label for="description" >Description</label><p style="color:red;"><?php echo $descERROR; ?></p>
                        <textarea name="description"  rows="8" cols="80" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                            <label for="category">Category</label>
                            <p style="color: red;"><?php echo $categoryError; ?></p>
                            <select name="category" class="form-control">
                                <?php foreach ($result2 as $cate): ?>
                                    <option value="<?php echo htmlspecialchars($cate['id']); ?>">
                                        <?php echo htmlspecialchars($cate['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    <div class="form-group">
                        <label for="quantity" >Quantity</label><p style="color: red;"><?php echo $quantityError; ?></p>
                        <input type="number" class="form-control" name="quantity" value="">
                    </div>
                    <div class="form-group">
                        <label for="price" >Price</label><p style="color: red;"><?php echo $priceError; ?></p>
                        <input type="number" class="form-control" name="price" value="">
                    </div>
                    <div class="from-group">
                        <label for="image">Image</label><p style="color:red;"><?php echo $imageError; ?></p>
                        <input type="file" name="image" class="from-control">
                    </div>
                    <div class="form-group mt-2">
                        <input type="submit" name="add" value="Add Post" class="btn btn-success">
                        <a href="index.php" class="btn btn-outline-dark">Back</a>
                    </div>
                  </form>
                 
                </div>
              
  </div>
  </div>
  </div>
  </div>
  <!-- /.card -->
    <!-- /.content -->
 <?php
include '../admin/footer.php';
 ?>