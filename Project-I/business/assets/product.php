<?php include 'includes/navbar.php'; ?>
<?php 
$conn = mysqli_connect('localhost','root','','GlassGuruDB');

if(!$conn){
    die('Database connection failed: ' . mysqli_connect_error());
}

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the product details from the database
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $sql);

$product = null;
if($result && mysqli_num_rows($result) > 0){
    $product = mysqli_fetch_assoc($result);
} else {
    die('Product not found!');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['title']; ?> - Product Details</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/pages.css">
</head>
<body>
    <div class="wrapper">

        <div class="product-details-container">
            <div class="product-image">
                <img src="../admin/uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>">
            </div>
            <div class="product-info">
                <h1><?php echo $product['title']; ?></h1>
                <p><strong>Price:</strong> Rs. <?php echo $product['price']; ?></p>
                <p><strong>Description:</strong> <?php echo $product['description']; ?></p>
            </div>
        </div>

    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/script.js"></script>
</body>
</html>
