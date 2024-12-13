
<?php

$conn = mysqli_connect('localhost','root','','GlassGuruDB');

if(!$conn){
    die('Database connection failed: ' .mysqli_connect_error());
}

    //1.fetchs total products
    $productQuery = 'select count(*) as total_products from products';
    $productResult = mysqli_query($conn,$productQuery);
    $productData = mysqli_fetch_assoc($productResult);
    $totalProducts = $productData['total_products'];
    //2.fetch total users
    $userQuery = 'select count(*) as total_users from users';
    $userResult = mysqli_query($conn,$userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $totalUsers = $userData['total_users'];



// // Dummy data (replace with actual database queries in a real setup)
// $totalProducts = 100; // Replace with query to count products
// // $totalUsers = 50;     // Replace with query to count users
// $totalCalculatorUses = 30; // Replace with query to track calculator usage
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/admin-style.css">
    <link rel="stylesheet" href="assets/css/product.css">
</head>
<body>

<div id="container">
    <?php include 'includes/navbar.php';?>

    <div class="admin-layout">

        <div id="" class="admin-content">
            <h2>Welcome to the Admin Dashboard</h2>
            
            <!-- Overview Section -->
            <div class="overview">
                <div class="overview-card">
                    <h4>Total Products</h4>
                    <p><?php echo $totalProducts; ?></p>
                </div>
                <div class="overview-card">
                    <h4>Total Users</h4>
                    <p><?php echo $totalUsers; ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</div>



<script src="assets/js/admin-script.js"></script>
</body>
</html>
